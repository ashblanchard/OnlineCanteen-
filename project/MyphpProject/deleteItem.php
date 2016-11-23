<?php
    require_once("Includes/db.php");
    $itemID = $_POST['currentItemID'];
    
    SeggieDB::getInstance()->delete_item($itemID);
    header('Location: inventoryPage.php' );

?>

