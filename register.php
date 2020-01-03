<?php

session_start();

require "head.php";
require "connection.php";
include "country_codes.php";

$errors = [];

// stolen from https://www.geeksforgeeks.org/php-startswith-and-endswith-functions/
function endsWith($string, $endString)
{
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}

// question to myself: do I need to change the names of username, also in session etc. to prevent confusion between the login username and pasword? Username is not important and even handy if it's remembered, pasword I don't store
if (isset($_POST["submit_register"])) {
    $db = openConnection();

    // validation: probably some cases will never fire, but it's more standardized this way. Also, probably more safe this way
    if (empty($_POST["first_name"])) {
        $errors["first_name"] = "You need to fill in your first name";
    } else {
        if (filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING)) {
            // way learned in Het Perspectief
            $first_name = $db->quote(htmlentities($_POST["first_name"]));
            $_SESSION["first_name"] = $first_name;
        } else {
            $errors["first_name"] = "You need to fill in your you first name correctly";
        }
    }
    if (empty($_POST["last_name"])) {
        $errors["last_name"] = "You need to fill in your last name";
    } else {
        if (filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING)) {
            // way according to https://phptherightway.com/#pdo_extension + https://www.php.net/manual/en/filter.filters.sanitize.php (note: didn't researched teh filters well, but chose on the basis of the name)
            $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
            $_SESSION["last_name"] = $last_name;
        } else {
            $errors["last_name"] = "You need to fill in your you last name correctly";
        }
    }
    if (empty($_POST["username"])) {
        $errors["username"] = "You need to fill in your username";
    } else {
        if (filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)) {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $_SESSION["username"] = $username;
        } else {
            $errors["username"] = "You need to fill in your you username correctly";
        }
    }
    $password = "";
    $password_confirmation = "";

    if (empty($_POST["password"])) {
        $errors["password"] = "You need to fill in a password";
    } else {
        if (filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)) {
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            // not storing password in session!
        } else {
            $errors["password"] = "You need to fill in your you password correctly";
        }
    }
    if (empty($_POST["password_confirmation"])) {
        $errors["password_confirmation"] = "You need to fill in the password a second time";
    } else {
        if (filter_input(INPUT_POST, 'password_confirmation', FILTER_SANITIZE_STRING)) {
            $password_confirmation = filter_input(INPUT_POST, 'password_confirmation', FILTER_SANITIZE_STRING);
            // not storing password in session!
        } else {
            $errors["password_confirmation"] = "You need to fill in the password correctly a second time";
        }
    }

    // TO DO: Check if password and password confirm are equal. Use password_verify for this.
    if ($password !== "" && $password_confirmation !== "") {
        if ($password === $password_confirmation) {
            echo "test123";
            $password_safe = password_hash($password, PASSWORD_DEFAULT);
            echo "password has been hashed";
        } else {
            echo "test456";
            $errors["password_match"] = "The two passwords don't match. Please try again";
        }
    }

    if (empty($_POST["gender"])) {
        $errors["gender"] = "You need to fill in your gender";
    } else {
        if (filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING)) {
            $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
            $_SESSION["gender"] = $gender;
        } else {
            $errors["gender"] = "You need to fill in your you gender correctly";
        }
    }
    // github and linkedin are not required fields,

    // TO DO IF TIME: MAKE IT WORK WITH ONLY WWW.-entry as well or just google.be for example also
    $linkedin = filter_input(INPUT_POST, 'linkedin', FILTER_SANITIZE_URL);
    $_SESSION["linkedin"] = $linkedin;    
    $github = filter_input(INPUT_POST, 'github', FILTER_SANITIZE_URL);
    $_SESSION["github"] = $github;    

    if (empty($_POST["email"])) {
        $errors["email"] = "You need to fill in your email";
    } else {
        if (filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $_SESSION["email"] = $email;
        } else {
            $errors["email"] = "You need to fill in your you email correctly";
        }
    }

    if (empty($_POST["preferred_language"])) {
        $errors["preferred_language"] = "You need to fill in your preferred_language";
    } else {
        if (in_array($_POST["preferred_language"], $iso_639_1_codes)) {
            $preferred_language = filter_input(INPUT_POST, 'preferred_language', FILTER_SANITIZE_STRING);
            $_SESSION["preferred_language"] = $preferred_language;
        } else {
            $errors["preferred_language"] = "You need to fill in your you preferred_language correctly. Google ISO 639-1 Codes";
        }
    }

    if (empty($_POST["avatar"])) {
        $errors["avatar"] = "You need to fill in your avatar";
    } else {
        // uses function declared above 
        if (endsWith($_POST["avatar"], ".jpg") || endsWith($_POST["avatar"], ".jpeg") || endsWith($_POST["avatar"], ".tif") || endsWith($_POST["avatar"], ".gif") || endsWith($_POST["avatar"], ".png")) {
            $avatar = filter_input(INPUT_POST, 'avatar', FILTER_SANITIZE_URL);
            $_SESSION["avatar"] = $avatar;
        } else {
            $errors["avatar"] = "You need to fill in your you avatar correctly. Accepted format are url's ending on .jpg .jpeg .tif .gif .png";
        }
    }
    if (empty($_POST["video"])) {
        $errors["video"] = "You need to fill in your video";
    } else {
        if (filter_input(INPUT_POST, 'video', FILTER_SANITIZE_URL)) {
            $video = filter_input(INPUT_POST, 'video', FILTER_SANITIZE_URL);
            $_SESSION["video"] = $video;
        } else {
            $errors["video"] = "You need to fill in your video correctly";
        }
    }

    // no validation for quote nor for quote_author

    $quote = filter_input(INPUT_POST, 'quote', FILTER_SANITIZE_STRING);
    $_SESSION["quote"] = $quote;    
    $quote_author = filter_input(INPUT_POST, 'quote_author', FILTER_SANITIZE_STRING);
    $_SESSION["quote_author"] = $quote_author;

    $_SESSION["errors"] = $errors;

    if (empty($errors)) {

        try {

            $sql = "INSERT INTO student (first_name, last_name, username, password, gender, linkedin, github, email, preferred_language, avatar, video, quote, quote_author) VALUES (:first_name, :last_name, :username, :password, :gender, :linkedin, :github, :email, :preferred_language, :avatar, :video, :quote, :quote_author)";
            // NOTE: $db repplaces more common $dpo
            $stmt = $db->prepare($sql);

            //$stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password_safe, PDO::PARAM_STR);
            $stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindValue(':linkedin', $linkedin, PDO::PARAM_STR);
            $stmt->bindValue(':github', $github, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':preferred_language', $preferred_language, PDO::PARAM_STR);
            $stmt->bindValue(':avatar', $avatar, PDO::PARAM_STR);
            $stmt->bindValue(':video', $video, PDO::PARAM_STR);
            $stmt->bindValue(':quote', $quote, PDO::PARAM_STR);
            $stmt->bindValue(':quote_author', $quote_author, PDO::PARAM_STR);

            // $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // <-- filter your data first (see [Data Filtering](#data_filtering)), especially important for INSERT, UPDATE, etc.
            // $stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO

            $stmt->execute();
            // NOTE: $db repplaces more common $dpo
            // $insert_id = $db->lastInsertId();
            //echo "Id of the last added record is: " . $insert_id;
            echo "Congratulations, $first_name. You've succesfully registered";
        } catch (PDOException $e) {
            echo '<pre>';
            echo 'Line: ' . $e->getLine() . '<br>';
            echo 'File: ' . $e->getFile() . '<br>';
            echo 'Errormessage: ' . $e->getMessage() . '<br>';
            echo '</pre>';
        }
    }
} elseif (!isset($_POST["submit"]) && empty($_SESSION)) {
    echo "Please enter your data to register";
}

