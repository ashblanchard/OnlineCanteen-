<?php
session_start();
?>
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
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <form class="navSearch" action="campers.php">
                <input class="navSearchBar" type="text" placeholder="Search Campers..." name="camper">
                <input class="navButton" type="submit" value="Search" >
            </form>
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
        <div class = "container">
            <?php
            if (!($_SESSION['password'] == "true")) {
                header("Location: index.php");
            }
            require_once("Includes/db.php");

            $selectedCamper = SeggieDB::getInstance()->get_camperInformation_by_camper_id($_GET["camperid"]);
            while ($row = mysqli_fetch_assoc($selectedCamper)) {
                echo "<h1>" . htmlentities($row["name"]) . "<br/></h1>";
                echo "<h2>Type: " . htmlentities($row["type"]) . "";
                $type = htmlentities($row["type"]);
                if (strcmp($type, "Staff") == 0) {
                    echo "<h3>Amount Due: $" . number_format(htmlentities($row["storeDeposit"]), 2) . "</h3>";
                } else {
                    echo "<h2>Cabin: " . htmlentities($row["cabin"]) . "</h2>";
                    echo "<h3>Initial Balance: $" . number_format(htmlentities($row["initialBalance"]), 2) . "</h3>";
                    echo "<h3>Current Balance: $" . number_format(htmlentities($row["storeDeposit"]), 2) . "</h3>";
                }
            }
            ?>


                <h3>Current Inventory:</h3><br>
                <div class ="resultsDiv">
                     <table class ="resultsTable">
                    <tr>
                        <th> ID </th>
                        <th> Item </th>
                        <th> Price </th>
                        <th> Purchase </th>
                    </tr>
                    <?php
                    require_once("Includes/db.php");

                    $result = SeggieDB::getInstance()->get_allInventoryInfo();
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . htmlentities($row["id"]) . "</td>";
                        echo "<td>" . htmlentities($row["itemName"]) . "</td>";
                        if (strcmp($type, "Staff") == 0) {
                            echo "<td>$" . number_format(htmlentities($row["itemPrice"]), 2) . "</td>";
                        } else {
                            echo "<td>$" . number_format(htmlentities($row["consumerPrice"]), 2) . "</td>";
                        }
                        echo "<td>  </td>";
                    }
                    ?>
                </table>
            </center>
        </div>
    </body>

</html>
