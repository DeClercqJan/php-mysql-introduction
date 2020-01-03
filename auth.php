<?php

session_start();

require "head.php";
require "connection.php";

var_dump($_POST);
// var_dump($_SESSION);

// to do:
// Create an auth.php file and write both the login and registration logic in them
// 1) The registration logic should: 
// move stuff from register.php here
// If the registration fails, go back to the previous form, fill in all the previously filled in data (except the passwords) and show an error on the correct field
// If the registration succeeds, go to profile.php and show the user's own profile.
// 2) The login logic should: 
// Check if the filled in username / email can be found on a user with that credential
// tip aan mezelf: kijk naar https://github.com/DeClercqJan/fietroute.org-member-rated-cycling-routes-per-province
// Check if the hashed database password, can be matched to the newly hashed (filled in) password
// If not, go back to the login page, giving an error 
// WATCH OUT: never say whether the password or the username/email was incorrect, always say either one of them could be wrong)
// If it's correct, move to the index.php page



$errors = [];

// REGISTRATION
include "country_codes.php";

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
    echo "test isset submit register start proces";
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
            // this one messes up color scheme in vscode, but I don't see any brackets error ... so i changed it to $_POST
            // $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
            $gender = $_POST["gender"];
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
            // this one messes up color scheme in vscode, but I don't see any brackets error ... so i changed it to $_POST
            // $video = filter_input(INPUT_POST, 'video', FILTER_SANITIZE_URL);
            $video = $_POST["video"];
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
}

if (isset($_POST["submit_register"]) && empty($_SESSION["errors"])) {
    echo "will try to connect to db";
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
        $id = $db->lastInsertId();
        echo "Id of the last added record is: " . $id;
        // echo "Congratulations, $username. You've succesfully registered";
        $_SESSION["status_registration"] = "succesful_registration";
        header("Location: profile.php?user=$id.php");
    } catch (PDOException $e) {
        echo '<pre>';
        echo 'Line: ' . $e->getLine() . '<br>';
        echo 'File: ' . $e->getFile() . '<br>';
        echo 'Errormessage: ' . $e->getMessage() . '<br>';
        echo '</pre>';
    }
} 
elseif (isset($_POST["submit_register"]) && !empty($_SESSION)) {
    $_SESSION["status_registration"] = "registration_started";
    header("Location: register.php");
} elseif (!isset($_POST["submit_register"]) && empty($_SESSION)) {
    $_SESSION["status_registration"] = "no_registration_started";
    header("Location: register.php");
}

// LOGIN 
if (isset($_POST["submit_login"])) {
    echo "test login";
    $db = openConnection();

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

    if (empty($_POST["password"])) {
        $errors["password"] = "You need to fill in a password";
    } else {
        if (filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)) {
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            // note storing password in session!
        } else {
            $errors["password"] = "You need to fill in your you password correctly";
        }
    }

    $_SESSION["errors"] = $errors;

    if (empty($errors)) {
        echo "no errors";
        try {
            $sql = "SELECT password, id FROM student WHERE username = :username";
            // NOTE: $db repplaces more common $dpo
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $password_hashed = $row["password"];
            $id = $row["id"];
            if (password_verify($password, $password_hashed)) {
                echo "Congratulations, $username. You've succesfully logged in";
                $_SESSION["id"] = $id;
                // header("Location: zoeken.php");
            } else {

                //echo "<p>er is een fout bij het aanmelden</p>";
                //echo "<a href='aanmelden.php'>Terug naar de pagina aanmelden</a>";
            }
        } catch (PDOException $e) {
            echo '<pre>';
            echo 'Line: ' . $e->getLine() . '<br>';
            echo 'File: ' . $e->getFile() . '<br>';
            echo 'Errormessage: ' . $e->getMessage() . '<br>';
            echo '</pre>';
        }
    }
} elseif (!isset($_POST["submit_login"]) && empty($_SESSION)) {
    echo "Please enter your data to login";
}