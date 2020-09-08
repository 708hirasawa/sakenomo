<?php

require_once("db_functions.php");
$id = sqlite3::escapeString($_GET['id']);

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$item = "";

if(isset($_POST['sakagura']) && $_POST['sakagura'] != undefined)
{
	$sakagura = $_POST['sakagura'];
    $item = "sakagura='$sakagura'";
}

if(isset($_POST['sakagura_name']) && $_POST['sakagura_name'] != undefined)
{
    $sakagura_name = sqlite3::escapeString($_POST['sakagura_name']);
    $sakagura_name = str_replace("&", "&amp;", $sakagura_name);

    if($item == "")
	{
        $item = "sakagura_name='$sakagura_name'";
    }
	else
	{
        $item .= ", sakagura_name='$sakagura_name'";
    }
}

if(isset($_POST['sakagura_read']) && $_POST['sakagura_read'] != undefined)
{
    $sakagura_read = sqlite3::escapeString($_POST['sakagura_read']);
    $sakagura_read = str_replace("&", "&amp;", $sakagura_read);

    if($item == "")
	{
        $item = "sakagura_read='$sakagura_read'";
    }
	else
	{
        $item .= ", sakagura_read='$sakagura_read'";
    }
}

if(isset($_POST['sakagura_english']) && $_POST['sakagura_english'] != undefined)
{
    $sakagura_english = sqlite3::escapeString($_POST['sakagura_english']);
    $sakagura_english = str_replace("&", "&amp;", $sakagura_english);

    if($item == "")
	{
        $item = "sakagura_english='$sakagura_english'";
    }
	else
	{
        $item .= ", sakagura_english='$sakagura_english'";
    }
}

if(isset($_POST['sakagura_intro']) && $_POST['sakagura_intro'] != undefined)
{
    $sakagura_intro = sqlite3::escapeString($_POST['sakagura_intro']);
    $sakagura_intro = str_replace("&", "&amp;", $sakagura_intro);

    if($item == "")
	{
        $item = "sakagura_intro='$sakagura_intro'";
    }
	else
	{
        $item .= ", sakagura_intro='$sakagura_intro'";
    }
}

if(isset($_POST['sakagura_search']) && $_POST['sakagura_search'] != undefined)
{
	$sakagura_search = "";

	if(!empty($_POST['sakagura_search']))
	{
		foreach($_POST['sakagura_search'] as $selected)
		{
			$selected = str_replace("&", "&amp;", $selected);
			$sakagura_search = ($sakagura_search == "") ? $selected : ($sakagura_search ."," .$selected);	
		}

		if($item == "")
		{
			$item = "sakagura_search='$sakagura_search'";
		}
		else
		{
			$item .= ", sakagura_search='$sakagura_search'";
		}
	}
	else
	{
		if($item == "")
		{
			$item = "sakagura_search='$sakagura_search'";
		}
		else
		{
			$item .= ", sakagura_search='$sakagura_search'";
		}
	}
}

if(isset($_POST['rank']) && $_POST['rank'] != undefined)
{
	$rank = sqlite3::escapeString($_POST['rank']);

	if($item == "")
	{
        $item = "rank='$rank'";
    }
	else
	{
        $item .= ", rank='$rank'";
    }
}

if(isset($_POST['country']) && $_POST['country'] != undefined)
{
	$country = sqlite3::escapeString($_POST['country']);

	if($item == "")
	{
        $item = "country='$country'";
    }
	else
	{
        $item .= ", country='$country'";
    }
}

if(isset($_POST['region_name']) && $_POST['region_name'] != undefined)
{
	$region_name = sqlite3::escapeString($_POST['region_name']);

    if($item == "")
	{
        $item = "region_name='$region_name'";
    }
	else
	{
        $item .= ", region_name='$region_name'";
    }
}

if(isset($_POST['pref']) && $_POST['pref'] != undefined)
{    
	$pref = sqlite3::escapeString($_POST['pref']);

	if($item == "")
	{
        $item = "pref='$pref'";
    }
	else
	{
        $item .= ", pref='$pref'";
    }
}

if(isset($_POST['pref_read']) && $_POST['pref_read'] != undefined)
{
	$pref_read = sqlite3::escapeString($_POST['pref_read']);

    if($item == "")
	{
        $item = "pref_read='$pref_read'";
    }
	else
	{
        $item .= ", pref_read='$pref_read'";
    }
}

