<?php 
require_once 'logincheck.php';
if(isset($_COOKIE["message"])){
	$message= '<font size="-1" color="#ff0000">'.$_COOKIE["message"].'</font>';
	setcookie("message");	//删除cookie
}
?>
<div class="title">视频管理</div>
<!--<a href="user.php?action=uploadvideo">上传视频>>></a>
--><?php 
echo isset($message)?$message:'';
?>
<table cellspacing="10">
<tr><td align="center">标题</td>
<td align="center">缩略图</td>
<td width=320 style='line-height:24px;' align="center">简介</td>
<td align="center">操作</td></tr>
<?php
	$modifyid=isset($_GET["modifyid"])?$_GET["modifyid"]:'';
	$sql="select * from video where 1=1";
	$db->query($sql);
	while($row=$db->getrow()){
		if($row["ID"]==$modifyid)
			echo "<form action=videomodify.php method=post><input type=hidden value=$row[ID] name=modifyinfo[] />
				  <tr><td width=80><input type=text style='width:80px;' value='$row[TITLE]' name=modifyinfo[] /></td>
				  <td><img src='$row[IMG]' width=120 /></td>
				  <td width=320 style='line-height:24px;'><font size='-1'><textarea style='width:280px;height:100px;' name=modifyinfo[]>$row[INTRO]</textarea></font></td>
				  <td><input type='submit' value='确认' /></td></tr></form>";
		else
			echo "<tr><td width=80>$row[TITLE]</td>
				  <td><img src=$row[IMG] width=120 /></td>
				  <td width=320 style='line-height:24px;'><font size='-1'>".($row["INTRO"]==''?"无":$row["INTRO"])."</font></td>
				  <td><a href=user.php?action=2&modifyid=$row[ID]>修改</a>/
				  <a href=videodelete.php?id=$row[ID]>删除</a></td></tr>";
	}
?>  
</table>