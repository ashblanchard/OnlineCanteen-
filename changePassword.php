<?php
$newPasswordDifferent = false;
$invalidPassword = false;
$errorMessage = "";

include "Includes/connect.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ((strcmp($_POST['newPass1'],$_POST['newPass2'])) != 0) {
        $newPasswordDifferent = true;
        $errorMessage = "The passwords you entered are different.";
    }if (strlen($_POST['newPass1']) < 6) {
        $invalidPassword = true;
        $errorMessage = "Your password has to be at least 6 characters.";
    }if (!$newPasswordDifferent && !$invalidPassword) {
        $password = md5($_POST['newPass1']);
        mysql_query("UPDATE users SET Password = '" . $password . "' WHERE Username = '" . $_SESSION['Username'] . "'");
        
        header('Location: settingsPage.php');
        exit;
    } else {
        echo "ERROR: $errorMessage" ;
    }
}
?>

