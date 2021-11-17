<?php
require_once("../db_functions.php");

if(!$db = opendatabase("../sake.db"))
{
   die("データベース接続エラー .<br />");
}

$id = $_GET['id'];
$sql = "DELETE FROM SAKAGURA_J WHERE id = '$id'";
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed";
	
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

$sql = "DELETE FROM FOLLOW_J WHERE sakagura_id = '$id'";
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

$sql = "DELETE FROM SAKE_J WHERE sakagura_id = '$id'";
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

