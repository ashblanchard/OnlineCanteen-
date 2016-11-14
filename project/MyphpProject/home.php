<!DOCTYPE html>
<!--
This is the home page for the website. Will allow the user to navigate to 
the various functions.
-->

<html>
    <head>
        <title>Home Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href ="styles.css" type ="text/css" rel ="stylesheet"/>
        <script src ="scripts.js"></script>
    </head>
    <body>
        <div class = "container">
            <!----------------------------------------------------------------------->
            <div class ="navigationBar">
                
                <a href="index.php">
                    <img class="backButton" alt ="" src ="images/backBack.png" title="Previous Page">
                </a>
                
                <a href ="home.php">
                    <img class="homeButton" alt ="" src ="images/homeButton.png" title="Home">
                </a>
                
                <a href ="settingsPage.php">
                    <img class = "settingsButton" alt ="" src ="images/settingsButton.png" title="Settings">
                </a>
            </div>
            <!----------------------------------------------------------------------->
            <div id ="homeBannerDiv">
                <img alt = " " id = "homeBanner" src = "images/campStore.png">
                <h1 id = "homeBannerText">Online Canteen</h1>
            </div>
            <hr>

            <!--Fix this to be a bigger search bar-->
            <div id ="homeSearchDiv">
                <form name="seggiecampers" action="campers.php">
                    <h3>Search Directory:</h3>
                    <input id = "homeSearchBox" type="text" name="camper" />
                    <input id = "homeSearchButton" type="submit" value="Search" />
                </form>  
            </div>

            <div id ="homeImageBottom">
                <img alt="" src="images/kidsPool.jpg">
            </div>

            <div id ="linkToLogin">
                <a href ="index.php">Back to login</a>
            </div>
        </div>
    </body>
</html>



