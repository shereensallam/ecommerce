<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
  include('config.php');
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: index.php');
  }
  if (isset($_POST['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: index.php");
  }
  $username = $_SESSION['username'];
  $query = $db->query("SELECT * FROM seller WHERE Username='$username'");
  $userRow=$query->fetch_array();
  
  $storeName = $db->query("SELECT * FROM store WHERE sellerID=$userRow[SellerID]");
  $storeRow=$storeName->fetch_array();
  
  $category = $db->query("SELECT * FROM category WHERE sellerID=$userRow[SellerID]");
  //$category=$category->fetch_array();
  
  if (isset($_POST['deletebtn'])) {
	$categoryName = mysqli_real_escape_string($db, $_POST['category']);
	if(empty($categoryName)){array_push($errors, "Category name is empty.");}
	else{
	$check_email = $db->query("SELECT categoryName FROM category WHERE CategoryName='$categoryName' AND SellerID=$userRow[SellerID]");
    $count=$check_email->num_rows;
    if($count==1){$result=$db->query("DELETE FROM category WHERE CategoryName='$categoryName' AND SellerID=$userRow[SellerID]");
  	header("location: category.php");}
	else{
	array_push($errors, "Category name does not exist.");}}
  }
  if (isset($_POST['categorybtn'])) {
	$categoryName = mysqli_real_escape_string($db, $_POST['category']);
	if(empty($categoryName)){array_push($errors, "Category name is empty.");}
	else{$check_email = $db->query("SELECT categoryName FROM category WHERE CategoryName='$categoryName' AND SellerID=$userRow[SellerID]");
    $count=$check_email->num_rows;
	if($count==1){array_push($errors, "Category name already exists.");}
	else {$result=$db->query("INSERT INTO category(CategoryName,storeID,sellerID) VALUES ('$categoryName',$storeRow[StoreID],$userRow[SellerID])");
  	header("location: category.php");}}
  }
   if (isset($_POST['productbtn'])) {
  	header("location: category.php");
  }
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Amaal's Souq</title>
    <link rel="stylesheet" href="css/foundation.css" />
  </head>
  <body background="back2.png">
        <div style="margin: 33px;">
            <div>
                <?php include('menu.php');?>
            </div>
            <form method="post" action="products.php">
                <div style="margin: 10px 0px 10px 0px; width: 30%;padding: 20px 40px; ">
                    <label style = "font-size:1.5em;"><b>Store Name: <?php echo $storeRow['StoreName'];?> </b></label>
                    <button type="submit" class="btn" name="productbtn">Add Categories</button>	
                </div>
                <div style="margin: 10px 0px 10px 0px; width: 30%;padding: 0px 40px; ">
                    <?php  if (count($errors) > 0) : ?>
                        <div class="error">
                            <?php foreach ($errors as $error) : ?>
                            <p><?php echo $error ?></p>
                            <?php endforeach ?>
                        </div>
                    <?php  endif ?> 
                    <label style = "font-size:1.2em;"><b>Edit Products:</b></label>
                    <input type="text" placeholder="Product Name" name="category">
                    <button type="submit" class="btn" name="categorybtn">Add Product</button>	
                    <button type="submit" class="btn" name="deletebtn">Delete Product</button>	
                    <label style = "font-size:1.2em;"><b>Available Products:</b></label>
                        <?php
                            $row = array();
                            while($row = mysqli_fetch_array($category)){
                                echo "<b>" . $row['CategoryName'] . "</b>,  ";
                            }
                        ?>
                </div>
            </form>
        </div>	
    </body>
</html>
