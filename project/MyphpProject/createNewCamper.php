<?php

session_start();
?>
<?php
if (!($_SESSION['LoggedIn'] == 1))
    header("Location: index.php")
    ?>
<?php

require_once("Includes/db.php");

/** other variables */
$nameIsEmpty = false;
$cabinIsEmpty = false;
$store_depositIsEmpty = false;

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /** Check whether the user has filled in the camper's name in the text field "user" */
    if ($_POST["name"] == "") {
        $nameIsEmpty = true;
    }
    if ($_POST["camperCabin"] == "") {
        $cabinIsEmpty = true;
    }
    if ($_POST["store_deposit"] == "") {
        $store_depositIsEmpty = true;
    }

    if (!$nameIsEmpty && !$cabinIsEmpty && !$store_depositIsEmpty) {
        SeggieDB::getInstance()->create_new_camper($_POST["name"], $_POST["camperCabin"], $_POST["store_deposit"]);
        header('Location: settingsPage.php');
        exit;
    }
    else {
        header('Location: settingsPage.php');
    }
}
?>



