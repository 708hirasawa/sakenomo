<?php
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
require_once("nonda.php");
require_once("twitterlogin/config.php"); 	// Include twitter configuration file
require_once("twitterlogin/User.class.php"); // Include User class
?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>Login [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_view_config.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_login_form.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="twitterlogin/css/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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

<script type="text/javascript">

	jQuery(document).ready(function() {

		$("body").wrapInner('<div id="wrapper"></div>');

		$(document).on('click','#submit_button', function() {

			var data = $("#registry_user_form").serialize();
			//alert("data:" + data);

			$.ajax({
				type: "post",
				url: "cgi/user_login.php",
				data: data,
			}).done(function(xml){
				var str = $(xml).find("str").text();
				var base = $(xml).find("base").text();

				//alert("str:" + str);
				//alert("base:" + base);

				if(str == "success")
					window.open('./sake_search.php', '_self');
				else {
					$("#message").hide();
					$("#message").text('メールアドレスもしくはパスワードが違います');
					$("#message").fadeIn();
				}
			}).fail(function(data){
				alert("failed");
				$("#message").text('This is Error');
			});
		});

		$('#email').change(function() {
			var txt = $(this).val();
			var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
			$(this).val(han);
		});

	}); // jQuery ready

	//読み込んでから表示
	$(window).on('load', function() {
		console.log("load");
	});

</script>

<body>

	<?php
		include_once('images/icons/svg_sprite.svg');
		write_side_menu();
		write_HamburgerLogo();
		write_search_bar();
		write_Nonda();
	?>

	<div id="container">
		<div id="registry_user_container">
			<div class="registry_user_title">ログイン</div>
			<form id="registry_user_form" action="" method="post">
				<div id="registry_user_content">
					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title">メールアドレス</div>
						</div>
						<div class="row">
							<div class="column2">
								<label><input id="email" type="text" name="email"></label>
							</div>
						</div>
					</div>
					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title">パスワード</div>
						</div>
						<div class="row">
							<div class="column2">
								<label>
									<input id="user_password" type="password" name="user_password">
								</label>
								<p id="message"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="registry_user_button_container">
					<a class="password_reset_link" href="user_view_config_password_inquiry.php">
						<span>パスワードを忘れた方はこちら</span>
					</a>
					<input type="button" id="submit_button" name="send" value="ログインする">

					<p class="another_account_login">または別のアカウントからログイン</p>

					<?php
						$output = '<a class="twitter_login" href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/twitter-login-btn.svg" /></a>';
						$output = '<div><a class="twitter_login" href="twitterlogin/index.php"><img src="twitterlogin/images/twitter-login-btn.svg" /></a></div>';
						print($output);
					?>

					<a class="registry_user_link" href="user_add_form.php">
						<span>会員登録されていない方はこちら</span>
					</a>
				</div>
			</form>
		</div>
	</div>

	<?php
		writefooter();
	?>

</body>
</html>
