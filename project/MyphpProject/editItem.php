<?php
session_start();

if (!($_SESSION['LoggedIn'] == 1)) {
    header("Location: index.php");
}

$itemNameisEmpty = false;
$itemPriceisEmpty = false;
$consumerPriceisEmpty = false;
$quantityisEmpty = false;

require_once("Includes/db.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (array_key_exists("back", $_POST)) {
        /** The Back to the List key was pressed.
         * Code redirects the user to the editWishList.php */
        header('Location: inventoryPage.php');
    } else if ($_POST['item_name'] == "") {
        $itemNameisEmpty = true;
    } else if ($_POST['item_price'] == "") {
        $itemPriceisEmpty = true;
    } else if ($_POST['consumer_price'] == "") {
        $consumerPriceisEmpty = true;
    } else if ($_POST['item_quantity'] == "") {
        $quantityisEmpty = true;
    } else if (!$itemNameisEmpty && !$itemPriceisEmpty && !$consumerPriceisEmpty && !$quantityisEmpty) {
        SeggieDB::getInstance()->update_item($_POST['currentItemID'], $_POST['item_name'], $_POST['item_price'], $_POST['consumer_price'], $_POST['item_quantity']);
        header('Location: inventoryPage.php');
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $itemInfo = array("id" => $_POST["currentItemID"],
        "itemName" => $_POST["item_name"],
        "itemPrice" => $_POST["item_price"],
        "consumerPrice" => $_POST["consumer_price"],
        "quantity" => $_POST["item_quantity"]);
} else if (array_key_exists("currentItemID", $_GET)) {
    $itemInfo = mysqli_fetch_array(SeggieDB::getInstance()->get_itemInfo_by_item_id($_GET["currentItemID"]));
} else {
    $itemInfo = array("id" => "", "itemName" => "", "itemPrice" => "", "consumerPrice" => "", "quantity" => "");
}
?>
<!DOCTYPE html><!--NEW-->
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
    </head>
    <body>
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <h2 class="hello"><?php echo "Hello " . $_SESSION['FirstName'] ?></h2><!--NEW-->
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
            <div class="resultsDiv">
                <h2>Current Inventory:</h2><br>
                <button type="button" class="button" onclick="displayNewInventory()">
                    <i class="fa fa-plus fa-1x" style="font-size: 28px;">Add Item</i>
                </button>
                <table class ="resultsTable">
                    <thead>
                        <tr> <th>ID</th> <th>Item</th> <th>Staff Price</th> <th>Camper Price</th> <th>Quantity</th> <th>Edit</th> <th>Remove</th> </tr>
                    </thead>
                </table>
            </div>
            <div class="editItemWindow">
                <h1>Edit Item</h1>

                <form name="editWish" action="editItem.php" method="POST">
                    <input type="hidden" name="currentItemID" value="<?php echo $itemInfo['id']; ?>" >

                    Item:
                    <input type ="text" name ="item_name" value="<?php echo $itemInfo['itemName']; ?>">
                    <?php
                    if ($itemNameisEmpty) {
                        echo '<div class="error">Please enter the name of the item.</div>';
                    }
                    ?>

                    Item Price:
                    <input type="text" name="item_price"  value="<?php echo $itemInfo['itemPrice']; ?>">
                    <?php
                    if ($itemPriceisEmpty) {
                        echo '<div class="error">Please enter original price of item.</div>';
                    }
                    ?>

                    Consumer Price:
                    <input type="text" name="consumer_price" value="<?php echo $itemInfo['consumerPrice']; ?>">
                    <?php
                    if ($consumerPriceisEmpty) {
                        echo '<div class="error">Please enter consumer price of item.</div>';
                    }
                    ?>

                    Quantity:
                    <input type="text" name="item_quantity" value="<?php echo $itemInfo['quantity']; ?>">
                    <?php
                    if ($quantityisEmpty) {
                        echo '<div class="error">Please enter quantity of item in stock.</div>';
                    }
                    ?>

                    <input type="submit" class="button" name="saveItem" value="Save Changes" style="margin-top: 10px;">
                    <input type="submit" class="button" name="back" value="Back" style="margin-top: 10px;">
                </form>
            </div>
        </div>
    </body>
</html>