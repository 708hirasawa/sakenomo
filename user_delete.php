<?php
require_once("db_functions.php");

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$username = $_POST['username'];

$sql = "SELECT * FROM USERS_J WHERE username = '$username'";
$res = executequery($db, $sql);

if(!$res)
{
	$return = "failed";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}

$row = getnextrow($res);
$sql = "DELETE FROM USERS_J WHERE username = '$username'";
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed";
	
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
else
{
	$return = "success";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}

?>
