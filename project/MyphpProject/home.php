<!DOCTYPE html>
<!--
This is the home page for the website. Will allow the user to navigate to 
the various functions.
-->

<html>
    <head>
        <title>Tuck Shop Canteen</title>
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
        <div class = "container">

            <div id ="homeSearchDiv">
                <form name="seggiecampers" action="campers.php">
                    <h2>Search Campers:</h2>
                    <input id = "homeSearchBox" type="text" name="camper" />
                    <input id = "homeSearchButton" type="submit" value="Search" />
                </form>  
            </div>
            <!--<div id ="homeImageBottom">
                    <img alt="" src="images/kidsPool.jpg">
                </div>-->
        </div>
    </body>
</html>



