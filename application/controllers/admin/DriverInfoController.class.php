<?php
class DriverInfoController extends Controller{

    public function addDriverInfoAction(){
        if(!empty($_POST)){
            $data['Sid'] = $_POST['Sid'];
            $data['Cid'] = $_POST['Cid'];
            $data['Sname'] = $_POST['Sname'];
            $data['Sex'] = $_POST['Sex'];
            $data['Sfid'] = $_POST['Sfid'];
            $data['Phone'] = $_POST['Phone'];
            $data['Saddress'] = $_POST['Saddress'];
            $this->helper('input_helper');
            $data = deepslashes($data);
            $data = deepspecialchar($data);
            $Model = new sjxxModel('sjxx');
            $rs = $Model->Insert($data);
            if($rs){
                echo 1;
            }
            else{
                echo 0;
            }
        }
    }

    public function updateAction(){
        if(!empty($_POST)){
            $data['Sid'] = $_POST['Sid'];
            $data['Cid'] = $_POST['Cid'];
            $data['Sname'] = $_POST['Sname'];
            $data['Sex'] = $_POST['Sex'];
            $data['Sfid'] = $_POST['Sfid'];
            $data['Phone'] = $_POST['Phone'];
            $data['Saddress'] = $_POST['Saddress'];

            $this->helper('input_helper');
            $data = deepslashes($data);
            $data = deepspecialchar($data);

            $Model = new sjxxModel('sjxx');
            $rs = $Model->Update($data);

            if($rs){
                echo 1;
            }
            else{
                echo 0;
            }
        }
    }

    public function selectDriversAction(){
        $Model = new sjxxModel('sjxx');
        $key = isset($_POST['Sid'])?'Sid':'Cid';
        $value = $_POST[$key];
        $array=array(
            'keyName'=>$key,
            'keyValue'=>$value
        );
        $rs = $Model->selectMorePk($array);
        $str = array(
            'data'=>$rs,
            'current'=>1,
            'total'=>1
        );
        if($rs) {
            echo json_encode($str);
        }else{
            echo '';
        }
    }

    public function InfoListsAction(){
        $Model = new sjxxModel('sjxx');
        $offset = isset($_POST['page'])?$_POST['page']:1;
        $Count = $Model->getCount();
        $pagesize = 10;
        $current = ($offset-1)*$pagesize;
        $rows = $Model->pageRows($current,$pagesize);
        $Total = ceil($Count/$pagesize);
        $str = array(
            'data'=>$rows,
            'current'=>$offset,
            'total'=>$Total
        );
        echo json_encode($str);
    }

    public function deleteAction(){
        if(!empty($_GET)) {
            $Model = new sjxxModel('sjxx');
            $rs = $Model->Delete($_GET['Sid']);
            if($rs){
                echo 1;
            }
            else{
                echo 0;
            }
        }
    }
}
?>