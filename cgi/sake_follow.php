﻿<?php

require_once("../db_functions.php");
$username = $_COOKIE['login_cookie'];
$sake_id = sqlite3::escapeString($_GET['sake_id']);

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

$sql = "SELECT * FROM FAVORITE_J WHERE username = '$username' AND sake_id = '$sake_id'";
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
		$count = 0;
		$sql1 = "DELETE FROM FAVORITE_J WHERE username = '$username' AND sake_id = '$sake_id'";
		$res = executequery($db, $sql1);

		if(!$res)
			$return = "failed";
		else
			$return = "unfollowed";

		$sql2 = "SELECT COUNT(*) FROM FAVORITE_J WHERE sake_id = '$sake_id'";
		$res = executequery($db, $sql2);

		if($row = getnextrow($res)) {
			$count = $row["COUNT(*)"];
		}

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <count>'.$count.'</count>'."\n";
		echo ' <sql>'.$sql1.'</sql>'."\n";
		echo '</xml>'."\n";
	}
	else
	{
		$in_time = time();
		$count = 0;
		$sql1 = "INSERT INTO FAVORITE_J VALUES ('$username', '$sake_id', '$in_time')";
		$res = executequery($db, $sql1);

		if(!$res)
			$return = "failed";
		else
			$return = "followed";

		$sql2 = "SELECT COUNT(*) FROM FAVORITE_J WHERE sake_id = '$sake_id'";
		$res = executequery($db, $sql2);

		if($row = getnextrow($res)) {
			$count = $row["COUNT(*)"];
		}

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <count>'.$count.'</count>'."\n";
		echo ' <sql>'.$sql1.'</sql>'."\n";
		echo '</xml>'."\n";
	}
}
?>
