<?php
require_once("../db_functions.php");

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
	$syudo = "";

	if($jsake_level == null || $jsake_level == "")
		return $syudo;

	$syudo_array = explode(',', $jsake_level);

	if($syudo_array[0] != null && $syudo_array[1] != null) {
		if($syudo_array[0] == $syudo_array[1]) {
			$syudo .= number_format($syudo_array[0], 1);
		} else {
			$syudo .= number_format($syudo_array[0], 1).'～'.number_format($syudo_array[1], 1);
		}
	} else if($syudo_array[0] != null && $syudo_array[1] == null) {
		$syudo .= number_format($syudo_array[0], 1);
	} else {
		$syudo .= '<span style="color: #b2b2b2;">--<span>';
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
		$rice_value .= '<span style="color: #b2b2b2">--</span>';
	}

	return $rice_value;
}


//$username = $_COOKIE['login_cookie'];
$username = $_POST["username"];
$from = $_POST["from"];
$disp_max = (isset($_POST["disp_max"]) && ($_POST["disp_max"] != "")) ? $_POST["disp_max"] : 25;

$count_query = $_POST["count_query"];

if(!$db = opendatabase("../sake.db"))
{
	die("データベース接続エラー .<br />");
}


$orderby = $_POST["orderby"];
$sql = "SELECT USERS_J.username AS username, USERS_J.nickname AS nickname, USERS_J.email AS email, USERS_J.pref AS user_pref, bdate, sex, USERS_J.address AS address, certification, age_disclose, sex_disclose, address_disclose, certification_disclose, SAKAGURA_J.pref AS pref, contributor, update_date, TABLE_NONDA.sake_id as sake_id, sake_name, sakagura_name, TABLE_NONDA.write_date as write_date, TABLE_NONDA.rank as rank, subject, message, flavor, tastes, committed FROM TABLE_NONDA, SAKE_J, SAKAGURA_J, USERS_J WHERE TABLE_NONDA.sake_id = SAKE_J.sake_id AND SAKE_J.sakagura_id = SAKAGURA_J.id AND USERS_J.username = TABLE_NONDA.contributor AND (subject != '' OR message != '') ORDER BY UPDATE_DATE DESC LIMIT " .$from .", " .$disp_max;

$res = executequery($db, $sql);


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
		$sake_id = $row['sake_id'];
		$intime = gmdate("Y/m/d", $row["favorite_date"] + 9 * 3600);
        $username = $row["contributor"];
		$added_paths = "";
		$sql_image = "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$username'";
		$image_result = executequery($db, $sql_image);
		
		while($image_record = getnextrow($image_result)) {

			if($added_paths == "")
				$added_paths = $image_record["filename"];
			else
				$added_paths .= ", " .$image_record["filename"];
		}

		$sql2 = "SELECT AVG(rank) FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND rank != 0";
		$res_avg = executequery($db, $sql2);
		$rd_average = getnextrow($res_avg);

		$avg_rank = $rd_average["AVG(rank)"];
		$avg_percent = ($avg_rank / 5) * 100;

		$username = $row["username"];		
        $sql3 = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$username' AND status = 1";
        $res_profile = executequery($db, $sql3);
        $rd_profile = getnextrow($res_profile);
        $profile_image = "images/icons/noimage_user30.svg";

        if($rd_profile) {
			$profile_image = "images/profile/" .$rd_profile["filename"];
        }

		$result[] = array('username' => $row["username"], 
						'nickname' => $row["nickname"], 
						'email' => $row["email"], 
						'profile_image' => $profile_image,
						'user_pref' => $row["user_pref"], 
						'bdate' => $row["bdate"], 
						'sex' => $row["sex"], 
						'address' => $row["address"], 
						'certification' => $row["certification"], 
						'age_disclose' => $row["age_disclose"], 
						'sex_disclose' => $row["sex_disclose"], 
						'address_disclose' => $row["address_disclose"], 
						'certification_disclose' => $row["certification_disclose"], 
						'pref' => $row["pref"], 
						'contributor' => $row["contributor"], 
						'update_date' => gmdate("Y/m/d", $row["update_date"] + 9 * 3600), 
						'sake_id' => $row["sake_id"], 
						'sake_name' => $row["sake_name"], 
						'sakagura_name' => $row["sakagura_name"], 
						'write_date' => $row["write_date"], 
						'rank' => $row["rank"], 
						'subject' => $row["subject"], 
						'message' => $row["message"], 
						'flavor' => $row["flavor"], 
						'tastes' => $row["tastes"], 
						'path' => $added_paths,
						'sake_rank' => $avg_rank,
						'committed' => $row["committed"] 
				);
	}

	header('Content-Type: application/json');
	$result_set[] = array('count' => $count_result, 'result' => $result, 'sql' => $sql);
	echo json_encode($result_set);
}

?>
