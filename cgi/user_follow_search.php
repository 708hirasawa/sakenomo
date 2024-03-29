<?php

require_once("../db_functions.php");
$username = $_POST['username'];
$count_result = 0;

if(!$db = opendatabase("../sake.db"))
{
	$result1 = 0;

	$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
	return 0;
}

if(isset($_POST["order"]) && ($_POST["order"] != ""))
{
    $order = $_POST["order"];
}
else 
{
    $order = "date_followed";
}

if(isset($_POST["sort"]) && ($_POST["sort"] != ""))
{
    $desc = $_POST["sort"];
}
else 
{
    $desc = "DESC";
}

$category = 1;
$from = $_POST["from"];
$to = 25;

if(isset($_POST["category"]) && ($_POST["category"] != ""))
{
    $category = $_POST["category"];
}

if($category == 1)
{
	$count_result = 0;
	
	if($_POST["count_query"] == "1")
	{
		$sql1 = "SELECT COUNT(*) FROM FOLLOW_USER, USERS_J where users_j.username = FOLLOW_USER.favoriteuser AND FOLLOW_USER.username = '$username'";
		$res = executequery($db, $sql1);
		$record = getnextrow($res); 
		$count_result = $record["COUNT(*)"];
	}

	//$sql = "SELECT * FROM USERS_J AS USERS_1 WHERE USERS_1.username IN (SELECT FOLLOW_USER.favoriteuser FROM USERS_J AS USERS_2, FOLLOW_USER WHERE USERS_2.username = '$username' AND USERS_2.username = FOLLOW_USER.username)";
	$sql1 = "SELECT * FROM FOLLOW_USER, USERS_J where users_j.username = FOLLOW_USER.favoriteuser AND FOLLOW_USER.username = '$username' ORDER BY DATE_FOLLOWED " .$desc ." LIMIT ".$from.", ".$to;

	$res = executequery($db, $sql1);

	if(!$res)
	{
		$result1 = 0;
		$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}

	while($row = getnextrow($res))
	{
		$username = $row["favoriteuser"];
		$nonda_count = 0;
		$nomitai_count = 0;
		$follow_count = 0;
		$follower_count = 0;
		$followed = 1;

		// nonda count
		/*
		$sql = "SELECT count(TABLE_NONDA.contributor) FROM TABLE_NONDA WHERE '$username' = TABLE_NONDA.contributor AND committed = 1"; 

		$res2 = executequery($db, $sql);

		if($row2 = getnextrow($res2)) {
			$nonda_count = $row2["count(TABLE_NONDA.contributor)"];
		}
		*/

		$sql = "SELECT COUNT(*) FROM TABLE_NONDA, SAKE_J WHERE SAKE_J.sake_id = TABLE_NONDA.sake_id AND contributor = '$username' AND (committed = 1 OR committed = 2)";
		$res2 = executequery($db, $sql);

		if($row2 = getnextrow($res2)) {
			$nonda_count = ($row2["COUNT(*)"] == "") ? "0" : $row2["COUNT(*)"];
		}

		// follow count 
		//$sql = "SELECT count(FOLLOW_USER.username) FROM FOLLOW_USER WHERE FOLLOW_USER.username = '$username'";
		$sql = "SELECT count(*) FROM FOLLOW_USER, USERS_J where users_j.username = FOLLOW_USER.favoriteuser AND FOLLOW_USER.username = '$username'";

		$res3 = executequery($db, $sql);

		if($row3 = getnextrow($res3)) {
			//$follow_count = $row3["count(FOLLOW_USER.username)"];
			$follow_count = $row3["count(*)"];
		}

		// follower count 
		//$sql = "SELECT count(FOLLOW_USER.favoriteuser) FROM FOLLOW_USER WHERE FOLLOW_USER.favoriteuser = '$username'";
		$sql = "SELECT COUNT(*) FROM FOLLOW_USER, USERS_J where users_j.username = FOLLOW_USER.username AND FOLLOW_USER.favoriteuser = '$username'";

		$res3 = executequery($db, $sql);
		
		if($row3 = getnextrow($res3)) {
			//$follower_count = $row3["count(FOLLOW_USER.favoriteuser)"];
			$follower_count = $row3["COUNT(*)"];
		}



		$imagefile = null;

		if($row['oauth_uid'] && ($row['picture'] && $row['picture'] != "")) {
			$imagefile = $row['picture'];
		}
		else {
			$username = stripslashes($row["username"]);
			$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$username' AND status = 1";
			$res4 = executequery($db, $sql);
			$rd = getnextrow($res4);

			if($rd) {
				$imagefile = "images/profile/" .$rd["filename"];
			}
		}

		$nickname = $row["nickname"];

		// twitterアカウント有無
		if(!$nickname && $row['oauth_uid']) {
			$nickname = $row["first_name"];
		}

		$result1[] = array('username' => $row["username"], 
							'nickname' => $nickname, 
							'usertype' => $row["usertype"], 
							'fname' => $row["fname"], 
							'minit' => $row["minit"], 
							'lname' => $row["lname"], 
							'sex' => $row["sex"],
							'bdate' => $row["bdate"],
							'email' => $row["email"],
							'phone' => $row["phone"],
							'country' => $row["country"],
							'pref' => $row["pref"],
							'address' => $row["address"],
							'postal_code' => $row["postal_code"],
							'introduction' => $row["introduction"],
							'certification' => $row["certification"],
							'date_followed' => gmdate("Y/m/d", $row["date_followed"] + 9 * 3600), 
							'imagefile' => $imagefile,
							'address_disclose' => $row["address_disclose"],
							'certification_disclose' => $row["certification_disclose"],
							'sex_disclose' => $row["sex_disclose"],
							'age_disclose' => $row["age_disclose"],
							'nonda_count' => $nonda_count,
							'follow_count' => $follow_count,
							'follower_count' => $follower_count,
							'followed' => $followed);
	}

	$result[] = array('result' => $result1, 'sql' => $sql1, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
	return 0;
}
else if($category == 2) 
{
	if($_POST["count_query"] == "1")
	{
		$sql1 = "SELECT COUNT(*) FROM FOLLOW_USER, USERS_J where users_j.username = FOLLOW_USER.username AND FOLLOW_USER.favoriteuser = '$username'";
		$res = executequery($db, $sql1);
		$record = getnextrow($res); 
		$count_result = $record["COUNT(*)"];
	}

	//$sql = "SELECT * FROM USERS_J AS USERS_1 WHERE USERS_1.username IN (SELECT FOLLOW_USER.favoriteuser FROM USERS_J AS USERS_2, FOLLOW_USER WHERE USERS_2.username = '$username' AND USERS_2.username = FOLLOW_USER.username)";
	$sql1 = "SELECT * FROM FOLLOW_USER, USERS_J where users_j.username = FOLLOW_USER.username AND FOLLOW_USER.favoriteuser = '$username' ORDER BY DATE_FOLLOWED " .$desc ." LIMIT ".$from.", ".$to;
	$res = executequery($db, $sql1);

	if(!$res)
	{
		$result1 = 0;
		$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}

	while($row = getnextrow($res))
	{
		$follower_name = $row["username"];	
		$nonda_count = 0;
		$nomitai_count = 0;
		$follow_count = 0;
		$follower_count = 0;
		$followed = 0;

		// nonda count
		$sql = "SELECT count(TABLE_NONDA.contributor) FROM TABLE_NONDA WHERE '$follower_name' = TABLE_NONDA.contributor"; 
		$res2 = executequery($db, $sql);

		if($row2 = getnextrow($res2)) {
			$nonda_count = $row2["count(TABLE_NONDA.contributor)"];
		}

		// follow count 
		$sql = "SELECT count(*) FROM FOLLOW_USER, USERS_J where users_j.username = FOLLOW_USER.favoriteuser AND FOLLOW_USER.username = '$follower_name'";
		$res3 = executequery($db, $sql);

		if($row3 = getnextrow($res3)) {
			$follow_count = $row3["count(*)"];
		}

		// follower count 
		$sql = "SELECT COUNT(*) FROM FOLLOW_USER, USERS_J where users_j.username = FOLLOW_USER.username AND FOLLOW_USER.favoriteuser = '$follower_name'";
		$res3 = executequery($db, $sql);
		
		if($row3 = getnextrow($res3)) {
			$follower_count = $row3["COUNT(*)"];
		}

		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////
		$imagefile = null;

		if($row['oauth_uid'] && ($row['picture'] && $row['picture'] != "")) {
			$imagefile = $row['picture'];
		}
		else {
			$username1 = stripslashes($row["username"]);
			$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$username1' AND status = 1";
			$res4 = executequery($db, $sql);
			$rd = getnextrow($res4);

			if($rd) {
				$imagefile = "images/profile/" .$rd["filename"];
			}
		}

		$sql = "SELECT * FROM FOLLOW_USER, USERS_J where USERS_J.username = FOLLOW_USER.username AND FOLLOW_USER.username = '$username' AND FOLLOW_USER.favoriteuser = '$follower_name'";
		$res5 = executequery($db, $sql);
		$row5 = getnextrow($res5);

		if($row5) {
			$followed = 1;
		}

		$nickname = $row["nickname"];

		// twitterアカウント有無
		if(!$nickname && $row['oauth_uid']) {
			$nickname = $row["first_name"];
		}
		
		$result1[] = array('username' => $follower_name, 
							'nickname' => $nickname, 
							'usertype' => $row["usertype"], 
							'fname' => $row["fname"], 
							'minit' => $row["minit"], 
							'lname' => $row["lname"], 
							'sex' => $row["sex"],
							'bdate' => $row["bdate"],
							'email' => $row["email"],
							'phone' => $row["phone"],
							'country' => $row["country"],
							'pref' => $row["pref"],
							'address' => $row["address"],
							'postal_code' => $row["postal_code"],
							'introduction' => $row["introduction"],
							'certification' => $row["certification"],
							'date_followed' => gmdate("Y/m/d", $row["date_followed"] + 9 * 3600), 
							'imagefile' => $imagefile,
							'address_disclose' => $row["address_disclose"],
							'certification_disclose' => $row["certification_disclose"],
							'sex_disclose' => $row["sex_disclose"],
							'age_disclose' => $row["age_disclose"],
							'nonda_count' => $nonda_count,
							'follow_count' => $follow_count,
							'follower_count' => $follower_count,
							'followed' => $followed);
		//$count_result++;
	}

	$result[] = array('result' => $result1, 'sql' => $sql1, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
	return 0;
}

?>
