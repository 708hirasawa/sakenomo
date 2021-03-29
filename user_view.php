<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("nonda.php");
require_once("searchbar.php");

$loginname = $_COOKIE['username'];
$url_username = ($_GET['username'] && $_GET['username'] != "") ? $_GET['username'] : $_COOKIE['username'];
$title = ($_COOKIE['login_cookie'] == $_GET['username']) ? "マイページ" : "プロファイル";
?>

<!DOCTYPE html>

<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta content='width=device-width, initial-scale=1' name='viewport'/>
	<?php print('<title>' .$title .'</title>'); ?>
	<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/user_view.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="rateyo/jquery.rateyo.js"></script>
	<script type="text/javascript" src="slick/slick.min.js"></script>
</head>

<body>

<?php
	include_once('images/icons/svg_sprite.svg');
	write_side_menu();
	write_HamburgerLogo();
	write_search_bar();
	write_Nonda();

	function disp_data_num($p_from, $p_to, $p_count)
	{
		$disp_num_from = 1 + $p_from;

		if($p_count >= $p_to)
		{
			$disp_num_to = $p_to;
		}
		else
		{
			$disp_num_to = $p_count;
		}

		if($disp_num_to == 0)
		{
			$disp_num = "検索結果がありません。";
		}
		else
		{
			$disp_num = $disp_num_from."件目～".$disp_num_to."件目を表示";
		}

		print($disp_num);
	}

	function displaySeimaiRate($rice_used, $seimai_rate)
	{
		$seimai = "";
		$rice_array = explode('/', $rice_used);
		$seimai_array = explode(',', $seimai_rate);

		for($i = 0; $i < count($seimai_array); $i++)
		{
			if(count($rice_array) > 0 && $i < count($rice_array))
			{
				$rice_entry = explode(',', $rice_array[$i]);

				if($rice_entry[1] == "1")
				{
					$seimai .= "麹米:";
				}
				else if($rice_entry[1] == "2")
				{
					$seimai .= "掛米:";
				}
			}

			if($seimai_array[$i] != "")
				$seimai .= $seimai_array[$i]."%";

			if($i < (count($seimai_array) - 1) && $seimai_array[$i + 1] != "")
			{
				$seimai .= " / ";
			}
		}

		return $seimai;
	}

	function displayOxidation($oxidation_level)
	{
		$oxidation_array = explode(',', $oxidation_level);
		$oxidation = "";

		if(count($oxidation_array) == 1)
		{
			$oxidation = $oxidation_array[0];
		}
		else
		{
			if($oxidation_array[0] == $oxidation_array[1])
			{
				$oxidation = $oxidation_array[0];
			}
			else
			{
				if($oxidation_array[0] != null && $oxidation_array[1] != null)
					$oxidation = $oxidation_array[0].'～'.$oxidation_array[1];
				else if($oxidation_array[0] != null && $oxidation_array[1] == null)
					$oxidation = $oxidation_array[0] ."以上";
				else if($oxidation_array[0] == null && $oxidation_array[1] != null)
					$oxidation = $oxidation_array[1] ."以下";
			}
		}
		return $oxidation;
	}

	function displaySyudo($jsake_level)
	{
		$syudo_array = explode(',', $jsake_level);
		$syudo = "";

		if(count($syudo_array) == 1)
		{
			$syudo = $syudo_array[0];
		}
		else
		{
			if($syudo_array[0] == $syudo_array[1])
			{
				$syudo = $syudo_array[0];
			}
			else
			{
				if($syudo_array[0] != null && $syudo_array[1] != null)
					$syudo = $syudo_array[0].'～'.$syudo_array[1];
				else if($syudo_array[0] != null && $syudo_array[1] == null)
					$syudo = $syudo_array[0] ."以上";
				else if($syudo_array[0] == null && $syudo_array[1] != null)
					$syudo = $syudo_array[1] ."以下";
			}
		}
		return $syudo;
	}

	function displayAlcohol($alcohol_level)
	{
		$alcohol_array = explode(',', $alcohol_level);
		$alcohol = "";

		if(count($alcohol_array) == 1)
		{
			$alcohol = $alcohol_array[0]."度";
		}
		else
		{
			if($alcohol_array[0] == $alcohol_array[1])
			{
				$alcohol = $alcohol_array[0]."度";
			}
			else
			{
				if($alcohol_array[0] != null && $alcohol_array[1] != null)
					$alcohol = $alcohol_array[0].'～'.$alcohol_array[1].'度';
				else if($alcohol_array[0] != null && $alcohol_array[1] == null)
					$alcohol = $alcohol_array[0] ."度以上";
				else if($alcohol_array[0] == null && $alcohol_array[1] != null)
					$alcohol = $alcohol_array[1] ."度以下";
			}
		}
		return $alcohol;
	}

	function displayRice($rice_used)
	{
		$rice_array = explode('/', $rice_used);
		$rice_value = "";

		for($i = 0; $i < count($rice_array); $i++)
		{
			$rice_entry = explode(',', $rice_array[$i]);

			$sql = "SELECT SAKE_RICE.rice_name, SAKE_RICE.rice_kanji, SAKE_RICE.rice_kana FROM SAKE_RICE WHERE SAKE_RICE.rice_name = '$rice_entry[0]'";
			$sake_result = executequery($db, $sql);
			$record = getnextrow($sake_result);

			if($rice_entry[1] == "1")
			{
				$rice_value .= "麹米:";
			}
			else if($rice_entry[1] == "2")
			{
				$rice_value .= "掛米:";
			}

			if($rice_entry[0] != "")
			{
				$rice_kanji = $record ? $record["rice_kanji"] : $rice_used;
				$rice_value .= $rice_kanji;
				break;
			}

			$rice_value += $rice_kanji;

			if($rice_entry[2] != "")
			{
				$rice_value .= '[' .$rice_entry[2] .'%]';
			}

			if($i < (count($rice_array) - 1))
				$rice_value .= ' / ';
		}

		//return $rice_entry[0];
		//$rice_value += $rice_kanji;

		return $rice_value;
	}

	$category = $_GET['category'];
	$p_max = 25;
	$page = $_GET['page'];
	$from = ($page - 1) * $p_max;
	$to = $from + $p_max;

	if(!$db = opendatabase("sake.db"))
	{
		die("データベース接続エラー .<br />");
	}

	///////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////

	if($_GET['username'] && $_GET['username'] != "") { 
		$sql = "SELECT * FROM USERS_J WHERE USERS_J.username = '$url_username'";
	}
	else {
		$sql = "SELECT * FROM USERS_J WHERE USERS_J.username = '$loginname'";
	}

	$res_user = executequery($db, $sql);
	$row = getnextrow($res_user);
	$username = $row["username"];

	///////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////

	$sql2 = "SELECT COUNT(*) FROM TABLE_NONDA, SAKE_J WHERE SAKE_J.sake_id = TABLE_NONDA.sake_id AND contributor = '$username'";
	$res2 = executequery($db, $sql2);

	$record = getnextrow($res2);
	$count_nonda = ($record["COUNT(*)"] == "") ? "--" : $record["COUNT(*)"];

	print('<div id="all_container" data-username="' .$username .'" data-page="' .$page .'" data-from="' .$from .'" data-to="' .$to .'" data-max="' .$p_max .'" data-category="' .$category .'">');

		if($row) {
			print('<div id="user_information">');

				$path = "images/icons/noimage_user30.svg";
				$imagefile = null;
				$username = stripslashes($row["username"]);
				$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$username' AND status = 1";
				$result = executequery($db, $sql);
				$rd = getnextrow($result);

				if($rd) {
					$imagefile = $rd["filename"];
					$path = "images/profile/" .$imagefile;
				}

				print('<div class="user_image_name_container">');
					print('<div class="user_image_container">');
						print('<img src=' .$path .'>');
					print('</div>');

					print('<div id="profile_name">' .$row["nickname"] .'</div>');

					print('<div class="user_profile_trigger">');
						print('<p class="plus_minus_icon"><span></span><span></span></p>');
					print('</div>');
				print('</div>');

				print('<div class="user_profile_container">');
					print('<div class="user_profile_content">');

						print('<div class="user_profile_column_container">');
							print('<div class="user_profile_row">');
								print('<div class="user_profile_column1">年代</div>');

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
								print('<div class="user_profile_column1">現住所</div>');

								if($row["pref"]) {
									print('<div class="user_profile_column2">' .$row["pref"] .'</div>');
								} else {
									print('<div class="user_profile_column2" style="color: #b2b2b2;">--</div>');
								}

							print('</div>');
							print('<div class="user_profile_row">');
								print('<div class="user_profile_column1">利酒資格</div>');

								if($row["certification"]) {
									$replace = str_replace('1', '利酒師', $row["certification"]);
									$replace = str_replace('2', '酒匠', $replace);
									print('<div class="user_profile_column2">' .$replace .'</div>');
								} else {
									print('<div class="user_profile_column2" style="color: #b2b2b2;">--</div>');
								}

							print('</div>');
						print('</div>');

						if($row['introduction']) {
							print('<p class="user_profile_text">' .$row['introduction'] .'</p>');
						} else {
							print('<p class="user_profile_text" style="color: #b2b2b2">自己紹介の登録はありません</p>');
						}

					print('</div>');
				print('</div>');

				print('<ul class="user_activity_info">');
					print('<li>');
						print('<span id="user_activity_nonda">'.$count_nonda .'</span>');
						print('<span>飲んだ</span>');
					print('</li>');

					print('<li>');
						print('<span id="user_activity_sakagura"></span>');
						print('<span>お気に入り酒蔵</span>');
					print('</li>');

					/*初期非表示print('<li>');
						print('<span id="user_activity_follower">no code</span>');
						print('<span>フォロワー</span>');
					print('</li>');*/
				print("</ul>");

				//print("loginname:" .$loginname ." username:" .$row["username"]);

				if($loginname == $row["username"]) {
					print('<ul class="user_buttons">');
						print('<li id="user_mypage"><a href="user_view_config.php" class="mypage_config_link"><svg class="user_buttons_config1616"><use xlink:href="#config1616"/></svg>マイページ設定</a></li>');
						/*print('<li id="user_trophy"><svg class="user_buttons_trophy1216"><use xlink:href="#trophy1216"/></svg>トロフィー</li>');*/
					print("</ul>");
				} else {
					print('<ul class="user_buttons">');
						$sql = "SELECT * FROM FOLLOW_USER WHERE username = '$loginname' AND favoriteuser = '$username'";
						$res = executequery($db, $sql);

						if($rd = getnextrow($res)) {
							print('<li id="user_follow" style="background:linear-gradient(#EDCACA, #ffffff); border:1px solid #FF4545; transition: 0.3s"><svg class="user_buttons_pin1616" style="fill:#FF4545"><use xlink:href="#pin1616"/></svg><span>フォロー中</span></li>');
						} else {
							print('<li id="user_follow"><svg class="user_buttons_pin1616"><use xlink:href="#pin1616"/></svg><span>フォロー</span></li>');
						}
					print("</ul>");
				}

			print("</div>");
		}

		print('<div id="main_banner_container">');
			print('<div id="container_wrapper">');
				print('<div id="table_wrapper">');

					if($row) {
						print('<div id="tab_main" class="tab_container">');
							print('<ul class="simpleTabs">');
								print('<li><a href="#tab_sake" class="active"><span><svg class="simpleTabs_sake3630"><use xlink:href="#sake3630"/></svg><span>日本酒</span></span></a></li>');
								print('<li><a href="#tab_sakagura"><span><svg class="simpleTabs_brewery3630"><use xlink:href="#brewery3630"/></svg><span>酒蔵</span></span></a></li>');
								print('<li><a href="#tab_users"><span><svg class="simpleTabs_reviewers3030"><use xlink:href="#reviewers3030"/></svg><span>レビュアー</span></span></a></li>');
								/*print('<li><a href="#tab_syuhanten"><span><svg class="simpleTabs_store3030"><use xlink:href="#store3030"/></svg><span>酒販店</span></span></a></li>');
								print('<li><a href="#tab_inshokuten"><span><svg class="simpleTabs_restaurant3630"><use xlink:href="#restaurant3630"/></svg><span>飲食店</span></span></a></li>');*/
							print("</ul>");

							//日本酒タブ//////////////////////////////////////////////////////////
							print('<div id="tab_sake" class="show">');
								print('<div class="tab_sake_sort_container">');
									print('<div class="display_selection">');
										print('<div class="display_selection_button selected"><span><svg class="display_selection_heart2020"><use xlink:href="#heart2020"/></svg>飲んだ</span></div>');
										print('<div class="display_selection_button"><span><svg class="display_selection_pin1616"><use xlink:href="#pin1616"/></svg>飲みたい</span></div>');
									print("</div>");

									/*非表示中print('<div class="user_drop_down">');
										print('<div class="sake_search_icon"><svg class="sake_search_search2020"><use xlink:href="#search2020"/></svg></div>');

										print('<div class="drop_down_select_container">');
											print('<select id="sake_pref_option" class="sake_selection">');
												print('<OPTION value="">都道府県</OPTION>');
												print('<OPTION value="北海道">北海道</OPTION>');
												print('<OPTION value="青森県">青森県</OPTION>');
												print('<OPTION value="岩手県">岩手県</OPTION>');
												print('<OPTION value="宮城県">宮城県</OPTION>');
												print('<OPTION value="秋田県">秋田県</OPTION>');
												print('<OPTION value="山形県">山形県</OPTION>');
												print('<OPTION value="福島県">福島県</OPTION>');
												print('<OPTION value="茨城県">茨城県</OPTION>');
												print('<OPTION value="栃木県">栃木県</OPTION>');
												print('<OPTION value="群馬県">群馬県</OPTION>');
												print('<OPTION value="埼玉県">埼玉県</OPTION>');
												print('<OPTION value="千葉県">千葉県</OPTION>');
												print('<OPTION value="東京都">東京都</OPTION>');
												print('<OPTION value="神奈川県">神奈川県</OPTION>');
												print('<OPTION value="新潟県">新潟県</OPTION>');
												print('<OPTION value="富山県">富山県</OPTION>');
												print('<OPTION value="石川県">石川県</OPTION>');
												print('<OPTION value="福井県">福井県</OPTION>');
												print('<OPTION value="山梨県">山梨県</OPTION>');
												print('<OPTION value="長野県">長野県</OPTION>');
												print('<OPTION value="岐阜県">岐阜県</OPTION>');
												print('<OPTION value="静岡県">静岡県</OPTION>');
												print('<OPTION value="愛知県">愛知県</OPTION>');
												print('<OPTION value="三重県">三重県</OPTION>');
												print('<OPTION value="滋賀県">滋賀県</OPTION>');
												print('<OPTION value="京都府">京都府</OPTION>');
												print('<OPTION value="大阪府">大阪府</OPTION>');
												print('<OPTION value="兵庫県">兵庫県</OPTION>');
												print('<OPTION value="奈良県">奈良県</OPTION>');
												print('<OPTION value="和歌山県">和歌山県</OPTION>');
												print('<OPTION value="鳥取県">鳥取県</OPTION>');
												print('<OPTION value="島根県">島根県</OPTION>');
												print('<OPTION value="岡山県">岡山県</OPTION>');
												print('<OPTION value="広島県">広島県</OPTION>');
												print('<OPTION value="山口県">山口県</OPTION>');
												print('<OPTION value="徳島県">徳島県</OPTION>');
												print('<OPTION value="香川県">香川県</OPTION>');
												print('<OPTION value="愛媛県">愛媛県</OPTION>');
												print('<OPTION value="高知県">高知県</OPTION>');
												print('<OPTION value="福岡県">福岡県</OPTION>');
												print('<OPTION value="佐賀県">佐賀県</OPTION>');
												print('<OPTION value="長崎県">長崎県</OPTION>');
												print('<OPTION value="熊本県">熊本県</OPTION>');
												print('<OPTION value="大分県">大分県</OPTION>');
												print('<OPTION value="宮城県">宮城県</OPTION>');
												print('<OPTION value="鹿児島県">鹿児島県</OPTION>');
												print('<OPTION value="沖縄県">沖縄県</OPTION>');
											print('</select>');
										print("</div>");

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

									$in_disp_from = 0;
									$p_max = 25;

									print('<div id="sake_sort">');
										print('<div class="sake_sort_icon"><svg class="sake_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>');
										print('<span value="favorite_date" class="click_sort_date">更新日</span>');
										/*非表示中print('<span value="sake_read"  class="click_sort_read">読み</span>');
										print('<span value="sake_rank"  class="click_sort_ranking">ランキング</span>');
										print('<span value="sake_like"  class="click_sort_like">いいね!</span>');*/
									print("</div>");
								print("</div>");

								print('<div class="result_count_container">');
									print('<span id="disp_sake"></span>');
								print('</div>');

								print('<input type="hidden" id="in_disp_from" value=0>');
								print('<input type="hidden" id="count_sake" value="' .$count_nonda .'">');
								print('<input type="hidden" id="order_sake" value=1>');

								print('<div id="sake_table"></div>');

								print('<div id="review_result_turn_page"></div>');

							print("</div>");

							//酒蔵タブ//////////////////////////////////////////////////////////
							$in_disp_from = 0;
							$p_max = 25;

							print('<div id="tab_sakagura" class="form-action hide">');
								print('<div class="tab_sakagura_sort_container">');
									print('<div class="display_selection">');
										print('<div class="display_selection_button"><span><svg class="display_selection_review1816"><use xlink:href="#review1816"/></svg>コメント</span></div>');
										print('<div class="display_selection_button selected"><span><svg class="display_selection_pin1616"><use xlink:href="#pin1616"/></svg>お気に入り</span></div>');
									print("</div>");

									$sql = "SELECT COUNT(*) FROM FOLLOW_J, SAKAGURA_J WHERE username = '$username' AND sakagura_id = id";
									$res = executequery($db, $sql);
									$record = getnextrow($res);
									$count_result = ($record["COUNT(*)"] == "") ? "--" : $record["COUNT(*)"];

									print('<input type="hidden" id="in_sakagura_disp_from" value=0>');
									print('<input type="hidden" id="order_sakagura" value="favorite_date">');
									print('<input type="hidden" id="count_sakagura" value=' .$count_result .'>');

									$numPage = $count_result / $p_max;
									$numPage = ($count_result % $p_max) ? ($numPage + 1) : $numPage;
									$numPage = ($numPage > 5) ? 5 : $numPage;

									/*print('<div class="user_drop_down" name="sake_pref" value="">');
										print('<div class="sake_search_icon"><svg class="sake_search_search2020"><use xlink:href="#search2020"/></svg></div>');
										print('<div class="drop_down_select_container"><span name="sake_pref" value=""></span>');

											print('<SELECT id="sakagura_pref_option" class="sake_selection">');
												print('<OPTION value="">都道府県</li>');
												print('<OPTION value="北海道">北海道</OPTION>');
												print('<OPTION value="青森県">青森県</OPTION>');
												print('<OPTION value="岩手県">岩手県</OPTION>');
												print('<OPTION value="宮城県">宮城県</OPTION>');
												print('<OPTION value="秋田県">秋田県</OPTION>');
												print('<OPTION value="山形県">山形県</OPTION>');
												print('<OPTION value="福島県">福島県</OPTION>');
												print('<OPTION value="茨城県">茨城県</OPTION>');
												print('<OPTION value="栃木県">栃木県</OPTION>');
												print('<OPTION value="群馬県">群馬県</OPTION>');
												print('<OPTION value="埼玉県">埼玉県</OPTION>');
												print('<OPTION value="千葉県">千葉県</OPTION>');
												print('<OPTION value="東京都">東京都</OPTION>');
												print('<OPTION value="神奈川県">神奈川県</OPTION>');
												print('<OPTION value="新潟県">新潟県</OPTION>');
												print('<OPTION value="富山県">富山県</OPTION>');
												print('<OPTION value="石川県">石川県</OPTION>');
												print('<OPTION value="福井県">福井県</OPTION>');
												print('<OPTION value="山梨県">山梨県</OPTION>');
												print('<OPTION value="長野県">長野県</OPTION>');
												print('<OPTION value="岐阜県">岐阜県</OPTION>');
												print('<OPTION value="静岡県">静岡県</OPTION>');
												print('<OPTION value="愛知県">愛知県</OPTION>');
												print('<OPTION value="三重県">三重県</OPTION>');
												print('<OPTION value="滋賀県">滋賀県</OPTION>');
												print('<OPTION value="京都府">京都府</OPTION>');
												print('<OPTION value="大阪府">大阪府</OPTION>');
												print('<OPTION value="兵庫県">兵庫県</OPTION>');
												print('<OPTION value="奈良県">奈良県</OPTION>');
												print('<OPTION value="和歌山県">和歌山県</OPTION>');
												print('<OPTION value="鳥取県">鳥取県</OPTION>');
												print('<OPTION value="島根県">島根県</OPTION>');
												print('<OPTION value="岡山県">岡山県</OPTION>');
												print('<OPTION value="広島県">広島県</OPTION>');
												print('<OPTION value="山口県">山口県</OPTION>');
												print('<OPTION value="徳島県">徳島県</OPTION>');
												print('<OPTION value="香川県">香川県</OPTION>');
												print('<OPTION value="愛媛県">愛媛県</OPTION>');
												print('<OPTION value="高知県">高知県</OPTION>');
												print('<OPTION value="福岡県">福岡県</OPTION>');
												print('<OPTION value="佐賀県">佐賀県</OPTION>');
												print('<OPTION value="長崎県">長崎県</OPTION>');
												print('<OPTION value="熊本県">熊本県</OPTION>');
												print('<OPTION value="大分県">大分県</OPTION>');
												print('<OPTION value="宮城県">宮城県</OPTION>');
												print('<OPTION value="鹿児島県">鹿児島県</OPTION>');
												print('<OPTION value="沖縄県">沖縄県</OPTION>');
											print('</SELECT>');

										print('</div>');
									print('</div>');*/

									if($count_result > 0) {
										print('<div id="sake_sort" name="sake_pref" value="">');
											print('<div class="sake_sort_icon"><svg class="sake_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>');
											print('<span value="favorite_date" class="click_sort_date" value="">更新日</span>');
										print("</div>");
									}

								print("</div>");

								if($count_result == 0) {
									print('<div id="sakagura_table">');
										print('<div class="navigate_page_no_registry">お気に入り登録はありません</div>');
									print('</div>');
								} else {
									print('<div class="result_count_container">');
										$p_max = ($count_result < 25) ? $count_result : 25;
										print('<span id="count_result">1～' .$p_max .'件 / 全' .$count_result .'件</span>');
									print('</div>');

									print('<div id="sakagura_table">');
									print('</div>');
								}

								print('<div id="sakagura_result_turn_page">');
									if($count_result > 25) {
										print('<button id="prev_mypage_sakagura" class="search_button"><svg class="prev_button_prev2020"><use xlink:href="#prev2020"/></svg></button>');
										$i = 1;

										print('<button class="search_button pageitems selected">' .$i .'</button>');

										for($i++; $i <= $numPage; $i++) {
											 print('<button class="search_button pageitems">' .$i .'</button>');
										}

										print('<button id="next_sakagura" class="search_button active"><svg class="next_button_next2020"><use xlink:href="#next2020"/></svg></button>');
									}
								print("</div>");
							print("</div>");

							//飲食店タブ//////////////////////////////////////////////////////////

							//レビュアータブ//////////////////////////////////////////////////////////
							print('<div id="tab_users" class="form-action hide">');
								print('<div class="tab_users_sort_container">');

									print('<div class="display_selection">');
										print('<div class="display_selection_button selected"><span><svg class="display_selection_pin1616"><use xlink:href="#pin1616"/></svg>フォロー中</span></div>');
										print('<div class="display_selection_button"><span><svg class="display_selection_people1616"><use xlink:href="#people1616"/></svg>フォロワー</span></div>');
									print("</div>");

									print('<input type="hidden" id="in_user_disp_from" value=0>');
									print('<input type="hidden" id="count_user" value=0>');
									print('<input type="hidden" id="order_user" value="date_followed">');


									/*
									print('<div class="user_drop_down">');
										print('<div class="sake_search_icon"><svg class="sake_search_search2020"><use xlink:href="#search2020"/></svg></div>');

										print('<div class="drop_down_select_container">');
											print('<select id="sake_pref_option" class="sake_selection">');
												print('<OPTION value="">----</OPTION>');
											print('</select>');
										print("</div>");

										print('<div class="drop_down_select_container">');

											print('<select id="special_name_option" class="sake_selection" >');
												print('<OPTION value="">----</OPTION>');
											print('</select>');

											print('<div class="sake_option_trigger"><span class="drop_down_select_title" name="special_name" value=""></span></div>');

										print("</div>");
									print("</div>");

									$in_disp_from = 0;
									$p_max = 25;
									*/

									print('<div id="user_sort">');
										print('<div class="sake_sort_icon"><svg class="sake_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>');
										print('<span value="favorite_date" class="click_sort_date">更新日</span>');
									print("</div>");

								print("</div>");

								print('<div class="result_count_container">');
									$p_max = ($count_result < 25) ? $count_result : 25;
									print('<span>1～' .$p_max .'件 / 全' .$count_result .'件</span>');
								print('</div>');

								print('<div id="users_table"></div>');
								print('<div id="userfollowpage"></div>');

							print('</div>');
						print("</div>");//tab_main
					} else {
						?>
						<script type="text/javascript">
						window.open('user_login_form.php', '_self');
						</script>
						<?php
						//print("no data");
					}

				print("</div>");//table_wrapper
			print("</div>");//container_wrapper

			//banner//////////////////////////////////////////////////////////////////////////////
			print('<div id="banner">');
				print('<div id="ad1"><img src="images/icons/notice_banner.svg"></div>');
			print('</div>');
		print("</div>");

	print("</div>");
	writefooter();

