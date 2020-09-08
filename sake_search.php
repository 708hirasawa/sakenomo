<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("nonda.php");
require_once("searchbar.php");
//require_once("portal_menu.php");
//require_once("user_mail.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <meta http-equiv="Content-Script-Type" content="text/javascript">
  <meta content='width=device-width, initial-scale=1, user-scalable=0' name='viewport'/>
  <title>日本酒総合情報サイト [Sakenomo]</title>
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
</head>

<?php

print('<body>');
  include_once('images/icons/svg_sprite.svg');
  write_side_menu();
  write_HamburgerLogo();
  write_search_bar();
  write_Nonda();
  //write_portal_menu();
  //write_manage_mail();

  print('<div id="container">');
      $username = $_COOKIE['login_cookie'];

      if(!$db = opendatabase("sake.db"))
      {
        die("データベース接続エラー .<br />");
      }

      print('<div id="mainview_container">');
        print('<div id="mainview">');

/*特集*******************/
print('<ul class="slider multiple-heading">');
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
print("</ul>");

/*新着レビュー*******************/
// $sql = "SELECT * FROM TABLE_NONDA, SAKE_J, SAKAGURA_J WHERE SAKE_J.sake_id = TABLE_NONDA.sake_id AND SAKE_J.sakagura_id = SAKAGURA_J.id AND (subject IS NOT '' OR message IS NOT '') ORDER BY update_date DESC LIMIT 10";
//$sql = "SELECT USERS_J.username AS username, USERS_J.pref AS pref, contributor, update_date, TABLE_NONDA.sake_id as sake_id, sake_name, sakagura_name, TABLE_NONDA.write_date as write_date, TABLE_NONDA.rank as rank, subject, message, flavor, tastes, committed FROM TABLE_NONDA, SAKE_J, SAKAGURA_J, USERS_J WHERE TABLE_NONDA.sake_id = SAKE_J.sake_id AND SAKE_J.sakagura_id = SAKAGURA_J.id AND USERS_J.email = TABLE_NONDA.contributor AND EXISTS (SELECT * FROM SAKE_IMAGE WHERE TABLE_NONDA.sake_id = SAKE_IMAGE.sake_id) ORDER BY UPDATE_DATE DESC LIMIT 16";
$sql = "SELECT USERS_J.username AS username, USERS_J.pref AS user_pref, bdate, sex, USERS_J.address, certification, age_disclose, sex_disclose, address_disclose, certification_disclose, SAKAGURA_J.pref AS pref, contributor, update_date, TABLE_NONDA.sake_id as sake_id, sake_name, sakagura_name, TABLE_NONDA.write_date as write_date, TABLE_NONDA.rank as rank, subject, message, flavor, tastes, committed FROM TABLE_NONDA, SAKE_J, SAKAGURA_J, USERS_J WHERE TABLE_NONDA.sake_id = SAKE_J.sake_id AND SAKE_J.sakagura_id = SAKAGURA_J.id AND USERS_J.email = TABLE_NONDA.contributor AND (subject IS NOT '' OR message IS NOT '') ORDER BY UPDATE_DATE DESC LIMIT 16";

