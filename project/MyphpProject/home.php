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
            <div id ="settingsPageLink">
                <a href ="settingsPage.php">
                    <img alt ="" src ="images/settingsButton.png" title="Settings">
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
                <form name="seggiecampers" action="campers.php">
                    Search Directory:
                    <input type="text" name="camper"  style = "width: 500px; height: 20px;"/>
                    <input type="submit" value="Search" />
                </form>  
            </div>
            <br><br><br><br>
            <br><br><br><br>
            <center>
                <img alt="" src="images/kidsPool.jpg">
            </center>
            <br></br>
            <a href ="index.php">Back to login</a>
        </div>
    </body>
</html>



