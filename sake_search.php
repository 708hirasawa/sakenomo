<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("nonda.php");
require_once("searchbar.php");
//require_once("portal_menu.php");

$flavor_table = array(array("10", "greenapple4040", "青りんご"),
    array("11", "strawberry4040", "いちご"),
    array("12", "orange4040", "オレンジ"),
    array("41", "kiwi4040", "キウイ"),
    array("13", "grapefruit4040", "グレープフルーツ"),
    array("43", "watermelon4040", "スイカ"),
    array("14", "nashi4040", "梨"),
    array("15", "pineapple4040", "パイナップル"),
    array("16", "banana4040", "バナナ"),
    array("42", "grape4040", "ぶどう"),
    array("17", "muscat4040", "マスカット"),
    array("18", "mango4040", "マンゴー"),
    array("19", "melon4040", "メロン"),
    array("20", "peach4040", "桃"),
    array("21", "pear4040", "洋梨"),
    array("22", "lychee4040", "ライチ"),
    array("23", "apple4040", "りんご"),
    array("24", "lemon4040", "レモン"),
    array("25", "flower4040", "花"),
    array("26", "mineralwater4040", "天然水・ミネラル"),
    array("27", "soda4040", "ソーダ・ラムネ"),
    array("28", "herb4040", "ハーブ・若草・根菜"),
    array("29", "tree4040", "木"),
    array("30", "rice4040", "ご飯・餅"),
    array("31", "nuts4040", "ナッツ・豆"),
    array("32", "butter4040", "バター・クリーム・バニラ・チーズ"),
    array("33", "driedfruit4040", "ドライフルーツ・乾物"),
    array("34", "soysauce4040", "しょうゆ・みりん"),
    array("35", "spice4040", "スパイス"),
    array("36", "caramel4040", "カラメル"),
    array("37", "cacao4040", "カカオ・ビターチョコ"),
    array("38", "cemedine4040", "セメダイン"),
    array("39", "yogurt4040", "ヨーグルト"),
    array("40", "other4040", "その他"));

function GetFlavorNames($flavors) {

  if($flavors && $flavors != "") {
    global $flavor_table;
    $flavor_array = explode(',', $flavors);
    $ret_value = "";
    $i = 0;
    $j = 0;

    for($i = 0; $i < count($flavor_array); $i++) {

      for($j = 0; $j < count($flavor_table); $j++) {

        if(intval($flavor_array[$i]) == intval($flavor_table[$j][0])) {

          if($ret_val == "") {
            $ret_val = $flavor_table[$j][2];
          }
          else {
            $ret_val .= '/' .$flavor_table[$j][2];
          }

          break;
        }
      }
    }

    return $ret_val;
  }
  else {
    $ret_value = "--";
    return $ret_val;
  }
}

?>

<!DOCTYPE html>

<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <meta http-equiv="Content-Script-Type" content="text/javascript">
  <meta content='width=device-width, initial-scale=1, user-scalable=0' name='viewport'/>
  <title>Home [Sakenomo]</title>
  <link rel="stylesheet" href="slick/slick-theme.css">
  <link rel="stylesheet" href="slick/slick.css">
  <link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
  <link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
  <link rel="stylesheet" type="text/css" href="css/sake_search.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
  <link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
  <link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
  <!-- <link rel="stylesheet" type="text/css" href="css/portal_menu.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" /> -->
  <!-- <link rel="stylesheet" type="text/css" href="css/user_mail.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" /> -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="slick/slick.min.js"></script>

  <script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
  <script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
  <script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
  <script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>

  <!-- <script src="js/portal_menu.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script> -->

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-1X2ZRV0BES"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-1X2ZRV0BES');
  </script>
</head>

<?php

print('<body>');
  include_once('images/icons/svg_sprite.svg');
  write_side_menu();
  write_HamburgerLogo();
  write_search_bar();
  //write_Nonda();
  //write_portal_menu();
  //write_manage_mail();

