<!DOCTYPE html>
<!--
This is the page that will show up upon opening the site. 
Login page for users
-->
<html>
    <head>
        <title>Login Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv=”Pragma” content=”no-cache”>
        <meta http-equiv=”Expires” content=”-1″>
        <meta http-equiv=”CACHE-CONTROL” content=”NO-CACHE”>
        <!--Custom CSS-->
        <link href ="styles.css" type ="text/css" rel ="stylesheet"/>
        <link rel="shortcut icon" href="images/favicon.png">
        <!--Scripts - Password verification code -->
        <script src ="scripts.js"></script>
    </head>
    <body>
        <div class = "container">  
            <div id ="loginBanner">
                <img src = "images/bannerImageNoTitle.png">
            </div>
            <h1 class = "navBannerText">Welcome to the Tuck Shop</h1>
            <?php
            include "Includes/connect.php";
            if (!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
                $_SESSION = array();
                session_destroy();
                ?>
                <meta http-equiv="refresh" content="0;index.php">
                <?php
            } elseif (!empty($_POST['username']) && !empty($_POST['password'])) {
                $username = mysql_real_escape_string($_POST['username']);
                $password = md5(mysql_real_escape_string($_POST['password']));

                $checklogin = mysql_query("SELECT * FROM users WHERE Username = '" . $username . "' AND Password= '" . $password . "'");
                if ($checklogin === FALSE) {
                    die(mysql_error());
                }
                if (mysql_num_rows($checklogin) == 1) {
                    $row = mysql_fetch_array($checklogin);
                    $email = $row['EmailAddress'];
                    $firstName = $row['FirstName'];

                    $_SESSION['Username'] = $username;
                    $_SESSION['EmailAddress'] = $email;
                    $_SESSION['FirstName'] = $firstName;
                    $_SESSION['LoggedIn'] = 1;

                    echo "<h1>Success</h1>";
                    echo "<p>We are now redirecting you to the member area.</p>";
                    header("Location:home.php");
                } else {
                    echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
                }
            } else {
                ?>

                <div id ="passwordDiv"> 

                    <form name="frm" method="post" action="index.php">
                        <h3>Username:</h3>
                        <input id = "passwordBox" type ="text" name="username">
                        <h3>Password:</h3>
                        <input id = "passwordBox" type ="password" name="password">
                        <br><input type="submit" class="button" value="Submit" style = "margin-top: 10px;" />
                        <br><input class="button" type="reset" value="Reset" style="margin-top: 10px;">
                    </form>
                </div>

                <!-- Camp Seggie logo on bottom of login page -->
                <div id ="loginBottomImage">
                    <img alt="" src="images/campStore.png">
                </div>
            <?php } ?>
        </div>
    </body>
</html>