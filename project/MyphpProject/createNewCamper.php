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
        <link href ="/styles.css" type ="text/css" rel ="stylesheet"/>
        <link rel="shortcut icon" href="/images/favicon.png">

        <!--CSS for Icons-->
        <link rel="stylesheet" href="/fontAwesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/fontAwesome/css/font-awesome.css">

        <!--Scripts-->
        <script src ="scripts.js"></script>
    </head>
    <body>
        <div class = "container">
            <!--Navigation Bar------------------------------------------------------->
            <div class ="navBarLeft">
                <a href ="../home.php">
                    <i class="fa fa-home fa-2x" title="Home"> Home</i>
                </a>
                <a href ="../inventoryPage.php">
                    <i class="fa fa-database fa-2x" title="Inventory"> Inventory</i>
                </a>
                <a href ="../settingsPage.php">

                    <i class="fa fa-cogs fa-2x" title="Settings"> Settings</i>
                </a>
                <a href="../index.php">
                    <i class ="fa fa-sign-out   fa-2x" title="Log Out"> Log Out</i>
                </a>
            </div>
            <div class ="navBannerDiv">
                <img alt = " " class = "navBanner" src = "../images/campStore.png">
            </div>
            <div class="backToTop">
                <a href="#top">
                    <i class="fa fa-angle-double-up fa-2x"></i>
                </a>
            </div>
            <!----------------------------------------------------------------------->

            <?php
            require_once("Includes/db.php");

            /** other variables */
            $nameIsEmpty = false;
            $cabinIsEmpty = false;
            $store_depositIsEmpty = false;

            /** Check that the page was requested from itself via the POST method. */
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                /** Check whether the user has filled in the camper's name in the text field "user" */
                if ($_POST["name"] == "") {
                    $nameIsEmpty = true;
                }
                if ($_POST["camperCabin"] == "") {
                    $cabinIsEmpty = true;
                }
                if ($_POST["store_deposit"] == "") {
                    $store_depositIsEmpty = true;
                }

                if (!$nameIsEmpty && !$cabinIsEmpty && !$store_depositIsEmpty) {
                    SeggieDB::getInstance()->create_new_camper($_POST["name"], $_POST["camperCabin"], $_POST["store_deposit"]);
                    header('Location: settingsPage.php');
                    exit;
                }
            }
            ?>
            <br></br>
            Add New Camper:<br>
            <br></br>
            <form action="createNewCamper.php" method="POST">
                Camper Name: <input type="text" name="name"/><br><br/>
                <?php
                if ($nameIsEmpty) {
                    echo ("Enter camper's name, please!");
                    echo ("<br/>");
                }
                ?> 
                Cabin: <input type="text" name="camperCabin"/><br><br/>
                <?php
                if ($cabinIsEmpty) {
                    echo ("Enter camper's cabin, please!");
                    echo ("<br/>");
                }
                ?>
                Store Deposit: <input type="text" name="store_deposit" /><br><br/>
                <?php
                if ($store_depositIsEmpty) {
                    echo ("Enter camper's store deposit, please!");
                    echo ("<br/>");
                }
                ?>
                <br></br>
                <input type="submit" value="Add Camper"/>
            </form>
        </div>
    </body>
</html>


