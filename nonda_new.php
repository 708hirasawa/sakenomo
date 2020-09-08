<?php
require_once("db_functions.php");

$in_time = time();
$sake_id = $_POST['sake_id'];
$contributor = $_POST['contributor'];
//$username = $_COOKIE['login_cookie'];
$tablename = "TABLE_NONDA";

if(!$db = opendatabase("sake.db"))
{
	$return = "データベース接続エラー".$id;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$sql = "INSERT INTO TABLE_NONDA(sake_id, contributor, write_date, update_date, committed) VALUES ('$sake_id', '$contributor', '$in_time', '$in_time', 2)";
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "飲んだ登録エラー".$id;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$return = "success";
header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo ' <str>'.$return.'</str>'."\n";
echo ' <write_date>'.$in_time.'</write_date>'."\n";
echo ' <sql>'.$sql.'</sql>'."\n";
echo '</xml>'."\n";
?>
