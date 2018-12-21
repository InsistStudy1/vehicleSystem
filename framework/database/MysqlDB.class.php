<?php
/**
 * Class MysqlDB
 * 作者：SteffenKong
 * 数据库工具类
 */
class MysqlDB implements I_DAO {
    private $Host;      //数据库主机名
    private $Port;      //数据库端口
    private $DBUser;    //数据库用户名
    private $DBPass;    //数据库密码
    private $DBName;    //数据库名字
    private $DBChar;    //数据库编码
    private static $Instance;       //工具类单例资源
    private static $resource;       //数据库连接资源

    //防克隆
    private function __clone(){}

    //单例化本类
    public static function Instance($config){
        if(!isset(self::$Instance)){
            $NewObj = new self($config);
            self::$Instance = $NewObj;
            return $NewObj;
         }
        else{
            return self::$Instance;
        }
    }

    //初始化参数
    private function __construct($config)
    {
        $this->Host = isset($config['Host']) ? $config['Host'] : 'localhost';
        $this->Port = isset($config['Port']) ? $config['Port'] : '3306';
        $this->DBUser = isset($config['DBUser']) ? $config['DBUser'] : 'root';
        $this->DBPass = isset($config['DBPass']) ? $config['DBPass'] : 'helloworld123+';
        $this->DBName = isset($config['DBName']) ? $config['DBName'] : '';
        $this->DBChar = isset($config['DBChar']) ? $config['DBChar'] : 'utf8';
        self::$resource = $this->Connect();
        if(self::$resource){
            $this->SetChar($this->DBChar);
            $this->SelDB($this->DBName);
        }
        else{
            die('数据库连接失败!!!');
        }
    }

    //连接数据库
    private function Connect(){
        $link = mysqli_connect($this->Host,$this->DBUser,$this->DBPass,$this->DBName,$this->Port);
        if($link){
            return $link;
        }
        else{
            return false;
        }
    }

    /*
     * 作用：执行所有sql语句
     * @param string sql语句
     * return string
     */
    public function query($sql){
        $res = mysqli_query(self::$resource,$sql);
        if($res){
            return $res;
        }
        else{
            echo '<table border="1" rules="all" align="center">';
            echo '<tr>';
            echo '<td>错误代码</td>';
            echo '<td>'.mysqli_errno(self::$resource).'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>错误信息</td>';
            echo '<td>'.mysqli_error(self::$resource).'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>错误语句</td>';
            echo '<td>'.$sql.'</td>';
            echo '</tr>';
            echo '<table>';
        }
    }


    /*
    * 作用：选择数据库编码
    * @param string 编码名字
    */
    private function SetChar($CharName){
        $sql = "set names $CharName";
        $this->query($sql);
    }

    /*
    * 作用：选择数据库
    * @param string 数据库名字
    */
    private function SelDB($DB){
        $sql = "use $DB";
        $this->query($sql);
    }

    /*
    * 作用：取出所有数据
    * @param string sql查询语句
    */
    public function fetchAll($sql){
        $res = $this->query($sql);
        $arr = array();
        if($res){
            while($row = mysqli_fetch_array($res)){
                $arr[] = $row;
            }
        }
        return $arr;
    }

    /*
    * 作用：取出一个数据
    * @param string sql查询语句
    */
    public function fetchOne($sql){
        $res = $this->query($sql);
        if($res){
            $row = mysqli_fetch_assoc($res);
            if($row) {
                return $row;
            }
        }
    }

    /*
    * 作用：取出一行数据
    * @param string sql查询语句
    */
    public function fetchRow($sql){
        $res = $this->query($sql);
        if($res){
            while($row = mysqli_fetch_assoc($res)){
                return $row;
            }
        }
    }

    public function getCount($sql){
        $res = $this->query($sql);
        if($res){
            $Count = mysqli_num_rows($res);
            return $Count;
        }

    }

    /*
     * 作用：防止用户恶意注入SQL语句
     * @param string 表单数据
     */
    public function filter($Data){
        return "'".mysqli_real_escape_string(self::$resource,$Data)."'";
    }
}
?>