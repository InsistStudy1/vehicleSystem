<?php
class PDODB implements I_DAO{
    private $Host;
    private $Port;
    private $DBUser;
    private $DBPass;
    private $DBChar;
    private $DBName;
    private $dsn;
    private $pdo;
    private $DriverOptions;
    private static $Instance;
    private function __clone(){}

    public static function Instance($config)
    {
        if(!isset(self::$Instance)){
            $NewObj = new self($config);
            self::$Instance = $NewObj;
            return $NewObj;
        }
        else{
            return self::$Instance;
        }
    }

    private function __construct($config)
    {
        $this->Host = isset($config['Host']) ? $config['Host'] : 'localhost';
        $this->Port = isset($config['Port']) ? $config['Port'] : '3306';
        $this->DBUser = isset($config['DBUser']) ? $config['DBUser'] : 'root';
        $this->DBPass = isset($config['DBPass']) ? $config['DBPass'] : 'helloworld123+';
        $this->DBName = isset($config['DBName']) ? $config['DBName'] : '';
        $this->DBChar = isset($config['DBChar']) ? $config['DBChar'] : 'utf8';

        $this->__initDriverOptions();
        $this->Connect();
    }

    public function __initDriverOptions(){
        $this->DriverOptions = array('set names '.$this->DBChar);
    }

    private function Connect(){
        $this->dsn = "mysql:host=$this->Host;port=$this->Port;dbname=$this->DBName";
        $this->pdo = new PDO($this->dsn,$this->DBUser,$this->DBPass,$this->DriverOptions);
    }

    public function query($sql){
        $res = $this->pdo->query($sql);
        if($res){
            return $res;
        }
        else{
            $ErrorInfo = $this->pdo->errorInfo();
            echo '<table border="1" rules="all" align="center">';
                echo '<tr>';
                    echo '<td>错误代码:</td>';
                    echo '<td>'.$ErrorInfo[1].'</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>错误信息:</td>';
                    echo '<td>'.$ErrorInfo[2].'</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>错误语句:</td>';
                    echo '<td>'.$sql.'</td>';
                echo '</tr>';
            echo '<table>';
        }
    }

    public function fetchAll($sql)
    {
        $res = $this->query($sql);
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
        $res->closeCursor();
        return $rows;
    }
    public function fetchOne($sql){
        $res = $this->query($sql);
        $row = $res->fetchColumn(PDO::FETCH_ASSOC);
        $res->closeCursor();
        return $row;
    }

    public function fetchRow($sql){
        $res = $this->query($sql);
        $row = $res->fetch(PDO::FETCH_ASSOC);
        $res->closeCursor();
        return $row;
    }

    public function filter($Data){
        return $this->pdo->quote($Data);
    }
}
?>