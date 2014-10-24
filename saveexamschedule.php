<?php	//保存考试进度
require_once 'logincheck.php';
$userUpdate["EXAM_SCHEDULE"]=isset($_POST["schedule"])?$_POST["schedule"]:'';
if($userUpdate["EXAM_SCHEDULE"]!=NULL){
	$db->update("stuinfo", $userUpdate, "ID=$userInfo[ID]");
}

?>