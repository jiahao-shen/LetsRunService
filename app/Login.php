<?php 
header("Content-type:text/html;charset=utf-8");
require "Database.php";

define("login_success", 10);
define("telephone_not_exist", 11);
define("password_error", 12);
define("unknown_error", 13);
define("already_login", 14);
/**
 * 登录服务
 * 根据用户发来的telephone和token来判断登录
 * 返回登录结果和信息
 */
$response = null;

// 判断数据库连接
if ($con == null) {
    // 返回msg
    $response = array(
        "msg" => unknown_error,
    );
} else {
    $request = json_decode($_POST["request"]); //获取http请求并解析成json对象
    $telephone = $request->telephone;   //获取电话号码
    $password = $request->password; //获取密码
    $result = $con->get("user_list", "*", [  //根据telephone获取用户result
        "telephone" => $telephone
    ]);
    if (!$result["telephone"]) {  //判断telephone是否为空
        $response = array(
            "msg" => telephone_not_exist    //手机号不存在
        );
    } else {    //手机号存在
        if ($result["token"]) { //判断token
            $response = array(
                "msg" => already_login  //token存在,已经登录
            );
        } else {    //token不存在,可以登录
            if (!password_verify($password, $result["password"])) { //用hash_password判断md5码加密后的密码是否一直
                $response = array(
                    "msg" => password_error //密码不正确
                );
            } else {
                $token = md5(uniqid()); //随机生成token
                if($con->update("user_list",[    //插入token
                    "token" => $token
                ],[
                    "telephone" => $telephone
                ])) {
                    $response = array(
                        "msg" => login_success, //登录成功
                        "token" => $token,  //返回token
                        "user" => array(    //返回用户信息
                            "telephone" => $result["telephone"],
                            "username" => $result["username"],
                            "birthday" => $result["birthday"],
                            "gender" => $result["gender"],
                            "blood" => $result["blood"],
                            "height" => $result["height"],
                            "weight" => $result["weight"],
                            "signature" => $result["signature"],
                            )
                        );
                } else {    //未知错误
                    $response = array(
                        "msg" => unknown_error
                    );
                }
            }
        }
    }
}
echo json_encode($response);    //打包成json返回给客户端
?>