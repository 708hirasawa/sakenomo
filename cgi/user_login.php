<?php

require_once("../db_functions.php");

$email = $_POST['email'];
$password = $_POST['user_password'];

if(!$db = opendatabase("../sake.db"))
{
   die("データベース接続エラー .<br />");
}

//$sql = "SELECT username, password, nickname, email, usertype FROM USERS_J WHERE (email = '$email' OR username = '$email') AND password = '$password'";
$sql = "SELECT username, password, nickname, email, usertype FROM USERS_J WHERE (email = '$email' OR username = '$email')";

$res = executequery($db, $sql);
$row = getnextrow($res);

if($row)
{
	$hash = $row["password"];

	if(!password_verify($password, $row['password'])) {

		$return = "パスワードが違います";

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
		return 0;		
	} 

	$return = "success";

	$username = $row["username"];
	$path = "images/icons/noimage_user30.svg";
	$imagefile = null;
	$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$username' AND status = 1";
	$result = executequery($db, $sql);
	$rd = getnextrow($result);
	
	$currdir = dirname(dirname(__FILE__));
	$basedir = '/' .substr(strrchr($currdir, "/"), 1) .'/';
	$basedir = (strcmp($basedir, '/public_html/') == 0) ? '/' : $basedir;

	if($rd) {
		$imagefile = $rd["filename"];
		$path = "images/profile/" .$imagefile;
	}

	setcookie("login_cookie", $row["username"], time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("username", $row["username"], time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("nickname", $row["nickname"], time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("email", $row["email"], time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("usertype_cookie", $row["usertype"], time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("user_profile_image", $path, time() + (10 * 365 * 24 * 60 * 60), $basedir);

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <username>'.$row["username"].'</username>'."\n";
	echo ' <usertype>'.$row["usertype"].'</usertype>'."\n";
	echo ' <base>'.$basedir.'</base>'."\n";
	echo '</xml>'."\n";
}
else
{
	$return = "パスワードが違います";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
?>
