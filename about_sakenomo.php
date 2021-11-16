<<<<<<< HEAD
<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>Sakenomoについて [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/about_sakenomo.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>

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

	print('<div id="all_container">');
		print('<div class="about_container">');
			print('<div class="about_title">Sakenomoについて</div>');

			print('<div class="about_content">');
				print('<div class="about_sub_title">');
					print('<p>リーガル</p>');
				print('</div>');
				print('<div class="about_item_container">');
					print('<div class="about_item">');
						print('<a class="about_item_link" href="agreement.php">');
							print('<span>利用規約</span>');
						print('</a>');
					print('</div>');
					print('<div class="about_item">');
						print('<a class="about_item_link" href="privacy_policy.php">');
							print('<span>プライバシーポリシー</span>');
						print('</a>');
					print('</div>');
				print('</div>');
			print('</div>');

			print('<div class="about_content">');
				print('<div class="about_sub_title">');
					print('<p>ヘルプ</p>');
				print('</div>');
				print('<div class="about_item_container">');
					/*print('<div class="about_item">');
						print('<a class="about_item_link" href="">');
							print('<span>ヘルプセンター</span>');
						print('</a>');
					print('</div>');*/
					print('<div class="about_item">');
						print('<a class="about_item_link" href="question.php">');
							print('<span>お問い合わせ</span>');
						print('</a>');
					print('</div>');
				print('</div>');
			print('</div>');

			/*print('<div class="about_content">');
				print('<div class="about_sub_title">');
					print('<p>About</p>');
				print('</div>');
				print('<div class="about_item_container">');
					print('<div class="about_item">');
						print('<a class="about_item_link" href="serviceguide_user.html">');
							print('<span>Sakenomoとは</span>');
						print('</a>');
					print('</div>');
					print('<div class="about_item">');
						print('<a class="about_item_link" href="company_aboutus.html">');
							print('<span>会社概要</span>');
						print('</a>');
					print('</div>');
				print('</div>');
			print('</div>');*/

		print("</div>");
	print("</div>");//all_container

	writefooter();

	//print("<hr>");
	//print("<img src=\"drinksake.gif\" id=\"logoimage\" Title=\"Sake and Sakagura Listings\" alt=\"Sake and Sakagura Listings sakenomo.com\">");

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
=======
<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>Sakenomoについて [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/about_sakenomo.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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

	print('<div id="all_container">');
		print('<div class="about_container">');
			print('<div class="about_title">Sakenomoについて</div>');

			print('<div class="about_content">');
				print('<div class="about_sub_title">');
					print('<p>リーガル</p>');
				print('</div>');
				print('<div class="about_item_container">');
					print('<div class="about_item">');
						print('<a class="about_item_link" href="agreement.php">');
							print('<span>利用規約</span>');
						print('</a>');
					print('</div>');
					print('<div class="about_item">');
						print('<a class="about_item_link" href="privacy_policy.php">');
							print('<span>プライバシーポリシー</span>');
						print('</a>');
					print('</div>');
				print('</div>');
			print('</div>');

			print('<div class="about_content">');
				print('<div class="about_sub_title">');
					print('<p>ヘルプ</p>');
				print('</div>');
				print('<div class="about_item_container">');
					/*print('<div class="about_item">');
						print('<a class="about_item_link" href="">');
							print('<span>ヘルプセンター</span>');
						print('</a>');
					print('</div>');*/
					print('<div class="about_item">');
						print('<a class="about_item_link" href="question.php">');
							print('<span>お問い合わせ</span>');
						print('</a>');
					print('</div>');
				print('</div>');
			print('</div>');

			/*print('<div class="about_content">');
				print('<div class="about_sub_title">');
					print('<p>About</p>');
				print('</div>');
				print('<div class="about_item_container">');
					print('<div class="about_item">');
						print('<a class="about_item_link" href="serviceguide_user.html">');
							print('<span>Sakenomoとは</span>');
						print('</a>');
					print('</div>');
					print('<div class="about_item">');
						print('<a class="about_item_link" href="company_aboutus.html">');
							print('<span>会社概要</span>');
						print('</a>');
					print('</div>');
				print('</div>');
			print('</div>');*/

		print("</div>");
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
>>>>>>> 8ffc5c76628e9fbf2d4d95e583fd051380c69d81
