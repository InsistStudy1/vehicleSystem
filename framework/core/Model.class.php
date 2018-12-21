<?php
class Model{
    protected $_dao;
    protected $table;
    protected $fields = array();

    public function __construct($table)
    {
        $this->ConnDB($table);
        $this->getfields();
    }


    /*
     * 自动插入数
     * access public
     *
     */
    public function getfields(){
        $sql = "desc $this->table";
        $result = $this->_dao->fetchAll($sql);
        foreach($result as $v){
            $this->fields[] = $v['Field'];
            if($v['Key']=='PRI'){
                $Pk = $v['Field'];
            }
        }
        if(isset($Pk)){
            $this->fields['Pk'] = $Pk;
        }
    }


    public function ConnDB($table){
        $config = $GLOBALS['config']['db'];
        switch ($GLOBALS['config']['app']['dao']){
            case 'pdo':
                $dao_class = 'PDODB';
                break;
            case 'mysql':
                $dao_class = 'MysqlDB';
                break;
        }
        $this->_dao = $dao_class::Instance($config);
        $this->table = $table;
    }

    public function Insert($list){
        $fields_list = '';
        $value_list = '';
        foreach ($list as $k=>$v){
            if(in_array($k,$this->fields)){
                $fields_list.=$k.',';
                $value_list.="'$v'".',';
            }
        }
        $fields_list = rtrim($fields_list,',');
        $value_list = rtrim($value_list,',');
        $sql = "insert into $this->table($fields_list) values($value_list)";
        $res = $this->_dao->query($sql);
        if($res){
            return $res;
        }
        else{
            return false;
        }
    }

     public function Delete($Pk){
        $where = 0;
        if(is_array($Pk)){
            $where = "$this->fields['Pk'] in (".implode(',',$Pk).")";
        }else{
            $where = "{$this->fields['Pk']} = '$Pk'";
        }
        $sql = "delete  from {$this->table} where $where";
        $res = $this->_dao->query($sql);
        if($res){
            return $res;
        }
        else{
            return false;
        }
    }

    public function Update($list){
            $uplist = '';
            $where = 0;
            foreach($list as $k=>$v){
                if(in_array($k,$this->fields)){
                    if($k == $this->fields['Pk']){
                        $where = "$k='$v'";
                    }
                    else{
                        $uplist .= "$k='$v'".',';
                    }
                }
            }
            $uplist = rtrim($uplist,',');
            $sql = "update $this->table set $uplist where $where";
            $res = $this->_dao->query($sql);
            if($res){
                return $res;
            }
            else{
                return false;
            }
    }

    public function selectByPk($Pk){
        $sql = "select * from $this->table where $this->fields['Pk']=$Pk";
        $res = $this->_dao->query($sql);
        if($res){
            return $res;
        }
        else{
            return false;
        }
    }




    public function pageRows($offect,$limit,$where=""){
        if(empty($where)){
            $sql = "select * from $this->table limit $offect,$limit";
        }
        else{
            $sql = "select * from $this->table where $where $offect,$limit";
        }
        $res = $this->_dao->fetchAll($sql);
        if($res){
            return $res;
        }
        else{
            return false;
        }
    }

    public function getCount(){
        $sql = "select count(*) from $this->table";
        $res = $this->_dao->fetchOne($sql);
        return $res['count(*)'];
    }

    public function getDataAll(){
        $sql = "select * from $this->table";
        $data = $this->_dao->fetchAll($sql);
        return $data;
    }

}
?>