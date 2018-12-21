$(function () {
    var file = true;

    //验证码验证
    $('#mpanel2').codeVerify({
        type : 1,
//            figure : 100,	//位数，仅在type=2时生效
//            arith : 0,	//算法，支持加减乘，不填为随机，仅在type=2时生效
        width : '140px',
        height : '52px',
        fontSize : '18px',
        btnId : 'submit',
        error : function() {
            file = false;
        },
        success : function() {
            file = true;
        }
    });

//表单验证
    var $userName = $("input[name=userName]");
    var $pwd = $("input[name=password]");
    var $code = $(".varify-input-code");

    function checkEmpty(ele) {
        if(ele.val() == ''){
            ele.addClass('warm');
        }else {
            ele.removeClass('warm');
        }
    }
    function submit() {
        checkEmpty($userName);
        checkEmpty($pwd);
        if(file){
            $code.removeClass('warm');
        }else {
            $code.addClass('warm');
        }
        if($userName.val() != "" && $pwd.val() != "" && file){
            var $pwdVal = hex_md5($pwd.val());
            $.post('index.php?p=admin&c=Login&c=sign',{userName:$userName.val(),pwd:$pwdVal},function (data) {
                console.log(data);
            })
        }
    }

    $userName.on('blur', function () {
        checkEmpty($userName);
    })
    $pwd.on('blur', function () {
        checkEmpty($pwd);
    })

    $('#submit').on('click', function () {
        submit();
    })
    $(document.body).on('keyup', function () {
        console.log(this);
    })
})
