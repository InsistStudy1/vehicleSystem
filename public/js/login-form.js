        (document).ready(function() {
    var file = true;

    //验证码验证
    $('#mpanel2').codeVerify({
        type : 1,
//            figure : 100,	//位数，仅在type=2时生效
//            arith : 0,	//算法，支持加减乘，不填为随机，仅在type=2时生效
        width : '88px',
        height : '34px',
        fontSize : '18px',
        btnId : 'submit',
        codeLength : 4,
        error : function() {
            file = false;
        },
        success : function() {
            file = true;
        }
    });

//表单验证
    var $userName = $("input[name=userName]"),
        $pwd = $("input[name=password]"),
        $code = $(".varify-input-code");

    $('#submit').on('click', function (){
        checkEmpty($userName);
        checkEmpty($pwd);
            if(file){
            $code.removeClass('warm');
        }else {
            $code.addClass('warm');
        }
        //验证通过时
        if($userName.val() != "" && $pwd.val() != "" && file){
            var $pwdVal = hex_md5($pwd.val());
            //发送AJAX请求
            $.post('index.php?p=Admin&c=Login&a=Sign',{userName:$userName.val(),pwd:$pwdVal},function(data){
                if(data==1){
                    location.href='index.php?p=Admin&c=manage&a=index';
                }
                else{
                    popup({type: 'error', msg: "用户名密码错误", delay: 1500, bg: true, clickDomCancel: true});
                }
            })
        }
    })
    $userName.on('blur', function () {
        checkEmpty($userName);
    })
    $pwd.on('blur', function () {
        checkEmpty($pwd);
    })

    function checkEmpty(ele) {
        if(ele.val() == ''){
            ele.addClass('warm');
        }else {
            ele.removeClass('warm');
        }
    }
}())
