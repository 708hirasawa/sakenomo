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
<title>お問い合わせ [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/agreement.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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

	print('<div id="all_container">');
		print('<div id="main_container">');
			print('<div class="subject">お問い合わせ</div>');
			print('<div class="introduction">いつもSakenomoをご利用いただき、誠にありがとうございます。</br>お問い合わせ、ご意見、ご要望などは下記のメールアドレス宛てにご連絡ください。</br>多数のお問い合わせが集中する場合、回答までお時間をいただくことがありますので、ご了承ください。</div>');

			print('<div class="section">');
				print('<a href="mailto:support@sakenomo.xsrv.jp" class="title">support@sakenomo.xsrv.jp</a>');
			print("</div>");

		print("</div>");//main_container
	print("</div>");//all_container

	?>

</body>
<script type="text/javascript">

	jQuery(document).ready(function($) {

		$("body").wrapInner('<div id="wrapper"></div>');

	});

</script>
</html>
