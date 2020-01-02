<?php
require "head.php";
require "connection.php";

var_dump($_POST);
?>
<article>
    <h2>Register</h2>
    <form action="insert.php" method="POST">
        <label for="first_name">First name</label>
        <input type="text" name="first_name" id="first_name"></br>
        <label for="last_name">Last name</label>
        <input type="text" name="last_name" id="last_name"></br>
        <label for="username">Username</label>
        <input type="text" name="username" id="username"></br>

        <label for="radio_male">Male</label>
        <input type="radio" name="gender" value="male" id="radio_male">
        <label for="radio_female">Female</label>
        <input type="radio" name="gender" value="female" id="radio_female">
        <label for="radio_other">Other</label>
        <input type="radio" name="gender" value="other" id="radio_other"></br>
        <label for="linkedin">Linkedin</label>
        <input type="url" name="linkedin" id="linkedin"></br>
        <label for="github">Github</label>
        <input type="url" name="github" id="github"></br>
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email"></br>
        <label for="preferred_language">Preferred language (ISO 639-1 code)</label>
        <input type="text" name="preferred_language" maxlength=2 id="preferred_language"></br>
        <label for="avatar">Avatar</label>
        <input type="url" name="avatar" id="avatar"></br>
        <label for="video">Video url</label>
        <input type="url" name="video" id="video"></br>
        <label for="quote">Quote</label>
        <input type="text" name="quote" id="quote"></br>
        <label for="quote_author">Quote author</label>
        <input type="text" name="quote_author" id="quote_author"></br>
        <input type="submit" value="register!" id="submit">
    </form>
</article>
<?php
?>