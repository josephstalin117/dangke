<?php
require_once 'logincheck.php';
?>
<div class="title">添加考生</div>
<?php 
if(isset($_POST["useradd"])){
	$userUpdate["STU_NUM"]=$_POST["useradd"][0];
	$userUpdate["STU_NAME"]=$_POST["useradd"][1];
	$userUpdate["STU_DEP"]=$_POST["useradd"][2];
	$userUpdate["EXAM_YEAR"]=$_POST["useradd"][3];
	$userUpdate["STU_PSW"]=$userUpdate["STU_NUM"];
	if($db->insert("stuinfo", $userUpdate))
		echo '<font size="-1" color="#ff0000">添加成功</font>';
	else 
		echo '<font size="-1" color="#ff0000">添加失败</font>';
}
?>
<form method="post" action="user.php?action=6">
学号：<input type="text" style="width:70px;" name="useradd[]" />
姓名：<input type="text" style="width:60px;" name="useradd[]" />
院系：<input type="text" name="useradd[]" />
年份：<input type="text" style="width:50px;" name="useradd[]" />
<input type="submit" value="确认添加" />
</form>