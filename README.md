* You must create db/dbinfo.php for use this app.

touch db/dbinfo.php
echo '
<?php
$db['SERV'] = 'localhost';
$db['USER'] = 'admin';
$db['PASS'] = '*****';
$db['DBNM'] = 'finance';

?>
' >> db/dbinfo.php
