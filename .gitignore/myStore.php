<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
  include('config.php');
  if (!isset($_SESSION['username'])) {
  	//header('location: index.php');
  }

  //$userID = $_SESSION['username'];
  $userID =1;
  $query = $DBcon->query("SELECT * FROM seller WHERE UserID='$userID'");
  $userRow=$query->fetch_array();
  
   if (isset($_POST['storebtn'])) {
	$storeName = mysqli_real_escape_string($DBcon, $_POST['store']);
	$result=$DBcon->query("INSERT INTO store(StoreName, SellerID) VALUES ('$storeName', $userRow[SellerID])");
  	header("location: store.php");
  }
  if (isset($_POST['deletebtn'])) {
	$result=$db->query("DELETE FROM store WHERE SellerID = $userRow[SellerID]");
  	header("location: store.php");
  }
  if (isset($_POST['categorybtn'])) {
  	header("location: category.php");
  }
  ?>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Amaal's Souq</title>

    <link rel="stylesheet" href="css/foundation.css" />
    </head>
        <div style="margin: 33px;">
            <div>
                <?php include('menu.php');?>
            </div>  <form method="post" action="store.php">
	<?php
            $check = $DBcon->query("SELECT * FROM store WHERE SellerID=$userRow[SellerID]");
            $count=$check->num_rows;
            if($count==0){
	?>
            <div style="margin: 10px 0px 10px 0px; width: 30%;padding: 40px 40px;">
                <label><b>Enter Store Name</b></label>
                <input type="text" placeholder="Store Name" name="store" required>
                <button type="submit" class="btn" name="storebtn">Add Store</button>		
            </div>
	<?php
            }else{
                $name = $DBcon->query("SELECT * FROM store WHERE sellerID=$userRow[SellerID]");
		$userRow=$name->fetch_array();
        ?>
                <div style="margin: 10px 0px 10px 0px; width: 30%;padding: 40px 40px; ">
                    <label style = "font-size:1.5em;"><b>Store Name: <?php echo $userRow['StoreName'];?> </b></label>
                    <button type="submit" class="btn" name="categorybtn">Add Categories</button>	
                    <button type="submit" class="btn" name="deletebtn">Delete Store</button>
                    <a href="product.php">Add Product</a>	                   
	  	 </div>
        <?php
            }
	?>
            </div>
	</form>
    </body>
</html>