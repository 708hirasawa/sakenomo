<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("nonda.php");
require_once("searchbar.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta content='width=device-width, initial-scale=1, user-scalable=0' name='viewport'/>
	<title>検索結果 [Sakenomo]</title>
	<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/sake_library_search.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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

function GetSakeSpecialName($sake_code)
{
	if($sake_code == "11") {
		$retval = "普通酒";
		return $retval;
	}
	else if($sake_code == "21") {
		$retval = "本醸造酒";
		return $retval;
	}
	else if($sake_code == "22") {
		$retval = "特別本醸造酒";
		return $retval;
	}
	else if($sake_code == "31") {
		$retval = "純米酒";
		return $retval;
	}
	else if($sake_code == "32") {
		$retval = "特別純米酒";
		return $retval;
	}
	else if($sake_code == "33") {
		$retval = "純米吟醸酒";
		return $retval;
	}
	else if($sake_code == "34") {
		$retval = "純米大吟醸酒";
		return $retval;
	}
	else if($sake_code == "43") {
		$retval = "吟醸酒";
		return $retval;
	}
	else if($sake_code == "44") {
		$retval = "大吟醸酒";
		return $retval;
	}
	else if($sake_code == "45") {
		$retval = "非公開";
		return $retval;
	}
	else if($sake_code == "90") {
		$retval = "その他";
		return $retval;
	}
	else if($sake_code == "99") {
		$retval = "";
		return $retval;
	}
	else {
		$retval = "";
		return $retval;
	}
}

function GetSakeCategory($category_code)
{
	if($category_code == "11") {
		$retval = "無ろ過";
		return $retval;
	}
	else if($category_code == "21") {
		$retval = "にごり酒";
		return $retval;
	}
	else if($category_code == "22") {
		$retval = "あらばしり";
		return $retval;
	}
	else if($category_code == "31") {
		$retval = "中取り/中垂/中汲み";
		return $retval;
	}
	else if($category_code == "32") {
		$retval = "責め・押切";
		return $retval;
	}
	else if($category_code == "33") {
		$retval = "生酒・本生";
		return $retval;
	}
	else if($category_code == "34") {
		$retval = "生詰酒";
		return $retval;
	}
	else if($category_code == "35") {
		$retval = "生貯蔵酒";
		return $retval;
	}
	else if($category_code == "36") {
		$retval = "火入れ";
		return $retval;
	}
	else if($category_code == "37") {
		$retval = "ひやおろし・秋上がり";
		return $retval;
	}
	else if($category_code == "38") {
		$retval = "しずく酒・しずくしぼり・袋吊り・袋しぼり・斗瓶取り・斗瓶囲い";
		return $retval;
	}
	else if($category_code == "39") {
		$retval = "直汲み・直詰め";
		return $retval;
	}
	else if($category_code == "40") {
		$retval = "遠心分離";
		return $retval;
	}
	else if($category_code == "41") {
		$retval = "槽しぼり";
		return $retval;
	}
	else if($category_code == "42") {
		$retval = "きもと";
		return $retval;
	}
	else if($category_code == "43") {
		$retval = "山廃もと";
		return $retval;
	}
	else if($category_code == "44") {
		$retval = "樽酒";
		return $retval;
	}
	else if($category_code == "45") {
		$retval = "原酒";
		return $retval;
	}
	else if($category_code == "46") {
		$retval = "生一本";
		return $retval;
	}
	else if($category_code == "47") {
		$retval = "斗瓶取り・斗瓶囲い";
		return $retval;
	}
	else if($category_code == "48") {
		$retval = "古酒・長期貯蔵酒";
		return $retval;
	}
	else if($category_code == "49") {
		$retval = "おり酒・おりがらみ・うすにごり・ささにごり";
		return $retval;
	}
	else if($category_code == "50") {
		$retval = "新酒・初しぼり・しぼりたて";
		return $retval;
	}
	else if($category_code == "51") {
		$retval = "スパークリング";
		return $retval;
	}
	else if($category_code == "90") {
		$retval = "その他";
		return $retval;
	}
	else {
		$retval = "";
		return $retval;
	}
}

$category = $_GET["category"];
$keyword = ($_GET['keyword'] != null && $_GET['keyword'] != undefined) ? $_GET['keyword'] : "";
$pref = $_GET["pref"];
$special_name = $_GET["special_name"];
$seimai_rate = $_GET["seimai"];
$rice_used = $_GET["rice_used"];
$p_max = 25;
$page = ($_GET['page'] != null && $_GET['page'] != undefined) ? $_GET['page'] : 1;
$from = ($page - 1) * $p_max;
$to = $from + $p_max;
$sake_category = $_GET['sake_category'];

if(!empty($_POST['sake_category']))
	$sake_category = implode(',', $_GET['sake_category']);

print('<div id="container" data-category=' .$category
							.' data-from=' .$from
							.' data-to' .$to
							.' data-sake_category="' .$sake_category
							.'" data-seimai_rate=' .$seimai_rate
							.' data-rice_used=' .$rice_used
							.' data-special_name=' .$special_name
							.' data-keyword="' .$keyword
							.'" data-pref="' .$pref .'">');

	print('<form id="hidden_form" name="hidden_form" method="post">');
		print('<input type="hidden" id="category" name="category" value=' .$category .'>');
		print('<input type="hidden" id="hidden_sort" name="orderby" value="">');
		print('<input type="hidden" id="hidden_desc" name="desc" value="">');
	print('</form>');
	//print('<div>from:' .$from .' page:' .$page .'</div>');

	?>

	<div id="search_main_container">

		<div id="accordion">
			<div id="accordion_frame">
				<div id="pc_search">
					<div></div><p>検索カテゴリ</p>
				</div>
				<div id="tab_accordion">
					<ul class="simpleTabs">
						<li><a href="#tabs-29" class="active"><svg class="mobile_accordion_all3030"><use xlink:href="#all3030"/></svg><p>すべて<span>を探す</span></p></a></li>
						<li><a href="#tabs-30"><svg class="mobile_accordion_sake3630"><use xlink:href="#sake3630"/></svg><p>日本酒<span>を探す</span></p></a></li>
						<li><a href="#tabs-31"><svg class="mobile_accordion_brewery3630"><use xlink:href="#brewery3630"/></svg><p>酒蔵<span>を探す</span></p></a></li>
						<!--<li><a href="#tabs-32"><svg class="mobile_accordion_store3030"><use xlink:href="#store3030"/></svg><p>酒販店<span>を探す</span></p></a></li>
						<li><a href="#tabs-33"><svg class="mobile_accordion_restaurant3630"><use xlink:href="#restaurant3630"/></svg><p>飲食店<span>を探す</span></p></a></li>-->
					</ul>

					<div id="tabs-29" class="form-action show">
						<div class="mobilesake_container">
							<div class="mobilesake_content">
							<?php
								print('<input type="hidden" id="in_disp_all_from" name="in_disp_all_from" value=' .$from .'>');
							?>
							</div>
						</div>
					</div>

					<div id="tabs-30" class="form-action hide">
						<div class="mobilesake_container">
							<div class="mobilesake_content">
								<a class="sake_new_registry" href="sake_add_form.php">
									<svg class="mobile_pen1616"><use xlink:href="#pen1616"/></svg>
									<p>日本酒を登録する</p>
								</a>
								<div id="mobile_sake_searchplus">
									<svg class="mobile_searchplus3020"><use xlink:href="#searchplus3020"/></svg>
									<p>詳細検索</p>
								</div>
							</div>
						</div>
						<div id="tabs-30_content">
							<div class="accordion_tabs_title"><div></div><p>日本酒<span>の絞り込み</span></p></div>
							<form id="sake_sidebar_form" name="sake_sidebar_form" method="post">
								<div class="sake_option">
									<div class="search_option_row_container"><svg class="search_option_icon_map1216"><use xlink:href="#map1216"/></svg><p class="search_option_row_title">都道府県</p></div>
									<SELECT name="pref">
									  <OPTION VALUE="">指定なし</OPTION>
									  <OPTION VALUE="北海道" read="ほっかいどう">北海道</OPTION>
									  <OPTION VALUE="青森県" read="あおもりけん">青森県</OPTION>
									  <OPTION VALUE="岩手県" read="いわてけん">岩手県</OPTION>
									  <OPTION VALUE="宮城県" read="みやぎけん">宮城県</OPTION>
									  <OPTION VALUE="秋田県" read="あきたけん">秋田県</OPTION>
									  <OPTION VALUE="山形県" read="やまがたけん">山形県</OPTION>
									  <OPTION VALUE="福島県" read="ふくしまけん">福島県</OPTION>
									  <OPTION VALUE="茨城県" read="いばらぎけん">茨城県</OPTION>
									  <OPTION VALUE="栃木県" read="とちぎけん">栃木県</OPTION>
									  <OPTION VALUE="群馬県" read="ぐんまけん">群馬県</OPTION>
									  <OPTION VALUE="埼玉県" read="さいたまけん">埼玉県</OPTION>
									  <OPTION VALUE="千葉県" read="ちばけん">千葉県</OPTION>
									  <OPTION VALUE="東京都" read="とうきょうと">東京都</OPTION>
									  <OPTION VALUE="神奈川県" read="かながわけん">神奈川県</OPTION>
									  <OPTION VALUE="新潟県" read="にいがたけん">新潟県</OPTION>
									  <OPTION VALUE="富山県" read="とやまけん">富山県</OPTION>
									  <OPTION VALUE="石川県" read="いしかわけん">石川県</OPTION>
									  <OPTION VALUE="福井県" read="ふくいけん">福井県</OPTION>
									  <OPTION VALUE="山梨県" read="やまなしけん">山梨県</OPTION>
									  <OPTION VALUE="長野県" read="ながのけん">長野県</OPTION>
									  <OPTION VALUE="岐阜県" read="ぎふけん">岐阜県</OPTION>
									  <OPTION VALUE="静岡県" read="しずおかけん">静岡県</OPTION>
									  <OPTION VALUE="愛知県" read="あいちけん">愛知県</OPTION>
									  <OPTION VALUE="三重県" read="みえけん">三重県</OPTION>
									  <OPTION VALUE="滋賀県" read="しがけん">滋賀県</OPTION>
									  <OPTION VALUE="京都府" read="きょうとふ">京都府</OPTION>
									  <OPTION VALUE="大阪府" read="おおさかふ">大阪府</OPTION>
									  <OPTION VALUE="兵庫県" read="ひょうごけん">兵庫県</OPTION>
									  <OPTION VALUE="奈良県" read="ならけん">奈良県</OPTION>
									  <OPTION VALUE="和歌山県" read="わかやまけん">和歌山県</OPTION>
									  <OPTION VALUE="鳥取県" read="とっとりけん">鳥取県</OPTION>
									  <OPTION VALUE="島根県" read="しまねけん">島根県</OPTION>
									  <OPTION VALUE="岡山県" read="おかやまけん">岡山県</OPTION>
									  <OPTION VALUE="広島県" read="ひろしまけん">広島県</OPTION>
									  <OPTION VALUE="山口県" read="やまぐちけん">山口県</OPTION>
									  <OPTION VALUE="徳島県" read="とくしまけん">徳島県</OPTION>
									  <OPTION VALUE="香川県" read="かがわけん">香川県</OPTION>
									  <OPTION VALUE="愛媛県" read="えひめけん">愛媛県</OPTION>
									  <OPTION VALUE="高知県" read="こうちけん">高知県</OPTION>
									  <OPTION VALUE="福岡県" read="ふくおかけん">福岡県</OPTION>
									  <OPTION VALUE="佐賀県" read="さがけん">佐賀県</OPTION>
									  <OPTION VALUE="長崎県" read="ながさきけん">長崎県</OPTION>
									  <OPTION VALUE="熊本県" read="くまもとけん">熊本県</OPTION>
									  <OPTION VALUE="大分県" read="おおいたけん">大分県</OPTION>
									  <OPTION VALUE="宮崎県" read="みやざきけん">宮城県</OPTION>
									  <OPTION VALUE="鹿児島県" read="かごしまけん">鹿児島県</OPTION>
									  <OPTION VALUE="沖縄県" read="おきなわけん">沖縄県</OPTION>
									</SELECT>

						  		<!--<span class="sake_option_trigger">
										<span>都道府県</span>
										<p class="arrow_icon"><span></span></p>
									</span>

									<div class="dialog_sidebar">
										<ul>
											<label><li><input type="checkbox" name="pref[]" value="北海道">北海道</li></label>
											<label><li><input type="checkbox" name="pref[]" value="青森県">青森県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="岩手県">岩手県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="宮城県">宮城県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="秋田県">秋田県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="山形県">山形県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="福島県">福島県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="茨城県">茨城県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="栃木県">栃木県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="群馬県">群馬県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="埼玉県">埼玉県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="千葉県">千葉県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="東京都">東京都</li></label>
											<label><li><input type="checkbox" name="pref[]" value="神奈川県">神奈川県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="新潟県">新潟県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="富山県">富山県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="石川県">石川県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="福井県">福井県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="山梨県">山梨県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="長野県">長野県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="岐阜県">岐阜県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="静岡県">静岡県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="愛知県">愛知県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="三重県">三重県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="滋賀県">滋賀県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="京都府">京都府</li></label>
											<label><li><input type="checkbox" name="pref[]" value="大阪府">大阪府</li></label>
											<label><li><input type="checkbox" name="pref[]" value="兵庫県">兵庫県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="奈良県">奈良県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="和歌山県">和歌山県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="鳥取県">鳥取県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="島根県">島根県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="岡山県">岡山県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="広島県">広島県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="山口県">山口県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="徳島県">徳島県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="香川県">香川県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="愛媛県">愛媛県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="高知県">高知県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="福岡県">福岡県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="佐賀県">佐賀県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="長崎県">長崎県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="熊本県">熊本県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="大分県">大分県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="宮城県">宮城県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="鹿児島県">鹿児島県</li></label>
											<label><li><input type="checkbox" name="pref[]" value="沖縄県">沖縄県</li></label>
										</ul>
									</div>-->
								</div>

								<div class="sake_option">
									<div class="search_option_row_container"><svg class="search_option_icon_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg><p class="search_option_row_title">特定名称</p></div>
									<SELECT name="special_name">
										<OPTION VALUE="">指定なし</OPTION>
										<OPTION VALUE="11">普通酒</OPTION>
										<OPTION VALUE="21">本醸造酒</OPTION>
										<OPTION VALUE="22">特別本醸造酒</OPTION>
										<OPTION VALUE="31">純米酒</OPTION>
										<OPTION VALUE="32">特別純米酒</OPTION>
										<OPTION VALUE="33">純米吟醸酒</OPTION>
										<OPTION VALUE="34">純米大吟醸酒</OPTION>
										<OPTION VALUE="43">吟醸酒</OPTION>
										<OPTION VALUE="44">大吟醸酒</OPTION>
										<OPTION VALUE="99">非公開</OPTION>
										<OPTION VALUE="90">その他</OPTION>
									</SELECT>

									<!--<span class="sake_option_trigger">
										<span>特定名称</span>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<label><li><input type="checkbox" name="special_name[]" value="11">普通酒</li></label>
											<label><li><input type="checkbox" name="special_name[]" value="21">本醸造酒</li></label>
											<label><li><input type="checkbox" name="special_name[]" value="22">特別本醸造酒</li></label>
											<label><li><input type="checkbox" name="special_name[]" value="31">純米酒</li></label>
											<label><li><input type="checkbox" name="special_name[]" value="32">特別純米酒</li></label>
											<label><li><input type="checkbox" name="special_name[]" value="33">純米吟醸酒</li></label>
											<label><li><input type="checkbox" name="special_name[]" value="34">純米大吟醸酒</li></label>
											<label><li><input type="checkbox" name="special_name[]" value="43">吟醸酒</li></label>
											<label><li><input type="checkbox" name="special_name[]" value="44">大吟醸酒</li></label>
											<label><li><input type="checkbox" name="special_name[]" value="99">非公開</li></label>
				 							<label><li><input type="checkbox" name="special_name[]" value="90">その他</li></label>
										</ul>
									</div>-->
								</div>

								<div class="sake_option_seiho">
									<span class="sake_option_trigger">
										<div class="search_option_row_container">
											<svg class="search_option_icon_oke2020"><use xlink:href="#oke2020"/></svg>
											<p class="search_option_row_title">製法の特徴</p>
										</div>
										<div class="search_option_row_text">選択する</div>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<label><li><input type="checkbox" name="sake_category[]" value="11">無濾過</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="45">原酒</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="39">直汲み・直詰め</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="33">生酒・本生</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="35">生貯蔵酒</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="34">生詰酒</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="21">にごり酒</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="49">おりがらみ・うすにごり</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="51">スパークリング</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="42">きもと</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="43">山廃もと</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="38">袋吊り・斗瓶囲い・雫酒</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="41">槽しぼり</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="40">遠心分離</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="22">あらばしり</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="31">中取り・中汲み・中垂れ</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="32">責め・押切り</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="50">新酒・初しぼり・しぼりたて</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="37">ひやおろし・秋上がり</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="48">古酒・長期熟成酒</li></label>
											<label><li><input type="checkbox" name="sake_category[]" value="44">樽酒</li></label>
										</ul>
									</div>
								</div>

								<div class="sake_option">
									<div class="search_option_row_container"><svg class="search_option_icon_rice1616"><use xlink:href="#rice1616"/></svg><p class="search_option_row_title">原料米</p></div>
									<SELECT name="rice_used">
										<OPTION VALUE="">指定なし</OPTION>
										<OPTION VALUE="kokusanmai" kanji="国産米">国産米</OPTION>
										<OPTION VALUE="yamadanishiki" kanji="山田錦">山田錦</OPTION>
										<OPTION VALUE="gohyakumangoku" kanji="五百万石">五百万石</OPTION>
										<OPTION VALUE="omachi" kanji="雄町">雄町</OPTION>
										<OPTION VALUE="aiyama" kanji="愛山">愛山</OPTION>
										<OPTION VALUE="akitashukomachi" kanji="秋田酒こまち">秋田酒こまち</OPTION>
										<OPTION VALUE="akinosei" kanji="秋の精">秋の精</OPTION>
										<OPTION VALUE="ipponjime" kanji="一本〆">一本〆</OPTION>
										<OPTION VALUE="oyamanishiki" kanji="雄山錦">雄山錦</OPTION>
										<OPTION VALUE="kairyoshinko" kanji="改良信交">改良信交</OPTION>
										<OPTION VALUE="kamenoo" kanji="亀の尾">亀の尾</OPTION>
										<OPTION VALUE="ginotome" kanji="ぎんおとめ">ぎんおとめ</OPTION>
										<OPTION VALUE="ginginga" kanji="吟ぎんが">吟ぎんが</OPTION>
										<OPTION VALUE="ginnosato" kanji="吟のさと">吟のさと</OPTION>
										<OPTION VALUE="ginnosei" kanji="吟の精">吟の精</OPTION>
										<OPTION VALUE="gimpu" kanji="吟風">吟風</OPTION>
										<OPTION VALUE="ginfubuki" kanji="吟吹雪">吟吹雪</OPTION>
										<OPTION VALUE="kinmonnishiki" kanji="金紋錦">金紋錦</OPTION>
										<OPTION VALUE="kuranohana" kanji="蔵の華">蔵の華</OPTION>
										<OPTION VALUE="koshitanrei" kanji="越淡麗">越淡麗</OPTION>
										<OPTION VALUE="koshinoshizuku" kanji="越の雫">越の雫</OPTION>
										<OPTION VALUE="saitonoshizuku" kanji="西都の雫">西都の雫</OPTION>
										<OPTION VALUE="sakemirai" kanji="酒未来">酒未来</OPTION>
										<OPTION VALUE="sakemusashi" kanji="さけ武蔵">さけ武蔵</OPTION>
										<OPTION VALUE="shinriki" kanji="神力">神力</OPTION>
										<OPTION VALUE="suisei" kanji="彗星">彗星</OPTION>
										<OPTION VALUE="senbonnishiki" kanji="千本錦">千本錦</OPTION>
										<OPTION VALUE="tatsunootoshigo" kanji="龍の落とし子">龍の落とし子</OPTION>
										<OPTION VALUE="tamazakae" kanji="玉栄">玉栄</OPTION>
										<OPTION VALUE="dewasansan" kanji="出羽燦々">出羽燦々</OPTION>
										<OPTION VALUE="dewanosato" kanji="出羽の里">出羽の里</OPTION>
										<OPTION VALUE="hattan" kanji="八反">八反</OPTION>
										<OPTION VALUE="hattannishiki" kanji="八反錦">八反錦</OPTION>
										<OPTION VALUE="hanaomoi" kanji="華想い">華想い</OPTION>
										<OPTION VALUE="hanafubuki" kanji="華吹雪">華吹雪</OPTION>
										<OPTION VALUE="hitachinishiki" kanji="ひたち錦">ひたち錦</OPTION>
										<OPTION VALUE="hitogokochi" kanji="ひとごこち">ひとごこち</OPTION>
										<OPTION VALUE="hohai" kanji="豊盃">豊盃</OPTION>
										<OPTION VALUE="hoshiakari" kanji="星あかり">星あかり</OPTION>
										<OPTION VALUE="maikaze" kanji="舞風">舞風</OPTION>
										<OPTION VALUE="misatonishiki" kanji="美郷錦">美郷錦</OPTION>
										<OPTION VALUE="miyamanishiki" kanji="美山錦">美山錦</OPTION>
										<OPTION VALUE="yamasakeyongo" kanji="山酒4号（玉苗）">山酒4号（玉苗）</OPTION>
										<OPTION VALUE="yamadaho" kanji="山田穂">山田穂</OPTION>
										<OPTION VALUE="yuinoka" kanji="結の香">結の香</OPTION>
										<OPTION VALUE="yumenoka" kanji="夢の香">夢の香</OPTION>
										<OPTION VALUE="wakamizu" kanji="若水">若水</OPTION>
										<OPTION VALUE="wataribune" kanji="渡船">渡船</OPTION>
										<OPTION VALUE="other" kanji="その他">その他</OPTION>
									</SELECT>

									<!--<span class="sake_option_trigger">
										<span>原料米</span>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<label><li value="kokusanmai"><input type="checkbox" name="rice_used[]" value="kokusanmai">国産米</li></label>
											<label><li value="yamadanishiki"><input type="checkbox" name="rice_used[]" value="yamadanishiki">山田錦</li></label>
											<label><li value="gohyakumangoku"><input type="checkbox" name="rice_used[]" value="gohyakumangoku">五百万石</li></label>
											<label><li value="omachi"><input type="checkbox" name="rice_used[]" value="omachi">雄町</li></label>
											<label><li value="aiyama"><input type="checkbox" name="rice_used[]" value="aiyama">愛山</li></label>
											<label><li value="akitashukomachi"><input type="checkbox" name="rice_used[]" value="akitashukomachi">秋田酒こまち</li></label>
											<label><li value="akinosei"><input type="checkbox" name="rice_used[]" value="akinosei">秋の精</li></label>
											<label><li value="ipponjime"><input type="checkbox" name="rice_used[]" value="ipponjime">一本〆</li></label>
											<label><li value="oyamanishiki"><input type="checkbox" name="rice_used[]" value="oyamanishiki">雄山錦</li></label>
											<label><li value="kairyoshinko"><input type="checkbox" name="rice_used[]" value="kairyoshinko">改良信交</li></label>
											<label><li value="kamenoo"><input type="checkbox" name="rice_used[]" value="kamenoo">亀の尾</li></label>
											<label><li value="ginotome"><input type="checkbox" name="rice_used[]" value="ginotome">ぎんおとめ</li></label>
											<label><li value="ginginga"><input type="checkbox" name="rice_used[]" value="ginginga">吟ぎんが</li></label>
											<label><li value="ginnosato"><input type="checkbox" name="rice_used[]" value="ginnosato">吟のさと</li></label>
											<label><li value="ginnosei"><input type="checkbox" name="rice_used[]" value="ginnosei">吟の精</li></label>
											<label><li value="gimpu"><input type="checkbox" name="rice_used[]" value="gimpu">吟風</li></label>
											<label><li value="ginfubuki"><input type="checkbox" name="rice_used[]" value="ginfubuki">吟吹雪</li></label>
											<label><li value="kinmonnishiki"><input type="checkbox" name="rice_used[]" value="kinmonnishiki">金紋錦</li></label>
											<label><li value="kuranohana"><input type="checkbox" name="rice_used[]" value="kuranohana">蔵の華</li></label>
											<label><li value="koshitanrei"><input type="checkbox" name="rice_used[]" value="koshitanrei">越淡麗</li></label>
											<label><li value="koshinoshizuku"><input type="checkbox" name="rice_used[]" value="koshinoshizuku">越の雫</li></label>
											<label><li value="saitonoshizuku"><input type="checkbox" name="rice_used[]" value="saitonoshizuku">西都の雫</li></label>
											<label><li value="sekemirai"><input type="checkbox" name="rice_used[]" value="sekemirai">酒未来</li></label>
											<label><li value="sakemusashi"><input type="checkbox" name="rice_used[]" value="sakemusashi">さけ武蔵</li></label>
											<label><li value="shinriki"><input type="checkbox" name="rice_used[]" value="shinriki">神力</li></label>
											<label><li value="suisei"><input type="checkbox" name="rice_used[]" value="suisei">彗星</li></label>
											<label><li value="senbonnishiki"><input type="checkbox" name="rice_used[]" value="senbonnishiki">千本錦</li></label>
											<label><li value="tatsunootoshigo"><input type="checkbox" name="rice_used[]" value="tatsunootoshigo">龍の落とし子</li></label>
											<label><li value="tamazakae"><input type="checkbox" name="rice_used[]" value="tamazakae">玉栄</li></label>
											<label><li value="dewasansan"><input type="checkbox" name="rice_used[]" value="dewasansan">出羽燦々</li></label>
											<label><li value="dewanosato"><input type="checkbox" name="rice_used[]" value="dewanosato">出羽の里</li></label>
											<label><li value="hattan"><input type="checkbox" name="rice_used[]" value="hattan">八反</li></label>
											<label><li value="hattannishiki"><input type="checkbox" name="rice_used[]" value="hattannishiki">八反錦</li></label>
											<label><li value="hanaomoi"><input type="checkbox" name="rice_used[]" value="hanaomoi">華想い</li></label>
											<label><li value="hanafubuki"><input type="checkbox" name="rice_used[]" value="hanafubuki">華吹雪</li></label>
											<label><li value="hitachinishiki"><input type="checkbox" name="rice_used[]" value="hitachinishiki">ひたち錦</li></label>
											<label><li value="hitogokochi"><input type="checkbox" name="rice_used[]" value="hitogokochi">ひとごこち</li></label>
											<label><li value="hohai"><input type="checkbox" name="rice_used[]" value="hohai">豊盃</li></label>
											<label><li value="hoshiakari"><input type="checkbox" name="rice_used[]" value="hoshiakari">星あかり</li></label>
											<label><li value="maikaze"><input type="checkbox" name="rice_used[]" value="maikaze">舞風</li></label>
											<label><li value="misatonishiki"><input type="checkbox" name="rice_used[]" value="misatonishiki">美郷錦</li></label>
											<label><li value="miyamanishiki"><input type="checkbox" name="rice_used[]" value="miyamanishiki">美山錦</li></label>
											<label><li value="yamasakeyongo"><input type="checkbox" name="rice_used[]" value="yamasakeyongo">山酒4号（玉苗）</li></label>
											<label><li value="yamadaho"><input type="checkbox" name="rice_used[]" value="yamadaho">山田穂</li></label>
											<label><li value="yuinoka"><input type="checkbox" name="rice_used[]" value="yuinoka">結の香</li></label>
											<label><li value="yumenoka"><input type="checkbox" name="rice_used[]" value="yumenoka">夢の香</li></label>
											<label><li value="wakamizu"><input type="checkbox" name="rice_used[]" value="wakamizu">若水</li></label>
											<label><li value="wataribune"><input type="checkbox" name="rice_used[]" value="wataribune">渡船</li></label>
											<label><li value="other"><input type="checkbox" name="rice_used[]" value="other">その他</li></label>
										</ul>
									</div>-->
								</div>

								<div class="sake_option">
									<div class="search_option_row_container"><svg class="search_option_icon_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg><p class="search_option_row_title">精米歩合</p></div>
									<SELECT name="seimai_rate">
									  <OPTION VALUE="">指定なし</OPTION>
									  <OPTION VALUE="19">20%未満</OPTION>
									  <OPTION VALUE="20">20%以上30%未満</OPTION>
									  <OPTION VALUE="30">30%以上40%未満</OPTION>
									  <OPTION VALUE="40">40%以上50%未満</OPTION>
									  <OPTION VALUE="50">50%以上60%未満</OPTION>
									  <OPTION VALUE="60">60%以上70%未満</OPTION>
									  <OPTION VALUE="70">70%以上</OPTION>
									</SELECT>

									<!--<span class="sake_option_trigger">
										<span>精米歩合</span>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<label><li style="width:108px"><input type="checkbox" name="seimai_rate[]" value="1">71%以上</li></label>
											<label><li style="width:108px"><input type="checkbox" name="seimai_rate[]" value="2">70%～61%</li></label>
											<label><li style="width:108px"><input type="checkbox" name="seimai_rate[]" value="3">60%～51%</li></label>
											<label><li style="width:108px"><input type="checkbox" name="seimai_rate[]" value="4">50%～41%</li></label>
											<label><li style="width:108px"><input type="checkbox" name="seimai_rate[]" value="5">40%～31%</li></label>
											<label><li style="width:108px"><input type="checkbox" name="seimai_rate[]" value="6">30%～21%</li></label>
											<label><li style="width:108px"><input type="checkbox" name="seimai_rate[]" value="7">20%以下</li></label>
										</ul>
									</div>-->
								</div>

								<!--非表示中<div class="sake_option">
									<div class="search_option_row_container"><svg class="search_option_icon_alc1616"><use xlink:href="#alc1616"/></svg><p class="search_option_row_title">Alc度数</p></div>
									<SELECT read="" name="alcohol_level">
									  <OPTION VALUE="">指定なし</OPTION>
									  <OPTION VALUE="">13%未満</OPTION>
									  <OPTION VALUE="">13%以上14%未満</OPTION>
									  <OPTION VALUE="">14%以上15%未満</OPTION>
									  <OPTION VALUE="">15%以上16%未満</OPTION>
									  <OPTION VALUE="">16%以上17%未満</OPTION>
									  <OPTION VALUE="">17%以上18%未満</OPTION>
									  <OPTION VALUE="">18%以上</OPTION>
									</SELECT>-->

									<!--<span class="sake_option_trigger">
										<span>Alc度数</span>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<label><li style="width:108px"><input type="checkbox" name="alcohol_level[]" value="1">13度未満</li></label>
											<label><li style="width:108px"><input type="checkbox" name="alcohol_level[]" value="2">13度～14度</li></label>
											<label><li style="width:108px"><input type="checkbox" name="alcohol_level[]" value="3">14度～15度</li></label>
											<label><li style="width:108px"><input type="checkbox" name="alcohol_level[]" value="4">15度～16度</li></label>
											<label><li style="width:108px"><input type="checkbox" name="alcohol_level[]" value="5">16度～17度</li></label>
											<label><li style="width:108px"><input type="checkbox" name="alcohol_level[]" value="6">17度～18度</li></label>
											<label><li style="width:108px"><input type="checkbox" name="alcohol_level[]" value="7">18度以上</li></label>
										</ul>
									</div>-->
								<!--非表示中</div>-->

								<!--非表示中<div class="sake_option">
									<div class="search_option_row_container"><svg class="search_option_icon_nihonshudo1616"><use xlink:href="#nihonshudo1616"/></svg><p class="search_option_row_title">日本酒度</p></div>
									<SELECT read="" name="jsake_level">
									  <OPTION VALUE="">指定なし</OPTION>
									  <OPTION VALUE="">-6.0未満</OPTION>
									  <OPTION VALUE="">-6.0以上-3.4未満</OPTION>
									  <OPTION VALUE="">-3.4以上-1.4未満</OPTION>
									  <OPTION VALUE="">-1.4以上+1.5未満</OPTION>
									  <OPTION VALUE="">+1.5以上+3.5未満</OPTION>
									  <OPTION VALUE="">+3.5以上+6.0未満</OPTION>
									  <OPTION VALUE="">+6.0以上</OPTION>
									</SELECT>-->

									<!--<span class="sake_option_trigger">
										<span>日本酒度</span>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<label><li style="width:108px"><input type="checkbox" name="jsake_level[]" value="1">-6.0以下</li></label>
											<label><li style="width:108px"><input type="checkbox" name="jsake_level[]" value="2">-5.9～-3.5</li></label>
											<label><li style="width:108px"><input type="checkbox" name="jsake_level[]" value="3">-3.4～-1.5</li></label>
											<label><li style="width:108px"><input type="checkbox" name="jsake_level[]" value="4">-1.4～+1.4</li></label>
											<label><li style="width:108px"><input type="checkbox" name="jsake_level[]" value="5">+1.5～+3.4</li></label>
											<label><li style="width:108px"><input type="checkbox" name="jsake_level[]" value="6">+3.5～+5.9</li></label>
											<label><li style="width:108px"><input type="checkbox" name="jsake_level[]" value="7">+6.0以上</li></label>
										</ul>
									</div>-->
								<!--非表示中</div>-->

								<!--<div class="sake_option">
									<span class="sake_option_trigger">
										<span>酸度</span>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<label><li><input type="checkbox" name="oxidation_level[]" value="1">0.5以下</li></label>
											<label><li><input type="checkbox" name="oxidation_level[]" value="2">0.6～1.0</li></label>
											<label><li><input type="checkbox" name="oxidation_level[]" value="3">1.1～1.5</li></label>
											<label><li><input type="checkbox" name="oxidation_level[]" value="4">1.6～2.0</li></label>
											<label><li><input type="checkbox" name="oxidation_level[]" value="5">2.1～2.5</li></label>
											<label><li><input type="checkbox" name="oxidation_level[]" value="6">2.6以上</li></label>
										</ul>
									</div>
								</div>-->

								<!--<div class="sake_option">
									<span class="sake_option_trigger">
										<span>フレーバー</span>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<li value="melon"><input type="checkbox" name="flavour[]" value="2">メロン</li>
											<li value="peach"><input type="checkbox" name="flavour[]" value="3">桃</li>
										</ul>
									</div>
								</div>-->

								<!--<div class="sake_option">
									<span class="sake_option_trigger">
										<span>鑑評会・コンクール</span>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<li><input type="checkbox" name="sake_award_history[]" value="1">全国新酒鑑評会</li>
											<li><input type="checkbox" name="sake_award_history[]" value="2">International SAKE Challenge</li>
											<li><input type="checkbox" name="sake_award_history[]" value="3">全米日本酒歓評会</li>
											<li><input type="checkbox" name="sake_award_history[]" value="4">SAKE COMPETITION</li>
										</ul>
									</div>
								</div>-->

								<!-- hidden data -->
								<?php
									print('<input type="hidden" id="in_disp_sake_from" name="from" value=' . $from .'>');
									print('<input type="hidden" id="in_disp_sake_to"   name="to" value=' .$to .'>');
								?>
								<input type="hidden" id="show_pos" name="show_pos" value=0>
								<!-- end hidden data -->
							</form>

							<div class="mobile_accordion_button_container">
								<button id="mobile_accordion_search_clear">クリア</button>
								<button id="submit_sake_search">検索</button>
							</div>
						</div>
					</div>

					<div id="tabs-31" class="form-action hide">
						<div class="mobilesake_container">
							<div class="mobilesake_content">
								<a class="sake_new_registry" href="sda_add_form.php">
									<svg class="mobile_pen1616"><use xlink:href="#pen1616"/></svg>
									<p>酒蔵を登録する</p>
								</a>
								<div id="mobile_brewery_searchplus">
									<svg class="mobile_searchplus3020"><use xlink:href="#searchplus3020"/></svg>
									<p>詳細検索</p>
								</div>
							</div>
						</div>
						<div id="tabs-31_content">
							<div class="accordion_tabs_title"><div></div><p>酒蔵<span>の絞り込み</span></p></div>
							<div>
								<form id="sakagura_sidebar_form" name="sakagura_sidebar_form" method="post">

									<!-- hidden data -->
									<?php
										print('<input type="hidden" id="in_disp_sakagura_from" name="from" value=' .$from .'>');
									?>
									<!-- end hidden data -->

									<div class="sakagura_option">
										<div class="search_option_row_container"><svg class="search_option_icon_map1216"><use xlink:href="#map1216"/></svg><p class="search_option_row_title">都道府県</p></div>
										<SELECT read="" name="sakagura_pref">
										  <OPTION VALUE="" read="">指定なし</OPTION>
										  <OPTION VALUE="北海道" read="ほっかいどう">北海道</OPTION>
										  <OPTION VALUE="青森県" read="あおもりけん">青森県</OPTION>
										  <OPTION VALUE="岩手県" read="いわてけん">岩手県</OPTION>
										  <OPTION VALUE="宮城県" read="みやぎけん">宮城県</OPTION>
										  <OPTION VALUE="秋田県" read="あきたけん">秋田県</OPTION>
										  <OPTION VALUE="山形県" read="やまがたけん">山形県</OPTION>
										  <OPTION VALUE="福島県" read="ふくしまけん">福島県</OPTION>
										  <OPTION VALUE="茨城県" read="いばらぎけん">茨城県</OPTION>
										  <OPTION VALUE="栃木県" read="とちぎけん">栃木県</OPTION>
										  <OPTION VALUE="群馬県" read="ぐんまけん">群馬県</OPTION>
										  <OPTION VALUE="埼玉県" read="さいたまけん">埼玉県</OPTION>
										  <OPTION VALUE="千葉県" read="ちばけん">千葉県</OPTION>
										  <OPTION VALUE="東京都" read="とうきょうと">東京都</OPTION>
										  <OPTION VALUE="神奈川県" read="かながわけん">神奈川県</OPTION>
										  <OPTION VALUE="新潟県" read="にいがたけん">新潟県</OPTION>
										  <OPTION VALUE="富山県" read="とやまけん">富山県</OPTION>
										  <OPTION VALUE="石川県" read="いしかわけん">石川県</OPTION>
										  <OPTION VALUE="福井県" read="ふくいけん">福井県</OPTION>
										  <OPTION VALUE="山梨県" read="やまなしけん">山梨県</OPTION>
										  <OPTION VALUE="長野県" read="ながのけん">長野県</OPTION>
										  <OPTION VALUE="岐阜県" read="ぎふけん">岐阜県</OPTION>
										  <OPTION VALUE="静岡県" read="しずおかけん">静岡県</OPTION>
										  <OPTION VALUE="愛知県" read="あいちけん">愛知県</OPTION>
										  <OPTION VALUE="三重県" read="みえけん">三重県</OPTION>
										  <OPTION VALUE="滋賀県" read="しがけん">滋賀県</OPTION>
										  <OPTION VALUE="京都府" read="きょうとふ">京都府</OPTION>
										  <OPTION VALUE="大阪府" read="おおさかふ">大阪府</OPTION>
										  <OPTION VALUE="兵庫県" read="ひょうごけん">兵庫県</OPTION>
										  <OPTION VALUE="奈良県" read="ならけん">奈良県</OPTION>
										  <OPTION VALUE="和歌山県" read="わかやまけん">和歌山県</OPTION>
										  <OPTION VALUE="鳥取県" read="とっとりけん">鳥取県</OPTION>
										  <OPTION VALUE="島根県" read="しまねけん">島根県</OPTION>
										  <OPTION VALUE="岡山県" read="おかやまけん">岡山県</OPTION>
										  <OPTION VALUE="広島県" read="ひろしまけん">広島県</OPTION>
										  <OPTION VALUE="山口県" read="やまぐちけん">山口県</OPTION>
										  <OPTION VALUE="徳島県" read="とくしまけん">徳島県</OPTION>
										  <OPTION VALUE="香川県" read="かがわけん">香川県</OPTION>
										  <OPTION VALUE="愛媛県" read="えひめけん">愛媛県</OPTION>
										  <OPTION VALUE="高知県" read="こうちけん">高知県</OPTION>
										  <OPTION VALUE="福岡県" read="ふくおかけん">福岡県</OPTION>
										  <OPTION VALUE="佐賀県" read="さがけん">佐賀県</OPTION>
										  <OPTION VALUE="長崎県" read="ながさきけん">長崎県</OPTION>
										  <OPTION VALUE="熊本県" read="くまもとけん">熊本県</OPTION>
										  <OPTION VALUE="大分県" read="おおいたけん">大分県</OPTION>
										  <OPTION VALUE="宮崎県" read="みやざきけん">宮城県</OPTION>
										  <OPTION VALUE="鹿児島県" read="かごしまけん">鹿児島県</OPTION>
										  <OPTION VALUE="沖縄県" read="おきなわけん">沖縄県</OPTION>
										</SELECT>

										<!--<span class="sakagura_option_trigger">
											<span name="sakagura_pref" value="">都道府県</span>
											<p class="arrow_icon"><span></span></p>
										</span>
										<div class="dialog_sidebar">
											<ul>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="北海道">北海道</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="青森県">青森県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="岩手県">岩手県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="宮城県">宮城県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="秋田県">秋田県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="山形県">山形県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="福島県">福島県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="茨城県">茨城県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="栃木県">栃木県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="群馬県">群馬県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="埼玉県">埼玉県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="千葉県">千葉県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="東京都">東京都</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="神奈川県">神奈川県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="新潟県">新潟県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="富山県">富山県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="石川県">石川県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="福井県">福井県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="山梨県">山梨県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="長野県">長野県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="岐阜県">岐阜県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="静岡県">静岡県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="愛知県">愛知県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="三重県">三重県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="滋賀県">滋賀県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="京都府">京都府</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="大阪府">大阪府</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="兵庫県">兵庫県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="奈良県">奈良県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="和歌山県">和歌山県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="鳥取県">鳥取県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="島根県">島根県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="岡山県">岡山県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="広島県">広島県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="山口県">山口県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="徳島県">徳島県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="香川県">香川県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="愛媛県">愛媛県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="高知県">高知県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="福岡県">福岡県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="佐賀県">佐賀県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="長崎県">長崎県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="熊本県">熊本県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="大分県">大分県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="宮城県">宮城県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="鹿児島県">鹿児島県</li></label>
												<label><li><input type="checkbox" name="sakagura_pref[]" value="沖縄県">沖縄県</li></label>
											</ul>
										</div>-->
									</div>

									<div class="sakagura_option">
										<div class="search_option_row_container"><svg class="search_option_icon_visit1616"><use xlink:href="#visit1616"/></svg><p class="search_option_row_title">酒蔵見学</p></div>
										<SELECT name="observation">
										  <OPTION VALUE="" read="">指定なし</OPTION>
										  <OPTION VALUE="1">可</OPTION>
										</SELECT>

									</div>

									<!--<div class="sakagura_option">
										<span class="sakagura_option_trigger">
											<span>酒蔵直販店</span>
											<p class="arrow_icon"><span></span></p>
										</span>
										<div class="dialog_sidebar">
											<label><span><input id="direct_sale" type="checkbox" name="direct_sale" value = "1">あり</span></label>
										</div>
									</div>

					    			<div class="sakagura_option">
					      			<span class="sakagura_option_trigger">
										<span>酒造組合</span>
					      			</span>
					      			<div class="dialog_sidebar">
					        			<ul>
										  <label><li><input type="radio" name="kumimai" value="">指定なし</li></label>
										  <label><li><input type="radio" name="kumimai" value=10>あり</li></label>
										  <label><li><input type="radio" name="kumimai" value=11>なし</li></label>
										  <label><li><input type="radio" name="kumimai" value=12>不明</li></label>
										</ul>
									  </div>
									</div>

					    			<div class="sakagura_option">
									  <span class="sakagura_option_trigger">
												<span>国税庁登録</span>
									  </span>
									  <div class="dialog_sidebar">
										<ul>
										  <label><li><input type="radio" name="kokuzei" value="">指定なし</li></label>
										  <label><li><input type="radio" name="kokuzei" value=10>あり</li></label>
										  <label><li><input type="radio" name="kokuzei" value=11>なし</li></label>
										  <label><li><input type="radio" name="kokuzei" value=12>不明</li></label>
										</ul>
									  </div>
									</div>

									<div class="sakagura_option">
							  		<span class="sakagura_option_trigger">
											<span>ステータス</span>
							  		</span>
							  		<div class="dialog_sidebar">
											<ul>
											  <label><li><input type="radio" name="status" value="">指定なし</li></label>
											  <label><li><input type="radio" name="status" value=10>active</li></label>
											  <label><li><input type="radio" name="status" value=11>inactive</li></label>
											  <label><li style="width:112px"><input type="radio" name="status" value=12>一時製造休止</li></label>
											  <label><li><input type="radio" name="status" value=13>営業不明</li></label>
											</ul>
							  		</div>
									</div>-->

								</form>

								<div class="mobile_accordion_button_container">
									<button id="mobile_accordion_search_clear">クリア</button>
									<button id="submit_sakagura_search">検索</button>
								</div>
							</div>
						</div> <!-- tab -->
					</div>


					<!--<div id="tabs-32_content" style="overflow:auto; padding:4px 2px 4px 2px; border:0px solid #c6c6c6" class="form-action hide">
						<div class="accordion_tabs_title"><div></div><p>酒販店<span>の絞り込み</span></p></div>
						<div style="overflow:auto; max-height:380px">
				  		<div class="accordion_title" value="syuhanten_accordion">
								<img style="vertical-align:middle; margin:2px; height:20px" src="images/icons/syuhanten.svg"><span style="margin-left:4px">酒販店の絞り込み<span><img style="float:right; width:20px; vertical-align:middle; margin:2px" src="images/icons/expand.svg">
							</div>
							<form id="syuhanten_sidebar_form" name="syuhanten_sidebar_form" method="post">

								<input type="hidden" id="in_syuhanten_disp_from"	name="from" value=0>
								<input type="hidden" id="in_syuhanten_disp_to"		name="to"	 value=25>
								<input type="hidden" id="hidden_syuhanten_count_query" name="count_query" value=0>

								<div class="syuhanten_option" style="margin:0px; padding:0px">
									<span style="float:left; width:100px;">
										<img style="margin:auto 4px auto 4px" src="images/icons/searchdot.svg">都道府県
									</span>
								  <span class="syuhanten_option_trigger">
										<span style="float:left; overflow:hidden; margin:0px; width:120px" name="syuhanten_pref" value="">指定なし</span>
										<span style="float:right; color:#c6c6c6; width:16px">&#x25BC;</span>
									</span>
									<div class="dialog_sidebar" style="overflow:auto; margin:0px">
										<ul style="margin:0px">
											<li value="北海道"><input type="checkbox" name="syuhanten_pref[]" value="北海道">北海道</li>
											<li value="青森県"><input type="checkbox" name="syuhanten_pref[]" value="青森県">青森県</li>
											<li value="岩手県"><input type="checkbox" name="syuhanten_pref[]" value="岩手県">岩手県</li>
											<li value="宮城県"><input type="checkbox" name="syuhanten_pref[]" value="宮城県">宮城県</li>
											<li value="秋田県"><input type="checkbox" name="syuhanten_pref[]" value="秋田県">秋田県</li>
											<li value="山形県"><input type="checkbox" name="syuhanten_pref[]" value="山形県">山形県</li>
											<li value="福島県"><input type="checkbox" name="syuhanten_pref[]" value="福島県">福島県</li>
											<li value="茨城県"><input type="checkbox" name="syuhanten_pref[]" value="茨城県">茨城県</li>
											<li value="栃木県"><input type="checkbox" name="syuhanten_pref[]" value="栃木県">栃木県</li>
											<li value="群馬県"><input type="checkbox" name="syuhanten_pref[]" value="群馬県">群馬県</li>
											<li value="埼玉県"><input type="checkbox" name="syuhanten_pref[]" value="埼玉県">埼玉県</li>
											<li value="千葉県"><input type="checkbox" name="syuhanten_pref[]" value="千葉県">千葉県</li>
											<li value="東京都"><input type="checkbox" name="syuhanten_pref[]" value="東京都">東京都</li>
											<li value="神奈川県"><input type="checkbox" name="syuhanten_pref[]" value="神奈川県">神奈川県</li>
											<li value="新潟県"><input type="checkbox" name="syuhanten_pref[]" value="新潟県">新潟県</li>
											<li value="富山県"><input type="checkbox" name="syuhanten_pref[]" value="富山県">富山県</li>
											<li value="石川県"><input type="checkbox" name="syuhanten_pref[]" value="石川県">石川県</li>
											<li value="福井県"><input type="checkbox" name="syuhanten_pref[]" value="福井県">福井県</li>
											<li value="山梨県"><input type="checkbox" name="syuhanten_pref[]" value="山梨県">山梨県</li>
											<li value="長野県"><input type="checkbox" name="syuhanten_pref[]" value="長野県">長野県</li>
											<li value="岐阜県"><input type="checkbox" name="syuhanten_pref[]" value="岐阜県">岐阜県</li>
											<li value="静岡県"><input type="checkbox" name="syuhanten_pref[]" value="静岡県">静岡県</li>
											<li value="愛知県"><input type="checkbox" name="syuhanten_pref[]" value="愛知県">愛知県</li>
											<li value="三重県"><input type="checkbox" name="syuhanten_pref[]" value="三重県">三重県</li>
											<li value="滋賀県"><input type="checkbox" name="syuhanten_pref[]" value="滋賀県">滋賀県</li>
											<li value="京都府"><input type="checkbox" name="syuhanten_pref[]" value="京都府">京都府</li>
											<li value="大阪府"><input type="checkbox" name="syuhanten_pref[]" value="大阪府">大阪府</li>
											<li value="兵庫県"><input type="checkbox" name="syuhanten_pref[]" value="兵庫県">兵庫県</li>
											<li value="奈良県"><input type="checkbox" name="syuhanten_pref[]" value="奈良県">奈良県</li>
											<li value="和歌山県"><input type="checkbox" name="syuhanten_pref[]" value="和歌山県">和歌山県</li>
											<li value="鳥取県"><input type="checkbox" name="syuhanten_pref[]" value="鳥取県">鳥取県</li>
											<li value="島根県"><input type="checkbox" name="syuhanten_pref[]" value="島根県">島根県</li>
											<li value="岡山県"><input type="checkbox" name="syuhanten_pref[]" value="岡山県">岡山県</li>
											<li value="広島県"><input type="checkbox" name="syuhanten_pref[]" value="広島県">広島県</li>
											<li value="山口県"><input type="checkbox" name="syuhanten_pref[]" value="山口県">山口県</li>
											<li value="徳島県"><input type="checkbox" name="syuhanten_pref[]" value="徳島県">徳島県</li>
											<li value="香川県"><input type="checkbox" name="syuhanten_pref[]" value="香川県">香川県</li>
											<li value="愛媛県"><input type="checkbox" name="syuhanten_pref[]" value="愛媛県">愛媛県</li>
											<li value="高知県"><input type="checkbox" name="syuhanten_pref[]" value="高知県">高知県</li>
											<li value="福岡県"><input type="checkbox" name="syuhanten_pref[]" value="福岡県">福岡県</li>
											<li value="佐賀県"><input type="checkbox" name="syuhanten_pref[]" value="佐賀県">佐賀県</li>
											<li value="長崎県"><input type="checkbox" name="syuhanten_pref[]" value="長崎県">長崎県</li>
											<li value="熊本県"><input type="checkbox" name="syuhanten_pref[]" value="熊本県">熊本県</li>
											<li value="大分県"><input type="checkbox" name="syuhanten_pref[]" value="大分県">大分県</li>
											<li value="宮城県"><input type="checkbox" name="syuhanten_pref[]" value="宮城県">宮城県</li>
											<li value="鹿児島県"><input type="checkbox" name="syuhanten_pref[]" value="鹿児島県">鹿児島県</li>
											<li value="沖縄県"><input type="checkbox" name="syuhanten_pref[]" value="沖縄県">沖縄県</li>
										</ul>
									</div>
								</div>

								<div style="height:24px; margin:8px 0 8px 0;">
									<img style="float:left; margin:auto 4px auto 4px" src="images/icons/searchdot.svg">
									<span style="float:left; width:90px;">取扱い日本酒</span>
									<div style="float:left; margin-left:14px">
										<div style="float:left; width:112px">
											<input type="radio" name="special_name" value="11">普通酒
										</div>
										<div style="float:left; width:112px">
											<input type="radio" name="special_name" text="本醸造酒" value="21">本醸造酒
										</div>
										<div style="float:left; width:112px">
											<input type="radio" name="special_name" text="特別本醸造酒" value="22">特別本醸造酒
										</div>
										<div style="float:left; width:112px">
											<input type="radio" name="special_name" value="31">純米酒
										</div>
										<div style="float:left; width:112px">
											<input type="radio" name="special_name" text="本醸造酒" value="32">特別純米酒
										</div>
										<div style="float:left; width:112px">
											<input type="radio" name="special_name" text="純米吟醸酒" value="33">純米吟醸酒
										</div>

										<div style="float:left; width:112px">
											<input type="radio" name="special_name" value="34">純米大吟醸酒
										</div>
										<div style="float:left; width:112px">
											<input type="radio" name="special_name" text="本醸造酒" value="43">吟醸酒
										</div>
										<div style="float:left; width:112px">
											<input type="radio" name="special_name" text="大吟醸酒" value="44">大吟醸酒
										</div>
										<div style="float:left; width:112px">
											<input type="radio" name="special_name" text="不明" value="99">不明</div>
										<div style="float:left; width:260px">
											<input type="radio" name="special_name" value="90">その他
											<input id="special_name_other" style="margin-left:8px; width:60%;" type="text" name="special_name_other">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>-->

					<!--<div id="tabs-33_content" style="overflow:auto; padding:4px 2px 4px 2px; border:0px solid #c6c6c6" class="form-action hide">
						<div class="accordion_tabs_title"><div></div><p>飲食店<span>の絞り込み</span></p></div>
						<div class="accordion_title" value="syuhanten_accordion">
							<svg  version="1.1" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;" width="24" height="18" viewBox="-0.032 -0.046 37 31" enable-background="new -0.032 -0.046 37 31" xml:space="preserve">
								<path fill="#FFF" d="M35.904,19.301l-1.959-8.6c-0.465-2.038-2.486-3.309-4.516-2.844l-5.84,1.337l-0.004-0.002l-6.148-6.276
								c-0.088,0.557-0.322,1.08-0.666,1.509l5.063,5.169l0.002,0.002l-11.307,2.59v-0.003l2.316-6.859
								c-0.496-0.238-0.934-0.604-1.254-1.066l-2.82,8.328v0.004l-5.84,1.338c-2.031,0.469-3.299,2.495-2.836,4.53l1.959,8.599
								c0.465,2.04,2.486,3.312,4.518,2.847l26.496-6.072C35.101,23.364,36.369,21.344,35.904,19.301z M33.691,21.067
								c-0.236,0.379-0.609,0.658-1.078,0.77L6.117,27.906c-0.469,0.106-0.926,0.015-1.305-0.222c-0.375-0.242-0.656-0.613-0.766-1.082
								l-1.961-8.6c-0.105-0.467-0.014-0.932,0.223-1.311c0.24-0.377,0.611-0.658,1.078-0.77l26.498-6.068
								c0.469-0.109,0.928-0.016,1.307,0.221c0.373,0.238,0.656,0.613,0.762,1.08l1.959,8.603C34.021,20.231,33.929,20.688,33.691,21.067z
								 M14.781,4.754c1.295-0.299,2.102-1.587,1.805-2.884c-0.293-1.297-1.582-2.104-2.873-1.809c-1.291,0.298-2.1,1.585-1.805,2.883
								C12.203,4.239,13.49,5.051,14.781,4.754z M12.884,19.579c-0.072-0.227-0.148-0.385-0.246-0.545l0.002-0.001
								c-0.389-0.651-1.008-0.991-1.723-0.987c-0.195,0-0.396,0.021-0.602,0.073c-0.479,0.108-0.881,0.321-1.174,0.634
								c-0.293,0.31-0.473,0.717-0.514,1.2v-0.001c-0.008,0.078-0.014,0.158-0.014,0.242c0,0.301,0.059,0.641,0.209,1.297
								c0.096,0.422,0.168,0.707,0.242,0.934c0.074,0.223,0.154,0.385,0.248,0.541H9.312c0.389,0.658,1.01,0.99,1.723,0.986
								c0.191,0,0.391-0.021,0.594-0.068c0.484-0.109,0.887-0.32,1.182-0.637c0.293-0.311,0.473-0.719,0.516-1.199
								c0.008-0.08,0.012-0.158,0.012-0.242c0-0.301-0.057-0.637-0.209-1.299C13.033,20.084,12.96,19.799,12.884,19.579z M12.109,21.983
								c-0.023,0.209-0.092,0.383-0.205,0.518c-0.113,0.133-0.279,0.232-0.523,0.286c-0.098,0.022-0.184,0.034-0.262,0.034
								c-0.166,0-0.303-0.041-0.42-0.113c-0.123-0.074-0.229-0.186-0.318-0.332c-0.092-0.156-0.184-0.412-0.354-1.158
								c-0.145-0.635-0.188-0.928-0.188-1.104c0-0.037,0.002-0.068,0.006-0.1c0.021-0.211,0.09-0.381,0.201-0.514
								c0.113-0.131,0.279-0.234,0.52-0.287c0.096-0.021,0.186-0.034,0.27-0.034c0.164,0.001,0.303,0.044,0.422,0.114
								c0.119,0.076,0.225,0.182,0.314,0.325c0.092,0.161,0.182,0.404,0.355,1.165c0.145,0.631,0.188,0.922,0.186,1.107
								C12.113,21.924,12.113,21.954,12.109,21.983z M17.105,17.346c-0.311-0.246-0.701-0.373-1.133-0.373c-0.17,0-0.344,0.018-0.525,0.061
								l-1.992,0.455c-0.043,0.012-0.086,0.035-0.121,0.072c-0.031,0.037-0.047,0.088-0.047,0.135l0.008,0.051v0.006l1.176,5.17
								c0.012,0.043,0.035,0.088,0.074,0.121c0.037,0.027,0.086,0.047,0.135,0.047l0.051-0.008l0.764-0.176
								c0.045-0.01,0.09-0.035,0.123-0.072c0.031-0.037,0.049-0.084,0.047-0.135l-0.008-0.053l-0.408-1.802l1.016-0.235
								c0.465-0.105,0.848-0.325,1.113-0.637c0.266-0.305,0.416-0.699,0.414-1.129c0-0.146-0.018-0.303-0.051-0.459
								C17.638,17.946,17.416,17.592,17.105,17.346z M16.421,19.266c-0.1,0.115-0.256,0.206-0.463,0.256l-0.963,0.221l-0.314-1.381
								l0.961-0.223c0.082-0.018,0.162-0.025,0.234-0.025c0.18,0,0.326,0.053,0.439,0.143c0.111,0.092,0.195,0.225,0.234,0.402
								c0.018,0.068,0.021,0.131,0.021,0.191C16.572,19.016,16.521,19.153,16.421,19.266z M22.744,20.315
								c-0.01-0.045-0.037-0.086-0.074-0.119c-0.037-0.031-0.088-0.05-0.135-0.05l-0.049,0.007l-2.355,0.539l-0.268-1.176l1.969-0.453
								c0.045-0.01,0.09-0.035,0.121-0.07c0.033-0.039,0.049-0.088,0.049-0.139l-0.006-0.049l-0.152-0.674
								c-0.012-0.043-0.035-0.09-0.072-0.123c-0.039-0.031-0.088-0.047-0.135-0.047l-0.055,0.008l-1.969,0.451l-0.256-1.131l2.354-0.541
								c0.043-0.008,0.088-0.033,0.119-0.068c0.029-0.039,0.047-0.09,0.047-0.138l-0.004-0.052l-0.156-0.676
								c-0.008-0.039-0.033-0.088-0.072-0.119c-0.037-0.032-0.086-0.047-0.135-0.047l-0.049,0.008l-3.33,0.762
								c-0.043,0.008-0.088,0.029-0.121,0.068c-0.033,0.041-0.049,0.09-0.049,0.137l0.008,0.055l1.178,5.17
								c0.01,0.047,0.033,0.09,0.07,0.121c0.041,0.033,0.088,0.047,0.137,0.047l0.053-0.002l3.328-0.764
								c0.045-0.014,0.09-0.035,0.119-0.074c0.033-0.039,0.051-0.088,0.049-0.133l-0.006-0.051L22.744,20.315z M17.968,16.678
								L17.968,16.678l-0.002-0.004L17.968,16.678z M27.83,19.86v0.004l0.002,0.002L27.83,19.86z M26.652,14.691l-0.002-0.004
								c-0.01-0.045-0.031-0.087-0.072-0.119c-0.037-0.032-0.086-0.053-0.133-0.053l-0.055,0.008l-0.676,0.155
								c-0.045,0.011-0.09,0.036-0.121,0.069c-0.033,0.04-0.049,0.092-0.049,0.141l0.006,0.05l0.738,3.244l-2.705-2.867l-0.002,0.002
								c-0.047-0.053-0.125-0.098-0.203-0.096c-0.025,0-0.049,0.004-0.074,0.01l-0.719,0.164c-0.043,0.012-0.088,0.034-0.119,0.072
								c-0.033,0.041-0.049,0.09-0.049,0.135l0.006,0.057v-0.004l1.182,5.182l-0.002-0.01c0.008,0.049,0.033,0.09,0.072,0.123
								s0.084,0.046,0.135,0.046l0.051-0.003l0.68-0.156c0.043-0.012,0.088-0.033,0.121-0.074c0.033-0.037,0.047-0.09,0.047-0.133
								l-0.004-0.053l-0.74-3.24l2.713,2.859h0.002c0.021,0.025,0.051,0.051,0.086,0.064c0.035,0.023,0.078,0.029,0.117,0.029
								c0.027,0,0.051,0,0.074-0.006l0.711-0.166c0.045-0.008,0.09-0.035,0.121-0.07c0.031-0.039,0.045-0.086,0.045-0.137l-0.004-0.047
								L26.652,14.691z"/>
							</svg>
							<span style="margin-left:4px">飲食店の絞り込み</span>
							<img style="float:right; right:4px; vertical-align:middle; margin:2px 0px" src="images/icons/expand.svg">
						</div>
						<div style="display:none"></div>
					</div>-->

				</div><!--tab_accordion-->
			</div> <!-- accordion_frame -->
		</div> <!-- accordion -->

		<?php
		function disp_data_num($p_from, $p_to, $p_count)
		{
			$disp_num_from = 1 + $p_from;

			if($p_count >= $p_to)
			{
				$disp_num_to = $p_to;
			}
			else
			{
				$disp_num_to = $p_count;
			}

			if($disp_num_to == 0)
			{
				$disp_num = "検索結果がありません。";
			}
			else
			{
				$disp_num = $disp_num_from."～".$disp_num_to;
			}
			print($disp_num);
		}

		if(!$db = opendatabase("sake.db"))
		{
			die("データベース接続エラー .<br />");
		}

		//tab_main//////////////////////////////////////////////////////////////////////////////
		print('<div id="tab_main">');

			/* count */
			print('<div id="tabs-all" class="form-action show">');

				if($category == "1")
				{
					/***********
					* すべて
					***********/
					$condition1 = "";
					$condition2 = "";
					$condition3 = "";

					if(isset($_GET["keyword"]) && ($_GET["keyword"] != ""))
					{
						$keyword = str_replace("　", " ", $_GET["keyword"]);
						$keyword_elements = explode(' ', $keyword);
						$condition1 = "";

						if(count($keyword_elements) > 1)
						{
								$expression = "";

								foreach($keyword_elements as $element) {
									if($expression == "")
									{
										$expression = '(sake_name LIKE "%' .$element .'%" OR sake_read LIKE "%' .$element. '%" OR sake_search LIKE "%' .$element. '%" OR sake_english LIKE "%' .$element .'%" OR sake_id LIKE "%' .$element .'%")';
									}
									else
									{
										$expression .= ' AND (sake_name LIKE "%' .$element .'%" OR sake_read LIKE "%' .$element. '%" OR sake_search LIKE "%' .$element. '%" OR sake_english LIKE "%' .$element .'%" OR sake_id LIKE "%' .$element .'%")';
									}
								}

								$condition1 = 'WHERE (' .$expression .')';
						}
						else
						{
								$condition1 = 'WHERE (sake_name LIKE "%' .$keyword .'%" OR sake_read LIKE "%' .$keyword. '%" OR sake_search LIKE "%' .$keyword. '%" OR sake_english LIKE "%' .$keyword .'%" OR sake_id LIKE "%' .$keyword .'%")';
						}

						$condition2 = "WHERE (sakagura_name LIKE \"%" .$keyword. "%\" OR sakagura_read LIKE \"%" .$keyword."%\" OR sakagura_search LIKE \"%" .$keyword."%\") ";
						$condition3 = "WHERE (syuhanten_name LIKE \"%" .$keyword. "%\" OR syuhanten_read LIKE \"%" .$keyword."%\") ";
					}

					if($condition1 == "")
					{
						$condition1 = "WHERE sakagura_id = id";
					}
					else
					{
						$condition1 .= "AND sakagura_id = id";
					}

					/////////////////////////////////////////////////////////////////////////////////////////////////////////////
					$sql = "SELECT COUNT(*) FROM SAKE_J, SAKAGURA_J ".$condition1;
					$res = executequery($db, $sql);
					$row = getnextrow($res);
					$count_result1 = $row["COUNT(*)"];

					$sql = "SELECT COUNT(*) FROM SAKAGURA_J ".$condition2;
					$res = executequery($db, $sql);
					$row = getnextrow($res);
					$count_result2 = $row["COUNT(*)"];

					/*
					$sql = "SELECT COUNT(*) FROM SYUHANTEN_J ".$condition3;
					$res = executequery($db, $sql);
					$row = getnextrow($res);
					$count_result3 = $row["COUNT(*)"];
					*/

					$count_result = $count_result1 + $count_result2 + $count_result3;
					print('<input type="hidden" id="hidden_all_count_query" name="count_all_query" value=' .$count_result .'>');
					//$sql = "SELECT * FROM SAKE_J, SAKAGURA_J ".$condition." ORDER BY sake_read"." LIMIT ".$from.", ".$to;

					$sql  = 'SELECT			SAKE_J.sake_id AS id, sake_name, SAKE_J.sake_rank AS rank, SAKE_J.write_update AS write_date, sakagura_name, special_name, sake_category, alcohol_level, jsake_level, rice_used, seimai_rate, setting, postal_code, pref, address, brand ';
					$sql .=	' FROM			SAKE_J, SAKAGURA_J ' .$condition1;
					$sql .= ' UNION ';
					$sql .= ' SELECT		SAKAGURA_J.id AS id, SAKAGURA_J.sakagura_name, SAKAGURA_J.rank AS rank,	SAKAGURA_J.date_updated AS write_date, null, null, null, null, null, null, null, null, postal_code, pref, address, brand ';
					$sql .= ' FROM			SAKAGURA_J ' .$condition2;
					//$sql .= ' UNION ';
					//$sql .= '	SELECT		SYUHANTEN_J.syuhanten_id AS id, SYUHANTEN_J.syuhanten_name, SYUHANTEN_J.syuhanten_rank AS rank,	SYUHANTEN_J.date_added AS write_date, null, null, null, null, null, null, null, null, syuhanten_postal_code AS postal_code, syuhanten_pref, syuhanten_address AS address, null ';
					//$sql .= ' FROM			SYUHANTEN_J ' .$condition3;
					$sql .= '	LIMIT '		.$from .', ' .$p_max;

					$res = executequery($db, $sql);

					//print('<div>' .$sql .'</div>');

					/////////////////////////////////////////////////////////////////////////////////////////
					print('<div class="count_sort_container">');
						/*非表示中print('<div class="sake_view">');

							print('<div class="search_result_keyword">');
								print('<div class="search_result_keyword_content"><span><svg class="search_result_keyword_search2020"><use xlink:href="#search2020"/></svg>検索ワード&nbsp;:&nbsp;</span>'.$keyword.'</div>');
							print('</div>');

						print("</div>");*/

						print('<div class="click_sort">
							<div><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>
							<div class="click_sort_standard click_sort_button">標準</div>
							<!--非表示中<div class="click_sort_date click_sort_button">更新日</div>-->
						</div>');
					print("</div>");

					//////////////////////////////////////////////////////////////////////////////////////
					print('<div class="search_result_count">');
						print('<span id="view_all_result">');
						disp_data_num($from, $to, $count_result);
						print('</span>');

						if($count_result > 0)
							print('<span id="count_all_result">件 / 全'.$count_result.'件</span>');
						else
							print('<span id="count_all_result" style="display:none">件 / 全'.$count_result.'件</span>');

						/*print('<span class="loading"><span>Loading...</span></span>');*/
					print('</div>');
					//////////////////////////////////////////////////////////////////////////////////////
					print('<div id="search_general_result">');

						while($row = getnextrow($res))
						{
							if(!strncmp($row["id"], 'A', 1))
							{
								$sake_id = $row["id"];
								$sql = "SELECT AVG(rank) FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND (rank != 0 AND rank != '')";
								$res_avg = executequery($db, $sql);
								$rd_average = getnextrow($res_avg);
								$rank = $rd_average["AVG(rank)"];

								// 日本酒///////////////////////////////////////////////////////////////////////
								$rice_used = $row["rice_used"];
								$rice_kanji = $rice_used;

								if($rice_used != "")
								{
									$sql = "SELECT SAKE_RICE.rice_name, SAKE_RICE.rice_kanji, SAKE_RICE.rice_kana FROM SAKE_RICE WHERE SAKE_RICE.rice_name = '$rice_used'";
									$sake_result = executequery($db, $sql);
									$record = getnextrow($sake_result);
									$rice_kanji = $record ? $record["rice_kanji"] : $rice_used;
								}

								print('<a class="searchRow_link" href="sake_view.php?sake_id='.$row["id"].'">');
									$path = "images/icons/noimage160.svg";
									$result_set = executequery($db, "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$row["id"] ."' LIMIT 8");

									if($rd = getnextrow($result_set)) {
										$path = "images/photo/thumb/" .$rd["filename"];
									}

									print('<div class="search_result_name_container">');
										print('<div class="search_result_sake_image"><img id="' .$path .'" src="' .$path .'"></div>');

										print('<div class="search_result_sake_brewery_date_container">');
											print('<div class="search_result_sake">'.stripslashes($row["sake_name"]).'</div>');

											print('<div class="search_result_brewery_date_container">');
												print('<div class="search_result_brewery">'.$row["sakagura_name"].' / '.$row["pref"].'</div>');

												print('<div class="search_result_date">');
													$intime = $row["write_date"];
													$intime = gmdate("Y/m/d", $intime + 9 * 3600);
													print($intime);
												print('</div>');
											print('</div>');
										print('</div>');

										/*非表示中print('<div class="search_result_button_container">');
											print('<button class="custom_button" sake_id=' .$row["id"] .'><span class="button-icon"><svg class="search_result_button_heart2020"><use xlink:href="#heart2020"/></svg></span><span class="button-text">飲んだ</span></button>');
											print('<button class="custom_button" sake_id=' .$row["id"] .'><span class="button-icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button-text">飲みたい</span></button>');
										print('</div>');*/

									print('</div>');

									// 酒ランク////////////////////////////////////////////////
									$rank_width = (($rank / 5) * 100) .'%';
									print('<div class="search_result_rank">');
										print('<div class="search_result_star_rating">');
											print('<div class="search_result_star_rating_front" style="width: ' .$rank_width. '">★★★★★</div>');
											print('<div class="search_result_star_rating_back">★★★★★</div>');
										print('</div>');
										if($rank) {
											print('<span class="search_result_sake_rate">' .number_format($rank, 1) .'</span>');
										} else {
											print('<span class="search_result_sake_rate" style="color: #b2b2b2;">--</span>');
										}
									print('</div>');

									////////////////////////////////////////////////
									print('<div class="spec">');
										print('<div class="spec_item">');
											print('<div class="spec_title"><svg class="spec_item_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg>特定名称</div>');
											print('<div class="spec_info">');

												if($row["special_name"]) {
													$special_name_array = explode(',', $row["special_name"]);
													if($special_name_array[0] == "90") {
														print($special_name_array[1]);
													} else {
														print(GetSakeSpecialName($special_name_array[0]));
													}
												} else {
													print('<span style="color: #b2b2b2;">--</span>');
												}

											print('</div>');
										print('</div>');
										/////////////////////////////////////////////////
										print('<div class="spec_item">');
											print('<div class="spec_title"><svg class="spec_item_alc1616"><use xlink:href="#alc1616"/></svg>Alc度数</div>');
											print('<div class="spec_info">');

												$alcohol_array = explode(',', $row["alcohol_level"]);
												if($alcohol_array[0] != null && $alcohol_array[1] != null) {
													if($alcohol_array[0] == $alcohol_array[1]) {
														print($alcohol_array[0].'%');
													} else {
														print($alcohol_array[0] .'～'.$alcohol_array[1].'%');
													}
												} else if($alcohol_array[0] != null && $alcohol_array[1] == null) {
													print($alcohol_array[0] .'%');
												} else {
													print('<span style="color: #b2b2b2;">--</span>');
												}

											print("</div>");
										print("</div>");
										/////////////////////////////////////////////////
										print('<div class="spec_item">');
											print('<div class="spec_title"><svg class="spec_item_rice1616"><use xlink:href="#rice1616"/></svg>原料米</div>');
											print('<div class="spec_info">');

												if($row["rice_used"]) {
													$rice_array = explode('/', $row["rice_used"]);
													for($i = 0; $i < count($rice_array); $i++) {
														$rice_entry = explode(',', $rice_array[$i]);

														if($i > 0 && $rice_entry[0] != "") {
															print(" / ");
														}

														$sql = "SELECT SAKE_RICE.rice_name, SAKE_RICE.rice_kanji, SAKE_RICE.rice_kana FROM SAKE_RICE WHERE SAKE_RICE.rice_name = '$rice_entry[0]'";
														$sake_result = executequery($db, $sql);
														$record = getnextrow($sake_result);

														if($rice_entry[1] == "1") {
															print("麹米:");
														} else if($rice_entry[1] == "2") {
															print("掛米:");
														}

														if($rice_entry[0] != "") {
															if($rice_entry[0] == "other") {
																print($rice_entry[3]);
															} else {
																$rice_kanji = $record ? $record["rice_kanji"] : $rice_used;
																print($rice_kanji ." ");
															}
														}
													}
												} else {
													print('<span style="color: #b2b2b2;">--</span>');
												}

											print("</div>");
										print("</div>");

										/////////////////////////////////////////////////
										print('<div class="spec_item">');
											print('<div class="spec_title"><svg class="spec_item_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg>精米歩合</div>');
											print('<div class="spec_info">');

												$rice_array = explode('/', $row["rice_used"]);
												$seimai_array = explode(',', $row["seimai_rate"]);
												$bfound = false;
											
												foreach($seimai_array as $element) {
												    if($element) {
														$bfound = true;
														break;
													}
												}

												if($bfound) {
													for($i = 0; $i < count($seimai_array); $i++) {
														if($i > 0 && $seimai_array[$i] != "") {
															print(" / ");
														}

														if(count($rice_array) > 0 && $i < count($rice_array)) {
															$rice_entry = explode(',', $rice_array[$i]);
															if($rice_entry[1] == "1") {
																print("麹米:");
															} else if($rice_entry[1] == "2") {
																print("掛米:");
															}
														}

														if($seimai_array[$i])
															print($seimai_array[$i]."%");
													}
												} else {
													print('<span style="color: #b2b2b2;">--</span>');
												}
											print("</div>");
										print("</div>");

										/////////////////////////////////////////////////
										print('<div class="spec_item">');
											print('<div class="spec_title"><svg class="spec_item_nihonshudo1616"><use xlink:href="#nihonshudo1616"/></svg>日本酒度</div>');
											print('<div class="spec_info">');

												$syudo_array = explode(',', $row["jsake_level"]);
												if($syudo_array[0] != null && $syudo_array[1] != null) {
													if($syudo_array[0] == $syudo_array[1]) {
														print(number_format($syudo_array[0], 1));
													} else {
														print(number_format($syudo_array[0], 1).'～'.number_format($syudo_array[1], 1));
													}
												} else if($syudo_array[0] != null && $syudo_array[1] == null) {
													print(number_format($syudo_array[0], 1));
												} else {
													print('<span style="color: #b2b2b2;">--<span>');
												}

											print("</div>");
										print("</div>");

										////////////////////////////////////////////////////////////////////////////

									print("</div>");
								print("</a>"); // searchRow_link
								$i++;
							}
							else if(!strncmp($row["id"], 'B', 1))
							{
								////////////////
								// 酒蔵
								////////////////
								print('<a class="sakaguraRow_link" href="sda_view.php?id=' .$row["id"] .'">');

									print('<div class="search_sakagura_result_name_container">');
										$path = "images/icons/noimage160.svg";
										/*一時的に非表示print('<div class="search_sakagura_result_brewery_image"><img id="' .$path .'" src="' .$path  .'"></div>');*/

										print('<div class="search_sakagura_result_brewery_pref_date_container">');
											print('<div class="search_sakagura_result_brewery">' .stripslashes($row["sake_name"]) .'</div>');

											print('<div class="search_sakagura_result_pref_date_container">');
												print('<div class="search_sakagura_result_pref">'.$row["pref"].' ' .$row["address"] .'</div>');
												print('<div class="search_sakagura_result_date">'.gmdate("Y/m/d", $row["write_date"] + 9 * 3600).'</div>');
											print('</div>');

										print('</div>');

										/*非表示中print('<div class="search_sakagura_result_button_container">');
											print('<button class="custom_button" sake_id=' .$row["id"] .'><span class="button-icon"><svg class="search_result_button_writing1816"><use xlink:href="#writing1816"/></svg></span><span class="button-text">コメント・写真</span></button>');
											print('<button class="custom_button" sake_id=' .$row["id"] .'><span class="button-icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button-text">フォロー</span></button>');
										print('</div>');*/

									print('</div>');

									print('<div class="sakagura_spec">');

										print('<div class="sakagura_spec_item">');
											print('<span class="sakagura_spec_title"><svg class="spec_item_bottle1616"><use xlink:href="#bottle1616"/></svg>代表銘柄</span>');
											print('<span class="sakagura_spec_info">');
												if($row["brand"]) {
													print($row["brand"]);
												} else {
													print('<span style="color: #b2b2b2;">--<span>');
												}
											print('</span>');
										print("</div>");
										/////////////////////////////////////////////////
										print('<div class="sakagura_spec_item">');
											print('<span class="sakagura_spec_title"><svg class="spec_item_visit1616"><use xlink:href="#visit1616"/></svg>酒蔵見学</span>');
											print('<span class="sakagura_spec_info">');
												if($row["observation"] == 1)
													print('可');
												else if($row["observation"] == 2)
													print('不可');
												else
													print('<span style="color: #b2b2b2;">--<span>');
											print('</span>');
										print("</div>");
										/////////////////////////////////////////////////
										print('<div class="sakagura_spec_item">');
											print('<span class="sakagura_spec_title"><svg class="spec_item_kurashop1616"><use xlink:href="#kurashop1616"/></svg>酒蔵直販店</span>');
											print('<span class="sakagura_spec_info">');
												if($row["direct_sale"] == 1)
													print('あり');
												else if($row["direct_sale"] == 2)
													print('なし');
												else
													print('<span style="color: #b2b2b2;">--<span>');
											print('</span>');
										print("</div>");

									print("</div>");
								print("</a>"); // sakaguraRow_link
							}
							else if(!strncmp($row["id"], 'S', 1))
							{
								////////////////
								// 酒販店
								////////////////
								$default_image = "syuhanten.gif";

								print('<div class="syuhantenRow" sake_id=' .$row["id"] .'><a class="syuhantenRow_link" href="syuhan_view.php?syuhanten_id=' .$row["id"] .'">');

									print('<div class="search_syuhanten_result_name_container">');
									$path = "images/icons/noimage160.svg";
										print('<div class="search_syuhanten_result_store_image"><img id="' .$path .'" src="' .$path  .'"></div>');

										print('<div class="search_syuhanten_result_store_pref_date_container">');
											print('<div class="search_syuhanten_result_store">' .stripslashes($row["sake_name"]). '</div>');

											print('<div class="search_syuhanten_result_pref_date_container">');
												print('<div class="search_syuhanten_result_pref">'.$row["pref"].' ' .$row["address"] .'</div>');
												print('<div class="search_syuhanten_result_date">'.$row["write_date"].'</div>');
											print('</div>');

										print('</div>');

										print('<div class="search_syuhanten_result_button_container">');
											print('<button class="custom_button" sake_id=' .$row["id"] .'><span class="button-icon"><svg class="search_result_button_writing1816"><use xlink:href="#writing1816"/></svg></span><span class="button-text">コメント・写真</span></button>');
											print('<button class="custom_button" sake_id=' .$row["id"] .'><span class="button-icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button-text">フォロー</span></button>');
										print('</div>');

									print('</div>');

									print('<div class="syuhanten_spec">');

										print('<div class="syuhanten_spec_item">');
											print('<span class="syuhanten_spec_title">日曜営業</span><span class="syuhanten_spec_info">あり</span>');
										print("</div>");
										/////////////////////////////////////////////////
										/*if($row["observation"] == 1)*/
										print('<div class="syuhanten_spec_item">');
											print('<span class="syuhanten_spec_title">商品配送</span><span class="syuhanten_spec_info">可</span>');
										print("</div>");
										/////////////////////////////////////////////////
									print("</div>");
								print("</a></div>");
							}
						}

					print("</div>"); // search_general_result

					////////////////////////////////////////////////////////////////////////////////////
					$numPage = floor($count_result / $p_max);
					$numPage = ($count_result % $p_max) ? ($numPage + 1) : $numPage;
					$numPage = ($numPage > 5) ? 5 : $numPage;
					$pagenum = ceil($from / $p_max);
					$showPos = ($page > 5) ? ($page - 5) : 0;

					print('<div id="allpage" class="search_result_turn_page">');
						if($count_result > 25)
						{
							print('<button id="prev_all" class="search_button">前の'.$p_max .'件</button>');

							for($i = 0; $i < $numPage; $i++)
							{
								if(($showPos + $i) == ($page - 1)) {

								 	print('<button class="search_button pageitems" style="background:#22445B; color:#ffffff;">' .($showPos + $i + 1) .'</button>');
								}
								else {
									print('<button class="search_button pageitems">' .($showPos + $i + 1) .'</button>');
								}
							}

							print('<button id="next_all" class="search_button">次の' .$p_max .'件</button>');
						}
					print("</div>");
				}
				else
				{
					$count_all_result = 0;
					$p_all_max = 25;

					print('<input type="hidden" id="hidden_all_count_query" name="count_all_query" value=0>');

					print('<div class="count_sort_container">');
						/*非表示中print('<div class="sake_view">');
							print('<div class="search_result_keyword">');
								print('<div class="search_result_keyword_content"><span><svg class="search_result_keyword_search2020"><use xlink:href="#search2020"/></svg>検索ワード&nbsp;:&nbsp;</span>'.$keyword.'</div>');
							print('</div>');
						print("</div>");*/

						print('<div class="click_sort">
							<div><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>
							<div class="click_sort_standard click_sort_button">標準</div>
							<!--非表示中<div class="click_sort_date click_sort_button">更新日</div>-->
						</div>');
					print("</div>");

					print('<div class="search_result_count">');
						print('<span id="view_all_result">');
						disp_data_num($from, $to, $count_all_result);
						print('</span>');

						if($count_result > 0)
							print('<span id="count_all_result">件 / 全'.$count_result.'件</span>');
						else
							print('<span id="count_all_result" style="display:none">件 / 全'.$count_result.'件</span>');

						/*print('<span class="loading"><span>Loading...</span></span>');*/
					print('</div>');

					print('<div id="search_general_result"></div>');

					//////////////////////////////////////////////////////////////////////////////////////

					print('<div id="allpage" class="search_result_turn_page">');

						if($count_result > 25)
						{
							print('<button id="prev_all" class="search_button">前の'.$p_max .'件</button>');
							$i = 1;

							print('<button class="search_button pageitems" style="background:#22445B; color:#ffffff;">' .$i .'</button>');

							for($i++; $i <= $numPage; $i++)
							{
								print('<button class="search_button pageitems">' .$i .'</button>');
							}

							print('<button id="next_all" class="search_button">次の' .$p_max .'件</button>');
						}
					print("</div>");
					//////////////////////////////////////////////////////////////////////////////////////
				}
			print("</div>"); // tab-all

			///////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////
			print('<div id="tabs-sake" class="form-action hide">');

				if($category == "2")
				{
					/***********
					* 酒
					***********/
					$condition = "";

					if(isset($_GET["keyword"]) && ($_GET["keyword"] != ""))
					{
							$sake_name = sqlite3::escapeString($_GET["keyword"]);
							$sake_name = str_replace("　", " ", $sake_name);
							$keyword_elements = explode(' ', $sake_name);
							$condition1 = "";

							if(count($keyword_elements) > 1)
							{
									$expression = "";

									foreach($keyword_elements as $element) {
										if($expression == "")
										{
												$expression = '(sake_name LIKE "%' .$element .'%" OR sake_read LIKE "%' .$element. '%" OR sake_search LIKE "%' .$element. '%" OR sake_english LIKE "%' .$element .'%" OR sake_id LIKE "%' .$element .'%")';
										}
										else
										{
												$expression .= ' AND (sake_name LIKE "%' .$element .'%" OR sake_read LIKE "%' .$element. '%" OR sake_search LIKE "%' .$element. '%" OR sake_english LIKE "%' .$element .'%" OR sake_id LIKE "%' .$element .'%")';
										}
									}

									$condition = 'WHERE (' .$expression .')';
							}
							else
							{
									$condition = 'WHERE (sake_name LIKE "%' .$sake_name .'%" OR sake_read LIKE "%' .$sake_name .'%" OR sake_search LIKE "%' .$sake_name. '%" OR sake_english LIKE "%' .$sake_name .'%" OR sake_id LIKE "%' .$sake_name.'%")';
							}
					}

					if(isset($_GET["sake_id"]) && ($_GET["sake_id"] != ""))
					{
						$sake_id = sqlite3::escapeString($_GET["sake_id"]);
						$sake_id = str_replace("%", "\%", $sake_id);

						if($condition == "")
						{
							$condition = "WHERE sake_id LIKE \"%".$sake_id."%\"";
						}
						else
						{
							$condition .= "AND sake_id LIKE \"%".$sake_id."%\"";
						}
					}

					if(isset($_GET["sakagura_name"]) && ($_GET["sakagura_name"] != ""))
					{
						$sakagura_name = sqlite3::escapeString($_GET["sakagura_name"]);
						$sakagura_name = str_replace("%", "\%", $sakagura_name);

						if($condition == "")
						{
							$condition = "WHERE sakagura_name LIKE \"%".$sakagura_name."%\"";
						}
						else
						{
							$condition .= "AND id LIKE \"%".$sakagura_name."%\"";
						}
					}

					if(isset($_GET["sakagura_read"]) && ($_GET["sakagura_read"] != ""))
					{
						$sakagura_read = sqlite3::escapeString($_GET["sakagura_read"]);
						$sakagura_read = str_replace("%", "\%", $sakagura_read);

						if($condition == "")
						{
							$condition = "WHERE sakagura_read LIKE \"%".$sakagura_read."%\"";
						}
						else
						{
							$condition .= "AND id LIKE \"%".$sakagura_read."%\"";
						}
					}

					if(isset($_GET["sake_region"]) && ($_GET["sake_region"] != ""))
					{
						$region_name = $_GET["sake_region"];
						$region_name = str_replace("%", "\%", $region_name);

						if($condition == "")
						{
							$condition = "WHERE region_name LIKE \"%".$region_name."%\" ";
						}
						else
						{
							//$condition .= "AND SAKAGURA_J.region_name LIKE \"%".$region_name."%\"";
							$condition .= "AND region_name LIKE \"%".$region_name."%\"";
						}
					}

					if(isset($_GET["pref"]) && ($_GET["pref"] != ""))
					{
						$pref = $_GET['pref'];

						if($condition == "")
						{
							$condition = "WHERE (" ."pref LIKE \"%".$pref."%\"" ." ) ";
						}
						else
						{
							$condition .= "AND (" ." OR pref LIKE \"%".$pref."%\"" ." ) ";
						}
					}

					if(isset($_GET["special_name"]) && ($_GET["special_name"] != ""))
					{
						$special_name = $_GET["special_name"];

						if($condition == "")
						{
							$condition = "WHERE " ."special_name LIKE \"%".$special_name."%\"" ."  ";
						}
						else
						{
							$condition .= "AND " ."special_name LIKE \"%".$special_name."%\"" ."  ";
						}
					}

					if(isset($_GET["rice_used"]) && ($_GET["rice_used"] != ""))
					{
						$rice_used = $_GET["rice_used"];

						if($condition == "")
						{
							$condition = "WHERE " ."rice_used LIKE \"%".$rice_used."%\"" ."  ";
						}
						else
						{
							$condition .= "AND " ."rice_used LIKE \"%".$rice_used."%\"" ."  ";
						}
					}

					//////////////////////////////////////
					if(!empty($_GET['sake_category']))
					{
						$expr = "";

						foreach($_GET['sake_category'] as $selected)
						{
							if($expr == "")
							{
								$expr = "sake_category LIKE \"%".$selected."%\"";
							}
							else
							{
								$expr .= " AND sake_category LIKE \"%".$selected."%\"";
							}
						}

						//print('<div>' .$expr .'</div>');
						if($condition == "")
						{
							//$condition = "WHERE (" .$expr ."%\") ";
							$condition = "WHERE (" .$expr ." ) ";
						}
						else
						{
							//$condition .= "AND (" .$expr ."%\") ";
							$condition .= "AND (" .$expr ." ) ";
						}
					}

					if(!empty($_GET['jsake_level']))
					{
						$expr = "";

						foreach($_GET['jsake_level'] as $selected)
						{
							if($selected == "1")
							{
								if($expr == "")
								{
									$expr = "substr(jsake_level, 0, 3) <= \"-6.0\"";
								}
								else
								{
									$expr .= " or (substr(jsake_level, 0, 3) <= \"-6.0\")";
								}
							}
							else if($selected == "2")
							{
								if($expr == "")
								{
									$expr = "(substr(jsake_level, 0, 3) >= \"-5.9\" and substr(jsake_level, 0, 3) < \"-3.5\")";
								}
								else
								{
									$expr .= " or (substr(jsake_level, 0, 3) >= \"-5.9\" and  substr(jsake_level, 0, 3) < \"-3.5\")";
								}
							}
							else if($selected == "3")
							{
								if($expr == "")
								{
									$expr = "(substr(jsake_level, 0, 3) >= \"-3.4\" and substr(jsake_level, 0, 3) < \"-1.5\")";
								}
								else
								{
									$expr .= " or (substr(jsake_level, 0, 3) >= \"-3.4\" and  substr(jsake_level, 0, 3) < \"-1.5\")";
								}
							}
							else if($selected == "4")
							{
								if($expr == "")
								{
									$expr = "(substr(jsake_level, 0, 3) >= \"-1.4\" and substr(jsake_level, 0, 3) < \"1.4\")";
								}
								else
								{
									$expr .= " or (substr(jsake_level, 0, 3) >= \"-1.4\" and  substr(jsake_level, 0, 3) < \"1.4\")";
								}
							}
							else if($selected == "5")
							{
								if($expr == "")
								{
									$expr = "(substr(jsake_level, 0, 3) >= \"1.5\" and substr(jsake_level, 0, 3) < \"3.4\")";
								}
								else
								{
									$expr .= " or (substr(jsake_level, 0, 3) >= \"1.5\" and  substr(jsake_level, 0, 3) < \"3.4\")";
								}
							}
							else if($selected == "6")
							{
								if($expr == "")
								{
									$expr = "(substr(jsake_level, 0, 3) >= \"3.5\" and substr(jsake_level, 0, 3) <= \"5.9\")";
								}
								else
								{
									$expr .= " or (substr(jsake_level, 0, 3) >= \"3.5\" and substr(jsake_level, 0, 3) < \"5.9\")";
								}
							}
							else if($selected == "7")
							{
								if($expr == "")
								{
									$expr = "substr(jsake_level, 0, 3) >= \"6\"";
								}
								else
								{
									$expr .= " or (substr(jsake_level, 0, 3) >= \"6\")";
								}
							}
						}

						if($condition == "")
						{
							$condition = "WHERE (" .$expr ." ) ";
						}
						else
						{
							$condition .= "AND (" .$expr ." ) ";
						}
					}

					if(!empty($_GET['oxidation_level']))
					{
						$expr = "";

						foreach($_GET['oxidation_level'] as $selected)
						{
							if($selected == "1")
							{
								if($expr == "")
								{
									$expr = "substr(oxidation_level, 0, 4) <= \"0.5\"";
								}
								else
								{
									$expr .= " or (substr(oxidation_level, 0, 4) <= \"0.5\")";
								}
							}
							else if($selected == "2")
							{
								if($expr == "")
								{
									$expr = "(substr(oxidation_level, 0, 4) >= \"0.6\" and substr(oxidation_level, 0, 4) < \"1.0\")";
								}
								else
								{
									$expr .= " or (substr(oxidation_level, 0, 4) >= \"0.6\" and  substr(oxidation_level, 0, 4) < \"1.0\")";
								}
							}
							else if($selected == "3")
							{
								if($expr == "")
								{
									$expr = "(substr(oxidation_level, 0, 4) >= \"1.1\" and substr(oxidation_level, 0, 4) < \"1.5\")";
								}
								else
								{
									$expr .= " or (substr(oxidation_level, 0, 4) >= \"1.1\" and  substr(oxidation_level, 0, 4) < \"1.5\")";
								}
							}
							else if($selected == "4")
							{
								if($expr == "")
								{
									$expr = "(substr(oxidation_level, 0, 4) >= \"1.6\" and substr(oxidation_level, 0, 4) < \"2.0\")";
								}
								else
								{
									$expr .= " or (substr(oxidation_level, 0, 4) >= \"1.6\" and  substr(oxidation_level, 0, 4) < \"2.0\")";
								}
							}
							else if($selected == "5")
							{
								if($expr == "")
								{
									$expr = "(substr(oxidation_level, 0, 4) >= \"2.1\" and substr(oxidation_level, 0, 4) <= \"2.5\")";
								}
								else
								{
									$expr .= " or (substr(oxidation_level, 0, 4) >= \"2.1\" and substr(oxidation_level, 0, 4) < \"2.5\")";
								}
							}
							else if($selected == "6")
							{
								if($expr == "")
								{
									$expr = "substr(oxidation_level, 0, 4) >= \"2.6\"";
								}
								else
								{
									$expr .= " or (substr(oxidation_level, 0, 4) >= \"2.6\")";
								}
							}
						}

						if($condition == "")
						{
							$condition = "WHERE (" .$expr ." ) ";
						}
						else
						{
							$condition .= "AND (" .$expr ." ) ";
						}
					}

					if(!empty($_GET['seimai_rate']))
					{
						$expr = "";

						foreach($_GET['seimai_rate'] as $selected)
						{
							if($selected == "1")
							{
								if($expr == "")
								{
									$expr = "substr(seimai_rate, 0, 3) > \"71\"";
								}
								else
								{
									$expr .= " or (substr(seimai_rate, 0, 3) > \"71\")";
								}
							}
							else if($selected == "2")
							{
								if($expr == "")
								{

									$expr = "(substr(seimai_rate, 0, 3) >= \"61\" and substr(seimai_rate, 0, 3) < \"70\")";
								}
								else
								{
									$expr .= " or (substr(seimai_rate, 0, 3) >= \"61\" and  substr(seimai_rate, 0, 3) < \"70\")";
								}
							}
							else if($selected == "3")
							{
								if($expr == "")
								{
									$expr = "(substr(seimai_rate, 0, 3) >= \"51\" and substr(seimai_rate, 0, 3) < \"60\")";
								}
								else
								{
									$expr .= " or (substr(seimai_rate, 0, 3) >= \"51\" and  substr(seimai_rate, 0, 3) < \"60\")";
								}
							}
							else if($selected == "4")
							{
								if($expr == "")
								{
									$expr = "(substr(seimai_rate, 0, 3) >= \"41\" and substr(seimai_rate, 0, 3) < \"50\")";
								}
								else
								{
									$expr .= " or (substr(seimai_rate, 0, 3) >= \"41\" and  substr(seimai_rate, 0, 3) < \"50\")";
								}
							}
							else if($selected == "5")
							{
								if($expr == "")
								{
									$expr = "(substr(seimai_rate, 0, 3) >= \"31\" and substr(seimai_rate, 0, 3) < \"40\")";
								}
								else
								{
									$expr .= " or (substr(seimai_rate, 0, 3) >= \"31\" and  substr(seimai_rate, 0, 3) < \"40\")";
								}
							}
							else if($selected == "6")
							{
								if($expr == "")
								{
									$expr = "(substr(seimai_rate, 0, 3) >= \"21\" and substr(seimai_rate, 0, 3) < \"30\")";
								}
								else
								{
									$expr .= " or (substr(seimai_rate, 0, 3) >= \"21\" and substr(seimai_rate, 0, 3) < \"30\")";
								}
							}
							else if($selected == "7")
							{
								if($expr == "")
								{
									$expr = "substr(seimai_rate, 0, 3) < \"20\"";
								}
								else
								{
									$expr .= " or (substr(seimai_rate, 0, 3) < \"20\")";
								}
							}
						}

						if($condition == "")
						{
							$condition = "WHERE (" .$expr ." ) ";
						}
						else
						{
							$condition .= "AND (" .$expr ." ) ";
						}
					}

					if(!empty($_GET['alcohol_level']))
					{
						$expr = "";

						foreach($_GET['alcohol_level'] as $selected)
						{
							if($selected == "1")
							{
								if($expr == "")
								{
									$expr = "substr(alcohol_level, 0, 3) < \"13\"";
								}
								else
								{
									$expr .= " or (substr(alcohol_level, 0, 3) < \"13\")";
								}
							}
							else if($selected == "2")
							{
								if($expr == "")
								{
									//select replace(alcohol_level, rtrim(alcohol_level, replace(alcohol_level, ',', '')), '') from sake_j;
									$expr = "(substr(alcohol_level, 0, 3) >= \"13\" and substr(alcohol_level, 0, 3) < \"14\")";
								}
								else
								{
									$expr .= " or (substr(alcohol_level, 0, 3) >= \"13\" and  substr(alcohol_level, 0, 3) < \"14\")";
								}
							}
							else if($selected == "3")
							{
								if($expr == "")
								{
									$expr = "(substr(alcohol_level, 0, 3) >= \"14\" and substr(alcohol_level, 0, 3) < \"15\")";
								}
								else
								{
									$expr .= " or (substr(alcohol_level, 0, 3) >= \"14\" and  substr(alcohol_level, 0, 3) < \"15\")";
								}
							}
							else if($selected == "4")
							{
								if($expr == "")
								{
									$expr = "(substr(alcohol_level, 0, 3) >= \"15\" and substr(alcohol_level, 0, 3) < \"16\")";
								}
								else
								{
									$expr .= " or (substr(alcohol_level, 0, 3) >= \"15\" and  substr(alcohol_level, 0, 3) < \"16\")";
								}
							}
							else if($selected == "5")
							{
								if($expr == "")
								{
									$expr = "(substr(alcohol_level, 0, 3) >= \"16\" and substr(alcohol_level, 0, 3) < \"17\")";
								}
								else
								{
									$expr .= " or (substr(alcohol_level, 0, 3) >= \"16\" and  substr(alcohol_level, 0, 3) < \"17\")";
								}
							}
							else if($selected == "6")
							{
								if($expr == "")
								{
									$expr = "(substr(alcohol_level, 0, 3) >= \"17\" and substr(alcohol_level, 0, 3) < \"18\")";
								}
								else
								{
									$expr .= " or (substr(alcohol_level, 0, 3) >= \"17\" and substr(alcohol_level, 0, 3) < \"18\")";
								}
							}
							else if($selected == "7")
							{
								if($expr == "")
								{
									$expr = "substr(alcohol_level, 0, 3) >= \"18\"";
								}
								else
								{
									$expr .= " or (substr(alcohol_level, 0, 3) >= \"18\")";
								}
							}
						}

						if($condition == "")
						{
							$condition = "WHERE (" .$expr ." ) ";
						}
						else
						{
							$condition .= "AND (" .$expr ." ) ";
						}
					}

					if(isset($_GET["develop"]) && ($_GET["develop"] != ""))
					{
						$develop = sqlite3::escapeString($_GET["develop"]);

						if($condition == "")
						{
							if($develop == "3")
							{
								$condition = "WHERE develop is NULL ";
							}
							else
							{
								$condition = "WHERE develop = \"".$develop."\"";
							}
						}
						else
						{
							if($develop == "3")
							{
								$condition .= "AND develop is NULL ";
							}
							else
							{
								$condition .= "AND develop = \"".$develop."\" ";
							}
						}
					}

					if(isset($_GET["pic_checkbox"]) && ($_GET["pic_checkbox"] != ""))
					{
						$pic_checkbox = $_GET["pic_checkbox"];

						if($condition == "")
						{
							$condition = "WHERE EXISTS (SELECT * FROM SAKE_IMAGE WHERE SAKE_J.sake_id = SAKE_IMAGE.sake_id)";
						}
						else
						{
							$condition .= "AND EXISTS (SELECT * FROM SAKE_IMAGE WHERE SAKE_J.sake_id = SAKE_IMAGE.sake_id)";
						}
					}

					if($condition == "")
					{
						$condition = "WHERE sakagura_id = id";
					}
					else
					{
						$condition .= "AND sakagura_id = id";
					}

					$sql = "SELECT COUNT(*) FROM SAKE_J, SAKAGURA_J ".$condition;
					$res = executequery($db, $sql);
					$row = getnextrow($res);
					$count_result = $row["COUNT(*)"];

					print('<input type="hidden" id="hidden_sake_count_result" name="count_result" value=' .$count_result .'>');

					/* query */
					$p_max = 25;

					//$sql = "SELECT * FROM SAKE_J, SAKAGURA_J ".$condition." ORDER BY sake_read"." LIMIT ".$from.", ".$to;
					$sql = "SELECT * FROM SAKE_J, SAKAGURA_J ".$condition." LIMIT ".$from.", ".$p_max;
					$res = executequery($db, $sql);
					//print('<div>' .$sql .'</div>');

					///////////////////////////////////////////////////////////////////////////////////
					print('<div class="count_sort_container">');
						/*非表示中print('<div class="sake_view">');
							print('<div class="search_result_keyword">');
								print('<div class="search_result_keyword_content"><span><svg class="search_result_keyword_search2020"><use xlink:href="#search2020"/></svg>検索ワード&nbsp;:&nbsp;</span>'.$keyword.'</div>');
							print('</div>');
						print("</div>");*/

						print('<div class="click_sort">
							<div><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>
							<div class="click_sort_standard click_sort_button" value = "sake_read">標準</div>
							<!--非表示中<div class="click_sort_date click_sort_button" value = "">更新日</div>-->
							<!--非表示中<div class="click_sort_ranking click_sort_button" value = "sake_rank">ランキング</div>-->
						</div>');
						/*print('<div class="click_sort">
							<div><img src="images/icons/sort.svg"></div>
							<div value = "" style="background:#22445B; color:#fff">更新日</div>
							<div value = "sake_read">よみ</div>
							<div value = "sake_rank">ランキング</div>
							<div value = "">レビュー数</div>
							<div value = "oxidation_level">酸度</div>
							<div value = "alcohol_level">アルコール</div>
							<div value = "jsake_level">日本酒度</div>
							<div value = "seimai_rate">精米歩合</div>
							<div value = "amino_level">アミノ酸度</div>
						</div>');*/
					print("</div>");

					print('<div class="search_result_count">');
						print('<span id="view_sake_result">');
						disp_data_num($from, $to, $count_result);
						print('</span>');

						if($count_result > 0)
							print('<span id="count_sake_result">件 / 全'.$count_result.'件</span>');
						else
							print('<span id="count_sake_result" style="display:none">件 / 全'.$count_result.'件</span>');

						/*print('<span class="loading"><span>Loading...</span></span>');*/
					print('</div>');

					///////////////////////////////////////////////////////////////////////////////
					print('<div id="search_sake_result">');

						$i = 0;

						while($row = getnextrow($res))
						{
							// 使用米
							//$rice_used = $row["rice_used"];
							//$rice_kanji = $rice_used;

							$sake_id = $row["sake_id"];
							$sql = "SELECT AVG(rank) FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND (rank != 0 AND rank != '')";
							$res_avg = executequery($db, $sql);
							$rd_average = getnextrow($res_avg);
							$rank = $rd_average["AVG(rank)"];

							print('<a class="searchRow_link" href="sake_view.php?sake_id=' .$row["sake_id"] .'">');

								$path = "images/icons/noimage160.svg";
								$result_set = executequery($db, "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$row["sake_id"] ."' LIMIT 8");

								if($rd = getnextrow($result_set)) {
									$path = "images/photo/thumb/" .$rd["filename"];
								}

								print('<div class="search_result_name_container">');
									print('<div class="search_result_sake_image"><img id="' .$path .'" src="' .$path .'"></div>');

									print('<div class="search_result_sake_brewery_date_container">');
										print('<div class="search_result_sake">'.stripslashes($row["sake_name"]).'</div>');

										print('<div class="search_result_brewery_date_container">');
											print('<div class="search_result_brewery">'.$row["sakagura_name"].' / '.$row["pref"].'</div>');

											print('<div class="search_result_date">');
												$intime = gmdate("Y/m/d", $row["write_update"] + 9 * 3600);
												print($intime);
											print('</div>');
										print('</div>');
									print('</div>');

									/*非表示中print('<div class="search_result_button_container">');
										print('<button class="custom_button" sake_id=' .$row["sake_id"] .'><span class="button-icon"><svg class="search_result_button_heart2020"><use xlink:href="#heart2020"/></svg></span><span class="button-text">飲んだ</span></button>');
										print('<button class="custom_button" sake_id=' .$row["sake_id"] .'><span class="button-icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button-text">飲みたい</span></button>');
									print('</div>');*/

								print('</div>');

								////////////////////////////////////////////////
								/* 酒ランク */
								$rank_width = (($rank / 5) * 100) .'%';

								print('<div class="search_result_rank">');
									print('<div class="search_result_star_rating">');
										print('<div class="search_result_star_rating_front" style="width: ' .$rank_width. '">★★★★★</div>');
										print('<div class="search_result_star_rating_back">★★★★★</div>');
									print('</div>');
									if($rank) {
										print('<span class="search_result_sake_rate">' .number_format($rank, 1) .'</span>');
									} else {
										print('<span class="search_result_sake_rate" style="color: #b2b2b2;">--</span>');
									}
								print('</div>');

								////////////////////////////////////////////////
								print('<div class="spec">');
									print('<div class="spec_item">');
										print('<div class="spec_title"><svg class="spec_item_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg>特定名称</div>');
										print('<div class="spec_info">');

											if($row["special_name"]) {
												$special_name_array = explode(',', $row["special_name"]);
												if($special_name_array[0] == "90") {
													print($special_name_array[1]);
												} else {
													print(GetSakeSpecialName($special_name_array[0]));
												}
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}

										print('</div>');
									print('</div>');
									/////////////////////////////////////////////////
									print('<div class="spec_item">');
										print('<div class="spec_title"><svg class="spec_item_alc1616"><use xlink:href="#alc1616"/></svg>Alc度数</div>');
										print('<div class="spec_info">');

											$alcohol_array = explode(',', $row["alcohol_level"]);
											if($alcohol_array[0] != null && $alcohol_array[1] != null) {
												if($alcohol_array[0] == $alcohol_array[1]) {
													print($alcohol_array[0].'%');
												} else {
													print($alcohol_array[0] .'～'.$alcohol_array[1].'%');
												}
											} else if($alcohol_array[0] != null && $alcohol_array[1] == null) {
												print($alcohol_array[0] .'%');
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}

										print("</div>");
									print("</div>");
									/////////////////////////////////////////////////
									print('<div class="spec_item">');
										print('<div class="spec_title"><svg class="spec_item_rice1616"><use xlink:href="#rice1616"/></svg>原料米</div>');
										print('<div class="spec_info">');

											if($row["rice_used"]) {
												$rice_array = explode('/', $row["rice_used"]);
												for($i = 0; $i < count($rice_array); $i++) {
													$rice_entry = explode(',', $rice_array[$i]);

													if($i > 0 && $rice_entry[0] != "") {
														print(" / ");
													}

													$sql = "SELECT SAKE_RICE.rice_name, SAKE_RICE.rice_kanji, SAKE_RICE.rice_kana FROM SAKE_RICE WHERE SAKE_RICE.rice_name = '$rice_entry[0]'";
													$sake_result = executequery($db, $sql);
													$record = getnextrow($sake_result);

													if($rice_entry[1] == "1") {
														print("麹米:");
													} else if($rice_entry[1] == "2") {
														print("掛米:");
													}

													if($rice_entry[0] != "") {
														if($rice_entry[0] == "other") {
															print($rice_entry[3]);
														} else {
															$rice_kanji = $record ? $record["rice_kanji"] : $rice_used;
															print($rice_kanji ." ");
														}
													}
												}
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}

										print("</div>");
									print("</div>");
									/////////////////////////////////////////////////
									print('<div class="spec_item">');
										print('<div class="spec_title"><svg class="spec_item_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg>精米歩合</div>');
										print('<div class="spec_info">');

										$rice_array = explode('/', $row["rice_used"]);
										$seimai_array = explode(',', $row["seimai_rate"]);

										if($seimai_array[0] || $seimai_array[1] || $seimai_array[2]) {
											for($i = 0; $i < count($seimai_array); $i++) {
												if($i > 0 && $seimai_array[$i] != "") {
													print(" / ");
												}

												if(count($rice_array) > 0 && $i < count($rice_array)) {
													$rice_entry = explode(',', $rice_array[$i]);
													if($rice_entry[1] == "1") {
														print("麹米:");
													} else if($rice_entry[1] == "2") {
														print("掛米:");
													}
												}

												if($seimai_array[$i])
													print($seimai_array[$i]."%");
											}
										} else {
											print('<span style="color: #b2b2b2;">--</span>');
										}

										print("</div>");
									print("</div>");
									/////////////////////////////////////////////////
									print('<div class="spec_item">');
										print('<div class="spec_title"><svg class="spec_item_nihonshudo1616"><use xlink:href="#nihonshudo1616"/></svg>日本酒度</div>');
										print('<div class="spec_info">');

										$syudo_array = explode(',', $row["jsake_level"]);
										if($syudo_array[0] != null && $syudo_array[1] != null) {
											if($syudo_array[0] == $syudo_array[1]) {
												print(number_format($syudo_array[0], 1));
											} else {
												print(number_format($syudo_array[0], 1).'～'.number_format($syudo_array[1], 1));
											}
										} else if($syudo_array[0] != null && $syudo_array[1] == null) {
											print(number_format($syudo_array[0], 1));
										} else {
											print('<span style="color: #b2b2b2;">--<span>');
										}

										print("</div>");
									print("</div>");
									/////////////////////////////////////////////////

								print("</div>");

							print("</a>"); // searchRow_link
							$i++;
						}
					print("</div>"); // search_sake_result

					////////////////////////////////////////////////////////////////////////////////////
					$numPage = ceil($count_result / $p_max);
					$numPage = ($numPage > 5) ? 5 : $numPage;
					$pagenum = ceil($from / $p_max);
					$showPos = ($page > 5) ? ($page - 5) : 0;
					$sakePageText = ($count_result > 0) ? "" : ' style="display:none"';

					print('<div id="sakepage" class="search_result_turn_page"' .$sakePageText .'>');

							if($count_result > 25) {
								print('<button id="prev_sake" class="search_button">前の'.$p_max .'件</button>');

								for($i = 0; $i < $numPage; $i++) {

									if(($showPos + $i) == ($page - 1)) {
										print('<button class="search_button pageitems" style="background:#22445B; color:#ffffff">' .($showPos + $i + 1) .'</button>');
									}
									else {
										print('<button class="search_button pageitems">' .($showPos + $i + 1) .'</button>');
									}
								}
								print('<button id="next_sake" class="search_button">次の' .$p_max .'件</button>');

							}
					print("</div>");
				}
				else
				{
					$count_sake_result = 0;
					$p_sake_max = 25;

					print('<input type="hidden" id="hidden_sake_count_result" name="count_sake_result" value=' .$count_sake_result .'>');

					///////////////////////////////////////////////////////////////////////////////////
					print('<div class="count_sort_container">');
						/*非表示中print('<div class="sake_view">');
							print('<div class="search_result_keyword">');
								print('<div class="search_result_keyword_content"><span><svg class="search_result_keyword_search2020"><use xlink:href="#search2020"/></svg>検索ワード&nbsp;:&nbsp;</span>'.$keyword.'</div>');
							print('</div>');
						print("</div>");*/

						print('<div class="click_sort">
							<div><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>
							<div class="click_sort_standard click_sort_button" value = "sake_read">標準</div>
							<!--非表示中<div class="click_sort_date click_sort_button" value = "">更新日</div>-->
							<!--非表示中<div class="click_sort_ranking click_sort_button" value = "sake_rank">ランキング</div>-->
						</div>');
					print("</div>");

					print('<div class="search_result_count">');
						print('<span id="view_sake_result">');
						disp_data_num($from, $to, $count_sake_result);
						print('</span>');

						if($count_sake_result > 0)
							print('<span id="count_sake_result">件 / 全'.$count_sake_result.'件</span>');
						else
							print('<span id="count_sake_result" style="display:none">件 / 全'.$count_sake_result.'件</span>');

						/*print('<span class="loading"><span>Loading...</span></span>');*/
					print('</div>');

					///////////////////////////////////////////////////////////////////////////////
					print('<div id="search_sake_result"></div>');

					///////////////////////////////////////////////////////////////////////////////
					$numPage = 5;

					print('<div id="sakepage" class="search_result_turn_page">');
						print('<button id="prev_sake" class="search_button">前の'.$p_max .'件</button>');
						$i = 1;

						print('<button class="search_button pageitems" style="background:#22445B; color:#ffffff;">' .$i .'</button>');

						/*for($i++; $i <= $numPage; $i++)
						{
							print('<button class="search_button pageitems">' .$i .'</button>');
						}*/

						print('<button id="next_sake" class="search_button">次の' .$p_sake_max .'件</button>');
					print("</div>");

				}
			print("</div>"); // tabs-sake

			//////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////
			print('<div id="tabs-sakagura" class="form-action hide">');

				if($category == "3")
				{
					$condition = "";

					if(isset($_GET["pref"]) && ($_GET["pref"] != ""))
					{
	        			$pref = $_GET["pref"];

						if($condition == "")
						{
							$condition = "WHERE pref LIKE \"%".$pref."%\" ";
						}
						else
						{
							$condition .= " AND pref \"%".$pref."%\"";
						}
					}

					if(isset($_GET["priority"]) && ($_GET["priority"] != ""))
					{
	        			$priority = $_GET["priority"];

						if($condition == "")
						{
							$condition = "WHERE sakagura LIKE \"%".$priority."%\" ";
						}
						else
						{
							$condition .= " AND sakagura LIKE \"%".$priority."%\"";
						}
	    			}

					if(isset($_GET["observation"]) && ($_GET["observation"] != ""))
					{
	        			$observation = $_GET["observation"];

						if($condition == "")
						{
							$condition = "WHERE observation LIKE \"%".$observation."%\" ";
						}
						else
						{
							$condition .= " AND observation LIKE \"%".$observation."%\"";
						}
	    			}

					if(isset($_GET["direct_sale"]) && ($_GET["direct_sale"] != ""))
					{
	        			$direct_sale = $_GET["direct_sale"];

						if($condition == "")
						{
							$condition = "WHERE direct_sale LIKE \"%".$direct_sale."%\" ";
						}
						else
						{
							$condition .= " AND direct_sale LIKE \"%".$direct_sale."%\"";
						}
	    			}

					if(isset($_GET["keyword"]) && ($_GET["keyword"] != ""))
					{
						$sakagura_name = sqlite3::escapeString($_GET["keyword"]);
						//$sakagura_name = str_replace("　", " ", $sakagura_name);
						$sakagura_name = str_replace("%", "\%", $sakagura_name);

						if($condition == "")
						{
							//$condition = "WHERE sakagura_name LIKE \"%".$sakagura_name."%\"";
							$condition = "WHERE sakagura_name LIKE \"%" .$sakagura_name. "%\" OR sakagura_read LIKE \"%" .$sakagura_name."%\" OR sakagura_search LIKE \"%" .$sakagura_name."%\"";
						}
						else
						{
							//$condition .= "AND sakagura_name LIKE \"%".$sakagura_name."%\"";
							$condition .= " AND sakagura_name LIKE \"%" .$sakagura_name. "%\" OR sakagura_read LIKE \"%" .$sakagura_name."%\" OR sakagura_search LIKE \"%" .$sakagura_name."%\"";
	        			}
	    			}

					if(isset($_GET["kumiai"]) && ($_GET["kumiai"] != ""))
					{
	        			$kumiai = $_GET["kumiai"];

						if($condition == "")
						{
							$condition = "WHERE kumiai LIKE \"%".$kumiai."%\" ";
						}
						else
						{
							$condition .= " AND kumiai LIKE \"%".$kumiai."%\"";
						}
	    			}

					if(isset($_GET["kokuzei"]) && ($_GET["kokuzei"] != ""))
					{
	        			$kokuzei = $_GET["kokuzei"];

						if($condition == "")
						{
							$condition = "WHERE kokuzei LIKE \"%".$kokuzei."%\" ";
						}
						else
						{
							$condition .= " AND kokuzei LIKE \"%".$kokuzei."%\"";
						}
	    			}

					if(isset($_GET["status"]) && ($_GET["status"] != ""))
					{
        				$status = $_GET["status"];

						if($condition == "")
						{
							$condition = "WHERE status LIKE \"%".$status."%\" ";
						}
						else
						{
							$condition .= " AND status LIKE \"%".$status."%\"";
						}
	    			}

					//$sql = "SELECT COUNT(*) FROM SAKAGURA_J ".$condition." ORDER BY sakagura_read";
					$sql = "SELECT COUNT(*) FROM SAKAGURA_J ".$condition;

					$res = executequery($db, $sql);
					$row = getnextrow($res);
					$count_result = $row["COUNT(*)"];

					print('<input type="hidden" id="hidden_sakagura_count_result"  name="count_result" value=' .$count_result .'>');

					/* query */
					$p_max = 25;
					$sql = "SELECT * FROM SAKAGURA_J ".$condition." ORDER BY sakagura_read"." LIMIT ".$from.", ".$p_max;
					//print('<div>' .$sql .'</div>');
					$res = executequery($db, $sql);

					///////////////////////////////////////////////////////////////////////////////
					print('<div class="count_sort_container">');
						/*非表示中print('<div class="sake_view">');
							print('<div class="search_result_keyword">');
								print('<div class="search_result_keyword_content"><span><svg class="search_result_keyword_search2020"><use xlink:href="#search2020"/></svg>検索ワード&nbsp;:&nbsp;</span>'.$keyword.'</div>');
							print('</div>');
						print("</div>");*/

						print('<div class="click_sort">
							<div><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>
							<div class="click_sort_standard click_sort_button" value = "">標準</div>
							<!--非表示中<div class="click_sort_date click_sort_button" value = "">更新日</div>-->
						</div>');
					print("</div>");

					print('<div class="search_result_count">');
						print('<span id="view_sakagura_result">');
						disp_data_num($from, $to, $count_result);
						print('</span>');

						if($count_result > 0)
							print('<span id="count_sakagura_result">件 / 全'.$count_result.'件</span>');
						else
							print('<span id="count_sakagura_result" style="display:none">件 / 全'.$count_result.'件</span>');

						/*print('<span class="loading"><span>Loading...</span></span>');*/
					print('</div>');

					///////////////////////////////////////////////////////////////////////////////
					print('<div id="search_sakagura_result">');
						$i = 0;

						while($row = getnextrow($res))
						{
							$path = "images/icons/noimage160.svg";

							print('<a class="sakaguraRow_link" href="sda_view.php?id=' .$row["id"] .'">');

								print('<div class="search_sakagura_result_name_container">');
									$path = "images/icons/noimage160.svg";
									/*一時的に非表示print('<div class="search_sakagura_result_brewery_image"><img id="' .$path .'" src="' .$path  .'"></div>');*/

									print('<div class="search_sakagura_result_brewery_pref_date_container">');
										print('<div class="search_sakagura_result_brewery">' .$row["sakagura_name"] .'</div>');

										print('<div class="search_sakagura_result_pref_date_container">');
											print('<div class="search_sakagura_result_pref">'.$row["pref"].' ' .$row["address"] .'</div>');
											print('<div class="search_sakagura_result_date">' .gmdate("Y/m/d", $row["date_updated"] + 9 * 3600) .'</div>');
										print('</div>');

									print('</div>');

									/*非表示中print('<div class="search_sakagura_result_button_container">');
										print('<button class="custom_button" sake_id=' .$row["sake_id"] .'><span class="button-icon"><svg class="search_result_button_writing1816"><use xlink:href="#writing1816"/></svg></span><span class="button-text">コメント・写真</span></button>');
										print('<button class="custom_button" sake_id=' .$row["sake_id"] .'><span class="button-icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button-text">フォロー</span></button>');
									print('</div>');*/

								print('</div>');

								print('<div class="sakagura_spec">');

									print('<div class="sakagura_spec_item">');
										print('<span class="sakagura_spec_title"><svg class="spec_item_bottle1616"><use xlink:href="#bottle1616"/></svg>代表銘柄</span>');
										print('<span class="sakagura_spec_info">');
											if($row["brand"]) {
												print($row["brand"]);
											} else {
												print('<span style="color: #b2b2b2;">--<span>');
											}
										print('</span>');
									print("</div>");
									/////////////////////////////////////////////////
									print('<div class="sakagura_spec_item">');
										print('<span class="sakagura_spec_title"><svg class="spec_item_visit1616"><use xlink:href="#visit1616"/></svg>酒蔵見学</span>');
										print('<span class="sakagura_spec_info">');
											if($row["observation"] == 1)
												print('可');
											else if($row["observation"] == 2)
												print('不可');
											else
												print('<span style="color: #b2b2b2;">--<span>');
										print('</span>');
									print("</div>");
									/////////////////////////////////////////////////
									print('<div class="sakagura_spec_item">');
										print('<span class="sakagura_spec_title"><svg class="spec_item_kurashop1616"><use xlink:href="#kurashop1616"/></svg>酒蔵直販店</span>');
										print('<span class="sakagura_spec_info">');
											if($row["direct_sale"] == 1)
												print('あり');
											else if($row["direct_sale"] == 2)
												print('なし');
											else
												print('<span style="color: #b2b2b2;">--<span>');
										print('</span>');
									print("</div>");
									/////////////////////////////////////////////////
									/*print('<div class="sakagura_spec_item">');
									print('<div class="sakagura_spec_title">酒造組合登録</div>');
									print('<div class="sakagura_spec_info">');

									if($row["kumiai"] == 10)
										print('あり');
									else if($row["kumiai"] == 11)
										print('なし');
									else if($row["kumiai"] == 12)
										print('不明');
									else
										print('--');

									print('</div>');
									print('</div>');
									/////////////////////////////////////////////////
									print('<div class="sakagura_spec_item">');
									print('<div class="sakagura_spec_title">国税庁登録</div>');
									print('<div class="sakagura_spec_info">');

									if($row["kokuzei"] == 10)
										print('あり');
									else if($row["kokuzei"] == 11)
										print('なし');
									else if($row["kokuzei"] == 12)
										print('不明');
									else
										print('--');

									print('</div>');
									print('</div>');

									/////////////////////////////////////////////////
									print('<div class="sakagura_spec_item">');
									print('<div class="sakagura_spec_title">プライオリティ</div>');
									print('<div class="sakagura_spec_info">');

									if($row["sakagura"] == 1)
										print('S');
									else if($row["sakagura"] == 2)
										print('A');
									else if($row["sakagura"] == 3)
										print('B');
									else if($row["sakagura"] == 4)
										print('C');
									else if($row["sakagura"] == 5)
										print('D');
									else if($row["sakagura"] == 6)
										print('E');
									else
										print('--');

									print('</div>');
									print('</div>');

									/////////////////////////////////////////////////
									print('<div class="sakagura_spec_item">');
									print('<div class="sakagura_spec_title">ステータス</div>');
									print('<div class="sakagura_spec_info">');

									if($row["status"] == 10)
										print('active');
									else if($row["status"] == 11)
										print('inactive');
									else if($row["status"] == 12)
										print('一時製造休止');
									else if($row["status"] == 13)
										print('営業不明');
									else
										print('--');

									print('</div>');
									print('</div>');
									*/
									////////////

								print("</div>");
							print("</a>");

							$i++;
						}

					print("</div>"); // search_sakagura_result

					///////////////////////////////////////////////////////////////////////////////

					$numPage = ceil($count_result / $p_max);
					$numPage = ($numPage > 5) ? 5 : $numPage;
					$showPos = ($page > 5) ? ($page - 5) : 0;

					print('<div id="sakagurapage" class="search_result_turn_page">');

						if($count_result > $p_max) {

							print('<button id="prev_sakagura" class="search_button">前の'.$p_max .'件</button>');

							for($i = 0; $i < $numPage; $i++)
							{
								if(($showPos + $i) == ($page - 1)) {

							 		print('<button class="search_button pageitems" style="background:#22445B; color:#ffffff;">' .($showPos + $i + 1) .'</button>');
								}
								else {
									print('<button class="search_button pageitems">' .($showPos + $i + 1) .'</button>');
								}
							}

							print('<button id="next_sakagura" class="search_button">次の' .$p_max .'件</button>');
						}

					print("</div>");
				}
				else
				{
					$count_sakagura_result = 0;
					$p_sakagura_max = 25;

					print('<input type="hidden" id="hidden_sakagura_count_result"	name="count_sakagura_result" value=' .$count_sakagura_result .'>');

					///////////////////////////////////////////////////////////////////////////////
					print('<div class="count_sort_container">');
						/*非表示中print('<div class="sake_view">');
							print('<div class="search_result_keyword">');
								print('<div class="search_result_keyword_content"><span><svg class="search_result_keyword_search2020"><use xlink:href="#search2020"/></svg>検索ワード&nbsp;:&nbsp;</span>'.$keyword.'</div>');
							print('</div>');
						print("</div>");*/

						print('<div class="click_sort">
							<div><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>
							<div class="click_sort_standard click_sort_button" value = "">標準</div>
							<!--非表示中<div class="click_sort_date click_sort_button" value = "">更新日</div>-->
						</div>');
					print("</div>");

					print('<div class="search_result_count">');
						print('<span id="view_sakagura_result">');
						disp_data_num($from, $to, $count_sakagura_result);
						print('</span>');

						print('<span id="count_sakagura_result">件 / 全'.$count_sakagura_result.'件</span>');

						/*print('<span class="loading"><span>Loading...</span></span>');*/
					print('</div>');

					///////////////////////////////////////////////////////////////////////////////

					print('<div id="search_sakagura_result"></div>');

					print('<div id="sakagurapage" class="search_result_turn_page">');
						print('<button id="prev_sakagura" class="search_button">前の'.$p_sakagura_max .'件</button>');
						/*$i = 1;

						print('<button class="search_button pageitems" style="background:#22445B; color:#ffffff;">' .$i .'</button>');

						for($i++; $i <= $numPage; $i++)
						{
							print('<button class="search_button pageitems">' .$i .'</button>');
						}*/

						print('<button id="next_sakagura" class="search_button">次の' .$p_sakagura_max .'件</button>');
					print("</div>");

				}
			print("</div>"); // tabs-sakagura

			///////////////////////////////////////////////////////////////////////////////
			print('<div id="tabs-syuhanten" class="form-action hide">');

				if($category == "4")
				{
					$condition = "";

			    if(isset($_GET["keyword"]) && ($_GET["keyword"] != ""))
			    {
					$syuhanten_name = sqlite3::escapeString($_GET["keyword"]);
					$syuhanten_name = str_replace("%", "\%", $syuhanten_name);

					if($condition == "")
					{
						$condition = "WHERE syuhanten_name LIKE \"%".$syuhanten_name."%\"";
					}
					else
					{
						$condition .= "AND syuhanten_name LIKE \"%".$syuhanten_name."%\"";
	        		}
	    		}

				if(!empty($_GET['syuhanten_pref']))
				{
					$expr = "";

					foreach($_GET['syuhanten_pref'] as $selected)
					{
						if($expr == "")
						{
							$expr = "syuhanten_pref LIKE \"%".$selected."%\"";
						}
						else
						{
							$expr .= " OR syuhanten_pref LIKE \"%".$selected."%\"";
						}
					}

					if($condition == "")
					{
						$condition = "WHERE (" .$expr ." ) ";
					}
					else
					{
						$condition .= "AND (" .$expr ." ) ";
					}
				}

					/* query */
					$sql = "SELECT COUNT(*) FROM SYUHANTEN_J " .$condition;

					$res = executequery($db, $sql);
					$row = getnextrow($res);
					$count_result = $row["COUNT(*)"];

					// query
					$sql = "SELECT * FROM SYUHANTEN_J ".$condition." ORDER BY syuhanten_read"." LIMIT ".$from.", ".$to;
					$res = executequery($db, $sql);
					$p_max = 25;

					////////////////////////////////////////////////////////////////////////////////////
					print('<input type="hidden" id="hidden_syuhanten_count_result"  name="count_result" value=' .$count_result .'>');

					///////////////////////////////////////////////////////////////////////////////
					print('<div class="count_sort_container">');
						/*非表示中print('<div class="sake_view">');
							print('<div class="search_result_keyword">');
								print('<div class="search_result_keyword_content"><span><svg class="search_result_keyword_search2020"><use xlink:href="#search2020"/></svg>検索ワード&nbsp;:&nbsp;</span>'.$keyword.'</div>');
							print('</div>');
						print("</div>");*/

						print('<div class="click_sort">
							<div><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>
							<div class="click_sort_standard click_sort_button" value = "">標準</div>
							<!--非表示中<div class="click_sort_date click_sort_button" value = "">更新日</div>-->
						</div>');
					print("</div>");

					print('<div class="search_result_count">');
						print('<span id="view_syuhanten_result">');
						disp_data_num($from, $to, $count_result);
						print('</span>');

						print('<span id="count_syuhanten_result">件 / 全'.$count_result.'件</span>');

						/*print('<span class="loading"><span>Loading...</span></span>');*/
					print('</div>');

					///////////////////////////////////////////////////////////////////////////////

					$i = 0;
					print('<div id="search_syuhanten_result">');

						$default_image = "images/icons/noimage160.svg";

						while($row = getnextrow($res))
						{
							print('<div class="syuhantenRow" sake_id=' .$row["sake_id"] .'><a class="syuhantenRow_link" href="syuhan_view.php?syuhanten_id=' .$row["syuhanten_id"].'">');

								print('<div class="search_syuhanten_result_name_container">');
								$path = "images/icons/noimage160.svg";
									print('<div class="search_syuhanten_result_store_image"><img id="' .$path .'" src="' .$path  .'"></div>');

									print('<div class="search_syuhanten_result_store_pref_date_container">');
										print('<div class="search_syuhanten_result_store">' .$row["syuhanten_name"] .'</div>');

										print('<div class="search_syuhanten_result_pref_date_container">');
											print('<div class="search_syuhanten_result_pref">' .$row["syuhanten_pref"] .' ' .$row["syuhanten_address"] .'</div>');
											print('<div class="search_syuhanten_result_date">' .$row["date_added"] .'</div>');
										print('</div>');

									print('</div>');

									print('<div class="search_syuhanten_result_button_container">');
										print('<button class="custom_button" sake_id=' .$row["syuhanten_id"] .'><span class="button-icon"><svg class="search_result_button_writing1816"><use xlink:href="#writing1816"/></svg></span><span class="button-text">コメント・写真</span></button>');
										print('<button class="custom_button" sake_id=' .$row["syuhanten_id"] .'><span class="button-icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button-text">フォロー</span></button>');
									print('</div>');

								print('</div>');

								print('<div class="syuhanten_spec">');

									print('<div class="syuhanten_spec_item">');
										print('<span class="syuhanten_spec_title">日曜営業</span><span class="syuhanten_spec_info">あり</span>');
									print("</div>");
									/////////////////////////////////////////////////
									print('<div class="syuhanten_spec_item">');
										print('<span class="syuhanten_spec_title">商品配送</span><span class="syuhanten_spec_info">可</span>');
									print("</div>");
									/////////////////////////////////////////////////
								print("</div>");
							print("</a></div>");
						}

					print("</div>"); // search_syuhanten_result

					print('<div id="syuhantenpage" class="search_result_turn_page">');
						print('<button id="prev_syuhanten" class="search_button">前の'.$p_max .'件</button>');
						/*$i = 1;

						print('<button class="search_button pageitems" style="background:#22445B; color:#ffffff;">' .$i .'</button>');

						for($i++; $i <= $numPage; $i++)
						{
							print('<button class="search_button pageitems">' .$i .'</button>');
						}*/

						print('<button id="next_syuhanten" class="search_button">次の' .$p_max .'件</button>');
					print("</div>");

				}
				else
				{
					$count_syuhanten_result = 0;
					$p_syuhanten_max = 25;

					print('<input type="hidden" id="hidden_syuhanten_count_result" name="count_syuhanten_result" value=' .$count_syuhanten_result .'>');

					///////////////////////////////////////////////////////////////////////////////
					print('<div class="count_sort_container">');
						/*非表示中print('<div class="sake_view">');
							print('<div class="search_result_keyword">');
								print('<div class="search_result_keyword_content"><span><svg class="search_result_keyword_search2020"><use xlink:href="#search2020"/></svg>検索ワード&nbsp;:&nbsp;</span>'.$keyword.'</div>');
							print('</div>');
						print("</div>");*/

						print('<div class="click_sort">
							<div><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div>
							<div class="click_sort_standard click_sort_button" value = "">標準</div>
							<!--非表示中<div class="click_sort_date click_sort_button" value = "">更新日</div>-->
						</div>');
					print("</div>");

					print('<div class="search_result_count">');
						print('<span id="view_syuhanten_result">');
						disp_data_num($from, $to, $count_syuhanten_result);
						print('</span>');

						print('<span id="count_syuhanten_result">件 / 全' .$count_syuhanten_result. '件</span>');
						/*print('<span class="loading"><span>Loading...</span></span>');*/
					print('</div>');

					///////////////////////////////////////////////////////////////////////////////

					print('<div id="search_syuhanten_result" style="margin-top:4px"></div>');

					print('<div id="syuhantenpage" class="search_result_turn_page">');
						print('<button id="prev_syuhanten" class="search_button">前の'.$p_syuhanten_max .'件</button>');
						/*$i = 1;

						print('<button class="search_button pageitems" style="background:#22445B; color:#ffffff;">' .$i .'</button>');

						for($i++; $i <= $numPage; $i++)
						{
							print('<button class="search_button pageitems">' .$i .'</button>');
						}*/

						print('<button id="next_syuhanten" class="search_button">次の'.$p_syuhanten_max .'件</button>');
					print("</div>");

				}

			print("</div>"); // tab-7
		print("</div>"); // main-tab
	print('</div>');
print('</div>');//container
writefooter();

/*******************************************************************************************************************/

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

?>
<!-- dialog_background -->
<div id="search_background">
	<div id="inner_background">
		<div class="loader"></div>
	</div>
</div>

<script type="text/javascript">

var rice_items = [
		  ["kokusanmai", "国産米", "こくさんまい"],
          ["yamadanishiki", "山田錦", "やまだにしき"],
          ["yamadaho", "山田穂", "やまだぼ"],
          ["gohyakumangoku", "五百万石", "ごひゃくまんごく"],
          ["omachi", "雄町", "おまち"],
          ["aiyama", "愛山", "あいやま"],
          ["akitashukomachi", "秋田酒こまち", "あきたさけこまち"],
          ["akinosei", "秋の精", "あきのせい"],
          ["ipponjime", "一本〆", "いっぽんじめ"],
          ["oyamanishiki", "雄山錦", "おやまにしき"],
          ["kairyoshinko", "改良信交", "かいりょうしんこう"],
          ["kamenoo", "亀の尾", "かめのお"],
          ["ginotome", "ぎんおとめ", "ぎんおとめ"],
          ["ginginga", "吟ぎんが", "ぎんぎんが"],
          ["ginnosato", "吟のさと", "ぎんのさと"],
          ["ginnosei", "吟の精", "ぎんのせい"],
          ["gimpu", "吟風", "ぎんぷう"],
          ["ginfubuki", "吟吹雪", "ぎんふぶき"],
          ["kinmonnishiki", "金紋錦", "きんもんにしき"],
          ["kuranohana", "蔵の華", "くらのはな"],
          ["koshitanrei", "越淡麗", "こしたんれい"],
          ["koshinoshizuku", "越の雫", "こしのしずく"],
          ["saitonoshizuku", "西都の雫", "さいとのしずく"],
          ["sakemirai", "酒未来", "さけみらい"],
          ["sakemusashi", "さけ武蔵", "さけむさし"],
          ["shinriki", "神力", "しんりき"],
          ["suisei", "彗星", "すいせい"],
          ["senbonnishiki", "千本錦", "せんぼんにしき"],
          ["tatsunootoshigo", "龍の落とし子", "たつのおとしご"],
          ["tamazakae", "玉栄", "たまさかえ"],
          ["dewasansan", "出羽燦々", "でわさんさん"],
          ["dewanosato", "出羽の里", "でわのさと"],
          ["hattan", "八反", "はったん"],
          ["hattannishiki", "八反錦", "はったんにしき"],
          ["hanaomoi", "華想い", "はなおもい"],
          ["hanafubuki", "華吹雪", "はなふぶき"],
          ["hitachinishiki", "ひたち錦", "ひたちにしき"],
          ["hitogokochi", "ひとごこち", "ひとごこち"],
          ["hohai", "豊盃", "ほうはい"],
          ["hoshiakari", "星あかり", "ほしあかり"],
          ["maikaze", "舞風", "まいかぜ"],
          ["misatonishiki", "美郷錦", "みさとにしき"],
          ["miyamanishiki", "美山錦", "みやまにしき"],
		  ["yamasakeyongo", "山酒4号（玉苗）", "やまさけよんごう（たまなえ）"],
          ["yuinoka", "結の香", "ゆいのか"],
          ["yumenoka", "夢の香", "ゆめのかおり"],
          ["wakamizu", "若水", "わかみず"],
          ["wataribune", "渡船", "わたりぶね"],
          ["other", "その他", "そのた"]];

function GetRiceString(rice_used) {

	var rice_array = rice_used.split('/');
	var rice_text = "";

	for(var i = 0; i < rice_array.length; i++) {
		var rice_entry = rice_array[i].split(',');

		rice_text += "<span>";

		for(var j = 0; j < rice_items.length; j++) {

			if(rice_entry[0] == rice_items[j][0]) {
	
				if(rice_entry[1] == "1") {
					rice_text += "麹米:";
				} else if(rice_entry[1] == "2") {
					rice_text += "掛米:";
				}

				if(rice_entry[0] == "other") {
					rice_text += (i == 0) ? rice_entry[3] : ' / ' + rice_entry[3];
					//rice_text += rice_entry[3];
				} else {
					//alert("rice_array[j]:" + rice_array[i]);
					rice_text += (i == 0) ? rice_items[j][1] : ' / ' + rice_items[j][1];
				}

				break;
			}
		}

		rice_text += "</span>";
	}

	return rice_text;
}

//hirasawa追加ここから/////////////////////////////////////////////////////////
/*スマホ絞り込み検索コンテンツ*/
$(document).on('click', '#mobile_sake_searchplus', function(e){
	$('#tabs-30_content').slideToggle();
});

$(document).on('click', '#mobile_brewery_searchplus', function(e){
	$('#tabs-31_content').slideToggle();
});

// Loadingイメージ表示関数
function dispLoading(){
     //$(".loading").css({"visibility": "visible"});
	 $('#search_background').css('display', 'block');
}

// Loadingイメージ削除関数
function removeLoading(){
     //$(".loading").css({"visibility": "hidden"});
	 $('#search_background').css('display', 'none');
}

///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
// all mode
///////////////////////////////////////////////////////////////////////////////////////////////

$(function() {

		function all_serialize(in_disp_from, in_disp_to) {

			var data = "category=1";

			if($('#sake_input').val() && $('#sake_input').val() != "") {
				data += "&keyword=" + $('#sake_input').val();
			}

			if(in_disp_to && in_disp_to > 0) {
				data += "&from=" + in_disp_from + "&to=" + in_disp_to;
			}
			else {
				var page = (in_disp_from / 25) + 1;
				data += "&page=" + page;
			}

			return data;
		}

		$('#tab_accordion a[href="#tabs-29"]').click(function() {

			var in_disp_from = 0;
			var in_disp_to = 25;

			$('#category').val(1);
			$('#tabs-29').fadeIn(400);
			$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
			$('#tabs-all').removeClass('hide').addClass('show').show();

			$('.accordion_title').css({"display": "block"});

			var data = all_serialize(in_disp_from, in_disp_to) + "&count_query=1";
			var my_url = "?" + all_serialize(in_disp_from, 0);

			var stateObj = { 'url': my_url,
							 'category': $('#category').val(),
							 'keyword': $('#sake_input').val(),
							 'from': in_disp_from,
							 'to': in_disp_to };

			history.pushState(stateObj, "test1", my_url);
			$("#search_content .menu li:nth(0)").trigger('click');

			searchAll(data, in_disp_from, in_disp_to, 1);
		});

		function strncmp(str1, str2, n)
		{
			str1 = str1.substring(0, n);
			str2 = str2.substring(0, n);
			return (( str1 == str2 ) ? 0 : (( str1 > str2 ) ? 1 : -1 ));
		}

		function searchAll(data, in_disp_from, in_disp_to, count_query)
		{
				//alert("data:" + data);

				dispLoading("処理中...");

				$.ajax({
						type: "POST",
						url: "complex_search.php",
						data: data,
						dataType: 'json',

				}).done(function(data){

						var innerHTML = "";
						var i = 0;
						var sake = data[0].result;

						removeLoading();
						$('#search_general_result').empty();

						//alert("success:" +  data[0].sql);

						if(sake != null)
						{
								var j = 0;
								var alcohol_array = 0;
								var syudo_array = 0;

								if(count_query == 1) {
									//alert("data[0].count:" + data[0].count);
									$('#count_result').text("件 / 全" + data[0].count + "件");
									$('#hidden_all_count_query').val(data[0].count);
								}

								for(i = 0; i < sake.length; i++)
								{
										if(!strncmp(sake[i].id, 'A', 1))
										{
											/////////////////////////////////////////////////////////////////////////////////////////
											// 日本酒
											/////////////////////////////////////////////////////////////////////////////////////////
											var rank_width = (sake[i].rank / 5) * 100 + '%';
											var innerHTML = '<a class="searchRow_link" href="sake_view.php?sake_id=' + sake[i].id + '">' +
																'<div class="search_result_name_container">' +
																	'<div class="search_result_sake_image"><img src="' + sake[i].filename + '"></div>' +
																	'<div class="search_result_sake_brewery_date_container">' +
																	'<div class="search_result_sake">' + sake[i].sake_name + '</div>' +
																	'<div class="search_result_brewery_date_container">' +
																			'<div class="search_result_brewery">' + sake[i].sakagura_name + ' / ' + sake[i].pref + '</div>' +
																			'<div class="search_result_date">' + sake[i].write_date + '</div>' +
																	'</div>' +
																'</div></div>' +
																'<div class="search_result_rank">' +
																	'<div class="search_result_star_rating">' +
																		'<div class="search_result_star_rating_front" style="width: ' + rank_width + '">★★★★★</div>' +
																		'<div class="search_result_star_rating_back">★★★★★</div>' +
																	'</div>';
																	if(sake[i].rank) {
																		innerHTML += '<span class="search_result_sake_rate">' + sake[i].rank.toFixed(1) + '</span>';
																	} else {
																		innerHTML += '<span class="search_result_sake_rate" style="color: #b2b2b2;">--</span>';
																	}
																innerHTML += '</div>';

														innerHTML += '<div class="spec">';

															innerHTML += '<div class="spec_item">';
															innerHTML += '<div class="spec_title"><svg class="spec_item_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg>特定名称</div>';
															innerHTML += '<div class="spec_info">';

																if(sake[i].special_name && sake[i].special_name != "") {
																	innerHTML += sake[i].special_name;
																} else {
																	innerHTML += '<span style="color: #b2b2b2">--</span>';
																}

															innerHTML += '</div>';
															innerHTML += '</div>';

															//////////////////////////////////////////////
															innerHTML += '<div class="spec_item">' + '<div class="spec_title"><svg class="spec_item_alc1616"><use xlink:href="#alc1616"/></svg>Alc度数</div>' + '<div class="spec_info">';

																if(sake[i].alcohol_level != undefined && sake[i].alcohol_level != null && sake[i].alcohol_level != "") {
																	var alcohol_array = sake[i].alcohol_level.split(',');
																	if(alcohol_array.length == 1) {
																		innerHTML += alcohol_array[0] + '%';
																	} else {
																		if(alcohol_array[0] == alcohol_array[1] && alcohol_array[0] != "") {
																			innerHTML += alcohol_array[0] + '%';
																		} else if(alcohol_array[0] != "" && alcohol_array[1] != "") {
																			innerHTML += alcohol_array[0] + '～' + alcohol_array[1] + '%';
																		} else if(alcohol_array[0] != "" && alcohol_array[1] == "") {
																			innerHTML += alcohol_array[0] + '%';
																		} else {
																			innerHTML += '<span style="color: #b2b2b2">--</span>';
																		}
																	}
																} else {
																	innerHTML += '<span style="color: #b2b2b2">--</span>';
																}

																innerHTML += '</div>';
															innerHTML += '</div>';

															///////////////////////////////////////////////////////////////
															innerHTML += '<div class="spec_item">';
															innerHTML += '<div class="spec_title"><svg class="spec_item_rice1616"><use xlink:href="#rice1616"/></svg>原料米</div>';
															innerHTML += '<div class="spec_info">';

																if(sake[i].rice_used != null && sake[i].rice_used != "") {
																	innerHTML += GetRiceString(sake[i].rice_used);
																} else {
																	innerHTML += '<span style="color: #b2b2b2">--</span>';
																}

															innerHTML += '</div>';
															innerHTML += '</div>';

															//////////////////////////////////////////////
															innerHTML += '<div class="spec_item">';
															innerHTML += '<div class="spec_title"><svg class="spec_item_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg>精米歩合</div>';
															innerHTML += '<div class="spec_info">';

																if(sake[i].seimai_rate && sake[i].seimai_rate != undefined && sake[i].seimai_rate != "") {
																	var seimai_array = sake[i].seimai_rate.split(',');
																	var rice_array = [];

																	if(sake[i].rice_used && sake[i].rice_used != undefined && sake[i].rice_used != "") {
																		rice_array = sake[i].rice_used.split('/');
																	}

																	for(var j = 0; j < seimai_array.length; j++) {
																		if(rice_array.length > 0 && j < rice_array.length) {
																			var rice_entry = rice_array[j].split(',');

																			if(rice_entry[1] == "1") {
																				innerHTML += "麹米:";
																			} else if(rice_entry[1] == "2") {
																				innerHTML += "掛米:";
																			}
																		}

																		if(seimai_array[j] != "") {
																			innerHTML += seimai_array[j] + '%';
																		}

																		if(j < (seimai_array.length - 1) && seimai_array[j + 1] != "") {
																			innerHTML += " / ";
																		}
																	}
																} else {
																	innerHTML += '<span style="color: #b2b2b2;">--</span>';
																}

															innerHTML += '</div>';
															innerHTML += '</div>';
															/////////////////////////////////////////////
															innerHTML += '<div class="spec_item">';
															innerHTML += '<div class="spec_title"><svg class="spec_item_nihonshudo1616"><use xlink:href="#nihonshudo1616"/></svg>日本酒度</div>';
															innerHTML += '<div class="spec_info">';

																if(sake[i].jsake_level && sake[i].jsake_level != undefined && sake[i].jsake_level != "") {
																	var syudo_array = sake[i].jsake_level.split(',');
																	if(syudo_array.length == 1) {
																		innerHTML += parseFloat(syudo_array[0]).toFixed(1);
																	} else {
																		if(syudo_array[0] == syudo_array[1]) {
																			innerHTML += parseFloat(syudo_array[0]).toFixed(1);
																		} else if(syudo_array[0] != "" && syudo_array[1] != "") {
																			innerHTML += parseFloat(syudo_array[0]).toFixed(1) + '～' + parseFloat(syudo_array[1]).toFixed(1);
																		} else if(syudo_array[0] != "" && syudo_array[1] == "") {
																			innerHTML += parseFloat(syudo_array[0]).toFixed(1);
																		}
																	}
																} else {
																	innerHTML += '<span style="color: #b2b2b2;">--</span>';
																}

															innerHTML += '</div>';
															innerHTML += '</div>';
														innerHTML += '</div>';

												innerHTML += '</a>'; // searchRow_link

											  $('#search_general_result').append(innerHTML);
										}
										else if(!strncmp(sake[i].id, 'B', 1))
										{
												////////////////
												// 酒蔵
												////////////////

												innerHTML = '<a class="sakaguraRow_link" href="sda_view.php?id=' + sake[i].id + '">';

												/////////////////////////////////////////////////////////////////////////////
												innerHTML += '<div class="search_sakagura_result_name_container">';
													/*一時的に非表示innerHTML += '<div class="search_sakagura_result_brewery_image"><img id="' + sake[i].filename + '" src="' + sake[i].filename + '"></div>';*/

													innerHTML += '<div class="search_sakagura_result_brewery_pref_date_container">';
														innerHTML += '<div class="search_sakagura_result_brewery">' + sake[i].sake_name + '</div>';
														innerHTML += '<div class="search_sakagura_result_pref_date_container">';
															innerHTML += '<div class="search_sakagura_result_pref">' + sake[i].pref + ' ' + sake[i].address + '</div>';
															innerHTML += '<div class="search_sakagura_result_date">' + sake[i].write_date + '</div>';
														innerHTML += '</div>';
													innerHTML += '</div>';

												innerHTML += '</div>';
												/////////////////////////////////////////////////////////////////////////////

												innerHTML += '<div class="sakagura_spec">';

													///////////
													innerHTML += '<div class="sakagura_spec_item">';
													innerHTML += '<span class="sakagura_spec_title"><svg class="spec_item_bottle1616"><use xlink:href="#bottle1616"/></svg>代表銘柄</span>';
													innerHTML += '<span class="sakagura_spec_info">';
														if(sake[i].brand != undefined)
															innerHTML += sake[i].brand;
														else
															innerHTML += '<span style="color: #b2b2b2;">--</span>';
													innerHTML += '</span>';
													innerHTML += '</div>';

													/////////////////////////////////////////////////
													innerHTML += '<div class="sakagura_spec_item">';
													innerHTML += '<span class="sakagura_spec_title"><svg class="spec_item_visit1616"><use xlink:href="#visit1616"/></svg>酒蔵見学</span>';
													innerHTML += '<span class="sakagura_spec_info">';
														if(sake[i].observation == 1)
															innerHTML += '可';
														else if(sake[i].observation == 2)
															innerHTML += '不可';
														else
															innerHTML += '<span style="color: #b2b2b2;">--</span>';
													innerHTML += '</span>';
													innerHTML += '</div>';

													/////////////////////////////////////////////////
													innerHTML += '<div class="sakagura_spec_item">';
													innerHTML += '<span class="sakagura_spec_title"><svg class="spec_item_visit1616"><use xlink:href="#visit1616"/></svg>酒蔵直販店</span>';
													innerHTML += '<span class="sakagura_spec_info">';
														if(sake[i].direct_sale == 1)
															innerHTML += 'あり';
														else if(sake[i].direct_sake == 2)
															innerHTML += 'なし';
														else
															innerHTML += '<span style="color: #b2b2b2;">--</span>';
													innerHTML += '</span>';
													innerHTML += '</div>';

													/////////////////////////////////////////////////
													/*innerHTML += '<div class="sakagura_spec_item">';
													innerHTML += '<div class="sakagura_spec_title"><svg class="spec_item_visit1616"><use xlink:href="#visit1616"/></svg>酒造組合登録</div>';
													innerHTML += '<div class="sakagura_spec_info">';

													if(sake[i].kumiai == 10)
														innerHTML += 'あり';
													else if(sake[i].kumiai == 11)
														innerHTML += 'なし';
													else if(sake[i].kumiai == 12)
														innerHTML += '不明';
													else
														innerHTML += '--';

													innerHTML += '</div>';
													innerHTML += '</div>';

													/////////////////////////////////////////////////
													innerHTML += '<div class="sakagura_spec_item">';
													innerHTML += '<div class="sakagura_spec_title">国税庁登録</div>';
													innerHTML += '<div class="sakagura_spec_info">';

													if(sake[i].kokuzei == 10)
														innerHTML += 'あり';
													else if(sake[i].kokuzei == 11)
														innerHTML += 'なし';
													else if(sake[i].kokuzei == 12)
														innerHTML += '不明';
													else
														innerHTML += '--';

													innerHTML += '</div>';
													innerHTML += '</div>';

													/////////////////////////////////////////////////
													innerHTML += '<div class="sakagura_spec_item">';
													innerHTML += '<div class="sakagura_spec_title">プライオリティ</div>';
													innerHTML += '<div class="sakagura_spec_info">';

													if(sake[i].priority == 1)
														innerHTML += 'S'
													else if(sake[i].priority == 2)
														innerHTML += 'A'
													else if(sake[i].priority == 3)
														innerHTML += 'B'
													else if(sake[i].priority == 4)
														innerHTML += 'C'
													else if(sake[i].priority == 5)
														innerHTML += 'D'
													else if(sake[i].priority == 6)
														innerHTML += 'E'
													else if(sake[i].priority == 7)
														innerHTML += 'X'
													else
														innerHTML += '--'

													innerHTML += '</div>';
													innerHTML += '</div>';

													/////////////////////////////////////////////////
													innerHTML += '<div class="sakagura_spec_item">';
													innerHTML += '<div class="sakagura_spec_title">ステータス</div>';
													innerHTML += '<div class="sakagura_spec_info">';

													if(sake[i].status == 10)
														innerHTML += 'active';
													else if(sake[i].status == 11)
														innerHTML += 'inactive';
													else if(sake[i].status == 12)
														innerHTML += '一時製造休止';
													else if(sake[i].status == 13)
														innerHTML += '営業不明';
													else
														innerHTML += '--';

													innerHTML += '</div>';
													innerHTML += '</div>';*/

												////////////
												innerHTML += '</div>'; // sakaguraspec
												////////////

												innerHTML += '</a>'; // sakaguraRow_link

												$('#search_general_result').append(innerHTML);

												//$('#search_sakagura_result').css({"visibility":"visible"});
												//alert("sake.length:" + sake.length + "i:" + i);
										}
										else if(!strncmp(sake[i].id, 'S', 1))
										{
												////////////////
												// 酒販店
												////////////////
												/*
												var path = "images/icons/camera20.svg";

												innerHTML += '<div class="syuhantenRow" sake_id=' + sake[i].id + '>';
													innerHTML += '<div><img style="border-radius:4px; width:98%; height:auto" src="images/photo/thumb/' + default_image + '"></div>';

														innerHTML += '<div>';
															innerHTML += '<button class="custom_button" sake_id=' + sake[i].id + '><span class="button-icon"><img src="images/icons/heart.svg"></span><span class="button-text">コメント・写真</span></button>';
															innerHTML += '<button class="custom_button" sake_id=' + sake[i].id + '><span class="button-icon"><img src="images/icons/pin.svg"></span><span class="button-text">お気に入り酒販店</span></button>';
														innerHTML += '</div>';

													innerHTML += '<div><a style="text-decoration:none" href="syuhan_view.php?syuhanten_id=' + sake[i].id  + '">' + sake[i].sake_name + '</a></div>';
													innerHTML += '<div style="font-size:11px">' + sake[i].postal_code + '  ' + sake[i].address + '</div>';
													innerHTML += '<div style="font-size:10px">コメント 0件</div>';

													innerHTML += '<div>';
													innerHTML += '<span class="label" style="text-align:center; width:148px">プレミア銘柄・人気銘柄あり</span>';
													innerHTML += '<span class="label" style="text-align:center; width:98px">一杯５００円以下</span>';
													innerHTML += '<span class="label" style="text-align:center; width:98px">日本酒にこだわる</span>';
													innerHTML += '</div>';
												innerHTML += '</div>';
												$('#search_general_result').append(innerHTML);
												*/
										}
								}


								//////////////////////////////////////////////////////////////////////////////////////////////////////////////
								//////////////////////////////////////////////////////////////////////////////////////////////////////////////
								var p_max = 25;

								if(count_query == 1 && $('#hidden_all_count_query').val() > p_max) {

										var numPage = Math.ceil($('#hidden_all_count_query').val() / p_max);
										numPage = (numPage > 5) ? 5 : numPage;

										$('#allpage').empty();
										$('#allpage').append('<button id="prev_all" class="search_button" style="margin-right:2px">前の' + p_max + '件</button>');

										for(i = 1; i <= numPage; i++) {
											if(i == 1)
												$('#allpage').append('<button class="search_button pageitems" style="text-align:center; width:26px; background:#22445B; color:#fff; margin-right:2px">1</button>');
											else
												$('#allpage').append('<button class="search_button pageitems" style="text-align:center; width:26px; margin-right:2px">' + i + '</button>');
										}

										$('#allpage').append('<button id="next_all" class="search_button" style="margin-right:2px; visibility:visible">次の' + p_max + '件</button>');
								}

								var limit = (in_disp_to >= $("#hidden_all_count_query").val()) ? $("#hidden_all_count_query").val() : in_disp_to;

								$('#in_disp_all_from').val(in_disp_from);

							    $('#view_all_result').text(parseInt($('#in_disp_all_from').val()) + 1 + '～' + limit);
								$('#count_all_result').text('件 / 全' + $('#hidden_all_count_query').val() + '件');
								$('#count_all_result').css({"display":"block"});

								var pagenum = $('#in_disp_all_from').val() / p_max;
								var showPos = parseInt($('#allpage .search_button.pageitems:first').text()) - 1;
								var position = pagenum - showPos;

								if(position < 0) {

									$('#allpage .pageitems').each(function() {
										$(this).text(parseInt($(this).text()) - 1);
										$(this).val($(this).val() - 1);
									});

									position = 0;
								}
								else if(position >= $('#allpage .pageitems').length) {

									$('#allpage .pageitems').each(function() {
										$(this).text(parseInt($(this).text()) + 1);
										$(this).val($(this).val() + 1);
									});

									position = $('#allpage .pageitems').length - 1;
								}

								//alert("in_disp_from:" + in_disp_from + " pagenum:" + pagenum + " showPos:" + showPos + " position:" + position);
								$('#allpage .pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
								$('#allpage .pageitems:nth(' + position + ')').css({"background": "#22445B", "color":"#ffffff"});

								$('html, body').animate({scrollTop:0}, '100');
						}

						////////////////////////////////////////////////////////////////////////
						// prev, next grey
						if($('#in_disp_all_from').val() >= 25) {
						    $('#prev_all').css({"color":"#0740A5", "cursor":"pointer"});
						}
						else {
							$('#prev_all').css({"color":"#b2b2b2", "cursor":"default"});
						}

						if((parseInt($('#in_disp_all_from').val()) + 25) < $("#hidden_all_count_query").val()) {
							$('#next_all').css({"color":"#0740A5", "cursor":"pointer"});
						}
						else {
							$('#next_all').css({"color":"#b2b2b2", "cursor":"default"});
						}

						removeLoading();

				}).fail(function(data){
						removeLoading();
						alert("Failed:" + data);
				}).complete(function(data){
						removeLoading();
				});
		}

	    $("body").on("search_all", function(event, data, in_disp_from, in_disp_to, count_query) {
			 searchAll(data, in_disp_from, in_disp_to, count_query);
		});

		$(document).on('click', '#prev_all', function(e){

			if(parseInt($("#in_disp_all_from").val()) >= 25) {
				var p_max = 25;
				var in_disp_to = $('#in_disp_all_from').val();
				var in_disp_from = $('#in_disp_all_from').val() - p_max;
				var data = all_serialize(in_disp_from, in_disp_to);
				var my_url = "?" + all_serialize(in_disp_from, 0);

				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#sake_input').val(),
								'from': in_disp_from,
								'to': in_disp_to };

				history.pushState(stateObj, "test1", my_url);
				searchAll(data, in_disp_from, in_disp_to, 0);
			}
		});

		$(document).on('click', '#next_all', function(e){

			var p_max = 25;

			if((parseInt($('#in_disp_all_from').val()) + p_max) < parseInt($('#hidden_all_count_query').val())) {

				var in_disp_from = parseInt($('#in_disp_all_from').val()) + p_max;
				var in_disp_to = in_disp_from + p_max;

				var data = all_serialize(in_disp_from, in_disp_to);
				var my_url = "?" + all_serialize(in_disp_from, 0);

				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#sake_input').val(),
								'from': in_disp_from,
								'to': in_disp_to };

				history.pushState(stateObj, "test1", my_url);
				searchAll(data, in_disp_from, in_disp_to, 0);

				$('#prev_all').css({"color":"#0740A5"});
			}
		});

		$(document).on('click', '#allpage .search_button.pageitems', function(e){

				$('#allpage .search_button.pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
				$(this).css({"background": "#22445B", "color":"#ffffff"});

				$('#category').val(1);

				var position = parseInt($(this).text());
				var in_disp_from = (position - 1) * 25;
				var in_disp_to = in_disp_from + 25;
				var data = all_serialize(in_disp_from, in_disp_to);
				var my_url = "?" + all_serialize(in_disp_from, 0);

				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#sake_input').val(),
								'from': in_disp_from,
								'to': in_disp_to };

				history.pushState(stateObj, "test1", my_url);

				searchAll(data, in_disp_from, in_disp_to, 0);
		});

		$('#tabs-all .click_sort_button').click(function() {
				var index = $('.click_sort_button').index(this);

				if(index == 0)
				{
				}
				else
				{
					$("#tabs-all .click_sort_standard, #tabs-all .click_sort_date").css({"color": "#b2b2b2"});
					$(this).css({"color": "#0740A5"});
				}
		});
});

///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
// sake mode
///////////////////////////////////////////////////////////////////////////////////////////////
$(function() {

		function sake_serialize(in_disp_from, in_disp_to) {

			var data = "category=" + $('#hidden_form input[name="category"]').val();

			if($('#sake_input').val() != "" && $('#sake_input').val() != undefined)
				data += '&keyword=' + $('#sake_input').val();

			if($('#hidden_form input[name="orderby"]').val() != "" && $('#hidden_form input[name="orderby"]').val() != undefined)
				data += '&orderby=' + $('#hidden_form input[name="orderby"]').val();

			if($('#hidden_form input[name="desc"]').val() != "" && $('#hidden_form input[name="desc"]').val() != undefined)
				data += '&desc=' + $('#hidden_form input[name="desc"]').val();

			if($('#sake_sidebar_form select[name="pref"]').val() != "" && $('#sake_sidebar_form select[name="pref"]').val() != undefined)
				data += '&pref=' + $('#sake_sidebar_form select[name="pref"]').val();

			if($('#sake_sidebar_form select[name="special_name"]').val() != "" && $('#sake_sidebar_form select[name="special_name"]').val() != undefined)
				data += '&special_name=' + $('#sake_sidebar_form select[name="special_name"]').val();

			if($('#sake_sidebar_form select[name="rice_used"]').val() != "" && $('#sake_sidebar_form select[name="rice_used"]').val() != undefined)
				data += '&rice_used=' + $('#sake_sidebar_form select[name="rice_used"]').val();

			if($('#sake_sidebar_form select[name="seimai_rate"]').val() != "" && $('#sake_sidebar_form select[name="seimai_rate"]').val() != undefined)
				data += '&seimai_rate=' + $('#sake_sidebar_form select[name="seimai_rate"]').val();

			///////////////////////////////////////////////////////////////////////
			if(in_disp_to && in_disp_to > 0)
				data += "&from=" + in_disp_from + "&to=" + in_disp_to;
			else {
				var page = (in_disp_from / 25) + 1;
				data += "&page=" + page;
			}
			///////////////////////////////////////////////////////////////////////

			//if($('#sake_sidebar_form input[name="from"]').val() != "" && $('#sake_sidebar_form input[name="from"]').val() != undefined)
			//	data += '&from=' + $('#sake_sidebar_form input[name="from"]').val();

			//if($('#sake_sidebar_form input[name="to]').val() != "" && $('#sake_sidebar_form input[name="to"]').val() != undefined)
			//	data += '&to=' + $('#sake_sidebar_form input[name="to"]').val();

			//&sake_category%5B%5D=11&sake_category%5B%5D=45&sake_category%5B%5D=39

			$('#sake_sidebar_form input[name="sake_category[]"]:checked').each(function() {
				data += "&sake_category%5B%5D=" + this.value;
			});

			return data;
		}

		$('#sake_sidebar_form .sake_option_trigger').click(function(){

				var obj = this;
				$(obj).next("div").slideToggle();
				//$(this).next("div").css({"overflow":"auto"});

				if ($(this).children(".arrow_icon").hasClass('active')) {
					// activeを削除
					$(this).children(".arrow_icon").removeClass('active');
				}
				else {
					// activeを追加
					$(this).children(".arrow_icon").addClass('active');
				}
		});

		$(".close_dialog_sidebar").click(function() {
				var obj = $(this).parent().parent();
				var selectedText = "";

				$(obj).find("ul li").each(function() {
						var inputObj = $(this).find("input");

						if($(inputObj).prop('checked') == true)
						{
								if(selectedText == "")
									selectedText = $(this).text();
								else
									selectedText += ", " + $(this).text();
						}
				});

				if(selectedText == "")
					selectedText = "指定なし";

				$(obj).find(".sake_option_trigger span:first-child").text(selectedText);
				$(this).closest(".dialog_sidebar").fadeOut();
		});

		$(".regular_button").click(function() {
				var obj = $(this).parent().parent();
				var selectedText = "";

				$(obj).find("ul li").each(function() {
						var inputObj = $(this).find("input");

						if($(inputObj).prop('checked') == true)
						{
								if(selectedText == "")
									selectedText = $(this).text();
								else
									selectedText += ", " + $(this).text();
						}

						//$(this).prop('checked',true);
				});

				if(selectedText == "")
					selectedText = "指定なし";

				$(obj).parent().find(".sake_option_trigger span:first-child").text(selectedText);
				$(this).closest(".dialog_sidebar").fadeOut();
		});

		$('#search_sake_result').delegate('.custom_button', 'click', function() {

			 var data = "sake_id=" + $(this).attr("sake_id");
			 var obj = this;

			 $.ajax({
					type: "post",
					url: "sake_follow.php?sake_id=<?php print($_GET['sake_id']);?>",
					data: data,
			 }).done(function(xml){
						var str = $(xml).find("str").text();
						//alert("button click");

						if(str == "follow")
						{
								//$(obj).css('background-color', '#fff');
								$(obj).animate({backgroundColor: '#e3e3e3', color: '#000'}, 'fast');
						}
						else if(str == "followed")
						{
								//$(obj).css('background-color', '#FF4545');
								$(obj).animate({ backgroundColor: '#FF4545', color: '#fff'}, 'fast');
						}

				}).fail(function(data){
							alert("This is Error");
							//$(obj).text('This is Error');
			 });
		});

		function searchSake(data, in_disp_from, in_disp_to, count_query)
		{
			dispLoading("処理中...");

			//alert("searchsake:" + data);

			$.ajax({
					type: "POST",
					url: "complex_search.php",
					data: data,
					dataType: 'json',

			}).done(function(data){

					var innerHTML = "";
					var i = 0, j = 0;
					var sake = data[0].result;
					var alcohol_array = 0;
					var syudo_array = 0;
					var innerHTML = "";

					$('#search_sake_result').empty();
					removeLoading();

					//alert("success:" + data[0].sql);
					//alert("count:" + data[0].count);
					//alert("sake_length:" + sake.length);

					if(count_query == 1) {
						//alert("count_result:" + data[0].count);
						$('#count_sake_result').text("件 / 全" + data[0].count + "件");
						$('#count_sake_result').css({"display":"block"});
						$('#sakepage').css({"display":"flex"});
						$('#hidden_sake_count_result').val(data[0].count);
					}

					//alert("SQL:" + data[0].sql);

					if(sake) {

						for(i = 0; i < sake.length; i++)
						{
								var path = sake[i].filename;
								innerHTML = '<a class="searchRow_link" href="sake_view.php?sake_id=' + sake[i].sake_id + '">';
								innerHTML += '<div class="search_result_name_container">';

										innerHTML += '<div class="search_result_sake_image"><img id="' + path + '" src="' + path + '"></div>';
										innerHTML += '<div class="search_result_sake_brewery_date_container">';
												innerHTML += '<div class="search_result_sake">' + sake[i].sake_name + '</div>';
												innerHTML += '<div class="search_result_brewery_date_container">';
														innerHTML += '<div class="search_result_brewery">' + sake[i].sakagura_name + ' / ' + sake[i].pref + '</div>';
														innerHTML += '<div class="search_result_date">' + sake[i].write_date + '</div>';
												innerHTML += '</div>';
										innerHTML += '</div>';

										/*非表示中innerHTML += '<div class="search_result_button_container">';
												innerHTML += '<button class="custom_button" sake_id=' + sake[i].sake_id + '><span class="button-icon"><svg class="search_result_button_heart2020"><use xlink:href="#heart2020"/></svg></span><span class="button-text">飲んだ</span></button>';
												innerHTML += '<button class="custom_button" sake_id=' + sake[i].sake_id + '><span class="button-icon"><svg class="search_result_button_pin1616"><use xlink:href="#pin1616"/></svg></span><span class="button-text">飲みたい</span></button>';
										innerHTML += '</div>';*/

								innerHTML += '</div>';


								// 酒ランク ////////////////////////////////////////////////
								var rank_width = (sake[i].sake_rank / 5) * 100 + '%';

								innerHTML += '<div class="search_result_rank">';
									innerHTML += '<div class="search_result_star_rating">';
										innerHTML += '<div class="search_result_star_rating_front" style="width: ' + rank_width + '">★★★★★</div>';
										innerHTML += '<div class="search_result_star_rating_back">★★★★★</div>';
									innerHTML += '</div>';

									if(sake[i].sake_rank) {
										innerHTML += '<span class="search_result_sake_rate">' + sake[i].sake_rank.toFixed(1) + '</span>';
									} else {
										innerHTML += '<span class="search_result_sake_rate" style="color: #b2b2b2;">--</span>';
									}

								innerHTML += '</div>';

								// スペック ////////////////////////////////////////////////////////////////////////////////////////////////
								innerHTML += '<div class="spec">';
										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg>特定名称</div>';
										innerHTML += '<div class="spec_info">';

												if(sake[i].special_name && sake[i].special_name != "") {
													innerHTML += sake[i].special_name;
												} else {
													innerHTML += '<span style="color: #b2b2b2;">--</span>';
												}

										innerHTML += '</div>'; // spec_info
										innerHTML += '</div>'; // spec_item

										/////////////////////////////////////////////////
										innerHTML += '<div class="spec_item">' + '<div class="spec_title"><svg class="spec_item_alc1616"><use xlink:href="#alc1616"/></svg>Alc度数</div>' + '<div class="spec_info">';

											if(sake[i].alcohol_level != undefined && sake[i].alcohol_level != null && sake[i].alcohol_level != "") {
												var alcohol_array = sake[i].alcohol_level.split(',');
												if(alcohol_array.length == 1) {
													innerHTML += alcohol_array[0] + '%';
												} else {
													if(alcohol_array[0] == alcohol_array[1]) {
														innerHTML += alcohol_array[0] + '%';
													} else if(alcohol_array[0] != "" && alcohol_array[1] != "") {
														innerHTML += alcohol_array[0] + '～' + alcohol_array[1] + '%';
													} else if(alcohol_array[0] != "" && alcohol_array[1] == "") {
														innerHTML += alcohol_array[0] + '%';
													}
												}
											} else {
												innerHTML += '<span style="color: #b2b2b2;">--</span>';
											}

										innerHTML += '</div>'; // spec_info
										innerHTML += '</div>'; // spec_item

										/////////////////////////////////////////////////
										/*
										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><img src="images/icons/sando.svg">酸度</div>';
										innerHTML += '<div class="spec_info">';

										if(sake[i].oxidation_level != null && sake[i].oxidation_level != undefined && sake[i].oxidation_level != "") {
											var oxidation_level = "" + sake[i].oxidation_level + " ";
											var oxidation_array = oxidation_level.split(',');

											if(oxidation_array.length == 1 && oxidation_array[0])
													innerHTML += oxidation_array[0];
											else if(oxidation_array.length > 1 && (oxidation_array[0] && oxidation_array[1])) {
												if(oxidation_array[0] && (!oxidation_array[1] || oxidation_array[1] != ""))
													innerHTML += oxidation_array[0];
												else if((!oxidation_array[0] || oxidation_array[0] != "") && oxidation_array[1])
													innerHTML += oxidation_array[1];
												else if(oxidation_array[0] == oxidation_array[1])
													innerHTML += oxidation_array[0];
												else
													innerHTML += oxidation_array[0] + "～" + oxidation_array[1];
											}
										}
										else {
											innerHTML += '--';
										}

										innerHTML += '</div>'; // spec_info
										innerHTML += '</div>'; // spec_item

										/////////////////////////////////////////////////
										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><img src="images/icons/alcohol.svg">製法の特徴</div>';
										innerHTML += '<div class="spec_info">';

										if(sake[i].sake_category != null && sake[i].sake_category != "")
										{
												innerHTML += sake[i].sake_category;
										}
										else
										{
												innerHTML += '--';
										}

										innerHTML += '</div>';
										innerHTML += '</div>';

										/////////////////////////////////////////////////
										*/

										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_rice1616"><use xlink:href="#rice1616"/></svg>原料米</div>';
										innerHTML += '<div class="spec_info">';

											if(sake[i].rice_used != null && sake[i].rice_used != "") {
												innerHTML += GetRiceString(sake[i].rice_used);
											} else {
												innerHTML += '<span style="color: #b2b2b2;">--</span>';
											}

										innerHTML += '</div>'; // spec_info
										innerHTML += '</div>'; // spec_item

										/////////////////////////////////////////////////
										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg>精米歩合</div>';
										innerHTML += '<div class="spec_info">';

											if(sake[i].seimai_rate && sake[i].seimai_rate != undefined && sake[i].seimai_rate != "") {
												var seimai_array = sake[i].seimai_rate.split(',');
												var rice_array = [];

												if(sake[i].rice_used && sake[i].rice_used != "") {
													rice_array = sake[i].rice_used.split('/');
												}

												for(var j = 0; j < seimai_array.length; j++) {
													if(rice_array.length > 0 && j < rice_array.length) {
														rice_entry = rice_array[j].split(',');

														if(rice_entry[1] == "1") {
															innerHTML += "麹米:";
														} else if(rice_entry[1] == "2") {
															innerHTML += "掛米:";
														}
													}

													if(seimai_array[j] != "") {
														innerHTML += seimai_array[j] + '%';
													}

													if(j < (seimai_array.length - 1) && seimai_array[j + 1] != "") {
														innerHTML += " / ";
													}
												}
											} else {
												innerHTML += '<span style="color: #b2b2b2;">--</span>';
											}

										innerHTML += '</div>'; // spec_info
										innerHTML += '</div>'; // spec_item

										/////////////////////////////////////////////////
										innerHTML += '<div class="spec_item">';
										innerHTML += '<div class="spec_title"><svg class="spec_item_nihonshudo1616"><use xlink:href="#nihonshudo1616"/></svg>日本酒度</div>';
										innerHTML += '<div class="spec_info">';

											if(sake[i].jsake_level && sake[i].jsake_level != "") {
												var syudo_array = sake[i].jsake_level.split(',');
												if(syudo_array.length == 1) {
													innerHTML += parseFloat(syudo_array[0]).toFixed(1);
												} else {
													if(syudo_array[0] == syudo_array[1]) {
														innerHTML += parseFloat(syudo_array[0]).toFixed(1);
													} else if(syudo_array[0] != "" && syudo_array[1] != "") {
														innerHTML += parseFloat(syudo_array[0]).toFixed(1) + '～' + parseFloat(syudo_array[1]).toFixed(1);
													} else if(syudo_array[0] != "" && syudo_array[1] == "") {
														innerHTML += parseFloat(syudo_array[0]).toFixed(1);
													}
												}
											} else {
												innerHTML += '<span style="color: #b2b2b2;">--</span>';
											}

										innerHTML += '</div>'; // spec_info
										innerHTML += '</div>'; // spec_item

								innerHTML += '</div>'; // spec
								innerHTML += '</a>'; // searchRow_link
								///////////////////////////////////////////////////////////////////////////

								$('#search_sake_result').append(innerHTML);
						}

						//////////////////////////////////////////////////////////////////////////////
						var p_max = 25;

						if(count_query == 1) {

							if($('#hidden_sake_count_result').val() > p_max) {
								var numPage = $('#hidden_sake_count_result').val() / p_max;
								numPage = ($('#hidden_sake_count_result').val() % p_max) ? (numPage + 1) : numPage;
								numPage = (numPage > 5) ? 5 : numPage;

								$('#sakepage').empty();
								$('#sakepage').append('<button id="prev_sake" class="search_button" style="margin-right:2px">前の' + p_max + '件</button>');

								for(i = 1; i <= numPage; i++) {
									if(i == 1)
										$('#sakepage').append('<button class="search_button pageitems" style="text-align:center; width:26px; background:#22445B; color:#fff; margin-right:2px">1</button>');
									else
										$('#sakepage').append('<button class="search_button pageitems" style="text-align:center; width:26px; margin-right:2px">' + i + '</button>');
								}

								$('#sakepage').append('<button id="next_sake" class="search_button" style="margin-right:2px; visibility:visible">次の' + p_max + '件</button>');
							}
							else {
								$('#sakepage').empty();
							}
						}

						//////////////////////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////

						$('#in_disp_sake_from').val(in_disp_from);
						$('#in_disp_sake_to').val(in_disp_to);

						var showPos = parseInt($('#sakepage .search_button.pageitems:first').text()) - 1;
						var pagenum = $('#in_disp_sake_from').val() / p_max;
						var position = pagenum - showPos;

						if(position < 0) {

							$('#sakepage .pageitems').each(function() {
								$(this).text(parseInt($(this).text()) - 1);
								$(this).val($(this).val() - 1);
							});

							position = 0;
						}
						else if(position >= $('#sakepage .pageitems').length) {

							$('#sakepage .pageitems').each(function() {
								$(this).text(parseInt($(this).text()) + 1);
								$(this).val($(this).val() + 1);
							});

							position = $('#sakepage .pageitems').length - 1;
						}

						//alert("pagenum:" + pagenum + " showPos:" + showPos + " nth:" + position);
						$('#sakepage .pageitems').css({"background": "#c6c6c6", "color":"#404040"});
						$('#sakepage .pageitems:nth(' + position + ')').css({"background": "#22445B", "color":"#ffffff"});

						//////////////////////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////

						var limit = (parseInt($('#in_disp_sake_to').val()) >= $("#hidden_sake_count_result").val()) ? $("#hidden_sake_count_result").val() : parseInt($('#in_disp_sake_to').val());
						$('#view_sake_result').text(parseInt($('#in_disp_sake_from').val()) + 1 + '～' + limit);

						$('html, body').animate({scrollTop:0}, '100');

						if($('.mobilesake_container').css('display') != 'none') {
							$('#tabs-30_content').css('display', 'none');
						}
					}
					else {
						$("#count_sake_result").css({"display":"none"});
						$('#sakepage').css({"display":"none"});
						$('#view_sake_result').text("検索結果がありません。");
					}

					if(parseInt($('#in_disp_sake_from').val()) >= 25)
						$('#prev_sake').css({"color":"#0740A5", "cursor":"pointer"});
					else
						$('#prev_sake').css({"color":"#b2b2b2", "cursor":"default"});

					if((parseInt($('#in_disp_sake_from').val()) + 25) < parseInt($("#hidden_sake_count_result").val()))
						$('#next_sake').css({"color":"#0740A5", "cursor":"pointer"});
					else
						$('#next_sake').css({"color":"#b2b2b2", "cursor":"default"});

				}).fail(function(data){
						alert("Failed:" + data);
				}).complete(function(data){
						// Loadingイメージを消す
						removeLoading();
				});
		}

	    $("body").on("search_sake", function( event, data, in_disp_from, in_disp_to, count_query) {
			 searchSake(data, in_disp_from, in_disp_to, count_query);
		});

		$(document).on('click', '#next_sake', function(e){

				if(parseInt($('#in_disp_sake_to').val()) < parseInt($('#hidden_sake_count_result').val()))
				{
					var p_max = 25;
					var in_disp_from = parseInt($("#in_disp_sake_from").val()) + p_max;
					var in_disp_to = in_disp_from + p_max;

					$('#category').val(2);

					var data = sake_serialize(in_disp_from, in_disp_to);
					var my_url = "?" + sake_serialize(in_disp_from, 0);
					var stateObj = { 'url': my_url,
									'category': $('#category').val(),
									'keyword': $('#sake_input').val(),
									'from': in_disp_from,
									'to': in_disp_to };

					history.pushState(stateObj, "test1", my_url);
					searchSake(data, in_disp_from, in_disp_to, 0);
				}
		});

		$(document).on('click', '#prev_sake', function(e) {

			if(parseInt($("#in_disp_sake_from").val()) >= 25) {

				var p_max = 25;
				var in_disp_to = parseInt($("#in_disp_sake_from").val());
				var in_disp_from = in_disp_to - p_max;

				$('#category').val(2);

				var data = sake_serialize(in_disp_from, in_disp_to);
				var my_url = "?" + sake_serialize(in_disp_from, 0);
				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#sake_input').val(),
								'from': in_disp_from,
								'to': in_disp_to };

				history.pushState(stateObj, "test1", my_url);
				$('#next_sake').css({"color":"#0740A5"});
				searchSake(data, in_disp_from, in_disp_to, 0);
			}
		});

		$(document).on('click', '#sakepage .search_button.pageitems', function(e){

				var position = parseInt($(this).text());
				var p_max = 25;
				var in_disp_from = (position - 1) * p_max;
				var in_disp_to = in_disp_from + 25;

				$('#category').val(2);
				$('#sakepage .search_button.pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
				$(this).css({"background": "#22445B", "color":"#ffffff"});

				var data = sake_serialize(in_disp_from, in_disp_to);
				var my_url = "?" + sake_serialize(in_disp_from, 0);
				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#hidden_form input[name="keyword"]').val(),
								'from': $('#in_disp_sake_from').val(),
								'to': $('#in_disp_sake_to').val() };

				history.pushState(stateObj, "test1", my_url);
				searchSake(data, in_disp_from, in_disp_to, 0);
		});

		$('#tabs-sake .click_sort_button').click(function() {

				var in_disp_from = 0;
				var in_disp_to = 25;
				var index = $('.click_sort_button').index(this);
				$('#category').val(2);

				if(index == 0) {
					if($('#hidden_desc').val() == "ASC") {
						$('#hidden_desc').val("DESC");
					}
					else {
						$('#hidden_desc').val("ASC");
					}
				}
				else {
					$('#hidden_sort').val($(this).data("value"));
					$("#tabs-sake .click_sort_standard, #tabs-sake .click_sort_date, #tabs-sake .click_sort_ranking").css({"color": "#b2b2b2"});
					$(this).css({"color": "#0740A5"});
				}

				var data = $("#sake_sidebar_form").serialize() + '&' + $("#hidden_form").serialize();
				var keyword = <?php echo json_encode($keyword); ?>;

				if(keyword && keyword != null)
					data += "&keyword=" + keyword;

				searchSake(data, in_disp_from, in_disp_to, 0);
		});

		$(document).on('click', '#submit_sake_search.sake_accordion', function(e){

				event.preventDefault();
				$('#category').val(2);

				var in_disp_from = 0;
				var in_disp_to = 25;
				var data = sake_serialize(in_disp_from, in_disp_to) + "&count_query=1";
				var my_url = "?" + sake_serialize(in_disp_from, 0) + "&count_query=1";
				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#sake_input').val(),
								'pref': $('select[name="pref"]').val(),
								'special_name': $('select[name="special_name"]').val(),
								'rice_used': $('select[name="rice_used"]').val(),
								'from': in_disp_from,
								'to': in_disp_to };

				history.pushState(stateObj, "test1", my_url);
				searchSake(data, in_disp_from, in_disp_to, 1);
		});

		$('#tab_accordion a[href="#tabs-30"]').click(function() {

				var in_disp_from = 0;
				var in_disp_to = 25;

				$('#tabs-30').fadeIn(400);
				$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
				$('#tabs-sake').removeClass('hide').addClass('show').show();
				$('#tabs-30_content').css('display', 'block');
				$('#category').val(2);

				$('#prev_sake').css({"color":"#b2b2b2"});
				$('#next_sake').css({"color":"#0740A5"});
				$('.accordion_title').css({"display": "block"});

				var data = sake_serialize(in_disp_from, in_disp_to) + "&count_query=1";
				var my_url = "?" + sake_serialize(in_disp_from, 0);

				$("#submit_sake_search").removeClass("sake_accordion sakagura_accordion syuhanten_accordion inshokuten_accordion");
				$('#submit_sake_search').addClass("sake_accordion");
				$('#sake_sidebar_form').css({"display": "block"});
				$("#search_content .menu li:nth(1)").trigger('click');

				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#sake_input').val(),
								'from': in_disp_from,
								'to': in_disp_to };

				history.pushState(stateObj, "test1", my_url);
				searchSake(data, in_disp_from, in_disp_to, 1);
	  });
});

///////////////////////////////////////////////////////////////////////////////////////////////
// sakagura mode
///////////////////////////////////////////////////////////////////////////////////////////////
$(function() {

		function sakagura_serialize(in_disp_from, in_disp_to) {

			var data = "category=" + $('#hidden_form input[name="category"]').val();
			//var data = $("#hidden_form").serialize() + '&' + $("#sakagura_sidebar_form").serialize();
			//$("#sakagura_sidebar_form").serialize() + '&' + $("#hidden_form").serialize() + '&count_query=1';

			if($('#sake_input').val())
				data += '&keyword=' + $('#sake_input').val();

			if($('#hidden_form input[name="orderby"]').val() != "" && $('#hidden_form input[name="orderby"]').val() != undefined)
				data += '&orderby=' + $('#hidden_form input[name="orderby"]').val();

			if($('#hidden_form input[name="desc"]').val() != "" && $('#hidden_form input[name="desc"]').val() != undefined)
				data += '&desc=' + $('#hidden_form input[name="desc"]').val();

			if($('#sakagura_sidebar_form select[name="sakagura_pref"]').val() != "" && $('#sakagura_sidebar_form select[name="sakagura_pref"]').val() != undefined)
				data += '&pref=' + $('#sakagura_sidebar_form select[name="sakagura_pref"]').val();

			if($('#sakagura_sidebar_form select[name="observation"]').val() != "" && $('#sakagura_sidebar_form select[name="observation"]').val() != undefined)
				data += '&observation=' + $('#sakagura_sidebar_form select[name="observation"]').val();

			if(in_disp_to && in_disp_to > 0) {
				data += "&from=" + in_disp_from + "&to=" + in_disp_to;
			}
			else {
				var page = (in_disp_from / 25) + 1;
				data += "&page=" + page;
			}

			//if($('#sakagura_sidebar_form input[name="from"]').val() != "" && $('#sakagura_sidebar_form input[name="from"]').val() != undefined)
			//	data += '&from=' + $('#sakagura_sidebar_form input[name="from"]').val();

			//if($('#sakagura_sidebar_form input[name="to]').val() != "" && $('#sakagura_sidebar_form input[name="to"]').val() != undefined)
			//	data += '&to=' + $('#sakagura_sidebar_form input[name="to"]').val();

			return data;
		}

		$('#tab_accordion a[href="#tabs-31"]').click(function() {
				$('#tabs-31').fadeIn(400);
				$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
				$('#tabs-sakagura').removeClass('hide').addClass('show').show();
				$('#category').val(3);

				var in_disp_from = 0;
				var in_disp_to = 25;

				$('.accordion_title').css({"display": "block"});

				var data = sakagura_serialize(in_disp_from, in_disp_to) + '&count_query=1';
				var my_url = "?" + sakagura_serialize(in_disp_from, 0);

				$("#submit_sakagura_search").removeClass("sake_accordion sakagura_accordion syuhanten_accordion inshokuten_accordion");
				$('#submit_sakagura_search').addClass("sakagura_accordion");
				$('#sakagura_sidebar_form').css({"display": "block"});

				$('#category').val(3);

				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#sake_input').val(),
								'from': in_disp_from,
								'to': in_disp_to };

				history.pushState(stateObj, "test1", my_url);

				$("#search_content .menu li:nth(2)").trigger('click');
				searchSakagura(data, in_disp_from, in_disp_to, 1);
		});

		$("#sakagura_sidebar_form ul span, #sakagura_sidebar_form ul button").click(function() {
				$(this).parent().fadeToggle();
		});

		$('#sakagura_sidebar_form .sakagura_option_trigger').click(function(){
			var obj = this;

			$('.sake_option_trigger').each(function(){
				if(this != obj)
				{
					$(this).next(".dialog_sidebar").css({"display":"none"});
					$(this).removeClass('active');
					$(this).find('span:nth-child(2)').html('&#x25BC')
				}
			});

			$(this).next("div").slideToggle();

			if ($(this).children(".arrow_icon").hasClass('active')) {
				// activeを削除
				$(this).children(".arrow_icon").removeClass('active');
			}
			else {
				// activeを追加
				$(this).children(".arrow_icon").addClass('active');
			}
		});

		$("#sakagura_sidebar_form ul span, #sake_sidebar_form ul button").click(function() {
				$(this).parent().fadeToggle();
		});

		$('#tabs-sakagura .click_sort_button').click(function() {
			var index = $('.click_sort_button').index(this);

			if(index == 0)
			{
			}
			else
			{
				$("#tabs-sakagura .click_sort_standard, #tabs-sakagura .click_sort_date").css({"color": "#b2b2b2"});
				$(this).css({"color": "#0740A5"});
			}
		});

		function searchSakagura(data, in_disp_from, in_disp_to, count_query)
		{
				dispLoading("処理中...");

				$.ajax({
						type: "POST",
						url: "complex_search.php",
						data: data,
						dataType: 'json',

				}).done(function(data){

						var innerHTML = "";
						var i = 0;
						var sakagura = data[0].result;

						removeLoading();
						//alert("searchSakagura:success data:" + data[0].result);
						//alert("searchSakagura:success data[0].sql:" + data[0].sakagura + " data[0].result:" + data[0].result);
						//alert("sql:" + data[0].sql + " 検索結果:" + data[0].count);

						$('#search_sakagura_result').empty();

						if(sakagura) {
								var j = 0;
								var alcohol_array = 0;
								var syudo_array = 0;

								if(count_query == 1)
								{
									$('#count_sakagura_result').text("件 / 全" + data[0].count + "件");
									$('#count_sakagura_result').css({"display":"block"});
									$('#hidden_sakagura_count_result').val(data[0].count);
									$('#sakagurapage').css({"display":"flex"});
									//alert("count_result:" + data[0].count);
								}

								for(i = 0; i < sakagura.length; i++)
								{
										innerHTML = '<a class="sakaguraRow_link" href="sda_view.php?id=' + sakagura[i].id + '">';

										/////////////////////////////////////////////////////////////////////////////
										innerHTML += '<div class="search_sakagura_result_name_container">';
											/*一時的に非表示innerHTML += '<div class="search_sakagura_result_brewery_image"><img id="' + sakagura[i].filename + '" src="' + sakagura[i].filename + '"></div>';*/

											innerHTML += '<div class="search_sakagura_result_brewery_pref_date_container">';
												innerHTML += '<div class="search_sakagura_result_brewery">' + sakagura[i].sakagura_name + '</div>';
												innerHTML += '<div class="search_sakagura_result_pref_date_container">';
													innerHTML += '<div class="search_sakagura_result_pref">' + sakagura[i].pref + ' ' + sakagura[i].address + '</div>';
													innerHTML += '<div class="search_sakagura_result_date">' + sakagura[i].write_date + '</div>';
												innerHTML += '</div>';
											innerHTML += '</div>';

										innerHTML += '</div>';
										/////////////////////////////////////////////////////////////////////////////

										innerHTML += '<div class="sakagura_spec">';

											///////////
											innerHTML += '<div class="sakagura_spec_item">';
											innerHTML += '<span class="sakagura_spec_title"><svg class="spec_item_bottle1616"><use xlink:href="#bottle1616"/></svg>代表銘柄</span>';
											innerHTML += '<span class="sakagura_spec_info">';
												if(sakagura[i].brand)
													innerHTML += sakagura[i].brand;
												else
													innerHTML += '<span style="color: #b2b2b2;">--</span>';
											innerHTML += '</span>';
											innerHTML += '</div>';

											/////////////////////////////////////////////////
											innerHTML += '<div class="sakagura_spec_item">';
											innerHTML += '<span class="sakagura_spec_title"><svg class="spec_item_visit1616"><use xlink:href="#visit1616"/></svg>酒蔵見学</span>';
											innerHTML += '<span class="sakagura_spec_info">';
												if(sakagura[i].observation == 1)
													innerHTML += '可';
												else if(sakagura[i].observation == 2)
													innerHTML += '不可';
												else
													innerHTML += '<span style="color: #b2b2b2;">--</span>';
											innerHTML += '</span>';
											innerHTML += '</div>';

											/////////////////////////////////////////////////
											innerHTML += '<div class="sakagura_spec_item">';
											innerHTML += '<span class="sakagura_spec_title"><svg class="spec_item_kurashop1616"><use xlink:href="#kurashop1616"/></svg>酒蔵直販店</span>';
											innerHTML += '<span class="sakagura_spec_info">';

												if(sakagura[i].direct_sale == 1)
													innerHTML += 'あり';
												else if(sakagura[i].direct_sake == 2)
													innerHTML += 'なし';
												else
													innerHTML += '<span style="color: #b2b2b2;">--</span>';

											innerHTML += '</span>';
											innerHTML += '</div>';

											/////////////////////////////////////////////////
											/*innerHTML += '<div class="sakagura_spec_item">';
											innerHTML += '<div class="sakagura_spec_title">酒造組合登録</div>';
											innerHTML += '<div class="sakagura_spec_info">';

											if(sakagura[i].kumiai == 10)
												innerHTML += 'あり';
											else if(sakagura[i].kumiai == 11)
												innerHTML += 'なし';
											else if(sakagura[i].kumiai == 12)
												innerHTML += '不明';
											else
												innerHTML += '--';

											innerHTML += '</div>';
											innerHTML += '</div>';

											/////////////////////////////////////////////////
											innerHTML += '<div class="sakagura_spec_item">';
											innerHTML += '<div class="sakagura_spec_title">国税庁登録</div>';
											innerHTML += '<div class="sakagura_spec_info">';

											if(sakagura[i].kokuzei == 10)
												innerHTML += 'あり';
											else if(sakagura[i].kokuzei == 11)
												innerHTML += 'なし';
											else if(sakagura[i].kokuzei == 12)
												innerHTML += '不明';
											else
												innerHTML += '--';

											innerHTML += '</div>';
											innerHTML += '</div>';

											/////////////////////////////////////////////////
											innerHTML += '<div class="sakagura_spec_item">';
											innerHTML += '<div class="sakagura_spec_title">プライオリティ</div>';
											innerHTML += '<div class="sakagura_spec_info">';

											if(sakagura[i].priority == 1)
												innerHTML += 'S'
											else if(sakagura[i].priority == 2)
												innerHTML += 'A'
											else if(sakagura[i].priority == 3)
												innerHTML += 'B'
											else if(sakagura[i].priority == 4)
												innerHTML += 'C'
											else if(sakagura[i].priority == 5)
												innerHTML += 'D'
											else if(sakagura[i].priority == 6)
												innerHTML += 'E'
											else if(sakagura[i].priority == 7)
												innerHTML += 'X'
											else
												innerHTML += '--'

											innerHTML += '</div>';
											innerHTML += '</div>';

											/////////////////////////////////////////////////
											innerHTML += '<div class="sakagura_spec_item">';
											innerHTML += '<div class="sakagura_spec_title">ステータス</div>';
											innerHTML += '<div class="sakagura_spec_info">';

											if(sakagura[i].status == 10)
												innerHTML += 'active';
											else if(sakagura[i].status == 11)
												innerHTML += 'inactive';
											else if(sakagura[i].status == 12)
												innerHTML += '一時製造休止';
											else if(sakagura[i].status == 13)
												innerHTML += '営業不明';
											else
												innerHTML += '--';

											innerHTML += '</div>';
											innerHTML += '</div>';
											*/

										innerHTML += '</div>'; // sakaguraspec
										innerHTML += '</a>'; // sakaguraRow_link

										$('#search_sakagura_result').append(innerHTML);
								}

								var p_max = 25;
								var limit = (in_disp_to >= $("#hidden_sakagura_count_result").val()) ? $("#hidden_sakagura_count_result").val() : in_disp_to;

								if(count_query == 1)
								{
									if($("#hidden_sakagura_count_result").val() > p_max) {

										var numPage = $('#hidden_sakagura_count_result').val() / p_max;
										numPage = ($('#hidden_sakagura_count_result').val() % p_max) ? (numPage + 1) : numPage;
										numPage = (numPage > 5) ? 5 : numPage;

										//alert("count:" + $('#hidden_sakagura_count_result').val());
										$('#sakagurapage').empty();
										$('#sakagurapage').append('<button id="prev_sakagura" class="search_button" style="margin-right:2px">前の' + p_max + '件</button>');

										for(i = 1; i <= numPage; i++) {
											if(i == 1)
												$('#sakagurapage').append('<button class="search_button pageitems" style="text-align:center; width:26px; background:#22445B; color:#fff; margin-right:2px">1</button>');
											else
												$('#sakagurapage').append('<button class="search_button pageitems" style="text-align:center; width:26px; margin-right:2px">' + i + '</button>');
										}

										$('#sakagurapage').append('<button id="next_sakagura" class="search_button" style="margin-right:2px; visibility:visible">次の' + p_max + '件</button>');
									}
									else {
										$('#sakagurapage').empty();
									}
								}

								//////////////////////////////////////////////////////////////////////////////
								$('#in_disp_sakagura_from').val(in_disp_from);

								var pagenum = $('#in_disp_sakagura_from').val() / p_max;
								var showPos = parseInt($('#sakagurapage .search_button.pageitems:first').text()) - 1;
								var position = pagenum - showPos;

								if(position < 0) {
									$('#sakagurapage .pageitems').each(function() {
										$(this).text(parseInt($(this).text()) - 1);
										$(this).val($(this).val() - 1);
									});

									position = 0;
								}
								else if(position >= $('#sakagurapage .pageitems').length) {
									$('#sakagurapage .pageitems').each(function() {
										$(this).text(parseInt($(this).text()) + 1);
										$(this).val($(this).val() + 1);
									});

									position = $('#sakagurapage .pageitems').length - 1;
								}

								var limit =  (in_disp_to >= $("#hidden_sakagura_count_result").val()) ? $("#hidden_sakagura_count_result").val() : in_disp_to;

								$('#sakagurapage .pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
								$('#sakagurapage .pageitems:nth(' + position + ')').css({"background": "#22445B", "color":"#ffffff"});
								$('#view_sakagura_result').text(parseInt($('#in_disp_sakagura_from').val()) + 1 + '～' + limit);

								$('html, body').animate({scrollTop:0}, 'fast');
						}
						else {
							$("#count_sakagura_result").css({"display":"none"});
							$('#sakagurapage').css({"display":"none"});
							$('#view_sakagura_result').css({"display":"block"});
							$('#view_sakagura_result').text("検索結果がありません。");
						}

						if(parseInt($('#in_disp_sakagura_from').val()) >= 25)
							$('#prev_sakagura').css({"color":"#0740A5", "cursor":"pointer"});
						else
							$('#prev_sakagura').css({"color":"#b2b2b2", "cursor":"default"});

						if((parseInt($('#in_disp_sakagura_from').val()) + 25) < parseInt($("#hidden_sakagura_count_result").val()))
							$('#next_sakagura').css({"color":"#0740A5", "cursor":"pointer"});
						else
							$('#next_sakagura').css({"color":"#b2b2b2", "cursor":"default"});

				}).fail(function(data){
						alert("Failed:" + data);
						removeLoading();
				}).complete(function(data){
						//alert("complete");
						// Loadingイメージを消す
						removeLoading();
				});
		}

	    $("body").on("search_sakagura", function( event, data, in_disp_from, in_disp_to, count_result) {
			 searchSakagura(data, in_disp_from, in_disp_to, count_result);
		});

		$(document).on('click', '#next_sakagura', function(e){

				var p_max = 25;

				if((parseInt($('#in_disp_sakagura_from').val()) + 25) < parseInt($('#hidden_sakagura_count_result').val()))
				{
					var in_disp_from = parseInt($("#in_disp_sakagura_from").val()) + 25;
					var in_disp_to = in_disp_from + p_max;

					var data = sakagura_serialize(in_disp_from, in_disp_to);
					var my_url = "?" + sakagura_serialize(in_disp_from, 0);

					var stateObj = { 'url': my_url,
									'category': $('#category').val(),
									'keyword': $('#sake_input').val(),
									'from': in_disp_from,
									'to': in_disp_to };

					history.pushState(stateObj, "test1", my_url);
					searchSakagura(data, in_disp_from, in_disp_to, 0);
				}
		});

		$(document).on('click', '#prev_sakagura', function(e) {

			if(parseInt($("#in_disp_sakagura_from").val()) >= 25) {

				var p_max = 25;
				var in_disp_to = parseInt($("#in_disp_sakagura_from").val());
				var in_disp_from = in_disp_to - p_max;
				var data = sakagura_serialize(in_disp_from, in_disp_to);
				var my_url = "?" + sakagura_serialize(in_disp_from, 0);
				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#sake_input').val(),
								'from': in_disp_from,
								'to': in_disp_to };

				history.pushState(stateObj, "test1", my_url);
				searchSakagura(data, in_disp_from, in_disp_to, 0);
			}
		});

		$(document).on('click', '#sakagurapage .search_button.pageitems', function(e){

				var p_max = 25;
				var keyword = $('#sake_input').val();
				var position = parseInt($(this).text());
				var in_disp_from = (position - 1) * p_max;
				var in_disp_to = in_disp_from + p_max;
				var data = sakagura_serialize(in_disp_from, in_disp_to);
				var my_url = "?" + sakagura_serialize(in_disp_from, 0);

				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#sake_input').val(),
								'pref': $('select[name="sakagura_pref"]').val(),
								'observation': $('select[name="observation"]').val(),
								'from': in_disp_from,
								'to': in_disp_to };

				history.pushState(stateObj, "test1", my_url);
				searchSakagura(data, in_disp_from, in_disp_to, 0);
		});

		$(document).on('click', '#submit_sakagura_search.sakagura_accordion', function(e){

				$('#category').val(3);
				var in_disp_from = 0;
				var in_disp_to = 25;

				event.preventDefault();

				var data = sakagura_serialize(in_disp_from, in_disp_to) + "&count_query=1";
				var my_url = "?" + sakagura_serialize(in_disp_from, 0);

				var stateObj = { 'url': my_url,
								'category': $('#category').val(),
								'keyword': $('#sake_input').val(),
								'pref': $('select[name="sakagura_pref"]').val(),
								'observation': $('select[name="observation"]').val(),
								'from': in_disp_from,
								'to': in_disp_to };

				history.pushState(stateObj, "test1", my_url);
				searchSakagura(data, in_disp_from, in_disp_to, 1);
		});
});

///////////////////////////////////////////////////////////////////////////////////////////////
// syuhanten mode
///////////////////////////////////////////////////////////////////////////////////////////////
$(function() {

		$('#tab_accordion a[href="#tabs-32"]').click(function() {
				$('#tabs-32').fadeIn(400);
				$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
				$('#tabs-syuhanten').removeClass('hide').addClass('show').show();

				$('#hidden_syuhanten_count_query').val(1);
				$('#in_syuhanten_disp_from').val(0);
				$('#in_syuhanten_disp_to').val(25);
				$('#category').val(4);
				$('#pref_syuhanten').css({"color":"#b2b2b2", "cursor":"default"});
				$('#next_syuhanten').css({"color":"#0740A5"});
				$('.accordion_title').css({"display": "block"});

				var data = $("#syuhanten_sidebar_form").serialize() + "&category=" + $('#category').val();
				var keyword = $('#sake_input').val();

				if(keyword && keyword != null)
					data += "&keyword=" + keyword;

				//alert("data:" + data);

				$("#submit_syuhanten_search").removeClass("sake_accordion sakagura_accordion syuhanten_accordion inshokuten_accordion");
				$('#submit_syuhanten_search').addClass("syuhanten_accordion");
				$('#syuhanten_sidebar_form').css({"display": "block"});

				searchSyuhanten(data);
		});

		$("#syuhanten_sidebar_form ul span, #syuhanten_sidebar_form ul button").click(function() {
				$(this).parent().fadeToggle();
		});

		$('#syuhanten_sidebar_form .syuhanten_option_trigger').click(function(){

				var obj = this;

				$('.syuhanten_option_trigger').each(function(){
					if(this != obj)
					{
							$(this).next(".dialog_sidebar").css({"display":"none"});
							$(this).removeClass('active');
							$(this).find('span:nth-child(2)').html('&#x25BC')
					}
				});

				$(this).next("div").slideToggle();
		});

		$("#syuhanten_sidebar_form ul span, #sake_sidebar_form ul button").click(function() {
				$(this).parent().fadeToggle();
		});

		$('#next_syuhanten').click(function(){

				$('#hidden_syuhanten_count_query').val(0);

				if(parseInt($('#in_syuhanten_disp_to').val()) < parseInt($('#hidden_syuhanten_count_result').val()))
				{
						var limit = ((parseInt($('#in_syuhanten_disp_to').val()) + 25) >= $("#hidden_syuhanten_count_result").val()) ? $("#hidden_syuhanten_count_result").val() : (parseInt($('#in_syuhanten_disp_to').val()) + 25);
						$('#in_syuhanten_disp_from').val(parseInt($("#in_syuhanten_disp_from").val()) + 25);
						$('#in_syuhanten_disp_to').val(parseInt($("#in_syuhanten_disp_to").val()) + 25);
						var data = $("#syuhanten_sidebar_form").serialize() + '&' + $("#hidden_form").serialize();

						//alert("data:" + data);
						searchSyuhanten(data);
						$('#view_syuhanten_result').text($('#in_syuhanten_disp_from').val() + '～' + limit);
						$('#prev_syuhanten').css({"color":"#0740A5"});
				}
		});

		$('#prev_syuhanten').click(function(){

				$('#hidden_syuhanten_count_query').val(0);

				if(parseInt($("#in_syuhanten_disp_from").val()) >= 25)
				{
					$('#in_syuhanten_disp_to').val(parseInt($("#in_syuhanten_disp_from").val()));
					$('#in_syuhanten_disp_from').val(parseInt($("#in_syuhanten_disp_from").val()) - 25);
					var data = $("#syuhanten_sidebar_form").serialize() + '&' + $("#hidden_form").serialize();

					searchSyuhanten(data);
					//$('#view_syuhanten_result').text($('#in_syuhanten_disp_from').val() + '～' + $('#in_syuhanten_disp_to').val());
				}
		});

		$(document).on('click', '#submit_sake_search.syuhanten_accordion', function(e){

				$('#category').val(4);
				$('#hidden_syuhanten_count_query').val(1);
				$('#in_syuhanten_disp_from').val(0);
				$('#in_syuhanten_disp_to').val(25);
				$('#search_syuhanten_result').empty();

				var data = $("#syuhanten_sidebar_form").serialize() + '&' + $("#hidden_form").serialize();
				event.preventDefault();

				searchSyuhanten(data);
				$('#prev_syuhanten').css({"color":"#b2b2b2", "cursor":"default"});
		});

		function searchSyuhanten(data)
		{
				dispLoading("処理中...");
				//alert("searchsyuhanten:" + data);

				$.ajax({
						type: "POST",
						url: "complex_search.php",
						data: data,
						dataType: 'json',

				}).done(function(data){

						var innerHTML = "";
						var i = 0;
						var sake = data[0].result;

						//alert("searchSyuhanten:success data:" + data[0].result);

						$('#search_syuhanten_result').empty();

						if(data != null)
						{
								var j = 0;
								var alcohol_array = 0;
								var syudo_array = 0;

								if($('#hidden_syuhanten_count_query').val() == "1")
								{
									$('#count_syuhanten_result').text("件 / 全" + data[0].count + "件");
									$('#hidden_syuhanten_count_result').val(data[0].count);
								}

								for(i = 0; i < sake.length; i++)
								{
									innerHTML = '<div class="syuhantenRow" sake_id=' + sake[i].sake_id + '>' +
													'<div style="text-align:center"><img style="vertical-align:middle; margin:18px auto; text-align:center; width:32px; height:32px" src="' + sake[i].filename + '"></div>' +
													'<div>' +
														'<button class="custom_button" sake_id=' + sake[i].sake_id + '><span class="button-icon"><img src="images/icons/heart.svg"></span><span class="button-text">コメント・写真</span></button>' +
														'<button class="custom_button" sake_id=' + sake[i].sake_id + '><span class="button-icon"><img src="images/icons/pin.svg"></span><span class="button-text">お気に入り酒販店</span></button>' +
													'</div>' +
													'<div>' + sake[i].sake_name + '<input type="hidden" value=' + sake[i].sake_id + '></div>' +
													'<div style="font-size:12px">' + sake[i].syuhanten_pref + '  ' + sake[i].syuhanten_address + '</div>' +
													'<div style="font-size:11px"><span style="margin-right:4px">コメント 0件</span><span style="margin-left:4px">取扱い日本酒　１１～２０種類</span></div>' +
													'<div>' +
														'<span class="label" style="text-align:center; width:148px">プレミア銘柄・人気銘柄あり</span>' +
														'<span class="label" style="text-align:center; width:98px">一杯５００円以下</span>' +
														'<span class="label" style="text-align:center; width:98px">日本酒にこだわる</span>' +
													'</div>' +
												'</div>';

									$('#search_syuhanten_result').append(innerHTML);
								}

								var limit = (parseInt($('#in_syuhanten_disp_to').val()) >= $("#hidden_syuhanten_count_result").val()) ? $("#hidden_syuhanten_count_result").val() : parseInt($('#in_syuhanten_disp_to').val());
								$('#in_syuhanten_disp_to').val(limit);
								$('#view_syuhanten_result').text($('#in_syuhanten_disp_from').val() + '～' + limit);
						}

				}).fail(function(data){
					alert("Failed:" + data);
				}).complete(function(data){
					// Loadingイメージを消す
					removeLoading();
				});
		}

		$('#tabs-syuhanten .click_sort div').click(function() {
				var index = $('#click_sort div').index(this);

				if(index == 0)
				{
				}
				else
				{
					$("#tabs-syuhanten .click_sort div").css({"background": "#b2b2b2", "color": "#ffffff"});
					$(this).css({"background": "#3f3f3f", "color": "#ffffff"});
				}
		});
});

jQuery(document).ready(function($) {

		$("body").wrapInner('<div id="wrapper"></div>');

		$('#tab_accordion').createTabs({
				text : $('#tab_accordion ul')
		});

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		if($('#category').val() == "1")
		{
			var curr = $('.simpleTabs').find(".active");
			var next = $('.simpleTabs').find('a[href="#tabs-29"]');

			curr.removeClass('active');
			next.addClass('active');

			$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
			$('#tabs-29').removeClass('hide').addClass('show').show();
			$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
			$('#tabs-all').removeClass('hide').addClass('show').show();

			////////////////////////////////////////////////////////////////////////
			// prev, next grey
			if($('#in_disp_all_from').val() >= 25) {
			    $('#prev_all').css({"color":"#0740A5", "cursor":"pointer"});
			}
			else {
				$('#prev_all').css({"color":"#b2b2b2", "cursor":"default"});
			}

			if((parseInt($('#in_disp_all_from').val()) + 25) < $("#hidden_all_count_query").val()) {
				$('#next_all').css({"color":"#0740A5", "cursor":"pointer"});
			}
			else {
				$('#next_all').css({"color":"#b2b2b2", "cursor":"default"});
			}

			$('.accordion_title').css({"display": "block"});
		}
		else if($('#category').val() == "2")
		{
			// prefecture
			if($('#container').data('pref') != "") {

				$('#tabs-30_content select[name="pref"] option').each(function() {

					if(this.value == $('#container').data('pref')) {
						 $('#tabs-30_content select[name="pref"]').val($('#container').data('pref'));
						 return false;
					}
				});
			}

			// special name
			if($('#container').data('special_name') != "") {
				$('select[name="special_name"] option').each(function() {

					if(this.value == $('#container').data('special_name')) {
						 $('select[name="special_name"]').val($('#container').data('special_name'));
						 return false;
					}
				});
			}

			// rice_used
			if($('#container').data('rice_used') != "") {
				$('select[name="rice_used"] option').each(function() {

					if(this.value == $('#container').data('rice_used')) {
						 $('select[name="rice_used"]').val($('#container').data('rice_used'));
						 return false;
					}
				});
			}

			// seimai_rate
			if($('#container').data('seimai_rate') != "") {
				$('select[name="seimai_rate"] option').each(function() {

					if(this.value == $('#container').data('seimai_rate')) {
						 $('select[name="seimai_rate"]').val($('#container').data('seimai_rate'));
						 return false;
					}
				});
			}

			// sake_category
			if($('#container').data('sake_category') != null && $('#container').data('sake_category') != undefined) {

				var sake_category = $('#container').data('sake_category').split(',');

				$('#sake_sidebar_form .dialog_sidebar:nth(0) ul li').each(function() {

					var inputObj = $(this).find("input");

					for(var i = 0; i < sake_category.length; i++) {
						if($(inputObj).val() == sake_category[i]) {
							$(inputObj).prop('checked', true);
						}
					}
				});
			}

			$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
			$('#tabs-sake').removeClass('hide').addClass('show').show();
			$("#submit_sake_search").removeClass("sake_accordion sakagura_accordion syuhanten_accordion inshokuten_accordion");
			$('#submit_sake_search').addClass("sake_accordion");
			$('#sake_sidebar_form').css({"display": "block"});

			//////////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////////
			var curr = $('.simpleTabs').find(".active");
			var next = $('.simpleTabs').find('a[href="#tabs-30"]');

			curr.removeClass('active');
			next.addClass('active');

			$('#tabs-30').removeClass('hide').addClass('show').show();

			if($('.mobilesake_container').css('display') == 'none') {
				$('#tabs-30_content').css('display', 'block');
			}

			if($('#container').data('from') > 25) {
				$('#prev_sake').css({"color":"#0740A5", "cursor":"default"});
			}

			$('#next_sake').css({"color":"#0740A5"});
			$('.accordion_title').css({"display": "block"});
		}
		else if($('#category').val() == "3")
		{
			// prefecture
			if($('#container').data('pref') != "") {

				$('select[name="sakagura_pref"] option').each(function() {

					if(this.value == $('#container').data('pref')) {
						 $('select[name="sakagura_pref"]').val($('#container').data('pref'));
						 return;
					}
				});
			}

			var observation = <?php echo json_encode($_GET['observation']); ?>;

			if(observation != "" && observation != undefined)
				$('#sakagura_sidebar_form input[name="observation"]').data('checked', observation);

			$('#submit_sakagura_search').addClass("sakagura_accordion");
			$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
			$('#tabs-sakagura').removeClass('hide').addClass('show').show();
			$('#sakagura_sidebar_form').css({"display": "block"});

			$('.simpleTabs li a:nth(1)').addClass("active");
			$('#tab_accordion').find('.show').removeClass('show').addClass('hide').hide();
			$('#tabs-31').removeClass('hide').addClass('show').show();

			////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////
			var curr = $('.simpleTabs').find(".active");
			var next = $('.simpleTabs').find('a[href="#tabs-31"]');

			curr.removeClass('active');
			next.addClass('active');

			$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
			$('#tabs-31').removeClass('hide').addClass('show').show();

			$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
			$('#tabs-sakagura').removeClass('hide').addClass('show').show();

			////////////////////////////////////////////////////////////////////////////////////////////////
			if(parseInt($('#in_disp_sakagura_from').val()) >= 25)
				$('#prev_sakagura').css({"color":"#0740A5", "cursor":"pointer"});
			else
				$('#prev_sakagura').css({"color":"#b2b2b2", "cursor":"default"});

			if((parseInt($('#in_disp_sakagura_from').val()) + 25) < parseInt($("#hidden_sakagura_count_result").val()))
				$('#next_sakagura').css({"color":"#0740A5", "cursor":"pointer"});
			else
				$('#next_sakagura').css({"color":"#b2b2b2", "cursor":"default"});
			////////////////////////////////////////////////////////////////////////////////////////////////

			$('#prev_sakagura').css({"visibility":"visible"});
			$('#next_sakagura').css({"visibility":"visible"});
			$('.accordion_title').css({"display": "block"});

			$("#submit_sakagura_search").removeClass("sake_accordion sakagura_accordion syuhanten_accordion inshokuten_accordion");
			$('#submit_sakagura_search').addClass("sakagura_accordion");
			$('#sakagura_sidebar_form').css({"display": "block"});
		}
		else if($('#category').val() == "4")
		{
			var syuhanten_pref = <?php echo json_encode($_GET['syuhanten_pref']); ?>;

			if(syuhanten_pref != "" && syuhanten_pref != undefined)
			{
				$('#syuhanten_sidebar_form .dialog_sidebar:nth(0)').find('ul li').each(function() {

					  var inputObj = $(this).find("input");

					  for(var i = 0; i < syuhanten_pref.length; i++)
					  {
						  if($(inputObj).val() == syuhanten_pref[i])
						  {
							  $(inputObj).prop('checked', true);
						  }
					  }
			    });

			  $('span[name="syuhanten_pref"]').text(syuhanten_pref);
		    }

			$('#submit_sake_search').addClass("syuhanten_accordion");
			$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
			$('#tabs-syuhanten').removeClass('hide').addClass('show').show();
			$('#syuhanten_sidebar_form').css({"display": "block"});

			$('.simpleTabs li a:nth(2)').addClass("active");
			$('#tab_accordion').find('.show').removeClass('show').addClass('hide').hide();
			$('#tabs-32').removeClass('hide').addClass('show').show();
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		var hash = window.location.hash;

		if(hash && hash != "") {
			var curr = $('#tab_main .simpleTabs').find(".active");
			var prev = $('#tab_main .simpleTabs').find('a[href="' + hash +'"]');

			$(hash).removeClass('hide').addClass('show').show();
		}
		else {

			//var href = window.location.href;
			var href = "sake_library_search.php";

			var stateObj = {
				url: href,
				category: $('#container').data('category'),
				keyword: $('#sake_input').val(),
				from: $('#container').data('from'),
				to: $('#container').data('from') + 25,
			};

			//history.replaceState(stateObj, "test1", "");
			history.pushState(stateObj, "test1", "");
		}

        //$('#category_menu_trigger').addClass('active');
        $('#category_menu_trigger span:first-child').text($('#search_content .menu li:nth(' + ($('#container').data('category') - 1) + ')').attr("value"));

		$(window).on('popstate', function(event) {

				var state = event.originalEvent.state;
				var keyword = (state.keyword != undefined) ? keyword : "";

				//alert("category:" + state.category + " popstate1b:" + category + " pop state:" + state.url + " from:" + state.from + " to:" + state.to);

				if(state.category == 1) {

					var data = "category=" + state.category;
					var pagenum = state.from / 25;

					if(state.keyword != "" && state.keyword != undefined)
						data += "&keyword=" + state.keyword;

					data += "&from=" + state.from + "&to=" + state.to + "&count_query=1";

					$('.accordion_title').css({"display": "block"});
					$('#tabs-30_content').css('display', 'none');

					$('#tab_accordion ul').find(".active").removeClass('active');
					$('#tab_accordion ul a:nth(0)').addClass('active');

					$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
					$('#tab_accordion').find('.show').removeClass('show').addClass('hide').hide();
					$('#tabs-all').removeClass('hide').addClass('show').show();
					$('#tabs-29').removeClass('hide').addClass('show').show();
					$('#tabs-29').fadeIn(400);

					$('#category').val(state.category);

					$('#allpage .pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
					$('#allpage .pageitems:nth(' + pagenum + ')').css({"background": "#22445B", "color":"#ffffff"});
					$('#category_menu_trigger span:first-child').text($('#search_content .menu li:nth(0)').attr("value"));

					$("body").trigger("search_all", [ data, state.from, state.to, 1]);
				}
				else if(state.category == 2) {

					var count_result = 1;
					var category = 1;
					var pagenum = state.from / 25;
					var data = "category=" + state.category;

					if(state.keyword && state.keyword != undefined)
						data += "&keyword=" + state.keyword;

					if(state.pref && state.pref != undefined)
						data += "&pref=" + state.pref;

					if(state.special_name && state.special_name != undefined)
						data += "&special_name=" + state.special_name;

					if(state.rice_used && state.rice_used != undefined)
						data += "&rice_used=" + state.rice_used;

					data += "&from=" + state.from + "&to=" + state.to + "&count_query=1";

					if(state.pref && state.pref != undefined)
						 $('#sake_sidebar_form select[name="pref"]').val(state.pref);

					if(state.special_name && state.special_name != undefined)
						 $('#sake_sidebar_form select[name="special_name"]').val(state.special_name);

					if(state.rice_used && state.rice_used != undefined)
						 $('#sake_sidebar_form select[name="rice_used"]').val(state.rice_used);

					$('#tab_accordion ul').find(".active").removeClass('active');
					$('#tab_accordion ul a:nth(1)').addClass('active');

					$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
					$('#tabs-sake').removeClass('hide').addClass('show').show();
					$('#tab_accordion').find('.show').removeClass('show').addClass('hide').hide();
					$('#tabs-30').removeClass('hide').addClass('show').show();
					$('#tabs-30').fadeIn(400);

					$('#category').val(state.category);
					$('#category_menu_trigger span:first-child').text($('#search_content .menu li:nth(1)').attr("value"));
					$('#sakepage .pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
					$('#sakepage .pageitems:nth(' + pagenum + ')').css({"background": "#22445B", "color":"#ffffff"});

					$("body").trigger("search_sake", [ data, state.from, state.to, 1 ]);
				}
				else if(state.category == 3) {

					var count_result = 1;
					var category = 3;
					var pagenum = state.from / 25;
					var data = "category=" + state.category;

					if(state.keyword && state.keyword != undefined)
						data += "&keyword=" + state.keyword;

					if(state.pref && state.pref != undefined)
						data += "&pref=" + state.pref;

					if(state.observation && state.observation != undefined)
						data += "&observation=" + state.observation;

					data += "&from=" + state.from + "&to=" + state.to + "&count_query=1";

					if(state.pref && state.pref != undefined)
						$('#sakagura_sidebar_form select[name="sakagura_pref"]').val(state.pref);

					$('#tab_accordion ul').find(".active").removeClass('active');
					$('#tab_accordion ul a:nth(2)').addClass('active');

					$('#category').val(3);
					$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
					$('#tabs-sakagura').removeClass('hide').addClass('show').show();
					$('#tabs-31').removeClass('hide').addClass('show').show();
					$('#tabs-31').fadeIn(400);

					$('#category').val(state.category);
					$('#category_menu_trigger span:first-child').text($('#search_content .menu li:nth(2)').attr("value"));
					$('#sakagurapage .pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
					$('#sakagurapage .pageitems:nth(' + pagenum + ')').css({"background": "#22445B", "color":"#ffffff"});

					$("body").trigger("search_sakagura", [ data, state.from, state.to, 1 ]);
				}
		});
});

</script>
</body>
</html>
