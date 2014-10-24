<?php
require_once 'logincheck.php';
$singleID=isset($_POST["single_id"])?$_POST["single_id"]:'';
$multiID=isset($_POST["multi_id"])?$_POST["multi_id"]:'';
$judgeID=isset($_POST["judge_id"])?$_POST["judge_id"]:'';

if($singleID){
	$data["QUESTION"]=$_POST["question"];
	$data["OPTION_A"]=$_POST["option_a"];
	$data["OPTION_B"]=$_POST["option_b"];
	$data["OPTION_C"]=$_POST["option_c"];
	$data["OPTION_D"]=$_POST["option_d"];
	$data["ANSWER"]=$_POST["answer"];
	print_r($data);
	if($db->update("single_selections", $data, "ID='$singleID'"))
		$message="保存成功";
	else
		$message="编辑失败";
	setcookie("message",$message);	//删除cookie
	header("Location:user.php?action=paper&type=single");
}
if($multiID){
	$data["QUESTION"]=$_POST["question"];
	$data["OPTION_A"]=$_POST["option_a"];
	$data["OPTION_B"]=$_POST["option_b"];
	$data["OPTION_C"]=$_POST["option_c"];
	$data["OPTION_D"]=$_POST["option_d"];
	$data["ANSWER"]=implode('', $_POST["answer"]);
	print_r($data);
	if($db->update("multi_selections", $data, "ID='$multiID'"))
		$message="保存成功";
	else
		$message="编辑失败";
	setcookie("message",$message);	//删除cookie
	header("Location:user.php?action=paper&type=multi");
}
if($judgeID){
	$data["QUESTION"]=$_POST["question"];
	$data["ANSWER"]=$_POST["answer"];
	print_r($data);
	if($db->update("judge_list", $data, "ID='$judgeID'"))
		$message="保存成功";
	else
		$message="编辑失败";
	setcookie("message",$message);	//删除cookie
	header("Location:user.php?action=paper&type=judge");
}