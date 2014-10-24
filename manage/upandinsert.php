<?php
require_once 'logincheck.php';
require_once '../library/uploadfile.php';
require_once '../library/excel/reader.php';
$option=array('filepath'=>'../upload','allowtype'=>array('xls'),"maxsize"=>"10000000","israndname"=>true);
$file=new FileUpload($option);
if(!$file->uploadFile("uploadfile"))//获取要上传的文件,上传
	$message=$file->getErrorMsg();
else{								//插入到数据库中
	$xl= new Spreadsheet_Excel_Reader();
	$xl->setOutputEncoding('CP936');
	$xl->read($option["filepath"].'/'.iconv("utf-8","GBK",$file->getNewFileName()));
	$succeed=0;
	$lost=0;
	for ($i = 2; $i <= $xl->sheets[0]['numRows']; $i++) {
		$data['STU_NUM']=str_replace(' ','',iconv("gb2312","utf-8",$xl->sheets[0]['cells'][$i][1]));
		$data['STU_NAME']=str_replace(' ','',iconv("GBK","utf-8",$xl->sheets[0]['cells'][$i][2]));
		$data['STU_DEP']=str_replace(' ','',iconv("gb2312","utf-8",$xl->sheets[0]['cells'][$i][3]));
		$data['STU_PSW']=$data['STU_NUM'];
		$data['EXAM_YEAR']=str_replace(' ','',iconv("gb2312","utf-8",$xl->sheets[0]['cells'][$i][4]));
		if($db->insert("stuinfo",$data)) 
			$succeed++;
		else 
			$lost++;	
	}
	$message="成功导入".$succeed."条记录，失败".$lost."条";
}
	setcookie("message",$message);
	//echo $message;
	header('Location:user.php?action=5');