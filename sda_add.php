<?php

require_once("db_functions.php");

$pref_array = array(
	array("北海道", "北海道地方"),
	array("青森県", "東北地方"),
	array("岩手県", "東北地方"),
	array("宮城県", "東北地方"),
	array("秋田県", "東北地方"),
	array("山形県", "東北地方"),
	array("福島県", "東北地方"),
	array("茨城県", "東北地方"),
	array("栃木県", "関東地方"),
	array("群馬県", "関東地方"),
	array("埼玉県", "関東地方"),
	array("千葉県", "関東地方"),
	array("東京都", "関東地方"),
	array("神奈川県", "関東地方"),
	array("新潟県", "中部地方"),
	array("富山県", "中部地方"),
	array("石川県", "中部地方"),
	array("福井県", "中部地方"),
	array("山梨県", "中部地方"),
	array("長野県", "中部地方"),
	array("岐阜県", "中部地方"),
	array("静岡県", "中部地方"),
	array("愛知県", "中部地方"),
	array("三重県", "近畿地方"),
	array("滋賀県", "近畿地方"),
	array("京都府", "近畿地方"),
	array("大阪府", "近畿地方"),
	array("兵庫県", "近畿地方"),
	array("奈良県", "近畿地方"),
	array("和歌山県", "近畿地方"),
	array("鳥取県", "中国地方"),
	array("島根県", "中国地方"),
	array("岡山県", "中国地方"),
	array("広島県", "中国地方"),
	array("山口県", "中国地方"),
	array("徳島県", "四国地方"),
	array("香川県", "四国地方"),
	array("愛媛県", "四国地方"),
	array("高知県", "四国地方"),
	array("福岡県", "九州地方"),
	array("佐賀県", "九州地方"),
	array("長崎県", "九州地方"),
	array("熊本県", "九州地方"),
	array("大分県", "九州地方"),
	array("宮城県", "九州地方"),
	array("鹿児島県", "九州地方"),
	array("沖縄県", "九州地方"));

$length = count($pref_array);

function get_region($pref)
{
	$len = count($pref_array);
	$ret = "";
	$i = 0;

	for($i = 0; $i < $len; $i++)
	{
		if($pref == $pref_array[$i][0])
		{
			$ret = $pref_array[$i][1];
			break;
		}
	}
	
	return $ret;
}

$id = $_POST['id'];
$pref = $_POST['pref'];
//$rank = $_POST['rank'];
//$country = $_POST['country'];
//$region_name = $_POST['region_name'];
//$sakagura = $_POST['sakagura'];

$sakagura = "1";
$rank = "0";
$country = "日本";
$region_name = get_region($pref);

$len = count($pref_array);
$i = 0;

for($i = 0; $i < $len; $i++)
{
	if($pref == $pref_array[$i][0])
	{
		$region_name = $pref_array[$i][1];
		break;
	}
}

$pref_read = $_POST['pref_read'];

$sakagura_name = sqlite3::escapeString($_POST['sakagura_name']);

$sakagura_search = "";

if(!empty($_POST['sakagura_search']))
{
	foreach($_POST['sakagura_search'] as $selected)
	{
		if($sakagura_search == "")
			$sakagura_search = $selected;
		else			
			$sakagura_search .= "," .$selected;
	}	
}

$url = "";

if(!empty($_POST['url']))
{
	foreach($_POST['url'] as $selected)
	{
		if($url == "")
			$url = $selected;
		else			
			$url .= "," .$selected;
	}	
}

$sakagura_read = sqlite3::escapeString($_POST['sakagura_read']);
$sakagura_english = sqlite3::escapeString($_POST['sakagura_english']);
$sakagura_intro = sqlite3::escapeString($_POST['sakagura_intro']);
$postal_code = $_POST['postal_code'];
$address = sqlite3::escapeString($_POST['address']);
$phone = $_POST['phone'];
$fax = $_POST['fax'];
$email = $_POST['email'];
$brand = $_POST['brand'];
$representative = $_POST['representative'];
$other_year = $_POST['other_year'];
$touji = $_POST['touji'];
$establishment = $_POST['establishment'];
$award_history = $_POST['award_history'];
$observation = $_POST['observation'];
$observatory_info = $_POST['observatory_info'];
$direct_sale = $_POST['direct_sale'];
$payment_method = $_POST['payment_method'];
$memo = sqlite3::escapeString($_POST['memo']);

