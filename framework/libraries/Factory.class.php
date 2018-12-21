<?php
/*
 * 工厂模式单例化工具类
 */
class Factory{
    public static function GetObj($ClassName){
        $ClassList = array();
        if(!isset($ClassList[$ClassName])){
            $ClassList[$ClassName] = new $ClassName;
            return $ClassList[$ClassName];
        }
        else{
            return $ClassList[$ClassName];
        }
    }
}
?>