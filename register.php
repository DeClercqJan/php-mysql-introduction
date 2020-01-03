<?php

session_start();

require "head.php";
require "connection.php";

var_dump($_POST);
echo "</br>";
var_dump($_SESSION);
echo "</br>";

if(!isset($_POST["submit_register"]) || isset($_SESSION["status_registration"]) && $_SESSION["status_registration"] == "no registration started") {
    // echo $_SESSION["status_registration"] . "</br>";
    echo "Please fill in the form below to register </br>";
}
elseif(isset($_SESSION["status_registration"]) && $_SESSION["status_registration"] == "registration started, but incomplete") {
    echo $_SESSION["status_registration"] . "</br>";

}

if (!empty($_SESSION["errors"])) {
    foreach ($_SESSION["errors"] as $error) {
        echo $error . "</br>";
    }
}

// if(isset($_SESSION["status_registration"]) && $_SESSION["status_registration"] == "no_registration_started") {
//     echo "Please enter your data to register";
//     // to do: check if there are more things that need to be reset
//     $_SESSION["status_registration"] = "";
// }



?>
<article>
    <h2>Register</h2>
    <form action="auth.php" method="POST">
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