$result = executequery($db, $sql);

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

			$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$contributor' AND status = 1";
			$res4 = executequery($db, $sql);
			$rd = getnextrow($res4);

			if($rd) {
				$path = "images/profile/" .$rd["filename"];
			}

              print('<div class="nonda_user_image_container">');
				print('<img src="' .$path .'">');

              print('</div>');

              print('<div class="nonda_user_name_container">');
                print('<div class="nonda_user_name">' .$record["username"] .'</div>');
                print('<div class="nonda_user_profile_date_container">');
                  print('<div class="nonda_user_profile">');

					$profile = "";

				    //20代後半/女性/和歌山県/利酒師(SSI認定)
					if($record["age_disclose"] == 1 && $record["bdate"] != "--") {
						$profile = $record["bdate"];
					}

					if($record["sex_disclose"] == 1 && $record["sex"] != "") {

						if($profile != "")
							$profile .= "/" .$record["sex"];
						else
							$profile = $record["sex"];
					}

					if($record["address_disclose"] == 1 && $record["user_pref"] != "") {
						if($profile != "")
							$profile .= "/" .$record["user_pref"];
						else
							$profile = $record["user_pref"];
					}

					if($record["certification_disclose"] == 1 && $record["certification"] != "") {
						if($profile != "")
							$profile .= "/" .$record["certification"];
						else
							$profile = $record["certification"];
					}
		
					print($profile);
			
				  print('</div>');

                  print('<div class="nonda_date">' .gmdate("Y/m/d", $record["update_date"] + 9 * 3600) .'</div>');
                print('</div>');
              print('</div>');

            print('</div>');
            ////////////////////////////////////////
            ////////////////////////////////////////
            print('<div class="nonda_sake_container">');
              print('<div class="nonda_sake_name">' .$record["sake_name"] .'</div>');
              print('<div class="nonda_brewery_pref_container">' .$record["sakagura_name"] .' / ' .$record["pref"] .'</div>');
            print('</div>');
            ////////////////////////////////////////
            ////////////////////////////////////////
            $rank_width = (($record[rank] / 5) * 100) .'%';
            print('<div class="nonda_rank">');
              print('<div class="review_star_rating">');
                print('<div class="review_star_rating_front" style="width:' .$rank_width. '">★★★★★</div>');
                print('<div class="review_star_rating_back">★★★★★</div>');
              print('</div>');
              if($record[rank]) {
                print('<span class="review_sake_rate">' .number_format($record["rank"], 1) .'</span>');
              } else {
                print('<span class="review_sake_rate" style="color: #b2b2b2;">--</span>');
              }
            print('</div>');
            ////////////////////////////////////////
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
            ////////////////////////////////////////
            $contributor = $record["contributor"];
            $image_result = executequery($db, "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$contributor'");
            $image_record = getnextrow($image_result);

            if($image_record && $image_record != "")
            {
              print('<div class="review_container">');
                $path = "images\\photo\\thumb\\". $image_record["filename"];
                print('<div class="review_image"><img src="' .$path .'" data-desc = "' .$image_record["desc"] .'"></div>');

                while($image_record = getnextrow($image_result))
                {
                  $path = "images\\photo\\thumb\\". $image_record["filename"];
                  print('<div class="review_image"><img src="' .$path .'" data-desc = "' .$image_record["desc"] .'"></div>');
                }
              print('</div>');
            } else {
              print('');
            }

            ////////////////////////////////////////
            ////////////////////////////////////////
            /*hirasawa非表示中if($record["tastes"])
            {
              $tastes_values = explode(',', $record["tastes"]);*/

              /*$taste1 = (($tastes_values[0] / 5) * 100) ."%";
              $taste2 = (($tastes_values[1] / 5) * 100) ."%";
              $taste3 = (($tastes_values[2] / 5) * 100) ."%";
              $taste4 = (($tastes_values[3] / 5) * 100) ."%";
              $taste5 = (($tastes_values[4] / 5) * 100) ."%";
              $taste6 = (($tastes_values[5] / 5) * 100) ."%";*/

              print('<div class="tastes">');

                print('<div class="tastes_item">');
                  print('<div class="tastes_title"><svg class="tastes_item_flavor1816"><use xlink:href="#flavor1816"/></svg>フレーバー</div>');
                  //print('<div class="taste_value_flavor">' .GetFlavorNames($record["flavor"]) .'</div>');
                  print('<div class="taste_value_flavor">ここにフレーバーが入ります</div>');
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

              print('</div>');/*tastes*/
            /*hirasawa非表示中} else {
              print('');
            }*/
          print('</a>');/*review*/
        }

      //hirasawa非表示中}
    print("</div>"); // thread;

print('</div>');

/*おすすめ*******************/
/*print('<div class="recommend_sake">');
  print('<div><svg class="top_recommend3630"><use xlink:href="#recommend3630"/></svg>おすすめの日本酒</div>');

  $sql = "SELECT SAKE_J.sake_id as sake_id, sake_name, sakagura_name, pref, filename FROM SAKE_J, SAKAGURA_J, SAKE_IMAGE WHERE SAKE_J.sakagura_id = SAKAGURA_J.id AND SAKE_J.sake_id = SAKE_IMAGE.sake_id ORDER BY RANDOM() LIMIT 8";
  $res = executequery($db, $sql);
  write_sake_list($db, $res);

print("</div>");*/

/*急上昇*******************/
/*print('<div class="trend_access">');
  print('<div><svg class="top_rising3630"><use xlink:href="#rising3630"/></svg>急上昇</div>');

  $sql = "SELECT SAKE_J.sake_id as sake_id, sake_name, sakagura_name, pref FROM SAKE_J, SAKAGURA_J WHERE SAKE_J.sakagura_id = SAKAGURA_J.id ORDER BY RANDOM() LIMIT 12";
  $res = executequery($db, $sql);
  write_sake_list($db, $res);

print("</div>");*/

