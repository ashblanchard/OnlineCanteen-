<?php
include("Includes/connect.php");
if (!($_SESSION['LoggedIn'] == 1))
    header("Location: index.php")
    ?>
<?php
require_once("Includes/db.php");

if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'add' && $_REQUEST['id'] > 0) {
    $pid = $_REQUEST['id'];
    SeggieDB::getInstance()->addtocart($pid, 1); //changed 1 to 0
    exit();
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
        <script language="javascript">
            function addtocart(pid) {
                document.form1.id.value = pid;
                document.form1.command.value = 'add';
                document.form1.submit();
            }
            function del(pid1) {
                if (confirm('Do you really mean to delete this item')) {
                    document.form2.pid1.value = pid;
                    document.form2.command1.value = 'delete';
                    document.form2.submit();
                }
            }
            function clear_cart() {
                if (confirm('This will empty your shopping cart, continue?')) {
                    document.form2.command1.value = 'clear';
                    document.form2.submit();
                }
            }
            function update_cart() {
                document.form2.command1.value = 'update';
                document.form2.submit();
            }
            function place_order() {
                if (confirm('Your current balance is now updated')) {
                    document.form2.command1.value = 'clear';
                    document.form2.submit();
                }
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
            <?php
            require_once("Includes/db.php");
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
            }
            ?>
            <div style="display:none;">
                <form name="form1">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="command" />
                </form>
            </div>

            <div id="camperProfile">
                <!--Inventory===============================================================================================-->
                <div id="camperProfileInventory">
                    <h1><i class="fa fa-archive fa-1x" aria-hidden="true"></i>Inventory</h1>
                    <!--                <h3>Current Inventory:</h3>-->
                    <table id="camperProfileInventoryTable" class="resultsTable">
                        <tr>
                            <th> Item </th>
                            <th> Price </th>
                            <th> Add to Cart </th>
                        </tr>
                        <?php
                        require_once("Includes/db.php");
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
                        <?php
                        if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'delete' && $_REQUEST['pid'] > 0) {
                            SeggieDB::getInstance()->remove_product($_REQUEST['pid']);
                        } else if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'clear') {
                            unset($_SESSION['cart']);
                        } else if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'update') {
                            $max = count($_SESSION['cart']);
                            for ($i = 0; $i < $max; $i++) {
                                $pid = $_SESSION['cart'][$i]['id'];
                                $q = intval($_REQUEST['product' . $pid]);
                                if ($q > 0 && $q <= 999) {
                                    $_SESSION['cart'][$i]['quantity'] = $q; //reaarrange!
                                } else {
                                    //$msg = 'Some proudcts not updated!, quantity must be a number between 1 and 999';
                                }
                            }
                        }
                        ?>
                    </table>
                </div>
                <!--========================================================================================================-->

                <!--Shopping Cart==========================================================================================-->
                <div id="camperProfileCart">
                    <h1><i class="fa fa-shopping-cart fa-1x" aria-hidden="true"></i>Cart</h1>
                    <form name="form2" method="post">
                        <input type="hidden" name="pid1" />
                        <input type="hidden" name="command1" />
                        <table id="camperProfileCartTable" class="resultsTable">
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Options</th>
                            </tr>
                            <?php
                            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                                $max = count($_SESSION['cart']);
                                for ($i = 0; $i < $max; $i++) { //changed the $1 = 0 
                                    $pid = $_SESSION['cart'][$i]['id'];
                                    $q = $_SESSION['cart'][$i]['quantity'];
                                    $pname = SeggieDB::getInstance()->get_product_name($pid);
                                    if ($q == 0) {
                                        continue;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $pname; ?>
                                        </td><!--changed PID-->
                                        <td>
                                            $ <?php echo SeggieDB::getInstance()->get_CamperPrice($pid) ?>
                                        </td>
                                        <td>
                                            <input type="text" name="product<?php echo $pid ?>" value="<?php echo $q ?>">
                                        </td>                    

                                        <td>
                                            <a href="javascript:del(<?php echo $pid ?>)">Remove</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="4" style="font-weight: 700;">
                                        Order Total: $<?php echo SeggieDB::getInstance()->get_order_total() ?>
                                    </td>

                                </tr>
                                <?php
                            } else {
                                echo "<tr bgColor='#FFFFFF'><td>There are no items in your shopping cart!</td>";
                            }
                            ?>
                            <tr>
                                <td><input type="button" value="Clear Cart" onclick="clear_cart()" class="button"></td>
                                <td><input type="button" value="Update Cart" onclick="update_cart()" class="button"></td>
                                <td><input type="button" value="Place Order" onclick="place_order()"class="button"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <!--========================================================================================================-->

            </div>
        </div>
    </body>
</html>
