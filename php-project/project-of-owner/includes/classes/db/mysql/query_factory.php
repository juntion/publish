<?php

/**
 * MySQL query_factory Class.
 * Class used for database abstraction to MySQL
 *
 * @package classes
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: query_factory.php 17549 2010-09-12 17:35:32Z drbyte $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
/*后台用peter注释
if(file_exists(DIR_WS_CLASSES.'monitorSqlDynamicClass.php')){
    require_once DIR_WS_CLASSES.'monitorSqlDynamicClass.php';
}*/

/**
 * Queryfactory - A simple database abstraction layer
 */
class queryFactory extends base
{

    protected $total_query_time;
    protected $count_queries;
    // protected $monitorClass;
    protected $link = false;
    protected $linkRead = false;
    protected $dbLink = false;
    protected $connectType = 1;//1是写库，2是读库
    protected $dbConnectedStatus = false;
    protected $hasWrite = false;//是否操作过写库，默认否
    protected $enable = DB_READ_SERVER_ENABLE;//是否开启读写分离

    protected $database;
    protected $user;
    protected $host;
    protected $password;
    protected $pConnect;
    protected $real;

    function queryFactory()
    {
        $this->count_queries = 0;
        $this->total_query_time = 0;
        //$this->monitorClass = new \classes\monitorSqlDynamicClass();
    }

    function disable()
    {
        $this->enable = false;
    }

    function enable()
    {
        $this->enable = true;
    }

    function connect($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect = 'false', $zp_real = false,$connectType = 0)
    {
        $otherdb = [C_DB_SERVER,CN_DB_SERVER,US_DB_SERVER];
        if(!in_array($zf_host,$otherdb) && !$this->hasWrite && $this->enable) {
            if ($connectType === 0) {
                //写连接
                $this->database = $zf_database;
                $this->user = $zf_user;
                $this->host = $zf_host;
                $this->password = $zf_password;
                $this->pConnect = $zf_pconnect;
                $this->real = $zp_real;
                if(@rand(1,3) == 1 && false){
                    //默认使用写库
                    $bool = $this->connectWriteDb($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect, $zp_real);
                    if($_GET['dbDebug'])var_dump('默认连接【写库】成功<br/>');
                }else{
                    //默认使用读库
                    $bool = $this->connectDb(DB_SERVER_READ, DB_SERVER_USERNAME_READ, DB_SERVER_PASSWORD_READ, DB_DATABASE_READ, $zf_pconnect, $zp_real,2);
                    $this->dbLink = $this->linkRead;
                    $this->connectType = 2;
                    if($_GET['dbDebug'])var_dump('默认连接【读库】成功<br/>');
                    if($bool){
                        if($_GET['dbDebug'])var_dump('默认连接【读库】成功<br/>');
                        //判断读库数据同步状态
                        $result = @mysqli_query( $this->linkRead, "show slave status");
                        if($result){
                            $row = @mysqli_fetch_assoc($result);
                            $SlaveIoRunning = isset($row['Slave_IO_Running']) ? $row['Slave_IO_Running'] : '';
                            $SlaveSqlRunning = isset($row['Slave_SQL_Running']) ? $row['Slave_SQL_Running'] : '';
                            $SecondsBehindMaster = isset($row['Seconds_Behind_Master']) ? (int)$row['Seconds_Behind_Master'] : 0;
                            if($_GET['dbDebug'] && empty($row))var_dump('没有配置同步<br/>');
                        }else{
                            //没有查询权限
                            $SlaveIoRunning = '';
                            $SlaveSqlRunning = '';
                            $SecondsBehindMaster = 0;
                            if($_GET['dbDebug'])var_dump('账号没有权限<br/>');
                        }
                        if ($SlaveIoRunning != 'Yes' || $SlaveSqlRunning != 'Yes' || $SecondsBehindMaster > 0) {
                            //同步失败，关闭读库连接，使用写库
                            $this->closeRead();
                            $bool = $this->connectWriteDb($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect, $zp_real);
                            if ($SlaveIoRunning != 'Yes' || $SlaveSqlRunning != 'Yes'){
                                if($_GET['dbDebug'])var_dump('【读库】同步失败<br/>');
                            }else{
                                if($_GET['dbDebug'])var_dump('【读库】存在同步锁表等情况<br/>');
                            }
                            if($_GET['dbDebug']){if ($bool) var_dump('切换【写库】成功<br/>'); else var_dump('切换【写库】失败<br/>');}
                        }else{
                            if($_GET['dbDebug'])var_dump('【读库】同步成功<br/>');
                        }
                    }else{
                        if($_GET['dbDebug'])var_dump('默认连接【读库】失败<br/>');
                        //连接读库失败，使用写库
                        $bool = $this->connectWriteDb($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect, $zp_real);
                        if($_GET['dbDebug']){if ($bool) var_dump('切换【写库】成功<br/>'); else var_dump('切换【写库】失败<br/>');}
                    }
                }
                if($_GET['dbDebug'])die;
            } elseif ($connectType === 2) {
                //读库重连
                $bool = $this->connectDb(DB_SERVER_READ, DB_SERVER_USERNAME_READ, DB_SERVER_PASSWORD_READ, DB_DATABASE_READ, $zf_pconnect, $zp_real,2);
                $this->dbLink = $this->linkRead;
            } else {
                //写库重连
                $bool = $this->connectDb($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect, $zp_real,1);
                $this->dbLink = $this->link;
            }
            $this->dbConnectedStatus = $bool;
            return $bool;
        }else{
            $bool = $this->connectDb($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect, $zp_real,1);
            $this->dbConnectedStatus = $bool;
            $this->enable = false;
            $this->linkRead = $this->link;
            $this->dbLink = $this->link;
            return $this->dbConnectedStatus;
        }
    }