/*ランキング*******************/
/*print('<div class="ranking">');
  print('<div>');
    print('<div><svg class="top_ranking3630"><use xlink:href="#ranking3630"/></svg>ランキング</div>');
    print('<div class="ranking_sort">');
      print('<div value="sort_all">すべて</div>');
      print('<div value="sort_month">月間</div>');
      print('<div value="sort_west">東日本</div>');
      print('<div value="sort_east">西日本</div>');
      print('<div value="sort_ginjo">吟醸酒</div>');
      print('<div value="sort_daiginjo">大吟醸酒</div>');
    print("</div>");
  print('</div>');

  $sql = "SELECT SAKE_J.sake_id as sake_id, sake_name, sakagura_name, pref FROM SAKE_J, SAKAGURA_J WHERE SAKE_J.sakagura_id = SAKAGURA_J.id ORDER BY RANDOM() LIMIT 12";
  $res = executequery($db, $sql);
  write_sake_list($db, $res);
print('</div>');*/

/********************/
          print("</div>");/*mainview閉じタグ*/

          /*バナーサイド*******************/
          print('<div id="banner_frame">');
            print('<div id="ad1"><img src="images/icons/notice_banner.svg"></div>');

			print('<div class="recommend_sake">');
				print('<div><svg class="top_recommend3630"><use xlink:href="#recommend3630"/></svg>おすすめの日本酒</div>');

				$sql = "SELECT SAKE_J.sake_id as sake_id, sake_name, sakagura_name, pref, filename FROM SAKE_J, SAKAGURA_J, SAKE_IMAGE WHERE SAKE_J.sakagura_id = SAKAGURA_J.id AND SAKE_J.sake_id = SAKE_IMAGE.sake_id ORDER BY RANDOM() LIMIT 8";
				$res = executequery($db, $sql);
				write_sake_list($db, $res);

			print("</div>");


              //write_sakagura($db);
              /**/

            /*全国の酒蔵*******************/
            /*一時的に非表示write_sakagura($db);*/

            /*日本酒を飲める飲食店非表示中*******************/
            /*write_inshokuten($db);*/

            /*日本酒を買える酒販店非表示中*******************/
            /*write_syuhanten($db);*/

            /*全国のレビュアー*******************/
            /*$sql = "SELECT username, imagefile FROM USERS_J ORDER BY RANDOM() LIMIT 20";
            $res = executequery($db, $sql);
            $i = 1;

            print('<div class="sake_users">');
              print('<div>');
                print('<div><svg class="top_reviewers3030"><use xlink:href="#reviewers3030"/></svg>全国のレビュアー</div>');
                print('<div class="ranking_sort">');
                  print('<div value="review_number">レビュー数</div>');
                  print('<div value="access_number">アクセス数</div>');
                print('</div>');
              print('</div>');

              print('<ul class="slider multiple-item">');
                while($row = getnextrow($res))
                {
                  $path = "images/icons/noimage_user30.svg";
                  if($row["imagefile"])
					$path = "images/profile/" .$row["imagefile"];

                  print('<li class="users" url="user_view.php?username='.$rd["contributor"].'">');
                    print('<a class="users_link" href="user_view.php?username='.$rd["contributor"].'">');
                      print('<div class="sake_users_image_container">');
                        print('<img id="' .$path .'" src="' .$path  .'">');
                      print('</div>');

                      print('<div class="sake_users_crown_username_container">');
                        print('<div class="sake_users_crown_container"><svg class="top_crown2218"><use xlink:href="#crown2218"/></svg><span>No.' .$i .'</span></div>');
                        print('<div class="sake_users_username_container">');
                          print('<h1>' .$row["username"] ."</h1>");
                        print('</div>');
                      print('</div>');
                    $i++;
                    print('</a>');
                  print('</li>');
                }
              print('</ul>');
            print('</div>');*/

            /*print('<div id="ad2"><img src="images/ad/ad2.jpg"></div>');
            print('<div id="calendar"></div>');*/

        print("</div>");
        /********************/
      print("</div>");/*mainview_container閉じタグhirasawa*/

      writefooter();

      ?>
  </div> <!-- container -->
</body>

<script type="text/javascript">


