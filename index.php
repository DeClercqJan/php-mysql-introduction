<?php
// phpinfo();
session_start();

require "head.php";
require "connection.php";

var_dump($_POST);
echo "</br>";
var_dump($_SESSION);
echo "</br>";

if (isset($_SESSION["first_load_after_login"]) && $_SESSION["first_load_after_login"] == true) {
    // I only want to display this once, not on refresh so I created a 
    $_SESSION["first_load_after_login"] = false;
    // don't reset this as I want't it to persist for the duration of the session
    echo $_SESSION["status_login"] . "</br>";
}

if (isset($_SESSION["status_login"]) && $_SESSION["status_login"] == "succesful login") {
    $db = openConnection();
    $sql = "SELECT id, first_name, last_name, email, preferred_language FROM student";
    // NOTE: $db repplaces more common $dpo 
    $results = $db->query($sql);
?>
    <article>
        <h2>Registered members</h2>
        <table>
            <th>first name</th>
            <th>last_name</th>
            <th>email</th>
            <th>preffered language</th>
            <th>profile page</th>
            <?php
            foreach ($results as $row) {
            ?>
                <tr>
                    <td><?php echo $row["first_name"] ?></td>
                    <td><?php echo $row["last_name"] ?></td>
                    <td><?php echo $row["email"] ?></td>
                    <td><?php echo $row["preferred_language"] ?></td>
                    <td><?php echo "<a href='profile.php?user=$row[id]'>See more</a>" ?></td>
                <tr>
                <?php
            }
                ?>
        </table>
    </article>
<?php

} else {
    header("Location: login.php");
}
// HOW LINK LANGUAGE AND COUNTRY? Their preferred language (in the form of an icon (flag)) 





?>