<?php
/**
 * 查找用户
 * 根据用户传来的query查询
 * 判断用户是否存在,是否是好友等
 */
header("Content-type:text/html;charset=utf-8");
require "Common/Const.php";

define("unknown_error", 13);
define("user_not_exist", 50);
define("user_already_friend", 51);
define("user_not_friend", 52);

$response = null;

if ($con == null) {
    $response = array(
        "msg" => unknown_error
    );
} else {
    $request = json_decode($_POST["request"]);
    $telephone = $request->telephone;
    $token = $request->token;
    $query = $request->query;
    $result = $con->get("user_list", "*", [
        "AND" => [
            "telephone" => $telephone,
            "token" => $token
        ]
    ]);
    if ($result != null) {
        $row = $con->get("user_list", "*", [
            "telephone" => $query
        ]);
        if ($row != null) {       //存在该用户
            $username = $row["username"];   //获取用户名

            $friend_list = $result["friend_list"] ? json_decode($result["friend_list"]) : array();  //获取好友列表

            if (in_array($query, $friend_list)) {   //好友列表中已经存在
                $response = array(
                    "msg" => user_already_friend,
                    "telephone" => $query,
                    "username" => $username,
                );
            } else {        //好友列表中不存在
                $response = array(
                    "msg" => user_not_friend,
                    "telephone" => $query,
                    "username" => $username,
                );
            }
        } else {    //不存在该用户
            $response = array(
                "msg" => user_not_exist,
                "telephone" => $query
            );
        }
    } else {
        $response = array(
            "msg" => unknown_error
        );
    }
}
echo json_encode($response);

?>