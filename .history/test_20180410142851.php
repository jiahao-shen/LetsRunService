<?php
header("Conten-type:text/html;charset=utf-8");
require "Common/Const.php";

$list = array();
$a = array(
    "msg" => 1,
    "name" => "sam"
);
$b = array(
    "msg" => 3,
    "name" => "sam"
);
$c = array(
    "msg" => 6,
    "name" => "sam"
);
$d = array(
    "msg" => 4,
    "name" => "sam"
);
$e = array(
    "msg" => 2,
    "name" => "sam"
);
$f = array(
    "msg" => 5,
    "name" => "sam"
);
array_push($list, $a);
array_push($list, $b);
array_push($list, $c);
array_push($list, $e);
array_push($list, $f);
function my_sort($a, $b) {
    return $a < $b->msg;
}
usort($list, "my_sort");
// foreach($list as $value) {
//     echo json_encode($value)."\n";
// }
?>