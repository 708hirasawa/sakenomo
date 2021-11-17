<?php

require_once("../db_functions.php");

$username = $_POST['email'];
$password = $_POST['user_password'];
$new_password = $_POST['new_password'];
$new_password = password_hash($new_password, PASSWORD_DEFAULT);

if(!$db = opendatabase("../sake.db"))
{
   die("データベース接続エラー .<br />");
}

$sql = "SELECT username, password, nickname FROM USERS_J WHERE username = '$username' AND password = '$password'";
$res = executequery($db, $sql);
$row = getnextrow($res);

if($row)
{
	$return = "success";

	$sql = "UPDATE USER_J SET password = '$new_password' WHERE username = '$username'";
	$res = executequery($db, $sql);

	if($res) {
		$return = "update_failed";
		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo ' <base>'.$basedir.'</base>'."\n";
		echo '</xml>'."\n";
	}
	else {
		$return = "success";
		setcookie("password_cookie", $password, time() + (10 * 365 * 24 * 60 * 60), $basedir);

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
	}
}
else
{
	$return = "wrong_password";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <base>'.$basedir.'</base>'."\n";
	echo '</xml>'."\n";
}
?>
