<?php
require_once("db_functions.php");

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$id = $_GET['id'];
$sql = "SELECT * FROM SYUHANTEN_J WHERE syuhanten_id = '$id'";
$res = executequery($db, $sql);
$row = getnextrow($res);

if($row)
{
	$sql = "DELETE FROM SYUHANTEN_J WHERE syuhanten_id = '$id'";
	$stmt = executequery($db, $sql);

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
}
else
{
	$return = "failed";
	
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
?>
