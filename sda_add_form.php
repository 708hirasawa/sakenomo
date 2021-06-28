<?php
require_once("html_disp.php");
require_once("manage_edit_sakagura.php");
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
<title>Sakenomo</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/manage_edit_sakagura.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/manage_edit_sakagura.js?random=<?php echo uniqid(); ?>"></script>
</head>

<body>

  <?php
	include_once('images/icons/svg_sprite.svg');
	write_side_menu();
	write_HamburgerLogo();
	write_search_bar();
	write_Nonda();

	$sakagura_id = $_GET['id'];
	$sakagura_name = $_GET['sakagura_name'];

	print('<div id="container">');
	writeSakaguraContainer();
	writeDialogAddSakaguraConfirm();
	print('</div>'); // container

	writefooter();
  ?>

</body>

<script type="text/javascript">

$(function() {

   $('#container input[name="sakagura_confirm"]').click(function() {

		var error_message = "";

		if($('input[name="sakagura_name"]').val() == "") {
			error_message += "酒蔵名を入力してください\n";
		}

		if($('select[name="pref"]').val() == "") {
			error_message += "都道府県を入力してください\n";
		}

		if(error_message != "") {
			alert("エラー\n" + error_message);
		}
		else {
			$('.dialog_sakagura_name').text($('input[name="sakagura_name"]').val());
			$('.dialog_sakagura_read').text($('input[name="sakagura_read"]').val());
			$('.dialog_sakagura_english').text($('input[name="sakagura_english"]').val());

			var sakagura_search_text = "";

			$('input[name="sakagura_search[]"]').each(function() {
				//alert("sakagura_search:" + $(this).val());
			
				if(sakagura_search_text != "")
					sakagura_search_text += ",";

				sakagura_search_text += $(this).val();
			});

			$('.dialog_sakagura_search').text(sakagura_search_text);
			$('.dialog_postal_code').text($('input[name="postal_code"]').val());
			$('.dialog_sakagura_pref').text($('select[name="pref"] option:selected').val());
			$('.dialog_address').text($('input[name="address"]').val());
			$('.dialog_phone').text($('input[name="phone"]').val());
			$('.dialog_fax').text($('input[name="fax"]').val());
			$('.dialog_url').text($('input[name="url"]').val());
			$('.dialog_email').text($('input[name="email"]').val());
			$('.dialog_representative').text($('input[name="representative"]').val());
			$('.dialog_touji').text($('input[name="touji"]').val());

			if($('select[name="establishment"] option:selected').val() == 9999) {
				$('.dialog_establishment').text('その他:' + $('input[name="other_year"]').val());
			}
			else {
				$('.dialog_establishment').text($('select[name="establishment"] option:selected').val());
			}

			$('.dialog_brand').text($('input[name="brand"]').val());
			$('.dialog_payment_method').text($('input[name="payment_method"]').val());
			$('.dialog_award_history').text($('textarea[name="award_history"]').val());
			$('.dialog_observatory_info').text($('textarea[name="observatory_info"]').val());
			$('.dialog_observation').text($('select[name="observation"] option:selected').text());
			//$('.dialog_memo').text($('textarea[name="memo"]').val());

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
			$('.dialog_add_sakagura_background').css({"display":"flex"});
		}
	});

	/////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////

	$('.sakagura_wrapper input[name="postal_code"]').jpostal({
		postcode : [
			'.sakagura_wrapper input[name="postal_code"]',
		],
		address : {
			'.sakagura_wrapper input[name="pref"]'		  : '%3',
			'.sakagura_wrapper input[name="address"]'     : '%4%5',
			'.sakagura_wrapper input[name="pref_read"]'   : '%8%9%10'
		}
	});

	// alert('postal_code:' + $('.sakagura_wrapper input[name="postal_code"]'));
	/////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////

	$('#container input[name="close_sakagura"]').click(function(){
		window.history.back();
	});

	$('#container .button_back').click(function() {
		$('.dialog_add_sakagura_background').css({"display":"none"});
	});

	$('#container input[name="update_sakagura"]').click(function() {

			var sakagura_id = <?php echo json_encode($sakagura_id); ?>;
			var data = $('#container .sakagura_form').serialize();

			data += "&sakagura_id=" + $('#container .sakagura_container').data('sakagura_id');
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
						window.open('sda_view.php?id=' + sakagura_id, '_self');
						return;
					}

			}).fail(function(data){
				 alert("This is Error");
			});
	});

	$('.submit_button').click(function() {

		var data = $('.sakagura_form').serialize();
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
				//alert("id:" + id);
				window.open('sda_view.php?id=' + id, '_self');
			}
			else
			{
				alert("insert failed:" + str);
			}
		}).fail(function(data){
			alert("This is Error");
		});
	});

	$('.sakagura_wrapper input[name="postal_code"], input[name="phone"], input[name="fax"], input[name="url"], input[name="email"]').change(function(){
		  var txt = $(this).val();
		  var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
		  $(this).val(han);
	});

	$('.sakagura_wrapper select[name="establishment"]').change(function(){

		if($('.sakagura_wrapper select[name="establishment"]').val() == 9999)
		{
			if($('input[name="other_year"]').prop("disabled") == true)
			{
				$('input[name="other_year"]').prop('disabled', false);
			}
		}
		else
		{
			$('input[name="other_year"]').prop('disabled', true);
		}

		return true;
	});
});

jQuery(document).ready(function($) {

    $("body").wrapInner('<div id="wrapper"></div>');
	$('.sakagura_container').css({"display":"flex"});

	var sakagura_id = <?php echo json_encode($sakagura_id); ?>;
	var sakagura_name = <?php echo json_encode($sakagura_name); ?>;

	$("body").wrapInner('<div id="wrapper"></div>');

	$('#container .sake_container').css({"display":"flex"});

	if(sakagura_id && sakagura_id != "")
	{
		//$('#container input[name="update_sakagura"]').css({"display":"block"});

		$('#container input[name="close_sakagura"]').css({"display":"block"});
		$('#container input[name="sakagura_confirm"]').css({"display":"block"});

		$('#container input[name="delete_sakagura"]').css({"display":"none"}); /* 削除ボタンは表示しない */
		$('#container input[name="submit_sakagura"]').css({"display":"none"}); /* 新規登録ボタンは表示しない */

		//alert("trigger:" + sakagura_id + " " + sakagura_name);
		$("body").trigger( "open_edit_sakagura", [ sakagura_id, sakagura_name ] );
	}
	else
	{
		$('#container input[name="close_sakagura"]').css({"display":"block"});
		$('#container input[name="update_sakagura"]').css({"display":"none"});
		$('#container input[name="sakagura_confirm"]').css({"display":"block"});
		$('#container input[name="delete_sakagura"]').css({"display":"none"});
	}
})(); // 匿名関数


</script>
</html>
