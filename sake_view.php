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
	<title>日本酒ページ [Sakenomo]</title>
	<link rel="stylesheet" href="slick/slick-theme.css">
	<link rel="stylesheet" href="slick/slick.css">
	<link href="rateyo/jquery.rateyo.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/sake_view.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
	<script src="rateyo/jquery.rateyo.js"></script>
	<script type="text/javascript" src="slick/slick.min.js"></script>
</head>

<body>
	<?php
		include_once('images/icons/svg_sprite.svg');
		write_side_menu();
		write_HamburgerLogo();
		write_search_bar();
		write_Nonda();

		$flavor_table = array(array("10", "greenapple4040", "青りんご"),
							 array("11", "strawberry4040", "いちご"),
							 array("12", "orange4040", "オレンジ"),
							 array("41", "kiwi4040", "キウイ"),
							 array("13", "grapefruit4040", "グレープフルーツ"),
							 array("43", "watermelon4040", "スイカ"),
							 array("14", "nashi4040", "梨"),
							 array("15", "pineapple4040", "パイナップル"),
							 array("16", "banana4040", "バナナ"),
							 array("42", "grape4040", "ぶどう"),
							 array("17", "muscat4040", "マスカット"),
							 array("18", "mango4040", "マンゴー"),
							 array("19", "melon4040", "メロン"),
							 array("20", "peach4040", "桃"),
							 array("21", "pear4040", "洋梨"),
							 array("22", "lychee4040", "ライチ"),
							 array("23", "apple4040", "りんご"),
							 array("24", "lemon4040", "レモン"),
							 array("25", "flower4040", "花"),
							 array("26", "mineralwater4040", "天然水・ミネラル"),
							 array("27", "soda4040", "ソーダ・ラムネ"),
							 array("28", "herb4040", "ハーブ・若草・根菜"),
							 array("29", "tree4040", "木"),
							 array("30", "rice4040", "ご飯・餅"),
							 array("31", "nuts4040", "ナッツ・豆"),
							 array("32", "butter4040", "バター・クリーム・バニラ・チーズ"),
							 array("33", "driedfruit4040", "ドライフルーツ・乾物"),
							 array("34", "soysauce4040", "しょうゆ・みりん"),
							 array("35", "spice4040", "スパイス"),
							 array("36", "caramel4040", "カラメル"),
							 array("37", "cacao4040", "カカオ・ビターチョコ"),
							 array("38", "cemedine4040", "セメダイン"),
							 array("39", "yogurt4040", "ヨーグルト"),
							 array("40", "other4040", "その他"));

		function GetFlavorNames($flavors) {

			global $flavor_table;
			$flavor_array = explode(',', $flavors);
			$ret_value = "";
			$i = 0;
			$j = 0;

			for($i = 0; $i < count($flavor_array); $i++) {

				for($j = 0; $j < count($flavor_table); $j++) {

					if(intval($flavor_array[$i]) == intval($flavor_table[$j][0])) {

						if($ret_val == "") {
							$ret_val = $flavor_table[$j][2];
						}
						else {
							$ret_val .= '/' .$flavor_table[$j][2];
						}

						break;
					}
				}
			}

			return $ret_val;
		}

		function getFlavorValue($value, &$image_value, &$flavor_name) {

			global $flavor_table;
			$i = 0;

			for($i = 0; $i < count($flavor_table); $i++) {

				if(intval($value) == intval($flavor_table[$i][0])) {
					$image_value = $flavor_table[$i][1];
					$flavor_name = $flavor_table[$i][2];
					break;
				}
			}

			return 1;
		}

		function object2array($object) {
			return @json_decode(@json_encode($object),1);
		}

		function sortByCount($a, $b) {
			return $b['count'] - $a['count'];
		}

		function GetSakeCategoryImage($category_code) {

			if($category_code == "11")
			{
				// 無濾過
				$path = '<use xlink:href="#muroka4040"/>';
				return $path;
			}
			else if($category_code == "21")
			{
				// にごり酒
				$path = '<use xlink:href="#nigori4040"/>';
				return $path;
			}
			else if($category_code == "22")
			{
				// あらばしり
				$path = '<use xlink:href="#arabashiri4040"/>';
				return $path;
			}
			else if($category_code == "31")
			{
				// 中取り・中汲み・中垂れ
				$path = '<use xlink:href="#nakadori4040"/>';
				return $path;
			}
			else if($category_code == "32")
			{
				// 責め・押切り
				$path = '<use xlink:href="#seme4040"/>';
				return $path;
			}
			else if($category_code == "33")
			{
				// 生酒・本生
				$path = '<use xlink:href="#nama4040"/>';
				return $path;
			}
			else if($category_code == "34")
			{
				// 生詰酒
				$path = '<use xlink:href="#namazume4040"/>';
				return $path;
			}
			else if($category_code == "35")
			{
				// 生貯蔵酒
				$path = '<use xlink:href="#namacho4040"/>';
				return $path;
			}
			else if($category_code == "37")
			{
				// ひやおろし・秋上がり
				$path = '<use xlink:href="#hiyaoroshi4040"/>';
				return $path;
			}
			else if($category_code == "38")
			{
				// 袋吊り・斗瓶囲い・雫酒
				$path = '<use xlink:href="#shizuku4040"/>';
				return $path;
			}
			else if($category_code == "39")
			{
				// 直汲み・直詰め
				$path = '<use xlink:href="#jika4040"/>';
				return $path;
			}
			else if($category_code == "40")
			{
				// 遠心分離
				$path = '<use xlink:href="#enshinbunri4040"/>';
				return $path;
			}
			else if($category_code == "41")
			{
				// 槽しぼり
				$path = '<use xlink:href="#fune4040"/>';
				return $path;
			}
			else if($category_code == "42")
			{
				// きもと
				$path = '<use xlink:href="#kimoto4040"/>';
				return $path;
			}
			else if($category_code == "43")
			{
				// 山廃もと
				$path = '<use xlink:href="#yamahaimoto4040"/>';
				return $path;
			}
			else if($category_code == "44")
			{
				// 樽酒
				$path = '<use xlink:href="#taru4040"/>';
				return $path;
			}
			else if($category_code == "45")
			{
				// 原酒
				$path = '<use xlink:href="#genshu4040"/>';
				return $path;
			}
			else if($category_code == "48")
			{
				// 古酒・長期熟成酒
				$path = '<use xlink:href="#koshu4040"/>';
				return $path;
			}
			else if($category_code == "49")
			{
				// おりがらみ・うすにごり
				$path = '<use xlink:href="#ori4040"/>';
				return $path;
			}
			else if($category_code == "50")
			{
				// 新酒・初しぼり・しぼりたて
				$path = '<use xlink:href="#shinshu4040"/>';
				return $path;
			}
			else if($category_code == "51")
			{
				// スパークリング
				$path = '<use xlink:href="#sparkling4040"/>';
				return $path;
			}
			/*else if($category_code == "90")
			{
				// その他
				$path = '<use xlink:href="resource.svg#icon_ori"></use>';
				return $path;
			}*/
			/*else
			{
				// 不明
				$path = '<use xlink:href="resource.svg#icon_ori"></use>';
				return $path;
			}*/
		}

		function GetRecommendedDrink($code)
		{
			if($code == "10")
			{
				$retval = "ロック";
				return $retval;
			}
			else if($code == "11")
			{
				$retval = "冷酒";
				return $retval;
			}
			else if($code == "12")
			{
				$retval = "常温";
				return $retval;
			}
			else if($code == "13")
			{
				$retval = "ぬる燗";
				return $retval;
			}
			else if($code == "14")
			{
				$retval = "熱燗";
				return $retval;
			}
		}

		function GetSakeCategory($category_code)
		{
		    if($category_code == "11")
		    {
				$retval = "無濾過";
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
				$retval = "中取り・中汲み・中垂れ";
				return $retval;
			}
			else if($category_code == "32")
			{
				$retval = "責め・押切り";
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
			/*else if($category_code == "36")
			{
				$retval = "火入れ";
				return $retval;
			}*/
			else if($category_code == "37")
			{
				$retval = "ひやおろし・秋上がり";
				return $retval;
			}
			else if($category_code == "38")
			{
				$retval = "袋吊り・斗瓶囲い・雫酒";
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
			/*else if($category_code == "46")
			{
				$retval = "生一本";
				return $retval;
			}*/
			/*else if($category_code == "47")
			{
				$retval = "斗瓶取り・斗瓶囲い";
				return $retval;
			}*/
			else if($category_code == "48")
			{
				$retval = "古酒・長期熟成酒";
				return $retval;
			}
			else if($category_code == "49")
			{
				$retval = "おりがらみ・うすにごり";
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
			/*else if($category_code == "90")
			{
				$retval = "その他";
				return $retval;
			}*/
			else
			{
				$retval = "";
				return $retval;
			}
		}

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
			else if($sake_code == "45")
			{
				$retval = "非公開";
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

		function GetIngredient($ingredient)
		{
			if($ingredient == "10")
			{
				$retval = "米";
				return $retval;
			}
			else if($ingredient == "11")
			{
				$retval = "米麹";
				return $retval;
			}
			else if($ingredient == "12")
			{
				$retval = "醸造アルコール";
				return $retval;
			}
			else if($ingredient == "13")
			{
				$retval = "糖類";
				return $retval;
			}
			else if($ingredient == "14")
			{
				$retval = "酸味料";
				return $retval;
			}
			else if($ingredient == "15")
			{
				$retval = "調味料";
				return $retval;
			}
			else
			{
				$retval = "";
				return $retval;
			}
		}

		////////////////////////////////////////
		////////////////////////////////////////
		function GetSakeKoubo($koubo_code)
		{
			if($koubo_code == "10")
			{
				$retval = "協会6号";
				return $retval;
			}
			else if($koubo_code == "11")
			{
				$retval = "協会7号";
				return $retval;
			}
			else if($koubo_code == "12")
			{
				$retval = "協会9号";
				return $retval;
			}
			else if($koubo_code == "13")
			{
				$retval = "協会10号";
				return $retval;
			}
			else if($koubo_code == "14")
			{
				$retval = "協会11号";
				return $retval;
			}
			else if($koubo_code == "15")
			{
				$retval = "協会14号";
				return $retval;
			}
			else if($koubo_code == "16")
			{
				$retval = "協会601号";
				return $retval;
			}
			else if($koubo_code == "17")
			{
				$retval = "協会701号";
				return $retval;
			}
			else if($koubo_code == "18")
			{
				$retval = "協会901号";
				return $retval;
			}
			else if($koubo_code == "19")
			{
				$retval = "協会1001号";
				return $retval;
			}
			else if($koubo_code == "20")
			{
				$retval = "協会1401号";
				return $retval;
			}
			else if($koubo_code == "21")
			{
				$retval = "協会1501号・秋田流花酵母(AK-1)";
				return $retval;
			}
			else if($koubo_code == "22")
			{
				$retval = "協会1601号";
				return $retval;
			}
			else if($koubo_code == "23")
			{
				$retval = "協会1701号";
				return $retval;
			}
			else if($koubo_code == "24")
			{
				$retval = "協会1801号";
				return $retval;
			}
			else if($koubo_code == "25")
			{
				$retval = "協会No.28";
				return $retval;
			}
			else if($koubo_code == "26")
			{
				$retval = "協会No.77";
				return $retval;
			}
			else if($koubo_code == "27")
			{
				$retval = "赤色清酒酵母";
				return $retval;
			}
			else if($koubo_code == "28")
			{
				$retval = "ワイン酵母";
				return $retval;
			}
			else if($koubo_code == "29")
			{
				$retval = "協会1101号";
				return $retval;
			}
			else if($koubo_code == "30")
			{
				$retval = "協会1901号";
				return $retval;
			}
			else if($koubo_code == "90")
			{
				$retval = "その他";
				return $retval;
			}
			else if($koubo_code == "91")
			{
				$retval = "その他２";
				return $retval;
			}
			else if($koubo_code == "92")
			{
				$retval = "その他３";
				return $retval;
			}
			else
			{
				//$retval = "";
				return $koubo_code;
			}
		}
		////////////////////////////////////////
		////////////////////////////////////////
		function GetAward($award_code)
		{
			if($award_code == "1")
			{
				$retval = "全国新酒鑑評会";
				return $retval;
			}
			else if($award_code == "2")
			{
				$retval = "International Wine Challenge";
				return $retval;
			}
			else if($award_code == "3")
			{
				$retval = "全米日本酒歓評会";
				return $retval;
			}
			else if($award_code == "4")
			{
				$retval = "SAKE COMPETITION";
				return $retval;
			}
			else
			{
				$retval = "";
				return $retval;
			}
		}

		function GetAwardRank($award_code, $rank_code)
		{
			if($award_code == "1")
			{
				$retval = "";

				if($rank_code == "1")
				{
					$retval = "金賞";
				}
				else if($rank_code == "2")
				{
					$retval = "入賞";
				}

				return $retval;
			}
			else if($award_code == "2")
			{
				$retval = "";

				if($rank_code == "1")
				{
					$retval = "トロフィー";
				}
				else if($rank_code == "2")
				{
					$retval = "金賞";
				}
				else if($rank_code == "3")
				{
					$retval = "銀賞";
				}
				else if($rank_code == "4")
				{
					$retval = "銅賞";
				}

				return $retval;
			}
			else if($award_code == "3")
			{
				$retval = "";

				if($rank_code == "1")
				{
					$retval = "グランプリ";
				}
				else if($rank_code == "2")
				{
					$retval = "準グランプリ";
				}
				else if($rank_code == "3")
				{
					$retval = "金賞";
				}
				else if($rank_code == "4")
				{
					$retval = "銀賞";
				}

				return $retval;
			}
			else if($award_code == "4")
			{
				$retval = "";

				if($rank_code == "1")
				{
						$retval = "GOLD";
				}
				else if($rank_code == "2")
				{
						$retval = "SILVER";
				}

				return $retval;
			}
			else
			{
				$retval = "";
				return $retval;
			}
		}

		////////////////////////////////////////
		////////////////////////////////////////

		$sake_id = $_GET['sake_id'];
		$nondaname = $_GET['username'];
		$username = $_COOKIE['login_cookie'];

		if(!$db = opendatabase("sake.db"))
		{
			die("データベース接続エラー .<br />");
		}

		$sql = "SELECT * FROM FAVORITE_J WHERE username = '$username' AND sake_id = '$sake_id'";
		$res = executequery($db, $sql);
		$rd_favorite = getnextrow($res);

		//$sql = "SELECT * FROM TABLE_NONDA WHERE contributor = '$username' AND sake_id = '$sake_id' AND committed = 1";
		$sql = "SELECT * FROM TABLE_NONDA, USERS_J WHERE contributor = '$username' AND sake_id = '$sake_id' AND USERS_J.email = TABLE_NONDA.contributor";

		$res = executequery($db, $sql);
		$rd_nonda = getnextrow($res);

		$sql = "SELECT AVG(rank) FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND (rank != 0 AND rank != '')";
		$res = executequery($db, $sql);
		$rd_average = getnextrow($res);
		$avg_rank = $rd_average["AVG(rank)"];
		$avg_percent = ($avg_rank / 5) * 100;

		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////
		//print("酒蔵のID". $sake_id);
		$sql = "SELECT * FROM SAKE_J, SAKAGURA_J WHERE sake_id = '$sake_id' AND sakagura_id = id";
		//$sql = "SELECT * FROM SAKE_J, SAKAGURA_J, SAKE_RICE WHERE sake_id = '$sake_id' AND sakagura_id = id AND (SAKE_J.rice_used = SAKE_RICE.rice_name or SAKE_J.rice_used is NULL)";
		//$sql = "SELECT * FROM SAKE_J, SAKAGURA_J, SAKE_RICE, SAKAGURA_ESTABLISHMENT WHERE sake_id = '$sake_id' AND sakagura_id = id AND (SAKE_J.rice_used = SAKE_RICE.rice_name or SAKE_J.rice_used is NULL or SAKE_J.rice_used = '') AND (SAKE_J.year_made = SAKAGURA_ESTABLISHMENT.year or SAKE_J.year_made is NULL or SAKE_J.year_made = '')";
		//$sql = "SELECT * FROM SAKE_J, SAKAGURA_J, SAKE_RICE, SAKAGURA_ESTABLISHMENT WHERE sake_id = '$sake_id' AND sakagura_id = id AND (SAKE_J.rice_used = SAKE_RICE.rice_name or SAKE_J.rice_used is NULL or SAKE_J.rice_used = '') AND (SAKE_J.kakemai = SAKE_RICE.rice_name or SAKE_J.kakemai is NULL or SAKE_J.kakemai = '') AND (SAKE_J.year_made = SAKAGURA_ESTABLISHMENT.year or SAKE_J.year_made is NULL or SAKE_J.year_made = '')";
		//$sql = "SELECT * FROM SAKE_J, SAKAGURA_J, SAKE_RICE SR1, SAKE_RICE SR2, SAKAGURA_ESTABLISHMENT WHERE sake_id = '$sake_id' AND sakagura_id = id AND (SAKE_J.rice_used = SR1.rice_name or SAKE_J.rice_used is NULL or SAKE_J.rice_used = '') AND (SAKE_J.kakemai = SR2.rice_name or SAKE_J.kakemai is NULL or SAKE_J.kakemai = '') AND (SAKE_J.year_made = SAKAGURA_ESTABLISHMENT.year or SAKE_J.year_made is NULL or SAKE_J.year_made = '')";

		$res = executequery($db, $sql);
		$row = getnextrow($res);

		if(!$row)
		{
			die("nodata .<br />");
		}

		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// creating a flavor lookup table
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$flavor_lookupTable1 = [];
		$flavor_lookupTable2 = [];
		$lookupTable_count1 = 0;
		$lookupTable_count2 = 0;
		$bFound1 = false;
		$bFound2 = false;

		$sql = "SELECT * FROM TABLE_NONDA WHERE sake_id = '$sake_id'";
		$res = executequery($db, $sql);

		while($rd = getnextrow($res)) {
			$flavor_array = explode(',', $rd["flavor"]);

			if(count($flavor_array) >= 1) {

				/* first flavor */
				for($j = 0; $j < count($flavor_lookupTable1); $j++) {
					if($flavor_array[0] == $flavor_lookupTable1[$j]['flavor']) {
						$flavor_lookupTable1[$j]['count']++;
						$lookupTable_count1++;
						$bFound1 = true;
						break;
					}
				}

				if(!$bFound1 && $flavor_array[0]) {
					$flavor_lookupTable1[] = array('flavor' => $flavor_array[0], 'count' => 1);
					$lookupTable_count1++;
				}

				/* second flavor */
				if(count($flavor_array) >= 2) {
					for($j = 0; $j < count($flavor_lookupTable2); $j++) {
						if($flavor_array[1] == $flavor_lookupTable2[$j]['flavor']) {
							$flavor_lookupTable2[$j]['count']++;
							$lookupTable_count2++;
							$bFound2 = true;
							break;
						}
					}

					if(!$bFound2 && $flavor_array[1]) {
						$flavor_lookupTable2[] = array('flavor' => $flavor_array[1], 'count' => 1);
						$lookupTable_count2++;
					}
				}

				$bFound1 = false;
				$bFound2 = false;
			}
		}

		usort($flavor_lookupTable1, 'sortByCount');
		usort($flavor_lookupTable2, 'sortByCount');

		/////////////////////////////////////////////////////////
		// 内容量
		$xmltext = $row["volume_other"];
		$xml = simplexml_load_string($row["volume_other"]);
		//$xml_array = object2array($xml);

		// アルコール
		$alcohol_array = explode(',', $row["alcohol_level"]);

		// 酒度
		$syudo_array = explode(',', $row["jsake_level"]);

		// 酸度
		$oxidation_array = explode(',', $row["oxidation_level"]);

		// アミノ酸
		$amino_array = explode(',', $row["amino_level"]);

		// 原材料
		$ingredients_array = explode(',', $row["ingredients"]);

		// 酵母
		$koubo_array = explode(',', $row["koubo_used"]);
		$category_array = explode(',', $row["sake_category"]);
		$award_array = explode('/', $row["sake_award_history"]);

		// 酒ランク
		$rank_value = intval($row["sake_rank"]);

		////////////////////////////////////////////////////////
		// tasting note
		$sql = "SELECT flavor, tastes FROM table_nonda WHERE sake_id = '$sake_id'";
		$nonda_result = executequery($db, $sql);
		$kaori = 0; $body = 0; $clear = 0; $amakara = 0; $umami = 0; $sanmi = 0; $bitter = 0; $yoin = 0;
		$taste_count = 1;
		$flavor_ranks = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$flavor_count = 0;

		while($nonda_record = getnextrow($nonda_result))
		{
			if($nonda_record["flavor"] && $nonda_record["flavor"] != "")
			{
				$flavor_array = explode(',', $nonda_record["flavor"]);

				for($i = 0; $i < count($flavor_array); $i++)
				{
					$flavor_index = intval($flavor_array[$i]);
					$flavor_ranks[$flavor_index]++;
				}

				$flavor_count++;
			}

			$taste_array = explode(',', $nonda_record["tastes"]);
			$kaori	 += intval($taste_array[0]);
			$body	 += intval($taste_array[1]);
			$clear	 += intval($taste_array[2]);
			$amakara += intval($taste_array[3]);
			$umami	 += intval($taste_array[4]);
			$sanmi	 += intval($taste_array[5]);
			$bitter	 += intval($taste_array[6]);
			$yoin	 += intval($taste_array[7]);
			$taste_count++;
		}

		$flavor_assoc_array = array(
			"1" => $flavor_ranks[1],
			"2" => $flavor_ranks[2],
			"3" => $flavor_ranks[3],
			"4" => $flavor_ranks[4],
			"5" => $flavor_ranks[5],
			"6" => $flavor_ranks[6],
			"7" => $flavor_ranks[7],
			"8" => $flavor_ranks[8],
			"9" => $flavor_ranks[9]
		);

		arsort($flavor_assoc_array);
		$flavor_keys = array_keys($flavor_assoc_array);

		$kaori_average	 = round($kaori / $taste_count, 2, PHP_ROUND_HALF_DOWN);
		$body_average	 = round($body / $taste_count, 2, PHP_ROUND_HALF_DOWN);
		$clear_average	 = round($clear / $taste_count, 2, PHP_ROUND_HALF_DOWN);
		$amakara_average = round($amakara / $taste_count, 2, PHP_ROUND_HALF_DOWN);
		$umami_average	 = round($umami / $taste_count, 2, PHP_ROUND_HALF_DOWN);
		$sanmi_average	 = round($sanmi / $taste_count, 2, PHP_ROUND_HALF_DOWN);
		$bitter_average	 = round($bitter / $taste_count, 2, PHP_ROUND_HALF_DOWN);
		$yoin_average	 = round($yoin / $taste_count, 2, PHP_ROUND_HALF_DOWN);

		$kaori_percent	 = (($kaori_average / 5) * 100) ."%";
		$body_percent    = (($body_average / 5) * 100) ."%";
		$clear_percent	 = (($clear_average / 5) * 100) ."%";
		$amakara_percent = (($amakara_average / 5) * 100) ."%";
		$umami_percent   = (($umami_average / 5) * 100) ."%";
		$sanmi_percent	 = (($sanmi_average / 5) * 100) ."%";
		$bitter_percent	 = (($bitter_average / 5) * 100) ."%";
		$yoin_percent	 = (($yoin_average / 5) * 100) ."%";

		$sql = "SELECT COUNT(*) FROM FAVORITE_J WHERE sake_id = '$sake_id'";
		$res = executequery($db, $sql);
		$rd_fav_count = getnextrow($res);
		$nomita_count = ($rd_fav_count["COUNT(*)"] == 0 || $rd_fav_count["COUNT(*)"] == '') ? "--" : $rd_fav_count["COUNT(*)"];

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		print('<div id="container" data-sake_id=' .$row["sake_id"]
							.' data-contributor="' .$username
							.'" data-sake_name="' .stripslashes($row["sake_name"])
							.'" data-sake_read="' .$row["sake_read"]
							.'" data-sakagura_name="' .$row["sakagura_name"]
							.'" data-pref=' .$row["pref"]
							.' data-write_date=' .$row["write_date"]
							.' data-rank=' .$row["rank"]
							.' data-flavor="' .$row["flavor"] .'">');

		print('<div id="sakeheader">');

			/* 銘柄名 */
			print('<div id="sake_name">'.stripslashes($row["sake_name"]).'</div>');
			print('<div id="sake_read">'.stripslashes($row["sake_read"]).'</div>');

			/* 酒 English */
			print('<div id="sake_english">'.stripslashes($row["sake_english"]).'</div>');

			print('<div class="rank_sakagura_container">');
				/* 酒ランク */
				$i = 0;
				print('<div id="sake_rank">');
					print('<div class="star_rating">');
						print('<div class="star_rating_front" style="width:' .$avg_percent .'%">★★★★★</div>');
						print('<div class="star_rating_back">★★★★★</div>');
					print('</div>');
					if($avg_rank) {
						print('<div id="sake_rate">' .number_format($avg_rank, 1) .'</div>');
					} else {
						print('<div id="sake_rate" style="color: #b2b2b2;">--</div>');
					}
				print('</div>');

				/* 飲みたい登録数 */
				print('<div class="nomitai_info" href="sda_view.php?id=' .$row["id"] .'">');
					print('<div class="nomitai_count_container"><svg class="nomitai_count_people1616"><use xlink:href="#people1616"/></svg><div class="nomitai_count_title">飲みたい</div></div>');
					print('<div id="nomitai_count">' .$nomita_count .'</div>');
				print('</div>');

				/* 酒蔵名 */
				print('<a class="sakagura_info" href="sda_view.php?id=' .$row["id"] .'">');
					print('<div class="sakagura_name_container"><svg class="sakagura_info_brewery3630"><use xlink:href="#brewery3630"/></svg><div id="sakagura_name">' .$row["sakagura_name"].'</div></div>');
					print('<div id="address"> / '.$row["pref"] .'</div>');
				print('</a>');

			print('</div>');

			/* 飲んだ・飲みたい */
			print('<ul id="personal">');

				if($rd_nonda)
				{
					$rank_value = ($rd_nonda["rank"] == "") ? 0 : number_format($rd_nonda["rank"], 1);

					//print('<li class="follow"><svg class="button_bbs_pin1616" style="fill:#FF4545"><use xlink:href="#pin1616"/></svg>飲みたい</li>');
					//print('<div>' .$rd_nonda["contributor"] .'</div>');

					///////////////////////////////////////////////////////////////////
					$image_result = executequery($db, "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$username'");
					$added_path = "";
					//$desc = "";
					$desc = [];

					while($image_record = getnextrow($image_result))
					{
						if($added_path == "")
							$added_path = $image_record["filename"];
						else
							$added_path .= ', ' .$image_record["filename"];

						array_push($desc, $image_record["desc"]);

						//if($desc == "")
						//	$desc = $image_record["desc"];
						//else
						//	$desc .= '/' .$image_record["desc"];
					}
					///////////////////////////////////////////////////////////////////

					//print('<div>added_path:' .$added_path .'</div>');
					print('<li id="button_bbs" style="background:linear-gradient(#EDCACA, #ffffff); border:1px solid #FF4545"
					data-contributor=' .$rd_nonda["contributor"]
					.' data-sake_id=' .$rd_nonda["sake_id"]
					.' data-pref=' .$rd_nonda["pref"]
					.' data-update_date=' .$rd_nonda["update_date"]
					.' data-rank="' .$rank_value
					.'" data-subject="' .$rd_nonda["subject"]
					.'" data-message="' .$rd_nonda["message"]
					.'" data-flavor="' .$rd_nonda["flavor"]
					.'" data-tastes="' .$rd_nonda["tastes"]
					.'" data-paths="' .$added_path
					.'" data-desc="' .$desc
					.'" data-committed=' .$rd_nonda["committed"] .'><svg class="button_bbs_heart2020" style="fill:#FF4545"><use xlink:href="#heart2020"/></svg>飲んだ</li>');
				}
				else
				{
					print('<li id="button_bbs"><svg class="button_bbs_heart2020"><use xlink:href="#heart2020"/></svg>飲んだ</li>');
				}

				if($rd_favorite)
				{
					//print('<li class="follow followed"><svg class="button_bbs_pin1616"><use xlink:href="#pin1616"/></svg>飲みたい</li>');
					print('<li class="follow" style="background:linear-gradient(#EDCACA, #ffffff); border:1px solid #FF4545; transition: 0.3s"><svg class="button_bbs_pin1616" style="fill:#FF4545; transition: 0.3s;"><use xlink:href="#pin1616"/></svg>飲みたい</li>');
				}
				else
				{
					print('<li class="follow"><svg class="button_bbs_pin1616"><use xlink:href="#pin1616"/></svg>飲みたい</li>');
				}

				/*print('<li id="button_edit">編集</li>');*/
				/*print('<li id="delete_sake" sake_id=' .$sake_id .'>削除</li>');*/
			print('</ul>');

		print('</div>'); /*sakeheader*/
		////////////////////////////////////////
		////////////////////////////////////////
		print('<div id="saketable_banner_container">');
			////////////////////////////////////////
			////////////////////////////////////////
			print('<div id="saketable">');
				print('<div id="tab_main">');

					print('<ul class="simpleTabs">');
						print('<li><a href="#top" class="active"><span><svg class="simpleTabs_sake3630"><use xlink:href="#sake3630"/></svg><span>トップ</span></span></a></li>');
						print('<li><a href="#review"><span><svg class="simpleTabs_review3630"><use xlink:href="#review3630"/></svg><span>レビュー</span></span></a></li>');
						print('<li><a href="#tasting"><span><svg class="simpleTabs_note3630"><use xlink:href="#note3630"/></svg><span>テイスティングノート</span></span></a></li>');
						print('<li><a href="#photo"><span><svg class="simpleTabs_camera3630"><use xlink:href="#camera3630"/></svg><span>写真</span></span></a></li>');
					print("</ul>");
					////////////////////////////////////////
					////////////////////////////////////////
					print('<div id="top" class="form-action show">');

						print('<div class="top_note"><div>一般ユーザーのご協力によって編集・投稿された情報は最新のものと異なる場合があります。</div><!--非表示中<a href=""><svg class="top_note_pen1616"><use xlink:href="#pen1616"/></svg>酒蔵向け無料会員登録はこちら</a>--></div>');

						print('<div id="preview_definition_container">');
							print('<div id="preview_frame">');

								$rd = executequery($db, "SELECT FILENAME FROM SAKE_IMAGE WHERE sake_id = '$sake_id' limit 9");
								$image = getnextrow($rd);

								if($image)
								{
									// プレビュー
									print('<ul id="preview_main_container">');
										$path = "images\\photo\\".$image["filename"];
										$i = 1;
										print('<li class="sakeimage">');
											print('<img src="' .$path  .'">');
										print('</li>');

										while($image = getnextrow($rd))
										{
											$path = "images\\photo\\".$image["filename"];
											print('<li class="sakeimage">');
											print('<img src="' .$path .'">');
											print('</li>');
											$i = $i + 1;
										}
									print("</ul>");

									// サムネ
									print('<ul id="preview_thumbnail_container">');
										$rd = executequery($db, "SELECT FILENAME FROM SAKE_IMAGE WHERE sake_id = '$sake_id' limit 9");

										while($image = getnextrow($rd))
										{
											$i = 1;
											print('<li class="sakeimage_thumbnail">');
												$path = "images\\photo\\".$image["filename"];
												print('<img src="' .$path  .'">');
												$i = $i + 1;
											print('</li>');
										}
									print("</ul>");
								}
								else
								{
									print('<ul id="preview_main_container">');
										print('<li class="sakeimage"><img src="images/icons/noimage320.svg"></li>');
										print('<li class="sakeimage"><img src="images/icons/noimage240.svg"></li>');
										print('<li class="sakeimage"><img src="images/icons/noimage160.svg"></li>');
										print('<li class="sakeimage"><img src="images/icons/noimage80.svg"></li>');
										print('<li class="sakeimage"><img src="images/icons/noimage_user30.svg"></li>');
										print('<li class="sakeimage"><img src="images/icons/test_photo1.JPG"></li>');
										print('<li class="sakeimage"><img src="images/icons/test_photo2.JPG"></li>');
									print("</ul>");

									print('<ul id="preview_thumbnail_container">');// サムネ画像は最大9個まで
										print('<li class="sakeimage_thumbnail"><img src="images/icons/noimage320.svg"></li>');
										print('<li class="sakeimage_thumbnail"><img src="images/icons/noimage240.svg"></li>');
										print('<li class="sakeimage_thumbnail"><img src="images/icons/noimage160.svg"></li>');
										print('<li class="sakeimage_thumbnail"><img src="images/icons/noimage80.svg"></li>');
										print('<li class="sakeimage_thumbnail"><img src="images/icons/noimage_user30.svg"></li>');
										//print('<li class="sakeimage_thumbnail"><img src="images/icons/test_photo1.JPG"></li>');
										//print('<li class="sakeimage_thumbnail"><img src="images/icons/test_photo2.JPG"></li>');
									print("</ul>");
								}
							print("</div>");

							////////////////////////////////////////
							////////////////////////////////////////
							print('<div id="definition_outerframe">');

								/* 基本スペック*/
								print('<div id="sake_basicspec">');
									print('<div class="sake_basicspec_title"><div></div>基本スペック</div>');

									print('<ul class="sake_basicspec_item_container">');
										// 特定名称
										print('<li class="sake_basicspec_item">');
											print('<span>');
												print('<svg class="sake_basicspec_tokuteimeisho1616"><use xlink:href="#tokuteimeisho1616"/></svg>');
											print("</span>");

											print('<span class="sake_basicspec_item_title">特定名称</span>');
											print('<span id="special_name">');

												$special_name_array = explode(',', $row["special_name"]);

												if($row["special_name"]) {
													if($special_name_array[0] == "90") {
														if(count($special_name_array) > 1) {
															print($special_name_array[1]);
														}
														else {
															print("その他");
														}
													} else {
														print(GetSakeSpecialName($special_name_array[0]));
													}
												} else {
													print('<span style="color: #b2b2b2;">--</span>');
												}

											print("</span>");
										print("</li>");

										// アルコール
										print('<li class="sake_basicspec_item">');
											print('<span>');
												print('<svg class="sake_basicspec_alc1616"><use xlink:href="#alc1616"/></svg>');
											print("</span>");
											print('<span class="sake_basicspec_item_title">Alc度数</span>');
											print('<span id="alcohol_level">');

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

											print("</span>");
										print("</li>");

										// 原料米
										print('<li class="sake_basicspec_item">');
											print('<span>');
												print('<svg class="sake_basicspec_rice1616"><use xlink:href="#rice1616"/></svg>');
											print("</span>");
											print('<span class="sake_basicspec_item_title">原料米</span>');
											print('<span id="rice_used1">');

												$rice_array = explode('/', $row["rice_used"]);

												if($row["rice_used"]) {
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

											print("</span>");
										print("</li>");

										// 精米歩合
										print('<li class="sake_basicspec_item">');
											print('<span>');
												print('<svg class="sake_basicspec_cleanedrice1616"><use xlink:href="#cleanedrice1616"/></svg>');
											print("</span>");
											print('<span class="sake_basicspec_item_title">精米歩合</span>');
											print('<span id="seimai_rate">');

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

											print("</span>");
										print("</li>");

										// 日本酒度
										print('<li class="sake_basicspec_item">');
											print('<span>');
												print('<svg class="sake_basicspec_nihonshudo1616"><use xlink:href="#nihonshudo1616"/></svg>');
											print("</span>");
											print('<span class="sake_basicspec_item_title">日本酒度</span>');
											print('<span id="jsake_level">');

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

											print("</span>");
										print("</li>");

										// 酸度
										print('<li class="sake_basicspec_item">');
											print('<span>');
												print('<svg class="sake_basicspec_sando1616"><use xlink:href="#sando1616"/></svg>');
											print("</span>");
											print("<span class='sake_basicspec_item_title'>酸度</span>");
											print('<span id="oxidation_level">');

												if($oxidation_array[0] != null && $oxidation_array[1] != null) {
													if($oxidation_array[0] == $oxidation_array[1]) {
														print(number_format($oxidation_array[0], 1));
													} else {
														print(number_format($oxidation_array[0], 1).'～'.number_format($oxidation_array[1], 1));
													}
												} else if($oxidation_array[0] != null && $oxidation_array[1] == null) {
													print(number_format($oxidation_array[0], 1));
												} else {
													print('<span style="color: #b2b2b2;">--<span>');
												}

											print("</span>");
										print("</li>");

										// アミノ酸度
										print('<li class="sake_basicspec_item">');
											print('<span>');
												print('<svg class="sake_basicspec_aminosando1616"><use xlink:href="#aminosando1616"/></svg>');
											print("</span>");
											print("<span class='sake_basicspec_item_title'>アミノ酸度</span>");
											print('<span id="amino_level">');

											if($amino_array[0] != null && $amino_array[1] != null) {
												if($amino_array[0] == $amino_array[1]) {
													print(number_format($amino_array[0], 1));
												} else {
													print(number_format($amino_array[0], 1).'～'.number_format($amino_array[1], 1));
												}
											} else if($amino_array[0] != null && $amino_array[1] == null) {
												print(number_format($amino_array[0], 1));
											} else {
												print('<span style="color: #b2b2b2;">--<span>');
											}

											print("</span>");
										print("</li>");

										// 酵母
										print('<li class="sake_basicspec_item">');
											print('<span>');
												print('<svg class="sake_basicspec_yeast1616"><use xlink:href="#yeast1616"/></svg>');
											print("</span>");
											print('<span class="sake_basicspec_item_title">酵母</span>');
											print('<span id="koubo">');

												if($row["koubo_used"]) {
													for($j = 0; $j < count($koubo_array); $j++) {
														if($koubo_array[$j] == "90" || $koubo_array[$j] == "91" || $koubo_array[$j] == "92") {
															//print($koubo_array[$j].":");
															print($koubo_array[$j + 1]);
															$j++;
														} else {
															print(GetSakeKoubo($koubo_array[$j]));
															//print($koubo_array[$j]);
														}
														if($j < (count($koubo_array) - 1))
														print(" / ");
													}
												} else {
													print('<span style="color: #b2b2b2;">--</span>');
												}

											print("</span>");
										print("</li>");

									print("</ul>");
								print("</div>");

								/*製法の特徴*/
								print('<div id="sake_category_frame">');
									print('<div class="sake_category_title"><div></div>製法の特徴</div>');

									print('<ul id="sake_category">');

										if($row["sake_category"] != null) {
											for($j = 0; $j < count($category_array); $j++)
											{
												if($category_array[$j] == "90")
												{
													print('<li>');
														print('<svg  version="1.1" id="sparkling" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;" width="40" height="40" viewBox="0 0 40 40">' .GetSakeCategoryImage($category_array[$j]) .'</svg>');
													print('<div>'.$category_array[$j + 1].'</div></li>');
													$j++;
												}
												else if($category_array[$j] != undefined && $category_array[$j] != "")
												{
													print('<li>');
														print('<svg  version="1.1" id="sparkling" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;" width="40" height="40" viewBox="0 0 40 40">' .GetSakeCategoryImage($category_array[$j]) .'</svg>');
													print('<div>'.GetSakeCategory($category_array[$j]).'</div></li>');
												}
											}
										}
										else {
											print('<span>----</span>');
										}
									print("</ul>");
								print("</div>");

								/*フレーバー*/
								print('<div id="flavor_information">');
									print('<div class="flavor_information_title"><div></div>フレーバー</div>');

									print('<ul id="flavor_category">');

										$image_value = "";
										$flavor_name = "";

										if($flavor_lookupTable1 || $flavor_lookupTable2) {
											/* フレーバー1 */
											if(count($flavor_lookupTable1) > 0) {
												getFlavorValue($flavor_lookupTable1[0]['flavor'], $image_value, $flavor_name);
												print('<li><svg><use xlink:href="#' .$image_value .'"/></svg><div>' .$flavor_name .'</div></li>');
											}
											/* フレーバー2 */
											if(count($flavor_lookupTable2) > 0) {
												getFlavorValue($flavor_lookupTable2[0]['flavor'], $image_value, $flavor_name);
												print('<li><svg><use xlink:href="#' .$image_value .'"/></svg><div>' .$flavor_name .'</div></li>');
											}
										} else {
											print('<span>----</span>');
										}

									print('</ul>');

								print('</div>');

								/*主な受賞*/
								print('<div id="sake_award_information">');
									print('<div class="sake_award_information_title"><div></div>鑑評会・コンクール</div>');

									print('<div class="sake_award_item">');

										if(count($award_array) > 0 && $award_array[0] != "")
										{
											for($j = 0; $j < count($award_array); $j++)
											{
												$award = explode(',', $award_array[$j]);
												print('<div>'.GetAward($award[0]));

													if($award[1] != "")
														print(" (".$award[1].") ");

													print(GetAwardRank($award[0], $award[2]));
												print("</div>");
											}
										} else {
											print('<span>----</span>');
										}
									print("</div>");
								print("</div>");
								////////////////////////////////////////
								////////////////////////////////////////
								/*プロフィール
								print('<div id="sake_profile_frame">');
									print('<div class="sake_profile_title"><svg class="sake_profile_profile2420"><use xlink:href="#profile2420"/></svg>プロフィール</div>');
									print('<div id="definition">'.stripslashes(nl2br($row["definition"])).'</div>');
								print('</div>');*/
								////////////////////////////////////////
								////////////////////////////////////////
							print("</div>"); //definition_outerframe
						print("</div>");

					print("</div>"); //top
					////////////////////////////////////////
					////////////////////////////////////////
					print('<div id="review" class="form-action hide">');

						$sql = "SELECT COUNT(*) FROM TABLE_NONDA WHERE sake_id = '$sake_id' AND (subject IS NOT '' OR message IS NOT '')";
						$res = executequery($db, $sql);
						$record = getnextrow($res);
						$count_result = $record["COUNT(*)"];
						$count_tastes = array(0, 0, 0, 0, 0, 0, 0, 0);
						$tastes_all = array(0, 0, 0, 0, 0, 0, 0, 0);
						$p_max = 25;

						////////////////////////////////////////
						////////////////////////////////////////

						if($count_result > 0) {
							print('<div class="review_sort">');
								print('<div class="click_sort"><div><svg class="click_sort_sort1214"><use xlink:href="#sort1214"/></svg></div><!--<div class="click_sort_standard">標準</div>--><div class="click_sort_date">更新日</div><!--非表示中<div class="click_sort_ranking">ランキング</div>--></div>');
							print('</div>');

							print('<div class="review_count_container">');
								if($count_result > $p_max) {
									$p_next = $p_max;

									if(($p_max + 25) > $count_result) {
										$p_next = $count_result - $p_max;
									}

									print('<span id="disp_sake" class="navigate_page">'. ($in_disp_from + 1) .'～' .$p_max .'件 / 全' .$count_result .'件</span>');
								}
								else
								{
									if($count_result < $p_max)
									{
										$p_max = $count_result;
									}

									print('<span id="disp_sake" class="navigate_page">'. ($in_disp_from + 1) .'～' .$p_max .'件 / 全' .$count_result .'件</span>');
								}
							print('</div>');

							$sql = "SELECT * FROM TABLE_NONDA, USERS_J WHERE sake_id = '$sake_id' AND USERS_J.email = TABLE_NONDA.contributor AND (subject IS NOT '' OR message IS NOT '') ORDER BY update_date DESC";
							$result = executequery($db, $sql);

							print('<div id="threads">');

								while($result && $record = getnextrow($result))
								{
									$i = 0;
									$path = "images/icons/noimage_user30.svg";

									$contributor = $record["contributor"];
									$sake_id = $record["sake_id"];
									//$rank_value = number_format($record["rank"], 1);
									$rank_value = ($record["rank"] == "") ? 0 : number_format($record["rank"], 1);

									$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$contributor' AND status = 1";
									$res4 = executequery($db, $sql);
									$rd = getnextrow($res4);

									if($rd) {
										//$path = "images/profile/noimage_user30.svg" .$rd["filename"];
										$path = "images/profile/" .$rd["filename"];
									}

									print('<a class="review" href="user_view_sakereview.php?sake_id=' .$sake_id .'&contributor=' .$contributor .'">');

										print('<div class="nonda_user_container">');

											print('<div class="nonda_user_image_container">');
												print('<img src="' .$path .'">');
											print('</div>');

											print('<div class="nonda_user_name_container">');
												print('<div class="nonda_user_name">' .$record["username"] .'</div>');
												print('<div class="nonda_user_profile_date_container">');
													print('<div class="nonda_user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>');
													print('<div class="nonda_date">' .gmdate("Y/m/d", $record["update_date"] + 9 * 3600) .'</div>');
												print('</div>');
											print('</div>');

										print('</div>');
										////////////////////////////////////////
										////////////////////////////////////////
										$rank_width = (($record[rank] / 5) * 100) .'%';
										print('<div class="nonda_rank">');
											print('<div class="review_star_rating">');
												print('<div class="review_star_rating_front" style="width:' .$rank_width. '">★★★★★</div>');
												print('<div class="review_star_rating_back">★★★★★</div>');
											print('</div>');
											if($record["rank"]) {
												print('<span class="review_sake_rate">' .number_format($record["rank"], 1) .'</span>');
											} else {
												print('<span class="review_sake_rate" style="color: #b2b2b2;">--</span>');
											}
										print('</div>');
										////////////////////////////////////////
										////////////////////////////////////////
										if($record["subject"] && $record["message"]) {
											print('<div class="nonda_subject_message_container">');
												print('<div class="nonda_subject">' .$record["subject"] .'</div>');
												print('<div class="nonda_message">'.nl2br($record["message"]).'</div>');
											print('</div>');
										} else if($record["subject"] && $record["message"] == null) {
											print('<div class="nonda_subject_message_container">');
												print('<div class="nonda_subject">' .$record["subject"] .'</div>');
											print('</div>');
										} else if($record["subject"] == null && $record["message"]) {
											print('<div class="nonda_subject_message_container">');
												print('<div class="nonda_message">'.nl2br($record["message"]).'</div>');
											print('</div>');
										} else {
											print('');
										}
										////////////////////////////////////////
										////////////////////////////////////////

										$image_result = executequery($db, "SELECT * FROM SAKE_IMAGE WHERE sake_id = '$sake_id' AND contributor = '$contributor'");
										$image_record = getnextrow($image_result);

										if($image_record && $image_record != "")
										{
											print('<div class="review_container">');
												$path = "images\\photo\\thumb\\". $image_record["filename"];
												print('<div class="review_image"><img src="' .$path .'" data-desc = "' .$image_record["desc"] .'"></div>');

												while($image_record = getnextrow($image_result))
												{
													$path = "images\\photo\\thumb\\". $image_record["filename"];
													print('<div class="review_image"><img src="' .$path .'" data-desc = "' .$image_record["desc"] .'"></div>');
												}
											print('</div>');
										} else {
											print('');
										}

										////////////////////////////////////////
										////////////////////////////////////////
										if($record["flavor"] || $record["tastes"])
										{
											if($record["tastes"])
												$tastes_values = explode(',', $record["tastes"]);
											else
												$tastes_values = Array(0, 0, 0, 0, 0, 0, 0, 0);

											print('<div class="tastes">');

												print('<div class="tastes_item">');
													print('<div class="tastes_title"><svg class="tastes_item_flavor1816"><use xlink:href="#flavor1816"/></svg>フレーバー</div>');
													//print('<div class="taste_value_flavor">' .$record["flavor"] .'</div>');
													if($record["flavor"]) {
														print('<div class="taste_value_flavor">' .GetFlavorNames($record["flavor"]) .'</div>');
													} else {
														print('<div class="taste_value_flavor" style="color: #b2b2b2;">--</div>');
													}
												print('</div>');
												////////////////////////////////////////
												print('<div class="tastes_item">');
													print('<div class="tastes_title"><svg class="tastes_item_aroma1216"><use xlink:href="#aroma1216"/></svg>香り</div>');
													print('<div class="tastes_value_container">');
														print('<div class="tastes_bar_container">');
															print('<input type="range" name="aroma" step="0.1" min="0" max="5" value="' .$tastes_values[0] .'" disabled="disabled" class="user_input_range">');
														print('</div>');
														if($tastes_values[0]) {
															print('<div class="taste_value">'. number_format($tastes_values[0], 1).'</div>');
														} else {
															print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
														}
													print('</div>');
												print('</div>');
												////////////////////////////////////////
												print('<div class="tastes_item">');
													print('<div class="tastes_title"><svg class="tastes_item_body1216"><use xlink:href="#body1216"/></svg>ボディ</div>');
													print('<div class="tastes_value_container">');
														print('<div class="tastes_bar_container">');
															print('<input type="range" name="body" step="0.1" min="0" max="5" value="' .$tastes_values[1] .'" disabled="disabled" class="user_input_range">');
														print('</div>');
														if($tastes_values[1]) {
															print('<div class="taste_value">'. number_format($tastes_values[1], 1).'</div>');
														} else {
															print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
														}
													print('</div>');
												print('</div>');
												////////////////////////////////////////
												print('<div class="tastes_item">');
													print('<div class="tastes_title"><svg class="tastes_item_clear3030"><use xlink:href="#clear3030"/></svg>クリア</div>');
													print('<div class="tastes_value_container">');
														print('<div class="tastes_bar_container">');
															print('<input type="range" name="clear" step="0.1" min="0" max="5" value="' .$tastes_values[2] .'" disabled="disabled" class="user_input_range">');
														print('</div>');
														if($tastes_values[2]) {
															print('<div class="taste_value">'. number_format($tastes_values[2], 1).'</div>');
														} else {
															print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
														}
													print('</div>');
												print('</div>');
												////////////////////////////////////////
												print('<div class="tastes_item">');
													print('<div class="tastes_title"><svg class="tastes_item_sweetness3030"><use xlink:href="#sweetness3030"/></svg>甘辛</div>');
													print('<div class="tastes_value_container">');
														print('<div class="tastes_bar_container">');
															print('<input type="range" name="sweetness" step="0.1" min="0" max="5" value="' .$tastes_values[3] .'" disabled="disabled" class="user_input_range">');
														print('</div>');
														if($tastes_values[3]) {
															print('<div class="taste_value">'. number_format($tastes_values[3], 1).'</div>');
														} else {
															print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
														}
													print('</div>');
												print('</div>');
												////////////////////////////////////////
												print('<div class="tastes_item">');
													print('<div class="tastes_title"><svg class="tastes_item_umami3030"><use xlink:href="#umami3030"/></svg>旨味</div>');
													print('<div class="tastes_value_container">');
														print('<div class="tastes_bar_container">');
															print('<input type="range" name="umami" step="0.1" min="0" max="5" value="' .$tastes_values[4] .'" disabled="disabled" class="user_input_range">');
														print('</div>');
														if($tastes_values[4]) {
															print('<div class="taste_value">'. number_format($tastes_values[4], 1).'</div>');
														} else {
															print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
														}
													print('</div>');
												print('</div>');
												////////////////////////////////////////
												print('<div class="tastes_item">');
													print('<div class="tastes_title"><svg class="tastes_item_acidity3030"><use xlink:href="#acidity3030"/></svg>酸味</div>');
													print('<div class="tastes_value_container">');
														print('<div class="tastes_bar_container">');
															print('<input type="range" name="acidity" step="0.1" min="0" max="5" value="' .$tastes_values[5] .'" disabled="disabled" class="user_input_range">');
														print('</div>');
														if($tastes_values[5]) {
															print('<div class="taste_value">'. number_format($tastes_values[5], 1).'</div>');
														} else {
															print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
														}
													print('</div>');
												print('</div>');
												////////////////////////////////////////
												print('<div class="tastes_item">');
													print('<div class="tastes_title"><svg class="tastes_item_bitter1216"><use xlink:href="#bitter1216"/></svg>ビター</div>');
													print('<div class="tastes_value_container">');
														print('<div class="tastes_bar_container">');
															print('<input type="range" name="bitter" step="0.1" min="0" max="5" value="' .$tastes_values[6] .'" disabled="disabled" class="user_input_range">');
														print('</div>');
														if($tastes_values[6]) {
															print('<div class="taste_value">'. number_format($tastes_values[6], 1).'</div>');
														} else {
															print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
														}
													print('</div>');
												print('</div>');
												////////////////////////////////////////
												print('<div class="tastes_item">');
													print('<div class="tastes_title"><svg class="tastes_item_yoin3030"><use xlink:href="#yoin3030"/></svg>余韻</div>');
													print('<div class="tastes_value_container">');
														print('<div class="tastes_bar_container">');
															print('<input type="range" name="yoin" step="0.1" min="0" max="5" value="' .$tastes_values[7] .'" disabled="disabled" class="user_input_range">');
														print('</div>');
														if($tastes_values[7]) {
															print('<div class="taste_value">'. number_format($tastes_values[7], 1).'</div>');
														} else {
															print('<div class="taste_value" style="color: #b2b2b2;">--</div>');
														}
													print('</div>');
												print('</div>');

											print('</div>');/*tastes*/
										} else {
											print('');
										}
									print('</a>');/*review*/
								}
							print("</div>"); // thread;

							////////////////////////////////////////
							////////////////////////////////////////
							print('<div class="search_result_turn_page">');

								if($p_max > 25) {

									print('<button id="prev_sake">前の'.$p_max .'件</button>');
									$i = 1;

									print('<button class="pageitems" style="background:#22445B; color:#ffffff;">' .$i .'</button>');

									for($i++; $i <= $numPage; $i++)
									{
										print('<button class="pageitems">' .$i .'</button>');
									}

									print('<button id="next_sake">次の' .$p_max .'件</button>');
								}
							print("</div>");
						}
						else {
							print('<div class="navigate_page_no_registry">レビューがまだ投稿されていません</div>');
						}

					print("</div>"); /* review */
					////////////////////////////////////////
					////////////////////////////////////////
					print('<div id="tasting" class="form-action hide">');

						print('<div class="tasting_note">');
							print('<div>テイスティングノートは飲んだ日本酒の評価をまとめておける機能です。他のユーザーと自分の評価を比較することができます。</div>');
						print('</div>');
						////////////////////////////////////////
						////////////////////////////////////////
						print('<div class="tastingnote_tab_panel">');
							print('<div class="tastingnote_chart">');
			          print('<div class="tastingnote_sort">');
								print('<div id="tastingnote_sort_all">みんな</div>');
								print('<div id="tastingnote_sort_user">あなた</div>');
			          print('</div>');

							$sql = "SELECT * FROM TABLE_NONDA WHERE sake_id = '$sake_id'";
							$res = executequery($db, $sql);

							while($record = getnextrow($res)) {
								$tastes_values = explode(',', $record["tastes"]);
								//print("<div>taste:" .$record["tastes"] ."</div>");

								if($tastes_values[0] && $tastes_values[0] != "") {
									$tastes_all[0] += $tastes_values[0];
									$count_tastes[0]++;
								}

								if($tastes_values[1] && $tastes_values[1] != "") {
									$tastes_all[1] += $tastes_values[1];
									$count_tastes[1]++;
								}

								if($tastes_values[2] && $tastes_values[2] != "") {
									$tastes_all[2] += $tastes_values[2];
									$count_tastes[2]++;
								}

								if($tastes_values[3] && $tastes_values[3] != "") {
									$tastes_all[3] += $tastes_values[3];
									$count_tastes[3]++;
								}

								if($tastes_values[4] && $tastes_values[4] != "") {
									$tastes_all[4] += $tastes_values[4];
									$count_tastes[4]++;
								}

								if($tastes_values[5] && $tastes_values[5] != "") {
									$tastes_all[5] += $tastes_values[5];
									$count_tastes[5]++;
								}

								if($tastes_values[6] && $tastes_values[6] != "") {
									$tastes_all[6] += $tastes_values[6];
									$count_tastes[6]++;
								}

								if($tastes_values[7] && $tastes_values[7] != "") {
									$tastes_all[7] += $tastes_values[7];
									$count_tastes[7]++;
								}
							}

							if($count_result > 0) {

								if($count_tastes[0] > 0)
									$tastes_all[0] = floor($tastes_all[0] / $count_tastes[0] * 100) / 100;

								if($count_tastes[1] > 0)
									$tastes_all[1] = floor($tastes_all[1] / $count_tastes[1] * 100) / 100;

								if($count_tastes[2] > 0)
									$tastes_all[2] = floor($tastes_all[2] / $count_tastes[2] * 100) / 100;

								if($count_tastes[3] > 0)
									$tastes_all[3] = floor($tastes_all[3] / $count_tastes[3] * 100) / 100;

								if($count_tastes[4] > 0)
									$tastes_all[4] = floor($tastes_all[4] / $count_tastes[4] * 100) / 100;

								if($count_tastes[5] > 0)
									$tastes_all[5] = floor($tastes_all[5] / $count_tastes[5] * 100) / 100;

								if($count_tastes[6] > 0)
									$tastes_all[6] = floor($tastes_all[6] / $count_tastes[6] * 100) / 100;

								if($count_tastes[7] > 0)
									$tastes_all[7] = floor($tastes_all[7] / $count_tastes[7] * 100) / 100;
							}

							//みんなグラフ//////////////////////////////////////
							print('<div id="tastingnote_graph_all">');
								//フレーバー//////////////////////////////////////
								print('<div class="tastingnote_tasting_box_flavor">');
									print('<div class="tastingnote_tasting_flavor_title_container">');
										print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_flavor3630"><use xlink:href="#flavor3630"/></svg></span>フレーバー</div>');
									print('</div>');

									/////////////////////////////////////////////////////////////////////////////////////
									$image_value = "";
									$flavor_name = "";

									print('<div class="tastingnote_flavor_container">');

										if(count($flavor_lookupTable1) > 0) {
											getFlavorValue($flavor_lookupTable1[0]['flavor'], $image_value, $flavor_name);

											print('<div id="tastingnote_flavor_content">');
												print('<svg><use xlink:href="#' .$image_value .'"/></svg>');
												print('<div class="tastingnote_flavor_caption">');
													print('<span>' .$flavor_name .'</span>');
												print('</div>');
												print('<div class="tastingnote_flavor_ratio">');
													$average_all = ($flavor_lookupTable1[0]['count'] / $lookupTable_count1) * 100;
													print('<span>' .number_format($average_all, 1) .'%</span>');
												print('</div>');
											print('</div>');
										}
										else {
											print('<div id="tastingnote_flavor_content">');

												print('<div class="tastingnote_flavor">');
													print('<span>1</span>');
												print('</div>');
												print('<div class="tastingnote_flavor_caption">');
													print('<span style="color: #b2b2b2;">--</span>');
												print('</div>');
												print('<div class="tastingnote_flavor_ratio">');
													print('<span style="color: #b2b2b2;">--</span>');
												print('</div>');
											print('</div>');
										}

										/////////////////////////////////////////////////////////////////////////////////////////////////////

										if(count($flavor_lookupTable2) > 0) {
											getFlavorValue($flavor_lookupTable2[0]['flavor'], $image_value, $flavor_name);

											print('<div id="tastingnote_flavor_content">');
												print('<svg><use xlink:href="#' .$image_value .'"/></svg>');
												print('<div class="tastingnote_flavor_caption">');
													print('<span>' .$flavor_name .'</span>');
												print('</div>');
												print('<div class="tastingnote_flavor_ratio">');
													$average_all = ($flavor_lookupTable2[0]['count'] / $lookupTable_count2) * 100;
													print('<span>' .number_format($average_all, 1) .'%</span>');
												print('</div>');
											print('</div>');
										}
										else {
											print('<div id="tastingnote_flavor_content">');
												print('<div class="tastingnote_flavor">');
													print('<span>2</span>');
												print('</div>');
												print('<div class="tastingnote_flavor_caption">');
													print('<span style="color: #b2b2b2;">--</span>');
												print('</div>');
												print('<div class="tastingnote_flavor_ratio">');
													print('<span style="color: #b2b2b2;">--</span>');
												print('</div>');
											print('</div>');
										}
									print('</div>');
									/////////////////////////////////////////////////////////////////////////////////////

								print('</div>');

								//香り//////////////////////////////////////
								print('<div class="tastingnote_tasting_box">');
									print('<div class="tastingnote_tasting_title_container">');
										print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_aroma2430"><use xlink:href="#aroma2430"/></svg></span>香り</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_bar_container">');
										print('<div class="tastingnote_input_range_container">');
											print('<input type="range" name="aroma" step="0.1" min="0" max="5" value="' .$tastes_all[0] .'" disabled="disabled" class="everyone_input_range">');
										print('</div>');
										print('<div class="tastingnote_tasting_caption">');
											print('<span>弱い</span>');
											print('<span>強い</span>');
										print('</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_score">');
										if($tastes_all[0]) {
											print('<span>'. number_format($tastes_all[0], 1).'</span>');
										} else {
											print('<span style="color: #b2b2b2;">--</span>');
										}
									print('</div>');
								print('</div>');

								//ボディ//////////////////////////////////////
								print('<div class="tastingnote_tasting_box">');
									print('<div class="tastingnote_tasting_title_container">');
										print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_body2430"><use xlink:href="#body2430"/></svg></span>ボディ</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_bar_container">');
										print('<div class="tastingnote_input_range_container">');
											print('<input type="range" name="body" step="0.1" min="0" max="5"  value="' .$tastes_all[1] .'" disabled="disabled" class="everyone_input_range">');
										print('</div>');
										print('<div class="tastingnote_tasting_caption">');
											print('<span>味が軽い・淡麗</span>');
											print('<span>味が重い・濃醇</span>');
										print('</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_score">');
										if($tastes_all[1]) {
											print('<span>'. number_format($tastes_all[1], 1).'</span>');
										} else {
											print('<span style="color: #b2b2b2;">--</span>');
										}
									print('</div>');
								print('</div>');

								//クリア//////////////////////////////////////
								print('<div class="tastingnote_tasting_box">');
									print('<div class="tastingnote_tasting_title_container">');
										print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_clear3030"><use xlink:href="#clear3030"/></svg></span>クリア</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_bar_container">');
										print('<div class="tastingnote_input_range_container">');
											print('<input type="range" name="clear" step="0.1" min="0" max="5" value="' .$tastes_all[2] .'" disabled="disabled" class="everyone_input_range">');
										print('</div>');
										print('<div class="tastingnote_tasting_caption">');
											print('<span>雑味がある</span>');
											print('<span>味がきれい</span>');
										print('</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_score">');
										if($tastes_all[2]) {
											print('<span>'. number_format($tastes_all[2], 1).'</span>');
										} else {
											print('<span style="color: #b2b2b2;">--</span>');
										}
									print('</div>');
								print('</div>');

								//甘辛//////////////////////////////////////
								print('<div class="tastingnote_tasting_box">');
									print('<div class="tastingnote_tasting_title_container">');
										print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_sweetness3030"><use xlink:href="#sweetness3030"/></svg></span>甘辛</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_bar_container">');
										print('<div class="tastingnote_input_range_container">');
											print('<input type="range" name="sweetness" step="0.1" min="0" max="5"  value="' .$tastes_all[3] .'" disabled="disabled" class="everyone_input_range">');
										print('</div>');
										print('<div class="tastingnote_tasting_caption">');
											print('<span>ドライ・辛口</span>');
											print('<span>スイート・甘口</span>');
										print('</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_score">');
										if($tastes_all[3]) {
											print('<span>'. number_format($tastes_all[3],1).'</span>');
										} else {
											print('<span style="color: #b2b2b2;">--</span>');
										}
									print('</div>');
								print('</div>');

								//旨味//////////////////////////////////////
								print('<div class="tastingnote_tasting_box">');
									print('<div class="tastingnote_tasting_title_container">');
										print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_umami3030"><use xlink:href="#umami3030"/></svg></span>旨味</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_bar_container">');
										print('<div class="tastingnote_input_range_container">');
											print('<input type="range" name="umami" step="0.1" min="0" max="5" value="' .$tastes_all[4] .'" disabled="disabled" class="everyone_input_range">');
										print('</div>');
										print('<div class="tastingnote_tasting_caption">');
											print('<span>弱い</span>');
											print('<span>強い</span>');
										print('</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_score">');
										if($tastes_all[4]) {
											print('<span>'. number_format($tastes_all[4], 1).'</span>');
										} else {
											print('<span style="color: #b2b2b2;">--</span>');
										}
									print('</div>');
								print('</div>');

								//酸味//////////////////////////////////////
								print('<div class="tastingnote_tasting_box">');
									print('<div class="tastingnote_tasting_title_container">');
										print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_acidity3030"><use xlink:href="#acidity3030"/></svg></span>酸味</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_bar_container">');
										print('<div class="tastingnote_input_range_container">');
											print('<input type="range" name="acidity" step="0.1" min="0" max="5" value="' .$tastes_all[5] .'" disabled="disabled" class="everyone_input_range">');
										print('</div>');
										print('<div class="tastingnote_tasting_caption">');
											print('<span>弱い</span>');
											print('<span>強い</span>');
										print('</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_score">');
										if($tastes_all[5]) {
											print('<span>'. number_format($tastes_all[5], 1).'</span>');
										} else {
											print('<span style="color: #b2b2b2;">--</span>');
										}
									print('</div>');
								print('</div>');

								//ビター//////////////////////////////////////
								print('<div class="tastingnote_tasting_box">');
									print('<div class="tastingnote_tasting_title_container">');
										print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_bitter2430"><use xlink:href="#bitter2430"/></svg></span>ビター</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_bar_container">');
										print('<div class="tastingnote_input_range_container">');
											print('<input type="range" name="bitter" step="0.1" min="0" max="5" value="' .$tastes_all[6] .'" disabled="disabled" class="everyone_input_range">');
										print('</div>');
										print('<div class="tastingnote_tasting_caption">');
											print('<span>弱い</span>');
											print('<span>強い</span>');
										print('</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_score">');
										if($tastes_all[6]) {
											print('<span>'. number_format($tastes_all[6], 1).'</span>');
										} else {
											print('<span style="color: #b2b2b2;">--</span>');
										}
									print('</div>');
								print('</div>');

								//余韻//////////////////////////////////////
								print('<div class="tastingnote_tasting_box">');
									print('<div class="tastingnote_tasting_title_container">');
										print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_yoin3030"><use xlink:href="#yoin3030"/></svg></span>余韻</div>');
									print('</div>');

									print('<div class="tastingnote_tasting_bar_container">');
										print('<div class="tastingnote_input_range_container">');
											print('<input type="range" name="yoin" step="0.1" min="0" max="5" value="' .$tastes_all[7] .'" disabled="disabled" class="everyone_input_range">');
										print('</div>');
										print('<div class="tastingnote_tasting_caption">');
											print('<span>長く続く</span>');
											print('<span>キレが良い</span>');
										print('</div>');
									print('</div>');

										print('<div class="tastingnote_tasting_score">');
											if($tastes_all[7]) {
												print('<span>'. number_format($tastes_all[7], 1).'</span>');
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}
									print('</div>');
								print('</div>');

							print('</div>');//tastingnote_graph_all
							//あなたグラフ//////////////////////////////////////
							print('<div id="tastingnote_graph_user">');
								//フレーバー//////////////////////////////////////
								print('<div class="tastingnote_tasting_box_flavor">');
									print('<div class="tastingnote_tasting_flavor_title_container">');
										print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_flavor3630"><use xlink:href="#flavor3630"/></svg></span>フレーバー</div>');
									print('</div>');

									////////////////////////////////////////////////////////////
									////////////////////////////////////////////////////////////
									$sql = "SELECT * FROM TABLE_NONDA WHERE TABLE_NONDA.sake_id='$sake_id' AND TABLE_NONDA.contributor='$username'";
									$user_res = executequery($db, $sql);
									$user_rd = getnextrow($user_res);

									if($user_rd["tastes"]) {
										$tastes_values = explode(',', $user_rd["tastes"]);
									}
									else {
										$tastes_values[0] = $tastes_values[1] = $tastes_values[2] = $tastes_values[3] = $tastes_values[4] = $tastes_values[5] = $tastes_values[6] = $tastes_values[7] = 0;
									}

									if($user_rd["flavor"])
									{
										$flavors_array = explode(',', $user_rd["flavor"]);
										$count = 0;

										print('<div class="tastingnote_flavor_container">');

											for($count = 0; $count < count($flavors_array) && $count < 2; $count++)
											{
												getFlavorValue($flavors_array[$count], $image_value, $flavor_name);

												print('<div id="tastingnote_flavor_content">');
														print('<svg><use xlink:href="#' .$image_value .'"/></svg>');

													print('<div class="tastingnote_flavor_caption">');
														print('<span>' .$flavor_name .'</span>');
													print('</div>');

												print('</div>');
											}

											for(; $count < 2; $count++)
											{
												print('<div id="tastingnote_flavor_content">');
													print('<div class="tastingnote_flavor">');
														print('<span>' .($count + 1) .'</span>');
													print('</div>');
													print('<div class="tastingnote_flavor_caption">');
														print('<span style="color: #b2b2b2;">--</span>');
													print('</div>');
													print('<div class="tastingnote_flavor_ratio">');
														/*print('<span></span>');*/
													print('</div>');
												print('</div>');
											}

										print('</div>');
									}
									else {

										print('<div class="tastingnote_flavor_container">');

											for($count = 0; $count < 2; $count++) {

												print('<div id="tastingnote_flavor_content">');
													print('<div class="tastingnote_flavor">');
														print('<span>' .($count + 1) .'</span>');
													print('</div>');
													print('<div class="tastingnote_flavor_caption">');
														print('<span style="color: #b2b2b2;">--</span>');
													print('</div>');
													print('<div class="tastingnote_flavor_ratio">');
														/*print('<span></span>');*/
													print('</div>');
												print('</div>');
											}

										print('</div>');
									}

								////////////////////////////////////////////////////////////
								////////////////////////////////////////////////////////////
								print('</div>');


			            //香り//////////////////////////////////////
			            print('<div class="tastingnote_tasting_box">');
			              print('<div class="tastingnote_tasting_title_container">');
			                print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_aroma2430"><use xlink:href="#aroma2430"/></svg></span>香り</div>');
			              print('</div>');

			              print('<div class="tastingnote_tasting_bar_container">');
								print('<div class="tastingnote_input_range_container">');
									if($tastes_values[0]) {
										print('<input type="range" name="aroma" step="0.1" min="0" max="5" value="'. $tastes_values[0].'" disabled="disabled" class="user_input_range">');
									} else {
										print('<input type="range" name="aroma" step="0.1" min="0" max="5" value="0" disabled="disabled" class="user_input_range">');
									}
												print('</div>');
								print('<div class="tastingnote_tasting_caption">');
								  print('<span>弱い</span>');
								  print('<span>強い</span>');
								print('</div>');
							  print('</div>');
							print('<div class="tastingnote_tasting_score">');
								if($tastes_values[0]) {
									print('<span>'. number_format($tastes_values[0], 1).'</span>');
								} else {
									print('<span style="color: #b2b2b2;">--</span>');
								}
							print('</div>');
			            print('</div>');

			            //ボディ//////////////////////////////////////
			            print('<div class="tastingnote_tasting_box">');
			              print('<div class="tastingnote_tasting_title_container">');
			                print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_body2430"><use xlink:href="#body2430"/></svg></span>ボディ</div>');
			              print('</div>');

			              print('<div class="tastingnote_tasting_bar_container">');
											print('<div class="tastingnote_input_range_container">');
												if($tastes_values[1]) {
													print('<input type="range" name="body" step="0.1" min="0" max="5" value="'. $tastes_values[1].'" disabled="disabled" class="user_input_range">');
												} else {
													print('<input type="range" name="body" step="0.1" min="0" max="5" value="0" disabled="disabled" class="user_input_range">');
												}
											print('</div>');
			                print('<div class="tastingnote_tasting_caption">');
			                  print('<span>味が軽い・淡麗</span>');
			                  print('<span>味が重い・濃醇</span>');
			                print('</div>');
			              print('</div>');
										print('<div class="tastingnote_tasting_score">');
											if($tastes_values[1]) {
												print('<span>'. number_format($tastes_values[1], 1).'</span>');
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}
										print('</div>');
			            print('</div>');

			            //クリア//////////////////////////////////////
			            print('<div class="tastingnote_tasting_box">');
			              print('<div class="tastingnote_tasting_title_container">');
			                print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_clear3030"><use xlink:href="#clear3030"/></svg></span>クリア</div>');
			              print('</div>');

			              print('<div class="tastingnote_tasting_bar_container">');
											print('<div class="tastingnote_input_range_container">');
												if($tastes_values[2]) {
													print('<input type="range" name="clear" step="0.1" min="0" max="5" value="'. $tastes_values[2].'" disabled="disabled" class="user_input_range">');
												} else {
													print('<input type="range" name="clear" step="0.1" min="0" max="5" value="0" disabled="disabled" class="user_input_range">');
												}
											print('</div>');
			                print('<div class="tastingnote_tasting_caption">');
			                  print('<span>雑味がある</span>');
			                  print('<span>味がきれい</span>');
			                print('</div>');
			              print('</div>');
										print('<div class="tastingnote_tasting_score">');
											if($tastes_values[2]) {
												print('<span>'. number_format($tastes_values[2], 1).'</span>');
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}
										print('</div>');
			            print('</div>');

			            //甘辛//////////////////////////////////////
			            print('<div class="tastingnote_tasting_box">');
			              print('<div class="tastingnote_tasting_title_container">');
			                print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_sweetness3030"><use xlink:href="#sweetness3030"/></svg></span>甘辛</div>');
			              print('</div>');

			              print('<div class="tastingnote_tasting_bar_container">');
											print('<div class="tastingnote_input_range_container">');
												if($tastes_values[3]) {
													print('<input type="range" name="sweetness" step="0.1" min="0" max="5" value="'. $tastes_values[3].'" disabled="disabled" class="user_input_range">');
												} else {
													print('<input type="range" name="sweetness" step="0.1" min="0" max="5" value="0" disabled="disabled" class="user_input_range">');
												}
											print('</div>');
			                print('<div class="tastingnote_tasting_caption">');
			                  print('<span>ドライ・辛口</span>');
			                  print('<span>スイート・甘口</span>');
			                print('</div>');
			              print('</div>');
										print('<div class="tastingnote_tasting_score">');
											if($tastes_values[3]) {
												print('<span>'. number_format($tastes_values[3], 1).'</span>');
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}
										print('</div>');
			            print('</div>');

			            //旨味//////////////////////////////////////
			            print('<div class="tastingnote_tasting_box">');
			              print('<div class="tastingnote_tasting_title_container">');
			                print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_umami3030"><use xlink:href="#umami3030"/></svg></span>旨味</div>');
			              print('</div>');

			              print('<div class="tastingnote_tasting_bar_container">');
											print('<div class="tastingnote_input_range_container">');
											if($tastes_values[4]) {
												print('<input type="range" name="umami" step="0.1" min="0" max="5" value="'. $tastes_values[4].'" disabled="disabled" class="user_input_range">');
											} else {
												print('<input type="range" name="umami" step="0.1" min="0" max="5" value="0" disabled="disabled" class="user_input_range">');
											}
											print('</div>');
			                print('<div class="tastingnote_tasting_caption">');
			                  print('<span>弱い</span>');
			                  print('<span>強い</span>');
			                print('</div>');
			              print('</div>');
										print('<div class="tastingnote_tasting_score">');
											if($tastes_values[4]) {
												print('<span>'. number_format($tastes_values[4], 1).'</span>');
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}
										print('</div>');
			            print('</div>');

			            //酸味//////////////////////////////////////
			            print('<div class="tastingnote_tasting_box">');
			              print('<div class="tastingnote_tasting_title_container">');
			                print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_acidity3030"><use xlink:href="#acidity3030"/></svg></span>酸味</div>');
			              print('</div>');

			              print('<div class="tastingnote_tasting_bar_container">');
											print('<div class="tastingnote_input_range_container">');
												if($tastes_values[5]) {
													print('<input type="range" name="acidity" step="0.1" min="0" max="5" value="'. $tastes_values[5].'" disabled="disabled" class="user_input_range">');
												} else {
													print('<input type="range" name="acidity" step="0.1" min="0" max="5" value="0" disabled="disabled" class="user_input_range">');
												}
											print('</div>');
			                print('<div class="tastingnote_tasting_caption">');
			                  print('<span>弱い</span>');
			                  print('<span>強い</span>');
			                print('</div>');
			              print('</div>');
										print('<div class="tastingnote_tasting_score">');
											if($tastes_values[5]) {
												print('<span>'. number_format($tastes_values[5], 1).'</span>');
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}
										print('</div>');
			            print('</div>');

			            //ビター//////////////////////////////////////
			            print('<div class="tastingnote_tasting_box">');
			              print('<div class="tastingnote_tasting_title_container">');
			                print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_bitter2430"><use xlink:href="#bitter2430"/></svg></span>ビター</div>');
			              print('</div>');

			              print('<div class="tastingnote_tasting_bar_container">');
											print('<div class="tastingnote_input_range_container">');
												if($tastes_values[6]) {
													print('<input type="range" name="bitter" step="0.1" min="0" max="5" value="'. $tastes_values[6].'" disabled="disabled" class="user_input_range">');
												} else {
													print('<input type="range" name="bitter" step="0.1" min="0" max="5" value="0" disabled="disabled" class="user_input_range">');
												}
											print('</div>');
			                print('<div class="tastingnote_tasting_caption">');
			                  print('<span>弱い</span>');
			                  print('<span>強い</span>');
			                print('</div>');
			              print('</div>');
										print('<div class="tastingnote_tasting_score">');
											if($tastes_values[6]) {
												print('<span>'. number_format($tastes_values[6], 1).'</span>');
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}
										print('</div>');
			            print('</div>');

			            //余韻//////////////////////////////////////
			            print('<div class="tastingnote_tasting_box">');
			              print('<div class="tastingnote_tasting_title_container">');
			                print('<div class="tastingnote_tasting_title"><span class="tastingnote_icon_adjust"><svg class="tastingnote_yoin3030"><use xlink:href="#yoin3030"/></svg></span>余韻</div>');
			              print('</div>');

			              print('<div class="tastingnote_tasting_bar_container">');
											print('<div class="tastingnote_input_range_container">');
												if($tastes_values[7]) {
													print('<input type="range" name="yoin" step="0.1" min="0" max="5" value="'. $tastes_values[7].'" disabled="disabled" class="user_input_range">');
												} else {
													print('<input type="range" name="yoin" step="0.1" min="0" max="5" value="0" disabled="disabled" class="user_input_range">');
												}
											print('</div>');
			                print('<div class="tastingnote_tasting_caption">');
			                  print('<span>長く続く</span>');
			                  print('<span>キレが良い</span>');
			                print('</div>');
			              print('</div>');
										print('<div class="tastingnote_tasting_score">');
											if($tastes_values[7]) {
												print('<span>'. number_format($tastes_values[7], 1).'</span>');
											} else {
												print('<span style="color: #b2b2b2;">--</span>');
											}
										print('</div>');
			            print('</div>');

			          print('</div>');//tastingnote_graph_user

			        print('</div>');//tastingnote_chart
							//フレーバーキャプション//////////////////////////////////////
							print('<div class="tastingnote_caption">');
								print('<div class="tastingnote_caption_title"><svg class="tastingnote_caption_help2020"><use xlink:href="#help2020"/></svg>フレーバーについて</div>');
								print('<div class="tastingnote_caption_invisible">');
									print('<div class="tastingnote_caption_text">フレーバーは味や香りなどから感じられる総合的な印象を表しています。日本酒の多様な風味をより具体的にイメージしていただけるように、Sakenomoではフレーバーを以下の34種類に分類しています。</div>');
									print('<div class="tastingnote_caption_content">');
										print('<div class="tastingnote_caption_content_title">フルーティタイプ</div>');
										print('<ul class="tastingnote_caption_item">');
											print('<li>青りんご</li><li>いちご</li><li>オレンジ</li><li>キウイ</li><li>グレープフルーツ</li><li>スイカ</li><li>梨</li><li>パイナップル</li><li>バナナ</li><li>ぶどう</li><li>マスカット</li><li>マンゴー</li><li>メロン</li><li>桃</li><li>洋梨</li><li>ライチ</li><li>りんご</li><li>レモン</li><li>花</li>');
										print('</ul>');

										print('<div class="tastingnote_caption_content_title">スッキリタイプ</div>');
										print('<ul class="tastingnote_caption_item">');
											print('<li>天然水・ミネラル</li><li>ソーダ水・ラムネ</li><li>ハーブ・若草・根菜</li><li>木</li>');
										print('</ul>');

										print('<div class="tastingnote_caption_content_title">コクタイプ</div>');
										print('<ul class="tastingnote_caption_item">');
											print('<li>ご飯・餅</li><li>ナッツ・豆</li><li>バター・クリーム・バニラ・チーズ</li><li>ドライフルーツ・乾物</li><li>しょうゆ・みりん</li><li>スパイス</li><li>カラメル</li><li>カカオ・ビターチョコ</li>');
										print('</ul>');

										print('<div class="tastingnote_caption_content_title">その他のタイプ</div>');
										print('<ul class="tastingnote_caption_item">');
											print('<li>セメダイン</li><li>ヨーグルト</li><li>その他</li>');
										print('</ul>');

									print('</div>');
								print('</div>');
							print('</div>');//tastingnote_caption

						print('</div>');

					print("</div>");/*tasting*/

					////////////////////////////////////////
					////////////////////////////////////////
					print('<div id="photo" class="hide">');

						print('<div class="photo_filter">');
							print('<div class="photo_filter_button_container">');
								print('<div class="photo_filter_button"><svg class="photo_filter_people1616"><use xlink:href="#people1616"/></svg><div>ユーザー</div></div>');
								/*print('<div class="photo_filter_button"><svg class="photo_filter_brewery2016"><use xlink:href="#brewery2016"/></svg><div>酒蔵</div></div>');*/
							print('</div>');
						print('</div>');

						//$sql = "SELECT COUNT(*) FROM		 SAKE_IMAGE, SAKE_J WHERE SAKE_IMAGE.sake_id = SAKE_J.sake_id AND SAKE_IMAGE.sake_id = '$sake_id'";
						$sql = "SELECT COUNT(*) FROM USERS_J, SAKE_IMAGE, SAKE_J WHERE SAKE_IMAGE.sake_id = SAKE_J.sake_id AND USERS_J.email = SAKE_IMAGE.contributor AND SAKE_IMAGE.sake_id = '$sake_id'";
						$result = executequery($db, $sql);
						$record = getnextrow($result);
						$count_result = $record["COUNT(*)"];

						if($count_result > 0) {
							print('<div class="photo_count_container">');
								$limit = 12;
								$p_max = $limit;

								//$sql = "SELECT SAKE_IMAGE.sake_id, SAKE_IMAGE.filename, SAKE_IMAGE.contributor, SAKE_IMAGE.desc, SAKE_IMAGE.added_date, sake_name FROM SAKE_IMAGE, SAKE_J WHERE SAKE_IMAGE.sake_id = SAKE_J.sake_id AND SAKE_IMAGE.sake_id = '$sake_id' ORDER BY filename"." LIMIT $limit";
								$sql = "SELECT SAKE_IMAGE.sake_id, SAKE_IMAGE.filename, USERS_J.username, SAKE_IMAGE.contributor, SAKE_IMAGE.desc, SAKE_IMAGE.added_date, sake_name FROM USERS_J, SAKE_IMAGE, SAKE_J WHERE SAKE_IMAGE.sake_id = SAKE_J.sake_id AND USERS_J.email = SAKE_IMAGE.contributor AND SAKE_IMAGE.sake_id = '$sake_id' ORDER BY filename"." LIMIT $limit";
								$result = executequery($db, $sql);

								if($count_result > $p_max) {
									$p_next = $p_max;

									if(($p_max + 25) > $count_result)
									{
										$p_next = $count_result - $p_max;
									}

									print('<span id="disp_sake" class="navigate_page">'. ($in_disp_from + 1) .'～' .$p_max .'件 / 全' .$count_result .'件</span>');
								} else {
									if($count_result < $p_max)
									{
										$p_max = $count_result;
									}

									print('<span id="disp_sake" class="navigate_page">'. ($in_disp_from + 1) .'～' .$p_max .'件 / 全' .$count_result .'件</span>');
								}

							print('</div>');

							print('<div id="photoframe" data-in_disp_from=0 data-in_disp_to=' .$limit .' data-limit=' .$limit .' data-count=' .$count_result .'>');

								while($record = getnextrow($result))
								{
									$path = "images\\photo\\".$record["filename"];
									print('<div class="sake_photo"' .' data-filename="' .$record["filename"] .'" data-contributor="' .$record["username"] .'" data-desc="' .$record["desc"] .'" data-added_date="' .gmdate("Y/m/d", $record["added_date"] + 9 * 3600) .'">');

										print('<div class="sake_photo_image_container"><img id="' .$record["filename"] .'" src="' .$path  .'"></div>');
										/*print('<img class="menu_trigger" src="images/icons/pen20.svg">');*/
										/*print('<ul>');
											print('<li id="' .$record["filename"] .'" filename = "' .$record["filename"] .'">削除</li>');
											print('<li id="' .$record["filename"] .'" filename = "' .$record["filename"] .'">プロフィール写真にする</li>');
										print('</ul>');*/
										/*print('<span>' .$record["filename"] .'</span>');*/
										print('<span>' .$record["username"] .'</span>');
									print("</div>"); /*sake_photo*/
								}
							print("</div>");

							////////////////////////////////////////
							////////////////////////////////////////
							print('<div class="search_result_turn_page">');

							if($count_result > $limit) {
									$i = 0;
									$numPage = ceil($count_result / $limit);

									print('<button id="prev_photo">前の'.$p_max .'件</button>');

									print('<button class="pageitems" style="background:#22445B; color:#ffffff;">' .($i + 1) .'</button>');

									for($i++; $i < $numPage; $i++)
									{
										print('<button class="pageitems">' .($i + 1) .'</button>');
									}

									print('<button id="next_photo" class="active">次の' .$p_max .'件</button>');
							}

							print("</div>");
						}
						else {
							print('<div class="navigate_page_no_registry">写真がまだ投稿されていません</div>');
						}

					print("</div>");/* photo */

				print("</div>"); //tab_main
				////////////////////////////////////////
				////////////////////////////////////////

				print('<div class="edit_sake_bar_container">');
					print('<div class="edit_sake_bar">');
						if($_COOKIE['login_cookie'] != "")
						{
							print('<a id="edit_sake" sakagura_id="' .$row["sakagura_id"] .'"><svg class="edit_sake_penplus2020"><use xlink:href="#penplus2020"/></svg>この日本酒の情報を編集する</a>');
							print('<a id="add_sake" sakagura_id="' .$row["sakagura_id"] .'"><svg class="add_sake_pen1616"><use xlink:href="#pen1616"/></svg>新しい日本酒を登録する</a>');
						} else {
							print('<a class="edit_sake" href="user_login_form.php"><svg class="edit_sake_penplus2020"><use xlink:href="#penplus2020"/></svg>この日本酒の情報を編集する</a>');
							print('<a class="add_sake" href="user_login_form.php"><svg class="add_sake_pen1616"><use xlink:href="#pen1616"/></svg>新しい日本酒を登録する</a>');
						}
					print("</div>");
				print('</div>');

				////////////////////////////////////////
				////////////////////////////////////////
				print('<div id="sake_spec">');
					print('<div><svg class="detail2430"><use xlink:href="#detail2430"/></svg>詳細情報</div>');

					/* 詳細項目 */
					print('<div class="edittable">');

						/* 日本酒名 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">日本酒名</div><div class="sakecolumn2" id="detail_sake_name">'.stripslashes($row["sake_name"]).'</div>');
						print('</div>');

						/* 酒蔵 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">酒蔵</div><div class="sakecolumn2" id="detail_sakagura_name">'.stripslashes($row["sakagura_name"]).'</div>');
						print('</div>');

						/* 住所 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">住所</div>');
							print('<div class="sakecolumn2" id="detail_sakagura_address">');
								if($row["pref"] || $row["adress"]) {
									print($row["pref"].stripslashes($row["address"]));
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* 醸造年度 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">醸造年度・Brewery Year(BY)</div>');
							print('<div class="sakecolumn2" id="Brewery Year">');
								if($row["year_made"]) {
									print($row["year_made"] .'年');
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* 特定名称 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">特定名称</div>');
							print('<div class="sakecolumn2" id="special_name_spec">');
								if($row["special_name"]) {
									if($special_name_array[0] == "90") {
										print($special_name_array[1]);
									} else {
										print(GetSakeSpecialName($row["special_name"]));
									}
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* Alc度数 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">Alc度数</div>');
							print('<div class="sakecolumn2" id="detail_alcohol_level">');
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
							print('</div>');
						print('</div>');

						/*原材料*/
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">原材料</div>');
							print('<div class="sakecolumn2" id="ingredients">');
								if($row["ingredients"]) {
									for($j = 0; $j < count($ingredients_array); $j++)
									{
										if($ingredients_array[$j] == "90")
										{
											print($ingredients_array[$j + 1]);
											$j++;
										}
										else
										{
											print(GetIngredient($ingredients_array[$j]));
										}

										if($j < (count($ingredients_array) - 1))
										print(" / ");
									}
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* 原料米 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">原料米</div>');
							print('<div class="sakecolumn2" id="rice_used2">');
								if($row["rice_used"]) {
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
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* 精米歩合 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">精米歩合</div>');
							print('<div class="sakecolumn2" id="rice_cleaned_rate">');
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

										if($seimai_array[$i] != "") {
											print($seimai_array[$i]."%");
										}
									}
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* 日本酒度 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">日本酒度</div>');
							print('<div class="sakecolumn2" id="nihonshu_level">');
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
							print('</div>');
						print('</div>');

						/* 酸度 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">酸度</div>');
							print('<div class="sakecolumn2" id="acidity_level">');
								if($oxidation_array[0] != null && $oxidation_array[1] != null) {
									if($oxidation_array[0] == $oxidation_array[1]) {
										print(number_format($oxidation_array[0], 1));
									} else {
										print(number_format($oxidation_array[0], 1).'～'.number_format($oxidation_array[1], 1));
									}
								} else if($oxidation_array[0] != null && $oxidation_array[1] == null) {
									print(number_format($oxidation_array[0], 1));
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* アミノ酸度 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">アミノ酸度</div>');
							print('<div class="sakecolumn2" id="aminosan_level">');
								if($amino_array[0] != null && $amino_array[1] != null) {
									if($amino_array[0] == $amino_array[1]) {
										print(number_format($amino_array[0], 1));
									} else {
										print(number_format($amino_array[0], 1).'～'.number_format($amino_array[1], 1));
									}
								} else if($amino_array[0] != null && $amino_array[1] == null) {
									print(number_format($amino_array[0], 1));
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* 酵母 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">酵母</div>');
							print('<div class="sakecolumn2" id="koubo_used">');
								if($row["koubo_used"]) {
									for($j = 0; $j < count($koubo_array); $j++)
									{
										if($koubo_array[$j] == "90" || $koubo_array[$j] == "91" || $koubo_array[$j] == "92")
										{
											print($koubo_array[$j + 1]);
											$j++;
										}
										else
										{
											 print(GetSakeKoubo($koubo_array[$j]));
										}

										if($j < (count($koubo_array) - 1))
											print(" / ");
									}
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* 製法の特徴 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">製法の特徴</div>');
							print('<div class="sakecolumn2" id="sake_category_spec">');
								if($row["sake_category"]) {
									for($j = 0; $j < count($category_array); $j++)
									{
										print(GetSakeCategory($category_array[$j]));

										if($j < (count($category_array) - 1))
											print(" / ");
									}
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* 鑑評会・コンクール */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">鑑評会・コンクール</div>');
							print('<div class="sakecolumn2" id="detail_concour">');
								if(count($award_array) > 0 && $award_array[0])
								{
									for($j = 0; $j < count($award_array); $j++)
									{
										$award = explode(',', $award_array[$j]);
										print(GetAward($award[0]));

											if($award[1] != "")
												print(" (".$award[1].") ");

											print(GetAwardRank($award[0], $award[2]));

											if($j < (count($award_array) - 1))
												print(" / ");
									}
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* おすすめの飲み方 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">おすすめの飲み方</div>');
							print('<div class="sakecolumn2" id="recommended_drink">');

								if($row["recommended_drink"] && $row["recommended_drink"] != undefined)
								{
									$drink_array = explode(',', $row["recommended_drink"]);
									$i;

									for($i = 0; $i < count($drink_array); $i++)
									{
										//print($drink_array[$i]);
										print(GetRecommendedDrink($drink_array[$i]));

										if($i < (count($drink_array) - 1))
											print(" / ");

										/*if($i < count($drink_array))
											print(', ');*/
									}
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* 内容量・価格 */
						/*print('<div class="sakerow">');
							print('<div class="sakecolumn1">内容量・価格</div>');
							print('<div class="sakecolumn2" id="volume">');

								if($row["volume_180"] == 1)
								print("180ml/" .$row["price_180"] ."円 ");

								if($row["volume_300"] == 1)
								print("300ml/" .$row["price_300"] ."円 ");

								if($row["volume_720"] == 1)
								print("720ml/" .$row["price_720"] ."円 ");

								if($row["volume_1800"] == 1)
								print("1800ml/" .$row["price_1800"] ."円 ");

								if($xml)
								{
									//print("<ul>");
									//foreach ($xml->item as $data) {
									//    print("<li>".$data->size_other. "ml: " .$data->price_other."円</li>");
									//}

									$volume_count = $xml->count();

									if($volume_count > 0 && $xml->item[0]->other_size1 != "")
									print("その他1: ".$xml->item[0]->other_size1 . "ml: " .$xml->item[0]->other_price1.'円  ');

									if($volume_count > 1 && $xml->item[1]->other_size2 != "")
									print("その他2: ".$xml->item[1]->other_size2 . "ml: " .$xml->item[1]->other_price2.'円  ');

									if($volume_count > 2 && $xml->item[2]->other_size3 != "")
									print("その他3: ".$xml->item[2]->other_size3 . "ml: " .$xml->item[2]->other_price3.'円  ');

									if($volume_count > 3 && $xml->item[3]->other_size4 != "")
									print("その他4: ".$xml->item[3]->other_size4 . "ml: " .$xml->item[3]->other_price4.'円  ');

									//print("</ul>");
								}
							print('</div>');
						print('</div>');*/

						/* JANコード */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">JANコード</div>');
							print('<div class="sakecolumn2" id="jas_code">');

								if($row["jas"]) {
									$jas_array = explode(',', $row["jas"]);
									$jas_string = "";
									$bFound = false;

									for($i = 0; $i < count($jas_array); $i++) {

										if($jas_array[$i]) {

											if($i > 0 && $jas_string)
												print(" / ");

											$jas_string = str_replace(' ', '', $jas_array[$i]);

											if($jas_string) {
												print($jas_string);
												$bFound = true;
											}
										}
									}

									if(!$bFound) {
										print('--');
									}
								} else {
									print('<span style="color: #b2b2b2;">--<span>');
								}
							print('</div>');
						print('</div>');

						/* 酒ID */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">酒ID</div><div class="sakecolumn2" id="sake_id">' .$row["sake_id"] .'</div>');
						print('</div>');

						/* 開発状況 */
						print('<div class="sakerow">');
							print('<div class="sakecolumn1">開発状況</div><div class="sakecolumn2" id="status">');

								if($row["develop"] == 1)
								{
									print('<span id="status">完成</span>');
								}
								else if($row["develop"] == 2)
								{
									print('<span id="status">途中</span>');
								}
								else
								{
									print('<span id="status">未完成</span>');
								}
							print('</div>');
						print('</div>');

						/* メモ */
						$row["sake_memo"] = nl2br($row["sake_memo"]);
						$row["sake_memo"] = stripslashes($row["sake_memo"]);

						print('<div class="sakerow">');
							print('<div class="sakecolumn1">メモ</div><div class="sakecolumn2" id="sake_memo">' .$row["sake_memo"] .'</div>');
						print('</div>');

					print('</div>'); /*edittable*/
				print('</div>');/*sake_spec*/
				////////////////////////////////////////
				////////////////////////////////////////
				$i = 0;
				$sakagura_id = $row["sakagura_id"];
				$result = executequery($db, "SELECT * FROM SAKE_J, SAKAGURA_J WHERE sakagura_id = id AND sakagura_id = '$sakagura_id'");
				////////////////////////////////////////
				////////////////////////////////////////
			print("</div>"); /*saketable*/
			////////////////////////////////////////
			////////////////////////////////////////
			// advertisement
			print('<div id="banner_frame">');

				$path = "images/icons/notice_banner.svg";
				print('<div id="ad1"><img src="images/icons/notice_banner.svg"></div>');

				/*非表示中*/
				/*print('<div class="sake_list">');
					print('<div><svg class="sake_list_samebrewery3630"><use xlink:href="#samebrewery3630"/></svg>同じ酒蔵の日本酒</div>');
					write_sake_list($db, $result);
				print("</div>");*/

				print('<div class="recommend_sake">');
					print('<div><svg class="top_recommend3630"><use xlink:href="#recommend3630"/></svg>おすすめの日本酒</div>');

					$sql = "SELECT SAKE_J.sake_id as sake_id, sake_name, sakagura_name, pref, filename FROM SAKE_J, SAKAGURA_J, SAKE_IMAGE WHERE SAKE_J.sakagura_id = SAKAGURA_J.id AND SAKE_J.sake_id = SAKE_IMAGE.sake_id ORDER BY RANDOM() LIMIT 8";
					$res = executequery($db, $sql);
					write_sake_list($db, $res);

				print("</div>");

				/*一時的に非表示write_sakagura($db);*/

			print('</div>');/*banner_frame*/
			////////////////////////////////////////
			////////////////////////////////////////
		print('</div>');/*saketable_banner_container*/
		////////////////////////////////////////
		////////////////////////////////////////
	print("</div>");/*container*/


// print('<input style="height: 0px" type="file" id="fileID">

print('<!-- dialog_preview -->');
print('<div id="dialog_preview">');
	print('<div class="dialog_preview_position_adjust">');
		print('<div class="dialog_preview_date_close_container">');
			print('<div class="dialog_preview_date"></div>');
			print('<button id="close_preview_button"><svg class="close_preview_close2020"><use xlink:href="#close2020"/></svg></button>');
		print('</div>');

		print('<div id="dialog_preview_image_container">');
			print('<img src="" id="preview_image">');
		print('</div>');

		print('<div class="dialog_preview_container2">');
			print('<a href="" class="dialog_preview_user_name"></a>');
			print('<div class="dialog_preview_caption"></div>');
		print('</div>');

		print('<!--<div id="dialog_preview_filename"></div>-->');
		print('<!--<input type="button" id="edit_preview_close" value="閉じる">-->');
	print('</div>');
print('</div>');

writefooter();
?>

<script type="text/javascript">

var xmltext = <?php echo json_encode($xmltext); ?>;

function getOrientation(imgDataURL)
{
	var byteString = atob(imgDataURL.split(',')[1]);
	var orientaion = byteStringToOrientation(byteString);
	return orientaion;

	function byteStringToOrientation(img)
	{
		var head = 0;
		var orientation;

		while(1)
		{
			if(img.charCodeAt(head) == 255 & img.charCodeAt(head + 1) == 218)
			{
				break;
			}
			if(img.charCodeAt(head) == 255 & img.charCodeAt(head + 1) == 216)
			{
				head += 2;
			}
			else
			{
				var length = img.charCodeAt(head + 2) * 256 + img.charCodeAt(head + 3);
				var endPoint = head + length + 2;

				if(img.charCodeAt(head) == 255 & img.charCodeAt(head + 1) == 225)
				{
					var segment = img.slice(head, endPoint);
					var bigEndian = segment.charCodeAt(10) == 77;
					var count;

					if(bigEndian)
					{
						count = segment.charCodeAt(18) * 256 + segment.charCodeAt(19);
					}
					else
					{
						count = segment.charCodeAt(18) + segment.charCodeAt(19) * 256;
					}

					for (i = 0; i < count; i++)
					{
						var field = segment.slice(20 + 12 * i, 32 + 12 * i);

						if((bigEndian && field.charCodeAt(1) == 18) || (!bigEndian && field.charCodeAt(0) == 18))
						{
							orientation = bigEndian ? field.charCodeAt(9) : field.charCodeAt(8);
						}
					}
					break;
				}

				head = endPoint;
			}

			if(head > img.length)
			{
				break;
			}
		}

		return orientation;
	}
}

function nl2br(str, is_xhtml) {
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

	return (str + '')
	.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function GetSakeSpecialName(sake_code)
{
	var special_name = "";

	if(sake_code == "11")
	{
		special_name = "普通酒";
	}
	else if(sake_code == "21")
	{
		special_name = "本醸造酒";
	}
	else if(sake_code == "22")
	{
		special_name = "特別本醸造酒";
	}
	else if(sake_code == "31")
	{
		special_name = "純米酒";
	}
	else if(sake_code == "32")
	{
		special_name = "特別純米酒";
	}
	else if(sake_code == "33")
	{
		special_name = "純米吟醸酒";
	}
	else if(sake_code == "34")
	{
		special_name = "純米大吟醸酒";
	}
	else if(sake_code == "43")
	{
		special_name = "吟醸酒";
	}
	else if(sake_code == "44")
	{
		special_name = "大吟醸酒";
	}
	else if($sake_code == "45")
	{
		special_name = "非公開";
	}
	else if(sake_code == "90")
	{
		special_name = "その他";
	}
	else if(sake_code == "99")
	{
		special_name = "";
	}
	else
	{
		special_name = "";
	}

	return special_name;
}

function GetFlavorNames(flavors)
{
	var flavor_array = flavors.split(',');
	var ret_value = "";
	var item = "";
	var i = 0;

	for(i = 0; i < flavor_array.length; i++)
	{
		if(flavor_array[i] == 1)
			item = "フルーツ系";
		else if(flavor_array[i] == 2)
			item = "ハーブ・草葉系";
		else if(flavor_array[i] == 3)
			item = "木系";
		else if(flavor_array[i] == 4)
			item = "プレーン系";
		else if(flavor_array[i] == 5)
			item = "米・穀物系";
		else if(flavor_array[i] == 6)
			item = "ナッツ・木の実系";
		else if(flavor_array[i] == 7)
			item = "乳製品系";
		else if(flavor_array[i] == 8)
			item = "熟成系";
		else if(flavor_array[i] == 9)
			item = "その他";

		if(ret_value == "")
		{
			ret_value = item;
		}
		else
		{
			ret_value += '/' + item;
		}
	}

	return ret_value;
}



/*slick***************************************/
$(function(){
	var slider = "#preview_main_container"; // スライダー
	var thumbnailItem = "#preview_thumbnail_container .sakeimage_thumbnail"; // サムネイル画像アイテム

	// サムネイル画像アイテムに data-index でindex番号を付与
	$(thumbnailItem).each(function(){
		var index = $(thumbnailItem).index(this);
		$(this).attr("data-index",index);
	});

	// スライダー初期化後、カレントのサムネイル画像にクラス「thumbnail-current」を付ける
	// 「slickスライダー作成」の前にこの記述は書いてください。
	$(slider).on('init',function(slick){
		var index = $(".sakeimage.slick-slide.slick-current").attr("data-slick-index");
		$(thumbnailItem+'[data-index="'+index+'"]').addClass("thumbnail-current");
	});

	//slickスライダー初期化
	$(slider).slick({
		autoplay: false,
		arrows: false,
		fade: true,
		infinite: false
	});

	//サムネイル画像アイテムをクリックしたときにスライダー切り替え
	$(thumbnailItem).on('click',function(){
		var index = $(this).attr("data-index");
		$(slider).slick("slickGoTo",index,false);
	});

	$('.simpleTabs li:nth(0)').click(function() {
		$(slider).slick('setPosition');
		$(slider).animate({'z-index':1}, 100, function(){
			$(slider).slick('setPosition');
			// $(slider).animate({'opacity':1});
		});
	});

	//サムネイル画像のカレントを切り替え
	$(slider).on('beforeChange',function(event,slick, currentSlide,nextSlide){
		$(thumbnailItem).each(function(){
		  $(this).removeClass("thumbnail-current");
		});
		$(thumbnailItem+'[data-index="'+nextSlide+'"]').addClass("thumbnail-current");
	});
});

$(function() {

	$('.multiple-sake').slick({
	infinite: true,
	centerMode: true,
	centerPadding: '0px',
	slidesToShow: 2,
		swipeToSlide: true,

	responsive: [{
		  breakpoint: 1260, settings: {
			centerMode: true,
			centerPadding: '100px',
			slidesToShow: 6,}
		  },
		  {
		  breakpoint: 1200, settings: {
			centerMode: true,
			centerPadding: '70px',
			slidesToShow: 6,}
		  },
		  {
		  breakpoint: 1140, settings: {
			centerMode: true,
			centerPadding: '40px',
			slidesToShow: 6,}
		  },
		  {
		  breakpoint: 1080, settings: {
			centerMode: true,
			centerPadding: '15px',
			slidesToShow: 6,}
		  },
		  {
		  breakpoint: 1020, settings: {
			centerMode: true,
			centerPadding: '145px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 960, settings: {
			centerMode: true,
			centerPadding: '110px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 900, settings: {
			centerMode: true,
			centerPadding: '85px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 840, settings: {
			centerMode: true,
			centerPadding: '60px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 780, settings: {
			centerMode: true,
			centerPadding: '30px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 720, settings: {
			centerMode: true,
			centerPadding: '0px',
			slidesToShow: 4,}
		  },
		  {
		  breakpoint: 660, settings: {
			centerMode: true,
			centerPadding: '130px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 600, settings: {
			centerMode: true,
			centerPadding: '100px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 540, settings: {
			centerMode: true,
			centerPadding: '70px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 480, settings: {
			centerMode: true,
			centerPadding: '55px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 447, settings: {
			centerMode: true,
			centerPadding: '40px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 415, settings: {
			centerMode: true,
			centerPadding: '34px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 401, settings: {
			centerMode: true,
			centerPadding: '24px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 376, settings: {
			centerMode: true,
			centerPadding: '18px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 370, settings: {
			centerMode: false,
			slidesToShow: 2,}
		  }
		]
	});

	$('.multiple-brewery, .multiple-restaurant, .multiple-store, .multiple-item').slick({
		centerMode: true,
		centerPadding: '0px',
		slidesToShow: 1,
		swipeToSlide: true,

		responsive: [{
		  breakpoint: 1260, settings: {
			centerMode: true,
			centerPadding: '100px',
			slidesToShow: 3,}
		  },
		  {
		  breakpoint: 1200, settings: {
			centerMode: true,
			centerPadding: '70px',
			slidesToShow: 3,}
		  },
		  {
		  breakpoint: 1140, settings: {
			centerMode: true,
			centerPadding: '40px',
			slidesToShow: 3,}
		  },
		  {
		  breakpoint: 1080, settings: {
			centerMode: true,
			centerPadding: '15px',
			slidesToShow: 3,}
		  },
		  {
		  breakpoint: 1020, settings: {
			centerMode: true,
			centerPadding: '145px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 960, settings: {
			centerMode: true,
			centerPadding: '110px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 900, settings: {
			centerMode: true,
			centerPadding: '85px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 840, settings: {
			centerMode: true,
			centerPadding: '60px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 780, settings: {
			centerMode: true,
			centerPadding: '30px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 720, settings: {
			centerMode: true,
			centerPadding: '0px',
			slidesToShow: 2,}
		  },
		  {
		  breakpoint: 660, settings: {
			centerMode: true,
			centerPadding: '130px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 600, settings: {
			centerMode: true,
			centerPadding: '100px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 540, settings: {
			centerMode: true,
			centerPadding: '70px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 480, settings: {
			centerMode: true,
			centerPadding: '55px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 447, settings: {
			centerMode: true,
			centerPadding: '40px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 415, settings: {
			centerMode: true,
			centerPadding: '34px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 401, settings: {
			centerMode: true,
			centerPadding: '24px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 376, settings: {
			centerMode: true,
			centerPadding: '18px',
			slidesToShow: 1,}
		  },
		  {
		  breakpoint: 370, settings: {
			centerMode: false,
			slidesToShow: 1,}
		  }
		]
	});
});

////////////////////////////////////////
////////////////////////////////////////
(function($, window) {
	$.fn.replaceOptions = function(options) {
		var self, $option;

		this.empty();
		self = this;

		$.each(options, function(index, option) {
			$option = $("<option></option>")
			.attr("value", option.value)
			.text(option.text);
			self.append($option);
		});
	};
})(jQuery, window);

//ノートタブ内 テイスティングソート
$(function() {
	'use strict';
	var isA = 0; // 現在地判定
	var btnA = document.getElementById('tastingnote_sort_all');
	var btnB = document.getElementById('tastingnote_sort_user');
	var divA = document.getElementById('tastingnote_graph_all');
	var divB = document.getElementById('tastingnote_graph_user');

	function setState(isA) {
		btnA.className = (isA == 0) ? 'btn inactive' : 'btn'; // Aのとき非表示
		divA.className = (isA == 0) ? 'boxDisplay' : 'boxNone'; // Aのとき表示
		btnB.className = (isA == 1) ? 'btn inactive' : 'btn'; // Bのとき非表示
		divB.className = (isA == 1) ? 'boxDisplay' : 'boxNone'; // Bのとき表示
	}

	setState(0);

	btnA.addEventListener('click', function(){
		if(isA == 0) return;
		isA = 0;
		setState(0);
	});

	btnB.addEventListener('click', function(){
		if (isA == 1) return;
		isA = 1;
		setState(1);
	});

	$('#tastingnote_sort_all').click(function() {
		$('.tastingnote_sort div').css({"border": "2px solid #d2d2d2","color": "#8c8c8c"});
		$(this).css({"border": "2px solid #A0C846","color": "#000000"});
	});

	$('#tastingnote_sort_user').click(function() {
		$('.tastingnote_sort div').css({"border": "2px solid #d2d2d2","color": "#8c8c8c"});
		$(this).css({"border": "2px solid #009696","color": "#000000"});
	});

	/*テイスティングソートキャプション*/
	$(document).on('click', '.tastingnote_caption', function(e){
		$('.tastingnote_caption_invisible').slideToggle();
	});
});

$(function() {

	var in_disp_from = 0;
	var in_disp_to = 1;
	var count_query = 1;
	var sake_id = <?php echo json_encode($sake_id); ?>;
	var count_nonda = <?php echo json_encode($count_nonda); ?>;

	function searchNonda(in_disp_from, in_disp_to, data, bCount)
	{
		$.ajax({
			type: "POST",
			url: "nonda_list.php",
			data: data,
			dataType: 'json',

		}).done(function(data){

			var count_result = data[0].count;
			var sake = data[0].result;
			var nonda_values = 0;

			if(count_result > 0)
			{
				//alert("succeed:" + data.length + " count:" + data[0].count + " sake_name:" + sake[0].sake_name + " username:" + sake[0].username);
				//alert("username:" + $(this).attr('username'));
				//alert("sake:" + sake[0].path);
				//alert("sql:" + sake[0].sql);

				////////////////////////////////////////
				////////////////////////////////////////

				var innerHTML = $('#nonda_sake_image > div:last-child')[0].outerHTML;
				var image_paths = sake[0].path;
				var count = 1;
				var i = 0;

				//alert("username:" + $(this).attr('username'));

				$('#nonda_sake_image').empty();
				$('#dialog_nonda_username').text(sake[0].username);
				$('#dialog_nonda_title').text(sake[0].subject);
				$('#dialog_nonda_message').text(sake[0].message);

				/*
				$('#dialog_nonda_userinfo img').attr("src", sake[0].userpath);
				$('#dialog_nonda_user_addr').attr("src", sake[0].user_addr);
				*/

				var rankHTML = "";
				var rank_value = parseInt(sake[0].sake_rank);

				for(i = 0; i < rank_value && i < 5; i++)
				{
					rankHTML += '<svg  version="1.1" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;" ';
					rankHTML += 'width="20" height="18" viewBox="-0.758 -0.272 21 21" enable-background="new -0.758 -0.272 21 21" xml:space="preserve">';
					rankHTML += '<polygon fill="#D55319" points="0,7.64 5,12.763 3.82,20 6,18.794 6,6.722 "/>'
					rankHTML += '<polygon fill="#D55319" points="10,0 6.91,6.583 6,6.722 6,18.794 10,16.583 "/>'
					rankHTML += '<polygon fill="#D55319" points="13.088,6.583 10,0 10,16.583 14,18.794 14,6.723 "/>'
					rankHTML += '<polygon fill="#D55319" points="15,12.763 20,7.64 14,6.723 14,18.794 16.178,20 "/>'
					rankHTML += '</svg>';
				}

				for(; i < 5; i++)
				{
					rankHTML += '<svg  version="1.1" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;" ';
					rankHTML += 'width="20" height="18" viewBox="-0.046 -0.845 21 21" enable-background="new -0.046 -0.845 21 21" xml:space="preserve">';
					rankHTML += '<polygon fill="#B1B0B1" points="0,7.64 5,12.763 3.82,20 6,18.794 6,6.722 "/>';
					rankHTML += '<polygon fill="#B1B1B2" points="10,0 6.91,6.583 6,6.722 6,18.794 10,16.583 "/>';
					rankHTML += '<polygon fill="#B1B1B2" points="13.088,6.583 10,0 10,16.583 14,18.794 14,6.723 "/>';
					rankHTML += '<polygon fill="#B1B1B2" points="15,12.763 20,7.64 14,6.723 14,18.794 16.178,20 "/>';
					rankHTML += '</svg>';
				}

				$('#dialog_nonda_rank').html(rankHTML);

				if(image_paths)
				{
					var pathArray = image_paths.split(',');

					for(i = 0; i < pathArray.length; i++)
					{
						$('#nonda_sake_image').append(innerHTML);
						var path = "images\\photo\\" + pathArray[i];
						var imageObj = $('#nonda_sake_image div:last img');

						$(imageObj).attr("src", path);
						$('#nonda_sake_image div:last-child').attr("path", pathArray[i]);
					}
				}
				else
				{
					$('#nonda_sake_image').append(innerHTML);
				}

				var tastes = sake[0].tastes;

				if(tastes)
				{
					var nomitai_values = tastes.split(',');

					$('#tabs_nonda_2 .graph .tasting_box').each(function(index) {
						var width = Math.floor((nomitai_values[index] / 5) * 100) + "%";
						//alert("width:" + width);


						$(this).find('.horizontal_bar').animate({"width": width}, 500);
						//$(this).find('div:first-child').text(nomitai_values[i++]);
					});
				}

				////////////////////////////////////////
				////////////////////////////////////////
				$('#dialog_nonda_username').text(sake[0].username);
				$('#dialog_nonda_title').text(sake[0].subject);
				$('#dialog_nonda_message').text(sake[0].message);
			}

		}).fail(function(data){
			alert("Failed:" + data);
		}).complete(function(data){
			//removeLoading();
		});
	}

	$('.dialog_nonda_next button:first-child').click(function() {

		if(in_disp_from > 0)
		{
			//alert("in_disp_from:" + in_disp_from + " count_nonda:" + count_nonda);
			in_disp_from--;

			var data = "sake_id="+sake_id+"&in_disp_from="+in_disp_from+"&in_disp_to="+in_disp_to+"&count_query="+count_query;
			searchNonda(in_disp_from, in_disp_to, data, true);
		}
	});

	$('.dialog_nonda_next button:last-child').click(function() {

		if(in_disp_from < count_nonda - 1)
		{
			//alert("in_disp_from:" + in_disp_from + " count_nonda:" + count_nonda);
			in_disp_from++;

			var data = "sake_id="+sake_id+"&in_disp_from="+in_disp_from+"&in_disp_to="+in_disp_to+"&count_query="+count_query;
			searchNonda(in_disp_from, in_disp_to, data, true);
		}
	});

    $("body").on( "nonda_message", function( event, id, username, update_date) {
		var data = "sake_id="+sake_id+"&username="+username+"&update_date="+update_date+"&in_disp_from="+in_disp_from+"&in_disp_to="+in_disp_to+"&count_query="+count_query;
		//alert("data:" + data + " in_disp_form:" + in_disp_from + " in_disp_to:" + in_disp_to);
		//alert("nonda_message:" + sake_id + " username:" + username);
		searchNonda(in_disp_from, in_disp_to, data, true);
	});


	$("body").on("nonda_saved", function(event, sake_id, contributor, write_date, committed, title, ranke, message, imagepath, tastes, flavor) {
		//window.open('sake_view.php?sake_id=' + sake_id, '_self');
		location.reload();
	});

	$("body").on("nonda_deleted", function(event, sake_id) {
		//window.open('sake_view.php?sake_id=' + sake_id, '_self');
		location.reload();
	});
});

$(function() {

	$('.tasting_sort2 div:nth(1)').click(function() {

		$('.tasting_sort2 div').css({"color":""});
		$('.tasting_sort2 div').css({"backgroundColor":""});

		$(this).css({"color":"#fff"});
		$(this).css({"backgroundColor":"#22445B"});

		//alert("tasting note2");
		$("#tasting .graph:nth(1) .tasting_bar div").removeClass("horizontal_bar");
		$("#tasting .graph:nth(1) .tasting_bar div").addClass("everyone_bar");

		$('#tasting .graph:nth(0) .tasting_bar div').each(function(index) {
			//$('.graph .tasting_bar').animate({ backgroundColor: '#6ACC8B', color: '#000'}, 'slow').animate({backgroundColor: '#FFF', color: '#000'}, 'slow');
			$("#tasting .graph:nth(1) .tasting_bar div:nth(" + index + ")").animate( { width: $(this).css("width") }, 500);
		});
	});

	$('.tasting_sort2 div:nth(0)').click(function() {

		var tastesArray = $('#tasting .graph:nth(1)').attr("tastes").split(',');
		var kaori	= parseFloat(tastesArray[0]);
		var body	= parseFloat(tastesArray[1]);
		var clear	= parseFloat(tastesArray[2]);
		var amakara = parseFloat(tastesArray[3]);
		var umami	= parseFloat(tastesArray[4]);
		var sanmi	= parseFloat(tastesArray[5]);
		var bitter	= parseFloat(tastesArray[6]);
		var yoin	= parseFloat(tastesArray[7]);

		var kaori_percent	= ((kaori / 5) * 100) + "%";
		var body_percent	= ((body / 5) * 100) + "%";
		var clear_percent	= ((clear / 5) * 100) + "%";
		var amakara_percent = ((amakara / 5) * 100) + "%";
		var umami_percent	= ((umami / 5) * 100) + "%";
		var sanmi_percent	= ((sanmi / 5) * 100) + "%";
		var bitter_percent	= ((bitter / 5) * 100) + "%";
		var yoin_percent	= ((yoin / 5) * 100) + "%";

		$('.tasting_sort2 div').css({"color":""});
		$('.tasting_sort2 div').css({"backgroundColor":""});

		$(this).css({"color":"#fff"});
		$(this).css({"backgroundColor":"#22445B"});

		$("#tasting .graph:nth(1) .tasting_bar div").removeClass("everyone_bar");
		$("#tasting .graph:nth(1) .tasting_bar div").addClass("horizontal_bar");

		$("#tasting .graph:nth(1) .tasting_bar div:nth(0)").animate( { width: kaori_percent }, 500);
		$("#tasting .graph:nth(1) .tasting_bar div:nth(1)").animate( { width: body_percent }, 500);
		$("#tasting .graph:nth(1) .tasting_bar div:nth(2)").animate( { width: clear_percent }, 500);
		$("#tasting .graph:nth(1) .tasting_bar div:nth(3)").animate( { width: amakara_percent }, 500);
		$("#tasting .graph:nth(1) .tasting_bar div:nth(4)").animate( { width: umami_percent }, 500);
		$("#tasting .graph:nth(1) .tasting_bar div:nth(5)").animate( { width: sanmi_percent }, 500);
		$("#tasting .graph:nth(1) .tasting_bar div:nth(6)").animate( { width: bitter_percent }, 500);
		$("#tasting .graph:nth(1) .tasting_bar div:nth(7)").animate( { width: yoin_percent }, 500);
	});
});

$(function() {

	$("body").on( "custom_message", function( event, pathArray, tablename, contributor, write_date, subject, path, rank, message, intime, image_paths, tastes, flavors ) {

		//alert("pathArray are 2:" + pathArray + " pathArray are:" + pathArray.length);
		//alert("tastes are:" + tastes);
		//alert("flavors are:" + flavors);

		var tastes_values = tastes.split(',');
		var i = 0;
		var innerText = '<div class="review">';

			innerText += '<div class="nonda_user_container">';
			innerText += '<div Class="nonda_user_image_container">';
			innerText += ' <img src="' + path + '">';
			innerText += '</div>';
			innerText += '<div class="nonda_user_name_container">';
			innerText += ' <div class="nonda_user_name">' + contributor + '</div>';
			innerText += ' <div class="nonda_user_profile_date_container">';
			innerText += '   <div class="nonda_user_profile">20代後半/女性/和歌山県/利酒師(SSI認定)</div>';
			innerText += '   <div class="nonda_date">' + intime + '</div>';
			innerText += ' </div>';
			innerText += '</div>';
			innerText += '</div>';

			////////////////////////////////////////
			////////////////////////////////////////
			var rank_width = (rank / 5) * 100 + '%';

			innerText += '<div class="nonda_rank">';
				innerText += '<div class="review_star_rating">';
					innerText += '<div class="review_star_rating_front" style="width:' + rank_width + '">★★★★★</div>';
					innerText += '<div class="review_star_rating_back">★★★★★</div>';
				innerText += '</div>';
				if(rank) {
					innerText += '<span class="review_sake_rate">' + rank + '</span>';
				} else {
					innerText += '<span class="review_sake_rate" style="color: #b2b2b2;">--</span>';
				}
			innerText += '</div>';
			////////////////////////////////////////
			////////////////////////////////////////
			innerText += '<div class="nonda_subject_message_container">';
				innerText += '<div class="nonda_subject">' + subject + '</div>';
				innerText += '<div class="nonda_message">' + nl2br(message) + '</div>';
			innerText += '</div>';
			////////////////////////////////////////
			////////////////////////////////////////

			innerText += '<div class="review_container">';

					for(i = 0; i < pathArray.length; i++)
					{
						var path = "images\\photo\\thumb\\" + pathArray[i];
						innerText += '<div>' +
							'<img class="preview" src="' + path + '">' +
						'</div>';
					}

			innerText += '</div>';

			////////////////////////////////////////
			////////////////////////////////////////

			if(tastes_values && tastes_values.length > 0)
			{
				var taste1 = ((tastes_values[0] / 5) * 100) + "%";
				var taste2 = ((tastes_values[1] / 5) * 100) + "%";
				var taste3 = ((tastes_values[2] / 5) * 100) + "%";
				var taste4 = ((tastes_values[3] / 5) * 100) + "%";
				var taste5 = ((tastes_values[4] / 5) * 100) + "%";
				var taste6 = ((tastes_values[5] / 5) * 100) + "%";
				var taste7 = ((tastes_values[6] / 5) * 100) + "%";
				var taste8 = ((tastes_values[7] / 5) * 100) + "%";

				innerText += '<div class="tastes">';

					innerText += '<div class="tastes_item">';
						innerText += '<div class="tastes_title"><svg class="tastes_item_flavor1816"><use xlink:href="#flavor1816"/></svg>フレーバー</div>';
						innerText += '<div class="taste_value_flavor">flavors:' + GetFlavorNames(flavors) + '</div>';
					innerText += '</div>';

					////////////////////////////////////////
					innerText += '<div class="tastes_item">';
						innerText += '	<div class="tastes_title"><svg class="tastes_item_aroma1216"><use xlink:href="#aroma1216"/></svg>香り</div>';
						innerText += '	<div class="tastes_value_container">';
							innerText += '<div class="tastes_bar_container">';
							innerText += '<div style="width:' + taste1 + '" class="tastes_horizontal_bar"></div>';
							innerText += '<div class="tastes_frame_bar"></div>';
							innerText += '</div>';
							innerText += '<div class="taste_value">' + tastes_values[0] + '</div>';
						innerText += '	</div>';
					innerText += '</div>';

					////////////////////////////////////////
					innerText += '<div class="tastes_item">';
						innerText += '	<div class="tastes_title"><svg class="tastes_item_body1216"><use xlink:href="#body1216"/></svg>ボディ</div>';
						innerText += '	<div class="tastes_value_container">';
							innerText += '<div class="tastes_bar_container">';
							innerText += '<div style="width:' + taste2 + '" class="tastes_horizontal_bar"></div>';
							innerText += '<div class="tastes_frame_bar"></div>';
							innerText += '</div>';
							innerText += '<div class="taste_value">' + tastes_values[1] + '</div>';
						innerText += '	</div>';
					innerText += '</div>';

					////////////////////////////////////////
					innerText += '<div class="tastes_item">';
						innerText += '	<div class="tastes_title"><svg class="tastes_item_clear3030"><use xlink:href="#clear3030"/></svg>クリア</div>';
						innerText += '	<div class="tastes_value_container">';
							innerText += '<div class="tastes_bar_container">';
							innerText += '<div style="width:' + taste3 + '" class="tastes_horizontal_bar"></div>';
							innerText += '<div class="tastes_frame_bar"></div>';
							innerText += '</div>';
							innerText += '<div class="taste_value">' + tastes_values[2] + '</div>';
						innerText += '	</div>';
					innerText += '</div>';
					////////////////////////////////////////

					innerText += '<div class="tastes_item">';
						innerText += '	<div class="tastes_title"><svg class="tastes_item_sweetness3030"><use xlink:href="#sweetness3030"/></svg>甘辛</div>';
						innerText += '	<div class="tastes_value_container">';
							innerText += '<div class="tastes_bar_container">';
							innerText += '<div style="width:' + taste4 + '" class="tastes_horizontal_bar"></div>';
							innerText += '<div class="tastes_frame_bar"></div>';
							innerText += '</div>';
							innerText += '<div class="taste_value">' + tastes_values[3] + '</div>';
						innerText += '	</div>';
					innerText += '</div>';
					////////////////////////////////////////

					innerText += '<div class="tastes_item">';
						innerText += '	<div class="tastes_title"><svg class="tastes_item_umami3030"><use xlink:href="#umami3030"/></svg>旨味</div>';
						innerText += '	<div class="tastes_value_container">';
							innerText += '<div class="tastes_bar_container">';
							innerText += '<div style="width:' + taste5 + '" class="tastes_horizontal_bar"></div>';
							innerText += '<div class="tastes_frame_bar"></div>';
							innerText += '</div>';
							innerText += '<div class="taste_value">' + tastes_values[4] + '</div>';
						innerText += '	</div>';
					innerText += '</div>';
					////////////////////////////////////////

					innerText += '<div class="tastes_item">';
						innerText += '	<div class="tastes_title"><svg class="tastes_item_acidity3030"><use xlink:href="#acidity3030"/></svg>酸味</div>';
						innerText += '	<div class="tastes_value_container">';
							innerText += '<div class="tastes_bar_container">';
							innerText += '<div style="width:' + taste6 + '" class="tastes_horizontal_bar"></div>';
							innerText += '<div class="tastes_frame_bar"></div>';
							innerText += '</div>';
							innerText += '<div class="taste_value">' + tastes_values[5] + '</div>';
						innerText += '	</div>';
					innerText += '</div>';
					////////////////////////////////////////

					innerText += '<div class="tastes_item">';
						innerText += '	<div class="tastes_title"><svg class="tastes_item_bitter1216"><use xlink:href="#bitter1216"/></svg>ビター</div>';
						innerText += '	<div class="tastes_value_container">';
							innerText += '<div class="tastes_bar_container">';
							innerText += '<div style="width:' + taste7 + '" class="tastes_horizontal_bar"></div>';
							innerText += '<div class="tastes_frame_bar"></div>';
							innerText += '</div>';
							innerText += '<div class="taste_value">' + tastes_values[5] + '</div>';
						innerText += '	</div>';
					innerText += '</div>';
					////////////////////////////////////////

					innerText += '<div class="tastes_item">';
						innerText += '	<div class="tastes_title"><svg class="tastes_item_yoin3030"><use xlink:href="#yoin3030"/></svg>余韻</div>';
						innerText += '	<div class="tastes_value_container">';
							innerText += '<div class="tastes_bar_container">';
							innerText += '<div style="width:' + taste8 + '" class="tastes_horizontal_bar"></div>';
							innerText += '<div class="tastes_frame_bar"></div>';
							innerText += '</div>';
							innerText += '<div class="taste_value">' + tastes_values[5] + '</div>';
						innerText += '	</div>';
					innerText += '</div>';

				innerText += '</div>';
			}

			innerText += '</div>';

			//alert("innerText:" + innerText);

			var element = $("#threads").prepend(innerText);

			////////////////////////////////////////
			// 写真のタブに登録する
			for(i = 0; i < pathArray.length; i++)
			{
				var path = "images\\photo\\" + pathArray[i];
				var innerHTML = '<div><div>' +
					'<img id="' + pathArray[i] + '" class="preview" src="' + path + '">' +
					'<button filename ="' + pathArray[i] + '" class="navigate_button">削除</button>' +
					'<span>' + pathArray[i] + '</span></div></div>';

				$element = $('#photoframe').append(innerHTML);
			}
	});
});

$(function() {

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 写真を拡大表示するイベント
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$(document).on('click', '.sake_photo', function(){

	    var touch_start_y;
		var path = $(this).find('img');

		$("#preview_image").attr("src", $(path).attr("src"));
		$("#dialog_preview .dialog_preview_user_name").text($(this).data("contributor"));
		$("#dialog_preview .dialog_preview_date").text($(this).data("added_date"));

		if($(this).data("desc") && $(this).data("desc") != "") {
			$("#dialog_preview .dialog_preview_caption").text($(this).data("desc"));
			$("#dialog_preview .dialog_preview_caption").css({"display":"flex"});
		}
		else {
			$("#dialog_preview .dialog_preview_caption").css({"display":"none"});
		}

		//alert("desc:" + $(this).data("desc"));
		//alert("added date:" + $(this).data("added_date"));

		// タッチしたとき開始位置を保存しておく
		$(window).on('touchstart', function(event) {
			touch_start_y = event.originalEvent.changedTouches[0].screenY;
		});

		// スワイプしているとき
		$(window).on('touchmove.noscroll', function(event) {
			var current_y = event.originalEvent.changedTouches[0].screenY,
			height = $('#dialog_preview').outerHeight(),
			is_top = touch_start_y <= current_y && $('#dialog_preview')[0].scrollTop === 0,
			is_bottom = touch_start_y >= current_y && $('#dialog_preview')[0].scrollHeight - $('#dialog_preview')[0].scrollTop === height;

			// スクロール対応モーダルの上端または下端のとき
			if(is_top || is_bottom) {
				// スクロール禁止
				event.preventDefault();
			}
		});

		// スクロール禁止
		$('html, body').css('overflow', 'hidden');
		$("#dialog_preview").css({"display":"flex"});
	});

	$('#close_preview_button').click(function() {
	  // イベントを削除
	  $(window).off('touchmove.noscroll');
	  $('html, body').css('overflow', '');
	  $("#dialog_preview").css({"display":"none"});
	});
});

$(function() {

	function searchPhoto(in_disp_from, disp_max, data, bCount)
	{
		//alert("data:" + data);

		$.ajax({
			type: "POST",
			url: "sake_photo.php",
			data: data,
			dataType: 'json',

		}).done(function(data){

			var innerHTML = "";
			var result = data[0].result;

			//alert("success: " + data[0].sql);
			//alert("result:" + result);

			$('#photoframe').empty();

			var photos = data[0].result;

			for(i = 0; i < photos.length; i++)
			{
				var path = "images\\photo\\" + photos[i].filename;
				innerHTML += '<div class="sake_photo"><div class="sake_photo_image_container"><img src="' + path  + '"></div><span>' + photos[i].contributor + '</span></div></div>';
			}

			$('#photoframe').html(innerHTML);

			//////////////////////////////////////////////////////////////////////////////////////////////////////////////
			var showPos = parseInt($('#photo .pageitems:first').text()) - 1;
			var position = Math.ceil(in_disp_from / $('#photoframe').data('limit'));
			var nth = position - showPos;
			var numPages = 5;

			if((nth + 1) < numPages)
			{
				//alert("showPos:" + showPos + " position:" + position + " nth:" + nth);
				$('.pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
				$('.pageitems:nth(' + nth + ')').css({"background": "#22445B", "color":"#ffffff"});
			}
			else
			{
				$(".pageitems").each(function() {
					$(this).text(parseInt($(this).text()) - 1);
					$(this).val($(this).val() - 1);
				});

				$('.pageitems').css({"background": "#b2b2b2", "color":"#ffffff"});
				$('.pageitems:nth-child(2)').css({"background": "#22445B", "color":"#ffffff"});
			}

			////////////////////////////////////////

			if(in_disp_from >= disp_max)
				$('#prev_photo').addClass('active');
			else
				$('#prev_photo').removeClass('active');

			if((in_disp_from + disp_max) > $('#photoframe').data('count'))
				$('#next_photo').removeClass('active');
			else
				$('#next_photo').addClass('active');
			////////////////////////////////////////

			$('#photoframe').data('in_disp_from', in_disp_from)
			$('#photoframe').data('in_disp_to', in_disp_from + disp_max)
			//alert('in_disp_from:' + $('#photoframe').data('in_disp_from'));

			$('html, body').animate({scrollTop:0}, '100');
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////

		}).fail(function(data){
			alert("Failed:" + data);
		});
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$(document).on('click', '#photo .pageitems', function(){
		var index = $(this).index();
		var numPages = 5;
		var limit = $('#photoframe').data('limit');
		var sake_id = <?php echo json_encode($sake_id); ?>;
		var in_disp_from = $('#photoframe').data('limit') * (index - 1);
		var disp_max = 12;

        var data = "sake_id=" + sake_id + "&in_disp_from=" + in_disp_from + "&in_disp_to=" + $('#photoframe').data('limit');
		var position = Math.ceil(in_disp_from / limit);

		searchPhoto(in_disp_from, disp_max, data, false);
	});

	$(document).on('click', '#prev_photo', function(){

		var numPages = 5;
		var limit = $('#photoframe').data('limit');
		var disp_max = 12;
		var sake_id = <?php echo json_encode($sake_id); ?>;
		var in_disp_from = $('#photoframe').data('in_disp_from') - $('#photoframe').data('limit')
        var data = "sake_id=" + sake_id + "&in_disp_from=" + in_disp_from + "&in_disp_to=" + $('#photoframe').data('limit');

		if(in_disp_from < 0)
			return 0;

		searchPhoto(in_disp_from, disp_max, data, false);
	});

	$(document).on('click', '#next_photo', function(){

		var in_disp_from = $('#photoframe').data('in_disp_from') + $('#photoframe').data('limit');
		var disp_max = 12;
		var sake_id = <?php echo json_encode($sake_id); ?>;
        var data = "sake_id=" + sake_id + "&in_disp_from=" + in_disp_from + "&in_disp_to=" + $('#photoframe').data('limit');

		if(in_disp_from > $('#photoframe').data('count'))
			return 0;

		searchPhoto(in_disp_from, disp_max, data, false);
	});

	$(document).on('mouseover', '#photoframe > div', function() {
		//alert("mouseover");
		$(this).find('.menu_trigger').fadeIn();
	});

    $("#photoframe ul li:nth-child(2)").click(function() {
		var filename = $(this).attr('filename');
        var sakeid = $('#container').data('sake_id');
        var obj = this;
        var data = "id="+sakeid+"&setting="+filename;
        alert("data:" + data);

        $.ajax({
            type: "post",
			url: "sake_update.php?id=<?php print($_GET['sake_id']);?>",
			data: data,
        }).done(function(xml){
            var str = $(xml).find("str").text();

            if(str == "success")
            {
				alert("プロフィール写真を設定しました");
				var path = "images/" + filename;

				$('.profile_image:first-child').attr("src", path);
				$('.thumb_image:first-child').attr("src", path);
            }
            else
            {
                alert("SQL returned Failed:" +str);
            }
        }).fail(function(data){
              var str = $(xml).find("str").text();
              alert("Failed:" +str);
        });
    });

	$('#photoframe > div').mouseleave(function() {
			$(this).find('.menu_trigger').fadeOut();
		});

		$('#photoframe > div').mouseleave(function() {

			//alert("mouseleave");
			$(this).find('ul').fadeOut();
		});

		//$("#photoframe").delegate('.menu_trigger', 'click', function(event) {
		//$(document).on('click', '.menu_trigger', function(event){

		//$("#photoframe").delegate('.menu_trigger', 'click', function(event) {
		$('.menu_trigger').click(function() {

		//alert('click');

		$(this).next('ul').fadeToggle();
		event.stopPropagation();
		event.preventDefault();

		return true;
	});

	$('#photoframe ul').mouseleave(function() {
		$(this).fadeOut();
	});
});

/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function($) {

	$('#add_nonda_sake').attr('sake_id', $('#container').data('sake_id'));
    $("body").wrapInner('<div id="wrapper"></div>');

	$('#tab_main').createTabs({
		text : $('#tab_main ul')
	});


	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	$('#button_bbs').click(function() {

		var sake_id = $('#container').data('sake_id');
		var username = $('#container').data('contributor');
		var bFound = false;

		if(username == undefined || username == "")
		{
			window.location.href = "user_login_form.php";
			return;
		}

		if($('#button_bbs').data('sake_id') && $('#button_bbs').data('sake_id') != undefined) {

			var desc_array = <?php echo json_encode($desc); ?>;

			$("body").trigger("open_nonda", [  $('#button_bbs').data('subject'),
											   $('#button_bbs').data('message'),
											   $('#button_bbs').data('rank'),
											   $('#button_bbs').data('paths'),
											   desc_array,
											   $('#button_bbs').data('sake_id'),
											   $('#container').data('sake_name'),
											   $('#container').data('sake_read'),
											   $('#container').data('sakagura_name'),
											   $('#container').data('pref'),
											   $('#button_bbs').data('write_date'),
											   $('#button_bbs').data('contributor'),
											   $('#button_bbs').data('tastes'),
											   $('#button_bbs').data('flavor'),
											   $('#button_bbs').data('committed') ] );
		}
		else {
			$("body").trigger("new_nonda", [ $('#container').data("sake_id"),
											 $('#container').data('sake_name'),
											 $('#container').data("sake_read"),
						  					 $('#container').data("sakagura_name"),
											 $('#container').data("pref"),
											 $('#container').data("contributor") ] );
		}
	});

	$("#showpic").click(function() {
		var sake_id = $(this).attr('sake_id');
		var sake_name = $('#sake_name').text();
		window.open('sake_image.php?sake_id=' + sake_id + '&data_type=sake&title=' + sake_name, '_self');
	});

	$('#add_sake').click(function() {
		//alert("add sake");
		var sakagura_id = $(this).attr('sakagura_id');
		window.open('sake_add_form.php?id=' + sakagura_id + '&sakagura_name=' + sakagura_name.innerText, '_self');
	});

	$('#edit_sake').click(function() {
		//alert("edit sake");
		var sake_id = <?php echo json_encode($_GET['sake_id']); ?>;
		var sakagura_id = $(this).attr('sakagura_id');
		window.open('sake_add_form.php?sake_id=' + $('#container').data('sake_id') + '&sake_name=' + $('#container').data('sake_name') + '&id=' + sakagura_id + '&sakagura_name=' + sakagura_name.innerText, '_self');
	});

	$("#personal .follow").click(function() {
		var data = $("#form").serialize();
		var sake_id = $('#container').data('sake_id');
		var username = $('#container').data('contributor');

		//alert("follow:" + sake_id);
		if(username == undefined || username == "")
		{
			window.location.href = "user_login_form.php";
			return;
		}

		 $.ajax({
				type: "post",
				url: "sake_follow.php?sake_id=<?php print($_GET['sake_id']);?>",
				data: data,
		 }).done(function(xml){
				var str = $(xml).find("str").text();
				var count = $(xml).find("count").text();
				//alert("count:" + count);

				count = (count == 0 || count == '') ? "--" : count;

				//alert("success:" + str);
				//alert("count:" + count);

				if(str == "follow")
				{
					//$("#personal .follow").animate({ backgroundColor: 'linear-gradient(#e6e6e6, #ffffff)', color: '#666666'}, 'slow');
					$("#personal .follow").css('background', 'linear-gradient(#e6e6e6, #ffffff)');
					$("#personal .follow").css('border', '1px solid #d2d2d2');
					$("#personal .follow").css('color', '#666666');
					$("#personal .button_bbs_pin1616").css('fill', '#b2b2b2');
					//$("#personal .follow").addClass("followed");
					$("#nomitai_count").text(count);
				}
				else if(str == "followed")
				{
					//$("#personal .follow").animate({ backgroundColor: 'linear-gradient(#EDCACA, #ffffff)', color: '#666666'}, 'slow');
					$("#personal .follow").css('background', 'linear-gradient(#EDCACA, #ffffff)');
					$("#personal .follow").css('border', '1px solid #FF4545');
					$("#personal .button_bbs_pin1616").css('fill', '#FF4545');
					//$("#personal .follow").removeClass("followed");
					$("#nomitai_count").text(count);
				}

		}).fail(function(data){
				alert("This is Error");
				$("#personal .follow").text('This is Error');
		});
	});

	if($('#nomitai_count').text() == '--') {
		$("#nomitai_count").css('color', '#b2b2b2');
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////
	var hash = window.location.hash;

	if(hash && hash != "")
	{
		var curr = $('#tab_main .simpleTabs').find(".active");
		var prev = $('#tab_main .simpleTabs').find('a[href="' + hash +'"]');

		curr.removeClass('active');
		prev.addClass('active');

		$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
		$(hash).removeClass('hide').addClass('show').show();
	}
	else
	{
		var stateObj = { url: "#top" };
		history.replaceState(stateObj, "test1", "");
	}

	$('.simpleTabs li a').click(function() {
		var stateObj = { url: $(this).attr("href") };
		history.pushState(stateObj, "test1", $(this).attr("href"));
	});

	$(window).on('popstate', function(event) {

		var state = event.originalEvent.state;
		var curr = $('.simpleTabs').find(".active");
		var href = state.url;
		var prev = $('.simpleTabs').find('a[href="' + state.url +'"]');

		curr.removeClass('active');
		prev.addClass('active');

		$('#tab_main').find('.show').removeClass('show').addClass('hide').hide();
		$(href).removeClass('hide').addClass('show').show();
	});

})(); // 匿名関数

</script>
</body>
</html>
