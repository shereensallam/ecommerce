<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
session_start();
if (!isset($_SESSION['userSession'])) {
	header("Location: Login.php");
}
require_once 'config.php';
if(isset($_POST['btn-save'])) {
	
	$oldpass = strip_tags($_POST['oldpass']);
	$newpass = strip_tags($_POST['newpass']);
	$lastname = strip_tags($_POST['lastname']);
        $firstname = strip_tags($_POST['firstname']);
        $address = strip_tags('address');
	$phone = strip_tags($_POST['phone']);
        $CCNumber= strip_tags($_POST['CCNumber']);
        $CCname = strip_tags($_POST['CCname']);
        $CCpin = strip_tags($_POST['CCpin']);

	
	$oldpass = $DBcon->real_escape_string($oldpass);
	$newpass = $DBcon->real_escape_string($newpass);
	$lastname = $DBcon->real_escape_string($lastname);
        $firstname = $DBcon->real_escape_string($firstname);
        $address = $DBcon-> real_escape_string($address);
       	$phone = $DBcon->real_escape_string($phone);
        $CCNumber = $DBcon -> real_escape_string ($CCNumber);
        $CCname= $DBcon -> real_escape_string ($CCname);
        $CCpin =$DBcon -> real_escape_string ($CCpin);

	
	$checkaccount = $DBcon->query("SELECT UserID FROM user WHERE Email='$email'");
	$count=$checkaccount->num_rows;
	if($oldpass!="" && $newpass!=""){
            $hashedpassword = password_hash($oldpass, PASSWORD_DEFAULT);
            $newhashedpassword = password_hash($newpass, PASSWORD_DEFAULT);
            $checkpass = $DBcon->query("SELECT Password FROM user WHERE userID='$userID'");
            $count=$checkpass -> num_rows;
            if ($count==1){
                $query = ("UPDATE user(Password) VALUES ('$newhashedpassword') WHERE userID='$userID'");
            }
            else {
                echo "Old password is not correct";
            }
        }
        if ($firstname !="") {
                $query = ("UPDATE user (FirstName) VALUES ('$firstname') WHERE userID='$userID'");
            }
        if ($lastname !="") {
                $query = ("UPDATE user (LasttName) VALUES ('$lastname') WHERE userID='$userID'");
        }
        if ($address !="") {
            $query = ("UPDATE buyer (Address) VALUES ('$address') WHERE userID='$userID'");
        } 
        if ($phone !="") {
            $query = ("UPDATE user (Phone) VALUES ('$phone') WHERE userID='$userID'");
        }
        if ($CCNumber !="") {
            $query = ("UPDATE creditcard (CreditCardNo) VALUES ('$CCnumber') WHERE userID='$userID'");
        }
        if ($CCpin !="") {
            $query = ("UPDATE creidtcard (CreditCardPin) VALUES ('$CCpin') WHERE userID='$userID'");
        }
        if ($CCname !="") {
                $query = ("UPDATE creditcard (CreditCardName) VALUES ('$CCname') WHERE userID='$userID'");
        }
    header ("Location: home.php");

}
	$DBcon->close();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Profile</title>
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
    <body bgcolor = "#FFFFFF">        
        <div align="center" style="color: #666666;">
            <div style=" width:800px; border:solid 1px antiquewhite;" align='left'>
                <div id="boxheader" style=" background-color: antiquewhite; color: #666666; padding:3px;">
                    <b style=" font-size: 40px; font-style: italic;">Edits</b>
                </div>
                <div style="margin: 33px;" align="center">
                    <form class="form-signin" method="post" id="register-form">
                        <?php
                        if (isset($msg)) {
                            echo $msg;
                        }
                        ?>

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Old Password" name="oldpass"/>
                            <input type='password' class='form-control' placeholder="New Password" name="newpass"/>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="First Name" name="firstname"/>
                            <span id="check-e"></span>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Last Name" name="lastname"/>
                        </div>
                        <br>
                        <div class="form-group">
                            <input class="form-control" placeholder="Address" name="address"/>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="phone" class="form-control" placeholder="Phone" name="phone"/>
                        </div>
                        <br>
                        <hr>
                        <p>Credit Card info</p>
                        <div class="form-group">
                            <input type="number" class="form-control" placeholder="Credit Card Number" name="CCNumber"/>
                        </div>
                        <br>
                        <div class="form-group">
                            <input name="CCname" placeholder="credit card name" class="form-control"/>
                        </div>
                        <br>
                        <div>
                            <input name="CCpin" placeholder="crefir card pin" class="form-control"/>
                        </div>
                        <hr />
                        <div class="form-group" align="left">
                            <button type="submit" class="btn btn-default" name="btn-save">
                                <span class="glyphicon glyphicon-log-in"></span>Save Changes
                            </button> 
                        </div>
               </form>
            </div>
        </div>
    </body>
</html>