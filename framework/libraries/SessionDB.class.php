<?php
class SessionDB{
    protected $_dao;
    public function __construct()
    {
        ini_set('session.gc_dividend','3');
        ini_set('session.gc_probability','1');
        ini_set('session.save_handler','user');
        session_set_save_handler(
            array($this,'SessionBegin'),
            array($this,'SessionEnd'),
            array($this,'SessionRead'),
            array($this,'SessionWrite'),
            array($this,'SessionDelete'),
            array($this,'SessionGC')
        );
        session_start();
    }

    public function SessionBegin(){
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

    }

    public function SessionEnd(){
        return true;
    }

    public function SessionRead($sess_id){
        $sql = "select sess_content from session where sess_id='$sess_id'";
        $row = $this->_dao->fetchRow($sql);
        return (string) $row[0];

    }

    public function SessionWrite($sess_id,$sess_content){
        $sql = "replace into session(sess_id,sess_content,LastTime) values('$sess_id','$sess_content',unix_timestamp())";
        $res = $this->_dao->query($sql);
        return $res;
    }

    public function SessionDelete($sess_id){
        $sql = "delete from session where sess_id='$sess_id'";
        $res = $this->_dao->query($sql);
        return $res;
    }

    public function SessionGC($LastTime){
        $sql = "delete from session where LastTime<unix_timestamp()-$LastTime";
        $res = $this->_dao->query($sql);
        return $res;
    }
}
?>