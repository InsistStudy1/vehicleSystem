<?php
interface I_DAO{
    public static function Instance($config);
    public function query($sql);
    public function fetchRow($sql);
    public function fetchOne($sql);
    public function fetchAll($sql);
    public function filter($Data);
}
?>