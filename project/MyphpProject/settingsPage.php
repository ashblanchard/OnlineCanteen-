
<!--
Settings page

-----TODO-----

Add CSS for the individual camper/staff adding

add comfirmation for upload

-->
<?php
session_start();
?>
<?php
if (!($_SESSION['LoggedIn'] == 1))
    header("Location: index.php")
    ?>
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
        <meta http-equiv=”Pragma” content=”no-cache”>
        <meta http-equiv=”Expires” content=”-1″>
        <meta http-equiv=”CACHE-CONTROL” content=”NO-CACHE”>
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
    </head>
    <body>
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <h2 class="hello"><?php echo "Hello " . $_SESSION['FirstName'] ?></h2>
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

            <div class="settingsBox">
                <!--Uploading a list of the current campers-->
                <div id="camperListUpload">
                    <form method = 'POST' enctype ='multipart/form-data'>
                        <h3>Upload Camper File (example.CSV):</h3>
                        <input type="file" name="file"/>
                        <i class="fa fa-cloud-upload fa-2x" style="color: #222"></i>
                        <input type ='submit' name='submitCamper' value ='Upload'/>
                    </form>
                </div>
                <!--Adding a SINGLE camper to the database-->
                <h3>New camper:</h3>
                <button class="button" onclick="displayAddIndividual(1)">
                    <i class="fa fa-plus fa-1x" style="font-size: 30px;">Add</i>
                </button>
            </div>

            <div class="settingsBox">
                <!-- Uploading a list of the staff members-->
                <div id="staffListUpload">
                    <form method = 'POST' enctype ='multipart/form-data'>
                        <h3>Upload Staff File (example.CSV):</h3>
                        <input type="file" name="staffFile">
                        <i class="fa fa-cloud-upload fa-2x" style="color: #222"></i>
                        <input type ='submit' name='submitStaff' value ='Upload'>
                    </form> 
                </div>
                <!--Adding a SINGLE staff member-->
                <h3>New Staff:</h3>
                <button class="button" onclick="displayAddIndividual(2)">
                    <i class="fa fa-plus fa-1x" style="font-size: 30px;">Add</i>
                </button>
            </div>

            <div style="display: block;">  
                <div class="settingsBox">
                    <h3>User Settings</h3>

                    <button type="button" id="newUserButton" class="button">New User</button><!--New user button-->

                    <button type="button" id="changePasswordButton" class="button" onclick="displayChangePassword()">
                        Change Password
                    </button>

                </div>
                <div class="settingsBox">
                    <h3>Show Databases</h3>

                    <button type="button"  id="showCampersButton" class="button">View all Campers</button>

                    <button type="button" id="showStaffButton" class="button">View all Staff</button>

                </div>
            </div>


            <!-- Hidden Divs===============================================================================-->
            <!--For changing the password for the logged in user-->
            <div id="changePassword">
                <i class="fa fa-times fa-2x" id="closeNewInventory" onclick="closeChangePassword()"></i>
                <h1>Change Password</h1>
                <form action="changePassword.php" method="POST">
                    Current Password:
                    <br><input type="password"name="oldPass1" onblur="checkSettings()"id="currentPass"><br>

                    New Password:
                    <br><input type="password" name="newPass1" onblur="checkSettings()" id="newPass"><br>

                    Confirm New Password: 
                    <br><input type="password" name="newPass2" onblur="checkSettings()" id="confirmPass" ><br>

                    <input class="addItemSubmitButton" type="submit" value="Submit">
                    <h3>*All Fields Required</h3>
                </form> 
            </div>
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
            <div id="addStaff" >
                <i class="fa fa-times fa-2x" id="closeNewInventory" onclick="closeAddIndividual(2)"></i>
                <h1>Add Staff</h1>
                <form action="createNewStaff.php" method="POST">
                    Name: 
                    <br><input type="text" name="name" onblur="checkSettings()" id="staffName"><br>

                    <input class="button" type="submit" value="Submit"/>
                </form>
            </div>
            <div id="addNewUser">
                <i class="fa fa-times fa-2x" id="closeNewUser" ></i>
                <h1>Register</h1>
                <p>Please enter your details below to register.</p>
                <form method="post" action="newUser.php" name="registerform" id="registerform">

                    First Name:<br>
                    <input type="text" name="firstName" id="username"><br>

                    Last Name:<br>
                    <input type="text" name="lastName" id="username"><br>

                    Username:<br>
                    <input type="text" name="username" id="username"><br>

                    Password:<br>
                    <input type="password" name="password" id="password"><br>

                    Re-Enter Password:<br>
                    <input type="password" name="passwordAgain" id="password"><br>

                    Email Address:<br>
                    <input type="text" name="email" id="email"><br>
                    
                    <input class="button" type="submit" name="register" id="register" value="Register">

                </form>
            </div>

            <!--Tables for camper/staff-->
            <div id="showAllStaff">
                <h1>Staff</h1>
                <div class ="resultsDiv">
                    <table class="resultsTable">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Amount Due</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <?php
                        require_once("Includes/db.php");
                        $result = SeggieDB::getInstance()->get_allStaffInfo();
                        while ($row = mysqli_fetch_array($result)) :
                            echo "<tr><td>" . htmlentities($row["type"]) . "</td>";
                            echo "<td> <a href=\"camperProfile.php/?camperid=" . $row["id"] . "\">" . htmlentities($row["name"]) . "</a></td>";
                            echo "<td>" . htmlentities($row["storeDeposit"]) . "</td>";
                            $currentID = $row['id'];
                            $type = htmlentities($row["type"]);
                            ?>
                            <td>
                                <form name="editPerson" action="editStaff.php" method="GET">
                                    <input type="hidden" name="currentID" value="<?php echo $currentID; ?>"/>
                                    <input type="submit" name="editStaff" value="Edit"/>
                                </form>  
                            </td>
                            <td>  
                                <form name="deletePerson" action="deleteStaff.php" method="POST">
                                    <input type="hidden" name="currentID" value="<?php echo $currentID; ?>"/>
                                    <input type="submit" name="deletePerson" value="Delete"/>
                                </form>
                            </td>
                            <?php
                            echo "</tr>\n";
                        endwhile;
                        ?>
                    </table>
                </div>
            </div>
            <div id="showAllCampers">
                <h1>Campers</h1>
                <div class ="resultsDiv">
                    <table class="resultsTable">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Cabin</th>
                                <th>Initial Balance</th>
                                <th>Store Deposit</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <?php
                        require_once("Includes/db.php");
                        $result = SeggieDB::getInstance()->get_allCamperInfo();
                        while ($row = mysqli_fetch_array($result)) :
                            echo "<tr><td>" . htmlentities($row["type"]) . "</td>";
                            echo "<td> <a href=\"camperProfile.php/?camperid=" . $row["id"] . "\">" . htmlentities($row["name"]) . "</a></td>";
                            echo "<td>" . htmlentities($row["cabin"]) . "</td>";
                            echo "<td>" . htmlentities($row["initialBalance"]) . "</td>";
                            echo "<td>" . htmlentities($row["storeDeposit"]) . "</td>";
                            $currentID = $row['id'];
                            $type = htmlentities($row["type"]);
                            ?>
                            <td>
                                <form name="editPerson" action="editCamper.php" method="GET">
                                    <input type="hidden" name="currentID" value="<?php echo $currentID; ?>"/>
                                    <input type="submit" name="editPerson" value="Edit"/>
                                </form>  
                            </td>
                            <td>  
                                <form name="deletePerson" action="deleteCamper.php" method="POST">
                                    <input type="hidden" name="currentID" value="<?php echo $currentID; ?>"/>
                                    <input type="submit" name="deletePerson" value="Delete"/>
                                </form>
                            </td>
                            <?php
                            echo "</tr>\n";
                        endwhile;
                        ?>
                    </table>
                </div>
            </div>


            <!--========================================================================================================-->

        </div>
        <script>
            $(function () {
                $("#addStaff").draggable();
                $("#addCamper").draggable();
                $("#changePassword").draggable();
            });

            /*
             
             $('').click(function () {
             $('').toggle();
             
             });
             
             */

            $('#showStaffButton').click(function () {
                $('#showAllStaff').toggle();
            });

            $('#showCampersButton').click(function () {
                $('#showAllCampers').toggle();
            });

            $('#newUserButton').click(function () {
                $('#addNewUser').show();
            });

            $('#closeNewUser').click(function () {
                $('#addNewUser').hide();
            });


        </script>

    </body>
</html>