?>

<!-- dialog_background -->
<div id="search_background">
	<div id="inner_background">
		<div class="loader"></div>
	</div>
</div>

</body>
<script type="text/javascript">

$(function() {
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

// Loadingイメージ表示関数
function dispLoading(){
     //$(".loading").css({"visibility": "visible"});
	 $('#search_background').css('display', 'block');
}

// Loadingイメージ削除関数
function removeLoading(){
     //$(".loading").css({"visibility": "hidden"});
	 $('#search_background').css('display', 'none');
}

/*****************************************************************************************************************************************************************************************
 * 日本酒タブ
 *****************************************************************************************************************************************************************************************/

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

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// 飲んだ
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		function nonda_serialize(in_disp_from, in_disp_to, query_count, mode) {

			var loginname = $('#all_container').data('username');
			var username =  <?php echo json_encode($_GET['username']); ?>;
			var data = "search_type=1";

			if(mode == 1) { // for ajax
				data += "&from=" + in_disp_from + "&to=" + in_disp_to;

				if(username && username != "")
					data += "&username=" + username;
				else if(loginname && loginname != "")
					data += "&username=" + loginname;
			}
			else if(mode == 2) { // for url
				data += "&page=" + (in_disp_from / $('#all_container').data('max') + 1);

				if(username && username != "")
					data += "&username=" + username;
			}

			if(query_count && query_count == 1) {
				data += "&count_query=" + query_count;
			}

			data += "&orderby=" + $("#order_sake").val();
			return data;
		}

		$("#sake_table").delegate('.nondaview .user_button', 'click', function() {

			var innerHTML = $('#tabs-2 div').find('div:last-child')[0].outerHTML;
			var tastes = $(this).attr('tastes');
			var sake_id = $(this).attr('sake_id');
			var sake_name = $(this).attr('sake_name');
			var image_paths = $(this).next('.image_paths').val();
			var pathArray = image_paths.split(',');
			var nomitai_values = tastes.split(',');
			var i = 0;

			$('.graph .frame_box').each(function() {
				var width = Math.floor((nomitai_values[i] / 5) * 100) + "%";
				$(this).find('.horizontal_bar').css({"width": width});
				$(this).find('div:nth-child(2)').text(nomitai_values[i++]);
			});

			$('#dialog_bbs').attr("write_date", $(this).attr('write_date'));

			if($(this).attr('subject') != "null")
				$('#custom_dialog_input_argument').val($(this).attr('subject'));

			if($(this).attr('message') != "null")
				$('#custom_dialog_input_message').val($(this).attr('message'));

			$('#add_nonda_sake').val(sake_name);
			$("#add_nonda_sake").attr("sake_id", sake_id);

			$("#dialog_background").css({"display":"block"});
			$("#dialog_bbs").css({"display":"block"});
			$("#dialog_bbs").attr("value", $(this).parent().index()); // setting the current clicked review

			$('#nonda_image').empty();
			$('#tabs-2 > div:first-child').append(innerHTML);

			for(i = 0; i < pathArray.length; i++)
			{
				var innerHTML = $('#tabs-2 div').find('div:last-child')[0].outerHTML;
				var path = "images\\photo\\" + pathArray[i];
				var imageObj = $('#nonda_image div:last-child img');

				$('#nonda_image div:last-child').attr("path", pathArray[i]);
				$(imageObj).attr("src", path);
				$('#tabs-2 > div:first-child').append(innerHTML);
			}

			//$('#tab_bbs_container .nondaTabs li:nth-child(3) a').click();
			$('#dialog_bbs').removeClass('add_nonda');
			$('#dialog_bbs').removeClass('edit_nonda');
			$('#dialog_bbs').addClass('edit_nonda');
		});

		$("#sake_table").delegate('.search_result_name_container .custom_button', 'click', function() {

			event.preventDefault();

			var id = $(this).attr('sake_id');
			var data = "sake_id="+$(this).attr('sake_id');
			var obj = this;

			$.ajax({
					type: "post",
					url: "sake_follow.php?sake_id="+id,
					data: data,
			}).done(function(xml){
					var str = $(xml).find("str").text();
					//alert("removed");

					if(str == "follow")
					{
						$(obj).removeClass("followed");
						$("#count_sake").val(  parseInt($("#count_sake").val()) - 1);
					}
					else
					{
						$(obj).addClass("followed");
						$("#count_sake").val(  parseInt($("#count_sake").val()) + 1);
					}

			}).fail(function(data){
					alert("This is Error");
			});
		});

		$("#sake_table").delegate('.tastingview .user_button', 'click', function() {

			var tastes = $(this).attr('tastes');
			var nomitai_values = tastes.split(',');
			var i = 0;

			$('.frame_box').each(function() {
				var width = Math.floor((nomitai_values[i] / 5) * 100) + "%";
				$(this).find('.horizontal_bar').css({"width": width});
				$(this).find('div:nth-child(2)').text(nomitai_values[i++]);
			});

			//alert("tastes:" + $(this).attr('tastes'));
			//alert("sake_id:" + $(this).attr("sake_id"));
			//alert("sake_name:" + $(this).parent().find("div a").text());

			$('#add_nonda_sake').val($(this).parent().find("div a").text());
			$('#add_nonda_sake').attr('sake_id', $(this).attr("sake_id"));
			$("#dialog_bbs").css({"display":"block"});
			$('#tab_bbs_container .nondaTabs li:nth-child(3) a').click();
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

						//alert("sql:" + data[0].sql);
						//alert("count resut:" + sake.length);
						$('#sake_table').empty()

						/////////////////////////////////////////////////////////////////
						$('#in_disp_from').val(in_disp_from);
						/////////////////////////////////////////////////////////////////

						if(count_result == 0 && sake == null) {
							var innerText = '<div class="navigate_page_no_registry">飲んだ登録はありません</div>';
							$('#disp_sake').css({"display":"none"});
							$("#sake_sort").css({"display":"none"});
							$("#tab_sake .result_count_container").css({"display":"none"});
							$('#sake_table').html(innerText);
							$('#review_result_turn_page').css({"display": "none"});
							removeLoading();
						}
						else {
							$("#sake_sort").css({"display":"flex"});
							$('#disp_sake').css({"display":"block"});
							$("#tab_sake .result_count_container").css({"display":"flex"});

							for(i = 0; i < sake.length; i++)
							{
								var username = $('#all_container').data('username');
								var tablename = "table_review" + sake[i].sake_id;
								var innerText = '<a class="user_nonda_link" href="user_view_sakereview.php?sake_id=' + sake[i].sake_id + '&contributor=' + username + '">';
								innerText += '<div class="user_nonda_sake_container">';
								innerText += '<div class="user_nonda_sake_brewery_date_container">';
								innerText += '<div class="user_nonda_sake_name">' + sake[i].sake_name + '</div>';
								innerText += '<div class="user_nonda_brewery_date_container">';
								innerText += '	<div>' + sake[i].sakagura_name + ' / ' + sake[i].pref + '</div>';
								innerText += '	<div class="user_nonda_date">' + sake[i].local_time + '</div>';
								innerText += '</div>';
								innerText += '</div>';
								innerText += '</div>';

								////////////////////////////////////////
								////////////////////////////////////////
								var rank_width = (sake[i].sake_rank / 5) * 100 + '%';

								innerText += '<div class="nonda_rank">';
									innerText += '<div class="review_star_rating">';
										innerText += '<div class="review_star_rating_front" style="width:' + rank_width + '">★★★★★</div>';
										innerText += '<div class="review_star_rating_back">★★★★★</div>';
									innerText += '</div>';
									if(sake[i].sake_rank) {
										innerText += '<span class="review_sake_rate">' + sake[i].sake_rank.toFixed(1) + '</span>';
									} else {
										innerText += '<span class="review_sake_rate" style="color: #b2b2b2;">--</span>';
									}
								innerText += '</div>';

								////////////////////////////////////////
								////////////////////////////////////////
								if(sake[i].subject && nl2br(sake[i].message)) {
									innerText += '<div class="user_nonda_subject_message_container">';
										innerText += '<div class="user_nonda_subject">' + sake[i].subject + '</div>';
										innerText += '<div class="user_nonda_message">' + nl2br(sake[i].message) + '</div>';
									innerText += '</div>';
								} else if(sake[i].subject && nl2br(sake[i].message == "")) {
									innerText += '<div class="user_nonda_subject_message_container">';
										innerText += '<div class="user_nonda_subject">' + sake[i].subject + '</div>';
									innerText += '</div>';
								} else if(sake[i].subject =="" && nl2br(sake[i].message)) {
									innerText += '<div class="user_nonda_subject_message_container">';
										innerText += '<div class="user_nonda_message">' + nl2br(sake[i].message) + '</div>';
									innerText += '</div>';
								} else {
									innerText += '';
								}

								////////////////////////////////////////
								////////////////////////////////////////
								if(sake[i].path != null && sake[i].path != "")
								{
									innerText += '<div class="review_container">';
										var pathArray = sake[i].path.split(', ');

										for(j = 0; j < pathArray.length; j++)
										{
											var path = "images\\photo\\thumb\\" + pathArray[j];
											innerText += '<div class="review_image">' + '<img class="preview" src="' + path + '">' + '</div>';
										}
									innerText += '</div>';
								}
								else
								{
									innerText += '';
								}

								////////////////////////////////////////
								////////////////////////////////////////
								if((sake[i].flavor != null && sake[i].flavor != "") || (sake[i].tastes != null && sake[i].tastes != ""))
								{
									var flavors = (sake[i].flavor == null) ? "" : sake[i].flavor;
									var tastes_values = (sake[i].tastes != null && sake[i].tastes != "") ? sake[i].tastes.split(',') : [0, 0, 0, 0, 0, 0, 0, 0];

									innerText += '<div class="tastes">';
										innerText += '<div class="tastes_item">';
											innerText += '<div class="tastes_title"><svg class="tastes_item_flavor1816"><use xlink:href="#flavor1816"/></svg>フレーバー</div>';
											innerText += '<div class="taste_value_flavor">';

												if(sake[i].flavor != "") {
													innerText += GetFlavorNames(flavors);
												} else {
													innerText += '<span style="color: #b2b2b2;">--</span>';
												}

											innerText += '</div>';
										innerText += '</div>';

										////////////////////////////////////////
										innerText += '<div class="tastes_item">';
											innerText += '<div class="tastes_title"><svg class="tastes_item_aroma1216"><use xlink:href="#aroma1216"/></svg>香り</div>';
											innerText += '<div class="tastes_value_container">';
												innerText += '<div class="tastes_bar_container">';

													innerText += '<input type="range" name="aroma" step="0.1" min="0" max="5" value="' + tastes_values[0] + '" disabled="disabled" class="user_input_range">';

												innerText += '</div>';
												innerText += '<div class="taste_value">';

													if(tastes_values[0] != 0) {
														innerText += parseFloat(tastes_values[0]).toFixed(1);
													} else {
														innerText += '<span style="color: #b2b2b2;">--</span>';
													}

												innerText += '</div>';
											innerText += '</div>';
										innerText += '</div>';
										////////////////////////////////////////
										innerText += '<div class="tastes_item">';
											innerText += '<div class="tastes_title"><svg class="tastes_item_body1216"><use xlink:href="#body1216"/></svg>ボディ</div>';
											innerText += '<div class="tastes_value_container">';
												innerText += '<div class="tastes_bar_container">';

													innerText += '<input type="range" name="body" step="0.1" min="0" max="5" value="' + tastes_values[1] + '" disabled="disabled" class="user_input_range">';

												innerText += '</div>';
												innerText += '<div class="taste_value">';

													if(tastes_values[1] != 0) {
														innerText += parseFloat(tastes_values[1]).toFixed(1);
													} else {
														innerText += '<span style="color: #b2b2b2;">--</span>';
													}

												innerText += '</div>';
											innerText += '</div>';
										innerText += '</div>';
										////////////////////////////////////////
										innerText += '<div class="tastes_item">';
											innerText += '<div class="tastes_title"><svg class="tastes_item_clear3030"><use xlink:href="#clear3030"/></svg>クリア</div>';
											innerText += '<div class="tastes_value_container">';
												innerText += '<div class="tastes_bar_container">';

													innerText += '<input type="range" name="clear" step="0.1" min="0" max="5" value="' + tastes_values[2] + '" disabled="disabled" class="user_input_range">';

												innerText += '</div>';
												innerText += '<div class="taste_value">';

													if(tastes_values[2] != 0) {
														innerText += parseFloat(tastes_values[2]).toFixed(1);
													} else {
														innerText += '<span style="color: #b2b2b2;">--</span>';
													}

												innerText += '</div>';
											innerText += '</div>';
										innerText += '</div>';
										////////////////////////////////////////
										innerText += '<div class="tastes_item">';
											innerText += '<div class="tastes_title"><svg class="tastes_item_sweetness3030"><use xlink:href="#sweetness3030"/></svg>甘辛</div>';
											innerText += '<div class="tastes_value_container">';
												innerText += '<div class="tastes_bar_container">';

													innerText += '<input type="range" name="sweetness" step="0.1" min="0" max="5" value="' + tastes_values[3] + '" disabled="disabled" class="user_input_range">';

												innerText += '</div>';
												innerText += '<div class="taste_value">';

													if(tastes_values[3] != 0) {
														innerText += parseFloat(tastes_values[3]).toFixed(1);
													} else {
														innerText += '<span style="color: #b2b2b2;">--</span>';
													}

												innerText += '</div>';
											innerText += '</div>';
										innerText += '</div>';
										////////////////////////////////////////
										innerText += '<div class="tastes_item">';
											innerText += '<div class="tastes_title"><svg class="tastes_item_umami3030"><use xlink:href="#umami3030"/></svg>旨味</div>';
											innerText += '<div class="tastes_value_container">';
												innerText += '<div class="tastes_bar_container">';

													innerText += '<input type="range" name="umami" step="0.1" min="0" max="5" value="' + tastes_values[4] + '" disabled="disabled" class="user_input_range">';

												innerText += '</div>';
												innerText += '<div class="taste_value">';

													if(tastes_values[4] != 0) {
														innerText += parseFloat(tastes_values[4]).toFixed(1);
													} else {
														innerText += '<span style="color: #b2b2b2;">--</span>';
													}

												innerText += '</div>';
											innerText += '</div>';
										innerText += '</div>';
										////////////////////////////////////////
										innerText += '<div class="tastes_item">';
											innerText += '	<div class="tastes_title"><svg class="tastes_item_acidity3030"><use xlink:href="#acidity3030"/></svg>酸味</div>';
											innerText += '	<div class="tastes_value_container">';
												innerText += '<div class="tastes_bar_container">';

													innerText += '<input type="range" name="acidity" step="0.1" min="0" max="5" value="' + tastes_values[5] + '" disabled="disabled" class="user_input_range">';

												innerText += '</div>';
												innerText += '<div class="taste_value">';

													if(tastes_values[5] != 0) {
														innerText += parseFloat(tastes_values[5]).toFixed(1);
													} else {
														innerText += '<span style="color: #b2b2b2;">--</span>';
													}

												innerText += '</div>';
											innerText += '</div>';
										innerText += '</div>';
										////////////////////////////////////////
										innerText += '<div class="tastes_item">';
											innerText += '	<div class="tastes_title"><svg class="tastes_item_bitter1216"><use xlink:href="#bitter1216"/></svg>ビター</div>';
											innerText += '	<div class="tastes_value_container">';
												innerText += '<div class="tastes_bar_container">';

													innerText += '<input type="range" name="bitter" step="0.1" min="0" max="5" value="' + tastes_values[6] + '" disabled="disabled" class="user_input_range">';

												innerText += '</div>';
												innerText += '<div class="taste_value">';

													if(tastes_values[6] != 0) {
														innerText += parseFloat(tastes_values[6]).toFixed(1);
													} else {
														innerText += '<span style="color: #b2b2b2;">--</span>';
													}

												innerText += '</div>';
											innerText += '</div>';
										innerText += '</div>';
										////////////////////////////////////////
										innerText += '<div class="tastes_item">';
											innerText += '<div class="tastes_title"><svg class="tastes_item_yoin3030"><use xlink:href="#yoin3030"/></svg>余韻</div>';
											innerText += '<div class="tastes_value_container">';
												innerText += '<div class="tastes_bar_container">';

													innerText += '<input type="range" name="yoin" step="0.1" min="0" max="5" value="' + tastes_values[7] + '" disabled="disabled" class="user_input_range">';

												innerText += '</div>';
												innerText += '<div class="taste_value">';

													if(tastes_values[7] != 0) {
														innerText += parseFloat(tastes_values[7]).toFixed(1);
													} else {
														innerText += '<span style="color: #b2b2b2;">--</span>';
													}

												innerText += '</div>';
											innerText += '</div>';
										innerText += '</div>';

									innerText += '</div>';
								} // tastes

								innerText += '</a>';

								$('#sake_table').append(innerText);
							}

							if(bCount == true)
							{
								var p_max = 25;
								var numPage = Math.ceil(count_result / p_max);
								var i = 1;

								numPage = (numPage < 5) ? numPage : 5;

								$("#count_sake").val(count_result);

								if(count_result > 25) {
									innerText = '<button id="prev_mypage_review"><svg class="prev_button_prev2020"><use xlink:href="#prev2020"/></svg></button>';
									innerText += '<button class="pageitems selected">' + i + '</button>';

									for(i++; i <= numPage; i++)
										 innerText += '<button class="pageitems">' + i + '</button>';

									if(count_result > p_max)
										 innerText += '<button id="next_mypage_review" class="active"><svg class="next_button_next2020"><use xlink:href="#next2020"/></svg></button>';
									else
										 innerText += '<button id="next_mypage_review"><svg class="next_button_next2020"><use xlink:href="#next2020"/></svg></button>';

									$('#review_result_turn_page').empty();
									$('#review_result_turn_page').append(innerText);
								}
								else {
									$('#review_result_turn_page').empty();
								}
							}

							///////////////////////////////////////////////////////////////////////////////////////////////////
							/////////////////////////////////////////////////////////////////////////////////////////////////

							var pagenum = $('#in_disp_from').val() / 25;
							var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text()) - 1;
							var position = pagenum - showPos;

							if(position >= $('#review_result_turn_page .pageitems').length)
							{
								//var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text());
								var showPos = (pagenum - $('#review_result_turn_page .pageitems').length) + 1;

								var i = 1;

								$('#review_result_turn_page .pageitems').each(function() {
										$(this).text(showPos + i);
										i++;
								});

								position = $('#review_result_turn_page .pageitems').length - 1;
							}
							else if(position < 0)
							{
								//alert("shift");
								var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text()) - 2;
								var i = 1;

								$('#review_result_turn_page .pageitems').each(function() {
										$(this).text(showPos + i);
										i++;
								});

								position = 0;
							}

							$('#review_result_turn_page .pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
							$('#review_result_turn_page .pageitems:nth(' + position + ')').css({"background": "#22445B", "color":"#ffffff"});

							///////////////////////////////////////////////////////////////////////////////////////////////////

							if(in_disp_from >= disp_max)
								$('#prev_mypage_review').addClass('active');
							else
								$('#prev_mypage_review').removeClass('active');

							if((in_disp_from + disp_max) > $("#count_sake").val())
								$('#next_mypage_review').removeClass('active');
							else
								$('#next_mypage_review').addClass('active');

							var limit = ((in_disp_from + disp_max) >= $("#count_sake").val()) ? $("#count_sake").val() : (in_disp_from + disp_max);
							$('#disp_sake').text((parseInt($('#in_disp_from').val()) + 1) + "～" + limit + "件 / 全" + $("#count_sake").val() + "件");

							$('html, body').animate({scrollTop:0}, '100');
							removeLoading();
						}

				}).fail(function(data){
						removeLoading();
						alert("Failed:" + data);
				}).complete(function(data){
						// Loadingイメージを消す
						removeLoading();
				});
	    }

		$("body").on("tab_sake_click", function( event, in_disp_from, in_disp_to, username, href, position, bCount) {

			var data = nonda_serialize(in_disp_from, in_disp_to, 1, 1);
			var my_url = "?" + nonda_serialize(in_disp_from, in_disp_to, 1, 2);

			if($("#order_sake").val()) {
				data += "&orderby=" + $("#order_sake").val();
				my_url += "&orderby=" + $("#order_sake").val();
			}

			my_url += href;

			$('#tab_sake').removeClass('nomitai_set');
			$('#tab_sake').addClass('nonda_set');
			$('#tab_sake .display_selection_button.selected').removeClass('selected');
			$('#tab_sake .display_selection div:first-child').addClass('selected');

			var stateObj = { 'search_type': 1,
							'category': 1,
							'data': data,
							'url': my_url,
							'href': href,
							'username': username,
							'orderby': $("#order_sake").val(),
							'from': 0,
							'to': 25 };

			//alert("data:" + data);
			history.pushState(stateObj, "user", my_url);
			$("body").trigger("search_nonda", [ in_disp_from, in_disp_to, data, true ] );
		});

		$("body").on("search_nonda", function( event, in_disp_from, in_disp_to, data, bCount) {
			searchNonda(in_disp_from, in_disp_to, data, bCount);
		});

		$("body").on("search_nomitai", function( event, in_disp_from, in_disp_to, data, bCount) {
			searchSake(in_disp_from, in_disp_to, data, bCount);
		});

		/* 次の飲んだ */
		$(document).on('click', '.nonda_set #next_mypage_review', function() {

				var search_type = 1;
				var category = 1;
				var disp_max = 25;
				var in_disp_from = parseInt($('#in_disp_from').val()) + disp_max;
				var in_disp_to = in_disp_from + disp_max;
				var orderby = $("#order_sake").val();

				var username = $('#all_container').data('username');
				var href = $('.simpleTabs li a:nth(0)').attr('href');

				var data = nonda_serialize(in_disp_from, in_disp_to, 0, 1);
				var my_url = "?" + nonda_serialize(in_disp_from, in_disp_to, 0, 2) + href;

				if(in_disp_from >= $("#count_sake").val())
					return false;

				var stateObj = { 'search_type': search_type,
								 'category': category,
								 'data': data,
								 'url': my_url,
								 'href': href,
								 'username': username,
								 'orderby': orderby,
								 'from': in_disp_from,
								 'to': in_disp_to };

				//alert("my_url:" + my_url);
				history.pushState(stateObj, "user", my_url);
				searchNonda(in_disp_from, disp_max, data, false);
		});

		/* 前の飲んだ */
		$(document).on('click', '.nonda_set #prev_mypage_review', function() {

				var search_type = 1;
				var category = 1;
				var disp_max = 25;
				var in_disp_to = parseInt($("#in_disp_from").val());
				var in_disp_from = parseInt($("#in_disp_from").val()) - disp_max;
				var orderby = $("#order_sake").val();
				var username = $('#all_container').data('username');
				var href = $('.simpleTabs li a:nth(0)').attr('href');

				var data = nonda_serialize(in_disp_from, in_disp_to, 0, 1);
				var my_url = "?" + nonda_serialize(in_disp_from, in_disp_to, 0, 2) + href;

				if(in_disp_from < 0)
				{
					$('#prev_mypage_review').removeClass('active');
					return false;
				}

				var stateObj = { 'search_type': search_type,
								 'category': category,
								 'data': data,
								 'url': my_url,
								 'href': href,
								 'username': username,
								 'orderby': orderby,
								 'from': in_disp_from,
								 'to': in_disp_to };

				history.pushState(stateObj, "user", my_url);
				searchNonda(in_disp_from, disp_max, data, false);
		});

		$(document).on('click', '.nonda_set #review_result_turn_page .pageitems', function(e){

				var search_type = 1;
				var category = 1;
				var limit = 0;
				var disp_max = 25;
				var count_query = 1;
				var href = $('.simpleTabs li a:nth(0)').attr('href');
				var orderby = $("#order_sake").val();
				var username = $('#all_container').data('username');
				var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text());
				var position = $(this).index();

				var in_disp_from = (showPos + position - 2) * disp_max;
				var in_disp_to = in_disp_from + disp_max;
				var href = $('.simpleTabs li a:nth(0)').attr('href');

				var data = nonda_serialize(in_disp_from, in_disp_to, 0, 1);
				var my_url = "?" + nonda_serialize(in_disp_from, in_disp_to, 0, 2) + href;

				$('.nonda_set #review_result_turn_page .pageitems.selected').removeClass("selected");

				var stateObj = { 'search_type': search_type,
								 'category': category,
								 'data': data,
								 'url': my_url,
								 'username': username,
								 'href': href,
								 'from': 0,
								 'to': 25,
								 'orderby': orderby };

				history.pushState(stateObj, "user", my_url);
				searchNonda(in_disp_from, disp_max, data, false);
		});

		/////////////////////////////////////////////////////
		// 飲んだ　更新日　click for sorting
		/////////////////////////////////////////////////////
		$(document).on('click', '#tab_sake.nonda_set .click_sort_date', function(e) {

				/*
				var count_query = 1;
				var disp_max = 25;
				var username = $('#all_container').data('username');
				var disp_max = 25;
				var in_disp_from = 0;
				var in_disp_to = in_disp_from + disp_max;

				var orderby = ($("#order_sake").val() == 1) ? 2 : 1;
				var data = "search_type=" + search_type + "&from=" + in_disp_from + "&disp_max=" + disp_max + "&count_query=" + count_query + "&username=" + username+"&orderby=" + orderby;

			    //alert("飲んだ data:" + data);

				$("#order_sake").val(orderby);
				$("#sake_sort span").css({"background": "#d2d2d2", "color": "#ffffff"});
				$(this).css({"background": "#28809E", "color": "#ffffff"});
				searchNonda(in_disp_from, disp_max, data, false);
				*/
		});

		/* 飲んだ */
		$('#tab_sake .display_selection div:first-child').on( "click", function(event) {

				var search_type = 1;
				var category = 1;
				var in_disp_from = 0;
				var in_disp_to = 25;
				var count_query = 1;
				var username = $('#all_container').data('username');
				var orderby = $("#order_sake").val();
				var href = $('.simpleTabs li a:nth(0)').attr('href') ? $('.simpleTabs li a:nth(0)').attr('href') : "#tab_sake";
				var data = nonda_serialize(in_disp_from, in_disp_to, count_query, 1);
				var my_url = "?" + nonda_serialize(in_disp_from, in_disp_to, 0, 2) + href;

				$('#tab_sake').removeClass('nomitai_set');
				$('#tab_sake').addClass('nonda_set');
				$('#tab_sake .display_selection_button.selected').removeClass('selected');
				$(this).addClass('selected');
				//$('#all_container').data('cateogry', 1);

				var stateObj = { 'search_type': search_type,
								 'category': category,
								 'data': data,
								 'url': my_url,
								 'href': href,
								 'username': username,
								 'from': 0,
								 'to': 25,
								 'orderby': orderby };

				history.pushState(stateObj, "user", my_url);
				searchNonda(in_disp_from, in_disp_to, data, true);
				ev.stopPropagation();
		});

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// 飲みたい
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function sake_serialize(in_disp_from, in_disp_to, query_count, mode) {

			var data = "search_type=1" + "&category=2";
			var loginname = <?php echo json_encode($_COOKIE['login_cookie']); ?>;
			var username =  <?php echo json_encode($_GET['username']); ?>;

			if(mode == 1) { // for ajax
				data += "&from=" + in_disp_from + "&disp_max=" + in_disp_to;

				if(username && username != "")
					data += "&username=" + username;
				else if(loginname && loginname != "")
					data += "&username=" + loginname;
			}
			else if(mode == 2) { // for url
				data += "&page=" + (in_disp_from / $('#all_container').data('max') + 1);

				if(username && username != "")
					data += "&username=" + username;
			}

			if(query_count && query_count == 1) {
				data += "&count_query=" + query_count;
			}

			data += "&orderby=" + $("#order_sake").val();
			return data;
		}

		function searchSake(in_disp_from, in_disp_to, data, bCount)
		{
			    dispLoading("処理中...");
				//alert("searchsake data:" + data);

				$.ajax({
						type: "POST",
						url: "ajax_favorite.php",
						data: data,
						dataType: 'json',

				}).done(function(data){

						var innerHTML = "";
						var i = 0;
						var count_result = data[0].count;
						var sake = data[0].result;
						var sql = data[0].sql;

						removeLoading();
						//alert("success:" + sake.length);
						//alert("searchSake sql:" + sql);

						$('#sake_table').empty()

						if(bCount && (count_result == 0 && sake == null)) {
							var innerText = '<div class="navigate_page_no_registry">飲みたい登録はありません</div>';
							$("#sake_sort").css({"display":"none"});
							$('#disp_sake').css({"display":"none"});
							$("#tab_sake .result_count_container").css({"display":"none"});
							$('#sake_table').html(innerText);
							$('#review_result_turn_page').css({"display": "none"});
							removeLoading();
						}
						else if(count_result == 0 && sake == null) {
							var innerText = '<div class="navigate_page_no_registry"></div>';
							$("#sake_sort").css({"display":"none"});
							$('#disp_sake').css({"display":"none"});
							$("#tab_sake .result_count_container").css({"display":"none"});
							$('#sake_table').html(innerText);
							$('#review_result_turn_page').css({"display": "none"});
							removeLoading();
						}
						else {
							$("#sake_sort").css({"display":"flex"});
							$("#tab_sake .result_count_container").css({"display":"flex"});
							$('#disp_sake').css({"display":"block"});

							var username = $('#all_container').data('username');
							var loginname = <?php echo json_encode($loginname); ?>;

							for(i = 0; i < sake.length; i++)
							{
								innerHTML += '<a class="searchRow_link" href="sake_view.php?sake_id=' + sake[i].sake_id + '">';
									innerHTML += '<div class="search_result_name_container">';

										innerHTML += '<div class="search_result_sake_image"><img id="' + sake[i].path + '" src="' + sake[i].path + '"></div>';

										innerHTML += '<div class="search_result_sake_brewery_date_container">';
											innerHTML += '<div class="search_result_sake">' + sake[i].sake_name + '</div>';

											innerHTML += '<div class="search_result_brewery_date_container">';
												innerHTML += '<div class="search_result_brewery">' + sake[i].sakagura_name + ' / ' + sake[i].pref + '</div>';
												innerHTML += '<div class="search_result_date">' + sake[i].write_date + '</div>';
											innerHTML += '</div>';

										innerHTML += '</div>';

										innerHTML += '<div class="search_result_button_container">';

											if(username == loginname) {
												//innerHTML += '<button id="' + sake[i].sake_id + '" class="user_button" style="float:right"><span class="button_icon"><img src="images/icons/heart.svg"></span><span class="button_text">飲みたい解除</span></button>';
												innerHTML += '<button class="custom_button followed" sake_id=' + sake[i].sake_id + '><span class="button_icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button_text">飲みたい</span></button>';
											}
										innerHTML += '</div>';

								innerHTML += '</div>';

								////////////////////////////////////////////////
								// 酒ランク
								var rank_width = (sake[i].sake_rank / 5) * 100 + '%';

								innerHTML	+= '<div class="search_result_rank">';

									innerHTML += '<div class="search_result_star_rating">';
										innerHTML += '<div class="search_result_star_rating_front" style="width: ' + rank_width + '">★★★★★</div>';
										innerHTML += '<div class="search_result_star_rating_back">★★★★★</div>';
									innerHTML += '</div>';

									if(sake[i].sake_rank != null && sake[i].sake_rank != '') {
										innerHTML += '<span class="search_result_sake_rate">' + sake[i].sake_rank.toFixed(1) + '</span>';
									}
									else {
										innerHTML += '<span class="search_result_sake_rate" style="color: #b2b2b2">--</span>';
									}

								innerHTML += '</div>';

								////////////////////////////////////////////////
								innerHTML += '<div class="spec">';

									////////////////////////////////////////////////
									// 特定名称
									////////////////////////////////////////////////
									innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg>特定名称</div>';
										innerHTML += '<div class="spec_info">';
											if(sake[i].special_name != "") {
												innerHTML += sake[i].special_name;
											} else {
												innerHTML += '<span style="color: #b2b2b2;">--</span>';
											}
										innerHTML += '</div>';
									innerHTML += '</div>';

									/////////////////////////////////////////////////
									// Alc度数
									////////////////////////////////////////////////
									innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_alc1616"><use xlink:href="#alc1616"/></svg>Alc度数</div>';
										innerHTML += '<div class="spec_info">';
											if(sake[i].alcohol_level) {
												innerHTML += sake[i].alcohol_level;
											} else {
												innerHTML += '<span style="color: #b2b2b2;">--</span>';
											}
										innerHTML += '</div>';
									innerHTML += '</div>';

									/////////////////////////////////////////////////
									// 原料米
									////////////////////////////////////////////////
									innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_rice1616"><use xlink:href="#rice1616"/></svg>原料米</div>';
										innerHTML += '<div class="spec_info">';
											if(sake[i].rice_used) {
												innerHTML += sake[i].rice_used;
											} else {
												innerHTML += '<span style="color: #b2b2b2;">--</span>';
											}
										innerHTML += '</div>';
									innerHTML += '</div>';

									/////////////////////////////////////////////////
									// 精米歩合
									////////////////////////////////////////////////
									innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg>精米歩合</div>';
										innerHTML += '<div class="spec_info">';
											if(sake[i].seimai_level) {
												innerHTML += sake[i].seimai_level;
											} else {
												innerHTML += '<span style="color: #b2b2b2;">--</span>';
											}
										innerHTML += '</div>';
									innerHTML += '</div>';

									/////////////////////////////////////////////////
									// 日本酒度
									////////////////////////////////////////////////
									innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_nihonshudo1616"><use xlink:href="#nihonshudo1616"/></svg>日本酒度</div>';
										innerHTML += '<div class="spec_info">';
											if(sake[i].jsake_level && sake[i].jsake_level != "") {
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
										innerHTML += "</div>";
									innerHTML += "</div>";
									/////////////////////////////////////////////////

								innerHTML += '</div>'; // spec

							innerHTML += '</a>'; // searchRow_link
						} // for

						//innerHTML += '</div>';//hirasawaこれ必要？

						$('#sake_table').append(innerHTML);

						if(bCount == true)
						{
							//alert("count:" + count_result);
							var p_max = 25;
							var numPage = Math.ceil(count_result / p_max);
							var numPage = (numPage < 5) ? numPage : 5;
							var i = 1;

							$("#count_sake").val(count_result);

							if(count_result > p_max) {
								innerText = '<button id="prev_mypage_review"><svg class="prev_button_prev2020"><use xlink:href="#prev2020"/></svg></button>';
								innerText += '<button class="pageitems selected">' + i + '</button>';

								for(i++; i <= numPage; i++) {
									 innerText += '<button class="pageitems">' + i + '</button>';
								}

								if(numPage > 1)
									innerText += '<button id="next_mypage_review" class="active"><svg class="next_button_next2020"><use xlink:href="#next2020"/></svg></button>';
								else
									innerText += '<button id="next_mypage_review"><svg class="next_button_next2020"><use xlink:href="#next2020"/></svg></button>';

								$('#review_result_turn_page').empty();
								$('#review_result_turn_page').append(innerText);
							}
							else {
								$('#review_result_turn_page').empty();
							}
						}

						////////////////////////////////////////////////////////////////////////////////////////////////////
						////////////////////////////////////////////////////////////////////////////////////////////////////

						$("#in_disp_from").val(in_disp_from);

						var pagenum = in_disp_from / 25;
						var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text()) - 1;
						var position = pagenum - showPos;
						var p_max = 25;

						if(position >= $('#review_result_turn_page .pageitems').length)
						{
							//var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text());
							var showPos = (pagenum - $('#review_result_turn_page .pageitems').length) + 1;
							var i = 1;

							$('#review_result_turn_page .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});

							position = $('#review_result_turn_page .pageitems').length - 1;
						}
						else if(position < 0)
						{
							var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text()) - 2;
							var i = 1;

							$('#review_result_turn_page .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});

							position = 0;
						}

						var limit = ((in_disp_from + p_max) >= $("#count_sake").val()) ? $("#count_sake").val() : (in_disp_from + p_max);
						$('#disp_sake').text((parseInt($('#in_disp_from').val()) + 1) + "～" + limit + "件 / 全" + $("#count_sake").val() + "件");

						$('#review_result_turn_page .pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
						$('#review_result_turn_page .pageitems:nth(' + position + ')').css({"background": "#22445B", "color":"#ffffff"});

						if(in_disp_from >= p_max)
							$('#prev_mypage_review').addClass('active');
						else
							$('#prev_mypage_review').removeClass('active');

						if((in_disp_from + p_max) > $("#count_sake").val())
							$('#next_mypage_review').removeClass('active');
						else
							$('#next_mypage_review').addClass('active');

						$('html, body').animate({scrollTop:0}, '100');
					}
				}).fail(function(data){
						removeLoading();
						alert("Failed:" + data);
				}).complete(function(data){
						removeLoading();
				});
	    }

		/* 次の飲みたい */
		$(document).on('click', '.nomitai_set #next_mypage_review', function() {

				var search_type = 1;
				var category = 2;
				var href = $('.simpleTabs li a:nth(0)').attr('href');
				var disp_max = 25;
				var in_disp_from = parseInt($("#in_disp_from").val()) + disp_max;
				var in_disp_to = in_disp_from + disp_max;
				var username = $('#all_container').data('username');
				var orderby = $("#order_sake").val();
				var bCount = 0;

				//alert("next count sake:" + $("#count_sake").val());

				if($('#review_result_turn_page .pageitems').length >   Math.ceil(  $("#count_sake").val() / disp_max))
				{
					var in_disp_from = parseInt($("#in_disp_from").val());
					var in_disp_to = in_disp_from + disp_max;
					bCount = 1;
					//alert("overflow page in_disp_from:" + in_disp_from + " in_disp_to:" + in_disp_to);
				}
				else if(in_disp_from >= $("#count_sake").val())
					return false;

				var data = sake_serialize(in_disp_from, disp_max, bCount, 1);
				var my_url = "?" + sake_serialize(in_disp_from, disp_max, 0, 2) + href;

				//alert("data:" + data);
				var stateObj = { 'search_type': search_type,
								 'data': data,
								 'url': my_url,
								 'category': category,
								 'href': href,
								 'from': in_disp_from,
								 'to': in_disp_to,
								 'username': username,
								 'orderby': orderby };

				history.pushState(stateObj, "user", my_url);
				searchSake(in_disp_from, in_disp_to, data, bCount);
		});

		/* 前の飲みたい */
		$(document).on('click', '.nomitai_set #prev_mypage_review', function() {

				var search_type = 1;
				var category = 2;
				var disp_max = 25;
				var href = $('.simpleTabs li a:nth(0)').attr('href');
				var in_disp_to = parseInt($("#in_disp_from").val());
				var in_disp_from = parseInt($("#in_disp_from").val()) - disp_max;
				var orderby = $("#order_sake").val();
				var username = $('#all_container').data('username');
				var data = sake_serialize(in_disp_from, disp_max, 0, 1);
				var my_url = "?" + sake_serialize(in_disp_from, disp_max, 0, 2) + href;

				if(in_disp_from < 0)
					return false;

				var stateObj = { 'search_type': search_type,
								 'category': category,
								 'data': data,
								 'url': my_url,
								 'href': href,
								 'from': in_disp_from,
								 'to': in_disp_to,
								 'username': username,
								 'orderby': orderby };

				history.pushState(stateObj, "user", my_url);
				searchSake(in_disp_from, in_disp_to, data, false);
		});

		$(document).on('click', '.nomitai_set #review_result_turn_page .pageitems', function(e){

				var search_type = 1;
				var category = 2;
				var disp_max = 25;
				var showPos = parseInt($('#review_result_turn_page .pageitems:nth(0)').text());
				var position = $(this).index();
				var in_disp_from = (showPos + position - 2) * disp_max;
				var in_disp_to = in_disp_from + disp_max;
				var orderby = $("#order_sake").val();
				var username = $('#all_container').data('username');
				var href = $('.simpleTabs li a:nth(0)').attr('href');
				var data = sake_serialize(in_disp_from, disp_max, 1, 1);
				var my_url = "?" + sake_serialize(in_disp_from, disp_max, 0, 2) + href;

				$('#review_result_turn_page .pageitems.selected').removeClass("selected");

				var stateObj = { 'search_type': search_type,
								 'category': category,
								 'data': data,
								 'url': my_url,
								 'href': href,
								 'from': in_disp_from,
								 'to': in_disp_to,
								 'username': username,
								 'orderby': orderby };

				history.pushState(stateObj, "user", my_url);
				searchSake(in_disp_from, in_disp_to, data, false);
		});

		/* 飲みたい */
		$('#tab_sake .display_selection div:nth-child(2)').on( "click", function(event) {

				var search_type = 1;
				var category = 2;
				var disp_max = 25;
				var in_disp_from = 0;
				var in_disp_to = disp_max;
				var orderby = $("#order_sake").val();
				var count_query = 1;
				var username = $('#all_container').data('username');
				var href = $('.simpleTabs li a:nth(0)').attr('href');
				var data = sake_serialize(in_disp_from, disp_max, 1, 1);
				var my_url = "?" + sake_serialize(in_disp_from, disp_max, 0, 2) + href;

				$('#all_container').data('cateogry', 2);
				$('#tab_sake').removeClass('nonda_set');
				$('#tab_sake').addClass('nomitai_set');

				$('#tab_sake .display_selection_button.selected').removeClass('selected');
				$(this).addClass('selected');

				var stateObj = { 'search_type': search_type,
								 'category': category,
								 'data': data,
								 'url': my_url,
								 'href': href,
								 'orderby': orderby,
								 'username': username,
								 'from': 0,
								 'to': 25 };

				history.pushState(stateObj, "user", my_url);
				searchSake(in_disp_from, disp_max, data, true);
				ev.stopPropagation();
		});

		/////////////////////////////////////////////////////
		// 飲みたい　更新日　click for sorting
		/////////////////////////////////////////////////////
		$(document).on('click', '#tab_sake.nomitai_set .click_sort_date', function(e) {

				var search_type = 1;
				var category = 2;
				var disp_max = 25;
				var username = $('#all_container').data('username');
				var in_disp_from = 0;
				var in_disp_to = disp_max;
				var href = $('.simpleTabs li a:nth(0)').attr('href');
				var orderby = ($("#order_sake").val() == 1) ? 2 : 1;
				var data = "search_type=" + search_type + "&category = "+category + "&from=" + in_disp_from + "&disp_max=" + disp_max + "&username=" + username + "&orderby=" + orderby;
				var my_url = "?search_type=" + search_type + "&category = "+category + "&from=" + in_disp_from + "&username=" + username + "&orderby=" + orderby + href;

				$("#order_sake").val(orderby);
				$("#sake_sort span").css({"color": "#b2b2b2"});
				$(this).css({"color": "#0740A5"});

				var stateObj = { 'search_type': search_type,
								 'category': category,
								 'data': data,
								 'url': my_url,
								 'href': href,
								 'from': 0,
								 'to': 25 };

				history.pushState(stateObj, "user", href);
				searchSake(in_disp_from, disp_max, data, false);
		});
});

