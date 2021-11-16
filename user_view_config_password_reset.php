<?php
/* アカウントに登録されているメールアドレスに認証コードを送信ボタンで送信 */
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
require_once("nonda.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>パスワードリセット [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_view_config_password_reset.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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
		write_Nonda();

		$username = $_COOKIE['username'];
		$email = $_COOKIE['email'];
	?>

	<div id="container">
		<div id="password_reset_container">
			<div class="password_reset_title">パスワードリセット</div>
			<form id="password_reset_form" name="form" action="user_view_config_authcode.php" method="post">

				<div id="password_reset_content">
					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title">アカウントに登録されているメールアドレスに認証コードを送信します。</div>
							<div class="row_title">送信ボタンを押してください。</div>
							<?php
								print('<input type="hidden" id="username" name="username" value="'. $username .'">');
								print('<input type="hidden" id="email" name="email" value="'. $email .'">');
							?>
						</div>
					</div>
				</div>
				<div class="password_reset_button_container">
					<input type="submit" id="submit_button" name="submit_button" value="送信">
				</div>
			</form>
		</div>
	</div>

	<?php
		writefooter();
	?>

</body>

<script type="text/javascript">

	/*
	$(document).on('click','#submit_button', function() {

		var email = <?php echo json_encode($email); ?>;
		var username = <?php echo json_encode($username); ?>;

		var data = "email=" + email + "&" + "username=" + username;
		alert("data:" + data);

		$.ajax({
			type: "post",
			url: "cgi/user_password_registry.php",
			data: data,
		}).done(function(xml){
			var str = $(xml).find("str").text();
			var sql = $(xml).find("sql").text();
			//alert("str:" + str);

			if(str == "success") {
				window.open('./user_view_config_authcode.php', '_self');
			}
			else {
				alert('メールを送信できませんでした。ご入力いただいたメールアドレスに間違いがないかご確認ください');
			}

		}).fail(function(data){
			alert('failed');
			alert('This is Error');
		});
	});
	*/

	jQuery(document).ready(function() {
		$("body").wrapInner('<div id="wrapper"></div>');
	}); // jQuery ready

</script>

</html>
