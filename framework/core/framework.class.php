<?php
class framework{
    public static function Run(){
        self::initPath();
        self::autoload();
        self::router();
    }

    protected static function initPath(){
        define('DS',DIRECTORY_SEPARATOR);
        define('ROOT',getcwd().DS);
        define('FRAMEWORK',ROOT.'framework'.DS);
        define('APPLICATION',ROOT.'application'.DS);
        define('PUB',ROOT.'Public'.DS);
        define('CORE',FRAMEWORK.'core'.DS);
        define('DATABASE',FRAMEWORK.'database'.DS);
        define('HELPER',FRAMEWORK.'helper'.DS);
        define('LIBRARY',FRAMEWORK.'libraries'.DS);
        define('CONFIGS',APPLICATION.'configs'.DS);
        define('CONTROLLERS',APPLICATION.'controllers'.DS);
        define('MODELS',APPLICATION.'models'.DS);
        define('VIEWS',APPLICATION.'views'.DS);

        define('PLATFORM',isset($_GET['p'])?$_GET['p']:'admin');
        define('CONTROLLER',isset($_GET['c'])?$_GET['c']:'Login');
        define('ACTION',isset($_GET['a'])?$_GET['a']:'Login');

        define('CUR_CONTROLLER',CONTROLLERS.PLATFORM.DS);
        define('CUR_VIEWS',VIEWS.PLATFORM.DS);
        include CONFIGS.'config.php';
        include DATABASE.'I_DAO.interface.php';

    }

    protected static function router(){
        $Action = ACTION.'Action';
        $Controller = CONTROLLER.'Controller';
        $ControllerObj = new $Controller();
        $ControllerObj->$Action();
    }

    public static function load($ClassName){
        $framework_list = array(
            'MysqlDB'=>DATABASE.$ClassName.'.class.php',
            'Factory'=>LIBRARY.$ClassName.'.class.php',
            'Controller'=>CORE.$ClassName.'.class.php',
            'Model'=>CORE.$ClassName.'.class.php',
            'PDODB'=>DATABASE.$ClassName.'.class.php',
            'SessionDB'=>LIBRARY.$ClassName.'.class.php',
            'Upload'=>LIBRARY.$ClassName.'.class.php'
        );

        if(isset($framework_list[$ClassName])){
            include $framework_list[$ClassName];
        }
        elseif(substr($ClassName,-10)=='Controller'){
            include CUR_CONTROLLER.$ClassName.'.class.php';
        }
        elseif(substr($ClassName,-5)=='Model'){
            include MODELS.$ClassName.'.class.php';
        }
        else{
            //不做处理
        }
    }

    protected static function autoload(){
        spl_autoload_register(array(__CLASS__,'load'));
    }
}
?>