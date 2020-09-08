<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("manage_edit_sake.php");
require_once("manage_edit_sakagura.php");
require_once("manage_edit_user.php");

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
				print('<span id="disp_sakagura">'. ($in_disp_from + 1) .' ～ 25/全' .$count_result .'件</span>');
			print('</div>');

			print('<div class="review_result_sakagura_page"></div>');
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
				print('<span id="disp_sakagura">'. ($in_disp_from + 1) .' ～ 25/全' .$count_result .'件</span>');
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

			print('<div id="container_wrapper">');
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
			  window.open('manage_view.php', '_self');
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
	});

	$('#menu_item_sake input[name="cancel_sake"]').click(function() {

		//alert("close sake");
		$('#sake_edit_detail').css({"display":"none"});
	});
});

// 酒検索
$(function() {

  $(document).on('keyup', '.sake_input', function(){

    var inputText = $(this).val().replace(/　/g, ' ');
    var count = inputText.length;
    var search_type = 1;
    var search_limit = 25;
    var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

    $("#menu_item_sake .sake_content").css({"visibility": "hidden"})
    $("#menu_item_sake .sake_content").empty();

	if(count >= 1)
    {
        $.ajax({
            type: "POST",
            url: "auto_complete.php",
						data: data,
            dataType: 'json',

        }).done(function(data){

            //alert("succeded:" + data + "length:" + data.length);
            $('#menu_item_sake .sake_content').empty();

            for(var i = 0; i < data.length; i++)
            {
				$('#menu_item_sake .sake_content').append('<li data-sake_id=' + data[i].sake_id + ' data-sake_name=' + data[i].sake_name + ' data-sakagura_name=' + data[i].sakagura_name + '><img src="images/icons/noimage80.svg">' + data[i].sake_name + '</li>');
			}

            if($("#menu_item_sake .sake_input").val().length > 0)
                $("#menu_item_sake .sake_content").css({"visibility": "visible"});

        }).fail(function(data){
            alert("Failed:" + data);
        });
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

		//alert("value:" + $(this).val());
		//$('.add_sakagura_content').append('<li class="message_class" data-sakagura_id="' + data[i].sake_id + '"><span style="width:28px"><img style="height:28px; width:auto;" src="' + data[i].filename + '"></span><span style="margin-left:4px">' + data[i].sake_name + '</span><span style="margin-left:8px">' + data[i].pref + '</span></li>');
		//alert("data1:" + $('input[name="sakagura_name"]').val());
		//alert("data:" + $(this).data('sakagura_id') + " sakagura_name:" + $(this).data('sakagura_name'));

		$('input[name="sakagura_name"]').val($(this).data('sakagura_name'));
		$('input[name="sakagura_id"]').val($(this).data('sakagura_id'));
	});

  $(document).on('click', '#menu_item_sake .sake_content li', function(){

		$('.sake_container').css({"display":"block"});
		$('#sake_edit_detail').css({"display":"flex"});
		$('input[name="submit_button"]').css({"display":"none"});
		$('input[name="update_button"]').css({"display":"block"});

		$("body").trigger( "open_edit_sake", [ $(this).data('sake_id'), $(this).data('sake_name') ] );
        $('input[name="submit_button"]').css({"display":"none"});
	});

	$('#sake_edit_prev2020').click(function() {

		$('#sake_edit_detail').css({"display":"none"});
	});

	$('#menu_item_sake input[name="button_back"]').click(function() {

			$('.dialog_add_sake_background').css({"display":"none"});
	});

	$('#menu_item_sake input[name="submit_button"]').click(function(){

	    var data = $('#menu_item_sake .form').serialize();

		//alert("input special_name:" + $('#menu_item_sake input[name="special_name"]:checked').val());
		//alert("input special_name:" + $('#menu_item_sake input[name="special_name"]:checked').parent().text())

		//alert("data:" + data);

		$.ajax({
				type: "post",
				url: "sake_add.php",
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
					url: "sake_update.php?id=" + sake_id,
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

				$.ajax({
					type: "post",
					url: "sake_dynamic_delete.php",
					data: data,
				}).done(function(xml){
					var str = $(xml).find("str").text();

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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		$('.manage_sakagura_search_container').css({"display":"block"});
	});

	// 酒蔵検索
	$(document).on('keyup', '#menu_item_sakagura .sakagura_input', function() {

		var inputText = $("#menu_item_sakagura .sakagura_input").val();
		var count = inputText.length;
		var search_type = 2;
		var search_limit = 24;
		var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

		$("#menu_item_sakagura .sakagura_content").css({"visibility": "hidden"})
		$("#menu_item_sakagura .sakagura_content").empty();
		//alert("count:" + count);

		if(count >= 1) {
			$.ajax({
				type: "POST",
				url: "auto_complete.php",
				data: data,
				dataType: 'json',

			}).done(function(data){

				//alert("succeded:" + data + "length:" + data.length);
				$('#menu_item_sake .sake_content').empty();

				for(var i = 0; i < data.length; i++)
				{
					var retobj = $('#menu_item_sakagura .sakagura_content').append('<li data-sakagura_id=' + data[i].sake_id + ' data-sakagura_name=' + data[i].sake_name + '><img src="images/icons/noimage80.svg">' + data[i].sake_name + '</li>');
				}

				if($("#menu_item_sakagura .sakagura_input").val().length > 0)
					$("#menu_item_sakagura .sakagura_content").css({"visibility": "visible"});

			}).fail(function(data){
				alert("Failed:" + data);
			});
		}
		else
		{
			$('#menu_item_sakagura .sakagura_content').empty();
		}
	}); // keyup

	$(document).on('click', '#menu_item_sakagura .sakagura_content li', function(){

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
							url: "sda_dynamic_delete.php?id=" + sakagura_id,
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
					url: "sakagura_update.php?id=" + sakagura_id,
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
			url: "sda_add.php",
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

  // ユーザー検索
  $(document).on('keyup', '#tab_user .user_input', function(){

		var inputText = $("#tab_user .user_input").val();
		var count = inputText.length;
		var search_type = 4;
		var search_limit = 24;
		var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

		$("#tab_user .user_content").css({"visibility": "hidden"})
		$("#tab_user .user_content").empty();
		//alert("count:" + count);
		//alert("data:" + data);

		if(count >= 1)
		{
			$.ajax({
				type: "POST",
				url: "auto_complete.php",
				data: data,
				dataType: 'json',

			}).done(function(data){

				//alert("succeded");
				//alert("succeded:" + data ); //+ "length:" + data.length);
				$('#tab_user .user_content').empty();

				for(var i = 0; i < data.length; i++)
				{
					var retobj = $('#tab_user .user_content').append('<li data-username=' + data[i].username + ' data-fname=' + data[i].fname + ' data-email=' + data[i].email + '><img src="images/icons/noimage80.svg">' + data[i].username + '</li>');
				}

				if($("#tab_user .user_input").val().length > 0)
					$("#tab_user .user_content").css({"visibility": "visible"});

			}).fail(function(data){
				alert("Failed:" + data);
			});
		}
		else
		{
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
							url: "user_delete.php",
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
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

</script>
</html>
