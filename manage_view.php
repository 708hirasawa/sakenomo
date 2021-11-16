<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("manage_edit_sake.php");
require_once("manage_edit_sakagura.php");
require_once("manage_edit_user.php");

function writePageNumberContainer($count_result)
{
	$i = 1;
	$p_max = 25;
	$numPage = (($count_result / $p_max) < 5) ? ($count_result / $p_max) : 5;

	print('<div class="page_number_container" data-in_disp_from = 0 data-in_disp_to=25 data-in_disp_max=25 data-write_date_from="" data-write_date_to="" data-count=' .$count_result .'>');
		print('<button class="prev_page">前の' .$p_max .'件</button>');
		print('<button class="pageitems selected">' .$i .'</button>');

		for($i++; $i <= $numPage; $i++)
		{
			 print('<button class="pageitems">' .$i .'</button>');
		}

		print('<button class="next_page" class="active">次の' .$p_max .'件</button>');
		print('<span class="image_progress" style="display:none"><img src="images/icons/gif-load.gif"></span>');

	print('</div>');
}

function displaySake()
{
	print('<div class="manage_sake_search_container">');
		print('<div class="input_item">');
			print('<input class="sake_input" class="all_mode" autocomplete="off" placeholder="日本酒を検索" type="text" name="sake_name">');
		print('</div>');

		print('<ul class="sake_content"></ul>');
		print('<div class="sake_table"></div>');

		print('<div class="review_count_container">');
			print('<span id="disp_sake">'. ($in_disp_from + 1) .' ～ 25/全' .$count_result .'件</span>');
		print('</div>');

		print('<div class="review_result_sake_page"></div>');
		writePageNumberContainer(100);

	print('</div>');
}

function displaySakagura()
{
	print('<div class="manage_sakagura_search_container">');
		print('<div class="input_item">');
			print('<input class="sakagura_input" class="all_mode" autocomplete="off" placeholder="酒蔵を検索" type="text" name="sakagura_name">');
		print('</div>');

		print('<div class="sakagura_content" data-from=0 data-count=0></div>');
		print('<div class="sakagura_table"></div>');

		print('<div class="review_count_container">');
			print('<span id="disp_sakagura">'. ($in_disp_from + 1) .' ～ 25/全' .$count_result .'件</span>');
		print('</div>');
		print('<div class="review_result_sakagura_page"></div>');
		writePageNumberContainer(100);

	print('</div>');
}

