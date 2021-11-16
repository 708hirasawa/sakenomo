<?php
require_once("html_disp.php");
require_once("manage_edit_sake.php");
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
<title>日本酒登録 [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/manage_edit_sake.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/manage_edit_sake.js?random=<?php echo uniqid(); ?>"></script>

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
	write_search_bar();
	write_Nonda();

	$sake_id   = $_GET['sake_id'];
	$sake_name = $_GET['sake_name'];

	$sakagura_id = $_GET['id'];
	$sakagura_name = $_GET['sakagura_name'];
	print('<div id="container">');

	writeSakeContainer("", "");
	writeChooseSakagura();
	writeDialogAddSakeConfirm();

	print('</div>'); // container
	writefooter();
  ?>

<script type="text/javascript">

jQuery(document).ready(function(){

	var sake_id = <?php echo json_encode($sake_id); ?>;
	var sake_name = <?php echo json_encode($sake_name); ?>;
	var sakagura_id = <?php echo json_encode($sakagura_id); ?>;
	var sakagura_name = <?php echo json_encode($sakagura_name); ?>;

	$("body").wrapInner('<div id="wrapper"></div>');

	/* 登録画面ボタン 初期設定 */
	$('#container input[name="cancel_sake"]').css({"display":"block"});
	$('#container input[name="confirm_button"]').css({"display":"block"});
	$('#container input[name="delete_sake"]').css({"display":"none"});

	/* 入力画面表示 */
	$('#container .sake_container').css({"display":"flex"});

	if(sakagura_id && sakagura_id != "")
	{
        $('#container .sakedata').data('sakagura_id', sakagura_id);
        $('#container input[name="sakagura_id"]').val(sakagura_id);
        $('#container input[name="sakagura_name"]').val(sakagura_name);
	}

	if(sake_id && sake_id != "")
	{
		//alert("edit sake:" + sake_id + " sake_name:" + sake_name);
		/* 確認画面ボタン　更新用 */
		$('input[name="submit_button"]').css({"display":"none"});
		$('input[name="update_button"]').css({"display":"block"});
		$("body").trigger( "open_edit_sake", [ sake_id, sake_name ] );
	}
	else
	{
		/* 確認画面ボタン　登録用 */
		$('#container input[name="submit_button"]').css({"display":"block"});
		$('#container input[name="update_button"]').css({"display":"none"});

		/* 自動カナ、ローマ字入力 */

		/*
		$('#container .sakedata').createAutoKana({
			sakagura_name		: $('#container input[name="sake_name"]'),
			sakagura_read		: $('#container input[name="sake_read"]'),
			sakagura_english	: $('#container input[name="sake_english"]')
		});
		*/
	}
});

/////////////////////////////////////////////////////////////////////////////
$(function() {

	/* 前のページに戻る */
	$('#container input[name="cancel_sake"]').click(function(){
		window.history.back();
	});

    /* 登録 */
    $('#container input[name="submit_button"]').click(function(){

		$('input[name="jas_code[]"]').each(function() {
			$(this).val($.trim($(this).val()));
		});

		var data = $('#container .form').serialize();
		//alert("data:" + data);

		$.ajax({
			type: "post",
			url: "cgi/sake_add.php",
			data: data,
		}).done(function(xml){
			var str = $(xml).find("str").text();

			if(str == "success") {
				var sake_id = $(xml).find("sake_id").text();
				alert($('.sakedata input[name="sake_name"]').val() + "を追加しました");
				window.open('sake_view.php?sake_id=' + sake_id, '_self');
			}
			else {
				$("#sample1").text(str);
			}
		}).fail(function(data){
		   alert("This is Error");
		});
    });

   /* 更新 */
   $('#container input[name="update_button"]').click(function() {

		var sake_id = $('#container  .sakedata').data('sake_id');
		var data = $('#container .form').serialize() + "&sake_id=" + $('#container  .sakedata').data('sake_id');

		if($('.sakedata input[name="sake_category[]"]:checked').length == 0)
			data += '&sake_category=';

		if($('.sakedata input[name="koubo_used[]"]:checked').length == 0)
			data += '&koubo_used=';

		if($('.sakedata input[name="special_name"]:checked').length == 0)
			data += '&special_name=';

		if($('.sakedata input[name="ingredients[]"]:checked').length == 0)
			data += '&ingredients=';

		if($('.sakedata input[name="recommended_drink[]"]:checked').length == 0)
			data += '&recommended_drink=';

		//alert("data:" + data);
		//alert("ingredients length:" + $('.sakedata input[name="ingredients[]"]:checked').length);
		//alert("sake_category length:" + $('.sakedata input[name="sake_category[]"]:checked').length);
		//alert("special_name:" + $('.sakedata input[name="special_name"]:checked').val());
		//alert("update data:" + data);

		$.ajax({
				type: "post",
				url: "cgi/sake_update.php?id=" + sake_id,
				data: data,
		}).done(function(xml){

				str = $(xml).find("str").text();
				sql = $(xml).find("sql").text();
				//alert("success:" + str);
				//alert("sql:" + sql);
				var sake_id = <?php echo json_encode($sake_id); ?>;

				if(str == "success")
				{
					window.open('sake_view.php?sake_id=' + sake_id, '_self');
					return;
				}

		}).fail(function(data){
			 alert("This is Error");
		});
	});
});

</script>
</body>
</html>