print('<div id="container">');
  $username = $_COOKIE['login_cookie'];

  if(!$db = opendatabase("sake.db")) {
    die("データベース接続エラー .<br />");
  }

  $sql = "SELECT COUNT(*) FROM TABLE_NONDA, SAKE_J, SAKAGURA_J, USERS_J WHERE TABLE_NONDA.sake_id = SAKE_J.sake_id AND SAKE_J.sakagura_id = SAKAGURA_J.id AND USERS_J.username = TABLE_NONDA.contributor AND (subject != '' OR message != '')";
  $result = executequery($db, $sql);
  $record = getnextrow($result);
  $count =  $record["COUNT(*)"];

  $sql = "SELECT oauth_uid, USERS_J.picture AS picture, USERS_J.username AS username, USERS_J.nickname AS nickname, USERS_J.pref AS user_pref, bdate, sex, USERS_J.address, certification, age_disclose, sex_disclose, address_disclose, certification_disclose, SAKAGURA_J.pref AS pref, contributor, update_date, TABLE_NONDA.sake_id as sake_id, sake_name, sakagura_name, TABLE_NONDA.write_date as write_date, TABLE_NONDA.rank as rank, subject, message, flavor, tastes, committed FROM TABLE_NONDA, SAKE_J, SAKAGURA_J, USERS_J WHERE TABLE_NONDA.sake_id = SAKE_J.sake_id AND SAKE_J.sakagura_id = SAKAGURA_J.id AND USERS_J.username = TABLE_NONDA.contributor AND (subject != '' OR message != '') ORDER BY UPDATE_DATE DESC LIMIT 25";
  $result = executequery($db, $sql);

  print('<div id="mainview_container" data-in_disp_from=0 data-count=' .$count .'>');
    print('<div id="mainview">');
      /*新着レビュー*******************/
      print('<div class="new_review">');
        print('<div><svg class="top_review3630"><use xlink:href="#review3630"/></svg>新着レビュー</div>');

        print('<div id="threads">');

          while($record = getnextrow($result)) {
            print('<a class="review" href="user_view_sakereview.php?sake_id=' .$record["sake_id"] .'&contributor=' .$record["contributor"] .'">');

              print('<div class="nonda_user_container" data-contributor=' .$record["contributor"]
                .' data-sake_id=' .$record["sake_id"]
                .' data-pref=' .$record["pref"]
                .' data-write_date=' .$record["write_date"]
                .' data-rank="' .$rank_value
                .'" data-subject="' .$record["subject"]
                .'" data-message="' .$record["message"]
                .'" data-flavor="' .$record["flavor"]
                .'" data-tastes="' .$record["tastes"]
                .'" data-committed=' .$record["committed"] .'>');

                $path = "images/icons/noimage_user30.svg";
                $contributor = $record["contributor"];
                $sake_id = $record["sake_id"];
                $rank_value = ($record["rank"] == "") ? 0 : number_format($record["rank"], 1);
				$nickname = $record["nickname"];

				/////////////////////////////////////////////////////////////////////////////
				if($record['oauth_uid'] && ($record['picture'] && $record['picture'] != "")) {
					$path = $record['picture'];
					$nickname = $record["username"];
				}
				else {
					$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$contributor' AND status = 1";
					$res4 = executequery($db, $sql);
					$rd = getnextrow($res4);

					if($rd) {
						$imagefile = $rd["filename"];
						$path = "images/profile/" .$imagefile;
					}
				}
				/////////////////////////////////////////////////////////////////////////////

                print('<div class="nonda_user_image_container">');
                  print('<img src="' .$path .'">');
                print('</div>');

                print('<div class="nonda_user_name_container">');
                  print('<div class="nonda_user_name">' .$nickname .'</div>');
                  print('<div class="nonda_user_profile_date_container">');
                    print('<div class="nonda_date">' .gmdate("Y/m/d", $record["update_date"] + 9 * 3600) .'</div>');
                  print('</div>');
                print('</div>');
              print('</div>');
              ////////////////////////////////////////
              print('<div class="nonda_sake_container">');
                print('<div class="nonda_sake_name">' .$record["sake_name"] .'</div>');
                print('<div class="nonda_brewery_pref_container">' .$record["sakagura_name"] .' / ' .$record["pref"] .'</div>');
              print('</div>');
              ////////////////////////////////////////
              $rank_width = (($record['rank'] / 5) * 100) .'%';
              print('<div class="nonda_rank">');
                print('<div class="review_star_rating">');
                  print('<div class="review_star_rating_front" style="width:' .$rank_width. '">★★★★★</div>');
                  print('<div class="review_star_rating_back">★★★★★</div>');
                print('</div>');
                if($record['rank']) {
                  print('<span class="review_sake_rate">' .number_format($record["rank"], 1) .'</span>');
                } else {
                  print('<span class="review_sake_rate" style="color: #b2b2b2;">--</span>');
                }
              print('</div>');
              ////////////////////////////////////////
              if($record["subject"] && $record["message"]) {
                print('<div class="nonda_subject_message_container">');
                  print('<div class="nonda_subject">' .$record["subject"] .'</div>');
                  print('<div class="nonda_message">'.nl2br($record["message"]).'</div>');
                print('</div>');
              } else if($record["subject"] && $record["message"] == null) {
                print('<div class="nonda_subject_message_container">');
                  print('<div class="nonda_subject">' .$record["subject"] .'</div>');
                print('</div>');
              } else if($record["subject"] == null && $record["message"]) {
                print('<div class="nonda_subject_message_container">');
                  print('<div class="nonda_message">'.nl2br($record["message"]).'</div>');
                print('</div>');
              } else {
                print('');
              }
              ////////////////////////////////////////
              $contributor = $record["contributor"];
              $image_result = executequery($db, "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$contributor'");
              $image_record = getnextrow($image_result);

              if($image_record && $image_record != "") {
                print('<div class="review_container">');
                  $path = "images\\photo\\thumb\\". $image_record["filename"];
                  print('<div class="review_image"><img src="' .$path .'" data-desc = "' .$image_record["desc"] .'"></div>');

                  while($image_record = getnextrow($image_result)) {
                    $path = "images\\photo\\thumb\\". $image_record["filename"];
                    print('<div class="review_image"><img src="' .$path .'" data-desc = "' .$image_record["desc"] .'"></div>');
                  }
                print('</div>');
              } else {
                print('');
              }

            ////////////////////////////////////////
            ////////////////////////////////////////
            if($record["flavor"] || $record["tastes"]) {
              if($record["tastes"])
                $tastes_values = explode(',', $record["tastes"]);
              else
                $tastes_values = Array(0, 0, 0, 0, 0, 0, 0, 0);

              print('<div class="tastes">');
                print('<div class="tastes_item">');
                  print('<div class="tastes_title"><svg class="tastes_item_flavor1816"><use xlink:href="#flavor1816"/></svg>フレーバー</div>');
                  if($record["flavor"]) {
                    print('<div class="taste_value_flavor">' .GetFlavorNames($record["flavor"]) .'</div>');
                  } else {
                    print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
                  }
                print('</div>');
                ////////////////////////////////////////
                print('<div class="tastes_item">');
                  print('<div class="tastes_title"><svg class="tastes_item_aroma1216"><use xlink:href="#aroma1216"/></svg>香り</div>');
                  print('<div class="tastes_value_container">');
                    print('<div class="tastes_bar_container">');
                      print('<input type="range" name="aroma" step="0.1" min="0" max="5" value="' .$tastes_values[0] .'" disabled="disabled" class="user_input_range">');
                    print('</div>');
                    if($tastes_values[0]) {
                      print('<div class="taste_value">'. number_format($tastes_values[0], 1).'</div>');
                    } else {
                      print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
                    }
                  print('</div>');
                print('</div>');
                ////////////////////////////////////////
                print('<div class="tastes_item">');
                  print('<div class="tastes_title"><svg class="tastes_item_body1216"><use xlink:href="#body1216"/></svg>ボディ</div>');
                  print('<div class="tastes_value_container">');
                    print('<div class="tastes_bar_container">');
                      print('<input type="range" name="body" step="0.1" min="0" max="5" value="' .$tastes_values[1] .'" disabled="disabled" class="user_input_range">');
                    print('</div>');
                    if($tastes_values[1]) {
                      print('<div class="taste_value">'. number_format($tastes_values[1], 1).'</div>');
                    } else {
                      print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
                    }
                  print('</div>');
                print('</div>');
                ////////////////////////////////////////
                print('<div class="tastes_item">');
                  print('<div class="tastes_title"><svg class="tastes_item_clear3030"><use xlink:href="#clear3030"/></svg>クリア</div>');
                  print('<div class="tastes_value_container">');
                    print('<div class="tastes_bar_container">');
                      print('<input type="range" name="clear" step="0.1" min="0" max="5" value="' .$tastes_values[2] .'" disabled="disabled" class="user_input_range">');
                    print('</div>');
                    if($tastes_values[2]) {
                      print('<div class="taste_value">'. number_format($tastes_values[2], 1).'</div>');
                    } else {
                      print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
                    }
                  print('</div>');
                print('</div>');
                ////////////////////////////////////////
                print('<div class="tastes_item">');
                  print('<div class="tastes_title"><svg class="tastes_item_sweetness3030"><use xlink:href="#sweetness3030"/></svg>甘辛</div>');
                  print('<div class="tastes_value_container">');
                    print('<div class="tastes_bar_container">');
                      print('<input type="range" name="sweetness" step="0.1" min="0" max="5" value="' .$tastes_values[3] .'" disabled="disabled" class="user_input_range">');
                    print('</div>');
                    if($tastes_values[3]) {
                      print('<div class="taste_value">'. number_format($tastes_values[3], 1).'</div>');
                    } else {
                      print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
                    }
                  print('</div>');
                print('</div>');
                ////////////////////////////////////////
                print('<div class="tastes_item">');
                  print('<div class="tastes_title"><svg class="tastes_item_umami3030"><use xlink:href="#umami3030"/></svg>旨味</div>');
                  print('<div class="tastes_value_container">');
                    print('<div class="tastes_bar_container">');
                      print('<input type="range" name="umami" step="0.1" min="0" max="5" value="' .$tastes_values[4] .'" disabled="disabled" class="user_input_range">');
                    print('</div>');
                    if($tastes_values[4]) {
                      print('<div class="taste_value">'. number_format($tastes_values[4], 1).'</div>');
                    } else {
                      print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
                    }
                  print('</div>');
                print('</div>');
                ////////////////////////////////////////
                print('<div class="tastes_item">');
                  print('<div class="tastes_title"><svg class="tastes_item_acidity3030"><use xlink:href="#acidity3030"/></svg>酸味</div>');
                  print('<div class="tastes_value_container">');
                    print('<div class="tastes_bar_container">');
                      print('<input type="range" name="acidity" step="0.1" min="0" max="5" value="' .$tastes_values[5] .'" disabled="disabled" class="user_input_range">');
                    print('</div>');
                    if($tastes_values[5]) {
                      print('<div class="taste_value">'. number_format($tastes_values[5], 1).'</div>');
                    } else {
                      print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
                    }
                  print('</div>');
                print('</div>');
                ////////////////////////////////////////
                print('<div class="tastes_item">');
                  print('<div class="tastes_title"><svg class="tastes_item_bitter1216"><use xlink:href="#bitter1216"/></svg>ビター</div>');
                  print('<div class="tastes_value_container">');
                    print('<div class="tastes_bar_container">');
                      print('<input type="range" name="bitter" step="0.1" min="0" max="5" value="' .$tastes_values[6] .'" disabled="disabled" class="user_input_range">');
                    print('</div>');
                    if($tastes_values[6]) {
                      print('<div class="taste_value">'. number_format($tastes_values[6], 1).'</div>');
                    } else {
                      print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
                    }
                  print('</div>');
                print('</div>');
                ////////////////////////////////////////
                print('<div class="tastes_item">');
                  print('<div class="tastes_title"><svg class="tastes_item_yoin3030"><use xlink:href="#yoin3030"/></svg>余韻</div>');
                  print('<div class="tastes_value_container">');
                    print('<div class="tastes_bar_container">');
                      print('<input type="range" name="yoin" step="0.1" min="0" max="5" value="' .$tastes_values[7] .'" disabled="disabled" class="user_input_range">');
                    print('</div>');
                    if($tastes_values[7]) {
                      print('<div class="taste_value">'. number_format($tastes_values[7], 1).'</div>');
                    } else {
                      print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
                    }
                  print('</div>');
                print('</div>');
              print('</div>');//tastes
            }

            print('<div class="sake_like_container">');
              print('<div class="sake_like">');

                $sql2 = "SELECT COUNT(*) FROM NONDA_LIKE, TABLE_NONDA WHERE TABLE_NONDA.contributor = '$contributor' AND TABLE_NONDA.sake_id = '$sake_id' AND TABLE_NONDA.contributor = NONDA_LIKE.contributor AND TABLE_NONDA.sake_id = NONDA_LIKE.sake_id";
                $result2 = executequery($db, $sql2);
                $count = ($rd = getnextrow($result2)) ? $rd["COUNT(*)"] : 0;

                $sql3 = "SELECT username FROM NONDA_LIKE, TABLE_NONDA WHERE NONDA_LIKE.username = '$username' AND TABLE_NONDA.contributor = '$contributor' AND TABLE_NONDA.sake_id = '$sake_id' AND TABLE_NONDA.contributor = NONDA_LIKE.contributor AND TABLE_NONDA.sake_id = NONDA_LIKE.sake_id";
                $result3 = executequery($db, $sql3);
                /////////////////////////////////////////////////////////

                if($rd = getnextrow($result3))
                  print('<svg class="sake_like_icon active"><use xlink:href="#heart2020"/></svg>');
                else
                  print('<svg class="sake_like_icon"><use xlink:href="#heart2020"/></svg>');

                print('<div class="sake_like_count">' .$count .'</div>');
              print('</div>');
            print('</div>');
            print('</a>');//review
          }
        print("</div>"); //thread;

      print('</div>');//new_review
      print('<div class="loader"></div>');
    print("</div>");//mainview
    ////////////////////////////////////////
    /*バナーサイド*******************/
    print('<div id="banner_frame">');
      print('<a id="ad1" href="sake_search.php"><img src="images/icons/notice_banner.jpg"></a>');

      /*初期非表示print('<ul class="slider multiple-heading">');
        print('<li><a href="specialselection_kimoto.php">');
          print('<div class="slide_kimoto">');
            print('<div class="slide_kimoto_article">');
              print('<div class="slide_kimoto_title">Sakenomo 特集</div>');
              print('<div class="slide_kimoto_text">『生酛<span> (きもと) </span>造り』</div>');
              print('<div class="slide_kimoto_text_sub">時を超えて注目を集める</div><div class="slide_kimoto_text_sub">伝統的な酒造り</div>');
            print('</div>');
          print('</div>');
        print('</a></li>');

        print('<li><a href="specialselection_sparkling.php">');
          print('<div class="slide_sparkling">');
            print('<div class="slide_sparkling_article">');
              print('<div class="slide_sparkling_title">Sakenomo 特集</div>');
              print('<div class="slide_sparkling_text">『スパークリング日本酒』</div>');
              print('<div class="slide_sparkling_text_sub">パチパチ新感覚の日本酒</div>');
            print('</div>');
          print('</div>');
        print('</a></li>');
      print("</ul>");*/
    print("</div>");
    ////////////////////////////////////////

  print("</div>");//mainview_container

  writefooter();
