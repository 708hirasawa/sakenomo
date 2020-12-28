<?php

require_once("db_functions.php");

$email = $_GET['email'];
$password = $_GET['password'];

if(!$db = opendatabase("sake.db"))
{
	die("データベース接続エラー.<br />");
}

$intime = time();
$username = "sakenomo" .$intime;

$sql = "INSERT INTO USERS_J(username, 
	                        password, 
	                        email) VALUES(
                            '$username', 
                            '$password', 
                            '$email')";

$res = executequery($db, $sql);

if(!$res)   
{
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
	print('<script src="js/sakenomuui.js"></script>');

	print('<body>');
	print('<div>登録できませんでした。</div>');
	print('</body>');
	print('</html>');
}
else
{
	setcookie("login_cookie", $username);
    setcookie("password_cookie", $password);
	setcookie("usertype_cookie", 9);

	$url = "";

	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
		$url = "https://";   
	else  
		$url = "http://";   

	// Append the host(domain name, ip) to the URL.   
	$url.= $_SERVER['HTTP_HOST'] ."/" .basename(__DIR__);   
	header('Location: ' .$url . '/mail_registry_complete.php?username=' .$username);
}

?>
