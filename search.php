<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
//require_once("nonda.php");
//require_once("searchbar.php");
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
	<!--<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />-->
	<link rel="stylesheet" type="text/css" href="css/search.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<!--<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>-->
	<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
</head>

<body>

<?php
include_once('images/icons/svg_sprite.svg');
//write_side_menu();
write_HamburgerLogo();
//write_search_bar();
//write_Nonda();

function GetSakeSpecialName($sake_code)
{
	if($sake_code == "11")
	{
		$retval = "普通酒";
		return $retval;
	}
	else if($sake_code == "21")
	{
		$retval = "本醸造酒";
		return $retval;
	}
	else if($sake_code == "22")
	{
		$retval = "特別本醸造酒";
		return $retval;
	}
	else if($sake_code == "31")
	{
		$retval = "純米酒";
		return $retval;
	}
	else if($sake_code == "32")
	{
		$retval = "特別純米酒";
		return $retval;
	}
	else if($sake_code == "33")
	{
		$retval = "純米吟醸酒";
		return $retval;
	}
	else if($sake_code == "34")
	{
		$retval = "純米大吟醸酒";
		return $retval;
	}
	else if($sake_code == "43")
	{
		$retval = "吟醸酒";
		return $retval;
	}
	else if($sake_code == "44")
	{
		$retval = "大吟醸酒";
		return $retval;
	}
	else if($sake_code == "90")
	{
		$retval = "その他";
		return $retval;
	}
	else if($sake_code == "99")
	{
		$retval = "";
		return $retval;
	}
	else
	{
		$retval = "";
		return $retval;
	}
}

function GetSakeCategory($category_code)
{
	if($category_code == "11")
	{
		$retval = "無ろ過";
		return $retval;
	}
	else if($category_code == "21")
	{
		$retval = "にごり酒";
		return $retval;
	}
	else if($category_code == "22")
	{
		$retval = "あらばしり";
		return $retval;
	}
	else if($category_code == "31")
	{
		$retval = "中取り/中垂/中汲み";
		return $retval;
	}
	else if($category_code == "32")
	{
		$retval = "責め・押切";
		return $retval;
	}
	else if($category_code == "33")
	{
		$retval = "生酒・本生";
		return $retval;
	}
	else if($category_code == "34")
	{
		$retval = "生詰酒";
		return $retval;
	}
	else if($category_code == "35")
	{
		$retval = "生貯蔵酒";
		return $retval;
	}
	else if($category_code == "36")
	{
		$retval = "火入れ";
		return $retval;
	}
	else if($category_code == "37")
	{
		$retval = "ひやおろし・秋上がり";
		return $retval;
	}
	else if($category_code == "38")
	{
		$retval = "しずく酒・しずくしぼり・袋吊り・袋しぼり・斗瓶取り・斗瓶囲い";
		return $retval;
	}
	else if($category_code == "39")
	{
		$retval = "直汲み・直詰め";
		return $retval;
	}
	else if($category_code == "40")
	{
		$retval = "遠心分離";
		return $retval;
	}
	else if($category_code == "41")
	{
		$retval = "槽しぼり";
		return $retval;
	}
	else if($category_code == "42")
	{
		$retval = "きもと";
		return $retval;
	}
	else if($category_code == "43")
	{
		$retval = "山廃もと";
		return $retval;
	}
	else if($category_code == "44")
	{
		$retval = "樽酒";
		return $retval;
	}
	else if($category_code == "45")
	{
		$retval = "原酒";
		return $retval;
	}
	else if($category_code == "46")
	{
		$retval = "生一本";
		return $retval;
	}
	else if($category_code == "47")
	{
		$retval = "斗瓶取り・斗瓶囲い";
		return $retval;
	}
	else if($category_code == "48")
	{
		$retval = "古酒・長期貯蔵酒";
		return $retval;
	}
	else if($category_code == "49")
	{
		$retval = "おり酒・おりがらみ・うすにごり・ささにごり";
		return $retval;
	}
	else if($category_code == "50")
	{
		$retval = "新酒・初しぼり・しぼりたて";
		return $retval;
	}
	else if($category_code == "51")
	{
		$retval = "スパークリング";
		return $retval;
	}
	else if($category_code == "90")
	{
		$retval = "その他";
		return $retval;
	}
	else
	{
		$retval = "";
		return $retval;
	}
}
?>