    /**
     * 默认连接写库
     * @param $zf_host
     * @param $zf_user
     * @param $zf_password
     * @param $zf_database
     * @param $zf_pconnect
     * @param $zp_real
     *
     * @return bool
     */
    function connectWriteDb($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect, $zp_real)
    {
        $bool = $this->connectDb($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect, $zp_real,1);
        $this->dbLink = $this->link;
        $this->connectType = 1;
        $this->enable = false;
        $this->hasWrite = true;
        return $bool;
    }

    /**
     * 连接数据库
     * @param        $zf_host
     * @param        $zf_user
     * @param        $zf_password
     * @param        $zf_database
     * @param string $zf_pconnect
     * @param bool   $zp_real
     * @param int   $type
     *
     * @return bool
     */
    function connectDb($zf_host, $zf_user, $zf_password, $zf_database, $zf_pconnect = 'false', $zp_real = false,$type = 1)
    {
        $link = null;
        if (!function_exists('mysqli_connect')) die ('Call to undefined function: mysql_connect().  Please install the MySQL Connector for PHP');
        //读连接
        /*$connectionRetry = 10;
        while (!isset($this->linkRead) || ($this->linkRead == FALSE && $connectionRetry != 0)) {
            $this->linkRead = @mysql_connect($zf_host, $zf_user, $zf_password, true);
            $connectionRetry--;
        }*/

        $port = 13307;
        //链接数据库  连不上就拉倒
        if(strpos($zf_host, ":") !== false){
            $explode = explode(':', $zf_host);
            $zf_host = $explode[0];
            $port = $explode[1] ? $explode[1] : 13307;
        }
        $link = @mysqli_connect($zf_host, $zf_user, $zf_password, $zf_database,$port);

        if ($link) {
            if (@mysqli_select_db($link, $zf_database)) {
                if (defined('DB_CHARSET') && version_compare(@mysqli_get_server_info($link), '4.1.0', '>=')) {
                    @mysqli_query($link,"SET NAMES '" . DB_CHARSET . "'");
                    if (function_exists('mysqli_set_charset')) {
                        @mysqli_set_charset($link,DB_CHARSET);
                        @mysqli_query($link,"SET NAMES '" . DB_CHARSET . "'");
                    } else {
                        @mysqli_query($link,"SET NAMES '" . DB_CHARSET . "'");
                    }
                }
                if($type == 1){
                    $this->link = $link;
                }else{
                    $this->linkRead = $link;
                }
                return true;
            } else {
                $this->set_error(mysqli_errno($link), mysqli_error($link), $zp_real);
                return false;
            }
        } else {
            $this->set_error(mysqli_errno($link), mysqli_error($link), $zp_real);
            return false;
        }
    }

