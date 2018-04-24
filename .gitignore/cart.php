<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php 
    include('config.php');
    if (!isset($_SESSION['username'])) {
  	header('location: Login.php');
    }

    $userID = $_SESSION['userID'];
    $query = $DBcon->query("SELECT * FROM buyer WHERE UserID='$userID'");
    $userRow=$query->fetch_array();
  
    $query1 = $DBcon->query("SELECT CartID FROM cart WHERE BuyerID='$BuyerID'");
    $cartRow = $query1->fetch_array();
  
    if (isset($_GET['action']))
    {
        if($_GET['action'] == 'add'){  
            $ProductID = $_GET['id'];
            $StoreID = $_GET['store'];
            $CategoryID = $_GET['category'];
            $ProductName = $_GET['name'];
            header("location: cart.php");
            $check_item = $DBcon->query("SELECT * FROM product_cart WHERE CartID=$cartRow[CartID] AND ProductID=$ProductID");
            $cartProduct = $check_item->fetch_array();
            $count=$check_item->num_rows;
            if($count==1){
                $quantity = 1;
                $quantity += $cartProduct['Quantity'];
                $qq=$DBcon->query("UPDATE product_cart SET Quantity=$quantity WHERE CartID=$cartRow[CartID] AND ProductID=$productID");}
            else{
                $qq=$DBcon->query("INSERT INTO product_cart (Quantity, ProductID, CartID) VALUES(1, $productID, $cartRow[CartID]");
            } 
        }
        else if ($_GET['action'] == remove){
	    $productID = $_GET['id'];
            $cartID = $_GET['cart'];
            $storeID = $_GET['store'];
            header("location: cart.php");
            $qq=$db->query("DELETE FROM product_cart WHERE CartID=$cartID AND ProductID=$productID");
        }
    }
    if (isset($_POST['checkout'])) {
        $date= date("Y-m-d");
	$result = $DBcon->query("SELECT * FROM product_cart WHERE CartID=$cartRow[CartID]");
	$qq=$DBcon->query("INSERT INTO order (BuyerID, OrderDate)
            VALUES($userRow[BuyerID], '$date')");
	$ordrID = $DBcon->insert_id;
	if($result){
            while($obj = $result->fetch_object()) {
                $qq=$DBcon->query("INSERT INTO product_order (Quantity, OrderID, ProductID, StoreID)
				VALUES($obj->Quantity, $ordrID, $obj->ProductID, $obj->StoreID)");
            }
        }
	$qq=$DBcon->query("DELETE FROM product_cart WHERE CartID=$cartRow[CartID]");
  	header("location: order.php");
    }
?>


<html>
    <head>
        <meta charset="utf-8" />
        <title>My Cart</title>
        <link rel="stylesheet" href="styles.css" />
        <style type = "text/css">
            body {
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
            }
            label {
                font-weight:bold;
                width:100px;
                font-size:14px;
            }
            .box {
                border:#666666 solid 1px;
            }
        </style>
    </head>
    <body>
        <div style=" margin: 33px;">
            <div>
                <?php include 'menu.php';?>
            </div>
        </div>
        <form method="post" action="cart.php">
            <div style="margin: 10px 0px 10px 0px; width: 30%;padding: 0px 100px; ">
                <h3>Items in Cart:</h3>
                <button type="submit" class="btn" name="checkout">Check Out</button>
            </div>
	</form>
        <?php
            $result = $DBcon->query("SELECT * FROM product_cart WHERE CartID=2");
            if($result){
                while($obj = $result->fetch_object()) {
                    echo '<div style="padding: 0px 100px;">';
                    echo '<p style= "display: inline-block; ">' . 'ProductID:  '.$obj->ProductID.' , Quantity:   '.$obj->Quantity.'</p>';
                    echo '<a href="cart.php?action=remove&id='.$obj->ProductID.'&cart='.$obj->CartID.'&store='.$obj->StoreID.'"><input type="submit" value="Remove From Cart" style="clear:both; background: #0078A0; border: none; color: black; font-size: 1em; padding: 10px; margin:4px 10px;" /></a>';
                    echo '</div>';
                }
            }
        ?>
    </body>
</html>