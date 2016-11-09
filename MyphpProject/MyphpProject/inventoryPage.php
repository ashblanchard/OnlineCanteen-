<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset=UTF-8">
    </head>
    <body>
        Current Inventory:<br>
        <br></br>
        <br></br>
    <center>
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
                echo "<td>" . htmlentities($row["itemPrice"]) . "</td>";
                echo "<td>" . htmlentities($row["consumerPrice"]) . "</td>";
                echo "<td>" . htmlentities($row["quantity"]) . "</td></tr>\n";
            }
            ?>
        </table>
    </center>
    </body>
</html>