    public function getDbStatus()
    {
        return [
            $this->connectType,
            $this->dbConnectedStatus,
            $this->hasWrite,
            $this->enable
        ];
    }

    /**
     * 此函数未调用
     * 选择数据库
     * @param $zf_database
     */
    function selectdb($zf_database)
    {
        @mysqli_select_db($zf_database, $this->dbLink);
    }

    function prepare_input($zp_string)
    {
        if (function_exists('mysqli_real_escape_string')) {
            return mysqli_real_escape_string( $this->dbLink, $zp_string);
        } elseif (function_exists('mysqli_escape_string')) {
            return mysqli_escape_string( $this->dbLink, $zp_string);
        } else {
            return addslashes($zp_string);
        }
    }

    /**
     * 关闭数据库链接
     */
    function close()
    {
        $this->closeRead();
        $this->closeWrite();
    }
    function closeRead()
    {
        if(!empty($this->linkRead)){
            @mysqli_close($this->linkRead);
        }
    }
    function closeWrite()
    {
        if(!empty($this->link)) {
            @mysqli_close($this->link);
        }
    }

    function set_error($zp_err_num, $zp_err_text, $zp_fatal = true)
    {
        $this->error_number = $zp_err_num;
        $this->error_text = $zp_err_text;
        if ($zp_fatal && $zp_err_num != 1141) { // error 1141 is okay ... should not die on 1141, but just continue on instead
            $this->show_error();
            die();
        }
    }

    function show_error()
    {
        if ($this->error_number == 0 && $this->error_text == DB_ERROR_NOT_CONNECTED && !headers_sent() && file_exists('nddbc.html')) include('nddbc.html');
        echo '<div class="systemError">';
        echo $this->error_number . ' ' . $this->error_text;
        echo '<br />in:<br />[' . (strstr($this->zf_sql, 'db_cache') ? 'db_cache table' : $this->zf_sql) . ']<br />';
        if (defined('IS_ADMIN_FLAG') && IS_ADMIN_FLAG == true) echo 'If you were entering information, press the BACK button in your browser and re-check the information you had entered to be sure you left no blank fields.<br />';
        echo '</div>';
    }

