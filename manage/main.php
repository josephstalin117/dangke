<?php
$action = isset($_GET["action"]) ? $_GET["action"] : '';
switch ($action) {
    case 1:
        require_once 'usermanage.php';
        break;
    case 2:
        require_once 'videomanage.php';
        break;
    case 4:

        break;
    case 3: //帮助
        echo '<div class="title">修改密码</div>';
        ?>
        <?php
        if (isset($_COOKIE["message"])) {
            echo '<font size="-1" color="#ff0000">' . $_COOKIE["message"] . '</font>';
            setcookie("message"); //删除cookie
        }
        ?>
        <form action="changepassword.php" method="post">
            <table><tr>
                    <td>旧密码：</td><td><input type="password" maxlength="12" name="PSW_OLD" /></td></tr>
                <tr><td>新密码：</td><td><input type="password" maxlength="12" name="PSW_NEW1" />*密码长度为8-12位，只允许输入数字和字母</td></tr>
                <tr><td>确认新密码：</td><td><input type="password" maxlength="12" name="PSW_NEW2" />*密码长度为8-12位，只允许输入数字和字母</td></tr>
                <tr><td></td><td><input type="submit" style="width:70px; height:30px;" value="提交" /></td></tr></table>
        </form>
        <?php
        break;
    case 5:
        require_once 'updownfile.php';
        break;
    case 6:
        require_once 'useradd.php';
        break;
    case "help":
        require_once 'help.php';
        break;
    case "uploadvideo":
        require_once 'uploadvideo.php';
        break;
    case "systemoption":
        require_once 'systemoption.php';
        break;
    case "paper":
        require_once 'paper.php';
        break;
    case "paperedit":
        require_once 'paperedit.php';
        break;
    case "paperadd":
        require_once 'paperadd.php';
        break;
    default:
        break;
}
?>