<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta content='width=device-width, initial-scale=1' name='viewport'/>
	<title>通知 [Sakenomo]</title>

	<link href="rateyo/jquery.rateyo.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/notifications.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
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

	print('<div class="header_container">');
		print('<div class="header_content">');
			print('<a href="javascript:history.back()"><svg class="header_prev2020"><use xlink:href="#prev2020"/></svg></a>');
			print('<div class="header_title">通知</div>');
		print('</div>');
	print('</div>');

	if(!$db = opendatabase("../sake.db"))
	{
		print('</body>');
		print('</html>');
		return;
	}

	$username = $_COOKIE['login_cookie'];
	$sql1 = "SELECT NONDA_LIKE.username, NONDA_LIKE.like_date, nickname, sake_name FROM NONDA_LIKE, USERS_J, SAKE_J, PROFILE_IMAGE WHERE NONDA_LIKE.contributor = '$username' AND NONDA_LIKE.username = USERS_J.username AND NONDA_LIKE.sake_id = SAKE_J.sake_id ORDER BY LIKE_DATE LIMIT 50";
	$res = executequery($db, $sql1);
	
	if(!$res) {
		//print('<div>' .$sql .'</div>');
		print('</body>');
		print('</html>');
		return;
	}

	print('<div id="all_container">');
		print('<div id="main_container">');

			print('<div id="notifications_container">');

			while($row = getnextrow($res)) {

				$path = "images/icons/noimage_user30.svg";
				$username = $row["username"];
				$sql2 = "SELECT filename FROM USER_J, PROFILE_IMAGE WHERE USERS_J.username = '$username' AND USERS_J.username = PROFILE_IMAGE.contributor AND status = 1";
				$result = executequery($db, $sql2);

				if($result && $record = getnextrow($result))
					$path = $record["filename"];

				/*
				print('<div class="notifications_content">');
					print('<div class="notifications_partner">');
						print('<div class="notifications_partner_img">');
							if($path) {
								print('<img src="' .$path .'">');
							} else {
								print('<img src="images/icons/noimage_user30.svg">');
							}
						print('</div>');
						print('<p class="notifications_partner_name"><span>' .$row["nickname"] .'</span>さん</p>');
					print('</div>');
					print('<div class="notifications_activity">');
						print('<p class="notifications_text">あなたをフォローしました</p>');
					print('</div>');
				print('</div>');
				*/

				print('<div class="notifications_content">');
					print('<div class="notifications_partner">');
						print('<div class="notifications_partner_img">');
							print('<img src="' .$path .'">');
						print('</div>');
						print('<p class="notifications_partner_name"><span>' .$row["nickname"] .'</span>さん</p>');
					print('</div>');
					print('<div class="notifications_activity">');
						print('<p class="notifications_text">あなたの投稿にいいねしました</p>');
						print('<p class="notifications_sake">' .$row["sake_name"] .'</p>');
					print('</div>');
				print('</div>');
			}

			print('</div>');
			print('<div>' .$sql2 .'</div>');

			print('<div id="side_container">');
				print('<a id="ad1" href="sake_search.php">');
					print('<img src="images/icons/notice_banner.jpg">');
				print("</a>");
			print('</div>');

		print('</div>');
	print('</div>');

	writefooter();

	?>

<script type="text/javascript">

</script>
</body>
</html>
