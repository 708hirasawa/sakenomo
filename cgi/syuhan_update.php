<?php

require_once("../db_functions.php");

$syuhanten_id = sqlite3::escapeString($_GET['syuhanten_id']);

$syuhanten_id = $_POST['syuhanten_id'];

if(!$db = opendatabase("../sake.db"))
{
   die("データベース接続エラー .<br />");
}

$item = "";

$syuhanten = $_POST['syuhanten'];

if($syuhanten != "")
{
    $item = "syuhanten='$syuhanten'";
}

$syuhanten_rank = $_POST['syuhanten_rank'];

if($syuhanten_rank != "")
{
	if($item == "")
	{
        $item = "syuhanten_rank='$syuhanten_rank'";
    }
	else
	{
        $item .= ", syuhanten_rank='$syuhanten_rank'";
    }
}

$syuhanten_type = $_POST['syuhanten_type'];

if($syuhanten_type != "")
{
	if($item == "")
	{
        $item = "syuhanten_type='$syuhanten_type'";
    }
	else
	{
        $item .= ", syuhanten_type='$syuhanten_type'";
    }
}

$syuhanten_country = $_POST['syuhanten_country'];

if($syuhanten_country != "")
{
	if($item == "")
	{
        $item = "syuhanten_country='$syuhanten_country'";
    }
	else
	{
        $item .= ", syuhanten_country='$syuhanten_country'";
    }
}

$syuhanten_region = $_POST['syuhanten_region'];

if($syuhanten_region != "")
{
	if($item == "")
	{
        $item = "syuhanten_region='$syuhanten_region'";
    }
	else
	{
        $item .= ", syuhanten_region='$syuhanten_region'";
    }
}

$syuhanten_pref = $_POST['syuhanten_pref'];

if($syuhanten_pref != "")
{
	if($item == "")
	{
        $item = "syuhanten_pref='$syuhanten_pref'";
    }
	else
	{
        $item .= ", syuhanten_pref='$syuhanten_pref'";
    }
}

$syuhanten_pref_read = $_POST['syuhanten_pref_read'];

if($syuhanten_pref_read != "")
{
	if($item == "")
	{
        $item = "syuhanten_pref_read='$syuhanten_pref_read'";
    }
	else
	{
        $item .= ", syuhanten_pref_read='$syuhanten_pref_read'";
    }
}

$syuhanten_name = $_POST['syuhanten_name'];

if($syuhanten_name != "")
{
	$syuhanten_name = sqlite3::escapeString($syuhanten_name);

	if($item == "")
	{
        $item = "syuhanten_name='$syuhanten_name'";
    }
	else
	{
        $item .= ", syuhanten_name='$syuhanten_name'";
    }
}

$syuhanten_search = $_POST['syuhanten_search'];

if($syuhanten_search != 'undefined')
{
	$syuhanten_search = sqlite3::escapeString($syuhanten_search);

	if($item == "")
	{
        $item = "syuhanten_search='$syuhanten_search'";
    }
	else
	{
        $item .= ", syuhanten_search='$syuhanten_search'";
    }
}

$syuhanten_read = $_POST['syuhanten_read'];

if($syuhanten_read != 'undefined')
{
    $syuhanten_read = sqlite3::escapeString($syuhanten_read);

	if($item == "")
	{
        $item = "syuhanten_read='$syuhanten_read'";
    }
	else
	{
        $item .= ", syuhanten_read='$syuhanten_read'";
    }
}

$syuhanten_english = $_POST['syuhanten_english'];

if($syuhanten_english != 'undefined')
{
    $syuhanten_english = sqlite3::escapeString($syuhanten_english);

	if($item == "")
	{
        $item = "syuhanten_english='$syuhanten_english'";
    }
	else
	{
        $item .= ", syuhanten_english='$syuhanten_english'";
    }
}

$syuhanten_sort = $_POST['syuhanten_sort'];

if($syuhanten_sort != 'undefined')
{
    $syuhanten_sort = sqlite3::escapeString($syuhanten_sort);

	if($item == "")
	{
        $item = "syuhanten_sort='$syuhanten_sort'";
    }
	else
	{
        $item .= ", syuhanten_sort='$syuhanten_sort'";
    }
}

