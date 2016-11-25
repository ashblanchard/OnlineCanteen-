


<?php

require_once("Includes/db.php");
/** other variables */
$nameIsEmpty = false;

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /** Check whether the user has filled in the camper's name in the text field "user" */
    if ($_POST["staffName"] == "") {
        $nameIsEmpty = true;
    }

    if (!$nameIsEmpty) {
        SeggieDB::getInstance()->create_new_staff($POST["staffName"]);
        header('Location: settingsPage.php');
        exit;
    }
}
?>
       