    function Execute($zf_sql, $zf_limit = false, $zf_cache = false, $zf_cachetime = 600)
    {
        // bof: collect database queries
        if (defined('STORE_DB_TRANSACTIONS') && STORE_DB_TRANSACTIONS == 'true') {
            global $PHP_SELF, $box_id, $current_page_base;
            if (strtoupper(substr($zf_sql, 0, 6)) == 'SELECT' /*&& strstr($zf_sql,'products_id')*/) {
                $f = @fopen(DIR_FS_SQL_CACHE . '/query_selects_' . $current_page_base . '_' . time() . '.txt', 'a');
                if ($f) {
                    fwrite($f, "\n\n" . 'I AM HERE ' . $current_page_base . /*zen_get_all_get_params() .*/
                        "\n" . 'sidebox: ' . $box_id . "\n\n" . "Explain \n" . $zf_sql . ";\n\n");
                    fclose($f);
                }
                unset($f);
            }
        }
        // eof: collect products_id queries
        global $zc_cache;
        if ($zf_limit) {
            $zf_sql = $zf_sql . ' LIMIT ' . $zf_limit;
        }
        $this->zf_sql = $zf_sql;

        //判断使用读库还是写库
        $this->chooseDbLink($zf_sql);

        if ($zf_cache AND $zc_cache->sql_cache_exists($zf_sql) AND !$zc_cache->sql_cache_is_expired($zf_sql, $zf_cachetime)) {
            $obj = new queryFactoryResult;
            $obj->cursor = 0;
            $obj->is_cached = true;
            $obj->sql_query = $zf_sql;
            $zp_result_array = $zc_cache->sql_cache_read($zf_sql);
            $obj->result = $zp_result_array;
            if ($zp_result_array && sizeof($zp_result_array) > 0) {
                $obj->EOF = false;
                while (list($key, $value) = each($zp_result_array[0])) {
                    $obj->fields[$key] = $value;
                }
                return ($obj);
            } else {
                $obj->EOF = true;
                return ($obj);
            }
        } elseif ($zf_cache) {
            $zc_cache->sql_cache_expire_now($zf_sql);
            $time_start = explode(' ', microtime());
            $obj = new queryFactoryResult;
            $obj->sql_query = $zf_sql;
            if (!$this->dbConnectedStatus) {
                if (!$this->connect($this->host, $this->user, $this->password, $this->database, $this->pConnect, $this->real,$this->connectType))
                    $this->set_error('0', DB_ERROR_NOT_CONNECTED);
            }

            $zp_db_resource = @mysqli_query($this->dbLink, $zf_sql);
            if (!$zp_db_resource) $this->set_error(@mysqli_errno($this->dbLink), @mysqli_error($this->dbLink));
            if (!($zp_db_resource instanceof mysqli_result)) {
                $obj = null;
                /*if($this->monitorClass->executeSqlHandle($zf_sql)){
                    $this->monitorClass->recoredData();
                }*/
                return true;
            }
            $obj->resource = $zp_db_resource;
            $obj->cursor = 0;
            $obj->is_cached = true;
            if ($obj->RecordCount() > 0) {
                $obj->EOF = false;
                $zp_ii = 0;
                while (!$obj->EOF) {
                    $zp_result_array = @mysqli_fetch_array($zp_db_resource);
                    if ($zp_result_array) {
                        while (list($key, $value) = each($zp_result_array)) {
                            if (!preg_match('/^[0-9]/', $key)) {
                                $obj->result[$zp_ii][$key] = $value;
                            }
                        }
                    } else {
                        $obj->Limit = $zp_ii;
                        $obj->EOF = true;
                    }
                    $zp_ii++;
                }
                while (list($key, $value) = each($obj->result[$obj->cursor])) {
                    if (!preg_match('/^[0-9]/', $key)) {
                        $obj->fields[$key] = $value;
                    }
                }
                $obj->EOF = false;
            } else {
                $obj->EOF = true;
            }
            $zc_cache->sql_cache_store($zf_sql, $obj->result, $zf_cachetime);
            $time_end = explode(' ', microtime());
            $query_time = $time_end[1] + $time_end[0] - $time_start[1] - $time_start[0];
            $this->total_query_time += $query_time;
            $this->count_queries++;
            return ($obj);
        } else {
            $time_start = explode(' ', microtime());
            $obj = new queryFactoryResult;
            if (!$this->dbConnectedStatus) {
                if (!$this->connect($this->host, $this->user, $this->password, $this->database, $this->pConnect, $this->real,$this->connectType))
                    $this->set_error('0', DB_ERROR_NOT_CONNECTED);
            }

            $zp_db_resource = @mysqli_query($this->dbLink, $zf_sql);
            if (!$zp_db_resource) {
                if (@mysqli_errno($this->dbLink) == 2006) {
                    if($this->connectType === 2) {
                        $this->linkRead = FALSE;
                    }else{
                        $this->link = FALSE;
                    }
                    $this->dbLink = FALSE;
                    $this->connect($this->host, $this->user, $this->password, $this->database, $this->pConnect, $this->real,$this->connectType);
                    $zp_db_resource = @mysqli_query($this->dbLink, $zf_sql);
                }
                if (!$zp_db_resource) {
                    $this->set_error(@mysqli_errno($this->dbLink), @mysqli_error($this->dbLink));
                }
            }
            if (!($zp_db_resource instanceof mysqli_result)) {
                $obj = null;
                /*if($this->monitorClass->executeSqlHandle($zf_sql)){
                    $this->monitorClass->recoredData();
                }*/
                return true;
            }
            $obj->resource = $zp_db_resource;
            $obj->cursor = 0;
            if ($obj->RecordCount() > 0) {
                $obj->EOF = false;
                $zp_result_array = @mysqli_fetch_array($zp_db_resource);
                if ($zp_result_array) {
                    while (list($key, $value) = each($zp_result_array)) {
                        if (!preg_match('/^[0-9]/', $key)) {
                            $obj->fields[$key] = $value;
                        }
                    }
                    $obj->EOF = false;
                } else {
                    $obj->EOF = true;
                }
            } else {
                $obj->EOF = true;
            }

            $time_end = explode(' ', microtime());
            $query_time = $time_end[1] + $time_end[0] - $time_start[1] - $time_start[0];
            $this->total_query_time += $query_time;
            $this->count_queries++;
            return ($obj);
        }
    }

