<?php

print <<< EOT1

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ops Work Tools</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

EOT1;

$host_name = isset($_POST['server_name']) ? htmlspecialchars($_POST["server_name"], ENT_QUOTES) :  "server_nameが入力されていません。";

$array = explode("\n", $host_name);
$array = array_map('trim', $array);
$array = array_filter($array, 'strlen');
$array = array_values($array);

//print_r($array);

echo "<h1>Result</h1><hr>";

print <<< EOT3

	<div class="table-responsive">
	<table class="table">
	<thead><tr><td>

EOT3;

	for($i = 0; $i < count($array); $i++) {
		$url  = "http://dump.linecorp.com/opsdb/api/v1/host/$array[$i]";
		$json = file_get_contents($url);
		$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
		$arr  = json_decode($json,true);
		if ($arr === NULL) {
			return;
		}else{
		echo "<b>$array[$i]</b><br>";
			$summary_data1 = $arr['host']["0"]['dev_adm_emp_info1'];
			$summary_arr1 = explode("|", $summary_data1);
			$summary_data2 = $arr['host']["0"]['dev_adm_emp_info2'];
			$summary_arr2 = explode("|", $summary_data2);
			echo "$summary_arr1[2] <br>";
			echo "$summary_arr2[2] <br>";
			//print_r($summary_arr);
		}
	}
echo "</td></tr>";
echo "</table></div>";

print <<< EOT2

</body>
</html>

EOT2;
?>
