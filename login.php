<?php
session_start();

require "head.php";
require "connection.php";

// var_dump($_SESSION);


// TO DO AFTER BREAK: DISPLAY LOGIN STATUS MESSAGES

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