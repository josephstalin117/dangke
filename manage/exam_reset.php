<?php
	require_once 'logincheck.php';
	require_once '../library/db.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK href="../style.css" type=text/css rel=stylesheet>
<title>用户中心</title>
<script type="text/javascript">   
<?php
if(!$userid = $_GET['id']) exit();
$arr = array(
	'SINGLE_ID'=>null,
	'MULTI_ID'=>null,
	'JUDGE_ID'=>null,
	'SELECT_SINGLE'=>null,
	'SELECT_MULTI'=>null,
	'SELECT_JUDGE'=>null,
	'EXAM_END_TIME'=>null,
	'EXAM_PASS_TIME'=>null,
	'EXAM_SCHEDULE'=>null,
	'PAPER_MD5'=>null,
	'STU_SCO'=>null
);
if($db->update('stuinfo', $arr, "ID = '$userid'"))
echo 'alert("操作成功！")';
?>
</script>
<body> 	

</body>
</html>
