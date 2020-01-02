<?php

session_start();

// to do:
// Create an auth.php file and write both the login and registration logic in them
// 1) The registration logic should: 
// move stuff from register.php here
// If the registration fails, go back to the previous form, fill in all the previously filled in data (except the passwords) and show an error on the correct field
// If the registration succeeds, go to profile.php and show the user's own profile.
// 2) The login logic should: 
// Check if the filled in username / email can be found on a user with that credential
// tip aan mezelf: kijk naar https://github.com/DeClercqJan/fietroute.org-member-rated-cycling-routes-per-province
// Check if the hashed database password, can be matched to the newly hashed (filled in) password
// If not, go back to the login page, giving an error 
// WATCH OUT: never say whether the password or the username/email was incorrect, always say either one of them could be wrong)
// If it's correct, move to the index.php page

?>