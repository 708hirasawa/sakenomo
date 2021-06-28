<?php
require_once("db_functions.php");

if(!$db = opendatabase("sake.db"))
{
	$return = "database connection failed";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$username = $_POST['username'];

$sql = "SELECT * FROM USERS_J WHERE username = '$username'";
$res = executequery($db, $sql);

if(!$res)
{
	$return = "failed deleting the user";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$sql = "DELETE FROM USERS_J WHERE username = '$username'";
$res = executequery($db, $sql);

if(!$res)
{
	$return = "failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$sql = "DELETE FROM FOLLOW_USER WHERE username = '$username'";
$res = executequery($db, $sql);

if(!$res)
{
	$return = "deleting from follow_user username failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$sql = "DELETE FROM FOLLOW_USER WHERE favoriteuser = '$username'";
$res = executequery($db, $sql);

if(!$res)
{
	$return = "deleting from follow_user favoriteuser failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$sql = "DELETE FROM FOLLOW_J WHERE username = '$username'";
$res = executequery($db, $sql);

if(!$res)
{
	$return = "failed to delete from follow";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$sql = "DELETE FROM FAVORITE_J WHERE username = '$username'";
$res = executequery($db, $sql);

if(!$res)
{
	$return = "failed to delete from favorite";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$sql = "DELETE FROM TABLE_NONDA WHERE contributor = '$username'";
$res = executequery($db, $sql);

if(!$res)
{
	$return = "failed to delete from nonda";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$sql = "DELETE FROM profile_image WHERE contributor = '$username'";
$res = executequery($db, $sql);

if(!$res)
{
	$return = "failed to delete profile image";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$return = "success";
//setcookie("login_cookie", "", time() + (10 * 365 * 24 * 60 * 60));
setcookie("login_cookie", "", 0);

header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo '<sql>'.$sql.'</sql>'."\n";
echo '<str>'.$return.'</str>'."\n";
echo '</xml>'."\n";

?>
