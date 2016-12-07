<html>
        <head>
        <meta charset="UTF-8">
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
        <script>
           $(function () {
                $("#addStaff").draggable();
                $("#addCamper").draggable();
                $("#changePassword").draggable();
            });
        </script>
    </head>
    <body>
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
                exit;
                ?>
            </table>
        </div>
    </body>
</html>



