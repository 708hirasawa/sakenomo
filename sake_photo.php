<?php
require_once("db_functions.php");

if(!$db = opendatabase("sake.db"))
{
	die("データベース接続エラー .<br />");
}

$sake_id = $_POST["sake_id"];
$in_disp_from = $_POST["in_disp_from"];
$in_disp_to = $_POST["in_disp_to"];
$count_result = 0;

$sql = "SELECT SAKE_IMAGE.sake_id, SAKE_IMAGE.filename, SAKE_IMAGE.contributor, SAKE_IMAGE.added_date, sake_name FROM SAKE_IMAGE, SAKE_J WHERE SAKE_IMAGE.sake_id = SAKE_J.sake_id AND SAKE_IMAGE.sake_id = '$sake_id' ORDER BY added_date"." LIMIT ".$in_disp_from.", ".$in_disp_to;
$res = executequery($db, $sql);

if(!$res)   
{
	die('Error');
}
else
{
	while($row = getnextrow($res))
	{
		$path = "images/photo/thumb/".$rpw["filename"];
		//$result[] = array('sake_id' => $row["sake_id"], 'filename' => $row["filename"], 'contributor' => $row["contributor"], 'sake_name' => $row["sake_name"], 'pref' => $row["pref"], 'filename' => $path);
		$result1[] = array('sake_id' => $row["sake_id"], 'filename' => $row["filename"], 'contributor' => $row["contributor"], 'sake_name' => $row["sake_name"]);
		$count_result++;
	}
}

$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);
header('Content-Type: application/json');
echo json_encode($result);

?>
