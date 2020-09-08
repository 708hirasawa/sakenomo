<?php

require_once("db_functions.php");
$sake_id = sqlite3::escapeString($_GET['sake_id']);

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$username = $_COOKIE['login_cookie'];
$sake_id = $_POST['sake_id'];

$sql = "SELECT * FROM NOMITAI_J WHERE sake_id = '$sake_id' AND username = '$username'";
$res = executequery($db, $sql);

if(!res)
{
	$return = "failed:" .$sql;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
else
{
	$row = getnextrow($res);

	if($row) 
	{
		$return = "success";
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <sql>'.$sql.'</sql>'."\n";
		echo ' <tastes>'.$row[nomitai_values].'</tastes>'."\n";
		echo '</xml>'."\n";
	}
	else
	{
		$return = "none:" .$sql;
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <sql>'.$sql.'</sql>'."\n";
		echo '</xml>'."\n";
	}
}
?>
