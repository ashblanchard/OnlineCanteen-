<?php
session_start();
?>
<!DOCTYPE html>
<!--
This is the home page for the website. Will allow the user to navigate to 
the various functions.
-->

<html>
    <head>
        <title>Tuck Shop</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Custom CSS-->
        <link href ="styles.css" type ="text/css" rel ="stylesheet"/>
        <link rel="shortcut icon" href="images/favicon.png">

        <!--CSS for Icons-->
        <link rel="stylesheet" href="fontAwesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="fontAwesome/css/font-awesome.css">

        <!--Scripts-->
        <script src ="scripts.js"></script>
    </head>
    <body>
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <form class="navSearch" action="campers.php">
                <input class="navSearchBar" type="text" placeholder="Search Campers..." name="camper">
                <input class="navButton" type="submit" value="Search" >
            </form>
            <a href ="home.php" class="currentLink">
                <i class="fa fa-home fa-2x" title="Home"> Home</i>
            </a>
            <a href ="inventoryPage.php">
                <i class="fa fa-database fa-2x" title="Inventory"> Inventory</i>
            </a>
            <a href ="settingsPage.php">

                <i class="fa fa-cogs fa-2x" title="Settings"> Settings</i>
            </a>
            <a href="index.php">
                <i class ="fa fa-sign-out   fa-2x" title="Log Out"> Log Out</i>
            </a>
        </div>
        <div class ="navBannerDiv">
            <img alt = " " class = "navBanner" src = "images/campStore.png">
        </div>
        <!----------------------------------------------------------------------->
        <?php
        if (isset($_SESSION['password'])) {
            if (!($_SESSION['password'] == "true")) {
                header("Location: index.php");
            }
        } else if (isset($_POST['userpass'])) {
            if (!($_POST['userpass'] == "123456")) {
                header("Location: index.php");
            } else {
                $_SESSION['password'] = "true";
            }
        } else {
            header("Location: index.php");
        }
        ?>
        <div class = "container">
            <div id ="homeSearchDiv">
                <form name="seggiecampers" action="campers.php">
                    <h2>Search:</h2>
                    <input class = "camperSearchBox" placeholder="Search Campers..." type="text" name="camper" />
                    <input class="button" type="submit" value="Search" />
                </form>  
            </div>
        </div>
    </body>
</html>



