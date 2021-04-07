<?php
require_once("manage_edit_sake.php");
require_once("db_functions.php");
require_once("html_disp.php");
?>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
</head>

<title>管理画面</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/sakenomuui.js"></script>
<script src="js/manage_edit_sake.js"></script>

<link rel="stylesheet" type="text/css" href="css/manage_view.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/manage_edit_sake.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />

<body>

	<?php

	include_once('images/icons/svg_sprite.svg');
	$username = $_GET['username'];
	$in_disp_from = 0;

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

		$db = opendatabase("sake.db");

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

	function displaySake()
	{
		print('<div class="manage_sake_search_container">');
				print('<div class="input_item">');
					print('<input class="sake_input" class="all_mode" autocomplete="off" placeholder="日本酒を検索" type="text" name="sake_name">');
				print('</div>');

				print('<ul class="sake_content"></ul>');
				print('<div id="sake_table" style="display:none"></div>');

				print('<div class="review_count_container">');
					print('<span id="disp_sake">'. ($in_disp_from + 1) .' ～ 25/全' .$count_result .'件</span>');
				print('</div>');

				print('<input type="hidden" id="in_disp_from" value=0>');
				print('<input type="hidden" id="count_sake" value=' .$count_result .'>');
				print('<input type="hidden" id="hidden_order_by" value="write_date">');
				print('<div id="review_result_sake_page"></div>');
		print('</div>');
	}

	function displaySakagura()
	{
		print('<div class="manage_sakagura_search_container">');
				print('<div class="input_item">');
					print('<input id="sakagura_input" class="all_mode" autocomplete="off" placeholder="酒蔵を検索" type="text" name="sakagura_name">');
				print('</div>');

				print('<ul id="sakagura_content"></ul>');
				print('<div id="sakagura_table" style="display:none"></div>');

				print('<div class="review_count_container">');
					print('<span id="disp_sakagura">'. ($in_disp_from + 1) .' ～ 25/全' .$count_result .'件</span>');
				print('</div>');

				print('<input type="hidden" id="in_disp_sakagura_from" value=0>');
				print('<input type="hidden" id="count_sakagura" value=' .$count_result .'>');
				print('<input type="hidden" id="hidden_sakagura_order_by" value="write_date">');
				print('<div id="review_result_sakagura_page"></div>');
		print('</div>');
	}

	function displayUsers()
	{
		print('<div id="manage_users_search_container">');
				print('<div class="input_item">');
					print('<input id="user_input" class="all_mode" autocomplete="off" placeholder="ユーザーを検索" type="text" name="user_name">');
				print('</div>');

				print('<ul id="user_content"></ul>');
				print('<div id="user_table" style="display:none"></div>');

				print('<div class="review_count_container">');
					print('<span id="disp_users">'. ($in_disp_from + 1) .' ～ 25/全' .$count_result .'件</span>');
				print('</div>');

				print('<input type="hidden" id="in_disp_users_from" value=0>');
				print('<input type="hidden" id="count_users" value=' .$count_result .'>');
				print('<input type="hidden" id="hidden_users_order_by" value="write_date">');
				print('<div id="review_result_users_page"></div>');
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
									print('<div class="column1">日本酒名</div>');
									print('<span>全角かな/半角英数字</span>');
								print('</div>');
								print('<div class="column2"><label><input id="sake_name" type="text" name="sake_name"></label></div>');
							print('</div>');

							print('<div class="row">');
								print('<div class="column1_container">');
									print('<div class="column1">ひらがな</div>');
									print('<span>全角かな</span>');
								print('</div>');
								print('<div class="column2"><label><input id="sake_read" type="text" name="sake_read"></label></div>');
							print('</div>');

							print('<div class="row">');
								print('<div class="column1_container">');
									print('<div class="column1">ローマ字</div>');
									print('<span>半角英数字</span>');
								print('</div>');
								print('<div class="column2"><label><input id="sake_english" type="text" name="sake_english"></label></div>');
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

	///////////////////////////////////////
	///////////////////////////////////////


	if(!$db = opendatabase("sake.db"))
	{
		die("データベース接続エラー .<br />");
	}

	$sql = "SELECT * FROM USERS_J WHERE username = '$username'";
	$res = executequery($db, $sql);
	$row = getnextrow($res);

	print('<div id="all_container">');

		print('<div id="main_banner_container">');

		//////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////
		print('<div id="banner">');
			//print('<div><span><svg class="logoheart14024"><use xlink:href="#logoheart14024"/></span></div>');

			print('<ul id="admin_menu" class="managemenu">');
					//print('<li><a href="#logo"><div><span class="managemenu_icon"><svg class="logoheart14024"><use xlink:href="#logoheart14024"/></span></div></a></li>');
					print('<li><a href="#sake_info"><div><span class="managemenu_icon"><svg width="10" height="10"><path d="M0 0 L10 5 L0 10 Z" style="fill:white"/></svg></span>日本酒ページ</div></a></li>');
					print('<li id="sake_info"><a href="#sake" class="active"><div>日本酒情報</div></a></li>');

					print('<li><a href="#sakagura_info"><div><span class="managemenu_icon"><svg width="10" height="10"><path d="M0 0 L10 5 L0 10 Z" style="fill:white"/></svg></span>酒蔵ページ</div></a></li>');
					print('<li id="sakagura_info"><a href="#sakagura"><div>酒蔵情報</div></a></li>');

					print('<li><a href="#comment"><div><span class="managemenu_icon"><svg width="10" height="10"><path d="M0 0 L10 5 L0 10 Z" style="fill:white"/></svg></span>その他</div></a></li>');
					print('<li><a href="#register"><div>お知らせ</div></a></li>');
					print('<li><a href="#follow"><div>メール</div></a></li>');
			print("</ul>");

			print('<ul id="user_menu" class="managemenu">');
					print('<li id="sake_info"><a href="#sake_info"><div><span class="managemenu_icon"><svg width="10" height="10"><path d="M0 0 L10 5 L0 10 Z" style="fill:white"/></svg></span>日本酒ページ</div></a></li>');
					print('<li><a href="#sake_edit" class="active"><div>日本酒ページ登録・編集</div></a></li>');
					print('<li><a href="#sake_nonda" class="active"><div>投稿・編集</div></a></li>');
					print('<li><a href="#sake_nomitai" class="active"><div>飲みたい</div></a></li>');
					print('<li><a href="#sake_iine" class="active"><div>いいね</div></a></li>');
					print('<li><a href="#sake_comment" class="active"><div>返信コメント登録・編集</div></a></li>');

					print('<li id="sakagura_info"><a href="#sake_info"><div><span class="managemenu_icon"><svg width="10" height="10"><path d="M0 0 L10 5 L0 10 Z" style="fill:white"/></svg></span>酒蔵ページ</div></a></li>');
					print('<li><a href="#sakagura_edit"><div>酒蔵ページ登録・編集</div></a></li>');
					print('<li><a href="#sakagura_photo"><div>コメント・写真登録・編集</div></a></li>');
					print('<li><a href="#sakagura_favorite"><div>お気に入り酒蔵</div></a></li>');
					print('<li><a href="#sakagura_comment"><div>いいね!</div></a></li>');

					print('<li><a href="#sake_info"><div><span class="managemenu_icon"><svg width="10" height="10"><path d="M0 0 L10 5 L0 10 Z" style="fill:white"/></svg></span>マイページ・その他</div></a></li>');
					print('<li id="user_info"><a href="#user_edit"><div>アカウント登録・編集</div></a></li>');
					print('<li><a href="#user_photo"><div>フォロー</div></a></li>');
					print('<li><a href="#user_favorite"><div>メッセージ</div></a></li>');
					print('<li><a href="#user_iine"><div>メール</div></a></li>');
			print("</ul>");

		print('</div>');

		//////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////

			print('<div id="container_wrapper">');

				print('<div id="table_wrapper">');

					if($row)
					{
						////////////////////////////////////////////////////////////////////////////////
						/*print('<div id="user_information">');
							$path = "images/icons/users.jpg";

							if($row["imagefile"])
							$path = "images/profile/" .$row["imagefile"];

							print('<img style="float:left; border-radius:4px; margin-left:4px; margin-right:4px; border:1px solid #e3e3e3; width:80px; height:auto;" src=' .$path .'>');

							print('<div style="overflow:auto; font-size:12px; border:0px solid #e3e3e3">');

								print('<div style="float:right; margin:2px"><button id="message_user" class="regular_button" style="width:42px; color:#404040; font-weight:bold">設定</button></div>');

								// ユーザー名
								print('<div id="profile_name" style="margin-left:8px; height:28px; margin:auto; font-size:11pt; font-weight:bold;\">' .$row["username"] .'</div>');

								// 住所
								print('<div style="margin-left:8px; height:28px; margin:auto; font-size:11pt; font-weight:bold;\">' .$row["pref"] .'</div>');

								// フォロー
								print('<div style="float:left; margin:2px"><span>フォロー</span><span>0</span></div>');
								print('<div style="float:left; margin:2px"><span>フォロワー</span><span>0</span></div>');

							print('</div>');

							print('<div style="overflow:auto; clear:both">');
								print('<button id="follow_user" class="regular_button" style="float:left; width:118px; color:#404040; font-weight:bold">フォローする</button>');
								print('<button id="trigger_user_message" class="regular_button" style="float:left; width:118px; color:#404040; font-weight:bold">メッセージを送る</button>');
							print('</div>');

						print("</div>");*/

						////////////////////////////////////////////////////////////////////////////////
						print('<div id="tab_main" class="tab_container" style="border: 2px solid #0000ff">');
							print('<ul class="simpleTabs">');
								print('<li><a href="#tab_admin" class="active"><span>管理者</span></a></li>');
								print('<li><a href="#tab_users"><span>一般ユーザー</span></a></li>');
								print('<li><a href="#tab_sakagura"><span>酒蔵</span></a></li>');
							print("</ul>");

							////////////////////////////////////////////////////////////////////////////////
							print('<!--/#sake.form-action-->');
							print('<div id="tab_admin" class="show">');

								// 酒編集
								print('<div class="sake_view">');
									print('<div class="diplay_selection">');
										print('<div class="edit_sake diplay_selection_button selected"><span>登録済み日本酒の編集</span></div>');
										print('<div class="add_new_sake diplay_selection_button"><span>新しい日本酒の登録</span></div>');
									print('</div>');

									writeSakeContainer("", "");
									displaySake();
								print("</div>");

								// 酒蔵編集
								print('<div id="sakagura_view">');
									print('<div class="diplay_selection">');
										print('<div id="edit_sakagura" class="diplay_selection_button selected"><span>登録済み酒蔵の編集</span></div>');
										print('<div id="add_new_sakagura" class="diplay_selection_button"><span>新しい酒蔵の登録</span></div>');
									print('</div>');

									include('manage_edit_sakagura.html');
									displaySakagura();
								print("</div>");

							///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

						print("</div>");

						////////////////////////////////////////////////////////////////////////////////
						print('<div id="tab_users" class="form-action hide" style="border: 2px solid #00ffff">');

							///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							// 酒編集
							print('<div class="sake_view">');
								print('<div class="diplay_selection">');
						  			print('<div class="edit_sake diplay_selection_button selected"><span>登録済み日本酒の編集</span></div>');
										print('<div class="add_new_sake diplay_selection_button"><span>新しい日本酒の登録</span></div>');
								print('</div>');

								writeSakeContainer("", "");
								displaySake();
							print("</div>");


							// 酒蔵編集
							/*
							print('<div class="sakagura_view">');
								print('<div class="diplay_selection">');
									print('<div class="edit_sakagura" class="diplay_selection_button selected"><span>登録済み酒蔵の編集</span></div>');
									print('<div class="add_new_sakagura" class="diplay_selection_button"><span>新しい酒蔵の登録</span></div>');
								print('</div>');

								include('manage_edit_sakagura.html');
								displaySakagura();
							print("</div>");
						  */

							///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							// ユーザー編集
							///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							print('<div class="user_view">');
								print('<div class="diplay_selection">');
									print('<div id="edit_user" class="diplay_selection_button selected"><span>登録済みユーザーの編集</span></div>');
								print('</div>');

								require_once("manage_edit_user.php");
								displayUsers();

							print("</div>");
							///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

						print("</div>");

						////////////////////////////////////////////////////////////////////////////////
						print("<!--/#sakagura.form-action-->");
							//print('<div id="tab_sakagura" border:4px solid #0000ff class="form-action hide">');
						print("</div>");

						print("</div>");
					}
					else
					{
						print("no data");
					}

				print("</div>");//table_wrapper
			print("</div>");//container_wrapper

		print("</div>");

	print("</div>");

	//print("<hr>");
	//print("<img src=\"drinksake.gif\" id=\"logoimage\" Title=\"Sake and Sakagura Listings\" alt=\"Sake and Sakagura Listings sakenomu.com\">");

	?>

</body>
<script type="text/javascript">

jQuery(document).ready(function($) {

	$('#admin_menu').css({"display":"block"});
	$('#dialog_edit_sake').css({"display":"none"});


//		alert("create tab");
	$('#tab_main').createTabs({
			text : $('#tab_main ul')
	});

	$('#cancel_user_button').click(function() {
			$("#dialog_addimage").css({"display":"none"});
	});

	$('.managemenu li').click(function() {
			$('.managemenu li').removeClass('selected');
			$(this).addClass('selected');
	});

});


$(function() {

  $("body").on( "edit_sake_close", function( event, obj) {
		$('#dialog_edit_sake').css({"display":"none"});
	});

	$('.simpleTabs a[href="#tab_admin"]').click(function() {
		  //alert('tab_admin click');
			$('.managemenu').css({"display": "none"});
			$('#admin_menu').css({"display": "block"});
	});

	$('.simpleTabs a[href="#tab_users"]').click(function() {
		  //alert('tab_users click');
			$('.managemenu').css({"display": "none"});
			$('#user_menu').css({"display": "block"});
		  $('.sake_container').css({"display":"none"});
	});

	$('.simpleTabs a[href="#tab_sakagura"]').click(function() {
		 //alert('tab_sakagura click');
	});

	$('#tab_admin .sake_view .add_new_sake').click(function() {
		$('#tab_admin .diplay_selection_button').removeClass('selected');
		$('.diplay_selection_button').removeClass('selected');
		$(this).addClass('selected');
		$('.sake_container').css({"display":"flex"});
	});

	$('#tab_admin .sake_view .edit_sake').click(function() {
		$('#tab_admin .diplay_selection_button').removeClass('selected');
		$(this).addClass('selected');
		$('.sake_container').css({"display":"none"});
		$('.manage_sake_search_container').css({"display":"block"});
	});

	$('#sake_info').click(function() {

		$('#sakagura_view').css({"display": "none"});
		$('#user_view').css({"display": "none"});
		$('#tab_admin .sake_view').css({"display": "block"});
		$('.sake_container').css({"display": "none"});
	});

	$('#sakagura_info').click(function() {

		$('.sake_container').css({"display": "none"});
		$('#tab_admin .sake_view').css({"display": "none"});
		$('#user_view').css({"display": "none"});
		$('#sakagura_container').css({"display": "none"});
		$('#sakagura_view').css({"display": "block"});
	});

	$('#user_info').click(function() {

		//alert("user_info");
		$('#tab_users .sake_view').css({"display": "none"});
		$('#tab_users .sakagura_view').css({"display": "none"});
		$('#tab_users .user_view').css({"display": "block"});
		$('#tab_users .sake_container').css({"display": "none"});
	});

	$('#add_new_sakagura').click(function() {
		 $('#sakagura_container').css({"display": "flex"});
	});

	$('#add_new_user').click(function() {
		$('.diplay_selection_button').removeClass('selected');
		$(this).addClass('selected');
		$('#user_container').css({"display":"flex"});
	});

	$('#edit_sakagura').click(function() {
		$('#edit_sakaggura .diplay_selection_button').removeClass('selected');
		$(this).addClass('selected');
		$('.manage_sakagura_search_container').css({"display":"block"});
		$('#sakagura_container').css({"display":"none"});

		$('#dialog_edit_sakagura').css({"display":"block"});
	});

	$('#trigger_user_message').click(function() {
		$('#mail_user').val($('#profile_name').text());
	});

	// Loadingイメージ表示関数
	function dispLoading(){
			 $("#loading").css({"visibility": "visible"});
	}

	// Loadingイメージ削除関数
	function removeLoading(){
			 $("#loading").css({"visibility": "hidden"});
	}
});


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

	$('#edit_user').click(function() {
		$('#tab_users .diplay_selection_button').removeClass('selected');
		$(this).addClass('selected');
		$('#user_container').css({"display":"none"});
		$('#manage_users_search_container').css({"display":"block"});
	});

	$('#user_edit').click(function() {
		alert("user_edit");

	});

});


