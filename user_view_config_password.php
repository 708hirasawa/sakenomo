<?php
/* 現在のパスワードを入力して新しいパスワードを入力するフォーム */
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>パスワード変更 [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_view_config_password.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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

		$username = $_COOKIE['login_cookie'];
		$email = $_COOKIE['email'];

		if(!$db = opendatabase("sake.db")) {
			print('<div>データベース接続エラー</div>');
			print('</body></html>');
			return;
		}

		$sql = "SELECT * FROM USERS_J WHERE username = '$username' OR email = '$username'";
		$res = executequery($db, $sql);
		$row = getnextrow($res);

		if(!$row) {
			print('<div>ユーザーが見つかりません</div>');
			print('</body></html>');
			return;
		}
	?>

	<div id="container">
		<div id="password_container">
			<div class="password_title">パスワード変更</div>
			<form id="password_form" action="" method="post">
				<div id="password_content">
					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title">現在のパスワード</div>
						</div>
						<div class="row">
							<div class="column2">
								<label>
									<input id="password" type="password" name="password">
								</label>
								<div id="password_verify"></div>
								<a class="password_link" href="user_view_config_password_reset.php">
									<span>パスワードをお忘れの方はこちら</span>
								</a>
									<p id="message"></p>
							</div>
						</div>
					</div>
				</div>
				<div id="password_content">
					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title">新しいパスワード</div>
						</div>
						<div class="row">
							<div class="column2">
								<label>
									<input id="new_password" type="password" name="new_password">
								</label>
								<p id="message"></p>
							</div>
							<div id="message">
								<p id="letter" class="invalid"><b>アルファベット小文字</b></p>
								<p id="capital" class="invalid"><b>アルファベット大文字</b></p>
								<p id="number" class="invalid"><b>数字</b></p>
								<p id="length" class="invalid"><b>6文字以上</b></p>
							</div>
						</div>
					</div>
					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title">パスワードを確認</div>
						</div>
						<div class="row">
							<div class="column2">
								<label>
									<input id="new_password_repeat" type="password" name="new_password_repeat">
								</label>
								<p id="message"></p>
							</div>
						</div>
					</div>
					<div id="password_check" style="display:none">パスワードが一致しません</div>
				</div>

				<div class="password_button_container">
					<input type="button" id="submit_button" name="submit_button" disabled=true value="パスワードを保存">
				</div>
			</form>
		</div>
	</div>

	<?php
		writefooter();
	?>

</body>

<script type="text/javascript">

	$(function() {

		function verifyEntries() {
			var status = true;

			// new password verification
			if($('#letter').hasClass('invalid') || $('#capital').hasClass('invalid') || $('#number').hasClass('invalid') || $('#length').hasClass('invalid')) {
				status = false;
			}

			// new password verification
			if($('#password_verify').hasClass('invalid')) {
				status = false;
			}

			// password match verification
			if($('#password_check').hasClass('invalid')) {
				status = false;
			}

			// disable/enable submit button based on status
			if(status == false) {
				$('#submit_button').prop('disabled', true);
				$('#submit_button').css('background', '#e6e6e6');
			}
			else {
				$('#submit_button').prop('disabled', false);
				$('#submit_button').css('background', '#C5CE51');
			}
		}

		// when the user starts to type something inside the password field
		$(document).on('keyup', '#new_password', function() {

			// validate lowercase letters
			if($('#new_password').val().match(/[a-z]/g)) {
				$('#letter').removeClass('invalid');
				$('#letter').addClass('valid');
			} else {
				$('#letter').removeClass('valid');
				$('#letter').addClass('invalid');
			}

			// validate capital letters
			if($('#new_password').val().match(/[A-Z]/g)) {
				$('#capital').removeClass('invalid');
				$('#capital').addClass('valid');
			} else {
				$('#capital').removeClass('valid');
				$('#capital').addClass('invalid');
			}

			// validate numbers
			if($('#new_password').val().match(/[0-9]/g)) {
				$('#number').removeClass('invalid');
				$('#number').addClass('valid');
			} else {
				$('#number').removeClass('valid');
				$('#number').addClass('invalid');
			}

			// validate length
			if($('#new_password').val().length >= 6) {
				$('#length').removeClass('invalid');
				$('#length').addClass('valid');
			} else {
				$('#length').removeClass('valid');
				$('#length').addClass('invalid');
			}
		});

		$(document).on('blur', 'input[name="password"]', function() {

			var username = <?php echo json_encode($username); ?>;
			var data = "username=" + username + "&" + $("#password_form").serialize();
			//alert("data:" + data);

			$.ajax({
				type: "post",
				url: "cgi/user_verify_password.php",
				data: data,
			}).done(function(xml){

				var str = $(xml).find("str").text();
				var sql = $(xml).find("sql").text();
				//alert("str:" + str + " sql:" + sql);

				if(str == "success") {
					$('#password_verify').text("現在のパスワードが一致しました");
					$('#password_verify').removeClass('invalid');
					$('#password_verify').addClass('valid');
					$('#password_verify').css({"display":"block"});
				}
				else {
					$('#password_verify').text("現在のパスワードが一致しません");
					$('#password_verify').removeClass('valid');
					$('#password_verify').addClass('invalid');
					$('#password_verify').css({"display":"block"});
				}

				verifyEntries();

			}).fail(function(data){
				var str = $(xml).find("str").text();
				alert("Failed:" +str);
			});
		});

		////////////////////////////////////////////////////////////////////////////////////
		// パスワード検証
		////////////////////////////////////////////////////////////////////////////////////
		// when the user clicks outside of the password field, hide the message box
		$('input[name="new_password"], input[name="new_password_repeat"]').blur(function() {

			// check for password match
			if($('input[name="new_password"]').val() != $('input[name="new_password_repeat"]').val()) {
				if($('input[name="new_password"]').val() != "" && $('input[name="new_password_repeat"]').val() != "") {
					$('#password_check').text("パスワードが一致しません");
					$('#password_check').removeClass('valid');
					$('#password_check').addClass('invalid');
					$('#password_check').css({"display":"block"});
				}
				else {
					$('#password_check').removeClass('valid');
					$('#password_check').addClass('invalid');
					$('#password_check').css({'display':'none'});
				}

				status = false;
			}
			else {
				$('#password_check').text("パスワードが一致しました");
				$('#password_check').removeClass('invalid');
				$('#password_check').addClass('valid');
				$('#password_check').css({'display':'block'});
			}

			verifyEntries();
		});

		////////////////////////////////////////////////////////////////////////
		$(document).on('click','#submit_button', function() {

			var username = <?php echo json_encode($username); ?>;
			var email = <?php echo json_encode($email); ?>;
			var data = "username=" + username + "&email=" + email + "&" + $("#password_form").serialize();
			//alert("data:" + data);

			$.ajax({
				type: "post",
				url: "cgi/user_password_update.php",
				data: data,
			}).done(function(xml) {
				var str = $(xml).find("str").text();
				var sql = $(xml).find("sql").text();

				//alert("str:" + str + " sql:" + sql);

				if(str == "success") {
					alert("パスワードを変更しました");
					window.open('./user_view_config.php', '_self');
				}
				else
					$("#message").text('パスワードが違います');

			}).fail(function(data){
				alert("failed");
				$("#message").text('This is Error');
			});
		});
	});

	jQuery(document).ready(function(){

		$("body").wrapInner('<div id="wrapper"></div>');

	}); // jQuery ready

</script>
</html>
