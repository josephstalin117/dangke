<?php
	session_start();
	$userID=isset($_SESSION['adminID']) ? $_SESSION['adminID'] : '';
	//验证用户是否已登陆
	if($userID==NULL){
		header("Location: index.php ");
    	exit(); 
    }
	session_destroy();
	setcookie("message","退出成功");
	Header("Location: ./ ");
?>