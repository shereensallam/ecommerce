<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
session_start();
if (isset($_SESSION['userSession'])!="") {
	header("Location: home.php");
}
require_once 'config.php';
if(isset($_POST['btn-signup'])) {
	
	$username = strip_tags($_POST['username']);
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);
        $firstName = strip_tags($_POST['firstName']);
        $lastName = strip_tags($_POST['lastName']);
	$phone = strip_tags($_POST['phone']);
        $stat= strip_tags($_POST['stat']);
	//echo $firstName;
     //   echo $lastName;
	
	$username = $DBcon->real_escape_string($username);
	$email = $DBcon->real_escape_string($email);
	$password = $DBcon->real_escape_string($password);
        $firstName = $DBcon->real_escape_string($firstName);
        $lastName = $DBcon-> real_escape_string($lastName);
       	$phone = $DBcon->real_escape_string($phone);
        
        $hashedusername = md5($username);
	$hashedpassword = md5($password);

	$checkaccount = $DBcon->query("SELECT UserID FROM user WHERE Email='$email'");
	$checkuser = $DBcon->query("SELECT UserID FROM user WHERE UserName='$hashedusername'");
	$countaccount=$checkaccount->num_rows;
	$countuser=$checkuser->num_rows;
	if($countaccount==0 && $countuser==0){
            $query = "INSERT INTO user (FirstName,LastName,Email,Password,UserName,PhoneNo) VALUES ('$firstName','$lastName','$email','$hashedpassword','$hashedusername','$phone')";
            if ($DBcon->query($query)) {                
		$msg = "<div class='alert alert-success'>
                            <span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
                        </div>";
                if ($stat == "buyer")
                {
                    $checkregister = $DBcon->query("SELECT * FROM user WHERE UserName='$hashedusername'");
                    $registerrow = mysqli_fetch_array($checkregister);
                    $Query= ("INSERT INTO buyer(UserID) VALUES ('$registerrow[UserID]')");
                    //Creating a cart for the buyer
                    $Query2 = $DBcon->query("SELECT * FROM buyer WHERE UserID = '$registerrow[UserID]'");
                    $row2 = mysqli_fetch_array($Query2);
                    $Query3= "INSERT INTO cart (BuyerID) VALUES ('$row2[BuyerID]')";
                    if (!$DBcon->query($Query3)) {                
                        echo "error" . $DBcon->error;
                    }
//                    header ("Location: home.php");

                }
                elseif ($stat == "seller")
                {
                    $row = mysqli_fetch_array($checkaccount);
                    $Query= "INSERT INTO seller(UserID) VALUES ('$row[UserID]')";
                }
                $_SESSION['userSession']=$checkaccount;
                
            }else {
                $msg = "Error: " . $DBcon->error;
		}
        }
	else{
		$msg = "<div class='alert alert-danger'>
			<span class='glyphicon glyphicon-info-sign'></span>email already exists!
			</div>";
	}
}
	$DBcon->close();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Page</title>
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
                    <b style=" font-size: 40px; font-style: italic;">Sign up</b>
                </div>
                <div style="margin: 33px;" align="center">
                    <form class="form-signin" method="post" id="register-form">

                        <?php
                        if (isset($msg)) {
                            echo $msg;
                        }
                        ?>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" name="username" required  />
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email address" name="email" required  />
                            <span id="check-e"></span>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password" required  />
                        </div>
                        <br>
                        <div class="form-group">
                            <input class="form-control" placeholder="first name" name="firstName" required/>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="last name" name="lastName" required  />
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="phone" class="form-control" placeholder="Phone" name="phone" required  />
                        </div>
                        <br>
                        <div class="form-group">
                            <input name="stat" placeholder="buyer or seller" class="form-control"/>
                                                <hr />
                        <div class="form-group" align="left">
                            <button type="submit" class="btn btn-default" name="btn-signup">
                                <span class="glyphicon glyphicon-log-in"></span>Create Account
                            </button> 
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>