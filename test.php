<?php
header("Conten-type:text/html;charset=utf-8");

require "Common/Const.php";

if ($con != null) {
    $result = $con -> select("user_list", "*");
    echo json_encode($result);
}
?>