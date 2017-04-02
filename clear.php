<?php

//Prepare DB setting
require_once('db/dbinfo.php');
$mysqli = new mysqli($db['SERV'], $db['USER'], $db['PASS'],$db['DBNM']);
    if ($mysqli->connect_errno) {
      print('<p>DB Connect Failed.</p>' . $mysqli->connect_error);
      exit();
    }
//set Post data for delete DB record
$code = isset($_POST['code']) ? htmlspecialchars($_POST["code"], ENT_QUOTES) :  "codeが入力されていません。";
$query  = "DELETE FROM main WHERE code = '$code'";
$result = $mysqli->query($query);

//Check result
if (!$result) {
    echo ("Querry Error!");
    $mysqli->close();
    exit();
}
$mysqli->close();

//print message.
echo "Success. $code deleted database.";
header('Location: http://finance.tagutagu.com/finance');
exit
?>
