<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
/** database connection credentials */
$dbHost = "localhost"; //on MySql
$dbUsername = "phpuser";
$dbPassword = "phpuserpw";

/** other variables */
$nameIsEmpty = false;
$last_nameIsEmpty = false;
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
    /** Create database connection */
    $con = mysqli_connect("localhost", "phpuser", "phpuserpw");
    if (!$con) {
        exit('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }
//set the default client character set 
    mysqli_set_charset($con, 'utf-8');
    
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $camperCabin = mysqli_real_escape_string($con, $_POST['camperCabin']);
    $store_deposit = mysqli_real_escape_string($con, $_POST['store_deposit']);

    if (!$nameisEmpty && !$cabinisEmpty && !$store_depositisEmpty){ 
        mysqli_select_db($con, "seggiecampers");
        mysqli_query($con, "INSERT campers (name, cabin, storeDeposit) VALUES ('" . $name . "', '" . $camperCabin . "', '" . $store_deposit. "')");
        mysqli_free_result($camperdb);
        mysqli_close($con);
        header('Location: succesful_camper_add.html');
        exit;
    }
}       
?>

<html>
    <head>
        <meta charset=UTF-8">
    </head>
    <body>
        Add New Camper:<br>
        <form action="createNewCamper.php" method="POST">
            Name: <input type="text" name="name"/><br/>
            <?php
            if ($nameIsEmpty) {
                echo ("Enter camper's name, please!");
                echo ("<br/>");
            }
            ?> 
            Cabin: <input type="text" name="camperCabin"/><br/>
            <?php
            if ($cabinIsEmpty) {
                echo ("Enter camper's cabin, please!");
                echo ("<br/>");
            }
            ?>
            Store Deposit: <input type="text" name="store_deposit" />
            <?php
            if ($store_depositIsEmpty) {
                echo ("Enter camper's store deposit, please!");
                echo ("<br/>");
            }
            ?>
            <input type="submit" value="Add Camper"/>
        </form>
    </body>
</html>


