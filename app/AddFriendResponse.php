<?php
header("Content-type:text/html;charset=utf-8");
require "Database.php";

define("add_friend_agree", 3);
define("add_friend_refuse", 4);
define("add_friend_success", 5);
define("unknown_error", 13);

$response = null;

if ($con == null) {
    $response = array(
        "msg" => unknown_error
    );
} else {
    $request = json_decode($_POST["request"]);  //获取请求体
    $telephone = $request->telephone;   //获取手机号
    $token = $request->token;   //
    $msg = $request->msg;  //获取msg 
    $response_list = $request->responseList;    //获取请求列表
    
    if ($con->get("user_list", "*", [   //验证token
        "AND" => [
            "telephone" => $telephone,
            "token" => $token
        ]
    ])) {
        foreach($response_list as $value) { //遍历请求列表
            $from_telephone = $value->fromTelephone;    //获取from_telephone
            $to_telephone = $value->toTelephone;    //获取to_telephone
            
            $con->delete("add_friend_request", [    //删除对应表中的请求
                "AND" => [
                    "from_telephone" => $from_telephone,
                    "to_telephone" => $to_telephone
                ]
            ]);

            if ($msg == add_friend_agree) { //如果用户同意好友添加
                $result = $con->get("user_list", "friend_list", [   //获取from_telephone的好友列表
                    "telephone" => $from_telephone
                ]);

                $from_friend_list = $result ? json_decode($result) : array();
                
                if (!in_array($to_telephone, $from_friend_list)) {  //如果from_telephone中不存在好友to_telephone
                    array_push($from_friend_list, $to_telephone);   //添加to_telephone到from_friend_list中
                    $con->update("user_list", [ //更新from_friend_list
                        "friend_list" => json_encode($from_friend_list)
                    ], [
                        "telephone" => $from_telephone
                    ]);
                }

                $result = $con->get("user_list", "friend_list", [   //获取to_telephone的好友列表
                    "telephone" => $to_telephone
                ]);
                
                $to_friend_list = $result ? json_decode($result) : array();
                
                if (!in_array($from_telephone, $to_friend_list)) {  //如果to_telephone中不存在好友from_telephone
                    array_push($to_friend_list, $from_telephone);   //添加from_telephone到to_friend_list中
                    $con->update("user_list", [     //更新to_friend_list
                        "friend_list" => json_encode($to_friend_list)
                    ], [
                        "telephone" => $to_telephone
                    ]);
                }

            }
        }
        $response = array(
            "msg" => add_friend_success
        );
    } else {
        $response = array(
            "msg" => unknown_error
        );
    }
}
echo json_encode($response);
?>