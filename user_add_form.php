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
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>Sakenomo</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_view_config.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_add_form.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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
	?>

	<div id="container">
		<div id="registry_user_container">

			<div class="registry_user_title">会員登録 (無料)</div>
			<div class="registry_user_note">
				ご入力いただいたメールアドレスに会員登録用のURLをお送りします。
			</div>

			<form id="registry_user_form" action="mail_registry.php" method="post">

				<div id="registry_user_content">
					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title_sign"></div>
							<div class="row_title">メールアドレス</div>
						</div>
						<div class="row">
							<div class="column1_container">
								<div class="column1">※必ずSakenomoからのメールを受信できるアドレスを入力してください。</div>
							</div>
							<div class="column2">
								<label><input id="email" type="text" name="email"></label>
								<span id="email_verify"></span>
							</div>
						</div>
					</div>

					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title_sign"></div>
							<div class="row_title">パスワード</div>
						</div>
						<div class="row">
							<div class="column1_container">
								<div class="column1">※以下の条件を含む半角英数字のパスワードを設定してください。</div>
							</div>
							<div id="message">
								<p id="letter" class="invalid"><b>アルファベット小文字</b></p>
								<p id="capital" class="invalid"><b>アルファベット大文字</b></p>
								<p id="number" class="invalid"><b>数字</b></p>
								<p id="length" class="invalid"><b>6文字以上</b></p>
							</div>
							<div class="column2">
								<label>
									<input type="password" id="user_password" name="user_password">
								</label>
							</div>
						</div>
					</div>
				</div>

				<div class="registry_user_button_container">
					<a class="agreement_link_button" href="agreement.php" target="_blank"><span>Sakenomo利用規約</span></a>
					<input type="submit" id="submit_button" name="send" value="利用規約に同意して送信する" disabled>
				</div>

			</form>

		</div>
	</div>


	<?php
		writefooter();
	?>

</body>

<script type="text/javascript">


	jQuery(document).ready(function(){

		$("body").wrapInner('<div id="wrapper"></div>');

		/*
		$('#email').change(function() {
			var txt = $(this).val();
			var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
			$(this).val(han);
		});
		*/

		$('#submit_button').click(function() {
			if(!$('input[name="email"]').val() || $('input[name="email"]').val() == "") {
				$('#submit_button').prop('disabled', true);
				$('#email_verify').text("メールアドレスを入力してください");
				event.stopPropagation();
				event.preventDefault();
			}
		});

		$('input[name="email"]').blur(function() {

			var data = $('#registry_user_form').serialize();
			//alert("メールのチェック:" + data);

			$.ajax({
				type: "post",
				url: "user_verify_email.php",
				data: data,
			}).done(function(xml){
				var str = $(xml).find("str").text();
				var sql = $(xml).find("sql").text();
				//alert("str:" + str);

				if(str == "already_exist") {
					$('#email_verify').text("すでに使われているメールアドレスです");
					$('#submit_button').prop('disabled', true);
				}
				else if(str == "invalid_email") {
					$('#email_verify').text("正しいメールアドレスを入力してください");
					$('#submit_button').prop('disabled', true);
				}
				else {
					$('#email_verify').text("");
					$('#submit_button').prop('disabled', false);
				}

			}).fail(function(data){
				  var str = $(xml).find("str").text();
				  alert("Failed:" +str);
			});
		});

		////////////////////////////////////////////////////////////////////////////////////
		// パスワード検証
		////////////////////////////////////////////////////////////////////////////////////
		// When the user clicks outside of the password field, hide the message box
		$('input[name="user_password"]').blur(function() {
			if($('#letter').hasClass('invalid') || $('#capital').hasClass('invalid') || $('#number').hasClass('invalid') || $('#length').hasClass('invalid')) {
				$('#submit_button').prop('disabled', true);
				$("#submit_button").css('background', '#e6e6e6');
			}
			else {
				$('#submit_button').prop('disabled', false);
				$("#submit_button").css('background', '#C5CE51');
			}
		});

		// When the user starts to type something inside the password field
		$(document).on('keyup', '#user_password', function(){

		  // Validate lowercase letters
		  if($('#user_password').val().match(/[a-z]/g)) {
				$('#letter').removeClass('invalid');
				$('#letter').addClass('valid');
		  } else {
				$('#letter').removeClass('valid');
				$('#letter').addClass('invalid');
		  }

		  // Validate capital letters
		  if($('#user_password').val().match(/[A-Z]/g)) {
				$('#capital').removeClass('invalid');
				$('#capital').addClass('valid');
		  } else {
				$('#capital').removeClass('valid');
				$('#capital').addClass('invalid');
		  }

		  // Validate numbers
		  if($('#user_password').val().match(/[0-9]/g)) {
				$('#number').removeClass('invalid');
				$('#number').addClass('valid');
		  } else {
				$('#number').removeClass('valid');
				$('#number').addClass('invalid');
		  }

		  // Validate length
		  if($('#user_password').val().length >= 6) {
				$('#length').removeClass('invalid');
				$('#length').addClass('valid');
		  } else {
				$('#length').removeClass('valid');
				$('#length').addClass('invalid');
		  }
		});

	}); // jQuery ready

</script>
</html>
