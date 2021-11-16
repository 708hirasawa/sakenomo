<<<<<<< HEAD
<?php
/* メールアドレスを入力し、検索するフォーム、アドレスが見つかれば、user_view_config_password_reset.phpに移行 */
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
require_once("nonda.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>アカウント検索 [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_view_config_authcode.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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
		session_start();
		include_once('images/icons/svg_sprite.svg');

		write_side_menu();
		write_HamburgerLogo();
		write_search_bar();
		write_Nonda();

		$authToken = $_SESSION['authToken'];
	?>

	<div id="container">
		<div id="authcode_container">
			<div class="authcode_title">アカウント検索</div>
			<!-- <form id="authcode_form" action="" method="post"> -->
			<form id="authcode_form" name="form" action="user_view_send_password_reset.php" method="post">
				<div id="authcode_content">
					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title">メールアドレスを入力してください。</div>
						</div>
						<div class="row">
							<div class="column2">
								<label>
									<input id="email" type="" name="email">
								</label>
								<p id="message"></p>
							</div>
						</div>
					</div>
					<div id="password_verify"></div>
				</div>
				<div class="authcode_button_container">
					<input type="button" id="submit_button" name="" value="検索">
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
	$(document).on('blur', 'input[name="email"]', function() {
		var email = <?php echo json_encode($email); ?>;
		var data = "email=" + $('input[name="email"]').val();

		//alert("submit:" + data);

		$.ajax({
			type: "post",
			url: "cgi/user_verify_email.php",
			data: data,
		}).done(function(xml){

			var str = $(xml).find("str").text();
			var sql = $(xml).find("sql").text();

			if(str == "success")
			{
				//alert("success:" + str);
				$('#password_verify').text("E-mailが見つかりました");
				$('#password_verify').css({"color":"#C5CE51"});

				$('#submit_button').prop('disabled', false);
				$("#submit_button").css('background', '#C5CE51');
			}
			else
			{
				$('#password_verify').removeClass('valid');
				$('#password_verify').addClass('invalid');
				$('#password_verify').text("現在のE-mailが一致していません");
				$('#password_verify').css({"color":"#CD0000"});

				///////////////////////////////
				$('#submit_button').prop('disabled', true);
				$("#submit_button").css('background', '#e6e6e6');
			}

		}).fail(function(data){
			var str = $(xml).find("str").text();
			alert("Failed:" +str);
		});
	});
	*/

	$('#submit_button').click(function(e) {

		var email = <?php echo json_encode($email); ?>;
		var data = "email=" + $('input[name="email"]').val();

		$.ajax({
			type: "post",
			url: "cgi/user_verify_email.php",
			data: data,
		}).done(function(xml){

			var str = $(xml).find("str").text();
			var sql = $(xml).find("sql").text();

			if(str == "found") {
				//alert("success:" + str);
				$('#password_verify').css({"color":"#259AFF"});
				$('#password_verify').text("E-mailが見つかりました");
				$('#authcode_form').submit();
			}
			else {
				$('#password_verify').removeClass('valid');
				$('#password_verify').addClass('invalid');
				$('#password_verify').text("E-mailが見つかりません");
				$('#password_verify').css({"color":"#CD0000"});
			}

		}).fail(function(data) {
			var str = $(xml).find("str").text();
			alert("Failed:" +str);
		});
	});

	jQuery(document).ready(function() {
		$("body").wrapInner('<div id="wrapper"></div>');
	}); // jQuery ready

</script>

</html>
=======
<?php
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
require_once("nonda.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>アカウント検索 [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_view_config_authcode.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
</head>

<body>

	<?php
		session_start();
		include_once('images/icons/svg_sprite.svg');

		write_side_menu();
		write_HamburgerLogo();
		write_search_bar();
		write_Nonda();

		$authToken = $_SESSION['authToken'];
	?>

	<div id="container">
		<div id="authcode_container">
			<div class="authcode_title">アカウント検索</div>
			<!-- <form id="authcode_form" action="" method="post"> -->
			<form id="authcode_form" name="form" action="user_view_send_password_reset.php" method="post">
				<div id="authcode_content">
					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title">メールアドレスを入力してください。</div>
						</div>
						<div class="row">
							<div class="column2">
								<label>
									<input id="email" type="" name="email">
								</label>
							</div>
						</div>
					</div>
					<div id="password_verify"></div>
				</div>
				<div class="authcode_button_container">
					<input type="button" id="submit_button" name="" value="検索">
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
	$(document).on('blur', 'input[name="email"]', function() {
		var email = <?php echo json_encode($email); ?>;
		var data = "email=" + $('input[name="email"]').val();

		//alert("submit:" + data);

		$.ajax({
			type: "post",
			url: "cgi/user_verify_email.php",
			data: data,
		}).done(function(xml){

			var str = $(xml).find("str").text();
			var sql = $(xml).find("sql").text();

			if(str == "success")
			{
				//alert("success:" + str);
				$('#password_verify').text("E-mailが見つかりました");
				$('#password_verify').css({"color":"#C5CE51"});

				$('#submit_button').prop('disabled', false);
				$("#submit_button").css('background', '#C5CE51');
			}
			else
			{
				$('#password_verify').removeClass('valid');
				$('#password_verify').addClass('invalid');
				$('#password_verify').text("現在のE-mailが一致していません");
				$('#password_verify').css({"color":"#CD0000"});

				///////////////////////////////
				$('#submit_button').prop('disabled', true);
				$("#submit_button").css('background', '#e6e6e6');
			}

		}).fail(function(data){
			var str = $(xml).find("str").text();
			alert("Failed:" +str);
		});
	});
	*/

	$('#submit_button').click(function(e) {

		var email = <?php echo json_encode($email); ?>;
		var data = "email=" + $('input[name="email"]').val();

		$.ajax({
			type: "post",
			url: "cgi/user_verify_email.php",
			data: data,
		}).done(function(xml){

			var str = $(xml).find("str").text();
			var sql = $(xml).find("sql").text();

			if(str == "success")
			{
				//alert("success:" + str);
				$('#password_verify').css({"color":"#259AFF"});
				$('#password_verify').text("E-mailが見つかりました");
				$('#authcode_form').submit();
			}
			else
			{
				$('#password_verify').removeClass('valid');
				$('#password_verify').addClass('invalid');
				$('#password_verify').text("E-mailが見つかりません");
				$('#password_verify').css({"color":"#CD0000"});
			}

		}).fail(function(data){
			var str = $(xml).find("str").text();
			alert("Failed:" +str);
		});
	});

	jQuery(document).ready(function() {
		$("body").wrapInner('<div id="wrapper"></div>');
	}); // jQuery ready


</script>

</html>
>>>>>>> 8ffc5c76628e9fbf2d4d95e583fd051380c69d81
