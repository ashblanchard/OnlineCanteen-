<?php
$newPasswordDifferent = false;
$invalidPassword = false;

include "base.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ((strcmp($_POST['newPass1'],$_POST['newPass2'])) != 0) {
        $newPasswordDifferent = true;
        echo "passwords different.";
    }if (strlen($_POST['newPass1']) < 6) {
        $invalidPassword = true;
        echo "less than 6";
    }if (!$newPasswordDifferent && !$invalidPassword) {
        mysql_query("UPDATE users SET Password = '" . $_POST['newPass1'] . "' WHERE Password = '" . $_POST['oldPass1'] . "'");
        header('Location: settingsPage.php');
        exit;
    }
     else {
         echo "no.";
     }
         
}
?>

