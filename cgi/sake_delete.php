<?php
require_once("../db_functions.php");

if(!$db = opendatabase("../sake.db"))
{
   die("データベース接続エラー .<br />");
}

$sake_id = $_POST['sake_id'];

$sql = "SELECT * FROM SAKE_J WHERE sake_id = '$sake_id'";
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

///////////////////
// 日本酒削除 
///////////////////
$sql = "DELETE FROM SAKE_J WHERE sake_id = '$sake_id'";
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

///////////////////
// 飲みたい削除 
///////////////////
$sql = "DELETE FROM FAVORITE_J WHERE sake_id = '$sake_id'";
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

///////////////////
// 飲んだ削除 
///////////////////
$sql = "DELETE FROM TABLE_NONDA WHERE sake_id = '$sake_id'";
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

///////////////////
// 酒の写真を削除 
///////////////////
$sql = "DELETE FROM SAKE_IMAGE WHERE sake_id = '$sake_id'";
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

////////////////////
$return = "success";

header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo '<str>'.$return.'</str>'."\n";
echo '</xml>'."\n";

?>
