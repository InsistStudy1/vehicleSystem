/**
 * Created by Machenike on 2018/5/18.
 */
$(document).ready(function () {
    //新建添加信息工具
    let addInfo = getOperateInfo();

    //车辆信息添加
    $('#addCarInfo').on('click', function () {
        addInfo.carInfo('../../index.php?p=Admin&c=CarInfo&a=addCarInfo');
    })

    //司机信息添加
    $('#addDriverInfo').on('click', function () {
        addInfo.driverInfo('../../index.php?p=Admin&c=DriverInfo&a=addDriverInfo');
    })

    //维修信息添加
    $('#addMaintainfo').on('click', function () {
        addInfo.maintainfo('../../index.php?p=Admin&c=Maintainfo&a=addMaintainfo');
    })

    //事故信息添加
    $('#addaccidentInfo').on('click', function () {
        addInfo.accidentInfo('../../index.php?p=Admin&c=AccidentInfo&a=addAccidentInfo');
    })
}())
