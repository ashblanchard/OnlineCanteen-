<?php
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
        exit;
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
        exit;
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Update Inventory Form</title>
    </head>
    <body>
<?php
require_once("Includes/db.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $itemInfo = array("id" => $_POST["currentItemID"],
        "itemName" => $_POST["item_name"],
        "itemPrice" => $_POST["item_price"],
        "consumerPrice" => $_POST["consumer_price"],
        "quantity" => $_POST["item_quantity"]);
} else if (array_key_exists("currentItemID", $_GET))
    $itemInfo = mysqli_fetch_array(SeggieDB::getInstance()->get_itemInfo_by_item_id($_GET["currentItemID"]));
else
    $itemInfo = array("id" => "", "itemName" => "", "itemPrice" => "", "consumerPrice" => "", "quantity" => "");
?>
        <form name="editWish" action="editItem.php" method="POST">
            <input type="hidden" name="currentItemID" value="<?php echo $itemInfo['id']; ?>" />
            <label>Item:</label>
            <input type ="text" name ="item_name" value="<?php echo $itemInfo['itemName']; ?>"/><br/>
<?php
if ($itemNameisEmpty)
    echo '<div class="error">Please enter the name of the item.</div>';
?>
            <br></br>
            <label>Item Price: </label>
            <input type="text" name="item_price"  value="<?php echo $itemInfo['itemPrice']; ?>" /><br/>
<?php
if ($itemPriceisEmpty)
    echo '<div class="error">Please enter original price of item.</div>';
?>
            <br></br>
            <label>Consumer Price:</label> 
            <input type="text" name="consumer_price" value="<?php echo $itemInfo['consumerPrice']; ?>"/><br/>
<?php
if ($consumerPriceisEmpty)
    echo '<div class="error">Please enter consumer price of item.</div>';
?>
            <br></br>
            <label>Quantity: </label>
            <input type="text" name="item_quantity" value="<?php echo $itemInfo['quantity']; ?>"/><br/>
<?php
if ($quantityisEmpty)
    echo '<div class="error">Please enter quantity of item in stock.</div>';
?>
            <br></br>
            <br></br>
            <input type="submit" name="saveItem" value="Save Changes"/>
            <input type="submit" name="back" value="Back to the List"/>

        </form>
    </body>
</html>