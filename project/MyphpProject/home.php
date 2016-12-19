<?php
session_start();
?>
<?php
if (!($_SESSION['LoggedIn'] == 1))
    header("Location: index.php")
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
        <meta http-equiv=”Pragma” content=”no-cache”>
        <meta http-equiv=”Expires” content=”-1″>
        <meta http-equiv=”CACHE-CONTROL” content=”NO-CACHE”>
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
            <h2 class="hello"><?php echo "Hello " . $_SESSION['FirstName'] ?></h2>
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
        <div class = "container">
            <div id ="homeSearchDiv">
                <form name="seggiecampers" action="campers.php">
                    <h2>Search:</h2>
                        <br></br>
                    <input class = "camperSearchBox" placeholder="Search ..." type="text" name="camper" />
                    <input class="button" type="submit" value="Search" />
                </form>  
            </div>
        </div>
    </body>
</html>



