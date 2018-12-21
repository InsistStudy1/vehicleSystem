<?php
class Controller{

    public function __construct()
    {
        $this->SetHeader();
    }

    protected function SetHeader(){
        header('Content-type:text/html;charset=utf-8');
    }

    protected function Jump($Url,$Info=null,$wait=0){
        if($Info==null){
            header('Location:'.$Url);
        }
        else{
            header('refresh:'.$wait.';url='.$Url);
            echo $Info.'<br/>';
        }
        exit();
    }

    protected function helper($helper){
        include HELPER.$helper.'.php';
    }
}
?>