<?php

/**
 * 用户已经登录的情况下根据telephone和token返回信息
 */
header("Conten-type:text/html;charset=utf-8");
require "app/Database.php";

$response = null;
if ($con == null) {
    $response = array(
        "msg" => request_failed,
    );
} else {
    $result = $con->get("user_list", "*", [
        "telephone" => "13915558435",
    ]);
    echo $result["count_step"];
}
// echo json_encode($response);
