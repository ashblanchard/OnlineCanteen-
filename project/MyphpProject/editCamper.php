<?php
$typeIsEmpty = false;
$cabinIsEmpty = false;
$balanceIsEmpty = false;
$storeDepositIsEmpty = false;

require_once("Includes/db.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (array_key_exists("back", $_POST)) {
        /** The Back to the List key was pressed.
         * Code redirects the user to the editWishList.php */
        header('Location: settingsPage.php');
        exit;
    } else if ($_POST['camperType'] == "") {
        $typeIsEmpty = true;
    } else if ($_POST['camperCabin'] == "") {
        $cabinIsEmpty = true;
    } else if ($_POST['camperBalance'] == "") {
        $balanceIsEmpty = true;
    } else if ($_POST['camperDeposit'] == "") {
        $storeDepositIsEmpty = true;
    } else if (!$typeIsEmpty && !$cabinIsEmpty && !$balanceIsEmpty && !$storeDepositIsEmpty) {
        SeggieDB::getInstance()->update_camper($_POST['currentID'], $_POST['camperType'], $_POST['camperCabin'], $_POST['camperBalance'], $_POST['camperDeposit']);
        header('Location: showCampers.php');
        exit;
    }
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Update Camper Information</title>
    </head>
    <body>
        <?php
        require_once("Includes/db.php");
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $camperInfo = array("id" => $_POST["currentID"],
                "type" => $_POST["camperType"],
                "cabin" => $_POST["camperCabin"],
                "initialBalance" => $_POST["camperBalance"],
                "storeDeposit" => $_POST["camperDeposit"]);
        } else if (array_key_exists("currentID", $_GET))
            $camperInfo = mysqli_fetch_array(SeggieDB::getInstance()->get_camperInformation_by_camper_id($_GET["currentID"]));
        else
            $camperInfo = array("id" => "", "type" => "", "cabin" => "", "balance" => "", "storeDeposit" => "");
        ?>
        <h1> <?php echo $camperInfo['name'] ?> </h1>
            <form name="editWish" action="editCamper.php" method="POST">
                <input type="hidden" name="currentID" value="<?php echo $camperInfo['id']; ?>" />
                <label>Type: (Camper or Staff)</label>
                <select name="camperType">
                    <option>Camper</option>
                    <option>Staff</option>
                </select>
                <?php
                if ($typeIsEmpty)
                    echo '<div class="error">Please enter type (Camper or Staff).</div>';
                ?>
                <br></br>
                <label>Cabin: </label>
                <input type="text" name="camperCabin"  value="<?php echo $camperInfo['cabin']; ?>" /><br/>
                <?php
                if ($cabinIsEmpty)
                    echo '<div class="error">Please enter camper cabin.</div>';
                ?>
                <br></br>
                <label>Update Initial Deposit:</label> 
                <input type="text" name="camperBalance" value="<?php echo $camperInfo['initialBalance']; ?>"/><br/>
                <?php
                if ($balanceIsEmpty)
                    echo '<div class="error">Please enter balance you wish to add.</div>';
                ?>
                <br></br>
                <label>Update Store Deposit: </label>
                <input type="text" name="camperDeposit" value="<?php echo $camperInfo['storeDeposit']; ?>"/><br/>
                <?php
                if ($storeDepositIsEmpty)
                    echo '<div class="error">Please enter edited store deposit amount.</div>';
                ?>
                <br></br>
                <br></br>
                <input type="submit" name="saveItem" value="Save Changes"/>
                <input type="submit" name="back" value="Back to the List"/>

            </form>
    </body>
</html>
