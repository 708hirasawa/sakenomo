<?php

require_once("db_functions.php");
$from = $_POST["from"];
$to = 25; //$_POST["in_disp_to"];
$count_query = $_POST["count_query"];

//$orderby = $_POST["orderby"];
$orderby = "update_date";
$intime = gmdate("Y/m/d H:i:s", $row["update_date"] + 9 * 3600);
$count_result = 0;

if(!$db = opendatabase("sake.db"))
{
	header('Content-Type: application/json');
	$result_set[] = array('count' => $count_result, 'result' => null);
	echo json_encode($result_set);
}

$condition = "WHERE SAKE_J.sakagura_id = SAKAGURA_J.id AND SAKE_J.sake_id = TABLE_NONDA.sake_id AND committed = 1";

if(isset($_POST['username']) && $_POST['username'] != "")
{
	$username = $_POST['username'];
	$condition .= " AND TABLE_NONDA.contributor = '$username'"; 
}

if(isset($_POST['sake_id']) && $_POST['sake_id'] != "")
{
	$sake_id = $_POST['sake_id'];
	$condition .= " AND SAKE_J.sake_id = '$sake_id'";
}

if(isset($_POST['update_date']) && $_POST['update_date'] != "")
{
	$update_date = $_POST['update_date'];
	$condition .= " AND TABLE_NONDA.update_date = '$update_date'"; 
}

if(isset($_POST['pref']) && $_POST['pref'] != "")
{
	$pref = $_POST['pref'];
    $condition .= " AND pref LIKE \"%".$pref."%\"";
}

if(isset($_POST['special_name']) && $_POST['special_name'] != "")
{
	$special_name = $_POST['special_name'];
    $condition .= " AND special_name LIKE \"%".$special_name."%\"";
}

if($count_query == 1)
{
	$sql = "SELECT COUNT(*) FROM SAKE_J, SAKAGURA_J, TABLE_NONDA " .$condition;
	//$sql = "SELECT COUNT(*) FROM SAKE_J, SAKAGURA_J, db1.TABLE_NONDA AS TABLE_NONDA WHERE TABLE_NONDA.contributor = '$username' AND SAKE_J.sakagura_id=SAKAGURA_J.id AND SAKE_J.sake_id = TABLE_NONDA.sake_id";
	$res = executequery($db, $sql);

	if(!res)
	{
		header('Content-Type: application/json');
		$result_set[] = array('count' => $count_result, 'result' => null);
		echo json_encode($result_set);
		return;
	}

	$record = getnextrow($res); 
	$count_result = $record["COUNT(*)"];
}

if(isset($_POST['orderby']) && $_POST['orderby'] != "")
{
	$orderby = $_POST['orderby'];

	if($orderby == 2) {
		$condition .= " ORDER BY TABLE_NONDA.update_date ASC";
	}
	else {
		$condition .= " ORDER BY TABLE_NONDA.update_date DESC";
	}
}
else 
{
	$condition .= " ORDER BY TABLE_NONDA.update_date DESC";
}

if(isset($_POST['from']) && $_POST['from'] != undefined)
{
	$from = $_POST['from'];

	if(isset($_POST['in_disp_to']) && $_POST['in_disp_to'] != undefined)
	{
		$to = $_POST['in_disp_to'];
	}

    $condition .= " LIMIT ".$from.", ".$to;
}

$sql = "SELECT TABLE_NONDA.sake_id AS sake_id, TABLE_NONDA.rank AS rank, TABLE_NONDA.flavor AS flavor, TABLE_NONDA.update_date AS update_date, TABLE_NONDA.contributor AS contributor, sake_name, sake_read, sakagura_name, pref, sake_rank, subject, message, tastes, committed FROM SAKE_J, SAKAGURA_J, TABLE_NONDA " .$condition;
$res = executequery($db, $sql);

if(!res)
{
	header('Content-Type: application/json');
	$result_set[] = array('count' => $count_result, 'result' => null);
	echo json_encode($result_set);
	return;
}
else
{
	while($row = getnextrow($res))
	{
		$sake_id = $row["sake_id"];
		$username = $row["contributor"];
		$added_paths = "";
		$sql_image = "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$username'";
		$image_result = executequery($db, $sql_image);
		
		while($image_record = getnextrow($image_result)) {

			if($added_paths == "")
				$added_paths = $image_record["filename"];
			else
				$added_paths .= ", " .$image_record["filename"];
		}

		$result[] = array('path' => $added_paths,
						'count' => $count_result,
						'sake_id'	=> $row["sake_id"],
						'sake_name' => stripslashes($row["sake_name"]), 
						'sake_read' => $row["sake_read"], 
						'sakagura_name' => $row["sakagura_name"], 
						'pref' => $row["pref"],
						'sake_rank' => $row["rank"],
						'subject' => $row["subject"],
						'message' => $row["message"],
						'username' => $row["contributor"],
						'flavor' => $row["flavor"],
						'tastes' =>  $row["tastes"],
						'write_date' => $row["write_date"],
						'update_date' => $row["update_date"],
						'sql' => $sql_image,
						'committed' => $row["committed"],
						'local_time' => gmdate("Y/m/d", $row["update_date"] + 9 * 3600) );
	}

	header('Content-Type: application/json');
	$result_set[] = array('count' => $count_result, 'result' => $result, 'sql' => $sql);
	echo json_encode($result_set);
}

?>
