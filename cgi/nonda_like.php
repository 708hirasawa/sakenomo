<?php

require_once("../db_functions.php");
$username = $_COOKIE['login_cookie'];
$username =	(isset($_POST['username']) && $_POST['username'] != 'undefined') ? $_POST['username'] : "";
$contributor = (isset($_POST['contributor']) && $_POST['contributor'] != 'undefined') ? $_POST['contributor'] : "";
$sake_id = (isset($_POST['sake_id']) && $_POST['sake_id'] != 'undefined') ? $_POST['sake_id'] : "";

if($username == "" || $contributor == "" || $sake_id == "") 
{
	$return = "データベース接続エラー";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

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

$sql = "SELECT TABLE_NONDA.contributor AS contributor, TABLE_NONDA.sake_id AS sake_id, username FROM NONDA_LIKE, TABLE_NONDA WHERE NONDA_LIKE.username = '$username' AND TABLE_NONDA.contributor = '$contributor' AND TABLE_NONDA.sake_id = '$sake_id' AND TABLE_NONDA.contributor = NONDA_LIKE.contributor AND TABLE_NONDA.sake_id = NONDA_LIKE.sake_id";
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
		$sql1 = "DELETE FROM NONDA_LIKE WHERE username = '$username' AND sake_id = '$sake_id' AND contributor = '$contributor'";
		$res = executequery($db, $sql1);

		//if(!$res)
		//	$return = "liked";
		//else
			$return = "unliked";

		$sql2 = "SELECT COUNT(*) FROM NONDA_LIKE WHERE contributor = '$contributor' AND sake_id = '$sake_id'";
		$res = executequery($db, $sql2);

		if($row = getnextrow($res)) {
			$count = $row["COUNT(*)"];
		}

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <count>'.$count.'</count>'."\n";
		echo ' <sql>'.$sql2.'</sql>'."\n";
		echo '</xml>'."\n";
	}
	else
	{
		$in_time = time();
		$count = 0;

		$sql1 = "INSERT INTO NONDA_LIKE VALUES('$username', '$contributor', '$sake_id', '$in_time')";
		$res = executequery($db, $sql1);

		if(!$res)
			$return = "unliked";
		else
			$return = "liked";

		$sql2 = "SELECT COUNT(*) FROM NONDA_LIKE WHERE sake_id = '$sake_id' AND contributor = '$contributor'";
		$res2 = executequery($db, $sql2);

		if($row = getnextrow($res2)) {
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
