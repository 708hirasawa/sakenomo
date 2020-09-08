<?php

require_once("db_functions.php");

$sake_id = $_POST['id'];
$contributor = $_POST['contributor'];
$filename = $_POST['filename'];
$desc = $_POST['desc'];
$sql = "default";

if(isset($_POST['desc']) && $_POST['desc'] != undefined) {
    $desc = sqlite3::escapeString($_POST['desc']);
    $desc = str_replace("&", "&amp;", $desc);
}
else {
	$return = "desc_not_specified";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
	return;
}

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

//$sql = "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$contributor' AND filename = '$filename' AND status = 2";
$sql = "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$contributor' AND filename = '$filename'";
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "select failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
}

$row = getnextrow($res);

if($row) {

	$sql = "UPDATE SAKE_IMAGE SET desc = '$desc' WHERE sake_id = '$sake_id' AND contributor = '$contributor' AND filename = '$filename'";
	$res = executequery($db, $sql);

	if(!$res) {  
		$return = "update failed";
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <sql>'.$sql.'</sql>'."\n";
		echo '</xml>'."\n";
	}
}

$return = "success";
header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo ' <str>'.$return .'</str>'."\n";
echo ' <sql>'.$sql .'</sql>'."\n";
echo '</xml>'."\n";

?>
