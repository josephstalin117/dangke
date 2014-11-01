<?php
require_once 'config/config.exam.php';
$action = isset($_GET["action"]) ? $_GET["action"] : '';
switch ($action) {
    case 1:
        ?>          
        <?php
        $videoID = isset($_GET["vid"]) ? $_GET["vid"] : '';
        if ($videoID) {
            $sql = "select * from video where 1=1 and ID='$videoID'";
            if ($db->query($sql)) {
                $videoPlay = $db->getrow();
                //CKPLAYER
                ?>
                <div class="title">正在播放</div>
                <div id="video" style="position:relative;z-index: 100;width:600px;height:400px; margin:0 auto;"><div id="a1"></div></div>
                <script type="text/javascript" src="js/jquery-1.4.2.min.js" mce_src="js/jquery-1.4.2.min.js"></script>
                <script type="text/javascript" src="ckplayer/ckplayer/ckplayer.js" charset="utf-8"></script>
                <script type="text/javascript">
                //如果你不需要某项设置，可以直接删除，注意var flashvars的最后一个值后面不能有逗号
                    var flashvars = {
                        f: '<?php echo $videoPlay["PATH"]; ?>', //视频地址 
                        c: '0', //是否读取文本配置,0不是，1是
                        e: '0',
                        b: 1
                    };
                    var params = {bgcolor: '#FFF', allowFullScreen: true, allowScriptAccess: 'always'};//这里定义播放器的其它参数如背景色（跟flashvars中的b不同），是否支持全屏，是否支持交互
                    var attributes = {id: 'ckplayer_a1', name: 'ckplayer_a1', menu: 'false'};
                //下面一行是调用播放器了，括号里的参数含义：（播放器文件，要显示在的div容器，宽，高，需要flash的版本，当用户没有该版本的提示，加载初始化参数，加载设置参数如背景，加载attributes参数，主要用来设置播放器的id）
                    swfobject.embedSWF('ckplayer/ckplayer/ckplayer.swf', 'a1', '600', '400', '10.0.0', 'ckplayer/ckplayer/expressInstall.swf', flashvars, params, attributes);
                    /*播放器地址，容器id，宽，高，需要flash插件的版本，flashvars,params,attributes
                     
                     下面三行是调用html5播放器用到的
                     var video='视频地址和类型';
                     var support='支持的平台或浏览器内核名称';	
                     */
                    var video = ['<?php echo $videoPlay["PATH"]; ?>', 'http://www.ckplayer.com/webm/0.webm->video/webm', 'http://www.ckplayer.com/webm/0.ogv->video/ogg'];
                    var support = ['iPad', 'iPhone', 'ios', 'android+false', 'msie10+false'];//默认的在ipad,iphone,ios设备中用html5播放,android,ie10上没有安装flash的也调用html5
                    CKobject.embedHTML5('video', 'ckplayer_a1', 600, 400, video, flashvars, support);

                    function playerstop() {
                        postdata();
                    }
                    function postdata() {
                        $.ajax({
                            type: "POST",
                            url: "saveschedule.php",
                            data: "videoid=<?php echo $videoPlay["ID"]; ?>"
                        });
                    }
                </script>
                <div style="width:500px;"><p>视频简介：</p><?php echo ($videoPlay["INTRO"] == '' ? "无" : $videoPlay["INTRO"]) ?></div>
                <?php
            } else {
                echo '找不到该视频';
            }
        }

        $sql = "select * from video where 1=1";
        $db->query($sql);
        echo '<div class="title">学习资料</div>';
        echo '<ul>';
        while ($video = $db->getrow()) {
            ?>
            <li style='float:left; text-anign:center; margin-left:5px; font-size:12px;height:208px; width:150px'>
                <a href="user.php?action=1&vid=<?php echo $video["ID"]; ?>"><img src="<?php echo $video["IMG"]; ?>" width="146" height="110" /></a>
                <p> 
                    <?php
                    echo $video["TITLE"] . '<br />';
                    if (in_array($video["ID"], explode(",", $userInfo["VIDEO_LEARNED"])))
                        echo "<font color='#00FF00'>(已学)</font>";
                    else
                        echo "<font color='#FF0000'>(未学)</font>";
                    ?>
                </p>
            </li>
            <?php
        }
        echo '</ul>';
        break;
    case 2: //个人信息
        ?>
        <div class="title">个人信息</div>
        <?php
        echo "姓名：$userInfo[STU_NAME]<br />";
        echo "学号：$userInfo[STU_NUM]<br />";
        echo "院系：$userInfo[STU_DEP]<br />";
        echo "成绩：";
        echo $userInfo["STU_SCO"] == NULL ? "无" : "$userInfo[STU_SCO]分";
        break;
    case 3: //修改密码
        ?>
        <div class="title">密码修改</div>
        <?php
        if (isset($_COOKIE["message"])) {
            echo '<font size="-1" color="#ff0000">' . $_COOKIE["message"] . '</font>';
            setcookie("message"); //删除cookie
        }
        ?>
        <form action="changepassword.php" method="post">
            <table>
                <tr><td>旧密码：</td><td><input type="password" maxlength="12" name="PSW_OLD" /></td></tr>
                <tr><td>新密码：</td><td><input type="password" maxlength="12" name="PSW_NEW1" />*密码长度为8-12位，只允许输入数字和字母</td></tr>
                <tr><td>确认新密码：</td><td><input type="password" maxlength="12" name="PSW_NEW2" />*密码长度为8-12位，只允许输入数字和字母</td></tr>
                <tr><td></td><td><input type="submit" style="width:70px; height:30px;" value="提交" /></td></tr></table>
        </form>
        <?php
        break;
    case 4://帮助
        ?>
        <div class="title">使用帮助</div>
        <p align="center"><font size="+3">系统使用说明</font></p>

        <p><center></center></p> 
        <p>1、党课学习考试系统分为学习和考试两个部分，只有首先完成所有学习内容的同学才可以参加考试！</p>
        <p>2、为了您能够顺利完成考试，参加考试之前请认真阅读考前须知内容。</p>
        <?php
        break;
    case 5: //开始考试
        ?>
        <div class="title">开始考试</div>
        <center><font size="+2">考前须知</font></center>
        <p>1、开始考试之前请完成规定的学习内容学习内容（要求：至少完整学习三个视频）。</p>
        <p>2、在线考试总分为100分，全部为选择题，共<?PHP echo ($config_exam['single_num'] + $config_exam['multi_num'] + $config_exam['judge_num']) ?>题。题目由系统随机抽取。</p>
        <p>3、考试总时间为<?php echo $config_exam["time"] ?>分钟，例如9:00开始考试，10:30系统自动提交提交（如果还停留在这个页面上），若不在页面上，时间到系统会自动提交但没有成绩，无法重新考试。</p>
        <p>4、若在线考试过程中遇到断网、机器故障等问题，可以通过其他机器登陆系统，若您尚未超过交卷时间，则可以继续考试，并且试卷和做题记录会自动恢复。若超过交卷时间，则无法继续考试。</p>

        <?php
//        $videoLearned = explode(",", $userInfo["VIDEO_LEARNED"]);
////        $sql = "select ID from video where 1=1";
//        if ((count($videoLearned) - 1) >= 3) {
//            //student's EXAM
//
//            if ($userInfo["EXAM_END_TIME"] == NULL) {
//                for ($n = 1; $n < 10; $n++) {
//                    //TO-do 已考完的章节不在此列
//                    //echo "<a href=exam_before.php?chapter='$n'>&gt;&gt;&gt;第'$n'章考试</a><br/>";
//                    echo "<a href=exam/examBefore.php?chapter='$n'>&gt;&gt;&gt;第'$n'章考试</a><br/>";
//                }
//            } else if ($userInfo["STU_SCO"] == NULL && time() < ($userInfo["EXAM_END_TIME"] + 600)) {
//                echo "<a href=selectexam.php>&gt;&gt;&gt;继续考试</a>";
//            } else if ($userInfo["STU_SCO"] == NULL && time() > ($userInfo["EXAM_END_TIME"] + 600)) {
//                echo '<font color="#FF0000">考试时间已到，无法继续考试！</font>';
//            }
//        } else {
//            echo '<font color="#FF0000">您还有未完成的学习内容，完成之后才能开始考试！</font>';
//        }
        $stuCheck = new stuCheck();

        //check the video learned
        $videoCheck = $stuCheck->videoCheck($userInfo["VIDEO_LEARNED"]);
        if ($videoCheck == FALSE) {
            $endTimeCheck = $stuCheck->endTimeCheck($userInfo["PAPER_MD5"], $db);
            //if end time exist
            if ($endTimeCheck === TRUE) {
                echo "<a href=exam/selectexam.php>&gt;&gt;&gt;继续考试</a>";
            } elseif ($endTimeCheck == FALSE) {
                $chap = $stuCheck->showChapter($userInfo["EXAM_CHAP"]);
                foreach ($chap as $key => $value) {
                    echo "<a href=exam/examBefore.php?chapter='$value'>&gt;&gt;&gt;第'$value'章考试</a><br/>";
                }
            } else {
                echo '<font color="#FF0000">' . $endTimeCheck . '</font></br>';
                $chap = $stuCheck->showChapter($userInfo["EXAM_CHAP"]);
                foreach ($chap as $key => $value) {
                    echo "<a href=exam/examBefore.php?chapter='$value'>&gt;&gt;&gt;第'$value'章考试</a><br/>";
                }
            }
        } else {
            echo '<font color="#FF0000">' . $videoCheck . '</font>';
        }

        break;
}

