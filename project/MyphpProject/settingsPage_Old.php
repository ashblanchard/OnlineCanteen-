
<!--
Settings page

-----TODO-----


-->
<!DOCTYPE html>
<?php
require_once("Includes/db.php");
if (isset($_POST["submitCamper"])) {
    $result = SeggieDB::getInstance()->select_campers();
    while ($row = mysqli_fetch_array($result)) {
        echo "<h1>" . htmlentities($row["id"]) . "</h1>";
        SeggieDB::getInstance()->delete_camper($row["id"]);
    }
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

$personType = "";

/** other variables */
$nameIsEmpty = false;
$cabinIsEmpty = false;
$store_depositIsEmpty = false;

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
      /** Check whether the user has filled in the camper's name in the text field "user"
      if ($_POST["name"] == "") {
      $nameIsEmpty = true;
      }
      if ($_POST["camperCabin"] == "") {
      $cabinIsEmpty = true;
      }
      if ($_POST["store_deposit"] == "") {
      $store_depositIsEmpty = true;
      }
     */
    if (!$nameIsEmpty && !$cabinIsEmpty && !$store_depositIsEmpty) {
        SeggieDB::getInstance()->create_new_camper($_POST["name"], $_POST["camperCabin"], $_POST["store_deposit"]);
        header('Location: settingsPage.php');
        exit;
    }
}
if (isset($_POST["submitStaff"])) {
    if ($_FILES['staffFile']['name']) {
        $result = SeggieDB::getInstance()->select_staff();
        while ($row = mysqli_fetch_array($result)) {
            echo "<h1>" . htmlentities($row["id"]) . "</h1>";
            SeggieDB::getInstance()->delete_staff($row["id"]);
        }
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
                $("#addStaff").draggable();
                $("#addCamper").draggable();
                $("#changePassword").draggable();
                $("#editPerson").draggable();
            });




        </script>
    </head>
    <body>
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <form class="navSearch" action="campers.php">
                <input class="navSearchBar" type="text" placeholder="Search Campers..." name="camper">
                <input class="navButton" type="submit" value="Search" >
            </form>
            <a href ="home.php">
                <i class="fa fa-home fa-2x" title="Home"> Home</i>
            </a>
            <a href ="inventoryPage.php">
                <i class="fa fa-database fa-2x" title="Inventory"> Inventory</i>
            </a>
            <a href ="settingsPage.php"class="currentLink">
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
                        <i class="fa fa-cloud-upload fa-2x" style="color: #222"></i>
                        <input type ='submit' name='submitCamper' value ='Upload'/>
                    </form>
                </div>
                <!--Adding a SINGLE camper to the database-->

                <button class="button" onclick="displayAddIndividual(1)">
                    <i class="fa fa-plus fa-1x" style="font-size: 30px;">New Camper</i>
                </button><br>

                <button class="button" id="toggleCamperTable" type="button">
                    <script>
                        $("#toggleCamperTable").click(function () {
                            $("#settingsCamperTable").toggle();
                        });
                    </script>
                    Show Camper Table
                </button>

            </div>

            <div id="staffSettings">
                <!-- Uploading a list of the staff members-->
                <div id="staffListUpload">
                    <form method = 'POST' enctype ='multipart/form-data'>
                        <h3>Upload staff list file (example.CSV):</h3>
                        <input type="file" name="staffFile">
                        <i class="fa fa-cloud-upload fa-2x" style="color: #222"></i>
                        <input type ='submit' name='submitStaff' value ='Upload'>
                    </form> 
                </div>
                <!--Adding a SINGLE staff member-->

                <button class="button" onclick="displayAddIndividual(2)">
                    <i class="fa fa-plus fa-1x" style="font-size: 30px;">New Staff</i>
                </button><br>
                <button class="button" id="toggleStaffTable" type="button">
                    <script>
                        $("#toggleStaffTable").click(function () {
                            $("#settingsStaffTable").toggle();
                        });
                    </script>
                    Show Staff Table
                </button>
            </div>

            <button id="changePasswordButton" class="button" onclick="displayChangePassword()">
                Change Password
            </button>
            <!-- CHANGE NEW PASSWORD FORM===============================================================================-->
            <!--            For changing the password for the logged in user-->
            <div id="changePassword">
                <i class="fa fa-times fa-2x" id="closeNewInventory" onclick="closeChangePassword()"></i>
                <h1>Change Password</h1>
                <form action="change password php file" method="POST">
                    Current Password:
                    <br><input type="password"name="currentPass" onblur="checkSettings()"id="currentPass"><br>

                    New Password:
                    <br><input type="password" name="newPass" onblur="checkSettings()" id="newPass"><br>

                    Confirm New Password: 
                    <br><input type="password" name="confirmPass" onblur="checkSettings()" id="confirmPass" ><br>

                    <input class="addItemSubmitButton" type="submit" value="Submit">
                    <h3>*All Fields Required</h3>
                </form> 
            </div>
            <!--========================================================================================================-->                
            <!--            Pop up div that allows the user to add a new camper-->
            <div id="addCamper">
                <i class="fa fa-times fa-2x" id="closeNewInventory" onclick="closeAddIndividual(1)"></i>
                <h1>Add Camper</h1>
                <form action="createNewCamper.php" method="POST">
                    Camper Name: 
                    <br><input type="text"name="name" onblur="checkSettings()"id="camperName"><br>

                    Cabin: 
                    <br><input type="text" name="camperCabin" onblur="checkSettings()" id="camperCabin"><br>

                    Store Deposit: 
                    <br><input type="text" name="store_deposit" onblur="checkSettings()" id="camperBalance" ><br>

                    <input class="addItemSubmitButton" type="submit" value="Submit">
                    <h3>*All Fields Required</h3>
                </form>
            </div>
            <!--            Pop up div that allows the user to add a staff member-->
            <div id="addStaff" >
                <i class="fa fa-times fa-2x" id="closeNewInventory" onclick="closeAddIndividual(2)"></i>
                <h1>Add Staff</h1>
                <form action="createNewStaff.php" method="POST">
                    Name: 
                    <br><input type="text" name="name" onblur="checkSettings()" id="staffName"><br>

                    <input class="button" type="submit" value="Submit"/>
                    <h3>*All Fields Required</h3>
                </form>
            </div>
            <!--==============================================================================================-->
            <div id="editPerson" class="popupForm">
                <i class="fa fa-times fa-2x" id="closeNewInventory" onclick="closeEditIndividual()"></i>

                <?php
                if ($personType === "Staff") {
                    require 'editStaff.php';
                } else if ($personType === "Camper") {
                    require'editCamper.php';
                }

                /* this makes me sad */
                ?>

            </div>

            <!--==============================================================================================-->



            <!--Table at the bottom of the page-->
            <div id ="settingsCamperTable" class ="resultsDiv">
                <table class="resultsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Cabin</th>
                            <th>Store Deposit</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <?php
                    $result = SeggieDB::getInstance()->get_allCamperInfo();
                    while ($row = mysqli_fetch_array($result)) :
                        echo "<tr><td>" . htmlentities($row["id"]) . "</td>";
                        echo "<td>" . htmlentities($row["type"]) . "</td>";
                        echo "<td> <a href=\"camperProfile.php/?camperid=" . $row["id"] . "\">" . htmlentities($row["name"]) . "</a></td>";
                        echo "<td>" . htmlentities($row["cabin"]) . "</td>";
                        echo "<td>" . htmlentities($row["storeDeposit"]) . "</td>";
                        $personType = $row["type"];
                        $personID = $row["id"];
                        ?>
                        <td>
                            <form name="camperEdit" method="POST">
                                <!--action="editItem.php" -->
                                <input type="hidden" name="currentItemID" id="personTypeValue" value="<?php echo $personType; ?>"/>
                                <input type="button" name="editItem" value="Edit" onclick="displayEditIndividual()"  >
                            </form>
                        </td>
                        <td>  
                            <form name="deleteItem" action="deletePerson.php" method="POST">
                                <input type="hidden" name="currentItemID" value="<?php echo $personID; ?>"/>
                                <input type="submit" name="deleteItem" value="Delete"/>
                            </form>
                        </td>
                        <?php
                        echo "</tr>\n";
                    endwhile;
                    exit;
                    ?>
                </table>
            </div>



            <div id="settingsStaffTable" class="resultsDiv">
                <table class="resultsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Cabin</th>
                            <th>Store Deposit</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <?php
                    $result = SeggieDB::getInstance()->get_allCamperInfo();
                    while ($row = mysqli_fetch_array($result)) :
                        echo "<tr><td>" . htmlentities($row["id"]) . "</td>";
                        echo "<td>" . htmlentities($row["type"]) . "</td>";
                        echo "<td> <a href=\"camperProfile.php/?camperid=" . $row["id"] . "\">" . htmlentities($row["name"]) . "</a></td>";
                        echo "<td>" . htmlentities($row["cabin"]) . "</td>";
                        echo "<td>" . htmlentities($row["storeDeposit"]) . "</td>";
                        $personType = $row["type"];
                        $personID = $row["id"];
                        ?>
                        <td>
                            <form name="editItem" method="POST">
                                <!--action="editItem.php" -->
                                <input type="hidden" name="currentItemID" id="personTypeValue" value="<?php echo $personType; ?>"/>
                                <input type="button" name="editItem" value="Edit" onclick="displayEditIndividual()"  >
                            </form>
                        </td>
                        <td>  
                            <form name="deleteItem" action="deletePerson.php" method="POST">
                                <input type="hidden" name="currentItemID" value="<?php echo $personID; ?>"/>
                                <input type="submit" name="deleteItem" value="Delete"/>
                            </form>
                        </td>
                        <?php
                        echo "</tr>\n";
                    endwhile;
                    exit;
                    ?>
                </table>
            </div>




        </div>
    </body>
</html>