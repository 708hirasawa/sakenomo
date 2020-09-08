<?php

require_once("db_functions.php");

$email = $_POST['email'];

if(!$db = opendatabase("sake.db"))
{
	$return = "connection_failure";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

//if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
//if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)))

if(!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {

	$return = "invalid_email";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

$sql = "SELECT username, password, usertype FROM USERS_J WHERE username = '$email' OR email = '$email'";
$res = executequery($db, $sql);
$row = getnextrow($res);

if(!$row) {
	$return = "success";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
}
else {
	$return = "already_exist";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
?>
