<?php
require_once 'library/db.php';
$db = new DB();
$sql = "select * from video";
$resule = $db->query($sql);

while($row = mysql_fetch_array($resule)){
	$arr["IMG"] = "/jsll/$row[IMG]";
	$db->update(video, $arr, "ID = $row[ID]");
}
?>