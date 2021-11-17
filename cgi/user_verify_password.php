<?php

require_once("../db_functions.php");

$username = $_POST['username'];
$password = $_POST['password'];

if(!$db = opendatabase("../sake.db"))
{
	$return = "connection_failure";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

$sql = "SELECT * FROM USERS_J WHERE username = '$username'";
$res = executequery($db, $sql);
$row = getnextrow($res);

if($row) 
{
	if(!password_verify($password, $row['password'])) 
	{
		$return = "failed";

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <sql>'.$sql.'</sql>'."\n";
		echo '</xml>'."\n";
	}
	else
	{
		$return = "success";

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <sql>'.$sql.'</sql>'."\n";
		echo '</xml>'."\n";
	}
}
else 
{
	$return = "user_doesnotexist";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
}
?>
