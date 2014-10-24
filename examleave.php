<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
    </head>

    <body>
        <script language="javascript">
            alert("<?php
if (isset($_COOKIE["message"])) {
    echo $_COOKIE["message"];
    setcookie("message"); //删除cookie
}
?> ");
            top.location = 'user.php?action=1';
        </script>
    </body>
</html>