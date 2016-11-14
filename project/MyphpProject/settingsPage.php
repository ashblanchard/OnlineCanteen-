<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Settings Page</title>
        <link href ="styles.css" type ="text/css" rel ="stylesheet"/>
        <script src ="scripts.js"></script>
    </head>
    <body>
        <div class = "container">
            <div  class="homePageLink">
                <a href ="home.php">
                    <img alt ="" src ="images/backBack.png" title="Back to Home">
                </a>
            </div>
            <center>
                <h1>Settings</h1>

                <br></br>
                <br></br>
                <br></br>
                <form method = 'POST' enctype ='multipart/form-data'>
                    <br>Upload Camper's File:
                    <input type="file" name="file"/>
                    <input type ='submit' name='submitCamper' value ='Upload'/>
                </form>
                <br></br>
                <form method = 'POST' enctype ='multipart/form-data'>
                    <br>Upload Staff File:
                    <input type="file" name="staffFile"/>
                    <input type ='submit' name='submitStaff' value ='Upload'/>
                </form> 
                <br></br>
                <br>New Camper:<a href="createNewCamper.php">ADD</a> 
                <br></br>
                <br>New Staff:<a href="createNewStaff.php">ADD</a> 
                </br>
                <br></br>
                <br>Inventory:<a href="inventoryPage.php">View</a> 
            </center>
    </body>
</html>

<?php
$x = 1;
$con = mysqli_connect("localhost:3308", "root", "root", "camp seggie");
if (isset($_POST["submitCamper"])) {
    if ($_FILES['file']['name']) {
        $filename = explode(".", $_FILES['file']['name']);
        if ($filename[1] == 'csv') {
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            while ($data = fgetcsv($handle)) {
                $item1 = mysqli_real_escape_string($con, $data[0]);
                $item2 = mysqli_real_escape_string($con, $data[1]);
                $item3 = mysqli_real_escape_string($con, $data[2]);
                $sql = "INSERT into camper(camper_id, name,cabin,balance) values('$x','$item1','$item2','$item3')";
                mysqli_query($con, $sql);
                $x++;
            }
            fclose($handle);
        }
        mysqli_close($con);
        header('Location: settingsPage.php');
    }
}
?>
