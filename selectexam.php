<?php
require_once 'logincheck.php';
require_once 'config/config.exam.php';
require_once 'config/config.system.php';
if($config_system["exam_end_time"]<time()) {
echo '<script>alert("考试时间已截止！")</script>';
exit();
}
if($userInfo["SINGLE_ID"] || $userInfo["MULTI_ID"] || $userInfo["JUDGE_ID"]){
	header("Location: exam.php ");
}else{
	if($userInfo["EXAM_TIMES"]>=1)
		exit();
	$suerUpdate["EXAM_TIMES"]=1;
	//单选题
	if($config_exam['single_num']>0){
		$sql="select ID from single_selections order by rand() limit $config_exam[single_num]";
		$db->query($sql);
		$userUpdate["SINGLE_ID"]='';
		while($row=$db->getrow())
		{
			$userUpdate["SINGLE_ID"].=$row["ID"].',';
		}
		$db->free_result();
	}
	//多选题
	if($config_exam['multi_num']>0){
		$num = array(6,4,4,6,4,8,7,6,5);
		foreach($num as $key => $value){
			$chap=$key+1;
			$sqlArr[] = "(select ID from multi_selections where CHAPTER = '$chap' order by rand() limit $value)";
		}
		$sql = implode(' union ', $sqlArr);
//		$sql="select ID from multi_selections order by rand() limit $config_exam[multi_num]";
		$db->query($sql);
		$userUpdate["MULTI_ID"]='';
		while($row=$db->getrow())
		{
			$userUpdate["MULTI_ID"].=$row["ID"].',';
		}
		$db->free_result();
	}
	//判断题
	if($config_exam['judge_num']>0){
		$sql="select ID from judge_list order by rand() limit $config_exam[judge_num]";
		$db->query($sql);
		$userUpdate["JUDGE_ID"]='';
		while($row=$db->getrow())
		{
			$userUpdate["JUDGE_ID"].=$row["ID"].',';
		}
		$db->free_result();
	}
	//exit();
	$userUpdate["PAPER_MD5"] = MD5("$userInfo[STU_NUM]$userInfo[ID]$userInfo[STU_NAME]");
	$userUpdate["EXAM_END_TIME"]=time()+$config_exam["time"]*60;
	$db->update("stuinfo", $userUpdate,"ID=$userInfo[ID]");
	header("Location: exam.php ");
}
?>