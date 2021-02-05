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

$email = $username;

if($row = getnextrow($res))
	$email = $row["email"];

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

$sql = "DELETE FROM FOLLOW_USER WHERE username = '$email'";
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

$sql = "DELETE FROM FOLLOW_USER WHERE favoriteuser = '$email'";
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

$sql = "DELETE FROM FOLLOW_J WHERE username = '$email'";
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

$sql = "DELETE FROM FAVORITE_J WHERE username = '$email'";
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

$sql = "DELETE FROM TABLE_NONDA WHERE contributor = '$email'";
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

$sql = "DELETE FROM profile_image WHERE contributor = '$email'";
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

header("Content-type: application/xml");
echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
echo '<xml>'."\n";
echo '<sql>'.$sql.'</sql>'."\n";
echo '<str>'.$return.'</str>'."\n";
echo '</xml>'."\n";

?>
