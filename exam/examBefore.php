<?php
require_once '../logincheck.php';
include '../config/config.db.php';
require_once '../config/config.exam.php';
require_once '../config/config.system.php';
include 'exam.php';

$exam = new exam();
$exam->examBefore($config_system["exam_end_time"]);
if ($exam == FALSE) {
    echo '<script>alert("考试时间已经结束"); history.back();</script>';
    exit();
}

$chapter = $_GET['chapter'];
?>
<a href="../user.php?action=5">点错了，取消考试</a><br />开始考试时间:<?php echo date("Y-m-d H:i") ?>考试结束时间：<?php echo date("Y-m-d H:i", time() + 60 * 20) ?>请尽快完成考试<br />
<a href="examSelect.php?chapter='<?php echo $chapter ?>'">我要考试</a>