if($establishment == "9999")
{
	if($other_year != undefined && $other_year != "")
		$establishment .= ','.$other_year;
}

if(!$db = opendatabase("sake.db"))
{
	die("データベース接続エラー.<br />");
}

//$sql = "select max(id) from sakagura_j";
//$sql = "select id from sakagura_j where id = (select max(id) from sakagura_j)";

$sql = "select id from sakagura_j where id = (select max(id) from sakagura_j where pref = '$pref')";
$res = executequery($db, $sql);
$row = getnextrow($res);

if($row) 
{
    $number = substr(strrchr($row["id"], B), 3);
    $counter = intval($number) + 1;
    $sequence = "B10".$counter;

    //$sql = "INSERT INTO SAKAGURA_J VALUES('$sakagura', 

    $sql = "INSERT INTO SAKAGURA_J(sakagura, 
			                        id, 
			                        rank, 
			                        country, 
			                        region_name, 
			                        pref, 
			                        pref_read, 
			                        sakagura_name, 
			                        sakagura_search, 
			                        sakagura_read, 
									sakagura_english,
			                        sakagura_intro, 
			                        postal_code, 
			                        address, 
			                        phone, 
			                        fax, 
			                        url, 
			                        email, 
			                        brand, 
			                        representative, 
			                        touji,
			                        establishment, 
			                        award_history, 
			                        observation, 
			                        observatory_info,
			                        direct_sale, 
			                        payment_method, 
			                        memo) VALUES(
                                    '$sakagura', 
                                    '$sequence', 
                                    '$rank', 
                                    '$country', 
                                    '$region_name', 
                                    '$pref', 
                                    '$pref_read', 
                                    '$sakagura_name', 
                                    '$sakagura_search', 
                                    '$sakagura_read', 
                                    '$sakagura_english', 
                                    '$sakagura_intro', 
                                    '$postal_code', 
                                    '$address', 
                                    '$phone', 
                                    '$fax', 
                                    '$url', 
                                    '$email', 
                                    '$brand', 
                                    '$representative', 
                                    '$touji', 
                                    '$establishment', 
                                    '$award_history', 
                                    '$observation', 
                                    '$observatory_info', 
                                    '$direct_sale', 
                                    '$payment_method', 
                                    '$memo')";

    $res = executequery($db, $sql);
    
	//or die("登録できませんでした。この酒蔵ID:" .$sequence ."はすでに登録されています。<br /><a href=\"sake_search.php\">検索画面に戻る</a><br /></body></html>");
    //print("登録しました｡ ID:".$sequence .":done<br>");

    if(!$res)   
    {
	    $return = "failed1:".$sql ." max:".$row["id"] ." new id:".$sequence;
    	
	    header("Content-type: application/xml");
	    echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	    echo '<xml>'."\n";
	    echo '<str>'.$return.'</str>'."\n";
	    echo '</xml>'."\n";
    }
    else
    {
        $return = "success";

        header("Content-type: application/xml");
        echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
        echo '<xml>'."\n";
        echo '<str>'.$return.'</str>'."\n";
        echo '<id>'.$sequence.'</id>'."\n";
        echo '</xml>'."\n";
    }
}
else
{
	$val = ($pref_array[12][0] == $pref);
	$region_name = "yamaguchi";
	$i = 0;
	$len = count($pref_array);

	for($i = 0; $i < $len; $i++)
	{
		if($pref == $pref_array[$i][0])
		{
			$region_name = $pref_array[12][1];
			$region_name = "samurai";
			break;
		}
		else
		{
			$region_name = $pref_array[$i][0];
		}
	}

	//$region_name = $pref_array[12][1];
	//$return = "failed2:".$pref_array[12][1]."SQL:".$sql." count:".$length ." val:".$val." region_name:".$region_name;
	$return = "failed2:"."SQL:".$sql;
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
?>
