<?php
session_start();

if (!($_SESSION['LoggedIn'] == 1)) {
    header("Location: index.php");
}

$typeIsEmpty = false;
$amountDueIsEmpty = false;

require_once("Includes/db.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (array_key_exists("back", $_POST)) {
        /** The Back to the List key was pressed.
         * Code redirects the user to the editWishList.php */
        header('Location: settingsPage.php');
        exit;
    } else if ($_POST['staffType'] == "") {
        $typeIsEmpty = true;
    } else if ($_POST['staffAmount'] == "") {
        $amountDueIsEmpty = true;
    } else if (!$typeIsEmpty && !$amountDueIsEmpty) {
        SeggieDB::getInstance()->update_staff($_POST['currentID'], $_POST['staffType'], $_POST['staffAmount']);
        header('Location: settingsPage.php');
        exit;
    }
}
?>
<!DOCTYPE html><!--NEW-->
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
            <h2 class="hello"><?php echo "Hello " . $_SESSION['FirstName'] ?></h2><!--NEW-->
            <form class="navSearch" action="campers.php">
                <input class="navSearchBar" type="text" placeholder="Search Campers..." name="camper">
                <input class="navButton" type="submit" value="Search" >
            </form>
            <a href ="home.php">
                <i class="fa fa-home fa-2x" title="Home"> Home</i>
            </a>
            <a href ="inventoryPage.php" class="currentLink">
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
            <?php
            require_once("Includes/db.php");
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $staffInfo = array("id" => $_POST["currentID"],
                    "type" => $_POST["staffType"],
                    "storeDeposit" => $_POST["staffAmount"]);
            } else if (array_key_exists("currentID", $_GET)) {
                $staffInfo = mysqli_fetch_array(SeggieDB::getInstance()->get_camperInformation_by_camper_id($_GET["currentID"]));
            } else {
                $staffInfo = array("id" => "", "type" => "", "storeDeposit" => "");
            }
            ?>
            <div class="editItemWindow">
                <h1> <?php echo $staffInfo['name'] ?> </h1>
                <form name="editStaff" action="editStaff.php" method="POST">

                    <input type="hidden" name="currentID" value="<?php echo $staffInfo['id']; ?>">
                    Type: (Camper or Staff)
                    <input type="text" name="staffType" value="<?php echo $staffInfo['type']; ?>">
                    <?php
                    if ($typeIsEmpty) {
                        echo '<div class="error">Please enter type.</div>';
                    }
                    ?>
                    Edit Amount Due:
                    <input type="text" name="staffAmount" value="<?php echo $staffInfo['storeDeposit']; ?>"/>
                    <?php
                    if ($amountDueIsEmpty) {
                        echo '<div class="error">Please enter edited amount due.</div>';
                    }
                    ?>
                    <input type="submit" name="saveItem" value="Save Changes" class="button" style="margin-top: 10px;">
                    <input type="submit" name="back" value="Back to the List" class="button" style="margin-top: 10px;">

                </form>
            </div>
        </div>
    </body>
</html>