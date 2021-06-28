<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("nonda.php");
require_once("searchbar.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta content='width=device-width, initial-scale=1, user-scalable=0' name='viewport'/>
	<title>酒蔵ページ [Sakenomo]</title>
	<link rel="stylesheet" href="slick/slick-theme.css">
	<link rel="stylesheet" href="slick/slick.css">
	<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/sda_view.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="slick/slick.min.js"></script>
	<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>" charset="Shift-JIS"></script>
	<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
</head>

<body>

<?php
include_once('images/icons/svg_sprite.svg');
write_side_menu();
write_HamburgerLogo();
write_search_bar();
write_Nonda();

$id = $_GET['id'];
$username = $_COOKIE['login_cookie'];

if(!$db = opendatabase("sake.db"))
{
  die("データベース接続エラー .<br />");
}

$sql = "SELECT COUNT(*) FROM FOLLOW_J WHERE sakagura_id = '$id'";
$res = executequery($db, $sql);
$record = getnextrow($res);
$count_result = $record["COUNT(*)"];

$sql = "SELECT * FROM SAKAGURA_J WHERE id = '$id'";
$res = executequery($db, $sql);
$row = getnextrow($res);
$sakagura_name = "";

function link_it($text) {
	$pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/u';
	$replacement = '<a href="\1" target=\"_blank\">\1</a>';
	$text= preg_replace($pattern, $replacement, $text);
	return $text;
}

function GetSakaguraType($code)
{
	$value = "--";

	if($code == "1")
	{
		$value = "S";
	}
	else if($code == "2")
	{
		$value = "A";
	}
	else if($code == "3")
	{
		$value = "B";
	}
	else if($code == "4")
	{
		$value = "C";
	}
	else if($code == "5")
	{
		$value = "D";
	}
	else if($code == "6")
	{
		$value = "E";
	}
	else if($code == "7")
	{
		$value = "X";
	}

  return $value;
}

function GetSakeSpecialName($special_name)
{
	$special_name_array = explode(',', $special_name);
	$sake_code = $special_name_array[0];

	if($sake_code == "11")
	{
		$retval = "普通酒";
		return $retval;
	}
	else if($sake_code == "21")
	{
		$retval = "本醸造酒";
		return $retval;
	}
	else if($sake_code == "22")
	{
		$retval = "特別本醸造酒";
		return $retval;
	}
	else if($sake_code == "31")
	{
		$retval = "純米酒";
		return $retval;
	}
	else if($sake_code == "32")
	{
		$retval = "特別純米酒";
		return $retval;
	}
	else if($sake_code == "33")
	{
		$retval = "純米吟醸酒";
		return $retval;
	}
	else if($sake_code == "34")
	{
		$retval = "純米大吟醸酒";
		return $retval;
	}
	else if($sake_code == "43")
	{
		$retval = "吟醸酒";
		return $retval;
	}
	else if($sake_code == "44")
	{
		$retval = "大吟醸酒";
		return $retval;
	}
	else if($sake_code == "45")
	{
		$retval = "非公開";
		return $retval;
	}
	else if($sake_code == "90")
	{
		$retval = $special_name_array[1];
		return $retval;
	}
	else if($sake_code == "99")
	{
		$retval = "";
		return $retval;
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

?>
<?php
print('<div id="fb-root"></div><script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v10.0" nonce="oqvO6VAM"></script>');

print('<div id="container"
              data-id=' .$id
              .' data-contributor="' .$username
              .'">');
	if($row) {
		print('<input type="hidden" id="hidden_title"				value="'  .stripslashes($row["sakagura_name"]) .'">');
		print('<input type="hidden" id="region_name"				value="'  .$row["region_name"] .'">');
		print('<input type="hidden" id="hidden_pref_read"			value="'  .$row["pref_read"] .'">');
		print('<input type="hidden" id="hidden_id"					value="'  .$id .'">');
		print('<input type="hidden" id="hidden_data_type"			value="sakagura">');
		print('<input type="hidden" id="hidden_sakagura"			value="' .$row["sakagura"] .'">');
		print('<input type="hidden" id="hidden_sakagura_search"		value="' .$row["sakagura_search"]		.'">');
		print('<input type="hidden" id="hidden_sakagura_develop"	value="' .$row["sakagura_develop"]	.'">');
		print('<input type="hidden" id="hidden_rank"				value="' .$row["rank"]							.'">');
		print('<input type="hidden" id="hidden_kumiai"				value="' .$row["kumiai"]							.'">');
		print('<input type="hidden" id="hidden_kokuzei"				value="' .$row["kokuzei"]							.'">');
		print('<input type="hidden" id="hidden_status"				value="' .$row["status"]							.'">');
		print('<input type="hidden" id="hidden_establishment"		value="' .$row["establishment"]			.'">');
		print('<input type="hidden" id="hidden_url"					value="' .$row["url"]								.'">');

		print('<input type="hidden" id="in_disp_from" value=0>');
		print('<input type="hidden" id="in_disp_to" value=25>');

		////////////////////////////////////////
    print('<div id="panelheader">');
      print('<div id="sakagura_name">'.stripslashes($row["sakagura_name"]).'</div>');

		if($row["sakagura_english"] && $row["sakagura_english"] != "")
			print('<div id="sakagura_english">'.stripslashes($row["sakagura_english"]).'</div>');

      print('<ul class="sakagura_info">');
        // 住所
        print('<li>');
          print('<span><svg class="sakagura_info_map1216"><use xlink:href="#map1216"/></svg></span>');
          if($row["pref"] || $row["adress"]) {
            print('<span id="pref">'.$row["pref"].'</span>');
            print('<span id="address">'.stripslashes($row["address"]).'</span>');
          } else {
            print('--');
          }
        print('</li>');
        // 電話番号
        print('<li>');
          print('<span><svg class="sakagura_info_telephone1616"><use xlink:href="#telephone1616"/></svg></span>');
          print('<span id="phone">');
            if($row["phone"]) {
              print($row["phone"]);
            } else {
              print('<span style="color: #b2b2b2;">--</span>');
            }
          print('</span>');
        print('</li>');
        // 代表銘柄
        print('<li>');
          print('<span><svg class="sakagura_info_bottle1616"><use xlink:href="#bottle1616"/></svg>代表銘柄</span>');
          print('<span id="brand">');
            if($row["brand"]) {
              print($row["brand"]);
            } else {
              print('<span style="color: #b2b2b2;">--</span>');
            }
          print('</span>');
        print('</li>');
        // 蔵見学情報
        print('<li>');
          print('<span><svg class="sakagura_info_visit1616"><use xlink:href="#visit1616"/></svg>酒蔵見学</span>');
          print('<span id="observation">');
            if($row["observation"] == 1) {
              print('可');
            } else if($row["observation"] == 2) {
              print('不可');
            } else {
              print('<span style="color: #b2b2b2;">--</span>');
            }
          print('</span>');
        print('</li>');
        // お気に入り酒蔵
        print('<li>');
          print('<span><svg class="sakagura_info_people1616"><use xlink:href="#people1616"/></svg>お気に入り</span>');
          print('<span id="favorite_sakagura_count">');
            if($count_result) {
              print($count_result);
            } else {
              print('<span style="color: #b2b2b2;">--</span>');
            }
          print('</span>');
        print('</li>');
      print("</ul>");

      print('<ul class="sakagura_buttons">');
        $result = executequery($db, "SELECT * FROM FOLLOW_J WHERE username = '$username' AND sakagura_id = '$id'");

        if($rd = getnextrow($result))
        {
          print('<li id="follow" style="background:linear-gradient(#EDCACA, #ffffff); border:1px solid #FF4545; transition: 0.3s" value=true><svg class="sakagura_buttons_pin1616" style="fill:#FF4545; transition: 0.3s;"><use xlink:href="#pin1616"/></svg>お気に入り</li>');
        }
        else
        {
          print('<li id="follow" value=false><svg class="sakagura_buttons_pin1616"><use xlink:href="#pin1616"/></svg>お気に入り</li>');
        }

      print("</ul>");
    print("</div>");

    print('<div id="main_banner_container">');
      print('<div id="mainframe">');
        // tabs
        print('<div id="tab_main">');
          print('<ul class="simpleTabs">');
            print('<li><a class="active" href="#tab-sake"><span><svg class="simpleTabs_product3630"><use xlink:href="#product3630"/></svg><span>商品</span></span></a></li>');
            print('<li><a href="#tab-map"><span><svg class="simpleTabs_map2430"><use xlink:href="#map2430"/></svg><span>地図</span></span></a></li>');
          print('</ul>');

          $result = executequery($db, "SELECT * FROM SAKE_J WHERE sakagura_id = '$id'");
          ////////////////////////////////////////
          print('<div id="tab-sake" class="form-action show">');

            $count_result = 0;

            $sql = "SELECT COUNT(*) FROM SAKE_J, SAKAGURA_J WHERE SAKE_J.sakagura_id = SAKAGURA_J.id AND SAKAGURA_J.id = '$id'";
            $result = executequery($db, $sql);

            if($result)
            {
              $rd = getnextrow($result);
              $count_result = $rd["COUNT(*)"];
            }

            $numPage = ($count_result % 25) ? ($count_result / 25) + 1 : $count_result / 25;

            print('<input type="hidden" id="hidden_sake_count_query" value=' .$count_result .'>');

            /* query */
            $in_disp_from = 0;
            $in_disp_to = 25;

            $sql = "SELECT * FROM SAKE_J, SAKAGURA_J WHERE SAKE_J.sakagura_id = SAKAGURA_J.id AND SAKAGURA_J.id = '$id' ORDER BY SAKE_J.sake_read ASC LIMIT $in_disp_from, $in_disp_to";
            //$sql = "SELECT * FROM SAKE_J, SAKAGURA_J WHERE SAKE_J.sakagura_id = SAKAGURA_J.id AND SAKAGURA_J.id = '$id' ORDER BY SAKE_J.write_update DESC LIMIT $in_disp_from, $in_disp_to";
            //print("<div>sql:".$sql."</div>");

            $result = executequery($db, $sql);
            $in_disp_from = 0;
            $p_max = 25;
            $i = 0;

            ////////////////////////////////////////

            ////////////////////////////////////////
            if($count_result > 0) {
              print('<div class="product_sort_container">');
                /*print('<div class="user_drop_down">');
                  print('<div class="sake_search_icon"><svg class="sake_search_search2020"><use xlink:href="#search2020"/></svg></div>');

                  print('<div class="drop_down_select_container">');

                    print('<select id="special_name_option" class="sake_selection" >');
                      print('<OPTION value="">特定名称</OPTION>');
                      print('<OPTION value="11">普通酒</OPTION>');
                      print('<OPTION value="21">本醸造酒</OPTION>');
                      print('<OPTION value="22">特別本醸造酒</OPTION>');
                      print('<OPTION value="31">純米酒</OPTION>');
                      print('<OPTION value="32">特別純米酒</OPTION>');
                      print('<OPTION value="33">純米吟醸酒</OPTION>');
                      print('<OPTION value="34">純米大吟醸酒</OPTION>');
                      print('<OPTION value="43">吟醸酒</OPTION>');
                      print('<OPTION value="44">大吟醸酒</OPTION>');
                      print('<OPTION value="90">その他</OPTION>');
                    print('</select>');

                    print('<div class="sake_option_trigger"><span class="drop_down_select_title" name="special_name" value=""></span></div>');

                  print("</div>");
                print("</div>");*/

                print('<div class="click_sort">');
                  print('<div class="sakagura_product_sort_icon"><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>');
                  print('<div value="sake_read" class="click_sort_read">標準</div>');
                  //print('<div value="write_date" class="click_sort_date">更新日</div>');
                  //print('<div value="write_date" class="click_sort_ranking">ランキング</div>');
                print('</div>');
              print('</div>');

              print('<div class="product_count_container">');
                if($count_result > $p_max) {
                  $p_next = $p_max;

                  if(($p_max + 25) > $count_result) {
                    $p_next = $count_result - $p_max;
                  }

                  print('<span id="disp_sake" class="navigate_page">'. ($in_disp_from + 1) .'～' .$p_max .'件 / 全' .$count_result .'件</span>');
                }
                else
                {
                  if($count_result < $p_max)
                  {
                    $p_max = $count_result;
                  }

                  print('<span id="disp_sake" class="navigate_page">'. ($in_disp_from + 1) .'～' .$p_max .'件 / 全' .$count_result .'件</span>');
                }
              print('</div>');//product_count_container
              ////////////////////////////////////////
              print('<div id="search_sake_result">');

                while($record = getnextrow($result))
                {
                  $sake_id = $record["sake_id"];
                  print('<a class="searchRow_link" href="sake_view.php?sake_id=' .$record["sake_id"] .'">');

                    $path = "images/icons/noimage160.svg";

                    //if($record["setting"] != "" && $record["setting"] != undefined)
                    //{
                    //  $path = "images/photo/thumb/" .$record["setting"];
                    //}
                    //else
                    {
						//$result_set = executequery($db, "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$record["sake_id"] ."' LIMIT 8");
						$result_set = executequery($db, "SELECT DISTINCT FILENAME, TABLE_NONDA.update_date FROM TABLE_NONDA, SAKE_IMAGE WHERE TABLE_NONDA.sake_id = '$sake_id' AND TABLE_NONDA.sake_id = SAKE_IMAGE.sake_id AND TABLE_NONDA.contributor = SAKE_IMAGE.contributor ORDER BY TABLE_NONDA.update_date DESC limit 2");

						if($rd = getnextrow($result_set))
						{
							$path = "images/photo/thumb/" .$rd["filename"];
						}
                    }

                    print('<div class="search_sake_result_name_container">');
                      print('<div class="search_sake_result_thumb_sake"><img src="' .$path .'"></div>');
                      print('<div class="search_sake_result_sake_brewery_date_container">');
                        print('<div class="search_sake_name">' .stripslashes($record["sake_name"]) .'</div>');
                        print('<div class="search_sake_result_brewery_date_container">');
                          print('<div>'.$record["sakagura_name"].' / '.$record["pref"].'</div>');
                          print('<div class="search_sake_result_date">');
                            $intime = gmdate("Y/m/d", $record["write_update"] + 9 * 3600);
                            print($intime);
                          print('</div>');
                        print('</div>');
                      print('</div>');
                    print('</div>');
                    ////////////////////////////////////////
                    // 酒ランク

                    $sql = "SELECT AVG(rank) FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND (rank != 0 AND rank != '')";
                    $res_avg = executequery($db, $sql);
                    $rd_average = getnextrow($res_avg);

                    $avg_rank = $rd_average["AVG(rank)"];
                    $avg_percent = ($avg_rank / 5) * 100;

                    if(!$avg_percent || $avg_percent == "") {
                      $avg_percent = 0;
                      //$avg_rank = "no code";
                    }

                    print('<div class="sake_rank">');
                      print('<div class="sake_rank_star_rating">');
                        print('<div class="sake_rank_star_rating_front" style="width:' .$avg_percent .'%">★★★★★</div>');
                        print('<div class="sake_rank_star_rating_back">★★★★★</div>');
                      print('</div>');
                      if($avg_rank) {
                        print('<span class="sake_rank_sake_rate">' .number_format($avg_rank, 1) .'</span>');
                      } else {
                        print('<span class="sake_rank_sake_rate" style="color: #b2b2b2;">--</span>');
                      }
                    print('</div>');
                    ////////////////////////////////////////
                    print('<div class="spec">');

                      print('<div class="spec_item">');
                        print('<div class="spec_title"><svg class="spec_item_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg>特定名称</div>');
                        print('<div class="spec_info">');

	                        if($record["special_name"] && $record["special_name"] != "") {
	                          print(GetSakeSpecialName($record["special_name"]));
	                        } else {
	                          print('<span style="color: #b2b2b2;">--</span>');
	                        }

                        print('</div>');
                      print('</div>');
                      ////////////////////////////////////////
                      print('<div class="spec_item">');
                        print('<div class="spec_title"><svg class="spec_item_alc1616"><use xlink:href="#alc1616"/></svg>Alc度数</div>');
                        print('<div class="spec_info">');

                          $alcohol_array = explode(',', $record["alcohol_level"]);

                          if($alcohol_array[0] != null && $alcohol_array[1] != null) {
                            if($alcohol_array[0] == $alcohol_array[1]) {
                              print($alcohol_array[0].'%');
                            } else {
                              print($alcohol_array[0] .'～'.$alcohol_array[1].'%');
                            }
                          } else if($alcohol_array[0] != null && $alcohol_array[1] == null) {
                            print($alcohol_array[0] .'%');
                          } else {
                            print('<span style="color: #b2b2b2;">--</span>');
                          }

                        print("</div>");
                      print("</div>");
                      ////////////////////////////////////////
                      print('<div class="spec_item">');
                        print('<div class="spec_title"><svg class="spec_item_rice1616"><use xlink:href="#rice1616"/></svg>原料米</div>');
                        print('<div class="spec_info">');

                          if($record["rice_used"] && $record["rice_used"] != "") {
                            $rice_array = explode('/', $record["rice_used"]);
                            for($i = 0; $i < count($rice_array); $i++) {
                              $rice_entry = explode(',', $rice_array[$i]);

                              if($i > 0 && $rice_entry[0] != "") {
                                print(" / ");
                              }

                              $sql = "SELECT SAKE_RICE.rice_name, SAKE_RICE.rice_kanji, SAKE_RICE.rice_kana FROM SAKE_RICE WHERE SAKE_RICE.rice_name = '$rice_entry[0]'";
                              $sake_result = executequery($db, $sql);
                              $rd = getnextrow($sake_result);

                              if($rice_entry[1] == "1") {
                                print("麹米:");
                              } else if($rice_entry[1] == "2") {
                                print("掛米:");
                              }

                              if($rice_entry[0] != "") {
                                if($rice_entry[0] == "other") {
                                  print($rice_entry[3]);
                                } else {
                                  $rice_kanji = $record ? $rd["rice_kanji"] : $rice_used;
                                  print($rice_kanji ." ");
                                }
                              }
                            }
                          } else {
                            print('<span style="color: #b2b2b2;">--</span>');
                          }

                        print("</div>");
                      print("</div>");
                      ////////////////////////////////////////
                      print('<div class="spec_item">');
                        print('<div class="spec_title"><svg class="spec_item_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg>精米歩合</div>');
                        print('<div class="spec_info">');

                          $rice_array = explode('/', $record["rice_used"]);
                          $seimai_array = explode(',', $record["seimai_rate"]);

                          if($seimai_array[0] || $seimai_array[1] || $seimai_array[2]) {
                            for($i = 0; $i < count($seimai_array); $i++) {
                              if($i > 0 && $seimai_array[$i] != "") {
                                print(" / ");
                              }

                              if(count($rice_array) > 0 && $i < count($rice_array)) {
                                $rice_entry = explode(',', $rice_array[$i]);
                                if($rice_entry[1] == "1") {
                                  print("麹米:");
                                } else if($rice_entry[1] == "2") {
                                  print("掛米:");
                                }
                              }

                              if($seimai_array[$i] != "")
                                print($seimai_array[$i]."%");
                            }
                          } else {
                            print('<span style="color: #b2b2b2;">--</span>');
                          }

                        print("</div>");
                      print("</div>");
                      ////////////////////////////////////////
                      print('<div class="spec_item">');
                        print('<div class="spec_title"><svg class="spec_item_nihonshudo1616"><use xlink:href="#nihonshudo1616"/></svg>日本酒度</div>');
                        print('<div class="spec_info">');

                          $syudo_array = explode(',', $record["jsake_level"]);
                          if($syudo_array[0] != null && $syudo_array[1] != null) {
                            if($syudo_array[0] == $syudo_array[1]) {
                              print(number_format($syudo_array[0], 1));
                            } else {
                              print(number_format($syudo_array[0], 1) .'～'.number_format($syudo_array[1], 1));
                            }
                          } else if($syudo_array[0] != null && $syudo_array[1] == null) {
                            print(number_format($syudo_array[0], 1));
                          } else {
                            print('<span style="color: #b2b2b2;">--<span>');
                          }

                        print("</div>");
                      print("</div>");
                      ////////////////////////////////////////

                    print("</div>");	// spec
                  print("</a>");	// searchRow_link
                  $i++;
                }
              print('</div>'); // search_sake_result

              ////////////////////////////////////////
              print('<div class="search_result_turn_page">');

					if($count_result > 25) {
						print('<button id="prev_sakagura_sake"><svg class="prev_button_prev2020"><use xlink:href="#prev2020"/></svg></button>');
						$i = 1;

						print('<button class="pageitems" style="background:#22445B; color:#ffffff">' .$i .'</button>');

						for($i++; $i <= $numPage; $i++)
						{
						    print('<button class="pageitems">' .$i .'</button>');
						}

						print('<button id="next_sakagura_sake"><svg class="next_button_next2020"><use xlink:href="#next2020"/></svg></button>');
					}

			  print("</div>");
            }
            else {
              print('<div class="navigate_page_no_registry">日本酒がまだ登録されていません</div>');
            }

          print("</div>"); // tab-sake

          ////////////////////////////////////////
          ////////////////////////////////////////

          $address = $row["pref"] ." " .$row["address"];
          //$address = $row["postal_code"] ." " .$row["pref"] ." " .$row["address"];

          print('<div id="tab-map" class="form-action hide">');
            print('<div class="sakagura_map_select">');
              print('<div class="sakagura_map_button_container">');
                print('<div class="sakagura_map_button"><svg class="sakagura_map_map1216"><use xlink:href="#map1216"/><div>'.stripslashes($row["sakagura_name"]).'</div></div>');
              print('</div>');
            print('</div>');
            print('<div id="sakagura_map">');
              print("<iframe class=\"map\" frameborder=\"0\" scrolling=\"yes\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.co.jp/maps?hl=&amp;ie=UTF8&amp;q=loc:".$address."&amp;z=18&amp;iwloc=B&amp;output=embed\"></iframe>");
            print('</div>');
          print('</div>');

        print('</div>'); // tab_main
        ////////////////////////////////////////
        ////////////////////////////////////////

        print('<div class="updatebar_container">');
          print('<div id="updatebar">');
			if($_COOKIE['login_cookie'] != "") {
              print('<a href="sda_add_form.php?id=' .$row["id"] .'&sakagura_name=' .$row["sakagura_name"] .'" id="update_sakagura"><svg class="update_sakagura_penplus2020"><use xlink:href="#penplus2020"/></svg>この酒蔵を編集</a>');
              print('<a href="sda_add_form.php" id="add_new_sakagura"><svg class="add_new_sakagura_pen1616"><use xlink:href="#pen1616"/></svg>新しい酒蔵を追加</a>');
            } else {
              print('<a href="user_login_form.php" id="update_sakagura"><svg class="update_sakagura_penplus2020"><use xlink:href="#penplus2020"/></svg>この酒蔵を編集</a>');
              print('<a href="user_login_form.php" id="add_new_sakagura"><svg class="add_new_sakagura_pen1616"><use xlink:href="#pen1616"/></svg>新しい酒蔵を追加</a>');
            }
          print('</div>');
        print('</div>');

        print('<div class="sns_buttons_container">');
          print('<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-text="'.stripslashes($row["sakagura_name"]).' / Sakenomo" data-lang="en" data-show-count="false"></a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>');
          print('<div class="fb-share-button" data-href="https://sakenomo.xsrv.jp/sakenomo/sda_view.php?id='.$sakagura_id.'" data-layout="button" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdrinksake.xsrv.jp%2Fhirasawa%2Fsake_view.php%3Fsake_id%3DA1010855763%23top&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"></a></div>');
          print('<div class="line-it-button" data-lang="ja" data-type="share-b" data-ver="3" data-url="https://sakenomo.xsrv.jp/sakenomo/sda_view.php?id='.$sakagura_id.'" data-color="default" data-size="small" data-count="false" style="display: none;"></div><script src="https://www.line-website.com/social-plugins/js/thirdparty/loader.min.js" async="async" defer="defer"></script>');
        print('</div>');

        ////////////////////////////////////////
        ////////////////////////////////////////
        print('<div id="sakagura_spec">');
          print('<div><svg class="detail2430"><use xlink:href="#detail2430"/></svg>詳細情報</div>');
          /* 詳細項目 */
          print('<div class="edittable">');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">酒蔵名</div><div class="sakaguracolumn2">' .$row["sakagura_name"] .'</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">住所</div>');
              print('<div class="sakaguracolumn2">');
                print('<div>');
                  print('<span>〒</span><span id="postal_code">');
                    if($row["postal_code"]) {
                      print($row["postal_code"]);
                    } else {
                      print('<span style="color: #b2b2b2;">--<span>');
                    }
                  print('</span>');
                  print('<span id="address">');
                    if($row["pref"] || $row["adress"]) {
                      print($row["pref"].stripslashes($row["address"]));
                    } else {
                      print('<span style="color: #b2b2b2;">--<span>');
                    }
                  print('</span>');
                print('</div>');
                print('<div id="sakagura_map2">');
                  print("<iframe class=\"map\" frameborder=\"0\" scrolling=\"yes\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.co.jp/maps?hl=&amp;ie=UTF8&amp;q=loc:".$address."&amp;z=18&amp;iwloc=B&amp;output=embed\"></iframe>");
                print('</div>');
              print('</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">TEL</div>');
              print('<div class="sakaguracolumn2" id="phone">');
                if($row["phone"]) {
                  print($row["phone"]);
                } else {
                  print('<span style="color: #b2b2b2;">--<span>');
                }
              print('</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">Email</div>');
              print('<div class="sakaguracolumn2" id="email">');
                if($row["email"]) {
                  print($row["email"]);
                } else {
                  print('<span style="color: #b2b2b2;">--<span>');
                }
              print('</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">URL</div>');
              print('<div class="sakaguracolumn2" id="url">');
                if($row["url"]) {
                  $url_array = explode(',', $row["url"]);
                  for($j = 0; $j < count($url_array); $j++)
                  {
                    print('<span><a href = "' .$url_array[$j] .'">' .$url_array[$j] .'</a></span>');
                  }
                } else {
                  print('<span style="color: #b2b2b2;">--<span>');
                }
              print('</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">創業・設立</div>');
              print('<div class="sakaguracolumn2" id="establishment">');
                $establishment = explode(',', $row["establishment"]);
                if($establishment[0] == 9999) {
                  print($establishment[1]);
                } else if($establishment[0] && $establishment[0] != "") {
                  print($establishment[0] .'年 (' .GetWareki($establishment[0]) .')');
                } else {
                  print('<span style="color: #b2b2b2;">--<span>');
                }
              print('</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">代表者</div>');
              print('<div class="sakaguracolumn2" id="representative">');
                if($row["representative"]) {
                  print($row["representative"]);
                } else {
                  print('<span style="color: #b2b2b2;">--<span>');
                }
              print('</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">杜氏</div>');
              print('<div class="sakaguracolumn2" id="touji">');
                if($row["touji"]) {
                  print($row["touji"]);
                } else {
                  print('<span style="color: #b2b2b2;">--<span>');
                }
              print('</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">代表銘柄</div>');
              print('<div class="sakaguracolumn2" id="brand2">');
                if($row["brand"]) {
                  print($row["brand"]);
                } else {
                  print('<span style="color: #b2b2b2;">--<span>');
                }
              print('</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">受賞歴</div>');
              print('<div class="sakaguracolumn2" id="award_history">');
                $row["award_history"] = nl2br($row["award_history"]);
                $row["award_history"] = stripslashes($row["award_history"]);
                if($row["award_history"]) {
                  print($row["award_history"]);
                } else {
                  print('<span style="color: #b2b2b2;">--<span>');
                }
              print('</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">酒蔵見学</div>');
              print('<div class="sakaguracolumn2" id="observation2">');
                if($row["observation"] == 1) {
                  print('可');
                } else if($row["observation"] == 2) {
                  print('不可');
                } else {
                  print('<span style="color: #b2b2b2;">--<span>');
                }

                if($row["observatory_info"] && $row["observatory_info"] != "")
                  print('<span>'.stripslashes($row["observatory_info"]).'</span>');
              print('</div>');
            print('</div>');

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">酒蔵直販店</div>');
              print('<div class="sakaguracolumn2" id="direct_sale">');
                if($row["direct_sale"] == 1) {
                  print('あり');
                } else if($row["direct_sale"] == 2) {
                  print('なし');
                } else {
                  print('<span style="color: #b2b2b2;">--<span>');
                }
              print('</div>');
            print('</div>');

          print('</div>');
        print('</div>');/*sakagura_spec*/
        ////////////////////////////////////////
        ////////////////////////////////////////
        /*print('<div class="spec_extra">');
          print('<div><svg class="detail2430"><use xlink:href="#detail2430"/></svg>管理人用</div>');
          // 管理人用
          print('<div class="edittable">');

            // 購入方法
            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">購入方法</div>');
              print('<div class="sakaguracolumn2" id="payment_method">'.$row["payment_method"].'</div>');
            print('</div>');

            // 酒蔵ID
            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">酒蔵ID</div>');
              print('<div class="sakaguracolumn2" id="sakagura_id">'.$row["id"].'</div>');
            print('</div>');

            // 酒蔵プライオリティ
            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">酒蔵プライオリティ</div>');
              print('<div class="sakaguracolumn2" id="sakagura_type">'.GetSakaguraType($row["sakagura"]).'</div>');
            print('</div>');

            // 酒造組合登録
            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">酒造組合登録</div>');
              print('<div class="sakaguracolumn2" id="kumiai">');

                if($row["kumiai"] == 10)
					print('あり');
                else if($row["kumiai"] == 11)
					print('なし');
                else if($row["kumiai"] == 12)
					print('不明');
                else
					print($row["kumiai"]);

              print('</div>');
            print('</div>');

            // 国税庁登録
            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">国税庁登録</div>');
              print('<div class="sakaguracolumn2" id="kokuzei">');

                if($row["kokuzei"] == 10)
					print('あり');
                else if($row["kokuzei"] == 11)
					print('なし');
                else if($row["kokuzei"] == 12)
					print('不明');
                else
					print($row["kokuzei"]);

              print('</div>');
            print('</div>');

            // アクティブ
            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">ステータス</div>');
              print('<div class="sakaguracolumn2" id="status">');

                if($row["status"] == 10)
                {
                  print('active');
                }
                else if($row["status"] == 11)
                {
                  print('inactive');
                }
                else if($row["status"] == 12)
                {
                  print('一時製造休止');
                }
                else if($row["status"] == 13)
                {
                  print('営業不明・自醸停止外部醸造');
                }

              print('</div>');
            print('</div>');

            // 開発状況
            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">開発状況</div>');
              print('<div class="sakaguracolumn2" id="develop">');

                if($row["sakagura_develop"] == 1)
                {
                  print('完成');
                }
                else if($row["sakagura_develop"] == 2)
                {
                  print('途中');
                }
                else
                {
                  print('未完成');
                }

              print('</div>');
            print('</div>');

            // メモ
            $row["memo"] = nl2br($row["memo"]);
            $row["memo"] = stripslashes($row["memo"]);

            print('<div class="sakagurarow">');
              print('<div class="sakaguracolumn1">メモ</div>');
              print('<div class="sakaguracolumn2" id="memo">'.link_it($row["memo"]).'</div>');
            print('</div>');

          print('</div>'); // edittable
        print("</div>"); //spec_extra*/

      print("</div>");/*mainframe*/
      ////////////////////////////////////////
      ////////////////////////////////////////
      /* advertisement */
      print('<div id="banner_frame">');
        print('<a id="ad1" href="sake_search.php"><img src="images/icons/notice_banner.jpg"></a>');
      print("</div>");

    print('</div>');/*main_banner_container*/
  }

	print('<input style="height: 0px" type="file" id="fileID">');
print("</div>"); //container
writefooter();
?>

<div id="search_background">
	<div id="inner_background">
		<div class="loader"></div>
	</div>
</div>

<script type="text/javascript">

/***************************************************************************************
  テスト用: 取り扱い商品の多い酒蔵順に表示

	SELECT		SAKAGURA_J.id, SAKAGURA_J.sakagura_name, COUNT(*)
	FROM		SAKAGURA_J, SAKE_J
	WHERE		SAKE_J.sakagura_id = SAKAGURA_J.id
	GROUP BY	SAKAGURA_J.id
	HAVING		COUNT(*) >= 25
	ORDER BY	COUNT(*);
***************************************************************************************/

/////////////////////////////////////////////////////////////////////////////////////
function nl2br(str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

    return (str + '')
      .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
} // nl2br

// Loadingイメージ表示関数
function dispLoading(){
	 $('#search_background').css('display', 'block');
}

// Loadingイメージ削除関数
function removeLoading(){
	 $('#search_background').css('display', 'none');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// prev, next sake
$(function() {

	var disp_max = 25;

	var rice_items = [
		  ["kokusanmai", "国産米", "こくさんまい"],
          ["yamadanishiki", "山田錦", "やまだにしき"],
          ["gohyakumangoku", "五百万石", "ごひゃくまんごく"],
          ["omachi", "雄町", "おまち"],
          ["aiyama", "愛山", "あいやま"],
          ["akitashukomachi", "秋田酒こまち", "あきたさけこまち"],
          ["akinosei", "秋の精", "あきのせい"],
          ["ipponjime", "一本〆", "いっぽんじめ"],
          ["oyamanishiki", "雄山錦", "おやまにしき"],
          ["kairyoshinko", "改良信交", "かいりょうしんこう"],
          ["kamenoo", "亀の尾", "かめのお"],
          ["ginotome", "ぎんおとめ", "ぎんおとめ"],
          ["ginginga", "吟ぎんが", "ぎんぎんが"],
          ["ginnosato", "吟のさと", "ぎんのさと"],
          ["ginnosei", "吟の精", "ぎんのせい"],
          ["gimpu", "吟風", "ぎんぷう"],
          ["ginfubuki", "吟吹雪", "ぎんふぶき"],
          ["kinmonnishiki", "金紋錦", "きんもんにしき"],
          ["kuranohana", "蔵の華", "くらのはな"],
          ["koshitanrei", "越淡麗", "こしたんれい"],
          ["koshinoshizuku", "越の雫", "こしのしずく"],
          ["saitonoshizuku", "西都の雫", "さいとのしずく"],
          ["sakemirai", "酒未来", "さけみらい"],
          ["sakemusashi", "さけ武蔵", "さけむさし"],
          ["shinriki", "神力", "しんりき"],
          ["suisei", "彗星", "すいせい"],
          ["senbonnishiki", "千本錦", "せんぼんにしき"],
          ["tatsunootoshigo", "龍の落とし子", "たつのおとしご"],
          ["tamazakae", "玉栄", "たまさかえ"],
          ["dewasansan", "出羽燦々", "でわさんさん"],
          ["dewanosato", "出羽の里", "でわのさと"],
          ["hattan", "八反", "はったん"],
          ["hattannishiki", "八反錦", "はったんにしき"],
          ["hanaomoi", "華想い", "はなおもい"],
          ["hanafubuki", "華吹雪", "はなふぶき"],
          ["hitachinishiki", "ひたち錦", "ひたちにしき"],
          ["hitogokochi", "ひとごこち", "ひとごこち"],
          ["hohai", "豊盃", "ほうはい"],
          ["hoshiakari", "星あかり", "ほしあかり"],
          ["maikaze", "舞風", "まいかぜ"],
          ["misatonishiki", "美郷錦", "みさとにしき"],
          ["miyamanishiki", "美山錦", "みやまにしき"],
          ["other", "その他", "そのた"]];

		function GetRiceString(rice_used) {

			var rice_array = rice_used.split('/');
			var rice_text = "";

			for(var i = 0; i < rice_array.length; i++)
			{
				var rice_entry = rice_array[i].split(',');
				//alert("rice_entry[0]:" + rice_entry[0] + " rice_entry[1]:" + rice_entry[1]);

				rice_text += "<span>";

				for(var j = 0; j < rice_items.length; j++) {
					if(rice_entry[0] == rice_items[j][0]) {

						var innerText = "";

						if(rice_entry[1] == "1") {
						  innerText = "麹米:";
						}
						else if(rice_entry[1] == "2") {
						  innerText = "掛米:";
						}

						rice_text += (i == 0) ? innerText + rice_items[j][1] : ' / ' + innerText + rice_items[j][1];
						//rice_text += (i == 0) ? rice_items[j][1] : ' / ' + rice_items[j][1];
						break;
					}
				}

				rice_text += "</span>";
			}

			return rice_text;
		}


  function searchSake(in_disp_from, disp_max, data, bCount)
	{
	    dispLoading("処理中...");
		//alert("searchsake:" + data);

		$.ajax({
				type: "POST",
				url: "complex_search.php",
				data: data,
				dataType: 'json',

			}).done(function(data){

  				var innerHTML = "";
  				var i = 0;
  				var count_result = data[0].count;
  				var sake = data[0].result;

				//alert("sql:" + data[0].sql);
				//alert("success count_result:" + sake.length);
				removeLoading();

				$('#search_sake_result').empty()

				for(i = 0; i < sake.length; i++)
				{
					innerHTML += '<a class="searchRow_link" href= "sake_view.php?sake_id=' + sake[i].sake_id + '">';

						innerHTML += '<div class="search_sake_result_name_container">';
							innerHTML += '<div class="search_sake_result_thumb_sake"><img src="' + sake[i].filename + '"></div>';
							innerHTML += '<div class="search_sake_result_sake_brewery_date_container">';
								innerHTML += '<div class="search_sake_name">' + sake[i].sake_name + '</div>';
								innerHTML += '<div class="search_sake_result_brewery_date_container">';
									innerHTML += '<div>' + sake[i].sakagura_name + ' / ' + sake[i].pref + '</div>';
									innerHTML += '<div class="search_sake_result_date">' + sake[i].write_date + '</div>';
								innerHTML += '</div>';
							innerHTML += '</div>';
						innerHTML += '</div>';

						innerHTML += '<div class="sake_rank">';
							var rank_width = (sake[i].sake_rank / 5) * 100 + '%';

							innerHTML += '<div class="sake_rank_star_rating">';

								innerHTML += '<div class="sake_rank_star_rating_front" style="width: ' + rank_width + '">★★★★★</div>';
								innerHTML += '<div class="sake_rank_star_rating_back">★★★★★</div>';

							innerHTML += '</div>';

							if(sake[i].sake_rank) {
								innerHTML += '<span class="sake_rank_sake_rate">' + sake[i].sake_rank.toFixed(1) + '</span>';
							} else {
								innerHTML += '<span class="sake_rank_sake_rate" style="color: #b2b2b2;">--</span>';
							}
						innerHTML += '</div>';

						innerHTML += '<div class="spec">';
							innerHTML += '<div class="spec_item">';
								innerHTML += '<div class="spec_title"><svg class="spec_item_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg>特定名称</div>';
								innerHTML += '<div class="spec_info">';
									if(sake[i].special_name && sake[i].special_name != "") {
										innerHTML += sake[i].special_name;
									} else {
										innerHTML += '<span style="color: #b2b2b2;">--</span>';
									}
								innerHTML += '</div>';
							innerHTML += '</div>';

							innerHTML += '<div class="spec_item">';
								innerHTML += '<div class="spec_title"><svg class="spec_item_alc1616"><use xlink:href="#alc1616"/></svg>Alc度数</div>';
								innerHTML += '<div class="spec_info">';
									if(sake[i].alcohol_level != "") {
										var alcohol_array = sake[i].alcohol_level.split(',');
										if(alcohol_array.length == 1) {
											innerHTML += alcohol_array[0] + '%';
										} else {
											if(alcohol_array[0] == alcohol_array[1]) {
												innerHTML += alcohol_array[0] + '%';
											} else if(alcohol_array[0] != "" && alcohol_array[1] != "") {
												innerHTML += alcohol_array[0] + '～' + alcohol_array[1] + '%';
											} else if(alcohol_array[0] != "" && alcohol_array[1] == "") {
												innerHTML += alcohol_array[0] + '%';
											}
										}
									} else {
										innerHTML += '<span style="color: #b2b2b2;">--</span>';
									}
								innerHTML += '</div>';
							innerHTML += '</div>';

              ////////////////////////////////////////////////////////////////////////////////////////////
              ////////////////////////////////////////////////////////////////////////////////////////////
							innerHTML += '<div class="spec_item">';
								innerHTML += '<div class="spec_title"><svg class="spec_item_rice1616"><use xlink:href="#rice1616"/></svg>原料米</div>';
								innerHTML += '<div class="spec_info">';
									if(sake[i].rice_used != null && sake[i].rice_used != "") {
										innerHTML += GetRiceString(sake[i].rice_used);
									} else {
										innerHTML += '<span style="color: #b2b2b2;">--</span>';
									}
								innerHTML += '</div>';
							innerHTML += '</div>';
              ////////////////////////////////////////////////////////////////////////////////////////////
              ////////////////////////////////////////////////////////////////////////////////////////////

							innerHTML += '<div class="spec_item">';
								innerHTML += '<div class="spec_title"><svg class="spec_item_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg>精米歩合</div>';
								innerHTML += '<div class="spec_info">';
									var seimai_array = sake[i].seimai_rate.split(',');
									var rice_array = sake[i].rice_used.split('/');

									if(seimai_array[0] || seimai_array[1] || seimai_array[2]) {
										for(var j = 0; j < seimai_array.length; j++) {
											if(rice_array.length > 0 && j < rice_array.length) {
												rice_entry = rice_array[j].split(',');

												if(rice_entry[1] == "1") {
													innerHTML += "麹米:";
												} else if(rice_entry[1] == "2") {
													innerHTML += "掛米:";
												}
											}

											if(seimai_array[j] != "") {
												innerHTML += seimai_array[j] + '%';
											}

											if(j < (seimai_array.length - 1) && seimai_array[j + 1] != "") {
												innerHTML += " / ";
											}
										}
									} else {
										innerHTML += '<span style="color: #b2b2b2;">--</span>';
									}
								innerHTML += '</div>';
							innerHTML += '</div>';

							innerHTML += '<div class="spec_item">';
								innerHTML += '<div class="spec_title"><svg class="spec_item_nihonshudo1616"><use xlink:href="#nihonshudo1616"/></svg>日本酒度</div>';
								innerHTML += '<div class="spec_info">';
									if(sake[i].jsake_level != "") {
										var syudo_array = sake[i].jsake_level.split(',');
										if(syudo_array.length == 1) {
											innerHTML += parseFloat(syudo_array[0]).toFixed(1);
										} else {
											if(syudo_array[0] == syudo_array[1]) {
												innerHTML += parseFloat(syudo_array[0]).toFixed(1);
											} else if(syudo_array[0] != "" && syudo_array[1] != "") {
												innerHTML += parseFloat(syudo_array[0]).toFixed(1) + '～' + parseFloat(syudo_array[1]).toFixed(1);
											} else if(syudo_array[0] != "" && syudo_array[1] == "") {
												innerHTML += parseFloat(syudo_array[0]).toFixed(1);
											}
										}
									} else {
										innerHTML += '<span style="color: #b2b2b2;">--</span>';
									}
								innerHTML += '</div>';
							innerHTML += '</div>';
						innerHTML += '</div>';

					innerHTML += '</a>';
				}

				$('#search_sake_result').append(innerHTML);

				//////////////////////////////////////////////////////////////////////////////////////////////////////
				//////////////////////////////////////////////////////////////////////////////////////////////////////
				var pagenum = in_disp_from / disp_max;
				var showPos = parseInt($('.search_result_turn_page .pageitems:nth(0)').text()) - 1;
				var position = pagenum - showPos;

				$("#in_disp_from").val(in_disp_from);
				$("#in_disp_to").val(in_disp_from + disp_max);

				if(position >= $('.search_result_turn_page .pageitems').length)
				{
					var showPos = parseInt($('.search_result_turn_page .pageitems:nth(0)').text());
					var i = 1;

					$('.search_result_turn_page .pageitems').each(function() {
							$(this).text(showPos + i);
							i++;
					});

					position = $('.search_result_turn_page .pageitems').length - 1;
				}
				else if(position < 0)
				{
					var showPos = parseInt($('.search_result_turn_page .pageitems:nth(0)').text()) - 2;
					var i = 1;

					$('.search_result_turn_page .pageitems').each(function() {
							$(this).text(showPos + i);
							i++;
					});

					position = 0;
				}

				$('.search_result_turn_page .pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
				$('.search_result_turn_page .pageitems:nth(' + position + ')').css({"background": "#22445B", "color":"#ffffff"});

				var limit = ((in_disp_from + disp_max) >= $("#hidden_sake_count_query").val()) ? $("#hidden_sake_count_query").val() : (in_disp_from + disp_max);
				$('#disp_sake').text((in_disp_from + 1) + "～" + limit + "件 / 全" + $("#hidden_sake_count_query").val() + "件");

				if(in_disp_from >= disp_max)
					$('#prev_sakagura_sake').css({"background":"#b2b2b2", "cursor":"pointer"});
				else
					$('#prev_sakagura_sake').css({"background":"#d2d2d2", "cursor":"default"});

				if((in_disp_from + disp_max) > parseInt($("#hidden_sake_count_query").val()))
					$('#next_sakagura_sake').css({"background":"#d2d2d2", "cursor":"default"});
				else
					$('#next_sakagura_sake').css({"background":"#b2b2b2", "cursor":"pointer"});

				//////////////////////////////////////////////////////////////////////////////////////////////////////
				//////////////////////////////////////////////////////////////////////////////////////////////////////
				$('html, body').animate({scrollTop:0}, '100');

			}).fail(function(data){
					alert("Failed:" + data);
			}).complete(function(data){
					// Loadingイメージを消す
					removeLoading();
			});
    }

	$(document).on('click', '#next_sakagura_sake', function(e){

		var sakagura_id = <?php echo json_encode($id); ?>;
		var in_disp_from = parseInt($("#in_disp_from").val()) + disp_max;
		var in_disp_to = in_disp_from + disp_max;

		if(in_disp_from < $("#hidden_sake_count_query").val())
		{
			//var data = "category=2" + "&sakagura_id="+sakagura_id+"&from="+in_disp_from+"&to="+in_disp_to + "&orderby=SAKE_J.write_update" + "&desc=DESC";
			var data = "category=2" + "&sakagura_id="+sakagura_id+"&from="+in_disp_from+"&to="+in_disp_to + "&orderby=SAKE_J.sake_read" + "&desc=ASC";
			searchSake(in_disp_from, disp_max, data, false);
		}
	});

	$(document).on('click', '#prev_sakagura_sake', function(e){

		var sakagura_id = <?php echo json_encode($id); ?>;
		var in_disp_from = parseInt($("#in_disp_from").val()) - disp_max;
		var in_disp_to = in_disp_from - disp_max;

		if(in_disp_from >= 0)
		{
			var data = "category=2" + "&sakagura_id="+sakagura_id+"&from="+in_disp_from+"&to="+in_disp_to + "&orderby=SAKE_J.sake_read" + "&desc=ASC";
			searchSake(in_disp_from, disp_max, data, false);
		}
	});

	$(document).on('click', '.search_result_turn_page .pageitems', function(e){

		var sakagura_id = <?php echo json_encode($id); ?>;
		var position = parseInt($(this).text());
		var in_disp_from = (position - 1) * disp_max;
		var in_disp_to = in_disp_from + disp_max;
		var my_url = "?" + data;
		var data = "category=2" + "&sakagura_id="+sakagura_id+"&from="+in_disp_from+"&to="+in_disp_to + "&orderby=SAKE_J.sake_read" + "&desc=ASC";
		searchSake(in_disp_from, disp_max, data, false);
	});

	/*非表示中*/
	/*$('#tab-sake .click_sort div').click(function() {
			var index = $('.click_sort div').index(this);

			if(index == 0)
			{
					if($('#hidden_desc').val() == "ASC")
					{
							$('#hidden_desc').val("DESC");
					}
					else
					{
							$('#hidden_desc').val("ASC");
					}
			}
			else
			{
					$(".click_sort_read, .click_sort_date, .click_sort_ranking, .click_sort_standard, click_sort_like").css({"background": "#d2d2d2", "color": "#ffffff"});
					$(this).css({"background": "#28809E;", "color": "#ffffff"});
			}

			var data = "category=2";
			var sakagura_id = <?php echo json_encode($id); ?>;
			var sort_value = $(this).attr("value");

			in_disp_from = 0;
			in_disp_to = 25;

			//alert("sort_value:" + sort_value);
			data += "&sakagura_id="+sakagura_id+"&in_disp_from="+in_disp_from+"&in_disp_to="+in_disp_to + "&orderby=" + sort_value + "&desc=" + "ASC";
			searchSake(in_disp_from, disp_max, data, false);
	});*/
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

jQuery(document).ready(function(){

	$("body").wrapInner('<div id="wrapper"></div>');

	$('#tab_main').createTabs({
			text : $('#tab_main ul')
	});

	$('.sakagura_buttons #follow').click(function() {

		var id = <?php echo json_encode($id); ?>;
		var data = $(this).attr("value");
		var username = $('#container').data('contributor');
		//alert("data1:" + data);

		if(username == undefined || username == "")
		{
        window.location.href = "user_login_form.php";
        return;
		}

		$.ajax({
			type: "post",
			url: "sda_follow.php?id="+id,
			data: data,
		}).done(function(xml){
			var str = $(xml).find("str").text();

			if(str == "follow")
			{
				$("#follow").css('background', 'linear-gradient(#e6e6e6, #ffffff)');
				$("#follow").css('border', '1px solid #d2d2d2');
				$("#follow").css('color', '#666666');
				$(".sakagura_buttons_pin1616").css('fill', '#b2b2b2');
				$("#follow").attr("value", false);
			}
			else if(str == "followed")
			{
				$("#follow").css('background', 'linear-gradient(#EDCACA, #ffffff)');
				$("#follow").css('border', '1px solid #FF4545');
				$(".sakagura_buttons_pin1616").css('fill', '#FF4545');
				$("#follow").attr("value", true);
			}
		}).fail(function(data){
		  alert("This is Error");
		  $("#follow").text('This is Error');
		});
	});

	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	var hash = window.location.hash;

	if(hash && hash != "")
	{
		var curr = $('#tab_main .simpleTabs').find(".active");
		var prev = $('#tab_main .simpleTabs').find('a[href="' + hash +'"]');

		curr.removeClass('active');
		prev.addClass('active');

		$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
		$(hash).removeClass('hide').addClass('show').show();
	}
	else
	{
		var stateObj = { url: "#top" };
		history.replaceState(stateObj, "test1", "");
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	$('.simpleTabs li a').click(function() {
		var stateObj = { url: $(this).attr("href") };
		history.pushState(stateObj, "test1", $(this).attr("href"));
		//history.replaceState(stateObj, "test1", $(this).attr("href"));
	});

	$(window).on('popstate', function(event) {

		var state = event.originalEvent.state;
		var href = state.url;
		var curr = $('.simpleTabs').find(".active");
		var prev = $('.simpleTabs').find('a[href="' + state.url +'"]');

		curr.removeClass('active');
		prev.addClass('active');

		$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
		$(href).removeClass('hide').addClass('show').show();
	});

	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	$(document).on('click', '#url a', function(){
		event.preventDefault();
		window.open($(this).attr("href"));
	});

}); // jquery ready

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

</script>
</body>
</html>
