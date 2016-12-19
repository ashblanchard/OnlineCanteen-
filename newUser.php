<?php include "Includes/connect.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html  
    <body>  
        <div>
            <?php
            $sameUsername = false;
            $differentPassword = false;
            $badPasswordLength = false;
            $errorMessage = "";

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
                    $errorMessage = "<p>Sorry, that username is taken. Please go <a href=\"settingsPage.php\">back</a> and try again.</p>";
                } if (strcmp($password, $passwordAgain) != 0) {
                    $differentPassword = true;
                    $errorMessage = "Your passwords do not match. Please go <a href=\"settingsPage.php\">back</a> and try again.";
                }
                if (strlen($password) < 6) {
                    $badPasswordLength = true;
                    $errorMessage = "Password has to be at least 6 characters. Please go <a href=\"settingsPage.php\">back</a> and try again.";
                }

                if (!$sameUsername && !$differentPassword && !$badPasswordLength) {
                    $registerquery = mysql_query("INSERT INTO users (FirstName, LastName, Username, Password, EmailAddress) VALUES('" . $firstName . "','" . $lastName . "','" . $username . "', '" . $password . "', '" . $email . "')");

                    echo "<h1> Success!</h1>";
                    echo "New user created return to settings page  <a href=\"settingsPage.php\">back</a>. ";
                } else {
                    echo "<h1>Error</h1>";
                    echo $errorMessage;
                }
            }
            ?> 


        </div>
    </body>
</html>
