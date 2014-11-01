<?php

require_once '../logincheck.php';
require_once '../config/config.exam.php';
require_once '../config/config.system.php';
chdir(dirname(__FILE__));
include './exam.php';

$chapter = $_GET['chapter'];
$exam = new exam();

$examCheck = $exam->examCheckTicke($config_system["exam_end_time"], $userInfo["STU_SCO"], $chapter, $userInfo["EXAM_CHAP"]);


//check status
if ($examCheck) {
    echo $examCheck;
    header("Location: user.php?action=5 ");
    exit();
}

//random select exam


?>
