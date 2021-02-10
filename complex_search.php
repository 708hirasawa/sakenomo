<?php

require_once("db_functions.php");
header('Content-type: text/html; charset=UTF-8');

function GetSakeSpecialName($special_name)
{
	$sake_code = explode(',', $special_name);

	if($sake_code[0] == "11")
	{
		$retval = "普通酒";
		return $retval;
	}
	else if($sake_code[0] == "21")
	{
		$retval = "本醸造酒";
		return $retval;
	}
	else if($sake_code[0] == "22")
	{
		$retval = "特別本醸造酒";
		return $retval;
	}
	else if($sake_code[0] == "31")
	{
		$retval = "純米酒";
		return $retval;
	}
	else if($sake_code[0] == "32")
	{
		$retval = "特別純米酒";
		return $retval;
	}
	else if($sake_code[0] == "33")
	{
		$retval = "純米吟醸酒";
		return $retval;
	}
	else if($sake_code[0] == "34")
	{
		$retval = "純米大吟醸酒";
		return $retval;
	}
	else if($sake_code[0] == "43")
	{
		$retval = "吟醸酒";
		return $retval;
	}
	else if($sake_code[0] == "44")
	{
		$retval = "大吟醸酒";
		return $retval;
	}
	else if($sake_code[0] == "45")
	{
		$retval = "非公開";
		return $retval;
	}
	else if($sake_code[0] == "90")
	{
		if(count($sake_code) > 1) 
		{
			$retval = $sake_code[1];
			return $retval;
		}
		else 
		{
			$retval = "その他";
			return $retval;
		}
	}
	else
	{
		$retval = "";
		return $retval;
	}
}

function GetSakeCategory($category_code)
{
	if($category_code == "11")
	{ 
		$retval = "無ろ過";
		return $retval;
	}
	else if($category_code == "21")
	{
		$retval = "にごり酒";
		return $retval;
	}
	else if($category_code == "22")
	{
		$retval = "あらばしり";
		return $retval;
	}
	else if($category_code == "31")
	{
		$retval = "中取り/中垂/中汲み";
		return $retval;
	}
	else if($category_code == "32")
	{
		$retval = "責め・押切";
		return $retval;
	}
	else if($category_code == "33")
	{
		$retval = "生酒・本生";
		return $retval;
	}
	else if($category_code == "34")
	{
		$retval = "生詰酒";
		return $retval;
	}
	else if($category_code == "35")
	{
		$retval = "生貯蔵酒";
		return $retval;
	}
	else if($category_code == "36")
	{
		$retval = "火入れ";
		return $retval;
	}
	else if($category_code == "37")
	{
		$retval = "ひやおろし・秋上がり";
		return $retval;
	}
	else if($category_code == "38")
	{
		$retval = "しずく酒・しずくしぼり・袋吊り・袋しぼり・斗瓶取り・斗瓶囲い";
		return $retval;
	}
	else if($category_code == "39")
	{
		$retval = "直汲み・直詰め";
		return $retval;
	}
	else if($category_code == "40")
	{
		$retval = "遠心分離";
		return $retval;
	}
	else if($category_code == "41")
	{
		$retval = "槽しぼり";
		return $retval;
	}
	else if($category_code == "42")
	{
		$retval = "きもと";
		return $retval;
	}
	else if($category_code == "43")
	{
		$retval = "山廃もと";
		return $retval;
	}
	else if($category_code == "44")
	{
		$retval = "樽酒";
		return $retval;
	}
	else if($category_code == "45")
	{
		$retval = "原酒";
		return $retval;
	}
	else if($category_code == "46")
	{
		$retval = "生一本";
		return $retval;
	}
	else if($category_code == "47")
	{
		$retval = "斗瓶取り・斗瓶囲い";
		return $retval;
	}
	else if($category_code == "48")
	{
		$retval = "古酒・長期貯蔵酒";
		return $retval;
	}
	else if($category_code == "49")
	{
		$retval = "おり酒・おりがらみ・うすにごり・ささにごり";
		return $retval;
	}
	else if($category_code == "50")
	{
		$retval = "新酒・初しぼり・しぼりたて";
		return $retval;
	}
	else if($category_code == "51")
	{
		$retval = "スパークリング";
		return $retval;
	}
	else if($category_code == "90")
	{
		$retval = "その他";
		return $retval;
	}
	else
	{
		$retval = "";
		return $retval;
	}
}

if(isset($_POST["search_text"]) && $_POST["search_text"] == "")
{
	die("入力エラー .<br />");
}

$username = $_COOKIE['login_cookie'];
$condition = "";

