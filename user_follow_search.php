<?php

require_once("db_functions.php");
$username = $_POST['username'];
$count_result = 0;

if(!$db = opendatabase("sake.db"))
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

if(isset($_POST["category"]) && ($_POST["category"] != ""))
{
    $category = $_POST["category"];
}

if($category == 1)
{
	//$sql = "SELECT * FROM USERS_J AS USERS_1 WHERE USERS_1.username IN (SELECT FOLLOW_USER.favoriteuser FROM USERS_J AS USERS_2, FOLLOW_USER WHERE USERS_2.username = '$username' AND USERS_2.username = FOLLOW_USER.username)";
	$sql1 = "SELECT * FROM FOLLOW_USER, USERS_J where users_j.email = FOLLOW_USER.favoriteuser AND FOLLOW_USER.username = '$username' ORDER BY DATE_FOLLOWED " .$desc;
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

		// nonda count
		$sql = "SELECT count(TABLE_NONDA.contributor) FROM TABLE_NONDA WHERE '$username' = TABLE_NONDA.contributor"; 
		$res2 = executequery($db, $sql);

		if($row2 = getnextrow($res2)) {
			$nonda_count = $row2["count(TABLE_NONDA.contributor)"];
		}

		// follow count 
		$sql = "SELECT count(FOLLOW_USER.username) FROM FOLLOW_USER WHERE '$username' = FOLLOW_USER.username";
		$res3 = executequery($db, $sql);

		if($row3 = getnextrow($res3)) {
			$follow_count = $row3["count(FOLLOW_USER.username)"];
		}

		// follower count 
		$sql = "SELECT count(FOLLOW_USER.favoriteuser) FROM FOLLOW_USER WHERE '$username' = FOLLOW_USER.favoriteuser";
		$res3 = executequery($db, $sql);

		if($row3 = getnextrow($res3)) {
			$follower_count = $row3["count(FOLLOW_USER.favoriteuser)"];
		}

		$imagefile = null;
		$email = stripslashes($row["email"]);
		$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$email' AND status = 1";
		$res4 = executequery($db, $sql);
		$rd = getnextrow($res4);

		if($rd) {
			$imagefile = $rd["filename"];
		}

		$result1[] = array('username' => $row["username"], 
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
							'imagefile' => $imagefile,
							'address_disclose' => $row["address_disclose"],
							'certification_disclose' => $row["certification_disclose"],
							'sex_disclose' => $row["sex_disclose"],
							'age_disclose' => $row["age_disclose"],
							'nonda_count' => $nonda_count,
							'follow_count' => $follow_count,
							'follower_count' => $follower_count);
		$count_result++;
	}

	$result[] = array('result' => $result1, 'sql' => $sql1, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
	return 0;
}
else if($category == 2) {
	//$sql = "SELECT * FROM USERS_J AS USERS_1 WHERE USERS_1.username IN (SELECT FOLLOW_USER.favoriteuser FROM USERS_J AS USERS_2, FOLLOW_USER WHERE USERS_2.username = '$username' AND USERS_2.username = FOLLOW_USER.username)";
	$sql1 = "SELECT * FROM FOLLOW_USER, USERS_J where users_j.email = FOLLOW_USER.username AND FOLLOW_USER.favoriteuser = '$username' ORDER BY DATE_FOLLOWED " .$desc;
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
		//$username = $row["favoriteuser"];
		$follower_name = $row["username"];	
		$nonda_count = 0;
		$nomitai_count = 0;
		$follow_count = 0;
		$follower_count = 0;

		// nonda count
		$sql = "SELECT count(TABLE_NONDA.contributor) FROM TABLE_NONDA WHERE '$follower_name' = TABLE_NONDA.contributor"; 
		$res2 = executequery($db, $sql);

		if($row2 = getnextrow($res2)) {
			$nonda_count = $row2["count(TABLE_NONDA.contributor)"];
		}

		// follow count 
		$sql = "SELECT count(FOLLOW_USER.username) FROM FOLLOW_USER WHERE '$follower_name' = FOLLOW_USER.username";
		$res3 = executequery($db, $sql);

		if($row3 = getnextrow($res3)) {
			$follow_count = $row3["count(FOLLOW_USER.username)"];
		}

		// follower count 
		$sql = "SELECT count(FOLLOW_USER.favoriteuser) FROM FOLLOW_USER WHERE '$follower_name' = FOLLOW_USER.favoriteuser";
		$res3 = executequery($db, $sql);

		if($row3 = getnextrow($res3)) {
			$follower_count = $row3["count(FOLLOW_USER.favoriteuser)"];
		}

		$imagefile = null;
		$email = stripslashes($row["email"]);
		$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$email' AND status = 1";
		$res4 = executequery($db, $sql);
		$rd = getnextrow($res4);

		if($rd) {
			$imagefile = $rd["filename"];
		}

		$sql = "SELECT count(*) FROM FOLLOW_USER where FOLLOW_USER.username = '$username' AND FOLLOW_USER.favoriteuser = '$follower_name'";
		$res5 = executequery($db, $sql);
		$row5 = getnextrow($res5);
		$followed = $row5["count(*)"];
		
		$result1[] = array('username' => $follower_name, 
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
							'imagefile' => $imagefile,
							'address_disclose' => $row["address_disclose"],
							'certification_disclose' => $row["certification_disclose"],
							'sex_disclose' => $row["sex_disclose"],
							'age_disclose' => $row["age_disclose"],
							'nonda_count' => $nonda_count,
							'follow_count' => $follow_count,
							'follower_count' => $follower_count,
							'followed' => $followed);
		$count_result++;
	}

	$result[] = array('result' => $result1, 'sql' => $sql1, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
	return 0;
}

?>
