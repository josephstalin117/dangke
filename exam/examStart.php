<?php

require_once '../logincheck.php';
require_once '../config/config.exam.php';
require_once '../config/config.system.php';
include 'exam.php';

$exam = new exam();

//check timeout
if (!$exam->examBefore($config_system["exam_end_time"])) {
    echo '<script>alert("考试时间已截止！")</script>';
    exit();
}
//生成考试卷子
?>

