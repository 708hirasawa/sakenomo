<?php

require_once("../db_functions.php");

$token = $_GET['token'];

if(!$db = opendatabase("../sake.db")) {
	die("データベース接続エラー.<br />");
}

$sql = "SELECT * FROM PRE_USERS WHERE token = '$token'";
$res = executequery($db, $sql);
$row = getnextrow($res);

if(!$row) {
	print("このトークンは無効です。" ."<br />");
	return;
}

$email = $row['email'];
$password = $row['password'];
$date = $row['date'];
$intime = time();

if(($intime - $date) > 86400) {
	print("このURLはご利用できません。有効期限が過ぎたかURLが間違えている可能性がございます。もう一度登録をやりなおして下さい。");
	return;
} 
	
$username = "sakenomo" .$intime;
$password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO USERS_J(username, nickname, password, email, user_added_date, modified_date) VALUES('$username', '$username', '$password', '$email', '$intime', '$intime')";
$res = executequery($db, $sql);

if(!$res) {
	print('<!DOCTYPE html>');
	print('<html lang="ja">');
	print('<head>');
	print('<meta charset="utf-8">');
	print('<meta http-equiv="Content-Style-Type" content="text/css">');
	print('<meta http-equiv="Content-Script-Type" content="text/javascript">');
	print('<meta content="width=device-width, initial-scale=1" name="viewport">');
	print('</head>');

	print('<title>会員登録</title>');
	print('<script src="//code.jquery.com/jquery-1.10.2.js"></script>');
	print('<script src="../js/sakenomuui.js"></script>');

	print('<body>');
	print('<div>登録できませんでした。</div>');
	print('</body>');
	print('</html>');
}
else
{
	$currdir = dirname(dirname(__FILE__));
	$basedir = '/' .substr(strrchr($currdir, "/"), 1) .'/';
	$basedir = (strcmp($basedir, '/public_html/') == 0) ? '/' : $basedir;

	setcookie("login_cookie", $username, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("username", $username, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("nickname", $username, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("email", $email, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("password_cookie", $password, time() + (10 * 365 * 24 * 60 * 60), $basedir);
	setcookie("usertype_cookie", 9, time() + (10 * 365 * 24 * 60 * 60), $basedir);

	$sql = "DELETE FROM PRE_USERS WHERE token = '$token'";
	$res = executequery($db, $sql);
	$url = "";

	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
		$url = "https://";
	else
		$url = "http://";

	// Append the host(domain name, ip) to the URL.
	$url.= $_SERVER['HTTP_HOST'] .$basedir;
	header('Location: ' .$url . 'mail_registry_complete.php');
}
?>
