<?php
// phpinfo();
session_start();

require "head.php";
require "connection.php";

// TO DO:
// Now, obviously we don't want non-logged-in people to see index.php with all our data, so protect index.php so that it checks for the user's login status and redirects to login.php when not logged in.

$db = openConnection();
$sql = "SELECT id, first_name, last_name, email, preferred_language FROM student";
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


// HOW LINK LANGUAGE AND COUNTRY? Their preferred language (in the form of an icon (flag)) 

?>