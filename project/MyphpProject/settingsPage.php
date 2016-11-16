<!DOCTYPE html>
<!--
Settings page

-----TODO-----

Add CSS for the individual camper adding

add comfirmation for upload


-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tuck Shop Canteen</title>

        <!--Custom CSS-->
        <link href ="styles.css" type ="text/css" rel ="stylesheet"/>
        <link rel="shortcut icon" href="images/favicon.png">

        <!--CSS for Icons-->
        <link rel="stylesheet" href="fontAwesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="fontAwesome/css/font-awesome.css">

        <!--Scripts-->
        <script src ="scripts.js"></script>
    </head>
    <body>
        <div class = "container">
            <!--Navigation Bar------------------------------------------------------->
            <div class ="navigationBar">
                <span class="backButton">
                    <a href="index.php">
                        <i class="fa fa-reply-all  fa-2x" title="Back to Login">Log Out</i>
                    </a>
                </span>
                <span class="homeButton">
                    <a href ="home.php">
                        <i class="fa fa-home fa-2x" title="Home"style="margin-right: 16px;">Home</i>
                    </a>
                </span>
                <span class = "settingsButton">
                    <a href ="settingsPage.php">
                        <i class="fa fa-cogs fa-2x" title="Settings">Settings</i>
                        <i class="fa fa-caret-left fa-2x"></i>
                    </a>
                </span>
                <div class ="navBannerDiv">
                    <img alt = "" class = "navBanner" src = "images/campStore.png">
                    <h1 class = "navBannerText"><!--Page Text here, If needed--></h1>
                </div>
                <hr>
            </div>
            <!----------------------------------------------------------------------->

            <!--Uploading a list of the current campers-->
            <div id="camperListUpload">
                <form method = 'POST' enctype ='multipart/form-data'>
                    <h3>Upload Camper's File:</h3>
                    <i class="fa fa-cloud-upload fa-2x"></i>
                    <input type="file" name="file"/>
                    <input type ='submit' name='submitCamper' value ='Upload'/>
                </form>
            </div>
            
            <!-- Uploading a list of the staff members-->
            <div id="staffListUpload">
                <form method = 'POST' enctype ='multipart/form-data'>
                    <h3>Upload Staff File:</h3>
                    <i class="fa fa-cloud-upload fa-2x"></i>
                    <input type="file" name="staffFile">
                    <input type ='submit' name='submitStaff' value ='Upload'/>
                </form> 
            </div>

            <!--Adding a SINGLE camper to the database-->
            <div id="addCamper">
                New Camper:
                <a href="createNewCamper.php">ADD</a> 
            </div>
            
            <!--Adding a SINGLE staff member-->
            <div class="addStaff">
                New Staff:
                <a href="createNewStaff.php">ADD</a> 
            </div>

            <!--Link to Inventory page----------------------------------------------->
            <div id="viewInventory">
                <a href="inventoryPage.php">
                    <span id="inventoryButton">
                        <i class="fa fa-database fa-5x"></i>                        
                    </span>
                    <br>
                    <h2>Inventory</h2>
                </a> 
            </div>
            <!----------------------------------------------------------------------->
            
        </div>
    </body>
</html>



<?php
$x = 1;
//Database info subject to change
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
