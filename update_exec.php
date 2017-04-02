<?php

require_once('db/dbinfo.php');

//$now_time = date("Y-m-t");

$mysqli = new mysqli($db['SERV'], $db['USER'], $db['PASS'],$db['DBNM']);
    if ($mysqli->connect_errno) {
      print('<p>DB Connect Failed.</p>' . $mysqli->connect_error);
      exit();
    }

$code = isset($_POST['code']) ? htmlspecialchars($_POST["code"], ENT_QUOTES) :  "codeが入力されていません。";
$name = isset($_POST['name']) ? htmlspecialchars($_POST["name"], ENT_QUOTES) :  "nameが入力されていません。";
$last_value = isset($_POST['last_value']) ? htmlspecialchars($_POST["last_value"], ENT_QUOTES) :  "last_valueが入力されていません。";
$time_value = isset($_POST['time_value']) ? htmlspecialchars($_POST["time_value"], ENT_QUOTES) :  "time_valueが入力されていません。";

$update_query = "update main set name = '$name' , last_value = $last_value , last_date = '$time_value' where code = $code";
$update_result = $mysqli->query($update_query);

if (!$update_result) {
    echo ("Querry Error!");
    print_r($update_result);
    $mysqli->close();
    exit();
}

$mysqli->close();

?>
