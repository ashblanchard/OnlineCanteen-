<?php
/** database connection credentials */
$dbHost = "localhost"; //on MySql
$dbUsername = "phpuser";
$dbPassword = "phpuserpw";

/** other variables */
$itemNameIsEmpty = false;
$originalPriceIsEmpty = false;
$consumerPriceIsEmpty = false;
$quantityIsEmpty = false;

/** Check that the page was requested from itself via the POST method. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /** Check whether the user has filled in the camper's name in the text field "user" */
    if ($_POST["itemName"] == "") {
        $itemNameIsEmpty = true;
    }
    if ($_POST["originalPrice"] == "") {
        $originalPriceIsEmpty = true;
    }
    if ($_POST["consumerPrice"] == "") {
        $consumerPriceIsEmpty = true;
    }
    if ($_POST["quantity"] == "") {
        $quantityIsEmpty = true;
    }
    /** Create database connection */
    $con = mysqli_connect("localhost", "phpuser", "phpuserpw");
    if (!$con) {
        exit('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
    }
//set the default client character set 
    mysqli_set_charset($con, 'utf-8');

    $itemName = mysqli_real_escape_string($con, $_POST['itemName']);
    $originalPrice = mysqli_real_escape_string($con, $_POST['originalPrice']);
    $consumerPrice = mysqli_real_escape_string($con, $_POST['consumerPrice']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);

    mysqli_select_db($con, "seggiecampers");
    mysqli_query($con, "INSERT inventory (itemName, itemPrice, consumerPrice, quantity) VALUES ('" . $itemName . "', '" . $originalPrice . "', '" . $consumerPrice . "','" . $quantity . "')");
    mysqli_close($con);
    header('Location:inventoryPage.php');
    exit;
}
?>
<html>
    <meta charset=UTF-8">
</head>
<body>
    Add New Inventory:<br>
    <br></br>
    <br></br>
    <form action="inventoryPage.php" method="POST">
        Item Name: <input type="text" name="itemName"/><br/>
        <?php
        if ($itemNameIsEmpty) {
            echo ("Enter item's name, please!");
            echo ("<br/>");
        }
        ?> 
        <br></br>
        Original Price: <input type="text" name="originalPrice"/><br/>
        <?php
        if ($originalPriceIsEmpty) {
            echo ("Enter original price, please!");
            echo ("<br/>");
        }
        ?>
        <br></br>
        Consumer Price: <input type="text" name="consumerPrice" /><br/>
        <?php
        if ($consumerPriceIsEmpty) {
            echo ("Enter consumer price, please!");
            echo ("<br/>");
        }
        ?>
        <br></br>
        Quantity: <input type="text" name="quantity" /></br>
        <?php
        if ($quantityIsEmpty) {
            echo ("Enter quantity of item, please!");
            echo ("<br/>");
        }
        ?>
        <br></br>
        <input type="submit" value="Add Inventory"/>
    </form>
    <br></br>
    <br></br>
<center>
    Current Inventory:<br>
    <br></br>
    <table border="black">
        <tr>
            <th>ID</th>
            <th>Item</th>
            <th>Original Price</th>
            <th>Consumer Price</th>
            <th>Quantity</th>
        </tr>
        <?php
        $con = mysqli_connect("localhost", "phpuser", "phpuserpw", "seggiecampers");
        if (!$con) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        $result = mysqli_query($con, "SELECT id, itemName, itemPrice, consumerPrice, quantity FROM inventory ");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . htmlentities($row["id"]) . "</td>";
            echo "<td>" . htmlentities($row["itemName"]) . "</td>";
            echo "<td>$" . number_format( htmlentities($row["itemPrice"]), 2).  "</td>";
            echo "<td>$" . number_format( htmlentities($row["consumerPrice"]), 2).  "</td>";
            echo "<td>" . htmlentities($row["quantity"]) . "</td></tr>\n";
        }
        ?>
</center>
</body>
</html>

