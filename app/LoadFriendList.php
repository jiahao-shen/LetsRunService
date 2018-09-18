<?php

/**
 * 用户已经登录的情况下根据telephone和token返回信息
 */
header("Conten-type:text/html;charset=utf-8");
require "Database.php";

define("unknown_error", 13);
define("load_friend_list_success", 60);

function my_sort($x, $y) {
    return $x["username"] > $y["username"];
}
$response = null;
if ($con == null) {
    $response = array(
        "msg" => unknown_error
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
    if ($result != null) {
        $list = $result["friend_list"] ? json_decode($result["friend_list"]) : array();
        $friend_list = array();
        foreach($list as $value) {
            $friend = $con->get("user_list", [
                "telephone",
                "username",
                "signature",
                "device"
            ], [
                "telephone" => $value
            ]);
            array_push($friend_list, $friend);
        }
        usort($friend_list, "my_sort");
        $response = array(
            "msg" => load_friend_list_success,
            "friendList" => $friend_list
        );
    } else {
        $response = array(
            "msg" => unknown_error
        );
    }
}
echo json_encode($response);
?>