<?php

function displaySeimaiRate($rice_used, $seimai_rate)
{
	$seimai = "";
	$rice_array = explode('/', $rice_used);
	$seimai_array = explode(',', $seimai_rate);

	for($i = 0; $i < count($seimai_array); $i++)
	{
		if(count($rice_array) > 0 && $i < count($rice_array))
		{
			$rice_entry = explode(',', $rice_array[$i]);

			if($rice_entry[1] == "1")
			{
				$seimai .= "麹米:";
			}
			else if($rice_entry[1] == "2")
			{
				$seimai .= "掛米:";
			}
		}

		if($seimai_array[$i] != "")
			$seimai .= $seimai_array[$i]."%";

		if($i < (count($seimai_array) - 1) && $seimai_array[$i + 1] != "")
		{
			$seimai .= " / ";
		}
	}

	return $seimai;
}

function displayOxidation($oxidation_level)
{
	$oxidation_array = explode(',', $oxidation_level);
	$oxidation = "";

	if(count($oxidation_array) == 1)
	{
		$oxidation = $oxidation_array[0];
	}
	else
	{
		if($oxidation_array[0] == $oxidation_array[1])
		{
			$oxidation = $oxidation_array[0];
		}
		else
		{
			if($oxidation_array[0] != null && $oxidation_array[1] != null)
				$oxidation = $oxidation_array[0].'～'.$oxidation_array[1];
			else if($oxidation_array[0] != null && $oxidation_array[1] == null)
				$oxidation = $oxidation_array[0] ."以上";
			else if($oxidation_array[0] == null && $oxidation_array[1] != null)
				$oxidation = $oxidation_array[1] ."以下";
		}
	}
	return $oxidation;
}

function displaySyudo($jsake_level)
{
	$syudo_array = explode(',', $jsake_level);
	$syudo = "";

	if(count($syudo_array) == 1)
	{
		$syudo = $syudo_array[0];
	}
	else
	{
		if($syudo_array[0] == $syudo_array[1])
		{
			$syudo = $syudo_array[0];
		}
		else
		{
			if($syudo_array[0] != null && $syudo_array[1] != null)
				$syudo = $syudo_array[0].'～'.$syudo_array[1];
			else if($syudo_array[0] != null && $syudo_array[1] == null)
				$syudo = $syudo_array[0] ."以上";
			else if($syudo_array[0] == null && $syudo_array[1] != null)
				$syudo = $syudo_array[1] ."以下";
		}
	}
	return $syudo;
}

function displayAlcohol($alcohol_level)
{
	$alcohol_array = explode(',', $alcohol_level);
	$alcohol = "";

	if(count($alcohol_array) == 1)
	{
		$alcohol = $alcohol_array[0]."度";
	}
	else
	{
		if($alcohol_array[0] == $alcohol_array[1])
		{
			$alcohol = $alcohol_array[0]."度";
		}
		else
		{
			if($alcohol_array[0] != null && $alcohol_array[1] != null)
				$alcohol = $alcohol_array[0].'～'.$alcohol_array[1].'度';
			else if($alcohol_array[0] != null && $alcohol_array[1] == null)
				$alcohol = $alcohol_array[0] ."度以上";
			else if($alcohol_array[0] == null && $alcohol_array[1] != null)
				$alcohol = $alcohol_array[1] ."度以下";
		}
	}
	return $alcohol;
}

function displayRice($rice_used)
{
	$rice_array = explode('/', $rice_used);
	$rice_value = "";

	$db = opendatabase("sake.db");

	for($i = 0; $i < count($rice_array); $i++)
	{
		$rice_entry = explode(',', $rice_array[$i]);

		$sql = "SELECT SAKE_RICE.rice_name, SAKE_RICE.rice_kanji, SAKE_RICE.rice_kana FROM SAKE_RICE WHERE SAKE_RICE.rice_name = '$rice_entry[0]'";
		$sake_result = executequery($db, $sql);
		$record = getnextrow($sake_result);

		if($rice_entry[1] == "1")
		{
			$rice_value .= "麹米:";
		}
		else if($rice_entry[1] == "2")
		{
			$rice_value .= "掛米:";
		}

		if($rice_entry[0] != "")
		{
			$rice_kanji = $record ? $record["rice_kanji"] : $rice_used;
			$rice_value .= $rice_kanji;
			break;
		}

		$rice_value += $rice_kanji;

		if($rice_entry[2] != "")
		{
			$rice_value .= '[' .$rice_entry[2] .'%]';
		}

		if($i < (count($rice_array) - 1))
			$rice_value .= ' / ';
	}

	return $rice_value;
}

