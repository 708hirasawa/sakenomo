<?php
require_once("db_functions.php");

$username = $_COOKIE['login_cookie'];
$tablename = $_POST['tablename'];

//$sake_id = sqlite3::escapeString($_GET['sake_id']);
$title = $_POST['title'];
$message = $_POST['message'];
$in_time = time();

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$sql = "INSERT INTO ".$tablename ."(contributor, subject, message, write_date) VALUES ('$username', '$title', '$message', '$in_time')";
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="Shift_JIS" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
else
{
	$return = "success" .$item;
	//$message_sequence = GetLastInsertRowID($db); 
	$message_sequence = $db->lastInsertRowID();

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="Shift_JIS" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <tablename>'.$tablename.'</tablename>'."\n";
	echo ' <message_sequence>'.$message_sequence.'</message_sequence>'."\n";
	echo ' <contributor>'.$username.'</contributor>'."\n";
	echo ' <subject>'.$title.'</subject>'."\n";
	echo ' <message>'.$message.'</message>'."\n";
	echo ' <intime>'.gmdate("Y/m/d H:i:s",$in_time + 9 * 3600).'</intime>'."\n";
	echo '</xml>'."\n";
}
?>
