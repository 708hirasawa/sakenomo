<?php
require_once("../db_functions.php");

$sake_name = sqlite3::escapeString($_POST['sake_name']);
$sake_read = sqlite3::escapeString($_POST['sake_read']);
$sake_english = sqlite3::escapeString($_POST['sake_english']);
$sake_search = $_POST['sake_search'];

$sakagura_id = $_POST['sakagura_id'];
$sake_rank = $_POST['sake_rank'];
$definition = sqlite3::escapeString($_POST['definition']);
$sake_memo = sqlite3::escapeString($_POST['sake_memo']);

/***********
 * 特定名称
 ***********/
//$special_name = $_POST['special_name'];

if(isset($_POST['special_name']) && $_POST['special_name'] != 'undefined')
{
	if($_POST['special_name'] == "90" && $_POST['special_name_other'] != 'undefined')
	{
		$special_name = $_POST['special_name'] ."," .$_POST['special_name_other'];	
	}
	else
	{
		$special_name = $_POST['special_name'];	
	}
}

$sake_category = $_POST['sake_category'];

$sake_award_name1 = $_POST['sake_award_name1']; 
$sake_award_year1 = $_POST['sake_award_year1']; 
$sake_award1 = $_POST['sake_award1']; 

$sake_award_name2 = $_POST['sake_award_name2']; 
$sake_award_year2 = $_POST['sake_award_year2']; 
$sake_award2 = $_POST['sake_award2']; 

$sake_award_name3 = $_POST['sake_award_name3']; 
$sake_award_year3 = $_POST['sake_award_year3']; 
$sake_award3 = $_POST['sake_award3']; 
$in_time = time();

$sake_award_history = "";

if($sake_award_name1 != 'undefined' && $sake_award_name1 != "")
{
	$sake_award_history = $sake_award_name1 .',' .$sake_award_year1 .',' .$sake_award1;
}

if($sake_award_name2 != 'undefined' && $sake_award_name2 != "")
{
	if($sake_award_history == "")
		$sake_award_history = $sake_award_name2 .',' .$sake_award_year2 .',' .$sake_award2;
	else
		$sake_award_history .= '/' .$sake_award_name2 .',' .$sake_award_year2 .',' .$sake_award2;
}

