<?php

require_once("db_functions.php");

$condition = "";

if(!$db = opendatabase("sake.db"))
{
	die("ÉfÅ[É^ÉxÅ[ÉXê⁄ë±ÉGÉâÅ[ .<br />");
}

if(isset($_POST["syuhanten_name"]) && ($_POST["syuhanten_name"] != ""))
{
    $syuhanten_name = sqlite3::escapeString($_POST["syuhanten_name"]);
    $syuhanten_name = str_replace("%", "\%", $syuhanten_name);
    $condition = "WHERE (syuhanten_name LIKE \"%".$syuhanten_name."%\" OR syuhanten_read LIKE \"%".$syuhanten_name."%\" OR syuhanten_id LIKE \"%".$syuhanten_name."%\" OR syuhanten_postal_code LIKE \"%".$syuhanten_name."%\" OR syuhanten_address LIKE \"%".$syuhanten_name."%\" OR syuhanten_phone LIKE \"%".$syuhanten_name."%\" OR syuhanten_url LIKE \"%".$syuhanten_name."%\") ";
}

/*********
 * ï]âø
 *********/
if(!empty($_POST['syuhanten_hyouka']))
{
	$counter = 0;
	$itemcount = count($_POST['syuhanten_hyouka']);

	if($condition == "")
		$condition = "WHERE (";	
	else	
		$condition .= "AND (";	

	/* loop to store and display values of individual checked checkbox. */
	foreach($_POST['syuhanten_hyouka'] as $selected)
	{
		if($selected == "1") // 71%à»è„
		{
			$condition .= "(syuhanten_rank <= 0.71)";
		}
		else if($selected == "2") // 70%Å`61%
		{
			$condition .= "(syuhanten_rank >= 0.61 AND syuhanten_rank <= 0.7)";
		}
		else if($selected == "3") // 60%Å`51%
		{
			$condition .= "(syuhanten_rank >= 0.51 AND syuhanten_rank <= 0.6)";
		}
		else if($selected == "4") // 50%Å`41%
		{
			$condition .= "(syuhanten_rank >= 0.41 AND syuhanten_rank <= 0.5)";
		}
		else if($selected == "5") // 40%Å`31%
		{
			$condition .= "(syuhanten_rank >= 0.31 AND syuhanten_rank <= 0.4)";
		}
		else if($selected == "6") // 30%Å`21%
		{
			$condition .= "(syuhanten_rank >= 0.21 AND syuhanten_rank <= 0.3)";
		}
		else if($selected == "7") // 20%à»â∫
		{
			$condition .= "(syuhanten_rank >= 0.2)";
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
 * ínï˚
 *********/
if(isset($_POST["syuhanten_region"]) && ($_POST["syuhanten_region"] != ""))
{
    $region_name = sqlite3::escapeString($_POST["syuhanten_region"]);
    $region_name = str_replace("%", "\%", $region_name);
  
    if($condition == "")
    {
        $condition = "WHERE syuhanten_region LIKE \"%".$region_name."%\" ";
    } 
    else
    {
        $condition .= "AND syuhanten_region LIKE \"%".$region_name."%\"";
    }
}

/***************
 * ìsìπï{åß
 ***************/
if(isset($_POST["syuhanten_pref"]) && ($_POST["syuhanten_pref"] != ""))
{
    $pref = sqlite3::escapeString($_POST["syuhanten_pref"]);
    $pref = str_replace("%", "\%", $pref);
  
    if($condition == "")
    {
        $condition = "WHERE syuhanten_pref LIKE \"%".$pref."%\"";
    } 
    else
    {
        $condition .= "AND syuhanten_pref LIKE \"%".$pref."%\"";
    }
}

$sql = "SELECT syuhanten_id, syuhanten_name, syuhanten_read, syuhanten_rank, syuhanten_pref, syuhanten_postal_code, syuhanten_address, syuhanten_url, syuhanten_phone FROM SYUHANTEN_J " .$condition ." LIMIT 1000";
$res = executequery($db, $sql);

if(!$res)   
{
	die('Error');
}
else
{
    while($row = getnextrow($res))
    {
		$sql = "SELECT filename FROM SYUHANTEN_IMAGE WHERE SYUHANTEN_IMAGE.syuhanten_id = '" .$row["syuhanten_id"] ."' LIMIT 8";
		$result_set = executequery($db, $sql);
	    
	    if($rd = getnextrow($result_set))
		{
			//$result1[] = array('syuhanten_name' => $row["syuhanten_name"], 'syuhanten_read' => $row["syuhanten_read"], 'syuhanten_id' => $row["syuhanten_id"], 'filename' => $rd["filename"], 'rank' => $row["syuhanten_rank"], 'syuhanten_phone' => $row["syuhanten_phone"], 'syuhanten_postal_code' => $row["syuhanten_postal_code"], 'syuhanten_address' => $row["syuhanten_pref"] ." " .$row["syuhanten_address"], 'phone' => $row["syuhanten_phone"], 'syuhanten_url' => $row["syuhanten_url"]);
			$result1[] = array('syuhanten_name' => $row["syuhanten_name"], 'syuhanten_read' => $row["syuhanten_read"], 'syuhanten_id' => $row["syuhanten_id"], 'filename' => $rd["filename"], 'rank' => $row["syuhanten_rank"], 'syuhanten_phone' => $row["syuhanten_phone"], 'syuhanten_postal_code' => $row["syuhanten_postal_code"], 'syuhanten_address' => $row["syuhanten_address"], 'phone' => $row["syuhanten_phone"], 'syuhanten_url' => $row["syuhanten_url"]);
	    }
	    else
	    {
			$default_image = "syuhanten.gif";
			//$result1[] = array('syuhanten_name' => $row["syuhanten_name"], 'syuhanten_read' => $row["syuhanten_read"], 'syuhanten_id' => $row["syuhanten_id"], 'rank' => $row["syuhanten_rank"], 'syuhanten_name' => $row["syuhanten_name"], 'syuhanten_phone' => $row["syuhanten_phone"], 'syuhanten_postal_code' => $row["syuhanten_postal_code"], 'syuhanten_address' => $row["syuhanten_pref"] ." " .$row["syuhanten_address"], 'phone' => $row["syuhanten_phone"], 'syuhanten_url' => $row["syuhanten_url"], 'filename' => $default_image);
			$result1[] = array('syuhanten_name' => $row["syuhanten_name"], 'syuhanten_read' => $row["syuhanten_read"], 'syuhanten_id' => $row["syuhanten_id"], 'rank' => $row["syuhanten_rank"], 'syuhanten_name' => $row["syuhanten_name"], 'syuhanten_phone' => $row["syuhanten_phone"], 'syuhanten_postal_code' => $row["syuhanten_postal_code"], 'syuhanten_address' => $row["syuhanten_address"], 'phone' => $row["syuhanten_phone"], 'syuhanten_url' => $row["syuhanten_url"], 'filename' => $default_image);
		}
    }
}

header('Content-Type: application/json');
echo json_encode($result1);

?>
