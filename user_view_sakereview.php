<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("nonda.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==" crossorigin="anonymous"></script>
	<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="rateyo/jquery.rateyo.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-1X2ZRV0BES"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-1X2ZRV0BES');
	</script>
</head>

<body>

	<?php
	include_once('images/icons/svg_sprite.svg');
	write_side_menu();
	write_HamburgerLogo();
	write_Nonda();

	$contributor = $_GET['contributor'];
	$sake_id = $_GET['sake_id'];
	$username = $_COOKIE['login_cookie'];

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
	$sql = "SELECT COUNT(*) FROM FOLLOW_J, SAKAGURA_J WHERE username = '$contributor' AND sakagura_id = id";

	$res = executequery($db, $sql);

	if(!$res) {
		print('<div>データベース接続エラー</div>');
		print('</body></html>');
		return;
	}

	$record = getnextrow($res);
	$count_sakagura = ($record["COUNT(*)"] == "") ? "--" : $record["COUNT(*)"];

	//////////////////////////////////////////////////////////////////////////////////////////////////
	$sql = "SELECT * FROM USERS_J WHERE username = '$contributor'";
	$res = executequery($db, $sql);

	if(!$res) {
		print('<div>データベース接続エラー</div>');
		print('</body></html>');
		return;
	}

	$row = getnextrow($res);
	$nickname = $row["nickname"];

	/* twitter 有無 */
	if(!$nickname) {
		if($row['oauth_uid']) {
			$nickname = $row["username"];
		}
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	//$sql = "SELECT COUNT(*) FROM TABLE_NONDA WHERE sake_id = '$sake_id'";
	$sql = "SELECT COUNT(*) FROM TABLE_NONDA, SAKE_J WHERE SAKE_J.sake_id = TABLE_NONDA.sake_id AND contributor = '$contributor'";

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
		$tastes_all[0] += floatval($tastes_values[0]);
		$tastes_all[1] += floatval($tastes_values[1]);
		$tastes_all[2] += floatval($tastes_values[2]);
		$tastes_all[3] += floatval($tastes_values[3]);
		$tastes_all[4] += floatval($tastes_values[4]);
		$tastes_all[5] += floatval($tastes_values[5]);
		$tastes_all[6] += floatval($tastes_values[6]);
		$tastes_all[7] += floatval($tastes_values[7]);
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

	$sql = "SELECT TABLE_NONDA.sake_id AS sake_id, TABLE_NONDA.rank AS rank, TABLE_NONDA.write_date AS write_date, TABLE_NONDA.contributor AS contributor, sake_name, sake_read, sakagura_name, pref, sake_rank, subject, message, flavor, tastes, committed FROM SAKE_J, SAKAGURA_J, TABLE_NONDA WHERE TABLE_NONDA.sake_id='$sake_id' AND TABLE_NONDA.contributor='$contributor' AND (SAKE_J.sake_id=TABLE_NONDA.sake_id) AND (SAKAGURA_J.id=SAKE_J.sakagura_id)";
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

	print('<div class="post_header_container">');
		print('<div class="post_header">');
			print('<a href="#"><svg class="post_header_prev2020"><use xlink:href="#prev2020"/></svg></a>');
			print('<div class="post_header_title">投稿</div>');
		print('</div>');
	print('</div>');

	print('<div id="all_container">');

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		print('<div id="user_information" data-sake_id=' .$record["sake_id"]
											.' data-sake_name="' .stripslashes($record["sake_name"])
											.'" data-sake_read="' .$record["sake_read"]
											.'" data-sakagura_name="' .$record["sakagura_name"]
											.'" data-pref=' .$record["pref"]
											.' data-write_date=' .$record["write_date"]
											.' data-contributor="' .$record["contributor"]
											.'" data-nickname="' .$nickname
											.'" data-subject="' .$record["subject"]
											.'" data-message="' .$record["message"]
											.'" data-rank="' .$record["rank"]
											.'" data-tastes="' .$record["tastes"]
											.'" data-flavor="' .$record["flavor"]
											.'" data-committed="' .$record["committed"]
											.'">');

			$sql = "SELECT * FROM USERS_J WHERE username = '$contributor' OR email = '$contributor'";
			$res = executequery($db, $sql);
			$row = getnextrow($res);

			if($row) {
				$path = "images/icons/noimage_user30.svg";

				if($row['oauth_uid'] && ($row['picture'] && $row['picture'] != "")) {
					$path = $row['picture'];
				}
				else {
					$imagefile = null;
					$contributor = stripslashes($row["username"]);
					$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$contributor' AND status = 1";
					$result = executequery($db, $sql);
					$rd = getnextrow($result);

					if($rd) {
						$imagefile = $rd["filename"];
						$path = "images/profile/" .$imagefile;
					}
				}
			}

			print('<div class="user_image_name_container">');
				//写真
				print('<div class="user_image_container">');
					print('<img src=' .$path .'>');
				print('</div>');

				//ユーザー名
				print('<div id="profile_name">' .$nickname .'</div>');

				//プロフィールボタン
				print('<div class="user_profile_trigger">');
					print('<p class="plus_minus_icon"><span></span><span></span></p>');
				print('</div>');
			print('</div>');

			//プロフィール
			print('<div class="user_profile_container">');
				print('<div class="user_profile_content">');

					print('<div class="user_profile_column_container">');
						print('<div class="user_profile_row">');
							print('<div class="user_profile_column1">年代 </div>');

							if($row["bdate"] != 0) {
								$bdateArray = explode("-", $row["bdate"]);
								$bdate = str_pad($bdateArray[2], 4, 0, STR_PAD_LEFT) . str_pad ($bdateArray[0], 2, 0, STR_PAD_LEFT) . str_pad ($bdateArray[1], 2, 0, STR_PAD_LEFT);

								$today = date('Ymd');

								$age = floor(($today - $bdate ) / 100000) * 10;

								print('<div class="user_profile_column2">' .$age .'代</div>');
							} else {
								print('<div class="user_profile_column2" style="color: #b2b2b2;">--</div>');
							}

						print('</div>');
						print('<div class="user_profile_row">');
							print('<div class="user_profile_column1">現住所 </div>');

							if($row["pref"]) {
								print('<div class="user_profile_column2">' .$row["pref"] .'</div>');
							} else {
								print('<div class="user_profile_column2" style="color: #b2b2b2;">--</div>');
							}
						print('</div>');
						/*print('<div class="user_profile_row">');
							print('<div class="user_profile_column1">利酒資格 </div>');

							if($row["certification"]) {
								$replace = str_replace('1', '利酒師', $row["certification"]);
								$replace = str_replace('2', '酒匠', $replace);
								print('<div class="user_profile_column2">' .$replace .'</div>');
							} else {
								print('<div class="user_profile_column2" style="color: #b2b2b2;">--</div>');
							}

						print('</div>');*/
					print('</div>');

					if($row['introduction']) {
						print('<p class="user_profile_text">' .$row['introduction'] .'</p>');
					}
					else {
						print('<p class="user_profile_text" style="color: #b2b2b2">自己紹介は登録されていません</p>');
					}

				print('</div>');
			print('</div>');

			//マイページタブリンク
			print('<div class="mypage_top_link_container">');
				print('<a href="user_view.php?username=' .$contributor .'" class="mypage_top_link"><svg class="mypage_top_link_person2020"><use xlink:href="#person2020"/></svg><span>マイページトップへ</span></a>');
			print("</div>");

		print("</div>");

		print('<div id="main_container">');
			print('<div id="link_review_container">');
				print('<div id="user_sake_review">');
					print('<div class="user_sake_container">');
						print('<div class="user_sake_sake_container">');
							print('<div class="user_sake_name_brewery_date_container">');
								print('<a class="searchRow_link" href="sake_view.php?sake_id=' .$sake_id .'"><div class="user_sake_name">' .stripslashes($record['sake_name']) .'</div></a>');
								print('<div class="user_sake_brewery_date_container">');
									print('<div>' .$record['sakagura_name'] .' / ' .$record['pref'] .'</div>');
								print('</div>');
							print('</div>');
						print('</div>');

						print('<div class="user_sake_tab_container">');
							print('<div class="user_sake_tab_link"><svg class="user_sake_review3630 user_sake_icon"><use xlink:href="#review3630"/></svg></div>');
							print('<div class="user_sake_border_line"></div>');
							print('<div class="user_sake_tab_link"><svg class="user_sake_note3630 user_sake_icon"><use xlink:href="#note3630"/></svg></div>');
							print('<div class="user_sake_border_line"></div>');
							if($_COOKIE['username'] == $record["contributor"]) {
								print('<div id="button_bbs" class="user_nonda_edit"><svg class="user_nonda_pen1616"><use xlink:href="#pen1616"/></svg>編集する</div>');
							}
						print('</div>');

						print('<div class="user_sake_tab_body">');

							print('<!--レビュータブ-->');
							print('<div class="user_sake_tab_panel">');

								print('<!--レーティング-->');
								$rank_width = ((floatval($record['rank']) / 5) * 100) .'%';
								print('<div class="user_sake_rank">');
									print('<div class="user_sake_star_rating">');
										print('<div class="user_sake_star_rating_front" style="width: ' .$rank_width. '">★★★★★</div>');
										print('<div class="user_sake_star_rating_back">★★★★★</div>');
									print('</div>');
									if($record['rank']) {
										print('<span class="user_sake_sake_rate">' .number_format($record['rank'], 1) .'</span>');
									} else {
										print('<span class="user_sake_sake_rate" style="color: #b2b2b2;">--</span>');
									}
								print('</div>');

								print('<!--レビューテキスト-->');
								if($record['subject'] && $record['message']) {
									print('<div class="user_sake_subject_message_container">');
										print('<div class="user_sake_subject">' .$record['subject'] .'</div>');
										print('<div class="user_sake_message">' .nl2br($record['message']) .'</div>');
									print('</div>');
								} else if($record['subject'] && $record['message'] == null) {
									print('<div class="user_sake_subject_message_container">');
										print('<div class="user_sake_subject">' .$record['subject'] .'</div>');
									print('</div>');
								} else if($record['subject'] == null && $record['message']) {
									print('<div class="user_sake_subject_message_container">');
										print('<div class="user_sake_message">' .nl2br($record['message']) .'</div>');
									print('</div>');
								} else {
									print('');
								}

								print('<!--写真-->');

								$image_result = executequery($db, "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$contributor'");

								if($image_result != 'undefined') {
									$image_record = getnextrow($image_result);

									if($image_record) {
										print('<div class="user_sake_image_container">');

										$path = "images\\photo\\". $image_record["filename"];
										print('<div class="user_sake_image" data-contributor="' .$image_record["contributor"] .'" data-desc = "' .$image_record["desc"] .'" data-added_date="' .gmdate("Y/m/d", $image_record["added_date"] + 9 * 3600) .'"><img src="' .$path .'"></div>');

										while($image_record = getnextrow($image_result))
										{
											$path = "images\\photo\\". $image_record["filename"];
											print('<div class="user_sake_image" data-contributor="' .$image_record["contributor"] .'" data-desc = "' .$image_record["desc"] .'" data-added_date="' .gmdate("Y/m/d", $image_record["added_date"] + 9 * 3600) .'"><img src="' .$path .'"></div>');
										}
										print('</div>');
									} else {
										print('');
									}
								}

							////////////////////////////////////////
							print('</div>');

							print('<div class="user_sake_tab_panel note_caption_tab_panel">');
								print('<div class="tasting_note">');
									print('<div>テイスティングノートではレビュアーとみんなの評価を比較することができます。</div>');
								print('</div>');
								print('<div class="tasting_chart_caption_container">');
									print('<div class="tastingnote_chart">');

										//フレーバー//////////////////////////////////////
										print('<div class="users_flavor_wrapper">');
											print('<div class="users_flavor_title"><div></div>フレーバー</div>');
											print('<div class="tastingnote_sort">');
												print('<div id="tastingnote_sort_user"><span></span>レビュアーの評価</div>');
												print('<div id="tastingnote_sort_all"><span></span>みんなの評価</div>');
											print('</div>');

											print('<div id="user_sake_graph_user">');
												print('<div class="tastingnote_flavor_container">');
													if($record["flavor"]) {
														$flavors_array = explode(',', $record["flavor"]);
														$image_value = "";
														$flavor_name = "";
														$count = 1;

														for($count = 0; $count < count($flavors_array) && $count < 2; $count++) {
															getFlavorValue($flavors_array[$count], $image_value, $flavor_name);
															print('<div id="tastingnote_flavor_content">');
																print('<svg><use xlink:href="#' .$image_value .'"/></svg>');
																print('<div class="tastingnote_flavor_caption">');
																	print('<h6>' .$flavor_name .'</h6>');
																print('</div>');
															print('</div>');
														}

														for(; $count < 2; $count++) {
															print('<div id="tastingnote_flavor_content">');
																print('<div class="tastingnote_flavor">');
																	print('<span>' .($count + 1) .'</span>');
																print('</div>');
																print('<div class="tastingnote_flavor_caption">');
																	print('<h6 style="color: #b2b2b2;">--</h6>');
																print('</div>');
															print('</div>');
														}

													} else {
														for($i = 0; $i < 2; $i++) {
															print('<div id="tastingnote_flavor_content">');
																print('<div class="tastingnote_flavor">');
																	print('<span>' .($i + 1) .'</span>');
																print('</div>');
																print('<div class="tastingnote_flavor_caption">');
																	print('<h6 style="color: #b2b2b2;">--</h6>');
																print('</div>');
															print('</div>');
														}
													}
												print('</div>');
											print('</div>');//user_sake_graph_user

											print('<div id="user_sake_graph_all">');
												print('<div class="tastingnote_flavor_container">');
													if($flavor_lookupTable > 0) {
														$image_value = "";
														$flavor_name = "";

														if(count($flavor_lookupTable) > 0) {
															getFlavorValue($flavor_lookupTable[0]['flavor'], $image_value, $flavor_name);
															$average_flavor = $flavor_lookupTable[0]['count'] / $lookupTable_count;
															print('<div id="tastingnote_flavor_content">');
																print('<svg><use xlink:href="#' .$image_value .'"/></svg>');
																print('<div class="tastingnote_flavor_caption">');
																	print('<h6>' .$flavor_name .'<span>（' .number_format(($average_flavor * 100), 1) .'%のユーザーに選ばれています）</span></h6>');
																print('</div>');
															print('</div>');
														} else {
															print('<div id="tastingnote_flavor_content">');
																print('<div class="tastingnote_flavor">');
																	print('<span>1</span>');
																print('</div>');
																print('<div class="tastingnote_flavor_caption">');
																	print('<h6 style="color: #b2b2b2;">--</h6>');
																print('</div>');
															print('</div>');
														}

														if(count($flavor_lookupTable) > 1) {
															getFlavorValue($flavor_lookupTable[1]['flavor'], $image_value, $flavor_name);
															$average_flavor = $flavor_lookupTable[1]['count'] / $lookupTable_count;
															print('<div id="tastingnote_flavor_content">');
																print('<svg><use xlink:href="#' .$image_value .'"/></svg>');
																print('<div class="tastingnote_flavor_caption">');
																	print('<h6>' .$flavor_name .'<span>（' .number_format(($average_flavor * 100), 1) .'%のユーザーに選ばれています）</span></h6>');
																print('</div>');
															print('</div>');
														} else {
															print('<div id="tastingnote_flavor_content">');
																print('<div class="tastingnote_flavor">');
																	print('<span>2</span>');
																print('</div>');
																print('<div class="tastingnote_flavor_caption">');
																	print('<h6 style="color: #b2b2b2;">--</h6>');
																print('</div>');
															print('</div>');
														}
													} else {
														for($i = 0; $i < 2; $i++) {
															print('<div id="tastingnote_flavor_content">');
																print('<div class="tastingnote_flavor">');
																	print('<span>' .($i + 1) .'</span>');
																print('</div>');
																print('<div class="tastingnote_flavor_caption">');
																	print('<h6>--</h6>');
																print('</div>');
															print('</div>');
														}
													}
												print('</div>');
											print('</div>');//user_sake_graph_all
										print('</div>');//users_flavor_wrapper

										//チャート//////////////////////////////////////
										print('<div class="users_chart_wrapper">');
											print('<div class="users_chart_title"><div></div>香味チャート</div>');
											print('<div class="users_chart_container">');
												print('<canvas id="users_chart"></canvas>');
											print('</div>');
										print('</div>');

									print('</div>');//tastingnote_chart
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
							print('</div>');//user_sake_tab_panel
						print('</div>');//user_sake_tab_body

						/////////////////////////////////////////////////////////
						$sql2 = "SELECT COUNT(*) FROM NONDA_LIKE, TABLE_NONDA WHERE TABLE_NONDA.contributor = '$contributor' AND TABLE_NONDA.sake_id = '$sake_id' AND TABLE_NONDA.contributor = NONDA_LIKE.contributor AND TABLE_NONDA.sake_id = NONDA_LIKE.sake_id";
						$result2 = executequery($db, $sql2);
						$count = ($rd = getnextrow($result2)) ? $rd["COUNT(*)"] : 0;

						$sql3 = "SELECT username FROM NONDA_LIKE, TABLE_NONDA WHERE NONDA_LIKE.username = '$username' AND TABLE_NONDA.contributor = '$contributor' AND TABLE_NONDA.sake_id = '$sake_id' AND TABLE_NONDA.contributor = NONDA_LIKE.contributor AND TABLE_NONDA.sake_id = NONDA_LIKE.sake_id";
						$result3 = executequery($db, $sql3);
						/////////////////////////////////////////////////////////

						print('<!--いいね-->');
						print('<div class="sake_like_container">');
							print('<div class="sake_like">');

								if($rd = getnextrow($result3)) 
									print('<svg class="sake_like_icon active"><use xlink:href="#heart2020"/></svg>');
								else
									print('<svg class="sake_like_icon"><use xlink:href="#heart2020"/></svg>');

								print('<div class="sake_like_count">' .$count .'</div>');
							print('</div>');
						print('</div>');

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
				print('<a id="ad1" href="sake_search.php">');
					print('<img src="images/icons/notice_banner.jpg">');
				print("</a>");
			print("</div>");
		print("</div>");

	print("</div>");

	print('<div id="dialog_preview">');
		print('<div class="dialog_preview_position_adjust">');
			print('<div class="dialog_preview_date_close_container">');
				print('<div class="dialog_preview_date"></div>');
				print('<button id="close_preview_button"><svg class="close_preview_close2020"><use xlink:href="#close2020"/></svg></button>');
			print('</div>');

			print('<div id="dialog_preview_image_container">');
				print('<img src="" id="preview_image">');
			print('</div>');

			print('<div class="dialog_preview_container2">');
				print('<a href="" class="dialog_preview_user_name"></a>');
				print('<div class="dialog_preview_caption"></div>');
			print('</div>');

		print('</div>');
	print('</div>');

	writefooter();

	?>

<script type="text/javascript">

$('.post_header a').click(function() {
	window.location = document.referrer;
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

$(function () {
  var container = $('.users_chart_container');
  ctx.attr('width', container.width());
  ctx.attr('height', 360);
});

var tastes_values_kaori = <?php echo json_encode($tastes_values[0]); ?>;
var tastes_values_body = <?php echo json_encode($tastes_values[1]); ?>;
var tastes_values_clear = <?php echo json_encode($tastes_values[2]); ?>;
var tastes_values_amakara = <?php echo json_encode($tastes_values[3]); ?>;
var tastes_values_umami = <?php echo json_encode($tastes_values[4]); ?>;
var tastes_values_sanmi = <?php echo json_encode($tastes_values[5]); ?>;
var tastes_values_bitter = <?php echo json_encode($tastes_values[6]); ?>;
var tastes_values_yoin = <?php echo json_encode($tastes_values[7]); ?>;

var tastes_all_kaori = <?php echo json_encode($tastes_all[0]); ?>;
var tastes_all_body = <?php echo json_encode($tastes_all[1]); ?>;
var tastes_all_clear = <?php echo json_encode($tastes_all[2]); ?>;
var tastes_all_amakara = <?php echo json_encode($tastes_all[3]); ?>;
var tastes_all_umami = <?php echo json_encode($tastes_all[4]); ?>;
var tastes_all_sanmi = <?php echo json_encode($tastes_all[5]); ?>;
var tastes_all_bitter = <?php echo json_encode($tastes_all[6]); ?>;
var tastes_all_yoin = <?php echo json_encode($tastes_all[7]); ?>;

Chart.defaults.global.defaultFontColor = '#000000';
Chart.defaults.global.defaultFontFamily = 'Helvetica Neue', 'Arial', 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', 'Meiryo', 'sans-serif';
var ctx = document.getElementById('users_chart');
var users_chart = new Chart(ctx, {
  type: 'radar',
  data: {
    labels: ['香り', 'ボディ', 'クリア', '甘辛', '旨味', '酸味', 'ビター', '余韻'],
    datasets: [{
      label: 'レビュアーの評価',
      data: [tastes_values_kaori, tastes_values_body, tastes_values_clear, tastes_values_amakara, tastes_values_umami, tastes_values_sanmi, tastes_values_bitter, tastes_values_yoin],
      backgroundColor: 'rgba(0,150,150, 0.2)',
      borderColor: '#009696',
      borderWidth: 2,
      pointRadius: 0,
    }, {
      label: 'みんなの評価',
      data: [tastes_all_kaori, tastes_all_body, tastes_all_clear, tastes_all_amakara, tastes_all_umami, tastes_all_sanmi, tastes_all_bitter, tastes_all_yoin],
      backgroundColor: 'rgba(160,200,70, 0.2)',
      borderColor: '#A0C846',
      borderWidth: 2,
      pointRadius: 0,
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scale: {
      ticks: {
        suggestedMin: 0,
        suggestedMax: 5,
        stepSize: 1
      }
    },
    legend: {
      display: true,
      onClick: function () { return false },
      labels: {
        boxWidth: 16,
        fontColor: '#3f3f3f',
        fontSize: 13,
        padding: 8
      }
    }
  }
});

$(function() {
	$('#button_bbs').click(function() {

		var added_path = "";
		var bFound = false;
		var desc_array = [];

		//alert("sake_name:" + $('#user_information').data('sake_name'));

		$('.user_sake_image').each(function() {
			desc_array.push($(this).data('desc'));
		});

		$('.user_sake_image img').each(function() {

			var path_array = $(this).attr("src").split('\\');

			if(added_path == "")
				added_path = path_array[path_array.length - 1];
			else
				added_path += ', ' + path_array[path_array.length - 1];

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
});

//レビューモーダルウィンドウ内タブ
$(function() {
	//初期表示
	$('.user_sake_tab_panel').hide();
	$('.user_sake_tab_panel').eq(0).show();
	$('.user_sake_tab_link').eq(0).addClass('is-active');

	//クリックイベント
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
});

//レビューモーダルウィンドウ内タブ テイスティングソート
$(function() {
	'use strict';
	var isA = 0; // 現在地判定
	var btnA = document.getElementById('tastingnote_sort_user');
	var btnB = document.getElementById('tastingnote_sort_all');
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

	$('#tastingnote_sort_user').click(function() {
		$('.tastingnote_sort div span').css({"border": "2px solid #d2d2d2"});
		$('.tastingnote_sort div span').css({"background": "rgba(210,210,210, 0.2)"});
		$('#tastingnote_sort_user span').css({"border": "2px solid #009696"});
		$('#tastingnote_sort_user span').css({"background": "rgba(0,150,150, 0.2)"});
	});

	$('#tastingnote_sort_all').click(function() {
		$('.tastingnote_sort div span').css({"border": "2px solid #d2d2d2"});
		$('.tastingnote_sort div span').css({"background": "rgba(210,210,210, 0.2)"});
		$('#tastingnote_sort_all span').css({"border": "2px solid #A0C846"});
		$('#tastingnote_sort_all span').css({"background": "rgba(160,200,70, 0.2)"});
	});

	//テイスティングソートキャプション
	$(document).on('click', '.tastingnote_caption', function(e){
		$('.tastingnote_caption_invisible').slideToggle();
	});
});

$(function() {
		$("body").on("nonda_saved", function(event, sake_id, contributor, write_date, committed, title, ranke, message, imagepath, tastes, flavor) {
			location.reload();

		});

		$("body").on("nonda_deleted", function(event, sake_id) {
			var username = getCookie('username');
			window.open('user_view.php?username=' + username, '_self');
		});
});

$(function() {
	$(document).on('click', '.user_sake_image', function(){
		var touch_start_y;
		var path = $(this).find('img');
		var nickname = $('#profile_name').text();

		$("#preview_image").attr("src", $(path).attr("src"));
		$("#dialog_preview .dialog_preview_user_name").text(nickname);
		$("#dialog_preview .dialog_preview_date").text($(this).data("added_date"));

		if($(this).data("desc") && $(this).data("desc") != "") {
			$("#dialog_preview .dialog_preview_caption").text($(this).data("desc"));
			$("#dialog_preview .dialog_preview_caption").css({"display":"flex"});
		}
		else {
			$("#dialog_preview .dialog_preview_caption").css({"display":"none"});
		}

		// タッチしたとき開始位置を保存しておく
		$(window).on('touchstart', function(event) {
			touch_start_y = event.originalEvent.changedTouches[0].screenY;
		});

		// スワイプしているとき
		$(window).on('touchmove.noscroll', function(event) {
			var current_y = event.originalEvent.changedTouches[0].screenY,
			height = $('#dialog_preview').outerHeight(),
			is_top = touch_start_y <= current_y && $('#dialog_preview')[0].scrollTop === 0,
			is_bottom = touch_start_y >= current_y && $('#dialog_preview')[0].scrollHeight - $('#dialog_preview')[0].scrollTop === height;

			// スクロール対応モーダルの上端または下端のとき
			if(is_top || is_bottom) {
				// スクロール禁止
				event.preventDefault();
			}
		});

		// スクロール禁止
		$('html, body').css('overflow', 'hidden');
		$("#dialog_preview").css({"display":"flex"});
	});

	$('#close_preview_button').click(function() {
		// イベントを削除
		$(window).off('touchmove.noscroll');
		$('html, body').css('overflow', '');
		$("#dialog_preview").css({"display":"none"});
	});

	$(document).on('click', '.sake_like_container', function() {

		var username = <?php echo json_encode($username); ?>;

		if(username == undefined || username == "")
		{
			window.location.href = "user_login_form.php";
			return;
		}

		var sake_id = <?php echo json_encode($sake_id); ?>;
		var contributor = <?php echo json_encode($contributor); ?>;
		var data = "sake_id=" + sake_id + "&contributor=" + contributor + "&username=" + username;
		var obj = this;
 
		//alert("sake_id:" + sake_id + " contributor:" + contributor);
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
});

jQuery(document).ready(function($) {

	$("body").wrapInner('<div id="wrapper"></div>');

	$('#profile_name').click(function(){
		var username = $('#user_information').data('contributor');
		window.open('user_view.php?username=' + username, '_self');
	});
});

</script>
</body>
</html>
