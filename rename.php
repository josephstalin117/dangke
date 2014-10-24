<?php
$dir =  opendir("video/image");
while (($file = readdir($dir)) !== false)
  {
  	//重命名
  	$num = intval(findNum($file));
  	if($num<=0) continue;
  	$old = "video/image/$file";
  	$new = str_replace("_0001", "", $old);
  	rename($old, $new);
  	//echo $old;
  	//echo $new;
  	echo $num;
  	echo "<br />";
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