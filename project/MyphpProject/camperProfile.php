
<html>
    <body>
        <?php
        $con = mysqli_connect("localhost", "phpuser", "phpuserpw");
        if (!$con) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
//set the default client character set 
        mysqli_set_charset($con, 'utf-8');


        mysqli_select_db($con, "seggiecampers");
        $selectedCamper = mysqli_query($con, "SELECT * FROM campers  WHERE id='" . $_GET['camperid'] . "'");
        while ($row = mysqli_fetch_assoc($selectedCamper)) {
            echo "<h1>" . htmlentities($row["name"]) . "<br/></h1></div>";
            echo "<h2>Cabin: " . htmlentities($row["cabin"]) . "<br/><br></br><br></br></h2>";
            $cabin = htmlentities($row["cabin"]);
            if (strcmp($cabin, "STAFF") == 0) {
                echo "<h3>Amount Due: $" . number_format(htmlentities($row["storeDeposit"]), 2) . "</h3>";
            } else {
                echo "<h3>Initial Balance: $" . number_format(htmlentities($row["initialBalance"]), 2) . "</h3>";
                echo "<h3>Current Balance: $" . number_format(htmlentities($row["storeDeposit"]), 2) . "</h3>";
            }
        }
        mysqli_close($con);
        ?>



        <h3>Current Inventory:</h3><br>
        <table border="black">
            <div align ='left'>
                <tr>
                    <th> ID </th>
                    <th> Item </th>
                    <th> Price </th>
                    <th> Quantity </th>
                    <th> Purchse </th>
                </tr>
<?php
$con = mysqli_connect("localhost", "phpuser", "phpuserpw", "seggiecampers");
if (!$con) {
    exit('Connect Error (' . mysqli_connect_errno() . ')  '
            . mysqli_connect_error());
}
$result = mysqli_query($con, "SELECT id, itemName, itemPrice, consumerPrice, quantity FROM inventory ");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>" . htmlentities($row["id"]) . "</td>";
    echo "<td>" . htmlentities($row["itemName"]) . "</td>";
    if (strcmp($cabin, "STAFF") == 0) {
        echo "<td>$" . number_format(htmlentities($row["itemPrice"]), 2) . "</td>";
    } else {
        echo "<td>$" . number_format(htmlentities($row["consumerPrice"]), 2) . "</td>";
    }
    echo "<td>" . htmlentities($row["quantity"]) . "</td>";
    echo "<td>  </td>";
}
?>
        </table>
    </body>
</html>
