<?php
date_default_timezone_set("Asia/Shanghai");
echo time();
echo '<br />';
echo $t=date('Y-m-d h:i:s',time());
echo '<br />';
echo strtotime($t);
echo '<br />';
//echo date("Ymd H:i:s",strtotime("now"))
?>