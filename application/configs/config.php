<?php
 return $GLOBALS['config'] = array(
    'db'=>array(
        'Host'=>'localhost',             //数据库服务器地址
        'Port'=>3306,                   //数据库端口号
        'DBUser'=>'root',               //数据库用户名
        'DBPass'=>'123456',     //数据库用户密码
        'DBName'=>'carsinfo',           //数据库名字
        'DBChar'=>'utf8'                //数据库编码
    ),

    'app'=>array(
        'dao'=>'mysql'                  //数据库驱动接口，选项：mysql or pdo
    )
);

?>
