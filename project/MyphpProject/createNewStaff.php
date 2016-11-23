<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tuck Shop</title>

        <!--Custom CSS-->
        <link href ="../styles.css" type ="text/css" rel ="stylesheet"/>
        <link rel="shortcut icon" href="../images/favicon.png">

        <!--CSS for Icons-->
        <link rel="stylesheet" href="../fontAwesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="../fontAwesome/css/font-awesome.css">

        <!--Scripts-->
        <script src ="scripts.js"></script>
    </head>
    <body>
        <div class = "container">
            <!--Navigation Bar------------------------------------------------------->
            <div class ="navigationBar">
                <span class="backButton">
                    <a href="../index.php">
                        <i class="fa fa-reply-all  fa-2x" title="Back to Login">Log Out</i>
                    </a>
                </span>
                <span class="homeButton">
                    <a href ="../home.php">
                        <i class="fa fa-home fa-2x" title="Home"style="margin-right: 16px;">Home</i>
                    </a>
                </span>
                <span class = "settingsButton">
                    <a href ="../settingsPage.php">
                        <i class="fa fa-cogs fa-2x" title="Settings">Settings</i>
                    </a>
                </span>
                <div class ="navBannerDiv">
                    <img alt = "" class = "navBanner" src = "../images/campStore.png">
                    <h1 class = "navBannerText"><!--Page Text here, If needed--></h1>
                </div>
                <hr>
            </div>
            <!----------------------------------------------------------------------->
        </div>
        <?php
        /** other variables */
        $nameIsEmpty = false;

        /** Check that the page was requested from itself via the POST method. */
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            /** Check whether the user has filled in the camper's name in the text field "user" */
            if ($_POST["name"] == "") {
                $nameIsEmpty = true;
            }

            if (!$nameIsEmpty) {
                SeggieDB::getInstance()->create_new_staff($POST["name"]);
                header('Location: settingsPage.php');
                exit;
            }
        }
        ?>
        <br></br>
        Add New Staff:<br>
        <br></br>
        <form action="createNewStaff.php" method="POST">
            Name: <input type="text" name="name"/><br/>
            <?php
            if ($nameIsEmpty) {
                echo ("Enter staff's name, please!");
                echo ("<br/>");
            }
            ?> 
            <br></br>
            <input type="submit" value="Add Staff"/>
        </form>
    </body>
</html>

