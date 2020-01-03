<?php
session_start();

require "head.php";
require "connection.php";

var_dump($_POST);
echo "</br>";
var_dump($_SESSION);
echo "</br>";

if (isset($_SESSION["status_login"]) && $_SESSION["status_login"] == "no login started") {
    echo $_SESSION["status_login"] . "</br>";
    echo "Please fill in the form below to login </br>";
} elseif (isset($_SESSION["status_login"]) && $_SESSION["status_login"] == "login started, but incomplete") {
    echo $_SESSION["status_login"] . "</br>";
} elseif (!isset($_POST["submit_login"])) {
    if (isset($_SESSION["status_login"]) && $_SESSION["status_login"] == "succesful login") {
    } else {
        echo "Please fill in the form below to login </br>";
    }
}

if (!empty($_SESSION["errors"])) {
    foreach ($_SESSION["errors"] as $error) {
        echo $error . "</br>";
    }
}


?>
<form action="auth.php" method="POST">
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