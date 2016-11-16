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
        <div class = "container">
            <!--Navigation Bar------------------------------------------------------->
            <div class ="navigationBar">
                <span class="backButton">
                    <a href="index.php">
                        <i class="fa fa-reply-all  fa-2x" title="Back to Login">Log Out</i>
                    </a>
                </span>
                <span class="homeButton">
                    <a href ="home.php">
                        <i class="fa fa-home fa-2x" title="Home">Home</i>
                        <i class="fa fa-caret-left fa-2x"></i> 
                    </a>
                </span>
                <span class = "settingsButton">
                    <a href ="settingsPage.php">
                        <i class="fa fa-cogs fa-2x" title="Settings" style="margin-right: 16px;">Settings</i>
                    </a>
                </span>
                <div class ="navBannerDiv">
                    <img alt = " " class = "navBanner" src = "images/campStore.png">
                    <h1 class = "navBannerText"><!--Page Text here, If needed--></h1>
                </div>
                <hr>
            </div>
            <!----------------------------------------------------------------------->

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



