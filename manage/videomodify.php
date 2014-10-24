<?php
require_once 'logincheck.php';
$videoID=isset($_POST["modifyinfo"])?$_POST["modifyinfo"][0]:'';
if($userID){
	$videoUpdate["TITLE"]=$_POST["modifyinfo"][1];
	$videoUpdate["INTRO"]=$_POST["modifyinfo"][2];
	if($db->update("video", $videoUpdate, "ID='$videoID'"))
		$message="修改成功！";
	else 
		$message="修改失败！";
	setcookie("message",$message);
	header("Location: user.php?action=2");
}