$(function() {

	/////////////////////////////////////////////////////////////////////////////
  // 酒検索
  $(document).on('keyup', '.sake_input', function(){

    var inputText = $(this).val().replace(/　/g, ' ');
    var count = inputText.length;
    var search_type = 1;
    var search_limit = 24;
    var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;
		//var sake_content = $(this).parent().next('.sake_content');
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
						//alert("obj:" + obj);

            for(var i = 0; i < data.length; i++)
            {
                //var retobj = $('.sake_content').append('<li class="message_class" data-sake_id=' + data[i].sake_id + ' data-sake_name=' + data[i].sake_name + ' data-sakagura_name=' + data[i].sakagura_name + '><img src="images/icons/noimage80.svg">' + data[i].sake_name + '</li>');
								//$(retobj).data('sake_name', data[i].sake_name);
								sake_content.append('<li class="message_class" data-sake_id=' + data[i].sake_id + ' data-sake_name=' + data[i].sake_name + ' data-sakagura_name=' + data[i].sakagura_name + '><img src="images/icons/noimage80.svg">' + data[i].sake_name + '</li>');
						 }

            if($(".sake_input").val().length > 0)
                $(".sake_content").css({"visibility": "visible"});

        }).fail(function(data){
            alert("Failed:" + data);
        });
    }
    else
    {
        $('.sake_content').empty();
    }
  }); // keyup

  $('.message_class').click(function() {
      var sake_id = $(this).attr('sake_id');
      $(".sake_input").val(this.innerText);
      window.open('sake_view.php?sake_id=' + sake_id, '_self');
  });

  $(document).on('click', '.sake_content .message_class', function(){

			$('.manage_sake_search_container').css({"display":"none"});
			$('.sake_container').css({"display":"block"});
			$("body").trigger( "open_edit_sake", [ $(this).data('sake_id'), $(this).data('sake_name') ] );
	});
});


