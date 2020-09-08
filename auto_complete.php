<?php
require_once("db_functions.php");

if(isset($_POST["search_text"]) && $_POST["search_text"] == "")
{
	die("入力エラー .<br />");
}

$username = $_COOKIE['login_cookie'];
$sake_name = sqlite3::escapeString( $_POST["search_text"] );

if(!$db = opendatabase("sake.db"))
{
	die("データベース接続エラー .<br />");
}

if($_POST["search_type"] == 1)
{
	/***********
	 * 酒
	 ***********/
	//$condition = "WHERE (sake_name LIKE \"".$sake_name."%\" OR sake_read LIKE \"".$sake_name."%\") AND SAKE_J.sakagura_id = SAKAGURA_J.id";

	$sake_name = sqlite3::escapeString($_POST["search_text"]);
	$sake_name = str_replace("　", " ", $sake_name);
	$keyword_elements = explode(' ', $sake_name);
	$condition = "";

	if(count($keyword_elements) > 1)
	{
		$expression = "";			

		foreach($keyword_elements as $element) {
			if($expression == "")
			{
				$expression = '(sake_name LIKE "%' .$element .'%" OR sake_read LIKE "%' .$element. '%" OR sake_search LIKE "%' .$element. '%" OR sake_english LIKE "%' .$element .'%")';
			}
			else
			{
				$expression .= ' AND (sake_name LIKE "%' .$element .'%" OR sake_read LIKE "%' .$element. '%" OR sake_search LIKE "%' .$element. '%" OR sake_english LIKE "%' .$element .'%")';
			}
		}

		$condition = 'WHERE (' .$expression .') AND SAKE_J.sakagura_id = SAKAGURA_J.id';
	}
	else
	{
		$condition = 'WHERE (sake_name LIKE "%' .$sake_name .'%" OR sake_read LIKE "%' .$sake_name .'%" OR sake_english LIKE "%' .$sake_name .'%") AND SAKE_J.sakagura_id = SAKAGURA_J.id';
	}

	$sql = "SELECT sake_name, sake_read, sake_id, sakagura_name, pref FROM SAKE_J, SAKAGURA_J " .$condition." ORDER BY sake_read"." LIMIT ".$_POST["search_limit"];
	$res = executequery($db, $sql);

	if(!$res)   
	{
		die('Error');
	}
	else
	{
		while($row = getnextrow($res))
		{
			$sql = "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$row["sake_id"] ."' LIMIT 2";
			$result_set = executequery($db, $sql);
			$path = "images/icons/NoPhotoSake.jpg";		   
 
			if($record = getnextrow($result_set))
			{
				$path = "images/photo/thumb/".$record["filename"];
			}

			//$row["sake_name"] = str_replace("%", "\%", $row["sake_name"]);
			$result[] = array('sake_name' => $row["sake_name"], 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"], 'sakagura_name' => $row["sakagura_name"], 'pref' => $row["pref"], 'filename' => $path);
		}

		header('Content-Type: application/json');
		echo json_encode($result);
	}
}
else if($_POST["search_type"] == 2)
{
	/**************
	 * 酒蔵
	 **************/
	$condition = "WHERE sakagura_name LIKE \"" .$sake_name. "%\" OR sakagura_read LIKE \"" .$sake_name."%\" OR sakagura_search LIKE \"" .$sake_name."%\"";
	$sql = "SELECT sakagura_name as sake_name, sakagura_read as sake_read, id as sake_id, pref, address, phone, url FROM SAKAGURA_J " .$condition." ORDER BY sakagura_read"." LIMIT ".$_POST["search_limit"];

	$res = executequery($db, $sql);

	if(!$res)   
	{
		die('Error');
	}
	else
	{
		$path = "images/icons/sakagura2.jpg";

		while($row = getnextrow($res))
		{
			$result[] = array('sake_name' => $row["sake_name"], 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"], 'pref' => $row["pref"], 'address' => $row["address"], 'phone' => $row["phone"], 'url' => $row["url"], 'filename' => $path);
		}

		header('Content-Type: application/json');
		echo json_encode($result);
	}
}
else if($_POST["search_type"] == 3)
{
	/**************
	 * 酒販店
	 **************/
	$condition = "WHERE syuhanten_name LIKE \"" .$sake_name. "%\" OR syuhanten_read LIKE \"" .$sake_name."%\"";
	$sql = "SELECT syuhanten_name as sake_name, syuhanten_read as sake_read, syuhanten_id as sake_id FROM SYUHANTEN_J " .$condition." ORDER BY syuhanten_read"." LIMIT ".$_POST["search_limit"];

	$res = executequery($db, $sql);

	if(!$res)   
	{
		die('Error');
	}
	else
	{
		while($row = getnextrow($res))
		{
			$result[] = array('sake_name' => $row["sake_name"], 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"]);
		}

		header('Content-Type: application/json');
		echo json_encode($result);
	}
}
else if($_POST["search_type"] == 4)
{
	/**************
	 * ユーザー
	 **************/
	$condition = "WHERE username LIKE \"" .$sake_name. "%\" OR fname LIKE \"" .$sake_name."%\"";
	$sql = "SELECT username, fname, lname, bdate, email, phone FROM USERS_J " .$condition." ORDER BY username"." LIMIT ".$_POST["search_limit"];

	$res = executequery($db, $sql);

	if(!$res)   
	{
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	else
	{
		while($row = getnextrow($res))
		{
			$result[] = array('username' => $row["username"], 'fname' => $row["fname"], 'lname' => $row["lname"], 'email' => $row["email"], 'phone' => $row["phone"], 'bdate' => $row["bdate"]);
		}

		header('Content-Type: application/json');
		echo json_encode($result);
	}
}

?>
