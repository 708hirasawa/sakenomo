<?php

require_once("db_functions.php");
$id = sqlite3::escapeString($_GET['id']);

if(!$db = opendatabase("sake.db"))
{
    //die("データベース接続エラー .<br />");
	$return = "failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
	return 0;
}

$item = "";

if(isset($_POST['sake_name']) && $_POST['sake_name'] != undefined)
{
    $sake_name = sqlite3::escapeString($_POST['sake_name']);
    $sake_name = str_replace("&", "&amp;", $sake_name);

    $item = "sake_name='$sake_name'";
}

if(isset($_POST['sakagura_id']) && $_POST['sakagura_id'] != "")
{    
	$sakagura_id = $_POST['sakagura_id'];

	if($item == "")
	{
        $item = "sakagura_id='$sakagura_id'";
    }
	else
	{
        $item .= ", sakagura_id='$sakagura_id'";
    }
}

if(isset($_POST['sake_search']) && $_POST['sake_search'] != undefined)
{    
	$sake_search = $_POST['sake_search'];
    $sake_search = str_replace("&", "&amp;", $sake_search);

	if($item == "")
	{
        $item = "sake_search='$sake_search'";
    }
	else
	{
        $item .= ", sake_search='$sake_search'";
    }
}

if(isset($_POST["sake_read"]) && $_POST['sake_read'] != undefined)
{    
    $sake_read = sqlite3::escapeString($_POST['sake_read']);
    $sake_read = str_replace("&", "&amp;", $sake_read);

	if($item == "")
	{
        $item = "sake_read='$sake_read'";
    }
	else
	{
        $item .= ", sake_read='$sake_read'";
    }
}

if(isset($_POST["sake_english"]) && $_POST['sake_english'] != undefined)
{
    $sake_english = sqlite3::escapeString($_POST['sake_english']);
    $sake_english = str_replace("&", "&amp;", $sake_english);

    if($item == "")
	{
        $item = "sake_english='$sake_english'";
    }
	else
	{
        $item .= ", sake_english='$sake_english'";
    }
}

if(isset($_POST['jas_code']) && !empty($_POST['jas_code']))
{
	$jas = "";

	foreach($_POST['jas_code'] as $selected)
	{
		$selected = sqlite3::escapeString($selected);
		$jas = ($jas == "") ? $selected : ($jas ."," .$selected);	
	}	

    if($item == "")
	{
        $item = "jas='$jas'";
    }
	else
	{
        $item .= ", jas='$jas'";
    }
}

if(isset($_POST['setting']) && $_POST['setting'] != undefined)
{
    $setting = sqlite3::escapeString($_POST['setting']);
    $setting = str_replace("&", "&amp;", $setting);

    if($item == "")
	{
        $item = "setting='$setting'";
    }
	else
	{
        $item .= ", setting='$setting'";
    }
}

if(isset($_POST['sake_rank']) && $_POST['sake_rank'] != undefined)
{    
	$sake_rank = $_POST['sake_rank'];

	if($item == "")
	{
        $item = "sake_rank='$sake_rank'";
    }
	else
	{
        $item .= ", sake_rank='$sake_rank'";
    }
}

$seimai_rate = "";
$seimai_rate_set = false;

if(isset($_POST['seimai_rate']) && $_POST['seimai_rate'] != undefined)
{
	$seimai_rate_set = true;
	$seimai_rate = sqlite3::escapeString($_POST['seimai_rate']);
}

if(isset($_POST['seimai_rate2']) && $_POST['seimai_rate2'] != undefined)
{
	$seimai_rate_set = true;
	$seimai_rate .= ',' .sqlite3::escapeString($_POST['seimai_rate2']);
}

if(isset($_POST['seimai_rate3']) && $_POST['seimai_rate3'] != undefined)
{
	$seimai_rate_set = true;
	$seimai_rate .= ',' .sqlite3::escapeString($_POST['seimai_rate3']);
}

