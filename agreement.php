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
<title>利用規約 [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/agreement.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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
			print('<div class="subject">Sakenomo 利用規約</div>');
			print('<div class="introduction">Welcome to Sakenomo !<br>Sakenomoは、世界中のより多くの方々に日本酒の魅力を伝えることを目的としたサービスです。<br>お客様が快適にSakenomoをご利用するために、以下の通り、利用規約を定めています。Sakenomoご利用の際には、この「Sakenomo利用規約」が適用されますので、ご利用前に必ずお読みください。</div>');

			print('<div class="section">');
				print('<div class="title">1. 目的</div>');
				print('<div class="text">1.1. この「Sakenomo利用規約」(以下「本規約」といいます)は、お客様がSakenomoをご利用になる際の注意事項や諸条件等について定めたものです。お客様が本サービスを利用する場合は、予め本規約に同意したものとみなします。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">2. 用語の定義</div>');
				print('<div class="text">2.1. 本規約において、以下の用語は、それぞれ次の意味を有します。</div>');
				print('<div class="item">●「お客様」とは、Sakenomo会員登録の有無にかかわらず、Sakenomoをご利用いただくすべてのお客様をいいます。</div>');
				print('<div class="item">●「Sakenomo会員」とは、Sakenomoを利用するために、当社所定の会員手続きを完了したお客様のことをいいます。</div>');
				print('<div class="item">●「Sakenomo会員申し込み者」とは、Sakenomo会員の申し込みを行ったお客様をいいます。</div>');
				print('<div class="item">●「Sakenomoサイト」とは、Sakenomoが提供されているウェブサイト (www.sakenomo.com) をいいます。</div>');
				print('<div class="item">●「Sakenomo非会員」とは、Sakenomo会員ではないお客様をいいます。</div>');
				print('<div class="item">●「当社」とは、Sakenomo株式会社をいいます。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">3. Sakenomo規約について</div>');
				print('<div class="sub_title">(Sakenomo規約)</div>');
				print('<div class="text">3.1. 本規約に付随し、Sakenomo利用に関する各種条件を規定する以下の規約（以下、「個別規約」といい、本規約とあわせて「Sakenomo規約」と総称します）は、本規約と一体として適用されます。</div>');
				print('<div class="item">(1) プライバシーポリシー</div>');
				print('<div class="item">(2) ガイドライン</div>');
				print('<div class="item">(3) その他当社が定める規約</div>');
				print('<div class="text">個別規約と本規約の間に矛盾または抵触がある場合には、個別規約の規定が優先的に適用されるものとします。</div>');

				print('<div class="sub_title">(Sakenomo規約の変更)</div>');
				print('<div class="text">3.2. Sakenomo規定は、当社がその裁量により必要または適切であると判断する場合には、その全部または一部が予告なく変更されることがあります。かかる変更等により、お客様または第三者に生じた損害について、当社は一切の責任を負わないものとします。当社がSakenomoサイト上での告知を含む適宜の方法によりSakenomo規約の変更を告知した後に、お客様がSakenomoを利用した場合には、変更後の規約を承認したものとみなされます。</div>');

				print('<div class="sub_title">(Sakenomo規約の閲覧)</div>');
				print('<div class="text">3.3. Sakenomo規約（変更があった場合は変更後のもの）は、Sakenomoサイト上に掲載されます。定期的に最新のSakenomo規約をご確認されることをお勧めします。</div>');

				print('<div class="sub_title">(可分性および有効性)</div>');
				print('<div class="text">3.4. Sakenomo規約の各規約の規定の全部または一部が法令に基づいて無効と判断された場合であっても、その他の規約は有効とします。Sakenomo規約の各規約の規定の全部または一部がある者との関係で無効と判断された場合であっても、その他の者との関係では有効とします。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">4. Sakenomoの利用</div>');

				print('<div class="sub_title">(サービス内容)</div>');
				print('<div class="text">4.1. Sakenomoは、当社が提供する日本酒に関する情報、またはお客様が投稿する日本酒に関する情報を、ウェブサイト上に掲載することによって、他のお客様が日本酒に対する理解を高め、日本酒選びの際の参考等とすることを目的にしています。</div>');

				print('<div class="sub_title">(サービスの変更)</div>');
				print('<div class="text">4.2. 当社がその裁量により必要または適切と判断する場合は、Sakenomoの内容を予告なく変更、中止、中断できるものとします。</div>');

				print('<div class="sub_title">(サービス利用方法)</div>');
				print('<div class="text">4.3. お客様は、パソコンやスマートフォンなどの機器を使って、Sakenomoサイトにアクセスいただくことで、Sakenomoの利用が可能です。</div>');

				print('<div class="sub_title">(サービス利用に必要となる設備)</div>');
				print('<div class="text">4.4. お客様がSakenomoを利用する際に必要となる、パソコン、スマートフォン、インターネット環境等については、お客様自らの費用で用意し、操作するものとします。当社は、お客様がウェブサイトにアクセスための準備や操作方法に関与しません。</div>');

				print('<div class="sub_title">(利用可能なサービスの範囲)</div>');
				print('<div class="text">4.5. Sakenomoは、会員登録をせずにご利用いただくことができますが、Sakenomo会員とSakenomo非会員では、利用可能なサービスの範囲が異なる場合があります。Sakenomo会員向け、Sakenomo非会員向けそれぞれに利用可能なサービスの範囲については、当社が決定し、予告なしに変更できるものとします。</div>');

				print('<div class="sub_title">(会員登録手続き)</div>');
				print('<div class="text">4.6. Sakenomo会員になることを希望するお客様は、Sakenomo規約および適用される諸条件に同意し、当社所定の手続きを行うことで、Sakenomo会員の申し込みができるものとします。</div>');

				print('<div class="sub_title">(会員手続きの完了)</div>');
				print('<div class="text">4.7. Sakenomo会員登録は、当社がSakenomo会員申し込みを承諾することにより完了します。次のいずれかに該当する場合、当社の判断により、会員申し込みを承諾しないことがあります。</div>');
				print('<div class="item">(1) Sakenomo会員申し込み者が存在しない場合</div>');
				print('<div class="item">(2) お申し込み内容に故意による虚偽があった場合</div>');
				print('<div class="item">(3) 過去Sakenomo規約に違反していた場合</div>');
				print('<div class="item">(4) その他当社が不適切と判断した場合</div>');

				print('<div class="sub_title">(アカウント等の情報管理)</div>');
				print('<div class="text">4.8. Sakenomo会員は、アカウント名やパスワード等の情報をご自身で責任を持って管理するものとし、当社はお客様の管理不足、使用上の過誤、不正確な登録情報等に起因する損害について、一切責任を負わないものとします。</div>');

				print('<div class="sub_title">(ガイドライン)</div>');
				print('<div class="text">4.9. お客様は、当社が別途定めるガイドラインに沿って、Sakenomoを利用するものとします。ガイドラインに反するものが判明した場合は、当社は予告なしに投稿等を削除できるものとし、削除に該当するかどうかは当社で判断します。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">5. 個人情報取り扱い</div>');
				print('<div class="sub_title">(プライバシーポリシー)</div>');
				print('<div class="text">5.1. 当社の個人情報取り扱いについては、当社が別途定める<a href="privacy_policy.php">プライバシーポリシー</a>をご覧ください。お客様は、プライバシーポリシーに沿って、Sakenomoを利用するものとします。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">6. 知的財産権等</div>');
				print('<div class="sub_title">(知的財産権の帰属)</div>');
				print('<div class="text">6.1. Sakenomoサイト上のコンテンツ、デザイン、ロゴ、画像、ソフトウェア等に関する著作権、商標権、財産権等を含む知的財産権は、当社に帰属しています。当社もしくは法令により許諾されている場合を除き、Sakenomoサイト上のすべての内容において、お客様が複製、編集、掲載、転載、提供、翻訳、転売等を行うことは禁止されています。</div>');

				print('<div class="sub_title">(知的財産権に起因する損害等)</div>');
				print('<div class="text">6.2. お客様が知的財産権に反する行為により損害を被った場合、当社は一切の責任を負わないものとします。また、当該行為によって、利益を得た場合、当社はその利益相当額を請求できるものとします。</div>');

				print('<div class="sub_title">(お客様が投稿したコンテンツの著作権の帰属)</div>');
				print('<div class="text">6.3. お客様が投稿した口コミや写真を含むコンテンツの著作権は、当社に帰属するものとし、その期間は、投稿時から当該著作権の存続期間の満了日までとします。</div>');

				print('<div class="sub_title">(お客様が投稿したコンテンツの無償利用)</div>');
				print('<div class="text">6.4. 当社は、お客様が投稿した口コミや写真を含むコンテンツを無償にて利用できるものとします。その際に当社は、お客様の口コミの要約や抜粋、写真の切り取り等を行う場合があり、地域制限、その他付随条件なく、利用できるものとします。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">7. 禁止行為</div>');
				print('<div class="sub_title">(禁止行為)</div>');
				print('<div class="text">7.1. お客様がSakenomoを利用するにあたり、以下の事項を禁止します。</div>');
				print('<div class="item">(1) Sakenomo規約に違反すること</div>');
				print('<div class="item">(2) Sakenomo上のすべての内容において、事前の同意なく、複製、複製、編集、掲載、転載、提供、翻訳、転売等を行うこと</div>');
				print('<div class="item">(3) 会員登録時に虚偽の申告をすること</div>');
				print('<div class="item">(4) 同一人物が複数の会員登録を行うこと</div>');
				print('<div class="item">(5) IDおよびパスワードをお客様本人以外に利用させること</div>');
				print('<div class="item">(6) 不適切な内容の投稿をすること</div>');
				print('<div class="item">(7) 当社または他のお客様の権利を侵害すること</div>');
				print('<div class="item">(8) 公序良俗に反すること</div>');
				print('<div class="item">(9) 異性との出会い等を目的に利用すること</div>');
				print('<div class="item">(10) Sakenomoの運営を妨げること、または当社の信用を毀損すること</div>');
				print('<div class="item">(11) その他、当社が不適切と判断すること</div>');

				print('<div class="sub_title">(禁止行為に対しての措置)</div>');
				print('<div class="text">7.2. お客様が前項各号の行為を行ったと当社が判断した場合、当社は投稿情報の削除措置、Sakenomo利用停止措置、またはその他当社が適切と判断する措置を取ることができるものとします。当該措置は、当社の裁量で行うものとし、その理由については、お答えいたしかねます。また、当該措置によって、お客様が被った損害について、当社は一切の責任を負わないものとします。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">8. 退会手続き</div>');
				print('<div class="sub_title">(退会手続き)</div>');
				print('<div class="text">8.1. Sakenomo会員が退会を希望する場合は、当社所定の退会手続きを行うものとします。</div>');

				print('<div class="sub_title">(退会による会員資格の失効)</div>');
				print('<div class="text">8.2. Sakenomo会員が退会手続きを行った時点で、当社で利用いただいていた、Sakenomo会員の特典や権利などの会員資格を失うものとします。</div>');

				print('<div class="sub_title">(退会後の投稿コンテンツ)</div>');
				print('<div class="text">8.3. Sakenomo会員が退会後も、投稿したコンテンツや写真等は削除されず、当該コンテンツや写真等の著作権は当社に帰属するものとします。</div>');

				print('<div class="sub_title">(退会後の有効規約)</div>');
				print('<div class="text">8.4. Sakenomo会員が退会後も、Sakenomo規約は有効とします。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">9. 免責事項</div>');
				print('<div class="sub_title">(不可抗力等による免責)</div>');
				print('<div class="text">9.1. 他に定める場合のほか、天災、地震、火災、洪水、テロ、暴動、停電、システム故障、ネットワーク障害、その他当社の責めによらない事由に基づくSakenomoの提供の停止、遅滞、不具合、中断による損害について、当社は責任を負わないものとします。</div>');

				print('<div class="sub_title">(記載情報)</div>');
				print('<div class="text">9.2. お客様は自己責任においてSakenomoを利用するものとし、Sakenomoを利用してなされたすべての行為およびその結果についての責任負うものとします。</div>');

				print('<div class="text">9.3. 当社は、Sakenomoサイト上のすべての情報について、保証をいたしません。Sakenomoサイト上の情報が起因して起こった損害(コンピューターウィルス等も含みます)やお客様同士のトラブルについて、当社は一切の責任を負わないものとします。記載情報に誤りがある場合は、問い合わせフォームよりご連絡ください。</div>');

				print('<div class="sub_title">(記載情報の削除)</div>');
				print('<div class="text">9.4. 当社は、当社が不適切と判断する情報を発見した場合、予告なく削除することがあり、その判断は当社の裁量で行うものとします。判断の理由については、説明いたしかねます。</div>');

				print('<div class="sub_title">(第三者運営のサイト)</div>');
				print('<div class="text">9.5. Sakenomoサイトに投稿された第三者運営のサイトへのリンクについて、当社は第三者運営のサイトについて、一切保証をしないものとします。リンク先で生じたトラブルや損害等についても、当社は一切の責任を負いません。</div>');

				print('<div class="sub_title">(責任制限)</div>');
				print('<div class="text">9.6. 当社は、当社に重過失があった場合を除き、直接損害以外の損害（間接損害、付随的損害、特別損害、懲罰的損害、結果損害、データの損失または消失を含みますが、これらに限られません）については、責任を負いません。</div>');

				print('<div class="sub_title">(限定保証)</div>');
				print('<div class="text">9.7. 当社は、Sakenomoの全部または一部が停止または中断されずに提供されること、または瑕疵のないことを保証しません。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">10. 一般条項</div>');
				print('<div class="sub_title">(準拠法)</div>');
				print('<div class="text">10.1. Sakenomo規約はすべて日本法に準拠するものとします。</div>');

				print('<div class="sub_title">(合意管轄)</div>');
				print('<div class="text">10.2. お客様と当社との間で訴訟の必要が生じた場合、東京地方裁判所を第一審の専属的合意管轄裁判所とします。</div>');
			print("</div>");

			print('<div class="section">');
				print('<div class="title">11. お問い合わせ</div>');
				print('<div class="sub_title">(お問い合わせ先)</div>');
				print('<div class="text">11.1. ご質問等ございましたら、問い合わせフォームよりお問い合わせください。</div>');
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
