<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("manage_edit_sake.php");
require_once("manage_edit_sakagura.php");
require_once("manage_edit_user.php");

function displaySake()
{
	print('<div class="review_count_container">');
		print('<span class="disp_sake">'. ($in_disp_from + 1) .' ～ 25/全' .$count_result .'件</span>');
	print('</div>');
}

function displaySakagura()
{
	print('<div class="manage_sakagura_search_container">');
			print('<div class="input_item">');
				print('<input class="sakagura_input" class="all_mode" autocomplete="off" placeholder="酒蔵を検索" type="text" name="sakagura_name">');
			print('</div>');

			print('<ul class="sakagura_content"></ul>');
			print('<div class="sakagura_table"></div>');

			print('<div class="review_count_container">');
				print('<span class="disp_sakagura">'. ($in_disp_from + 1) .' ～ 25/全' .$count_result .'件</span>');
			print('</div>');

			print('<div class="review_result_sakagura_page"></div>');
	print('</div>');
}

function displayUsers()
{
	print('<div id="manage_users_search_container">');
			print('<div class="input_item">');
				print('<input class="user_input" class="all_mode" autocomplete="off" placeholder="ユーザーを検索" type="text" name="user_name">');
			print('</div>');

			print('<ul class="user_content"></ul>');
			print('<div id="user_table" style="display:none"></div>');

			print('<div class="review_count_container">');
				print('<span class="disp_users">'. ($in_disp_from + 1) .' ～ 25/全' .$count_result .'件</span>');
			print('</div>');

			print('<div class="review_result_users_page"></div>');
	print('</div>');
}

function displayUserInfo()
{
	print('<div class="registoryUserInfo">');
					print('<div class="row_container">');

						print('<div class="row_title_container">');
							print('<div class="row_title_sign"></div>');
							print('<div class="row_title">日本酒の名称<span>必須</span></div>');
						print('</div>');

						print('<div class="row">');
							print('<div class="column1_container">');
								print('<div class="column1">その他の日本酒名 ※上記以外の旧字体・異字体(例:桜/櫻など)を含む日本酒名も登録したい場合は以下に入力してください</div>');
								print('<span>全角かな/半角英数字</span>');
							print('</div>');
							print('<div class="column2"><label><input id="sake_search" type="text" name="sake_search"></label></div>');
						print('</div>');

					print('</div>');
	print('</div>');
}

function writePageNumberContainer($count_result)
{
		///////////////////////////////////////////////////////////////////////////////////
		$i = 1;
		$p_max = 25;
		$numPage = (($count_result / $p_max) < 5) ? ($count_result / $p_max) : 5;

		print('<div class="page_number_container" data-in_disp_from = 0 data-in_disp_to = 25 data-in_disp_max = 25 data-write_date_from = "" data-write_date_to = "" data-count = ' .$count_result .'>');
			print('<button class="prev_page">前の' .$p_max .'件</button>');
			print('<button class="pageitems selected">' .$i .'</button>');

			for($i++; $i <= $numPage; $i++)
			{
				 print('<button class="pageitems">' .$i .'</button>');
			}

			print('<button class="next_page" class="active">次の' .$p_max .'件</button>');
			print('<span class="image_progress" style="display:none"><img src="images/icons/gif-load.gif"></span>');

		print('</div>');
		///////////////////////////////////////////////////////////////////////////////////
}

?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
</head>

<title>管理画面 [管理者]</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/sakenomuui.js"></script>
<script src="js/manage_edit_sake.js"></script>
<script src="js/manage_edit_sakagura.js"></script>

<link rel="stylesheet" type="text/css" href="css/manage_user_view.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/manage_edit_sake.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/manage_edit_sakagura.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/manage_edit_user.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />

