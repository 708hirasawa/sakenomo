<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
?>

<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>プロフィール編集 [Sakenomo]</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/user_view_config_profile.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
</head>

<body>

	<?php
	include_once('images/icons/svg_sprite.svg');
	write_side_menu();
	write_HamburgerLogo();
	write_search_bar();

	//$username = $_SESSION['loginname'];
	$username = $_COOKIE['login_cookie'];

	if(!$db = opendatabase("sake.db"))
	{
		print('<div>データベース接続エラー</div>');
		print('</body></html>');
		return;
	}

	$sql = "SELECT * FROM USERS_J WHERE username = '$username' OR email = '$username'";
	$res = executequery($db, $sql);
	$row = getnextrow($res);

	if(!$row)
	{
		print('<div>データベース接続エラー</div>');
		print('</body></html>');
		return;
	}

	$imagefile = null;
	$username = stripslashes($row["username"]);
	$sql = "SELECT * FROM PROFILE_IMAGE WHERE contributor = '$username' AND status = 1";
	$result = executequery($db, $sql);
	$rd = getnextrow($result);

	if($rd) {
		$imagefile = $rd["filename"];
	}

	// $imagefile = $row["imagefile"];
	$username = stripslashes($row["username"]);
	$nickname = stripslashes($row["nickname"]);
	$fname = stripslashes($row["fname"]);
	$minit = stripslashes($row["minit"]);
	$lname = stripslashes($row["lname"]);
	$sex = stripslashes($row["sex"]);
	$bdate = stripslashes($row["bdate"]);
	$email = stripslashes($row["email"]);
	$phone = stripslashes($row["phone"]);
	$pref = $row["pref"];
	$address = stripslashes($row["address"]);
	$address_read = stripslashes($row["address_read"]);
	$postal_code = $row["postal_code"];
	$certification = $row["certification"];
	$age_disclose = $row["age_disclose"];
	$sex_disclose = $row["sex_disclose"];
	$address_disclose = $row["address_disclose"];
	$certification_disclose = $row["certification_disclose"];
	$introduction = stripslashes($row["introduction"]);

	print('<input type="hidden" name="hidden_email" value=' .$email .'>');
	print('<input type="hidden" name="hidden_username" value=' .$username .'>');
	print('<input type="hidden" name="hidden_nickname" value=' .$nickname .'>');
	print('<input type="hidden" id="hidden_fname" value=' .$fname .'>');
	print('<input type="hidden" id="hidden_minit" value=' .$minit .'>');
	print('<input type="hidden" id="hidden_lname" value=' .$lname .'>');
	print('<input type="hidden" id="hidden_sex" value=' .$sex .'>');
	print('<input type="hidden" id="hidden_bdate" value=' .$bdate .'>');
	print('<input type="hidden" id="hidden_phone" value=' .$phone .'>');;
	print('<input type="hidden" id="hidden_pref" value=' .$pref .'>');;
	print('<input type="hidden" id="hidden_address" value=' .$address .'>');;
	print('<input type="hidden" id="hidden_address_read" value=' .$address_read .'>');;
	print('<input type="hidden" id="hidden_postal_code" value=' .$postal_code .'>');;
	print('<input type="hidden" id="hidden_imagefile" value=' .$imagefile .'>');;
	print('<input type="hidden" id="hidden_introduction" value="' .$introduction .'">');;
	print('<input type="hidden" id="hidden_certification" value="' .$certification .'">');;
	print('<input type="hidden" id="hidden_age_disclose" value="' .$age_disclose .'">');;
	print('<input type="hidden" id="hidden_sex_disclose" value="' .$sex_disclose .'">');;
	print('<input type="hidden" id="hidden_address_disclose" value="' .$address_disclose .'">');;
	print('<input type="hidden" id="hidden_certification_disclose" value="' .$certification_disclose .'">');

	print('<div id="all_container">');

		print('<div id="user_information">');
			$path = "images/icons/noimage_user30.svg";
			if($imagefile)
				$path = "images/profile/" .$imagefile;
			print('<div class="user_image_name_container">');
				print('<div class="user_image_container">');
					print('<img src=' .$path .'>');
				print('</div>');
				print('<div id="profile_name">' .$row["nickname"] .'</div>');

			print('</div>');
		print("</div>");

		print('<form id="main_container">');

			print('<input type="hidden" name="email" value=' .$email .'>');

			print('<div class="mypage_config_title_button_container">');
				print('<div class="mypage_config_title"><svg class="config_title_config1616"><use xlink:href="#config1616"/></svg>プロフィール編集</div>');
				print('<a class="mypage_config_button" href="user_view_config.php?username=' .$username .'"><span>マイページ設定</span></a>');
			print('</div>');

			print('<div id="config_content">');

				//写真//////////////////////////////////////////////////////////////////////////
				print('<div class="config_item">');
					print('<div class="config_item_title">プロフィール写真</div>');
					print('<div class="profile_photo_container">');
						print('<input type="file">');
						print('<div class="profile_photo">');
							print('<img src=' .$path .'>');
							print('<progress class="profile_photo_progress" value="0" max="100"></progress>');
							print('<div class="profile_status_total_container">');
								print('<div class="profile_status">status</div>');
								print('<div class="profile_total">total</div>');
							print('</div>');
							print('<div class="profile_photo_button_container">');
								print('<input type="button" class="change_pic" value="+">');
								print('<input type="button" class="remove_profile_pic" value="削除">');
							print('</div>');
							print('<input type="hidden" name="delete_image" value=0>');
							print('<input type="file" id="file1">');
						print('</div>');
					print('</div>');
				print('</div>');

				//名前//////////////////////////////////////////////////////////////////////////
				print('<div class="config_item">');
					print('<div class="config_item_title">ユーザー名</div>');
					print('<div class="user_name_container">');
						print('<input name="nickname" id="user_name_input_argument" class="user_name_inputform" value="' .$row["nickname"] .'" placeholder="">');
					print('</div>');
				print('</div>');

				//生年月日//////////////////////////////////////////////////////////////////////////
				print('<div class="config_item">');
					print('<div class="config_item_title">生年月日<span>※生年月日は公開されません</span></div>');
					print('<div class="user_birthday_container">');
						print('<div class="user_birthday_select_item">');
							print('<SELECT id="birthday_year" name="birthday_year">');
								print('<OPTION VALUE="">----</OPTION>');
								print('<OPTION VALUE="2021">2021</OPTION>');
								print('<OPTION VALUE="2020">2020</OPTION>');
								print('<OPTION VALUE="2019">2019</OPTION>');
								print('<OPTION VALUE="2018">2018</OPTION>');
								print('<OPTION VALUE="2017">2017</OPTION>');
								print('<OPTION VALUE="2016">2016</OPTION>');
								print('<OPTION VALUE="2015">2015</OPTION>');
								print('<OPTION VALUE="2014">2014</OPTION>');
								print('<OPTION VALUE="2013">2013</OPTION>');
								print('<OPTION VALUE="2012">2012</OPTION>');
								print('<OPTION VALUE="2011">2011</OPTION>');
								print('<OPTION VALUE="2010">2010</OPTION>');
								print('<OPTION VALUE="2009">2009</OPTION>');
								print('<OPTION VALUE="2008">2008</OPTION>');
								print('<OPTION VALUE="2007">2007</OPTION>');
								print('<OPTION VALUE="2006">2006</OPTION>');
								print('<OPTION VALUE="2005">2005</OPTION>');
								print('<OPTION VALUE="2004">2004</OPTION>');
								print('<OPTION VALUE="2003">2003</OPTION>');
								print('<OPTION VALUE="2002">2002</OPTION>');
								print('<OPTION VALUE="2001">2001</OPTION>');
								print('<OPTION VALUE="2000">2000</OPTION>');
								print('<OPTION VALUE="1999">1999</OPTION>');
								print('<OPTION VALUE="1998">1998</OPTION>');
								print('<OPTION VALUE="1997">1997</OPTION>');
								print('<OPTION VALUE="1996">1996</OPTION>');
								print('<OPTION VALUE="1995">1995</OPTION>');
								print('<OPTION VALUE="1994">1994</OPTION>');
								print('<OPTION VALUE="1993">1993</OPTION>');
								print('<OPTION VALUE="1992">1992</OPTION>');
								print('<OPTION VALUE="1991">1991</OPTION>');
								print('<OPTION VALUE="1990">1990</OPTION>');
								print('<OPTION VALUE="1989">1989</OPTION>');
								print('<OPTION VALUE="1988">1988</OPTION>');
								print('<OPTION VALUE="1987">1987</OPTION>');
								print('<OPTION VALUE="1986">1986</OPTION>');
								print('<OPTION VALUE="1985">1985</OPTION>');
								print('<OPTION VALUE="1984">1984</OPTION>');
								print('<OPTION VALUE="1983">1983</OPTION>');
								print('<OPTION VALUE="1982">1982</OPTION>');
								print('<OPTION VALUE="1981">1981</OPTION>');
								print('<OPTION VALUE="1980">1980</OPTION>');
								print('<OPTION VALUE="1979">1979</OPTION>');
								print('<OPTION VALUE="1978">1978</OPTION>');
								print('<OPTION VALUE="1977">1977</OPTION>');
								print('<OPTION VALUE="1976">1976</OPTION>');
								print('<OPTION VALUE="1975">1975</OPTION>');
								print('<OPTION VALUE="1974">1974</OPTION>');
								print('<OPTION VALUE="1973">1973</OPTION>');
								print('<OPTION VALUE="1972">1972</OPTION>');
								print('<OPTION VALUE="1971">1971</OPTION>');
								print('<OPTION VALUE="1970">1970</OPTION>');
								print('<OPTION VALUE="1969">1969</OPTION>');
								print('<OPTION VALUE="1968">1968</OPTION>');
								print('<OPTION VALUE="1967">1967</OPTION>');
								print('<OPTION VALUE="1966">1966</OPTION>');
								print('<OPTION VALUE="1965">1965</OPTION>');
								print('<OPTION VALUE="1964">1964</OPTION>');
								print('<OPTION VALUE="1963">1963</OPTION>');
								print('<OPTION VALUE="1962">1962</OPTION>');
								print('<OPTION VALUE="1961">1961</OPTION>');
								print('<OPTION VALUE="1960">1960</OPTION>');
								print('<OPTION VALUE="1959">1959</OPTION>');
								print('<OPTION VALUE="1958">1958</OPTION>');
								print('<OPTION VALUE="1957">1957</OPTION>');
								print('<OPTION VALUE="1956">1956</OPTION>');
								print('<OPTION VALUE="1955">1955</OPTION>');
								print('<OPTION VALUE="1954">1954</OPTION>');
								print('<OPTION VALUE="1953">1953</OPTION>');
								print('<OPTION VALUE="1952">1952</OPTION>');
								print('<OPTION VALUE="1951">1951</OPTION>');
								print('<OPTION VALUE="1950">1950</OPTION>');
								print('<OPTION VALUE="1949">1949</OPTION>');
								print('<OPTION VALUE="1948">1948</OPTION>');
								print('<OPTION VALUE="1947">1947</OPTION>');
								print('<OPTION VALUE="1946">1946</OPTION>');
								print('<OPTION VALUE="1945">1945</OPTION>');
								print('<OPTION VALUE="1944">1944</OPTION>');
								print('<OPTION VALUE="1943">1943</OPTION>');
								print('<OPTION VALUE="1942">1942</OPTION>');
								print('<OPTION VALUE="1941">1941</OPTION>');
								print('<OPTION VALUE="1940">1940</OPTION>');
								print('<OPTION VALUE="1939">1939</OPTION>');
								print('<OPTION VALUE="1938">1938</OPTION>');
								print('<OPTION VALUE="1937">1937</OPTION>');
								print('<OPTION VALUE="1936">1936</OPTION>');
								print('<OPTION VALUE="1935">1935</OPTION>');
								print('<OPTION VALUE="1934">1934</OPTION>');
								print('<OPTION VALUE="1933">1933</OPTION>');
								print('<OPTION VALUE="1932">1932</OPTION>');
								print('<OPTION VALUE="1931">1931</OPTION>');
								print('<OPTION VALUE="1930">1930</OPTION>');
								print('<OPTION VALUE="1929">1929</OPTION>');
								print('<OPTION VALUE="1928">1928</OPTION>');
								print('<OPTION VALUE="1927">1927</OPTION>');
								print('<OPTION VALUE="1926">1926</OPTION>');
								print('<OPTION VALUE="1925">1925</OPTION>');
								print('<OPTION VALUE="1924">1924</OPTION>');
								print('<OPTION VALUE="1923">1923</OPTION>');
								print('<OPTION VALUE="1922">1922</OPTION>');
								print('<OPTION VALUE="1921">1921</OPTION>');
								print('<OPTION VALUE="1920">1920</OPTION>');
								print('<OPTION VALUE="1919">1919</OPTION>');
								print('<OPTION VALUE="1918">1918</OPTION>');
								print('<OPTION VALUE="1917">1917</OPTION>');
								print('<OPTION VALUE="1916">1916</OPTION>');
								print('<OPTION VALUE="1915">1915</OPTION>');
								print('<OPTION VALUE="1914">1914</OPTION>');
								print('<OPTION VALUE="1913">1913</OPTION>');
								print('<OPTION VALUE="1912">1912</OPTION>');
								print('<OPTION VALUE="1911">1911</OPTION>');
								print('<OPTION VALUE="1910">1910</OPTION>');
								print('<OPTION VALUE="1909">1909</OPTION>');
								print('<OPTION VALUE="1908">1908</OPTION>');
								print('<OPTION VALUE="1907">1907</OPTION>');
								print('<OPTION VALUE="1906">1906</OPTION>');
								print('<OPTION VALUE="1905">1905</OPTION>');
								print('<OPTION VALUE="1904">1904</OPTION>');
								print('<OPTION VALUE="1903">1903</OPTION>');
								print('<OPTION VALUE="1902">1902</OPTION>');
								print('<OPTION VALUE="1901">1901</OPTION>');
								print('<OPTION VALUE="1900">1900</OPTION>');
							print('</SELECT>');
							print('<span>年</span>');
						print('</div>');
						print('<div class="user_birthday_select_item">');
							print('<SELECT id="birthday_month" name="birthday_month">');
								print('<OPTION VALUE="">--</OPTION>');
								print('<OPTION VALUE="1">1</OPTION>');
								print('<OPTION VALUE="2">2</OPTION>');
								print('<OPTION VALUE="3">3</OPTION>');
								print('<OPTION VALUE="4">4</OPTION>');
								print('<OPTION VALUE="5">5</OPTION>');
								print('<OPTION VALUE="6">6</OPTION>');
								print('<OPTION VALUE="7">7</OPTION>');
								print('<OPTION VALUE="8">8</OPTION>');
								print('<OPTION VALUE="9">9</OPTION>');
								print('<OPTION VALUE="10">10</OPTION>');
								print('<OPTION VALUE="11">11</OPTION>');
								print('<OPTION VALUE="12">12</OPTION>');
							print('</SELECT>');
							print('<span>月</span>');
						print('</div>');
						print('<div class="user_birthday_select_item">');
							print('<SELECT id="birthday_day" name="birthday_day">');
								print('<OPTION VALUE="">--</OPTION>');
								print('<OPTION VALUE="1">1</OPTION>');
								print('<OPTION VALUE="2">2</OPTION>');
								print('<OPTION VALUE="3">3</OPTION>');
								print('<OPTION VALUE="4">4</OPTION>');
								print('<OPTION VALUE="5">5</OPTION>');
								print('<OPTION VALUE="6">6</OPTION>');
								print('<OPTION VALUE="7">7</OPTION>');
								print('<OPTION VALUE="8">8</OPTION>');
								print('<OPTION VALUE="9">9</OPTION>');
								print('<OPTION VALUE="10">10</OPTION>');
								print('<OPTION VALUE="11">11</OPTION>');
								print('<OPTION VALUE="12">12</OPTION>');
								print('<OPTION VALUE="13">13</OPTION>');
								print('<OPTION VALUE="14">14</OPTION>');
								print('<OPTION VALUE="15">15</OPTION>');
								print('<OPTION VALUE="16">16</OPTION>');
								print('<OPTION VALUE="17">17</OPTION>');
								print('<OPTION VALUE="18">18</OPTION>');
								print('<OPTION VALUE="19">19</OPTION>');
								print('<OPTION VALUE="20">20</OPTION>');
								print('<OPTION VALUE="21">21</OPTION>');
								print('<OPTION VALUE="22">22</OPTION>');
								print('<OPTION VALUE="23">23</OPTION>');
								print('<OPTION VALUE="24">24</OPTION>');
								print('<OPTION VALUE="25">25</OPTION>');
								print('<OPTION VALUE="26">26</OPTION>');
								print('<OPTION VALUE="27">27</OPTION>');
								print('<OPTION VALUE="28">28</OPTION>');
								print('<OPTION VALUE="29">29</OPTION>');
								print('<OPTION VALUE="30">30</OPTION>');
								print('<OPTION VALUE="31">31</OPTION>');
							print('</SELECT>');
							print('<span>日</span>');
						print('</div>');
					print('</div>');
				print('</div>');

				//年代//////////////////////////////////////////////////////////////////////////
				print('<div class="config_item">');
					print('<div class="config_item_title">年代<span>※年代は自動計算されます</span></div>');
					print('<div class="user_age_container">');
						print('<div class="user_age">--</div>');
						/*print('<div class="disclose_select_item">');
							初期非表示print('<SELECT id="age_disclose_select" name="age_disclose_select">');
								print('<OPTION VALUE=1>公開</OPTION>');
								print('<OPTION VALUE=2>非公開</OPTION>');
							print('</SELECT>');
						print('</div>');*/
					print('</div>');
				print('</div>');

				//性別//////////////////////////////////////////////////////////////////////////
				print('<div class="config_item">');
					print('<div class="config_item_title">性別<span>※性別は公開されません</span></div>');
					print('<div class="user_sex_container">');
						print('<div class="user_sex_select_item">');
							print('<SELECT id="sex" name="sex">');
								print('<OPTION VALUE="">----</OPTION>');
								print('<OPTION VALUE="男性">男性</OPTION>');
								print('<OPTION VALUE="女性">女性</OPTION>');
							print('</SELECT>');
						print('</div>');
						/*初期非表示print('<div class="disclose_select_item">');
							print('<SELECT id="sex_disclose_select" name="sex_disclose_select">');
								print('<OPTION VALUE=1>公開</OPTION>');
								print('<OPTION VALUE=2>非公開</OPTION>');
							print('</SELECT>');
						print('</div>');*/
					print('</div>');
				print('</div>');

				//現住所//////////////////////////////////////////////////////////////////////////
				print('<div class="config_item">');
					print('<div class="config_item_title">現住所</div>');
					print('<div class="user_address_container">');
						print('<div class="user_address_select_item">');
							print('<SELECT id="pref" read="" name="pref">');
								print('<OPTION VALUE="" read="">----</OPTION>');
								print('<OPTION VALUE="北海道" read="ほっかいどう">北海道</OPTION>');
								print('<OPTION VALUE="青森県" read="あおもりけん">青森県</OPTION>');
								print('<OPTION VALUE="岩手県" read="いわてけん">岩手県</OPTION>');
								print('<OPTION VALUE="宮城県" read="みやぎけん">宮城県</OPTION>');
								print('<OPTION VALUE="秋田県" read="あきたけん">秋田県</OPTION>');
								print('<OPTION VALUE="山形県" read="やまがたけん">山形県</OPTION>');
								print('<OPTION VALUE="福島県" read="ふくしまけん">福島県</OPTION>');
								print('<OPTION VALUE="茨城県" read="いばらぎけん">茨城県</OPTION>');
								print('<OPTION VALUE="栃木県" read="とちぎけん">栃木県</OPTION>');
								print('<OPTION VALUE="群馬県" read="ぐんまけん">群馬県</OPTION>');
								print('<OPTION VALUE="埼玉県" read="さいたまけん">埼玉県</OPTION>');
								print('<OPTION VALUE="千葉県" read="ちばけん">千葉県</OPTION>');
								print('<OPTION VALUE="東京都" read="とうきょうと">東京都</OPTION>');
								print('<OPTION VALUE="神奈川県" read="かながわけん">神奈川県</OPTION>');
								print('<OPTION VALUE="新潟県" read="にいがたけん">新潟県</OPTION>');
								print('<OPTION VALUE="富山県" read="とやまけん">富山県</OPTION>');
								print('<OPTION VALUE="石川県" read="いしかわけん">石川県</OPTION>');
								print('<OPTION VALUE="福井県" read="ふくいけん">福井県</OPTION>');
								print('<OPTION VALUE="山梨県" read="やまなしけん">山梨県</OPTION>');
								print('<OPTION VALUE="長野県" read="ながのけん">長野県</OPTION>');
								print('<OPTION VALUE="岐阜県" read="ぎふけん">岐阜県</OPTION>');
								print('<OPTION VALUE="静岡県" read="しずおかけん">静岡県</OPTION>');
								print('<OPTION VALUE="愛知県" read="あいちけん">愛知県</OPTION>');
								print('<OPTION VALUE="三重県" read="みえけん">三重県</OPTION>');
								print('<OPTION VALUE="滋賀県" read="しがけん">滋賀県</OPTION>');
								print('<OPTION VALUE="京都府" read="きょうとふ">京都府</OPTION>');
								print('<OPTION VALUE="大阪府" read="おおさかふ">大阪府</OPTION>');
								print('<OPTION VALUE="兵庫県" read="ひょうごけん">兵庫県</OPTION>');
								print('<OPTION VALUE="奈良県" read="ならけん">奈良県</OPTION>');
								print('<OPTION VALUE="和歌山県" read="わかやまけん">和歌山県</OPTION>');
								print('<OPTION VALUE="鳥取県" read="とっとりけん">鳥取県</OPTION>');
								print('<OPTION VALUE="島根県" read="しまねけん">島根県</OPTION>');
								print('<OPTION VALUE="岡山県" read="おかやまけん">岡山県</OPTION>');
								print('<OPTION VALUE="広島県" read="ひろしまけん">広島県</OPTION>');
								print('<OPTION VALUE="山口県" read="やまぐちけん">山口県</OPTION>');
								print('<OPTION VALUE="徳島県" read="とくしまけん">徳島県</OPTION>');
								print('<OPTION VALUE="香川県" read="かがわけん">香川県</OPTION>');
								print('<OPTION VALUE="愛媛県" read="えひめけん">愛媛県</OPTION>');
								print('<OPTION VALUE="高知県" read="こうちけん">高知県</OPTION>');
								print('<OPTION VALUE="福岡県" read="ふくおかけん">福岡県</OPTION>');
								print('<OPTION VALUE="佐賀県" read="さがけん">佐賀県</OPTION>');
								print('<OPTION VALUE="長崎県" read="ながさきけん">長崎県</OPTION>');
								print('<OPTION VALUE="熊本県" read="くまもとけん">熊本県</OPTION>');
								print('<OPTION VALUE="大分県" read="おおいたけん">大分県</OPTION>');
								print('<OPTION VALUE="宮崎県" read="みやざきけん">宮城県</OPTION>');
								print('<OPTION VALUE="鹿児島県" read="かごしまけん">鹿児島県</OPTION>');
								print('<OPTION VALUE="沖縄県" read="おきなわけん">沖縄県</OPTION>');
							print('</SELECT>');
						print('</div>');
						/*print('<div class="disclose_select_item">');
							print('<SELECT id="address_disclose_select" name="address_disclose_select">');
								print('<OPTION VALUE=1>公開</OPTION>');
								print('<OPTION VALUE=2>非公開</OPTION>');
							print('</SELECT>');
						print('</div>');*/
					print('</div>');
				print('</div>');

				//資格//////////////////////////////////////////////////////////////////////////
				print('<div class="config_item">');
					print('<div class="config_item_title">利酒資格<span>※保有資格を選択してください</span></div>');
					print('<div class="user_certification_container">');
						print('<div class="user_certification_select_item">');
							print('<label><input type="checkbox" name="certification[]" value="1">利酒師(SSI認定)</label>');
							print('<label><input type="checkbox" name="certification[]" value="2">酒匠(SSI認定)</label>');
						print('</div>');
						/*print('<div class="disclose_select_item">');
							print('<SELECT id="certification_disclose_select" name="certification_disclose_select">');
								print('<OPTION VALUE=1>公開</OPTION>');
								print('<OPTION VALUE=2>非公開</OPTION>');
							print('</SELECT>');
						print('</div>');*/
					print('</div>');
				print('</div>');

				//自己紹介//////////////////////////////////////////////////////////////////////////
				print('<div class="config_item">');
					print('<div class="config_item_title">自己紹介</div>');
					print('<div class="user_introduction_container">');
						print('<div class="user_introduction_select_item">');
							print('<textarea id="user_introduction" name="user_introduction">' .$row["introduction"] .'</textarea>');
						print('</div>');
					print('</div>');
				print('</div>');

			print('</div>');//config_content

			//ボタン//////////////////////////////////////////////////////////////////////////
			print('<div class="user_config_button_container">');
				print('<input id="button_cancel" type="button" value="戻る">');
				print('<input id="submit_button" type="button" value="登録する">');
			print('</div>');

		print("</form>");//main_container

	print("</div>");//all_container

	writefooter();

	?>

