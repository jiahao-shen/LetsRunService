<?php
/**
 * 常量类,定义数据库对象
 */
require dirname(__DIR__)."/Medoo/vendor/autoload.php";

use Medoo\Medoo;
define("db_address", "127.0.0.1");
define("db_account", "root");
define("db_password", "258667");
define("db_name", "LetsRun");

$con = new Medoo([
    "database_type" => "mysql",
    "database_name" => db_name,
    "server" => db_address,
    "username" => db_account,
    "password" => db_password,
    "charset" => "utf-8"
]);


?>