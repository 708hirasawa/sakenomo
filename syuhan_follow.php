<?php

require_once("db_functions.php");

$username = $_COOKIE['login_cookie'];
$syuhanten_id = sqlite3::escapeString($_GET['syuhanten_id']);

if(!$db = opendatabase("sake.db"))
{
	$return = "データベース接続エラー";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

$sql = "SELECT * FROM FOLLOW_SYUHANTEN_J WHERE username = '$username' AND syuhanten_id = '$syuhanten_id'";
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}
else
{
	if($row = getnextrow($res))
	{
		$sql = "DELETE FROM FOLLOW_SYUHANTEN_J WHERE username = '$username' AND syuhanten_id = '$syuhanten_id'";
		$res = executequery($db, $sql);

		if(!$res)
			$return = "failed";
		else
			$return = "follow";

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
	}
	else
	{
		$sql = "INSERT INTO FOLLOW_SYUHANTEN_J VALUES ('$username', '$syuhanten_id')";
		$res = executequery($db, $sql);

		if(!$res)
			$return = "failed";
		else
			$return = "followed";

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
	}
}
?>