function writeSakeContainer($sakagura_id, $sakagura_name)
{
  print('<div class="sake_container">');
    print('<div id="registory_sake_container">');
      print('<div class="edit_sake_title">日本酒情報 登録・編集</div>');
      print('<div class="edit_sake_note">');
        print('登録・編集する情報に誤りがないことをご確認ください。また、入力された情報が事実と異なる場合、管理者側から修正・削除させていただくことがございますので、ご了承ください。');
      print('</div>');

      print('<form class="form" name="form" method="post">');

        print('<div class="sakedata">');

          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">酒蔵<span class="row_title_red">必須</span></div>');
            print('</div>');
            print('<div class="row_select_brewery">');
              print('<div class="column1_container">');
                print('<div class="column1"><input type="button" name="add_sakagura_button" value="酒蔵の選択"></div>');
              print('</div>');
              print('<input type="text" disabled name="sakagura_name" value = ' .$sakagura_name .'>');
              print('<input type="hidden" name="sakagura_id" value= ' .$sakagura_id .'>');
            print('</div>');
          print('</div>');

          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">日本酒の名称<span>必須</span></div>');
            print('</div>');

            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">日本酒名</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2"><label><input type="text" name="sake_name"></label></div>');
            print('</div>');

            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">ひらがな</div>');
                print('<span>全角かな</span>');
              print('</div>');
              print('<div class="column2"><label><input type="text" name="sake_read"></label></div>');
            print('</div>');

            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">ローマ字</div>');
                print('<span>半角英数字</span>');
              print('</div>');
              print('<div class="column2"><label><input type="text" name="sake_english"></label></div>');
            print('</div>');

            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">その他の日本酒名 ※上記以外の旧字体・異字体(例:桜/櫻など)を含む日本酒名も登録したい場合は以下に入力してください</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2"><label><input type="text" name="sake_search"></label></div>');
            print('</div>');
          print('</div>');

          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">醸造年度・Brewery Year(BY)<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">※醸造年度とは、酒造業界の1年間を表す単位のことで、7/1から翌年の6/30までの期間をいいます</div>');
              print('</div>');
              print('<div class="column2">');
                print('<label><SELECT name="year_made">');
                  print('<OPTION VALUE="">----</OPTION>');
                  print('<OPTION VALUE=2021>2021年 令和3年</OPTION>');
                  print('<OPTION VALUE=2020>2020年 令和2年</OPTION>');
                  print('<OPTION VALUE=2019>2019年 令和1年</OPTION>');
                  print('<OPTION VALUE=2018>2018年 平成30年</OPTION>');
                  print('<OPTION VALUE=2017>2017年 平成29年</OPTION>');
                  print('<OPTION VALUE=2016>2016年 平成28年</OPTION>');
                  print('<OPTION VALUE=2015>2015年 平成27年</OPTION>');
                  print('<OPTION VALUE=2014>2014年 平成26年</OPTION>');
                  print('<OPTION VALUE=2013>2013年 平成25年</OPTION>');
                  print('<OPTION VALUE=2012>2012年 平成24年</OPTION>');
                  print('<OPTION VALUE=2011>2011年 平成23年</OPTION>');
                  print('<OPTION VALUE=2010>2010年 平成22年</OPTION>');
                  print('<OPTION VALUE=2009>2009年 平成21年</OPTION>');
                  print('<OPTION VALUE=2008>2008年 平成20年</OPTION>');
                  print('<OPTION VALUE=2007>2007年 平成19年</OPTION>');
                  print('<OPTION VALUE=2006>2006年 平成18年</OPTION>');
                  print('<OPTION VALUE=2005>2005年 平成17年</OPTION>');
                  print('<OPTION VALUE=2004>2004年 平成16年</OPTION>');
                  print('<OPTION VALUE=2003>2003年 平成15年</OPTION>');
                  print('<OPTION VALUE=2002>2002年 平成14年</OPTION>');
                  print('<OPTION VALUE=2001>2001年 平成13年</OPTION>');
                  print('<OPTION VALUE=2000>2000年 平成12年</OPTION>');
                  print('<OPTION VALUE=1999>1999年 平成11年</OPTION>');
                  print('<OPTION VALUE=1998>1998年 平成10年</OPTION>');
                  print('<OPTION VALUE=1997>1997年 平成9年</OPTION>');
                  print('<OPTION VALUE=1996>1996年 平成8年</OPTION>');
                  print('<OPTION VALUE=1995>1995年 平成7年</OPTION>');
                  print('<OPTION VALUE=1994>1994年 平成6年</OPTION>');
                  print('<OPTION VALUE=1993>1993年 平成5年</OPTION>');
                  print('<OPTION VALUE=1992>1992年 平成4年</OPTION>');
                  print('<OPTION VALUE=1991>1991年 平成3年</OPTION>');
                  print('<OPTION VALUE=1990>1990年 平成2年</OPTION>');
                  print('<OPTION VALUE=1989>1989年 平成1年</OPTION>');
                  print('<OPTION VALUE=1988>1988年 昭和63年</OPTION>');
                  print('<OPTION VALUE=1987>1987年 昭和62年</OPTION>');
                  print('<OPTION VALUE=1986>1986年 昭和61年</OPTION>');
                  print('<OPTION VALUE=1985>1985年 昭和60年</OPTION>');
                  print('<OPTION VALUE=1984>1984年 昭和59年</OPTION>');
                  print('<OPTION VALUE=1983>1983年 昭和58年</OPTION>');
                  print('<OPTION VALUE=1982>1982年 昭和57年</OPTION>');
                  print('<OPTION VALUE=1981>1981年 昭和56年</OPTION>');
                  print('<OPTION VALUE=1980>1980年 昭和55年</OPTION>');
                  print('<OPTION VALUE=1979>1979年 昭和54年</OPTION>');
                  print('<OPTION VALUE=1978>1978年 昭和53年</OPTION>');
                  print('<OPTION VALUE=1977>1977年 昭和52年</OPTION>');
                  print('<OPTION VALUE=1976>1976年 昭和51年</OPTION>');
                  print('<OPTION VALUE=1975>1975年 昭和50年</OPTION>');
                  print('<OPTION VALUE=1974>1974年 昭和49年</OPTION>');
                  print('<OPTION VALUE=1973>1973年 昭和48年</OPTION>');
                  print('<OPTION VALUE=1972>1972年 昭和47年</OPTION>');
                  print('<OPTION VALUE=1971>1971年 昭和46年</OPTION>');
                  print('<OPTION VALUE=1970>1970年 昭和45年</OPTION>');
                print('</SELECT></label>');
              print('</div>');
            print('</div>');
          print('</div>');

          // 特定名称
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">特定名称<span></span></div>');
            print('</div>');

            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">1つのみ選択可</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2_tokuteimeisho">');
                print('<label><input type="radio" name="special_name" value="11">普通酒</label>');
                print('<label><input type="radio" name="special_name" value="21">本醸造酒</label>');
                print('<label><input type="radio" name="special_name" value="22">特別本醸造酒</label>');
                print('<label><input type="radio" name="special_name" value="31">純米酒</label>');
                print('<label><input type="radio" name="special_name" value="32">特別純米酒</label>');
                print('<label><input type="radio" name="special_name" value="33">純米吟醸酒</label>');
                print('<label><input type="radio" name="special_name" value="34">純米大吟醸酒</label>');
                print('<label><input type="radio" name="special_name" value="43">吟醸酒</label>');
                print('<label><input type="radio" name="special_name" value="44">大吟醸酒</label>');
                print('<label><input type="radio" name="special_name" value="45">非公開</label>');
                print('<div><label><input type="radio" name="special_name" value="90">その他</label><input type="text" name="special_name_other" id="special_name_other"></div>');
              print('</div>');
            print('</div>'); // row
          print('</div>'); // row_container

          // Alc
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">Alc度数<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">※範囲を表す場合は上限の数値を(&nbsp;&nbsp;)内のフォームに入力してください(例:15%～16%)</div>');
                print('<span>半角数字</span>');
              print('</div>');
              print('<div class="column2_range">');
                print('<div><input type="text" name="alcohol_level[]" value= "">&nbsp;%&nbsp;(～&nbsp;</div>');
                print('<div><input type="text" name="alcohol_level[]" value= ""> &nbsp;%&nbsp;) </div>');
              print('</div>');
            print('</div>');
          print('</div>');

          // 原材料
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">原材料<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row dialog_ingredient">');
              print('<div class="column1_container">');
                print('<div class="column1">複数選択可</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2_ingredient">');
                print('<label><input type="checkbox" name="ingredients[]" value="10" kanji="米">米</label>');
                print('<label><input type="checkbox" name="ingredients[]" value="11" kanji="米麹">米麹</label>');
                print('<label><input type="checkbox" name="ingredients[]" value="12" kanji="醸造アルコール">醸造アルコール</label>');
                print('<label><input type="checkbox" name="ingredients[]" value="13" kanji="糖類">糖類</label>');
                print('<label><input type="checkbox" name="ingredients[]" value="14" kanji="酸味料">酸味料</label>');
                print('<label><input type="checkbox" name="ingredients[]" value="15" kanji="調味料">調味料</label>');
                print('<div><label><input type="checkbox" name="ingredients[]" value="90" kanji="その他" id="ingredients_checked">その他</label><input type="text" name="ingredients_other" id="ingredients_other"></div>');
              print('</div>');
            print('</div>');
          print('</div>');

          // 原料米・精米歩合
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">原料米・精米歩合<!--<span></span>--></div>');
            print('</div>');
            // 原料米1
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">原料米1</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2">');
                print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">A.&nbsp;原料米1の品種名(例:山田錦)を選択してください</div>');
                    print('<label><SELECT name="rice_used" id="rice_used">');
                      print('<OPTION VALUE="">----</OPTION>');
                      print('<OPTION VALUE="kokusanmai" kanji="国産米">国産米<!--(こくさんまい)--></OPTION>');
                      print('<OPTION VALUE="yamadanishiki" kanji="山田錦">山田錦<!--(やまだにしき)--></OPTION>');
                      print('<OPTION VALUE="gohyakumangoku" kanji="五百万石">五百万石<!--(ごひゃくまんごく)--></OPTION>');
                      print('<OPTION VALUE="omachi" kanji="雄町">雄町<!--(おまち)--></OPTION>');
                      print('<OPTION VALUE="miyamanishiki" kanji="美山錦">美山錦<!--(みやまにしき)--></OPTION>');
                      print('<OPTION VALUE="aiyama" kanji="愛山">愛山<!--(あいやま)--></OPTION>');
                      print('<OPTION VALUE="akitashukomachi" kanji="秋田酒こまち">秋田酒こまち<!--(あきたさけこまち)--></OPTION>');
                      print('<OPTION VALUE="kamenoo" kanji="亀の尾">亀の尾<!--(かめのお)--></OPTION>');
                      print('<OPTION VALUE="ginginga" kanji="吟ぎんが">吟ぎんが<!--(ぎんぎんが)--></OPTION>');
                      print('<OPTION VALUE="ginnosei" kanji="吟の精">吟の精<!--(ぎんのせい)--></OPTION>');
                      print('<OPTION VALUE="gimpu" kanji="吟風">吟風<!--(ぎんぷう)--></OPTION>');
                      print('<OPTION VALUE="kuranohana" kanji="蔵の華">蔵の華<!--(くらのはな)--></OPTION>');
                      print('<OPTION VALUE="koshitanrei" kanji="越淡麗">越淡麗<!--(こしたんれい)--></OPTION>');
                      print('<OPTION VALUE="sakemirai" kanji="酒未来">酒未来<!--(さけみらい)--></OPTION>');
                      print('<OPTION VALUE="suisei" kanji="彗星">彗星<!--(すいせい)--></OPTION>');
                      print('<OPTION VALUE="dewasansan" kanji="出羽燦々">出羽燦々<!--(でわさんさん)--></OPTION>');
                      print('<OPTION VALUE="dewanosato" kanji="出羽の里">出羽の里<!--(でわのさと)--></OPTION>');
                      print('<OPTION VALUE="hattan" kanji="八反">八反<!--(はったん)--></OPTION>');
                      print('<OPTION VALUE="hattannishiki" kanji="八反錦">八反錦<!--(はったんにしき)--></OPTION>');
                      print('<OPTION VALUE="hanaomoi" kanji="華想い">華想い<!--(はなおもい)--></OPTION>');
                      print('<OPTION VALUE="hanafubuki" kanji="華吹雪">華吹雪<!--(はなふぶき)--></OPTION>');
                      print('<OPTION VALUE="hitogokochi" kanji="ひとごこち">ひとごこち</OPTION>');
                      print('<OPTION VALUE="misatonishiki" kanji="美郷錦">美郷錦<!--(みさとにしき)--></OPTION>');
                      print('<OPTION VALUE="yamadaho" kanji="山田穂">山田穂<!--(やまだぼ)--></OPTION>');
                      print('<OPTION VALUE="yumenoka" kanji="夢の香">夢の香<!--(ゆめのかおり)--></OPTION>');
                      print('<OPTION VALUE="wataribune" kanji="渡船">渡船<!--(わたりぶね)--></OPTION>');
                      print('<OPTION VALUE="other" kanji="その他">その他</OPTION>');
                    print('</SELECT></label>');
                    print('<div id="rice_used_other">');
                      print('<div class="rice_used_other_text">その他の品種名を入力してください</div>');
                      print('<label class="rice_used_other_input"><input type="text" name="rice_used_other"></label>');
                    print('</div>');
                  print('</div>');
                print('</div>');

                print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">B.&nbsp;原料米1の精米歩合を入力してください</div>');
                    print('<label class="rice_used_other_input"><input type="text" name="seimai_rate" id="seimai_rate">%</label>');
                  print('</div>');
                print('</div>');

                print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">C.&nbsp;原料米1について麹米・掛米を指定する場合は選択してください</div>');
                    print('<label><SELECT name="kakemai">');
                      print('<OPTION VALUE="0" kanji="">----</OPTION>');
                      print('<OPTION VALUE="1" kanji="麹米">麹米</OPTION>');
                      print('<OPTION VALUE="2" kanji="掛米">掛米</OPTION>');
                    print('</SELECT></label>');
                  print('</div>');
                print('</div>');

                /*print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">D.&nbsp;原料米全体に占める原料米1の割合を指定する場合は入力してください</div>');
                    print('<label class="rice_used_other_input"><input type="text" name="kakemai_rate">%</label>');
                  print('</div>');
                print('</div>');*/
              print('</div>');
            print('</div>');

            // 原料米2
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">原料米2</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2">');
                print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">A.&nbsp;原料米2の品種名(例:山田錦)を選択してください</div>');
                    print('<label><SELECT name="rice_used2" id="rice_used2">');
                      print('<OPTION VALUE="">----</OPTION>');
											print('<OPTION VALUE="kokusanmai" kanji="国産米">国産米<!--(こくさんまい)--></OPTION>');
                      print('<OPTION VALUE="yamadanishiki" kanji="山田錦">山田錦<!--(やまだにしき)--></OPTION>');
                      print('<OPTION VALUE="gohyakumangoku" kanji="五百万石">五百万石<!--(ごひゃくまんごく)--></OPTION>');
                      print('<OPTION VALUE="omachi" kanji="雄町">雄町<!--(おまち)--></OPTION>');
                      print('<OPTION VALUE="miyamanishiki" kanji="美山錦">美山錦<!--(みやまにしき)--></OPTION>');
                      print('<OPTION VALUE="aiyama" kanji="愛山">愛山<!--(あいやま)--></OPTION>');
                      print('<OPTION VALUE="akitashukomachi" kanji="秋田酒こまち">秋田酒こまち<!--(あきたさけこまち)--></OPTION>');
                      print('<OPTION VALUE="kamenoo" kanji="亀の尾">亀の尾<!--(かめのお)--></OPTION>');
                      print('<OPTION VALUE="ginginga" kanji="吟ぎんが">吟ぎんが<!--(ぎんぎんが)--></OPTION>');
                      print('<OPTION VALUE="ginnosei" kanji="吟の精">吟の精<!--(ぎんのせい)--></OPTION>');
                      print('<OPTION VALUE="gimpu" kanji="吟風">吟風<!--(ぎんぷう)--></OPTION>');
                      print('<OPTION VALUE="kuranohana" kanji="蔵の華">蔵の華<!--(くらのはな)--></OPTION>');
                      print('<OPTION VALUE="koshitanrei" kanji="越淡麗">越淡麗<!--(こしたんれい)--></OPTION>');
                      print('<OPTION VALUE="sakemirai" kanji="酒未来">酒未来<!--(さけみらい)--></OPTION>');
                      print('<OPTION VALUE="suisei" kanji="彗星">彗星<!--(すいせい)--></OPTION>');
                      print('<OPTION VALUE="dewasansan" kanji="出羽燦々">出羽燦々<!--(でわさんさん)--></OPTION>');
                      print('<OPTION VALUE="dewanosato" kanji="出羽の里">出羽の里<!--(でわのさと)--></OPTION>');
                      print('<OPTION VALUE="hattan" kanji="八反">八反<!--(はったん)--></OPTION>');
                      print('<OPTION VALUE="hattannishiki" kanji="八反錦">八反錦<!--(はったんにしき)--></OPTION>');
                      print('<OPTION VALUE="hanaomoi" kanji="華想い">華想い<!--(はなおもい)--></OPTION>');
                      print('<OPTION VALUE="hanafubuki" kanji="華吹雪">華吹雪<!--(はなふぶき)--></OPTION>');
                      print('<OPTION VALUE="hitogokochi" kanji="ひとごこち">ひとごこち</OPTION>');
                      print('<OPTION VALUE="misatonishiki" kanji="美郷錦">美郷錦<!--(みさとにしき)--></OPTION>');
                      print('<OPTION VALUE="yamadaho" kanji="山田穂">山田穂<!--(やまだぼ)--></OPTION>');
                      print('<OPTION VALUE="yumenoka" kanji="夢の香">夢の香<!--(ゆめのかおり)--></OPTION>');
                      print('<OPTION VALUE="wataribune" kanji="渡船">渡船<!--(わたりぶね)--></OPTION>');
                      print('<OPTION VALUE="other" kanji="その他">その他</OPTION>');
                    print('</SELECT></label>');
                    print('<div id="rice_used_other2">');
                      print('<div class="rice_used_other_text">その他の品種名を入力してください</div>');
                      print('<label><input type="text" name="rice_used_other2"></label>');
                    print('</div>');
                  print('</div>');
                print('</div>');

                print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">B.&nbsp;原料米2の精米歩合を入力してください</div>');
                    print('<label class="rice_used_other_input"><input type="text" name="seimai_rate2" id="seimai_rate2" value="">%</label>');
                  print('</div>');
                print('</div>');

                print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">C.&nbsp;原料米2について麹米・掛米を指定する場合は選択してください</div>');
                    print('<label><SELECT name="kakemai2">');
                      print('<OPTION VALUE="0" kanji="">----</OPTION>');
                      print('<OPTION VALUE="1" kanji="麹米">麹米</OPTION>');
                      print('<OPTION VALUE="2" kanji="掛米">掛米</OPTION>');
                    print('</SELECT></label>');
                  print('</div>');
                print('</div>');

                /*print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">D.&nbsp;原料米全体に占める原料米2の割合を指定する場合は入力してください</div>');
                    print('<label class="rice_used_other_input"><input type="text" name="kakemai_rate2">%</label>');
                  print('</div>');
                print('</div>');*/
              print('</div>');
            print('</div>');

            // 原料米3
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">原料米3</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2">');
                print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">A.&nbsp;原料米3の品種名(例:山田錦)を選択してください</div>');
                    print('<label><SELECT name="rice_used3" id="rice_used3">');
                      print('<OPTION VALUE="">----</OPTION>');
                      print('<OPTION VALUE="kokusanmai" kanji="国産米">国産米<!--(こくさんまい)--></OPTION>');
                      print('<OPTION VALUE="yamadanishiki" kanji="山田錦">山田錦<!--(やまだにしき)--></OPTION>');
                      print('<OPTION VALUE="gohyakumangoku" kanji="五百万石">五百万石<!--(ごひゃくまんごく)--></OPTION>');
                      print('<OPTION VALUE="omachi" kanji="雄町">雄町<!--(おまち)--></OPTION>');
                      print('<OPTION VALUE="miyamanishiki" kanji="美山錦">美山錦<!--(みやまにしき)--></OPTION>');
                      print('<OPTION VALUE="aiyama" kanji="愛山">愛山<!--(あいやま)--></OPTION>');
                      print('<OPTION VALUE="akitashukomachi" kanji="秋田酒こまち">秋田酒こまち<!--(あきたさけこまち)--></OPTION>');
                      print('<OPTION VALUE="kamenoo" kanji="亀の尾">亀の尾<!--(かめのお)--></OPTION>');
                      print('<OPTION VALUE="ginginga" kanji="吟ぎんが">吟ぎんが<!--(ぎんぎんが)--></OPTION>');
                      print('<OPTION VALUE="ginnosei" kanji="吟の精">吟の精<!--(ぎんのせい)--></OPTION>');
                      print('<OPTION VALUE="gimpu" kanji="吟風">吟風<!--(ぎんぷう)--></OPTION>');
                      print('<OPTION VALUE="kuranohana" kanji="蔵の華">蔵の華<!--(くらのはな)--></OPTION>');
                      print('<OPTION VALUE="koshitanrei" kanji="越淡麗">越淡麗<!--(こしたんれい)--></OPTION>');
                      print('<OPTION VALUE="sakemirai" kanji="酒未来">酒未来<!--(さけみらい)--></OPTION>');
                      print('<OPTION VALUE="suisei" kanji="彗星">彗星<!--(すいせい)--></OPTION>');
                      print('<OPTION VALUE="dewasansan" kanji="出羽燦々">出羽燦々<!--(でわさんさん)--></OPTION>');
                      print('<OPTION VALUE="dewanosato" kanji="出羽の里">出羽の里<!--(でわのさと)--></OPTION>');
                      print('<OPTION VALUE="hattan" kanji="八反">八反<!--(はったん)--></OPTION>');
                      print('<OPTION VALUE="hattannishiki" kanji="八反錦">八反錦<!--(はったんにしき)--></OPTION>');
                      print('<OPTION VALUE="hanaomoi" kanji="華想い">華想い<!--(はなおもい)--></OPTION>');
                      print('<OPTION VALUE="hanafubuki" kanji="華吹雪">華吹雪<!--(はなふぶき)--></OPTION>');
                      print('<OPTION VALUE="hitogokochi" kanji="ひとごこち">ひとごこち</OPTION>');
                      print('<OPTION VALUE="misatonishiki" kanji="美郷錦">美郷錦<!--(みさとにしき)--></OPTION>');
                      print('<OPTION VALUE="yamadaho" kanji="山田穂">山田穂<!--(やまだぼ)--></OPTION>');
                      print('<OPTION VALUE="yumenoka" kanji="夢の香">夢の香<!--(ゆめのかおり)--></OPTION>');
                      print('<OPTION VALUE="wataribune" kanji="渡船">渡船<!--(わたりぶね)--></OPTION>');
                      print('<OPTION VALUE="other" kanji="その他">その他</OPTION>');
                    print('</SELECT></label>');
                    print('<div id="rice_used_other3">');
                      print('<div class="rice_used_other_text">その他の品種名を入力してください</div>');
                      print('<label><input type="text" name="rice_used_other3"></label>');
                    print('</div>');
                  print('</div>');
                print('</div>');

                print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">B.&nbsp;原料米3の精米歩合を入力してください</div>');
                    print('<label class="rice_used_other_input"><input type="text" name="seimai_rate3" id="seimai_rate3" value="">%</label>');
                  print('</div>');
                print('</div>');

                print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">C.&nbsp;原料米3について麹米・掛米を指定する場合は選択してください</div>');
                    print('<label><SELECT name="kakemai3">');
                      print('<OPTION VALUE="0" kanji="">----</OPTION>');
                      print('<OPTION VALUE="1" kanji="麹米">麹米</OPTION>');
                      print('<OPTION VALUE="2" kanji="掛米">掛米</OPTION>');
                    print('</SELECT></label>');
                  print('</div>');
                print('</div>');

                /*print('<div class="column2_riceitem_container">');
                  print('<div class="column2_riceitem">');
                    print('<div class="column2_riceitem_text">D.&nbsp;原料米全体に占める原料米3の割合を指定する場合は入力してください</div>');
                    print('<label class="rice_used_other_input"><input type="text" name="kakemai_rate3">%</label>');
                  print('</div>');
                print('</div>');*/
              print('</div>');
            print('</div>');
          print('</div>'); // <!-- row_container -->

          // 日本酒度
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">日本酒度<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">※範囲を表す場合は上限の数値を(&nbsp;&nbsp;)内のフォームに入力してください(例:+2.0～+3.0)</div>');
                print('<span>半角数字</span>');
              print('</div>');
              print('<div class="column2_range">');
                print('<div><input type="text" name="jsake_level[]" value= "">&nbsp;&nbsp;(～&nbsp;</div>');
                print('<div><input type="text" name="jsake_level[]" value= "">&nbsp;&nbsp;)</div>');
              print('</div>');
            print('</div>');
          print('</div>');

          // 酸度
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">酸度<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">※範囲を表す場合は上限の数値を(&nbsp;&nbsp;)内のフォームに入力してください(例:1.0～1.2)</div>');
                print('<span>半角数字</span>');
              print('</div>');
              print('<div class="column2_range">');
                print('<div><input type="text" name="oxidation_level[]" value= "">&nbsp;&nbsp;(～&nbsp;</div>');
                print('<div><input type="text" name="oxidation_level[]" value= "">&nbsp;&nbsp;)</div>');
              print('</div>');
            print('</div>');
          print('</div>');

          // アミノ酸度
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">アミノ酸度<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">※範囲を表す場合は上限の数値を(&nbsp;&nbsp;)内のフォームに入力してください(例:1.0～1.2)</div>');
                print('<span>半角数字</span>');
              print('</div>');
              print('<div class="column2_range">');
                print('<div><input type="text" name="amino_level[]" value= "">&nbsp;&nbsp;(～&nbsp;</div>');
                print('<div><input type="text" name="amino_level[]" value= "">&nbsp;&nbsp;)</div>');
              print('</div>');
            print('</div>');
          print('</div>');

          // 酵母
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">酵母<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row dialog_yeast">');
              print('<div class="column1_container">');
                print('<div class="column1">複数選択可</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2_yeast">');
                print('<label><input type="checkbox" name="koubo_used[]" value="10" kanji="協会6号">協会6号・協会601号・新政酵母</label>');
                print('<label><input type="checkbox" name="koubo_used[]" value="11" kanji="協会7号">協会7号・協会701号・真澄酵母</label>');
                print('<label><input type="checkbox" name="koubo_used[]" value="12" kanji="協会9号">協会9号・協会901号・熊本酵母</label>');
                print('<label><input type="checkbox" name="koubo_used[]" value="13" kanji="協会10号">協会10号・協会1001号・小川酵母</label>');
                print('<label><input type="checkbox" name="koubo_used[]" value="14" kanji="協会11号">協会11号・協会1101号</label>');
                print('<label><input type="checkbox" name="koubo_used[]" value="15" kanji="協会14号">協会14号・協会1401号・金沢酵母</label>');
                /*print('<label><input type="checkbox" name="koubo_used[]" value="16" kanji="協会601号">協会601号</label>');*/
                /*print('<label><input type="checkbox" name="koubo_used[]" value="17" kanji="協会701号">協会701号</label>');*/
                /*print('<label><input type="checkbox" name="koubo_used[]" value="18" kanji="協会901号">協会901号</label>');*/
                /*print('<label><input type="checkbox" name="koubo_used[]" value="19" kanji="協会1001号">協会1001号</label>');*/
                /*print('<label><input type="checkbox" name="koubo_used[]" value="29" kanji="協会1101号">協会1101号</label>');*/
                /*print('<label><input type="checkbox" name="koubo_used[]" value="20" kanji="協会1401号">協会1401号</label>');*/
                print('<label><input type="checkbox" name="koubo_used[]" value="21" kanji="協会1501号・秋田流花酵母(AK-1)">協会1501号・秋田流花酵母(AK-1)</label>');
                print('<label><input type="checkbox" name="koubo_used[]" value="22" kanji="協会1601号">協会1601号</label>');
                print('<label><input type="checkbox" name="koubo_used[]" value="23" kanji="協会1701号">協会1701号</label>');
                print('<label><input type="checkbox" name="koubo_used[]" value="24" kanji="協会1801号">協会1801号</label>');
                print('<label><input type="checkbox" name="koubo_used[]" value="30" kanji="協会1901号">協会1901号</label>');
                /*print('<label><input type="checkbox" name="koubo_used[]" value="25" kanji="協会No.28">協会No.28</label>');*/
                /*print('<label><input type="checkbox" name="koubo_used[]" value="26" kanji="協会No.77">協会No.77</label>');*/
                /*print('<label><input type="checkbox" name="koubo_used[]" value="27" kanji="赤色清酒酵母">赤色清酒酵母</label>');*/
                /*print('<label><input type="checkbox" name="koubo_used[]" value="28" kanji="ワイン酵母">ワイン酵母</label>');*/
                print('<div class="column2_yeast_others_container">');
                  print('<div>');
                    print('<label><input type="checkbox" name="koubo_used[]" value="90" kanji="その他1" id="koubo_other_checked">その他1</label>');
                    print('<input type="text" name="koubo_other" id="koubo_other">');
                  print('</div>');
                  print('<div>');
                    print('<label><input type="checkbox" name="koubo_used[]" value="91" kanji="その他2" id="koubo_other_checked2">その他2</label>');
                    print('<input type="text" name="koubo_other2" id="koubo_other2">');
                  print('</div>');
                  print('<div>');
                    print('<label><input type="checkbox" name="koubo_used[]" value="92" kanji="その他3" id="koubo_other_checked3">その他3</label>');
                    print('<input type="text" name="koubo_other3" id="koubo_other3">');
                  print('</div>');
                print('</div>');
              print('</div>');
            print('</div>');
          print('</div>');

          // 製法の特徴
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">製法の特徴<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">複数選択可</div>');
                // <!--<span></span>-->
              print('</div>');
              print('<div class="column2_seiho">');
                print('<label><input name="sake_category[]" type="checkbox" value="11" kanji="無ろ過">無濾過</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="45" kanji="原酒">原酒</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="39" kanji="直汲み・直詰め">直汲み・直詰め</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="33" kanji="生酒・本生">生酒・本生</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="35" kanji="生貯蔵酒">生貯蔵酒</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="34" kanji="生詰酒">生詰酒</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="21" kanji="にごり酒">にごり酒</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="49" kanji="おり酒・おりがらみ・うすにごり・ささにごり">おりがらみ・うすにごり</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="51" kanji="スパークリング">スパークリング</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="42" kanji="きもと">きもと</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="43" kanji="山廃もと">山廃もと</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="38" kanji="しずく酒・しずくしぼり・袋吊り・袋しぼり・斗瓶取り・斗瓶囲い">袋吊り・斗瓶囲い・雫酒</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="41" kanji="槽しぼり">槽しぼり</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="40" kanji="遠心分離">遠心分離</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="22" kanji="あらばしり">あらばしり</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="31" kanji="中取り/中垂/中汲み">中取り・中汲み・中垂れ</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="32" kanji="責め・押切">責め・押切り</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="50" kanji="新酒・初しぼり・しぼりたて">新酒・初しぼり・しぼりたて</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="37" kanji="ひやおろし・秋上がり">ひやおろし・秋上がり</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="48" kanji="古酒・長期貯蔵酒">古酒・長期熟成酒</label>');
                print('<label><input name="sake_category[]" type="checkbox" value="44" kanji="木桶仕込">木桶仕込</label>');
                //<!--<label><input name="sake_category[]" type="checkbox" value="90" path="images/icons/sakecategory18.gif" kanji="その他" name="category_checked">その他<input type="text" name="sake_category_other"></label>-->');
              print('</div>');
            print('</div>');
          print('</div>');

          // 鑑評会・コンクール
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">鑑評会・コンクール<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">鑑評会・コンクール1</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2">');
                print('<label>');
                  print('<input type="text" name="sake_award[]" value= "" placeholder="例：全国新酒鑑評会 2020 金賞">');
                print('</label>');
              print('</div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">鑑評会・コンクール2</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2">');
                print('<label>');
                  print('<input type="text" name="sake_award[]" value= "" placeholder="例：全国新酒鑑評会 2020 金賞">');
                print('</label>');
              print('</div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">鑑評会・コンクール3</div>');
                print('<span>全角かな/半角英数字</span>');
              print('</div>');
              print('<div class="column2">');
                print('<label>');
                  print('<input type="text" name="sake_award[]" value= "" placeholder="例：全国新酒鑑評会 2020 金賞">');
                print('</label>');
              print('</div>');
            print('</div>');
          print('</div>');

          //<!-- おすすめの飲み方 -->
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">おすすめの飲み方<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">複数選択可</div>');
                //<!--<span></span>-->
              print('</div>');
              print('<div class="column2_recommend">');
                print('<label><input type="checkbox" name="recommended_drink[]" value="10">ロック</label>');
                print('<label><input type="checkbox" name="recommended_drink[]" value="11">冷酒</label>');
                print('<label><input type="checkbox" name="recommended_drink[]" value="12">常温</label>');
                print('<label><input type="checkbox" name="recommended_drink[]" value="13">ぬる燗</label>');
                print('<label><input type="checkbox" name="recommended_drink[]" value="14">熱燗</label>');
              print('</div>');
            print('</div>');
          print('</div>');

          //<!-- JANコード -->
          print('<div class="row_container">');
            print('<div class="row_title_container">');
              print('<div class="row_title_sign"></div>');
              print('<div class="row_title">JANコード<!--<span></span>--></div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">JANコード1</div>');
                print('<span>半角数字</span>');
              print('</div>');
              print('<div class="column2">');
                print('<label>');
                  print('<input type="text" name="jas_code[]" value= "">');
                print('</label>');
              print('</div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">JANコード2</div>');
                print('<span>半角数字</span>');
              print('</div>');
              print('<div class="column2">');
                print('<label>');
                  print('<input type="text" name="jas_code[]" value= "">');
                print('</label>');
              print('</div>');
            print('</div>');
            print('<div class="row">');
              print('<div class="column1_container">');
                print('<div class="column1">JANコード3</div>');
                print('<span>半角数字</span>');
              print('</div>');
              print('<div class="column2">');
                print('<label>');
                  print('<input type="text" name="jas_code[]" value= "">');
                print('</label>');
              print('</div>');
            print('</div>');
          print('</div>');

        print('</div>');

      print('</form>');

      print('<div class="edit_sake_button_container">');
        print('<input name="cancel_sake" type="button" value="戻る">');
        print('<input name="confirm_button" type="button" value="確認する">');
        print('<input name="delete_sake" type="button" value="削除">');
      print('</div>');

    print('</div>');
  print('</div>'); // <!--container-->

  return 0;
}