</body>
<script type="text/javascript">

$(function() {

	$('#button_cancel').click(function() {

		//<a href="javascript:history.back()">
		var username = <?php echo json_encode($username); ?>;
		var data = $('#main_container').serialize() + '&username=' + username;
		data += "&hidden_username=" + $('input[name="hidden_username"]').val();

		$.ajax({
			type: "post",
			url: "user_update_cancel.php?username=<?php print($username);?>",
			data: data,
		}).done(function(xml){

			var str = $(xml).find("str").text();
			var sql = $(xml).find("sql").text();
			//alert("sql:" + sql);

			if(str == "success") {
				window.open("javascript:history.back()", '_self');
				return;
			}

		}).fail(function(data){
			alert("This is Error");
		}).complete(function(data){
			// Loadingイメージを消す
			// removeLoading();
		});
	});

	$('#submit_button').click(function() {

		var username = <?php echo json_encode($username); ?>;
		var data = $('#main_container').serialize() + '&username=' + username;
		data += "&hidden_username=" + $('input[name="hidden_username"]').val();

		//alert("data:" + data);


		if($('#main_container input[name="certification[]"]:checked').length == 0)
			data += '&certification=';

		if($('input[name="nickname"]').val() == "") {
			alert("ユーザー名が入力されていません");
			return;
		}

		if( ($('select[name="birthday_year"]').val() == "" || $('select[name="birthday_month"]').val() == "" || $('select[name="birthday_day"]').val() == "") &&
		   !($('select[name="birthday_year"]').val() == "" && $('select[name="birthday_month"]').val() == "" && $('select[name="birthday_day"]').val() == "")) {

			alert("生年月日を正しく入力してください");
			return;
		}

		$.ajax({
			type: "post",
			url: "user_update.php?username=<?php print($username);?>",
			data: data,
		}).done(function(xml){

			var str = $(xml).find("str").text();
			var sql = $(xml).find("sql").text();
			var new_username = $(xml).find("username").text();
			//alert("sql:" + sql);

			if(str == "success") {
				alert("データを更新しました");
				//location.reload();
				window.open('user_view_config.php', '_self');
				return;
			}
			else if(str == "exist") {
				alert("このユーザー名 " + $('input[name="nickname"]').val() +  " はすでに使われています");
				//alert("sql:" + sql);
			}

		}).fail(function(data){
			alert("This is Error");
		}).complete(function(data){
			// Loadingイメージを消す
			// removeLoading();
		});
	});
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// user profile image upload
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

$(function() {

	function _(el){
		return document.getElementById(el);
	}

	function completeHandler(event, obj, total, status, progress){
		var responseText = event.target.responseText;
		var responseArray = JSON.parse(responseText);
		var path = "images\\profile\\" + responseArray[0];

		//alert("success:" + responseArray[1] + ", " + responseArray[1] + ", " + responseArray[2]);

		status.html(responseArray[0]);
		progress.val(0);
        obj.removeClass('image_rotated_by_90_counter_clock', 'image_rotated_by_90_clock', 'image_rotated_by_180_clock');
        obj.attr("src", path);

        progress.css({"display":"none"});
        status.css({"display":"none"});
        total.css({"display":"none"});
		$('input[name="delete_image"]').val(0);
	}

	function progressHandler(event, total, status, progress){

 		var percent = (event.loaded / event.total) * 100;
        total.html(event.loaded + "/" + event.total + " bytes");
		status.html(Math.round(percent) + "% uploaded");
		progress.val(Math.round(percent));
	}

	function errorHandler(event, status){
		status.html("Upload Failed");
	}

	function abortHandler(event, status){
		status.html("Upload Aborted");
	}

	$('.change_pic').click(function() {
		$('#file1').trigger("click");
	});

	$('.remove_profile_pic').click(function() {

		var path = "images/icons/noimage_user30.svg";
		$('#main_container .profile_photo img').attr("src", path);
		$('input[name="delete_image"]').val(1);
	});

	$('#file1').change(function() {

        var progress = $('#main_container .profile_photo_progress');
        var status = $('#main_container .profile_status');
        var total = $('#main_container .profile_total');
		var img_obj = $('#main_container .profile_photo img');
		var username = <?php echo json_encode($username); ?>;
		var reader = new FileReader(); // Create a file reader
		var file = $(this).prop("files")[0];

		reader.onload = function(e) {

   			var width = img_obj.width();
			var height = img_obj.height();
            var formdata = new FormData();
            var ajax = new XMLHttpRequest();

            progress.css({"display":"block"});
            status.css({"display":"block"});
            total.css({"display":"block"});
			img_obj.attr("src", e.target.result);

            formdata.append("file1", file);
            formdata.append("username", $('input[name="hidden_email"]').val());
            formdata.append("max_width", 200);
            formdata.append("max_height", 200);

            ajax.upload.addEventListener("progress", function(event) { progressHandler(event, total, status, progress, true); }, false);
            ajax.addEventListener("load", function(event) { completeHandler(event, img_obj, total, status, progress); }, false);
            ajax.addEventListener("error", function(event) { errorHandler(event, status); }, false);
            ajax.addEventListener("abort", function(event) { abortHandler(event, status); }, false);
            ajax.open("POST", "upload_user_image.php");
            ajax.send(formdata);
		}

		reader.readAsDataURL(file);
	});
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

jQuery(document).ready(function($) {

	var username = <?php echo json_encode($username); ?>;

	$("body").wrapInner('<div id="wrapper"></div>');
	$('#sex').val($('#hidden_sex').val());
	$('#pref').val($('#hidden_pref').val());

	if($('#hidden_age_disclose').val() != "")
		$('#age_disclose_select').val($('#hidden_age_disclose').val());

	if($('#hidden_sex_disclose').val() != "")
		$('#sex_disclose_select').val($('#hidden_sex_disclose').val());

	if($('#hidden_address_disclose').val() != "")
		$('#address_disclose_select').val($('#hidden_address_disclose').val());

	if($('#hidden_certification_disclose').val() != "")
		$('#certification_disclose_select').val($('#hidden_certification_disclose').val());

	if($('#hidden_bdate').val())
	{
		var bdate = $('#hidden_bdate').val();
		var bdateArray = bdate.split('-');

		$('#birthday_month').val(bdateArray[0]);
		$('#birthday_day').val(bdateArray[1]);
		$('#birthday_year').val(bdateArray[2]);
	}

	if(bdateArray[0]) {
		var birthDate = new Date(bdateArray[2], bdateArray[0] - 1, bdateArray[1]);

		var y2 = birthDate.getFullYear().toString().padStart(4, '0');
		var m2 = (birthDate.getMonth() + 1).toString().padStart(2, '0');
		var d2 = birthDate.getDate().toString().padStart(2, '0');

		var today = new Date();
		var y1 = today.getFullYear().toString().padStart(4, '0');
		var m1 = (today.getMonth() + 1).toString().padStart(2, '0');
		var d1 = today.getDate().toString().padStart(2, '0');

		var age = Math.floor((Number(y1 + m1 + d1) - Number(y2 + m2 + d2)) / 100000) * 10;

		$('.user_age').text(age + ' 代');
	} else {
		$('.user_age').text('--');
	}

	var certification = $('#hidden_certification').val();
	var certification_array = certification.split(',');

	$.each(certification_array, function(index, val) {
		$('input[name="certification[]"]').each(function() {
			if(val == this.value)
					this.checked = true;
		});
	});

	$("#tab_sake").addClass("nomitai_set");
	$('#tab_main').createTabs({
		text : $('#tab_main ul')
	});
});

</script>
</html>
