<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tuck Shop Canteen</title>

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
        <div class = "container">

            <div id="camperSearch">
                <form name="seggiecampers" action="campers.php">
                    <h2>Search Campers:</h2>
                    <input id="camperSearchBar" type="text" name="camper">
                    <input id="camperSearchButton" type="submit" value="Search">
                </form>  
            </div>
            <h4>Search Results: <?php echo $_GET["camper"]; ?></h4>


            <?php
            $con = mysqli_connect("localhost:3308", "root", "root");
            if (!$con) {
                exit('Connect Error (' . mysqli_connect_errno() . ') '
                        . mysqli_connect_error());
            }
            //set the default client character set 
            mysqli_set_charset($con, 'utf-8');
            mysqli_select_db($con, "camp seggie");

            $camper = mysqli_real_escape_string($con, htmlentities($_GET["camper"]));

            $camperdb = mysqli_query($con, "SELECT camper_id FROM camper WHERE name LIKE '%$camper%'");

            if (mysqli_num_rows($camperdb) < 1) {
                exit("The person " . htmlentities($_GET["camper"]) . " is not found. Please check the spelling and try again");
            }
            $row = mysqli_fetch_row($camperdb);
            mysqli_free_result($camperdb);
            ?>

            <div id ="camperSearchResultsDiv">
                <table id="searchResultsTable">
                    <tr>
                        <th>ID#</th>
                        <th>Name</th>
                        <th>Cabin</th>
                        <th>Store Deposit</th>
                    </tr>
                    <?php
                    $result = mysqli_query($con, "SELECT camper_id, name, cabin, balance FROM camper  WHERE name LIKE '%$camper%'");
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr><td>" . htmlentities($row["camper_id"]) . "</td>";
                        echo "<td> <a href=\"camperProfile.php/?camper_id=" . $row["camper_id"] . "\">" . htmlentities($row["name"]) . "</a></td>";
                        echo "<td>" . htmlentities($row["cabin"]) . "</td>";
                        echo "<td>" . htmlentities($row["balance"]) . "</td></tr>\n";
                    }
                    mysqli_free_result($result);
                    mysqli_close($con);
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
