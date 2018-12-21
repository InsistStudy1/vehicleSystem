<?php
class CarInfoController extends Controller{

    public function addCarInfoAction(){
        if(!empty($_POST)){

            //收集Ajax的数据
            $data['Cid'] = $_POST['Cid'];
            $data['Fid'] = $_POST['Fid'];
            $data['Chj'] = $_POST['Chj'];
            $data['Chrq'] = $_POST['Chrq'];
            $data['Zzh'] = $_POST['Zzh'];
            $data['zw'] = $_POST['zw'];

            //导入辅助函数
            $this->helper('input_helper');

            //过滤并处理非法字符
            $data = deepslashes($data);
            $data = deepspecialchar($data);

            //实例化并调用自动添加方法
            $Model = new clxxModel('clxx');
            $rs = $Model->Insert($data);

            //判断添加结果
            if($rs){
                echo 1;
            }
            else{
                echo 0;
            }

        }
    }

    public function InfoListsAction(){
        $Model = new clxxModel('clxx');
        $offset = isset($_POST['page'])?$_POST['page']:1;
        $Count = $Model->getCount();
        $pagesize = 10;
        $current = ($offset-1)*$pagesize;
        $Total =ceil($Count/$pagesize);
        $rows = $Model->pageRows($current,$pagesize);
        $str = array(
            'data'=>$rows,
            'current'=>$offset,
            'total'=>$Total
        );
        echo json_encode($str);
    }

    public function selectCarInfosAction(){
        $Model = new clxxModel('clxx');
            $key = isset($_POST['Cid'])?'Cid':'Fid';
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
            $data['Cid'] = $_POST['Cid'];
            $data['Fid'] = $_POST['Fid'];
            $data['Chj'] = $_POST['Chj'];
            $data['Chrq'] = $_POST['Chrq'];
            $data['Zzh'] = $_POST['Zzh'];
            $data['zw'] = $_POST['zw'];

            $this->helper('input_helper');
            $data = deepslashes($data);
            $data = deepspecialchar($data);

            $Model = new clxxModel('clxx');
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
            $Model = new clxxModel('clxx');
            $rs = $Model->Delete($_GET['Cid']);

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