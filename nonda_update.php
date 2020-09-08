<?php
require_once("db_functions.php");

ini_set('memory_limit', '128M');

$username = $_COOKIE['login_cookie'];
$write_date = $_POST['write_date'];
$data_type = $_POST['data_type'];
$id = $_POST['id'];
$tablename = "TABLE_NONDA";
$in_time = time();
$item = "added_paths = '', deleted_paths = ''";
$path = "images/icons/users.jpg";

if(!$db = opendatabase("sake.db"))
{
	$return = "データベース接続エラー";
	echo "[\"" .$return  ."\", \"upload is complete\", \"" .$id ."\"]";
	return 0;
}

if(!$db1 = opendatabase("sake.db"))
{
	$return = "データベース接続エラー";
	echo "[\"" .$return  ."\", \"upload is complete\", \"" .$id ."\"]";
	return 0;
}

if(isset($_POST['committed']) && $_POST['committed'] != undefined)
{
	$committed = $_POST['committed'];

    if($item == "")
	{
        $item = "committed='$committed'";
    }
	else
	{
        $item .= ", committed='$committed'";
    }
}

if(isset($_POST['title']) && $_POST['title'] != undefined)
{
	$subject = addslashes($_POST['title']);
    $subject = str_replace("&", "&amp;", $subject);

    if($item == "")
	{
        $item = "subject='$subject'";
    }
	else
	{
        $item .= ", subject='$subject'";
    }
}

if(isset($_POST['message']) && $_POST['message'] != undefined)
{
	$message = addslashes($_POST['message']);
    $message = str_replace("&", "&amp;", $message);

    if($item == "")
	{
        $item = "message='$message'";
    }
	else
	{
        $item .= ", message='$message'";
    }
}

if(isset($_POST['rank']) && $_POST['rank'] != undefined)
{
	$rank = addslashes($_POST['rank']);

    if($item == "")
	{
        $item = "rank='$rank'";
    }
	else
	{
        $item .= ", rank='$rank'";
    }
}

if(isset($_POST['flavor']) && $_POST['flavor'] != undefined)
{
	$flavor = $_POST['flavor'];

    if($item == "")
	{
        $item = "flavor='$flavor'";
    }
	else
	{
        $item .= ", flavor='$flavor'";
    }
}

if(isset($_POST['taste']) && $_POST['taste'] != undefined)
{
	$taste = $_POST['taste'];

    if($item == "")
	{
        $item = "tastes='$taste'";
    }
	else
	{
        $item .= ", tastes='$taste'";
    }
}

$sql = "SELECT * FROM TABLE_NONDA WHERE sake_id = '$id' AND write_date = '$write_date'";
$result = executequery($db, $sql);
$row = getnextrow($result);

if($row)
{
	$deletedArray = explode(',', $row['deleted_paths']);

	foreach($deletedArray as &$filename)
	{
		if($filename != "")
		{
			$sql = "DELETE FROM SAKE_IMAGE WHERE sake_id = '$id' AND filename = '$filename'";
			$result1 = executequery($db1, $sql);

			if(!$result1)
			{
				$return = "image deletion failed:".$sql;
				header("Content-type: application/xml");
				echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
				echo '<xml>'."\n";
				echo ' <str>'.$return.'</str>'."\n";
				echo '</xml>'."\n";
				return;	
			}

			$path = "images/photo/".$filename;
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
}

$sql = "UPDATE TABLE_NONDA SET ".$item." WHERE sake_id = '$id' AND write_date = '$write_date'";
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed1:" .$sql;
	echo "[\"" .$return  ."\", \"update failed\", \"" .$id ."\"]";
	return 0;
}

/*
$user_result = executequery($db, "SELECT * FROM USERS_J WHERE username = '$username'");
$user_record = getnextrow($user_result);

if($user_record)
   $path = "images/profile/" .$user_record["imagefile"];
*/

$result = array($username, $_POST['title'], $_POST['message'], $_POST['rank'], $_POST['message'], $in_time, $_POST['taste'], $_POST['flavor'], $sql, $path, $_POST['committed']);
echo json_encode($result);

?>
