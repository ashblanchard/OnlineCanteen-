<?php
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
        header('Location: showStaff.php');
        exit;
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Update Staff Information</title>
    </head>
    <body>
        <?php
        require_once("Includes/db.php");
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $staffInfo = array("id" => $_POST["currentID"],
                "type" => $_POST["staffType"],
                "storeDeposit" => $_POST["staffAmount"]);
        } else if (array_key_exists("currentID", $_GET))
            $staffInfo = mysqli_fetch_array(SeggieDB::getInstance()->get_camperInformation_by_camper_id($_GET["currentID"]));
        else
            $staffInfo = array("id" => "", "type" => "", "storeDeposit" => "");
        ?>
        <h1> <?php echo $staffInfo['name'] ?> </h1>
        <form name="editStaff" action="editStaff.php" method="POST">
            <input type="hidden" name="currentID" value="<?php echo $staffInfo['id']; ?>" />
            <label>Type: (Camper or Staff)</label>
            <input type="text" name="staffType" value="<?php echo $staffInfo['type']; ?>"/><br/>
            <?php
            if ($typeIsEmpty)
                echo '<div class="error">Please enter type.</div>';
            ?>
            <br></br>
            <label>Edit Amount Due: </label>
            <input type="text" name="staffAmount" value="<?php echo $staffInfo['storeDeposit']; ?>"/><br/>
            <?php
            if ($amountDueIsEmpty)
                echo '<div class="error">Please enter edited amount due.</div>';
            ?>
            <br></br>
            <br></br>
            <input type="submit" name="saveItem" value="Save Changes"/>
            <input type="submit" name="back" value="Back to the List"/>

        </form>
    </body>
</html>