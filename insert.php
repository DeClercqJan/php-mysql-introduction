<?php
require "head.php";
require "connection.php";
include "country_codes.php";

//var_dump($_POST);

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

if (isset($_POST["submit"])) {
    $db = openConnection();

    // validation: probably some cases will never fire, but it's more standardized this way. Also, probably more safe this way
    if (empty($_POST["first_name"])) {
        $errors["first_name"] = "You need to fill in your first name";
    } else {
        if (filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING)) {
            // way learned in Het Perspectief
            $first_name = $db->quote(htmlentities($_POST["first_name"]));
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
        } else {
            $errors["last_name"] = "You need to fill in your you last name correctly";
        }
    }

    if (empty($_POST["username"])) {
        $errors["username"] = "You need to fill in your username";
    } else {
        if (filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)) {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        } else {
            $errors["username"] = "You need to fill in your you username correctly";
        }
    }

    if (empty($_POST["gender"])) {
        $errors["gender"] = "You need to fill in your gender";
    } else {
        if (filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING)) {
            $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
        } else {
            $errors["gender"] = "You need to fill in your you gender correctly";
        }
    }
    // github and linkedin are not required fields,
    // TO DO IF TIME: MAKE IT WORK WITH ONLY WWW.-entry as well or just google.be for example also
    $linkedin = filter_input(INPUT_POST, 'linkedin', FILTER_SANITIZE_URL);
    $github = filter_input(INPUT_POST, 'github', FILTER_SANITIZE_URL);

    if (empty($_POST["email"])) {
        $errors["email"] = "You need to fill in your email";
    } else {
        if (filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) {
            $gender = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        } else {
            $errors["email"] = "You need to fill in your you email correctly";
        }
    }

    if (empty($_POST["preferred_language"])) {
        $errors["preferred_language"] = "You need to fill in your preferred_language";
    } else {
        if (in_array($_POST["preferred_language"], $iso_639_1_codes)) {
            $preferred_language = filter_input(INPUT_POST, 'preferred_language', FILTER_SANITIZE_STRING);
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
        } else {
            $errors["avatar"] = "You need to fill in your you avatar correctly. Accepted format are url's ending on .jpg .jpeg .tif .gif .png";
        }
    }
    if (empty($_POST["video"])) {
        $errors["video"] = "You need to fill in your video";
    } else {
        if (filter_input(INPUT_POST, 'video', FILTER_SANITIZE_EMAIL)) {
            $video = filter_input(INPUT_POST, 'video', FILTER_SANITIZE_URL);
        } else {
            $errors["video"] = "You need to fill in your video correctly";
        }
    }
    if (empty($_POST["video"])) {
        $errors["video"] = "You need to fill in your video";
    } else {
        if (filter_input(INPUT_POST, 'video', FILTER_SANITIZE_EMAIL)) {
            $video = filter_input(INPUT_POST, 'video', FILTER_SANITIZE_URL);
        } else {
            $errors["video"] = "You need to fill in your video correctly";
        }
    }

    // no validation for quote nor for quote_author

    if (empty($errors)) {

        try {

            $quote = filter_input(INPUT_POST, 'quote', FILTER_SANITIZE_STRING);
            $quote_author = filter_input(INPUT_POST, 'quote_author', FILTER_SANITIZE_STRING);

            $sql = "INSERT INTO student (first_name, last_name, gender, linkedin, github, email, preferred_language, avatar, video, quote, quote_author) VALUES (:first_name, :last_name, :gender, :linkedin, :github, :email, :preferred_language, :avatar, :video, :quote, :quote_author)";
            // NOTE: $db repplaces more common $dpo
            $stmt = $db->prepare($sql);

            //$stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
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
} else {
    echo "Please enter your data to register";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "</br>";
    }
}

?>
<article>
    <h2>Register</h2>
    <form action="insert.php" method="POST">
        <label for="first_name">First name</label>
        <input type="text" name="first_name" id="first_name"></br>
        <label for="last_name">Last name</label>
        <input type="text" name="last_name" id="last_name"></br>
        <label for="username">Username</label>
        <input type="text" name="username" id="username"></br>

        <label for="radio_male">Male</label>
        <input type="radio" name="gender" value="male" id="radio_male">
        <label for="radio_female">Female</label>
        <input type="radio" name="gender" value="female" id="radio_female">
        <label for="radio_other">Other</label>
        <input type="radio" name="gender" value="other" id="radio_other"></br>
        <label for="linkedin">Linkedin</label>
        <input type="url" name="linkedin" id="linkedin"></br>
        <label for="github">Github</label>
        <input type="url" name="github" id="github"></br>
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email"></br>
        <label for="preferred_language">Preferred language (ISO 639-1 code)</label>
        <input type="text" name="preferred_language" maxlength=2 id="preferred_language"></br>
        <label for="avatar">Avatar</label>
        <input type="url" name="avatar" id="avatar"></br>
        <label for="video">Video url</label>
        <input type="url" name="video" id="video"></br>
        <label for="quote">Quote</label>
        <input type="text" name="quote" id="quote"></br>
        <label for="quote_author">Quote author</label>
        <input type="text" name="quote_author" id="quote_author"></br>
        <input type="submit" name="submit" value="register!" id="submit">
    </form>
</article>
<?php
?>