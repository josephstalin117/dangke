<?php
require_once 'logincheck.php';
$videoID=isset($_GET["id"])?$_GET["id"]:'';
if($videoID!=NULL){
	if($db->delete('video',"ID=$videoID"))
		$message="删除成功！";
	else 
		$message="删除失败！";
	setcookie("message",$message);
	header("Location: user.php?action=2");
}
?>