if($sake_award_name3 != 'undefined' && $sake_award_name3 != "")
{
	if($sake_award_history == "")
		$sake_award_history = $sake_award_name3 .',' .$sake_award_year3 .',' .$sake_award3;
	else
		$sake_award_history .= '/' .$sake_award_name3 .',' .$sake_award_year3 .',' .$sake_award3;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$rice_used = "";
$seimai_rate = "";

if($_POST['rice_used'] != 'undefined' && $_POST['rice_used'] != "")
{
	$rice_used = $_POST['rice_used'] . "," .$_POST['kakemai'] ."," .$_POST['kakemai_rate']; 

	if($_POST['rice_used_other'] != 'undefined' && $_POST['rice_used_other'] != "")
		$rice_used .= ',' .$_POST['rice_used_other'];
}

if($_POST['rice_used2'] != 'undefined' && $_POST['rice_used2'] != "")
{
	if($rice_used != "")
		$rice_used .= "/";

	$rice_used .= $_POST['rice_used2'] . "," .$_POST['kakemai2'] ."," .$_POST['kakemai_rate2']; 

	if($_POST['rice_used_other2'] != 'undefined' && $_POST['rice_used_other2'] != "")
		$rice_used .= ',' .$_POST['rice_used_other2'];
}

if($_POST['rice_used3'] != 'undefined' && $_POST['rice_used3'] != "")
{
	if($rice_used != "")
		$rice_used .= "/";

	$rice_used .= $_POST['rice_used3'] . "," .$_POST['kakemai3'] ."," .$_POST['kakemai_rate3']; 

	if($_POST['rice_used_other3'] != 'undefined' && $_POST['rice_used_other3'] != "")
		$rice_used .= ',' .$_POST['rice_used_other3'];
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($_POST['seimai_rate'] != 'undefined' && $_POST['seimai_rate'] !="")
{
	$seimai_rate .= $_POST['seimai_rate'];
}

if($_POST['seimai_rate2'] != 'undefined' && $_POST['seimai_rate2'] !="")
{
    if($seimai_rate != "")
		 $seimai_rate .= ',';

	$seimai_rate .= $_POST['seimai_rate2'];
}

if($_POST['seimai_rate3'] != 'undefined' && $_POST['seimai_rate3'] !="")
{
    if($seimai_rate != "")
		 $seimai_rate .= ',';

	$seimai_rate .= $_POST['seimai_rate3'];
}

$alcohol_level = "";

if(isset($_POST['alcohol_level']) && !empty($_POST['alcohol_level']))
{
	foreach($_POST['alcohol_level'] as $selected)
	{
		$alcohol_level = ($alcohol_level == "") ? $selected : ($alcohol_level ."," .$selected);	
	}	
}

$jsake_level = "";

if(isset($_POST['jsake_level']) && !empty($_POST['jsake_level']))
{
	foreach($_POST['jsake_level'] as $selected)
	{
		$jsake_level = ($jsake_level == "") ? $selected : ($jsake_level ."," .$selected);	
	}	
}

$oxidation_level = "";

if(isset($_POST['oxidation_level']) && !empty($_POST['oxidation_level']))
{
	foreach($_POST['oxidation_level'] as $selected)
	{
		$oxidation_level = ($oxidation_level == "") ? $selected : ($oxidation_level ."," .$selected);	
	}	
}

$amino_level = "";

if(isset($_POST['amino_level']) && !empty($_POST['amino_level']))
{
	$amino_level = "";

	foreach($_POST['amino_level'] as $selected)
	{
		$amino_level = ($amino_level == "") ? $selected : ($amino_level ."," .$selected);	
	}	
}

$syubo = $_POST['syubo'];
$kasu_level = $_POST['kasu_level'];
$water_used = $_POST['water_used'];
$year_made = $_POST['year_made'];
$sake_type = $_POST['sake_type'];
$taste = $_POST['taste'];
$smell = $_POST['smell'];
$feature = $_POST['feature'];
//$award_history = $_POST['award_history'];
$kakemai = $_POST['kakemai'];
$kakemai_rate = $_POST['kakemai_rate'];

if($year_made == "")
	$year_made = null;

if($rice_used == "")
	$rice_used = null;

/**************
 * 原材料
 *************/
$ingredients_value = "";	

if(!empty($_POST['ingredients']))
{
	$bfound = false;

	foreach($_POST['ingredients'] as $selected)
	{
		$ingredients_value = ($ingredients_value == "") ? $selected : ($ingredients_value ."," .$selected);	

		if($selected == "90")
			$bfound = true;
	}	

	if($bfound)
	{
		$ingredients_value = ($ingredients_value ."," .$_POST['ingredients_other']);	
	}
}

/**************
 * 製法の特徴
 *************/
$category_value = "";	

if(!empty($_POST['sake_category']))
{
	$bfound = false;

	foreach($_POST['sake_category'] as $selected)
	{
		$category_value = ($category_value == "") ? $selected : ($category_value ."," .$selected);	

		if($selected == "90")
			$bfound = true;
	}	

	if($bfound)
	{
		$category_value = ($category_value ."," .$_POST['sake_category_other']);	
	}
}

$jas = "";

if(isset($_POST['jas_code']) && !empty($_POST['jas_code']))
{
	foreach($_POST['jas_code'] as $selected)
	{
		$selected = sqlite3::escapeString($selected);
		$jas = ($jas == "") ? $selected : ($jas ."," .$selected);	
	}	
}

/***********
 * 酵母
 ***********/
$koubo_value = "";	

if(!empty($_POST['koubo_used']))
{
	foreach($_POST['koubo_used'] as $selected)
	{
		$koubo_value = ($koubo_value == "") ? $selected : ($koubo_value ."," .$selected);	

		if($selected == "90")
		{
			$koubo_value = ($koubo_value ."," .$_POST['koubo_other']);	
		}
		else if($selected == "91")
		{
			$koubo_value = ($koubo_value ."," .$_POST['koubo_other2']);	
		}
		else if($selected == "92")
		{
			$koubo_value = ($koubo_value ."," .$_POST['koubo_other3']);	
		}
	}	
}

/*******************
 * オススメの飲み方
 *******************/
$recommended_drink = "";	

if(!empty($_POST['recommended_drink']))
{
	foreach($_POST['recommended_drink'] as $selected)
	{
		if($selected != "")
		{
			if($recommended_drink == "")
				$recommended_drink = $selected;
			else
				$recommended_drink .= "," .$selected;	
		}
	}	
}

if(!$db = opendatabase("../sake.db"))
{
	$ret = "登録できませんでした。";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$ret.'</str>'."\n";
	echo '</xml>'."\n";
}

if(!$sake_name)
{
	$ret = "登録できませんでした。";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$ret.'</str>'."\n";
	echo '</xml>'."\n";
}

$sql = "select sake_id from sake_j where sake_id = (select max(sake_id) from sake_j)";
$res = executequery($db, $sql);
$row = getnextrow($res);

if(!$row) 
{
	$ret = "登録できませんでした。";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$ret.'</str>'."\n";
	echo '</xml>'."\n";
}


$number = substr(strrchr($row["sake_id"], 'A'), 3);
$counter = intval($number) + 1;
$sequence = "A10".$counter;

$sql = "INSERT INTO SAKE_J(sake_id, 
						sake_name, 
						sake_search,
						jas,						
						sake_read,
						sake_english,
						sakagura_id,
						sake_rank, 
						definition, 
						special_name, 
						sake_category, 
						ingredients, 
						seimai_rate, 
						alcohol_level, 
						rice_used, 
						jsake_level, 
						oxidation_level, 
						amino_level,
						koubo_used,
						syubo,
						kasu_level, 
						water_used, 
						year_made, 
						sake_type, 
						taste, 
						smell, 
						feature, 
						recommended_drink, 
						recommended_cook,
						sake_award_history,
						sake_memo,
						write_date,
						write_update) VALUES(
						'$sequence', 
						'$sake_name',
						'$sake_search',
						'$jas',						
						'$sake_read',
						'$sake_english',
						'$sakagura_id',
						'$sake_rank',
						'$definition',
						'$special_name',
						'$category_value',
						'$ingredients_value', 
						'$seimai_rate', 
						'$alcohol_level', 
						'$rice_used', 
						'$jsake_level', 
						'$oxidation_level', 
						'$amino_level', 
						'$koubo_value', 
						'$syubo', 
						'$kasu_level', 
						'$water_used', 
						'$year_made', 
						'$sake_type', 
						'$taste', 
						'$smell', 
						'$feature', 
						'$recommended_drink', 
						'$recommended_cook',
						'$sake_award_history',
						'$sake_memo',
						'$in_time',
						'$in_time'
						)";

$res = executequery($db, $sql);

if(!$res) 
{
	$ret = "failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<sake_id>'.$sequence.'</sake_id>'."\n";
	echo '<str>'.$ret.'</str>'."\n";
	echo '</xml>'."\n";
}
else 
{
	$ret = "success";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<sake_id>'.$sequence.'</sake_id>'."\n";
	echo '<str>'.$ret.'</str>'."\n";
	echo '</xml>'."\n";
}

?>
