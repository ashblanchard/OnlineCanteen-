<?php
    require_once("Includes/db.php");
    $currentID = $_POST['currentID'];
    
    SeggieDB::getInstance()->delete_camper($currentID);
    header('Location: showStaff.php' );
?>

