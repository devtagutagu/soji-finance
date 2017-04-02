<?php

//Require edit
require_once('db/dbinfo.php');

$mysqli = new mysqli($db['SERV'], $db['USER'], $db['PASS'],$db['DBNM']);
    if ($mysqli->connect_errno) {
      print('<p>DB Connect Failed.</p>' . $mysqli->connect_error);
      exit();
    }

$select_query = "select * from main";
$select_result = $mysqli->query($select_query);

if (!$select_result) {
    echo ("Querry Error!");
    print_r($update_result);
    $mysqli->close();
    exit();
}

echo <<< EOT1

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>若林荘次専用　株価情報</title>
  <link href="css/bootstrap.css" rel="stylesheet">

<!--

-->

</head>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="jquery.bootgrid/jquery.bootgrid.js"></script>

<section class="panel panel-default">

    <div class="panel-heading"><h1>若林荘次専用　株価情報</h1></div>
    <div class="panel-body">

        <ul class="nav nav-tabs">
            <li class='active'> <a data-toggle="tab" href="#menu1">株価を表示する。</a></li>
            <li>		<a data-toggle="tab" href="#menu2">銘柄を登録する。</a></li>
        </ul>

        <div class="tab-content">
            <div id="menu1" class="tab-pane fade in active">
		<table  class="table table-bordered">
        	<thead>
                 <tr class="warning">
                        <th>証券コード</th>
                        <th>銘柄名</th>
                        <th>株価</th>
                        <th>最終チェック日時</th>
                        <th>取得単価</th>
                        <th>保有株数</th>
                        <th>損益</th>
                        <th>その他</th>
			<th>削除</th>
                 </tr>
		</thead>
		<tbody>

EOT1;
while ($row = $select_result->fetch_assoc()) {

		echo "<tr>";
		echo "<td><a href='https://stocks.finance.yahoo.co.jp/stocks/detail/?code=$row[code].T' target=\"_blank\">$row[code]</a></td>";
		echo "<td>$row[name]</td>";
		//echo "<td>$row[last_value]</td>";
		echo "<td>".number_format($row[last_value])."</td>" ;
		echo "<td>$row[last_date]</td>";
		//echo "<td>$row[buy_value]</td>";
		echo "<td>".number_format($row[buy_value])."</td>" ;
		echo "<td>$row[buy_num]株</td>";

		//get profits
		$cost_total = "$row[buy_value]" * "$row[buy_num]";
		$now_value  = "$row[last_value]" * "$row[buy_num]";
		$profits = $now_value - $cost_total ;

		if ($profits > 0 ){
			echo "<td class='text-success'>".number_format($profits)."</td>" ;
		}else{
			echo "<td class='text-danger'>".number_format($profits)."</td>" ;
		}

		//get chart
		//echo "<td>$row[etc]</td>";
		//echo "<td><img src='http://quote.nomura.co.jp/nomura/cgi-bin/chart21.exe?template=chart/Jchart_kabu&mode=D&basequote=$row[code]/T'></td>";
		echo "<td><img src='https://chart.yahoo.co.jp/?code=$row[code].T&tm=5d&size=e&vip=off' border='1'></td>";

		//delete js
		echo "<td>";
		echo "<form name='clear_$row[code]' method='POST' action='clear.php'>";
                echo '<input type=hidden name=code value=';
                echo "$row[code] >";
                //echo "<script>console.log(document.testtaguchi)</script>";
                echo '</form>';
                echo "<a href='javascript:document.clear_$row[code].submit()'>delete<br></a>";
		echo "</td>";

		echo "</tr>";
}

echo <<< EOT2
		</table>
            </div>

            <div id="menu2" class="tab-pane fade ">
                <h3>銘柄の情報を新規登録します。</h3>
		<form action="add_item.php" method="post">
		<div class="form-group">
			<label>証券番号 （4ケタ）:</label>
			<input  type="number" min="1" max="9999" name="code"><br><br>
			<label>保有株数  :</label>
			<input  type="number" name="buy_num"><br><br>
			<label>取得価格（1株あたり）:</label>
			<input  type="number" name="buy_value"><br><br>
			<button type="submit" class="btn btn-success">登録する</button>
		</form>
		</div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

(function () {
  function sort(tbody, compareFunction) {
    var rows = tbody.children;
    if(!rows || !rows[0] || rows.length == 1) return;
    var size = rows.length;
    var arr = [];
    for(var i = 0; i < size; i++) arr.push(rows[i]);
    arr.sort(compareFunction);
    for(var i = size - 1; i > 0; i--) tbody.insertBefore(arr[i-1], arr[i]);
  }
  function numConvert(s) {
    return s == Number(s) ? Number(s) : s;
  }
  function asc(idx) {
    return function(a, b) {
      var a_ = numConvert(a.children[idx].innerText);
      var b_ = numConvert(b.children[idx].innerText);
      return a_ > b_ ? 1 : -1;
    };
  }
  function desc(idx) {
    return function(a, b) {
      var a_ = numConvert(a.children[idx].innerText);
      var b_ = numConvert(b.children[idx].innerText);
      return a_ < b_ ? 1 : -1;
    };
  }
  function sortEvent(tbody, idx) {
    var mode = true;
    return function(e) {
      if(mode) sort(tbody,  asc(idx));
      else     sort(tbody, desc(idx));
      mode = !mode;
    };
  }
  var ts = document.getElementsByTagName('table');
  for(var i = ts.length; i--; ) {
    var ths = ts[i].tHead.getElementsByTagName('th');
    for(var j = ths.length; j--; )
      ths[j].addEventListener("click", sortEvent(ts[i].tBodies[0], j));
  }
})();

</script>

</body>
</html>

EOT2;
?>
