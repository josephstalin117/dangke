<?phpinclude 'config/config.db.php';require_once 'config/config.exam.php';require_once 'config/config.system.php';if($config_system["exam_end_time"]<time()) {echo '<script>alert("考试时间已经结束"); history.back();</script>';exit();}echo '<a href="user.php?action=5">取消考试</a><br />';echo '�������ĵ�ǰʱ����'.date("Y-m-d H:i").'�����Կ�ʼ֮���������'.date("Y-m-d H:i",time()+60*90).'֮ǰ�ύ�Ծ�����û�гɼ���<br />';echo '<a href="selectexam.php" >&gt;&gt;&gt;��ʼ����</a>';?>