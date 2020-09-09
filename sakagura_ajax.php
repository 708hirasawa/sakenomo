<?php

require_once("db_functions.php");

if(isset($_POST["search_text"]) && $_POST["sakagura_name"] == "")
{
	die("“ü—ÍƒGƒ‰[ .<br />");
}

$condition = "";

if(!$db = opendatabase("sake.db"))
{
	die("ƒf[ƒ^ƒx[ƒXÚ‘±ƒGƒ‰[ .<br />");
}

if(isset($_POST["sakagura_name"]) && ($_POST["sakagura_name"] != ""))
{
    $sakagura_name = sqlite3::escapeString($_POST["sakagura_name"]);
    $sakagura_name = str_replace("%", "\%", $sakagura_name);
    $condition = "WHERE (sakagura_name LIKE \"%".$sakagura_name."%\" OR sakagura_read LIKE \"%".$sakagura_name."%\" OR id LIKE \"%".$sakagura_name."%\" OR postal_code LIKE \"%".$sakagura_name."%\" OR address LIKE \"%".$sakagura_name."%\" OR phone LIKE \"%".$sakagura_name."%\" OR url LIKE \"%".$sakagura_name."%\") ";
}

/*********
 * •]‰¿
 *********/
if(!empty($_POST['sakagura_hyouka']))
{
	$counter = 0;
	$itemcount = count($_POST['sakagura_hyouka']);

	if($condition == "")
		$condition = "WHERE (";	
	else	
		$condition .= "AND (";	

	/* loop to store and display values of individual checked checkbox. */
	foreach($_POST['sakagura_hyouka'] as $selected)
	{
		if($selected == "1") // 71%ˆÈã
		{
			$condition .= "(rank <= 0.71)";
		}
		else if($selected == "2") // 70%`61%
		{
			$condition .= "(rank >= 0.61 AND rank <= 0.7)";
		}
		else if($selected == "3") // 60%`51%
		{
			$condition .= "(rank >= 0.51 AND rank <= 0.6)";
		}
		else if($selected == "4") // 50%`41%
		{
			$condition .= "(rank >= 0.41 AND rank <= 0.5)";
		}
		else if($selected == "5") // 40%`31%
		{
			$condition .= "(rank >= 0.31 AND rank <= 0.4)";
		}
		else if($selected == "6") // 30%`21%
		{
			$condition .= "(rank >= 0.21 AND rank <= 0.3)";
		}
		else if($selected == "7") // 20%ˆÈ‰º
		{
			$condition .= "(rank >= 0.2)";
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
 * ‘n‹Æ
 ***********/
if(!empty($_POST['establishment']))
{
	$counter = 0;
	$itemcount = count($_POST['establishment']);

	if($condition == "")
		$condition = "WHERE (";	
	else	
		$condition .= "AND (";	

	/* loop to store and display values of individual checked checkbox. */

	foreach($_POST['establishment'] as $selected)
	{
		if($selected == "1")	
		{
			$condition .= "establishment >= 2011";
		}
		else if($selected == "2") 
		{
			$condition .= "(establishment >= 2001 AND establishment <= 2010)";
		}
		else if($selected == "3") 
		{
			$condition .= "(establishment >= 1991 AND establishment <= 2000)";
		}
		else if($selected == "4") 
		{
			$condition .= "(establishment >= 1981 AND establishment <= 1990)";
		}
		else if($selected == "5") 
		{
			$condition .= "(establishment >= 1971 AND establishment <= 1980)";
		}
		else if($selected == "6") 
		{
			$condition .= "(establishment >= 1961 AND establishment <= 1970)";
		}
		else if($selected == "7") 
		{
			$condition .= "(establishment >= 1951 AND establishment <= 1960)";
		}
		else if($selected == "8") 
		{
			$condition .= "(establishment >= 1941 AND establishment <= 1950)";
		}
		else if($selected == "9") 
		{
			$condition .= "(establishment >= 1931 AND establishment <= 1940)";
		}
		else if($selected == "10")
		{
			$condition .= "(establishment >= 1921 AND establishment <= 1930)";
		}
		else if($selected == "11")
		{
			$condition .= "(establishment >= 1911 AND establishment <= 1920)";
		}
		else if($selected == "12")
		{
			$condition .= "(establishment >= 1901 AND establishment <= 1910)";
		}
		else if($selected == "13") 
		{
			$condition .= "(establishment >= 1891 AND establishment <= 1900)";
		}
		else if($selected == "14")
		{
			$condition .= "(establishment >= 1881 AND establishment <= 1890)";
		}
		else if($selected == "15")
		{
			$condition .= "(establishment >= 1871 AND establishment <= 1880)";
		}
		else if($selected == "16")
		{
			$condition .= "(establishment >= 1861 AND establishment <= 1870)";
		}
		else if($selected == "17")
		{
			$condition .= "(establishment >= 1851 AND establishment <= 1860)";
		}
		else if($selected == "18")
		{
			$condition .= "establishment <= 1850";
		}

		$counter++;

		if($counter < $itemcount)
		{
			$condition .= " OR ";
		}
	}	
	
	$condition .= ") ";	
}


/***************
 * ğ‘ Œ©Šw
 ***************/
if(isset($_POST["observation"]) && ($_POST["observation"] != ""))
{
    $observation = sqlite3::escapeString($_POST["observation"]);
    $observation = str_replace("%", "\%", $observation);
  
    if($condition == "")
    {
        $condition = "WHERE observation LIKE \"%".$observation."%\"";
    } 
    else
    {
        $condition .= "AND observation LIKE \"%".$observation."%\"";
    }
}

/*********
 * ’n•û
 *********/
if(isset($_POST["sakagura_region"]) && ($_POST["sakagura_region"] != ""))
{
    $region_name = sqlite3::escapeString($_POST["sakagura_region"]);
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
if(isset($_POST["sakagura_pref"]) && ($_POST["sakagura_pref"] != ""))
{
    $pref = sqlite3::escapeString($_POST["sakagura_pref"]);
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

$sql = "SELECT id, sakagura_name, sakagura_read, rank, pref, address, url, phone FROM SAKAGURA_J " .$condition ." LIMIT 1000";
$res = executequery($db, $sql);

if(!$res)   
{
	die('Error');
}
else
{
    while($row = getnextrow($res))
    {
		$sql = "SELECT filename FROM SAKAGURA_IMAGE WHERE SAKAGURA_IMAGE.sakagura_id = '" .$row["id"] ."' LIMIT 8";
		$result_set = executequery($db, $sql);
	    
	    if($rd = getnextrow($result_set))
		{
			$result1[] = array('sakagura_name' => $row["sakagura_name"], 'sakagura_read' => $row["sakagura_read"], 'sakagura_id' => $row["id"], 'filename' => $rd["filename"], 'rank' => $row["rank"], 'address' => $row["pref"] ." " .$row["address"], 'phone' => $row["phone"], 'url' => $row["url"]);
	    }
	    else
	    {
			$default_image = "sakagura.gif";
			$result1[] = array('sakagura_name' => $row["sakagura_name"], 'sakagura_read' => $row["sakagura_read"], 'sakagura_id' => $row["id"], 'rank' => $row["rank"], 'sakagura_name' => $row["sakagura_name"], 'address' => $row["pref"] ." " .$row["address"], 'phone' => $row["phone"], 'url' => $row["url"], 'filename' => $default_image);
		}
    }
}

header('Content-Type: application/json');
echo json_encode($result1);

?>