function writeChooseSakagura()
{
  print('<div class="dialog_add_sakagura_background">');
  	print('<div class="dialog_table">');
      print('<div class="dialog_table-cell">');
  			print('<div id="dialog_add_sakagura">');
  				print('<span class="close_add_sakagura">');
  					print('<button class="close_add_sakagura_button"><svg class="close_add_sakagura_prev2020"><use xlink:href="#prev2020"/></svg></button>');
  				print('</span>');

  				print('<div class="add_sakagura_title">酒蔵 選択</div>');
  				print('<div class="add_sakagura_note">');
  					print('以下のフォームに酒蔵名を入力し、登録・編集したい日本酒の酒蔵を選択して「決定する」を押してください。');
  				print('</div>');

  				print('<div class="add_sakagura_form_container">');
  					print('<div class="add_sakagura_form">');
					  print('<input class="add_sakagura_input" autocomplete="off" placeholder="酒蔵名を入力してください" type="text" name="add_sake_name">');
					print('</div>');
  					print('<ul class="add_sakagura_content"></ul>');
  				print('</div>');

  				print('<div class="add_sakagura_button_container">');
  					print('<input type="button" name="add_sakagura_ok" value="決定する">');
  				print('</div>');
  			print('</div>');
  		print('</div>');
  	print('</div>');
  print('</div>');
}

