<?php
class ManageController extends BaseController{
    public function IndexAction(){
        include CUR_VIEWS.'index.html';
    }

    //注销用户
    public function logoutAction(){
        //销毁session
        unset($_SESSION['flag']);
        //释放session
        session_destroy();
        $this->jump('index.php?p=Admin&c=Login&a=Login');
    }

    public function setusersAction(){
        $data['uname'] = $_POST['userName'];
        $data['upswd'] = $_POST['pwd'];

        $this->helper('input_helper');
        $data = deepslashes($data);
        $data = deepspecialchar($data);

        $Model = new usersModel('users');
        $rs = $Model->Update($data);
        if($rs){
            echo 1;
        }
        else{
            echo 0;
        }
    }

    public function UploadFileAction(){
        $ImgFile = $_FILES['upfile'];
        $Obj = Factory::GetObj('Upload');
        $Path = $Obj->UploadOne($ImgFile);
        $data['Img'] = $Path;
        $data['uname'] = $_SESSION['flag']['uname'];
        $Model = new usersModel('users');
        $rs = $Model->Update($data);
        if($rs) {
            $res = array(
                'res'=>1,
                'Path' => $Path
            );
            echo json_encode($res);
        }else{
            echo 0;
        }
    }

    public function ImgShowAction(){
        $AllPath = '';
        $Obj = new usersModel('users');
        $Pk = $_SESSION['flag']['uname'];
        $Path = $Obj->ImgShow($Pk);
        $UserName = $_SESSION['flag']['uname'];
        foreach($Path as $v){
            $AllPath = $v;
        }

        $data = array(
            'path'=>$AllPath,
            'name'=>$UserName
        );

        if($Path) {
            echo  json_encode($data);
        }
    }
}
?>