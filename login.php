<?php
	session_start();
	require_once 'library/db.php';
	require_once 'config/config.system.php';
	date_default_timezone_set("Asia/Shanghai");
	//检查系统是否开启
	if(time()<$config_system["start_time"] || time()>$config_system["end_time"]){
		$message="系统开放时间为".date('Y-m-d H:i',$config_system["start_time"])."到".date('Y-m-d H:i',$config_system["end_time"]);
		setcookie("message",$message);
		header("Location:index.php");
		exit();
	}
    $userNumber=dowith_sql(isset($_POST["STU_NUM"]) ? $_POST["STU_NUM"] : '');
	$password=dowith_sql(isset($_POST["STU_PSW"]) ? $_POST["STU_PSW"] : '');
	unset($_POST["STU_NUM"]);
	isset($_POST["STU_PSW"]);
	//接受用户输入开始验证

	if($userNumber!= NULL && $password!=NULL){
		$db=new DB();
		$sql="SELECT * FROM stuinfo WHERE 1=1 AND STU_NUM = '$userNumber' AND STU_PSW = '$password' order by ID desc";
		
		$db->query("$sql");
		
		$userInfo=$db->getrow();
		if($userInfo){
			$_SESSION['userID']=$userInfo["ID"];	//添加session供全局验证
			$ip = $_SERVER['REMOTE_ADDR'];
			if($userInfo["LOG_IP"])		//记录IP
				$userUpdate["LOG_IP"]=$userInfo["LOG_IP"].';'.$ip;
			else 
				$userUpdate["LOG_IP"]=$ip;
			if(!$userInfo["LOG_TIMES"])
			{
				$message="这是您第一次登陆系统，安全起见，请修改密码！";
				$userUpdate["LOG_TIMES"]=1;
				$db->update("stuinfo", $userUpdate,"ID='$userInfo[ID]'");
				header("Location: user.php?action=3 ");
			}else{
				$userUpdate["LOG_TIMES"]=$userInfo["LOG_TIMES"]+1;
				$db->update("stuinfo", $userUpdate,"ID='$userInfo[ID]'");
				header("Location: user.php?action=1 ");
				exit();
			}
		}else{
			$message="用户名或密码错误";
			header("Location: index.php ");
		}
		$db->free_result();
	}else{
		$message="请输入用户名和密码";
		header("Location: index.php ");
	}
	setcookie("message",$message); 
	
function dowith_sql($str)
{
   $str = str_replace("and","",$str);
   $str = str_replace("execute","",$str);
   $str = str_replace("update","",$str);
   $str = str_replace("count","",$str);
   $str = str_replace("chr","",$str);
   $str = str_replace("mid","",$str);
   $str = str_replace("master","",$str);
   $str = str_replace("truncate","",$str);
   $str = str_replace("char","",$str);
   $str = str_replace("declare","",$str);
   $str = str_replace("select","",$str);
   $str = str_replace("create","",$str);
   $str = str_replace("delete","",$str);
   $str = str_replace("insert","",$str);
   $str = str_replace("'","",$str);
   $str = str_replace("\"","",$str);
   $str = str_replace(" ","",$str);
   $str = str_replace("or","",$str);
   $str = str_replace("=","",$str);
   $str = str_replace("%20","",$str);
   $str = str_replace("#","",$str);
   //echo $str;
   return $str;
}

?>