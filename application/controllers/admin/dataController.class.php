<?php
class dataController extends Controller{

    public function AccidentInfoAction(){
            $Model = new sgxxModel('sgxx');
            $res5 = $Model->getData5();
            $res6 = $Model->getData6();
            $res7 = $Model->getData7();
            $res8 = $Model->getData8();
            $data1 = array('number'=>4);
            $data2 = array('number'=>4);
            $data3 = array('number'=>6);
            $data4 = array('number'=>5);
            $data5 = array('number'=>$res5);
            $data6 = array('number'=>$res6);
            $data7 = array('number'=>$res7);
            $data8 = array('number'=>$res8);
            $data9 = array('number'=>8);
            $data10 = array('number'=>3);
            $data11 = array('number'=>8);
            $data12 = array('number'=>2);
            $re = array(
                $data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$data12,
            );
            echo json_encode($re);
    }

    public function addressAction(){
        $Model = new sgxxModel('sgxx');
        $address1 = $Model->getAddressData1();
        $address2 = $Model->getAddressData2();
        $address3 = $Model->getAddressData3();
        $address4 = $Model->getAddressData4();
        $data1 = array("value"=>$address1,"name"=>"珠海市");
        $data2 = array("value"=>$address2,"name"=>"深圳市");
        $data3 = array("value"=>$address3,"name"=>"东莞市");
        $data4 = array("value"=>$address4,"name"=>"广州市");
        $re = array($data1,$data2,$data3,$data4);
        echo json_encode($re);
    }

    public function PriceAction(){
        $Model = new sgxxModel('sgxx');
        $data = $Model->getPrices();
        $data1 = array('value'=>$data[0],'name'=>'1k以下');
        $data2 = array('value'=>$data[1],'name'=>'1k-3k');
        $data3 = array('value'=>$data[2],'name'=>'3k-5k');
        $data4 = array('value'=>$data[3],'name'=>'5k-1w');
        $data5 = array('value'=>$data[4],'name'=>'1w以上');
        $re = array($data1,$data2,$data3,$data4,$data5);
        echo json_encode($re);
    }
}
?>