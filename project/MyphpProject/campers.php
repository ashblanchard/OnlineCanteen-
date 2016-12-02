<?php
session_start();
?>
<?php
if (!($_SESSION['LoggedIn'] == 1))
    header("Location: index.php")
    ?>
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
            <a href ="home.php">
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
        <div class="backToTop">
            <a href="#top">
                <i class="fa fa-angle-double-up fa-2x"></i>
            </a>
        </div>
        <!----------------------------------------------------------------------->
        <div class="container">
            <div id ="camperSearch">
                <form name="seggiecampers" action="campers.php">
                    <h2>Search:</h2>
                    <input class="camperSearchBox" placeholder="Search Campers..." type="text" name="camper">
                    <input class="button" type="submit" value="Search">
                </form> 
            </div>

            <h4>Search Results: <?php echo $_GET["camper"] . "<br/>"; ?> </h4>


            <?php
            require_once("Includes/db.php");

            $camperID = SeggieDB::getInstance()->get_allSimilarCamper_id_by_name($_GET["camper"]);
            if (!$camperID) {
                exit("The person " . $_GET["camper"] . " is not found. Please check the spelling and try again");
            }
            ?>
            <div class ="resultsDiv">
                <table class="resultsTable">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Cabin</th>
                            <th>Store Deposit</th>
                        </tr>
                    </thead>
                    <?php
                    $result = SeggieDB::getInstance()->get_allSimilarCamperInformation_by_camper_id($_GET["camper"]);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<td>" . htmlentities($row["type"]) . "</td>";
                        echo "<td> <a href=\"camperProfile.php/?camperid=" . $row["id"] . "\">" . htmlentities($row["name"]) . "</a></td>";
                        echo "<td>" . htmlentities($row["cabin"]) . "</td>";
                        echo "<td>" . htmlentities($row["storeDeposit"]) . "</td></tr>\n";
                    }
                    mysqli_free_result($result);
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