    function query($sql)
    {
        //判断使用读库还是写库
        $this->chooseDbLink($sql);

        $result = mysqli_query($this->dbLink, $sql);
        if($result){
            /*if($this->monitorClass->executeSqlHandle($sql)){
                $this->monitorClass->recoredData();
            }*/
        }
        return $result;
    }

    function getAll($sql)
    {
        $result = $this->query($sql);
        if ($result) {
            $info = array();
            while ($asc = mysqli_fetch_assoc($result)) {
                $info[] = $asc;
            }
            return $info;
        }
    }

    function ExecuteRandomMulti($zf_sql, $zf_limit = 0, $zf_cache = false, $zf_cachetime = 0)
    {
        $this->zf_sql = $zf_sql;
        //判断使用读库还是写库
        $this->chooseDbLink($zf_sql);

        $time_start = explode(' ', microtime());
        $obj = new queryFactoryResult;
        $obj->result = array();
        if (!$this->dbConnectedStatus) {
            if (!$this->connect($this->host, $this->user, $this->password, $this->database, $this->pConnect, $this->real,$this->connectType))
                $this->set_error('0', DB_ERROR_NOT_CONNECTED);
        }
        $zp_db_resource = @mysqli_query($this->dbLink, $zf_sql);
        if (!$zp_db_resource) $this->set_error(mysqli_errno($this->dbLink), mysqli_error($this->dbLink));
        if (!($zp_db_resource instanceof mysqli_result)) {
            $obj = null;
            return true;
        }
        $obj->resource = $zp_db_resource;
        $obj->cursor = 0;
        $obj->Limit = $zf_limit;
        if ($obj->RecordCount() > 0 && $zf_limit > 0) {
            $obj->EOF = false;
            $zp_Start_row = 0;
            if ($zf_limit) {
                $zp_start_row = zen_rand(0, $obj->RecordCount() - $zf_limit);
            }
            $obj->Move($zp_start_row);
            $obj->Limit = $zf_limit;
            $zp_ii = 0;
            while (!$obj->EOF) {
                $zp_result_array = @mysqli_fetch_array($zp_db_resource);
                if ($zp_ii == $zf_limit) $obj->EOF = true;
                if ($zp_result_array) {
                    while (list($key, $value) = each($zp_result_array)) {
                        $obj->result[$zp_ii][$key] = $value;
                    }
                } else {
                    $obj->Limit = $zp_ii;
                    $obj->EOF = true;
                }
                $zp_ii++;
            }
            $obj->result_random = array_rand($obj->result, sizeof($obj->result));
            if (is_array($obj->result_random)) {
                $zp_ptr = $obj->result_random[$obj->cursor];
            } else {
                $zp_ptr = $obj->result_random;
            }
            while (list($key, $value) = each($obj->result[$zp_ptr])) {
                if (!preg_match('/^[0-9]/', $key)) {
                    $obj->fields[$key] = $value;
                }
            }
            $obj->EOF = false;
        } else {
            $obj->EOF = true;
        }


        $time_end = explode(' ', microtime());
        $query_time = $time_end[1] + $time_end[0] - $time_start[1] - $time_start[0];
        $this->total_query_time += $query_time;
        $this->count_queries++;
        return ($obj);
    }

    /**
     * @return int
     */
    function insert_ID()
    {
        //获取insert_id直接使用写连接
        return @mysqli_insert_id($this->link);
    }

    function metaColumns($zp_table)
    {
        $sql = "select * from " . $zp_table . " limit 1";
        //判断使用读库还是写库
        $this->chooseDbLink($sql);

        $res = @mysqli_query($this->dbLink, $sql);
        $num_fields = @mysqli_num_fields($res);
        for ($i = 0; $i < $num_fields; $i++) {
// BOM by zen-cart.cn
            $info = mysqli_fetch_field_direct($res, $i);
            $obj[GBcase($info->name, "upper")] = new queryFactoryMeta($i, $res);
// EOM by zen-cart.cn
        }
        return $obj;
    }

