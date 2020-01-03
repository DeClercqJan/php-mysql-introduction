<?php
session_start();

require "head.php";
require "connection.php";

var_dump($_POST);
echo "</br>";
var_dump($_SESSION);
echo "</br>";

// note: also set status_login after succesful register so less text here needed
if (isset($_SESSION["status_login"]) && $_SESSION["status_login"] == "succesful login") {
    $id = "";
    if (isset($_GET["user"])) {
        echo $_GET["user"];
        $id = $_GET["user"];
    } else {
        echo "You have not chosen a specifc user on <a href='index.php'>index.php</a> so this page show your data by default after having logged in";
        $id = $_SESSION["id"];
    }
    try {
        // TO DO if time: Include an API call to the following API: Be Like Bill, use the documentation to understand how you need to use it, do this using either curl in PHP or ajax in Javascript. The received image (from the api) needs to be worked into the profile page somewhere.(nice to have)
        echo $id;
        $db = openConnection();
        $sql = "SELECT * FROM student WHERE id = :id";
        // NOTE: $db repplaces more common $dpo 
        // NOTE2: bindvalue and bindParam both work
        $stmt = $db->prepare($sql);
        // $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row["username"] == null) {
            echo "the user id was not found. Find an existing list of users on <a href='index.php'>index.php</a>";
        } else {
?>
            <!-- TO DO if time: style this. dispaly video and not url for instance -->
            <!-- also: probably could do this more elegantly and dynamically so that if I add a column, there's no need to change this manually -->
            <article>
                <h2>Registered members</h2>
                <table>
                    <th>id</th>
                    <th>first name</th>
                    <th>last_name</th>
                    <th>username</th>
                    <th>gender</th>
                    <th>linkedin</th>
                    <th>github</th>
                    <th>email</th>
                    <th>preffered language</th>
                    <th>avatar</th>
                    <th>video</th>
                    <th>quote</th>
                    <th>quote_author</th>
                    <th>created at</th>
                    <tr>
                        <td><?php echo $row["id"] ?></td>
                        <td><?php echo $row["first_name"] ?></td>
                        <td><?php echo $row["last_name"] ?></td>
                        <td><?php echo $row["username"] ?></td>
                        <td><?php echo $row["gender"] ?></td>
                        <td><?php echo $row["linkedin"] ?></td>
                        <td><?php echo $row["github"] ?></td>
                        <td><?php echo $row["email"] ?></td>
                        <td><?php echo $row["preferred_language"] ?></td>
                        <td><?php echo $row["avatar"] ?></td>
                        <td><?php echo $row["video"] ?></td>
                        <td><?php echo $row["quote"] ?></td>
                        <td><?php echo $row["quote_author"] ?></td>
                        <td><?php echo $row["created_at"] ?></td>
                    <tr>
                </table>
            </article>
<?php
        }
    } catch (PDOException $e) {
        echo '<pre>';
        echo 'Line: ' . $e->getLine() . '<br>';
        echo 'File: ' . $e->getFile() . '<br>';
        echo 'Errormessage: ' . $e->getMessage() . '<br>';
        echo '</pre>';
    }
} else {
    header("Location: login.php");
}