$syuhanten_intro = $_POST['syuhanten_intro'];

if($syuhanten_intro != 'undefined')
{
    $syuhanten_intro = sqlite3::escapeString($syuhanten_intro);
    //$syuhanten_intro = str_replace("%", "\%", sqlite3::escapeString($syuhanten_intro));
    
	if($item == "")
	{
        $item = "syuhanten_intro='$syuhanten_intro'";
    }
	else
	{
        $item .= ", syuhanten_intro='$syuhanten_intro'";
    }
}

$syuhanten_postal_code = $_POST['syuhanten_postal_code'];

if($syuhanten_postal_code != "")
{
	if($item == "")
	{
        $item = "syuhanten_postal_code='$syuhanten_postal_code'";
    }
	else
	{
        $item .= ", syuhanten_postal_code='$syuhanten_postal_code'";
    }
}

$syuhanten_address = $_POST['syuhanten_address'];

if($syuhanten_address != "")
{
	if($item == "")
	{
        $item = "syuhanten_address='$syuhanten_address'";
    }
	else
	{
        $item .= ", syuhanten_address='$syuhanten_address'";
    }
}

$syuhanten_phone = $_POST['syuhanten_phone'];

if($syuhanten_phone != "")
{
	if($item == "")
	{
        $item = "syuhanten_phone='$syuhanten_phone'";
    }
	else
	{
        $item .= ", syuhanten_phone='$syuhanten_phone'";
    }
}

$syuhanten_fax = $_POST['syuhanten_fax'];

if($syuhanten_fax != "")
{
	if($item == "")
	{
        $item = "syuhanten_fax='$syuhanten_fax'";
    }
	else
	{
        $item .= ", syuhanten_fax='$syuhanten_fax'";
    }
}

$syuhanten_url = $_POST['syuhanten_url'];

if($syuhanten_url != "")
{
	if($item == "")
	{
        $item = "syuhanten_url='$syuhanten_url'";
    }
	else
	{
        $item .= ", syuhanten_url='$syuhanten_url'";
    }
}

$syuhanten_email = $_POST['syuhanten_email'];

if($syuhanten_email != "")
{
	if($item == "")
	{
        $item = "syuhanten_email='$syuhanten_email'";
    }
	else
	{
        $item .= ", syuhanten_email='$syuhanten_email'";
    }
}

$syuhanten_hours = $_POST['syuhanten_hours'];

if($syuhanten_hours != "")
{
	if($item == "")
	{
        $item = "syuhanten_hours='$syuhanten_hours'";
    }
	else
	{
        $item .= ", syuhanten_hours='$syuhanten_hours'";
    }
}

$syuhanten_closed = $_POST['syuhanten_closed'];

if($syuhanten_closed != "")
{
	if($item == "")
	{
        $item = "syuhanten_closed='$syuhanten_closed'";
    }
	else
	{
        $item .= ", syuhanten_closed='$syuhanten_closed'";
    }
}

$syuhanten_parking = $_POST['syuhanten_parking'];

if($syuhanten_parking != "")
{
	if($item == "")
	{
        $item = "syuhanten_parking='$syuhanten_parking'";
    }
	else
	{
        $item .= ", syuhanten_parking='$syuhanten_parking'";
    }
}

$syuhanten_sake = $_POST['syuhanten_sake'];

if($syuhanten_sake != 'undefined')
{
	if($item == "")
	{
        $item = "syuhanten_sake='$syuhanten_sake'";
    }
	else
	{
        $item .= ", syuhanten_sake='$syuhanten_sake'";
    }
}

$syuhanten_memo = $_POST['syuhanten_memo'];

if($syuhanten_memo != "")
{
	if($item == "")
	{
        $item = "syuhanten_memo='$syuhanten_memo'";
    }
	else
	{
        $item .= ", syuhanten_memo='$syuhanten_memo'";
    }
}

$syuhanten_datasource = $_POST['syuhanten_datasource'];

