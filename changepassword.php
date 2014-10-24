<?php
	require_once 'logincheck.php';
	$psw_old=isset($_POST["PSW_OLD"])?$_POST["PSW_OLD"]:'';
	$psw_new1=isset($_POST["PSW_NEW1"])?$_POST["PSW_NEW1"]:'';
	$psw_new2=isset($_POST["PSW_NEW2"])?$_POST["PSW_NEW2"]:'';
	if($psw_old && $psw_new1 && $psw_new2){
		//验证密码新密码是否合法
		if($psw_old==$userInfo["STU_PSW"]){
			if($psw_new1==$psw_new2){
				if(strlen($psw_new1)<=12 && strlen($psw_new1)>=8){
					if($psw_new1!=$psw_old){
						if(preg_match("/^[0-9A-Za-z]*$/", $psw_new1)) {
							$userUpdate["STU_PSW"]=$psw_new1;
							if($db->update("stuinfo", $userUpdate,"ID='$userInfo[ID]'")){
								$message="密码修改成功！";
							}else{
								$message="操作失败，请重试";
							}
						}else{
							$message="只允许输入字母A-Z,a-z和数字1-9";
						}
					}else{
						$message="新密码与旧密码不能相同！";
					}
				}else{
					$message="新密码长度必须为8-12位！";
				}
			}else{
				$message="两次输入的密码不一致！";
			}
		}else{
			$message="旧密码不正确！";
		}
	}else{
		$message="请正确输入！";
	}
	setcookie("message",$message); 
	header("Location: user.php?action=3 ");
?>