<?php 
// phpinfo();
require "head.php";
require "connection.php";

$db = openConnection();
$sql = "SELECT * FROM student";
$results = $db -> query($sql);
foreach ($results as $row) {
    print_r($row);
}

?>