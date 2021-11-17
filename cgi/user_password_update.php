<?php

require_once("../db_functions.php");
$email = "";
$new_password = "";
$clause = "";

if(isset($_POST['new_password']) && $_POST['new_password'] != 'undefined')
{
	$new_password = $_POST['new_password'];
}

if(isset($_POST['username']) && $_POST['username'] != 'undefined')
{
	$username = $_POST['username'];

	if($clause == "")
	{
		$clause = " WHERE username ='" .$username . "'";
	}
	else
	{
		$clause .= " AND username ='" .$username . "'";
	}
}

if(isset($_POST['email']) && $_POST['email'] != 'undefined')
{
	$email = $_POST['email'];

	if($clause == "")
	{
		$clause = " WHERE email ='" .$email . "'";
	}
	else
	{
		$clause .= " AND email ='" .$email . "'";
	}
}

if($email == "" && $username == "")
 {
	$return = "failed1";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

if(!$db = opendatabase("../sake.db")) {
   die("データベース接続エラー .<br />");
}

$new_password = password_hash($new_password, PASSWORD_DEFAULT);
$sql = "UPDATE USERS_J SET password = '$new_password' " .$clause;
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed2";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '<sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
	return;
}

$sql = "SELECT * FROM USERS_J" .$clause;
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed3";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '<sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
}

$row = getnextrow($res);

if(!$row)   
{
	$return = "failed4";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '<sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
	return;
}

$username = $row['username'];
$email = $row['email'];
$nickname = $row['nickname'];
$password = $row['password'];

$currdir = dirname(dirname(__FILE__));
$basedir = '/' .substr(strrchr($currdir, "/"), 1) .'/';
$basedir = (strcmp($basedir, '/public_html/') == 0) ? '/' : $basedir;

$path = "images/icons/noimage_user30.svg";
$imagefile = null;
$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$username' AND status = 1";
$result = executequery($db, $sql);
$rd = getnextrow($result);

if($rd) {
	$imagefile = $rd["filename"];
	$path = "images/profile/" .$imagefile;
}

setcookie("login_cookie", $username, time() + (10 * 365 * 24 * 60 * 60), $basedir);
setcookie("username", $username, time() + (10 * 365 * 24 * 60 * 60), $basedir);
setcookie("email", $email, time() + (10 * 365 * 24 * 60 * 60), $basedir);
setcookie("nickname", $nickname, time() + (10 * 365 * 24 * 60 * 60), $basedir);
setcookie("password_cookie", $new_password, time() + (10 * 365 * 24 * 60 * 60), $basedir);
setcookie("usertype_cookie", $row["usertype"], time() + (10 * 365 * 24 * 60 * 60), $basedir);
setcookie("user_profile_image", $path, time() + (10 * 365 * 24 * 60 * 60), $basedir);

unset($_SESSION['authToken']); 

$return = "success";

header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo ' <str>'.$return.'</str>'."\n";
echo ' <sql>'.$sql.'</sql>'."\n";
echo '</xml>'."\n";

?>
