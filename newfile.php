<?php

//打开 images 目录
$dir =  opendir("video/file");
//require_once 'library/db.php';
//$db = new DB();
//列出 images 目录中的文件
while (($file = readdir($dir)) !== false)
  {
  	//echo "filename: " . $file;
  	$count = intval(findNum($file));
  	if($count<=0) continue;
  	//重命名
  	$file=G2U($file);
	//$file_arr[$count] = iconv("GBK","UTF-8",str_replace('.flv',"",$file));
  	//$file_arr[$count] = str_replace('.flv',"",$file);
  	$old = U2G("video/file/$file");
  	$new = "video/file/$count.flv";
  	rename($old, $new);
  	echo "<a href='/jsll/video/file/$file'>$file</a>";
  	continue;
  	
	$file_arr[$count] = iconv("GBK","UTF-8",str_replace('.flv',"",$file));
	$file_arr[$count]=str_replace("第","",$file_arr[$count]);
	$file_arr[$count]=str_replace("讲","",$file_arr[$count]);
	$file_arr[$count]=str_replace("1","",$file_arr[$count]);
	$file_arr[$count]=str_replace("2","",$file_arr[$count]);
	$file_arr[$count]=str_replace("3","",$file_arr[$count]);
	$file_arr[$count]=str_replace("4","",$file_arr[$count]);
	$file_arr[$count]=str_replace("5","",$file_arr[$count]);
	$file_arr[$count]=str_replace("6","",$file_arr[$count]);
	$file_arr[$count]=str_replace("7","",$file_arr[$count]);
	$file_arr[$count]=str_replace("8","",$file_arr[$count]);
	$file_arr[$count]=str_replace("9","",$file_arr[$count]);
	$file_arr[$count]=str_replace("0","",$file_arr[$count]);
  }
  exit();
  
  for($i=1; $i<=count($file_arr); $i++){
	$arr["ID"]=$i;
	$arr["TITLE"]=$file_arr[$i];
	$arr["PATH"]="video/file/video$i.flv";
	$arr["IMG"]="video/image/video$i.jpg";
	print_r($arr);
	
/*	if($db->insert("video", $arr))
		echo "succeed";
	else 
		echo "fail";*/
	echo "<br />";
  }
  closedir($dir);

  function U2G($str){
  	return iconv('UTF-8','GBK',$str);
  }
  function G2U($str){
  	return iconv('GBK','UTF-8',$str);
  }
    
   function findNum($str=''){
	$str=trim($str);
	if(empty($str)){return '';}
	$temp=array('1','2','3','4','5','6','7','8','9','0');
	$result='';
	for($i=0;$i<strlen($str);$i++){
		if(in_array($str[$i],$temp)){
			$result.=$str[$i];
		}
	}
	return $result;
}
?>