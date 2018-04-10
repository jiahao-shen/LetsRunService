<?php
/**
 * 退出登录服务
 * 根据telephone和token来注销token
 */
header("Content-type:text/html;charset=utf-8");
require "Common/Const.php";

define("unknown_error", 13);
define("logout_success", 30);
define("logout_failed", 31);

$response = null;

if ($con == null) {
    $response = array(
        "msg" => unknown_error
    );
} else {
    $request = json_decode($_POST["request"]);
    $telephone = $request->telephone;
    $token = $request->token;
    if ($con->get("user_list", "*", [
        "AND" => [
            "telephone" => $telephone, 
            "token" => $token
        ]
    ])) {
        $con->update("user_list", [
            "token" => null
        ],[
            "telephone" => $telephone
        ]);
        $response = array(
            "msg" => logout_success
        );
    } else {
        $response = array(
            "msg" => logout_failed
        );
    }
}
echo json_encode($response);
?>