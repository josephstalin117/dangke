<?php

require_once 'logincheck.php';

include 'config/config.db.php';
require_once 'config/config.exam.php';
require_once 'config/config.system.php';

if ($config_system["exam_end_time"] < time()) {
    echo '<script>alert("考试时间已经结束"); history.back();</script>';
    exit();
}
$chapter = $_GET['chapter'];
echo '<a href="user.php?action=5">点错了，取消考试</a><br />';
echo '开始考试时间：' . date("Y-m-d H:i") . ' 考试结束时间：' . date("Y-m-d H:i", time() + 60 * 20) . '请尽快完成考试<br />';
echo '<a href="selectexam.php?chapter=' . $chapter . ' ">&gt;&gt;&gt;我要考试</a>';
?>
