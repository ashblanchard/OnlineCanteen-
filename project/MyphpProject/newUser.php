<?php include "Includes/connect.php"; ?>
<!DOCTYPE html><!--NEW-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv=”Pragma” content=”no-cache”>
        <meta http-equiv=”Expires” content=”-1″>
        <meta http-equiv=”CACHE-CONTROL” content=”NO-CACHE”>
        <title>Tuck Shop</title>

        <!--Custom CSS-->
        <link href ="styles.css" type ="text/css" rel ="stylesheet"/>
        <link rel="shortcut icon" href="images/favicon.png">

        <!--CSS for Icons-->
        <link rel="stylesheet" href="fontAwesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="fontAwesome/css/font-awesome.css">

        <!--Scripts-->
        <script src ="scripts.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
    <body>
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <h2 class="hello"><?php echo "Hello " . $_SESSION['FirstName'] ?></h2>
            <form class="navSearch" action="campers.php">
                <input class="navSearchBar" type="text" placeholder="Search Campers..." name="camper">
                <input class="navButton" type="submit" value="Search" >
            </form>
            <a href ="home.php">
                <i class="fa fa-home fa-2x" title="Home"> Home</i>
            </a>
            <a href ="inventoryPage.php">
                <i class="fa fa-database fa-2x" title="Inventory"> Inventory</i>
            </a>
            <a href ="settingsPage.php"class="currentLink">

                <i class="fa fa-cogs fa-2x" title="Settings"> Settings</i>
            </a>
            <a href="index.php">
                <i class ="fa fa-sign-out   fa-2x" title="Log Out"> Log Out</i>
            </a>
        </div>
        <div class ="navBannerDiv">
            <img alt = " " class = "navBanner" src = "images/campStore.png">
        </div>
        <div class="backToTop">
            <a href="#top">
                <i class="fa fa-angle-double-up fa-2x"></i>
            </a>
        </div>
        <!----------------------------------------------------------------------->
        <div class = "container">
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
                    $errorMessage = "<p>Sorry, that username is taken. Go back and try again.";
                } if (strcmp($password, $passwordAgain) != 0) {
                    $differentPassword = true;
                    $errorMessage = "Your passwords do not match. Go back and try again.";
                }
                if (strlen($password) < 6 || strlen($password) == 0) {
                    $badPasswordLength = true;
                    $errorMessage = "Password has to be at least 6 characters. Go back and try again.";
                }
                if (!$sameUsername && !$differentPassword && !$badPasswordLength) {
                    $registerquery = mysql_query("INSERT INTO users (FirstName, LastName, Username, Password, EmailAddress) VALUES('" . $firstName . "','" . $lastName . "','" . $username . "', '" . $password . "', '" . $email . "')");
                    echo "<h1> Success!</h1>";
                    echo "User created!";
                } else {
                    echo "<h1>Error</h1>";
                    echo $errorMessage;
                }
            } else {
                echo "<h1>Error</h1>";
                echo $errorMessage;
            }
            ?> 
            <br>
            <a href="settingsPage.php">
                <button class="button" style="margin-top: 10%;">Back</button>
            </a>

        </div>
    </body>
</html>