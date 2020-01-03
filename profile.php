<?php 
session_start();

require "head.php";
require "connection.php";

// note: other registration statusses on register.php
if (isset($_SESSION["status_registration"]) && $_SESSION["status_registration"] == "succesful registration") {
    echo $_SESSION["status_registration"];
    // to do: check if there are more things that need to be reset
    $_SESSION["status_registration"] = "";
}

// to do:
// On profile.php get the required user's details from the database
// Print them out on a profile page you design, if you need inspiration, you can look here
// Include an API call to the following API: Be Like Bill, use the documentation to understand how you need to use it, do this using either curl in PHP or ajax in Javascript. The received image (from the api) needs to be worked into the profile page somewhere.(nice to have)
// Every column of the database table needs to be shown someway
// The final result needs to be a coherent profile page
