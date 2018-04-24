<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    $DBhost = "localhost";
    $DBuser = "root";
    $DBpass = "";
    $DBname = "ecommerce";
	 
    $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
    if ($DBcon->connect_errno) {
        die("ERROR : -> ".$DBcon->connect_error);
    }