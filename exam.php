<?php
require_once 'logincheck.php';
require_once 'config/config.exam.php';
if ($userInfo["STU_SCO"] != NULL) {
    header("Location: user.php?action=5 ");
    exit();
}
if (!($userInfo["SINGLE_ID"] || $userInfo["MULTI_ID"] || $userInfo["JUDGE_ID"])) {
    header("Location: user.php?action=5 ");
    exit();
}

//取出题库
if ($userInfo['SINGLE_ID'])
    $single_id = explode(",", $userInfo["SINGLE_ID"]);
if ($userInfo['MULTI_ID'])
    $multi_id = explode(",", $userInfo["MULTI_ID"]);
if ($userInfo['JUDGE_ID'])
    $judge_id = explode(",", $userInfo["JUDGE_ID"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <LINK href="style.css" type=text/css rel=stylesheet>
        <title>考试页面</title>
        <script type="text/javascript">
            function showLocale()
            {
                var today;
                today = new Date();
                objD = today;
                var str, colorhead, colorfoot;
                var yy = objD.getYear();
                if (yy < 1900)
                    yy = yy + 1900;
                var MM = objD.getMonth() + 1;
                if (MM < 10)
                    MM = '0' + MM;
                var dd = objD.getDate();
                if (dd < 10)
                    dd = '0' + dd;
                var hh = objD.getHours();
                if (hh < 10)
                    hh = '0' + hh;
                var mm = objD.getMinutes();
                if (mm < 10)
                    mm = '0' + mm;
                var ss = objD.getSeconds();
                if (ss < 10)
                    ss = '0' + ss;
                var ww = objD.getDay();
                if (ww == 0)
                    colorhead = "<font color=\"#FF0000\">";
                if (ww > 0 && ww < 6)
                    colorhead = "<font color=\"#373737\">";
                if (ww == 6)
                    colorhead = "<font color=\"#008000\">";
                if (ww == 0)
                    ww = "星期日";
                if (ww == 1)
                    ww = "星期一";
                if (ww == 2)
                    ww = "星期二";
                if (ww == 3)
                    ww = "星期三";
                if (ww == 4)
                    ww = "星期四";
                if (ww == 5)
                    ww = "星期五";
                if (ww == 6)
                    ww = "星期六";
                colorfoot = "</font>"
                str = colorhead + "今天是：" + yy + "年" + MM + "月" + dd + "日" + " " + ww + colorfoot;
                document.writeln(str);
            }</script>
    <body>
        <iframe name="hidden" style="display:none;">

        </iframe>
        <!-- 顶部 -->
        <div class="top">
            <script type="text/javascript">showLocale();</script>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            剩余时间：
            <!--Time left-->
            <span id="time"></span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;欢迎您，<?php echo $userInfo["STU_NAME"]; ?>&nbsp;&nbsp;
            <a href="logout.php" onclick="if (!confirm('确定要离开当前页面？请务必在<?php echo date("Y-m-d H:i:s", $userInfo['EXAM_END_TIME']); ?>前再次登录并提交试卷，过期没有成绩！'))
                        return false;">退出</a>
        </div>
        <!-- 头部 -->
        <div class="head_img"></div>
        <!--正文-->
        <div class="contain">
            <div class="exam_page">
                <form id="exam" name="exam" method="post" target="hidden" action="examsubmit.php?paper=<?php echo $userInfo["PAPER_MD5"] ?>">
                    <?php
                    $title = array('一', '二', '三');
                    $titleCount = 0;
                    ?>
                    <?php if (isset($single_id)) { ?>
                        <?php echo $title[$titleCount++] ?>、单项选择题（每小题<?php echo $config_exam["single_sorce"]; ?>分，共<?php echo $config_exam["single_num"]; ?>题）。<br />
                        <?php
                        $inputID = 0;
                        $i = 0;
                        while ($single_id[$i]) {
                            $sql = "select * from single_selections where ID='$single_id[$i]'";
                            $db->query($sql);
                            $row = $db->getrow();
                            echo ($i + 1) . '、' . $row["QUESTION"] . '<br />';
                            echo "<input id=n$inputID type=\"radio\" name=\"single$i\" value=\"A\">&nbsp;A:&nbsp;$row[OPTION_A]<br />";
                            echo "<input id=n$inputID type=\"radio\" name=\"single$i\" value=\"B\">&nbsp;B:&nbsp;$row[OPTION_B]<br />";
                            echo "<input id=n$inputID type=\"radio\" name=\"single$i\" value=\"C\">&nbsp;C:&nbsp;$row[OPTION_C]<br />";
                            echo "<input id=n$inputID type=\"radio\" name=\"single$i\" value=\"D\">&nbsp;D:&nbsp;$row[OPTION_D]<br />";
                            echo "<br />";
                            $i++;
                            $inputID++;
                        }
                        ?>
                    <?php } ?>
                    <?php if (isset($multi_id)) { ?>
                        <?php echo $title[$titleCount++] ?>、选择题（本大题答案选项有可能是一个或者若干个，选错或者漏选不得分，每小题<?php echo $config_exam["multi_sorce"]; ?>分，共<?php echo $config_exam["multi_num"]; ?>题）。<br />
                        <?php
                        $i = 0;
                        $inputID = 0;
                        while ($multi_id[$i]) {
                            $sql = "select * from multi_selections where ID='$multi_id[$i]'";
                            $db->query($sql);
                            $row = $db->getrow();
                            echo ($i + 1) . '、' . $row["QUESTION"] . '<br />';
                            echo "<input id=n$inputID type=\"checkbox\" name=\"multi$i" . "[]\" value=\"A\">&nbsp;A:&nbsp;$row[OPTION_A]<br />";
                            echo "<input id=n$inputID type=\"checkbox\" name=\"multi$i" . "[]\" value=\"B\">&nbsp;B:&nbsp;$row[OPTION_B]<br />";
                            echo "<input id=n$inputID type=\"checkbox\" name=\"multi$i" . "[]\" value=\"C\">&nbsp;C:&nbsp;$row[OPTION_C]<br />";
                            echo "<input id=n$inputID type=\"checkbox\" name=\"multi$i" . "[]\" value=\"D\">&nbsp;D:&nbsp;$row[OPTION_D]<br />";
                            echo "<br />";
                            $i++;
                            $inputID++;
                        }
                    }
                    ?>
                    <?php if (isset($judge_id)) { ?>
                        <?php echo $title[$titleCount++] ?>、判断题（每小题<?php echo $config_exam["judge_sorce"]; ?>分，共<?php echo $config_exam["judge_num"]; ?>题）。<br />
                        <?php
                        $i = 0;
                        $inputID = 0;
                        while ($judge_id[$i]) {
                            $sql = "select * from judge_list where ID='$judge_id[$i]'";
                            $db->query($sql);
                            $row = $db->getrow();
                            echo ($i + 1) . '、' . $row["QUESTION"] . '<br />';
                            echo "<input id=n$inputID type=\"radio\" name=\"judge$i\" value=\"1\">&nbsp;对<br />";
                            echo "<input id=n$inputID type=\"radio\" name=\"judge$i\" value=\"0\">&nbsp;错<br />";
                            echo "<br />";
                            $i++;
                            $inputID++;
                        }
                        ?>
                    <?php } ?>
                    <input type="hidden" name="sure" value="1" />
                    <center><font size="-1" color="#FF0000">试卷提交后无法修改，请仔细检查后再交卷！</font></center>
                    <center><input type="submit" value="确认交卷" /></center>
                </form>
            </div>
        </div>



        <!--倒计时,保存进度-->
        <script type="text/javascript" src="js/jquery-1.4.2.min.js" mce_src="js/jquery-1.4.2.min.js"></script>
        <script LANGUAGE="javascript">
                //show time left
                var total = (<?php echo ($userInfo["EXAM_END_TIME"] - time()); ?>);
                var examNow = "";
                var examOld = "";
                //?
                var instal = 0;
                //?
                var examInstallStr = "";
<?php
//exam schedule 考试进度
if ($userInfo["EXAM_SCHEDULE"] != NULL) {
    echo "examInstallStr=\"$userInfo[EXAM_SCHEDULE]\";";
    echo "selectInstall();";
}
?>
                var installTime = new Date();
                var t0 = installTime.getTime();
                showTime();
                function showTime() {
                    total--;
                    var sec = total % 60;
                    var mins = parseInt(total / 60);
                    if (mins > 0) {
                        document.getElementById("time").innerHTML = mins + "分" + sec + "秒";
                    } else if (total >= 0) {
                        document.getElementById("time").innerHTML = sec + "秒";
                    } else {
                        document.getElementById("time").innerHTML = "时间到，正在提交！";
                    }
                    if (total > 0) {
                        //A check is performed every second
                        setTimeout("showTime()", 1000);
                        inputCheck();
                    } else {
                        document.exam.submit();
                    }
                }

                //save exam progress
                function inputCheck() {
                    examNow = '';
                    for (var i = 0; i < document.exam.length; i++) {
                        if (document.exam.elements[i].checked == true) {
                            examNow += "1";
                        } else {
                            examNow += "0";
                        }
                    }
                    if (instal == 0) {
                        examOld = examNow;
                        instal++;
                    }
                    if (examNow != examOld) {
                        postdata();
                    }
                    examOld = examNow;
                }

                //ajax
                function postdata() {
                    var str = "schedule=" + examNow;
                    $.ajax({
                        type: "POST",
                        url: "saveexamschedule.php",
                        data: str
                    });
                }

                function selectInstall() {
                    for (var i = 0; i < document.exam.length; i++) {
                        //examInstallStr.charAt(i);
                        if (examInstallStr.charAt(i) == "1")
                            document.exam.elements[i].checked = true;
                    }
                }
        </script>
    </body>
</html>