<?php
require "head.php";
require "connection.php";

var_dump($_POST);
$test2 = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
echo "DIT IS TEST2: $test2";

 if (isset($_POST)) {
    echo "test isset";
    try {
        $test = $_POST["first_name"];
        var_dump($test);

        $db = openConnection();

        // way learned in Het Perspectief
        $first_name = $db->quote(htmlentities($_POST["first_name"]));
        var_dump($first_name);

        // way according to https://phptherightway.com/#pdo_extension + https://www.php.net/manual/en/filter.filters.sanitize.php (note: didn't researched teh filters well, but chose on the basis of the name)
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        var_dump($last_name);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        // $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
        $linkedin = filter_input(INPUT_POST, 'linkedin', FILTER_SANITIZE_URL);
        $github = filter_input(INPUT_POST, 'github', FILTER_SANITIZE_URL);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $preferred_language = filter_input(INPUT_POST, 'preferred_language', FILTER_SANITIZE_STRING);
        $avatar = filter_input(INPUT_POST, 'avatar', FILTER_SANITIZE_URL);
        $video = filter_input(INPUT_POST, 'video', FILTER_SANITIZE_URL);
        $quote = filter_input(INPUT_POST, 'quote', FILTER_SANITIZE_STRING);
        $quote_author = filter_input(INPUT_POST, 'quote_author', FILTER_SANITIZE_STRING);

        // $sql = "INSERT INTO student (first_name, last_name, username, gender, linkedin, github, email, preferred_language, avatar, video, quote, quote_author) VALUES (:first_name, :last_name, :username, :gender, :linkedin, :github, :email, :preferred_language, :avatar, :video, :quote, :quote_author)";
        // $sql = "INSERT INTO student (first_name, last_name) VALUES (:first_name, :last_name)";
        //$sql = "INSERT INTO student (first_name, last_name, username, gender, linkedin, github, email, preferred_language, avatar, video, quote, quote_author) VALUES (:first_name, :last_name, '', 'mannetje', '', '', '', '', '', '', '', '')";
        $sql = "INSERT INTO student (first_name, last_name, gender, linkedin, github, email, preferred_language, avatar, video, quote, quote_author) VALUES (:first_name, :last_name, :gender, :linkedin, :github, :email, :preferred_language, :avatar, :video, :quote, :quote_author)";
        // NOTE: $db repplaces more common $dpo
        $stmt = $db->prepare($sql);

        //$stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindValue(':linkedin', $linkedin, PDO::PARAM_STR);
        $stmt->bindValue(':github', $github, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':preferred_language', $preferred_language, PDO::PARAM_STR);
        $stmt->bindValue(':avatar', $avatar, PDO::PARAM_STR);
        $stmt->bindValue(':video', $video, PDO::PARAM_STR);
        $stmt->bindValue(':quote', $quote, PDO::PARAM_STR);
        $stmt->bindValue(':quote_author', $quote_author, PDO::PARAM_STR);

        // $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // <-- filter your data first (see [Data Filtering](#data_filtering)), especially important for INSERT, UPDATE, etc.
        // $stmt->bindParam(':id', $id, PDO::PARAM_INT); // <-- Automatically sanitized for SQL by PDO
        
        $stmt->execute();
        // NOTE: $db repplaces more common $dpo
        $insert_id = $db->lastInsertId();
        echo "Id of the last added record is: " . $insert_id;
    } catch (PDOException $e) {
        echo '<pre>';
        echo 'Line: ' . $e -> getLine() . '<br>';
        echo 'File: ' . $e -> getFile() . '<br>';
        echo 'Errormessage: ' . $e -> getMessage() . '<br>';
        echo '</pre>';
    } 
 }
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