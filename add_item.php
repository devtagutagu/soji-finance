<?php

require_once('db/dbinfo.php');

$mysqli = new mysqli($db['SERV'], $db['USER'], $db['PASS'],$db['DBNM']);
    if ($mysqli->connect_errno) {
      print('<p>DB Connect Failed.</p>' . $mysqli->connect_error);
      exit();
    }

$code = isset($_POST['code']) ? htmlspecialchars($_POST["code"], ENT_QUOTES) :  "codeが入力されていません。";
$buy_value = isset($_POST['buy_value']) ? htmlspecialchars($_POST["buy_value"], ENT_QUOTES) :  "buy_valueが入力されていません。";
$buy_num = isset($_POST['buy_num']) ? htmlspecialchars($_POST["buy_num"], ENT_QUOTES) :  "buy_numが入力されていません。";

//Make Query for Register new item.
$insert_query = "insert into main(code , buy_value , buy_num) values ( $code , $buy_value , $buy_num ) ";
$insert_result = $mysqli->query($insert_query);

if (!$insert_result) {
    echo ("Querry Error!");
    print_r($insert_result);
    $mysqli->close();
    exit();
}

$mysqli->close();

shell_exec("./get_my_finance_single.sh '$code'");
echo "Success. $code deleted database.";
header('Location: http://finance.tagutagu.com/finance');

?>
