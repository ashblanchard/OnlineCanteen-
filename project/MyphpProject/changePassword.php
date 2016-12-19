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
            $newPasswordDifferent = false;
            $invalidPassword = false;
            $errorMessage = "";
            
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if ((strcmp($_POST['newPass1'], $_POST['newPass2'])) != 0) {
                    $newPasswordDifferent = true;
                    $errorMessage = "The passwords you entered are different.";
                }if (strlen($_POST['newPass1']) < 6) {
                    $invalidPassword = true;
                    $errorMessage = "Your password has to be at least 6 characters.";
                }if (!$newPasswordDifferent && !$invalidPassword) {
                    $password = md5($_POST['newPass1']);
                    mysql_query("UPDATE users SET Password = '" . $password . "' WHERE Username = '" . $_SESSION['Username'] . "'");

                    header('Location: settingsPage.php');
                    exit;
                } else {
                    echo "ERROR: $errorMessage";
                }
            }
            ?>

            <br>
            <a href="settingsPage.php">
                <button class="button" style="margin-top: 10%;">Back</button>
            </a>
        </div>
    </body>
</html>