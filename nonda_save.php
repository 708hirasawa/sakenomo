<?php
require_once("db_functions.php");

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

ini_set('memory_limit', '128M');

$sake_id = $_POST['sake_id'];
$contributor = $_POST['contributor'];
$write_date = $_POST['write_date'];
$in_time = time();
$path = "images/icons/users.jpg";

$item = "";

if(!$db = opendatabase("sake.db"))
{
	$return = "データベース接続エラー";
	echo "[\"" .$return  ."\", \"upload is complete\", \"" .$sake_id ."\"]";
	return 0;
}

if(isset($_POST['committed']) && $_POST['committed'] != undefined) {
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

if(isset($_POST['title']) && $_POST['title'] != undefined) {
	$subject = sqlite3::escapeString($_POST['title']);
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

if(isset($_POST['message']) && $_POST['message'] != undefined) {
	$message = sqlite3::escapeString($_POST['message']);
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

if(isset($_POST['rank']) && $_POST['rank'] != undefined) {
	$rank = sqlite3::escapeString($_POST['rank']);

    if($item == "")
	{
        $item = "rank='$rank'";
    }
	else
	{
        $item .= ", rank='$rank'";
    }
}

if(isset($_POST['flavor']) && $_POST['flavor'] != undefined) {
	$flavor = $_POST['flavor'];

    if($item == "") {
        $item = "flavor='$flavor'";
    }
	else {
        $item .= ", flavor='$flavor'";
    }
}

if(isset($_POST['taste']) && $_POST['taste'] != undefined) {
	$taste = $_POST['taste'];

    if($item == "") {
        $item = "tastes='$taste'";
    }
	else {
        $item .= ", tastes='$taste'";
    }
}

if($item == "") {
    $item = "update_date='$in_time'";
}
else {
    $item .= ", update_date='$in_time'";
}

$sql = "UPDATE TABLE_NONDA SET ".$item." WHERE sake_id = '$sake_id' AND contributor = '$contributor'";
$res = executequery($db, $sql);

if(!$res) {
	$return = "failed1:" .$sql;
	echo "[\"" .$return  ."\", \"upload is complete\", \"" .$sake_id ."\"]";
	return 0;
}

/*********************************************************************************************************************
 * commit uploaded images
 *********************************************************************************************************************/
$sql_update = "UPDATE SAKE_IMAGE SET status = 1 WHERE sake_id = '$sake_id' AND contributor = '$contributor' AND status = 2";
$result = executequery($db, $sql_update);

if(!$res) {
	$return = "file update failed";
	echo "[\"" .$return  ."\", \"upload is complete\", \"" .$sake_id ."\"]";
	return 0;
}

/*********************************************************************************************************************
 * commit deleted images selected by users
 *********************************************************************************************************************/
$sql_select = "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$contributor' AND status = 3";
$result = executequery($db, $sql_select);

if($result) {
	while($row = getnextrow($result)) {

		$path = "images/photo/".$row[filename];
		$thumbpath = "images/photo/thumb/".$row[filename];

		if(file_exists($path)) {
			$ret = unlink($path);	
		}

		if(file_exists($thumbpath)) {
			$ret = unlink($thumbpath);	
		}
	}
}

$sql = "DELETE FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$contributor' AND status = 3";
$res = executequery($db, $sql);

if(!$res) {
	$return = "file deletion failed";
	echo "[\"" .$return  ."\", \"upload is complete\", \"" .$sake_id ."\"]";
	return 0;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$user_result = executequery($db, "SELECT * FROM USERS_J WHERE username = '$username'");
$user_record = getnextrow($user_result);

if($user_record)
   $path = "images/profile/" .$user_record["imagefile"];

$result = array($sql_update, $sake_id, $contributor, $in_time, $_POST['committed'], $_POST['title'], $path, $_POST['rank'], $_POST['message'], $_POST['taste'], $_POST['flavor']);
echo json_encode($result);

?>
