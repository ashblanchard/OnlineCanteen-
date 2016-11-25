<!DOCTYPE html>
<!--
Settings page

-----TODO-----

Add CSS for the individual camper/staff adding

add comfirmation for upload


-->
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

require_once("Includes/db.php");

/** other variables */
$nameIsEmpty = false;
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

    if (!$nameIsEmpty && !$cabinIsEmpty && !$store_depositIsEmpty) {
        SeggieDB::getInstance()->create_new_camper($_POST["name"], $_POST["camperCabin"], $_POST["store_deposit"]);
        header('Location: settingsPage.php');
        exit;
    }
}

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
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function () {
                $("#addCamper").draggable();
            });
            $(function () {
                $("#addStaff").draggable();
            });
        </script>
    </head>
    <body>
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <a href ="home.php">
                <i class="fa fa-home fa-2x" title="Home"> Home</i>
            </a>
            <a href ="inventoryPage.php">
                <i class="fa fa-database fa-2x" title="Inventory"> Inventory</i>
            </a>
            <a href ="settingsPage.php">

                <i class="fa fa-cogs fa-2x" title="Settings"> Settings</i>
            </a>
            <a href="index.php">
                <i class ="fa fa-sign-out   fa-2x" title="Log Out"> Log Out</i>
            </a>
        </div>
        <div class ="navBannerDiv">
            <img alt = " " class = "navBanner" src = "images/campStore.png">
        </div>
        <div class="backToTop">
            <a href="#top">
                <i class="fa fa-angle-double-up fa-2x"></i>
            </a>
        </div>
        <!----------------------------------------------------------------------->
        <div class = "container">


            <div id="camperSettings">
                <!--Uploading a list of the current campers-->
                <div id="camperListUpload">
                    <form method = 'POST' enctype ='multipart/form-data'>
                        <h3>Upload new camper list file (example.CSV):</h3>
                        <input type="file" name="file"/>
                        <i class="fa fa-cloud-upload fa-2x"></i>
                        <input type ='submit' name='submitCamper' value ='Upload'/>
                    </form>
                </div>
                <!--Adding a SINGLE camper to the database-->
                <h3>New camper:</h3>
                <button class="button" onclick="displayAddIndividual(1)">
                    <i class="fa fa-plus fa-1x" style="font-size: 30px;">Add</i>
                </button>
            </div>


            <div id="staffSettings">
                <!-- Uploading a list of the staff members-->
                <div id="staffListUpload">
                    <form method = 'POST' enctype ='multipart/form-data'>
                        <h3>Upload staff list file (example.CSV):</h3>
                        <input type="file" name="staffFile">
                        <i class="fa fa-cloud-upload fa-2x"></i>
                        <input type ='submit' name='submitStaff' value ='Upload'>
                    </form> 
                </div>
                <!--Adding a SINGLE staff member-->
                <h3>New Staff:</h3>
                <button class="button" onclick="displayAddIndividual(2)">
                    <i class="fa fa-plus fa-1x" style="font-size: 30px;">Add</i>
                </button>
            </div>


            <div id="addCamper">
                <i class="fa fa-times fa-2x" id="closeNewInventory" onclick="closeAddIndividual(1)"></i>
                <h1>Add Camper</h1>
                <form action="createNewCamper.php" method="POST">
                    Camper Name: <br><input type="text" name="name"><br>
                    <?php
                    if ($nameIsEmpty) {
                        echo ("Enter camper's name, please!");
                        echo ("<br/>");
                    }
                    ?> 
                    Cabin: <br><input type="text" name="camperCabin"><br>
                    <?php
                    if ($cabinIsEmpty) {
                        echo ("Enter camper's cabin, please!");
                        echo ("<br/>");
                    }
                    ?>
                    Store Deposit: <br><input type="text" name="store_deposit"><br>
                    <?php
                    if ($store_depositIsEmpty) {
                        echo ("Enter camper's store deposit, please!");
                        echo ("<br/>");
                    }
                    ?>

                    <input class="addItemSubmitButton" type="submit" value="Submit">
                </form>
            </div>

            <div id="addStaff" >
                <i class="fa fa-times fa-2x" id="closeNewInventory" onclick="closeAddIndividual(2)"></i>
                <h1>Add Staff</h1>
                <form action="createNewStaff.php" method="POST">
                    Name: <br><input type="text" name="name"/><br>
                    <?php
                    if ($nameIsEmpty) {
                        echo ("Enter staff's name, please!");
                        echo ("<br/>");
                    }
                    ?> 

                    <input class="button" type="submit" value="Submit"/>
                </form>
            </div>

        </div>
    </body>
</html>




