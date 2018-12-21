<?php
class BaseController extends Controller{

    public function __construct()
    {
parent::__construct();
$this->CheckSess();

}

//检查整改网站是否携带Session令牌访问
public function CheckSess(){
session_start();
if(!isset($_SESSION['flag'])){
$this->Jump('index.php?p=admin&c=Login&a=Login');
        }
        }
        }
        ?>