if(isset($_POST['url']) && $_POST['url'] != undefined)
{
	$url = "";

	if(!empty($_POST['url']))
	{
		foreach($_POST['url'] as $selected)
		{
			$selected = str_replace("&", "&amp;", $selected);
			$url = ($url == "") ? $selected : ($url ."," .$selected);	
		}

		if($item == "")
		{
			$item = "url='$url'";
		}
		else
		{
			$item .= ", url='$url'";
		}
	}
	else
	{
		if($item == "")
		{
			$item = "url='$url'";
		}
		else
		{
			$item .= ", url='$url'";
		}
	}
}

if(isset($_POST['postal_code']) && $_POST['postal_code'] != undefined)
{
    $postal_code = sqlite3::escapeString($_POST['postal_code']);

    if($item == "")
	{
        $item = "postal_code='$postal_code'";
    }
	else
	{
        $item .= ", postal_code='$postal_code'";
    }
}

if(isset($_POST['address']) && $_POST['address'] != undefined)
{
    $address = sqlite3::escapeString($_POST['address']);
    $address = str_replace("&", "&amp;", $address);

    if($item == "")
	{
        $item = "address='$address'";
    }
	else
	{
        $item .= ", address='$address'";
    }
}

if(isset($_POST['phone']) && $_POST['phone'] != undefined)
{
	$phone = sqlite3::escapeString($_POST['phone']);

    if($item == "")
	{
        $item = "phone='$phone'";
    }
	else
	{
        $item .= ", phone='$phone'";
    }
}

if(isset($_POST['fax']) && $_POST['fax'] != undefined)
{
	$fax = sqlite3::escapeString($_POST['fax']);

    if($item == "")
	{
        $item = "fax='$fax'";
    }
	else
	{
        $item .= ", fax='$fax'";
    }
}

if(isset($_POST['email']) && $_POST['email'] != undefined)
{
	$email = sqlite3::escapeString($_POST['email']);
    $email = str_replace("&", "&amp;", $email);

    if($item == "")
	{
        $item = "email='$email'";
    }
	else
	{
        $item .= ", email='$email'";
    }
}

if(isset($_POST['brand']) && $_POST['brand'] != undefined)
{
    $brand = sqlite3::escapeString($_POST['brand']);
    $brand = str_replace("&", "&amp;", $brand);

    if($item == "")
	{
        $item = "brand='$brand'";
    }
	else
	{
        $item .= ", brand='$brand'";
    }
}

if(isset($_POST['representative']) && $_POST['representative'] != undefined)
{
	$representative = sqlite3::escapeString($_POST['representative']);
    $representative = str_replace("&", "&amp;", $representative);

    if($item == "")
	{
        $item = "representative='$representative'";
    }
	else
	{
        $item .= ", representative='$representative'";
    }
}

if(isset($_POST['touji']) && $_POST['touji'] != undefined)
{
	$touji = sqlite3::escapeString($_POST['touji']);
    $touji = str_replace("&", "&amp;", $touji);

    if($item == "")
	{
        $item = "touji='$touji'";
    }
	else
	{
        $item .= ", touji='$touji'";
    }
}

if(isset($_POST['establishment']) && $_POST['establishment'] != undefined)
{
	$establishment = sqlite3::escapeString($_POST['establishment']);
	$other_year = sqlite3::escapeString($_POST['other_year']);
    $other_year = str_replace("&", "&amp;", $other_year);

	if($establishment == "9999")
	{
		if($other_year != undefined && $other_year != "")
			$establishment .= ','.$other_year;
	}

    if($item == "")
	{
        $item = "establishment='$establishment'";
    }
	else
	{
        $item .= ", establishment='$establishment'";
    }
}

if(isset($_POST['award_history']) && $_POST['award_history'] != undefined)
{
	$award_history = sqlite3::escapeString($_POST['award_history']);

    if($item == "")
	{
        $item = "award_history='$award_history'";
    }
	else
	{
        $item .= ", award_history='$award_history'";
    }
}

if(isset($_POST['observation']) && $_POST['observation'] != undefined)
{
	$observation = sqlite3::escapeString($_POST['observation']);

    if($item == "")
	{
        $item = "observation='$observation'";
    }
	else
	{
        $item .= ", observation='$observation'";
    }
}