/*****************************************************************************************************************************************************************************************
 * 酒蔵タブ
 *****************************************************************************************************************************************************************************************/

$(function() {

		$('#in_sakagura_disp_from').val(0);

		function searchSakagura(data, in_disp_from, in_disp_to)
		{
				dispLoading("処理中...");
				//alert("sakagura data:" + data);
				//alert("count_result:" + $('#count_result').val());

				$.ajax({
						type: "POST",
						url: "ajax_favorite.php",
						data: data,
						dataType: 'json',

				}).done(function(data){

						var innerHTML = "";
						var i = 0;
						var sakagura = data[0].result;

						//alert("searchSakagura:success data[0].count" + data[0].result + " data[0].sake:" + data[0].sql);
						//alert("検索結果:" + data[0].count);
						//alert("sql:" + data[0].sql);

						////////////////////////////////////////////////////////////////////////
						var disp_max = 25;
						var limit = $('#in_sakagura_disp_from').val() + disp_max;
						limit = (limit > $("#count_sakagura").val()) ? $("#count_sakagura").val() : limit;

						//alert("my in_disp_from:" + in_disp_from);
						$('#in_sakagura_disp_from').val(in_disp_from);
						////////////////////////////////////////////////////////////////////////

						$('#sakagura_table').empty();

						if(sakagura == null || sakagura.length == 0) {
							var innerText = '<div class="navigate_page_no_registry">お気に入り登録はありません</div>';
							$('#sakagura_table').html(innerText);
							$('#sakagura_result_turn_page').css({"display": "none"});
							$("#tab_sakagura #sake_sort").css({"display":"none"});
							$("#tab_sakagura .result_count_container").css({"display":"none"});
							removeLoading();
						}
						else {
							var j = 0;
							var alcohol_array = 0;
							var syudo_array = 0;
							var loginname = <?php echo json_encode($loginname); ?>;

							for(i = 0; i < sakagura.length; i++)
							{
								innerHTML = '<a class="sakaguraRow_link" href="sda_view.php?id=' + sakagura[i].sakagura_id + '">';

									/////////////////////////////////////////////////////////////////////////////
									innerHTML += '<div class="search_sakagura_result_name_container">';
										/*一時的に非表示innerHTML += '<div class="search_sakagura_result_brewery_image"><img id="' + '" src="' + sakagura[i].filename + '"></div>';*/

										innerHTML += '<div class="search_sakagura_result_brewery_pref_date_container">';
											innerHTML += '<div class="search_sakagura_result_brewery">' + sakagura[i].sakagura_name + '</div>';

											innerHTML += '<div class="search_result_brewery_date_container">';
												innerHTML += '<div class="search_result_brewery">' + sakagura[i].pref + ' ' + sakagura[i].address + '</div>';
												innerHTML += '<div class="search_result_date">' + sakagura[i].write_date + '</div>';
											innerHTML += '</div>';
										innerHTML += '</div>';


										if($('#all_container').data('username') == loginname) {
											innerHTML += '<div class="search_sakagura_result_button_container">';
												innerHTML += '<button class="custom_button followed" sakagura_id=' + sakagura[i].sakagura_id + '><span class="button_icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button_text">お気に入り</span></button>';
											innerHTML += '</div>';
										}

									innerHTML += '</div>';
									/////////////////////////////////////////////////////////////////////////////

									innerHTML += '<div class="spec">';

										///////////
										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_bottle1616"><use xlink:href="#bottle1616"/></svg>代表銘柄</div>';
										innerHTML += '<div class="spec_info">';

										if(sakagura[i].brand)
											innerHTML += sakagura[i].brand;
										else
											innerHTML += '<span style="color: #b2b2b2;">--</span>';

										innerHTML += '</div>';
										innerHTML += '</div>';

										/////////////////////////////////////////////////

										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_visit1616"><use xlink:href="#visit1616"/></svg>酒蔵見学</div>';
										innerHTML += '<div class="spec_info">';

										if(sakagura[i].observation == 1)
											innerHTML += '可';
										else if(sakagura[i].observation == 2)
											innerHTML += '不可';
										else
											innerHTML += '<span style="color: #b2b2b2;">--</span>';

										innerHTML += '</div>';
										innerHTML += '</div>';

										/////////////////////////////////////////////////

										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_kurashop1616"><use xlink:href="#kurashop1616"/></svg>酒蔵直販店</div>';
										innerHTML += '<div class="spec_info">';

										if(sakagura[i].direct_sale == 1)
											innerHTML += 'あり';
										else if(sakagura[i].direct_sale == 2)
											innerHTML += 'なし';
										else
												innerHTML += '<span style="color: #b2b2b2">--</span>';

										innerHTML += '</div>';
										innerHTML += '</div>';

										/////////////////////////////////////////////////

										/*公開中非表示innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title">酒造組合登録</div>';
										innerHTML += '<div class="spec_info">';

										if(sakagura[i].kumiai == 10)
											innerHTML += 'あり';
										else if(sakagura[i].kumiai == 11)
											innerHTML += 'なし';
										else if(sakagura[i].kumiai == 12)
											innerHTML += '不明';
										else
											innerHTML += '--';

										innerHTML += '</div>';
										innerHTML += '</div>';

										/////////////////////////////////////////////////

										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title">国税庁登録</div>';
										innerHTML += '<div class="spec_info">';

										if(sakagura[i].kokuzei == 10)
											innerHTML += 'あり';
										else if(sakagura[i].kokuzei == 11)
											innerHTML += 'なし';
										else if(sakagura[i].kokuzei == 12)
											innerHTML += '不明';
										else
											innerHTML += '--';

										innerHTML += '</div>';
										innerHTML += '</div>';

										/////////////////////////////////////////////////

										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title">プライオリティ</div>';
										innerHTML += '<div class="spec_info">';

										if(sakagura[i].priority == 1)
											innerHTML += 'S'
										else if(sakagura[i].priority == 2)
											innerHTML += 'A'
										else if(sakagura[i].priority == 3)
											innerHTML += 'B'
										else if(sakagura[i].priority == 4)
											innerHTML += 'C'
										else if(sakagura[i].priority == 5)
											innerHTML += 'D'
										else if(sakagura[i].priority == 6)
											innerHTML += 'E'
										else if(sakagura[i].priority == 7)
											innerHTML += 'X'
										else
											innerHTML += '--'

										innerHTML += '</div>';
										innerHTML += '</div>';

										/////////////////////////////////////////////////

										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title">ステータス</div>';
										innerHTML += '<div class="spec_info">';

										if(sakagura[i].status == 10)
											innerHTML += 'active';
										else if(sakagura[i].status == 11)
											innerHTML += 'inactive';
										else if(sakagura[i].status == 12)
											innerHTML += '一時製造休止';
										else if(sakagura[i].status == 13)
											innerHTML += '営業不明';
										else
											innerHTML += '--';

										innerHTML += '</div>';
										innerHTML += '</div>';*/

									////////////
									innerHTML += '</div>'; // sakaguraspec
									////////////

									innerHTML += '</a>'; //sakaguraRow_link

									$('#sakagura_table').append(innerHTML);
							}

							var limit = (in_disp_to >= $("#count_sakagura").val()) ? $("#count_sakagura").val() : in_disp_to;
							var pagenum = $('#in_sakagura_disp_from').val() / 25;

							var showPos = parseInt($('#sakagura_result_turn_page .pageitems:nth(0)').text()) - 1;
							var pagenum = $('#in_sakagura_disp_from').val() / 25;
							var position = pagenum - showPos;

							//alert("showPos:" + showPos + " pagenum:" + pagenum + " position:" + position);

							if(position >= $('#sakagura_result_turn_page .pageitems').length)
							{
								//var showPos = parseInt($('#sakagura_result_turn_page .pageitems:nth(0)').text());
								var showPos = (pagenum - $('#sakagura_result_turn_page .pageitems').length) + 1;
								var i = 1;

								$('#sakagura_result_turn_page .pageitems').each(function() {
										$(this).text(showPos + i);
										i++;
								});

								position = $('#sakagura_result_turn_page .pageitems').length - 1;
							}
							else if(position < 0)
							{
								//var showPos = parseInt($('#sakagura_result_turn_page .pageitems:nth(0)').text()) - 2;
								var showPos = showPos + position;
								var i = 1;

								$('#sakagura_result_turn_page .pageitems').each(function() {
										$(this).text(showPos + i);
										i++;
								});

								position = 0;
							}

							$('#sakagura_result_turn_page .pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
							$('#sakagura_result_turn_page .pageitems:nth(' + position + ')').css({"background": "#22445B", "color":"#ffffff"});
							$('#sakagura_result_turn_page').css({"display": "flex"});

							var text = parseInt($('#in_sakagura_disp_from').val()) + 1 + '～' + limit + '件 / 全' + $('#count_sakagura').val() + '件'
							$('#count_result').text(text);

							$('html, body').animate({scrollTop:0}, '100');

							if(parseInt($('#in_sakagura_disp_from').val()) >= 25)
								$('#prev_mypage_sakagura').addClass('active');
							else
								$('#prev_mypage_sakagura').removeClass('active');

							if((parseInt($('#in_sakagura_disp_from').val()) + 25) < parseInt($("#count_sakagura").val()))
								$('#next_sakagura').addClass('active');
							else
								$('#next_sakagura').removeClass('active');
					}
					removeLoading();

				}).fail(function(data){
						removeLoading();
						alert("Failed:" + data);
				}).complete(function(data){
						//alert("complete");
						// Loadingイメージを消す
						removeLoading();
				});
		}

		function sakagura_serialize(in_disp_from, disp_max, query_count, mode)
		{
			var category = 2;
			var orderby = $("#order_sakagura").val();
			var loginname = <?php echo json_encode($_COOKIE['login_cookie']); ?>;
			var username =  <?php echo json_encode($username); ?>;
			var data = "search_type=2";

			if(mode == 1) { // for ajax
				data += "&from=" + in_disp_from + "&disp_max=" + disp_max;

				if(username && username != "")
					data += "&username=" + username;
				else if(loginname && loginname != "")
					data += "&username=" + loginname;
			}
			else if(mode == 2) { // for url
				var url_username =  <?php echo json_encode($_GET['username']); ?>;

				data += "&page=" + (in_disp_from / $('#all_container').data('max') + 1);

				if(url_username && url_username != "")
					data += "&username=" + url_username;
			}

			if(query_count && query_count == 1) {
				data += "&count_query=" + query_count;
			}

			return data;
		}

		$("body").on("tab_sakagura_click", function(event, in_disp_from, in_disp_to, username, href, position, bCount)
		{
			var search_type = 2;
			var category = 2;
			var data = sakagura_serialize(in_disp_from, in_disp_to, 1, 1);
			var my_url = "?" + sakagura_serialize(in_disp_from, in_disp_to, 1, 2);

			if($("#order_sakagura").val()) {
				data += "&orderby=" + $("#order_sakagura").val();
				my_url += "&orderby=" + $("#order_sakagura").val();
			}

			my_url += href;

			$('#tab_sakagura .display_selection_button.selected').removeClass('selected');
			$('#tab_sakagura .display_selection_button:nth(1)').addClass('selected');

			$('#sakagura_result_turn_page .pageitems.selected').removeClass('selected');
			$('#sakagura_result_turn_page .pageitems:nth(0)').addClass('selected');

			var stateObj = { 'search_type': search_type,
							 'category': category,
							 'data': data,
							 'url': my_url,
							 'href': href,
							 'username': username,
							 'orderby': $("#order_sakagura").val(),
							 'from': 0,
							 'to': 25 };

			history.pushState(stateObj, "user", my_url);
			searchSakagura(data, in_disp_from, in_disp_to);
		});

		$("body").on("search_sakagura", function(event, data, in_disp_from, in_disp_to) {
			searchSakagura(data, in_disp_from, in_disp_to)
		});

		/* コメント・写真 */
		$('#tab_sakagura .display_selection div:first-child').on( "click", function(event) {

				$('#tab_sakagura .display_selection_button.selected').removeClass('selected');
				$(this).addClass('selected');
		});

		/* お気に入り */
		$('#tab_sakagura .display_selection div:nth-child(2)').on( "click", function(event) {

				$('#tab_sakagura .display_selection_button.selected').removeClass('selected');
				$(this).addClass('selected');

				/*
				var search_type = 2;
				var disp_max = 25;
				var in_disp_from = 0;
				var in_disp_to = ((in_disp_from + disp_max) > $('#count_sakagura').val()) ? $('#count_sakagura').val() : in_disp_from + disp_max;
				var username = $('#all_container').data('username');
				var count_query = 1;
				var data = "search_type=" + search_type + "&from = "+in_disp_from + "&disp_max=" + disp_max + "&username=" + username + "&orderby="+ $("#order_sake").val() + "&count_query=1";

				$('#tab_sakagura .display_selection_button.selected').removeClass('selected');
				$(this).addClass('selected');

				var text = (in_disp_from + 1) + '～' + in_disp_to + '件 / 全' + $('#count_sakagura').val() + '件'
				$('#count_result').text(text);

			    //alert("data:" + data);
				searchSakagura(data, in_disp_from, in_disp_to);
				ev.stopPropagation();
				*/
		});

		$("#sakagura_table").delegate('.search_sakagura_result_button_container .custom_button', 'click', function() {

				event.preventDefault();

				var id = $(this).attr('sakagura_id');
				var data = "sakagura_id="+$(this).attr('sakagura_id');
				var obj = this;

				//alert("酒蔵ID:"+id);

				$.ajax({
						type: "post",
						url: "sda_follow.php?id="+id,
						data: data,
				}).done(function(xml){
						var str = $(xml).find("str").text();

						if(str == "follow")
						{
							$(obj).removeClass("followed");
						}
						else
						{
							$(obj).addClass("followed");
						}

				}).fail(function(data){
						alert("This is Error");
				});
		});

		$(document).on('click', '#next_sakagura', function() {

				var search_type = 2;
				var disp_max = 25;
				var username = $('#all_container').data('username');
				var orderby = $("#order_sakagura").val();
				var in_disp_from = parseInt($("#in_sakagura_disp_from").val()) + disp_max;
				var in_disp_to = ((in_disp_from + disp_max) > $('#count_sakagura').val()) ? $('#count_sakagura').val() : in_disp_from + disp_max;
				var href = $('.simpleTabs li a:nth(1)').attr('href');
				var data = sakagura_serialize(in_disp_from, disp_max, 1, 1);
				var my_url = "?" + sakagura_serialize(in_disp_from, disp_max, 1, 2) + href;

				if((parseInt($("#in_sakagura_disp_from").val()) + disp_max) >= $("#count_sakagura").val())
					return false;

				var stateObj = { 'search_type': search_type,
								 'data': data,
								 'url': my_url,
								 'href': href,
								 'orderby': orderby,
								 'username': username,
								 'from': in_disp_from,
								 'to': in_disp_to };

				history.pushState(stateObj, "user", my_url);

				//alert("sakagura data:" + data);
				searchSakagura(data, in_disp_from, in_disp_to);
		});

		$(document).on('click', '#prev_mypage_sakagura', function() {

				var search_type = 2;
				var disp_max = 25;
				var username = $('#all_container').data('username');
				var orderby = $("#order_sakagura").val();
				var in_disp_from = parseInt($("#in_sakagura_disp_from").val()) - disp_max;
				var in_disp_to = in_disp_from + disp_max;
				var href = $('.simpleTabs li a:nth(1)').attr('href');
				var data = sakagura_serialize(in_disp_from, disp_max, 1, 1);
				var my_url = "?" + sakagura_serialize(in_disp_from, disp_max, 1, 2) + href;

				if(($("#in_sakagura_disp_from").val() - disp_max) < 0)
					return false;

				$('#next_sakagura').addClass('active');

				var stateObj = { 'search_type': search_type,
								 'data': data,
								 'url': my_url,
								 'href': href,
								 'username': username,
								 'orderby': orderby,
								 'from': in_disp_from,
								 'to': in_disp_to };

				history.pushState(stateObj, "user", my_url);
				//alert("search sakagura in_disp_from:" + in_disp_from);
				searchSakagura(data, in_disp_from, in_disp_to);
		});

		$(document).on('click', '#sakagura_result_turn_page .pageitems', function(e){

				var search_type = 2;
				var disp_max = 25;
				var position = parseInt($(this).text());
				var in_disp_from = (position - 1) * disp_max;
				var in_disp_to = in_disp_from + disp_max;
				var username = $('#all_container').data('username');
				var orderby = $("#order_sakagura").val();
				var href = $('.simpleTabs li a:nth(1)').attr('href');
				var data = sakagura_serialize(in_disp_from, disp_max, 1, 1);
				var my_url = "?" + sakagura_serialize(in_disp_from, disp_max, 1, 2) + href;

				var stateObj = { 'search_type': search_type,
								 'data': data,
								 'url': my_url,
								 'href': href,
								 'url': my_url,
								 'username': username,
								 'orderby': orderby,
								 'from': in_disp_from,
								 'to': in_disp_to };

				history.pushState(stateObj, "user", my_url);
				searchSakagura(data, in_disp_from, in_disp_to);
		});
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$(function() {

	function users_serialize(category, in_disp_from, in_disp_to, bCount, mode)
	{
		var data = "search_type=3&category=" + category;
		var loginname = <?php echo json_encode($_COOKIE['username']); ?>;
		var username =  <?php echo json_encode($_GET['username']); ?>;

		if(mode == 1) { // for ajax
			data += "&from=" + in_disp_from + "&in_disp_to=" + in_disp_to;

			if(username && username != "")
				data += "&username=" + username;
			else if(loginname && loginname != "")
				data += "&username=" + loginname;
		}
		else if(mode == 2) { // for url
			var url_username =  <?php echo json_encode($_GET['username']); ?>;

			data += "&page=" + (in_disp_from / $('#all_container').data('max') + 1);

			if(url_username && url_username != "")
				data += "&username=" + url_username;
		}

		if(bCount && bCount == 1) {
			data += "&count_query=" + bCount;
		}

		return data;
	}

	function searchUsers(data, category, in_disp_from, in_disp_to, bCount)
	{
			var loginname = <?php echo json_encode($_COOKIE['username']); ?>;
			var username = $('#all_container').data('username');
			dispLoading("処理中...");
			//alert("searchUsers:" + data);
			//alert("count_result:" + $('#count_result').val());
			//alert("category:" + category);

			$.ajax({
					type: "POST",
					url: "user_follow_search.php",
					data: data,
					dataType: 'json',

			}).done(function(data) {

					removeLoading();

					var i = 0;
					var count_result = data[0].count;
					var users = data[0].result;
					var sql = data[0].sql;

					$('#users_table').empty();
					//alert("sql:" + sql);
					//alert("count_result:" + count_result);

					if(count_result == 0 && users == null) {
						var innerMessage = "";

						if(category == 1)
							innerMessage = "フォローはありません";
						else if(category == 2)
							innerMessage = "フォロワーはいません";

						var innerText = '<div class="navigate_page_no_registry">' + innerMessage + '</div>';

						$('#users_table').html(innerText);
						$('#user_sort').css({"display":"none"});

						//alert("count_result:" + count_result + " users:" + users);
						$("#tab_users .result_count_container").css({"display":"none"});
						$('#userfollowpage').empty();
					}
					else {

						$('#user_sort').css({"display":"flex"});

						for(i = 0; i < users.length; i++) {

							var path = "images/icons/noimage_user30.svg";
							var innerHTML = "";

							if(users[i].imagefile && users[i].imagefile != "") {
								path = "images/profile/" + users[i].imagefile;
							}

							innerHTML += '<a class="usersRow_link" href="user_view.php?username=' + users[i].username + '">';
								innerHTML += '<div class="search_users_result_name_container">';
									innerHTML += '<div class="search_users_result_brewery_image"><img src="' + path + '"></div>';
									innerHTML += '<div class="search_users_result_name_profile_date_container">';
										innerHTML += '<div class="search_users_result_name">' + users[i].nickname + '</div>';
										innerHTML += '<div class="search_result_profile_date_container">';
											innerHTML += '<div class="search_result_date">' + users[i].date_followed + '</div>';
										innerHTML += '</div>';

									innerHTML += '</div>';
									innerHTML += '<div class="search_users_result_button_container">';

										if(username == loginname) {
											if(category == 1) {
												//innerHTML += '<button class="custom_button"><span class="button_icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button_text">フォロー</span></button>';
												innerHTML += '<button class="custom_button followed" data-username="' + users[i].email + '"><span class="button_icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button_text">フォロー</span></button>';
											}
											else if(category == 2) {
												if(users[i].followed) {
													innerHTML += '<button class="custom_button followed" data-username="' + users[i].email + '"><span class="button_icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button_text">フォロー</span></button>';
												}
												else {
													innerHTML += '<button class="custom_button" data-username="' + users[i].email + '"><span class="button_icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button_text">フォロー</span></button>';
												}
											}
										}

									innerHTML += '</div>';
								innerHTML += '</div>';

								innerHTML += '<div class="spec">';

									innerHTML += '<div class="spec_item">';
										innerHTML += '<span class="spec_title"><svg class="spec_item_heart2020"><use xlink:href="#heart2020"/></svg>飲んだ</span><span class="spec_info">' + users[i].nonda_count + '</span>';
									innerHTML += '</div>';
									/////////////////////////////////////////////////
									innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_pin1616"><use xlink:href="#pin1616"/></svg>フォロー中</div>';
										innerHTML += '<div class="spec_info">' + users[i].follow_count + '</div>';
									innerHTML += '</div>';

									/////////////////////////////////////////////////
									innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_people1616"><use xlink:href="#people1616"/></svg>フォロワー</div>';
										innerHTML += '<div class="spec_info">' + users[i].follower_count + '</div>';
									innerHTML += '</div>';
								innerHTML += '</div>';

							innerHTML += '</a>';

							$('#users_table').append(innerHTML);
							$("#tab_users .result_count_container").css({"display":"flex"});
						}

						//////////////////////////////////////////////////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////////////////

						if(bCount == true)
						{
							var p_max = 25;
							var numPage = Math.ceil(count_result / p_max);
							var numPage = (numPage < 5) ? numPage : 5;
							var i = 1;

							$("#count_user").val(count_result);

							if(count_result > p_max) {
								innerText = '<button id="prev_mypage_review"><svg class="prev_button_prev2020"><use xlink:href="#prev2020"/></svg></button>';
								innerText += '<button class="pageitems selected">' + i + '</button>';

								for(i++; i <= numPage; i++) {
									 innerText += '<button class="pageitems">' + i + '</button>';
								}

								if(numPage > 1)
									innerText += '<button id="next_mypage_review" class="active"><svg class="next_button_next2020"><use xlink:href="#next2020"/></svg></button>';
								else
									innerText += '<button id="next_mypage_review"><svg class="next_button_next2020"><use xlink:href="#next2020"/></svg></button>';

								$('#userfollowpage').empty();
								$('#userfollowpage').append(innerText);
							}
							else {
								$('#userfollowpage').empty();
							}
						}

						var limit = (in_disp_to >= $("#count_user").val()) ? $("#count_user").val() : in_disp_to;
						var text = parseInt($('#in_user_disp_from').val()) + in_disp_from + 1 + '～' + limit + '件 / 全' + $('#count_user').val() + '件'

						//////////////////////////////////////////////////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////////////////

						$("#in_user_disp_from").val(in_disp_from);

						var pagenum = $('#in_user_disp_from').val() / 25;
						var showPos = parseInt($('#userfollowpage .pageitems:nth(0)').text()) - 1;
						var position = pagenum - showPos;
						var p_max = 25;

						if(position >= $('#userfollowpage .pageitems').length)
						{
							var showPos = parseInt($('#userfollowpage .pageitems:nth(0)').text());
							var i = 1;

							$('#userfollowpage .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});

							position = $('#userfollowpage .pageitems').length - 1;
						}
						else if(position < 0)
						{
							//alert("case 2");
							var showPos = parseInt($('#userfollowpage .pageitems:nth(0)').text()) - 2;
							var i = 1;

							$('#userfollowpage .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});

							position = 0;
						}

						$('#userfollowpage .pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
						$('#userfollowpage .pageitems:nth(' + position + ')').css({"background": "#22445B", "color":"#ffffff"});


						//////////////////////////////////////////////////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////////////////

						$('#tab_users .result_count_container').text(text);
						$('html, body').animate({scrollTop:0}, '100');

						if(in_disp_from >= p_max)
							$('#userfollowpage #prev_mypage_review').addClass('active');
						else
							$('#userfollowpage #prev_mypage_review').removeClass('active');

						if((in_disp_from + p_max) > $("#count_user").val())
							$('#userfollowpage #next_mypage_review').removeClass('active');
						else
							$('#userfollowpage #next_mypage_review').addClass('active');
					}

			}).fail(function(data){
					removeLoading();
					alert("Failed:" + data);
			}).complete(function(data){
					//alert("complete");
					// Loadingイメージを消す
					removeLoading();
			});
	}


	$(document).on('click', '#userfollowpage #next_mypage_review', function()
	{

			var search_type = 3;
			var disp_max = 25;
			var username = $('#all_container').data('username');
			var orderby = $("#order_sakagura").val();
			var in_disp_from = parseInt($("#in_user_disp_from").val()) + disp_max;
			var in_disp_to = ((in_disp_from + disp_max) > $('#count_user').val()) ? $('#count_user').val() : in_disp_from + disp_max;
			var bCount = 0;

			var href = $('.simpleTabs li a:nth(2)').attr('href');
			var data = users_serialize(1, in_disp_from, in_disp_to, bCount, 1);
			var my_url = "?" + users_serialize(1, in_disp_from, in_disp_to, bCount, 2) + href;
			var category = $('#all_container').data('category') ? $('#all_container').data('category') : 1;


			if((parseInt($("#in_user_disp_from").val()) + disp_max) >= $("#count_user").val())
				return false;

			var stateObj = { 'search_type': search_type,
							'category': 3,
							'data': data,
							'url': my_url,
							'href': href,
							'username': username,
							'orderby': $("#order_user").val(),
							'from': 0,
							'to': 25 };


			history.pushState(stateObj, "user", my_url);
			searchUsers(data, category, in_disp_from, in_disp_to, bCount);

			//alert("sakagura data:" + data);
			//alert("next user");
	});

	$(document).on('click', '#userfollowpage #prev_mypage_review', function()
	{
			var search_type = 3;
			var disp_max = 25;
			var username = $('#all_container').data('username');
			var orderby = $("#order_sakagura").val();
			var in_disp_from = parseInt($("#in_user_disp_from").val()) - disp_max;
			var in_disp_to = ((in_disp_from + disp_max) > $('#count_user').val()) ? $('#count_user').val() : in_disp_from + disp_max;
			var bCount = 0;

			var href = $('.simpleTabs li a:nth(2)').attr('href');
			var data = users_serialize(1, in_disp_from, in_disp_to, bCount, 1);
			var my_url = "?" + users_serialize(1, in_disp_from, in_disp_to, bCount, 2) + href;
			var category = $('#all_container').data('category') ? $('#all_container').data('category') : 1;

			if(($("#in_user_disp_from").val() - disp_max) < 0)
				return false;

			var stateObj = { 'search_type': search_type,
							'category': 3,
							'data': data,
							'url': my_url,
							'href': href,
							'username': username,
							'orderby': $("#order_user").val(),
							'from': 0,
							'to': 25 };

			history.pushState(stateObj, "user", my_url);
			searchUsers(data, category, in_disp_from, in_disp_to, bCount);
	});


	$(document).on('click', '#userfollowpage .pageitems', function(e){

			var search_type = 3;
			var category = $('#all_container').data('category') ? $('#all_container').data('category') : 1;
			var disp_max = 25;
			var showPos = parseInt($('#userfollowpage .pageitems:nth(0)').text());
			var position = $(this).index();
			var in_disp_from = (showPos + position - 2) * disp_max;
			var in_disp_to = in_disp_from + disp_max;
			var orderby = $("#order_user").val();
			var username = $('#all_container').data('username');
			var href = $('.simpleTabs li a:nth(2)').attr('href');
			var data = users_serialize(1, in_disp_from, in_disp_to, 0, 1);
			var my_url = "?" + users_serialize(1, in_disp_from, in_disp_to, 0, 2) + href;

			$('#userfollowpage .pageitems.selected').removeClass("selected");

			var stateObj = { 'search_type': search_type,
							 'category': category,
							 'data': data,
							 'url': my_url,
							 'href': href,
							 'from': in_disp_from,
							 'to': in_disp_to,
							 'username': username,
							 'orderby': orderby };

			history.pushState(stateObj, "user", my_url);
			//alert("pageitems click:" + $(this).index());
			searchUsers(data, category, in_disp_from, in_disp_to, 0);
	});


	$('#user_sort .click_sort_date').click(function() {

		var data = "username=" + $('#all_container').data('username');
		var category = 1;

		$('#user_sort').toggleClass('sort_user_desc');

		if($('#user_sort').hasClass('sort_user_desc')) {
			data += "&sort=ASC";
			//alert("desc");
		}
		else {
			data += "&sort=DESC";
		}

		//alert("data:" + data);
		searchUsers(data, category, 0, 25, false);
	});

	$(document).on('click', '#tab_users .custom_button', function(e) {

			event.preventDefault();

			var favoriteuser = $(this).data('username');
			var data = "favoriteuser=" + favoriteuser;
			var obj = this;
			//alert('tab_user:' + $(this).data('username'));

			$.ajax({
				type: "post",
				url: "user_follow.php",
				data: data,
			}).done(function(xml){

				var str = $(xml).find("str").text();
				//alert("success:" + str);

				if(str == "followed")
				{
					$(obj).addClass("followed");
				}
				else
				{
					$(obj).removeClass("followed");
				}
			}).fail(function(data){
				alert("This is Error");
			});

	});

	$("body").on("tab_users_click", function(event, in_disp_from, in_disp_to, username, href, position, bCount)
	{
		var search_type = 3;
		var in_disp_from = 0;
		var in_disp_to = 25;
		var bCount = 1;
		var data = users_serialize(1, in_disp_from, in_disp_to, bCount, 1);
		var my_url = "?" + users_serialize(1, in_disp_from, in_disp_to, bCount, 2) + href;
		var category = $('#all_container').data('category') ? $('#all_container').data('category') : 1;

		$('#tab_users .display_selection_button.selected').removeClass('selected');
		$('#tab_users .display_selection_button:nth(0)').addClass('selected');

		var stateObj = { 'search_type': search_type,
						'category': 3,
						'data': data,
						'url': my_url,
						'href': href,
						'username': username,
						'orderby': $("#order_user").val(),
						'from': 0,
						'to': 25 };

		history.pushState(stateObj, "user", my_url);
		$("body").trigger("search_users", [ data, category, in_disp_from, in_disp_to, 1 ] );
	});

	$("body").on("search_users", function(event, data, category, in_disp_from, in_disp_to)
	{
		searchUsers(data, category, in_disp_from, in_disp_to, true)
	});

	$('#tab_users .display_selection div:first-child').on( "click", function(event) {

		$('#tab_users .display_selection_button.selected').removeClass('selected');
		$(this).addClass('selected');

		var href = "#tab_users";
		var search_type = 3;
		var category = 1;
		var in_disp_from = 0;
		var in_disp_to = 25;
		var bCount = 1;
		var username = $('#all_container').data('username');
		var data = users_serialize(category, in_disp_from, in_disp_to, bCount, 1);
		var my_url = "?" + users_serialize(category, in_disp_from, in_disp_to, bCount, 2) + href;

		var stateObj = { 'search_type': search_type,
						'category': category,
						'data': data,
						'url': my_url,
						'href': href,
						'username': username,
						'orderby': $("#order_user").val(),
						'from': 0,
						'to': 25 };

		history.pushState(stateObj, "user", my_url);
		//$("body").trigger("search_users", [ data, in_disp_from, in_disp_to, 1 ] );
		searchUsers(data, category, in_disp_from, in_disp_to, true);
	});

	/* お気に入り */
	$('#tab_users .display_selection div:nth-child(2)').on( "click", function(event) {

		$('#tab_users .display_selection_button.selected').removeClass('selected');
		$(this).addClass('selected');

		var href = "#tab_users";
		var search_type = 3;
		var category = 2;
		var in_disp_from = 0;
		var in_disp_to = 25;
		var bCount = 1;
		var username = $('#all_container').data('username');
		var data = users_serialize(category, in_disp_from, in_disp_to, bCount, 1);
		var my_url = "?" + users_serialize(category, in_disp_from, in_disp_to, bCount, 2) + href;
		//alert("data:" + data);

		var stateObj = { 'search_type': search_type,
						'category': 3,
						'data': data,
						'url': my_url,
						'href': href,
						'username': username,
						'orderby': $("#order_user").val(),
						'from': 0,
						'to': 25 };

		history.pushState(stateObj, "user", my_url);
		//$("body").trigger("search_users", [ data, in_disp_from, in_disp_to, 1 ] );
		//alert("category:" + data);
		searchUsers(data, category, in_disp_from, in_disp_to, true);
	});

	/*
	$(document).on('click', '#users_table .usersRow_link', function(e){
		alert("user_table click");
		//var username = $('#user_information').data('contributor');
		//window.open('user_view.php?username=' + username, '_self');
	});
	*/
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$(function() {

		$("#syuhanten_table").delegate('.user_button', 'click', function() {

				var id = this.id;
				var data = "syuhanten_id="+this.id;
				var obj = this;

				$.ajax({
						type: "post",
						url: "syuhan_follow.php?syuhanten_id="+id,
						data: data,
				}).done(function(xml){
						var str = $(xml).find("str").text();

						if(str == "follow")
						{
								$(obj).parent().delegate('div').fadeOut();
						}
				}).fail(function(data){
						alert("This is Error");
				});
		});
});

$(function() {

	$('#trigger_user_message').click(function(){
		$('#dialog_message').fadeToggle();
	});

	$('#addimage').click(function() {
		$("#dialog_addimage_background").css({"display":"block"});
		$("#dialog_addimage").css({"display":"block"});
	});

	$('#close_addimage_button').click(function () {
		$("#dialog_background").css({"display":"none"});
		$("#dialog_addimage").css({"display":"none"});
	});

	$('#close_addimage').click(function() {
		$("#dialog_background").css({"display":"none"});
		$("#dialog_addimage").css({"display":"none"});
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

	$('#user_activity_nonda').text($('#count_sake').val());
	$('#user_activity_sakagura').text($('#count_sakagura').val());

	if($('#user_activity_nonda').text() == '--') {
		$("#user_activity_nonda").css('color', '#b2b2b2');
	}

	if($('#user_activity_sakagura').text() == '--') {
		$("#user_activity_sakagura").css('color', '#b2b2b2');
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	$('.simpleTabs li a').click(function() {

		var position = $(this).parent().index();
		var href = $('.simpleTabs li a:nth(' + position + ')').attr('href');
		var my_url = href;
		var username = $('#all_container').data('username');
		var in_disp_from = 0;
		var in_disp_to = 25;

		if(href == "#tab_sake")
		{
			$("body").trigger("tab_sake_click", [ in_disp_from, in_disp_to, username, href, position, true ] );
		}
		else if(href == "#tab_sakagura")
		{
			$("body").trigger("tab_sakagura_click", [ in_disp_from, in_disp_to, username, href, position, true ] );
		}
		else if(href == "#tab_users")
		{
			$("body").trigger("tab_users_click", [ in_disp_from, in_disp_to, username, href, position, true ] );
		}
	});

	$(window).on('popstate', function(event) {

		var state = event.originalEvent.state;
		var category = state.category;
		var disp_max = 25;
		var curr = $('.simpleTabs').find(".active");
		var href = state.href;
		var prev = $('.simpleTabs').find('a[href="' + state.href +'"]');

		curr.removeClass('active');
		prev.addClass('active');

		$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
		$(href).removeClass('hide').addClass('show').show();

		//alert("popstate:" + state.search_type);

		if(state.search_type == 1)
		{
			if(state.category && state.category == 1) {
				//var data = "from=" + state.from + "&to=" + state.to + "&username=" + state.username + "&orderby=" + state.orderby;
				var data = state.data;
				var in_disp_from = (state.from && state.from != undefined) ? state.from : 0;
				var in_disp_to = in_disp_from + disp_max;

				//alert("data:" + data);
				$('#all_container').data('cateogry', 1);
				$('#tab_sake').removeClass('nomitai_set');
				$('#tab_sake').addClass('nonda_set');
				$('#tab_sake .display_selection_button.selected').removeClass('selected');
				$('#tab_sake .display_selection_button:nth(0)').addClass('selected');
				$("body").trigger("search_nonda", [ in_disp_from, disp_max, data, false ] );
			}
			else if(state.category && state.category == 2) {
				var in_disp_from = (state.from && state.from != undefined) ? state.from : 0;
				var in_disp_to = in_disp_from + disp_max;
				var data = state.data;
				//var data = "search_type=" + state.search_type +"&from=" + state.from + "&disp_max=" + disp_max + "&username=" + state.username + "&orderby=" + state.orderby;

				$('#all_container').data('cateogry', 2);
				$('#tab_sake').removeClass('nonda_set');
				$('#tab_sake').addClass('nomitai_set');
				$('#tab_sake .display_selection_button.selected').removeClass('selected');
				$('#tab_sake .display_selection_button:nth(1)').addClass('selected');
				$("body").trigger("search_nomitai", [ in_disp_from, state.to, data, false ] );
			}
		}
		else if(state.search_type == 2)
		{
			// var data = "search_type=" + state.search_type + "&from=" + state.from + "&to="  + state.to + "&username="  + state.username + "&count_query=1" + "&orderby=" + state.orderby;
			var data = state.data;
			$("body").trigger("search_sakagura", [ data, state.from, state.to ] );
		}
		else if(state.search_type == 3)
		{

			// var data = "search_type=" + state.search_type + "&from=" + state.from + "&to="  + state.to + "&username="  + state.username + "&count_query=1" + "&orderby=" + state.orderby;
			var data = state.data;
			$("body").trigger("search_user", [ data, state.from, state.to ] );
		}
	});

	///////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////

	$('#user_follow').click(function() {

		var loginname = <?php echo json_encode($_COOKIE['username']); ?>;
		var username = $('#all_container').data('username');
		var favoriteuser = $('#all_container').data('username');
		var data = "favoriteuser=" + favoriteuser;

		if(loginname == null|| loginname == "") {
			window.location.href = "user_login_form.php";
			return;
		}

		$.ajax({
			type: "post",
			url: "user_follow.php",
			data: data,
		}).done(function(xml){

			var str = $(xml).find("str").text();

			if(str == "followed")
			{
				$("#user_follow").css('background', 'linear-gradient(#EDCACA, #ffffff)');
				$("#user_follow").css('border', '1px solid #FF4545');
				$(".user_buttons_pin1616").css('fill', '#FF4545');
				$("#user_follow span").text('フォロー中');
			}
			else if(str == "unfollowed")
			{
				$("#user_follow").css('background', 'linear-gradient(#e6e6e6, #ffffff)');
				$("#user_follow").css('border', '1px solid #d2d2d2');
				$("#user_follow").css('color', '#666666');
				$(".user_buttons_pin1616").css('fill', '#b2b2b2');
				$("#user_follow span").text('フォロー');
			}
		}).fail(function(data){
			alert("This is Error");
		});
	});

	///////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	var hash = window.location.hash;

	if(hash && hash != "")
	{
		var curr = $('#tab_main .simpleTabs').find(".active");
		var prev = $('#tab_main .simpleTabs').find('a[href="' + hash +'"]');
		var disp_max = 25;

		curr.removeClass('active');
		prev.addClass('active');

		$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
		$(hash).removeClass('hide').addClass('show').show();

		var disp_max = 25;
		var in_disp_from = $('#all_container').data('from') ? $('#all_container').data('from') : 0;
		var in_disp_to = in_disp_from + disp_max;
		var count_query = 1;

		if(hash == "#tab_sake")
		{
			if($('#all_container').data('category') == 2) {

				var search_type = 1;
				var category = 1;
				var username = $('#all_container').data('username');
				var orderby = $('#order_sake').val();
				var data = "search_type=" + search_type + "&category" + category + "&from=" + in_disp_from + "&disp_max=" + disp_max + "&username=" + username;

				if(count_query)
					data += "&count_query=" + count_query;

				if($("#order_sakagura").val())
					data += "&orderby=" + $("#order_sake").val();

				$('#tab_sake').removeClass('nonda_set');
				$('#tab_sake').addClass('nomitai_set');
				$('#tab_sake .display_selection_button.selected').removeClass('selected');
				$('#tab_sake .display_selection div:nth(1)').addClass('selected');

				//alert("data:" + data)
				$("body").trigger("search_nomitai", [ in_disp_from, in_disp_to, data, true ] );
			}
			else {

				var category = 2;
				var data = "category" + category + "&username=" + $('#all_container').data('username') + "&from=" + in_disp_from + "&to=" + in_disp_to;

				if(count_query)
					data += "&count_query=" + count_query;

				if($("#order_sake").val())
					data += "&orderby=" + $("#order_sake").val();

				$('#tab_sake').removeClass('nomitai_set');
				$('#tab_sake').addClass('nonda_set');

				$('#tab_sake .display_selection_button.selected').removeClass('selected');
				$('#tab_sake .display_selection div:first-child').addClass('selected');

				$("body").trigger("search_nonda", [ in_disp_from, disp_max, data, true ] );
			}
		}
		else if(hash == "#tab_sakagura")
		{
			var search_type = 2;
			var data = "search_type=" + search_type +
						"&from=" + in_disp_from +
						"&to=" + in_disp_to +
						"&username=" + $('#all_container').data('username') +
						"&count_query=1" +
						"&orderby=" + $('#order_sakagura').val();

			//alert("sakagura:" + in_disp_from);

			$("body").trigger("search_sakagura", [ data, in_disp_from, in_disp_to ] );
		}
		else if(hash == "#tab_users")
		{
			var search_type = 3;
			var category = $('#all_container').data('category');
			//alert("category:" + category);
			var data = "search_type=" + search_type +
						"&category=" + category +
						"&from=" + in_disp_from +
						"&to=" + in_disp_to +
						"&username=" + $('#all_container').data('username') +
						"&count_query=1" +
						"&orderby=" + $('#order_sakagura').val();

			//alert("data:" + data);
			$('#tab_users .display_selection_button.selected').removeClass('selected');
			$('#tab_users .display_selection div:nth(' + (category - 1) + ')').addClass('selected');

			$("body").trigger("search_users", [ data, category, in_disp_from, in_disp_to ] );
		}
	}
	else
	{
		//var stateObj = { url: "#top" };
		var href = $('.simpleTabs li a:nth(0)').attr('href');
		var username =  <?php echo json_encode($url_username); ?>;

		var orderby = $('#order_sake').val();

		var stateObj = { 'href': href,
						 'username': username,
						 'orderby': orderby,
						 'from': 0,
						 'to': 25 };

		history.replaceState(stateObj, "user", "");
		$('#tab_sake .display_selection div:first-child').trigger('click');
	}
});

</script>
</html>
