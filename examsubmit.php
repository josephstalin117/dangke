<?php

session_start();
$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : '';
//验证用户是否已登陆
if ($userID != NULL) {
    $sql = "SELECT * FROM stuinfo WHERE ID = '$userID'";
} else if (isset($_GET["paper"])) {
    $paper_md5 = $_GET["paper"];
    $sql = "SELECT * FROM stuinfo WHERE PAPER_MD5 = '$paper_md5'";
} else {
    header("Location: index.php ");
    exit();
}
require_once("library/db.php");
$db = new DB();
$db->query("$sql");
$userInfo = $db->getrow();
$isLogin = true;
$_SESSION['userID'] = $userInfo["ID"];
require_once 'config/config.exam.php';

//验证是否存在题号
if (!($userInfo["SINGLE_ID"] || $userInfo["MULTI_ID"] || $userInfo["JUDGE_ID"])) {
    exit();
}

//确保页面由exam提交
if (!isset($_POST["sure"])) {
    exit();
}

//是否成绩已存在
if ($userInfo["STU_SCO"] != NULL) {
    echo '您的试卷已提交，请勿重复提交！';
    exit();
}


//计算最终成绩
$score = 0;
//单选题
if ($config_exam['single_num']) {
    for ($i = 0; $i < $config_exam["single_num"]; $i++) {
        $singleAnswer[$i] = isset($_POST["single$i"]) ? $_POST["single$i"] : '';
    }
    $singleID = explode(",", $userInfo["SINGLE_ID"]);
    $i = 0;
    while ($singleID[$i]) {
        $sql = "select ANSWER from single_selections where ID='$singleID[$i]' and ANSWER='$singleAnswer[$i]'";
        $db->query($sql);
        if ($db->getrow()) {
            $score+=$config_exam["single_sorce"];
        }
        $i++;
    }
    $userUpdate["SELECT_SINGLE"] = implode(",", $singleAnswer);
}
//多选题
if ($config_exam['multi_num']) {
    for ($i = 0; $i < $config_exam["multi_num"]; $i++) {
        $multiAnswer[$i] = isset($_POST["multi$i"]) ? implode('', $_POST["multi$i"]) : '';
    }
    $multiID = explode(",", $userInfo["MULTI_ID"]);
    $i = 0;
    while ($multiID[$i]) {
        //存在问题？？
        $sql = "select ANSWER from multi_selections where ID='$multiID[$i]' and ANSWER='$multiAnswer[$i]'";
        $db->query($sql);
        if ($db->getrow()) {
            $score+=$config_exam["multi_sorce"];
        }
        $i++;
    }
    $userUpdate["SELECT_MULTI"] = implode(",", $multiAnswer);
}
//判断题
if ($config_exam['multi_num']) {
    for ($i = 0; $i < $config_exam["judge_num"]; $i++) {
        $judgeAnswer[$i] = isset($_POST["judge$i"]) ? $_POST["judge$i"] : '';
    }
    $judgeID = explode(",", $userInfo["JUDGE_ID"]);
    $i = 0;
    while ($judgeID[$i]) {
        $sql = "select ANSWER from judge_list where ID='$judgeID[$i]' and ANSWER='$judgeAnswer[$i]'";
        $db->query($sql);
        if ($db->getrow()) {
            $score+=$config_exam["judge_sorce"];
        }
        $i++;
    }
    $userUpdate["SELECT_JUDGE"] = implode(",", $judgeAnswer);
}

//插入数据库
if (time() > ($userInfo["EXAM_END_TIME"] + 10 * 60)) {
    $userUpdate["STU_OTHER"] = "time_out";
}
$userUpdate["EXAM_PASS_TIME"] = time();
$userUpdate["STU_SCO"] = $score;
if ($db->update("stuinfo", $userUpdate, "ID=$userInfo[ID]")) {
    if (time() > ($userInfo["EXAM_END_TIME"] + 10 * 60)) {
        $message = "您的试卷已提交，但是系统检测到您的考试状态不正常。";
    } else {
        $message = "提交成功！";
    }
    setcookie("message", $message);
    header("Location: examleave.php ");
} else {
    echo '
	<script>
	alert("提交失败，请重试！");
	</script>
	';
}
?>