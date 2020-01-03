<?php
session_start();

require "head.php";
require "connection.php";

$errors = [];

if (isset($_POST["submit_register"])) {
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
}

?>
<form action="login.php" method="POST">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" <?php if (isset($_SESSION["username"])) {
                                                            echo "value=" . $_SESSION["username"];
                                                        } ?>></br>
    <!-- NOTE: don't store password in session -->
    <label for="password">Password</label>
    <input type="password" name="password" id="password"></br>
    <input type="submit" name="submit_login" value="login" id="submit_login">
</form>
<?php
//TO DO:
// Create a login.php file and fill it up with a login form (email/password or username/password)
?>