<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Settings</title>
    </head>
    <body>
    <center>
        <h1>Settings</h1>
    </center>
        <br></br>
        <br></br>
        <br></br>
        <form method = 'POST' enctype ='multipart/form-data'>
            <br>Upload File:
            <input type="file" name="file"/>
            <input type ='submit' name='submit' value ='Upload'/>
        </form> 
        <br></br>
        <br>New Camper:<a href="createNewCamper.php">ADD CAMPER</a> 
        </br>
        <br>Inventory:<a href="inventoryPage.php">View</a> 
    </body>
</html>

<?php
$con = mysqli_connect("localhost", "phpuser", "phpuserpw", "seggiecampers");
if (isset($_POST["submit"])) {
    if ($_FILES['file']['name']) {
        $filename = explode(".", $_FILES['file']['name']);
        if ($filename[1] == 'csv') {
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            while ($data = fgetcsv($handle)) {
                $item1 = mysqli_real_escape_string($con, $data[0]);
                $item2 = mysqli_real_escape_string($con, $data[1]);
                $item3 = mysqli_real_escape_string($con, $data[2]);
                $sql = "INSERT into campers(name,cabin,storeDeposit) values('$item1','$item2','$item3')";
                mysqli_query($con, $sql);
            }
            fclose($handle);
        }
    mysqli_close($con);
    header('Location: upload_successful.html');
    }
}
?>