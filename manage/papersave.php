<?php
require_once 'logincheck.php';
$type=isset($_GET["type"])?$_GET["type"]:'';

if($type=="single"){
	$data["QUESTION"]=$_POST["question"];
	$data["OPTION_A"]=$_POST["option_a"];
	$data["OPTION_B"]=$_POST["option_b"];
	$data["OPTION_C"]=$_POST["option_c"];
	$data["OPTION_D"]=$_POST["option_d"];
	$data["ANSWER"]=$_POST["answer"];
	if($db->insert("single_selections", $data))
		$message="保存成功";
	else
		$message="编辑失败";
	setcookie("message",$message);	//删除cookie
	header("Location:user.php?action=paper&type=single");
}
if($type=="multi"){
	$data["QUESTION"]=$_POST["question"];
	$data["OPTION_A"]=$_POST["option_a"];
	$data["OPTION_B"]=$_POST["option_b"];
	$data["OPTION_C"]=$_POST["option_c"];
	$data["OPTION_D"]=$_POST["option_d"];
	$data["ANSWER"]=implode('', $_POST["answer"]);
	if($db->insert("multi_selections", $data))
		$message="保存成功";
	else
		$message="编辑失败";
	setcookie("message",$message);	//删除cookie
	header("Location:user.php?action=paper&type=multi");
}
if($type=="judge"){
	$data["QUESTION"]=$_POST["question"];
	$data["ANSWER"]=$_POST["answer"];
	if($db->insert("judge_list", $data))
		$message="保存成功";
	else
		$message="编辑失败";
	setcookie("message",$message);	//删除cookie
	header("Location:user.php?action=paper&type=judge");
}