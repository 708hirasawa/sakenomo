<?php

require_once("db_functions.php");
$username = $_COOKIE['login_cookie'];
$favoriteuser = $_POST['favoriteuser'];

//$favoriteuser = sqlite3::escapeString($_GET['favoriteuser']);

if(!$db = opendatabase("sake.db"))
{
	$return = "failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

$sql = "SELECT * FROM FOLLOW_USER WHERE username = '$username' AND favoriteuser = '$favoriteuser'";
$res = executequery($db, $sql);

if(!res)
{
	$return = "failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return;
}

$record = getnextrow($res);

if(!$record) { 

	$intime = time();
	$sql = "INSERT INTO FOLLOW_USER VALUES ('$username', '$favoriteuser', $intime)";
	$res = executequery($db, $sql);

	$return = "followed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
else {

	$sql = "DELETE FROM FOLLOW_USER WHERE username = '$username' AND favoriteuser = '$favoriteuser'";
	$res = executequery($db, $sql);

	if(!$res)
		$return = "failed";
	else
		$return = "unfollowed";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
?>
