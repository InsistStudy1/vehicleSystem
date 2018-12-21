<?php
class AccidentInfoController extends Controller{
    public function addAccidentInfoAction(){
        if(!empty($_POST)){

            //收集Ajax数据
            $data['Gid'] = $_POST['Gid'];
            $data['Cid'] = $_POST['Cid'];
            $data['Sid'] = $_POST['Sid'];
            $data['Grq'] = $_POST['Grq'];
            $data['Gaddress'] = $_POST['Gaddress'];
            $data['Yy'] = $_POST['Yy'];
            $data['Je'] = $_POST['Je'];

            //导入辅助函数
            $this->helper('input_helper');

            //过滤非法关键字
            $data = deepspecialchar($data);
            $data = deepslashes($data);

            //实例化并调用模型来添加数据
            $Model = new sgxxModel('sgxx');
            $rs = $Model->Insert($data);

            //判断添加的结果
            if($rs){
                echo 1;
            }
            else{
                echo 0;
            }
        }
    }

    public function AccidentInfosAction(){
        $Model = new sgxxModel('sgxx');
        $key = isset($_POST['Cid'])?'Cid':'Gid';
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

    public function updateAction(){
        if(!empty($_POST)){
            $data['Gid'] = $_POST['Gid'];
            $data['Cid'] = $_POST['Cid'];
            $data['Sid'] = $_POST['Sid'];
            $data['Grq'] = $_POST['Grq'];
            $data['Gaddress'] = $_POST['Gaddress'];
            $data['Yy'] = $_POST['Yy'];
            $data['Je'] = $_POST['Je'];

            $this->helper('input_helper');
            $data = deepslashes($data);
            $data = deepspecialchar($data);

            $Model = new sgxxModel('sgxx');
            $rs = $Model->Update($data);

            if($rs){
                echo 1;
            }
            else{
                echo 0;
            }
        }
    }

    public function InfoListsAction(){
        $Model = new sgxxModel('sgxx');
        $current = isset($_POST['page'])?$_POST['page']:1;

        $pagesize = 10;
        $offset = ($current-1)*$pagesize;
        $Count = $Model->getCount();
        $rows = $Model->pageRows($offset,$pagesize);
        $Total = ceil($Count/$pagesize);
        $data = array(
            'data'=>$rows,
            'current'=>$current,
            'total'=>$Total
        );
        echo json_encode($data);
    }

    public function deleteAction(){
        if(!empty($_GET)) {
            $Model = new sgxxModel('sgxx');
            $rs = $Model->Delete($_GET['Gid']);
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