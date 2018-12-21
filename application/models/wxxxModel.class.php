<?php
class wxxxModel extends Model{
    public function selectMorePk($Pk){
        if(isset($Pk['keyName'])) {
            $Pk2 = $Pk['keyName'];
            $where = $Pk['keyValue'];
            if($Pk2=='Cid'){

                $sql = "select * from $this->table where Cid='$where'";
                $res = $this->_dao->fetchAll($sql);
                if($res){
                    return $res;
                }
                else{
                    return false;
                }
            }
            else{
                $sql = "select * from $this->table where Wid='$where'";
                $res = $this->_dao->fetchAll($sql);
                if($res){
                    return $res;
                }
                else{
                    return false;
                }
            }
        }
    }
}
?>