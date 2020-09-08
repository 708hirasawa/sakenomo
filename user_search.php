<?php
require_once("db_functions.php");

$sql = 0;
$count_result = 0;
$condition = "";

if(isset($_POST["username"]) && $_POST["username"] == "")
{
	$username = sqlite3::escapeString( $_POST["username"] );

	$condition = 'WHERE username LIKE "' .$username;
}

if(isset($_POST["keyword"]) && $_POST["keyword"] == "")
{
	$keyword = sqlite3::escapeString( $_POST["keyword"] );

	if($condition == "")
	{
		$condition = 'WHERE username LIKE "' .$keyword;
	}
	else
	{
		$condition .= " AND username LIKE "' .$keyword;
	}
}

if(!$db = opendatabase("sake.db"))
{
	$result1 = 0;

	$result[] = array('user' => $result1, 'sql' => $sql, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
	return 0;
}

$sql = "SELECT * FROM USERS_J .$condition;
$res = executequery($db, $sql);
$row = getnextrow($res);
$count_result = 0;

if(!$row)
{
	$result1 = 0;

	$result[] = array('user' => $result1, 'sql' => $sql, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
	return 0;
}

while($row = getnextrow($res))
{
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
						'address_disclose' => $row["address_disclose"],
						'certification_disclose' => $row["certification_disclose"],
						'sex_disclose' => $row["sex_disclose"],
						'age_disclose' => $row["age_disclose"]);
	$count_result++;
}

header('Content-Type: application/json');
$result[] = array('user' => $result1, 'sql' => $sql, 'count' => $count_result);


?>
