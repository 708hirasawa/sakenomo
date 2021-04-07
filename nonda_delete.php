<?php

require_once("db_functions.php");

$sake_id = $_POST['sake_id'];
$contributor = $_POST['contributor'];
$write_date = $_POST['write_date'];
$sql = "default";

if(!$db = opendatabase("sake.db"))
{
	$return = "データベース接続エラー";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
	return;
}

$sql = "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$contributor'";
$result = executequery($db, $sql);

while($row = getnextrow($result))
{
	$filename = $row["filename"];
	$path = "images/".$filename;
	$thumbpath = "images/photo/thumb/".$filename;

	if(file_exists($path))
	{
		$ret = unlink($path);
	}

	if(file_exists($thumbpath))
	{
		$ret = unlink($thumbpath);
	}
}

$sql = "DELETE FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$contributor'";
$res = executequery($db, $sql);

if(!$res)
{
	$return = "delete failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
}

//////////////////////////////////////////////////////////////////////////////////////////////////////
// 投稿削除
//////////////////////////////////////////////////////////////////////////////////////////////////////

$sql = "DELETE FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND contributor = '$contributor'";
$result = executequery($db, $sql);

if(!$result)
{
	$return = "delete failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
	return;
}

$return = "success";
header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo ' <str>'.$return .'</str>'."\n";
echo ' <sql>'.$sql .'</sql>'."\n";
echo '</xml>'."\n";
?>
