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
	<title>飲食店ページ [Sakenomo]</title>
	<link rel="stylesheet" href="slick/slick-theme.css">
	<link rel="stylesheet" href="slick/slick.css">
	<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/inshokuten_view.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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

$id = $_GET['inshokuten_id'];
$username = $_COOKIE['login_cookie'];

if(!$db = opendatabase("sake.db")) {
	die("データベース接続エラー .<br />");
}

$inshokuten_id = $_GET['inshokuten_id'];

if(!$db = opendatabase("sake.db")) {
	die("データベース接続エラー .<br />");
}

$sql = "SELECT * FROM INSHOKUTEN_J WHERE inshokuten_id = '$inshokuten_id'";
$res = executequery($db, $sql);
$row = getnextrow($res);
$address = $row["inshokuten_pref"] ." " .$row["inshokuten_address"];

print('<div id="container">');
	if($row) {
		print('<input type="hidden" id="hidden_inshokuten_id" value="' .$row["inshokuten_id"]  .'">');
		print('<input type="hidden" id="hidden_inshokuten_region"  value="' .$row["inshokuten_region"]   .'">');
		print('<input type="hidden" id="hidden_inshokuten_develop" value="' .$row["inshokuten_develop"]  .'">');
		print('<input type="hidden" id="hidden_inshokuten_rank"    value="' .$row["inshokuten_rank"]     .'">');
		print('<input type="hidden" id="hidden_inshokuten_address" value="' .$row["inshokuten_address"]  .'">');
		print('<input type="hidden" id="hidden_inshokuten"				 value="' .$row["inshokuten"] .'">');
		print('<input type="hidden" id="hidden_inshokuten_sake"		 value="' .$row["inshokuten_sake"] .'">');

		print('<div id="panelheader">');
			// 飲食店名
			print('<div id="inshokuten_name">'.$row["inshokuten_name"].'</div>');
			print('<div id="inshokuten_english">'.stripslashes($row["inshokuten_english"]).'</div>');

			print('<ul class="inshokuten_info">');
				// 住所
				print('<li>');
					print('<span><svg class="inshokuten_info_map1216"><use xlink:href="#map1216"/></svg></span>');
					if($row["inshokuten_pref"] || $row["inshokuten_address"]) {
						print('<span id="pref">'.stripslashes($row["inshokuten_pref"]).'</span>');
						print('<span id="address">'.stripslashes($row["inshokuten_address"]).'</span>');
					} else {
						print('--');
					}
				print('</li>');

				// 電話番号
				print('<li>');
					print('<span><svg class="inshokuten_info_telephone1616"><use xlink:href="#telephone1616"/></svg></span>');
					print('<span id="phone">');
						if($row["inshokuten_phone"]) {
							print($row["inshokuten_phone"]);
						} else {
							print('--');
						}
					print('</span>');
				print('</li>');

				// 定休日
				print('<li>');
					print('<span><svg class="inshokuten_info_holiday1616"><use xlink:href="#holiday1616"/></svg></span>');
					print('<span id="inshokuten_closed">');
						if($row["inshokuten_closed"]) {
							print($row["inshokuten_closed"]);
						} else {
							print('--');
						}
					print('</span>');
				print('</li>');

				// お気に入り
				print('<li>');
					print('<span><svg class="inshokuten_info_people1616"><use xlink:href="#people1616"/></svg>お気に入り</span>');
					print('<span id="favorite_inshokuten_count">no code</span>');
				print('</li>');
			print('</ul>');

			print('<ul class="inshokuten_buttons">');
				$result = executequery($db, "SELECT * FROM FOLLOW_INSHOKUTEN_J WHERE username = '$username' AND inshokuten_id = '$id'");

				if($rd = getnextrow($result)) {
					print('<li id="follow" class="followed" value=true style="background:linear-gradient(#EDCACA, #ffffff); border:1px solid #FF4545; transition: 0.3s;"><svg class="inshokuten_buttons_pin1616" style="fill:#FF4545; transition: 0.3s;"><use xlink:href="#pin1616"/></svg>お気に入り</li>');
				} else {
					print('<li id="follow" value=false><svg class="inshokuten_buttons_pin1616"><use xlink:href="#pin1616"/></svg>お気に入り</li>');
				}
			print("</ul>");
		print('</div>');

		print('<div id="main_banner_container">');
			print('<div id="mainframe">');
				print('<div id="tab_main">');
					print('<ul class="simpleTabs">');
						print('<li><a class="active" href="#tab-sake"><span><svg class="simpleTabs_product3630"><use xlink:href="#product3630"/></svg><span>日本酒メニュー</span></span></a></li>');
						print('<li><a href="#tab-map"><span><svg class="simpleTabs_map2430"><use xlink:href="#map2430"/></svg><span>地図</span></span></a></li>');
					print('</ul>');

					// メニュータブ
					print('<div id="tab-sake" class="form-action show">');
						print('<div class="menu_sort_container">');
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
								print('<div class="inshokuten_menu_sort_icon"><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>');
								print('<div value="sake_read" class="click_sort_read">標準</div>');
								//print('<div value="write_date" class="click_sort_date">更新日</div>');
								//print('<div value="write_date" class="click_sort_ranking">ランキング</div>');
							print('</div>');
						print('</div>');

						////////////////////////////////////////
						print('<div class="product_count_container">');
							if($count_result > $p_max) {
								$p_next = $p_max;

								if(($p_max + 25) > $count_result) {
									$p_next = $count_result - $p_max;
								}

								print('<span id="disp_sake" class="navigate_page">'. ($in_disp_from + 1) .' ～ ' .$p_max .'&nbsp;/&nbsp;全' .$count_result .'件</span>');
							} else {
								if($count_result < $p_max) {
									$p_max = $count_result;
								}

								print('<span id="disp_sake" class="navigate_page">'. ($in_disp_from + 1) .'～' .$p_max .'件 / 全' .$count_result .'件</span>');
							}

							print('<div id="add_sake_menu_button"><svg class="add_sake_menu_pluslarge2020"><use xlink:href="#pluslarge2020"/></svg>メニュー追加</div>');
						print('</div>');

						////////////////////////////////////////
						print('<div id="search_sake_result">');
							print('<a class="searchRow" href="sake_view.php?sake_id=' .$record["sake_id"] .'">');

								$path = "images/icons/noimage160.svg";

								if($record["setting"] != "" && $record["setting"] != undefined) {
									$path = "images/photo/thumb/" .$record["setting"];
								} else {
									$result_set = executequery($db, "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$record["sake_id"] ."' LIMIT 8");

									if($rd = getnextrow($result_set)) {
										$path = "images/photo/thumb/" .$rd["filename"];
									}
								}

								print('<div class="search_sake_result_name_container">');
									print('<div class="search_sake_result_thumb_sake"><img src="' .$path .'"></div>');
									print('<div class="search_sake_result_sake_brewery_date_container">');
										print('<div class="search_sake_name"><!--' .stripslashes($record["sake_name"]) .'-->ここに日本酒名が入ります</div>');
										print('<div class="search_sake_result_brewery_date_container">');
											print('<div><!--'.$record["sakagura_name"].'-->ここに酒蔵名が入ります / <!--'.$record["pref"].'-->ここに都道府県が入ります</div>');
											print('<div class="search_sake_result_date">');
												$intime = gmdate("Y/m/d", $record["write_date"] + 9 * 3600);
												print($intime);
											print('</div>');
										print('</div>');
									print('</div>');
									print('<div class="sake_menu_delete_button_container">');
										print('<button class="sake_menu_delete_button"><svg class="sake_menu_delete_button_close2020"><use xlink:href="#close2020"/></svg></button>');
									print('</div>');
								print('</div>');
								////////////////////////////////////////
								// 酒ランク
								print('<div class="sake_rank">');
									print('<div class="sake_rank_star_rating">');
										print('<div class="sake_rank_star_rating_front" style="width: 75%">★★★★★</div>');
										print('<div class="sake_rank_star_rating_back">★★★★★</div>');
									print('</div>');
									print('<span class="sake_rank_sake_rate">0.00</span>');
								print('</div>');

								////////////////////////////////////////
								print('<div class="spec">');
									print('<div class="spec_item">');
										print('<div class="spec_title"><svg class="spec_item_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg>特定名称</div>');
										if($record["special_name"] && $record["special_name"] != "") {
											print('<div class="spec_info">'.GetSakeSpecialName($record["special_name"]).'</div>');
										} else {
											print('<div class="spec_info">--</div>');
										}
									print('</div>');
									////////////////////////////////////////
									print('<div class="spec_item">');
										print('<div class="spec_title"><svg class="spec_item_alc1616"><use xlink:href="#alc1616"/></svg>Alc度数</div>');
										print('<div class="spec_info">');
											if($record["alcohol_level"] && $record["alcohol_level"] != "") {
												$alcohol_array = explode(',', $record["alcohol_level"]);

												if(count($alcohol_array) == 1) {
													print($alcohol_array[0]);
												} else {
													if($alcohol_array[0] != null && $alcohol_array[1] != null)
														print($alcohol_array[0] ."～".$alcohol_array[1]."度");
													else if($alcohol_array[0] != null && $alcohol_array[1] == null)
														print($alcohol_array[0] ."度");
													else if($alcohol_array[0] == null && $alcohol_array[1] != null)
														print($alcohol_array[1] ."度以下");
												}
											} else {
												print('--');
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

													$sql = "SELECT SAKE_RICE.rice_name, SAKE_RICE.rice_kanji, SAKE_RICE.rice_kana FROM SAKE_RICE WHERE SAKE_RICE.rice_name = '$rice_entry[0]'";
													$sake_result = executequery($db, $sql);
													$rd = getnextrow($sake_result);

													if($rice_entry[1] == "1") {
														print("麹米:");
													} else if($rice_entry[1] == "2") {
														print("掛米:");
													}

													if($rice_entry[0] != "") {
														$rice_kanji = $rd ? $rd["rice_kanji"] : $rice_used;
														print($rice_kanji);
													}

													if($i < (count($rice_array) - 1)) {
														print(" / ");
													}
												}
											} else {
												print('--');
											}
										print("</div>");
									print("</div>");
									////////////////////////////////////////
									print('<div class="spec_item">');
										print('<div class="spec_title"><svg class="spec_item_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg>精米歩合</div>');
										print('<div class="spec_info">');
											if($record["seimai_rate"] && $record["seimai_rate"] != "") {
												$alcohol_array = explode(',', $record["alcohol_level"]);
												$seimai_array = explode(',', $record["seimai_rate"]);

												for($i = 0; $i < count($seimai_array); $i++) {
													if(count($rice_array) > 0 && $i < count($rice_array)) {
														$rice_entry = explode(',', $rice_array[$i]);

														if($rice_entry[1] == "1") {
															print("麹米:");
														} else if($rice_entry[1] == "2") {
															print("掛米:");
														}
													}

													if($seimai_array[$i] != "") {
														print($seimai_array[$i]."%");
													}

													if($i < (count($seimai_array) - 1) && $seimai_array[$i + 1] != "") {
														print(" / ");
													}
												}
											} else {
												print('--');
											}
										print("</div>");
									print("</div>");
									////////////////////////////////////////
									print('<div class="spec_item">');
										print('<div class="spec_title"><svg class="spec_item_nihonshudo1616"><use xlink:href="#nihonshudo1616"/></svg>日本酒度</div>');
										print('<div class="spec_info">');
											if($record["jsake_level"] && $record["jsake_level"] != "") {
												$syudo_array = explode(',', $record["jsake_level"]);

												if(count($syudo_array) == 1) {
													print($syudo_array[0]);
												} else if(count($syudo_array) > 1 && $syudo_array[0] != "") {
													if($syudo_array[0] != null && $syudo_array[1] != null)
														print($syudo_array[0] ."～" .$syudo_array[1]);
													else if($syudo_array[0] && $syudo_array[1] == null)
														print($syudo_array[0]);
													else if($syudo_array[0] == null && $syudo_array[1])
														print($syudo_array[1] ."以下");
												}
											} else {
												print('--');
											}
										print("</div>");
									print("</div>");
								print("</div>");
							print("</a>");
						print('</div>');//search_sake_result

						print('<div class="search_result_turn_page">');
							if($count_result > 25) {
								print('<button id="prev_inshokuten_sake"><svg class="prev_button_prev2020"><use xlink:href="#prev2020"/></svg></button>');
								$i = 1;

								print('<button class="pageitems" style="background:#22445B; color:#ffffff">' .$i .'</button>');

								for($i++; $i <= $numPage; $i++) {
									print('<button class="pageitems">' .$i .'</button>');
								}

								print('<button id="next_inshokuten_sake"><svg class="next_button_next2020"><use xlink:href="#next2020"/></svg></button>');
							}
						print("</div>");
					print('</div>');

					//地図タブ
					print('<div id="tab-map" class="form-action hide">');
						print('<div class="inshokuten_map_select">');
							print('<div class="inshokuten_map_button_container">');
								print('<div class="inshokuten_map_button"><svg class="inshokuten_map_map1216"><use xlink:href="#map1216"/><div>'.$row["inshokuten_name"].'</div></div>');
							print('</div>');
						print('</div>');
						print('<div id="inshokuten_map">');
							print("<iframe class=\"map\" frameborder=\"0\" scrolling=\"yes\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.co.jp/maps?hl=&amp;ie=UTF8&amp;q=loc:'.$address.'&amp;z=18&amp;iwloc=B&amp;output=embed\"></iframe>");
						print('</div>');
					print('</div>');
				print('</div>'); //tab_main

				print('<div class="updatebar_container">');
					print('<div id="updatebar">');
						if($_COOKIE['usertype_cookie'] == 9) {
							print('<a href="inshokuten_add_form.php?id=' .$row["inshokuten_id"] .'&inshokuten_name=' .$row["inshokuten_name"] .'" id="update_inshokuten"><svg class="update_inshokuten_penplus2020"><use xlink:href="#penplus2020"/></svg>編集する</a>');
							print('<a href="inshokuten_add_form.php" id="add_new_inshokuten"><svg class="add_new_inshokuten_pen1616"><use xlink:href="#pen1616"/></svg>追加する</a>');
						} else {
							print('<a href="user_login_form.php" id="update_inshokuten"><svg class="update_inshokuten_penplus2020"><use xlink:href="#penplus2020"/></svg>編集する</a>');
							print('<a href="user_login_form.php" id="add_new_inshokuten"><svg class="add_new_inshokuten_pen1616"><use xlink:href="#pen1616"/></svg>追加する</a>');
						}
					print('</div>');
				print('</div>');

				print('<div class="sns_buttons_container">');
					print('<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-text="'.stripslashes($row["inshokuten_name"]).' / Sakenomo" data-lang="en" data-show-count="false"></a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>');
					print('<div class="fb-share-button" data-href="https://sakenomo.xsrv.jp/sakenomo/inshokuten_view.php?inshokuten_id='.$inshokuten_id.'" data-layout="button" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fdrinksake.xsrv.jp%2Fhirasawa%2Fsake_view.php%3Fsake_id%3DA1010855763%23top&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"></a></div>');
					print('<div class="line-it-button" data-lang="ja" data-type="share-b" data-ver="3" data-url="https://sakenomo.xsrv.jp/sakenomo/inshokuten_view.php?inshokuten_id='.$inshokuten_id.'" data-color="default" data-size="small" data-count="false" style="display: none;"></div><script src="https://www.line-website.com/social-plugins/js/thirdparty/loader.min.js" async="async" defer="defer"></script>');
				print('</div>');

				print('<div id="inshokuten_spec">');
					print('<div><svg class="detail2430"><use xlink:href="#detail2430"/></svg>詳細情報</div>');
					print('<div class="edittable">');
						//店名
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">店名</div><div class="inshokutencolumn2">' .$row["inshokuten_name"] .'</div>');
						print('</div>');

						//住所
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">住所</div>');
							print('<div class="inshokutencolumn2">');
								print('<div>');
									print('<span>〒</span><span id="postal_code">');
										if($row["inshokuten_postal_code"]) {
											print($row["inshokuten_postal_code"]);
										} else {
											print('--');
										}
									print('</span>');
									print('<span id="address">');
										if($row["inshokuten_pref"] || $row["inshokuten_adress"]) {
											print($row["inshokuten_pref"].stripslashes($row["inshokuten_address"]));
										} else {
											print('--');
										}
									print('</span>');
								print('</div>');
								print('<div id="inshokuten_map2">');
									print("<iframe class=\"map\" frameborder=\"0\" scrolling=\"yes\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.co.jp/maps?hl=&amp;ie=UTF8&amp;q=loc:'.$address.'&amp;z=18&amp;iwloc=B&amp;output=embed\"></iframe>");
								print('</div>');
							print('</div>');
						print('</div>');

						//TEL
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">TEL</div>');
							print('<div class="inshokutencolumn2" id="phone">');
								if($row["inshokuten_phone"]) {
									print($row["inshokuten_phone"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//E-mail
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">Email</div>');
							print('<div class="inshokutencolumn2" id="email">');
								if($row["inshokuten_email"]) {
									print($row["inshokuten_email"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//アクセス
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">店舗までのアクセス</div>');
							print('<div class="inshokutencolumn2" id="access">');
								if($row["inshokuten_station_optional"]) {
									print($row["inshokuten_station_optional"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//営業時間
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">営業時間</div>');
							print('<div class="inshokutencolumn2" id="hours">');
								if($row["inshokuten_hours"]) {
									print($row["inshokuten_hours"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//定休日
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">定休日</div>');
							print('<div class="inshokutencolumn2" id="holiday">');
								if($row["inshokuten_holiday"]) {
									print($row["inshokuten_holiday"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//ジャンル
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">ジャンル</div>');
							print('<div class="inshokutencolumn2" id="genre">');
								if($row["inshokuten_main_genre"] != null && $row["inshokuten_sub_genre"] != null && $row["inshokuten_sub_genre2"] != null) {
									print($row["inshokuten_main_genre"] .' / '.$row["inshokuten_sub_genre"].' / '.$row["inshokuten_sub_genre2"]);
								} else if($row["inshokuten_main_genre"] != null && $row["inshokuten_sub_genre"] != null && $row["inshokuten_sub_genre2"] == null) {
									print($row["inshokuten_main_genre"] .' / '.$row["inshokuten_sub_genre"]);
								} else if($row["inshokuten_main_genre"] != null && $row["inshokuten_sub_genre"] == null && $row["inshokuten_sub_genre2"] == null) {
									print($row["inshokuten_main_genre"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//日本酒メニュー
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">日本酒メニュー</div>');
							print('<div class="inshokutencolumn2" id="sake_count">');
								if($row["inshokuten_sake_count"]) {
									print($row["inshokuten_sake_count"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//サービスの特徴
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">サービスの特徴</div>');
							print('<div class="inshokutencolumn2" id="store_style">');
								if($row["inshokuten_store_style"]) {
									print($row["inshokuten_store_style"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//予算
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">予算</div>');
							print('<div class="inshokutencolumn2" id="budget">');
								if($row["inshokuten_budget"]) {
									print($row["inshokuten_budget"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//予約
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">予約</div>');
							print('<div class="inshokutencolumn2" id="reservation">');
								if($row["inshokuten_reservation"]) {
									print($row["inshokuten_reservation"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//支払い方法
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">支払い方法</div>');
							print('<div class="inshokutencolumn2" id="payment">');
								if($row["inshokuten_payment"] != null && $row["inshokuten_payment_optional"] != null) {
									print($row["inshokuten_payment"] .' / '.$row["inshokuten_payment_optional"]);
								} else if($row["inshokuten_payment"] != null && $row["inshokuten_payment_optional"] == null) {
									print($row["inshokuten_payment"]);
								} else if($row["inshokuten_payment"] == null && $row["inshokuten_payment_optional"] != null) {
									print($row["inshokuten_payment_optional"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//席数
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">席数</div>');
							print('<div class="inshokutencolumn2" id="seats">');
								if($row["inshokuten_seats"]) {
									print($row["inshokuten_seats"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//駐車場
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">駐車場</div>');
							print('<div class="inshokutencolumn2" id="parking">');
								if($row["inshokuten_parking"] != null && $row["inshokuten_parking_optional"] != null) {
									print($row["inshokuten_parking"] .' / '.$row["inshokuten_parking_optional"]);
								} else if($row["inshokuten_parking"] != null && $row["inshokuten_parking_optional"] == null) {
									print($row["inshokuten_parking"]);
								} else if($row["inshokuten_parking"] == null && $row["inshokuten_parking_optional"] != null) {
									print($row["inshokuten_parking_optional"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//ホームページ・SNSアカウント
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">ホームページ・SNSアカウント</div>');
							print('<div class="inshokutencolumn2" id="url">');
								if($row["inshokuten_url"]) {
									$url_array = explode(',', $row["inshokuten_url"]);
									for($j = 0; $j < count($url_array); $j++)
									{
										print('<span><a href = "' .$url_array[$j] .'">' .$url_array[$j] .'</a></span>');
									}
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//オープン日
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">オープン日</div>');
							print('<div class="inshokutencolumn2" id="opened_date">');
								if($row["inshokuten_opened_date"]) {
									print($row["inshokuten_opened_date"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');

						//備考
						print('<div class="inshokutenrow">');
							print('<div class="inshokutencolumn1">備考</div>');
							print('<div class="inshokutencolumn2" id="remarks">');
								if($row["inshokuten_remarks"]) {
									print($row["inshokuten_remarks"]);
								} else {
									print('--');
								}
							print('</div>');
						print('</div>');
					print('</div>'); //edittable
				print('</div>'); //inshokuten_spec
			print('</div>'); //mainframe

			print('<div id="banner_frame">');
				print('<div id="ad1"><img src="images/icons/notice_banner.jpg"></div>');
			print("</div>");
		print('</div>'); //main_banner_container
	}
print("</div>"); //container
writefooter();

print('<div id="dialog_add_inshokuten_background">');
	print('<div class="dialog_table">');
		print('<div class="dialog_table-cell">');
			print('<div id="dialog_add_inshokuten">');
				print('<span class="close_add_inshokuten">');
					print('<button class="close_add_inshokuten_button"><svg class="close_add_inshokuten_prev2020"><use xlink:href="#prev2020"/></svg></button>');
				print('</span>');

				print('<div class="add_inshokuten_title">日本酒メニュー 追加</div>');
				print('<div class="add_inshokuten_note">');
					print('以下のフォームに日本酒名を入力し、追加したい日本酒を選択して「決定する」を押してください。');
				print('</div>');

				print('<div class="add_inshokuten_form_container">');
					print('<div class="add_inshokuten_form">');
						print('<input id="add_sake_input" autocomplete="off" placeholder="日本酒名を入力してください" type="text" name="add_sake_name">');
					print('</div>');
					print('<ul id="add_sake_content"></ul>');
				print('</div>');

				print('<div class="add_inshokuten_button_container">');
					print('<input type="button" name="add_inshokuten_ok" value="決定する">');
				print('</div>');
			print('</div>');
		print('</div>');
	print('</div>');
print('</div>');
?>

<script type="text/javascript">

$(function() {
	//メニュー追加ページ日本酒の選択モーダルウィンドウ
	$('#add_sake_menu_button').click(function() {
		var touch_start_y;
		// タッチしたとき開始位置を保存しておく
		$(window).on('touchstart', function(event) {
			touch_start_y = event.originalEvent.changedTouches[0].screenY;
		});
		// スワイプしているとき
		$(window).on('touchmove.noscroll', function(event) {
			var current_y = event.originalEvent.changedTouches[0].screenY,
			height = $('#dialog_add_inshokuten_background').outerHeight(),
			is_top = touch_start_y <= current_y && $('#dialog_add_inshokuten_background')[0].scrollTop === 0,
			is_bottom = touch_start_y >= current_y && $('#dialog_add_inshokuten_background')[0].scrollHeight - $('#dialog_add_inshokuten_background')[0].scrollTop === height;

			// スクロール対応モーダルの上端または下端のとき
			if (is_top || is_bottom) {
				// スクロール禁止
				event.preventDefault();
			}
		});

		// スクロール禁止
		$('html, body').css('overflow', 'hidden');
		$("#dialog_add_inshokuten_background").css({"display":"flex"});
	});

	$('.close_add_inshokuten_button').click(function() {
		// イベントを削除
		$(window).off('touchmove.noscroll');
		$('html, body').css('overflow', '');
		$("#dialog_add_inshokuten_background").css({"display":"none"});
	});

	// 追加する酒の検索
	$('#add_sake_input').on('keyup', function() {
		var inputText = $("#add_sake_input").val();
		var count = inputText.length;
		var search_limit = 24;
		var search_type = 1;
		var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

		if(count >= 1) {
			$.ajax({
				type: "POST",
				url: "auto_complete.php",
				data: data,
				dataType: 'json',
			}).done(function(data) {
				//alert("succeded:" + data + "length:" + data.length);
				$('#add_sake_content').empty();

				for(var i = 0; i < data.length; i++) {
					//alert("filename: " + data[i].filename);
					$('#add_sake_content').append('<li class="message_class" sake_id="' + data[i].sake_id + '"><svg class="add_sake_content_icon"><use xlink:href="#bottle1616"/></svg><div><span>' + data[i].sake_name + '</span><span>' + data[i].sakagura_name + '</span></div></li>');
				}

				$("#add_sake_content").css({"visibility": "visible"});

				$("#add_sake_content li").click(function () {
					if($(this).hasClass("checked")) {
						$(this).removeClass("checked");
						this.style.backgroundColor = "";
						this.style.color = "#000"
					} else {
						$(this).addClass("checked");
						this.style.backgroundColor = "#FFC88D";
						this.style.color = "#404040"
					}
				});

			}).fail(function(data) {
				//alert("Failed:" + data);
			});
		} else {
			$('#add_sake_content').empty();
		}
	}); //keyup
});

jQuery(document).ready(function($) {

	$("body").wrapInner('<div id="wrapper"></div>');

	$('#tab_main').createTabs({
		text : $('#tab_main ul')
	});

	$("body").fadeIn(400);

});
</script>
</body>
</html>
