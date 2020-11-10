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

  if(!$db = opendatabase("sake.db")) {
    die("データベース接続エラー .<br />");
  }

  print('<div id="mainview_container">');
    print('<div id="mainview">');

      /*新着レビュー*******************/
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
              print('<div class="nonda_sake_container">');
                print('<div class="nonda_sake_name">' .$record["sake_name"] .'</div>');
                print('<div class="nonda_brewery_pref_container">' .$record["sakagura_name"] .' / ' .$record["pref"] .'</div>');
              print('</div>');
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
              print('</div>');//tastes
            print('</a>');//review
          }
        print("</div>"); //thread;
      print('</div>');//new_review
    print("</div>");//mainview
    ////////////////////////////////////////
    /*バナーサイド*******************/
    print('<div id="banner_frame">');
      print('<div id="ad1"><img src="images/icons/notice_banner.svg"></div>');

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
    print("</div>");
    ////////////////////////////////////////

  print("</div>");//mainview_container

  writefooter();
?>
</div> <!-- container -->
</body>

<script type="text/javascript">

jQuery(document).ready(function($) {
  $("body").wrapInner('<div id="wrapper"></div>');

  $('.multiple-heading').slick({
    autoplay: true,
    autoplaySpeed: 6000,
  });
});

</script>
</html>