if($_POST["category"] == 1)
{
	if(!$db = opendatabase("sake.db"))
	{
		$result1 = 0;
		$count_result = 0;

		$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);

		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}

	$from = $_POST["from"];
	$to = 25;
	$count_result = 0;

	if(isset($_POST["keyword"]) && ($_POST["keyword"] != ""))
	{
		$keyword = $_POST["keyword"];
			
		$keyword = str_replace("　", " ", $keyword);

		$keyword_elements = explode(' ', $keyword);
		$condition1 = "";

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

				$condition1 = 'WHERE (' .$expression .')';
		}
		else
		{
				$condition1 = 'WHERE (sake_name LIKE "%' .$keyword .'%" OR sake_read LIKE "%' .$keyword. '%" OR sake_search LIKE "%' .$keyword. '%" OR sake_english LIKE "%' .$keyword .'%" OR sake_id LIKE "%' .$keyword .'%")';
		}

		$condition2 = "WHERE (sakagura_name LIKE \"%" .$keyword. "%\" OR sakagura_read LIKE \"%" .$keyword."%\" OR sakagura_search LIKE \"%" .$keyword."%\") ";
		$condition3 = "WHERE (syuhanten_name LIKE \"%" .$keyword. "%\" OR syuhanten_read LIKE \"%" .$keyword."%\") ";
	}

	if($condition1 == "")
	{
		$condition1 = "WHERE sakagura_id = id";
	} 
	else
	{
		$condition1 .= "AND sakagura_id = id";
	}

	if($_POST["count_query"] == "1")
	{
		$sql = "SELECT COUNT(*) FROM SAKE_J, SAKAGURA_J ".$condition1;
		$res = executequery($db, $sql);
		$row = getnextrow($res);
		$count_result1 = $row["COUNT(*)"];

		$sql = "SELECT COUNT(*) FROM SAKAGURA_J ".$condition2;
		$res = executequery($db, $sql);
		$row = getnextrow($res);
		$count_result2 = $row["COUNT(*)"];

		//$sql = "SELECT COUNT(*) FROM SYUHANTEN_J ".$condition3;
		//$res = executequery($db, $sql);
		//$row = getnextrow($res);
		//$count_result3 = $row["COUNT(*)"];

		$count_result = $count_result1 + $count_result2; // + $count_result3;
	}

	$sql  = 'SELECT			SAKE_J.sake_id AS id, sake_name, SAKE_J.sake_rank AS rank, SAKE_J.write_update AS write_date, sakagura_name, special_name, sake_category, alcohol_level, jsake_level, rice_used, seimai_rate, postal_code, pref, address, SAKE_J.sake_id as observation, SAKE_J.sake_id as direct_sale, SAKE_J.sake_id as brand ';
	$sql .=	' FROM			SAKE_J, SAKAGURA_J ' .$condition1;
	$sql .= ' UNION ';
	$sql .= ' SELECT		SAKAGURA_J.id AS id, SAKAGURA_J.sakagura_name, SAKAGURA_J.rank AS rank, SAKAGURA_J.date_updated AS write_date, null, null, null, null, null, null, null, postal_code, pref, address, observation, direct_sale, brand '; 
	$sql .= ' FROM			SAKAGURA_J ' .$condition2;
	//$sql .= ' UNION ';
	//$sql .= ' SELECT		SYUHANTEN_J.syuhanten_id AS id, SYUHANTEN_J.syuhanten_name, SYUHANTEN_J.syuhanten_rank AS rank, SYUHANTEN_J.date_added AS write_date, null, null, null, null, null, null, null, syuhanten_postal_code AS postal_code, syuhanten_pref, syuhanten_address AS address, null, null, null ';
	//$sql .= ' FROM			SYUHANTEN_J ' .$condition3;
	$sql .= ' LIMIT	'	   .$from .', ' .$to;

	$res = executequery($db, $sql);

	if(!$res)   
	{
		$result1 = 0;
		$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}
	else
	{			
		while($row = getnextrow($res))
		{
			$default_image = "images/icons/noimage160.svg";
			$special_name = GetSakeSpecialName($row["special_name"]);
			$sake_category = "";

			if($row["sake_category"] != "" && $row["sake_category"] != undefined)
			{
				$sake_category_array = explode(',', $row["sake_category"]);

				for($i = 0; $i < count($sake_category_array) && $sake_category_array[$i] != 0; $i++)
				{
					$retval = GetSakeCategory($sake_category_array[$i]);

					if($retval != "")
						$sake_category .= $retval;
				}
			}

			$sql2 = "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$row["id"] ."' LIMIT 1";
			$result_set = executequery($db, $sql2);
 
			if($record = getnextrow($result_set))
			{
				$default_image = "images/photo/thumb/".$record["filename"];
			}

			$intime = gmdate("Y/m/d", $row["write_date"] + 9 * 3600);
			$rice_text = $row["rice_used"];

			if($row["rice_used"] && $row["rice_used"] != "")
			{
				$rice_text = "";
				$rice_array = explode('/', $row["rice_used"]);

				for($i = 0; $i < count($rice_array); $i++)
				{
					$rice_entry = explode(',', $rice_array[$i]);
		
					$sql3 = "SELECT SAKE_RICE.rice_name, SAKE_RICE.rice_kanji, SAKE_RICE.rice_kana FROM SAKE_RICE WHERE SAKE_RICE.rice_name = '$rice_entry[0]'";
					$sake_result = executequery($db, $sql3);


					$rd = getnextrow($sake_result);
					$rice_text .= "<span>";

					if(count($rice_entry) > 1) 
					{
						if($rice_entry[1] == "1")
						{
							$rice_text .= "麹米:";
						}
						else if($rice_entry[1] == "2")
						{
							$rice_text .= "掛米:";
						}
					}

					if($rice_entry[0] != "")
					{
						$rice_kanji = $rd ? $rd["rice_kanji"] : $rice_entry[0];
						$rice_text .= $rice_kanji;
					}

					$rice_text .= "</span>";

					if($i < (count($rice_array) - 1))
						$rice_text .= " / ";
				}
			}

			$sake_id = $row["id"];
			$avg_rank = $row["rank"];

			if(!strncmp($sake_id, "A", 1)) {
				$sql4 = "SELECT AVG(rank) FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND (rank != 0 AND rank != '')";
				$res_avg = executequery($db, $sql4);
				$rd_average = getnextrow($res_avg);
				$avg_rank = $rd_average["AVG(rank)"];
			}

			$result1[] = array('id' => $row["id"], 
								'filename' => $default_image, 
								'sake_name' => stripslashes($row["sake_name"]), 
								'rank' => $avg_rank, 
								'sakagura_name' => $row["sakagura_name"], 
								'special_name' => $special_name, 
								'sake_category' => $sake_category, 
								'alcohol_level' => $row["alcohol_level"], 
								'jsake_level' => $row["jsake_level"], 
								'seimai_rate' => $row["seimai_rate"], 
								'rice_used' => $row["rice_used"], // $rice_text, 
								'postal_code' => $row["postal_code"], 
								'pref' => $row["pref"], 
								'address' => $row["address"], 
								'observation' => $row["observation"], 
								'direct_sale' => $row["direct_sale"], 
								'brand' => $row["brand"], 
								'write_date' => $intime);
		}
	}

	$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
}
else if($_POST["category"] == 2)
{
	$condition = "";
	$db = opendatabase("sake.db");

	if(!$db) {
		$result1 = 0;
		$count_result = 0;

		$result[] = array('result' => $result1, 'sql' => $condition, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}

	function patternMatch($string, $seimai_rate1, $seimai_rate2)
	{
		if($string != "" && $string != null) 
		{
			$seimai_array = explode(',', $string);

			for($i = 0; $i < count($seimai_array); $i++) 
			{
				if(intval($seimai_array[$i]) >= $seimai_rate1 && intval($seimai_array[$i]) < $seimai_rate2) 
				{
					return 1;
				}
			}
		}

		return 0;
		//return 1;
	}

	$db->createFunction('patternMatch', 'patternMatch', 3);		

	if(isset($_POST["keyword"]) && ($_POST["keyword"] != "")) {

		$keyword = $_POST["keyword"];
		$keyword = str_replace("　", " ", $keyword);
		$keyword_elements = explode(' ', $keyword);
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
			$condition = 'WHERE (sake_name LIKE "%' .$keyword .'%" OR sake_read LIKE "%' .$keyword. '%" OR sake_search LIKE "%' .$keyword. '%" OR sake_english LIKE "%' .$keyword .'%" OR sake_id LIKE "%' .$keyword .'%")';
		}
	}

    if(isset($_POST["sake_id"]) && ($_POST["sake_id"] != ""))
    {
        $sake_id = $_POST["sake_id"];

		if($condition == "")
		{
			$condition = "WHERE sake_id ='" .$sake_id. "'";
		}
		else
		{
			$condition .= " AND sake_id ='" .$sake_id. "'";
		}
    }

    if(isset($_POST["write_date_from"]) && ($_POST["write_date_from"] != ""))
    {
		// "&write_date_from=" + date1 + 
		// "&write_date_to="   + date2 + 

        $write_date_from = $_POST["write_date_from"];

		if(isset($_POST["write_date_to"]) && ($_POST["write_date_to"] != ""))
		{
			$write_date_to = $_POST["write_date_to"];

			if($condition == "")
			{
				$condition = "WHERE (write_update >='" .$write_date_from. "' AND write_update < '" .$write_date_to. "')";
			}
			else
			{
				$condition .= " AND (write_update >='" .$write_date_from. "' AND write_update < '" .$write_date_to. "')";
			}
		}
    }

    if(isset($_POST["write_update"]) && ($_POST["write_update"] != ""))
    {
        $write_update = $_POST["write_update"];

		if($condition == "")
		{
			$condition = "WHERE write_update >='" .$write_update. "'";
		}
		else
		{
			$condition .= " AND write_update >='" .$write_update. "'";
		}
    }

	if(is_array($_POST['pref'])) 
	{
		if(!empty($_POST['pref']))
		{
			$expr = "";

			foreach($_POST['pref'] as $selected)
			{
				if($expr == "")
				{
					$expr = "pref LIKE \"%".$selected."%\"";
				}
				else
				{
					$expr .= " OR pref LIKE \"%".$selected."%\"";
				}
			}	

			//$condition = "WHERE (" .$expr ." ) ";

			if($condition == "")
			{
				$condition = "WHERE (" .$expr ." ) ";
			}
			else
			{
				$condition .= " AND (" .$expr ." ) ";
			}
		}
	}
	else
	{
		if(isset($_POST["pref"]) && ($_POST["pref"] != ""))
		{
			$pref = $_POST["pref"];

			if($condition == "")
			{
				$condition = "WHERE pref ='" .$pref. "'";
			}
			else
			{
				$condition .= " AND pref ='" .$pref. "'";
			}
		}
	}

	if(is_array($_POST['special_name'])) 
	{
		if(!empty($_POST['special_name']))
		{
			$expr = "";

			foreach($_POST['special_name'] as $selected)
			{
				if($expr == "")
				{
					$expr = "special_name LIKE \"%".$selected."%\"";
				}
				else
				{
					$expr .= " OR special_name LIKE \"%".$selected."%\"";
				}
			}	

			if($condition == "")
			{
				$condition = "WHERE (" .$expr ." ) ";
			}
			else
			{
				$condition .= " AND (" .$expr ." ) ";
			}
		}
	}
	else
	{
		if(isset($_POST["special_name"]) && ($_POST["special_name"] != ""))
		{
			$special_name = $_POST["special_name"];

			if($condition == "")
			{
				$condition = "WHERE special_name like '%" .$special_name. "%'";
			}
			else
			{
				$condition .= " AND special_name like '%" .$special_name. "%'";
			}
		}
	}

	if(isset($_POST["rice_used"]) && ($_POST["rice_used"] != ""))
	{
		$rice_used = $_POST["rice_used"];

		if($condition == "")
		{
			$condition = "WHERE rice_used LIKE \"%" .$rice_used. "%\"";
		}
		else
		{
			$condition .= " AND rice_used LIKE \"%" .$rice_used ."%\"";
		}
	}

	if(is_array($_POST['seimai_rate'])) 
	{
		if(!empty($_POST['seimai_rate']))
		{
			$expr = "";

			foreach($_POST['seimai_rate'] as $selected)
			{
				if($expr == "")
				{
					$expr = 'seimai_rate LIKE "%'.$selected.'%"';
				}
				else
				{
					$expr .= ' OR seimai_rate LIKE "%'.$selected.'%"';
				}
			}	

			if($condition == "")
			{
				$condition = "WHERE (" .$expr ." ) ";
			}
			else
			{
				$condition .= " AND (" .$expr ." ) ";
			}
		}
	}
	else
	{
		if(isset($_POST["seimai_rate"]) && ($_POST["seimai_rate"] != ""))
		{
			$seimai_rate = $_POST["seimai_rate"];

			if($seimai_rate == "10") {
				$seimai_rate1 = 1;
				$seimai_rate2 = 20;
			}
			else if($seimai_rate == "20") {
				$seimai_rate1 = 20;
				$seimai_rate2 = 30;
			}
			else if($seimai_rate == "30") {
				$seimai_rate1 = 30;
				$seimai_rate2 = 40;
			}
			else if($seimai_rate == "40") {
				$seimai_rate1 = 40;
				$seimai_rate2 = 50;
			}
			else if($seimai_rate == "50") {
				$seimai_rate1 = 50;
				$seimai_rate2 = 60;
			}
			else if($seimai_rate == "60") {
				$seimai_rate1 = 60;
				$seimai_rate2 = 70;
			}
			else if($seimai_rate == "70") {
				$seimai_rate1 = 70;
				$seimai_rate2 = 100;
			}
	
			if($condition == "")
			{
				$condition = "WHERE patternMatch(seimai_rate, " .$seimai_rate1 .", " .$seimai_rate2 .")";
			}
			else
			{
				$condition .= " AND patternMatch(seimai_rate, " .$seimai_rate1 .", " .$seimai_rate2 .")";
			}
		}
	}
	
	if(!empty($_POST['sake_category']))
	{
		$expr = "";

		foreach($_POST['sake_category'] as $selected)
		{
			if($expr == "")
			{
				$expr = "sake_category LIKE \"%".$selected."%\"";
			}
			else
			{
				$expr .= " AND sake_category LIKE \"%".$selected."%\"";
			}
		}	

		if($condition == "")
		{
			$condition = "WHERE (" .$expr ." ) ";
		}
		else
		{
			$condition .= " AND (" .$expr ." ) ";
		}
	}

	if(!empty($_POST['jsake_level']))
	{
		$expr = "";

		foreach($_POST['jsake_level'] as $selected)
		{
			if($expr == "")
			{
				$expr = "jsake_level LIKE \"%".$selected."%\"";
			}
			else
			{
				$expr .= " OR jsake_level LIKE \"%".$selected."%\"";
			}
		}	

		if($condition == "")
		{
			$condition = "WHERE (" .$expr ." ) ";
		}
		else
		{
			$condition .= " AND (" .$expr ." ) ";
		}
	}

	if(!empty($_POST['sake_rank']))
	{
		$expr = "";

		foreach($_POST['sake_rank'] as $selected)
		{
			if($expr == "")
			{
				$expr = "sake_rank LIKE \"%".$selected."%\"";
			}
			else
			{
				$expr .= " OR sake_rank LIKE \"%".$selected."%\"";
			}
		}	

		if($condition == "")
		{
			$condition = "WHERE (" .$expr ." ) ";
		}
		else
		{
			$condition .= " AND (" .$expr ." ) ";
		}
	}

	if(!empty($_POST['sake_award_history']))
	{
		$expr = "";

		foreach($_POST['sake_award_history'] as $selected)
		{
			if($expr == "")
			{
				$expr = "sake_award_history LIKE \"%".$selected."%\"";
			}
			else
			{
				$expr .= " OR sake_award_history LIKE \"%".$selected."%\"";
			}
		}	

		if($condition == "")
		{
			$condition = "WHERE (" .$expr ." ) ";
		}
		else
		{
			$condition .= " AND (" .$expr ." ) ";
		}
	}

	if(!empty($_POST['oxidation_level']))
	{
		$expr = "";

		foreach($_POST['oxidation_level'] as $selected)
		{
			if($expr == "")
			{
				$expr = "oxidation_level LIKE \"%".$selected."%\"";
			}
			else
			{
				$expr .= " OR oxidation_level LIKE \"%".$selected."%\"";
			}
		}	

		if($condition == "")
		{
			$condition = "WHERE (" .$expr ." ) ";
		}
		else
		{
			$condition .= " AND (" .$expr ." ) ";
		}
	}

    if(isset($_POST["sakagura_id"]) && ($_POST["sakagura_id"] != ""))
    {
        $sakagura_id = $_POST["sakagura_id"];

		if($condition == "")
		{
			$condition = "WHERE id ='" .$sakagura_id. "'";
		}
		else
		{
			$condition .= " AND id ='" .$sakagura_id. "'";
		}
    }

	if($condition == "")
	{
		$condition = "WHERE sakagura_id = id";
	} 
	else
	{
		$condition .= " AND sakagura_id = id";
	}

	$orderby = "";

    if($_POST["orderby"] != undefined && $_POST["orderby"] != "")
	{
		$desc = "DESC";

		if($_POST["desc"] != undefined && $_POST["desc"] != "") {
			$desc = $_POST["desc"];
		}

		$orderby = $_POST["orderby"] ." " .$desc;
	}


	// query count 
	$count_result = 0;

	if($_POST["count_query"] == "1")
	{
		$sql = "SELECT COUNT(*) FROM SAKE_J, SAKAGURA_J ".$condition;
		$res = executequery($db, $sql);
		$record = getnextrow($res); 
		$count_result = $record["COUNT(*)"];
	}

	// query 
	$from = ($_POST["from"] != undefined && $_POST["from"]) ? $_POST["from"] : 0; 
	//$to = ($_POST["to"] != undefined && $_POST["to"]) ? $_POST["to"] : 25; 
	$to = 25; 

	if($orderby != "")
		$sql = "SELECT * FROM SAKE_J, SAKAGURA_J ".$condition ." ORDER BY " .$orderby ." LIMIT ".$from.", ".$to;
	else	
		$sql = "SELECT * FROM SAKE_J, SAKAGURA_J ".$condition ." LIMIT ".$from.", ".$to;

	$res = executequery($db, $sql);
	$sql1 = $sql;

	if(!$res)   
	{
		$result1 = 0;
		$count_result = 0;

		$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}
	else
	{
		while($row = getnextrow($res))
		{
			$sake_category_array = explode(',', $row["sake_category"]);
			$special_name = GetSakeSpecialName($row["special_name"]);
			$sake_category = "";

			for($i = 0; $i < count($sake_category_array); $i++)
			{
				$retval = GetSakeCategory($sake_category_array[$i]);

				if($retval != "")
					$sake_category .= $retval;
			}
			
			$intime = gmdate("Y/m/d", $row["write_update"] + 9 * 3600);
			$sake_id = $row["sake_id"];
			//$result_set = executequery($db, "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$row["sake_id"] ."' LIMIT 8");
			$result_set = executequery($db, "SELECT DISTINCT FILENAME, TABLE_NONDA.update_date FROM TABLE_NONDA, SAKE_IMAGE WHERE TABLE_NONDA.sake_id = '$sake_id' AND TABLE_NONDA.sake_id = SAKE_IMAGE.sake_id AND TABLE_NONDA.contributor = SAKE_IMAGE.contributor ORDER BY TABLE_NONDA.update_date DESC limit 2");

			if($rd = getnextrow($result_set))
			{
				$sake_id = $row["sake_id"];
				$sql = "SELECT AVG(rank) FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND (rank != 0 AND rank != '')";
				$res_avg = executequery($db, $sql);
				$rd_average = getnextrow($res_avg);
				$avg_rank = $rd_average["AVG(rank)"];

				/*
				$rice_array = explode('/', $rd["rice_used"]);
				$rice_used = "";

				for($i = 0; $i < count($rice_array); $i++)
				{
					$rice_entry = explode(',', $rice_array[$i]);

					$sql = "SELECT SAKE_RICE.rice_name, SAKE_RICE.rice_kanji, SAKE_RICE.rice_kana FROM SAKE_RICE WHERE SAKE_RICE.rice_name = '$rice_entry[0]'";
					$sake_result = executequery($db, $sql);

					$record = getnextrow($sake_result);

					if($rice_entry[1] == "1") {
						rice_used .= "麹米:";
					}
					else if($rice_entry[1] == "2") {
						rice_used .= "掛米:";
					}

					if($rice_entry[0] != ""){
						$rice_kanji = $record ? $record["rice_kanji"] : $rice_used;
						rice_used .= $rice_kanji;
					}

					if($i < (count($rice_array) - 1))
						rice_used .= " / ";
				}
				*/

				$imagefile = "images/photo/thumb/" .$rd["filename"];
				$result1[] = array('sake_name' => stripslashes($row["sake_name"]), 
									'sake_read' => $row["sake_read"], 
									'sake_english' => $row["sake_english"], 
									'sake_search' => $row["sake_search"], 
									'special_name' => $special_name, 
									'special_name_code' => $row["special_name"], 
									'sake_id' => $row["sake_id"], 
									'sakagura_name' => $row["sakagura_name"], 
									'sakagura_id' => $row["id"], 
									'alcohol_level' => $row["alcohol_level"], 
									'jsake_level' => $row["jsake_level"], 
									'oxidation_level' => $row["oxidation_level"], 
									'amino_level' => $row["amino_level"], 
									'rice_used' => $row["rice_used"],
									'seimai_rate' => $row["seimai_rate"], 
									'sake_category' => $sake_category, 
									'sake_category_code' => $row["sake_category"], 
									'koubo_used' => $row["koubo_used"], 
									'year_made' => $row["year_made"], 
									'sake_award_history' => $row["sake_award_history"], 
									'recommended_drink' => $row["recommended_drink"], 
									'filename' => $imagefile, 
									'sake_rank' => $avg_rank, 
									'pref' => $row["pref"], 
									'address' => $row["address"], 
									'phone' => $row["phone"], 
									'ingredients' => $row["ingredients"], 
									'jas' => $row["jas"], 
									'url' => $row["url"], 
									'write_date' => $intime);
			}
			else
			{
				$default_image = "images/icons/noimage160.svg";

				$result1[] = array('sake_name' => stripslashes($row["sake_name"]), 
									'sake_read' => $row["sake_read"], 
									'sake_english' => $row["sake_english"], 
									'sake_search' => $row["sake_search"], 
									'special_name' => $special_name, 
									'special_name_code' => $row["special_name"], 
									'sake_id' => $row["sake_id"], 
									'sake_rank' => $row["sake_rank"], 
									'sakagura_name' => $row["sakagura_name"], 
									'sakagura_id' => $row["id"], 
									'alcohol_level' => $row["alcohol_level"], 
									'jsake_level' => $row["jsake_level"], 
									'oxidation_level' => $row["oxidation_level"], 
									'amino_level' => $row["amino_level"], 
									'rice_used' => $row["rice_used"],
									'seimai_rate' => $row["seimai_rate"], 
									'sake_category' => $sake_category, 
									'sake_category_code' => $row["sake_category"], 
									'koubo_used' => $row["koubo_used"], 
									'year_made' => $row["year_made"], 
									'sake_award_history' => $row["sake_award_history"], 
									'recommended_drink' => $row["recommended_drink"], 
									'pref' => $row["pref"], 
									'address' => $row["address"], 
									'phone' => $row["phone"], 
									'ingredients' => $row["ingredients"], 
									'jas' => $row["jas"], 
									'url' => $row["url"], 
									'filename' => $default_image, 
									'write_date' => $intime);
			}
		}
	}

	$result[] = array('result' => $result1, 'sql' => $sql1, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
}
else if($_POST["category"] == 3)
{
	/**************
	 * 酒蔵
	 **************/

    if(isset($_POST["keyword"]) && ($_POST["keyword"] != ""))
    {
        $keyword = $_POST["keyword"];
        
        if($condition == "")
        {
			$condition = 'WHERE (sakagura_name LIKE "%' .$keyword. '%" OR sakagura_read LIKE "%' .$keyword .'%" OR sakagura_search LIKE "%' .$keyword .'%")';
        } 
        else
        {
			$condition .= 'AND (sakagura_name LIKE "%' .$keyword. '%" OR sakagura_read LIKE "%' .$keyword .'%" OR sakagura_search LIKE "%' .$keyword .'%")';
        }
    }

    if(isset($_POST["sakagura_id"]) && ($_POST["sakagura_id"] != ""))
    {
        $sakagura_id = $_POST["sakagura_id"];

		if($condition == "")
		{
			$condition = "WHERE id ='" .$sakagura_id. "'";
		}
		else
		{
			$condition .= " AND id ='" .$sakagura_id. "'";
		}
    }
	
    if(isset($_POST["pref"]) && ($_POST["pref"] != ""))
    {
        $sakagura_pref = $_POST["pref"];

		if($condition == "")
		{
			$condition = "WHERE pref ='" .$sakagura_pref. "'";
		}
		else
		{
			$condition .= " AND pref ='" .$sakagura_pref. "'";
		}
    }

    if(isset($_POST["observation"]) && ($_POST["observation"] != ""))
    {
        $observation = $_POST["observation"];

		if($condition == "")
		{
			$condition = "WHERE observation LIKE \"%".$observation."%\" ";
		}
		else
		{
			$condition .= " AND observation LIKE \"%".$observation."%\"";
		}
    }

    if(isset($_POST["write_date_from"]) && ($_POST["write_date_from"] != ""))
    {
        $write_date_from = $_POST["write_date_from"];

		if(isset($_POST["write_date_to"]) && ($_POST["write_date_to"] != ""))
		{
			$write_date_to = $_POST["write_date_to"];

			if($condition == "")
			{
				$condition = "WHERE (date_updated >='" .$write_date_from. "' AND date_updated < '" .$write_date_to. "')";
			}
			else
			{
				$condition .= " AND (date_updated >='" .$write_date_from. "' AND date_updated < '" .$write_date_to. "')";
			}
		}
    }

    if(isset($_POST["kumiai"]) && ($_POST["kumiai"] != ""))
    {
        $kumiai = $_POST["kumiai"];

		if($condition == "")
		{
			$condition = "WHERE kumiai LIKE \"%".$kumiai."%\" ";
		}
		else
		{
			$condition .= " AND kumiai LIKE \"%".$kumiai."%\"";
		}
    }
    
    if(isset($_POST["kokuzei"]) && ($_POST["kokuzei"] != ""))
    {
        $kokuzei = $_POST["kokuzei"];

		if($condition == "")
		{
			$condition = "WHERE kokuzei LIKE \"%".$kokuzei."%\" ";
		}
		else
		{
			$condition .= " AND kokuzei LIKE \"%".$kokuzei."%\"";
		}
    }
    
    if(isset($_POST["status"]) && ($_POST["status"] != ""))
    {
        $status = $_POST["status"];

		if($condition == "")
		{
			$condition = "WHERE status LIKE \"%".$status."%\" ";
		}
		else
		{
			$condition .= " AND status LIKE \"%".$status."%\"";
		}
    }	

    if(isset($_POST["priority"]) && ($_POST["priority"] != ""))
    {
        $priority = $_POST["priority"];

		if($condition == "")
		{
			$condition = "WHERE sakagura LIKE \"%".$priority."%\" ";
		}
		else
		{
			$condition .= " AND sakagura LIKE \"%".$priority."%\"";
		}
    }	

	if(!$db = opendatabase("sake.db"))
	{
		$result1 = 0;
		$count_result = 0;

		$result[] = array('result' => $result1, 'sql' => $condition, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}

	$count_result = 0;


	if($_POST["count_query"] == "1")
	{
		$sql = "SELECT COUNT(*) FROM SAKAGURA_J ".$condition." ORDER BY sakagura_read";

		$res = executequery($db, $sql);
		$record = getnextrow($res); 
		$count_result = $record["COUNT(*)"];
	}

	$from = $_POST["from"];
	//$to = $_POST["to"];
	$to = 25;
	
	$sql = "SELECT sakagura_name, sakagura_read, sakagura_english, id, establishment, sakagura, pref, address, email, touji, representative, postal_code, phone, url, award_history, observation, observatory_info, direct_sale, brand, status, date_updated, kumiai, kokuzei FROM SAKAGURA_J " .$condition." ORDER BY sakagura_read"." LIMIT ".$from.", ".$to;

	$res = executequery($db, $sql);

	if(!$res)   
	{
		$result1 = 0;
		$count_result = 0;

		$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}
	else
	{
		while($row = getnextrow($res))
		{
			$default_image = "images/icons/noimage160.svg";
			$intime = gmdate("Y/m/d", $row["date_updated"] + 9 * 3600);
			$result2[] = array('sakagura_name' => $row["sakagura_name"], 
								'sakagura_read' => $row["sakagura_read"], 
								'sakagura_english' => $row["sakagura_english"], 
								'id' => $row["id"], 
								'pref' => $row["pref"], 
								'postal_code' => $row["postal_code"], 
								'address' => $row["address"], 
								'phone' => $row["phone"], 
								'fax' => $row["fax"], 
								'url' => $row["url"], 
								'email' => $row["email"], 
								'establishment' => $row["establishment"], 
								'representative' => $row["representative"], 
								'touji' => $row["touji"], 
								'award_history' => $row["award_history"],
								'observation' => $row["observation"],
								'observatory_info' => $row["observatory_info"],
								'direct_sale' => $row["direct_sale"], 
								'brand' => $row["brand"], 
								'kumiai' => $row["kumiai"], 
								'kokuzei' => $row["kokuzei"], 
								'status' => $row["status"], 
								'priority' => $row["sakagura"], 
								'write_date' => $intime, 
								'filename' => $default_image);
		}
	}

	$result[] = array('result' => $result2, 'sql' => $sql, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
}
else if($_POST["category"] == 4)
{
	/**************
	 * 酒販店
	 **************/

    if(isset($_POST["keyword"]) && ($_POST["keyword"] != ""))
    {
        $keyword = $_POST["keyword"];
        
        if($condition == "")
        {
			$condition = 'WHERE (syuhanten_name LIKE "' .$keyword .'%" OR syuhanten_read LIKE "' .$keyword .'%")';
        } 
        else
        {
			$condition .= 'AND (syuhanten_name LIKE "' .$keyword .'%" OR syuhanten_read LIKE "' .$keyword .'%")';
        }
    }

	if(!empty($_POST['syuhanten_pref']))
	{
		$expr = "";

		foreach($_POST['syuhanten_pref'] as $selected)
		{
			if($expr == "")
			{
				$expr = "syuhanten_pref LIKE \"%".$selected."%\"";
			}
			else
			{
				$expr .= " OR syuhanten_pref LIKE \"%".$selected."%\"";
			}
		}	

		if($condition == "")
		{
			$condition = "WHERE (" .$expr ." ) ";
		}
		else
		{
			$condition .= " AND (" .$expr ." ) ";
		}
	}

	if(!$db = opendatabase("sake.db"))
	{
		$result1 = 0;
		$count_result = 0;

		$result[] = array('result' => $result1, 'sql' => $condition, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}

	/* query */
	$count_result = 0;

	if($_POST["count_query"] == "1")
	{
		$sql = "SELECT COUNT(*) FROM SYUHANTEN_J ".$condition." ORDER BY syuhanten_read";
		$res = executequery($db, $sql);
		$record = getnextrow($res); 
		$count_result = $record["COUNT(*)"];
	}

	$from = $_POST["from"];
	//$in_disp_to = $_POST["to"];
	$to = 25;

	$sql = "SELECT syuhanten_name as sake_name, syuhanten_read as sake_read, syuhanten_id as sake_id, syuhanten_phone, syuhanten_postal_code, syuhanten_pref, syuhanten_address, syuhanten_url FROM SYUHANTEN_J " .$condition." ORDER BY syuhanten_read"." LIMIT ".$from.", ".$to;
	$res = executequery($db, $sql);

	if(!$res)   
	{
		$result1 = 0;
		$count_result = 0;

		$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}
	else
	{
		$default_image = "images/icons/camera20.svg";

		while($row = getnextrow($res))
		{
			$result3[] = array('sake_name' => $row["sake_name"], 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"], 'syuhanten_phone' => $row["syuhanten_phone"], 'syuhanten_pref' => $row["syuhanten_pref"], 'syuhanten_postal_code' => $row["syuhanten_postal_code"], 'syuhanten_address' => $row["syuhanten_address"], 'syuhanten_url' => $row["syuhanten_url"], 'filename' => $default_image);
		}
	}

	$result[] = array('result' => $result3, 'sql' => $sql, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
}
else if($_POST["category"] == 5)
{
	/**************
	 * ユーザー
	 **************/

    if(isset($_POST["username"]) && ($_POST["username"] != ""))
    {
        $username = $_POST["username"];
        
        if($condition == "")
        {
			$condition = 'WHERE (username LIKE "' .$username .'%")';
        } 
        else
        {
			$condition .= 'AND (user_name LIKE "' .$username .'%")';
        }
    }

	if(!empty($_POST['pref']))
	{
		$expr = "";

		foreach($_POST['pref'] as $selected)
		{
			if($expr == "")
			{
				$expr = "pref LIKE \"%".$selected."%\"";
			}
			else
			{
				$expr .= " OR pref LIKE \"%".$selected."%\"";
			}
		}	

		if($condition == "")
		{
			$condition = "WHERE (" .$expr ." ) ";
		}
		else
		{
			$condition .= " AND (" .$expr ." ) ";
		}
	}

    if(isset($_POST["write_date_from"]) && ($_POST["write_date_from"] != ""))
    {
        $write_date_from = $_POST["write_date_from"];

		if(isset($_POST["write_date_to"]) && ($_POST["write_date_to"] != ""))
		{
			$write_date_to = $_POST["write_date_to"];

			if($condition == "")
			{
				$condition = "WHERE (user_added_date >='" .$write_date_from. "' AND user_added_date < '" .$write_date_to. "')";
			}
			else
			{
				$condition .= " AND (user_added_date >='" .$write_date_from. "' AND user_added_date < '" .$write_date_to. "')";
			}
		}
    }

	if(!$db = opendatabase("sake.db"))
	{
		$result1 = 0;
		$count_result = 0;

		$result[] = array('result' => $result1, 'sql' => $condition, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}

	/* query */
	$count_result = 0;

	if($_POST["count_query"] == "1")
	{
		$sql = "SELECT COUNT(*) FROM USERS_J ".$condition." ORDER BY username";
		$res = executequery($db, $sql);
		$record = getnextrow($res); 
		$count_result = $record["COUNT(*)"];
	}

	$from = ($_POST["from"] != undefined && $_POST["from"]) ? $_POST["from"] : 0; 
	$to = ($_POST["to"] != undefined && $_POST["to"]) ? $_POST["to"] : 25; 

	$sql = "SELECT username, fname, minit, lname, sex, bdate, email, pref, user_added_date FROM USERS_J " .$condition." ORDER BY username"." LIMIT ".$from.", ".$to;
	$res = executequery($db, $sql);

	if(!$res)   
	{
		$result1 = 0;
		$count_result = 0;

		$result[] = array('result' => $result1, 'sql' => $sql, 'count' => $count_result);
		header('Content-Type: application/json');
		echo json_encode($result);
		return 0;
	}
	else
	{
		$default_image = "images/icons/camera20.svg";
		$imagefile = ($row["imagefile"] == "") ? $default_image : 'images/profile/' .$row["imagefile"];

		while($row = getnextrow($res))
		{
			$intime = gmdate("Y/m/d", $row["user_added_date"] + 9 * 3600);

			$result3[] = array('username' => $row["username"], 
								'fname' => $row["fname"], 
								'minit' => $row["minit"], 
								'lname' => $row["lname"], 
								'sex' => $row["sex"], 
								'bdate' => $row["bdate"], 
								'email' => $row["email"], 
								'phone' => $row["phone"], 
								'address' => $row["address"], 
								'address_read' => $row["address_read"], 
								'postal_code' => $row["postal_code"], 
								'introduction' => $row["introduction"], 
								'certification' => $row["certification"], 
								'address_disclose' => $row["address_disclose"], 
								'certification_disclose' => $row["certification_disclose"], 
								'sex_disclose' => $row["sex_disclose"], 
								'age_disclose' => $row["age_disclose"], 
								'write_date' => $intime, 
								'filename' => $imagefile);
		}
	}

	$result[] = array('sake' => $result3, 'sql' => $sql, 'count' => $count_result);
	header('Content-Type: application/json');
	echo json_encode($result);
}
?>