$(function() {

	$('.multiple-sake').slick({
	infinite: true,
	centerMode: true,
	centerPadding: '0px',
	slidesToShow: 2,
	swipeToSlide: true,

	responsive: [{
		  breakpoint: 1260, settings: {
			centerMode: true,
			centerPadding: '100px',
			slidesToShow: 6,}
		  },
		  {
		  breakpoint: 1200, settings: {
			centerMode: true,
			centerPadding: '70px',
			slidesToShow: 6,}
		  },
		  {
		  breakpoint: 1140, settings: {
			centerMode: true,
			centerPadding: '40px',
			slidesToShow: 6,}
		  },
		  {
		  breakpoint: 1080, settings: {
			centerMode: true,
			centerPadding: '15px',
			slidesToShow: 6,}
		  },
		  {
		  breakpoint: 1020, settings: {
			centerMode: true,
			centerPadding: '145px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 960, settings: {
			centerMode: true,
			centerPadding: '110px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 900, settings: {
			centerMode: true,
			centerPadding: '85px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 840, settings: {
			centerMode: true,
			centerPadding: '60px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 780, settings: {
			centerMode: true,
			centerPadding: '30px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 720, settings: {
			centerMode: true,
			centerPadding: '0px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 660, settings: {
			centerMode: true,
			centerPadding: '130px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 600, settings: {
			centerMode: true,
			centerPadding: '100px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 540, settings: {
			centerMode: true,
			centerPadding: '70px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 480, settings: {
			centerMode: true,
			centerPadding: '55px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 447, settings: {
			centerMode: true,
			centerPadding: '40px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 415, settings: {
			centerMode: true,
			centerPadding: '34px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 401, settings: {
			centerMode: true,
			centerPadding: '24px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 376, settings: {
			centerMode: true,
			centerPadding: '18px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 370, settings: {
			centerMode: false,
			slidesToShow: 2,}
		  }
		]
	});

	$('.multiple-brewery, .multiple-restaurant, .multiple-store, .multiple-item').slick({
		centerMode: true,
		centerPadding: '0px',
		slidesToShow: 1,
		swipeToSlide: true,

		responsive: [{
		  breakpoint: 1260, settings: {
			centerMode: true,
			centerPadding: '100px',
			slidesToShow: 3,}
		  },
		  {
		  breakpoint: 1200, settings: {
			centerMode: true,
			centerPadding: '70px',
			slidesToShow: 3,}
		  },
		  {
		  breakpoint: 1140, settings: {
			centerMode: true,
			centerPadding: '40px',
			slidesToShow: 3,}
		  },
		  {
		  breakpoint: 1080, settings: {
			centerMode: true,
			centerPadding: '15px',
			slidesToShow: 3,}
		  },
		  {
		  breakpoint: 1020, settings: {
			centerMode: true,
			centerPadding: '145px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 960, settings: {
			centerMode: true,
			centerPadding: '110px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 900, settings: {
			centerMode: true,
			centerPadding: '85px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 840, settings: {
			centerMode: true,
			centerPadding: '60px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 780, settings: {
			centerMode: true,
			centerPadding: '30px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 720, settings: {
			centerMode: true,
			centerPadding: '0px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 660, settings: {
			centerMode: true,
			centerPadding: '130px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 600, settings: {
			centerMode: true,
			centerPadding: '100px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 540, settings: {
			centerMode: true,
			centerPadding: '70px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 480, settings: {
			centerMode: true,
			centerPadding: '55px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 447, settings: {
			centerMode: true,
			centerPadding: '40px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 415, settings: {
			centerMode: true,
			centerPadding: '34px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 401, settings: {
			centerMode: true,
			centerPadding: '24px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 376, settings: {
			centerMode: true,
			centerPadding: '18px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 370, settings: {
			centerMode: false,
			slidesToShow: 1,}
		  }
		]
	});
});

jQuery(document).ready(function($) {

  $("body").wrapInner('<div id="wrapper"></div>');

  /////////////////////////////////////////////////
  $('.multiple-heading').slick({
    autoplay: true,
    autoplaySpeed: 6000,
  });


  /*$('#calendar').datepicker({
  		inline: true,
  		firstDay: 1,
  		showOtherMonths: true,
  		dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
  });*/

  /*hirasawa削除$(".static").draggable({
    start: function(event, ui) {
		//alert("no click");
        $(this).addClass('noclick');
    }
  });*/

  /*hirasawa削除$(".sakeitem_click").draggable({
    start: function(event, ui) {
        $(this).addClass('noclick');
    }
  });*/

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // recommended sake events
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  /*$(".multiple-message li span").click(function() {
			if ($(this).hasClass('noclick')) {
					$(this).removeClass('noclick');
			}
			else {
				var url = $(this).attr('value');
				window.open(url + this.id, '_self');
		 }
  });hirasawa削除*/

  /*hirasawa削除$(".static").click(function() {
			if ($(this).hasClass('noclick')) {
					$(this).removeClass('noclick');
			}
			else {
				var url = $(this).attr('value');
				window.open(url + this.id, '_self');
		 }
  });*/

  /*hirasawa削除$(".sakeitem_click").click(function() {
			if($(this).hasClass('noclick')) {
					$(this).removeClass('noclick');
			}
			else {
					var url = $(this).attr('url');
					window.open(url + $(this).attr('sake_id'), '_self');
		  }
  });*/

  ////////////////////////////////////////////////////////////////////////////
});

</script>
</html>
