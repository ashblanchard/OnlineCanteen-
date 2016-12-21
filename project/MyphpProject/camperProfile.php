<?php
//header('Cache-Control: no cache'); //no cache
//session_cache_limiter('private_no_expire'); // works
////session_cache_limiter('public'); // works too
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
}
if (isset($_REQUEST['commandBack']) && $_REQUEST['commandBack'] == 'back') {
    unset($_SESSION['cart']);
    header("Location:../campers.php?camper=" . $_GET["camperSearch"]);
}
?>
<?php
if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'delete' && $_REQUEST['pid'] > 0) {
    SeggieDB::getInstance()->remove_product($_REQUEST['pid']);
} else if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'clear') {
    unset($_SESSION['cart']);
} else if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'checkout' /* && $_REQUEST['newBalance'] > 0 && $_REQUEST['id'] > 0 */) {
    $max = count($_SESSION['cart']);
    for ($i = 0; $i < $max; $i++) {
        $pid = $_SESSION['cart'][$i]['id'];
        $q = intval($_REQUEST['product' . $pid]);
        if ($q > 0 && $q <= 999) {
            $_SESSION['cart'][$i]['quantity'] = $q;
            SeggieDB::getInstance()->update_quantity($pid, $q); //reaarrange!
        }
    }
    SeggieDB::getInstance()->update_balance($_REQUEST['id'], $_REQUEST['newBalance']);
    unset($_SESSION['cart']);
    header("Refresh:0");
} else if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'update') {
    $max = count($_SESSION['cart']);
    for ($i = 0; $i < $max; $i++) {
        $pid = $_SESSION['cart'][$i]['id'];
        $q = intval($_REQUEST['product' . $pid]);
        if ($q > 0 && $q <= 999) {
            $_SESSION['cart'][$i]['quantity'] = $q;
        } else {
            $msg = 'Some proudcts not updated!, quantity must be a number between 1 and 999';
            echo $msg;
        }
    }
}
?>
<!DOCTYPE html>
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
        <script>
            function addtocart(pid1) {
                document.form1.id1.value = pid1;
                document.form1.command1.value = 'add';
                document.form1.submit();
            }
            function del(pid) {
                if (confirm('Do you really mean to remove this item from the cart?')) {
                    document.form2.pid.value = pid;
                    document.form2.command2.value = 'delete';
                    document.form2.submit();
                } else {

                }
            }
            function clear_cart() {
                if (confirm('This will empty the shopping cart, continue?')) {
                    document.form2.command2.value = 'clear';
                    document.form2.submit();
                }
            }
            function update_cart() {
                document.form2.command2.value = 'update';
                document.form2.submit();
            }
            function place_order(id, newBalance) {
                if (confirm('Please confirm checkout.')) {
                    document.form2.id.value = id;
                    document.form2.newBalance.value = newBalance;
                    document.form2.command2.value = 'checkout';
                    document.form2.submit();
                }
            }
            function previous_results() {
                document.backForm.commandBack.value = 'back';
                document.backForm.submit();

            }


        </script>
    </head>
    <body>
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <h2 class="hello"><?php echo "Hello " . $_SESSION['FirstName'] ?></h2>
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
            <form name = "backForm" method ='post'>
                <input type="hidden" name="commandBack" />
                <input type="button" value="Previous Results" onclick="previous_results()" class="button" id="camperProfileBackButton">
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
                    <div id="camperProfileInventoryTableDiv">
                        <table id="camperProfileInventoryTable" class="resultsTable">
                            <thead id="camperProfileInventoryHead">
                                <tr>
                                    <th> Item </th>
                                    <th> Price </th>
                                    <th> Add to Cart </th>
                                </tr>
                            </thead>
                            <!--body -->
                            <tbody id="camperProfileInventoryBody" colspan="3">
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
                            </tbody>    
                    </div> 
                    </table>
                </div>
            </div>
            <!--========================================================================================================-->

            <!--Shopping Cart==========================================================================================-->
            <div id="camperProfileCart">
                <h1><i class="fa fa-shopping-cart fa-1x" aria-hidden="true"></i> Cart</h1>
                <div id="camperProfileCartDiv">
                    <form name="form2" method="post">
                        <input type="hidden" name="pid" />
                        <input type="hidden" name="newBalance" />
                        <input type="hidden" name="id" />
                        <input type ="hidden" name="searchName" />
                        <input type="hidden" name="command2" />



                        <table id="camperProfileCartTable" class="resultsTable">
                            <tr>
                                <th>Name</th>
                                <th style="min-width: 70px;">Price</th>
                                <th>Qty</th>
                                <th style="min-width: 70px;">Amount</th>
                                <th style="width: 100%;">Options</th>
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
                                            <td>$ <?php echo number_format(SeggieDB::getInstance()->get_CamperPrice($pid), 2) ?></td>
                                            <td><input type="text" name="product<?php echo $pid ?>" value="<?php echo $q ?>" maxlength="3" size="2" /></td>                    
                                            <td>$ <?php echo number_format(SeggieDB::getInstance()->get_CamperPrice($pid) * $q, 2) ?></td>
                                            <td><a href="javascript:del(<?php echo $pid ?>)">Remove</a></td></tr>

                                    <?php } else if (strcmp($type, "Staff") == 0) { ?>
                                        <tr><td><?php echo $pname; ?></td><!--changed PID-->
                                            <td>$<?php echo number_format(SeggieDB::getInstance()->get_StaffPrice($pid), 2) ?></td>
                                            <td><input type="text" name="product<?php echo $pid ?>" value="<?php echo $q ?>" maxlength="3" size="2" /></td>                    
                                            <td style="min-width: 50px;">$<?php echo number_format(SeggieDB::getInstance()->get_StaffPrice($pid) * $q, 2) ?></td>
                                            <td><a href="javascript:del(<?php echo $pid ?>)">Remove</a></td></tr>
                                        <?php
                                    }
                                }
                                ?>

                                <tr><td style="font-weight: 700;">Today's Spendings:
                                        $<?php
                                        if (strcmp($type, "Staff") == 0) {
                                            $dailyAmount = number_format(SeggieDB::getInstance()->get_StaffOrder_total(), 2);
                                        } else
                                            $dailyAmount = number_format(SeggieDB::getInstance()->get_CamperOrder_total(), 2);
                                        ?><?php echo $dailyAmount ?></td></tr>

<!--                                <tr><td></td><tab></tab>
                                <td></td>
                                <td colspan="3"></td>
                                <td></td>
                                <td></td></tr>-->
                                <?php
                            } else
                                echo "<tr bgColor='#FFFFFF'><td>There are no items in your shopping cart!</td>";
                            ?>
                        </table>
                        <input type="button" value="Clear Cart" onclick="clear_cart()" class="button">
                        <input type="button" value="Update Cart" onclick="update_cart()" class="button">
                        <input type="button" value="Checkout" onclick="place_order(<?php echo $personID ?>, <?php echo $dailyAmount ?>)" class="button">
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>

</body>

</html>
