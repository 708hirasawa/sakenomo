<?php

require_once("db_functions.php");
$username = $_COOKIE['login_cookie'];

if(!$db = opendatabase("sake.db"))
{
	die("ƒf[ƒ^ƒx[ƒXÚ‘±ƒGƒ‰[ .<br />");
}

$condition = "";

if(isset($_POST["sake_name"]) && ($_POST["sake_name"] != ""))
{
    $sake_name = sqlite3::escapeString( $_POST["sake_name"]);
    $sake_name = str_replace("%", "\%", $sake_name);
    $condition = "WHERE (sake_name LIKE \"%".$sake_name."%\" OR sake_read LIKE \"%".$sake_name."%\" OR sake_english LIKE \"%".$sake_name."%\" OR sake_id LIKE \"%".$sake_name."%\") ";
}

/***************
 * special_name
 ***************/
if(!empty($_POST['special_name']))
{
	$counter = 0;
	$itemcount = count($_POST['special_name']);

	if($condition == "")
		$condition = "WHERE (";	
	else	
		$condition .= "AND (";	

	/* loop to store and display values of individual checked checkbox. */
	foreach($_POST['special_name'] as $selected)
	{
		$condition .= "special_name = $selected"; 
		$counter++;

		if($counter < $itemcount)
		{
			$condition .= " OR ";
		}
		
		//$condition .= "special_name = '15'";	
	}
	
	//$condition .= "special_name = '15'";	
	$condition .= ") ";	
}

//$condition = "WHERE (special_name = '15') ";

/***********
 * Žð•Ä
 ***********/
if(!empty($_POST['syubei']))
{
	$counter = 0;
	$itemcount = count($_POST['syubei']);

	if($condition == "")
		$condition = "WHERE (";	
	else	
		$condition .= "AND (";	

	/* loop to store and display values of individual checked checkbox. */
	foreach($_POST['syubei'] as $selected)
	{
		$condition .= "sake_category = $selected"; 
		$counter++;

		if($counter < $itemcount)
		{
			$condition .= " OR ";
		}
	}	
	
	$condition .= ") ";	
}

/***********
 * Ž_“x
 ***********/
if(!empty($_POST['sando']))
{
	$counter = 0;
	$itemcount = count($_POST['sando']);

	if($condition == "")
		$condition = "WHERE (";	
	else	
		$condition .= "AND (";	

	/* loop to store and display values of individual checked checkbox. */
	foreach($_POST['sando'] as $selected)
	{
		if($selected == "1") // 0.5ˆÈ‰º
		{
			$condition .= "(oxidation_level <= 0.5)";
		}
		else if($selected == "2") // 0.6`1.0
		{
			$condition .= "(oxidation_level >= 0.6 AND oxidation_level <= 1)";
		}
		else if($selected == "3") // 1.1`1.5
		{
			$condition .= "(oxidation_level >= 1.1 AND oxidation_level <= 1.5)";
		}
		else if($selected == "4") // 1.6`2.0
		{
			$condition .= "(oxidation_level >= 1.6 AND oxidation_level <= 2.0)";
		}
		else if($selected == "5") // 2.1`2.5
		{
			$condition .= "(oxidation_level >= 2.1 AND oxidation_level <= 2.5)";
		}
		else if($selected == "6") // 2.6ˆÈã
		{
			$condition .= "(oxidation_level >= 2.6)";
		}
		
		$counter++;

		if($counter < $itemcount)
		{
			$condition .= " OR ";
		}
	}	
	
	$condition .= ") ";	
}

/***********
 * ¸•Ä•à‡
 ***********/
if(!empty($_POST['seimai']))
{
	$counter = 0;
	$itemcount = count($_POST['seimai']);

	if($condition == "")
		$condition = "WHERE (";	
	else	
		$condition .= "AND (";	

	/* loop to store and display values of individual checked checkbox. */
	foreach($_POST['seimai'] as $selected)
	{
		if($selected == "1") // 71%ˆÈã
		{
			$condition .= "seimai_rate <= 0.71";
		}
		else if($selected == "2") // 70%`61%
		{
			$condition .= "(seimai_rate >= 61 AND seimai_rate <= 70)";
		}
		else if($selected == "3") // 60%`51%
		{
			$condition .= "(seimai_rate >= 51 AND seimai_rate <= 60)";
		}
		else if($selected == "4") // 50%`41%
		{
			$condition .= "(seimai_rate >= 41 AND seimai_rate <= 50)";
		}
		else if($selected == "5") // 40%`31%
		{
			$condition .= "(seimai_rate >= 31 AND seimai_rate <= 40)";
		}
		else if($selected == "6") // 30%`21%
		{
			$condition .= "(seimai_rate >= 21 AND seimai_rate <= 30)";
		}
		else if($selected == "7") // 20%ˆÈ‰º
		{
			$condition .= "seimai_rate >= 20";
		}
		
		$counter++;

		if($counter < $itemcount)
		{
			$condition .= " OR ";
		}
	}	
	
	$condition .= ") ";	
}


