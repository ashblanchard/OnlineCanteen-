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

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /** Check whether the user has filled in the camper's name in the text field "user" */
    if ($_POST["name"] == "") {
        $nameIsEmpty = true;
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

    if (!$nameIsEmpty ){ 
        mysqli_select_db($con, "seggiecampers");
        mysqli_query($con, "INSERT campers (name, cabin) VALUES ('" . $name . "', 'STAFF')");
        mysqli_close($con);
        exit;
    }    
}
?>

<html>
    <head>
        <meta charset=UTF-8">
    </head>
    <body>
        Add New Staff:<br>
        <form action="createNewStaff.php" method="POST">
            Name: <input type="text" name="name"/><br/>
            <?php
            if ($nameIsEmpty) {
                echo ("Enter staff's name, please!");
                echo ("<br/>");
            }
            ?> 
            <input type="submit" value="Add Staff"/>
        </form>
    </body>
</html>