<div id="container">
	<?php
	$search_category = $_POST["search_type"];
	$keyword = $_POST["keyword"];
	$pref = "";
	?>

	<form id="hidden_form" name="hidden_form" method="post">
		<?php print('<input type="hidden" id="search_category" name="search_category" value=' .$search_category .'>'); ?>
		<?php print('<input type="hidden" id="keyword" name="keyword" value=' .$keyword .'>'); ?>
		<?php print('<input type="hidden" id="hidden_sort" name="orderby" value="">'); ?>
		<?php print('<input type="hidden" id="hidden_desc" name="desc" value="DESC">'); ?>
	</form>

	<div id="search_main_container">

		<div id="accordion">
			<div id="accordion_frame">
				<svg class="close_icon_prev2020"><use xlink:href="#prev2020"/></svg>
				<div id="tab_accordion">
					<ul class="simpleTabs">
						<li><a href="#tabs-30" class="active"><svg class="mobile_accordion_sake3630"><use xlink:href="#sake3630"/></svg><p>日本酒<span>を探す</span></p></a></li>
						<li><a href="#tabs-31"><svg class="mobile_accordion_brewery3630"><use xlink:href="#brewery3630"/></svg><p>酒蔵<span>を探す</span></p></a></li>
						<!--<li><a href="#tabs-32"><svg class="mobile_accordion_store3030"><use xlink:href="#store3030"/></svg><p>酒販店<span>を探す</span></p></a></li>-->
						<li><a href="#tabs-33"><svg class="mobile_accordion_restaurant3630"><use xlink:href="#restaurant3630"/></svg><p>飲食店<span>を探す</span></p></a></li>
					</ul>

					<div id="tabs-30" class="form-action show">
						<div id="tabs-30_content">
							<!--<div class="accordion_tabs_title"><div></div><p>日本酒<span>の絞り込み</span></p></div>-->
							<form id="sake_sidebar_form" name="sake_sidebar_form" method="post">

								<!-- hidden data -->
								<input type="hidden" id="in_sake_disp_from" name="in_disp_from" value=0>
								<input type="hidden" id="in_sake_disp_to"   name="in_disp_to"	 value=25>
								<input type="hidden" id="hidden_sake_count_query" name="count_query" value=0>
								<!-- end hidden data -->

								<div class="search_window_container">
									<div class="search_window">
										<div class="search_window_icon">
											<svg class="search_window_sake3630"><use xlink:href="#sake3630"/></svg>
										</div>
										<input type="text" name="sake_name" placeholder="日本酒名を入力">
									</div>
								</div>

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
								</div>

								<div class="sake_option">
									<div class="search_option_row_container"><svg class="search_option_icon_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg><p class="search_option_row_title">精米歩合</p></div>
									<SELECT read="" name="seimai_rate">
									  <OPTION VALUE="">指定なし</OPTION>
									  <OPTION VALUE="">20%未満</OPTION>
									  <OPTION VALUE="">20%以上30%未満</OPTION>
									  <OPTION VALUE="">30%以上40%未満</OPTION>
									  <OPTION VALUE="">40%以上50%未満</OPTION>
									  <OPTION VALUE="">50%以上60%未満</OPTION>
									  <OPTION VALUE="">60%以上70%未満</OPTION>
									  <OPTION VALUE="">70%以上</OPTION>
									</SELECT>
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
									</SELECT>

									<span class="sake_option_trigger">
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
									</div>
								</div>-->

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
									</SELECT>

									<span class="sake_option_trigger">
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
									</div>
								</div>-->

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
										<span>ユーザー満足度</span>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<li><input type="checkbox" name="sake_rank[]" value="1">1</li>
											<li><input type="checkbox" name="sake_rank[]" value="2">2</li>
											<li><input type="checkbox" name="sake_rank[]" value="3">3</li>
											<li><input type="checkbox" name="sake_rank[]" value="4">4</li>
											<li><input type="checkbox" name="sake_rank[]" value="5">5</li>
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

							</form>

							<div class="mobile_accordion_button_container">
								<button id="mobile_accordion_search_clear">クリア</button>
								<button id="submit_sake_search">検索</button>
							</div>
						</div>
					</div>

					<div id="tabs-31" class="form-action hide">
						<div id="tabs-31_content">
							<form id="sakagura_sidebar_form" name="sakagura_sidebar_form" method="post">

								<!-- hidden data -->
								<input type="hidden" id="in_sakagura_disp_from" name="in_disp_from" value=0>
								<input type="hidden" id="in_sakagura_disp_to"   name="in_disp_to"	 value=25>
								<input type="hidden" id="hidden_sakagura_count_query"  name="count_query" value=0>
								<!-- end hidden data -->

								<div class="search_window_container">
									<div class="search_window">
										<div class="search_window_icon">
											<svg class="search_window_brewery3630"><use xlink:href="#brewery3630"/></svg>
										</div>
										<input type="text" name="sake_name" placeholder="酒蔵名を入力">
									</div>
								</div>

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
								</div>

								<div class="sakagura_option">
									<div class="search_option_row_container"><svg class="search_option_icon_visit1216"><use xlink:href="#visit1216"/></svg><p class="search_option_row_title">酒蔵見学</p></div>
									<SELECT read="" name="observation">
									  <OPTION VALUE="" read="">指定なし</OPTION>
									  <OPTION VALUE="1">可</OPTION>
									</SELECT>

									<!--<span class="sakagura_option_trigger">
										<span>酒蔵見学</span>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<label><span><input id="observation" type="checkbox" name="observation" value = "1">可</span></label>
									</div>-->
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
						</div> <!-- tab -->
					</div>

					<!--<div id="tabs-32_content" style="overflow:auto; padding:4px 2px 4px 2px; border:0px solid #c6c6c6" class="form-action hide">
						<div class="accordion_tabs_title"><div></div><p>酒販店<span>の絞り込み</span></p></div>
						<div style="overflow:auto; max-height:380px">
				  		<div class="accordion_title" value="syuhanten_accordion">
								<img style="vertical-align:middle; margin:2px; height:20px" src="images/icons/syuhanten.svg"><span style="margin-left:4px">酒販店の絞り込み<span><img style="float:right; width:20px; vertical-align:middle; margin:2px" src="images/icons/expand.svg">
							</div>
							<form id="syuhanten_sidebar_form" name="syuhanten_sidebar_form" method="post">

								<input type="hidden" id="in_syuhanten_disp_from"	name="in_disp_from" value=0>
								<input type="hidden" id="in_syuhanten_disp_to"		name="in_disp_to"	 value=25>
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

					<div id="tabs-33" class="form-action hide">
						<div id="tabs-33_content" class="form-action hide">
							<form id="inshokuten_sidebar_form" name="inshokuten_sidebar_form" method="post">
								<div class="search_window_container">
									<div class="search_window">
										<div class="search_window_icon">
											<svg class="search_window_map1216"><use xlink:href="#map1216"/></svg>
										</div>
										<input type="text" name="" placeholder="駅名を入力">
									</div>
								</div>
								<div class="search_window_container">
									<div class="search_window">
										<div class="search_window_icon">
											<svg class="search_window_sake3630"><use xlink:href="#sake3630"/></svg>
										</div>
										<input type="text" name="" placeholder="日本酒名を入力">
									</div>
								</div>

								<div class="inshokuten_option">
									<div class="search_option_row_container"><svg class="search_option_icon_genre1616"><use xlink:href="#genre1616"/></svg><p class="search_option_row_title">ジャンル</p></div>
									<SELECT name="genre">
										<OPTION VALUE="">指定なし</OPTION>
										<OPTION VALUE="izakaya">居酒屋</OPTION>
										<OPTION VALUE="restaurant">レストラン</OPTION>
										<OPTION VALUE="bistro">ビストロ</OPTION>
										<OPTION VALUE="bar">バー・バル</OPTION>
										<OPTION VALUE="standingbar">立ち飲み</OPTION>
										<OPTION VALUE="kakuuchi">角打ち</OPTION>
										<OPTION VALUE="seafood">魚介・海鮮料理</OPTION>
										<OPTION VALUE="sushi">寿司</OPTION>
										<OPTION VALUE="kaiseki">懐石料理</OPTION>
										<OPTION VALUE="kappo">割烹・小料理</OPTION>
										<OPTION VALUE="soba">そば</OPTION>
										<OPTION VALUE="udon">うどん</OPTION>
										<OPTION VALUE="noodle">麺料理</OPTION>
										<OPTION VALUE="nabe">鍋料理・すき焼き・しゃぶしゃぶ</OPTION>
										<OPTION VALUE="eel">うなぎ</OPTION>
										<OPTION VALUE="oden">おでん</OPTION>
										<OPTION VALUE="bowl">丼もの</OPTION>
										<OPTION VALUE="okonomiyaki">お好み焼き・もんじゃ焼き</OPTION>
										<OPTION VALUE="yakitori">焼き鳥・串料理</OPTION>
										<OPTION VALUE="barbecue">焼肉</OPTION>
										<OPTION VALUE="steak">鉄板焼き・ステーキ</OPTION>
										<OPTION VALUE="meat">肉料理</OPTION>
										<OPTION VALUE="french">フレンチ</OPTION>
										<OPTION VALUE="italian">イタリアン</OPTION>
										<OPTION VALUE="chinese">中華料理</OPTION>
										<OPTION VALUE="bringin">料理持ち込み</OPTION>
										<OPTION VALUE="others">その他</OPTION>
									</SELECT>
								</div>

								<div class="inshokuten_option">
									<div class="search_option_row_container"><svg class="search_option_icon_bottle1616"><use xlink:href="#bottle1616"/></svg><p class="search_option_row_title">日本酒種類</p></div>
									<SELECT name="pref">
										<OPTION VALUE="">指定なし</OPTION>
										<OPTION VALUE="">～10種類</OPTION>
										<OPTION VALUE="">11～20種類</OPTION>
										<OPTION VALUE="">21～30種類</OPTION>
										<OPTION VALUE="">31～40種類</OPTION>
										<OPTION VALUE="">41～50種類</OPTION>
										<OPTION VALUE="">51～70種類</OPTION>
										<OPTION VALUE="">71～100種類</OPTION>
										<OPTION VALUE="">101種類～</OPTION>
									</SELECT>
								</div>

								<div class="inshokuten_option_service">
									<span class="inshokuten_option_trigger">
										<div class="search_option_row_container">
											<svg class="search_option_icon_tokkuri1616"><use xlink:href="#tokkuri1616"/></svg>
											<p class="search_option_row_title">サービス</p>
										</div>
										<div class="search_option_row_text">選択する</div>
										<p class="arrow_icon"><span></span></p>
									</span>
									<div class="dialog_sidebar">
										<ul>
											<label><li><input type="checkbox" name="" value="">日本酒中心のドリンクメニュー</li></label>
											<label><li><input type="checkbox" name="" value="">プレミア銘柄・人気銘柄の日本酒を飲める</li></label>
											<label><li><input type="checkbox" name="" value="">1杯500円以下で日本酒を飲める</li></label>
											<label><li><input type="checkbox" name="" value="">日本酒飲み放題あり</li></label>
											<label><li><input type="checkbox" name="" value="">日本酒セルフ式</li></label>
										</ul>
									</div>
								</div>

								<div class="inshokuten_option">
									<div class="search_option_row_container"><svg class="search_option_icon_budget1616"><use xlink:href="#budget1616"/></svg><p class="search_option_row_title">予算</p></div>
									<div class="search_option_select_container">
										<div class="search_option_select_text">
											<SELECT name="">
												<OPTION VALUE="">下限</OPTION>
												<OPTION VALUE="">￥1,000</OPTION>
												<OPTION VALUE="">￥2,000</OPTION>
												<OPTION VALUE="">￥3,000</OPTION>
												<OPTION VALUE="">￥4,000</OPTION>
												<OPTION VALUE="">￥5,000</OPTION>
												<OPTION VALUE="">￥6,000</OPTION>
												<OPTION VALUE="">￥8,000</OPTION>
												<OPTION VALUE="">￥10,000</OPTION>
												<OPTION VALUE="">￥15,000</OPTION>
												<OPTION VALUE="">￥20,000</OPTION>
												<OPTION VALUE="">￥30,000</OPTION>
											</SELECT>
											<p>から</p>
										</div>
										<div class="search_option_select_text">
											<SELECT name="">
												<OPTION VALUE="">上限</OPTION>
												<OPTION VALUE="">￥1,000</OPTION>
												<OPTION VALUE="">￥2,000</OPTION>
												<OPTION VALUE="">￥3,000</OPTION>
												<OPTION VALUE="">￥4,000</OPTION>
												<OPTION VALUE="">￥5,000</OPTION>
												<OPTION VALUE="">￥6,000</OPTION>
												<OPTION VALUE="">￥8,000</OPTION>
												<OPTION VALUE="">￥10,000</OPTION>
												<OPTION VALUE="">￥15,000</OPTION>
												<OPTION VALUE="">￥20,000</OPTION>
												<OPTION VALUE="">￥30,000</OPTION>
											</SELECT>
											<p>まで</p>
										</div>
									</div>
								</div>
							</form>

							<div class="mobile_accordion_button_container">
								<button id="mobile_accordion_search_clear">クリア</button>
								<button id="submit_inshokuten_search">検索</button>
							</div>
						</div>
					</div>

				</div> <!--tab_accordion-->
			</div> <!-- accordion_frame -->
		</div> <!-- accordion -->

	</div>