<body>

	<?php

	include_once('images/icons/svg_sprite.svg');
    $username = $_COOKIE['login_cookie'];

	$in_disp_from = 0;

	///////////////////////////////////////
	///////////////////////////////////////

	if(!$db = opendatabase("sake.db"))
	{
		die("データベース接続エラー .<br />");
	}

	$sql = "SELECT * FROM USERS_J WHERE username = '$username' OR email = '$username'";
	$res = executequery($db, $sql);
	$row = getnextrow($res);

	print('<div id="all_container">');

		print('<div id="main_banner_container">');

			print('<div id="banner">');
				print('<div class="logo_box"><svg class="logoheartgray14024"><use xlink:href="#logoheartgray14024"/></div>');

				print('<ul id="user_menu" class="managemenu">');
					print('<li id="sake_info">日本酒ページ</li>');
					print('<li><a href="#sake_edit" class="active"><div>日本酒情報</div></a></li>');
					print('<li><a href="#sake_nonda"><div>飲んだ</div></a></li>');
					print('<li><a href="#sake_nomitai"><div>飲みたい</div></a></li>');
					print('<li><a href="#sake_iine"><div>いいね</div></a></li>');
					print('<li><a href="#sake_comment"><div>返信コメント</div></a></li>');

					print('<li id="sakagura_info">酒蔵ページ</li>');
					print('<li><a href="#sakagura_edit"><div>酒蔵情報</div></a></li>');
					print('<li><a href="#sakagura_photo"><div>コメント・写真</div></a></li>');
					print('<li><a href="#sakagura_favorite"><div>お気に入り酒蔵</div></a></li>');
					print('<li><a href="#sakagura_iine"><div>いいね</div></a></li>');
					print('<li><a href="#sakagura_comment"><div>返信コメント</div></a></li>');

					print('<li id="user_info">マイページ・その他</li>');
					print('<li><a href="#user_account"><div>アカウント</div></a></li>');
					print('<li><a href="#user_profile"><div>プロフィール</div></a></li>');
					print('<li><a href="#user_follow"><div>フォロー</div></a></li>');
					print('<li><a href="#user_message"><div>メッセージ</div></a></li>');
				print("</ul>");
			print('</div>');

			////////////////////////////////////////////////////////////////////////////////

			print('<div id="container_wrapper">');

				print('<div id="table_wrapper">');

					if($row)
					{
						print('<div id="tab_main" class="tab_container">');
							print('<ul class="simpleTabs">');
								print('<li><a href="#tab_admin" class="active"><span>管理者</span></a></li>');
								print('<li><a href="#tab_users"><span>一般ユーザー</span></a></li>');
								print('<li><a href="#tab_sakagura"><span>酒蔵</span></a></li>');
							print("</ul>");

							//////////////////////////////////////////////////////////////////////
							// 日本酒ページ > 日本酒情報
							print('<div id="sake_edit" class="form-action show">');
								print('<div id="sake_edit_list">');

									print('<div class="menu_title">日本酒情報</div>');

									print('<div class="list_selection_container">');
										print('<ul class="list_content">');
											print('<li id="all_sake_list"><a class="active" href="#">すべて</a></li>');
											print('<li id="new_sake_list"><a href="#"><span>新規登録</span><span>一覧</span></a></li>');
											print('<li id="edit_sake_list"><a href="#"><span>編集</span><span>一覧</span></a></li>');
											print('<li id="hide_sake_list"><a href="#"><span>非表示</span><span>一覧</span></a></li>');
										print('</ul>');
									print('</div>');

									///////////////////////////////////////////////////////////////////////////////////
									print('<div class="sort_container">');
										print('<svg class="sort_search2020"><use xlink:href="#search2020"/></svg>');

										print('<label class="sort_content"><SELECT name="">');
											print('<OPTION VALUE="">年</OPTION>');
											print('<OPTION VALUE="2018">2018</OPTION>');
											print('<OPTION VALUE="2017">2017</OPTION>');
											print('<OPTION VALUE="2016">2016</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">月</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">日</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
											print('<OPTION VALUE="13">13</OPTION>');
											print('<OPTION VALUE="14">14</OPTION>');
											print('<OPTION VALUE="15">15</OPTION>');
											print('<OPTION VALUE="16">16</OPTION>');
											print('<OPTION VALUE="17">17</OPTION>');
											print('<OPTION VALUE="18">18</OPTION>');
											print('<OPTION VALUE="19">19</OPTION>');
											print('<OPTION VALUE="20">20</OPTION>');
											print('<OPTION VALUE="21">21</OPTION>');
											print('<OPTION VALUE="22">22</OPTION>');
											print('<OPTION VALUE="23">23</OPTION>');
											print('<OPTION VALUE="24">24</OPTION>');
											print('<OPTION VALUE="25">25</OPTION>');
											print('<OPTION VALUE="26">26</OPTION>');
											print('<OPTION VALUE="27">27</OPTION>');
											print('<OPTION VALUE="28">28</OPTION>');
											print('<OPTION VALUE="29">29</OPTION>');
											print('<OPTION VALUE="30">30</OPTION>');
											print('<OPTION VALUE="31">31</OPTION>');
										print('</SELECT></label>');
									print('</div>');

									/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

									$sql = "SELECT COUNT(*) FROM SAKE_J, SAKAGURA_J WHERE SAKE_J.sakagura_id = SAKAGURA_J.id";
									$res = executequery($db, $sql);
									$row = getnextrow($res);
									$count_result = $row["COUNT(*)"];

									$in_disp_from = 0;
									$in_disp_to = ($count_result < 25) ? $count_result : 25;

									print('<div class="count_result">' .($in_disp_from + 1) .'～' .$in_disp_to .'/全'.$count_result.'件</div>');

									writePageNumberContainer($count_result);

								    $path = "images/icons/noimage_user30.svg";
									//$sql = "SELECT SAKE_J.sake_id as sake_id, sake_name, sakagura_name, pref, filename FROM SAKE_J, SAKAGURA_J, SAKE_IMAGE WHERE SAKE_J.sakagura_id = SAKAGURA_J.id AND SAKE_J.sake_id = SAKE_IMAGE.sake_id ORDER BY RANDOM() LIMIT 8";
									$sql = "SELECT SAKE_J.sake_id as sake_id, sake_name, sakagura_name, pref, SAKE_J.write_date as write_date FROM SAKE_J, SAKAGURA_J WHERE SAKE_J.sakagura_id = SAKAGURA_J.id LIMIT 25";
									$res = executequery($db, $sql);
									$username = $_COOKIE['login_cookie'];

									///////////////////////////////////////////////////////
									$contributor = $row["contributor"];
									$user_result = executequery($db, "SELECT * FROM USERS_J WHERE username = '$contributor'");
									$user_record = getnextrow($user_result);

									if($user_record)
										$path = "images/profile/" .$user_record["imagefile"];
									///////////////////////////////////////////////////////

									print('<div class="review_result_sake_page">');

									while($row = getnextrow($res))
									{
										print('<div class="sake_registry_container" data-sake_id=' .$row["sake_id"] .' data-sake_name=' .$row["sake_name"] .'>');
											print('<div class="user_info_container">');
												print('<div class="user_image_container">');
													print('<img src="' .$path .'">');
												print('</div>');

												print('<div class="user_registration_container">');
													print('<div class="user_name">'. $username .'</div>');
													print('<div class="user_profile_date_container">');
														print('<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
														print('<div class="user_date">' .gmdate("Y/m/d", $row["write_date"] + 9 * 3600) .'</div>');
													print('</div>');
												print('</div>');
											print('</div>'); // user_info_container

											print('<div class="sake_info_container">');
												print('<div class="sake_name">' .$row["sake_name"]. '</div>');
												print('<div class="brewery_prefecture_name">' .$row["sakagura_name"] . '/' .$row["pref"] .'</div>');
											print('</div>');
										print('</div>'); // sake_resigtry container
									}

									print('</div>');

								/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
								/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

								print("</div>");

								print('<div id="sake_edit_detail">');

									print('<div class="menu_title">日本酒情報</div>');
									print('<div id="sake_edit_prev2020"><svg class="return_button"><use xlink:href="#prev2020"/></svg>一覧へ戻る</div>');
									writeSakeContainer("", "");
								print("</div>");
							print("</div>");

							//////////////////////////////////////////////////////////////////////
							// 日本酒ページ > 飲んだ
							print('<div id="sake_nonda" class="form-action hide">');
								print('<div id="sake_nonda_list">');
									print('<div class="menu_title">飲んだ</div>');

									print('<div class="list_selection_container">');
										print('<ul class="list_content">');
											print('<li id="all_nonda_list"><a class="active" href="#">すべて</a></li>');
											print('<li id="new_nonda_list"><a href="#"><span>新規登録</span><span>一覧</span></a></li>');
											print('<li id="edit_nonda_list"><a href="#"><span>編集</span><span>一覧</span></a></li>');
											print('<li id="hide_nonda_list"><a href="#"><span>非表示</span><span>一覧</span></a></li>');
										print('</ul>');
									print('</div>');

									print('<div class="sort_container">');
										print('<svg class="sort_search2020"><use xlink:href="#search2020"/></svg>');

										print('<label class="sort_content"><SELECT name="">');
											print('<OPTION VALUE="">年</OPTION>');
											print('<OPTION VALUE="2018">2018</OPTION>');
											print('<OPTION VALUE="2017">2017</OPTION>');
											print('<OPTION VALUE="2016">2016</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">月</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">日</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
											print('<OPTION VALUE="13">13</OPTION>');
											print('<OPTION VALUE="14">14</OPTION>');
											print('<OPTION VALUE="15">15</OPTION>');
											print('<OPTION VALUE="16">16</OPTION>');
											print('<OPTION VALUE="17">17</OPTION>');
											print('<OPTION VALUE="18">18</OPTION>');
											print('<OPTION VALUE="19">19</OPTION>');
											print('<OPTION VALUE="20">20</OPTION>');
											print('<OPTION VALUE="21">21</OPTION>');
											print('<OPTION VALUE="22">22</OPTION>');
											print('<OPTION VALUE="23">23</OPTION>');
											print('<OPTION VALUE="24">24</OPTION>');
											print('<OPTION VALUE="25">25</OPTION>');
											print('<OPTION VALUE="26">26</OPTION>');
											print('<OPTION VALUE="27">27</OPTION>');
											print('<OPTION VALUE="28">28</OPTION>');
											print('<OPTION VALUE="29">29</OPTION>');
											print('<OPTION VALUE="30">30</OPTION>');
											print('<OPTION VALUE="31">31</OPTION>');
										print('</SELECT></label>');
									print('</div>');

									$condition = "WHERE SAKE_J.sakagura_id = SAKAGURA_J.id AND SAKE_J.sake_id = TABLE_NONDA.sake_id";
									$sql = "SELECT COUNT(*) FROM SAKE_J, SAKAGURA_J, TABLE_NONDA " .$condition ." LIMIT 25";

									$res = executequery($db, $sql);
									$row = getnextrow($res);
									$count_result = $row["COUNT(*)"];
									$in_disp_from = 0;
									$disp_max = 25;

									$in_disp_to = ($count_result < $disp_max) ? $count_result : $disp_max;

									print('<div class="count_result">' .($in_disp_from + 1) .'～' .$in_disp_to .'/全'.$count_result.'件</div>');

									///////////////////////////////////////////////////////////////////////////////////
									writePageNumberContainer($count_result);
									///////////////////////////////////////////////////////////////////////////////////

									$sql = "SELECT TABLE_NONDA.sake_id AS sake_id, TABLE_NONDA.rank AS rank, TABLE_NONDA.write_date AS write_date, TABLE_NONDA.update_date AS update_date, TABLE_NONDA.contributor AS contributor, sake_name, sake_read, sakagura_name, pref, sake_rank, subject, message, tastes, committed FROM SAKE_J, SAKAGURA_J, TABLE_NONDA " .$condition  ." ORDER BY update_date DESC LIMIT 25";;
									$res = executequery($db, $sql);

									print('<div class="review_result_sake_page">');

									while($row = getnextrow($res)) {

											$local_time = gmdate("Y/m/d H:i:s", $row["write_date"] + 9 * 3600);
											$sake_id = $row["sake_id"];
											$username = $row["contributor"];
											$added_paths = "";

											$sql_image = "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$username'";
											$image_result = executequery($db, $sql_image);

											while($image_record = getnextrow($image_result)) {

												if($added_paths == "")
													$added_paths = $image_record["filename"];
												else
													$added_paths .= ", " .$image_record["filename"];
											}

											//////////////////////////////////////////////////////////////////////////////
											print('<div class="sake_nonda_container" data-sake_id=' .$sake_id
																					.' data-sake_name="' .$row["sake_name"]
																					.'" data-sake_read="' .$row["sake_read"]
																					.'" data-sakagura_name="' .$row["sakagura_name"]
																					.'" data-pref=' .$row["pref"]
																					.' data-update_date=' .$row["update_date"]
																					.' data-write_date=' .$row["write_date"]
																					.' data-contributor="' .$row["contributor"]
																					.'" data-subject="' .$row["subject"]
																					.'" data-rank=' .$row["rank"]
																					.' data-message="' .$row["message"]
																					.'" data-tastes="' .$row["tastes"]
																					.'" data-committed=' .$row["committed"]
																					.' data-flavor="' .$row["flavor"]
																					.'" data-path="' .$added_paths
																					.'">');

												print('<div class="user_info_container">');
													print('<div class="user_image_container">');
														print('<img src="' .$path .'">');
													print('</div>');

													print('<div class="user_registration_container">');
														print('<div class="user_name">' .$row["contributor"] .'</div>');
														print('<div class="user_profile_date_container">');
															print('<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
															print('<div class="user_date">' .$local_time .'</div>');
														print('</div>');
													print('</div>');
												print('</div>');

												print('<div class="sake_info_container">');
													print('<div class="sake_name">' .$row["sake_name"] .'</div>');
													print('<div class="brewery_prefecture_name">' .$row["sakagura_name"] .' / ' .$row["pref"] .'</div>');
												print('</div>');
											print('</div>');
									}

									print('</div>');

									//////////////////////////////////////////////////////////////////////////////

								print("</div>");

								print('<div id="sake_nonda_detail">');
									print('<div class="menu_title">飲んだ</div>');
									print('<div id="sake_nonda_prev2020"><svg class="return_button"><use xlink:href="#prev2020"/></svg>一覧へ戻る</div>');

									//飲んだ詳細
									print('<div id="user_sake_review">');

										print('<div class="user_sake_container">');
											//ユーザー
											print('<div class="user_info_container">');
												print('<div class="user_image_container">');
													print('<img src="' .$path .'">');
												print('</div>');

												print('<div class="user_registration_container">');
													print('<div class="user_name">ここにユーザー名が入ります</div>');
													print('<div class="user_profile_date_container">');
														print('<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
														print('<div class="user_date">' .gmdate("Y/m/d", $record["update_date"] + 9 * 3600) .'</div>');
													print('</div>');
												print('</div>');
											print('</div>');

									    //酒
											print('<div class="sake_info_container">');
												print('<div class="sake_name">ここに日本酒名が入ります</div>');
												print('<div class="brewery_prefecture_name">酒蔵名が入る / 都道府県名</div>');
											print('</div>');

									    //タブ
									    print('<div class="user_sake_tab_container">');
									      print('<div class="user_sake_tab_link"><svg class="user_sake_review3630 user_sake_icon"><use xlink:href="#review3630"/></svg></div>');
									      print('<div class="user_sake_border_line"></div>');
									      print('<div class="user_sake_tab_link"><svg class="user_sake_note3630 user_sake_icon"><use xlink:href="#note3630"/></svg></div>');
									      print('<div class="user_sake_border_line"></div>');
									    print('</div>');

									    print('<div class="user_sake_tab_body">');

									      print('<!--レビュータブ-->');
									      print('<div class="user_sake_tab_panel">');

									        print('<!--レーティング-->');
									        print('<div class="user_sake_rank">');
									          print('<div class="user_sake_star_rating">');
									            print('<div class="user_sake_star_rating_front" style="width: 75%">★★★★★</div>');
									            print('<div class="user_sake_star_rating_back">★★★★★</div>');
									          print('</div>');
									          print('<span class="user_sake_sake_rate">no code</span>');
									        print('</div>');

									        print('<!--レビューテキスト-->');
									        print('<div class="user_sake_subject_message_container">');
									          print('<div class="user_sake_subject">ここにレビュータイトルが表示されますここにレビュータイトルが表示されます</div>');
									          print('<div class="user_sake_message">ここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されますここにレビュー本文が表示されます</div>');
									        print('</div>');

									        print('<!--写真-->');
									        print('<div class="user_sake_image_container">');
														$path = "images/icons/noimage160.svg";
									          print('<div class="user_sake_image"><img src="' .$path .'"></div>');
									        print('</div>');

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
										                print('<div id="user_sake_flavor_content">');
										                  print('<div class="user_sake_flavor">');
										                    print('<span>1</span>');
										                  print('</div>');
										                  print('<div class="user_sake_flavor_caption">');
										                    print('<span>バター・クリーム・バニラ・チーズ</span>');
										                  print('</div>');
										                  print('<div class="user_sake_flavor_ratio">');
										                    print('<!--<span></span>-->');
										                  print('</div>');
										                print('</div>');

										                print('<div id="user_sake_flavor_content">');
										                  print('<div class="user_sake_flavor">');
										                    print('<span>2</span>');
										                  print('</div>');
										                  print('<div class="user_sake_flavor_caption">');
										                    print('<span>入力されていません</span>');
										                  print('</div>');
										                  print('<div class="user_sake_flavor_ratio">');
										                    print('<!--<span></span>-->');
										                  print('</div>');
										                print('</div>');

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
										                print('<div id="user_sake_flavor_content">');
										                  print('<div class="user_sake_flavor">');
										                    print('<span>1</span>');
										                  print('</div>');
										                  print('<div class="user_sake_flavor_caption">');
										                    print('<span>バター・クリーム・バニラ・チーズ</span>');
										                  print('</div>');
										                  print('<div class="user_sake_flavor_ratio">');
										                    print('<span>68%</span>');
										                  print('</div>');
										                print('</div>');

										                print('<div id="user_sake_flavor_content">');
										                  print('<div class="user_sake_flavor">');
										                    print('<span>2</span>');
										                  print('</div>');
										                  print('<div class="user_sake_flavor_caption">');
										                    print('<span>桃</span>');
										                  print('</div>');
										                  print('<div class="user_sake_flavor_ratio">');
										                    print('<span>17%</span>');
										                  print('</div>');
										                print('</div>');

										              print('</div>');
										            print('</div>');

										            print('<!--香り-->');
										            print('<div class="user_sake_tasting_box">');
										              print('<div class="user_sake_tasting_title_container">');
										                print('<div class="user_sake_tasting_title"><span class="user_sake_icon_adjust"><svg class="user_sake_aroma2430"><use xlink:href="#aroma2430"/></svg></span>香り</div>');
										              print('</div>');

										              print('<div class="user_sake_tasting_bar_container">');
										                print('<div class="tastingnote_input_range_container">');
										                  print('<input type="range" name="aroma" step="0.1" min="0" max="5" value="' .$taste1_all .'" disabled="disabled" class="everyone_input_range">');
										                print('</div>');
										                print('<div class="user_sake_tasting_caption">');
										                  print('<span>弱い</span>');
										                  print('<span>強い</span>');
										                print('</div>');
										              print('</div>');

										              print('<div class="user_sake_tasting_score">');
																		if ($taste1_all != 0) {
																			print('<span>' .$taste1_all .'</span>');
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
										                  print('<input type="range" name="body" step="0.1" min="0" max="5" value="' .$taste2_all .'" disabled="disabled" class="everyone_input_range">');
										                print('</div>');
										                print('<div class="user_sake_tasting_caption">');
										                  print('<span>味が軽い・淡麗</span>');
										                  print('<span>味が重い・濃醇</span>');
										                print('</div>');
										              print('</div>');

										              print('<div class="user_sake_tasting_score">');
																		if ($taste2_all != 0) {
																			print('<span>' .$taste2_all .'</span>');
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
										                  print('<input type="range" name="clear" step="0.1" min="0" max="5" value="' .$taste3_all .'" disabled="disabled" class="everyone_input_range">');
										                print('</div>');
										                print('<div class="user_sake_tasting_caption">');
										                  print('<span>雑味がある</span>');
										                  print('<span>味がきれい</span>');
										                print('</div>');
										              print('</div>');

										              print('<div class="user_sake_tasting_score">');
																		if ($taste3_all != 0) {
																			print('<span>' .$taste3_all .'</span>');
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
										                  print('<input type="range" name="sweetness" step="0.1" min="0" max="5" value="' .$taste4_all .'" disabled="disabled" class="everyone_input_range">');
										                print('</div>');
										                print('<div class="user_sake_tasting_caption">');
										                  print('<span>ドライ・辛口</span>');
										                  print('<span>スイート・甘口</span>');
										                print('</div>');
										              print('</div>');

										              print('<div class="user_sake_tasting_score">');
																		if ($taste4_all != 0) {
																			print('<span>' .$taste4_all .'</span>');
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
										                  print('<input type="range" name="umami" step="0.1" min="0" max="5" value="' .$taste5_all .'" disabled="disabled" class="everyone_input_range">');
										                print('</div>');
										                print('<div class="user_sake_tasting_caption">');
										                  print('<span>弱い</span>');
										                  print('<span>強い</span>');
										                print('</div>');
										              print('</div>');

										              print('<div class="user_sake_tasting_score">');
																		if ($taste5_all != 0) {
																			print('<span>' .$taste5_all .'</span>');
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
										                  print('<input type="range" name="acidity" step="0.1" min="0" max="5" value="' .$taste6_all .'" disabled="disabled" class="everyone_input_range">');
										                print('</div>');
										                print('<div class="user_sake_tasting_caption">');
										                  print('<span>弱い</span>');
										                  print('<span>強い</span>');
										                print('</div>');
										              print('</div>');

										              print('<div class="user_sake_tasting_score">');
																		if ($taste6_all != 0) {
																			print('<span>' .$taste6_all .'</span>');
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
										                  print('<input type="range" name="bitter" step="0.1" min="0" max="5" value="' .$taste7_all .'" disabled="disabled" class="everyone_input_range">');
										                print('</div>');
										                print('<div class="user_sake_tasting_caption">');
										                  print('<span>弱い</span>');
										                  print('<span>強い</span>');
										                print('</div>');
										              print('</div>');

										              print('<div class="user_sake_tasting_score">');
																		if ($taste7_all != 0) {
																			print('<span>' .$taste7_all .'</span>');
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
										                  print('<input type="range" name="yoin" step="0.1" min="0" max="5" value="' .$taste8_all .'" disabled="disabled" class="everyone_input_range">');
										                print('</div>');
										                print('<div class="user_sake_tasting_caption">');
										                  print('<span>長く続く</span>');
										                  print('<span>キレが良い</span>');
										                print('</div>');
										              print('</div>');

										              print('<div class="user_sake_tasting_score">');
																		if ($taste8_all != 0) {
																			print('<span>' .$taste8_all .'</span>');
																		} else {
																			print('<span style="color: #b2b2b2;">--</span>');
																		}
																	print('</div>');
										            print('</div>');

										          print('</div><!--user_sake_graph_all-->');

										        print('</div><!--user_sake_chart-->');

												print('</div>');
									      print('</div><!--user_sake_tab_panel-->');
									    print('</div><!--user_sake_tab_body-->');

									    print('<!--いいね-->');
									    print('<div class="user_sake_like_container">');
									      print('<a class="user_sake_like">');
									        print('<svg class="user_sake_like_icon"><use xlink:href="#like1616"/></svg>');
									        print('<div class="user_sake_like_title">いいね!</div>');
									      print('</a>');
									      print('<div class="user_sake_like_count">123</div>');
									    print('</div>');

									  print('</div>');

									print('</div>');

								print("</div>");
							print("</div>");

							//////////////////////////////////////////////////////////////////////
							// 日本酒ページ > 飲みたい
							print('<div id="sake_nomitai" class="form-action hide">');
								print('<div id="sake_nomitai_list">');
									print('<div class="menu_title">飲みたい</div>');

									print('<div class="sort_container">');
										print('<svg class="sort_search2020"><use xlink:href="#search2020"/></svg>');

										print('<label class="sort_content"><SELECT name="">');
											print('<OPTION VALUE="">年</OPTION>');
											print('<OPTION VALUE="2018">2018</OPTION>');
											print('<OPTION VALUE="2017">2017</OPTION>');
											print('<OPTION VALUE="2016">2016</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">月</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">日</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
											print('<OPTION VALUE="13">13</OPTION>');
											print('<OPTION VALUE="14">14</OPTION>');
											print('<OPTION VALUE="15">15</OPTION>');
											print('<OPTION VALUE="16">16</OPTION>');
											print('<OPTION VALUE="17">17</OPTION>');
											print('<OPTION VALUE="18">18</OPTION>');
											print('<OPTION VALUE="19">19</OPTION>');
											print('<OPTION VALUE="20">20</OPTION>');
											print('<OPTION VALUE="21">21</OPTION>');
											print('<OPTION VALUE="22">22</OPTION>');
											print('<OPTION VALUE="23">23</OPTION>');
											print('<OPTION VALUE="24">24</OPTION>');
											print('<OPTION VALUE="25">25</OPTION>');
											print('<OPTION VALUE="26">26</OPTION>');
											print('<OPTION VALUE="27">27</OPTION>');
											print('<OPTION VALUE="28">28</OPTION>');
											print('<OPTION VALUE="29">29</OPTION>');
											print('<OPTION VALUE="30">30</OPTION>');
											print('<OPTION VALUE="31">31</OPTION>');
										print('</SELECT></label>');
									print('</div>');

									///////////////////////////////////////////////////////////////////////////////////////////////////////////
									$disp_max = 25;
									$in_disp_from = 0;
									$in_disp_to = $in_disp_from + $disp_max;

									$condition = "WHERE FAVORITE_J.sake_id = SAKE_J.sake_id AND sakagura_id = id";
									$sql = "SELECT COUNT(*) FROM FAVORITE_J, SAKE_J, SAKAGURA_J " .$condition ." LIMIT ".$in_disp_from.", ".$disp_max;
									$res = executequery($db, $sql);
									$row = getnextrow($res);
									$count_result = $row["COUNT(*)"];

									$sql = "SELECT SAKE_J.sake_id, SAKE_J.sake_name, SAKE_J.sake_read, SAKE_J.special_name, SAKE_J.alcohol_level, SAKE_J.rice_used, SAKE_J.seimai_rate, SAKE_J.jsake_level, SAKE_J.oxidation_level, SAKE_J.amino_level, SAKE_J.koubo_used, SAKE_J.sake_rank, SAKE_J.write_date, SAKAGURA_J.sakagura_name, SAKAGURA_J.sakagura_name, SAKAGURA_J.id, SAKAGURA_J.pref, SAKAGURA_J.address, FAVORITE_J.username FROM FAVORITE_J, SAKE_J, SAKAGURA_J " .$condition ." LIMIT ".$in_disp_from.", ".$disp_max;
									$res = executequery($db, $sql);

									print('<div class="count_result">' .($in_disp_from + 1) .'～' .$in_disp_to .'/全'.$count_result.'件</div>');
									writePageNumberContainer($count_result);
									///////////////////////////////////////////////////////////////////////////////////

									if(!$res)
									{
											header('Content-Type: application/json');
											$result_set[] = array('count' => $count_result, 'result' => null);
											echo json_encode($result_set);
									}
									else
									{
											print('<div class="review_result_sake_page">');

											while($row = getnextrow($res))
											{
													$sakd_id = $row[sake_id];
													$intime = gmdate("Y/m/d H:i:s", $row["write_date"] + 9 * 3600);
													$path = "images/icons/noimage160.svg";

													$sql = "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sakd_id' LIMIT 2";
													$res_image = executequery($db, $sql);

													if($record = getnextrow($res_image))
													{
														$path = "images\\photo\\thumb\\".$record["filename"];
													}

													print('<div class="sake_nomitai_container" data-sake_id=' .$row["sake_id"] .' data-sake_name=' .$row["sake_name"] .'>');

														print('<div class="user_info_container">');
															print('<div class="user_image_container">');
																print('<img src="' .$path .'">');
															print('</div>');

															print('<div class="user_registration_container">');
																print('<div class="user_name">' .$row["username"] .'</div>');
																print('<div class="user_profile_date_container">');
																	print('<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
																	print('<div class="user_date">' .gmdate("Y/m/d", $row["write_date"] + 9 * 3600) .'</div>');
																print('</div>');
															print('</div>');
														print('</div>');

														print('<div class="sake_info_container">');
															print('<div class="sake_name">' .$row["sake_name"] .'</div>');
															print('<div class="brewery_prefecture_name">' .$row["sakagura_name"] .' / ' .$row["pref"] .'</div>');
														print('</div>');
													print('</div>');

											}

											print('</div>');
									}
									///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

									/*********************************************************
									print('<div class="sake_nomitai_container">');
										print('<div class="user_info_container">');
											print('<div class="user_image_container">');
												print('<img src="' .$path .'">');
											print('</div>');

											print('<div class="user_registration_container">');
												print('<div class="user_name">ここにユーザー名が入ります</div>');
												print('<div class="user_profile_date_container">');
													print('<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
													print('<div class="user_date">' .gmdate("Y/m/d", $record["write_date"] + 9 * 3600) .'</div>');
												print('</div>');
											print('</div>');
										print('</div>');

										print('<div class="sake_info_container">');
											print('<div class="sake_name">ここに日本酒名が入ります1</div>');
											print('<div class="brewery_prefecture_name">酒蔵名が入る / 都道府県名</div>');
										print('</div>');
									print('</div>');
									**********************************************************/

								print("</div>");

								print('<div id="nomitai_edit_detail">');

									print('<div class="menu_title">日本酒情報</div>');
									print('<div id="nomitai_edit_prev2020"><svg class="return_button"><use xlink:href="#prev2020"/></svg>一覧へ戻る</div>');
									writeSakeContainer("", "");
								print("</div>");

							print("</div>");

							//////////////////////////////////////////////////////////////////////
							// 酒蔵ページ > 酒蔵情報
							print('<div id="sakagura_edit" class="form-action hide">');
								print('<div id="sakagura_edit_list">');
									print('<div class="menu_title">酒蔵情報</div>');

									print('<div class="list_selection_container">');
										print('<ul class="list_content">');
											print('<li id="all_sake_list"><a class="active" href="#">すべて</a></li>');
											print('<li id="new_sake_list"><a href="#"><span>新規登録</span><span>一覧</span></a></li>');
											print('<li id="edit_sake_list"><a href="#"><span>編集</span><span>一覧</span></a></li>');
											print('<li id="hide_sake_list"><a href="#"><span>非表示</span><span>一覧</span></a></li>');
										print('</ul>');
									print('</div>');

									print('<div class="sort_container">');
										print('<svg class="sort_search2020"><use xlink:href="#search2020"/></svg>');

										print('<label class="sort_content"><SELECT name="">');
											print('<OPTION VALUE="">年</OPTION>');
											print('<OPTION VALUE="2018">2018</OPTION>');
											print('<OPTION VALUE="2017">2017</OPTION>');
											print('<OPTION VALUE="2016">2016</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">月</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">日</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
											print('<OPTION VALUE="13">13</OPTION>');
											print('<OPTION VALUE="14">14</OPTION>');
											print('<OPTION VALUE="15">15</OPTION>');
											print('<OPTION VALUE="16">16</OPTION>');
											print('<OPTION VALUE="17">17</OPTION>');
											print('<OPTION VALUE="18">18</OPTION>');
											print('<OPTION VALUE="19">19</OPTION>');
											print('<OPTION VALUE="20">20</OPTION>');
											print('<OPTION VALUE="21">21</OPTION>');
											print('<OPTION VALUE="22">22</OPTION>');
											print('<OPTION VALUE="23">23</OPTION>');
											print('<OPTION VALUE="24">24</OPTION>');
											print('<OPTION VALUE="25">25</OPTION>');
											print('<OPTION VALUE="26">26</OPTION>');
											print('<OPTION VALUE="27">27</OPTION>');
											print('<OPTION VALUE="28">28</OPTION>');
											print('<OPTION VALUE="29">29</OPTION>');
											print('<OPTION VALUE="30">30</OPTION>');
											print('<OPTION VALUE="31">31</OPTION>');
										print('</SELECT></label>');
									print('</div>');

									//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//$res = executequery($db, "SELECT * FROM SAKAGURA_J ORDER BY RANDOM() LIMIT 12");

									$sql = "SELECT COUNT(*) FROM SAKAGURA_J";
									$res = executequery($db, $sql);
									$row = getnextrow($res);
									$count_result = $row["COUNT(*)"];

									$res = executequery($db, "SELECT * FROM SAKAGURA_J ORDER BY sakagura_read LIMIT 25");

									$in_disp_from = 0;
									$in_disp_to = ($count_result < 25) ? $count_result : 25;
									print('<div class="count_result">' .($in_disp_from + 1) .'～' .$in_disp_to .'/全'.$count_result.'件</div>');

									writePageNumberContainer($count_result);
									print('<div class="review_result_sake_page">');

									while($row = getnextrow($res))
									{
											print('<div class="brewery_registry_container" data-sakagura_id=' .$row["id"] .' data-sakagura_name=' .$row["sakagura_name"] .'>');
												print('<div class="user_info_container">');
													print('<div class="user_image_container">');
														print('<img src="' .$path .'">');
													print('</div>');

													print('<div class="user_registration_container">');
														print('<div class="user_name">' .$username .'</div>');
														print('<div class="user_profile_date_container">');
															print('<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
															print('<div class="user_date">' .gmdate("Y/m/d", $row["date_added"] + 9 * 3600) .'</div>');
														print('</div>');
													print('</div>');
												print('</div>');

												print('<div class="brewery_info_container">');
													print('<div class="brewery_name">' .$row["sakagura_name"] .'</div>');
													print('<div class="brewery_prefecture_name">' .$row["pref"] .'</div>');
												print('</div>');
											print('</div>');
									}

									/*
									print('<div class="brewery_registry_container">');
										print('<div class="user_info_container">');
											print('<div class="user_image_container">');
												print('<img src="' .$path .'">');
											print('</div>');

											print('<div class="user_registration_container">');
												print('<div class="user_name">ここにユーザー名が入ります</div>');
												print('<div class="user_profile_date_container">');
													print('<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
													print('<div class="user_date">' .gmdate("Y/m/d", $row["date_added"] + 9 * 3600) .'</div>');
												print('</div>');
											print('</div>');
										print('</div>');

										print('<div class="brewery_info_container">');
											print('<div class="brewery_name">ここに酒蔵名が入ります１</div>');
											print('<div class="brewery_prefecture_name">都道府県名</div>');
										print('</div>');
									print('</div>');
									*/

									print("</div>");

									//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

								print("</div>");

								print('<div id="sakagura_edit_detail">');

									print('<div class="menu_title">酒蔵情報</div>');
									print('<div id="sakagura_edit_prev2020"><svg class="return_button"><use xlink:href="#prev2020"/></svg>一覧へ戻る</div>');
									writeSakaguraContainer("", "");

								print("</div>");
							print("</div>");

							//////////////////////////////////////////////////////////////////////
							// 酒蔵ページ > お気に入り酒蔵
							print('<div id="sakagura_favorite" class="form-action hide">');
								print('<div id="sakagura_favorite_list">');
									print('<div class="menu_title">お気に入り酒蔵</div>');

									print('<div class="sort_container">');
										print('<svg class="sort_search2020"><use xlink:href="#search2020"/></svg>');

										print('<label class="sort_content"><SELECT name="">');
											print('<OPTION VALUE="">年</OPTION>');
											print('<OPTION VALUE="2018">2018</OPTION>');
											print('<OPTION VALUE="2017">2017</OPTION>');
											print('<OPTION VALUE="2016">2016</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">月</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">日</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
											print('<OPTION VALUE="13">13</OPTION>');
											print('<OPTION VALUE="14">14</OPTION>');
											print('<OPTION VALUE="15">15</OPTION>');
											print('<OPTION VALUE="16">16</OPTION>');
											print('<OPTION VALUE="17">17</OPTION>');
											print('<OPTION VALUE="18">18</OPTION>');
											print('<OPTION VALUE="19">19</OPTION>');
											print('<OPTION VALUE="20">20</OPTION>');
											print('<OPTION VALUE="21">21</OPTION>');
											print('<OPTION VALUE="22">22</OPTION>');
											print('<OPTION VALUE="23">23</OPTION>');
											print('<OPTION VALUE="24">24</OPTION>');
											print('<OPTION VALUE="25">25</OPTION>');
											print('<OPTION VALUE="26">26</OPTION>');
											print('<OPTION VALUE="27">27</OPTION>');
											print('<OPTION VALUE="28">28</OPTION>');
											print('<OPTION VALUE="29">29</OPTION>');
											print('<OPTION VALUE="30">30</OPTION>');
											print('<OPTION VALUE="31">31</OPTION>');
										print('</SELECT></label>');
									print('</div>');

									/**************
									 * 酒蔵
									 **************/
									$default_image = "images/icons/noimage160.svg";
									$in_disp_from = 0;
									$in_disp_to = 25;

									$sql = "SELECT COUNT(*) FROM FOLLOW_J, SAKAGURA_J WHERE sakagura_id = id ORDER BY sakagura_read LIMIT " .$in_disp_from .", " .$in_disp_to;
									$res = executequery($db, $sql);
									$row = getnextrow($res);
									$count_result = $row["COUNT(*)"];

									///////////////////////////////////////////////////////////////////////////////////
									$in_disp_to = ($count_result < 25) ? $count_result : 25;

									print('<div class="count_result">' .($in_disp_from + 1) .'～' .$in_disp_to .'/全'.$count_result.'件</div>');
									writePageNumberContainer($count_result);
									///////////////////////////////////////////////////////////////////////////////////

									print('<div class="review_result_sake_page">');

									$sql = "SELECT * FROM FOLLOW_J, SAKAGURA_J WHERE sakagura_id = id ORDER BY sakagura_read LIMIT " .$in_disp_from .", " .$in_disp_to;
									$res = executequery($db, $sql);

									while($row = getnextrow($res))
									{
											print('<div class="brewery_favorite_container">');
												print('<div class="user_info_container">');
													print('<div class="user_image_container">');
														print('<img src="' .$default_image .'">');
													print('</div>');

													print('<div class="user_registration_container">');
														print('<div class="user_name">' .$row["username"] .'</div>');
														print('<div class="user_profile_date_container">');
															print('<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
															print('<div class="user_date">' .gmdate("Y/m/d", $row["favorite_date"] + 9 * 3600) .'</div>');
														print('</div>');
													print('</div>');
												print('</div>');

												print('<div class="brewery_info_container">');
													print('<div class="brewery_name">' .$row["sakagura_name"] .'</div>');
													print('<div class="brewery_prefecture_name">' .$row["pref"] .'</div>');
												print('</div>');
											print('</div>');
									}

									/*
									print('<div class="brewery_favorite_container">');
										print('<div class="user_info_container">');
											print('<div class="user_image_container">');
												print('<img src="' .$path .'">');
											print('</div>');

											print('<div class="user_registration_container">');
												print('<div class="user_name">ここにユーザー名が入ります</div>');
												print('<div class="user_profile_date_container">');
													print('<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
													print('<div class="user_date">' .gmdate("Y/m/d", $record["write_date"] + 9 * 3600) .'</div>');
												print('</div>');
											print('</div>');
										print('</div>');

										print('<div class="brewery_info_container">');
											print('<div class="brewery_name">ここに酒蔵名が入ります２</div>');
											print('<div class="brewery_prefecture_name">都道府県名</div>');
										print('</div>');
									print('</div>');
									*/

								print('</div>');

								print('</div>');

								print('<div id="sakagura_favorite_detail">');

									print('<div class="menu_title">酒蔵情報</div>');
									print('<div id="sakagura_favorite_prev2020"><svg class="return_button"><use xlink:href="#prev2020"/></svg>一覧へ戻る</div>');
									writeSakaguraContainer("", "");

								print("</div>");

							print("</div>");

							//////////////////////////////////////////////////////////////////////
							// マイページ > アカウント
							print('<div id="user_account" class="form-action hide">');
								print('<div id="user_account_list">');
									print('<div class="menu_title">アカウント</div>');

									print('<div class="sort_container">');
										print('<svg class="sort_search2020"><use xlink:href="#search2020"/></svg>');

										print('<label class="sort_content"><SELECT name="">');
											print('<OPTION VALUE="">年</OPTION>');
											print('<OPTION VALUE="2018">2018</OPTION>');
											print('<OPTION VALUE="2017">2017</OPTION>');
											print('<OPTION VALUE="2016">2016</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">月</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">日</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
											print('<OPTION VALUE="13">13</OPTION>');
											print('<OPTION VALUE="14">14</OPTION>');
											print('<OPTION VALUE="15">15</OPTION>');
											print('<OPTION VALUE="16">16</OPTION>');
											print('<OPTION VALUE="17">17</OPTION>');
											print('<OPTION VALUE="18">18</OPTION>');
											print('<OPTION VALUE="19">19</OPTION>');
											print('<OPTION VALUE="20">20</OPTION>');
											print('<OPTION VALUE="21">21</OPTION>');
											print('<OPTION VALUE="22">22</OPTION>');
											print('<OPTION VALUE="23">23</OPTION>');
											print('<OPTION VALUE="24">24</OPTION>');
											print('<OPTION VALUE="25">25</OPTION>');
											print('<OPTION VALUE="26">26</OPTION>');
											print('<OPTION VALUE="27">27</OPTION>');
											print('<OPTION VALUE="28">28</OPTION>');
											print('<OPTION VALUE="29">29</OPTION>');
											print('<OPTION VALUE="30">30</OPTION>');
											print('<OPTION VALUE="31">31</OPTION>');
										print('</SELECT></label>');
									print('</div>');

									///////////////////////////////////////////////////////////////////////////////////
									$sql = "SELECT * FROM USERS_J";
									$res = executequery($db, $sql);
									$row = getnextrow($res);
									$count_result = $row["COUNT(*)"];

									///////////////////////////////////////////////////////////////////////////////////
									$in_disp_from = 0;
									$in_disp_to = ($count_result < 25) ? $count_result : 25;
									print('<div class="count_result">' .($in_disp_from + 1) .'～' .$in_disp_to .'/全'.$count_result.'件</div>');

									writePageNumberContainer($count_result);
									///////////////////////////////////////////////////////////////////////////////////

									print('<div class="review_result_user_page">');

									//$sql = "SELECT * FROM USERS_J WHERE username = '$username'";
									$sql = "SELECT * FROM USERS_J LIMIT 10";
									$res = executequery($db, $sql);

									while($row = getnextrow($res))
									{
											print('<div class="user_account_container">');
												print('<div class="user_info_container">');
													print('<div class="user_registration_container">');
														print('<div class="user_name">' .$row["username"] .'</div>');
														print('<div class="user_profile_date_container">');
															print('<div class="user_date">' .gmdate("Y/m/d", $row["user_added_date"] + 9 * 3600) .'</div>');
														print('</div>');
													print('</div>');
												print('</div>');

												print('<div class="mail_address_container">');
													print('<div class="mail_address_content">' .$row["email"] .'</div>');
												print('</div>');
											print('</div>');
									}

									print('</div>');

									/*
									print('<div class="user_account_container">');
										print('<div class="user_info_container">');
											print('<div class="user_registration_container">');
												print('<div class="user_name">ここにユーザー名が入ります</div>');
												print('<div class="user_profile_date_container">');
													print('<div class="user_date">' .gmdate("Y/m/d", $row["write_date"] + 9 * 3600) .'</div>');
												print('</div>');
											print('</div>');
										print('</div>');

										print('<div class="mail_address_container">');
											print('<div class="mail_address_content">xxxx@mail.com</div>');
										print('</div>');
									print('</div>');
									*/

								print("</div>");
							print("</div>");

							//////////////////////////////////////////////////////////////////////
							// マイページ > プロフィール
							print('<div id="user_profile" class="form-action hide">');
								print('<div id="user_profile_list">');
									print('<div class="menu_title">プロフィール</div>');

									print('<div class="sort_container">');
										print('<svg class="sort_search2020"><use xlink:href="#search2020"/></svg>');

										print('<label class="sort_content"><SELECT name="">');
											print('<OPTION VALUE="">年</OPTION>');
											print('<OPTION VALUE="2018">2018</OPTION>');
											print('<OPTION VALUE="2017">2017</OPTION>');
											print('<OPTION VALUE="2016">2016</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">月</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
										print('</SELECT></label>');

										print('<label class="sort_content"><SELECT disabled name="">');
											print('<OPTION VALUE="">日</OPTION>');
											print('<OPTION VALUE="1">1</OPTION>');
											print('<OPTION VALUE="2">2</OPTION>');
											print('<OPTION VALUE="3">3</OPTION>');
											print('<OPTION VALUE="4">4</OPTION>');
											print('<OPTION VALUE="5">5</OPTION>');
											print('<OPTION VALUE="6">6</OPTION>');
											print('<OPTION VALUE="7">7</OPTION>');
											print('<OPTION VALUE="8">8</OPTION>');
											print('<OPTION VALUE="9">9</OPTION>');
											print('<OPTION VALUE="10">10</OPTION>');
											print('<OPTION VALUE="11">11</OPTION>');
											print('<OPTION VALUE="12">12</OPTION>');
											print('<OPTION VALUE="13">13</OPTION>');
											print('<OPTION VALUE="14">14</OPTION>');
											print('<OPTION VALUE="15">15</OPTION>');
											print('<OPTION VALUE="16">16</OPTION>');
											print('<OPTION VALUE="17">17</OPTION>');
											print('<OPTION VALUE="18">18</OPTION>');
											print('<OPTION VALUE="19">19</OPTION>');
											print('<OPTION VALUE="20">20</OPTION>');
											print('<OPTION VALUE="21">21</OPTION>');
											print('<OPTION VALUE="22">22</OPTION>');
											print('<OPTION VALUE="23">23</OPTION>');
											print('<OPTION VALUE="24">24</OPTION>');
											print('<OPTION VALUE="25">25</OPTION>');
											print('<OPTION VALUE="26">26</OPTION>');
											print('<OPTION VALUE="27">27</OPTION>');
											print('<OPTION VALUE="28">28</OPTION>');
											print('<OPTION VALUE="29">29</OPTION>');
											print('<OPTION VALUE="30">30</OPTION>');
											print('<OPTION VALUE="31">31</OPTION>');
										print('</SELECT></label>');
									print('</div>');

									//$sql = "SELECT * FROM USERS_J WHERE username = '$username'";
									$sql = "SELECT * FROM USERS_J LIMIT 10";
									$res = executequery($db, $sql);

									while($row = getnextrow($res))
									{
											$imagefile = ($row["imagefile"] == "") ? $path : 'images/profile/' .$row["imagefile"];

											print('<div class="user_profile_container" data-username=' .$row["username"] .' data-fname=' .$row["fname"] .'>');
												print('<div class="user_info_container">');
													print('<div class="user_image_container">');
														print('<img src="' .$imagefile .'">');
													print('</div>');

													print('<div class="user_registration_container">');
														print('<div class="user_name">' .$row["username"] .'</div>');
														print('<div class="user_profile_date_container">');
															print('<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
															print('<div class="user_date">' .gmdate("Y/m/d", $row["write_date"] + 9 * 3600) .'</div>');
														print('</div>');
													print('</div>');
												print('</div>');

												print('<div class="mail_address_container">');
													print('<div class="mail_address_content">'.$row["email"].'</div>');
												print('</div>');
											print('</div>');
									}

								print("</div>");

								print('<div id="user_profile_detail">');

									print('<div class="menu_title">プロフィール</div>');
									print('<div id="user_profile_prev2020"><svg class="return_button"><use xlink:href="#prev2020"/></svg>一覧へ戻る</div>');
									writeUserContainer();

							  print("</div>");

						print("</div>");
					}
					else
					{
						print("no data");
					}

				print("</div>");//table_wrapper

			print("</div>");//container_wrapper

		print("</div>");//main_banner_container

	print("</div>");//all_container
	?>

	<!-- dialog_login -->
	<div id="dialog_login">
		<form class="login" id="form" name="form" method="post">
			<h3 style="color:#fff">Login</h3>
			<div>
				<label>ユーザー名</label>
				<input type="text" name="email" />
				<span class="error"></span>
			</div>
			<div>
				<label>パスワード</label>
				<input type="password" name="user_password" />
				<p id="login_message"></p>
				<span class="error"></span>
			</div>
			<div class="bottom">
				<input type="button" id="login" value="ログイン">
				<div class="clear"></div>
			</div>
		</form>
	</div>

</body>

<script src="js/manage_edit_user.js"></script>
<script type="text/javascript">

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

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function(){

	var username = <?php echo json_encode($username); ?>;

    if(!username || username == undefined) {
		$('#dialog_login').css('display', 'flex');
	}

	$(document).on('click','#dialog_login #login', function(){
	  var data = $("#form").serialize();
	  //alert("data:" + data);

	  $.ajax({
			type: "post",
			url: "user_login.php",
			data: data,
	  }).done(function(xml){
		  var str = $(xml).find("str").text();

		  if(str == "success")
			  window.open('manage_user_view.php', '_self');
		  else
			  $("#login_message").text('パスワードが違います');
	  }).fail(function(data){
		  alert(str);
		  $("#login_message").text('This is Error');
	  });
	});
});


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function($) {

	$('#user_menu').css({"display":"block"});

	$("#sake_edit .sake_container input").prop("disabled", true);
	$("#sake_edit .sake_container select").prop("disabled", true);

	$('input[name="update_sake"]').css({"display":"none"});
	$('input[name="confirm_button"]').css({"display":"none"});
	$('input[name="delete_sake"]').css({"display":"none"});

	$('#sake_edit .sake_container input[name="cancel_sake"]').prop("disabled", false);

	$('#sakagura_edit .sakagura_container input').prop("disabled", true);
	$('#sakagura_edit .sakagura_container select').prop("disabled", true);
	$('#sakagura_edit .sakagura_container textarea').prop("disabled", true);

	$('#sakagura_edit input[name="update_sakagura"]').css({"display":"none"});
	$('#sakagura_edit input[name="sakagura_confirm"]').css({"display":"none"});
	$('#sakagura_edit input[name="delete_sakagura"]').css({"display":"none"});

	$('#sakagura_edit .sakagura_container input[name="close_sakagura"]').prop("disabled", false);

	$('#sake_edit input[name="cancel_sake"]').click(function() {
			$('#sake_edit_detail').css({"display":"none"});
	});

	$('#sakagura_edit input[name="close_sakagura"]').click(function() {
			$('#sakagura_edit_detail').css({"display":"none"});
	});

	$('#main_banner_container').createTabs({
			text : $('#user_menu')
	});

	//////////////////////////////////////////////////////////////////////////////////////
	var hash = window.location.hash;

	if(hash && hash != "")
	{
		var curr = $('#user_menu').find(".active");
		var prev = $('#user_menu').find('a[href="' + hash +'"]');

		curr.removeClass('active');
		prev.addClass('active');

		$('#main_banner_container').find('.show').removeClass('show').addClass('hide').hide();
		$(hash).removeClass('hide').addClass('show').show();
	}
	else
	{
		var stateObj = { url: "#sake_edit" };
		history.replaceState(stateObj, "test1", $(this).attr("href"));
	}

	$('#user_menu li a').click(function() {
		var stateObj = { url: $(this).attr("href") };
		history.pushState(stateObj, "test1", $(this).attr("href"));
	});

	$(window).on('popstate', function(event) {

		var state = event.originalEvent.state;
		var curr = $('#user_menu').find(".active");
		var href = state.url;
		var prev = $('#user_menu').find('a[href="' + state.url +'"]');

		//alert("url:" + state.url);
		curr.removeClass('active');
		prev.addClass('active');

		$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
		$(href).removeClass('hide').addClass('show').show();
	});
	///////////////////////////////////////////////////////////////////////////////////////////

	$('.simpleTabs a[href="#tab_admin"]').click(function() {
      window.open("manage_view.php", '_self');
	});

	$(document).on('click', '.sake_registry_container', function(e){

			//alert("sake_id:" + $(this).data('sake_id') + " sake_name: " + $(this).data('sake_name'));

			$('#sake_edit .sake_container').css({"display":"block"});
			$('#sake_edit_detail').css({"display":"flex"});
			$("body").trigger( "open_edit_sake", [ $(this).data('sake_id'), $(this).data('sake_name') ] );
	});

	$('#sake_edit_prev2020').click(function() {
			$('#sake_edit_detail').css({"display":"none"});
	});

	$(document).on('click', '.sake_nonda_container', function(e){

			$('#sake_nonda_detail .user_sake_subject').text($(this).data('subject'));
			$('#sake_nonda_detail .user_sake_message').text($(this).data('message'));
			$('#sake_nonda_detail .user_name').text($(this).data('username'));
			$('#sake_nonda_detail .user_date').text($(this).data('write_date'));
			$('#sake_nonda_detail .sake_name').text($(this).data('sake_name'));
			$('#sake_nonda_detail .brewery_prefecture_name').text($(this).data('sakagura_name') + ' / '  + $(this).data('pref'));
			$('#sake_nonda_detail .sake_rate').text($(this).data('rank'));

			//alert("tastes:" + $(this).data('tastes'));

			if($(this).data('tastes') && $(this).data('tastes') != undefined) {
				var tastes = $(this).data('tastes').toString();
				var taste_values = tastes.split(',');
				var i = 0;

				$('.user_sake_user_bar').css({"width": "0%"});
				$('.user_sake_tasting_score span').text("0.0");

				for(i = 0; i < taste_values.length; i++)　{
					 taste_values[i] = (taste_values[i] == "") ? 0 : taste_values[i];
					 var width = (taste_values[i] / 10) * 100 + '%';
					 //alert("taste_values[i]:" + taste_values[i] + " width:" + width);

					 $('.user_sake_user_bar:nth(' + i + ')').css({"width": width});
					 $('.user_sake_tasting_score:nth(' + i + ') span').text((taste_values[i] == 0) ? "0.0" : taste_values[i]);
				}
			}

			if($(this).data('flavor') != undefined && $(this).data('flavor') != "") {
				var flavors = $(this).data('flavor').toString();
				var flavor_values = flavors.split(',');
				var flavor_text = "";

				//alert("flavors:" + flavors);

				for(i = 0; i < flavor_values.length; i++)
				{
					 flavor_text += GetFlavorNames(flavor_values[i])
				}

				$('.user_sake_flavor_caption').text(flavor_text);
			}

			//////////////////////////////////////////////////////////////////////////////
			$('.sake_nonda_container .user_sake_image_container').remove();
			//$('.sake_nonda_container .user_sake_image_container').html('');

			if($(this).data('path') != "" && $(this).data('path') != undefined) {

  				var pathArray = $(this).data('path').split(', ');
				var innerHTML = "";
				var path = "";

				//alert("path:" + $(this).data('path'));

				for(var i = 0; i < pathArray.length; i++) {
					path = "images\\photo\\thumb\\" + pathArray[i];
					innerHTML += '<div class="user_sake_image"><img src="' + path + '"></div>';
				}

				$('.user_sake_image_container').html(innerHTML);
				//alert("innerHTML:" + innerHTML);
			}

			$('#sake_nonda_detail').css({"display":"flex"});
	});

	$('#sake_nonda_prev2020').click(function() {
		$('#sake_nonda_detail').css({"display":"none"});
	});

	$('.user_profile_container').click(function() {

		$('#user_container').css({"display":"block"});
		$('#user_profile_detail').css({"display":"flex"});
		$("body").trigger("open_edit_user", [ $(this).data('username'), $(this).data('fname') ] );

		//alert("user_container:" + $('#user_container'));
	});

	$('#user_profile_prev2020').click(function() {
		$('#user_profile_detail').css({"display":"none"});
	});
});


/*レビューモーダルウィンドウ内タブ*/
$(function () {
  /*初期表示*/
  $('.user_sake_tab_panel').hide();
  $('.user_sake_tab_panel').eq(0).show();
  $('.user_sake_tab_link').eq(0).addClass('is-active');

  /*クリックイベント*/
  $('.user_sake_tab_link').each(function () {
    $(this).on('click', function () {
      var index = $('.user_sake_tab_link').index(this);
      $('.user_sake_tab_link').removeClass('is-active');
      $(this).addClass('is-active');
      $('.user_sake_tab_panel').hide();
      $('.user_sake_tab_panel').eq(index).show();
    });
  });
});

$(function() {
	$('.user_sake_tab_link').click(function() {
		$('.user_sake_icon').css({"fill": "#8c8c8c"});
		$(this).find(".user_sake_icon").css({"fill": "#3f3f3f"});
	});
});

/*レビューモーダルウィンドウ内タブ テイスティングソート*/
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
		if(isA == 0)
			return;

		isA = 0;
		setState(0);
	});

	btnB.addEventListener('click', function(){
		if(isA == 1)
			return;

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
});


// 酒検索
$(function() {
		$(document).on('keyup', '#sake_edit .sake_input', function(){

		var inputText = $(this).val().replace(/　/g, ' ');
		var count = inputText.length;
		var search_type = 1;
		var search_limit = 49;
		var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;
			var sake_content = $(this).parent().parent().find('.sake_content');

		$(".sake_content").css({"visibility": "hidden"})
		$(".sake_content").empty();

		if(count >= 1)
		{
			$.ajax({
				type: "POST",
				url: "auto_complete.php",
							data: data,
				dataType: 'json',

			}).done(function(data){

				//alert("succeded:" + data + "length:" + data.length);
				$('.sake_content').empty();

				for(var i = 0; i < data.length; i++)
				{
									sake_content.append('<li data-sake_id=' + data[i].sake_id + ' data-sake_name=' + data[i].sake_name + ' data-sakagura_name=' + data[i].sakagura_name + '><img src="images/icons/noimage80.svg">' + data[i].sake_name + '</li>');
							}

				if($("#sake_edit .sake_input").val().length > 0)
					$("#sake_edit .sake_content").css({"visibility": "visible"});

			}).fail(function(data){
				alert("Failed:" + data);
			});
		}
		else
		{
			$('#sake_edit .sake_content').empty();
		}
	}); // keyup

	$(document).on('click', '#sake_edit .sake_content li', function(){

			//alert("sake_container");
			$('#sake_edit .manage_sake_search_container').css({"display":"none"});
			$('#sake_edit .sake_container').css({"display":"block"});
			$("body").trigger( "open_edit_sake", [ $(this).data('sake_id'), $(this).data('sake_name') ] );
	});

	$(document).on('click', '#sake_nomitai .sake_nomitai_container', function(){

			//alert("sake_container");
			$('.sake_container').css({"display":"block"});
			$('#nomitai_edit_detail').css({"display":"flex"});
			$("body").trigger( "open_edit_sake", [ $(this).data('sake_id'), $(this).data('sake_name') ] );
	});

	$('#nomitai_edit_prev2020').click(function() {
		$('#nomitai_edit_detail').css({"display":"none"});
	});

	function searchFavoriteSake(in_disp_from, disp_max, data, bCount)
	{
			//alert("searchFavoriteSake:" + data);

			$.ajax({
					type: "POST",
					url: "ajax_favorite.php",
					data: data,
					dataType: 'json',

			}).done(function(data){

					var count_result = data[0].count;
					var sake = data[0].result;
					var username = <?php echo json_encode($username); ?>;
					var i = 0;

					//alert("success:" + sake.length);
					//alert("success:" + data[0].sql);
					//alert("sake.length:" + sake.length);
					$('#sake_nomitai .review_result_sake_page').empty()

					for(i = 0; i < sake.length; i++)
					{
								var path = "images/icons/noimage160.svg";
								var innerHTML = '<div class="sake_registry_container" data-sake_id=' + sake[i].sake_id + ' data-sake_name=' + sake[i].sake_name + '>';
								innerHTML += '<div class="user_info_container">';
								innerHTML += '<div class="user_image_container">';
								innerHTML += '<img src="' + path + '">';
								innerHTML += '</div>';

								innerHTML += '<div class="user_registration_container">';
								innerHTML += '<div class="user_name">' + sake[i].username + '</div>';
								innerHTML += '<div class="user_profile_date_container">';
								innerHTML += '<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>';
								innerHTML += '<div class="user_date">' + sake[i].write_date + '</div>';
								innerHTML += '</div>';
								innerHTML += '</div>';
								innerHTML += '</div>'; // user_info_container

								innerHTML += '<div class="sake_info_container">';
								innerHTML += '<div class="sake_name">' + sake[i].sake_name + '</div>';
								innerHTML += '<div class="brewery_prefecture_name">' + sake[i].sakagura_name + '/' + sake[i].pref + '</div>';
								innerHTML += '</div>';
								innerHTML += '</div>'; // sake_resigtry container
								$('#sake_nomitai .review_result_sake_page').append(innerHTML);
					}

					if(count_result != 0)
					{
							$("#sake_nomitai .page_number_container").data('count', count_result);
							//alert("count:" + $("#sake_nomitai .page_number_container").data('count'));
					}

					$("#sake_nomitai .count_result").text(($("#sake_nomitai .page_number_container").data('in_disp_from') + 1) + '～' +  $("#sake_nomitai .page_number_container").data('in_disp_to') + '/全' + $("#sake_nomitai .page_number_container").data('count') + '件');

			}).fail(function(data){
					alert("Failed:" + data);
			}).complete(function(data){
					// Loadingイメージを消す
					removeLoading();
			});
    }

	function searchSake(data)
	{
		//alert("searchSake data:" + data);

		$.ajax({
				type: "POST",
				url: "complex_search.php",
				data: data,
				dataType: 'json',

		}).done(function(data){

					var i = 0;
					var sake = data[0].result;
					var path = "images/icons/noimage_user30.svg";

					$('#sake_edit .review_result_sake_page').empty();

					//alert("success:" + data[0].sql);
					//alert("success: count:" + sake);

					for(i = 0; i < sake.length; i++)
					{
							var innerHTML = "";

							innerHTML += '<div class="sake_registry_container" data-sake_id=' + sake[i].sake_id + ' data-sake_name=' + sake[i].sake_name + '>';
								innerHTML += '<div class="user_info_container">';
									innerHTML += '<div class="user_image_container">';
										innerHTML += '<img src="' + path + '">';
									innerHTML += '</div>';

									innerHTML += '<div class="user_registration_container">';
										innerHTML += '<div class="user_name">' + <?php echo json_encode($username); ?> + '</div>';
										innerHTML += '<div class="user_profile_date_container">';
											innerHTML += '<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>';
											innerHTML += '<div class="user_date">' + sake[i].write_date + '</div>';
										innerHTML += '</div>';
									innerHTML += '</div>';
								innerHTML += '</div>'; // user_info_container

								innerHTML += '<div class="sake_info_container">';
									innerHTML += '<div class="sake_name">' + sake[i].sake_name + '</div>';
									innerHTML += '<div class="brewery_prefecture_name">' + sake[i].sakagura_name + '/' + sake[i].pref + '</div>';
								innerHTML += '</div>';
							innerHTML += '</div>'; // sake_resigtry container

						  //alert("html:" + innerHTML);
							$('#sake_edit .review_result_sake_page').append(innerHTML);
					}

					if(data[0].count != 0)
						$("#sake_edit .page_number_container").data('count', data[0].count);

					$("#sake_edit .count_result").text(($("#sake_edit .page_number_container").data('in_disp_from') + 1) + '～' +  $("#sake_edit .page_number_container").data('in_disp_to') + '/全' + $("#sake_edit .page_number_container").data('count') + '件');

			}).fail(function(data){
					alert("Failed:" + data);
			}).complete(function(data){
					// Loadingイメージを消す
			});
	}

	$(document).on('click', '#sake_edit .page_number_container .pageitems', function(e){

			var position = $(this).index();
			var showPos = parseInt($(this).text()) - 1;
			var count_query = 0;
			var search_category = 2;
			var in_disp_from = showPos * $("#sake_edit .page_number_container").data('in_disp_max');
			var in_disp_to = in_disp_from + 25;

			$("#sake_edit .page_number_container").data('in_disp_from', in_disp_from);
			$("#sake_edit .page_number_container").data('in_disp_to', in_disp_to);
			$('#sake_edit .pageitems').removeClass("selected");
			$(this).addClass("selected");
			//alert("showPos:" + showPos + " position:" + position);

			var data = "&count_query=" + count_query +
									"&category=" + search_category +
									"&write_date_from=" + $("#sake_edit .page_number_container").data('write_date_from') +
									"&write_date_to="   + $("#sake_edit .page_number_container").data('write_date_to') +
									"&from=" + $("#sake_edit .page_number_container").data('in_disp_from') +
									"&to=" + $("#sake_edit .page_number_container").data('in_disp_to') +
									"&in_disp_max="  + $("#sake_edit .page_number_container").data('in_disp_max');

			//alert("data:" + data);
			searchSake(data);
	});

	$(document).on('click', '#sake_edit .page_number_container .prev_page', function(e){
			//alert("sake next_page");
			var count_query = 0;
			var search_category = 2;
			var in_disp_from = 0;
			var in_disp_to = 25;
			var position = $('#sake_edit .pageitems.selected').index();

			//alert("prev:" + $("#sake_edit .page_number_container").data('in_disp_from'))

			if($("#sake_edit .page_number_container").data('in_disp_from') >= $("#sake_edit .page_number_container").data('in_disp_max'))
			{
					if(position > 1)
					{
							//alert("position:" + position + " length:" + $('#sake_edit .pageitems').length);
							$('#sake_edit .pageitems.selected.selected').removeClass("selected");
							$('#sake_edit .pageitems:nth(' + (position - 2) + ')').addClass("selected");
					}
					else
					{
							var showPos = parseInt($('#sake_edit .pageitems:nth(0)').text()) - 2;
							var i = 1;
							//alert("showPos:" + showPos + " pageitem:" + $('#sake_edit .pageitems:nth(0)').text());

							$('#sake_edit .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});
					}

					in_disp_from = $("#sake_edit .page_number_container").data('in_disp_from') - $("#sake_edit .page_number_container").data('in_disp_max');
					var in_disp_to = in_disp_from + $("#sake_edit .page_number_container").data('in_disp_max');

					$("#sake_edit .page_number_container").data('in_disp_from', in_disp_from);
					$("#sake_edit .page_number_container").data('in_disp_to', in_disp_to);

					var data = "&count_query=" + count_query +
											"&category=" + search_category +
											"&write_date_from=" + $("#sake_edit .page_number_container").data('write_date_from') +
											"&write_date_to="   + $("#sake_edit .page_number_container").data('write_date_to') +
											"&from=" + $("#sake_edit .page_number_container").data('in_disp_from') +
											"&to=" + $("#sake_edit .page_number_container").data('in_disp_to') +
											"&in_disp_max=" + $("#sake_edit .page_number_container").data('in_disp_max');

					//alert("search_sake:" + data);
					searchSake(data);
			}
	});

	$(document).on('click', '#sake_edit .page_number_container .next_page', function(e){

			//alert("sake next_page");
			var count_query = 0;
			var search_category = 2;
			var in_disp_from = $("#sake_edit .page_number_container").data('in_disp_from') + $("#sake_edit .page_number_container").data('in_disp_max');
			var in_disp_to = $("#sake_edit .page_number_container").data('in_disp_to') + $("#sake_edit .page_number_container").data('in_disp_max');
			var position = $('#sake_edit .pageitems.selected').index();

			in_disp_to = (in_disp_to > $("#sake_edit .page_number_container").data('count')) ? $("#sake_edit .page_number_container").data('count') : in_disp_to;

			if(in_disp_from < $("#sake_edit .page_number_container").data('count'))
			{
					//alert("position:" + position + " length:" + $('#sake_edit .pageitems').length);

					if(position < $('#sake_edit .pageitems').length)
					{
							//alert("position:" + position + " length:" + $('#sake_edit .pageitems').length);
							$('#sake_edit .pageitems.selected.selected').removeClass("selected");
							$('#sake_edit .pageitems:nth(' + position + ')').addClass("selected");
					}
					else
					{
							var showPos = parseInt($('#sake_edit .pageitems:nth(0)').text());
							var i = 1;

							$('#sake_edit .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});
					}

					$("#sake_edit .page_number_container").data('in_disp_from', in_disp_from);
					$("#sake_edit .page_number_container").data('in_disp_to', in_disp_to);

					var data = "&count_query=" + count_query +
											"&category=" + search_category +
											"&write_date_from=" + $("#sake_edit .page_number_container").data('write_date_from') +
											"&write_date_to="   + $("#sake_edit .page_number_container").data('write_date_to') +
											"&from=" + $("#sake_edit .page_number_container").data('in_disp_from') +
											"&to=" + $("#sake_edit .page_number_container").data('in_disp_to') +
											"&in_disp_max="  + $("#sake_edit .page_number_container").data('in_disp_max');

					//alert("search_sake:" + data);
					searchSake(data);
			}
	});

	$(document).on('click', '#sake_edit .list_content li a:nth(0)', function(){

			var position = $(this).index();
			var showPos = 1;
			var count_query = 0;
			var search_category = 2;
			var in_disp_from = 0;
			var in_disp_to = in_disp_from + 25;

			$("#sake_edit .page_number_container").data('in_disp_from', in_disp_from);
			$("#sake_edit .page_number_container").data('in_disp_to', in_disp_to);
			$('#sake_edit .pageitems').removeClass("selected");
			$('#sake_edit .page_number_container .pageitems:nth(0)').addClass("selected");
			//$(this).addClass("selected");
			//alert("showPos:" + showPos + " position:" + position);

			var data = "&count_query=" + count_query +
									"&category=" + search_category +
									"&write_date_from=" + $("#sake_edit .page_number_container").data('write_date_from') +
									"&write_date_to="   + $("#sake_edit .page_number_container").data('write_date_to') +
									"&from=" + $("#sake_edit .page_number_container").data('in_disp_from') +
									"&to=" + $("#sake_edit .page_number_container").data('in_disp_to') +
									"&in_disp_max=" + $("#sake_edit .page_number_container").data('in_disp_max');

			//alert("data:" + data);
			searchSake(data);

			$('#sake_edit .list_content li a').removeClass('active');
			$(this).addClass('active');

	});

	/* 新規登録一覧 */
	$(document).on('click', '#sake_edit .list_content li a:nth(1)', function(){

			var position = $(this).index();
			var showPos = 1;
			var count_query = 0;
			var search_category = 2;
			var in_disp_from = 0;
			var in_disp_to = in_disp_from + 25;

			$("#sake_edit .page_number_container").data('in_disp_from', in_disp_from);
			$("#sake_edit .page_number_container").data('in_disp_to', in_disp_to);
			$('#sake_edit .pageitems').removeClass("selected");
			$('#sake_edit .page_number_container .pageitems:nth(0)').addClass("selected");
			//$(this).addClass("selected");
			//alert("showPos:" + showPos + " position:" + position);

			var data = "&count_query=" + count_query +
									"&category=" + search_category +
									"&write_date_from=" + $("#sake_edit .page_number_container").data('write_date_from') +
									"&write_date_to="   + $("#sake_edit .page_number_container").data('write_date_to') +
									"&from=" + $("#sake_edit .page_number_container").data('in_disp_from') +
									"&to=" + $("#sake_edit .page_number_container").data('in_disp_to') +
									"&in_disp_max=" + $("#sake_edit .page_number_container").data('in_disp_max');

			//alert("data:" + data);
			searchSake(data);

			$('#sake_edit .list_content li a').removeClass('active');
			$(this).addClass('active');
	});

	$(document).on('click', '#sake_edit .list_content li a:nth(2)', function(){

			var position = 1;
			var showPos = 1;
			var count_query = 0;
			var search_category = 2;
			var in_disp_from = 0;
			var in_disp_to = in_disp_from + 25;

			//alert("編集");

			$("#sake_edit .page_number_container").data('in_disp_from', in_disp_from);
			$("#sake_edit .page_number_container").data('in_disp_to', in_disp_to);
			$('#sake_edit .pageitems').removeClass("selected");
			$(this).addClass("selected");
		    $('.page_number_container .pageitems:nth(0)').addClass("selected");
			//alert("showPos:" + showPos + " position:" + position);

			var data = "&count_query=" + count_query +
									"&category=" + search_category +
									"&write_date_from=" + $("#sake_edit .page_number_container").data('write_date_from') +
									"&write_date_to="   + $("#sake_edit .page_number_container").data('write_date_to') +
									"&from=" + $("#sake_edit .page_number_container").data('in_disp_from') +
									"&to=" + $("#sake_edit .page_number_container").data('in_disp_to') +
									"&in_disp_max=" + $("#sake_edit .page_number_container").data('in_disp_max');

			//alert("data:" + data);
			searchSake(data);

			$('#sake_edit .list_content li a').removeClass('active');
			$(this).addClass('active');
	});

    $(document).on('click', '#sake_edit .list_content li a:nth(3)', function(){

			$('#sake_edit .list_content li a').removeClass('active');
			$(this).addClass('active');
	});

    $("#sake_edit .sort_content SELECT").change(function(){

			var index = $(this).parent().index();
		    var val1 = $("#sake_edit .sort_content SELECT:nth(0)").val();
			var val2 = $("#sake_edit .sort_content SELECT:nth(1)").val();
			var val3 = $("#sake_edit .sort_content SELECT:nth(2)").val();
			var str1 = "", str2 = "";
			var date1 = "", date2 = "";

			$("#sake_edit .sort_content SELECT").prop("disabled", false);

			if(val1 && val2 && val3)
			{
					str1 = val1 + '.' + val2 + '.' + val3;
				  //alert("val1:" + val1 + " val2:" + val2 + " val3:" + val3);

					date1 = new Date(str1);
					date2 = new Date(str1);
					date2.setDate(date2.getDate() + 1);

					//date2.add(1).day();
					//alert("date1:" + date1);
					//alert("date1:" + date2);

					date1 = date1.getTime() / 1000;
					date2 = date2.getTime() / 1000;
			}
			else if((val1 && val2) && !val3)
			{
					if(parseInt(val2) == 12)
					{
							str1 = val1 + '.' + val2 + '.1';
							str2 = (parseInt(val1) + 1) + '.1.1';
					}
					else
					{
							str1 = val1 + '.' + val2 + '.1';
							str2 = val1 + '.' + (parseInt(val2) + 1) + '.1';
					}


					date1 = new Date(str1).getTime() / 1000;
					date2 = new Date(str2).getTime() / 1000;

			}
			else if(val1 && (!val2 && !val3))
			{
					str1 = val1 + '.1.1';
					str2 = (parseInt(val1) + 1) + '.1.1';

					date1 = new Date(str1).getTime() / 1000;
					date2 = new Date(str2).getTime() / 1000;
			}


			//alert("Date1:" + date1);
			//alert("Date2:" + date2);

			var position = $(this).index();
			var showPos = parseInt($(this).text()) - 1;
			var count_query = 1;
			var search_category = 2;
			var in_disp_from = 0;
			var in_disp_to = in_disp_from + 25;
			var i = 1;

			$("#sake_edit .page_number_container").data('in_disp_from', in_disp_from);
			$("#sake_edit .page_number_container").data('in_disp_to', in_disp_to);
			$('#sake_edit .pageitems').removeClass("selected");
			$('#sake_nomitai .pageitems:nth(0)').addClass("selected");

			//alert("showPos:" + showPos + " position:" + position);

			$('#sake_edit .pageitems').each(function() {
					$(this).text(i);
					i++;
			});

			$('#sake_edit .pageitems').removeClass("selected");
			$('#sake_edit .pageitems:nth(0)').addClass("selected");

			$("#sake_edit .page_number_container").data('write_date_from', date1);
			$("#sake_edit .page_number_container").data('write_date_to', date2);

			var data = "&count_query=" + count_query +
									"&category=" + search_category +
									"&write_date_from=" + date1 +
									"&write_date_to="   + date2 +
									"&from=" + $("#sake_edit .page_number_container").data('in_disp_from') +
									"&to=" + $("#sake_edit .page_number_container").data('in_disp_to') +
									"&in_disp_max=" + $("#sake_edit .page_number_container").data('in_disp_max');

			//alert("data:" + data);
			searchSake(data);
    });

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$(document).on('click', '#sake_nomitai .page_number_container .prev_page', function(e){
			//alert("sake next_page");
			var search_type = 1;
			var count_query = 0;
			var search_category = 2;
			var in_disp_from = 0;
			var in_disp_to = 25;
			var position = $('#sake_nomitai .pageitems.selected').index();
			var username = <?php echo json_encode($username); ?>;
			var orderby = "write_date";

			//alert("prev:" + $("#sake_nomitai .page_number_container").data('in_disp_from'))

			if($("#sake_nomitai .page_number_container").data('in_disp_from') >= $("#sake_edit .page_number_container").data('in_disp_max'))
			{
					if(position > 1)
					{
							//alert("position:" + position + " length:" + $('#sake_nomitai .pageitems').length);
							$('#sake_nomitai .pageitems.selected.selected').removeClass("selected");
							$('#sake_nomitai .pageitems:nth(' + (position - 2) + ')').addClass("selected");
					}
					else
					{
								var showPos = parseInt($('#sake_nomitai .pageitems:nth(0)').text()) - 2;
								var i = 1;
								//alert("showPos:" + showPos + " pageitem:" + $('#sake_nomitai .pageitems:nth(0)').text());

								$('#sake_nomitai .pageitems').each(function() {
										$(this).text(showPos + i);
										i++;
								});
					}

					in_disp_from = $("#sake_nomitai .page_number_container").data('in_disp_from') - $("#sake_nomitai .page_number_container").data('in_disp_max');
					var in_disp_to = in_disp_from + $("#sake_nomitai .page_number_container").data('in_disp_max');

					$("#sake_nomitai .page_number_container").data('in_disp_from', in_disp_from);
					$("#sake_nomitai .page_number_container").data('in_disp_to', in_disp_to);

					var data = "search_type=" + search_type +
											"&from=" + $("#sake_nomitai .page_number_container").data('in_disp_from') +
											"&in_disp_to=" + $("#sake_nomitai .page_number_container").data('in_disp_to') +
											"&write_date_from=" + $("#sake_edit .page_number_container").data('write_date_from') +
											"&write_date_to="   + $("#sake_edit .page_number_container").data('write_date_to') +
											"&disp_max="  + $("#sake_nomitai .page_number_container").data('in_disp_max') +
											"&orderby="  + orderby;

					//alert("search_sake:" + data);
					searchFavoriteSake(in_disp_from, $("#sake_nomitai .page_number_container").data('in_disp_max'), data, 1);
					$("#sake_nomitai .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sake_nomitai .page_number_container").data('count') + '件');
			}
	});

	$(document).on('click', '#sake_nomitai .page_number_container .next_page', function(e){

			//alert("sake next_page");
			var search_type = 1;
			var count_query = 0;
			var search_category = 2;
			var in_disp_from = $("#sake_nomitai .page_number_container").data('in_disp_from') + $("#sake_nomitai .page_number_container").data('in_disp_max');
			var in_disp_to = $("#sake_nomitai .page_number_container").data('in_disp_to') + $("#sake_nomitai .page_number_container").data('in_disp_max');
			var position = $('#sake_nomitai .pageitems.selected').index();
			var username = <?php echo json_encode($username); ?>;
			var orderby = "write_date";

			in_disp_to = (in_disp_to > $("#sake_nomitai .page_number_container").data('count')) ? $("#sake_nomitai .page_number_container").data('count') : in_disp_to;

			if(in_disp_from < $("#sake_nomitai .page_number_container").data('count'))
			{
					if(position < $('#sake_nomitai .pageitems').length)
					{
							//alert("position:" + position + " length:" + $('#sake_nomitai .pageitems').length);
							$('#sake_nomitai .pageitems.selected.selected').removeClass("selected");
							$('#sake_nomitai .pageitems:nth(' + position + ')').addClass("selected");
					}
					else if($('#sake_nomitai .pageitems').length >= 5)
					{
							//alert("position2:" + position + " length:" + $('#sake_nomitai .pageitems').length);
							var showPos = parseInt($('#sake_nomitai .pageitems:nth(0)').text());
							var i = 1;

							$('#sake_nomitai .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});
					}
					else
					{
							return 0;
					}

					$("#sake_nomitai .page_number_container").data('in_disp_from', in_disp_from);
					$("#sake_nomitai .page_number_container").data('in_disp_to', in_disp_to);

					var data = "search_type=" + search_type +
											"&from=" + $("#sake_nomitai .page_number_container").data('in_disp_from') +
											"&in_disp_to=" + $("#sake_nomitai .page_number_container").data('in_disp_to') +
											"&write_date_from=" + $("#sake_edit .page_number_container").data('write_date_from') +
											"&write_date_to="   + $("#sake_edit .page_number_container").data('write_date_to') +
											"&disp_max="  + $("#sake_nomitai .page_number_container").data('in_disp_max') +
											"&orderby="  + orderby;

					//alert("search_sake:" + data);
					searchFavoriteSake(in_disp_from, $("#sake_nomitai .page_number_container").data('in_disp_max'), data, 1);
					$("#sake_nomitai .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sake_nomitai .page_number_container").data('count') + '件');
			}
	});

	$(document).on('click', '#sake_nomitai .pageitems', function(e){

			var search_type = 1;
			var position = $(this).index();
			var showPos = parseInt($(this).text()) - 1;
			var in_disp_from = showPos * $("#sake_nomitai .page_number_container").data('in_disp_max');
			var in_disp_to = in_disp_from + 25;
			var orderby = "write_date";
			var username = <?php echo json_encode($username); ?>;

			$("#sake_nomitai .page_number_container").data('in_disp_from', in_disp_from);
			$("#sake_nomitai .page_number_container").data('in_disp_to', in_disp_to);
			$('#sake_nomitai .pageitems').removeClass("selected");
			$(this).addClass("selected");
			//alert("showPos:" + showPos + " position:" + position);

			var data = "search_type=" + search_type +
									"&from=" + $("#sake_nomitai .page_number_container").data('in_disp_from') +
									"&in_disp_to=" + $("#sake_nomitai .page_number_container").data('in_disp_to') +
									"&write_date_from=" + $("#sake_nomitai .page_number_container").data('write_date_from') +
									"&write_date_to="   + $("#sake_nomitai .page_number_container").data('write_date_to') +
									"&disp_max="  + $("#sake_nomitai .page_number_container").data('in_disp_max') +
									"&orderby="  + orderby;

			//alert("data:" + data);
			searchFavoriteSake(in_disp_from, $("#sake_nomitai .page_number_container").data('in_disp_max'), data, 1);
			$("#sake_nomitai .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sake_nomitai .page_number_container").data('count') + '件');
	});

	$("#sake_nomitai .sort_content SELECT").change(function(){

			var index = $(this).parent().index();
			var count_query = 1;
			var val1 = $("#sake_nomitai .sort_content SELECT:nth(0)").val();
			var val2 = $("#sake_nomitai .sort_content SELECT:nth(1)").val();
			var val3 = $("#sake_nomitai .sort_content SELECT:nth(2)").val();
			var str1 = "", str2 = "";
			var date1 = "", date2 = "";
			var i = 1;

			$("#sake_nomitai .sort_content SELECT").prop("disabled", false);

			if(val1 && val2 && val3)
			{
					str1 = val1 + '.' + val2 + '.' + val3;
				  //alert("val1:" + val1 + " val2:" + val2 + " val3:" + val3);

					date1 = new Date(str1);
					date2 = new Date(str1);
					date2.setDate(date2.getDate() + 1);

					//date2.add(1).day();
					//alert("date1:" + date1);
					//alert("date1:" + date2);

					date1 = date1.getTime() / 1000;
					date2 = date2.getTime() / 1000;
			}
			else if((val1 && val2) && !val3)
			{
					if(parseInt(val2) == 12)
					{
							str1 = val1 + '.' + val2 + '.1';
							str2 = (parseInt(val1) + 1) + '.1.1';
					}
					else
					{
							str1 = val1 + '.' + val2 + '.1';
							str2 = val1 + '.' + (parseInt(val2) + 1) + '.1';
					}

					date1 = new Date(str1).getTime() / 1000;
					date2 = new Date(str2).getTime() / 1000;

			}
			else if(val1 && (!val2 && !val3))
			{
					str1 = val1 + '.1.1';
					str2 = (parseInt(val1) + 1) + '.1.1';

					date1 = new Date(str1).getTime() / 1000;
					date2 = new Date(str2).getTime() / 1000;
			}

			//alert("Date1:" + date1);
			//alert("Date2:" + date2);

			var search_type = 1;
			var position = $(this).index();
			var showPos = parseInt($(this).text()) - 1;
			var in_disp_from = 0;
			var in_disp_to = in_disp_from + 25;
			var orderby = "write_date";
			var username = <?php echo json_encode($username); ?>;

			$("#sake_nomitai .page_number_container").data('in_disp_from', in_disp_from);
			$("#sake_nomitai .page_number_container").data('in_disp_to', in_disp_to);
			$('#sake_nomitai .pageitems').removeClass("selected");
			$('#sake_nomitai .pageitems:nth(0)').addClass("selected");

			$('#sake_nomitai .pageitems').each(function() {
					$(this).text(i);
					i++;
			});

			$("#sake_nomitai .page_number_container").data('write_date_from', date1);
			$("#sake_nomitai .page_number_container").data('write_date_to', date2);

			//alert("showPos:" + showPos + " position:" + position);
			var data = "&count_query=" + count_query +
									"&search_type=" + search_type +
									"&from=" + $("#sake_nomitai .page_number_container").data('in_disp_from') +
									"&in_disp_to=" + $("#sake_nomitai .page_number_container").data('in_disp_to') +
									"&write_date_from=" + date1 +
									"&write_date_to="   + date2 +
									"&disp_max="  + $("#sake_nomitai .page_number_container").data('in_disp_max') +
									"&orderby="  + orderby;

			//alert("data:" + data);
			searchFavoriteSake(in_disp_from, $("#sake_nomitai .page_number_container").data('in_disp_max'), data, 1);
			$("#sake_nomitai .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sake_nomitai .page_number_container").data('count') + '件');
  });

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  $("#sakagura_favorite .sort_content SELECT").change(function(){

			var index = $(this).parent().index();
			var count_query = 1;
		  var val1 = $("#sakagura_favorite .sort_content SELECT:nth(0)").val();
			var val2 = $("#sakagura_favorite .sort_content SELECT:nth(1)").val();
			var val3 = $("#sakagura_favorite .sort_content SELECT:nth(2)").val();
			var str1 = "", str2 = "";
			var date1 = "", date2 = "";
			var i = 1;

		  $("#sakagura_favorite .sort_content SELECT").prop("disabled", false);

			if(val1 && val2 && val3)
			{
					str1 = val1 + '.' + val2 + '.' + val3;
				  //alert("val1:" + val1 + " val2:" + val2 + " val3:" + val3);

					date1 = new Date(str1);
					date2 = new Date(str1);
					date2.setDate(date2.getDate() + 1);

					//date2.add(1).day();
					//alert("date1:" + date1);
					//alert("date1:" + date2);

					date1 = date1.getTime() / 1000;
					date2 = date2.getTime() / 1000;
			}
			else if((val1 && val2) && !val3)
			{
					if(parseInt(val2) == 12)
					{
							str1 = val1 + '.' + val2 + '.1';
							str2 = (parseInt(val1) + 1) + '.1.1';
					}
					else
					{
							str1 = val1 + '.' + val2 + '.1';
							str2 = val1 + '.' + (parseInt(val2) + 1) + '.1';
					}

					date1 = new Date(str1).getTime() / 1000;
					date2 = new Date(str2).getTime() / 1000;

			}
			else if(val1 && (!val2 && !val3))
			{
					str1 = val1 + '.1.1';
					str2 = (parseInt(val1) + 1) + '.1.1';

					date1 = new Date(str1).getTime() / 1000;
					date2 = new Date(str2).getTime() / 1000;
			}

			//alert("Date1:" + date1);
			//alert("Date2:" + date2);

			var search_type = 2;
			var in_disp_from = 0;
			var in_disp_to = in_disp_from + 25;
			var orderby = "write_date";
			var username = <?php echo json_encode($username); ?>;

			$("#sakagura_favorite .page_number_container").data('in_disp_from', in_disp_from);
			$("#sakagura_favorite .page_number_container").data('in_disp_to', in_disp_to);
			$('#sakagura_favorite .pageitems').removeClass("selected");
			$('#sakagura_favorite .pageitems:nth(0)').addClass("selected");

			$('#sakagura_favorite .pageitems').each(function() {
					$(this).text(i);
					i++;
			});

			$("#sakagura_favorite .page_number_container").data('write_date_from', date1);
			$("#sakagura_favorite .page_number_container").data('write_date_to', date2);
			$(this).addClass("selected");
			//alert("showPos:" + showPos + " position:" + position);

			var data = "&count_query=" + count_query +
									"&search_type=" + search_type +
									"&from=" + $("#sakagura_favorite .page_number_container").data('in_disp_from') +
									"&to="	 + $("#sakagura_favorite .page_number_container").data('in_disp_to') +
									"&write_date_from=" + date1 +
									"&write_date_to="   + date2 +
									"&username="+ username+
									"&disp_max="  + $("#sakagura_favorite .page_number_container").data('in_disp_max');

			//alert("data1:" + data);
			searchFavoriteSakagura(data);
	});


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function searchUser(data)
	{
		//alert("searchUser data:" + data);

		$.ajax({
				type: "POST",
				url: "complex_search.php",
				data: data,
				dataType: 'json',

		}).done(function(data){

					var i = 0;
					var user = data[0].sake;
          var path = "images/icons/noimage_user30.svg";

					$('#user_account .review_result_user_page').empty();
					//alert("success:" + data[0].sql);
					//alert("success: count:" + data[0].count);

					for(i = 0; i < user.length; i++)
					{
							var innerHTML = "";

							innerHTML += '<div class="user_account_container">';
								innerHTML += '<div class="user_info_container">';
									innerHTML += '<div class="user_registration_container">';
										innerHTML += '<div class="user_name">' + user[i].username + '</div>';
										innerHTML += '<div class="user_profile_date_container">';
											innerHTML += '<div class="user_date">' + user[i].write_date + '</div>';
										innerHTML += '</div>';
									innerHTML += '</div>';
								innerHTML += '</div>';

								innerHTML += '<div class="mail_address_container">';
									innerHTML += '<div class="mail_address_content">' + user[i].email + '</div>';
								innerHTML += '</div>';
							innerHTML += '</div>';

							$('#user_account .review_result_user_page').append(innerHTML);
					}

					if(data[0].count != 0)
						$("#user_account .page_number_container").data('count', data[0].count);

					$("#user_account .count_result").text(($("#user_account .page_number_container").data('in_disp_from') + 1) + '～' +  $("#user_account .page_number_container").data('in_disp_to') + '/全' + $("#user_account .page_number_container").data('count') + '件');

			}).fail(function(data){
					alert("Failed:" + data);
			}).complete(function(data){
					// Loadingイメージを消す
			});
	}

  $("#user_account .sort_content SELECT").change(function(){

			var index = $(this).parent().index();
			var count_query = 1;
			var val1 = $("#user_account .sort_content SELECT:nth(0)").val();
			var val2 = $("#user_account .sort_content SELECT:nth(1)").val();
			var val3 = $("#user_account .sort_content SELECT:nth(2)").val();
			var str1 = "", str2 = "";
			var date1 = "", date2 = "";
			var i = 1;

			$("#user_account .sort_content SELECT").prop("disabled", false);

			if(val1 && val2 && val3)
			{
					str1 = val1 + '.' + val2 + '.' + val3;
				  //alert("val1:" + val1 + " val2:" + val2 + " val3:" + val3);

					date1 = new Date(str1);
					date2 = new Date(str1);
					date2.setDate(date2.getDate() + 1);

					//date2.add(1).day();
					//alert("date1:" + date1);
					//alert("date1:" + date2);

					date1 = date1.getTime() / 1000;
					date2 = date2.getTime() / 1000;
			}
			else if((val1 && val2) && !val3)
			{
					if(parseInt(val2) == 12)
					{
							str1 = val1 + '.' + val2 + '.1';
							str2 = (parseInt(val1) + 1) + '.1.1';
					}
					else
					{
							str1 = val1 + '.' + val2 + '.1';
							str2 = val1 + '.' + (parseInt(val2) + 1) + '.1';
					}

					date1 = new Date(str1).getTime() / 1000;
					date2 = new Date(str2).getTime() / 1000;

			}
			else if(val1 && (!val2 && !val3))
			{
					str1 = val1 + '.1.1';
					str2 = (parseInt(val1) + 1) + '.1.1';

					date1 = new Date(str1).getTime() / 1000;
					date2 = new Date(str2).getTime() / 1000;
			}

			//alert("Date1:" + date1);
			//alert("Date2:" + date2);

			var search_category = 5;
			var in_disp_from = 0;
			var in_disp_to = in_disp_from + 25;
			var orderby = "write_date";
			var username = <?php echo json_encode($username); ?>;

			$("#user_account .page_number_container").data('in_disp_from', in_disp_from);
			$("#user_account .page_number_container").data('in_disp_to', in_disp_to);
			$('#user_account .pageitems').removeClass("selected");
			$('#user_account .pageitems:nth(0)').addClass("selected");

			$('#user_account .pageitems').each(function() {
					$(this).text(i);
					i++;
			});

			$("#user_account .page_number_container").data('write_date_from', date1);
			$("#user_account .page_number_container").data('write_date_to', date2);
			$(this).addClass("selected");
			//alert("showPos:" + showPos + " position:" + position);

			var data = "&count_query=" + count_query +
									"&category=" + search_category +
									"&from=" + $("#user_account .page_number_container").data('in_disp_from') +
									"&to="	 + $("#user_account .page_number_container").data('in_disp_to') +
									"&write_date_from=" + date1 +
									"&write_date_to="   + date2 +
									"&disp_max="  + $("#user_account .page_number_container").data('in_disp_max');

			//alert("data1:" + data);
			searchUser(data);
    });

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function searchNonda(data, bCount)
	{
		    //alert("searchNonda:" + data);
			$('#sake_nonda .image_progress').css({"display":"block"});

			$.ajax({
					type: "POST",
					url: "nonda_list.php",
					data: data,
					dataType: 'json',

			}).done(function(data){

				//alert("success:" + data);
				var count_result = data[0].count;
				var sake = data[0].result;

				//alert("count_result" + sake.length);
				//alert("sql:" + data[0].sql);
				$('#sake_nonda .image_progress').css({"display":"none"});

				if(sake.length > 0) {

					var path = "images/icons/noimage_user30.svg";

					$('#sake_nonda .review_result_sake_page').empty()

					for(var i = 0; i < sake.length; i++) {
						//////////////////////////////////////////////////////////////////////////////
						var innerHTML = '<div class="sake_nonda_container" data-sake_id=' + sake[i].sake_id;
								innerHTML += ' data-sake_name="' + sake[i].sake_name;
								innerHTML += '" data-sake_read="' + sake[i].sake_read;
								innerHTML += '" data-sakagura_name=' + sake[i].sakagura_name;
								innerHTML += ' data-pref=' + sake[i].pref;
								innerHTML += ' data-write_date=' + sake[i].write_date;
								innerHTML += ' data-update_date=' + sake[i].update_date;
								innerHTML += ' data-contributor=' + sake[i].contributor;
								innerHTML += ' data-subject="' + sake[i].subject;
								innerHTML += '" data-rank="' + sake[i].rank;
								innerHTML += '" data-message="' + sake[i].message;
								innerHTML += '" data-image_paths="' + sake[i].image_paths;
								innerHTML += '" data-tastes="' + sake[i].tastes;
								innerHTML += '" data-committed="' + sake[i].committed;
								innerHTML += '" data-flavor="' + sake[i].flavor;
								innerHTML += '" data-path="' + sake[i].path;
								innerHTML += '">';

							innerHTML += '<div class="user_info_container">';
								innerHTML += '<div class="user_image_container">';
									innerHTML += '<img src="' + path + '">';
								innerHTML += '</div>';

								innerHTML += '<div class="user_registration_container">';
									innerHTML += '<div class="user_name">' + sake[i].username + '</div>';
									innerHTML += '<div class="user_profile_date_container">';
										innerHTML += '<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>';
										innerHTML += '<div class="user_date">' + sake[i].local_time + '</div>';
									innerHTML += '</div>';
								innerHTML += '</div>';
							innerHTML += '</div>';

							innerHTML += '<div class="sake_info_container">';
								innerHTML += '<div class="sake_name">' + sake[i].sake_name + '</div>';
								innerHTML += '<div class="brewery_prefecture_name">' + sake[i].sakagura_name + ' / ' + sake[i].pref + '</div>';
							innerHTML += '</div>';
						innerHTML += '</div>';

						$('#sake_nonda .review_result_sake_page').append(innerHTML);
					}
				}
			}).fail(function(data){
				 alert("Failed:" + data);
				 $('#sake_nonda .image_progress').css({"display":"none"});
			}).complete(function(data){
				 //alert("complete");
				 $('#sake_nonda .image_progress').css({"display":"none"});
			});
	}

	$(document).on('click', '#sake_nonda .page_number_container .prev_page', function(e){

		  //alert("nonda prev_page");
			var search_type = 1;
			var in_disp_from = 0;
			var in_disp_to = 25;
			var position = $('#sake_nonda .pageitems.selected').index();
			var username = <?php echo json_encode($username); ?>;
			var orderby = 1;
			//alert("prev:" + $("#sake_nonda .page_number_container").data('in_disp_from'))

			if($("#sake_nonda .page_number_container").data('in_disp_from') >= $("#sake_edit .page_number_container").data('in_disp_max'))
			{
					if(position > 1)
					{
							//alert("position:" + position + " length:" + $('#sake_nomitai .pageitems').length);
							$('#sake_nonda .pageitems.selected.selected').removeClass("selected");
							$('#sake_nonda .pageitems:nth(' + (position - 2) + ')').addClass("selected");
					}
					else
					{
							var showPos = parseInt($('#sake_nonda .pageitems:nth(0)').text()) - 2;
							var i = 1;
							//alert("showPos:" + showPos + " pageitem:" + $('#sake_nonda .pageitems:nth(0)').text());

							$('#sake_nonda .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});
					}

					in_disp_from = $("#sake_nonda .page_number_container").data('in_disp_from') - $("#sake_nonda .page_number_container").data('in_disp_max');
					var in_disp_to = in_disp_from + $("#sake_nonda .page_number_container").data('in_disp_max');

					$("#sake_nonda .page_number_container").data('in_disp_from', in_disp_from);
					$("#sake_nonda .page_number_container").data('in_disp_to', in_disp_to);

					var data = "search_type=" + search_type +
											"&from=" + $("#sake_nonda .page_number_container").data('in_disp_from') +
											"&in_disp_to="	 + $("#sake_nonda .page_number_container").data('in_disp_max') +
											"&disp_max="  + $("#sake_nonda .page_number_container").data('in_disp_max') +
											"&orderby="  + orderby;

					//alert("sake_nonda:" + data);
					searchNonda(data, 1);
					$("#sake_nonda .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sake_nonda .page_number_container").data('count') + '件');
			}
	});

	$(document).on('click', '#sake_nonda .page_number_container .next_page', function(e){

			//alert("nonda next_page");
			var search_type = 1;
			//var in_disp_from = $("#sake_nonda .page_number_container").data('in_disp_from') + $("#sake_nonda .page_number_container").data('in_disp_max');
			var in_disp_from = $("#sake_nonda .page_number_container").data('in_disp_from') + $("#sake_nonda .page_number_container").data('in_disp_max');
			var in_disp_to = $("#sake_nonda .page_number_container").data('in_disp_to') + $("#sake_nonda .page_number_container").data('in_disp_max');
			var position = $('#sake_nonda .pageitems.selected').index();
			var username = <?php echo json_encode($username); ?>;
			var orderby = 1;
			//alert("position:" + position + " length:" + $('#sake_nonda .pageitems').length);

			if(in_disp_to < $("#sake_nonda .page_number_container").data('count'))
			{
					if(position < $('#sake_nonda .pageitems').length)
					{
							//alert("position:" + position + " length:" + $('#sake_nonda .pageitems').length);
							$('#sake_nonda .pageitems.selected.selected').removeClass("selected");
							$('#sake_nonda .pageitems:nth(' + position + ')').addClass("selected");
					}
					else
					{
							var showPos = parseInt($('#sake_nonda .pageitems:nth(0)').text());
							var i = 1;

							$('#sake_nonda .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});
					}

					$("#sake_nonda .page_number_container").data('in_disp_from', in_disp_from);
					$("#sake_nonda .page_number_container").data('in_disp_to', in_disp_to);

					var data = "search_type=" + search_type +
											"&from=" + $("#sake_nonda .page_number_container").data('in_disp_from') +
											"&in_disp_to="	 + $("#sake_nonda .page_number_container").data('in_disp_max') +
											"&disp_max="  + $("#sake_nonda .page_number_container").data('in_disp_max') +
											"&orderby="  + orderby;

					//alert("sake_nonda:" + data);
					searchNonda(data, 1);
					$("#sake_nonda .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sake_nonda .page_number_container").data('count') + '件');
			}
	});

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function searchSakagura(data)
	{
		//alert("searchSakagura data:" + data);

		$.ajax({
			type: "POST",
			url: "complex_search.php",
			data: data,
			dataType: 'json',

		}).done(function(data){
			var i = 0;
			var sakagura = data[0].result;
			var path = "images/icons/noimage_user30.svg";
			var username = <?php echo json_encode($username); ?>;

			$('#sakagura_edit .review_result_sake_page').empty();
			//alert("success:" + data[0].count);
			//alert("success:" + data[0].sql);
			//alert("sakagura:" + sakagura.length);

			for(i = 0; i < sakagura.length; i++)
			{
					var innerHTML = '<div class="brewery_registry_container" data-sakagura_id=' + sakagura[i].id + ' data-sakagura_name=' + sakagura[i].sakagura_name + '>';
						innerHTML += '<div class="user_info_container">';
							innerHTML += '<div class="user_image_container">';
								innerHTML += '<img src="' + path + '">';
							innerHTML += '</div>';

							innerHTML += '<div class="user_registration_container">';
								innerHTML += '<div class="user_name">' + username + '</div>';
								innerHTML += '<div class="user_profile_date_container">';
									innerHTML += '<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>';
									innerHTML += '<div class="user_date">' + sakagura[i].write_date + '</div>';
								innerHTML += '</div>';
							innerHTML += '</div>';
						innerHTML += '</div>';

						innerHTML += '<div class="brewery_info_container">';
							innerHTML += '<div class="brewery_name">' + sakagura[i].sakagura_name + '</div>';
							innerHTML += '<div class="brewery_prefecture_name">' + sakagura[i].pref + '</div>';
						innerHTML += '</div>';
					innerHTML += '</div>';

					$('#sakagura_edit .review_result_sake_page').append(innerHTML);
				}
			}).fail(function(data){
					alert("Failed:" + data);
			}).complete(function(data){
					// Loadingイメージを消す
			});
	}

	$(document).on('click', '#sakagura_edit .page_number_container .pageitems', function(e){

			var position = $(this).index();
			var showPos = parseInt($(this).text()) - 1;
			var count_query = 0;
			var search_category = 3;
			var in_disp_from = showPos * $("#sakagura_edit .page_number_container").data('in_disp_max');
			var in_disp_to = in_disp_from + 25;

			$("#sakagura_edit .page_number_container").data('in_disp_from', in_disp_from);
			$("#sakagura_edit .page_number_container").data('in_disp_to', in_disp_to);
			$('#sakagura_edit .pageitems').removeClass("selected");
			$(this).addClass("selected");
			//alert("showPos:" + showPos + " position:" + position);

			var data = "&count_query=" + count_query +
									"&category=" + search_category +
									"&from=" + $("#sakagura_edit .page_number_container").data('in_disp_from') +
									"&to=" + $("#sakagura_edit .page_number_container").data('in_disp_to') +
									"&in_disp_max="  + $("#sakagura_edit .page_number_container").data('in_disp_max');

			//alert("data:" + data);
			searchSakagura(data);
			$("#sakagura_edit .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sakagura_edit .page_number_container").data('count') + '件');
	});

	$(document).on('click', '#sakagura_edit .page_number_container .prev_page', function(e){

			//alert("sakagura next_page");
			var count_query = 0;
			var search_category = 3;
			var in_disp_from = $("#sakagura_edit .page_number_container").data('in_disp_from') + $("#sakagura_edit .page_number_container").data('in_disp_max');
			var in_disp_to = $("#sakagura_edit .page_number_container").data('in_disp_to') + $("#sakagura_edit .page_number_container").data('in_disp_max');
			var position = $('#sakagura_edit .pageitems.selected').index();

			if($("#sakagura_edit .page_number_container").data('in_disp_from') >= $("#sakagura_edit .page_number_container").data('in_disp_max')) {
					if(position > 1) {
						//alert("position:" + position + " length:" + $('#sakagura_edit .pageitems').length);
						$('#sakagura_edit .pageitems.selected.selected').removeClass("selected");
						$('#sakagura_edit .pageitems:nth(' + (position - 2) + ')').addClass("selected");
					}
					else {
						var showPos = parseInt($('#sakagura_edit .pageitems:nth(0)').text()) - 2;
						var i = 1;
						//alert("showPos:" + showPos + " pageitem:" + $('#sakagura_edit .pageitems:nth(0)').text());

						$('#sakagura_edit .pageitems').each(function() {
								$(this).text(showPos + i);
								i++;
						});
					}

					in_disp_from = $("#sakagura_edit .page_number_container").data('in_disp_from') - $("#sakagura_edit .page_number_container").data('in_disp_max');
					var in_disp_to = in_disp_from + $("#sakagura_edit .page_number_container").data('in_disp_max');

					$("#sakagura_edit .page_number_container").data('in_disp_from', in_disp_from);
					$("#sakagura_edit .page_number_container").data('in_disp_to', in_disp_to);

					var data = "&count_query=" + count_query +
											"&category=" + search_category +
											"&from=" + $("#sakagura_edit .page_number_container").data('in_disp_from') +
											"&to=" + $("#sakagura_edit .page_number_container").data('in_disp_to') +
											"&in_disp_max="  + $("#sakagura_edit .page_number_container").data('in_disp_max');

					//alert("search_sake:" + data);
					searchSakagura(data);
					$("#sakagura_edit .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sakagura_edit .page_number_container").data('count') + '件');
			}
	});

	$(document).on('click', '#sakagura_edit .page_number_container .next_page', function(e){

			//alert("sakagura next_page");
			var count_query = 0;
			var search_category = 3;
			var in_disp_from = $("#sakagura_edit .page_number_container").data('in_disp_from') + $("#sakagura_edit .page_number_container").data('in_disp_max');
			var in_disp_to = $("#sakagura_edit .page_number_container").data('in_disp_to') + $("#sakagura_edit .page_number_container").data('in_disp_max');
			var position = $('#sakagura_edit .pageitems.selected').index();

			in_disp_to = (in_disp_to > $("#sakagura_edit .page_number_container").data('count')) ? $("#sakagura_edit .page_number_container").data('count') : in_disp_to;

			//alert("position:" + position + " length:" + $('#sakagura_edit .pageitems').length);

			if(in_disp_from < $("#sakagura_edit .page_number_container").data('count'))
			{
					if(position < $('#sakagura_edit .pageitems').length)
					{
							//alert("position:" + position + " length:" + $('#sakagura_edit .pageitems').length);
							$('#sakagura_edit .pageitems.selected.selected').removeClass("selected");
							$('#sakagura_edit .pageitems:nth(' + position + ')').addClass("selected");
					}
					else
					{
							var showPos = parseInt($('#sakagura_edit .pageitems:nth(0)').text());
							var i = 1;

							$('#sakagura_edit .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});
					}

					$("#sakagura_edit .page_number_container").data('in_disp_from', in_disp_from);
					$("#sakagura_edit .page_number_container").data('in_disp_to', in_disp_to);

					var data = "&count_query=" + count_query +
											"&category=" + search_category +
											"&from=" + $("#sakagura_edit .page_number_container").data('in_disp_from') +
											"&to=" + $("#sakagura_edit .page_number_container").data('in_disp_to') +
											"&in_disp_max="  + $("#sakagura_edit .page_number_container").data('in_disp_max');

					//alert("search_sake:" + data);
					searchSakagura(data);
					$("#sakagura_edit .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sakagura_edit .page_number_container").data('count') + '件');
			}
	});

	$("#sakagura_edit .sort_content SELECT").change(function(){

			var index = $(this).parent().index();
		    var val1 = $("#sakagura_edit .sort_content SELECT:nth(0)").val();
			var val2 = $("#sakagura_edit .sort_content SELECT:nth(1)").val();
			var val3 = $("#sakagura_edit .sort_content SELECT:nth(2)").val();
			var str1 = "", str2 = "";
			var date1 = "", date2 = "";

		  $("#sakagura_edit .sort_content SELECT").prop("disabled", false);

			if(val1 && val2 && val3)
			{
					str1 = val1 + '.' + val2 + '.' + val3;
				  //alert("val1:" + val1 + " val2:" + val2 + " val3:" + val3);

					date1 = new Date(str1);
					date2 = new Date(str1);
					date2.setDate(date2.getDate() + 1);

					//date2.add(1).day();
					//alert("date1:" + date1);
					//alert("date1:" + date2);

					date1 = date1.getTime() / 1000;
					date2 = date2.getTime() / 1000;
			}
			else if((val1 && val2) && !val3)
			{
					if(parseInt(val2) == 12)
					{
							str1 = val1 + '.' + val2 + '.1';
							str2 = (parseInt(val1) + 1) + '.1.1';
					}
					else
					{
							str1 = val1 + '.' + val2 + '.1';
							str2 = val1 + '.' + (parseInt(val2) + 1) + '.1';
					}

					date1 = new Date(str1).getTime() / 1000;
					date2 = new Date(str2).getTime() / 1000;

			}
			else if(val1 && (!val2 && !val3))
			{
					str1 = val1 + '.1.1';
					str2 = (parseInt(val1) + 1) + '.1.1';

					date1 = new Date(str1).getTime() / 1000;
					date2 = new Date(str2).getTime() / 1000;
			}

			//alert("Date1:" + date1);
			//alert("Date2:" + date2);

			var position = $(this).index();
			var count_query = 0;
			var search_category = 3;
			var in_disp_from = 0;
			var in_disp_to = in_disp_from + 25;
			var i = 1;

			$("#sakagura_edit .page_number_container").data('in_disp_from', in_disp_from);
			$("#sakagura_edit .page_number_container").data('in_disp_to', in_disp_to);

			$("#sakagura_edit .page_number_container").data('write_date_from', date1);
			$("#sakagura_edit .page_number_container").data('write_date_to', date2);

			$('#sakagura_edit .pageitems').removeClass("selected");
			$('#sakagura_edit .pageitems:nth(0)').addClass("selected");

			$('#sakagura_edit .pageitems').each(function() {
					$(this).text(i);
					i++;
			});

			var data = "&count_query=" + count_query +
									"&category=" + search_category +
									"&write_date_from=" + date1 +
									"&write_date_to="   + date2 +
									"&from=" + $("#sakagura_edit .page_number_container").data('in_disp_from') +
									"&to=" + $("#sakagura_edit .page_number_container").data('in_disp_to') +
									"&in_disp_max="  + $("#sakagura_edit .page_number_container").data('in_disp_max');

			//alert("data:" + data);
			searchSakagura(data);
			$("#sakagura_edit .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sakagura_edit .page_number_container").data('count') + '件');
    });

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function searchFavoriteSakagura(data)
	{
		//alert("searchFavorite data:" + data);

		$.ajax({
				type: "POST",
				url: "ajax_favorite.php",
				data: data,
				dataType: 'json',

		}).done(function(data){

					var i = 0;
          var path = "images/icons/noimage_user30.svg";
					var username = <?php echo json_encode($username); ?>;
					var count_result = data[0].count;
					var sakagura = data[0].result;

					$('#sakagura_favorite .review_result_sake_page').empty();
					//alert("success");
					//alert("success:" + data[0].sql);
					//alert("data:" + data.length);

					if(sakagura != null) {
							//alert("count_result2:" + sakagura.length);

							for(i = 0; i < sakagura.length; i++)
							{
								var innerHTML = '<div class="brewery_registry_container" data-sakagura_id=' + sakagura[i].id + ' data-sakagura_name=' + sakagura[i].sakagura_name + '>';
									innerHTML += '<div class="user_info_container">';
										innerHTML += '<div class="user_image_container">';
											innerHTML += '<img src="' + path + '">';
										innerHTML += '</div>';

										innerHTML += '<div class="user_registration_container">';
											innerHTML += '<div class="user_name">' + username + '</div>';
											innerHTML += '<div class="user_profile_date_container">';
												innerHTML += '<div class="user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>';
												innerHTML += '<div class="user_date">' + sakagura[i].write_date + '</div>';
											innerHTML += '</div>';
										innerHTML += '</div>';
									innerHTML += '</div>';

									innerHTML += '<div class="brewery_info_container">';
										innerHTML += '<div class="brewery_name">' + sakagura[i].sakagura_name + '</div>';
										innerHTML += '<div class="brewery_prefecture_name">' + sakagura[i].pref + '</div>';
									innerHTML += '</div>';
								innerHTML += '</div>';

								$('#sakagura_favorite .review_result_sake_page').append(innerHTML);
						 }
					}

					if(count_result != null)
					{
							$("#sakagura_favorite .page_number_container").data('count', count_result);
							//alert("count:" + $("#sakagura_favorite .page_number_container").data('count'));
					}

					$("#sakagura_favorite .count_result").text(($("#sakagura_favorite .page_number_container").data('in_disp_from') + 1) + '～' +  $("#sakagura_favorite .page_number_container").data('in_disp_to') + '/全' + $("#sakagura_favorite .page_number_container").data('count') + '件');

					//alert("count_result3:" + sakagura.length);

			}).fail(function(data){
					alert("Failed:" + data);
			}).complete(function(data){
					// Loadingイメージを消す
			});
	}

	$(document).on('click', '#sakagura_favorite .page_number_container .pageitems', function(e){

			var position = $(this).index();
			var showPos = parseInt($(this).text()) - 1;
			var count_query = 0;
			var search_type = 2;
			var in_disp_from = showPos * $("#sakagura_edit .page_number_container").data('in_disp_max');
			var in_disp_to = in_disp_from + 25;

			$("#sakagura_favorite .page_number_container").data('in_disp_from', in_disp_from);
			$("#sakagura_favorite .page_number_container").data('in_disp_to', in_disp_to);
			$('#sakagura_favorite .pageitems').removeClass("selected");
			$(this).addClass("selected");
			//alert("showPos:" + showPos + " position:" + position);

			var data = "&count_query=" + count_query +
									"&search_type=" + search_type +
									"&from=" + $("#sakagura_favorite .page_number_container").data('in_disp_from') +
									"&to="	 + $("#sakagura_favorite .page_number_container").data('in_disp_to') +
									"&write_date_from=" + $("#sakagura_favorite .page_number_container").data('write_date_from') +
									"&write_date_to="  + $("#sakagura_favorite .page_number_container").data('write_date_to') +
									"&in_disp_max="  + $("#sakagura_favorite .page_number_container").data('in_disp_max');

			//alert("data:" + data);
			searchFavoriteSakagura(data);
			$("#sakagura_favorite .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sakagura_favorite .page_number_container").data('count') + '件');
	});

	$(document).on('click', '#sakagura_favorite .page_number_container .prev_page', function(e){

			//alert("sakagura next_page");
			var count_query = 0;
			var search_type = 2;
			var in_disp_from = $("#sakagura_favorite .page_number_container").data('in_disp_from') + $("#sakagura_favorite .page_number_container").data('in_disp_max');
			var in_disp_to = $("#sakagura_favorite .page_number_container").data('in_disp_to') + $("#sakagura_favorite .page_number_container").data('in_disp_max');
			var position = $('#sakagura_favorite .pageitems.selected').index();

			if($("#sakagura_favorite .page_number_container").data('in_disp_from') >= $("#sakagura_favorite .page_number_container").data('in_disp_max'))
			{
					if(position > 1)
					{
							//alert("position:" + position + " length:" + $('#sakagura_favorite .pageitems').length);
							$('#sakagura_favorite .pageitems.selected.selected').removeClass("selected");
							$('#sakagura_favorite .pageitems:nth(' + (position - 2) + ')').addClass("selected");
					}
					else
					{
								var showPos = parseInt($('#sakagura_favorite .pageitems:nth(0)').text()) - 2;
								var i = 1;
								//alert("showPos:" + showPos + " pageitem:" + $('#sakagura_favorite .pageitems:nth(0)').text());

								$('#sakagura_favorite .pageitems').each(function() {
										$(this).text(showPos + i);
										i++;
								});
					}

					in_disp_from = $("#sakagura_favorite .page_number_container").data('in_disp_from') - $("#sakagura_favorite .page_number_container").data('in_disp_max');
					var in_disp_to = in_disp_from + $("#sakagura_favorite .page_number_container").data('in_disp_max');

					$("#sakagura_favorite .page_number_container").data('in_disp_from', in_disp_from);
					$("#sakagura_favorite .page_number_container").data('in_disp_to', in_disp_to);

					var data = "&count_query=" + count_query +
											"&search_type=" + search_type +
											"&from=" + $("#sakagura_favorite .page_number_container").data('in_disp_from') +
											"&to="	 + $("#sakagura_favorite .page_number_container").data('in_disp_to') +
											"&write_date_from=" + $("#sakagura_favorite .page_number_container").data('write_date_from') +
											"&write_date_to="  + $("#sakagura_favorite .page_number_container").data('write_date_to') +
											"&in_disp_max="  + $("#sakagura_favorite .page_number_container").data('in_disp_max');

					//alert("search_sake:" + data);
					searchFavoriteSakagura(data);
					$("#sakagura_favorite .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sakagura_favorite .page_number_container").data('count') + '件');
			}
	});

	$(document).on('click', '#sakagura_favorite .page_number_container .next_page', function(e){

			//alert("sakagura next_page");
			var count_query = 0;
			var search_type = 2;
			var in_disp_from = $("#sakagura_favorite .page_number_container").data('in_disp_from') + $("#sakagura_favorite .page_number_container").data('in_disp_max');
			var in_disp_to = $("#sakagura_favorite .page_number_container").data('in_disp_to') + $("#sakagura_favorite .page_number_container").data('in_disp_max');
			var position = $('#sakagura_favorite .pageitems.selected').index();

			in_disp_to = (in_disp_to > $("#sakagura_favorite .page_number_container").data('count')) ? $("#sakagura_favorite .page_number_container").data('count') : in_disp_to;

			//alert("position:" + position + " length:" + $('#sakagura_favorite .pageitems').length);

			if(in_disp_from < $("#sakagura_favorite .page_number_container").data('count'))
			{
					if(position < $('#sakagura_favorite .pageitems').length)
					{
							//alert("position:" + position + " length:" + $('#sakagura_favorite .pageitems').length);
							$('#sakagura_favorite .pageitems.selected.selected').removeClass("selected");
							$('#sakagura_favorite .pageitems:nth(' + position + ')').addClass("selected");
					}
					else
					{
							var showPos = parseInt($('#sakagura_favorite .pageitems:nth(0)').text());
							var i = 1;

							$('#sakagura_favorite .pageitems').each(function() {
									$(this).text(showPos + i);
									i++;
							});
					}

					$("#sakagura_favorite .page_number_container").data('in_disp_from', in_disp_from);
					$("#sakagura_favorite .page_number_container").data('in_disp_to', in_disp_to);

					var data = "&count_query=" + count_query +
											"&search_type=" + search_type +
											"&from=" + $("#sakagura_favorite .page_number_container").data('in_disp_from') +
											"&to=" + $("#sakagura_favorite .page_number_container").data('in_disp_to') +
											"&write_date_from=" + $("#sakagura_favorite .page_number_container").data('write_date_from') +
											"&write_date_to="  + $("#sakagura_favorite .page_number_container").data('write_date_to') +
											"&in_disp_max="  + $("#sakagura_favorite .page_number_container").data('in_disp_max');

					//alert("search_sake:" + data);
					searchFavoriteSakagura(data);
					$("#sakagura_favorite .count_result").text((in_disp_from + 1) + '～' + in_disp_to + '/全' + $("#sakagura_favorite .page_number_container").data('count') + '件');
			}
	});

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$('#update_sake').click(function() {

			var sake_id = $('#sakedata').data('sake_id');
			var data = $('#form').serialize();
			var sake_category = "";

			data += "&sakagura_id=" + $("#dialog_sakagura_name").attr('sakagura_id');
			alert("data:" + data);

			/*
			$.ajax({
					type: "post",
					url: "sake_update.php?id=<?php print($_GET['sake_id']);?>",
					data: data,
			}).done(function(xml){

					str = $(xml).find("str").text();
					//alert("success:" + str);
					sql = $(xml).find("sql").text();
					//alert("sql:" + sql);

					if(str == "success")
					{
						//ajax_update_sake_data(xml);
						location.reload();
						return;
					}

			}).fail(function(data){
				alert("This is Error");
			});
			*/
	});

	$("#delete_sake").click(function() {

			var sake_id = $('#sakedata').data('sake_id');

			alert("sake_id:" + sake_id);

			if(confirm("削除しますか" + sake_id) == true)
			{
				var data = "sake_id="+sake_id;

				$.ajax({
					type: "post",
					url: "sake_dynamic_delete.php",
					data: data,
				}).done(function(xml){
					var str = $(xml).find("str").text();

					if(str == "success")
					{
							//var sakagura_id	= $("#sakagura_id").val();
							location.reload();
							return;
					}

				}).fail(function(data){
					var str = $(xml).find("str").text();
					alert("Failed:" +str);
				});
			}
	});
});


// 酒蔵追加・編集
$(function() {

  $(document).on('click', '#sakagura_edit .brewery_registry_container', function(){

			$('#sakagura_edit .sakagura_container').css({"display":"block"});
			$('#sakagura_edit_detail').css({"display":"flex"});
			$("body").trigger( "open_edit_sakagura", [ $(this).data('sakagura_id'), $(this).data('sakagura_name') ] );
	});

  $(document).on('click', '#sakagura_favorite .brewery_favorite_container', function(){

			$('#sakagura_favorite .sakagura_container').css({"display":"block"});
			$('#sakagura_favorite_detail').css({"display":"flex"});
			$("body").trigger( "open_edit_sakagura", [ $(this).data('sakagura_id'), $(this).data('sakagura_name') ] );
	});

	$('#sakagura_edit_prev2020').click(function() {
		$('#sakagura_edit_detail').css({"display":"none"});
	});

	$('#sakagura_favorite_prev2020').click(function() {
		$('#sakagura_favorite_detail').css({"display":"none"});
	});

    // 酒蔵追加
	$('#tab_users .add_new_sakagura').click(function() {
			$('.sakagura_container').css({"display": "flex"});
	});

  // 酒蔵検索
  $(document).on('keyup', '#tab_users .sakagura_input', function(){

    var inputText = $("#tab_users .sakagura_input").val();
    var count = inputText.length;
    var search_type = 2;
    var search_limit = 24;
    var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

    $("#tab_users .sakagura_content").css({"visibility": "hidden"})
    $("#tab_users .sakagura_content").empty();
		//alert("count:" + count);

	if(count >= 1) {
        $.ajax({
            type: "POST",
            url: "auto_complete.php",
						data: data,
            dataType: 'json',

        }).done(function(data){

            //alert("succeded:" + data + "length:" + data.length);
            $('.sake_content').empty();

            for(var i = 0; i < data.length; i++)
            {
                var retobj = $('#tab_users .sakagura_content').append('<li data-sakagura_id=' + data[i].sake_id + ' data-sakagura_name=' + data[i].sake_name + '><img src="images/icons/noimage80.svg">' + data[i].sake_name + '</li>');
            }

            if($("#tab_users .sakagura_input").val().length > 0)
                $("#tab_users .sakagura_content").css({"visibility": "visible"});

        }).fail(function(data){
            alert("Failed:" + data);
        });
    }
    else
    {
        $('#tab_users .sakagura_content').empty();
    }
  }); // keyup
});


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 酒編集
$(function() {

	$('#tab_users .edit_sake').click(function() {
			$('#tab_users .diplay_selection_button').removeClass('selected');
			$(this).addClass('selected');
			$('#tab_users .sake_container').css({"display":"none"});
			$('#tab_users .manage_sake_search_container').css({"display":"block"});
	});

	$('#tab_users .add_new_sake').click(function() {

			$('.diplay_selection_button').removeClass('selected');
			$(this).addClass('selected');
			$('.sake_container').css({"display":"flex"});
	});
});

$(function() {

	// ユーザー編集・追加
	$(function() {

		$('#edit_user').click(function() {
				$('#tab_users .diplay_selection_button').removeClass('selected');
				$(this).addClass('selected');
				$('#user_container').css({"display":"none"});
				$('#manage_users_search_container').css({"display":"block"});
		});

		$('#user_edit').click(function() {
				alert("user_edit");
		});

		$('#user_info').click(function() {
				//alert("user_info");
				$('#tab_users > div').css({"display": "none"});
				$('#tab_users .user_view').css({"display": "block"});
		});

		$('#add_new_user').click(function() {
				$('.diplay_selection_button').removeClass('selected');
				$(this).addClass('selected');
				$('#user_container').css({"display":"flex"});
		});
	});

	/////////////////////////////////////////////////////////////////////////////
  // ユーザー検索
  $(document).on('keyup', '#tab_users .user_input', function(){

    var inputText = $("#tab_users .user_input").val();
    var count = inputText.length;
    var search_type = 4;
    var search_limit = 24;
    var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;
		//alert("user input");

    $("#tab_users .user_content").css({"visibility": "hidden"})
    $("#tab_users .user_content").empty();

	if(count >= 1) {
        $.ajax({
            type: "POST",
            url: "complex_search.php",
						data: data,
            dataType: 'json',

        }).done(function(data){

            //alert("succeded:" + data + "length:" + data.length);
            $('.sake_content').empty();

            for(var i = 0; i < data.length; i++)
            {
                var retobj = $('#tab_users .user_content').append('<li data-username=' + data[i].username + ' data-lname=' + data[i].lname + ' data-fname=' + data[i].fname + '><img src="images/icons/noimage80.svg">' + data[i].username + '</li>');
            }

            if($("#tab_users .user_input").val().length > 0)
                $("#tab_users .user_content").css({"visibility": "visible"});

        }).fail(function(data){
            alert("Failed:" + data);
        });
    }
    else
    {
        $('#tab_users .user_content').empty();
    }
  }); // keyup

  $(document).on('click', '#tab_users .user_content li', function(){

			//alert("id:" + $(this).data('sakagura_id'));
			$('#manage_users_search_container').css({"display":"none"});
			$('#user_container').css({"display":"block"});
			$("body").trigger( "open_edit_user", [ $(this).data('username'), $(this).data('fname') ] );
	});
});

</script>
</html>
