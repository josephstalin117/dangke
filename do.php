<?php
chdir(dirname(__FILE__));
	require_once("library/db.php");
	$db=new DB();
	$sql="SELECT * FROM single_selections";
	$result=$db->query("$sql");
	$update["ID"]=1;
	while($row=mysql_fetch_array($result)){	
		$db->update('single_selections', $update,"ID=$row[ID]");
		$update["ID"]++;
	}
?>