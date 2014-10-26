<?php

//error_reporting(0);
Class DB {

    private $link_id;
    private $handle;
    private $is_log;
    private $time;

    //构造函数
    public function __construct() {
        $this->time = $this->microtime_float();
        require_once("config.db.php");
        $this->connect($db_config["hostname"], $db_config["username"], $db_config["password"], $db_config["database"], $db_config["pconnect"]);
        $this->is_log = $db_config["log"];
        if ($this->is_log) {
            $handle = fopen($db_config["logfilepath"] . "dblog.txt", "a+");
            $this->handle = $handle;
        }
    }

    //数据库连接
    public function connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect = 0, $charset = 'utf8') {
        if ($pconnect == 0) {
            //mysql_connect($dbhost, $dbuser, $dbpw, true);
            $this->link_id = @mysql_connect($dbhost, $dbuser, $dbpw, true);
            if (!$this->link_id) {
                $this->halt("数据库连接失败");
            }
        } else {
            $this->link_id = @mysql_pconnect($dbhost, $dbuser, $dbpw);
            if (!$this->link_id) {
                $this->halt("数据库持久连接失败");
            }
        }
        if (!@mysql_select_db($dbname, $this->link_id)) {
            $this->halt('数据库选择失败');
        }
        //else $this->halt('数据库选择成功');
        @mysql_query("set names " . $charset);
    }

    //查询 
    public function query($sql) {
        $this->write_log("查询 " . $sql);
        if ($this->result = mysql_query($sql, $this->link_id))
        //if(!$query) $this->halt('Query Error: ' . $sql);
            return $this->result;
    }

    public function getrow() { //创建一个向前的结果集指针 
        $this->row = mysql_fetch_array($this->result);
        return $this->row;
    }

    //插入
    public function insert($table, $dataArray) {
        $field = "";
        $value = "";
        if (!is_array($dataArray) || count($dataArray) <= 0) {
            $this->halt('没有要插入的数据');
            return false;
        }
        while (list($key, $val) = each($dataArray)) {
            $field .="$key,";
            $value .="'$val',";
        }
        $field = substr($field, 0, -1);
        $value = substr($value, 0, -1);
        $sql = "insert into $table($field) values($value)";
        $this->write_log("插入 " . $sql);
        if (!$this->query($sql))
            return false;
        return true;
    }

    //update sql array
    public function update($table, $dataArray, $condition = "") {
        if (!is_array($dataArray) || count($dataArray) <= 0) {
            $this->halt('没有要更新的数据');
            return false;
        }
        $value = "";
        while (list($key, $val) = each($dataArray)) {
            if ($val == 0)
                $val = null;
            //echo $val;
            $value .= "$key = '$val',";
        }
        $value = substr($value, 0, -1);
        //echo $value.'<br/>';
        $sql = "update $table set $value where 1=1 and $condition";
        $this->write_log("更新 " . $sql);
        if (!$this->query($sql)) {
            return false;
        } else {
            return true;
        }
    }

    //删除
    public function delete($table, $condition = "") {
        if (empty($condition)) {
            $this->halt('没有设置删除的条件');
            return false;
        }
        $sql = "delete from $table where 1=1 and $condition";
        $this->write_log("删除 " . $sql);
        if (!$this->query($sql))
            return false;
        return true;
    }

    //返回结果集
    public function fetch_array($query, $result_type = MYSQL_ASSOC) {
        $this->write_log("返回结果集");
        return mysql_fetch_array($query, $result_type);
    }

    //获取记录条数
    public function num_rows($results) {
        if (!is_bool($results)) {
            $num = mysql_num_rows($results);
            $this->write_log("获取的记录条数为" . $num);
            return $num;
        } else {
            return 0;
        }
    }

    //释放结果集
    public function free_result() {
        $void = func_get_args();
        foreach ($void as $query) {
            if (is_resource($query) && get_resource_type($query) === 'mysql result') {
                return mysql_free_result($query);
            }
        }
        $this->write_log("释放结果集");
    }

    //获取最后插入的id
    public function insert_id() {
        $id = mysql_insert_id($this->link_id);
        $this->write_log("最后插入的id为" . $id);
        return $id;
    }

    //关闭数据库连接
    public function close() {
        $this->write_log("已关闭数据库连接");
        return @mysql_close($this->link_id);
    }

    //错误提示
    public function halt($msg = '') {
        $msg .= "\r\n" . mysql_error();
        $this->write_log($msg);
        die($msg);
    }

    //析构函数
    public function __destruct() {
        $this->free_result();
        $use_time = ($this->microtime_float()) - ($this->time);
        $this->write_log("完成整个查询任务,所用时间为" . $use_time);
        if ($this->is_log) {
            fclose($this->handle);
        }
    }

    //写入日志文件
    public function write_log($msg = '') {
        if ($this->is_log) {
            $text = date("Y-m-d H:i:s") . " " . $msg . "\r\n";
            fwrite($this->handle, $text);
        }
    }

    //获取毫秒数
    public function microtime_float() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    //将结果以表格的形式显示
    //两个数组举例
    /* $fieldArr=array(
      'STU_NUM'=>'学号',
      'STU_NAME'=>'姓名',
      'STU_DEP'=>'院系（部门）',
      'STU_SCO'=>'成绩'
      );
      $fieldStyle=array(
      '学号'=>'width=100',
      '姓名'=>'width=100',
      '院系（部门）'=>'width=100',
      '成绩'=>'width=100'
      ); */
    public function DataToTable($table = '', $fieldArr, $condition = '', $tableStyle = '', $fieldStyle) {
        while (list($key, $val) = each($fieldArr)) {
            $field.=$key . ",";
            $field_[] = $key;
            $name[] = $val;
        }

        $field = substr($field, 0, -1);
        $sql = "select $field from $table $condition";
        $this->query($sql);
        echo '<table ' . $tableStyle . '><tr>';
        foreach ($name as $title)
            echo '<td ' . $fieldStyle[$title] . '>' . $title . '</td>';
        echo '</tr>';
        while ($this->getrow()) {
            echo '<tr>';
            foreach ($field_ as $name)
                echo '<td>' . $this->row[$name] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    //带有复选框,其余同上
    public function DataToTableWithCheck($table = '', $fieldArr, $condition = '', $tableStyle = '', $fieldStyle) {
        while (list($key, $val) = each($fieldArr)) {
            $field.=$key . ",";
            $field_[] = $key;
            $name[] = $val;
        }
        $field = substr($field, 0, -1);
        $sql = "select * from $table $condition";
        $this->query($sql);
        echo '<table ' . $tableStyle . '><tr>';
        echo '<td></td>';
        foreach ($name as $title)
            echo '<td ' . $fieldStyle[$title] . '>' . $title . '</td>';
        echo '</tr>';
        while ($this->getrow()) {
            echo '<tr>';
            echo '<td width="20"><input type=checkbox name=checkbox[] value="' . $this->row[ID] . '" /></td>';
            foreach ($field_ as $name)
                echo '<td align="center">' . $this->row[$name] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

}

?>
