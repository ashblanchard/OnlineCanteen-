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
    }
    if ($_POST['itemName'] == "") {
        $itemNameisEmpty = true;
    }
    if ($_POST['itemPrice'] == "") {
        $itemPriceisEmpty = true;
    }
    if ($_POST['consumerPrice'] == "") {
        $consumerPriceisEmpty = true;
    }
    if ($_POST['quantity'] == "") {
        $quantityisEmpty = true;
    }
    if (!$itemNameisEmpty && !$itemPriceisEmpty && !$consumerPriceisEmpty && !$quantityisEmpty) {
        SeggieDB::getInstance()->update_item($_POST['currentItemID'], $_POST['itemName'], $_POST['itemPrice'], $_POST['consumerPrice'], $_POST['quantity']);
        header('Location: editItem.php');
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
        if ($_SERVER["REQUEST_METHOD"] == "POST")
            $itemInfo = array("id" => $_POST['currentItemID'], "itemName" =>
                $_POST['itemName'], "itemPrice" =>
                $_POST['ItemPrice'], "consumerPrice" => $_POST['consumerPrice'], "quantity" => $_POST['quantity']);
        else if (array_key_exists("currentItemID", $_GET))
            $itemInfo = mysqli_fetch_array(SeggieDB::getInstance()->get_itemInfo_by_item_id($_GET["currentItemID"]));
        ?>
        <form name="editWish" action="editItem.php" method="POST">
            <input type="hidden" name="currentItemID" value="<?php echo $itemInfo['id']; ?>" />
            Item: <input type ="text" name ="itemName" value="<?php echo $itemInfo['itemName']; ?>"/><br/>
            <?php
            if ($itemNameisEmpty)
                echo "Please enter item's name.";
            ?>
            <br></br>
            Item Price: <input type="text" name="itemPrice"  value="<?php echo $itemInfo['itemPrice']; ?>" /><br/>
            <?php
            if ($itemPriceisEmpty)
                echo "Please enter item's original price.";
            ?>
            <br></br>
            Consumer Price: <input type="text" name="consumerPrice" value="<?php echo $itemInfo['consumerPrice']; ?>"/><br/>
            <?php
            if ($consumerPriceisEmpty)
                echo "Please enter consumer price.";
            ?>
            <br></br>
            Quantity: <input type="text" name="quantity" value="<?php echo $itemInfo['quantity']; ?>"/><br/>
            <?php
            if ($quantityisEmpty)
                echo "Please enter quantity of item.";
            ?>
            <br></br>
            <input type="submit" name="saveItem" value="Save Changes"/>
            <input type="submit" name="back" value="Back to the List"/>

        </form>
    </body>
</html>