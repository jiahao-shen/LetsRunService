<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;

define("socket_login", 1);
define("socket_add_friend", 2);
define("unknown_error", 13);


/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */

class Events {

    public static function onWorkerStart($businessWorker) {
    }

    public static function onConnect($client_id) {
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message) {
        global $con;    //获取数据库对象
        $response = null;
        $request = json_decode($message);   //解析请求体
        $msg = $request->msg;   //获取方式
        $telephone = $request->telephone;   //用户手机号
        $token = $request->token;   //用户token
        if ($con->get("user_list", "*", ["telephone" => $telephone, "token" => $token])) {    //验证token和手机号是否匹配
            switch($msg) {  //判断socket请求方式
                case socket_login:  //登录请求
                    $device = $request->info;
                    $con->update("user_list", [     //更新client_id
                        "client_id" => $client_id
                        "device" => $device
                    ], [
                        "telephone" => $telephone
                    ]);
                    echo "login:$telephone,$client_id\n";
                    $result = $con->select("add_friend_request", [
                        "[>]user_list" => [
                            "from_telephone" => "telephone"
                        ]
                        ], [
                            "add_friend_request.from_telephone(fromTelephone)",
                            "add_friend_request.to_telephone(toTelephone)",
                            "add_friend_request.message(message)",
                            "user_list.username(fromUserName)"
                        ], [
                            "add_friend_request.to_telephone" => $telephone
                        ]);
                    $response = array(
                        "msg" => socket_login,
                        "info" => $result
                    );
                    Gateway::sendToCurrentClient(json_encode($response));
                    $_SESSION["telephone"] = $telephone;    //session保存该连接的电话号码
                    break;
                case socket_add_friend: //添加好友请求
                    $info = $request->info; //获取请求的具体内容
                    $from_telephone = $info->fromTelephone; //获取来源手机号
                    $from_username = $info->fromUserName;   //获取来源用户名
                    $to_telephone = $info->toTelephone; //获取请求对象的手机号
                    $message = $info->message;  //获取请求验证消息

                    $insert_result = $con->insert("add_friend_request", [  //插入到好友申请表中
                        "from_telephone" => $from_telephone,
                        "to_telephone" => $to_telephone,
                        "message" => $message
                    ]);
                    
                    if ($insert_result->rowCount()) {
                        $response = array(  //打包返回数据
                            "msg" => socket_add_friend,
                            "info" => array(
                                "fromTelephone" => $from_telephone,
                                "fromUserName" => $from_username,
                                "message" => $message,
                                "toTelephone" => $to_telephone
                            )
                        );
    
                        $to_client_id = $con->get("user_list", "client_id", [
                            "telephone" => $to_telephone
                        ]);     //获取请求对象的client_id
                        Gateway::sendToClient($to_client_id, json_encode($response));   //发送给指定对象
                    }
                    break;
            }
        } else {
            $response = array(      //token验证失败,返回未知错误
                "msg" => unknown_error
            );
            Gateway::sendToCurrentClient(json_encode($response));
        }
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id) {
       echo "logout: $client_id\n";
       global $con;
       $con->update("user_list", [
           "client_id" => null
       ], [
           "telephone" => $_SESSION["telephone"]        //断开连接后从session中获取telephone并删除client_id
       ]);
   }
}
