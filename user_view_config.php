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
<title>マイページ設定 [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_view_config.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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

	// if no login information send back to to page
	$username = $_COOKIE['login_cookie'];
	//$_SESSION['loginname'] = $loginname;


	if(!$db = opendatabase("sake.db"))
	{
		print('<div>データベース接続エラー</div>');
		print('</body></html>');
		return;
	}

	$sql = "SELECT * FROM USERS_J WHERE username = '$username' OR email = '$username'";
	$res = executequery($db, $sql);
	$row = getnextrow($res);

	if(!$row)
	{
		print('<div>データベース接続エラー</div>');
		print('</body></html>');
		return;
	}

	$imagefile = null;
	$email = stripslashes($row["email"]);
	$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$email' AND status=1";
	$result = executequery($db, $sql);
	$rd = getnextrow($result);

	if($rd) {
		$imagefile = $rd["filename"];
	}

	print('<div id="all_container">');

		print('<div id="user_information">');
			$path = "images/icons/noimage_user30.svg";
			if($imagefile)
				$path = "images/profile/" .$imagefile;
			print('<div class="user_image_name_container">');
				print('<div class="user_image_container">');
					print('<img src=' .$path .'>');
				print('</div>');
				print('<div id="profile_name">' .$row["nickname"] .'</div>');

			print('</div>');
		print("</div>");

		print('<div id="config_container">');
			print('<div class="mypage_config_title"><svg class="config_title_config1616"><use xlink:href="#config1616"/></svg>マイページ設定</div>');

			print('<div id="config_content">');
				print('<div id="config_sub_title">');
					print('<p>アカウント設定</p>');
				print('</div>');
				print('<div class="config_item_container">');
					////////////////////////////////////////////////////////////////////////////////
					/*初期は非表示print('<div class="config_item">');
						print('<a id="account_link_input_trigger" class="config_input_trigger" href="">');
							print('<span>アカウント連携</span>');
						print('</a>');
					print('</div>');*/
					////////////////////////////////////////////////////////////////////////////////
					/*初期は非表示print('<div class="config_item">');
						print('<a id="receiving_mail_input_trigger" class="config_input_trigger" href="">');
							print('<span>メール受信設定</span>');
						print('</a>');
					print('</div>');*/
					////////////////////////////////////////////////////////////////////////////////
					/*初期は非表示print('<div class="config_item">');
						print('<a id="privacy_input_trigger" class="config_input_trigger" href="">');
							print('<span>プライバシー設定(初めは不要)</span>');
						print('</a>');
					print('</div>');*/
					////////////////////////////////////////////////////////////////////////////////
					print('<div class="config_item">');
						print('<a id="withdraw_input_trigger" class="config_input_trigger" href="user_view_config_withdraw.php">');
							print('<span>Sakenomo退会</span>');
						print('</a>');
					print('</div>');
					////////////////////////////////////////////////////////////////////////////////
				print('</div>');//config_item_container
			print('</div>');//config_content

			print('<div id="config_content">');
				print('<div id="config_sub_title">');
					print('<p>プロフィール設定</p>');
				print('</div>');
				print('<div class="config_item_container">');
					////////////////////////////////////////////////////////////////////////////////
					print('<div class="config_item">');
						print('<a id="profile_input_trigger" class="config_input_trigger" href="user_view_config_profile.php">');
							print('<span>プロフィール編集</span>');
						print('</a>');
					print('</div>');
					////////////////////////////////////////////////////////////////////////////////
				print('</div>');//config_item_container
			print('</div>');//config_content
		print("</div>");//config_container

	print("</div>");//all_container

	writefooter();

	//print("<hr>");
	//print("<img src=\"drinksake.gif\" id=\"logoimage\" Title=\"Sake and Sakagura Listings\" alt=\"Sake and Sakagura Listings sakenomu.com\">");

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
