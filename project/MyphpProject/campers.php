<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <body><center>Search Results: <?php echo $_GET["camper"] . "<br/>"; ?>
        <br></br>
        <br></br>
        
        <?php
        $con = mysqli_connect("localhost", "phpuser", "phpuserpw");
        if (!$con) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
//set the default client character set 
        mysqli_set_charset($con, 'utf-8');
        mysqli_select_db($con, "seggiecampers");

        $camper = mysqli_real_escape_string($con, htmlentities($_GET["camper"]));

        $camperdb = mysqli_query($con, "SELECT id FROM campers WHERE name LIKE '%$camper%'");

        if (mysqli_num_rows($camperdb) < 1) {
            exit("The person " . htmlentities($_GET["camper"]) . " is not found. Please check the spelling and try again");
        }
        $row = mysqli_fetch_row($camperdb);
        mysqli_free_result($camperdb);
        ?>
        <form name=singleCamper action="camperProfile.php">
        <table border="black">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Cabin</th>
                <th>Store Deposit</th>
            </tr>
            <?php
            $result = mysqli_query($con, "SELECT id, name, cabin, storeDeposit FROM campers  WHERE name LIKE '%$camper%'");
            while ($row = mysqli_fetch_array($result)) { 
                
                echo "<tr><td>" . htmlentities($row["id"]) . "</td>";
                echo "<td> <a href='camperProfile.php?camperid='".$row["id"]."'>" . htmlentities($row["name"]) . "</a></td>";
                echo "<td>" . htmlentities($row["cabin"]) . "</td>";
                echo "<td>" . htmlentities($row["storeDeposit"]) . "</td></tr>\n";
            }
            mysqli_free_result($result);
            mysqli_close($con);
            ?>
        </table>
        </form>   
    </center>
    </body>
</html>