</div>

<div class="dialog_sake_search_background">
	<div class="dialog_table">
		<div class="dialog_table-cell">
			<div id="dialog_sake_search">
				<span class="close_sake_search">
					<button class="close_sake_search_button"><svg class="close_sake_search_prev2020"><use xlink:href="#prev2020"/></svg></button>
				</span>

				<!--<div class="add_sakagura_title">酒蔵 選択</div>
				<div class="add_sakagura_note">
					以下のフォームに酒蔵名を入力し、登録・編集したい日本酒の酒蔵を選択して「決定する」を押してください。
				</div>-->

				<div class="sake_search_form_container">
					<div class="sake_search_form">
						<input id="sake_input" class="sake_search_input" autocomplete="off" placeholder="日本酒名を入力してください" type="text" name="sake_search_name">
					</div>
					<ul id="sake_search_content"></ul>
				</div>

				<!--<div class="add_sakagura_button_container">
					<input type="button" name="add_sakagura_ok" value="決定する">
				</div>-->
			</div>
		</div>
	</div>
</div>

<?php writefooter(); ?>

<script type="text/javascript">

$(function() {
	$('.close_icon_prev2020').click(function(){
		window.history.back();
	});

	$('#tab_accordion').createTabs({
			text : $('#tab_accordion ul')
	});

	///////////////////////////////////////////////////////////////////////////////////////////////
	// sake mode
	///////////////////////////////////////////////////////////////////////////////////////////////

	// 酒編集ページ酒蔵の選択モーダルウィンドウ
	$('input[name="sake_name"]').click(function() {
		var touch_start_y;
		// タッチしたとき開始位置を保存しておく
		$(window).on('touchstart', function(event) {
			touch_start_y = event.originalEvent.changedTouches[0].screenY;
		});
		// スワイプしているとき
		$(window).on('touchmove.noscroll', function(event) {
			var current_y = event.originalEvent.changedTouches[0].screenY,
			height = $('.dialog_sake_search_background').outerHeight(),
			is_top = touch_start_y <= current_y && $('.dialog_sake_search_background')[0].scrollTop === 0,
			is_bottom = touch_start_y >= current_y && $('.dialog_sake_search_background')[0].scrollHeight - $('.dialog_sake_search_background')[0].scrollTop === height;

			// スクロール対応モーダルの上端または下端のとき
			if (is_top || is_bottom) {
				// スクロール禁止
				event.preventDefault();
			}
		});

		// スクロール禁止
		$('html, body').css('overflow', 'hidden');
		$(".dialog_sake_search_background").css({"display":"flex"});
	});

	$('.close_sake_search_button').click(function() {
		// イベントを削除
		$(window).off('touchmove.noscroll');
		$('html, body').css('overflow', '');
		$(".dialog_sake_search_background").css({"display":"none"});
	});

	$('#sake_sidebar_form .sake_option_trigger').click(function(){
		var obj = this;
		$(obj).next("div").slideToggle();

		if ($(this).children(".arrow_icon").hasClass('active')) {
			// activeを削除
			$(this).children(".arrow_icon").removeClass('active');
		} else {
			// activeを追加
			$(this).children(".arrow_icon").addClass('active');
		}
	});

	///////////////////////////////////////////////////////////////////////////////////////////////
	// sakagura mode
	///////////////////////////////////////////////////////////////////////////////////////////////


	///////////////////////////////////////////////////////////////////////////////////////////////
	// inshokuten mode
	///////////////////////////////////////////////////////////////////////////////////////////////

	$('#inshokuten_sidebar_form .inshokuten_option_trigger').click(function(){
		var obj = this;
		$(obj).next("div").slideToggle();

		if ($(this).children(".arrow_icon").hasClass('active')) {
			// activeを削除
			$(this).children(".arrow_icon").removeClass('active');
		} else {
			// activeを追加
			$(this).children(".arrow_icon").addClass('active');
		}
	});

	//日本酒入力 1////////////////////////////
	$(document).on('keyup', '.all_mode', function(e){
		var inputText = $("#sake_input").val().replace(/　/g, ' ');
		var count = inputText.length;
		var data = "search_text="+inputText;

		if($("#sake_option").css("display") == "block")
			return false;

		if(event.keyCode == 13 && count > 0) {
			$('#sake_search_content').empty();
			return false;
		}

		//$('#general_content').empty();
		$("#sake_search_content").css({"visibility": "hidden"});

		if(count >= 1) {
			$.ajax({
				type: "POST",
				url: "auto_multiple.php",
				data: data,
				dataType: 'json',
			}).done(function(data){

			//alert("input:" + $("#sake_input").val());

				$('#sake_search_content').empty();
				//alert("succeded:" + data + "length:" + data[0].sakagura);
				var sake = data[0].sake;
				var sakagura = data[0].sakagura;
				var syuhanten = data[0].syuhanten;
				var i = 0;

				if(sake != null) {
					for(i = 0; i < sake.length; i++) {
						$('#sake_search_content').append('<li class="general_class1"><svg class="autocomplete_icon_sake"><use xlink:href="#bottle1616"/></svg>' + sake[i].sake_name + '<input type="hidden" value="' + sake[i].sake_id + '"></li>');
					}
				}

				if(sakagura != null) {
					$('#sake_search_content').append('<hr>');

					for(i = 0; i < sakagura.length; i++) {
						$('#sake_search_content').append('<li class="general_class2"><svg class="autocomplete_icon_brewery"><use xlink:href="#brewery3630"/></svg>' + sakagura[i].sake_name + '<input type="hidden" value="' + sakagura[i].sake_id + '"></li>');
					}
				}

				if(syuhanten != null) {
					$('#sake_search_content').append('<hr>');

					for(i = 0; i < syuhanten.length; i++) {
						$('#sake_search_content').append('<li class="general_class3"><svg class="autocomplete_icon_store"><use xlink:href="#store3030"/></svg>' + syuhanten[i].sake_name + '<input type="hidden" value="' + syuhanten[i].sake_id + '"></li>');
					}
				}

				if(sake != null || sakagura != null)
					$("#sake_search_content").css({"visibility": "visible"});

			}).fail(function(data){
				//alert("Failed:" + data);
			});
		} else {
			$('#sake_search_content').empty();
		}
	});
	//日本酒入力 2////////////////////////////
	$(document).on('keyup', '#sake_input', function(){

		var inputText = $("#sake_input").val().replace(/　/g, ' ');
		var count = inputText.length;
		var search_type = 1;
		var search_limit = 24;
		var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

		if($("#sake_option").css("display") == "block")
			return false;

		$("#sake_search_content").css({"visibility": "hidden"})
		$("#sake_search_content").empty();

		if(count >= 1) {
			$.ajax({
				type: "POST",
				url: "auto_complete.php",
				data: data,
				dataType: 'json',
			}).done(function(data){

				//alert("succeded:" + data + "length:" + data.length);
				$('#sake_search_content').empty();

				for(var i = 0; i < data.length; i++) {
					$('#sake_search_content').append('<li class="message_class" sake_id=' + data[i].sake_id + '><svg class="autocomplete_icon_sake"><use xlink:href="#bottle1616"/></svg>' + data[i].sake_name + '</li>');
				}

				$('.message_class').click(function() {
					var sake_id = $(this).attr('sake_id');
					//alert("sake_id:" + sake_id);
					$("#sake_input").val(this.innerText);
					window.open('sake_view.php?sake_id=' + sake_id, '_self');
				});

				if(sake != null || sakagura != null)
					$("#sake_search_content").css({"visibility": "visible"});

			}).fail(function(data){
				alert("Failed:" + data);
			});
		} else {
			$('#sake_search_content').empty();
		}
	});

});
</script>
</body>
</html>
