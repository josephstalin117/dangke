<?php
date_default_timezone_set("Asia/Shanghai");
require_once 'logincheck.php';
$select=isset($_POST["select"])?$_POST["select"]:'';
if(isset($select)){
	$enable=$_POST["enable"];
	$title=$_POST["title"];
	$start_time=strtotime("$select[0]-$select[1]-$select[2] 6:00:00");
	$end_time=strtotime("$select[3]-$select[4]-$select[5] 18:00:00");
	$exam_start_time=strtotime("$select[6]-$select[7]-$select[8] 6:00:00");
	$exam_end_time=strtotime("$select[9]-$select[10]-$select[11] 18:00:00"); 
	$str="
<?php
\$config_system[\"enable\"]=$enable;
\$config_system[\"title\"]='$title';
\$config_system[\"start_time\"]=$start_time;	//系统开启时间
\$config_system[\"end_time\"]=$end_time;		//关闭时间
\$config_system[\"exam_start_time\"]=$exam_start_time;	//考试开启时间
\$config_system[\"exam_end_time\"]=$exam_end_time;		//关闭时间
?>
	";
	file_put_contents("../config/config.system.php", $str);
	$message="修改成功！";
	setcookie("message",$message); 
	header("Location:user.php?action=systemoption");
} 

?>