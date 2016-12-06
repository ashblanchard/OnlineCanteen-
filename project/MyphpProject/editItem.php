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
        
        
        
 