<?php
header("Conten-type:text/html;charset=utf-8");
require "Common/Const.php";

$list = array();
$a = array(
    "msg" => 1,
    "name" => "sam"
);
$b = array(
    "msg" => 1,
    "name" => "sam"
);
$c = array(
    "msg" => 1,
    "name" => "sam"
);
$d = array(
    "msg" => 1,
    "name" => "sam"
);
$e = array(
    "msg" => 1,
    "name" => "sam"
);
$f = array(
    "msg" => 1,
    "name" => "sam"
);
array_push($list, $a);
array_push($list, $b);
array_push($list, $c);
array_push($list, $e);
array_push($list, $f);

?>