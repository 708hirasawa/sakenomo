<?php

require_once("../db_functions.php");

$intime = time();
$username = $_COOKIE['login_cookie'];
$id = sqlite3::escapeString($_GET['id']);

if(!$db = opendatabase("../sake.db"))
{
	$return = "データベース接続エラー";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

$sql = "SELECT * FROM FOLLOW_J WHERE username = '$username' AND sakagura_id = '$id'";
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
		$sql = "DELETE FROM FOLLOW_J WHERE username = '$username' AND sakagura_id = '$id'";
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
		$sql = "INSERT INTO FOLLOW_J VALUES ('$username', '$id', '$intime')";
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
