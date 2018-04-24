<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
require_once 'config.php';
if (isset($_SESSION['userSession'])) {
    header("Location: home.php");
    exit;
}
if (isset($_POST['btn-login'])) {

    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);
    $username = $DBcon->real_escape_string($username);
    $password = $DBcon->real_escape_string($password);
    $hashedusername= md5($username);
    $hashedpassword = md5($password);
    $query = $DBcon->query("SELECT UserID FROM user WHERE Username='$hashedusername' and Password='$hashedpassword'");
    $row = $query->fetch_array();
    $count = $query->num_rows;
    if (($count == 1)) {
        $_SESSION['userSession'] = $row['UserID'];
        header ("Location: home.php");
                    $msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> regitsered !
				</div>";

        } else {
            $msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> Invalid Username or Password !
				</div>";
            echo "Error" . $DBcon->error; 

        }
    }
    $DBcon->close();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css">
        <title>Login Page</title>
        <style type = "text/css" class=>
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
            <div style=" width:300px; border:solid 1px antiquewhite;" align="left">
                <div id="boxheader" style=" background-color: antiquewhite; color: #666666; padding:3px;">
                    <b style=" font-size: 40px; font-style: italic;">Login</b>
                </div>
                <div style="margin: 33px;" align="center">
                    <form action="Login.php" method="post">
                        <?php
                            if(isset($msg)){
                                echo $msg;
                                }?>
                        <div class="form-group">
                            <input class ="textareas" class="form-control" placeholder="username" name="username" required />
                            <span id="check-e"></span>
                        </div>
                        <br>
                        <div class="form-group">
                            <input class="textareas" type="password" class="form-control" placeholder="Password" name="password" required />
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="buttons" name="btn-login" id="btn-login">
                                <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
                            </button>
                            <br>
                            <br>
                            <a href="SignUP.php" style="color: blue">click here to sign up</a>
                        </div>
                     </form>    
                    <br>
                    <!--<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div> -->
                    <br>
                </div>
            </div>
        </div>
    </body>
</html>
