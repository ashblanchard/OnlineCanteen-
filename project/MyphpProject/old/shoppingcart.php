<?php
include("Includes/db.php");
include ("Includes/connect.php");

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

<html>
    <head>
        <!DOCTYPE html"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Shopping Cart</title>
            <script language="javascript">
                function del(pid) {
                    if (confirm('Do you really mean to delete this item')) {
                        document.form1.pid.value = pid;
                        document.form1.command.value = 'delete';
                        document.form1.submit();
                    }
                }
                function clear_cart() {
                    if (confirm('This will empty your shopping cart, continue?')) {
                        document.form1.command.value = 'clear';
                        document.form1.submit();
                    }
                }
                function update_cart() {
                    document.form1.command.value = 'update';
                    document.form1.submit();
                }
                function place_order() {
                    if (confirm('Your current balance is now updated')) {
                        document.form1.command.value = 'clear';
                        document.form1.submit();
                    }
                }


            </script>
    </head>
    <body>
        <form name="form1" method="post">
            <input type="hidden" name="pid" />
            <input type="hidden" name="command" />
            <div style="margin:0px auto; width:600px;" >
                <div style="padding-bottom:10px">
                    <h1 align="center">Shopping Cart</h1>
                    <input type="button" value="Continue Shopping" onclick="window.location = 'home.php'" />
                </div>
                <!--<div style="color:#F00"><?php //echo $msg;   ?></div>-->
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
                        <tr><td><b>Order Total: $<?php echo SeggieDB::getInstance()->get_order_total() ?></b></td>
                            <td colspan="5" align="right"><input type="button" value="Clear Cart" onclick="clear_cart()">
                                    <input type="button" value="Update Cart" onclick="update_cart()">
                                        <input type="button" value="Place Order" onclick="place_order()"></td></tr>
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