<?php

function writeSakaguraContainer()
{
	print('<div class="sakagura_container">');
	print('<div class="registory_sakagura_container">');
	  print('<div class="edit_sakagura_title">酒蔵情報 登録・編集</div>');
	  print('<div class="edit_sakagura_note">');
		print('登録・編集する情報に誤りがないことをご確認ください。また、入力された情報が事実と異なる場合、管理者側から修正・削除させていただくことがございますので、ご了承ください。');
	  print('</div>');

	  print('<form class="sakagura_form" name="form">');
		print('<div class="sakagura_wrapper">');

		  print('<div class="row_container">');

			print('<div class="row_title_container">');
			  print('<div class="row_title_sign"></div>');
			  print('<div class="row_title">酒蔵の名称<span>必須</span></div>');
			print('</div>');
			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">会社名 ※法人格(例:株式会社/有限会社など)は入力しないでください</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column2">');
				print('<input type="text" name="sakagura_name">');
			  print('</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">ひらがな</div>');
				print('<span>全角かな</span>');
			  print('</div>');
			  print('<div class="column2">');
				print('<input type="text" name="sakagura_read">');
			  print('</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">ローマ字</div>');
				print('<span>半角英数字</span>');
			  print('</div>');
			  print('<div class="column2">');
				print('<input type="text" name="sakagura_english">');
			  print('</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">その他の会社名 ※上記以外の旧字体・異字体(例:桜/櫻など)を含む会社名も登録したい場合は以下に入力してください</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column2">');
				print('<input type="text" name="sakagura_search[]">');
				print('<input type="text" name="sakagura_search[]">');
				print('<input type="text" name="sakagura_search[]">');
			  print('</div>');
			print('</div>');

		  print('</div>');

		  print('<div class="row_container">');

			print('<div class="row_title_container">');
			  print('<div class="row_title_sign"></div>');
			  print('<div class="row_title">住所</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">郵便番号</div>');
				print('<span>半角数字</span>');
			  print('</div>');
			  print('<div class="column2">');
				print('<input type="text" size="24" name="postal_code">');
			  print('</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">都道府県</div>');
			  print('</div>');
			  print('<div class="column2">');
				print('<SELECT read="" name="pref">');
				  print('<OPTION VALUE="" read="">都道府県の選択</OPTION>');
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
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">住所</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column2">');
				print('<input type="text" name="address">');
			  print('</div>');
			print('</div>');

			/*
			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">住所 かな</div>');
				print('<span>全角漢字かな</span>');
			  print('</div>');
			  print('<div class="column2"><input type="text" name="pref_read"></div>');
			print('</div>');
			*/

		  print('</div>');

		  print('<div class="row_container">');

			print('<div class="row_title_container">');
			  print('<div class="row_title_sign"></div>');
			  print('<div class="row_title">問い合わせ先</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">電話番号</div>');
				print('<span>半角数字</span>');
			  print('</div>');
			  print('<div class="column2"><input type="text" name="phone"></div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">FAX番号</div>');
				print('<span>半角数字</span>');
			  print('</div>');
			  print('<div class="column2"><input type="text" name="fax"></div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">Email</div>');
				print('<span>半角英数字</span>');
			  print('</div>');
			  print('<div class="column2"><input type="text" name="email"></div>');
			print('</div>');

		  print('</div>');

		  print('<div class="row_container">');

			print('<div class="row_title_container">');
			  print('<div class="row_title_sign"></div>');
			  print('<div class="row_title">会社概要</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">ホームページ</div>');
				print('<span>半角英数字</span>');
			  print('</div>');
			  print('<div class="column2">');
				print('<input type="text" name="url[]">');
				print('<input type="text" name="url[]">');
				print('<input type="text" name="url[]">');
			  print('</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">創業・設立</div>');
				print('<!--<span></span>-->');
			  print('</div>');
			  print('<div class="column2">');
				print('<SELECT name="establishment">');
				  print('<OPTION VALUE="">創業・設立年の選択</OPTION>');
				  print('<OPTION VALUE=2019>2019年 (令和1年)</OPTION>');
				  print('<OPTION VALUE=2018>2018年 (平成30年)</OPTION>');
				  print('<OPTION VALUE=2017>2017年 (平成29年)</OPTION>');
				  print('<OPTION VALUE=2016>2016年 (平成28年)</OPTION>');
				  print('<OPTION VALUE=2015>2015年 (平成27年)</OPTION>');
				  print('<OPTION VALUE=2014>2014年 (平成26年)</OPTION>');
				  print('<OPTION VALUE=2013>2013年 (平成25年)</OPTION>');
				  print('<OPTION VALUE=2012>2012年 (平成24年)</OPTION>');
				  print('<OPTION VALUE=2011>2011年 (平成23年)</OPTION>');
				  print('<OPTION VALUE=2010>2010年 (平成22年)</OPTION>');
				  print('<OPTION VALUE=2009>2009年 (平成21年)</OPTION>');
				  print('<OPTION VALUE=2008>2008年 (平成20年)</OPTION>');
				  print('<OPTION VALUE=2007>2007年 (平成19年)</OPTION>');
				  print('<OPTION VALUE=2006>2006年 (平成18年)</OPTION>');
				  print('<OPTION VALUE=2005>2005年 (平成17年)</OPTION>');
				  print('<OPTION VALUE=2004>2004年 (平成16年)</OPTION>');
				  print('<OPTION VALUE=2003>2003年 (平成15年)</OPTION>');
				  print('<OPTION VALUE=2002>2002年 (平成14年)</OPTION>');
				  print('<OPTION VALUE=2001>2001年 (平成13年)</OPTION>');
				  print('<OPTION VALUE=2000>2000年 (平成12年)</OPTION>');
				  print('<OPTION VALUE=1999>1999年 (平成11年)</OPTION>');
				  print('<OPTION VALUE=1998>1998年 (平成10年)</OPTION>');
				  print('<OPTION VALUE=1997>1997年 (平成9年)</OPTION>');
				  print('<OPTION VALUE=1996>1996年 (平成8年)</OPTION>');
				  print('<OPTION VALUE=1995>1995年 (平成7年)</OPTION>');
				  print('<OPTION VALUE=1994>1994年 (平成6年)</OPTION>');
				  print('<OPTION VALUE=1993>1993年 (平成5年)</OPTION>');
				  print('<OPTION VALUE=1992>1992年 (平成4年)</OPTION>');
				  print('<OPTION VALUE=1991>1991年 (平成3年)</OPTION>');
				  print('<OPTION VALUE=1990>1990年 (平成2年)</OPTION>');
				  print('<OPTION VALUE=1989>1989年 (平成1年)</OPTION>');
				  print('<OPTION VALUE=1988>1988年 (昭和63年)</OPTION>');
				  print('<OPTION VALUE=1987>1987年 (昭和62年)</OPTION>');
				  print('<OPTION VALUE=1986>1986年 (昭和61年)</OPTION>');
				  print('<OPTION VALUE=1985>1985年 (昭和60年)</OPTION>');
				  print('<OPTION VALUE=1984>1984年 (昭和59年)</OPTION>');
				  print('<OPTION VALUE=1983>1983年 (昭和58年)</OPTION>');
				  print('<OPTION VALUE=1982>1982年 (昭和57年)</OPTION>');
				  print('<OPTION VALUE=1981>1981年 (昭和56年)</OPTION>');
				  print('<OPTION VALUE=1980>1980年 (昭和55年)</OPTION>');
				  print('<OPTION VALUE=1979>1979年 (昭和54年)</OPTION>');
				  print('<OPTION VALUE=1978>1978年 (昭和53年)</OPTION>');
				  print('<OPTION VALUE=1977>1977年 (昭和52年)</OPTION>');
				  print('<OPTION VALUE=1976>1976年 (昭和51年)</OPTION>');
				  print('<OPTION VALUE=1975>1975年 (昭和50年)</OPTION>');
				  print('<OPTION VALUE=1974>1974年 (昭和49年)</OPTION>');
				  print('<OPTION VALUE=1973>1973年 (昭和48年)</OPTION>');
				  print('<OPTION VALUE=1972>1972年 (昭和47年)</OPTION>');
				  print('<OPTION VALUE=1971>1971年 (昭和46年)</OPTION>');
				  print('<OPTION VALUE=1970>1970年 (昭和45年)</OPTION>');
				  print('<OPTION VALUE=1969>1969年 (昭和44年)</OPTION>');
				  print('<OPTION VALUE=1968>1968年 (昭和43年)</OPTION>');
				  print('<OPTION VALUE=1967>1967年 (昭和42年)</OPTION>');
				  print('<OPTION VALUE=1966>1966年 (昭和41年)</OPTION>');
				  print('<OPTION VALUE=1965>1965年 (昭和40年)</OPTION>');
				  print('<OPTION VALUE=1964>1964年 (昭和39年)</OPTION>');
				  print('<OPTION VALUE=1963>1963年 (昭和38年)</OPTION>');
				  print('<OPTION VALUE=1962>1962年 (昭和37年)</OPTION>');
				  print('<OPTION VALUE=1961>1961年 (昭和36年)</OPTION>');
				  print('<OPTION VALUE=1960>1960年 (昭和35年)</OPTION>');
				  print('<OPTION VALUE=1959>1959年 (昭和34年)</OPTION>');
				  print('<OPTION VALUE=1958>1958年 (昭和33年)</OPTION>');
				  print('<OPTION VALUE=1957>1957年 (昭和32年)</OPTION>');
				  print('<OPTION VALUE=1956>1956年 (昭和31年)</OPTION>');
				  print('<OPTION VALUE=1955>1955年 (昭和30年)</OPTION>');
				  print('<OPTION VALUE=1954>1954年 (昭和29年)</OPTION>');
				  print('<OPTION VALUE=1953>1953年 (昭和28年)</OPTION>');
				  print('<OPTION VALUE=1952>1952年 (昭和27年)</OPTION>');
				  print('<OPTION VALUE=1951>1951年 (昭和26年)</OPTION>');
				  print('<OPTION VALUE=1950>1950年 (昭和25年)</OPTION>');
				  print('<OPTION VALUE=1949>1949年 (昭和24年)</OPTION>');
				  print('<OPTION VALUE=1948>1948年 (昭和23年)</OPTION>');
				  print('<OPTION VALUE=1947>1947年 (昭和22年)</OPTION>');
				  print('<OPTION VALUE=1946>1946年 (昭和21年)</OPTION>');
				  print('<OPTION VALUE=1945>1945年 (昭和20年)</OPTION>');
				  print('<OPTION VALUE=1944>1944年 (昭和19年)</OPTION>');
				  print('<OPTION VALUE=1943>1943年 (昭和18年)</OPTION>');
				  print('<OPTION VALUE=1942>1942年 (昭和17年)</OPTION>');
				  print('<OPTION VALUE=1941>1941年 (昭和16年)</OPTION>');
				  print('<OPTION VALUE=1940>1940年 (昭和15年)</OPTION>');
				  print('<OPTION VALUE=1939>1939年 (昭和14年)</OPTION>');
				  print('<OPTION VALUE=1938>1938年 (昭和13年)</OPTION>');
				  print('<OPTION VALUE=1937>1937年 (昭和12年)</OPTION>');
				  print('<OPTION VALUE=1936>1936年 (昭和11年)</OPTION>');
				  print('<OPTION VALUE=1935>1935年 (昭和10年)</OPTION>');
				  print('<OPTION VALUE=1934>1934年 (昭和9年)</OPTION>');
				  print('<OPTION VALUE=1933>1933年 (昭和8年)</OPTION>');
				  print('<OPTION VALUE=1932>1932年 (昭和7年)</OPTION>');
				  print('<OPTION VALUE=1931>1931年 (昭和6年)</OPTION>');
				  print('<OPTION VALUE=1930>1930年 (昭和5年)</OPTION>');
				  print('<OPTION VALUE=1929>1929年 (昭和4年)</OPTION>');
				  print('<OPTION VALUE=1928>1928年 (昭和3年)</OPTION>');
				  print('<OPTION VALUE=1927>1927年 (昭和2年)</OPTION>');
				  print('<OPTION VALUE=1926>1926年 (大正15年/昭和元年)</OPTION>');
				  print('<OPTION VALUE=1925>1925年 (大正14年)</OPTION>');
				  print('<OPTION VALUE=1924>1924年 (大正13年)</OPTION>');
				  print('<OPTION VALUE=1923>1923年 (大正12年)</OPTION>');
				  print('<OPTION VALUE=1922>1922年 (大正11年)</OPTION>');
				  print('<OPTION VALUE=1921>1921年 (大正10年)</OPTION>');
				  print('<OPTION VALUE=1920>1920年 (大正9年)</OPTION>');
				  print('<OPTION VALUE=1919>1919年 (大正8年)</OPTION>');
				  print('<OPTION VALUE=1918>1918年 (大正7年)</OPTION>');
				  print('<OPTION VALUE=1917>1917年 (大正6年)</OPTION>');
				  print('<OPTION VALUE=1916>1916年 (大正5年)</OPTION>');
				  print('<OPTION VALUE=1915>1915年 (大正4年)</OPTION>');
				  print('<OPTION VALUE=1914>1914年 (大正3年)</OPTION>');
				  print('<OPTION VALUE=1913>1913年 (大正2年)</OPTION>');
				  print('<OPTION VALUE=1912>1912年 (明治45年/大正元年)</OPTION>');
				  print('<OPTION VALUE=1911>1911年 (明治44年)</OPTION>');
				  print('<OPTION VALUE=1910>1910年 (明治43年)</OPTION>');
				  print('<OPTION VALUE=1909>1909年 (明治42年)</OPTION>');
				  print('<OPTION VALUE=1908>1908年 (明治41年)</OPTION>');
				  print('<OPTION VALUE=1907>1907年 (明治40年)</OPTION>');
				  print('<OPTION VALUE=1906>1906年 (明治39年)</OPTION>');
				  print('<OPTION VALUE=1905>1905年 (明治38年)</OPTION>');
				  print('<OPTION VALUE=1904>1904年 (明治37年)</OPTION>');
				  print('<OPTION VALUE=1903>1903年 (明治36年)</OPTION>');
				  print('<OPTION VALUE=1902>1902年 (明治35年)</OPTION>');
				  print('<OPTION VALUE=1901>1901年 (明治34年)</OPTION>');
				  print('<OPTION VALUE=1900>1900年 (明治33年)</OPTION>');
				  print('<OPTION VALUE=1899>1899年 (明治32年)</OPTION>');
				  print('<OPTION VALUE=1898>1898年 (明治31年)</OPTION>');
				  print('<OPTION VALUE=1897>1897年 (明治30年)</OPTION>');
				  print('<OPTION VALUE=1896>1896年 (明治29年)</OPTION>');
				  print('<OPTION VALUE=1895>1895年 (明治28年)</OPTION>');
				  print('<OPTION VALUE=1894>1894年 (明治27年)</OPTION>');
				  print('<OPTION VALUE=1893>1893年 (明治26年)</OPTION>');
				  print('<OPTION VALUE=1892>1892年 (明治25年)</OPTION>');
				  print('<OPTION VALUE=1891>1891年 (明治24年)</OPTION>');
				  print('<OPTION VALUE=1890>1890年 (明治23年)</OPTION>');
				  print('<OPTION VALUE=1889>1889年 (明治22年)</OPTION>');
				  print('<OPTION VALUE=1888>1888年 (明治21年)</OPTION>');
				  print('<OPTION VALUE=1887>1887年 (明治20年)</OPTION>');
				  print('<OPTION VALUE=1886>1886年 (明治19年)</OPTION>');
				  print('<OPTION VALUE=1885>1885年 (明治18年)</OPTION>');
				  print('<OPTION VALUE=1884>1884年 (明治17年)</OPTION>');
				  print('<OPTION VALUE=1883>1883年 (明治16年)</OPTION>');
				  print('<OPTION VALUE=1882>1882年 (明治15年)</OPTION>');
				  print('<OPTION VALUE=1881>1881年 (明治14年)</OPTION>');
				  print('<OPTION VALUE=1880>1880年 (明治13年)</OPTION>');
				  print('<OPTION VALUE=1879>1879年 (明治12年)</OPTION>');
				  print('<OPTION VALUE=1878>1878年 (明治11年)</OPTION>');
				  print('<OPTION VALUE=1877>1877年 (明治10年)</OPTION>');
				  print('<OPTION VALUE=1876>1876年 (明治9年)</OPTION>');
				  print('<OPTION VALUE=1875>1875年 (明治8年)</OPTION>');
				  print('<OPTION VALUE=1874>1874年 (明治7年)</OPTION>');
				  print('<OPTION VALUE=1873>1873年 (明治6年)</OPTION>');
				  print('<OPTION VALUE=1872>1872年 (明治5年)</OPTION>');
				  print('<OPTION VALUE=1871>1871年 (明治4年)</OPTION>');
				  print('<OPTION VALUE=1870>1870年 (明治3年)</OPTION>');
				  print('<OPTION VALUE=1869>1869年 (明治2年)</OPTION>');
				  print('<OPTION VALUE=1868>1868年 (慶応4年/明治元年)</OPTION>');
				  print('<OPTION VALUE=9999>その他</OPTION>');
				print('</SELECT>');
			  print('</div>');
			  print('<div class="column3_container">');
				print('<div class="column3">その他を選んだ方は以下に年を入力してください</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column4"><input type="text" name="other_year" DISABLED></div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">代表者名</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column2"><input type="text" name="representative"></div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">杜氏名</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column2"><input type="text" name="touji"></div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">代表的な銘柄</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column2"><input type="text" name="brand"></div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">受賞暦</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column2"><textarea name="award_history"></textarea></div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">蔵見学</div>');
				print('<span></span>');
			  print('</div>');
			  print('<div class="column2">');
				print('<SELECT name="observation">');
				  print('<OPTION VALUE="">指定なし</OPTION>');
				  print('<OPTION VALUE=1>可</OPTION>');
				  print('<OPTION VALUE=2>不可</OPTION>');
				print('</SELECT>');
			  print('</div>');
			  print('<div class="column3_container">');
				print('<div class="column3">備考</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column4">');
				print('<textarea name="observatory_info"></textarea>');
			  print('</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1">酒蔵直販店</div>');
			  print('<div class="column2">');
				print('<SELECT name="direct_sale">');
				  print('<OPTION VALUE="">指定なし</OPTION>');
				  print('<OPTION VALUE=1>有</OPTION>');
				  print('<OPTION VALUE=2>無</OPTION>');
				print('</SELECT>');
			  print('</div>');
			print('</div>');

		  print('</div>');

		  /*
		  print('<div class="row_container">');

			print('<div class="row_title_container">');
			  print('<div class="row_title_sign"></div>');
			  print('<div class="row_title">管理者用</div>');
			print('</div>');
			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">購入方法</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column2"><input type="text" name="payment_method"></div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">酒蔵プライオリティ</div>');
				print('<span></span>');
			  print('</div>');
			  print('<div class="column2">');
				print('<SELECT name="sakagura">');
				  print('<OPTION VALUE="">指定なし</OPTION>');
				  print('<OPTION VALUE="1">S</OPTION>');
				  print('<OPTION VALUE="2">A</OPTION>');
				  print('<OPTION VALUE="3">B</OPTION>');
				  print('<OPTION VALUE="4">C</OPTION>');
				  print('<OPTION VALUE="5">D</OPTION>');
				  print('<OPTION VALUE="6">E</OPTION>');
				  print('<OPTION VALUE="7">X</OPTION>');
				print('</SELECT>');
			  print('</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">酒造組合登録</div>');
				print('<span></span>');
			  print('</div>');
			  print('<div class="column2 column2_select">');
				print('<label><input type="radio" name="kumiai" value="10">あり</label>');
				print('<label><input type="radio" name="kumiai" value="11">なし</label>');
				print('<label><input type="radio" name="kumiai" value="12">不明</label>');
			  print('</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">国税庁登録</div>');
				print('<span></span>');
			  print('</div>');
			  print('<div class="column2 column2_select">');
				print('<label><input type="radio" name="kokuzei" value="10">あり</label>');
				print('<label><input type="radio" name="kokuzei" value="11">なし</label>');
				print('<label><input type="radio" name="kokuzei" value="12">不明</label>');
			  print('</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">ステータス</div>');
				print('<span></span>');
			  print('</div>');
			  print('<div class="column2 column2_select">');
				print('<label><input type="radio" name="status" value="10">active</label>');
				print('<label><input type="radio" name="status" value="11">inactive</label>');
				print('<label><input type="radio" name="status" value="12">一時製造休止</label>');
				print('<label><input type="radio" name="status" value="13">営業不明・自醸停止外部醸造</label>');
			  print('</div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">メモ</div>');
				print('<span>全角かな/半角英数字</span>');
			  print('</div>');
			  print('<div class="column2"><textarea name="memo"></textarea></div>');
			print('</div>');

			print('<div class="row">');
			  print('<div class="column1_container">');
				print('<div class="column1">データ状況</div>');
				print('<span></span>');
			  print('</div>');
			  print('<div class="column2 column2_select">');
				print('<SELECT name="sakagura_develop">');
				  print('<OPTION VALUE="0">未完成</OPTION>');
				  print('<OPTION VALUE="1">完成</OPTION>');
				  print('<OPTION VALUE="2">途中</OPTION>');
				print('</SELECT>');
			  print('</div>');
			print('</div>');

		  print('</div>');
		  */

		  /*
		  print('<div class="row">');
			print('<div class="column1">酒蔵の紹介</div>');
			print('<div class="column2"><textarea name="sakagura_intro"></textarea></div>');
		  print('</div>');

		  print('<div class="sakerow">');
			print('<span class="sakecolumn1">酒蔵の紹介　<span></span></span>');
			print('<span class="sakecolumn2">');
			  print('<textarea name="sakagura_intro"></textarea>');
			print('</span>');
		  print('</div>');
		  */

		print('</div>');
	  print('</form>');

	  print('<div class="edit_sakagura_button_container">');
		print('<input name="close_sakagura" type="button" value="戻る">');
		print('<input name="sakagura_confirm" type="button" value="確認する">');
    print('<input name="delete_sakagura" type="button" value="削除">');
	  print('</div>');
	print('</div>');
	print('</div>');
}

