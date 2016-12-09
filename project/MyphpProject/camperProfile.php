<?php
if (!isset($_SESSION['cart']))
    session_start();
?>
<?php
if (!($_SESSION['LoggedIn'] == 1))
    header("Location: index.php");
?>
<?php
include("Includes/db.php");

if (isset($_REQUEST['command1']) && $_REQUEST['command1'] == 'add' && $_REQUEST['id1'] > 0) {
    $pid = $_REQUEST['id1'];
    SeggieDB::getInstance()->addtocart($pid, 1);
    //changed 1 to 0
}
?>
<?php
if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'delete' && $_REQUEST['pid'] > 0) {
    SeggieDB::getInstance()->remove_product($_REQUEST['pid']);
} else if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'clear') {
    unset($_SESSION['cart']);
} else if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'checkout') {
     $max = count($_SESSION['cart']);
    for ($i = 0; $i < $max; $i++) {
        $pid = $_SESSION['cart'][$i]['id'];
        $q = intval($_REQUEST['product' . $pid]);
        if ($q > 0 && $q <= 999) {
            $_SESSION['cart'][$i]['quantity'] = $q;
            SeggieDB::getInstance()->update_quantity($pid, $q); //reaarrange!
        }
    }
    unset($_SESSION['cart']);
    header("Refresh:0");
} else if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'update') {
    $max = count($_SESSION['cart']);
    for ($i = 0; $i < $max; $i++) {
        $pid = $_SESSION['cart'][$i]['id'];
        $q = intval($_REQUEST['product' . $pid]);
        if ($q > 0 && $q <= 999) {
            $_SESSION['cart'][$i]['quantity'] = $q;
            SeggieDB::getInstance()->update_quantity($pid, $q); //reaarrange!
        } else {
            //$msg = 'Some proudcts not updated!, quantity must be a number between 1 and 999';
        }
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
        <link href ="../styles.css" type ="text/css" rel ="stylesheet"/>
        <link rel="shortcut icon" href="../images/favicon.png">

        <!--CSS for Icons-->
        <link rel="stylesheet" href="../fontAwesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="../fontAwesome/css/font-awesome.css">

        <!--Scripts-->
        <script src ="scripts.js"></script>
        <script language="javascript">
            function addtocart(pid1) {
                document.form1.id1.value = pid1;
                document.form1.command1.value = 'add';
                document.form1.submit();
            }
            function del(pid) {
                if (confirm('Do you really mean to delete this item')) {
                    document.form2.pid.value = pid;
                    document.form2.command2.value = 'delete';
                    document.form2.submit();
                }
            }
            function clear_cart() {
                if (confirm('This will empty your shopping cart, continue?')) {
                    document.form2.command2.value = 'clear';
                    document.form2.submit();
                }
            }
            function update_cart() {
                document.form2.command2.value = 'update';
                document.form2.submit();
            }
            function place_order() {
                if (confirm('Please confirm checkout.')) {
                document.form2.command2.value = 'checkout';
                document.form2.submit();
            }
            }


        </script>
    </head>
    <body>
        <!--Navigation Bar------------------------------------------------------->
                <div class ="navBarLeft">
                    <h2 class="hello"><?php echo "Hello " . $_SESSION['FirstName'] ?></h2><!--NEW-->
                    <form class="navSearch" action="../campers.php">
                        <input class="navSearchBar" type="text" placeholder="Search Campers..." name="camper">
                        <input class="navButton" type="submit" value="Search" >
                    </form>
                    <a href ="../home.php">
                        <i class="fa fa-home fa-2x" title="Home"> Home</i>
                    </a>
                    <a href ="../inventoryPage.php">
                        <i class="fa fa-database fa-2x" title="Inventory"> Inventory</i>
                    </a>
                    <a href ="../settingsPage.php">
        
                        <i class="fa fa-cogs fa-2x" title="Settings"> Settings</i>
                    </a>
                    <a href="../index.php">
                        <i class ="fa fa-sign-out   fa-2x" title="Log Out"> Log Out</i>
                    </a>
                </div>
                <div class ="navBannerDiv">
                    <img alt = " " class = "navBanner" src = "../images/campStore.png">
                </div>
                <div class="backToTop">
                    <a href="#top">
                        <i class="fa fa-angle-double-up fa-2x"></i>
                    </a>
                </div>
        <!----------------------------------------------------------------------->
        <div class = "container">
            <form method ='post'>
                <?php
                $selectedCamper = SeggieDB::getInstance()->get_camperInformation_by_camper_id($_GET["camperid"]);

                while ($row = mysqli_fetch_assoc($selectedCamper)) {
                    echo "<h1>" . htmlentities($row["name"]) . "<br/></h1>";
                    echo "<h2>Type: " . htmlentities($row["type"]) . "";
                    $type = htmlentities($row["type"]);
                    if (strcmp($type, "Staff") == 0) {
                        echo "<h3>Amount Due: $" . number_format(htmlentities($row["storeDeposit"]), 2) . "</h3>";
                    } else {
                        echo "<h2>Cabin: " . htmlentities($row["cabin"]) . "</h2>";
                        echo "<h3>Initial Balance: $" . number_format(htmlentities($row["initialBalance"]), 2) . "</h3>";
                        echo "<h3>Current Balance: $" . number_format(htmlentities($row["storeDeposit"]), 2) . "</h3>";
                    }
                    $initialBalance = htmlentities($row["initialBalance"]);
                    $storeDeposit = htmlentities($row["storeDeposit"]);
                    $personID = htmlentities($row["id"]);
                }
                ?>
            </form>
            <div style="display:none;">
                <form name="form1" method="post">
                    <input type="hidden" name="id1" />
                    <input type="hidden" name="command1" />
                </form>
            </div>
            <div id="camperProfile">
                <!--Inventory===============================================================================================-->
                <div id="camperProfileInventory">
                    <h1><i class="fa fa-archive fa-1x" aria-hidden="true"></i>  Inventory</h1>
                    <!--                <h3>Current Inventory:</h3>-->
                    <table id="camperProfileInventoryTable" class="resultsTable">
                        <tr>
                            <th> Item </th>
                            <th> Price </th>
                            <th> Add to Cart </th>
                        </tr>
                        <?php
                        $result = SeggieDB::getInstance()->get_allInventoryInfo();
                        while ($row = mysqli_fetch_assoc($result)) :
                            echo "<tr><td>" . htmlentities($row["itemName"]) . "</td>";
                            if (strcmp($type, "Staff") == 0) {
                                echo "<td>$" . number_format(htmlentities($row["itemPrice"]), 2) . "</td>";
                            } else {
                                echo "<td>$" . number_format(htmlentities($row["consumerPrice"]), 2) . "</td>";
                            }
                            $q = 1;
                            ?>
                            <td>  
                                <input type="button" value="Add to Cart" class="button" onclick="addtocart(<?php echo $row['id'] ?>)" />
                            </td>
                            <?php
                            echo "</tr>\n";
                        endwhile;
                        ?>
                    </table>
                </div>
                <!--========================================================================================================-->

                <!--Shopping Cart==========================================================================================-->
                <div id="camperProfileCart">
                    <h1><i class="fa fa-shopping-cart fa-1x" aria-hidden="true"></i>  Cart</h1>
                    <form name="form2" method="post">
                        <input type="hidden" name="pid" />

                        <input type="hidden" name="balance" />
                        <input type="hidden" name="daily" />
                        <input type="hidden" name="type" />
                        <input type="hidden" name="id" />
                        <input type="hidden" name="command2" />


                        <table id="camperProfileCartTable" class="resultsTable">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Options</th>
                            </tr>
                            <?php
                            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                                $max = count($_SESSION['cart']);
                                for ($i = 0; $i < $max; $i++) {  //changed the $1 = 0 
                                    $pid = $_SESSION['cart'][$i]['id'];
                                    $q = $_SESSION['cart'][$i]['quantity'];
                                    $pname = SeggieDB::getInstance()->get_product_name($pid);
                                    if ($q == 0) {
                                        continue;
                                    }
                                    ?>
                                    <?php if (!strcmp($type, "Staff") == 0) { ?>
                                        <tr><td><?php echo $pname; ?></td><!--changed PID-->
                                            <td>$ <?php echo SeggieDB::getInstance()->get_CamperPrice($pid) ?></td>
                                            <td><input type="text" name="product<?php echo $pid ?>" value="<?php echo $q ?>" maxlength="3" size="2" /></td>                    
                                            <td>$ <?php echo SeggieDB::getInstance()->get_CamperPrice($pid) * $q ?></td>
                                            <td><a href="javascript:del(<?php echo $pid ?>)">Remove</a></td></tr>

                                    <?php } else if (strcmp($type, "Staff") == 0) { ?>
                                        <tr><td><?php echo $pname; ?></td><!--changed PID-->
                                            <td>$ <?php echo SeggieDB::getInstance()->get_StaffPrice($pid) ?></td>
                                            <td><input type="text" name="product<?php echo $pid ?>" value="<?php echo $q ?>" maxlength="3" size="2" /></td>                    
                                            <td>$ <?php echo SeggieDB::getInstance()->get_StaffPrice($pid) * $q ?></td>
                                            <td><a href="javascript:del(<?php echo $pid ?>)">Remove</a></td></tr>
                                        <?php
                                    }
                                }
                                ?>

                                <tr><td colspan="4" style="font-weight: 700;">Today's Spendings:
                                        $<?php
                                        if (strcmp($type, "Staff") == 0) {
                                            $dailyAmount = SeggieDB::getInstance()->get_StaffOrder_total();
                                            echo $dailyAmount;
                                        } else
                                            $dailyAmount = SeggieDB::getInstance()->get_CamperOrder_total();
                                        echo $dailyAmount;
                                        ?></td></tr>
                                <tr><td><input type="button" value="Clear Cart" onclick="clear_cart()" class="button"></td>
                                    <td><input type="button" value="Update Cart" onclick="update_cart()" class="button"></td>
                                    <td><input type="button" value="Place Order" onclick="place_order()" class="button"></td></tr>
                                <tr><td><b>Potential Balance: <?php echo SeggieDB::getInstance()->get_seggie_type($personID, $type, $storeDeposit, $initialBalance) ?></b></td>
                            </table>
                            <?php
                        } else
                            echo "<tr bgColor='#FFFFFF'><td>There are no items in your shopping cart!</td>";
                        ?>

                    </form>
                </div>
            </div>
        </div>

    </body>

</html>
