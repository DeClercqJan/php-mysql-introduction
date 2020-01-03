<?php
session_start();

require "head.php";
require "connection.php";

$errors = [];

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
        echo "no errors";;
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

if (!empty($_SESSION["errors"])) {
    foreach ($_SESSION["errors"] as $error) {
        echo $error . "</br>";
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