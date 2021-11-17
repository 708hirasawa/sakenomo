<?php

session_start();
require_once("../db_functions.php");

mb_language("Japanese");
mb_internal_encoding("UTF-8");

$auth_code = generateRandomString();
$_SESSION['authToken'] = $auth_code;

$email = $_POST['email'];
$username = $_POST['username'];

if(!$db = opendatabase("../sake.db")) {
	return;
}

if(!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
	return;
}

$sql = "SELECT username FROM USERS_J WHERE email = '$email'";
$res = executequery($db, $sql);
$row = getnextrow($res);

if($row) {
	$title = "Sakenomoパスワードリセットのご案内";
	$to = $email;
	$content = "Sakenomoをご利用いただき誠にありがとうございます。\nご使用中のSakenomoアカウントのパスワードをリセットするには、下記の認証コードをSakenomoの『認証コード入力ページ』にご入力ください。\n本メールにお心当たりがない場合は、恐れ入りますが、破棄してくださいますようお願い申し上げます。\n\n" .$auth_code;

	if(mb_send_mail($to, $title, $content)) {
		$return = "success";

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
	}
	else {
		$return = "failed";

		header("Content-type: application/xml");
		echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
		echo '<xml>'."\n";
		echo ' <str>'.$return.'</str>'."\n";
		echo '</xml>'."\n";
	}
}
else {
	$return = "failed";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
?>
