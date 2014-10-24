<div class="title">题库管理</div>
<table width="100%">
  <tr>
    <td align="center"><a href="user.php?action=paper&type=single">单选题</a><a href="user.php?action=paperadd&type=single" style="margin-left:10px;" title="添加"><img src="../style/image/button_add.gif" /></a></td>
    <td align="center"><a href="user.php?action=paper&type=multi">多选题</a><a href="user.php?action=paperadd&type=multi" style="margin-left:10px;" title="添加"><img src="../style/image/button_add.gif" /></a></td>
    <td align="center"><a href="user.php?action=paper&type=judge">判断题</a><a href="user.php?action=paperadd&type=judge" style="margin-left:10px;" title="添加"><img src="../style/image/button_add.gif" /></a></td>
  </tr>
</table>
<?php 
if(isset($_COOKIE["message"])){
	$message= '<font size="-1" color="#ff0000">'.$_COOKIE["message"].'</font>';
	setcookie("message");	//删除cookie
}
echo isset($message)?$message:'';
?>
<?php
	require_once 'logincheck.php';
	$type=isset($_GET["type"])?$_GET["type"]:'';
	switch ($type){
		case 'single':
			$index=1;
			$sql="select * from single_selections order by ID";
			$db->query($sql);
			while($row=$db->getrow()){
				echo "<div>".$index."：$row[QUESTION]</div>
					  <div>A：$row[OPTION_A]</div>
					  <div>B：$row[OPTION_B]</div>
					  <div>C：$row[OPTION_C]</div>
					  <div>D：$row[OPTION_D]</div>
					  <div style='border-bottom:#ccc dotted 1px;'>答案：$row[ANSWER]<span style='float:right'><a href='user.php?action=paperedit&single_id=$row[ID]'>编辑</a>/<a href='paperdel.php?single_id=$row[ID]'>删除</a></span></div>
				";
				$index++;
			}
			break;
		case 'multi':
			$index=1;
			$sql="select * from multi_selections order by ID";
			$db->query($sql);
			while($row=$db->getrow()){
				echo "<div>".$index."：$row[QUESTION]</div>
					  <div>A：$row[OPTION_A]</div>
					  <div>B：$row[OPTION_B]</div>
					  <div>C：$row[OPTION_C]</div>
					  <div>D：$row[OPTION_D]</div>
					  <div style='border-bottom:#ccc dotted 1px;'>答案：$row[ANSWER]<span style='float:right'><a href='user.php?action=paperedit&multi_id=$row[ID]'>编辑</a>/<a href='paperdel.php?multi_id=$row[ID]'>删除</a></span></div>
				";
				$index++;
			}
			break;
		case 'judge':
			$answer_string[1]="对";
			$answer_string[0]="错";
			$index=1;
			$sql="select * from judge_list order by ID";
			$db->query($sql);
			while($row=$db->getrow()){
				echo "<div>".$index."：$row[QUESTION]</div>
					  <div style='border-bottom:#ccc dotted 1px;'>答案：".$answer_string[$row["ANSWER"]]."<span style='float:right'><a href='user.php?action=paperedit&judge_id=$row[ID]'>编辑</a>/<a href='paperdel.php?judge_id=$row[ID]'>删除</a></span></div>
				";
				$index++;
			}
			break;
		default:
			break;
	}
?>