function displayUser()
{
	print('<div class="manageuser_search_container">');
		print('<div class="input_item">');
			print('<input class="user_input" class="all_mode" autocomplete="off" placeholder="ユーザーを検索" type="text" name="user_name">');
		print('</div>');

		print('<ul class="user_content"></ul>');
		print('<div class="user_table"></div>');

		print('<div class="review_count_container">');
			print('<span id="disp_sakagura">'. ($in_disp_from + 1) .' ～ 100/全' .$count_result .'件</span>');
		print('</div>');

		print('<div class="review_result_user_page"></div>');
	print('</div>');
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
<script src="js/sakenomuui.js?var=20170522" charset="Shift-JIS"></script>
<script src="js/manage_edit_sake.js?random=<?php echo uniqid(); ?>"></script>
<script src="js/manage_edit_sakagura.js?random=<?php echo uniqid(); ?>"></script>

<link rel="stylesheet" type="text/css" href="css/manage_view.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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

	if(!$db = opendatabase("sake.db")) {
		die("データベース接続エラー .<br />");
	}

	$sql = "SELECT * FROM USERS_J WHERE username = '$username' OR email = '$username'";
	$res = executequery($db, $sql);
	$row = getnextrow($res);

	if(!$row) {
		die("データベース接続エラー .<br />");
	}

	$usertype = $row['usertype'];

	print('<div id="all_container">');

		print('<div id="main_banner_container">');

			print('<div id="banner">');
				print('<div class="logo_box"><svg class="logoheartgray14024"><use xlink:href="#logoheartgray14024"/></div>');

			print('<ul id="admin_menu" class="managemenu">');
					print('<li id="sake_info">日本酒ページ</li>');
					print('<li><a href="#menu_item_sake" class="active"><div>日本酒情報</div></a></li>');
					print('<li id="sakagura_info">酒蔵ページ</li>');
					print('<li><a href="#menu_item_sakagura"><div>酒蔵情報</div></a></li>');
					print('<li id="sakagura_info">ユーザーページ</li>');
					print('<li><a href="#tab_user"><div>ユーザー情報</div></a></li>');
					print('<li id="other_info">その他</li>');
					print('<li><a href="#tab_register"><div>お知らせ</div></a></li>');
					print('<li><a href="#tab_follow"><div>メール</div></a></li>');
			print("</ul>");

			print("</div>"); // banner

			////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////
			print('<div id="container_wrapper" data-category=1>');
			print('<div id="table_wrapper">');

			if($row)
			{
					////////////////////////////////////////////////////////////////////////////////
					print('<div id="tab_main">');
						print('<ul class="simpleTabs">');
							print('<li><a href="#tab_admin" class="active"><span>管理者</span></a></li>');
							print('<li><a href="#tab_users"><span>一般ユーザー</span></a></li>');
							print('<li><a href="#tab_sakagura"><span>酒蔵</span></a></li>');
						print("</ul>");
					print('</div>');
					////////////////////////////////////////////////////////////////////////////////

					////////////////////////////////////////////////////////////////////////////////
					// 酒編集
					print('<div id="menu_item_sake" class="form-action show">');
						print('<div class="diplay_selection">');
							print('<div class="edit_sake diplay_selection_button selected"><span>登録済み日本酒の編集</span></div>');
							print('<div class="add_new_sake diplay_selection_button"><span>新しい日本酒の登録</span></div>');
						print('</div>');

						print('<div id="sake_edit_detail">');
							print('<div class="menu_title">日本酒情報</div>');
							print('<div id="sake_edit_prev2020"><svg class="return_button"><use xlink:href="#prev2020"/></svg>一覧へ戻る</div>');
							writeSakeContainer("", "");
						print("</div>");

						writeChooseSakagura();
						writeDialogAddSakeConfirm();

					displaySake();
					print("</div>");
					////////////////////////////////////////////////////////////////////////////////


					////////////////////////////////////////////////////////////////////////////////
					// 酒蔵編集
					print('<div id="menu_item_sakagura" class="form-action hide">');
						print('<div class="diplay_selection">');
							print('<div class="edit_sakagura diplay_selection_button selected"><span>登録済み酒蔵の編集</span></div>');
							print('<div class="add_new_sakagura diplay_selection_button"><span>新しい酒蔵の登録</span></div>');
						print('</div>');

						//writeSakaguraContainer("", "");

						print('<div id="sakagura_edit_detail">');
							print('<div class="menu_title">酒蔵情報</div>');
							print('<div id="sakagura_edit_prev2020"><svg class="return_button"><use xlink:href="#prev2020"/></svg>一覧へ戻る</div>');
							writeSakaguraContainer("", "");
							writeDialogAddSakaguraConfirm();
						print("</div>");

						displaySakagura();
					print("</div>");
					////////////////////////////////////////////////////////////////////////////////

					////////////////////////////////////////////////////////////////////////////////
					// ユーザー編集
					print('<div id="tab_user" class="form-action hide">');

						print('<div class="diplay_selection">');
							print('<div class="edit_user diplay_selection_button selected"><span>登録済みユーザーの編集</span></div>');
						print('</div>');

						print('<div id="user_profile_detail">');

							print('<div class="menu_title">ユーザー情報</div>');
							print('<div id="user_profile_prev2020"><svg class="return_button"><use xlink:href="#prev2020"/></svg>一覧へ戻る</div>');
							writeUserContainer();

						print("</div>");

						displayUser();
					print("</div>");
					////////////////////////////////////////////////////////////////////////////////
			}
			else
			{
				print("no data");
			}

		print("</div>"); // table_wrapper
		print("</div>"); // container_wrapper

		//////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////

	print("</div>"); // main_banner_container
	print("</div>"); // all_container

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

<script src="js/manage_edit_user.js?random=<?php echo uniqid(); ?>"></script>
<script type="text/javascript">

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

var rice_items = [
		  ["kokusanmai", "国産米", "こくさんまい"],
          ["yamadanishiki", "山田錦", "やまだにしき"],
          ["yamadaho", "山田穂", "やまだぼ"],
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
		  ["yamasakeyongo", "山酒4号（玉苗）", "やまさけよんごう（たまなえ）"],
          ["yuinoka", "結の香", "ゆいのか"],
          ["yumenoka", "夢の香", "ゆめのかおり"],
          ["wakamizu", "若水", "わかみず"],
          ["wataribune", "渡船", "わたりぶね"],
          ["other", "その他", "そのた"]];

function GetRiceString(rice_used) {

	var rice_array = rice_used.split('/');
	var rice_text = "";

	for(var i = 0; i < rice_array.length; i++) {
		var rice_entry = rice_array[i].split(',');

		rice_text += "<span>";

		for(var j = 0; j < rice_items.length; j++) {

			if(rice_entry[0] == rice_items[j][0]) {

				if(rice_entry[1] == "1") {
					rice_text += "麹米:";
				} else if(rice_entry[1] == "2") {
					rice_text += "掛米:";
				}

				if(rice_entry[0] == "other") {
					rice_text += (i == 0) ? rice_entry[3] : ' / ' + rice_entry[3];
					//rice_text += rice_entry[3];
				} else {
					//alert("rice_array[j]:" + rice_array[i]);
					rice_text += (i == 0) ? rice_items[j][1] : ' / ' + rice_items[j][1];
				}

				break;
			}
		}

		rice_text += "</span>";
	}

	return rice_text;
}


$(function() {

	var username = <?php echo json_encode($username); ?>;
	var usertype = <?php echo json_encode($usertype); ?>;

    if(!username || username == 'undefined' || usertype != 9) {
		$('#dialog_login').css('display', 'flex');
	}

	$(document).on('click','#dialog_login #login', function(){
	  var data = $("#form").serialize();
	  //alert("data:" + data);

	  $.ajax({
			type: "post",
			url: "cgi/user_login.php",
			data: data,
	  }).done(function(xml){
		  var str = $(xml).find("str").text();
		  var usertype = $(xml).find("usertype").text();

		  if(str == "success") {
			
			  //alert("usertype:" + usertype);

			  if(usertype == 9) {
					window.open('manage_view.php', '_self');
			  }
			  else {
					$("#login_message").text('管理画面へのアクセス権がありません');
			  }
		  }
		  else {
			  $("#login_message").text('パスワードが違います');
		  }
	  }).fail(function(data){
		  alert(str);
		  $("#login_message").text('This is Error');
	  });
	});
});


//$in_disp_from = 0;
//$in_disp_to = ($count_result < 25) ? $count_result : 25;
//print('<div class="count_result">' .($in_disp_from + 1) .'～' .$in_disp_to .'/全'.$count_result.'件</div>');
//writePageNumberContainer($count_result);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function($) {

	$('#menu_item_sake .sakedata').createAutoKana({
		sakagura_name : $('#menu_item_sake input[name="sake_name"]'),
		sakagura_read : $('#menu_item_sake input[name="sake_read"]'),
		sakagura_english : $('#menu_item_sake input[name="sake_english"]')
	});

	$('#menu_item_sakagura .sakagura_container').createAutoKana({
		sakagura_name :  $('#menu_item_sakagura input[name="sakagura_name"]'),
		sakagura_read :  $('#menu_item_sakagura input[name="sakagura_read"]'),
		sakagura_english :  $('#menu_item_sakagura input[name="sakagura_english"]')
	});

	$('#admin_menu').css({"display":"block"});

	$('.managemenu li').click(function() {
		$('.managemenu li').removeClass('selected');
		$(this).addClass('selected');
	});

	$('.simpleTabs a[href="#tab_users"]').click(function() {
		window.open("manage_user_view.php", '_self');
	});

	$('#main_banner_container').createTabs({
		text : $('#admin_menu')
	});
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 酒検索
$(function() {

	function searchSake(data, bCount) 
	{
		//alert("data:" + data);

        $.ajax({
            type: "POST",
            url: "cgi/complex_search.php",
			data: data,
            dataType: 'json',

        }).done(function(data){

			var sake = data[0].result;
			var count = data[0].count;
			var sql = data[0].sql;

			//alert("sql:" + sql);
            //alert("succeded:" + data + "length:" + sake.length);

            $('#menu_item_sake .sake_content').empty();

            for(var i = 0; i < sake.length; i++)
            {
				var innerHTML = "";
				//$('#menu_item_sake .sake_content').append('<li data-sake_id=' + sake[i].sake_id + ' data-sake_name=' + sake[i].sake_name + ' data-sakagura_name=' + sake[i].sakagura_name + '><img src="' + sake[i].filename + '">' + sake[i].sake_name + '</li>');

				////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					var path = sake[i].filename;
					innerHTML = '<div class="searchRow_link" data-sake_id=' + sake[i].sake_id + ' data-sake_name=' + sake[i].sake_name + ' data-sakagura_name=' + sake[i].sakagura_name + '>';

					innerHTML += '<div class="search_result_name_container">';

							innerHTML += '<div class="search_result_sake_image"><img id="' + path + '" src="' + path + '"></div>';
							innerHTML += '<div class="search_result_sake_brewery_date_container">';
									innerHTML += '<div class="search_result_sake">' + sake[i].sake_name + '</div>';
									innerHTML += '<div class="search_result_brewery_date_container">';
											innerHTML += '<div class="search_result_brewery">' + sake[i].sakagura_name + ' / ' + sake[i].pref + '</div>';
											innerHTML += '<div class="search_result_date">' + sake[i].write_date + '</div>';
									innerHTML += '</div>';
							innerHTML += '</div>';

					innerHTML += '</div>';

					// 酒ランク ////////////////////////////////////////////////
					var rank_width = (sake[i].sake_rank / 5) * 100 + '%';

					innerHTML += '<div class="search_result_rank">';
						innerHTML += '<div class="search_result_star_rating">';
							innerHTML += '<div class="search_result_star_rating_front" style="width: ' + rank_width + '">★★★★★</div>';
							innerHTML += '<div class="search_result_star_rating_back">★★★★★</div>';
						innerHTML += '</div>';

						if(sake[i].sake_rank) {
							innerHTML += '<span class="search_result_sake_rate">' + sake[i].sake_rank.toFixed(1) + '</span>';
						} else {
							innerHTML += '<span class="search_result_sake_rate" style="color: #b2b2b2;">--</span>';
						}

					innerHTML += '</div>';

					// スペック ////////////////////////////////////////////////////////////////////////////////////////////////
					innerHTML += '<div class="spec">';
							innerHTML += '<div class="spec_item">';
							innerHTML += '<div class="spec_title"><svg class="spec_item_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg>特定名称</div>';
							innerHTML += '<div class="spec_info">';

									if(sake[i].special_name && sake[i].special_name != "") {
										innerHTML += sake[i].special_name;
									} else {
										innerHTML += '<span style="color: #b2b2b2;">--</span>';
									}

							innerHTML += '</div>'; // spec_info
							innerHTML += '</div>'; // spec_item

							/////////////////////////////////////////////////
							innerHTML += '<div class="spec_item">' + '<div class="spec_title"><svg class="spec_item_alc1616"><use xlink:href="#alc1616"/></svg>Alc度数</div>' + '<div class="spec_info">';

								if(sake[i].alcohol_level != 'undefined' && sake[i].alcohol_level != null && sake[i].alcohol_level != "") {
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

							innerHTML += '</div>'; // spec_info
							innerHTML += '</div>'; // spec_item


							innerHTML += '<div class="spec_item">';
							innerHTML += '<div class="spec_title"><svg class="spec_item_rice1616"><use xlink:href="#rice1616"/></svg>原料米</div>';
							innerHTML += '<div class="spec_info">';

								if(sake[i].rice_used != null && sake[i].rice_used != "") {
									innerHTML += GetRiceString(sake[i].rice_used);
								} else {
									innerHTML += '<span style="color: #b2b2b2;">--</span>';
								}

							innerHTML += '</div>'; // spec_info
							innerHTML += '</div>'; // spec_item

							/////////////////////////////////////////////////
							innerHTML += '<div class="spec_item">';
							innerHTML += '<div class="spec_title"><svg class="spec_item_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg>精米歩合</div>';
							innerHTML += '<div class="spec_info">';

								if(sake[i].seimai_rate && sake[i].seimai_rate != 'undefined' && sake[i].seimai_rate != "") {
									var seimai_array = sake[i].seimai_rate.split(',');
									var rice_array = [];

									if(sake[i].rice_used && sake[i].rice_used != "") {
										rice_array = sake[i].rice_used.split('/');
									}

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

							innerHTML += '</div>'; // spec_info
							innerHTML += '</div>'; // spec_item

							/////////////////////////////////////////////////
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

							innerHTML += '</div>'; // spec_info
							innerHTML += '</div>'; // spec_item

					innerHTML += '</div>'; // spec

					innerHTML += '</div>'; // searchRow_link
					///////////////////////////////////////////////////////////////////////////

					$('#menu_item_sake .sake_content').append(innerHTML);
			}

            if($("#menu_item_sake .sake_input").val().length > 0)
                $("#menu_item_sake .sake_content").css({"visibility": "visible"});

        }).fail(function(data){
            alert("Failed:" + data);
        });
	}

	$("body").on("search_sake", function(event, data, bCount) {
			$("#menu_item_sake .sake_content").css({"visibility": "visible"})
			searchSake(data, bCount);
	});

	$(document).on('keyup', '.sake_input', function(){

		var inputText = $(this).val().replace(/　/g, ' ');
		var count = inputText.length;
		var search_type = 2;
		var from = 0;
		var to = 25;
		var data = "category=" + search_type + "from=" + from + "&to=" + to + "&search_text=" + inputText  + "&keyword=" + inputText;

		$("#menu_item_sake .sake_content").css({"visibility": "hidden"})
		$("#menu_item_sake .sake_content").empty();

		//alert("data:" + data);

		if(count >= 1)
		{
			searchSake(data);
		}
		else
		{
			$('#menu_item_sake .sake_content').empty();
		}
	}); // keyup

	$(document).on('click', '.add_sakagura_content li', function(){
		alert("click add_sakagura_content li");

		$(window).off('touchmove.noscroll');
		$('html, body').css('overflow', '');
		$("#dialog_add_sakagura_background").css({"display":"none"});

		$('input[name="sakagura_name"]').val($(this).data('sakagura_name'));
		$('input[name="sakagura_id"]').val($(this).data('sakagura_id'));
	});

	$(document).on('click', '#menu_item_sake .searchRow_link', function(){

		$('.sake_container').css({"display":"block"});
		$('#sake_edit_detail').css({"display":"flex"});
		$('input[name="submit_button"]').css({"display":"none"});
		$('input[name="update_button"]').css({"display":"block"});

		$("body").trigger( "open_edit_sake", [ $(this).data('sake_id'), $(this).data('sake_name') ] );
		//alert("sake_id:" +  $(this).data('sake_id') + " sake_nake:" + $(this).data('sake_name'));

        $('input[name="submit_button"]').css({"display":"none"});
	});

	$(document).on('click', '#menu_item_sake .prev_page', function(){

		alert("prev_sake_page");
	});

	$(document).on('click', '#menu_item_sake .next_page', function(){

		alert("next_sake_page");
	});

	$('#sake_edit_prev2020').click(function() {
		$('#sake_edit_detail').css({"display":"none"});
	});

	$('#menu_item_sake input[name="button_back"]').click(function() {
		$('.dialog_add_sake_background').css({"display":"none"});
	});

	$('#menu_item_sake input[name="submit_button"]').click(function() {

	    var data = $('#menu_item_sake .form').serialize();

		//alert("input special_name:" + $('#menu_item_sake input[name="special_name"]:checked').val());
		//alert("input special_name:" + $('#menu_item_sake input[name="special_name"]:checked').parent().text())

		//alert("data:" + data);

		$.ajax({
				type: "post",
				url: "cgi/sake_add.php",
				data: data,
		}).done(function(xml){
				var str = $(xml).find("str").text();

				if(str == "success")
				{
					var sake_id = $(xml).find("sake_id").text();
					var sake_name = $(xml).find("sake_name").text();
					var sql = $(xml).find("sql").text();
					//alert("SQL:" + sql);
					alert("sake_id:" + sake_id + "を追加しました");
					//alert($('input[name="sake_name"]').val() + "を追加しました");
					//window.open('sake_view.php?sake_id=' + sake_id, '_self');
					$("#menu_item_sake .dialog_add_sake_background").css({"display":"none"});
					$('#sake_edit_detail').css({"display":"none"});
				}
				else
				{
					$("#sample1").text(str);
				}
		 }).fail(function(data){
				alert("This is Error");
				//$("#sample1").text('This is Error');
		});
	});

	$('#menu_item_sake input[name="update_button"]').click(function() {

			var sake_id = $('#menu_item_sake .sakedata').data('sake_id');
			var sake_name = $('input[name="sake_name"]').val();
			//var sakagura_id = $('#menu_item_sake .sakedata').data('sakagura_id');
			//alert("sakagura_id:" + sakagura_id);
			//alert("sake_id:" + sake_id);

			var data = $('#menu_item_sake .form').serialize() + "&sake_id=" + $('#menu_item_sake .sakedata').data('sake_id');

			//alert("sake_id:" + sake_id + " sakagura_id:" + $('#menu_item_sake .sakedata').data('sakagura_id') + " data:" + data);
			//alert("update data:" + data);

			$.ajax({
					type: "post",
					url: "cgi/sake_update.php?id=" + sake_id,
					data: data,
			}).done(function(xml){

					str = $(xml).find("str").text();
					sql = $(xml).find("sql").text();
					//alert("sql:" + sql);

					if(str == "success")
					{
						alert("success:" + sake_name + "を更新しました");
						location.reload();
						return;
					}

			}).fail(function(data){
				 alert("This is Error");
			});
	});

	$('input[name="delete_sake"]').click(function() {

			var sake_id = $('#menu_item_sake .sakedata').data('sake_id');
			var sake_name = $('input[name="sake_name"]').val();

			//alert("sake_id:" + sake_id);

			if(confirm("" + sake_name + "を削除しますか") == true)
			{
				var data = "sake_id="+sake_id;
				alert("sake data:" + data);

				$.ajax({
					type: "post",
					url: "cgi/sake_delete.php",
					data: data,
				}).done(function(xml){

					var str = $(xml).find("str").text();
			
					alert("return:" + str);

					if(str == "success")
					{
						//var sakagura_id	= $("#menu_item_sakagura_id").val();
						//location.reload();
						$("#menu_item_sake  .dialog_add_sake_background").css({"display":"none"});
						$('#sake_edit_detail').css({"display":"none"});
						$('.sake_content').empty();
						$('.sake_input').val('');
					}

				}).fail(function(data){
					var str = $(xml).find("str").text();
					alert("Failed:" +str);
				});
			}
	});
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 酒蔵追加・編集
$(function() {

	$('#menu_item_sakagura_info').click(function() {
		$('.view_container').css({"display": "none"});
	});

	// 酒蔵追加
	$('#menu_item_sakagura .add_new_sakagura').click(function() {

		//alert("add sake");
		$('#menu_item_sakagura .diplay_selection_button').removeClass('selected');
		$(this).addClass('selected');

		$('#menu_item_sakagura input[name="sakagura_confirm"]').css({"display":"block"});
		$('#menu_item_sakagura input[name="update_sakagura"]').css({"display":"none"});
		$('#menu_item_sakagura input[name="delete_sakagura"]').css({"display":"none"});

		$('#menu_item_sakagura .sakagura_container').css({"display":"block"});
		$('#menu_item_sakagura .sakagura_container input[type="text"]').val('');

		$('#sakagura_edit_detail').css({"display":"flex"});
	});

	$('#menu_item_sakagura .edit_sakagura').click(function() {

		$('#menu_item_sakagura .diplay_selection_button').removeClass('selected');
		$(this).addClass('selected');

		var category = 3;
		var from = 0;
		var count_query = 1;

		var orderby = "date_updated DESC";
		//var data = "category=" + category + "&from=" + from + "&count_query=" + count_query + "&orderby=" + orderby;
		var data = "category=" + category + "&from=" + from + "&count_query=" + count_query + "&orderby=" + orderby;

		$("body").trigger("search_sakagura", [ data, true ] );
		$('.manage_sakagura_search_container').css({"display":"block"});
	});

	function searchSakagura(data, bCount) 
	{
		$.ajax({
			type: "POST",
			url: "cgi/complex_search.php",
			data: data,
			dataType: 'json',

		}).done(function(data){

			var sakagura = data[0].result;
			var count = data[0].count;
			var sql = data[0].sql;

			//alert("succeded:" + data + "length:" + data.length);
			$('#menu_item_sake .sake_content').empty();

			$('#menu_item_sakagura .sakagura_content').data('count', count);

			for(var i = 0; i < sakagura.length; i++)
			{
				//var retobj = $('#menu_item_sakagura .sakagura_content').append('<li data-sakagura_id=' + sakagura[i].id + ' data-sakagura_name=' + sakagura[i].sake_name + '><img src="images/icons/noimage80.svg">' + sakagura[i].sakagura_name + '\t' + sakagura[i].write_date + '</li>');
				var innerHTML = '<div class="sakaguraRow_link" href="sda_view.php?id=' + sakagura[i].id + '">';

				/////////////////////////////////////////////////////////////////////////////
				innerHTML += '<div class="search_sakagura_result_name_container">';
					/*一時的に非表示innerHTML += '<div class="search_sakagura_result_brewery_image"><img id="' + sakagura[i].filename + '" src="' + sakagura[i].filename + '"></div>';*/

					innerHTML += '<div class="search_sakagura_result_brewery_pref_date_container">';
						innerHTML += '<div class="search_sakagura_result_brewery">' + sakagura[i].sakagura_name + '</div>';
						innerHTML += '<div class="search_sakagura_result_pref_date_container">';
							innerHTML += '<div class="search_sakagura_result_pref">' + sakagura[i].pref + ' ' + sakagura[i].address + '</div>';
							innerHTML += '<div class="search_sakagura_result_date">' + sakagura[i].write_date + '</div>';
						innerHTML += '</div>';
					innerHTML += '</div>';

				innerHTML += '</div>';
				/////////////////////////////////////////////////////////////////////////////

				innerHTML += '<div class="sakagura_spec">';

					/////////////////////////////////////////////////
					innerHTML += '<div class="sakagura_spec_item">';
					innerHTML += '<span class="sakagura_spec_title"><svg class="spec_item_bottle1616"><use xlink:href="#bottle1616"/></svg>代表銘柄</span>';
					innerHTML += '<span class="sakagura_spec_info">';
						if(sakagura[i].brand)
							innerHTML += sakagura[i].brand;
						else
							innerHTML += '<span style="color: #b2b2b2;">--</span>';
					innerHTML += '</span>';
					innerHTML += '</div>';

					/////////////////////////////////////////////////
					innerHTML += '<div class="sakagura_spec_item">';
					innerHTML += '<span class="sakagura_spec_title"><svg class="spec_item_visit1616"><use xlink:href="#visit1616"/></svg>酒蔵見学</span>';
					innerHTML += '<span class="sakagura_spec_info">';
						if(sakagura[i].observation == 1)
							innerHTML += '可';
						else if(sakagura[i].observation == 2)
							innerHTML += '不可';
						else
							innerHTML += '<span style="color: #b2b2b2">--</span>';
					innerHTML += '</span>';
					innerHTML += '</div>';

					/////////////////////////////////////////////////
					innerHTML += '<div class="sakagura_spec_item">';
					innerHTML += '<span class="sakagura_spec_title"><svg class="spec_item_kurashop1616"><use xlink:href="#kurashop1616"/></svg>酒蔵直販店</span>';
					innerHTML += '<span class="sakagura_spec_info">';
						if(sakagura[i].direct_sale == 1)
							innerHTML += 'あり';
						else if(sakagura[i].direct_sale == 2)
							innerHTML += 'なし';
						else
							innerHTML += '<span style="color: #b2b2b2">--</span>';
					innerHTML += '</span>';
					innerHTML += '</div>';
					/////////////////////////////////////////////////

				innerHTML += '</div>'; // sakaguraspec
				innerHTML += '</div>'; // sakaguraRow_link

				var retobj = $('#menu_item_sakagura .sakagura_content').append(innerHTML);
			}

			if($("#menu_item_sakagura .sakagura_input").val().length > 0)
				$("#menu_item_sakagura .sakagura_content").css({"visibility": "visible"});

		}).fail(function(data){
			alert("Failed:" + data);
		});
	}

	$("body").on("search_sakagura", function(event, data, bCount) {

		$("#menu_item_sakagura .sakagura_content").css({"visibility": "visible"})
		searchSakagura(data, true);
	});

	$(document).on('click', '#menu_item_sakagura .prev_page', function() {

		//alert("prev_page");

		if(parseInt($('.sakagura_content').data('from')) >= 25) {

			var p_max = 25;
			var in_disp_to = parseInt($('.sakagura_content').data('from'));
			var in_disp_from = in_disp_to - p_max;
			var data = "category=" + category + "&from=" + from + "&count_query=" + count_query + "&orderby=" + orderby;
			
			searchSakagura(data, in_disp_from, in_disp_to, 0);
		}
	});

	$(document).on('click', '#menu_item_sakagura .next_page', function(){

		var p_max = 25;

		if((parseInt($('.sakagura_content').data('from')) + 25) < parseInt($('.sakagura_content').data('count'))) {

			alert("next_page");

			var in_disp_from = parseInt($('.sakagura_content').data('from')) + 25;
			var in_disp_to = in_disp_from + p_max;
			var data = "category=" + category + "&from=" + from + "&count_query=" + count_query + "&orderby=" + orderby;

			searchSakagura(data, in_disp_from, in_disp_to, 0);
		}
	});

	// 酒蔵検索
	$(document).on('keyup', '#menu_item_sakagura .sakagura_input', function() {

		var inputText = $("#menu_item_sakagura .sakagura_input").val();
		var count = inputText.length;
		var category = 3;
		var from = 0;
		var data = "category=" + category + "&from=" + from + "&search_text=" + inputText;

		$("#menu_item_sakagura .sakagura_content").css({"visibility": "hidden"})
		$("#menu_item_sakagura .sakagura_content").empty();
		//alert("count:" + count);

		if(count >= 1) {
			searchSakagura(data, true);
		}
		else
		{
			$('#menu_item_sakagura .sakagura_content').empty();
		}
	}); // keyup

	$(document).on('click', '#menu_item_sakagura .sakaguraRow_link', function(){

		//$('#sakagura_container').css({"display":"flex"});
		//$('#sakagura_confirm').css({"display":"none"});

		$('#menu_item_sakagura input[name="update_sakagura"]').css({"display":"block"});
		$('#menu_item_sakagura input[name="delete_sakagura"]').css({"display":"block"});
		$('#menu_item_sakagura input[name="sakagura_confirm"]').css({"display":"none"});

		$(".dialog-confirm").css({"display":"none"});
		$('#menu_item_sakagura .sakagura_container').css({"display": "block"});
		//$('#sakagura_container').css({"display":"block"});
		$('#sakagura_edit_detail').css({"display":"flex"});
		$("body").trigger( "open_edit_sakagura", [ $(this).data('sakagura_id'), $(this).data('sakagura_name') ] );
	});

	$('#menu_item_sakagura input[name="close_sakagura"]').click(function() {
		$('#sakagura_edit_detail').css({"display":"none"});
	});

	$('#menu_item_sakagura input[name="delete_sakagura"]').click(function() {

		var sakagura_id = $('.sakagura_container').data('sakagura_id');
		var sakagura_name = $('input[name="sakagura_name"]').val();

		if(confirm("削除しますか:" + sakagura_id) == true)
		{
			var data = "id="+sakagura_id;

			$.ajax({
					type: "post",
					url: "cgi/sda_delete.php?id=" + sakagura_id,
					data: data,
			}).done(function(xml){
				var str = $(xml).find("str").text();

				if(str == "success")
				{
					alert("酒蔵を削除しました:" + $(xml).find("sql").text());
					$("#menu_item_sakagura .sakagura_content").empty();
					$('#sakagura_edit_detail').css({"display":"none"});
				}

			}).fail(function(data){
					var str = $(xml).find("str").text();
					alert("Failed:" +str);
			});
		} // confirm
	});

	$('#sakagura_edit_prev2020').click(function() {
			$('#sakagura_edit_detail').css({"display":"none"});
	});

	$('#menu_item_sakagura input[name="button_back"]').click(function() {

			$('.dialog_add_sake_background').css({"display":"none"});
	});

	$('input[name="sakagura_confirm"]').click(function() {

			$('#menu_item_sakagura .dialog_sakagura_name').text($('#menu_item_sakagura input[name="sakagura_name"]').val());
			$('#menu_item_sakagura .dialog_sakagura_read').text($('#menu_item_sakagura input[name="sakagura_read"]').val());
			$('#menu_item_sakagura .dialog_sakagura_english').text($('#menu_item_sakagura input[name="sakagura_english"]').val());
			$('#menu_item_sakagura .dialog_sakagura_search').text($('#menu_item_sakagura input[name="sakagura_search[]"]').val());
			$('#menu_item_sakagura .dialog_postal_code').text($('#menu_item_sakagura input[name="postal_code"]').val());
			$('#menu_item_sakagura .dialog_sakagura_pref').text($('#menu_item_sakagura select[name="pref"] option:selected').val());
			$('#menu_item_sakagura .dialog_address').text($('#menu_item_sakagura input[name="address"]').val());
			$('#menu_item_sakagura .dialog_phone').text($('#menu_item_sakagura input[name="phone"]').val());
			$('#menu_item_sakagura .dialog_fax').text($('#menu_item_sakagura input[name="fax"]').val());
			$('#menu_item_sakagura .dialog_url').text($('#menu_item_sakagura input[name="url"]').val());
			$('#menu_item_sakagura .dialog_email').text($('#menu_item_sakagura input[name="email"]').val());
			$('#menu_item_sakagura .dialog_representative').text($('#menu_item_sakagura input[name="representative"]').val());
			$('#menu_item_sakagura .dialog_touji').text($('#menu_item_sakagura input[name="touji"]').val());
			$('#menu_item_sakagura .dialog_establishment').text($('#menu_item_sakagura select[name="establishment"] option:selected').val());
			$('#menu_item_sakagura .dialog_brand').text($('#menu_item_sakagura input[name="brand"]').val());
			$('#menu_item_sakagura .dialog_payment_method').text($('#menu_item_sakagura input[name="payment_method"]').val());
			$('#menu_item_sakagura .dialog_memo').text($('#menu_item_sakagura textarea[name="memo"]').text());

			var touch_start_y;
			// タッチしたとき開始位置を保存しておく
			$(window).on('touchstart', function(event) {
				touch_start_y = event.originalEvent.changedTouches[0].screenY;
			});
			// スワイプしているとき
			$(window).on('touchmove.noscroll', function(event) {
				var current_y = event.originalEvent.changedTouches[0].screenY,
				height = $('.dialog_add_sakagura_background').outerHeight(),
				is_top = touch_start_y <= current_y && $('.dialog_add_sakagura_background')[0].scrollTop === 0,
				is_bottom = touch_start_y >= current_y && $('.dialog_add_sakagura_background')[0].scrollHeight - $('.dialog_add_sakagura_background')[0].scrollTop === height;

				// スクロール対応モーダルの上端または下端のとき
				if(is_top || is_bottom) {
					// スクロール禁止
					event.preventDefault();
				}
			});

			// スクロール禁止
			$('html, body').css('overflow', 'hidden');
			$('#menu_item_sakagura .dialog-confirm').css({"display":"flex"});
	});

	$('input[name="update_sakagura"]').click(function() {

			var sakagura_id = $('#menu_item_sakagura .sakagura_container').data('sakagura_id');
			var data = $('#menu_item_sakagura .sakagura_form').serialize();

			data += "&sakagura_id=" + $('#menu_item_sakagura .sakagura_container').data('sakagura_id');
			//alert("sakagura_id:" + sakagura_id);
			//alert("update data:" + data);

			$.ajax({
					type: "post",
					url: "cgi/sakagura_update.php?id=" + sakagura_id,
					data: data,
			}).done(function(xml){

					str = $(xml).find("str").text();
					sql = $(xml).find("sql").text();

					//alert("success:" + str);
					//alert("sql:" + sql);

					if(str == "success")
					{
						 $("#menu_item_sakagura .sakagura_content").empty();
						 location.reload();
						 return;
					}

			}).fail(function(data){
				 alert("This is Error");
			});
	});

	$('.edit_sakagura_button_container .submit_button').click(function() {
		//$('.dialog-confirm').css({"display":"none"});
		var data = $('#menu_item_sakagura .sakagura_form').serialize();
		//alert("data:" + data);

		$.ajax({
			type: "post",
			url: "cgi/sda_add.php",
			data: data,
		}).done(function(xml){
			var str = $(xml).find("str").text();

			if(str == "success")
			{
				var id = $(xml).find("id").text();
				alert("succeeded id:" + id);

				$("#menu_item_sakagura .sakagura_content").empty();
				$("#dialog_add_sakagura_background").css({"display":"none"});
				$('#sakagura_edit_detail').css({"display":"none"});
				//$("#dialog_add_sake_background").css({"display":"flex"});
			}
			else
			{
				alert("insert failed:" + str);
				//$("#sample1").text(str);
			}
		}).fail(function(data){
				alert("This is Error");
		});
	});
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ユーザー編集
$(function() {

  function searchUser(data) {

	$.ajax({
		type: "POST",
		url: "cgi/auto_complete.php",
		data: data,
		dataType: 'json',

	}).done(function(data){

		//alert("succeded");
		//alert("succeded:" + data ); //+ "length:" + data.length);
		$('#tab_user .user_content').empty();

		for(var i = 0; i < data.length; i++)
		{
			var retobj = $('#tab_user .user_content').append('<li data-username=' + data[i].username + ' data-fname=' + data[i].fname + ' data-email=' + data[i].email + '><img src="' + data[i].profile_image + '">' + data[i].username + '\t' + data[i].email + '\t' + data[i].added_date +'</li>');
		}

		if($("#tab_user .user_input").val().length > 0)
			$("#tab_user .user_content").css({"visibility": "visible"});

	}).fail(function(data){
		alert("Failed:" + data);
	});

  }

  // ユーザー検索
  $(document).on('keyup', '#tab_user .user_input', function(){

		var inputText = $("#tab_user .user_input").val();
		var count = inputText.length;
		var search_type = 4;
		var search_limit = 100;
		var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

		$("#tab_user .user_content").css({"visibility": "hidden"})
		$("#tab_user .user_content").empty();
		//alert("count:" + count);
		//alert("data:" + data);

		if(count >= 1) {
			searchUser(data);
		}
		else {
			$('#tab_user .user_content').empty();
		}
    }); // keyup

    $(document).on('click', '#tab_user .user_content li', function(){

		$('#user_container').css({"display":"block"});
		$('#user_profile_detail').css({"display":"flex"});

		//alert('username:' + $(this).data('username'));
		$("body").trigger( "open_edit_user", [ $(this).data('username'), $(this).data('fname') ] );

	});

	$('#user_profile_prev2020').click(function() {
		$('#user_profile_detail').css({"display":"none"});
	});

	$('#delete_user').click(function() {
		//alert("delete user clicked:" + $('#user_name_input_argument').val());

		var username = $('#user_name_input_argument').val();
		var val = $('#main_container').serialize();

		if(confirm("" + username + "を削除してもいいですか？") == true)
		{
			var data = "username=" + $('#user_name_input_argument').val();

			$.ajax({
				type: "POST",
				url: "cgi/user_delete.php",
				data: data,
			}).done(function(xml){

				var str = $(xml).find("str").text();
				//alert("succeeded");

				if(str == "success")
				{
					alert("ユーザー" + username +"を削除しました");
					$('#user_profile_detail').css({"display":"none"});
					$("#tab_user .user_input").val('');
					$("#tab_user .user_content").empty();
					//$("#follow").text(str);
					//$(obj).closest('div').fadeOut();
				}

			}).fail(function(data){
					alert("Failed:" + data);
			});
		}
	});

	// user
	$('#admin_menu li:nth(5)').click(function() {
		var search_type = 4;
		var search_limit = 100;
		var data = "search_type=" + search_type + "&search_limit=" + search_limit;

		$('#disp_sakagura').text('1 ～ ' + search_limit + '件表示');

		//alert("data:" + data);
		searchUser(data);
	});
});


// 酒追加・編集
$(function() {

	$('#menu_item_sake_info').click(function() {

			$('.view_container').css({"display": "none"});
			$('.sake_view').css({"display": "block"});
	});

	$('#menu_item_sake .add_new_sake').click(function() {

			$('#menu_item_sake .diplay_selection_button').removeClass('selected');
			$(this).addClass('selected');

			/* 登録画面ボタン 初期設定 */
			$('#menu_item_sake input[name="cancel_sake"]').css({"display":"block"});
			$('#menu_item_sake input[name="confirm_button"]').css({"display":"block"});
			$('#menu_item_sake input[name="delete_sake"]').css({"display":"none"});

			/* 確認画面ボタン　初期設定 */
			$('input[name="submit_button"]').css({"display":"block"});
			$('input[name="update_button"]').css({"display":"none"});

		    /* 入力画面表示 */
			$('#menu_item_sake .sake_container').css({"display":"block"});
			$('#sake_edit_detail').css({"display":"flex"});
	});

	$('#menu_item_sake .edit_sake').click(function() {

			$('#menu_item_sake .diplay_selection_button').removeClass('selected');
			$(this).addClass('selected');

			/* 登録画面ボタン 初期設定 */
			$('#menu_item_sake input[name="cancel_sake"]').css({"display":"block"});
			$('#menu_item_sake input[name="confirm_button"]').css({"display":"block"});
			$('#menu_item_sake input[name="delete_sake"]').css({"display":"block"});

			/* 確認画面ボタン　初期設定 */
			$('input[name="submit_button"]').css({"display":"none"});
			$('input[name="update_button"]').css({"display":"block"});

		    /* 検索窓表示 */
			$('.sake_container').css({"display":"none"});
			$('.manage_sake_search_container').css({"display":"block"});
		
			//////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////
			var inputText = '';
			var count = 0;
			var search_type = 2;
			var from = 0;
			var to = 25;
			//var data = "category=" + search_type + "from=" + from + "&to=" + to + "&search_text=" + inputText  + "&keyword=" + inputText;
			var data = "category=" + search_type + "&from=" + from + "&to=" + to + "&orderby=write_update";

			$("body").trigger("search_sake", [ data, true ] );
	});

	$('#menu_item_sake input[name="cancel_sake"]').click(function() {

		//alert("close sake");
		$('#sake_edit_detail').css({"display":"none"});
	});
});


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

</script>
</html>

