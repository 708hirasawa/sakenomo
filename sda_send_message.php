<?php

require_once("db_functions.php");

$username			= $_COOKIE['login_cookie'];
$password			= $_COOKIE['password_cookie'];
$sakagura_id		= $_POST['sakagura_id'];
$sakagura_name		= $_POST['sakagura_name'];
$title				= $_POST['title'];
$message			= $_POST['message'];
$in_time			= time();
$sent_tablename		= "sent_".$username;
$received_tablename	= "received_".$sakagura_name;

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$sql = "INSERT INTO ".$received_tablename ."(username, subject, message, write_date) VALUES ('$username', '$title', '$message', '$in_time')";
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed1:" .$sql;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
else
{
	$sql = "INSERT INTO ".$sent_tablename ."(username, subject, message, write_date) VALUES ('$sakagura_name', '$title', '$message', '$in_time')";
	$res = executequery($db, $sql);

	if(!$res)   
	{
		$return = "failed2:" .$sql;
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
	}
	else
	{
		//$message_sequence = $db->lastInsertRowID();
		$return = "success";

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <intime>'.gmdate("Y/m/d H:i:s", $in_time + 9 * 3600).'</intime>'."\n";
		echo '</xml>'."\n";
	}
}
?>
	