    /**
     * 此函数未使用过
     * @return string
     */
    function get_server_info()
    {
        //TODO 区分读写连接
        if ($this->link) {
            return mysqli_get_server_info($this->link);
        } else {
            return UNKNOWN;
        }
    }

    function queryCount()
    {
        return $this->count_queries;
    }

    function queryTime()
    {
        return $this->total_query_time;
    }

    function perform($tableName, $tableData, $performType = 'INSERT', $performFilter = '', $debug = false)
    {
        switch (strtolower($performType)) {
            case 'insert':
                $insertString = "";
                $insertString = "INSERT INTO " . $tableName . " (";
                foreach ($tableData as $key => $value) {
                    if ($debug === true) {
                        echo $value['fieldName'] . '#';
                    }
                    $insertString .= $value['fieldName'] . ", ";
                }
                $insertString = substr($insertString, 0, strlen($insertString) - 2) . ') VALUES (';
                reset($tableData);
                foreach ($tableData as $key => $value) {
                    $bindVarValue = $this->getBindVarValue($value['value'], $value['type']);
                    $insertString .= $bindVarValue . ", ";
                }
                $insertString = substr($insertString, 0, strlen($insertString) - 2) . ')';
                if ($debug === true) {
                    echo $insertString;
                    die();
                } else {
                    $this->execute($insertString);
                }
                break;
            case 'update':
                $updateString = "";
                $updateString = 'UPDATE ' . $tableName . ' SET ';
                foreach ($tableData as $key => $value) {
                    $bindVarValue = $this->getBindVarValue($value['value'], $value['type']);
                    $updateString .= $value['fieldName'] . '=' . $bindVarValue . ', ';
                }
                $updateString = substr($updateString, 0, strlen($updateString) - 2);
                if ($performFilter != '') {
                    $updateString .= ' WHERE ' . $performFilter;
                }
                if ($debug === true) {
                    echo $updateString;
                    die();
                } else {
                    $this->execute($updateString);
                }
                break;
        }
    }

    function getBindVarValue($value, $type)
    {
        $typeArray = explode(':', $type);
        $type = $typeArray[0];
        switch ($type) {
            case 'csv':
                return $value;
                break;
            case 'passthru':
                return $value;
                break;
            case 'float':
                return (!zen_not_null($value) || $value == '' || $value == 0) ? 0 : $value;
                break;
            case 'integer':
                return (int)$value;
                break;
            case 'string':
                if (isset($typeArray[1])) {
                    $regexp = $typeArray[1];
                }
                return '\'' . $this->prepare_input($value) . '\'';
                break;
            case 'noquotestring':
                return $this->prepare_input($value);
                break;
            case 'currency':
                return '\'' . $this->prepare_input($value) . '\'';
                break;
            case 'date':
                return '\'' . $this->prepare_input($value) . '\'';
                break;
            case 'enum':
                if (isset($typeArray[1])) {
                    $enumArray = explode('|', $typeArray[1]);
                }
                return '\'' . $this->prepare_input($value) . '\'';
            case 'regexp':
                $searchArray = array('[', ']', '(', ')', '{', '}', '|', '*', '?', '.', '$', '^');
                foreach ($searchArray as $searchTerm) {
                    $value = str_replace($searchTerm, '\\' . $searchTerm, $value);
                }
                return $this->prepare_input($value);
            default:
                die('var-type undefined: ' . $type . '(' . $value . ')');
        }
    }

    /**
     * method to do bind variables to a query
     **/
    function bindVars($sql, $bindVarString, $bindVarValue, $bindVarType, $debug = false)
    {
        $bindVarTypeArray = explode(':', $bindVarType);
        $sqlNew = $this->getBindVarValue($bindVarValue, $bindVarType);
        $sqlNew = str_replace($bindVarString, $sqlNew, $sql);
        return $sqlNew;
    }

    function prepareInput($string)
    {
        return $this->prepare_input($string);
    }

