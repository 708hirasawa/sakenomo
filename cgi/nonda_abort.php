<?php

require_once("../db_functions.php");

$sake_id = $_POST['sake_id'];
$write_date = $_POST['write_date'];
$imagepath = $_POST['imagepath'];
$pathArray = explode(',', $imagepath);

if(!$bbs_db = opendatabase("../sake.db"))
{
	$return = "failed to open a database1";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

$sql = "SELECT * FROM TABLE_NONDA WHERE sake_id = '" .$sake_id ."' AND write_date = " .$write_date;
$res = executequery($bbs_db, $sql);
$rd = getnextrow($res);

if($rd)
{
	if(!$db = opendatabase("../sake.db"))
	{
		$return = "failed to open a database2";
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
		return;
	}

	$image_entry = stripslashes($rd["image_paths"]);
	$image_entry = str_replace("[", "", $image_entry);
	$image_entry = str_replace("]", "", $image_entry);
	$image_array = explode(',', $image_entry);
	$bFound = false;

	foreach($pathArray as &$filename)
	{
		foreach($image_array as &$imageitem)
		{
			if($filename == $imageitem)
			{
				$bFound = true;
				break;
			}
		}

		if($bFound == false)
		{
			$sql = "DELETE FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND filename = '$filename'";
			$res = executequery($db, $sql);

			if(!$res)
			{
				$return = "failed delete:".$sql;
				header("Content-type: application/xml");
				echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
				echo '<xml>'."\n";
				echo ' <str>'.$return.'</str>'."\n";
				echo '</xml>'."\n";
			}

			$path = "../images/".$filename;
			$thumbpath = "../images/photo/thumb/".$filename;
			$return = "success";

			if(file_exists($path)) 
			{	
				$ret = unlink($path);	
			
				if($ret == FALSE)
				{
					$return = "failed unlink1";
					header("Content-type: application/xml");
					echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
					echo '<xml>'."\n";
					echo ' <str>'.$return.'</str>'."\n";
					echo '</xml>'."\n";	
					return;
				}
			} // if

			if(file_exists($thumbpath)) 
			{
				$ret = unlink($thumbpath);	

				if($ret == FALSE)
				{
					$return = "failed unlink2";
					header("Content-type: application/xml");
					echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
					echo '<xml>'."\n";
					echo ' <str>'.$return.'</str>'."\n";
					echo '</xml>'."\n";	
					return;
				}
			} // if	

			$bFound = false;

		} // bFound
	}
}


$return = "success";
header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo ' <str>'.$return .'</str>'."\n";
echo '</xml>'."\n";

?>

