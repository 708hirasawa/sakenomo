<?php
require_once("db_functions.php");

function displaySpecialName($sake_code)
{
	$special_name = "";

	if($sake_code == null || $sake_code == "")
		return $special_name;

	$special_array = explode(',', $sake_code);
	
	if($special_array[0] == "11")
	{
		$special_name = "普通酒";
	}
	else if($special_array[0] == "21")
	{
		$special_name = "本醸造酒";
	}
	else if($special_array[0] == "22")
	{
		$special_name = "特別本醸造酒";
	}
	else if($special_array[0] == "31")
	{
		$special_name = "純米酒";
	}
	else if($special_array[0] == "32")
	{
		$special_name = "特別純米酒";
	}
	else if($special_array[0] == "33")
	{
		$special_name = "純米吟醸酒";
	}
	else if($special_array[0] == "34")
	{
		$special_name = "純米大吟醸酒";
	}
	else if($special_array[0] == "43")
	{
		$special_name = "吟醸酒";
	}
	else if($special_array[0] == "44")
	{
		$special_name = "大吟醸酒";
	}
	else if($special_array[0] == "90")
	{
		$special_name = $special_array[1];
	}
	else if($special_array[0] == "45")
	{
		$special_name = "非公開";
	}
	else
	{
		$special_name = "";
	}

	return $special_name;
}

function displaySeimaiRate($db, $rice_used, $seimai_rate)
{
	$seimai = "";

	if(($rice_used   && $rice_used   != "") && 
	   ($seimai_rate && $seimai_rate != "")) {

		$rice_array   = explode('/', $rice_used);
		$seimai_array = explode(',', $seimai_rate);
		$bfound = false;

		foreach($seimai_array as $element) 
		{
			if($element) {
				$bfound = true;
				break;
			}
		}

		if($bfound) 
		{
			for($i = 0; $i < count($seimai_array); $i++) 
			{
				if($i > 0 && $seimai_array[$i] != "") 
				{
					$seimai .= " / ";
				}
	
				if(count($rice_array) > 0 && $i < count($rice_array)) 
				{
					$rice_entry = explode(',', $rice_array[$i]);
					if($rice_entry[1] == "1") {
						$seimai .= "麹米:";
					} else if($rice_entry[1] == "2") {
						$seimai .= "掛米:";
					}
				}
	
				if($seimai_array[$i])
					$seimai .= $seimai_array[$i] ."%";
			}
		} 
		else 
		{
			$seimai .= '<span style="color: #b2b2b2;">--</span>';
		}
	}
	
	return $seimai;
}

function displayOxidation($db, $oxidation_level)
{
	$oxidation_array = explode(',', $oxidation_level);
	$oxidation = "";

	if(count($oxidation_array) == 1)
	{
		$oxidation = $oxidation_array[0];
	}
	else
	{
		if($oxidation_array[0] == $oxidation_array[1])
		{
			$oxidation = $oxidation_array[0];
		}
		else
		{
			if($oxidation_array[0] != null && $oxidation_array[1] != null)
				$oxidation = $oxidation_array[0].'～'.$oxidation_array[1];
			else if($oxidation_array[0] != null && $oxidation_array[1] == null)
				$oxidation = $oxidation_array[0];
			else if($oxidation_array[0] == null && $oxidation_array[1] != null)
				$oxidation = $oxidation_array[1] ."以下";
		}
	}

	return $oxidation;
}

function displaySyudo($db, $jsake_level)
{
	$syudo_array = explode(',', $jsake_level);
	$syudo = "";

	if(count($syudo_array) == 1)
	{
			$syudo = $syudo_array[0];
	}
	else
	{
		if($syudo_array[0] == $syudo_array[1])
		{
				$syudo = $syudo_array[0];
		}
		else
		{
			if($syudo_array[0] != null && $syudo_array[1] != null)
				$syudo = $syudo_array[0].'～'.$syudo_array[1];
			else if($syudo_array[0] != null && $syudo_array[1] == null)
				$syudo = $syudo_array[0];
			else if($syudo_array[0] == null && $syudo_array[1] != null)
				$syudo = $syudo_array[1] ."以下";
		}
	}

	return $syudo;
}

