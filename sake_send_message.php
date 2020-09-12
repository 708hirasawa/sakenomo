<?php
require_once("db_functions.php");

$username = $_COOKIE['login_cookie'];
$password = $_COOKIE['password_cookie'];
$tablename = $_POST['tablename'];

//$sake_id = sqlite3::escapeString($_GET['sake_id']);
$title = $_POST['title'];
//$title = mb_convert_encoding($title, "UTF-8", "SJIS");
$title = mb_convert_encoding($title, "SJIS", "UTF-8");

$message = $_POST['message'];
//$message = mb_convert_encoding($message, "UTF-8", "SJIS");
$message = mb_convert_encoding($message, "SJIS", "UTF-8");

$in_time = time();

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$sql = "INSERT INTO ".$tablename ."(contributor, subject, message, pass_word, write_date) VALUES ('$username', '$title', '$message', '$password', '$in_time')";
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
	//$return = "success" .$item;

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
