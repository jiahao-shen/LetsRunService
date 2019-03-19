<?php 
header("Content-type:text/html;charset=utf-8");
require "Database.php";

define("unknown_error", 13);
define("update_user_info_succcess", 70);
define("update_user_info_failed", 71);
/**
 * 修改用户数据
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
    $token = $request->token;
    $user = $request->user;

    $username = $user->username;
    $gender = $user->gender;
    $birthday = $user->birthday;
    $blood = $user->blood;
    $height = $user->height;
    $weight = $user->weight;
    $isCountStep = $user->isCountStep;
    $goalSteps = $user->goalSteps;
    $signature = $user->signature;

    $result = $con->update("user_list", [
        "username" => $username,
        "gender" => $gender,
        "birthday" => $birthday,
        "blood" => $blood,
        "height" => $height,
        "weight" => $weight,
        "goal_steps" => $goalSteps,
        "is_count_step" => $isCountStep,
        "signature" => $signature
    ], [
        "token" => $token
    ]);
    if ($result->rowCount()) {
        $response = array(
            "msg" => update_user_info_succcess
        );
    } else {
        $response = array(
            "msg" => update_user_info_failed
        );
    }
}
echo json_encode($response);    //打包成json返回给客户端
?>