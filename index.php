<?php 
// phpinfo();
require "head.php";
require "connection.php";

$db = openConnection();
$sql = "SELECT first_name, last_name, email, preferred_language FROM student";
$results = $db -> query($sql);
foreach ($results as $row) {
    print_r($row);
}

?>