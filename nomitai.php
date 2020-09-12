<?php

require_once("db_functions.php");
$sake_id = sqlite3::escapeString($_GET['sake_id']);

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$username = $_COOKIE['login_cookie'];
$sake_id = $_POST['sake_id'];
$nomitai_values = $_POST['taste'];

$sql = "SELECT * FROM NOMITAI_J WHERE sake_id = '$sake_id' AND username = '$username'";
$res = executequery($db, $sql);
$row = getnextrow($res);

if(!$row) 
{
	$in_time = time();
	$sql = "INSERT INTO NOMITAI_J(sake_id, username, nomitai_values, nomitai_date) VALUES ('$sake_id', '$username', '$nomitai_values', '$in_time')";
	$res = executequery($db, $sql);

	if(!$res)   
	{
		$return = "failed" .$sql;
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
	}
	else
	{
		$return = "success";
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <sql>'.$sql.'</sql>'."\n";
		echo '</xml>'."\n";
	}
}
else
{
	$item = "";

	if($sake_id != "")
	{
		$item = "sake_id='$sake_id'";
	}

	if($nomitai_values != "")
	{    
		if($item == "")
		{
			$item = "nomitai_values='$nomitai_values'";
		}
		else
		{
			$item .= ", nomitai_values='$nomitai_values'";
		}
	}

	$sql = "UPDATE NOMITAI_J SET ".$item." WHERE sake_id = '$sake_id' AND username = '$username'";
	$res = executequery($db, $sql);

	if(!$res)   
	{
		$return = "failed";
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
	}
	else
	{
		$return = "success";
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <sql>'.$sql.'</sql>'."\n";
		echo '</xml>'."\n";
	}
}

?>
