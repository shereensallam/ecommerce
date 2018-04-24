<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
if (isset($_POST['logout'])){
    session_destroy();
    unset($_SESSION['userSession']);
    header ("Location: Login.php");
    exit();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css">
        <title></title>
    </head>
    <body>
        <form action="" method="Post">
        <div>
            <ul>
              <li><a href="home.php">Home</a></li>
              <li><a href="myStore.php">My Store</a></li>
              <li><a href="myProfile.php">Profile</a></li>
              <li><a href="cart.php"> My Cart</a></li>
              <li float="right" style="margin-top: 8px"><button name="logout" style="border: none; color: #666666; background-color: antiquewhite;">Logout</button></li>
            </ul>
        </div>
 </form>   </body>
</html>
