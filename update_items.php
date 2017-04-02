<?php

require_once('db/dbinfo.php');

$mysqli = new mysqli($db['SERV'], $db['USER'], $db['PASS'],$db['DBNM']);
    if ($mysqli->connect_errno) {
      print('<p>DB Connect Failed.</p>' . $mysqli->connect_error);
      exit();
    }

$get_ids_query = 'SELECT code from main;';
$id_result = $mysqli->query($get_ids_query);

if (!$id_result) {
    echo ("Querry Error!");
    $mysqli->close();
    exit();
}

while ($row = $id_result->fetch_assoc()) {
	echo "$row[code]\n";
}

$mysqli->close();

?>
