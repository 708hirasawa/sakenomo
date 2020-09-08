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

$syuhanten = $_POST['syuhanten'];
$syuhanten_id = $_POST['syuhanten_id'];
$syuhanten_rank = $_POST['syuhanten_rank'];
$syuhanten_type = $_POST['syuhanten_type'];
$syuhanten_country = $_POST['syuhanten_country'];
$syuhanten_pref = $_POST['pref'];
$syuhanten_pref_read = $_POST['pref_read'];
$syuhanten_region = get_region($syuhanten_pref);
$syuhanten_name = $_POST['syuhanten_name'];
$syuhanten_search = $_POST['syuhanten_search'];
$syuhanten_read = $_POST['syuhanten_read'];
$syuhanten_english = $_POST['syuhanten_english'];
$syuhanten_sort = $_POST['syuhanten_sort'];
$syuhanten_intro = $_POST['syuhanten_intro'];
$syuhanten_postal_code = $_POST['syuhanten_postal_code'];
$syuhanten_address = $_POST['syuhanten_address'];
$syuhanten_phone = $_POST['syuhanten_phone'];
$syuhanten_fax = $_POST['syuhanten_fax'];
$syuhanten_url = $_POST['syuhanten_url'];
$syuhanten_email = $_POST['syuhanten_email'];

$syuhanten_hours = $_POST['syuhanten_hours'];
$syuhanten_closed = $_POST['syuhanten_closed'];
$syuhanten_parking = $_POST['syuhanten_parking'];
$syuhanten_sake = $_POST['syuhanten_sake'];
$syuhanten_memo = $_POST['syuhanten_memo'];
$syuhanten_datasource = $_POST['syuhanten_datasource'];
$syuhanten_lastcontacted = $_POST['syuhanten_lastcontacted'];


if(!$db = opendatabase("sake.db"))
{
	die("データベース接続エラー.<br />");
}

//$sql = "select max(syuhanten_id) from syuhanten_j";
$sql = "select syuhanten_id from syuhanten_j where syuhanten_id = (select max(syuhanten_id) from syuhanten_j)";
//$sql = "select syuhanten_id from syuhanten_j where syuhanten_id = (select max(syuhanten_id) from syuhanten_j where syuhanten_region = '$syuhanten_region' AND syuhanten_pref = '$syuhanten_pref')";

$res = executequery($db, $sql);
$row = getnextrow($res);

if($row) 
{
	$number = substr(strrchr($row["syuhanten_id"], S), 3);
	$counter = intval($number) + 1;
	$sequence = "S10".$counter;

	$sql = "INSERT INTO SYUHANTEN_J(syuhanten, 
						                      syuhanten_id, 
						                      syuhanten_rank, 
						                      syuhanten_type, 
						                      syuhanten_country, 
						                      syuhanten_region, 
						                      syuhanten_pref, 
						                      syuhanten_pref_read, 
						                      syuhanten_name, 
						                      syuhanten_search,
						                      syuhanten_read,
											  syuhanten_english,		
						                      syuhanten_sort,
						                      syuhanten_intro,
						                      syuhanten_postal_code, 
						                      syuhanten_address, 
						                      syuhanten_phone, 
						                      syuhanten_fax, 
						                      syuhanten_url, 
						                      syuhanten_email, 
						                      syuhanten_hours, 
						                      syuhanten_closed, 
						                      syuhanten_parking, 
						                      syuhanten_sake, 
						                      syuhanten_memo, 
						                      syuhanten_datasource,
						                      syuhanten_lastcontacted)
                                  VALUES('$syuhanten', 
                                         '$sequence', 
                                         '$syuhanten_rank', 
                                         '$syuhanten_type', 
                                         '$syuhanten_country', 
                                         '$syuhanten_region', 
                                         '$syuhanten_pref', 
                                         '$syuhanten_pref_read', 
                                         '$syuhanten_name', 
                                         '$syuhanten_search', 
                                         '$syuhanten_read', 
										 '$syuhanten_english',
                                         '$syuhanten_sort', 
                                         '$syuhanten_intro', 
                                         '$syuhanten_postal_code', 
                                         '$syuhanten_address', 
                                         '$syuhanten_phone', 
                                         '$syuhanten_fax', 
                                         '$syuhanten_url', 
                                         '$syuhanten_email', 
                                         '$syuhanten_hours', 
                                         '$syuhanten_closed', 
                                         '$syuhanten_parking', 
                                         '$syuhanten_sake', 
                                         '$syuhanten_memo', 
                                         '$syuhanten_datasource', 
                                         '$syuhanten_lastcontacted')";

  $res = executequery($db, $sql);
  
  if(!$res)   
  {
      $return = "failed1:".$sql;

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
	$return = "failed2:".$sql;
	
	header("Content-type: application/xml");
	echo '<?xml version="1.0" encoding="utf-8" ?> ' . "\n";
	echo '<xml>'."\n";
	echo '<str>'.$return.'</str>'."\n";
	echo '</xml>'."\n";
}
?>
