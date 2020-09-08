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
<title>プライバシーポリシー [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css">
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

	/*$username = $_GET['username'];

	if(!$db = opendatabase("sake.db"))
	{
		die("データベース接続エラー .<br />");
	}

	$sql = "SELECT * FROM USERS_J WHERE username = '$username'";
	$res = executequery($db, $sql);
	$row = getnextrow($res);*/

	//var responseArray = JSON.parse(responseText);
	//var path = "images\\profile\\" + responseArray[0];

	print('<div id="all_container">');
		print('<div id="main_container">');
			print('<div class="subject">Sakenomo プライバシーポリシー</div>');
			print('<div class="introduction">Sakenomo株式会社（以下「当社」といいます）は、当社が運営するサービス（以下「本サービス」といいます）を提供するにあたり、以下のプライバシーポリシー（以下「本ポリシー」といいます）に従って個人情報を適切に取り扱います。</div>');

			print('<div class="section">');
				print('<div class="title">1. 個人情報の定義</div>');
				print('<div class="text">個人情報とは、本サービスを通じてお客様から取得する氏名、メールアドレス、パスワード、会員ID、通信端末に関する情報、その他のお客様個人を特定できる情報のことを指します。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">2. 個人情報の利用目的</div>');
				print('<div class="text">当社は、取得した個人情報を、以下の目的のために利用いたします。</div>');
				print('<div class="item">●本サービスに関する情報提供のため</div>');
				print('<div class="item">●当社および第三者の商品等の広告または宣伝（お客様の属性を用いたターゲティング広告を含む）</div>');
				print('<div class="item">●お客様の本人確認のため</div>');
				print('<div class="item">●お客様からのお問い合わせに対応するため</div>');
				print('<div class="item">●お客様同士の認識のため</div>');
				print('<div class="item">●本サービス改善や新サービス開発検討のため</div>');
				print('<div class="item">●本サービスに関するアンケート対象者抽出のため</div>');
				print('<div class="item">●個人を特定できない範囲においての統計データ作成・利用</div>');
				print('<div class="item">●契約や法律等に基づく権利の行使や義務の履行</div>');
				print('<div class="item">●その他、当社の事業に関連する目的のため</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">3. 個人情報の共有・利用制限</div>');
				print('<div class="text">当社は、以下に定める場合を除いて、事前にお客様本人の同意なく、利用目的の達成に必要な範囲を超えて個人情報を利用または第三者に共有することはありません。</div>');
				print('<div class="item">●お客様の同意があった場合</div>');
				print('<div class="item">●法令により認められた場合</div>');
				print('<div class="item">●裁判所、検察庁、警察、税務署、弁護士会またはこれらに準じた権限を持つ機関から個人情報開示を求められた場合</div>');
				print('<div class="item">●人の生命、身体または財産保護のために必要とされ、お客様本人から同意を得るのが困難な場合</div>');
				print('<div class="item">●合併、営業譲渡、その他の事由による事業承継の際に、事業を継承する者に対して開示する場合</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">4. 個人情報取り扱い委託</div>');
				print('<div class="text">当社は、第三者に個人情報取り扱いを業務委託する場合があります。その場合、当社は、個人情報を適切に保護できる管理体制を持つ委託先を厳選し、個人情報を適切に取り扱うことを条件として、個人情報取り扱いを業務委託するものとします。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">5. 第三者が提供するサービスについて</div>');
				print('<div class="text">本サービス上のリンク等を通じてアクセス可能な、第三者が提供するサービスに関わる個人情報取り扱いについて、当社は一切関与しておらず、責任を負わないものとします。当該サービスの個人情報取り扱いについては、それぞれのサービス提供者が定めるプライバシーポリシーをご覧ください。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">6. 安全管理措置</div>');
				print('<div class="text">当社は、お客様が安心して本サービスをご利用できるように、個人情報の漏洩または毀損の防止、その他個人情報の安全管理が確保できるよう、適切に個人情報の取り扱いを行います。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">7. 個人情報に関する問い合わせ</div>');
				print('<div class="text">個人情報に関するお問い合わせは、お問い合わせフォームよりお願いいたします。<!--お問い合わせフォームは<a href="#">こちら</a>。--></div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">8. 本ポリシーの更新</div>');
				print('<div class="text">当社は、法令等の変更や必要に応じて、本ポリシーを更新することがあります。本サービス上に掲載の最新のプライバシーポリシーをご覧いただくようお願いいたします。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="text">2018年10月23日制定</div>');
			print("</div>");
		print("</div>");//main_container
	print("</div>");//all_container

	writefooter();

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
