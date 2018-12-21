<?php
class LoginController extends Controller {
    public function LoginAction(){
        include CUR_VIEWS.'Login.html';
    }

    public function SignAction(){

        $UserName = $_POST['userName'];
        $UserPass = $_POST['pwd'];
        $this->helper('input_helper');
        $UserName = deepslashes($UserName);
        $Password = deepslashes($UserPass);
        $AdminModel = new usersModel('users');
        session_start();
        $rs = $AdminModel->Login($UserName,$Password);
        if($rs){
            $_SESSION['flag']=$rs;
            echo 1;
        }
        else{
            echo 0;
        }
    }
}
?>