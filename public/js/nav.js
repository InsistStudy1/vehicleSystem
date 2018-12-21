/**
 * Created by Machenike on 2018/5/28.
 */
//折叠菜单
$('#sidebar .hasSub>a').on('click', function () {
    $(this).parent().toggleClass('extend');
})

var $subLi = $('#sidebar .hasSub>a').next().children();
//添加图表信息统计
$subLi.push($('.chartLi')[0]);
$subLi.on('click', function () {
    if(!$(this).hasClass('chartLi')){
        $('.chartLi a').removeClass('active');
    }
    var aList = $('#sidebar .hasSub').children('ul').children('li').children('a');
    aList.removeClass('active');
    $(this).children('a').addClass('active');

    //更换iframe链接
    var url = $(this).children('a').attr('href');
    $('#myFrame').attr('src', url);
    return false;
});

//点击右侧箭头显示隐藏左侧导航栏
$('.toggle-sidebar').on('click', function () {
    if (!$('#sidebar').hasClass('change')) {
        sidebarHide();
    } else {
        sidebarShow();
    }

});
//设置content和myFrame的高度
var $maxHeight = $('#sidebar').height();
$('#content').height($maxHeight);
$('#myFrame').height($maxHeight);
/*
 * 判断PC端还是移动端
 * true为PC端，false为手机端
 * */
function IsPC() {
    var userAgentInfo = navigator.userAgent,
        Agents = ["Android", "iPhone",
        "SymbianOS", "Windows Phone",
        "iPad", "iPod"],
        flag = true;
    for (let v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}

//手机端时右侧侧边栏隐藏
if (!IsPC()) {
    sidebarHide();
}
window.onresize = function () {
    if (!IsPC()) {
        sidebarHide();
    }
    //设置content和myFrame的高度
    let $maxHeight = $('#sidebar').height();
    $('#content').height($maxHeight);
    $('#myFrame').height($maxHeight);
}

//显示侧边栏
function sidebarShow() {
    $('.sidebar-fixed').removeClass('change');
    $('.toggle-sidebar i').removeClass('icon-jiantouyou1').addClass('icon-jiantouzuo');
    $('#content').removeClass('change');
}

//隐藏侧边栏
function sidebarHide() {
    $('.sidebar-fixed').addClass('change');
    $('.toggle-sidebar i').removeClass('icon-jiantouzuo').addClass('icon-jiantouyou1');
    $('#content').addClass('change');
}
