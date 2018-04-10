<?php

/**
 * 注册服务
 */
header("Content-type:text/html;charset=utf-8");
require "Common/Const.php";

define("path", "./UserImage/");
define("telephone_not_exist", 11);
define("unknown_error", 13);
define("check_phone", 20);
define("register", 21);
define("telephone_already_exist", 22);
define("register_success", 23);

$response = null;
if ($con == null) { //数据库连接失败
    $response = array(
        "msg" => unknown_error,
    );
} else {
    $request = json_decode($_POST["request"]);  //接受http请求并解析成json对象
    $msg = $request->msg;   //获取请求方式
    switch ($msg) {
        case check_phone:   //检查手机号是否已经被注册
            $telephone = $request->telephone;   //获取手机号
            $result = $con->get("user_list", "telephone", [
                "telephone" => $telephone,  
            ]);
            if ($result) {
                $response = array(
                    "msg" => telephone_already_exist,   //手机号已经被注册
                );
            } else {
                $response = array(
                    "msg" => telephone_not_exist,   //手机号没有被注册
                );
            }
            break;
        case register:  //注册
            $user = $request->user; //获取用户对象
            $telephone = $user->telephone;  //获取手机
            $password = password_hash($user->password, PASSWORD_DEFAULT);   //获取md5加密后的密码并进行二次加密
            $username = $user->username;    //获取用户名
            $gender = $user->gender;    //获取性别
            $birthday = $user->birthday;    //获取生日
            $blood = $user->blood;  //获取血型
            $height = $user->height;    //获取身高
            $weight = $user->weight;    //获取体重
            $img = $_FILES["img"];  //获取头像
            $token = md5(uniqid()); //随机生成token
            $result = $con->insert("user_list", [    //插入用户数据
                "telephone" => $telephone,
                "password" => $password,
                "username" => $username,
                "gender" => $gender,
                "birthday" => $birthday,
                "blood" => $blood,
                "height" => $height,
                "weight" => $weight,
                "token" => $token,  //插入用户数据的同时插入刚刚生成的token
            ]);
            if ($result->rowCount()) {      //插入用户数成功
                move_uploaded_file($img["tmp_name"], path . $img["name"]);  //保存图片
                $response = array(  //返回注册成功的信息
                    "msg" => register_success,
                    "token" => $token
                );
            } else {    //插入数据失败
                $response = array(
                    "msg" => unknown_error
                );
            }
            break;
    }
}
echo json_encode($response);
?>