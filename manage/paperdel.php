<?php
require_once 'logincheck.php';
$singleID=isset($_GET["single_id"])?$_GET["single_id"]:'';
$multiID=isset($_GET["multi_id"])?$_GET["multi_id"]:'';
$judgeID=isset($_GET["judge_id"])?$_GET["judge_id"]:'';

if($singleID){
	if($db->delete("single_selections", "ID='$singleID'"))
		$message="删除成功";
	else
		$message="编辑失败";
	setcookie("message",$message);	//删除cookie
	header("Location:user.php?action=paper&type=single");
}
if($multiID){
	if($db->delete("multi_selections", "ID='$multiID'"))
		$message="删除成功";
	else
		$message="编辑失败";
	setcookie("message",$message);	//删除cookie
	header("Location:user.php?action=paper&type=multi");
}
if($judgeID){
	if($db->delete("judge_list", "ID='$judgeID'"))
		$message="删除成功";
	else
		$message="编辑失败";
	setcookie("message",$message);	//删除cookie
	header("Location:user.php?action=paper&type=judge");
}