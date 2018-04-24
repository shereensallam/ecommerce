<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
  include('config.php');
  //if (!isset($_SESSION['username'])) {
  //	header('location: Login.php');
  //}

  //$userID = $_SESSION['username'];
  $userID=1;
  $query = $DBcon->query("SELECT * FROM buyer WHERE UserID='$userID'");
  $userRow=$query->fetch_array();
  $query = $DBcon->query("SELECT * FROM orderr WHERE BuyerID=$userRow[BuyerID]");
?>

<html>
    <head>
        <meta charset="utf-8" />
        <title>My Order</title>
        <link rel="stylesheet" href="styles.css" />
    </head>
    <body>
        <div style="margin: 33px;">
            <div>
                <?php include('menu.php');?>
            </div>
        <form method="post" action="checkout.php">
            <div style="margin: 10px 0px 10px 0px; width: 30%;padding: 0px 100px; ">
                <h3>Order History:</h3>
            </div>
	</form>
        <?php
	    $query = $DBcon->query("SELECT * FROM orderr WHERE BuyerID=$userRow[BuyerID]");
            $result = $DBcon->query("SELECT * FROM order_product WHERE OrderID=$orderRow[OrderID]");
            if($query){
                while($obj2 = $query->fetch_object()){
                    $result = $DBcon->query("SELECT * FROM order_product WHERE OrderID=$obj2->OrderID");
                    while($obj = $result->fetch_object()) {
                        echo '<div style="padding: 0px 100px;">';
                        echo '<p style= "display: inline-block; ">' . 'Quantity:  '.$obj->Quantity.' , OrderID:   '.$obj->OrderID.' , ProductID:   '.$obj->ProductID.' , StoreID:   '.$obj->StoreID.'</p>';
                        echo '</div>';
                }}
            }
        ?>
        </div>
    </body>
</html>
