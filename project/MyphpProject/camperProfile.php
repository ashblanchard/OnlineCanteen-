
<html>
    <body>
        
        <?php
        if(!isset($_GET['camperid'])){
            echo "No ID found!";
        }
        $con = mysqli_connect("localhost", "phpuser", "phpuserpw");
        if (!$con) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
//set the default client character set 
        mysqli_set_charset($con, 'utf-8');


        mysqli_select_db($con, "seggiecampers");
        $name = mysqli_query($con, "SELECT name FROM campers WHERE id='" . $_GET['camperid'] . "'");
        $cabin = mysqli_real_query($con, "SELECT cabin FROM campers WHERE id='" . $_GET['camperid'] . "'");
        echo(". htmlententies($name)");
        echo(". htmlententies($cabin)");
        mysqli_close($con);
        ?>
        Current Inventory:<br>
        <br></br>
        <table border="black">
            <tr>
                <th>ID</th>
                <th>Item</th>
                <th>Original Price</th>
                <th>Consumer Price</th>
                <th>Quantity</th>
                <th>Purchse</th>
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
                echo "<td>" . htmlentities($row["quantity"]) . "</td>";
            }
            ?>
    </body>
</html>
