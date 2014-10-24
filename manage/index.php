<?php
	session_start();
	$userNum=isset($_SESSION["adminID"]) ? $_SESSION["adminID"] : '';
	if($userNum!=NULL){
		header("Location: user.php ");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>用户登录</title>
<link href="../style.css" rel="stylesheet" type="text/css">
<body>
<div class="index_img"></div>
<div class="index_container">
    <div class="login_container">
    	<div class="message_container">
    <?php 
        if(isset($_COOKIE["message"])){
            echo $_COOKIE["message"];
            setcookie("message");	//删除cookie
        }
    ?>
    	</div>
    <form id="login" name="login" method="post" action="login.php">
    <div>
    <h3 style="float:left; line-height:36px; color:#333; font-weight:lighter; font-family:Microsoft Yahei, Helvetica, sans-serif;">账号:</h3>
    <input class="input_text" type="text"  maxlength="8" name="STU_NUM">
    </div>
    <div style="margin-top:16px;">
    <h3 style="float:left; line-height:36px; color:#333; font-weight:lighter; font-family:Microsoft Yahei, Helvetica, sans-serif;">密码:</h3>
    <input class="input_text" type="password" name="STU_PSW" >
    </div>
    <div style="margin-top:16px;">
    <input style="height:36px; width:128px;" type="submit" onMouseOver="this.style='background-color:#000;'" value="登 陆"  name="submit"/>
    <input style="height:36px; width:128px; margin-left:14px;" type="reset"  value="清 空"  name="reset"/>
    </div>
    </form>
    </div>
</div>

</body>
</head>
</html>