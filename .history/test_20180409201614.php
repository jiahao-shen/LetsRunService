<?php
header("Conten-type:text/html;charset=utf-8");
require "Common/Const.php";

$result = $con->select("add_friend_request", [
    "[>]user_list" => [
        "to_telephone" => "telephone"
    ]
    ], [
        "add_friend_request.from_telephone(A)",
        "add_friend_request.to_telephone(B)",
        "add_friend_request.message(C)",
        "user_list.username(D)"
    ]);
echo json_encode($result);
?>