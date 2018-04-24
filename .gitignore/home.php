<?php
session_start();
if (!isset($_SESSION['userSession'])) {
	header("Location: Login.php");
}
require_once 'config.php';
$userID = $_SESSION['userSession'];   //remove when done

$userID = 1;        //for testing
$buyerchecked="";
$checkbuyer= $DBcon->query ("SELECT * FROM buyer WHERE UserID = '$userID'");
$query = $DBcon->query("SELECT * FROM seller WHERE UserEmail='$userID'");

$buyerrow = $checkbuyer -> fetch_array();
$countbuyer = $checkbuyer -> num_rows;
if($countbuyer==1){
    $buyerchecked = "hidden: false";
}
else {
    $buyerchecked = "hidden: true";
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Home Page</title>
        <link rel="stylesheet" href="styles.css">
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
        <div style="margin: 33px;">
            <div>
                <?php include('menu.php');?>
            </div>
            
            <div id="products" <?php echo $buyerchecked ?> > 
                <h2 style=" font-family: cursive; color: #666666"> Products </h2>
                <div class="search-container">
                    <form method="Post" action="home.php">
                        <input type="text" placeholder="Search.." name="search">
                        <button type="submit" name="srch-btn">Search</button>
                    </form>
                </div>  
                <hr>
                <?php
                    if (!isset($_POST['srch-btn'])){
                        $result = $DBcon->query("SELECT P.ProductID, P.StoreID, P.CategoryID, P.ProductName, P.Price, S.StoreName FROM product_store P, store S WHERE S.StoreID = P.StoreID");
                        if($result){
                            while($obj = $result->fetch_object()) {
                                echo '<div>';
                                echo '<p style= "display: inline-block; ">' . 'Product:  '.$obj->ProductName.' , Store:  '.$obj->StoreName.'</p>';
                                echo '<a href="cart.php?action=add&id='.$obj->ProductID.'&store='.$obj->StoreID.'&category='.$obj->CategoryID.'&name='.$obj->ProductName.'"><input type="submit" value="Add To Cart" style="clear:both; background: #0078A0; border: none; color: #fff; font-size: 1em; padding: 10px; margin:4px 10px;" /></a>';
                                echo '</div>';
                            }
                        }
                        
                    }
                    elseif (isset($_POST['srch-btn'])){
                        $search = mysqli_real_escape_string($DBcon, $_POST['search']);
                        $result = $DBcon->query("SELECT P.ProductID, P.StoreID, P.ProductName, P.CategoryID, P.Price, P.Quantity, S.StoreName FROM product_store P, store S WHERE ProductName = '$search' AND S.StoreID = P.StoreID");
                        echo 'Result for '.$search;
                        if($result){
                            while($obj = $result->fetch_object()) {
                                echo '<div>';
                                echo '<p style= "display: inline-block; ">' . 'Product:  '.$obj->ProductName.' , Store:   '.$obj->StoreName.'</p>';
                                echo '<a href="cart.php?action=add&id='.$obj->ProductID.'&store='.$obj->StoreID.'&category='.$obj->CategoryID.'&name='.$obj->ProductName.'"><input type="submit" value="Add To Cart" style="clear:both; background: #0078A0; border: none; color: #ffffff; font-size: 1em; padding: 10px; margin:4px 10px;" /></a>';
                                echo '</div>';
                            }
                        }
                    }
                ?>
            </div> 
        </div>      
    </body>
</html>