function displayAlcohol($alcohol_level)
{
	$alcohol = "";

	if($alcohol_level == null || $alcohol_level == "")
		return $alcohol;

	$alcohol_array = explode(',', $alcohol_level);

	if($alcohol_array[0] != null && $alcohol_array[1] != null) {
		if($alcohol_array[0] == $alcohol_array[1]) {
			$alcohol = $alcohol_array[0].'%';
		} else {
			$alcohol = $alcohol_array[0] .'～'.$alcohol_array[1].'%';
		}
	} else if($alcohol_array[0] != null && $alcohol_array[1] == null) {
		$alcohol = $alcohol_array[0] .'%';
	} else {
		$alcohol = '<span style="color: #b2b2b2;">--</span>';
	}

	return $alcohol;
}

function displayAminoLevel($db, $amino_level)
{
	$amino_array = explode(',', $amino_level);
	$amino_level = "";

	if(count($amino_array) == 1)
	{
		$amino_level = $amino_array[0];
	}
	else
	{
		if($amino_array[0] == $amino_array[1])
		{
			$amino_level = $amino_array[0];
		}
		else
		{
			if($amino_array[0] != null && $amino_array[1] != null)
				$amino_level = $amino_array[0].'～'.$amino_array[1];
			else if($amino_array[0] != null && $amino_array[1] == null)
				$amino_level = $amino_array[0] ."以上";
			else if($amino_array[0] == null && $amino_array[1] != null)
				$amino_level = $amino_array[1] ."以下";
			else
				$amino_level = $amino_array[0] ."以下";
		}
	}

	return $amino_level;
}

function displayRice($db, $rice_used)
{
	$rice_value = "";

	if($rice_used && $rice_used != "") 
	{
		$rice_array = explode('/', $rice_used);

		for($i = 0; $i < count($rice_array); $i++) {
			$rice_entry = explode(',', $rice_array[$i]);

			if($i > 0 && $rice_entry[0] != "") {
				$rice_value .= " / ";
			}

			$sql = "SELECT SAKE_RICE.rice_name, SAKE_RICE.rice_kanji, SAKE_RICE.rice_kana FROM SAKE_RICE WHERE SAKE_RICE.rice_name = '$rice_entry[0]'";
			$sake_result = executequery($db, $sql);
			$record = getnextrow($sake_result);

			if($rice_entry[1] == "1") {
				$rice_value .= "麹米:";
			} else if($rice_entry[1] == "2") {
				$rice_value .= "掛米:";
			}

			if($rice_entry[0] != "") 
			{
				if($rice_entry[0] == "other" && count($rice_entry) >= 3) {
					$rice_value .= $rice_entry[3];
				} 
				else 
				{
					$rice_kanji = $record ? $record["rice_kanji"] : $rice_used;
					$rice_value .= $rice_kanji ." ";
				}
			}
		}
	} 
	else 
	{
		$rice_value .= '<span style="color: #b2b2b2;">--</span>';
	}

	return $rice_value;
}

//$username = $_COOKIE['login_cookie'];
$username = $_POST["username"];
$from = $_POST["from"];
$disp_max = (isset($_POST["disp_max"]) && ($_POST["disp_max"] != "")) ? $_POST["disp_max"] : 25;

$search_type = $_POST["search_type"];
$count_query = $_POST["count_query"];

if(!$db = opendatabase("sake.db"))
{
	die("データベース接続エラー .<br />");
}