if($seimai_rate_set == true && $seimai_rate != "")
{
    if($item == "")
	{
        $item = "seimai_rate='$seimai_rate'";
    }
	else
	{
        $item .= ", seimai_rate='$seimai_rate'";
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$rice_used = "";
$rice_used_set = false;

if(isset($_POST['rice_used']) && $_POST['rice_used'] != undefined)
{
	if($_POST['rice_used'] != "")
	{
		$rice_used1 = sqlite3::escapeString($_POST['rice_used']);
		$kakemai_used1 = sqlite3::escapeString($_POST['kakemai']);
		$kakemai_rate1 = sqlite3::escapeString($_POST['kakemai_rate']);
		$rice_used = $rice_used1 .',' .$kakemai_used1 .',' .$kakemai_rate1;

		if($rice_used1 == "other")
		{
			if(isset($_POST['rice_used_other']) && $_POST['rice_used_other'] != undefined)
			{
				$rice_used_other = sqlite3::escapeString($_POST['rice_used_other']);
				$rice_used .= ',' .$rice_used_other;
			}	
		}
	}

	$rice_used_set = true;
}

if(isset($_POST['rice_used2']) && $_POST['rice_used2'] != undefined)
{
	if($_POST['rice_used2'] != "")
	{
		$rice_used2 = sqlite3::escapeString($_POST['rice_used2']);
		$kakemai_used2 = sqlite3::escapeString($_POST['kakemai2']);
		$kakemai_rate2 = sqlite3::escapeString($_POST['kakemai_rate2']);

		if($rice_used != "")
			$rice_used .= '/';

		$rice_used .= $rice_used2 .',' .$kakemai_used2 .',' .$kakemai_rate2;

		if($rice_used2 == "other")
		{
			if(isset($_POST['rice_used_other2']) && $_POST['rice_used_other2'] != undefined)
			{
				$rice_used_other2 = sqlite3::escapeString($_POST['rice_used_other2']);
				$rice_used .= ',' .$rice_used_other2;
			}	
		}
	}

	$rice_used_set = true;
}

if(isset($_POST['rice_used3']) && $_POST['rice_used3'] != undefined)
{
	if($_POST['rice_used3'] != "")
	{
		$rice_used3 = sqlite3::escapeString($_POST['rice_used3']);
		$kakemai_used3 = sqlite3::escapeString($_POST['kakemai3']);
		$kakemai_rate3 = sqlite3::escapeString($_POST['kakemai_rate3']);

		if($rice_used != "")
			$rice_used .= '/';

		$rice_used .= $rice_used3 .',' .$kakemai_used3 .',' .$kakemai_rate3;

		if($rice_used3 == "other")
		{
			if(isset($_POST['rice_used_other3']) && $_POST['rice_used_other3'] != undefined)
			{
				$rice_used_other3 = sqlite3::escapeString($_POST['rice_used_other3']);
				$rice_used .= ',' .$rice_used_other3;
			}	
		}
	}
	
	$rice_used_set = true;
}

if($rice_used_set == true)
{
    if($item == "")
	{
        $item = "rice_used='$rice_used'";
    }
	else
	{
        $item .= ", rice_used='$rice_used'";
    }
}

if(isset($_POST['sake_award']) && !empty($_POST['sake_award']))
{
	$sake_award = "";

	foreach($_POST['sake_award'] as $selected)
	{
		$selected = sqlite3::escapeString($selected);
		$sake_award = ($sake_award == "") ? $selected : ($sake_award ."||" .$selected);	
	}

    if($item == "")
	{
        $item = "sake_award_history='$sake_award'";
    }
	else
	{
        $item .= ", sake_award_history='$sake_award'";
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['alcohol_level']) && !empty($_POST['alcohol_level']))
{
	$alcohol_level = "";

	foreach($_POST['alcohol_level'] as $selected)
	{
		$alcohol_level = ($alcohol_level == "") ? $selected : ($alcohol_level ."," .$selected);	
	}	

    if($item == "")
	{
        $item = "alcohol_level='$alcohol_level'";
    }
	else
	{
        $item .= ", alcohol_level='$alcohol_level'";
    }
}

if(isset($_POST['jsake_level']) && !empty($_POST['jsake_level']))
{
	$jsake_level = "";

	foreach($_POST['jsake_level'] as $selected)
	{
		$jsake_level = ($jsake_level == "") ? $selected : ($jsake_level ."," .$selected);	
	}	

    if($item == "")
	{
        $item = "jsake_level='$jsake_level'";
    }
	else
	{
        $item .= ", jsake_level='$jsake_level'";
    }
}

if(isset($_POST['oxidation_level']) && !empty($_POST['oxidation_level']))
{
	$oxidation_level = "";

	foreach($_POST['oxidation_level'] as $selected)
	{
		$oxidation_level = ($oxidation_level == "") ? $selected : ($oxidation_level ."," .$selected);	
	}	

    if($item == "")
	{
        $item = "oxidation_level='$oxidation_level'";
    }
	else
	{
        $item .= ", oxidation_level='$oxidation_level'";
    }
}

if(isset($_POST['amino_level']) && !empty($_POST['amino_level']))
{
	$amino_level = "";

	foreach($_POST['amino_level'] as $selected)
	{
		$amino_level = ($amino_level == "") ? $selected : ($amino_level ."," .$selected);	
	}	

    if($item == "")
	{
        $item = "amino_level='$amino_level'";
    }
	else
	{
        $item .= ", amino_level='$amino_level'";
    }
}

if(isset($_POST['special_name']) && $_POST['special_name'] != undefined)
{
	if($_POST['special_name'] == "90" && $_POST['special_name_other'] != undefined)
	{
		$special_name = $_POST['special_name'] ."," .$_POST['special_name_other'];	
	}
	else
	{
		$special_name = $_POST['special_name'];	
	}

    if($item == "")
	{
        $item = "special_name='$special_name'";
    }
	else
	{
        $item .= ", special_name='$special_name'";
    }
}

if(isset($_POST['definition']) && $_POST['definition'] != undefined)
{
    $definition = sqlite3::escapeString($_POST['definition']);
    $definition = str_replace("&", "&amp;", $definition);

    if($item == "")
	{
        $item = "definition='$definition'";
    }
	else
	{
        $item .= ", definition='$definition'";
    }
}


if(isset($_POST['ingredients']) && $_POST['ingredients'] != undefined) 
{
	$ingredients = "";	
	$bfound = false;

	if(!empty($_POST['ingredients']))
	{
		foreach($_POST['ingredients'] as $selected)
		{
			$ingredients = ($ingredients == "") ? $selected : ($ingredients ."," .$selected);	

			if($selected == "90")
				$bfound = true;
		}	

		if($bfound)
		{
			$ingredients_other = $_POST['ingredients_other'];
			$ingredients = ($ingredients ."," .$ingredients_other);	
		}

		if($item == "")
		{
			$item = "ingredients='$ingredients'";
		}
		else
		{
			$item .= ", ingredients='$ingredients'";
		}
	}
	else
	{
		if($item == "")
		{
			$item = "ingredients='$ingredients'";
		}
		else
		{
			$item .= ", ingredients='$ingredients'";
		}
	}
}

if(isset($_POST['koubo_used']) && $_POST['koubo_used'] != undefined)
{
	$koubo_used = "";	

	if(!empty($_POST['koubo_used']))
	{
		foreach($_POST['koubo_used'] as $selected)
		{
			$koubo_used = ($koubo_used == "") ? $selected : ($koubo_used ."," .$selected);	

			if($selected == "90")
			{
				$koubo_other = $_POST['koubo_other'];
				$koubo_used = ($koubo_used ."," .$koubo_other);	
			}
			else if($selected == "91")
			{
				$koubo_other2 = $_POST['koubo_other2'];
				$koubo_used = ($koubo_used ."," .$koubo_other2);	
			}	
			else if($selected == "92")
			{
				$koubo_other3 = $_POST['koubo_other3'];
				$koubo_used = ($koubo_used ."," .$koubo_other3);	
			}	
		}

		if($item == "")
		{
			$item = "koubo_used='$koubo_used'";
		}
		else
		{
			$item .= ", koubo_used='$koubo_used'";
		}
	}
	else
	{
		if($item == "")
		{
			$item = "koubo_used='$koubo_used'";
		}
		else
		{
			$item .= ", koubo_used='$koubo_used'";
		}
	}
}


if(isset($_POST['sake_category']) && $_POST['sake_category'] != undefined)
{
	$sake_category = ""; 
	
	if($_POST['sake_category'] == '')
	{
		if($item == "")
		{
			$item = "sake_category='$sake_category'";
		}
		else
		{
			$item .= ", sake_category='$sake_category'";
		}
	}
	else if(!empty($_POST['sake_category']))
	{
		$bfound = false;

		foreach($_POST['sake_category'] as $selected)
		{
			$sake_category = ($sake_category == "") ? $selected : ($sake_category ."," .$selected);	
		
			if($selected == "90")
				$bfound = true;
		}	

		$sake_category_other = $_POST['sake_category_other'];

		if($bfound && $sake_category_other != "")
		{
			//$sake_category = ($sake_category == "") ? $selected : ($sake_category ."," .$selected);	
			$sake_category = $sake_category ."," .$sake_category_other;	
		}
		
		if($item == "")
		{
			$item = "sake_category='$sake_category'";
		}
		else
		{
			$item .= ", sake_category='$sake_category'";
		}
	}
}

if(isset($_POST['syubo']) && $_POST['syubo'] != undefined)
{
	$syubo = $_POST['syubo'];

    if($item == "")
	{
        $item = "syubo='$syubo'";
    }
	else
	{
        $item .= ", syubo='$syubo'";
    }
}

if(isset($_POST['kasu_level']) && $_POST['kasu_level'] != undefined)
{
	$kasu_level = $_POST['kasu_level'];

    if($item == "")
	{
        $item = "kasu_level='$kasu_level'";
    }
	else
	{
        $item .= ", kasu_level='$kasu_level'";
    }
}

if(isset($_POST['recommended_drink']) && $_POST['recommended_drink'] != undefined)
{
	$recommended_drink = "";	

	if(!empty($_POST['recommended_drink']))
	{
		foreach($_POST['recommended_drink'] as $selected)
		{
			$recommended_drink = ($recommended_drink == "") ? $selected : ($recommended_drink ."," .$selected);	
		}

		if($item == "")
		{
			$item = "recommended_drink='$recommended_drink'";
		}
		else
		{
			$item .= ", recommended_drink='$recommended_drink'";
		}
	}
	else
	{
		if($item == "")
		{
			$item = "recommended_drink='$recommended_drink'";
		}
		else
		{
			$item .= ", recommended_drink='$recommended_drink'";
		}
	}
}

if(isset($_POST['year_made']) && $_POST['year_made'] != undefined)
{
	$year_made = $_POST['year_made'];

    if($item == "")
	{
        $item = "year_made='$year_made'";
    }
	else
	{
        $item .= ", year_made='$year_made'";
    }
}

if(isset($_POST['sake_type']) && $_POST['sake_type'] != undefined)
{
	$sake_type = $_POST['sake_type'];

    if($item == "")
	{
        $item = "sake_type='$sake_type'";
    }
	else
	{
        $item .= ", sake_type='$sake_type'";
    }
}

if(isset($_POST['taste']) && $_POST['taste'] != undefined)
{
	$taste = $_POST['taste'];

    if($item == "")
	{
        $item = "taste='$taste'";
    }
	else
	{
        $item .= ", taste='$taste'";
    }
}

if(isset($_POST['smell']) && $_POST['smell'] != undefined)
{
	$smell = $_POST['smell'];
    $smell = str_replace("&", "&amp;", $smell);

    if($item == "")
	{
        $item = "smell='$smell'";
    }
	else
	{
        $item .= ", smell='$smell'";
    }
}

if(isset($_POST['feature']) && $_POST['feature'] != undefined)
{
	$feature = $_POST['feature'];
    $feature = str_replace("&", "&amp;", $feature);

    if($item == "")
	{
        $item = "feature='$feature'";
    }
	else
	{
        $item .= ", feature='$feature'";
    }
}

if(isset($_POST['sake_memo']) && $_POST['sake_memo'] != undefined)
{
    $sake_memo = sqlite3::escapeString($_POST['sake_memo']);
    $sake_memo = str_replace("&", "&amp;", $sake_memo);

    if($item == "")
	{
        $item = "sake_memo='$sake_memo'";
    }
	else
	{
        $item .= ", sake_memo='$sake_memo'";
    }
}

if(isset($_POST['develop']) && $_POST['develop'] != undefined)
{
	$develop = $_POST['develop'];

    if($item == "")
	{
		if($develop == "0")
			$item = "develop=NULL";
		else
			$item = "develop='$develop'";
    }
	else
	{
		if($develop == "0")
			$item .= ", develop=NULL";
		else
			$item .= ", develop='$develop'";
    }
}

$in_time = time();

if($item == "")
{
    $item = "write_update='$in_time'";
}
else
{
    $item .= ", write_update='$in_time'";
}

$sql = "UPDATE SAKE_J SET ".$item." WHERE sake_id = '$id'";

$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
else
{
	//$return = "success" .$item;
	//$return = "success:" .$sql;
	$return = "success";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
}
?>
