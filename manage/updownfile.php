<?php
require_once 'logincheck.php';
?>
<div class="title">批量上传</div>
<?php 
	if(isset($_COOKIE["message"])){
	echo '<font size="-1" color="#ff0000">'.$_COOKIE["message"].'</font>';
	setcookie("message");	//删除cookie
}?>
<form enctype="multipart/form-data" method="post" action="upandinsert.php" name="uploadform">
<input type="file" name="uploadfile" />
<input type="submit" name="submit" value="导入" />
</form>
注意：<br />
1、导入的文件格式只能是xls。<br />
2、点击<a href="导入信息模板.xls">这里</a>下载模板文件。