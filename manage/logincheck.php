﻿<?php
	chdir(dirname(__FILE__));
	session_start();
	$userID=isset($_SESSION['adminID']) ? $_SESSION['adminID'] : '';
	//验证用户是否已登陆
	if($userID==NULL){
		header("Location: index.php ");
    	exit(); 
    }
	require_once("../library/db.php");
	$db=new DB();
	$sql="SELECT * FROM admin WHERE ID = '$userID'";
	$db->query("$sql");
	$userInfo=$db->getrow();
	$isLogin=true;
?>