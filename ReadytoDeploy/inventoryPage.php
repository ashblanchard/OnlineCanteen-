<?php
session_start();
?>
<?php
if (!($_SESSION['LoggedIn'] == 1))
    header("Location: index.php")
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv=”Pragma” content=”no-cache”>
        <meta http-equiv=”Expires” content=”-1″>
        <meta http-equiv=”CACHE-CONTROL” content=”NO-CACHE”>
        <title>Tuck Shop</title>

        <!--Custom CSS-->
        <link href ="styles.css" type ="text/css" rel ="stylesheet"/>
        <link rel="shortcut icon" href="images/favicon.png">

        <!--CSS for Icons-->
        <link rel="stylesheet" href="fontAwesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="fontAwesome/css/font-awesome.css">

        <!--Scripts-->
        <script src ="scripts.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function () {
                $("#newInventory").draggable();
            });
        </script>
    </head>
    <body>
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <h2 style="color:white;"><?php echo "Hello " . $_SESSION['FirstName'] ?></h2>
            <form class="navSearch" action="campers.php">
                <input class="navSearchBar" type="text" placeholder="Search Campers..." name="camper">
                <input class="navButton" type="submit" value="Search" >
            </form>
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
        <div class = "container">

            <div id ="newInventory" class="ui-widget-content">
                <i class="fa fa-times fa-2x" id="closeNewInventory" onclick="closeNewInventory()"></i> 
                <?php
                require_once("Includes/db.php");
                /** other variables */
                $itemNameIsEmpty = false;
                $itemPriceIsEmpty = false;
                $consumerPriceIsEmpty = false;
                $quantityIsEmpty = false;

                /** Check that the page was requested from itself via the POST method. */
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    /** Check whether the user has filled in the camper's name in the text field "user" */
                    if ($_POST["itemName"] == "") {
                        $itemNameIsEmpty = true;
                    }
                    if ($_POST["itemPrice"] == "") {
                        $itemPriceIsEmpty = true;
                    }
                    if ($_POST["consumerPrice"] == "") {
                        $consumerPriceIsEmpty = true;
                    }
                    if ($_POST["quantity"] == "") {
                        $quantityIsEmpty = true;
                    }
                    if (!$itemNameIsEmpty && !$itemPriceIsEmpty && !$consumerPriceIsEmpty && !$quantityIsEmpty) {
                        SeggieDB::getInstance()->create_new_item($_POST["itemName"], $_POST["itemPrice"], $_POST["consumerPrice"], $_POST["quantity"]);
                        header('Location: inventoryPage.php');
                        exit;
                    }
                }
                ?>
                <h1>Add New Inventory:</h1>
                <form action="inventoryPage.php" method="POST">
                    Item Name: 
                    <br><input type="text" id="itemName" name="itemName" onblur="checkField()"><br>

                    Staff Price: 
                    <br><input type="text" name="itemPrice" id="itemPrice" onblur="checkField()"><br>

                    Camper Price: 
                    <br><input type="text" name="consumerPrice" id="consumerPrice" onblur="checkField()"><br>

                    Quantity: 
                    <br><input type="text" name="quantity" id="quantity" onblur="checkField()"><br>

                    <input type="submit" id="addItemSubmitButton" class ="button">
                    <h3>*All Fields Required</h3>
                </form>
            </div>

            <div class="resultsDiv">

                <h2>Current Inventory:</h2><br>

                <button type="button" class="button" onclick="displayNewInventory()">
                    <i class="fa fa-plus fa-1x" style="font-size: 28px;">Add Item</i>
                </button>
                <table class ="resultsTable">
                    <thead>
                        <tr> <th>ID</th> <th>Item</th> <th>Staff Price</th> <th>Camper Price</th> <th>Quantity</th> <th>Edit</th> <th>Remove</th> </tr>
                    </thead>
                    <?php
                    require_once("Includes/db.php");

                    $result = SeggieDB::getInstance()->get_allInventoryInfo();
                    while ($row = mysqli_fetch_assoc($result)) :
                        echo "<tr><td> " . htmlentities($row["id"]) . "</td>";
                        echo "<td>" . htmlentities($row["itemName"]) . "</td>";
                        echo "<td>$" . number_format(htmlentities($row["itemPrice"]), 2) . "</td>";
                        echo "<td>$" . number_format(htmlentities($row["consumerPrice"]), 2) . "</td>";
                        echo "<td>" . htmlentities($row["quantity"]) . "</td>";
                        $currentItemID = $row["id"];
                        ?>
                        <td>
                            <form name="editItem" action="editItem.php" method="">
                                <input type="hidden" name="currentItemID" value="<?php echo $currentItemID; ?>"/>
                                <input type="submit" name="editItem" value="Edit"/>
                            </form>
                        </td>
                        <td>  
                            <form name="deleteItem" action="deleteItem.php" method="POST">
                                <input type="hidden" name="currentItemID" value="<?php echo $currentItemID; ?>"/>
                                <input type="submit" name="deleteItem" value="Delete"/>
                            </form>
                        </td>
                        <?php
                        echo "</tr>\n";
                    endwhile;
                    exit;
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>

