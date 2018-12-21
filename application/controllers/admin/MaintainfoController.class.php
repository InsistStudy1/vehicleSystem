<?php
class MaintainfoController extends Controller{
    public function addMaintainfoAction(){
        if(!empty($_POST)){
            $data['Wid'] = $_POST['Wid'];
            $data['Cid'] = $_POST['Cid'];
            $data['Nr'] = $_POST['Nr'];
            $data['Fy'] = $_POST['Fy'];
            $data['Wrq'] = $_POST['Wrq'];
            $data['Waddress'] = $_POST['Waddress'];
            $this->helper('input_helper');
            $data = deepslashes($data);
            $data = deepspecialchar($data);

            $Model = new wxxxModel('wxxx');
            $rs = $Model->Insert($data);
            if($rs){
                echo 1;
            }else{
                echo 0;
            }
        }
    }

    public function selectMaintainfosAction(){
        $Model = new wxxxModel('wxxx');
        $key = isset($_POST['Cid'])?'Cid':'Wid';
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
        $Model = new wxxxModel('wxxx');
        $offset = isset($_POST['page'])?$_POST['page']:1;
        $Count = $Model->getCount();
        $pagesize = 10;
        $Total = ceil($Count/$pagesize);
        $current = ($offset-1)*$pagesize;
        $rows = $Model->pageRows($current,$pagesize);
        $str = array(
            'data'=>$rows,
            'current'=>$offset,
            'total'=>$Total
        );
        echo json_encode($str);
    }

    public function updateAction(){
        if(!empty($_POST)){
            $data['Wid'] = $_POST['Wid'];
            $data['Cid'] = $_POST['Cid'];
            $data['Nr'] = $_POST['Nr'];
            $data['Fy'] = $_POST['Fy'];
            $data['Wrq'] = $_POST['Wrq'];
            $data['Waddress'] = $_POST['Waddress'];

            $this->helper('input_helper');
            $data = deepslashes($data);
            $data = deepspecialchar($data);

            $Model = new wxxxModel('wxxx');
            $rs = $Model->Update($data);

            if($rs){
                echo 1;
            }
            else{
                echo 0;
            }
        }
    }

    public function deleteAction(){
        if(!empty($_GET)) {
            $Model = new wxxxModel('wxxx');
            $rs = $Model->Delete($_GET['Wid']);
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