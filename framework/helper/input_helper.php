<?php


//辅助函数

//批量防止SQL注入攻击

/*
 * @param $data array
 * @return string
 */
function deepslashes($data){
    //判断$data的表现形式,并且需要处理空的情况
    if(empty($data)){
        return $data;
    }

    return is_array($data)?array_map('deepslashes',$data):addslashes($data);

    /* 初级写法
    if(is_array($data)){
            //数组批量处理
            foreach($data as $v){
                return deepslashes($v);
            }
    }
    else{
            //单一变量处理
        return addslashes($data);
    }
    */
}

//批量实体转义(防御XSS跨站脚本攻击)
function deepspecialchar($data){
    if(empty($data)){
        return $data;
    }

    //判断是单一数据还是批量数据
    return is_array($data)?array_map('deepspecialchar',$data) : htmlspecialchars($data);
}
?>