class stuCheck {

    function videoCheck($videoLearnd) {
        $videos = explode(",", $videoLearnd);
        try {
            if ((count($videos) - 1) >= 3) {
                return FALSE;
            } else {
                throw new Exception('您还有未完成的学习内容，完成之后才能开始考试！');
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function endTimeCheck($paperId, $db) {
        try {
            if ($paperId) {
                $sql = "select * from exam where PAPER_MD5='$paperId'";
                $db->query($sql);
                $exam = $db->getrow();
                if ($exam["EXAM_END_TIME"] != NULL) {
                    //continue exam
                    if ($exam["EXAM_SCORE"] == NULL && time() < ($exam["EXAM_END_TIME"] + 600)) {
                        return TRUE;
                    } elseif ($exam["EXAM_SCORE"] == NULL && time() >= ($exam["EXAM_END_TIME"] + 600)) {
                        throw new Exception("考试时间已到，无法继续考试！");
                    }
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    //show the chapter
    function showChapter($chapter) {
        try {
            $chapterComplete = explode(",", $chapter);
            $chapterAll = [1, 2, 3, 4, 5, 6, 7, 8, 9];
            $result = array_diff($chapterAll, $chapterComplete);
            if ($result) {
                return $result;
            } else {
                throw new Exception("您的考试已经全部完成");
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
?>