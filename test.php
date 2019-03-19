<?php
header("Conten-type:text/html;charset=utf-8");

require "app/Database.php";

if ($con != null) {
    $result = $con->update("test", [
        "name" => "fuck"
    ], [
        "id" => 1
    ]);
    print($result->rowCount());
}
?>