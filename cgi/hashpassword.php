<?php

define('MUTEX_KEY', 123456); # the key to access you unique semaphore

require_once("../db_functions.php");

if(!$db = opendatabase("../sake.db")) {
	die("データベース接続エラー.<br />");
}

$sql = "SELECT * FROM USERS_J";
$res = executequery($db, $sql);

if(!$res) {
	die("データベース接続エラー.<br />");
}

sem_get( MUTEX_KEY, 1, 0666, 1 );
sem_acquire( ($resource = sem_get( MUTEX_KEY )) );

while($row = getnextrow($res)) {

	$username = $row['username'];
	$email = $row['email'];
	$password = $row['password'];

	$password = password_hash($password, PASSWORD_DEFAULT);
	$sql = "UPDATE USERS_J SET password = '$password' WHERE username = '$username'";
	$result = executequery($db, $sql);

	if(!$result) {
		sem_release( $resource );
	}

	print("updating email:" .$email ." username:" .$username ." password:" .$password);
}

sem_release( $resource );


?>
