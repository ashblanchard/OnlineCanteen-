<?php
session_start();
?>
<!DOCTYPE html>
<?php
if (!($_SESSION['LoggedIn'] == 1))
    header("Location: index.php")
    ?>
<?php
require_once("Includes/db.php");
/** other variables */
$nameIsEmpty = false;

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /** Check whether the user has filled in the camper's name in the text field "user" */
    if ($_POST["name"] == "") {
        $nameIsEmpty = true;
    }

    if (!$nameIsEmpty) {
        SeggieDB::getInstance()->create_new_staff($_POST["name"]);
        header('Location: settingsPage.php');
        exit;
    } else {
        header('Location: settingsPage.php');
    }
}
?>


