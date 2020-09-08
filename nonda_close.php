<?php

require_once("db_functions.php");
$sake_id = $_POST['sake_id'];
$write_date = $_POST['write_date'];

$sql = "";

if(!$db = opendatabase("sake.db"))
{
	$return = "failed to open a database";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

if(!$db = opendatabase("sake.db"))
{
	$return = "failed to open a database";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$sql = "SELECT * FROM TABLE_NONDA WHERE sake_id = '$id' AND write_date = '$write_date'";
$res = executequery($db1, $sql);

if(!$res)
{
	$return = "ドラフトは作成されていません".$sql;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$row = getnextrow($res);

if(!$row)
{
	$return = "ドラフトは作成されていません".$sql;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$return = "success";
header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo ' <str>'.$return .'</str>'."\n";
echo ' <image_paths>' .$row["image_paths"] .'</image_paths>'."\n";
echo ' <contributor>' .$contributor .'</contributor>'."\n";
echo ' <subject>' .$row["subject"] .'</subject>'."\n";
echo ' <message>' .$row["message"] .'</message>'."\n";

echo '</xml>'."\n";
?>

