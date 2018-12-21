## 车辆信息管理系统
1、在 `mysql` 新建数据库 `carsinfo`，导入 `carsinfo.sql` 
2、修改目录`./application/configs/config.php` 里面的 `DBUser` 和 `DBPass` 改为自己 `mysql` 的用户名密码
3、项目放在服务器运行即可
4、车辆管理系统默认管理员账号：admin，密码：123
5、由于安全问题需要开启图片上传配置，才能修改图片
    1. 打开 `php.ini`
    2. 查找 `fileinfo` 注释这行
    3. 查找 `date.timezone` 改为 `date.timezone = PRC`
    4、即可上传图片
