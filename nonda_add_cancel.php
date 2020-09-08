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

//$sql = "SELECT * FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND write_date = '$write_date'";
$sql = "SELECT * FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND contributor = '$contributor'";
$result = executequery($db, $sql);
$row = getnextrow($result);

if($row['committed'] == 0)
{
	if($row && $row['added_paths'] != "")
	{
		$addedArray = explode(',', $row['added_paths']);

		foreach($addedArray as &$filename)
		{
			$sql = "DELETE FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND filename = '$filename'";
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
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////
	// 飲んだ削除
	//////////////////////////////////////////////////////////////////////////////////////////////////////

	//$sql = "DELETE FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND write_date = '$write_date'";
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
}

//$return = "success:" .$sql;
$return = "success";
header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo ' <str>'.$return .'</str>'."\n";
echo ' <sql>'.$sql .'</sql>'."\n";
echo '</xml>'."\n";
?>
