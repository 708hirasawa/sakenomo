<?php

require_once("../db_functions.php");

if(!$db = opendatabase("../sake.db"))
{
	$return = "database connection failure";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

$id = $_POST['id'];
$data_type = $_POST['data_type'];
$filename = $_POST['filename'];
//$filename = str_replace("%", "_", $filename);
$status = $_POST['status'];

$sql_select = "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$id' AND filename = '$filename'";
$res = executequery($db, $sql_select);
$row = getnextrow($res);

if(!$row) {
	$return = "failed select:".$sql_select;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql_select.'</sql>'."\n";
	echo '</xml>'."\n";
}

if($status == 3) { 	

	if($row["status"] == 2) { // removing a file which is not committed so delete it.
		$sql_delete = "DELETE FROM SAKE_IMAGE WHERE sake_id = '$id' AND filename = '$filename'";
		$stmt = executequery($db, $sql_delete);

		if($stmt)
		{
			$path = "../images/photo/".$row["filename"];
			$thumbpath = "../images/photo/thumb/".$row["filename"];
			$return = "success";

			if($data_type == "sakagura") {
				$path = "../images/sakagura/".$row["filename"];
				$thumbpath = "../images/sakagura/thumb/".$row["filename"];
			}

			if(file_exists($path)) {
				$ret = unlink($path);	

				if($ret == FALSE)
					$return = "failed unlink1";
			}
			else {
				$return = "file_does_not_exit";
			}

			if(file_exists($thumbpath)) {
				$ret = unlink($thumbpath);	

				if($ret == FALSE)
					$return = "failed unlink2";
			}
			else {
				$return = "file_does_not_exit";
			}

			header("Content-type: application/xml");
			echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
			echo '<xml>'."\n";
			echo ' <str>'.$return.'</str>'."\n";
			echo ' <sql>'.$sql_delete.'</sql>'."\n";
			echo ' <filename>'.$path.'</filename>'."\n";
			echo '</xml>'."\n";	
		}
		else
		{
			$return = "failed delete:".$sql_delete;
			header("Content-type: application/xml");
			echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
			echo '<xml>'."\n";
			echo ' <str>'.$return.'</str>'."\n";
			echo ' <sql>'.$sql_delete.'</sql>'."\n";
			echo '</xml>'."\n";
		}
	}
	else {	// just set a flag to delete when committed
		$sql_update = "UPDATE SAKE_IMAGE SET status = 3 WHERE sake_id = '$id' AND filename = '$filename'";
		$stmt = executequery($db, $sql_update);

		if($stmt) {		
			$return = "success";		
		}
		else {
			$return = "deletion failed";		
		}

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <sql>'.$sql_update.'</sql>'."\n";
		echo ' <filename>'.$path.'</filename>'."\n";
		echo '</xml>'."\n";	
	}
}
else {
	$return = "unknown operation:".$status;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql_select.'</sql>'."\n";
	echo '</xml>'."\n";
}
?>
