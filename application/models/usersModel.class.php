<?php
class usersModel extends Model{
    public function Login($UserName,$Password){
        $UserName=$this->_dao->filter($UserName);
        $Password=$this->_dao->filter($Password);
        $sql = "select uname,upswd from users where uname=$UserName and upswd=$Password";
        $res = $this->_dao->fetchRow($sql);
        if($res){
            return $res;
        }
    }

    public function ImgShow($Pk){
        $sql = "select Img from users where uname='$Pk'";
        $rs = $this->_dao->fetchRow($sql);
        if($rs){
            return $rs;
        }
        else{
            return false;
        }
    }
}
?>