<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
require_once("nonda.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>Sakenomo退会 [Sakenomo]</title>

<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_view_config_withdraw.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
</head>

<body>

	<?php
	include_once('images/icons/svg_sprite.svg');
	write_side_menu();
	write_HamburgerLogo();
	write_search_bar();
	write_Nonda();

	$username = $_GET['username'];

	if(!$db = opendatabase("sake.db"))
	{
		die("データベース接続エラー .<br />");
	}

	$sql = "SELECT * FROM USERS_J WHERE username = '$username'";
	$res = executequery($db, $sql);
	$row = getnextrow($res);

	//var responseArray = JSON.parse(responseText);
	//var path = "images\\profile\\" + responseArray[0];

	print('<div id="all_container">');

		/*if($row)
		{*/
			print('<div id="user_information">');

				$path = "images/icons/noimage_user30.svg";

				if($row["imagefile"])
				$path = "images/profile/" .$row["imagefile"];

				print('<div class="user_image_name_container">');
					//写真
					print('<div class="user_image_container">');
						print('<img src=' .$path .'>');
					print('</div>');

					//ユーザー名
					print('<div id="profile_name">' .$row["username"] .'</div>');

				print('</div>');

			print("</div>");
		/*}*/

		print('<div id="main_sub_container">');

			print('<div id="main_container">');
				print('<div class="mypage_config_title_button_container">');
					print('<div class="mypage_config_title"><svg class="config_title_config1616"><use xlink:href="#config1616"/></svg>Sakenomo退会</div>');
					print('<a class="mypage_config_button" href="user_view_config.php?username=' .$username .'"><span>設定画面トップへ</span></a>');
				print('</div>');

				print('<div id="config_content">');

					print('<div class="config_item">');
						print('<div class="config_item_title">退会する前にご確認ください</div>');
						print('<div class="user_withdraw_container">');
							print('<div class="user_withdraw_note">Sakenomoを退会すると、現在ご利用中の機能が使用できなくなります。</div>');
							print('<div class="user_withdraw_text_container">');
								print('<div class="user_withdraw_text">飲んだ</div>');
								print('<div class="user_withdraw_subtext">・満足度登録</div>');
								print('<div class="user_withdraw_subtext">・レビュー投稿</div>');
								print('<div class="user_withdraw_subtext">・写真投稿</div>');
								print('<div class="user_withdraw_subtext">・テイスティングノート登録</div>');
								print('<div class="user_withdraw_text">飲みたい</div>');
								print('<div class="user_withdraw_text">お気に入り酒蔵</div>');
								print('<div class="user_withdraw_text">フォロー</div>');
								print('<div class="user_withdraw_subnote">以上の機能をはじめ、すべてのユーザー機能がお使いいただけなくなりますので、ご注意ください。</div>');
							print('</div>');
						print('</div>');
					print('</div>');

				print('</div>');//config_content

				//ボタン//////////////////////////////////////////////////////////////////////////
				print('<div class="user_config_button_container">');
					print('<a href="javascript:history.back()"><input id="button_cancel" type="button" value="戻る"></a>');
					print('<input id="submit_button" type="button" value="退会する">');
				print('</div>');

			print("</div>");//main_container

			print('<div id="sub_container">');
			print('</div>');//sub_container

		print("</div>");//main_sub_container

	print("</div>");//all_container

	writefooter();

	?>

</body>
<script type="text/javascript">

	jQuery(document).ready(function($) {

		$("body").wrapInner('<div id="wrapper"></div>');
		$("#tab_sake").addClass("nomitai_set");
		$('#tab_main').createTabs({
			text : $('#tab_main ul')
		});

		$('#cancel_user_button').click(function() {
			$("#dialog_addimage").css({"display":"none"});
		});

		//$('#diplay_selection div:first-child').click();
		$('#diplay_selection div:first-child').trigger('click');
	});

</script>
</html>
