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
        <!--Custom CSS-->
        <link href ="styles.css" type ="text/css" rel ="stylesheet"/>
        <link rel="shortcut icon" href="images/favicon.png">
        <!--Scripts-->
        <script src ="scripts.js"></script>
    </head>
    <body>
        <div class = "container">  
            <div id ="loginBanner">
                <img src = "images/bannerImageNoTitle.png">
            </div>
            <h1 class = "navBannerText">Online Canteen</h1>
            <div id ="passwordDiv">
                <form name="frm" method="post" action="home.php">
                    <h3>Enter Password:</h3><br>
                    <input id = "passwordBox" type ="password" name="userpass">
                    <input type="submit" id ="loginButton" value="Submit" onclick="return val();" style = "" />
                    <br><input id="loginReset" type="reset" value="Reset"/>
                </form>
            </div>
            <div id ="loginBottomImage">
                <img alt="" src="images/campStore.png">
            </div>
        </div>
    </body>
</html>