<?php
class sgxxModel extends Model{
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
                $sql = "select * from $this->table where Gid='$where'";
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

    public function getData5()
    {
        $sql = "select count(*) from sgxx where substring(Grq,6,2)='05'";
        $res = $this->_dao->fetchOne($sql);
        return $res['count(*)'];
    }

    public function getData6()
    {
        $sql = "select count(*) from sgxx where substring(Grq,6,2)='06'";
        $res = $this->_dao->fetchOne($sql);
        return $res['count(*)'];
    }

    public function getData7()
    {
        $sql = "select count(*) from sgxx where substring(Grq,6,2)='07'";
        $res = $this->_dao->fetchOne($sql);
        return $res['count(*)'];
    }

    public function getData8()
    {
        $sql = "select count(*) from sgxx where substring(Grq,6,2)='08'";
        $res = $this->_dao->fetchOne($sql);
        return $res['count(*)'];
    }

    public function getAddressData1(){
        $sql = "select count(*) from sgxx where substring(Gaddress,4,3)='珠海市'";
        $res = $this->_dao->fetchOne($sql);
        return $res['count(*)'];
    }

    public function getAddressData2(){
        $sql = "select count(*) from sgxx where substring(Gaddress,4,3)='深圳市'";
        $res = $this->_dao->fetchOne($sql);
        return $res['count(*)'];
    }

    public function getAddressData3(){
        $sql = "select count(*) from sgxx where substring(Gaddress,4,3)='东莞市'";
        $res = $this->_dao->fetchOne($sql);
        return $res['count(*)'];
    }

    public function getAddressData4(){
        $sql = "select count(*) from sgxx where substring(Gaddress,4,3)='广州市'";
        $res = $this->_dao->fetchOne($sql);
        return $res['count(*)'];
    }

    public function getPrices(){
        $sql1 = "select count(*) from sgxx where Je<1000";
        $sql2 = "select count(*) from sgxx where Je>=1000 and Je<3000";
        $sql3 = "select count(*) from sgxx where Je>=3000 and Je<5000";
        $sql4 = "select count(*) from sgxx where Je>=5000 and Je<10000";
        $sql5 = "select count(*) from sgxx where Je>10000";
        $res1 = $this->_dao->fetchOne($sql1);
        $res2 = $this->_dao->fetchOne($sql2);
        $res3 = $this->_dao->fetchOne($sql3);
        $res4 = $this->_dao->fetchOne($sql4);
        $res5 = $this->_dao->fetchOne($sql5);
        return array($res1['count(*)'],$res2['count(*)'],$res3['count(*)'],$res4['count(*)'],$res5['count(*)']);
    }
}
?>