if(isset($_POST['observatory_info']) && $_POST['observatory_info'] != undefined)
{
	$observatory_info = sqlite3::escapeString($_POST['observatory_info']);
    $observatory_info = str_replace("&", "&amp;", $observatory_info);

    if($item == "")
	{
        $item = "observatory_info='$observatory_info'";
    }
	else
	{
        $item .= ", observatory_info='$observatory_info'";
    }
}

if(isset($_POST['direct_sale']) && $_POST['direct_sale'] != undefined)
{
	$direct_sale = sqlite3::escapeString($_POST['direct_sale']);
    $direct_sale = str_replace("&", "&amp;", $direct_sale);

    if($item == "")
	{
        $item = "direct_sale='$direct_sale'";
    }
	else
	{
        $item .= ", direct_sale='$direct_sale'";
    }
}

if(isset($_POST['payment_method']) && $_POST['payment_method'] != undefined)
{
	$payment_method = sqlite3::escapeString($_POST['payment_method']);
    $payment_method = str_replace("&", "&amp;", $payment_method);

    if($item == "")
	{
        $item = "direct_sale='$payment_method'";
    }
	else
	{
        $item .= ", payment_method='$payment_method'";
    }
}

if(isset($_POST['kumiai']) && $_POST['kumiai'] != undefined)
{
	$kumiai = sqlite3::escapeString($_POST['kumiai']);

    if($item == "")
	{
        $item = "kumiai='$kumiai'";
    }
	else
	{
        $item .= ", kumiai='$kumiai'";
    }
}

if(isset($_POST['kokuzei']) && $_POST['kokuzei'] != undefined)
{
	$kokuzei = sqlite3::escapeString($_POST['kokuzei']);

    if($item == "")
	{
        $item = "kokuzei='$kokuzei'";
    }
	else
	{
        $item .= ", kokuzei='$kokuzei'";
    }
}

if(isset($_POST['status']) && $_POST['status'] != undefined)
{
	$status = sqlite3::escapeString($_POST['status']);

    if($item == "")
	{
        $item = "status='$status'";
    }
	else
	{
        $item .= ", status='$status'";
    }
}

if(isset($_POST['memo']) && $_POST['memo'] != undefined)
{
	$memo = sqlite3::escapeString($_POST['memo']);
    $memo = str_replace("&", "&amp;", $memo);

    if($item == "")
	{
        $item = "memo='$memo'";
    }
	else
	{
        $item .= ", memo='$memo'";
    }
}

if(isset($_POST['data_source']) && $_POST['data_source'] != undefined)
{
	$data_source = sqlite3::escapeString($_POST['data_source']);
    $data_source = str_replace("&", "&amp;", $data_source);

    if($item == "")
	{
        $item = "data_source='$data_source'";
    }
	else
	{
        $item .= ", data_source='$data_source'";
    }
}

if(isset($_POST['LastContacted']) && $_POST['LastContacted'] != undefined)
{
    //$LastContacted = str_replace("%", "\%", sqlite3::escapeString($LastContacted));
	$LastContacted = sqlite3::escapeString($_POST['LastContacted']);
    $LastContacted = str_replace("&", "&amp;", $LastContacted);

    if($item == "")
	{
        $item = "LastContacted='$LastContacted'";
    }
	else
	{
        $item .= ", LastContacted='$LastContacted'";
    }
}

if(isset($_POST['sakagura_develop']) && $_POST['sakagura_develop'] != undefined)
{
	$sakagura_develop = sqlite3::escapeString($_POST['sakagura_develop']);

    if($item == "")
	{
		if($sakagura_develop == "0")
			$item = "sakagura_develop=NULL";
		else
			$item = "sakagura_develop='$sakagura_develop'";
    }
	else
	{
		if($sakagura_develop == "0")
			$item .= ", sakagura_develop=NULL";
		else
			$item .= ", sakagura_develop='$sakagura_develop'";
    }
}

$in_time = time();

if($item == "")
{
    $item = "date_updated='$in_time'";
}
else
{
    $item .= ", date_updated='$in_time'";
}

$sql = "UPDATE SAKAGURA_J SET ".$item." WHERE id = '$id'";
$res = executequery($db, $sql);

if(!$res)   
{
	$return = "failed";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
}
else
{
	$return = "success";
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo ' <str>'.$return.'</str>'."\n";
	echo ' <sql>'.$sql.'</sql>'."\n";
	echo '</xml>'."\n";
}
?>
