<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
$sameUsername = false;
$differentPassword = false;
$badPasswordLength = false;

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $firstName = mysql_real_escape_string($_POST['firstName']);
    $lastName = mysql_real_escape_string($_POST['lastName']);
    $username = mysql_real_escape_string($_POST['username']);
    $password = md5(mysql_real_escape_string($_POST['password']));
    $passwordAgain = md5(mysql_real_escape_string($_POST['passwordAgain']));
    $email = mysql_real_escape_string($_POST['email']);

    $checkusername = mysql_query("SELECT * FROM users WHERE Username = '" . $username . "'");

    if (mysql_num_rows($checkusername) == 1) {
        $sameUsername = true;
        echo "<h1>Error</h1>";
        echo "<p>Sorry, that username is taken. Please go <a href=\"newUser.php\">back</a> and try again.</p>";
    } if (strcmp($password, $passwordAgain) != 0) {
        $differentPassword = true;
        echo "<h1>Error</h1>";
        echo "Your passwords do not match.";
    }
    if (strlen($password) < 6) {
        $badPasswordLength = true;
        echo "<h1>Error</h1>";
        echo "Password has to be at least 6 characters.";
    }

    if (!$sameUsername && !$differentPassword && !$badPasswordLength) {
        $registerquery = mysql_query("INSERT INTO users (FirstName, LastName, Username, Password, EmailAddress) VALUES('" . $firstName . "','" . $lastName . "','" . $username . "', '" . $password . "', '" . $email . "')");
        if ($registerquery) {
            echo "<h1>Success</h1>";
            echo "<p>Your account was successfully created. Please <a href=\"index.php\">click here to login</a>.</p>";
        } else {
            echo "<h1>Error</h1>";
            echo "<p>Sorry, your registration failed. Please go back and try again.</p>";
        }
    }
} else {
    ?>



    <?php
}
?>


