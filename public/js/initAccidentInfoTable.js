/**
 * Created by Machenike on 2018/5/19.
 */
$(document).ready(function () {
    //新建数据处理工具，实现获取数据，查询数据，页码跳转功能
    processData('../../index.php?p=Admin&c=AccidentInfo&a=InfoLists','../../index.php?p=Admin&c=AccidentInfo&a=AccidentInfos','accident','Wid');
}())