function writeDialogAddSakeConfirm()
{
  print('<div class="dialog_add_sake_background">');
    print('<div class="dialog_table">');
      print('<div class="dialog_table-cell">');
        print('<div id="dialog_add_sake">');
          print('<div class="confirm_note">ご入力いただいた情報に間違いがないかご確認ください。</div>');
          print('<div class="frame">');
            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>酒蔵</div>');
              print('<div class="confirm_item_info dialog_sakagura_name" colspan="4"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>日本酒名</div>');
              print('<div class="confirm_item_info dialog_sake_name"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>ひらがな</div>');
              print('<div class="confirm_item_info dialog_sake_read"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>ローマ字</div>');
              print('<div class="confirm_item_info dialog_sake_english"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>その他の日本酒名</div>');
              print('<div class="confirm_item_info dialog_sake_search"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>醸造年度・Brewery Year(BY)</div>');
              print('<div class="confirm_item_info dialog_year_made"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>特定名称</div>');
              print('<div class="confirm_item_info dialog_special_name"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>Alc度数</div>');
              print('<div class="confirm_item_info">');
                print('<div>');
                  print('<span class="dialog_alcohol_level"></span>');
                  print('<span class="dialog_alcohol_level2"></span>');
                print('</div>');
              print('</div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>原材料</div>');
              print('<div class="confirm_item_info dialog_ingredients"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>原料米</div>');
              print('<div class="confirm_item_info dialog_rice_used"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>精米歩合</div>');
              print('<div class="confirm_item_info dialog_seimai_rate"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>日本酒度</div>');
              print('<div class="confirm_item_info">');
                print('<div>');
                  print('<span class="dialog_jsake_level"></span>');
                  print('<span class="dialog_jsake_level2"></span>');
                print('</div>');
              print('</div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>酸度</div>');
              print('<div class="confirm_item_info">');
                print('<div>');
                  print('<span class="dialog_oxidation_level"></span>');
                  print('<span class="dialog_oxidation_level2"></span>');
                print('</div>');
              print('</div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>アミノ酸度</div>');
              print('<div class="confirm_item_info">');
                print('<div>');
                  print('<span class="dialog_amino_level"></span>');
                  print('<span class="dialog_amino_level2"></span>');
                print('</div>');
              print('</div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>酵母</div>');
              print('<div class="confirm_item_info dialog_koubo_used"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>製法の特徴</div>');
              print('<div class="confirm_item_info dialog_sake_category"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>鑑評会・コンクール</div>');
              print('<div class="confirm_item_info dialog_award_history"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>おすすめの飲み方</div>');
              print('<div class="confirm_item_info dialog_recommended_drink"></div>');
            print('</div>');

            print('<div class="alt">');
              print('<div class="confirm_item_title"><span></span>JANコード</div>');
              print('<div class="confirm_item_info dialog_jas_code"></div>');
            print('</div>');

          print('</div>');

          print('<div class="edit_sake_button_container">');
            print('<input type="button" name="button_back" value="閉じる">');
            print('<input type="button" name="submit_button" value="登録する">');
            print('<input type="button" name="update_button" value="更新する">');
          print('</div>');
        print('</div>');
      print('</div>');
    print('</div>');
  print('</div>');
}

?>
