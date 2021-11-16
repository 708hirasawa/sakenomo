<?php
/* 認証コードを入力する画面、認証コードが一致すれば、user_view_config_password_update.phpに移行 */
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
require_once("nonda.php");
require_once("db_functions.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>認証コード入力 [Sakenomo]</title>
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

		$email = (isset($_POST['email']) && $_POST['email'] != 'undefined') ? $_POST['email'] : "";

		if(!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {

			$return = "invalid email";

			print('<div id="container">');
			print('<div id="authcode_container">');
			print('<div class="authcode_title">failed:' .$return .'</div>');
			print('</div>');
			print('</div>');
			print('</body>');
			return;
		}

		$auth_code = generateRandomString();

		$_SESSION['authToken'] = $auth_code;

		if(!$db = opendatabase("sake.db")) {
			return;
		}

		$sql = "SELECT username FROM USERS_J WHERE email = '$email'";
		$res = executequery($db, $sql);
		$row = getnextrow($res);

		if($row) {
			$title = "パスワードのリセット";
			$to = $email;
			$content = "パスワードをリセットしますか？\nご利用のSakenomoアカウントのパスワードをリセットするには、以下の認証コードを使ってプロセスを完了してください。パスワードのリセットにお心当たりがない場合はこのメールを無視してください\n\n" .$auth_code;

			if(!mb_send_mail($to, $title, $content))
			{
				print('<div id="container">');
				print('<div id="authcode_container">');
				print('<div class="authcode_title">認証コード入力</div>');
					print('認証コードの送信に失敗しました');
				print('</div>');
				print('</div>');
				print('</body>');
				return;
			}
		}
	?>

	<div id="container">
		<div id="authcode_container">
			<div class="authcode_title">認証コード入力</div>
			<form id="authcode_form" action="user_view_config_password_update.php" method="post">
				<div id="authcode_content">
					<div class="row_container">
						<div class="row_title_container">
							<div class="row_title">メールアドレスに届いた認証コードを入力してください。</div>
						</div>
						<div class="row">
							<div class="column2">
								<label>
									<input id="token" type="" name="token">
									<?php print('<input type="hidden" id="email" name="email" value="' .$email .'">'); ?>
								</label>
								<p id="message"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="authcode_button_container">
					<input type="submit" id="submit_button" name="" disabled=true value="次へ">
				</div>
			</form>
		</div>
	</div>

	<?php
		writefooter();
	?>

</body>

<script type="text/javascript">

	//$('input[name="token"]').blur(function() {
	$(document).on('keyup', 'input[name="token"]', function() {

		var token = <?php echo json_encode($auth_code); ?>;

		if($('#token').val() == token) {
			$('#message').text("認証コードが一致しました");
			$("#submit_button").css('background', '#259AFF');
			$('#submit_button').prop('disabled', false);
		}
		else {
			$('#message').text("認証コードが違います");
			$('#submit_button').prop('disabled', true);
			$("#submit_button").css('background', '#e6e6e6');
		}
	});

	jQuery(document).ready(function() {

		$("body").wrapInner('<div id="wrapper"></div>');

	}); // jQuery ready

</script>
</html>
