<?php

require_once("db_functions.php");
$username = $_COOKIE['login_cookie'];

if(!$db = opendatabase("sake.db"))
{
	die("データベース接続エラー .<br />");
}

if(isset($_POST["search_text"]) && ($_POST["search_text"] != ""))
{
	$sake_name = sqlite3::escapeString($_POST["search_text"]);
	//$sake_name = str_replace("%", "\%", $sake_name);

	$sake_name = str_replace("　", " ", $sake_name);
	$keyword_elements = explode(' ', $sake_name);
	$condition = "";

	if(count($keyword_elements) > 1)
	{
		$expression = "";			

		foreach($keyword_elements as $element) {
			if($expression == "")
			{
				$expression = '(sake_name LIKE "%' .$element .'%" OR sake_read LIKE "%' .$element. '%" OR sake_search LIKE "%' .$element. '%" OR sake_english LIKE "%' .$element .'%" OR sake_id LIKE "%' .$element .'%")';
			}
			else
			{
				$expression .= ' AND (sake_name LIKE "%' .$element .'%" OR sake_read LIKE "%' .$element. '%" OR sake_search LIKE "%' .$element. '%" OR sake_english LIKE "%' .$element .'%" OR sake_id LIKE "%' .$element .'%")';
			}
		}

		$condition = 'WHERE (' .$expression .')';
	}
	else
	{
		$condition = 'WHERE sake_name LIKE "' .$sake_name .'%" OR sake_read LIKE "%' .$sake_name. '%" OR sake_english LIKE "%' .$sake_name .'%"';
	}
}

$sql = "SELECT COUNT(*) FROM SAKE_J " .$condition." ORDER BY sake_read"." LIMIT 12";
$res = executequery($db, $sql);
$row = getnextrow($res); 
$count_result = $row["COUNT(*)"];

$sql = "SELECT sake_name, sake_read, sake_id FROM SAKE_J " .$condition." ORDER BY sake_read"." LIMIT 8";
$res = executequery($db, $sql);

if(!$res)   
{
	die('Error');
}
else
{
    while($row = getnextrow($res))
    {
		$sql = "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$row["sake_id"] ."' LIMIT 8";
		$result_set = executequery($db, $sql);
	    
	    if($rd = getnextrow($result_set))
		{
			//$result1[] = array('sake_name' => $row["sake_name"], 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"], 'filename' => $rd["filename"]);
			$result1[] = array('sake_name' => stripslashes($row["sake_name"]), 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"], 'sakagura_name' => $row["sakagura_name"], 'filename' => $rd["filename"], 'sake_rank' => $row["sake_rank"], 'address' => $row["address"], 'phone' => $row["phone"], 'url' => $row["url"]);
	    }
	    else
	    {
			$default_image = "sake.jpg";
			$result1[] = array('sake_name' => stripslashes($row["sake_name"]), 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"], 'sake_rank' => $row["sake_rank"], 'sakagura_name' => $row["sakagura_name"], 'address' => $row["address"], 'phone' => $row["phone"], 'url' => $row["url"], 'filename' => $default_image);
		}

        //$result1[] = array('sake_name' => stripslashes($row["sake_name"]), 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"]);
    }
}

/**************
 * 酒蔵
 **************/

$condition = "WHERE sakagura_name LIKE \"" .$sake_name. "%\" OR sakagura_read LIKE \"" .$sake_name."%\" OR sakagura_search LIKE \"%" .$sake_name."%\"";
$sql = "SELECT sakagura_name as sake_name, sakagura_read as sake_read, id as sake_id FROM SAKAGURA_J " .$condition." ORDER BY sakagura_read"." LIMIT 8";
$res = executequery($db, $sql);

if(!$res)   
{
	die('Error');
}
else
{
    while($row = getnextrow($res))
    {
        $result2[] = array('sake_name' => $row["sake_name"], 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"]);
    }
}

/**************
 * 酒販店
 **************/

$condition = "WHERE syuhanten_name LIKE \"" .$sake_name. "%\" OR syuhanten_read LIKE \"" .$sake_name."%\"";
$sql = "SELECT syuhanten_name as sake_name, syuhanten_read as sake_read, syuhanten_id as sake_id FROM SYUHANTEN_J " .$condition." ORDER BY syuhanten_read"." LIMIT 8";
$res = executequery($db, $sql);

if(!$res)   
{
	die('Error');
}
else
{
    while($row = getnextrow($res))
    {
        $result3[] = array('sake_name' => $row["sake_name"], 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"]);
    }
}

$result[] = array('sake' => $result1, 'sakagura' => $result2, 'syuhanten' => $result3);

header('Content-Type: application/json');
echo json_encode($result);

?>
