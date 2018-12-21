<?php
class Upload{
    private $FileSize;
    private $allow_ext_list;
    private $allow_mime_list;
    private $mime_map;
    private $Error;
    private $FilePath;
    private function GetError(){
        return $this->Error;
    }
    public function __construct()
    {
        $this->FileSize = 1024*1024;
        $this->allow_ext_list = array('.png','.gif','.jpg','.jpeg');
        $this->allow_mime_list = array();
        $this->mime_map = array(
            '.jpeg'=>array('image/jpeg','image/pjpeg','image/jpg'),
            '.jpg'=>array('image/jpeg','image/pjpeg','image/jpg'),
            '.gif'=>array('image/gif'),
            '.png'=>array('image/png','image/x-png')
        );
        $this->FilePath = './public/';
    }
    public function UploadOne($File){
        if($File['size'] > $this->FileSize){
            $this->Error='文件过大';
        }
        if($File['error']!=0){
            $this->Error='文件错误';
        }
        $ext = strtolower(strrchr($File['name'],'.'));
        if(!in_array($ext,$this->allow_ext_list)){
            $this->Error='文件后缀错误!!!';
        }
        foreach($this->allow_ext_list as $value){
            $this->allow_mime_list = array_merge($this->allow_mime_list,$this->mime_map[$value]);
        }
        $this->allow_mime_list = array_unique($this->allow_mime_list);
        if(!in_array($File['type'],$this->allow_mime_list)){
            $this->Error='文件协议错误!!!';
        }
        $Obj = new Finfo(FILEINFO_MIME_TYPE);
        $type = $Obj->file($File['tmp_name']);
        if(!in_array($type,$this->allow_mime_list)){
            $this->Error='文件协议错误!!!';
        }
        $SubFile = date('YMDS').'/';
        if(!is_dir($this->FilePath.$SubFile)){
            mkdir($this->FilePath.$SubFile);
        }
        $Prefix = "Img_";
        $FileName = uniqid($Prefix,true).$ext;
        $APath = $this->FilePath.$SubFile.$FileName;
        if(move_uploaded_file($File['tmp_name'],$APath)){
            return $APath;
        }
        else{
            return false;
        }
    }
}
?>