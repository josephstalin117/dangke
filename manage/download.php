<?php
	require_once 'logincheck.php';
	$dep=isset($_POST["dep"])?$_POST["dep"]:'';
	$year=isset($_POST["year"])?$_POST["year"]:'';
	if(!($dep && $year))
		exit();
	if($dep=="all" && $year=="all")
		$sql="select * from stuinfo where 1=1 order by EXAM_YEAR,STU_DEP,STU_NUM";
	else if($dep=="all")
		$sql="select * from stuinfo where 1=1 and EXAM_YEAR='$year' order by STU_DEP";
	else if($year=="all")
		$sql="select * from stuinfo where 1=1 and STU_DEP='$dep'";
	else 
		$sql="select * from stuinfo where 1=1 and EXAM_YEAR='$year' and STU_DEP='$dep'";
	
	$db->query($sql);
    header("Content-Type: application/vnd.ms-execl");
	header("Content-Disposition: attachment; filename=考试系统成绩表.xls");
	header("Pragma: no-cache");
	header("Exp ires: 0");
	echo '<table border="1">';
	echo iconv("utf-8","gb2312",'<tr><td width="100">学号</td>
                              <td width="100">姓名</td>
                              <td width="100">密码</td>
                              <td width="170">院系</td>
			      			  <td width="60">年份</td>
                              <td width="100">成绩</td>
                              <td width="60">备注</td></tr>'
                              );
	while($row=$db->getrow()){
	echo '<tr>';
	echo '<td width="100" style="height: 22px; vnd.ms-excel.numberformat:@">'.iconv("utf-8","gb2312",$row["STU_NUM"]).'</td>';
	echo '<td width="100">'.iconv("utf-8","GBK",$row["STU_NAME"]).'</td>';
	echo '<td width="170" style="height: 22px; vnd.ms-excel.numberformat:@">'.iconv("utf-8","gb2312",$row["STU_PSW"]).'</td>';
	echo '<td width="170">'.iconv("utf-8","gb2312",$row["STU_DEP"]).'</td>';
	echo '<td width="170">'.iconv("utf-8","gb2312",$row["EXAM_YEAR"]).'</td>';
	echo '<td width="100">'	.iconv("utf-8","gb2312",$row["STU_SCO"]).'</td>';
  	echo '<td width="100">'.iconv("utf-8","gb2312",$row["STU_OTHER"]).'</td>';
	echo '</tr>';
	}
	echo '</table>';
?>