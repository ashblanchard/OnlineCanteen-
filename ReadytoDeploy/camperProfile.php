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
    SeggieDB::getInstance()->addtocart($pid, 1); //changed 1 to 0
}
?>
<?php
if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'delete' && $_REQUEST['pid'] > 0) {
    SeggieDB::getInstance()->remove_product($_REQUEST['pid']);
} else if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'clear') {
    unset($_SESSION['cart']);
} else if (isset($_REQUEST['command2']) && $_REQUEST['command2'] == 'update') {
    $max = count($_SESSION['cart']);
    for ($i = 0; $i < $max; $i++) {
        $pid = $_SESSION['cart'][$i]['id'];
        $q = intval($_REQUEST['product' . $pid]);
        if ($q > 0 && $q <= 999) {
            $_SESSION['cart'][$i]['quantity'] = $q; //reaarrange!
        } else {
            
            
        }
    }
}
?>
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
                if (confirm('Your current balance is now updated')) {
                    document.form2.command2.value = 'placeorder';
                    document.form2.submit();
                }
            }


        </script>
    </head>
    <body>
        <!--Navigation Bar------------------------------------------------------->
        <div class ="navBarLeft">
            <h2 style="color:white;"><?php echo "Hello " . $_SESSION['FirstName'] ?></h2>
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
            $selectedCamper = SeggieDB::getInstance()->get_camperInformation_by_camper_id($_GET["camperid"]);
            $camperid = $_GET["camperid"];
       
            while ($row = mysqli_fetch_assoc($selectedCamper)) {
                $balance = $row["initialBalance"];
                echo "selectedbalance:" . $balance; 
                 $deposit = $row["storeDeposit"];
                echo "<br>storedeposit:" . $deposit;
                 $type =  $row["type"];
                echo "<br> type:" . $type;
                echo "<h1>" . htmlentities($row["name"]) . "<br/></h1>";
                echo "<h2>Type: " . htmlentities($row["type"]) . "";
               
                
                if (strcmp($type, "Staff") == 0) {
                    echo "<h3>Amount Due: $" . number_format(htmlentities($row["storeDeposit"]), 2) . "</h3>";
                } else {
                    echo "<h2>Cabin: " . htmlentities($row["cabin"]) . "</h2>";
                    echo "<h3>Initial Balance: $" . number_format(htmlentities($row["initialBalance"]), 2) . "</h3>";
                    echo "<h3>Current Balance: $" . number_format(htmlentities($row["storeDeposit"]), 2) . "</h3>";
                }
            }
            ?>

            <form name="form1" method="post">
                <input type="hidden" name="id1" />
                <input type="hidden" name="command1" />
            </form>
            <h3>Current Inventory:</h3>
            <table border = "black">
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
                        <a href="javascript:addtocart(<?php echo $row['id'] ?>)">Add to Cart</a>
                    </td>
                    <?php
                    echo "</tr>\n";

                endwhile;
                ?>
                <form name="form2" method="post">
                    <input type="hidden" name="pid" />
                    <input type="hidden" name="command2" />

                    <div style="margin:0px auto; width:600px;" >
                        <!--<div style="color:#F00"><?php //echo $msg;        ?></div>-->
                        <table border="0" cellpadding="5px" cellspacing="1px" style="font-family:Verdana, Geneva, sans-serif; font-size:11px; background-color:#E1E1E1" width="100%">
                            <?php
                            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                                echo '<tr bgcolor="#FFFFFF" style="font-weight:bold"><td>Id</td><td>Name</td><td>Price</td><td>Qty</td><td>Amount</td><td>Options</td></tr>';
                                $max = count($_SESSION['cart']);
                                for ($i = 0; $i < $max; $i++) { //changed the $1 = 0 
                                    $pid = $_SESSION['cart'][$i]['id'];
                                    $q = $_SESSION['cart'][$i]['quantity'];
                                    $pname = SeggieDB::getInstance()->get_product_name($pid);
                                    if ($q == 0) {
                                        continue;
                                    }
                                    ?>
                                    <tr bgcolor="#FFFFFF"><td><?php echo $pid; ?></td><td><?php echo $pname; ?></td><!--changed PID-->
                                        <td>$ <?php echo SeggieDB::getInstance()->get_CamperPrice($pid) ?></td>
                                        <td><input type="text" name="product<?php echo $pid ?>" value="<?php echo $q ?>" maxlength="3" size="2" /></td>                    
                                        <td>$ <?php echo SeggieDB::getInstance()->get_CamperPrice($pid) * $q ?></td>
                                        <td><a href="javascript:del(<?php echo $pid ?>)">Remove</a></td></tr>
                                    
                                            <?php
                                }
                               
                                
                                ?>

                                <tr><td><b>Today's Spendings: $<?php echo get_order_total(); ?></b></td>
                                    
                                    <td colspan="5" align="right"><input type="button" value="Clear Cart" onclick="clear_cart()">
                                        <input type="button" value="Update Cart" onclick="update_cart()">
                                        <input type="button" value="Place Order" onclick="place_order()"></td></tr>
                                <tr><td><b>Potential Balance: <?php echo get_seggie_type($type, $deposit, $balance); ?></b></td>
                                 
           
                                <?php
                            } else {
                                echo "<tr bgColor='#FFFFFF'><td>There are no items in your shopping cart!</td>";
                            }
                            ?>
                        </table>
                    </div>
                </form>
                </body>

                </html>
