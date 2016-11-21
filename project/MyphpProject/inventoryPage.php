<?php
/** database connection credentials */
$dbHost = "localhost"; //on MySql
$dbUsername = "phpuser";
$dbPassword = "phpuserpw";

/** other variables */
$itemNameIsEmpty = false;
$originalPriceIsEmpty = false;
$consumerPriceIsEmpty = false;
$quantityIsEmpty = false;

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /** Check whether the user has filled in the camper's name in the text field "user" */
    if ($_POST["itemName"] == "") {
        $itemNameIsEmpty = true;
    }
    if ($_POST["originalPrice"] == "") {
        $originalPriceIsEmpty = true;
    }
    if ($_POST["consumerPrice"] == "") {
        $consumerPriceIsEmpty = true;
    }
    if ($_POST["quantity"] == "") {
        $quantityIsEmpty = true;
    }
    /** Create database connection */
    $con = mysqli_connect("localhost", "phpuser", "phpuserpw");
    if (!$con) {
        exit('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }
//set the default client character set 
    mysqli_set_charset($con, 'utf-8');

    $itemName = mysqli_real_escape_string($con, $_POST['itemName']);
    $originalPrice = mysqli_real_escape_string($con, $_POST['originalPrice']);
    $consumerPrice = mysqli_real_escape_string($con, $_POST['consumerPrice']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);

    mysqli_select_db($con, "seggiecampers");
    mysqli_query($con, "INSERT inventory (itemName, itemPrice, consumerPrice, quantity) VALUES ('" . $itemName . "', '" . $originalPrice . "', '" . $consumerPrice . "','" . $quantity . "')");
    mysqli_close($con);
    header('Location:inventoryPage.php');
    exit;
}
?>
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
            <a href ="inventoryPage.php" class="currentLink">
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

            <!--Currently hidden, to style later-->
            <div id="newInventory">
                <h1>Add New Inventory:</h1>
                <!--Replace the PHP here with Javascript, so it can prompt the user 
                for the fields without calling the database-->
                <form action="inventoryPage.php" method="POST">
                    Item Name: <input type="text" name="itemName">
                    <?php
//                    if ($itemNameIsEmpty) {
//                        echo ("Enter item's name, please!");
//                        echo ("<br/>");
//                    }
//                    
                    ?>
                    Original Price: <input type="text" name="originalPrice">
                    <?php
//                    if ($originalPriceIsEmpty) {
//                        echo ("Enter original price, please!");
//                        echo ("<br/>");
//                    }
//                    
                    ?>
                    Consumer Price: <input type="text" name="consumerPrice">
                    <?php
//                    if ($consumerPriceIsEmpty) {
//                        echo ("Enter consumer price, please!");
//                        echo ("<br>");
//                    }
//                    
                    ?>
                    Quantity: <input type="text" name="quantity">
                    <?php
//                    if ($quantityIsEmpty) {
//                        echo ("Enter quantity of item, please!");
//                        echo ("<br>");
//                    }
//                    
                    ?>
                    <input type="submit" onblur="checkField()"> <!--value="Add Inventory"-->
                </form>
            </div>



            <div id="inventoryDiv">
                <h1>Current Inventory:</h1>
                <table id="inventoryTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Original Price</th>
                            <th>Consumer Price</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1,001</td>
                            <td>Lorem</td>
                            <td>ipsum</td>
                            <td>dolor</td>
                            <td>sit</td>
                        </tr>
                        <tr>
                            <td>1,002</td>
                            <td>amet</td>
                            <td>consectetur</td>
                            <td>adipiscing</td>
                            <td>elit</td>
                        </tr>
                        <tr>
                            <td>1,003</td>
                            <td>Integer</td>
                            <td>nec</td>
                            <td>odio</td>
                            <td>Praesent</td>
                        </tr>
                        <tr>
                            <td>1,003</td>
                            <td>libero</td>
                            <td>Sed</td>
                            <td>cursus</td>
                            <td>ante</td>
                        </tr>
                        <tr>
                            <td>1,004</td>
                            <td>dapibus</td>
                            <td>diam</td>
                            <td>Sed</td>
                            <td>nisi</td>
                        </tr>
                        <tr>
                            <td>1,005</td>
                            <td>Nulla</td>
                            <td>quis</td>
                            <td>sem</td>
                            <td>at</td>
                        </tr>
                        <tr>
                            <td>1,006</td>
                            <td>nibh</td>
                            <td>elementum</td>
                            <td>imperdiet</td>
                            <td>Duis</td>
                        </tr>
                        <tr>
                            <td>1,007</td>
                            <td>sagittis</td>
                            <td>ipsum</td>
                            <td>Praesent</td>
                            <td>mauris</td>
                        </tr>
                        <tr>
                            <td>1,008</td>
                            <td>Fusce</td>
                            <td>nec</td>
                            <td>tellus</td>
                            <td>sed</td>
                        </tr>
                        <tr>
                            <td>1,009</td>
                            <td>augue</td>
                            <td>semper</td>
                            <td>porta</td>
                            <td>Mauris</td>
                        </tr>
                        <tr>
                            <td>1,010</td>
                            <td>massa</td>
                            <td>Vestibulum</td>
                            <td>lacinia</td>
                            <td>arcu</td>
                        </tr>
                        <tr>
                            <td>1,011</td>
                            <td>eget</td>
                            <td>nulla</td>
                            <td>Class</td>
                            <td>aptent</td>
                        </tr>
                        <tr>
                            <td>1,012</td>
                            <td>taciti</td>
                            <td>sociosqu</td>
                            <td>ad</td>
                            <td>litora</td>
                        </tr>
                        <tr>
                            <td>1,013</td>
                            <td>torquent</td>
                            <td>per</td>
                            <td>conubia</td>
                            <td>nostra</td>
                        </tr>
                        <tr>
                            <td>1,014</td>
                            <td>per</td>
                            <td>inceptos</td>
                            <td>himenaeos</td>
                            <td>Curabitur</td>
                        </tr>
                        <tr>
                            <td>1,015</td>
                            <td>sodales</td>
                            <td>ligula</td>
                            <td>in</td>
                            <td>libero</td>
                        </tr>
                    </tbody>
                    <?php
//                    $con = mysqli_connect("localhost", "phpuser", "phpuserpw", "seggiecampers");
//                    if (!$con) {
//                        exit('Connect Error (' . mysqli_connect_errno() . ') '
//                                . mysqli_connect_error());
//                    }
//                    $result = mysqli_query($con, "SELECT id, itemName, itemPrice, consumerPrice, quantity FROM inventory ");
//                    while ($row = mysqli_fetch_assoc($result)) {
//                        echo "<tr><td>" . htmlentities($row["id"]) . "</td>";
//                        echo "<td>" . htmlentities($row["itemName"]) . "</td>";
//                        echo "<td>$" . number_format(htmlentities($row["itemPrice"]), 2) . "</td>";
//                        echo "<td>$" . number_format(htmlentities($row["consumerPrice"]), 2) . "</td>";
//                        echo "<td>" . htmlentities($row["quantity"]) . "</td></tr>\n";
//                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>