if($_POST["search_type"] == "1")
{
	/***********
	 * 酒
	 ***********/
	$orderby = $_POST["orderby"];
	$pref = $_POST["pref"];
	$special_name = $_POST["special_name"];
	$count_result = 0;
	$condition = "WHERE FAVORITE_J.sake_id = SAKE_J.sake_id AND sakagura_id = id";	
	
	if($username != "")
	{
        $condition .= " AND username LIKE \"%".$username."%\"";
	}

	if($pref != "")
	{
        $condition .= " AND pref LIKE \"%".$pref."%\"";
	}

	if($special_name != "" && $special_name != undefined)
	{
        $condition .= " AND special_name LIKE \"%".$special_name."%\"";
	}

    if(isset($_POST["write_date_from"]) && ($_POST["write_date_from"] != ""))
    {
        $write_date_from = $_POST["write_date_from"];

		if(isset($_POST["write_date_to"]) && ($_POST["write_date_to"] != ""))
		{
			$write_date_to = $_POST["write_date_to"];
			$condition .= " AND (write_date >='" .$write_date_from. "' AND write_date < '" .$write_date_to. "')";
		}
    }

	if(isset($_POST['orderby']) && $_POST['orderby'] != "")
	{
		if($_POST['orderby'] == 2) {
			$orderby = "favorite_date ASC";
		}
		else {
			$orderby = "favorite_date DESC";
		}
	}
	else {
		$orderby = "favorite_date DESC";
	}

	if($count_query == 1)
	{
		$sql = "SELECT COUNT(*) FROM FAVORITE_J, SAKE_J, SAKAGURA_J " .$condition ." ORDER BY " .$orderby ." LIMIT ".$from.", ".$disp_max;
		$res = executequery($db, $sql);
		$record = getnextrow($res); 
		$count_result = $record["COUNT(*)"];

		$sql = "SELECT SAKE_J.sake_id, SAKE_J.sake_name, SAKE_J.sake_read, SAKE_J.special_name, SAKE_J.alcohol_level, SAKE_J.rice_used, SAKE_J.seimai_rate, SAKE_J.jsake_level, SAKE_J.oxidation_level, SAKE_J.amino_level, SAKE_J.koubo_used, SAKE_J.sake_rank, SAKE_J.write_date, FAVORITE_J.favorite_date, SAKAGURA_J.sakagura_name, SAKAGURA_J.sakagura_name, SAKAGURA_J.id, SAKAGURA_J.pref, SAKAGURA_J.address, FAVORITE_J.username FROM FAVORITE_J, SAKE_J, SAKAGURA_J " .$condition ." ORDER BY " .$orderby ." LIMIT ".$from.", ".$disp_max;
		$res = executequery($db, $sql);
	}
	else
	{
		$sql = "SELECT SAKE_J.sake_id, SAKE_J.sake_name, SAKE_J.sake_read, SAKE_J.special_name, SAKE_J.alcohol_level, SAKE_J.rice_used, SAKE_J.seimai_rate, SAKE_J.jsake_level, SAKE_J.oxidation_level, SAKE_J.amino_level, SAKE_J.koubo_used, SAKE_J.sake_rank, SAKE_J.write_date, FAVORITE_J.favorite_date, SAKAGURA_J.sakagura_name, SAKAGURA_J.sakagura_name, SAKAGURA_J.id, SAKAGURA_J.pref, SAKAGURA_J.address, FAVORITE_J.username FROM FAVORITE_J, SAKE_J, SAKAGURA_J " .$condition ." ORDER BY " .$orderby ." LIMIT ".$from.", ".$disp_max;
		$res = executequery($db, $sql);
		//$count_result = count($res);
	}

	if(!$res)   
	{
		header('Content-Type: application/json');
		$result_set[] = array('count' => $count_result, 'result' => null);
		echo json_encode($result_set);
	}
	else
	{
		while($row = getnextrow($res))
		{
            $sake_id = $row[sake_id];
			$intime = gmdate("Y/m/d", $row["favorite_date"] + 9 * 3600);
			$path = "images/icons/noimage160.svg";
            
			$sql1 = "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' LIMIT 2";
			$res_image = executequery($db, $sql1);

            if($record = getnextrow($res_image))
            {
				$path = "images\\photo\\thumb\\".$record["filename"];    
            }

            $sql2 = "SELECT AVG(rank) FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND rank is not 0";
            $res_avg = executequery($db, $sql2);
            $rd_average = getnextrow($res_avg);

            $avg_rank = $rd_average["AVG(rank)"];
            $avg_percent = ($avg_rank / 5) * 100;

			$result[] = array('path' => $path,
							  'sake_name' => $row["sake_name"], 
							  'sake_read' => $row["sake_read"], 
							  'sake_id'	  => $row["sake_id"],
							  'special_name' => displaySpecialName($row["special_name"]),
							  'alcohol_level' => displayAlcohol($row["alcohol_level"]), 
							  'rice_used' => displayRice($db, $row["rice_used"]), 
							  'seimai_level' => displaySeimaiRate($db, $row["rice_used"], $row["seimai_rate"]), 
							  'jsake_level'	 => displaySyudo($db, $row["jsake_level"]),
							  'oxidation_level' => displayOxidation($db, $row["oxidation_level"]), 
							  'amino_level'	  => displayAminoLevel($db, $row["amino_level"]),
							  'koubo_used'	  => $row["koubo_used"],
							  'sakagura_id' => $row["id"], 
							  'sakagura_name' => $row["sakagura_name"], 
							  'pref'	  => $row["pref"],
							  'address'	  => $row["address"],
							  'username'  => $row["username"],
							  'sake_rank' => $avg_rank,
							  'write_date' => $intime);
		}

		header('Content-Type: application/json');
		$result_set[] = array('count' => $count_result, 'result' => $result, 'sql' => $sql);
		echo json_encode($result_set);
	}
}
else if($_POST["search_type"] == "2")
{
	/**************
	 * 酒蔵
	 **************/
	$disp_max = 25;
	$orderby = (isset($_POST["orderby"]) && ($_POST["orderby"] != "")) ? $_POST["orderby"] : "sakagura_read";

	$condition = "WHERE FOLLOW_J.sakagura_id = SAKAGURA_J.id";	
	
	if($username != "")
	{
        $condition .= " AND username LIKE \"%".$username."%\"";
	}

	if($pref != "")
	{
        $condition .= " AND pref LIKE \"%".$pref."%\"";
	}

    if(isset($_POST["write_date_from"]) && ($_POST["write_date_from"] != ""))
    {
        $write_date_from = $_POST["write_date_from"];

		if(isset($_POST["write_date_to"]) && ($_POST["write_date_to"] != ""))
		{
			$write_date_to = $_POST["write_date_to"];
			$condition .= " AND (favorite_date >='" .$write_date_from. "' AND favorite_date < '" .$write_date_to. "')";
		}
    }

	if($count_query == 1)
	{
		$sql = "SELECT COUNT(*) FROM FOLLOW_J, SAKAGURA_J " .$condition ." ORDER BY " .$orderby ." DESC LIMIT ".$from.", ".$disp_max;
		$res = executequery($db, $sql);
		$record = getnextrow($res); 
		$count_result = $record["COUNT(*)"];

		$sql = "SELECT * FROM FOLLOW_J, SAKAGURA_J " .$condition ." ORDER BY " .$orderby ." DESC LIMIT ".$from.", ".$disp_max;
		$res = executequery($db, $sql);
	}
	else
	{
		$sql = "SELECT * FROM FOLLOW_J, SAKAGURA_J " .$condition ." ORDER BY " .$orderby ." DESC LIMIT ".$from.", ".$disp_max;
		$res = executequery($db, $sql);
	}

	if(!$res)   
	{
		header('Content-Type: application/json');
		$result_set = array();
		echo json_encode($result_set);
	}
	else
	{
		$default_image = "images/icons/noimage160.svg";

		while($row = getnextrow($res))
		{
			$intime = gmdate("Y/m/d", $row["favorite_date"] + 9 * 3600);

			$result[] = array('sakagura_name' => $row["sakagura_name"], 
							  'sakagura_read' => $row["sakagura_read"], 
							  'sakagura_id' => $row["id"],
							  'pref' => $row["pref"],
							  'address' => $row["address"],
							  'brand' => $row["brand"],
						      'observation' => $row["observation"],
							  'direct_sale' => $row["direct_sale"],
							  'kumiai' => $row["kumiai"], 
							  'kokuzei' => $row["kokuzei"],
							  'status' => $row["status"], 
							  'priority' => $row["sakagura"],
							  'filename' => $default_image,
							  'rank' => $row["rank"],
							  'write_date' => $intime);
		}

		header('Content-Type: application/json');
		$result_set[] = array('count' => $count_result, 'result' => $result, 'sql' => $sql);
		echo json_encode($result_set);
	}
}
else if($_POST["search_type"] == "3")
{
	/**************
	 * 酒販店
	 **************/
	$condition = "WHERE syuhanten_name LIKE \"" .$sake_name. "%\" OR syuhanten_read LIKE \"" .$sake_name."%\"";
	$sql = "SELECT syuhanten_name as sake_name, syuhanten_read as sake_read, syuhanten_id as sake_id FROM SYUHANTEN_J " .$condition." ORDER BY syuhanten_read"." LIMIT 12";
	$res = executequery($db, $sql);

	if(!$res)   
	{
		//die('Error');

		header('Content-Type: application/json');
		$result = array();
		echo json_encode($result);
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
else
{
	$result = "unknown operation";
	$ret = "search_type:" + $_POST["search_type"];
	header('Content-Type: application/json');
	$result_set[] = array('count' => $count_result, 'result' => $result, 'sql' => 0);
	echo json_encode($result_set);
}
?>