/*********
 * •]‰¿
 *********/
if(!empty($_POST['hyouka']))
{
	$counter = 0;
	$itemcount = count($_POST['hyouka']);

	if($condition == "")
		$condition = "WHERE (";	
	else	
		$condition .= "AND (";	

	/* loop to store and display values of individual checked checkbox. */
	foreach($_POST['hyouka'] as $selected)
	{
		if($selected == "1") // 71%ˆÈã
		{
			$condition .= "(sake_rank <= 0.71)";
		}
		else if($selected == "2") // 70%`61%
		{
			$condition .= "(sake_rank >= 0.61 AND sake_rank <= 0.7)";
		}
		else if($selected == "3") // 60%`51%
		{
			$condition .= "(sake_rank >= 0.51 AND sake_rank <= 0.6)";
		}
		else if($selected == "4") // 50%`41%
		{
			$condition .= "(sake_rank >= 0.41 AND sake_rank <= 0.5)";
		}
		else if($selected == "5") // 40%`31%
		{
			$condition .= "(sake_rank >= 0.31 AND sake_rank <= 0.4)";
		}
		else if($selected == "6") // 30%`21%
		{
			$condition .= "(sake_rank >= 0.21 AND sake_rank <= 0.3)";
		}
		else if($selected == "7") // 20%ˆÈ‰º
		{
			$condition .= "(sake_rank >= 0.2)";
		}
		
		$counter++;

		if($counter < $itemcount)
		{
			$condition .= " OR ";
		}
	}	
	
	$condition .= ") ";	
}


/*********
 * ’n•û
 *********/
if(isset($_POST["sake_region"]) && ($_POST["sake_region"] != ""))
{
    $region_name = sqlite3::escapeString($_POST["sake_region"]);
    $region_name = str_replace("%", "\%", $region_name);
  
    if($condition == "")
    {
        $condition = "WHERE region_name LIKE \"%".$region_name."%\" ";
    } 
    else
    {
        $condition .= "AND region_name LIKE \"%".$region_name."%\"";
    }
}

/***************
 * “s“¹•{Œ§
 ***************/
if(isset($_POST["sake_pref"]) && ($_POST["sake_pref"] != ""))
{
    $pref = sqlite3::escapeString($_POST["sake_pref"]);
    $pref = str_replace("%", "\%", $pref);
  
    if($condition == "")
    {
        $condition = "WHERE pref LIKE \"%".$pref."%\"";
    } 
    else
    {
        $condition .= "AND pref LIKE \"%".$pref."%\"";
    }
}

$condition .= " AND sakagura_id=id";
//$sql = "SELECT sake_name, sake_read, special_name, sake_id, sake_rank, sakagura_name, address, url, phone FROM SAKE_J, SAKAGURA_J " .$condition." ORDER BY sake_read"." LIMIT 1000";

$sql = "SELECT sake_name, sake_read, special_name, sake_id, sake_rank, sakagura_name, pref, address, url, phone FROM SAKE_J, SAKAGURA_J " .$condition ." LIMIT 1000";
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
			//$result1[] = array('sake_name' => count($_POST['special_name']) ." " .$row["sake_name"], 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"], 'sakagura_name' => $row["sakagura_name"], 'filename' => $rd["filename"], 'sake_rank' => $row["sake_rank"], 'address' => $row["pref"] ." " .$row["address"], 'phone' => $row["phone"], 'url' => $row["url"]);
			$result1[] = array('sake_name' => $row["sake_name"], 'name' => $row["sake_read"], 'sake_id' => $row["sake_id"], 'sakagura_name' => $row["sakagura_name"], 'filename' => $rd["filename"], 'sake_rank' => $row["sake_rank"], 'address' => $row["pref"] ." " .$row["address"], 'phone' => $row["phone"], 'url' => $row["url"]);
	    }
	    else
	    {
			$default_image = "sake.jpg";
			$result1[] = array('sake_name' => $row["sake_name"], 'name' => count($_POST['special_name']) ." " .$row["sake_read"], 'sake_id' => $row["sake_id"], 'sake_rank' => $row["sake_rank"], 'sakagura_name' => $row["sakagura_name"], 'address' => $row["pref"] ." " .$row["address"], 'phone' => $row["phone"], 'url' => $row["url"], 'filename' => $default_image);
		}
    }
}

//$result[] = array('sake' => $result1, 'sakagura' => $result1, 'syuhanten' => $result1);
header('Content-Type: application/json');
echo json_encode($result1);

?>
