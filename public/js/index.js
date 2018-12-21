/**
 * Created by Administrator on 18-5-17.
 */
$(document).ready(function () {
    $(document)
        .ajaxStart(function () {
            NProgress.start();
        })
        .ajaxStop(function () {
            NProgress.done();
        })

    $.get('index.php?p=Admin&c=Manage&a=ImgShow',function (data) {
        $('#admin-img').attr('src',data.path);
        $('.user-avatar').attr('src',data.path);
        $('.user-name').text(data.name);
    },'json')


    //点击documen隐藏右上角用户
    $('document').on('click', function () {
        $('.dropdown.user').removeClass('open');
    })
    //
    //点击修改个人信息显示模态框
    $('#updataPersonalInfo').on('click', function () {

        $('#updateModal').modal('show');
        $('#updateImg').on('click',function () {
            $(this).on('change', function () {
                var fd = new FormData();
                fd.append("upfile", $("#updateImg").get(0).files[0]);
                $.ajax({
                    url:'index.php?p=Admin&c=Manage&a=UploadFile',
                    type:"post",
                    processData: false, //不以key，value值转换为对象
                    contentType: false, //
                    data:fd,
                    dataType:'json',
                    success:function(data){
                        if(data.res == 1){
                            $('#admin-img').attr('src',data.Path);
                            console.log($('#admin-img'));
                            $('.user-avatar').attr('src',data.Path);
                        }else {
                            popup({type: 'error', msg: "上传失败", delay: 1500, bg: true, clickDomCancel: true});
                        }
                    }
                });
            });
        })

        //修改图片
        // $('#file_upload').uploadify({
        //     'swf': './public/lib/order/uploadify.swf',
        //     'script': './public/lib/php/uploadify.php',
        //     'queueSizeLimit': 1,
        //     'buttonText': '更换图片',
        //     'fileObjName': 'img_path',
        //     'width': 100,
        //     'height': 30,
        //     'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
        //     'rollover': true,
        //     'removeTimeout': 1,
        //     'onUploadSuccess': function (file, data, response) {
        //         console.log(file+".."+data+".."+response);
        //     }
        // });
        var isNull = true;
        $('.info-left input').on('blur', function () {
            if ($(this).val() == '') {
                $(this).addClass('warm');
                isNull = true;
            } else {
                $(this).removeClass('warm');
                isNull = false;
            }
        })

        var check = getVerification();
        $('#updateInfo').on('click', function () {
            if(!check.checkIsNull([$('#userName').val()])){
                $('#userName').addClass('warm');
            }else {
                $('#userName').removeClass('warm');
            }
            if(!check.checkIsNull([$('#pwd').val()])){
                $('#pwd').addClass('warm');return;
            }else {
                $('#pwd').removeClass('warm');
            }
            if(!check.checkIsNull([$('#confirmPwd').val()])){
                $('#confirmPwd').addClass('warm');return;
            }else {
                $('#confirmPwd').removeClass('warm');
            }
           if ($('#pwd').val() !== $('#confirmPwd').val()) {
               $('#pwd').addClass('warm');
               $('#confirmPwd').addClass('warm');
               return;
           } else {
               var $pwdVal = hex_md5($("#pwd").val());
               $.ajax({
                   'url': 'index.php?p=Admin&c=Manage&a=setusers',
                   'type':'post',
                   'data': {
                       'userName': $('#userName').val(),
                       'pwd': $pwdVal
                   },
                   success: function (data) {

                       $('#updateModal').modal('hide');
                       promptInfo(data, '修改');
                   }
               })
           }
        })
    })


    //sideNav滚动条
    var $sideNav = $('.sideNav');
    $sideNav.slimScroll({
        width: 'auto', //可滚动区域宽度
        height: '100%', //可滚动区域高度
        size: '5px', //组件宽度
        color: 'rgb(153, 153, 153)', //滚动条颜色
        position: 'right', //组件位置：left/right
        distance: '0px', //组件与侧边之间的距离
        start: 'top', //默认滚动位置：top/bottom
        opacity: .4, //滚动条透明度
        alwaysVisible: true, //是否 始终显示组件
        disableFadeOut: true, //是否 鼠标经过可滚动区域时显示组件，离开时隐藏组件
        railVisible: true, //是否 显示轨道
        railColor: 'transparent', //轨道颜色
        railDraggable: true, //是否 滚动条可拖动
        railClass: 'slimScrollRail', //轨道div类名
        barClass: 'slimScrollBar', //滚动条div类名
        wrapperClass: 'slimScrollDiv', //外包div类名
        allowPageScroll: true, //是否 使用滚轮到达顶端/底端时，滚动窗口
        wheelStep: 10, //滚轮滚动量
        touchScrollStep: 200, //滚动量当用户使用手势
        borderRadius: '7px', //滚动条圆角
        railBorderRadius: '7px' //轨道圆角
    });

}());