$(function() {

	/////////////////////////////////////////////////////////////////////////////
  // 酒蔵検索
  $(document).on('keyup', '#sakagura_input', function(){

    var inputText = $("#sakagura_input").val();
    var count = inputText.length;
    var search_type = 2;
    var search_limit = 24;
    var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

    $("#sakagura_content").css({"visibility": "hidden"})
    $("#sakagura_content").empty();
		//alert("count:" + count);

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
                var retobj = $('#sakagura_content').append('<li class="message_class" data-sakagura_id=' + data[i].sake_id + ' data-sakagura_name=' + data[i].sake_name + '><img src="images/icons/noimage80.svg">' + data[i].sake_name + '</li>');
            }

            if($("#sakagura_input").val().length > 0)
                $("#sakagura_content").css({"visibility": "visible"});

        }).fail(function(data){
            alert("Failed:" + data);
        });
    }
    else
    {
        $('#sakagura_content').empty();
    }
  }); // keyup

  $(document).on('click', '#sakagura_content .message_class', function(){

			//alert("sakagura:" + $(this).data('sakagura_name'));
			//alert("id:" + $(this).data('sakagura_id'));

			$('.manage_sakagura_search_container').css({"display":"none"});
			$('#sakagura_container').css({"display":"block"});

			$("body").trigger( "open_edit_sakagura", [ $(this).data('sakagura_id'), $(this).data('sakagura_name') ] );
	});
});


$(function() {

	/////////////////////////////////////////////////////////////////////////////
  // ユーザー検索
  $(document).on('keyup', '#user_input', function(){

    var inputText = $("#user_input").val();
    var count = inputText.length;
    var search_type = 4;
    var search_limit = 24;
    var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

    $("#user_content").css({"visibility": "hidden"})
    $("#user_content").empty();

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
                var retobj = $('#user_content').append('<li class="message_class" data-username=' + data[i].username + ' data-lname=' + data[i].lname + ' data-fname=' + data[i].fname + '><img src="images/icons/noimage80.svg">' + data[i].username + '</li>');
            }

            if($("#user_input").val().length > 0)
                $("#user_content").css({"visibility": "visible"});

        }).fail(function(data){
            alert("Failed:" + data);
        });
    }
    else
    {
        $('#user_content').empty();
    }
  }); // keyup

  $(document).on('click', '#user_content .message_class', function(){

			//alert("user:" + $(this).data('username'));
			//alert("id:" + $(this).data('sakagura_id'));

			$('#manage_users_search_container').css({"display":"none"});
			$('#user_container').css({"display":"block"});

			$("body").trigger( "open_edit_user", [ $(this).data('username'), $(this).data('fname') ] );
	});
});

</script>
</html>
