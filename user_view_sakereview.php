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
	<meta content='width=device-width, initial-scale=1' name='viewport'/>
	<title>日本酒レビュー [Sakenomo]</title>

	<link href="rateyo/jquery.rateyo.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/user_view_sakereview.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="rateyo/jquery.rateyo.js"></script>
</head>

<body>

	<?php
	include_once('images/icons/svg_sprite.svg');
	write_side_menu();
	write_HamburgerLogo();
	write_search_bar();
	write_Nonda();

	$username = $_GET['contributor'];
	$sake_id = $_GET['sake_id'];

	function sortByCount($a, $b) {
		return  $b['count'] - $a['count'];
	}

	function getFlavorValue($value, &$image_value, &$flavor_name) {

		$flavor_array = array(array("10", "greenapple4040", "青りんご"),
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

		$i = 0;

		for($i = 0; $i < count($flavor_array); $i++) {

			if($value == $flavor_array[$i][0]) {
				$image_value = $flavor_array[$i][1];
				$flavor_name = $flavor_array[$i][2];
			}
		}

		return 1;
	}

	if(!$db = opendatabase("sake.db"))
	{
		print('<div>データベース接続エラー</div>');
		print('</body></html>');
		return;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	//$sql = "SELECT COUNT(*) FROM FOLLOW_J, SAKE_J WHERE SAKE_J.sakagura_id = FOLLOW_J.sakagura_id AND SAKE_J.sake_id = '$sake_id'";
	$sql = "SELECT COUNT(*) FROM FOLLOW_J, SAKAGURA_J WHERE username = '$username' AND sakagura_id = id";

	$res = executequery($db, $sql);

	if(!$res)
	{
		print('<div>データベース接続エラー</div>');
		print('</body></html>');
		return;
	}

	$record = getnextrow($res);
	$count_sakagura = ($record["COUNT(*)"] == "") ? "--" : $record["COUNT(*)"];

	//////////////////////////////////////////////////////////////////////////////////////////////////
	$sql = "SELECT * FROM USERS_J WHERE username = '$username'";
	$res = executequery($db, $sql);

	if(!$res)
	{
		print('<div>データベース接続エラー</div>');
		print('</body></html>');
		return;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	//$sql = "SELECT COUNT(*) FROM TABLE_NONDA WHERE sake_id = '$sake_id'";
	$sql = "SELECT COUNT(*) FROM TABLE_NONDA, SAKE_J WHERE SAKE_J.sake_id = TABLE_NONDA.sake_id AND contributor = '$username'";

	$res = executequery($db, $sql);
	$rd = getnextrow($res);
	$nonda_count = ($rd["COUNT(*)"] == 0 || $rd["COUNT(*)"] == "") ? "no code" : $rd["COUNT(*)"];
	$count_result = $rd["COUNT(*)"];

	$tastes_all[0] = 0;
	$tastes_all[1] = 0;
	$tastes_all[2] = 0;
	$tastes_all[3] = 0;
	$tastes_all[4] = 0;
	$tastes_all[5] = 0;
	$tastes_all[6] = 0;
	$tastes_all[7] = 0;

	$sql = "SELECT * FROM TABLE_NONDA WHERE sake_id = '$sake_id'";
	$res = executequery($db, $sql);

	while($rd = getnextrow($res)) {
		$tastes_values = explode(',', $rd["tastes"]);
		$tastes_all[0] += $tastes_values[0];
		$tastes_all[1] += $tastes_values[1];
		$tastes_all[2] += $tastes_values[2];
		$tastes_all[3] += $tastes_values[3];
		$tastes_all[4] += $tastes_values[4];
		$tastes_all[5] += $tastes_values[5];
		$tastes_all[6] += $tastes_values[6];
		$tastes_all[7] += $tastes_values[7];
	}

	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	$count_tastes = array(0, 0, 0, 0, 0, 0, 0, 0);
	$tastes_all = array(0, 0, 0, 0, 0, 0, 0, 0);

	while($rd = getnextrow($res)) {

		$tastes_values = explode(',', $rd["tastes"]);

		if($tastes_values[0] && $tastes_values[0] != "") {
			$tastes_all[0] += $tastes_values[0];
			$count_tastes[0]++;
		}

		if($tastes_values[1] && $tastes_values[1] != "") {
			$tastes_all[1] += $tastes_values[1];
			$count_tastes[1]++;
		}

		if($tastes_values[2] && $tastes_values[2] != "") {
			$tastes_all[2] += $tastes_values[2];
			$count_tastes[2]++;
		}

		if($tastes_values[3] && $tastes_values[3] != "") {
			$tastes_all[3] += $tastes_values[3];
			$count_tastes[3]++;
		}

		if($tastes_values[4] && $tastes_values[4] != "") {
			$tastes_all[4] += $tastes_values[4];
			$count_tastes[4]++;
		}

		if($tastes_values[5] && $tastes_values[5] != "") {
			$tastes_all[5] += $tastes_values[5];
			$count_tastes[5]++;
		}

		if($tastes_values[6] && $tastes_values[6] != "") {
			$tastes_all[6] += $tastes_values[6];
			$count_tastes[6]++;
		}

		if($tastes_values[7] && $tastes_values[7] != "") {
			$tastes_all[7] += $tastes_values[7];
			$count_tastes[7]++;
		}
	}

	if($count_result > 0) {

		if($count_tastes[0] > 0)
			$tastes_all[0] = floor($tastes_all[0] / $count_tastes[0] * 100) / 100;

		if($count_tastes[1] > 0)
			$tastes_all[1] = floor($tastes_all[1] / $count_tastes[1] * 100) / 100;

		if($count_tastes[2] > 0)
			$tastes_all[2] = floor($tastes_all[2] / $count_tastes[2] * 100) / 100;

		if($count_tastes[3] > 0)
			$tastes_all[3] = floor($tastes_all[3] / $count_tastes[3] * 100) / 100;

		if($count_tastes[4] > 0)
			$tastes_all[4] = floor($tastes_all[4] / $count_tastes[4] * 100) / 100;

		if($count_tastes[5] > 0)
			$tastes_all[5] = floor($tastes_all[5] / $count_tastes[5] * 100) / 100;

		if($count_tastes[6] > 0)
			$tastes_all[6] = floor($tastes_all[6] / $count_tastes[6] * 100) / 100;

		if($count_tastes[7] > 0)
			$tastes_all[7] = floor($tastes_all[7] / $count_tastes[7] * 100) / 100;
	}

	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////

	$sql = "SELECT * FROM TABLE_NONDA WHERE sake_id = '$sake_id'";
	$res = executequery($db, $sql);

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// creating a lookup table
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$flavor_lookupTable = [];
	$lookupTable_count = 0;
	$bFound = false;

	while($rd = getnextrow($res)) {
		$flavor_array = explode(',', $rd["flavor"]);

		if(count($flavor_array) >= 1) {

			/* first flavor */
			for($j = 0; $j < count($flavor_lookupTable); $j++) {
				if($flavor_array[0] == $flavor_lookupTable[$j]['flavor']) {
					$flavor_lookupTable[$j]['count']++;
					$lookupTable_count++;
					$bFound = true;
					break;
				}
			}

			if(!$bFound && $flavor_array[0]) {
				$flavor_lookupTable[] = array('flavor' => $flavor_array[0], 'count' => 1);
				$lookupTable_count++;
			}

			$bFound = false;

			/* second flavor */
			if(count($flavor_array) > 1) {
				for($j = 0; $j < count($flavor_lookupTable); $j++) {
					if($flavor_array[1] == $flavor_lookupTable[$j]['flavor']) {
						$flavor_lookupTable[$j]['count']++;
						$lookupTable_count++;
						$bFound = true;
						break;
					}
				}

				if(!$bFound && $flavor_array[0]) {
					$flavor_lookupTable[] = array('flavor' => $flavor_array[1], 'count' => 1);
					$lookupTable_count++;
				}
			}

			$bFound = false;
		}
	}

	usort($flavor_lookupTable, 'sortByCount');

	/*
	$bFound2 = false;
	$lookupTable_count2 = 0;
	$flavor_lookupTable2 = [];

	while($rd = getnextrow($res)) {
		$flavor_array = explode(',', $rd["flavor"]);

		if(count($flavor_array) >= 1) {

			// first flavor
			for($j = 0; $j < count($flavor_lookupTable1); $j++) {
				if($flavor_array[0] == $flavor_lookupTable1[$j]['flavor']) {
					$flavor_lookupTable1[$j]['count']++;
					$lookupTable_count1++;
					$bFound1 = true;
					break;
				}
			}

			if(!$bFound1 && $flavor_array[0]) {
				$flavor_lookupTable1[] = array('flavor' => $flavor_array[0], 'count' => 1);
				$lookupTable_count1++;
			}

			// second flavor
			if(count($flavor_array) >= 2) {
				for($j = 0; $j < count($flavor_lookupTable2); $j++) {
					if($flavor_array[1] == $flavor_lookupTable2[$j]['flavor']) {
						$flavor_lookupTable2[$j]['count']++;
						$lookupTable_count2++;
						$bFound2 = true;
						break;
					}
				}

				if(!$bFound2 && $flavor_array[1]) {
					$flavor_lookupTable2[] = array('flavor' => $flavor_array[1], 'count' => 1);
					$lookupTable_count2++;
				}
			}

			$bFound1 = false;
			$bFound2 = false;
		}
	}
	usort($flavor_lookupTable2, 'sortByCount');
	*/

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// retrieve nonda information
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$sql = "SELECT TABLE_NONDA.sake_id AS sake_id, TABLE_NONDA.rank AS rank, TABLE_NONDA.write_date AS write_date, TABLE_NONDA.contributor AS contributor, sake_name, sake_read, sakagura_name, pref, sake_rank, subject, message, flavor, tastes, committed FROM SAKE_J, SAKAGURA_J, TABLE_NONDA WHERE TABLE_NONDA.sake_id='$sake_id' AND TABLE_NONDA.contributor='$username' AND (SAKE_J.sake_id=TABLE_NONDA.sake_id) AND (SAKAGURA_J.id=SAKE_J.sakagura_id)";
	$result = executequery($db, $sql);

	if(!$result)
	{
		print('<div>データベース接続エラー</div>');
		print('</body></html>');
		return;
	}

	$record = getnextrow($result);

	if($record["tastes"]) {
		$tastes_values = explode(',', $record["tastes"]);
	}
	else {
		$tastes_values = Array(0, 0, 0, 0, 0, 0, 0, 0);
	}

	print('<div id="all_container">');

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		print('<div id="user_information" data-sake_id=' .$record["sake_id"]
											.' data-sake_name="' .stripslashes($record["sake_name"])
											.'" data-sake_read="' .$record["sake_read"]
											.'" data-sakagura_name="' .$record["sakagura_name"]
											.'" data-pref=' .$record["pref"]
											.' data-write_date=' .$record["write_date"]
											.' data-contributor=' .$record["contributor"]
											.' data-subject="' .$record["subject"]
											.'" data-message="' .$record["message"]
											.'" data-rank="' .$record["rank"]
											.'" data-tastes="' .$record["tastes"]
											.'" data-flavor="' .$record["flavor"]
											.'" data-committed="' .$record["committed"]
											.'">');

			$sql = "SELECT * FROM USERS_J WHERE username = '$username' OR email = '$username'";
			$res = executequery($db, $sql);
			$row = getnextrow($res);

			if($row) {
				$path = "images/icons/noimage_user30.svg";
				$imagefile = null;
				$email = stripslashes($row["email"]);
				$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$email' AND status = 1";
				$result = executequery($db, $sql);
				$rd = getnextrow($result);

				if($rd) {
					$imagefile = $rd["filename"];
					$path = "images/profile/" .$imagefile;
				}
			}

			print('<div class="user_image_name_container">');
			//写真
			print('<div class="user_image_container">');
				print('<img src=' .$path .'>');
			print('</div>');

			//ユーザー名
			print('<div id="profile_name">' .$row["username"] .'</div>');

			//プロフィールボタン
			print('<div class="user_profile_trigger">');
				print('<p class="plus_minus_icon"><span></span><span></span></p>');
			print('</div>');
		print('</div>');

			//プロフィール
			print('<div class="user_profile_container">');
			/*print('<h1 class="user_profile_title">プロフィール</h1>');*/
			print('<div class="user_profile_content">');

				if($row['introduction']) {
					print('<p class="user_profile_text">' .$row['introduction'] .'</p>');
				}
				else {
					print('<p class="user_profile_text">ここにプロフィール本文が入りますここにプロフィール本文が入りますここにプロフィール本文が入りますここにプロフィール本文が入りますここにプロフィール本文が入りますここにプロフィール本文が入りますここにプロフィール本文が入りますここにプロフィール本文が入ります</p>');
				}

				print('<div class="user_profile_column_container">');
					print('<div class="user_profile_row">');
						if($row["bdate"]) {
							print('<div class="user_profile_column1">年代</div><div class="user_profile_column2">' .$row['bdate'] .'</div>');
						}
						else {
							print('<div class="user_profile_column1">年代</div><div class="user_profile_column2">ここに年代(例:30代)が入ります</div>');
						}
					print('</div>');
					print('<div class="user_profile_row">');
						if($row["sex"]) {
							print('<div class="user_profile_column1">性別</div><div class="user_profile_column2">' .$row['sex'] .'</div>');
						}
						else {
							print('<div class="user_profile_column1">性別</div><div class="user_profile_column2">ここに性別が入ります</div>');
						}
					print('</div>');
					print('<div class="user_profile_row">');
						print('<div class="user_profile_column1">現住所(都道府県)</div><div class="user_profile_column2">' .$row['pref'] .'</div>');
					print('</div>');
					print('<div class="user_profile_row">');
						print('<div class="user_profile_column1">利酒資格</div><div class="user_profile_column2">' .$row['certification'] .'</div>');
					print('</div>');
				print('</div>');

			print('</div>');
		print('</div>');

			//マイページタブリンク
			print('<div class="mypage_top_link_container">');
				print('<a href="user_view.php?username=' .$username .'" class="mypage_top_link"><svg class="mypage_top_link_person2020"><use xlink:href="#person2020"/></svg><span>マイページトップへ</span></a>');
			print("</div>");

		print("</div>");

		print('<div id="main_container">');
			print('<div id="link_review_container">');
				//飲んだ詳細
				print('<div id="user_sake_review">');

				  print('<div class="user_sake_container">');
				    //酒
				    print('<div class="user_sake_sake_container">');
				      print('<div class="user_sake_name_brewery_date_container">');
				        print('<a class="searchRow_link" href="sake_view.php?sake_id=' .$sake_id .'"><div class="user_sake_name">' .stripslashes($record[sake_name]) .'</div></a>');
				        print('<div class="user_sake_brewery_date_container">');
				          print('<div>' .$record['sakagura_name'] .' / ' .$record['pref'] .'</div>');
				        print('</div>');
				      print('</div>');
				    print('</div>');

				    //タブ
				    print('<div class="user_sake_tab_container">');
				      print('<div class="user_sake_tab_link"><svg class="user_sake_review3630 user_sake_icon"><use xlink:href="#review3630"/></svg></div>');
				      print('<div class="user_sake_border_line"></div>');
				      print('<div class="user_sake_tab_link"><svg class="user_sake_note3630 user_sake_icon"><use xlink:href="#note3630"/></svg></div>');
				      print('<div class="user_sake_border_line"></div>');
							if($_COOKIE['login_cookie'] == $record["contributor"]) {
								print('<div id="button_bbs" class="user_nonda_edit"><svg class="user_nonda_pen1616"><use xlink:href="#pen1616"/></svg>編集する</div>');
							}
				    print('</div>');

				    print('<div class="user_sake_tab_body">');

				      print('<!--レビュータブ-->');
				      print('<div class="user_sake_tab_panel">');

				        print('<!--レーティング-->');
								$rank_width = (($record[rank] / 5) * 100) .'%';
				        print('<div class="user_sake_rank">');
				          print('<div class="user_sake_star_rating">');
				            print('<div class="user_sake_star_rating_front" style="width: ' .$rank_width. '">★★★★★</div>');
				            print('<div class="user_sake_star_rating_back">★★★★★</div>');
				          print('</div>');
									if($record[rank]) {
										print('<span class="user_sake_sake_rate">' .number_format($record[rank], 1) .'</span>');
									} else {
										print('<span class="user_sake_sake_rate" style="color: #b2b2b2;">--</span>');
									}
				        print('</div>');

				        print('<!--レビューテキスト-->');
								if($record[subject] && $record[message]) {
									print('<div class="user_sake_subject_message_container">');
									  print('<div class="user_sake_subject">' .$record[subject] .'</div>');
									  print('<div class="user_sake_message">' .nl2br($record[message]) .'</div>');
									print('</div>');
								} else if($record[subject] && $record[message] == null) {
									print('<div class="user_sake_subject_message_container">');
					          print('<div class="user_sake_subject">' .$record[subject] .'</div>');
					        print('</div>');
								} else if($record[subject] == null && $record[message]) {
									print('<div class="user_sake_subject_message_container">');
					          print('<div class="user_sake_message">' .nl2br($record[message]) .'</div>');
					        print('</div>');
								} else {
									print('');
								}

				        print('<!--写真-->');

								$image_result = executequery($db, "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$username'");

								if($image_result != undefined) {
									$image_record = getnextrow($image_result);

									if($image_record) {
										print('<div class="user_sake_image_container">');

										$path = "images\\photo\\thumb\\". $image_record["filename"];
										print('<div class="user_sake_image"><img src="' .$path .'" data-desc = "' .$image_record["desc"] .'"></div>');

										while($image_record = getnextrow($image_result))
										{
											$path = "images\\photo\\thumb\\". $image_record["filename"];
											print('<div class="user_sake_image"><img src="' .$path .'" data-desc = "' .$image_record["desc"] .'"></div>');
										}
										print('</div>');
									} else {
										print('');
									}
								}

							////////////////////////////////////////
							print('</div>');

							print('<!--テイスティングノートタブ-->');

							print('<div class="user_sake_tab_panel note_caption_tab_panel">');
								print('<div class="user_sake_chart">');
									print('<div class="user_sake_chart_content">');
										print('<div class="user_sake_sort">');
											print('<div id="user_sake_sort_user">レビュアー</div>');
											print('<div id="user_sake_sort_all">みんな</div>');
										print('</div>');

										print('<!--レビュアーグラフ-->');
										print('<div id="user_sake_graph_user">');
											print('<!--フレーバー-->');
											print('<div class="user_sake_tasting_box_flavor">');
												print('<div class="user_sake_tasting_flavor_title_container">');
													print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_flavor3630"><use xlink:href="#flavor3630"/></svg></span>フレーバー</div>');
												print('</div>');

												print('<div class="user_sake_flavor_container">');

													if($record["flavor"])
													{
														$flavors_array = explode(',', $record["flavor"]);
														$image_value = "";
														$flavor_name = "";
														$count = 1;

														for($count = 0; $count < count($flavors_array) && $count < 2; $count++)
														{
															getFlavorValue($flavors_array[$count], $image_value, $flavor_name);

															print('<div id="user_sake_flavor_content">');

																print('<svg><use xlink:href="#' .$image_value .'"/></svg>');

																print('<div class="user_sake_flavor_caption">');
																	print('<span>' .$flavor_name .'</span>');
																print('</div>');

															print('</div>');
														}

														for(; $count < 2; $count++) {
															print('<div id="user_sake_flavor_content">');
																print('<div class="user_sake_flavor">');
																	print('<span>' .($count + 1) .'</span>');
																print('</div>');
																print('<div class="user_sake_flavor_caption">');
																	print('<span>--</span>');
																print('</div>');
																print('<div class="user_sake_flavor_ratio">');
																	print('<!--<span></span>-->');
																print('</div>');
															print('</div>');
														}

														//var htmlText = '<div class="nonda_flavor"><svg><use xlink:href="#' + $(this).data("img") + '"/></svg></div>';
													}
													else
													{
														for($i = 0; $i < 2; $i++) {
															print('<div id="user_sake_flavor_content">');
																print('<div class="user_sake_flavor">');
																	print('<span>' .($i + 1) .'</span>');
																print('</div>');
																print('<div class="user_sake_flavor_caption">');
																	print('<span style="color: #b2b2b2;">--</span>');
																print('</div>');
																print('<div class="user_sake_flavor_ratio">');
																	print('<!--<span></span>-->');
																print('</div>');
															print('</div>');
														}
													}
												print('</div>');

											print('</div>');

					            print('<!--香り-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_aroma2430"><use xlink:href="#aroma2430"/></svg></span>香り</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="aroma" step="0.1" min="0" max="5" value="' .$tastes_values[0] .'" disabled="disabled" class="user_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>弱い</span>');
					                  print('<span>強い</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_values[0]) {
														print('<span>' .number_format($tastes_values[0], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--ボディ-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_body2430"><use xlink:href="#body2430"/></svg></span>ボディ</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="body" step="0.1" min="0" max="5" value="' .$tastes_values[1] .'" disabled="disabled" class="user_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>味が軽い・淡麗</span>');
					                  print('<span>味が重い・濃醇</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_values[1]) {
														print('<span>' .number_format($tastes_values[1], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--クリア-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_clear3030"><use xlink:href="#clear3030"/></svg></span>クリア</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="clear" step="0.1" min="0" max="5" value="' .$tastes_values[2] .'" disabled="disabled" class="user_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>雑味がある</span>');
					                  print('<span>味がきれい</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_values[2]) {
														print('<span>' .number_format($tastes_values[2], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--甘辛-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_sweetness3030"><use xlink:href="#sweetness3030"/></svg></span>甘辛</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="sweetness" step="0.1" min="0" max="5" value="' .$tastes_values[3] .'" disabled="disabled" class="user_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>ドライ・辛口</span>');
					                  print('<span>スイート・甘口</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_values[3]) {
														print('<span>' .number_format($tastes_values[3], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--旨味-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_umami3030"><use xlink:href="#umami3030"/></svg></span>旨味</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="umami" step="0.1" min="0" max="5" value="' .$tastes_values[4] .'" disabled="disabled" class="user_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>弱い</span>');
					                  print('<span>強い</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_values[4]) {
														print('<span>' .number_format($tastes_values[4], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--酸味-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_acidity3030"><use xlink:href="#acidity3030"/></svg></span>酸味</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="acidity" step="0.1" min="0" max="5" value="' .$tastes_values[5] .'" disabled="disabled" class="user_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>弱い</span>');
					                  print('<span>強い</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_values[5]) {
														print('<span>' .number_format($tastes_values[5], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--ビター-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_bitter2430"><use xlink:href="#bitter2430"/></svg></span>ビター</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="bitter" step="0.1" min="0" max="5" value="' .$tastes_values[6] .'" disabled="disabled" class="user_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>弱い</span>');
					                  print('<span>強い</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_values[6]) {
														print('<span>' .number_format($tastes_values[6], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--余韻-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_yoin3030"><use xlink:href="#yoin3030"/></svg></span>余韻</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="yoin" step="0.1" min="0" max="5" value="' .$tastes_values[7] .'" disabled="disabled" class="user_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>長く続く</span>');
					                  print('<span>キレが良い</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_values[7]) {
														print('<span>' .number_format($tastes_values[7], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
											print('</div>');

										print('</div><!--user_sake_graph_user-->');

										print('<!--みんなグラフ-->');
										print('<div id="user_sake_graph_all">');
											print('<!--フレーバー-->');
											print('<div class="user_sake_tasting_box_flavor">');
												print('<div class="user_sake_tasting_flavor_title_container">');
													print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_flavor3630"><use xlink:href="#flavor3630"/></svg></span>フレーバー</div>');
												print('</div>');

												print('<div class="user_sake_flavor_container">');

													if($flavor_lookupTable > 0) {
														$image_value = "";
														$flavor_name = "";

														if(count($flavor_lookupTable) > 0) {
															getFlavorValue($flavor_lookupTable[0]['flavor'], $image_value, $flavor_name);
															$average_flavor = $flavor_lookupTable[0]['count'] / $lookupTable_count;

															print('<div id="user_sake_flavor_content">');
																print('<svg><use xlink:href="#' .$image_value .'"/></svg>');

																print('<div class="user_sake_flavor_caption">');
																	print('<span>' .$flavor_name .'</span>');
																print('</div>');

																print('<div class="user_sake_flavor_ratio">');
																	print('<span>' .number_format(($average_flavor * 100), 1) .'%</span>');
																print('</div>');
															print('</div>');
														}
														else
														{
															print('<div id="user_sake_flavor_content">');
																print('<div class="user_sake_flavor">');
																	print('<span>1</span>');
																print('</div>');
																print('<div class="user_sake_flavor_caption">');
																	print('<span style="color: #b2b2b2;">--</span>');
																print('</div>');
																print('<div class="user_sake_flavor_ratio">');
																	print('<span style="color: #b2b2b2;">--</span>');
																print('</div>');
															print('</div>');
														}

														if(count($flavor_lookupTable) > 1) {
															getFlavorValue($flavor_lookupTable[1]['flavor'], $image_value, $flavor_name);
															$average_flavor = $flavor_lookupTable[1]['count'] / $lookupTable_count;

															print('<div id="user_sake_flavor_content">');
																print('<svg><use xlink:href="#' .$image_value .'"/></svg>');

																print('<div class="user_sake_flavor_caption">');
																	print('<span>' .$flavor_name .'</span>');
																print('</div>');

																print('<div class="user_sake_flavor_ratio">');
																	print('<span>' .number_format(($average_flavor * 100), 1) .'%</span>');
																print('</div>');
															print('</div>');
														}
														else
														{
															print('<div id="user_sake_flavor_content">');
																print('<div class="user_sake_flavor">');
																	print('<span>2</span>');
																print('</div>');
																print('<div class="user_sake_flavor_caption">');
																	print('<span style="color: #b2b2b2;">--</span>');
																print('</div>');
																print('<div class="user_sake_flavor_ratio">');
																	print('<span style="color: #b2b2b2;">--</span>');
																print('</div>');
															print('</div>');
														}
													}
													else
													{
														for($i = 0; $i < 2; $i++) {
															print('<div id="user_sake_flavor_content">');
																print('<div class="user_sake_flavor">');
																	print('<span>' .($i + 1) .'</span>');
																print('</div>');
																print('<div class="user_sake_flavor_caption">');
																	print('<span>--</span>');
																print('</div>');
																print('<div class="user_sake_flavor_ratio">');
																	print('<!--<span></span>-->');
																print('</div>');
															print('</div>');
														}
													}
												print('</div>');
											print('</div>');

					            print('<!--香り-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_aroma2430"><use xlink:href="#aroma2430"/></svg></span>香り</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="aroma" step="0.1" min="0" max="5" value="' .$tastes_all[0] .'" disabled="disabled" class="everyone_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>弱い</span>');
					                  print('<span>強い</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_all[0] != 0) {
														print('<span>' .number_format($tastes_all[0], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--ボディ-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_body2430"><use xlink:href="#body2430"/></svg></span>ボディ</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="body" step="0.1" min="0" max="5" value="' .$tastes_all[1] .'" disabled="disabled" class="everyone_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>味が軽い・淡麗</span>');
					                  print('<span>味が重い・濃醇</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_all[1] != 0) {
														print('<span>' .number_format($tastes_all[1], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--クリア-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_clear3030"><use xlink:href="#clear3030"/></svg></span>クリア</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="clear" step="0.1" min="0" max="5" value="' .$tastes_all[2] .'" disabled="disabled" class="everyone_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>雑味がある</span>');
					                  print('<span>味がきれい</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_all[2] != 0) {
														print('<span>' .number_format($tastes_all[2], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--甘辛-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_sweetness3030"><use xlink:href="#sweetness3030"/></svg></span>甘辛</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="sweetness" step="0.1" min="0" max="5" value="' .$tastes_all[3] .'" disabled="disabled" class="everyone_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>ドライ・辛口</span>');
					                  print('<span>スイート・甘口</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_all[3] != 0) {
														print('<span>' .number_format($tastes_all[3], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--旨味-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_umami3030"><use xlink:href="#umami3030"/></svg></span>旨味</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="umami" step="0.1" min="0" max="5" value="' .$tastes_all[4] .'" disabled="disabled" class="everyone_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>弱い</span>');
					                  print('<span>強い</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_all[4] != 0) {
														print('<span>' .number_format($tastes_all[4], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--酸味-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_acidity3030"><use xlink:href="#acidity3030"/></svg></span>酸味</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="acidity" step="0.1" min="0" max="5" value="' .$tastes_all[5] .'" disabled="disabled" class="everyone_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>弱い</span>');
					                  print('<span>強い</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_all[5] != 0) {
														print('<span>' .number_format($tastes_all[5], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--ビター-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_bitter2430"><use xlink:href="#bitter2430"/></svg></span>ビター</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="bitter" step="0.1" min="0" max="5" value="' .$tastes_all[6] .'" disabled="disabled" class="everyone_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>弱い</span>');
					                  print('<span>強い</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_all[6] != 0) {
														print('<span>' .number_format($tastes_all[6], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					            print('<!--余韻-->');
					            print('<div class="user_sake_tasting_box">');
					              print('<div class="user_sake_tasting_title_container">');
					                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_yoin3030"><use xlink:href="#yoin3030"/></svg></span>余韻</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_bar_container">');
													print('<div class="tastingnote_input_range_container">');
														print('<input type="range" name="yoin" step="0.1" min="0" max="5" value="' .$tastes_all[7] .'" disabled="disabled" class="everyone_input_range">');
													print('</div>');
					                print('<div class="user_sake_tasting_caption">');
					                  print('<span>長く続く</span>');
					                  print('<span>キレが良い</span>');
					                print('</div>');
					              print('</div>');

					              print('<div class="user_sake_tasting_score">');
													if ($tastes_all[7] != 0) {
														print('<span>' .number_format($tastes_all[7], 1) .'</span>');
													} else {
														print('<span style="color: #b2b2b2;">--</span>');
													}
												print('</div>');
					            print('</div>');

					          print('</div><!--user_sake_graph_all-->');

					        print('</div><!--user_sake_chart-->');
									//フレーバーキャプション//////////////////////////////////////
									print('<div class="tastingnote_caption">');
										print('<div class="tastingnote_caption_title"><svg class="tastingnote_caption_help2020"><use xlink:href="#help2020"/></svg>フレーバーについて</div>');
										print('<div class="tastingnote_caption_invisible">');
											print('<div class="tastingnote_caption_text">フレーバーは味や香りなどから感じられる総合的な印象を表しています。日本酒の多様な風味をより具体的にイメージしていただけるように、Sakenomoではフレーバーを以下の34種類に分類しています。</div>');
											print('<div class="tastingnote_caption_content">');
												print('<div class="tastingnote_caption_content_title">フルーティタイプ</div>');
												print('<ul class="tastingnote_caption_item">');
													print('<li>青りんご</li><li>いちご</li><li>オレンジ</li><li>キウイ</li><li>グレープフルーツ</li><li>スイカ</li><li>梨</li><li>パイナップル</li><li>バナナ</li><li>ぶどう</li><li>マスカット</li><li>マンゴー</li><li>メロン</li><li>桃</li><li>洋梨</li><li>ライチ</li><li>りんご</li><li>レモン</li><li>花</li>');
												print('</ul>');

												print('<div class="tastingnote_caption_content_title">スッキリタイプ</div>');
												print('<ul class="tastingnote_caption_item">');
													print('<li>天然水・ミネラル</li><li>ソーダ水・ラムネ</li><li>ハーブ・若草・根菜</li><li>木</li>');
												print('</ul>');

												print('<div class="tastingnote_caption_content_title">コクタイプ</div>');
												print('<ul class="tastingnote_caption_item">');
													print('<li>ご飯・餅</li><li>ナッツ・豆</li><li>バター・クリーム・バニラ・チーズ</li><li>ドライフルーツ・乾物</li><li>しょうゆ・みりん</li><li>スパイス</li><li>カラメル</li><li>カカオ・ビターチョコ</li>');
												print('</ul>');

												print('<div class="tastingnote_caption_content_title">その他のタイプ</div>');
												print('<ul class="tastingnote_caption_item">');
													print('<li>セメダイン</li><li>ヨーグルト</li><li>その他</li>');
												print('</ul>');

											print('</div>');
										print('</div>');
									print('</div>');//tastingnote_caption
								print('</div>');
				      print('</div><!--user_sake_tab_panel-->');
				    print('</div><!--user_sake_tab_body-->');

				    print('<!--いいね-->');
				    /*print('<div class="user_sake_like_container">');
				      print('<a class="user_sake_like">');
				        print('<svg class="user_sake_like_icon"><use xlink:href="#like1616"/></svg>');
				        print('<div class="user_sake_like_title">いいね!</div>');
				      print('</a>');
				      print('<div class="user_sake_like_count">123</div>');
				    print('</div>');*/

				  print('</div>');

				print('</div>');

				//次へ前へ
				/*非表示中print('<div class="next_prev_container">');
					print('<div class="next_prev_bar">');
						print('<a id="prev_button" href="">前へ</a>');
						print('<a id="next_button" href="">次へ</a>');
					print("</div>");
				print('</div>');*/

			print("</div>");

			print('<div id="side_container">');
				print('<div class="ad_banner">');
					print('<img src="images/icons/notice_banner.svg">');
				print("</div>");
			print("</div>");
		print("</div>");

	print("</div>");

	writefooter();

	?>

<script type="text/javascript">

//hirasawa追加
//テイスティングソートキャプション
$(document).on('click', '.tastingnote_caption', function(e){
	$('.tastingnote_caption_invisible').slideToggle();
});

$(function() {

	$('#button_bbs').click(function() {

		var added_path = "";
		var bFound = false;
        var desc_array = [];

		//alert("sake_name:" + $('#user_information').data('sake_name'));

		$('.user_sake_image img').each(function() {

			var path_array = $(this).attr("src").split('\\');

			if(added_path == "")
				added_path = path_array[path_array.length - 1];
			else
				added_path += ', ' + path_array[path_array.length - 1];

			desc_array.push($(this).data('desc'));
			//alert("desc:" + $(this).data('desc'));
		});

		//alert("sake_id:" + $('#user_information').data('sake_id'));
		//alert("added_path:" + added_path);
		//alert("desc_array:" + desc_array);
		//alert("username:" + $('#user_information').data('committed'));

		$("body").trigger("open_nonda", [ $('#user_information').data('subject'),
										  $('#user_information').data('message'),
										  $('#user_information').data('rank'),
										  added_path,
										  desc_array,
										  $('#user_information').data('sake_id'),
										  $('#user_information').data('sake_name'),
										  $('#user_information').data('sake_read'),
										  $('#user_information').data('sakagura_name'),
										  $('#user_information').data('pref'),
										  $('#user_information').data('write_date'),
										  $('#user_information').data('contributor'),
										  $('#user_information').data('tastes'),
										  $('#user_information').data('flavor'),
										  $('#user_information').data('committed') ] );

	});

	$('.user_profile_trigger').click(function() {

		$('.user_profile_container').slideToggle();

		if ($(this).children(".plus_minus_icon").hasClass('active')) {
			// activeを削除
			$(this).children(".plus_minus_icon").removeClass('active');
		}
		else {
			// activeを追加
			$(this).children(".plus_minus_icon").addClass('active');
		}
	});
});

/* レビューモーダルウィンドウ内タブ */
$(function() {

	/* 初期表示 */
	$('.user_sake_tab_panel').hide();
	$('.user_sake_tab_panel').eq(0).show();
	$('.user_sake_tab_link').eq(0).addClass('is-active');

	/* クリックイベント */
	$('.user_sake_tab_link').each(function () {
		$(this).on('click', function () {
			  var index = $('.user_sake_tab_link').index(this);
			  $('.user_sake_tab_link').removeClass('is-active');
			  $(this).addClass('is-active');
			  $('.user_sake_tab_panel').hide();
			  $('.user_sake_tab_panel').eq(index).show();
		});
	});

	$('.user_sake_tab_link').click(function() {
		$('.user_sake_icon').css({"fill": "#8c8c8c"});
		$(this).find(".user_sake_icon").css({"fill": "#3f3f3f"});
	});

	$("#edit_user_close, #cancel_user_button").click(function() {
			$("#dialog_background").css({"display":"none"});
			$("#dialog_user").css({"display":"none"});
	});
});

/* レビューモーダルウィンドウ内タブ テイスティングソート */
$(function() {
	'use strict';
	var isA = 0; // 現在地判定
	var btnA = document.getElementById('user_sake_sort_user');
	var btnB = document.getElementById('user_sake_sort_all');
	var divA = document.getElementById('user_sake_graph_user');
	var divB = document.getElementById('user_sake_graph_all');

	function setState(isA) {
		btnA.className = (isA == 0) ? 'btn inactive' : 'btn'; // Aのとき非表示
		divA.className = (isA == 0) ? 'boxDisplay' : 'boxNone'; // Aのとき表示
		btnB.className = (isA == 1) ? 'btn inactive' : 'btn'; // Bのとき非表示
		divB.className = (isA == 1) ? 'boxDisplay' : 'boxNone'; // Bのとき表示
	}

	setState(0);

	btnA.addEventListener('click', function(){
		if (isA == 0) return;
			isA = 0;
			setState(0);
	});

	btnB.addEventListener('click', function(){
	if (isA == 1) return;
		isA = 1;
		setState(1);
	});

	$('#user_sake_sort_user').click(function() {
		$('.user_sake_sort div').css({"border": "2px solid #d2d2d2","color": "#8c8c8c"});
		$(this).css({"border": "2px solid #009696","color": "#000000"});
	});

	$('#user_sake_sort_all').click(function() {
		$('.user_sake_sort div').css({"border": "2px solid #d2d2d2","color": "#8c8c8c"});
		$(this).css({"border": "2px solid #A0C846","color": "#000000"});
	});

	$('#trigger_user_message').click(function() {
		$('#mail_user').val($('#profile_name').text());
	});
});

$(function() {

		function nl2br(str, is_xhtml) {
			var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

			return (str + '')
			.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
		}

		function GetFlavorNames(flavors)
		{
			var flavor_array = flavors.split(',');
			var ret_value = "";
			var item = "";
			var i = 0;

			for(i = 0; i < flavor_array.lenth; i++)
			{
				if(flavor_array[i] == 1)
					item = "フルーツ系";
				else if(flavor_array[i] == 2)
					item = "ハーブ・草葉系";
				else if(flavor_array[i] == 3)
					item = "木系";
				else if(flavor_array[i] == 4)
					item = "プレーン系";
				else if(flavor_array[i] == 5)
					item = "米・穀物系";
				else if(flavor_array[i] == 6)
					item = "ナッツ・木の実系";
				else if(flavor_array[i] == 7)
					item = "乳製品系";
				else if(flavor_array[i] == 8)
					item = "熟成系";
				else if(flavor_array[i] == 9)
					item = "その他";

				if(ret_value == "")
				{
					ret_value = item;
				}
				else
				{
					ret_value += '/' + item;
				}
			}

			return ret_value;
		}

		$(document).on('click', '.delete_nonda', function() {

				var write_date = $(this).attr('write_date');
				var tablename = $(this).attr('tablename');
				var sake_id = $(this).attr('sake_id');
				var imagepath = $(this).parent().find('.image_paths').val();
				var data = "write_date="+write_date+"&sake_id="+sake_id+"&imagepath="+imagepath;
				var obj = this;
				//alert("data:" +data);

				$.ajax({
						type: "post",
						url: "nonda_delete.php",
						data: data,
				}).done(function(xml){
						var str = $(xml).find("str").text();
						//alert("ret:" + str);

						if(str == "success")
						{
								//$("#follow").text(str);
								//$(obj).closest('div').fadeOut();
								$(obj).parent().parent().fadeOut();
						}

				}).fail(function(data){
						var str = $(xml).find("str").text();
						alert("Failed:" +str);
				});
		});

		function searchNonda(in_disp_from, disp_max, data, bCount)
		{
			  dispLoading("処理中...");

				//alert("SearchNonda:" + data);

				$.ajax({
						type: "POST",
						url: "nonda_list.php",
						data: data,
						dataType: 'json',

				}).done(function(data){

						var i = 0;
						var count_result = data[0].count;
						var sake = data[0].result;
						var nonda_values = 0;

						$('#sake_table').empty()

						if(count_result > 0)
						{
							for(i = 0; i < sake.length; i++)
							{
									var tablename = "table_review" + sake[i].sake_id;
									var innerText = '<div class="user_nonda_container">';

									innerText += '<div class="user_nonda_sake_container">';
									innerText += '<div class="user_nonda_sake_brewery_date_container">';
									innerText += '<div class="user_nonda_sake_name">' + sake[i].sake_name + '</div>';
									innerText += '<div class="user_nonda_brewery_date_container">';
									innerText += '	<div>' + sake[i].sakagura_name + ' / ' + sake[i].pref + '</div>';
									innerText += '	<div class="user_nonda_date"></div>';
									innerText += '</div>';
									innerText += '</div>';
									innerText += '<div class="user_nonda_button_container">';
									innerText += '<button class="custom_button"><span class="button_icon"><svg class="user_nonda_button_heart2020"><use xlink:href="#heart2020"/></svg></span><span class="button-text">飲んだ</span></button>';
									innerText += '</div>';
									innerText += '<button class="delete_nonda" sake_id = "' + sake[i].sake_id + '" write_date = "' + sake[i].write_date + '" style="border-radius:0px; background:transparent; width:28px"><img style="width:14px; margin:0px" src="images/icons/cross.svg"></button>';
									innerText += '</div>';

									////////////////////////////////////////
									////////////////////////////////////////
									var rank_width = (sake[i].sake_rank / 5) * 100 + '%';

									innerText += '<div class="nonda_rank">';
										innerText += '<div class="review_star_rating">';
											innerText += '<div class="review_star_rating_front" style="width:' + rank_width + '">★★★★★</div>';
											innerText += '<div class="review_star_rating_back">★★★★★</div>';
										innerText += '</div>';

									innerText += '<span class="review_sake_rate">' + sake[i].sake_rank + '</span>';
									innerText += '</div>';

									////////////////////////////////////////
									////////////////////////////////////////
									innerText += '<div class="user_nonda_subject_message_container">';
										innerText += '<div class="user_nonda_subject">' + sake[i].subject + '</div>';
										innerText += '<div class="user_nonda_message">' + nl2br(sake[i].message) + '</div>';
									innerText += '</div>';
									////////////////////////////////////////
									////////////////////////////////////////

									innerText += '<div class="review_container">';

									if(sake[i].path != null && sake[i].path != "")
									{
											var pathArray = sake[i].path.split(',');

											for(j = 0; j < pathArray.length; j++)
											{
												var path = "images\\photo\\thumb\\" + pathArray[j];
												innerText += '<div class="review_image">' + '<img class="preview" src="' + path + '">' + '</div>';
											}
									}
									else
									{
											var path = "images/icons/noimage160.svg";
											innerText += '<div class="review_image">' + '<img src="' + path + '">' + path + '</div>';
									}

									innerText += '</div>';

									////////////////////////////////////////
									////////////////////////////////////////
									if(sake[i].tastes != null)
									{
										var tastes_values = sake[i].tastes.split(',');
										var taste1 = ((tastes_values[0] / 5) * 100) + "%";
										var taste2 = ((tastes_values[1] / 5) * 100) + "%";
										var taste3 = ((tastes_values[2] / 5) * 100) + "%";
										var taste4 = ((tastes_values[3] / 5) * 100) + "%";
										var taste5 = ((tastes_values[4] / 5) * 100) + "%";
										var taste6 = ((tastes_values[5] / 5) * 100) + "%";
										var taste7 = ((tastes_values[6] / 5) * 100) + "%";
										var taste8 = ((tastes_values[7] / 5) * 100) + "%";

										innerText += '<div class="tastes">';

											innerText += '<div class="tastes_item">';
												innerText += '<div class="tastes_title"><svg class="tastes_item_flavor1816"><use xlink:href="#flavor1816"/></svg>フレーバー</div>';
												innerText += '<div class="taste_value_flavor">' + sake[i].flavor + '</div>';
												//alert("innerText2:" + innerText);
											innerText += '</div>';

											////////////////////////////////////////
											innerText += '<div class="tastes_border_line"></div>';
											////////////////////////////////////////

											innerText += '<div class="tastes_item">';
												innerText += '	<div class="tastes_title"><svg class="tastes_item_aroma1216"><use xlink:href="#aroma1216"/></svg>香り</div>';
												innerText += '	<div class="tastes_value_container">';
													innerText += '<div class="tastes_bar_container">';
													innerText += '<div style="width:' + taste1 + '" class="tastes_horizontal_bar"></div>';
													innerText += '<div class="tastes_frame_bar"></div>';
													innerText += '</div>';
													innerText += '<div class="taste_value">' + tastes_values[0] + '</div>';
												innerText += '	</div>';
											innerText += '</div>';

											////////////////////////////////////////
											innerText += '<div class="tastes_item">';
												innerText += '	<div class="tastes_title"><svg class="tastes_item_body1216"><use xlink:href="#body1216"/></svg>ボディ</div>';
												innerText += '	<div class="tastes_value_container">';
													innerText += '<div class="tastes_bar_container">';
													innerText += '<div style="width:' + taste2 + '" class="tastes_horizontal_bar"></div>';
													innerText += '<div class="tastes_frame_bar"></div>';
													innerText += '</div>';
													innerText += '<div class="taste_value">' + tastes_values[1] + '</div>';
												innerText += '	</div>';
											innerText += '</div>';

											////////////////////////////////////////
											innerText += '<div class="tastes_item">';
												innerText += '	<div class="tastes_title"><svg class="tastes_item_clear3030"><use xlink:href="#clear3030"/></svg>クリア</div>';
												innerText += '	<div class="tastes_value_container">';
													innerText += '<div class="tastes_bar_container">';
													innerText += '<div style="width:' + taste3 + '" class="tastes_horizontal_bar"></div>';
													innerText += '<div class="tastes_frame_bar"></div>';
													innerText += '</div>';
													innerText += '<div class="taste_value">' + tastes_values[2] + '</div>';
												innerText += '	</div>';
											innerText += '</div>';
											////////////////////////////////////////

											innerText += '<div class="tastes_item">';
												innerText += '	<div class="tastes_title"><svg class="tastes_item_sweetness3030"><use xlink:href="#sweetness3030"/></svg>甘辛</div>';
												innerText += '	<div class="tastes_value_container">';
													innerText += '<div class="tastes_bar_container">';
													innerText += '<div style="width:' + taste4 + '" class="tastes_horizontal_bar"></div>';
													innerText += '<div class="tastes_frame_bar"></div>';
													innerText += '</div>';
													innerText += '<div class="taste_value">' + tastes_values[3] + '</div>';
												innerText += '	</div>';
											innerText += '</div>';
											////////////////////////////////////////

											innerText += '<div class="tastes_item">';
												innerText += '	<div class="tastes_title"><svg class="tastes_item_umami3030"><use xlink:href="#umami3030"/></svg>旨味</div>';
												innerText += '	<div class="tastes_value_container">';
													innerText += '<div class="tastes_bar_container">';
													innerText += '<div style="width:' + taste5 + '" class="tastes_horizontal_bar"></div>';
													innerText += '<div class="tastes_frame_bar"></div>';
													innerText += '</div>';
													innerText += '<div class="taste_value">' + tastes_values[4] + '</div>';
												innerText += '	</div>';
											innerText += '</div>';
											////////////////////////////////////////

											innerText += '<div class="tastes_item">';
												innerText += '	<div class="tastes_title"><svg class="tastes_item_acidity3030"><use xlink:href="#acidity3030"/></svg>酸味</div>';
												innerText += '	<div class="tastes_value_container">';
													innerText += '<div class="tastes_bar_container">';
													innerText += '<div style="width:' + taste6 + '" class="tastes_horizontal_bar"></div>';
													innerText += '<div class="tastes_frame_bar"></div>';
													innerText += '</div>';
													innerText += '<div class="taste_value">' + tastes_values[5] + '</div>';
												innerText += '	</div>';
											innerText += '</div>';
											////////////////////////////////////////

											innerText += '<div class="tastes_item">';
												innerText += '	<div class="tastes_title"><svg class="tastes_item_bitter1216"><use xlink:href="#bitter1216"/></svg>ビター</div>';
												innerText += '	<div class="tastes_value_container">';
													innerText += '<div class="tastes_bar_container">';
													innerText += '<div style="width:' + taste7 + '" class="tastes_horizontal_bar"></div>';
													innerText += '<div class="tastes_frame_bar"></div>';
													innerText += '</div>';
													innerText += '<div class="taste_value">' + tastes_values[5] + '</div>';
												innerText += '	</div>';
											innerText += '</div>';
											////////////////////////////////////////

											innerText += '<div class="tastes_item">';
												innerText += '	<div class="tastes_title"><svg class="tastes_item_yoin3030"><use xlink:href="#yoin3030"/></svg>余韻</div>';
												innerText += '	<div class="tastes_value_container">';
													innerText += '<div class="tastes_bar_container">';
													innerText += '<div style="width:' + taste8 + '" class="tastes_horizontal_bar"></div>';
													innerText += '<div class="tastes_frame_bar"></div>';
													innerText += '</div>';
													innerText += '<div class="taste_value">' + tastes_values[5] + '</div>';
												innerText += '	</div>';
											innerText += '</div>';

										innerText += '</div>';
									} // tastes

									innerText += '</div>';

									$('#sake_table').append(innerText);
							 }
						}

						if(bCount == true)
						{
							//alert("count:" + count_result);
							//alert("count_result:" + count_result);
							var p_max = 25;
							var numPage = (count_result / p_max);
							var numPage = (numPage < 5) ? numPage : 5;
							var i = 1;

							$("#count_sake").val(count_result);

							innerText = '<button id="prev_review">前の' + p_max + '件</button>';
							innerText += '<button class="pageitems selected">' + i + '</button>';

							for(i++; i <= numPage; i++) {
								 innerText += '<button class="pageitems">' + i + '</button>';
							}

							if(count_result > p_max) {
								 innerText += '<button id="next_review" class="active">次の' + p_max + '件</button>';
							}
							else {
								 innerText += '<button id="next_review">次の' + p_max + '件</button>';
							}

							$('#review_result_turn_page').empty();
							$('#review_result_turn_page').append(innerText);
						}

						$('#in_disp_from').val(in_disp_from);
						var limit = ((in_disp_from + disp_max) >= $("#count_sake").val()) ? $("#count_sake").val() : (in_disp_from + disp_max);
						$('#disp_sake').text($('#in_disp_from').val() + " ～ " + limit + "/全" + $("#count_sake").val() + "件");

				}).fail(function(data){
						alert("Failed:" + data);
				}).complete(function(data){
						// Loadingイメージを消す
						removeLoading();
				});
	    }

		/* 次の飲みたい */
		$(document).on('click', '.nomitai_set #next_review', function() {

				var search_type = 1;
				var disp_max = 25;
				var in_disp_from = parseInt($("#in_disp_from").val()) + disp_max;
				var in_disp_to = ((in_disp_from + disp_max) > $("#count_sake").val()) ? $("#count_sake").val() : in_disp_from + disp_max;
				var username = <?php echo json_encode($username); ?>;
				var data = "search_type="+search_type+"&in_disp_from="+in_disp_from+"&disp_max="+disp_max.toString()+"&username="+username+"&orderby="+ $("#hidden_order_by").val()+"&pref="+$('span[name="sake_pref"]').attr("value")+"&special_name="+$('span[name="special_name"]').attr("value");
				var position = $('#review_result_turn_page .pageitems.selected').index();

				if(in_disp_from >= $("#count_sake").val())
					return false;

				if(position < $('#review_result_turn_page .pageitems').length)
				{
					//alert("position:" + position + " length:" + $('#review_result_turn_page .pageitems').length);
					$('#review_result_turn_page .pageitems.selected').removeClass("selected");
					$('#review_result_turn_page .pageitems:nth(' + position + ')').addClass("selected");
				}
				else
				{
					var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text());
					var i = 1;

					$('#review_result_turn_page .pageitems').each(function() {
							$(this).text(showPos + i);
							i++;
					});
				}

				searchSake(in_disp_from, disp_max, data, false);

			  $('#prev_review').addClass('active');

				$("#in_disp_from").val(in_disp_from);
				$("#in_disp_to").val(in_disp_to);
				$('#disp_sake').text((in_disp_from + 1) + ' ～ ' + in_disp_to + ' / 全' +　$("#count_sake").val());
		});

		/* 前の飲みたい */
		$(document).on('click', '.nomitai_set #prev_review', function() {

				var search_type = 1;
				var disp_max = 25;
				var in_disp_from = parseInt($("#in_disp_from").val()) - disp_max;
				var username = <?php echo json_encode($username); ?>;
				var data = "search_type="+search_type+"&in_disp_from="+in_disp_from+"&disp_max="+disp_max.toString()+"&username="+username+"&orderby="+ $("#hidden_order_by").val()+"&pref="+$('span[name="sake_pref"]').attr("value")+"&special_name="+$('span[name="special_name"]').attr("value");
				var position = $('#review_result_turn_page .pageitems.selected').index();

				if(in_disp_from < 0)
				{
					//alert("return false");
					return false;
				}

				if(position > 1)
				{
					//alert("position:" + position + " length:" + $('#review_result_turn_page .pageitems').length);
					$('#review_result_turn_page .pageitems.selected').removeClass("selected");
					$('#review_result_turn_page .pageitems:nth(' + (position - 2) + ')').addClass("selected");
				}
				else
				{
					var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text()) - 2;
					var i = 1;

					//alert("showPos:" + showPos + " pageitem:" + $('#review_result_turn_page .pageitems:nth(0)').text());

					$('#review_result_turn_page .pageitems').each(function() {
							$(this).text(showPos + i);
							i++;
					});
			   }

				searchSake(in_disp_from, disp_max, data, false);

				if(in_disp_from == 0)
					 $('#prev_review').removeClass('active');

				$("#in_disp_from").val(in_disp_from);
				$("#in_disp_from").val(in_disp_to);
				$('#disp_sake').text((in_disp_from + 1) + ' ～ ' + in_disp_to + ' / 全' +　$("#count_sake").val());
		});


		$(document).on('click', '#review_result_turn_page .pageitems', function(e){

				var search_type = 1;
				var disp_max = 25;
				var limit = 0;
				var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text());
				var position = $(this).index();

				var in_disp_from = (showPos + position - 2) * disp_max;
				var in_disp_to = in_disp_from + disp_max;
				var username = <?php echo json_encode($username); ?>;
				var data = "search_type="+search_type+"&in_disp_from="+in_disp_from+"&disp_max="+disp_max.toString()+"&username="+username+"&orderby="+ $("#hidden_order_by").val()+"&pref="+$('span[name="sake_pref"]').attr("value")+"&special_name="+$('span[name="special_name"]').attr("value");

				//alert("position:" + position);
				$('#review_result_turn_page .pageitems.selected').removeClass("selected");
				$('#in_disp_from').val((position - 1) * disp_max);

				limit = parseInt(parseInt($('#in_disp_from').val()) + disp_max);
				limit = (limit > $("#count_sake").val()) ? $("#count_sake").val() : limit;

				$('#in_disp_to').val(limit);
				$('#in_disp_from').val(in_disp_from);
				$('#in_disp_to').val(in_disp_to);

				if(in_disp_from + disp_max > $("#count_sake").val())
				{
					 $('#next_review').removeClass('active');
				}
				else
				{
					 $('#next_review').addClass('active');
				}

				if(in_disp_from > 0 && $("#count_sake").val() > disp_max)
				{
					 $('#prev_review').addClass('active');
				}
				else
				{
					 $('#prev_review').removeClass('active');
				}

				$('#review_result_turn_page .search_result_count').text((in_disp_from + 1) + '件目 ～ ' + $('#in_disp_to').val() + '件目を表示 / 全' + $('#count_sakagura').val() + '件');
				$('#review_result_turn_page .pageitems:nth(' + (position - 1) + ')').addClass("selected");

				searchSake(in_disp_from, disp_max, data, false);
		});

		$('#sake_sort span').click(function() {

				var search_type = 1;
				var disp_max = 25;
				var username = <?php echo json_encode($username); ?>;
				var in_disp_from = 0;
				var disp_max = 25;
				var data = "search_type="+search_type+"&in_disp_from="+in_disp_from+"&disp_max="+disp_max.toString()+"&username="+username+"&orderby="+ $(this).attr("value")+"&pref="+ $('span[name="sake_pref"]').attr("value")+ "&special_name="+ $('span[name="special_name"]').attr("value");

				//alert("data:" + data);
				//alert("sake_sort span click");
				$("#hidden_order_by").val($(this).attr("value"));
				$("#sake_sort span").css({"background": "#d2d2d2", "color": "#ffffff"});
				$(this).css({"background": "#28809E", "color": "#ffffff"});
				//alert('value:' + $(this).attr("value"));
				searchSake(in_disp_from, disp_max, data, false);
		});

		$("body").on("nonda_saved", function(event, sake_id, contributor, write_date, committed, title, ranke, message, imagepath, tastes, flavor) {
			location.reload();

		});

		$("body").on("nonda_deleted", function(event, sake_id) {
			var username = getCookie('login_cookie');
			window.open('user_view.php?username=' + username, '_self');
		});
});

jQuery(document).ready(function($) {

  $("body").wrapInner('<div id="wrapper"></div>');

	$("#tab_sake").addClass("nomitai_set");
	$('#tab_main').createTabs({
			text : $('#tab_main ul')
	});

	$('#cancel_user_button').click(function() {
			$("#dialog_addimage").css({"display":"none"});
	});

    $('#profile_name').click(function(){
		var username = $('#user_information').data('contributor');
        window.open('user_view.php?username=' + username, '_self');
    });
});

</script>
</body>
</html>
