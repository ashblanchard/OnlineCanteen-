<!DOCTYPE html>
<!--
Author: Patrick McGee
Date: 9/11/2016
-->
<!--SHELL
<html>
    <head>
        <title>Login Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href ="styles.css" type ="text/css" rel ="stylesheet"/>
        <script src ="scripts.js"></script>
    </head>
    <body>
        <div class = "container">


        </div>
    </body>
</html>
-->
<html>
    <head>
        <title>Login Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href ="styles.css" type ="text/css" rel ="stylesheet"/>
        <script src ="scripts.js"></script>
    </head>
    <body>
        <div class = "container">
            <div id ="homeSettingsButton">
                <a href ="settingsPage.php">
                    <img alt ="" src ="images/settingsButton.png">
                </a>
            </div>
            <div id ="homeBannerDiv">
                <img alt = " " id = "homeBanner" src = "images/homeBanner.jpg">
                <h1 id = "homeBannerText">Camp Seggie's Online Canteen</h1>
            </div>
            <hr>
            <br><br><br><br>
            <!--Fix this to be a bigger search bar-->
            <div id ="homeSearchDiv">
                <h3>Search Directory:</h3><br>
                <form id ="homeSearch">
                    <input id ="homeSearchBar" type ="search"style="height: 30px; width: 500px;">
                    <button type ="button" style="height: 30px; width: 100px;">Search</button>
                </form>
            </div>
            <br><br><br><br>
            <br><br><br><br>
            <a href ="login.html">Back to login</a>
        </div>
    </body>
</html>