    function isSelect($sql)
    {
        $sql = str_replace("\r\n",' ',$sql);
        $sql = str_replace("\n",' ',$sql);
        $sql = str_replace("\r",' ',$sql);
        $sql = str_replace("  ",' ',$sql);
        $sql = trim($sql);
        if(strtolower(substr($sql,0,6)) == "select"){
            return true;
        }else{
            return false;
        }
    }
    function chooseDbLink($sql)
    {
        //判断使用读库还是写库
        if($this->isSelect($sql) && !$this->hasWrite && $this->enable){
            $this->dbLink = $this->linkRead;
            $this->connectType = 2;
        }else{
            if($this->enable){
                $this->closeRead();//关闭读库连接
            }
            $this->hasWrite = true;
            $this->connectType = 1;
            if($this->link === false || empty($this->link)){
                $this->connectDb($this->host, $this->user, $this->password, $this->database, $this->pConnect, $this->real,1);
            }
            $this->dbLink = $this->link;
        }
    }
}

class queryFactoryResult
{

    function queryFactoryResult()
    {
        $this->is_cached = false;
    }

    function MoveNext()
    {
        global $zc_cache;
        $this->cursor++;
        if ($this->is_cached) {
            if ($this->cursor >= sizeof($this->result)) {
                $this->EOF = true;
            } else {
                while (list($key, $value) = each($this->result[$this->cursor])) {
                    $this->fields[$key] = $value;
                }
            }
        } else {
            $zp_result_array = @mysqli_fetch_array($this->resource);
            if (!$zp_result_array) {
                $this->EOF = true;
            } else {
                while (list($key, $value) = each($zp_result_array)) {
                    if (!preg_match('/^[0-9]/', $key)) {
                        $this->fields[$key] = $value;
                    }
                }
            }
        }
    }

    function MovePrev()
    {
        global $zc_cache;
        $this->cursor--;
        if ($this->is_cached) {
            if ($this->cursor >= sizeof($this->result)) {
                $this->EOF = true;
            } else {
                while (list($key, $value) = each($this->result[$this->cursor])) {
                    $this->fields[$key] = $value;
                }
            }
        } else {
            @mysqli_data_seek($this->resource,$this->cursor);
            $zp_result_array = @mysqli_fetch_array($this->resource);
            if (!$zp_result_array) {
                $this->EOF = true;
            } else {
                while (list($key, $value) = each($zp_result_array)) {
                    if (!preg_match('/^[0-9]/', $key)) {
                        $this->fields[$key] = $value;
                    }
                }
            }
        }
    }

    function MoveNextRandom()
    {
        $this->cursor++;
        if ($this->cursor < $this->Limit) {
            $zp_result_array = $this->result[$this->result_random[$this->cursor]];
            while (list($key, $value) = each($zp_result_array)) {
                if (!preg_match('/^[0-9]/', $key)) {
                    $this->fields[$key] = $value;
                }
            }
        } else {
            $this->EOF = true;
        }
    }

    function RecordCount()
    {
        return @mysqli_num_rows($this->resource);
    }

    function Move($zp_row)
    {
        global $db;
        if (@mysqli_data_seek($this->resource, $zp_row)) {
            $zp_result_array = @mysqli_fetch_array($this->resource);
            while (list($key, $value) = each($zp_result_array)) {
                $this->fields[$key] = $value;
            }
            @mysqli_data_seek($this->resource, $zp_row);
            $this->EOF = false;
            return;
        } else {
            $this->EOF = true;
            $db->set_error(mysqli_errno($this->dbLink), mysqli_error($this->dbLink));
        }
    }
    function MoveNew($zp_row)
    {
        global $db;
        if (@mysqli_data_seek($this->resource, $zp_row)) {
            $zp_result_array = @mysqli_fetch_array($this->resource);
            while (list($key, $value) = each($zp_result_array)) {
                if (!preg_match('/^[0-9]/', $key)) {
                    $this->fields[$key] = $value;
                }
            }
            //@mysqli_data_seek($this->resource, $zp_row);
            $this->EOF = false;
            return;
        } else {
            $this->EOF = true;
            //$db->set_error(mysql_errno($this->dbLink), mysqli_error($this->dbLink));
        }
    }
}

class queryFactoryMeta
{

    function queryFactoryMeta($zp_field, $zp_res)
    {
        $info = mysqli_fetch_field_direct($zp_res, $zp_field);
        $this->type = $info->type;
        $this->max_length = $info->max_length;
    }
}
