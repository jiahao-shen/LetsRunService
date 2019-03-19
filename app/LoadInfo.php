<?php

/**
 * 用户已经登录的情况下根据telephone和token返回信息
 */
header("Conten-type:text/html;charset=utf-8");
require "Database.php";

define("request_success", 40);
define("request_failed", 41);

$response = null;
if ($con == null) {
    $response = array (
        "msg" => request_failed
    );
} else {
    $request = json_decode($_POST["request"]);
    $telephone = $request->telephone;
    $token = $request->token;
    $result = $con->get("user_list", "*", [
        "AND" => [
            "telephone" => $telephone, 
            "token" => $token
        ]
    ]);
    if ($result == null) {
        $response = array(
            "msg" => request_failed
        );
    } else {
        $response = array(
            "msg" => request_success,
            "user" => array(
                "telephone" => $result["telephone"],
                "username" => $result["username"],
                "birthday" => $result["birthday"],
                "gender" => $result["gender"],
                "blood" => $result["blood"],
                "height" => $result["height"],
                "weight" => $result["weight"],
                "isCountStep" => $result["is_count_step"],
                "goalSteps" => $result["goal_steps"],
                "signature" => $result["signature"],
            )
        );
    }
}
echo json_encode($response);    
?>