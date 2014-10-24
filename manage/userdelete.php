<?php
require_once 'logincheck.php';
$userID=isset($_GET["id"])?$_GET["id"]:'';
if($userID!=NULL){
	if($db->delete('stuinfo',"ID=$userID"))
		$message="删除成功！";
	else 
		$message="删除失败！";
	setcookie("message",$message);
	header("Location: user.php?action=1");
}
?>