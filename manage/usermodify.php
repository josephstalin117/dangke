<div class="title">考生管理</div>
<?php
require_once 'logincheck.php';
$userID=isset($_POST["modifyid"])?$_POST["modifyid"]:'';
if($userID){
	$userUpdate["STU_NAME"]=$_POST["stu_name"];
	$userUpdate["STU_NUM"]=$_POST["stu_number"];
	$userUpdate["STU_DEP"]=$_POST["stu_dep"];
//	$userUpdate["STU_SCO"]=$_POST["stu_sco"];
	if($db->update("stuinfo", $userUpdate, "ID='$userID'"))
		$message="修改成功！";
	else 
		$message="修改失败！";
	setcookie("message",$message);
	header("Location: user.php?action=1");
}
?>