if($syuhanten_datasource != "")
{
	if($item == "")
	{
        $item = "syuhanten_datasource='$syuhanten_datasource'";
    }
	else
	{
        $item .= ", syuhanten_datasource='$syuhanten_datasource'";
    }
}

$syuhanten_lastcontacted = $_POST['syuhanten_lastcontacted'];

if($syuhanten_lastcontacted != "")
{
	if($item == "")
	{
        $item = "syuhanten_lastcontacted='$syuhanten_lastcontacted'";
    }
	else
	{
        $item .= ", syuhanten_lastcontacted='$syuhanten_lastcontacted'";
    }
}

$syuhanten_develop = $_POST['syuhanten_develop'];

if($syuhanten_develop != "")
{
    if($item == "")
	{
		if($syuhanten_develop == "0")
			$item = "syuhanten_develop=NULL";
		else
			$item = "syuhanten_develop='$syuhanten_develop'";
    }
	else
	{
		if($syuhanten_develop == "0")
			$item .= ", syuhanten_develop=NULL";
		else
			$item .= ", syuhanten_develop='$syuhanten_develop'";
    }
}

$sql = "UPDATE SYUHANTEN_J SET ".$item." WHERE syuhanten_id = '$syuhanten_id'";
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed ".$sql;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
else
{
	//$return = "success:".$sql;
	$return = "success";

	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo ' <syuhanten>'.$syuhanten.'</syuhanten>'."\n";
	echo ' <syuhanten_name>'.$syuhanten_name.'</syuhanten_name>'."\n";
	echo ' <syuhanten_read>'.$syuhanten_read.'</syuhanten_read>'."\n";
	echo ' <syuhanten_rank>'.$syuhanten_rank.'</syuhanten_rank>'."\n";
	echo ' <syuhanten_type>'.$syuhanten_type.'</syuhanten_type>'."\n";
	echo ' <syuhanten_country>'.$syuhanten_country.'</syuhanten_country>'."\n";
	echo ' <syuhanten_region>'.$syuhanten_region.'</syuhanten_region>'."\n";
	echo ' <syuhanten_pref>'.$syuhanten_pref.'</syuhanten_pref>'."\n";
	echo ' <syuhanten_pref_read>'.$syuhanten_pref_read.'</syuhanten_pref_read>'."\n";
	echo ' <syuhanten_search>'.$syuhanten_search.'</syuhanten_search>'."\n";
	echo ' <syuhanten_sort>'.$syuhanten_sort.'</syuhanten_sort>'."\n";
	echo ' <syuhanten_intro>'.$syuhanten_intro.'</syuhanten_intro>'."\n";
	echo ' <syuhanten_postal_code>'.$syuhanten_postal_code.'</syuhanten_postal_code>'."\n";
	echo ' <syuhanten_address>'.$syuhanten_address.'</syuhanten_address>'."\n";
	echo ' <syuhanten_phone>'.$syuhanten_phone.'</syuhanten_phone>'."\n";
	echo ' <syuhanten_fax>'.$syuhanten_fax.'</syuhanten_fax>'."\n";
	echo ' <syuhanten_url>'.$syuhanten_url.'</syuhanten_url>'."\n";
	echo ' <syuhanten_email>'.$syuhanten_email.'</syuhanten_email>'."\n";
	echo ' <syuhanten_hours>'.$syuhanten_hours.'</syuhanten_hours>'."\n";
	echo ' <syuhanten_closed>'.$syuhanten_closed.'</syuhanten_closed>'."\n";
	echo ' <syuhanten_parking>'.$syuhanten_parking.'</syuhanten_parking>'."\n";
	echo ' <syuhanten_sake>'.$syuhanten_sake.'</syuhanten_sake>'."\n";
	echo ' <syuhanten_memo>'.$syuhanten_memo.'</syuhanten_memo>'."\n";
	echo ' <syuhanten_datasource>'.$syuhanten_datasource.'</syuhanten_datasource>'."\n";
	echo ' <syuhanten_lastcontacted>'.$syuhanten_lastcontacted.'</syuhanten_lastcontacted>'."\n";
	echo '</xml>'."\n";
}
?>

