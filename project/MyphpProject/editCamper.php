<?php
$cabinIsEmpty = false;
$balanceIsEmpty = false;
$balanceIsNumeric = false;

require_once("Includes/db.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (array_key_exists("back", $_POST)) {
        /** The Back to the List key was pressed.
         * Code redirects the user to the editWishList.php */
        header('Location: settingsPage.php');
        exit;
    } else if ($_POST['camperCabin'] == "") {
        $cabinIsEmpty = true;
    } else if ($_POST['camperBalance'] == "") {
        $balanceIsEmpty = true;
    }
    $initialEntered = $_POST['camperBalance'];
    $newInitial = trim($initialEntered, '$');
    if(is_numeric($newInitial)){
        $balanceIsNumeric = true;
    }
     if (!$cabinIsEmpty && !$balanceIsEmpty && $balanceIsNumeric) {
        SeggieDB::getInstance()->update_camper($_POST['currentID'], $_POST['camperCabin'], $newInitial, $newInitial);
        header('Location: settingsPage.php');
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
                "cabin" => $_POST["camperCabin"],
                "initialBalance" => $_POST["camperBalance"],
                "storeDeposit" => $_POST["camperBalance"]);
        } else if (array_key_exists("currentID", $_GET))
            $camperInfo = mysqli_fetch_array(SeggieDB::getInstance()->get_camperInformation_by_camper_id($_GET["currentID"]));
        else
            $camperInfo = array("id" => "", "type" => "", "cabin" => "", "balance" => "", "storeDeposit" => "");
        ?>
        <h1> <?php echo $camperInfo['name'] ?> </h1>
            <form name="editWish" action="editCamper.php" method="POST">
                <input type="hidden" name="currentID" value="<?php echo $camperInfo['id']; ?>" />
                <label>Cabin: </label>
                <input type="text" name="camperCabin"  value="<?php echo $camperInfo['cabin']; ?>" /><br/>
                <?php
                if ($cabinIsEmpty)
                    echo '<div class="error">Please enter camper cabin.</div>';
                ?>
                <br></br>
                <label>Add to Store Account:</label> 
                <input type="text" name="camperBalance" value="<?php echo "$".number_format($camperInfo['storeDeposit'],2); ?>"/><br/>
                <?php
                if ($balanceIsEmpty)
                    echo '<div class="error">Please enter balance you wish to add.</div>';
                ?>
                <br></br>
                <br></br>
                <br></br>
                <input type="submit" name="saveItem" value="Save Changes"/>
                <input type="submit" name="back" value="Back to the List"/>

            </form>
    </body>
</html>