?>
</div> <!-- container -->
</body>

<script type="text/javascript">

$(function() {

		var flavor_table = [["10", "greenapple4040", "青りんご"],
						    ["11", "strawberry4040", "いちご"],
							["12", "orange4040", "オレンジ"],
							["41", "kiwi4040", "キウイ"],
							["13", "grapefruit4040", "グレープフルーツ"],
							["43", "watermelon4040", "スイカ"],
							["14", "nashi4040", "梨"],
							["15", "pineapple4040", "パイナップル"],
							["16", "banana4040", "バナナ"],
							["42", "grape4040", "ぶどう"],
							["17", "muscat4040", "マスカット"],
							["18", "mango4040", "マンゴー"],
							["19", "melon4040", "メロン"],
							["20", "peach4040", "桃"],
							["21", "pear4040", "洋梨"],
							["22", "lychee4040", "ライチ"],
							["23", "apple4040", "りんご"],
							["24", "lemon4040", "レモン"],
							["25", "flower4040", "花"],
							["26", "mineralwater4040", "天然水・ミネラル"],
							["27", "soda4040", "ソーダ・ラムネ"],
							["28", "herb4040", "ハーブ・若草・根菜"],
							["29", "tree4040", "木"],
							["30", "rice4040", "ご飯・餅"],
							["31", "nuts4040", "ナッツ・豆"],
							["32", "butter4040", "バター・クリーム・バニラ・チーズ"],
							["33", "driedfruit4040", "ドライフルーツ・乾物"],
							["34", "soysauce4040", "しょうゆ・みりん"],
							["35", "spice4040", "スパイス"],
							["36", "caramel4040", "カラメル"],
							["37", "cacao4040", "カカオ・ビターチョコ"],
							["38", "cemedine4040", "セメダイン"],
							["39", "yogurt4040", "ヨーグルト"],
							["40", "other4040", "その他"]];

		function GetFlavorNames(flavors) {

			var ret_value = "";
			var i = 0, j = 0;

			var flavor_array = flavors.split(',');

			for(i = 0; i < flavor_array.length; i++) {

				for(j = 0; j < flavor_table.length; j++) {

					if(flavor_array[i] == flavor_table[j][0]) {

						if(ret_value == "") {
							ret_value = flavor_table[j][2];
						}
						else {
							ret_value += '/' + flavor_table[j][2];
						}
						break;
					}
				}
			}

			return ret_value;
		}

	function nl2br(str, is_xhtml) {
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

		return (str + '')
		.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}

	function nonda_serialize(in_disp_from, in_disp_to, query_count) {

		var data = "search_type=1" + "&from=" + in_disp_from + "&to=" + in_disp_to;

		if(query_count && query_count == 1) {
			data += "&count_query=" + query_count;
		}

		data += "&orderby=" + "UPDATE_DATE";

		return data;
	}

	// Loadingイメージ表示関数
	function dispLoading(){
		//$(".loading").css({"visibility": "visible"});
		$('.loader').css('display', 'block');
	}

	// Loadingイメージ削除関数
	function removeLoading(){
		//$(".loading").css({"visibility": "hidden"});
		$('.loader').css('display', 'none');
	}

	$(document).on('click', '.sake_like_container', function() {

		event.preventDefault();
		var username = <?php echo json_encode($username); ?>;

		if(username == undefined || username == "")
		{
			window.location.href = "user_login_form.php";
			return;
		}

		var sake_id = $(this).parent().find('.nonda_user_container').data('sake_id');
		var contributor = $(this).parent().find('.nonda_user_container').data('contributor');
		var data = "sake_id=" + sake_id + "&contributor=" + contributor + "&username=" + username;
		var obj = this;

		//alert("data:" + data);

		$.ajax({
			type: "post",
			url: "cgi/nonda_like.php",
			data: data,
		}).done(function(xml){
			var str = $(xml).find("str").text();
			var count = $(xml).find("count").text();
			var sql = $(xml).find("sql").text();
			//alert("str:" + str + " sql:" + sql);

			if(str == "unliked")
			{
				$(obj).find('.sake_like_icon').removeClass("active");
				$(obj).find('.sake_like_count').text(count);
			}
			else if(str == "liked")
			{
				$(obj).find('.sake_like_icon').addClass("active");
				$(obj).find('.sake_like_count').text(count);
			}

		}).fail(function(data){
			alert("This is Error");
		});
	});

	var loadingFlag = false;

   //$(window).on('load scroll', function() {
   $(window).scroll(function () {

		var footerHeight = $('.sakenomu_footer').is(":hidden") ? 0 : $('.sakenomu_footer').height();

		//if($(window).scrollTop() + $(window).height() >= $(document).height() && ($('#mainview_container').data('in_disp_from') + 25) < $('#mainview_container').data("count")) {
		//if($(window).scrollTop() + window.innerHeight >= ($(document).height() - $('.sakenomu_footer').height()) && ($('#mainview_container').data('in_disp_from') + 25) < $('#mainview_container').data("count")) {
		//if($(window).scrollTop() + $(window).height() == $(document).height())  {
        //if($(window).scrollTop() + $(window).height() >= ($(document).height() - footerHeight) && ($('#mainview_container').data('in_disp_from') + 25) < $('#mainview_container').data("count")) {


		if(!loadingFlag && $(window).scrollTop() + $(window).height() >= ($(document).height() - footerHeight - 75) && ($('#mainview_container').data('in_disp_from') + 25) < $('#mainview_container').data("count")) {

			loadingFlag = true;

			//alert("footerHeight:" + footerHeight);
			var in_disp_from = $('#mainview_container').data('in_disp_from') + 25;
			var in_disp_to = in_disp_from + 25;
			var data = nonda_serialize(in_disp_from, in_disp_to, 0);

			//$(this).unbind('scroll');
			//alert("count:" + $('#mainview_container').data("count"));
			//alert("data:" + data);
		    dispLoading("処理中...");

			$.ajax({
					type: "POST",
					url: "cgi/nonda_scroll.php",
					data: data,
					dataType: 'json',

			}).done(function(data){

					var i = 0;
					var count_result = data[0].count;
					var sake = data[0].result;
					var nonda_values = 0;

					removeLoading();

					//alert("sql:" + data[0].sql);
					//alert("count resut:" + sake.length);

					if(count_result == 0 && sake == null) {
						var innerText = '<div class="navigate_page_no_registry">投稿はありません</div>';
						$('#disp_sake').css({"display":"none"});
						$("#sake_sort").css({"display":"none"});
						$('#threads').html(innerText);
						$('#review_result_turn_page').css({"display": "none"});
						removeLoading();
					}
					else {

						//alert("nonda_scroll length:" + sake.length);

						for(i = 0; i < sake.length; i++)
						{
							  var innerHTML = '<a class="review" href="user_view_sakereview.php?sake_id=' + sake[i].sake_id + '&contributor=' + sake[i].username + '">';

							  innerHTML += '<div class="nonda_user_container" data-contributor=' + sake[i].username;
							  innerHTML += ' data-sake_id=' + sake[i].sake_id;
							  innerHTML += ' data-pref=' + sake[i].pref;
							  innerHTML += ' data-write_date=' + sake[i].write_date;
							  innerHTML += ' data-rank="' + sake[i].rank;
							  innerHTML += '" data-subject="' + sake[i].subject;
							  innerHTML += '" data-message="' + sake[i].message;
							  innerHTML += '" data-flavor="' + sake[i].flavor;
							  innerHTML += '" data-tastes="' + sake[i].tastes;
							  innerHTML += '" data-committed=' + sake[i].committed + '>';

							  innerHTML += '<div class="nonda_user_image_container">';
								 innerHTML += '<img src="' + sake[i].profile_image + '">';
							  innerHTML += '</div>';

								 innerHTML += '<div class="nonda_user_name_container">';
								  innerHTML += '<div class="nonda_user_name">' + sake[i].nickname + '</div>';
								  innerHTML += '<div class="nonda_user_profile_date_container">';
									innerHTML += '<div class="nonda_date">' + sake[i].update_date + '</div>';
								  innerHTML += '</div>';
								innerHTML += '</div>';
							  innerHTML += '</div>';

							  ////////////////////////////////////////
							  innerHTML += '<div class="nonda_sake_container">';
								innerHTML += '<div class="nonda_sake_name">' + sake[i].sake_name + '</div>';
								innerHTML += '<div class="nonda_brewery_pref_container">' + sake[i].sakagura_name + ' / ' + sake[i].pref + '</div>';
							  innerHTML += '</div>';
							  ////////////////////////////////////////
							  var rank_width = ((sake[i].rank / 5) * 100) + '%';

							  innerHTML += '<div class="nonda_rank">';
								innerHTML += '<div class="review_star_rating">';
								  innerHTML += '<div class="review_star_rating_front" style="width:' + rank_width + '">★★★★★</div>';
								  innerHTML += '<div class="review_star_rating_back">★★★★★</div>';
								innerHTML += '</div>';

								if(sake[i].rank) {
								  innerHTML += '<span class="review_sake_rate">' + parseFloat(sake[i].rank).toFixed(1) + '</span>';
								} else {
								  innerHTML += '<span class="review_sake_rate" style="color: #b2b2b2">--</span>';
								}
							  innerHTML += '</div>';
							  ////////////////////////////////////////

							  if(sake[i].subject && sake[i].message) {
									innerHTML += '<div class="nonda_subject_message_container">';
									  innerHTML += '<div class="nonda_subject">' + sake[i].subject + '</div>';
									  innerHTML += '<div class="nonda_message">' + nl2br(sake[i].message) + '</div>';
									innerHTML += '</div>';
							  } else if(sake[i].subject && sake[i].message == null) {
									innerHTML += '<div class="nonda_subject_message_container">';
									  innerHTML += '<div class="nonda_subject">' + sake[i].subject + '</div>';
									innerHTML += '</div>';
							  } else if(sake[i].subject == null && sake[i].message) {
									innerHTML += '<div class="nonda_subject_message_container">';
									  innerHTML += '<div class="nonda_message">' + sake[i].message + '</div>';
									innerHTML += '</div>';
							  } else {
									innerHTML += '';
							  }

							  if(sake[i].path && sake[i].path != "") {
									var pathArray = sake[i].path.split(', ');
									var j;

									innerHTML += '<div class="review_container">';
  									for(j = 0; j < pathArray.length; j++)
  									{
  										//var path = "images\\photo\\thumb\\" + pathArray[i];
  										//alert("image:" + path);

										innerHTML += '<div class="review_image"><img src="' + "images\\photo\\thumb\\" + pathArray[j] + '"></div>';
  									}
									innerHTML += '</div>';
							  } else {
									innerHTML += '';
							  }

							////////////////////////////////////////
							////////////////////////////////////////
							if(sake[i].flavor || sake[i].tastes) {

							  if(sake[i].tastes)
								tastes_values = sake[i].tastes.split(',');
							  else
								tastes_values = [0, 0, 0, 0, 0, 0, 0, 0];

							  innerHTML += '<div class="tastes">';
								innerHTML += '<div class="tastes_item">';
								  innerHTML += '<div class="tastes_title"><svg class="tastes_item_flavor1816"><use xlink:href="#flavor1816"/></svg>フレーバー</div>';
								  innerHTML += '<div class="taste_value_flavor">' + GetFlavorNames(sake[i].flavor) + '</div>';
								innerHTML += '</div>';

								////////////////////////////////////////
								innerHTML += '<div class="tastes_item">';
								  innerHTML += '<div class="tastes_title"><svg class="tastes_item_aroma1216"><use xlink:href="#aroma1216"/></svg>香り</div>';
								  innerHTML += '<div class="tastes_value_container">';
									innerHTML += '<div class="tastes_bar_container">';
									  innerHTML += '<input type="range" name="aroma" step="0.1" min="0" max="5" value="' + tastes_values[0] + '" disabled="disabled" class="user_input_range">';
									innerHTML += '</div>';

									if(tastes_values[0]) {
									  innerHTML += '<div class="taste_value">' + parseFloat(tastes_values[0]).toFixed(1) + '</div>';
									} else {
									  innerHTML += '<div class="taste_value" style="color: #b2b2b2">--</div>';
									}

								  innerHTML += '</div>';
								innerHTML += '</div>';

								////////////////////////////////////////
								innerHTML += '<div class="tastes_item">';
								  innerHTML += '<div class="tastes_title"><svg class="tastes_item_body1216"><use xlink:href="#body1216"/></svg>ボディ</div>';
								  innerHTML += '<div class="tastes_value_container">';
									innerHTML += '<div class="tastes_bar_container">';
									  innerHTML += '<input type="range" name="body" step="0.1" min="0" max="5" value="' + tastes_values[1] + '" disabled="disabled" class="user_input_range">';
									innerHTML += '</div>';

									if(tastes_values[1]) {
									  innerHTML += '<div class="taste_value">' + parseFloat(tastes_values[1]).toFixed(1) + '</div>';
									} else {
									  innerHTML += '<div class="taste_value" style="color: #b2b2b2">--</div>';
									}
								  innerHTML += '</div>';
								innerHTML += '</div>';

								////////////////////////////////////////
								innerHTML += '<div class="tastes_item">';
								  innerHTML += '<div class="tastes_title"><svg class="tastes_item_clear3030"><use xlink:href="#clear3030"/></svg>クリア</div>';
								  innerHTML += '<div class="tastes_value_container">';
									innerHTML += '<div class="tastes_bar_container">';
									  innerHTML += '<input type="range" name="clear" step="0.1" min="0" max="5" value="' + tastes_values[2] + '" disabled="disabled" class="user_input_range">';
									innerHTML += '</div>';
									if(tastes_values[2]) {
									  innerHTML += '<div class="taste_value">' + parseFloat(tastes_values[2]).toFixed(1) + '</div>';
									} else {
									  innerHTML += '<div class="taste_value" style="color: #b2b2b2">--</div>';
									}
								  innerHTML += '</div>';
								innerHTML += '</div>';
								////////////////////////////////////////

								innerHTML += '<div class="tastes_item">';
								  innerHTML += '<div class="tastes_title"><svg class="tastes_item_sweetness3030"><use xlink:href="#sweetness3030"/></svg>甘辛</div>';
								  innerHTML += '<div class="tastes_value_container">';
									innerHTML += '<div class="tastes_bar_container">';
									  innerHTML += '<input type="range" name="sweetness" step="0.1" min="0" max="5" value="' + tastes_values[3] + '" disabled="disabled" class="user_input_range">';
									innerHTML += '</div>';

									if(tastes_values[3]) {
									  innerHTML += '<div class="taste_value">' + parseFloat(tastes_values[3]).toFixed(1) + '</div>';
									} else {
									  innerHTML += '<div class="taste_value" style="color: #b2b2b2">--</div>';
									}
								  innerHTML += '</div>';
								innerHTML += '</div>';

								////////////////////////////////////////
								innerHTML += '<div class="tastes_item">';
								  innerHTML += '<div class="tastes_title"><svg class="tastes_item_umami3030"><use xlink:href="#umami3030"/></svg>旨味</div>';
								  innerHTML += '<div class="tastes_value_container">';
									innerHTML += '<div class="tastes_bar_container">';
									  innerHTML += '<input type="range" name="umami" step="0.1" min="0" max="5" value="' + tastes_values[4] + '" disabled="disabled" class="user_input_range">';
									innerHTML += '</div>';

									if(tastes_values[4]) {
									  innerHTML += '<div class="taste_value">' + parseFloat(tastes_values[4]).toFixed(1) + '</div>';
									} else {
									  innerHTML += '<div class="taste_value" style="color: #b2b2b2">--</div>';
									}
								  innerHTML += '</div>';
								innerHTML += '</div>';

								////////////////////////////////////////
								innerHTML += '<div class="tastes_item">';
								  innerHTML += '<div class="tastes_title"><svg class="tastes_item_acidity3030"><use xlink:href="#acidity3030"/></svg>酸味</div>';
								  innerHTML += '<div class="tastes_value_container">';
									innerHTML += '<div class="tastes_bar_container">';
									  innerHTML += '<input type="range" name="acidity" step="0.1" min="0" max="5" value="' + tastes_values[5] + '" disabled="disabled" class="user_input_range">';
									innerHTML += '</div>';

									if(tastes_values[5]) {
										innerHTML += '<div class="taste_value">' + parseFloat(tastes_values[5]).toFixed(1) + '</div>';
									} else {
										innerHTML += '<div class="taste_value" style="color: #b2b2b2">--</div>';
									}
								  innerHTML += '</div>';
								innerHTML += '</div>';

								////////////////////////////////////////
								innerHTML += '<div class="tastes_item">';
								  innerHTML += '<div class="tastes_title"><svg class="tastes_item_bitter1216"><use xlink:href="#bitter1216"/></svg>ビター</div>';
								  innerHTML += '<div class="tastes_value_container">';
									innerHTML += '<div class="tastes_bar_container">';
									  innerHTML += '<input type="range" name="bitter" step="0.1" min="0" max="5" value="' + tastes_values[6] + '" disabled="disabled" class="user_input_range">';
									innerHTML += '</div>';

									if(tastes_values[6]) {
									  innerHTML += '<div class="taste_value">' + parseFloat(tastes_values[6]).toFixed(1) + '</div>';
									} else {
									  innerHTML += '<div class="taste_value" style="color: #b2b2b2;">--</div>';
									}
								  innerHTML += '</div>';
								innerHTML += '</div>';

								////////////////////////////////////////
								innerHTML += '<div class="tastes_item">';
									innerHTML += '<div class="tastes_title"><svg class="tastes_item_yoin3030"><use xlink:href="#yoin3030"/></svg>余韻</div>';
									innerHTML += '<div class="tastes_value_container">';
										innerHTML += '<div class="tastes_bar_container">';
										  innerHTML += '<input type="range" name="yoin" step="0.1" min="0" max="5" value="' + tastes_values[7] + '" disabled="disabled" class="user_input_range">';
										innerHTML += '</div>';

										if(tastes_values[7]) {
										  innerHTML += '<div class="taste_value">' + parseFloat(tastes_values[7]).toFixed(1) + '</div>';
										} else {
										  innerHTML += '<div class="taste_value" style="color: #b2b2b2">--</div>';
										}
										  innerHTML += '</div>';
									innerHTML += '</div>';
								innerHTML += '</div>';
							} //if tastes

							//alert("innerHTML:" + innerHTML);
							innerHTML += '</a>'; //review
							$('#threads').append(innerHTML);

							//alert("path:" + sake[i].path);
							//break;

						} // for
						//alert("innerHTML:" + innerHTML);
					} // else

					$('#mainview_container').data('in_disp_from', $('#mainview_container').data('in_disp_from') + 25);
                    loadingFlag = false;
					//$('html, body').animate({scrollTop: $(window).scrollTop() - 8 }, '100');

			}).fail(function(data){
					removeLoading();
					alert("Failed:" + data);
			}).complete(function(data){
					// Loadingイメージを消す
					removeLoading();
			});
	   }
    });
});


jQuery(document).ready(function($) {
  $("body").wrapInner('<div id="wrapper"></div>');

  $('.multiple-heading').slick({
    autoplay: true,
    autoplaySpeed: 6000,
  });
});

</script>
</html>
