<?php

require_once("db_functions.php");
$username = $_POST['username'];
$hidden_username = $_POST['hidden_username'];
$email = $_POST['email'];

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$email' AND STATUS = 2";
$result = executequery($db, $sql);
$row = getnextrow($result);

if($row) 
{
	$sql = "DELETE FROM PROFILE_IMAGE WHERE contributor = '$email' AND STATUS = 2";
	$res = executequery($db, $sql);

	if(!$res)   
	{
		$return = "failed ".$sql;
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo '<str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
		return;
	}
}

$return = "success";
header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo ' <str>'.$return.'</str>'."\n";
echo ' <sql>'.$sql.'</sql>'."\n";
echo '</xml>'."\n";

?>