function writeDialogAddSakaguraConfirm()
{
  print('<div class="dialog_add_sakagura_background" title="酒蔵を追加しますか？">');
	print('<div class="dialog_table">');
	  print('<div class="dialog_table-cell">');
		print('<div id="dialog_add_sakagura">');
		  print('<div class="confirm_note">ご入力いただいた情報に間違いがないかご確認ください。</div>');
		  print('<div class="frame">');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>酒蔵名</div>');
			print('<div class="confirm_item_info dialog_sakagura_name" style="margin: 2px 0px 2px 0px;"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>酒蔵名よみ</div>');
			print('<div class="confirm_item_info dialog_sakagura_read" style="margin: 2px 0px 2px 0px;"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>酒蔵名英語よみ</div>');
			print('<div class="confirm_item_info dialog_sakagura_english"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>酒蔵名検索用</div>');
			print('<div class="confirm_item_info dialog_sakagura_search"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>郵便番号</div>');
			print('<div class="confirm_item_info dialog_postal_code"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>都道府県</div>');
			print('<div class="confirm_item_info dialog_sakagura_pref"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>住所</div>');
			print('<div class="confirm_item_info dialog_address"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>住所よみ</div>');
			print('<div class="confirm_item_info dialog_address_read"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>酒蔵の紹介</div>');
			print('<div class="confirm_item_info dialog_intro"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>電話番号</div>');
			print('<div class="confirm_item_info dialog_phone"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>FAX番号</div>');
			print('<div class="confirm_item_info dialog_fax"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>ウェブサイト</div>');
			print('<div class="confirm_item_info dialog_url"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>Email</div>');
			print('<div class="confirm_item_info dialog_email"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>代表銘柄</div>');
			print('<div class="confirm_item_info dialog_brand"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>代表者</div>');
			print('<div class="confirm_item_info dialog_representative"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>杜氏</div>');
			print('<div class="confirm_item_info dialog_touji"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>創業</div>');
			print('<div class="confirm_item_info dialog_establishment"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>受賞暦</div>');
			print('<div class="confirm_item_info dialog_award_history"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>蔵見学</div>');
			print('<div class="confirm_item_info dialog_observation"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>蔵見学情報</div>');
			print('<div class="confirm_item_info dialog_observatory_info"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>直販</div>');
			print('<div class="confirm_item_info dialog_direct_sale"></div>');
			print('</div>');

			print('<div class="alt">');
			print('<div class="confirm_item_title"><span></span>購入方法</div>');
			print('<div class="confirm_item_info dialog_payment_method"></div>');
			print('</div>');

			// print('<div class="alt">');
			// print('<div class="confirm_item_title"><span></span>メモ</div>');
			// print('<div class="confirm_item_info dialog_memo"></div>');
			// print('</div>');

			// print('<div class="alt">');
			// print('<div class="confirm_item_title"><span></span>Last Contacted</div>');
			// print('<div class="confirm_item_info dialog_LastContacted"></div>');
			// print('</div>');

			print('<div class="edit_sakagura_button_container">');
				print('<input type="button" class="button_back" value="閉じる">');
				print('<input type="button" name="update_sakagura" value="登録・更新">');
				print('<input type="button" name="submit_sakagura" class="submit_button" value="登録する">');
			print('</div>');

		print('</div>'); // frame

	print('</div>');
	print('</div>');
	print('</div>');
	print('</div>');
}

?>