// if (!empty($errors)) {
//     foreach ($errors as $error) {
//         echo $error . "</br>";
//     }
// }

if (!empty($_SESSION["errors"])) {
    foreach ($_SESSION["errors"] as $error) {
        echo $error . "</br>";
    }
}

?>
<article>
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <label for="first_name">First name</label>
        <input type="text" name="first_name" id="first_name" <?php if (isset($_SESSION["first_name"])) {
                                                                    echo "value=" . $_SESSION["first_name"];
                                                                } ?>></br>
        <label for="last_name">Last name</label>
        <input type="text" name="last_name" id="last_name" <?php if (isset($_SESSION["last_name"])) {
                                                                echo "value=" . $_SESSION["last_name"];
                                                            } ?>></br>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" <?php if (isset($_SESSION["username"])) {
                                                                echo "value=" . $_SESSION["username"];
                                                            } ?>></br>
        <!-- NOTE: don't store password in session -->
        <label for="password">Password</label>
        <input type="password" name="password" id="password"></br>
        <label for="password_confirmation">Enter your password once more</label>
        <input type="password" name="password_confirmation" id="password_confirmation"></br>
        <label for="radio_male">Male</label>
        <input type="radio" name="gender" value="male" id="radio_male" <?php if (isset($_SESSION["gender"]) && $_SESSION["gender"] == "male") {
                                                                            echo "checked";
                                                                        } ?>>
        <label for="radio_female">Female</label>
        <input type="radio" name="gender" value="female" id="radio_female" <?php if (isset($_SESSION["gender"]) && $_SESSION["gender"] == "female") {
                                                                                echo "checked";
                                                                            } ?>>
        <label for="radio_other">Other</label>
        <input type="radio" name="gender" value="other" id="radio_other" <?php if (isset($_SESSION["gender"]) && $_SESSION["gender"] == "other") {
                                                                                echo "checked";
                                                                            } ?>></br>
        <label for="linkedin">Linkedin</label>
        <input type="url" name="linkedin" id="linkedin" <?php if (isset($_SESSION["linkedin"])) {
                                                            echo "value=" . $_SESSION["linkedin"];
                                                        } ?>></br>
        <label for="github">Github</label>
        <input type="url" name="github" id="github" <?php if (isset($_SESSION["github"])) {
                                                        echo "value=" . $_SESSION["github"];
                                                    } ?>></br>
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" <?php if (isset($_SESSION["email"])) {
                                                        echo "value=" . $_SESSION["email"];
                                                    } ?>></br>
        <label for="preferred_language">Preferred language (ISO 639-1 code)</label>
        <input type="text" name="preferred_language" maxlength=2 id="preferred_language" <?php if (isset($_SESSION["preferred_language"])) {
                                                                                                echo "value=" . $_SESSION["preferred_language"];
                                                                                            } ?>></br>
        <label for="avatar">Avatar</label>
        <input type="url" name="avatar" id="avatar" <?php if (isset($_SESSION["avatar"])) {
                                                        echo "value=" . $_SESSION["avatar"];
                                                    } ?>></br>
        <label for="video">Video url</label>
        <input type="url" name="video" id="video" <?php if (isset($_SESSION["video"])) {
                                                        echo "value=" . $_SESSION["video"];
                                                    } ?>></br>
        <label for="quote">Quote</label>
        <input type="text" name="quote" id="quote" <?php if (isset($_SESSION["quote"])) {
                                                        echo "value=" . $_SESSION["quote"];
                                                    } ?>></br>
        <label for="quote_author">Quote author</label>
        <input type="text" name="quote_author" id="quote_author" <?php if (isset($_SESSION["quote_author"])) {
                                                                        echo "value=" . $_SESSION["quote_author"];
                                                                    } ?>></br>
        <input type="submit" name="submit_register" value="register!" id="submit_register">
    </form>
</article>
<?php
?>