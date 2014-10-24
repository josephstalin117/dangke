<?php 
require_once 'logincheck.php';
if(isset($_COOKIE["message"])){
	$message= '<font size="-1" color="#ff0000">'.$_COOKIE["message"].'</font>';
	setcookie("message");	//删除cookie
}
	if(isset($_POST["dep"]))
		$_SESSION['dep']=$_POST["dep"];
	if(isset($_POST["year"]))
		$_SESSION['year']=$_POST["year"];
	$dep=isset($_SESSION['dep'])?$_SESSION['dep']:'';
	$year=isset($_SESSION['year'])?$_SESSION['year']:'';
?>
<div class="title">学生管理</div>
<form name="select" method="post" action="user.php?action=1">
院系：
	 <select name="dep" id="department">
       <option value="all">全部</option>   
<?php 
$sql="select STU_DEP from stuinfo where 1=1 group by STU_DEP";
$db->query($sql);
while($row=$db->getrow()){
	if($dep==$row["STU_DEP"])
		echo "<option name=$row[STU_DEP] value=$row[STU_DEP] selected=selected>$row[STU_DEP]</option>";
	else
		echo "<option name=$row[STU_DEP] value=$row[STU_DEP]>$row[STU_DEP]</option>";
}
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;年份：
<select name="year" id="year">
<option value="all">全部</option> 
<?php 

$sql="select EXAM_YEAR from stuinfo where 1=1 group by EXAM_YEAR";
$db->query($sql);
while($row=$db->getrow()){
	if($year==$row["EXAM_YEAR"])
		echo "<option value=$row[EXAM_YEAR] selected=selected>$row[EXAM_YEAR]</option>";
	else
		echo "<option value=$row[EXAM_YEAR]>$row[EXAM_YEAR]</option>";
}
?>
    </select>
<input type="submit" value="查询" onclick="document.select.action='user.php?action=1';" />
<input type="button" value="添加" onclick="javascript: window.open('user.php?action=6');" />
<input type="submit" value="下载" onclick="document.select.action='download.php';" />
</form>
<?php
echo isset($message)?$message:'';
echo $dep;
if(isset($dep)&& isset($year)){
	if($dep=="all" && $year=="all")
		$sql="select * from stuinfo where 1=1 order by STU_DEP,STU_NUM";
	else if($dep=="all")
		$sql="select * from stuinfo where 1=1 and EXAM_YEAR='$year'";
	else if($year=="all")
		$sql="select * from stuinfo where 1=1 and STU_DEP='$dep'";
	else 
		$sql="select * from stuinfo where 1=1 and EXAM_YEAR='$year' and STU_DEP='$dep'";
	$db->query($sql);
?>
<table cellspacing="10">
<tr><th>学号</th><th>姓名</th><th>密码</th><th>院系</th><th width="40">成绩</th><th>操作</th></tr>
<?php
while($row=$db->getrow())
if($row["ID"]==(isset($_GET["modifyid"])?$_GET["modifyid"]:''))
	echo "<form name=modify method=post action=usermodify.php><input type=hidden name=modifyid value='$row[ID]' />
		<tr><td><input name=stu_number style='width:70px;' type=text value='$row[STU_NUM]' /></td>
			<td><input name=stu_name style='width:60px;' type=text value='$row[STU_NAME]' /></td>
			<td>$row[STU_PSW]</td>
			<td><input name=stu_dep type=text value='$row[STU_DEP]' /></td>
			<td>$row[STU_SCO]</td>
			<td><input type=submit value=保存 /></td>
		</tr></form>";
else
	echo "<tr><td>$row[STU_NUM]</td><td>$row[STU_NAME]</td><td>$row[STU_PSW]</td><td>$row[STU_DEP]</td><td>$row[STU_SCO]</td><td><a href='user.php?action=1&modifyid=$row[ID]' >修改</a> / <a href='exam_reset.php?id=$row[ID]' target='_blank'>重考</a> / <a href='userdelete.php?id=$row[ID]' >删除</a></td></tr>";
?>
</table>
<?php 
}
?>
