<?php
require_once 'logincheck.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <LINK href="style.css" type=text/css rel=stylesheet>
        <title>用户中心</title>
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
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
        <!-- 顶部 -->
        <div class="top">
            <script type="text/javascript">showLocale();</script>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            欢迎您，<?php echo $userInfo["STU_NAME"]; ?>&nbsp;&nbsp;
            <a href="logout.php">退出</a>
        </div>
        <div class="head_img"></div>
        <div class="contain">
            <!-- 侧栏   -->
            <div class="sideBar">
                <div class="menu">
                    <ul>
                        <li>
                            <a href="user.php?action=1">学习资料</a>
                        </li>
                        <li>
                            <a href="user.php?action=5">开始考试</a>
                        </li>
                        <li>
                            <a href="user.php?action=2">个人信息</a>
                        </li>
                        <li>
                            <a href="user.php?action=3">密码修改</a>
                        </li>
                        <li>
                            <a href="user.php?action=4">使用帮助</a>
                        </li>
                    </ul>
                </div><!-- end of menu -->
            </div><!-- end of sideBar -->
            <!-- 内容   -->
            <div>
            </div><!-- end of contain -->
            <div class="main">
                <?php
                require_once 'main.php';
                ?>
            </div><!-- end of main -->
        </div><!-- end of contain -->


    </body>
</html>
