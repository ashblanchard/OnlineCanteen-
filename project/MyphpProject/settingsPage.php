<!DOCTYPE html>
<!--
Settings page

-----TODO-----

Add CSS for the individual camper/staff adding

add comfirmation for upload


-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tuck Shop</title>

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
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <a href ="../home.php">
                <i class="fa fa-home fa-2x" title="Home"> Home</i>
            </a>
            <a href ="../inventoryPage.php">
                <i class="fa fa-database fa-2x" title="Inventory"> Inventory</i>
            </a>
            <a href ="../settingsPage.php">

                <i class="fa fa-cogs fa-2x" title="Settings"> Settings</i>
            </a>
            <a href="../index.php">
                <i class ="fa fa-sign-out   fa-2x" title="Log Out"> Log Out</i>
            </a>
        </div>
        <div class ="navBannerDiv">
            <img alt = " " class = "navBanner" src = "../images/campStore.png">
        </div>
        <div class="backToTop">
            <a href="#top">
                <i class="fa fa-angle-double-up fa-2x"></i>
            </a>
        </div>
        <!----------------------------------------------------------------------->
        <div class = "container">

            <!--Uploading a list of the current campers-->
            <div id="camperListUpload">
                <form method = 'POST' enctype ='multipart/form-data'>
                    <h3>Upload Camper's File:</h3>
                    <i class="fa fa-cloud-upload fa-2x"></i>
                    <input type="file" name="file"/>
                    <input type ='submit' name='submitCamper' value ='Upload'/>
                </form>
            </div>

            <!--Adding a SINGLE camper to the database-->
            <div id="addCamper1">
                <h3>New Camper:</h3>
                <a href="createNewCamper.php">ADD</a> 
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

            <!--Adding a SINGLE staff member-->
            <div class="addStaff1">
                <h3>New Staff:</h3>
                <a href="createNewStaff.php">ADD</a> 
            </div>

            <!--Link to Inventory page
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
require_once("Includes/db.php");
if (isset($_POST["submitCamper"])) {
    if ($_FILES['file']['name']) {
        $filename = explode(".", $_FILES['file']['name']);
        if ($filename[1] == 'csv') {
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            while ($data = fgetcsv($handle)) {
                SeggieDB::getInstance()->create_new_camper($data[0], $data[1], $data[2]);
            }
            fclose($handle);
        }
        header('Location: settingsPage.php');
    }
}
?>
<?php
require_once("Includes/db.php");
if (isset($_POST["submitStaff"])) {
    if ($_FILES['staffFile']['name']) {
        $filename = explode(".", $_FILES['staffFile']['name']);
        if ($filename[1] == 'csv') {
            $handle = fopen($_FILES['staffFile']['tmp_name'], "r");
            while ($data = fgetcsv($handle)) {
                $staffName = "" . $data[0] . " " . $data[1] . "";
                SeggieDB::getInstance()->create_new_staff($staffName);
            }
            fclose($handle);
        }
        header('Location: settingsPage.php');
    }
}
?>
