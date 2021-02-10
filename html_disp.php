<?php

function GetWareki($year)
{
	$seireki = intval($year);
	$wareki = "";

	if($seireki > 2018)
	{
		if($seireki == 2019)
			$wareki = "平成31年/令和元年";
		else
			$wareki = "令和".($seireki - 2018)."年";
	}
	else if($seireki > 1988)
	{
		if($seireki == 1989)
			$wareki = "昭和64年/平成元年";
		else
			$wareki = "平成".($seireki - 1988)."年";
	}
    else if($seireki > 1925)
	{
		if($seireki == 1926)
			$wareki = "大正15年/昭和元年";
		else
			$wareki = "昭和".($seireki - 1925)."年";
	}
    else if($seireki > 1911)
	{
		if($seireki == 1912)
			$wareki = "明治45年/大正元年";
		else
			$wareki = "大正".($seireki - 1911)."年";
	}
    else if($seireki > 1867)
	{
		if($seireki == 1868)
			$wareki = "慶応4年/明治元年";
		else
			$wareki = "明治".($seireki - 1867)."年";
	}

	return $wareki;
}

function write_sake_list($db, $res)
{
	$path = "images/icons/noimage240.svg";
	print('<ul class="slider multiple-sake">');

	while($row = getnextrow($res))
	{
		$sake_id = $row["sake_id"];
		$rd = executequery($db, "SELECT FILENAME FROM SAKE_IMAGE WHERE sake_id = '$sake_id'");

		$image = getnextrow($rd);

		if($image)
			$path = "images\\photo\\thumb\\".$image["filename"];
		else
			$path = "images/icons/noimage240.svg";

		print('<li class="sakeitem">');
			print('<a href="sake_view.php?sake_id=' .$row["sake_id"] .'" class="sakeitem_click">');
				print("<div class='sakeitem_image_container'><img src=\"" .$path  ."\"></div>");
				print('<h1 class="sakeitem_sake_brewery_container">');
					print('<div class="sakeitem_sake_container">');
						print('<p>' .stripslashes($row["sake_name"]) .'</p>');
					print('</div>');
					print('<div class="sakeitem_brewery_container">');
						print('<p>' .stripslashes($row["sakagura_name"]) .'/' .$row["pref"] .'</p>');
					print('</div>');
				print('</h1>');
			print('</a>');
		print('</li>');
	}
	print("</ul>");
}

function write_sake($db)/*使用禁止*/
{
	$path = "images/icons/NoPhotoSake.jpg";
	$sql = "SELECT SAKE_J.sake_id as sake_id, id, sake_name, sakagura_name, pref, filename FROM SAKE_J, SAKAGURA_J, SAKE_IMAGE WHERE SAKE_J.sakagura_id = SAKAGURA_J.id AND SAKE_J.sake_id = SAKE_IMAGE.sake_id ORDER BY RANDOM() LIMIT 2";
	$res = executequery($db, $sql);

	if($row = getnextrow($res))
	{
		$result_set = executequery($db, "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$row["sake_id"] ."' LIMIT 8");

		if($rd = getnextrow($result_set))
		{
			$path = "images/photo/thumb/" .$rd["filename"];
		}

		print('<div class="banner">');
			print('<div><img src="images/icons/bottle.svg">オススメの酒</div>');
			print('<div class="banner_item">');
				print('<div><img src="' .$path .'"></div>');
				print('<div>');
					print('<a href="sake_view.php?sake_id=' .$row["sake_id"] .'">'.stripslashes($row["sake_name"]) .'</a>');
				print('</div>');
				print('<div>');
					print('<img src="images/icons/top.svg">');
					print('<a href="sda_view.php?id=' .$row["id"] .'">'.stripslashes($row["sakagura_name"]) .'/' .$row["pref"] .'</a>');
				print('</div>');
				print('<div>--</div>');
			print('</div>');

			if($row = getnextrow($res))
			{
				$path = "images/icons/NoPhotoSake.jpg";
				$result_set = executequery($db, "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$row["sake_id"] ."' LIMIT 8");

				if($rd = getnextrow($result_set))
				{
					$path = "images/photo/thumb/" .$rd["filename"];
				}

				print('<div class="banner_item">');
					print('<div><img src="' .$path .'"></div>');
					print('<div>');
						print('<a href="sake_view.php?sake_id=' .$row["sake_id"] .'">'.stripslashes($row["sake_name"]) .'</a>');
					print('</div>');
					print('<div>');
						print('<img src="images/icons/top.svg">');
						print('<a href="sda_view.php?id=' .$row["id"] .'">'.stripslashes($row["sakagura_name"]) .'/' .$row["pref"] .'</a>');
					print('</div>');
					print('<div>--</div>');
				print('</div>');
			}
		print('</div>');
	}
}

function write_sakagura($db)
{
	////////////////////////////////////////
	//$sql = "SELECT sakagura_id, sakagura_name, sakagura_pref FROM SAKAGURA_J ORDER BY RANDOM() LIMIT 12";
	//$res = executequery($db, $sql);
	$res = executequery($db, "SELECT * FROM SAKAGURA_J ORDER BY RANDOM() LIMIT 12");

	print('<div class="brewery"><div><svg class="top_brewery3630"><use xlink:href="#brewery3630"/></svg>全国の酒蔵</div>');
		print('<ul class="slider multiple-brewery">');

			while($row = getnextrow($res))
			{
				$path = "images/icons/noimage160.svg";
				print('<li sakagura_id="' .$row["sakagura_id"] .'">');
					print('<a href="sda_view.php?id=' .$row["id"] .'" class="banner_item sakagura">');
						print('<div><img src="' .$path .'"></div>');
						print('<div class="banner_item_article_container">');
							print('<div class="banner_item_name_pref_container">');
								print('<div class="banner_item_name_container"><div>' .$row["sakagura_name"] .'</div></div>');
								print('<div class="banner_item_pref_container">');
									print('<div>'.$row["pref"].'</div>');
									//print('<span>'.stripslashes($row["address"]).'</span>');
								print('</div>');
							print('</div>');
							print('<div class="banner_item_profile_container">');
								// 代表銘柄
								print('<div class="banner_item_brewery_profile">');
									print('<div>代表銘柄: ' .$row["brand"] .'</div>');
								print('</div>');
								// 蔵見学情報
								print('<div class="banner_item_brewery_profile">');
									if($row["observation"] == 1)
										print('<div>蔵見学: 可</div>');
									else if($row["observation"] == 2)
										print('<div>蔵見学: 不可</div>');
									else
										print('<div>蔵見学: --</div>');
								print('</div>');
								// お気に入り酒蔵
								print('<div class="banner_item_brewery_profile">');
									print('<div>お気に入り酒蔵: --</div>');
								print('</div>');
							print('</div>');/*banner_item_brewery_profile_container閉じタグ*/
						print('</div>');/*banner_item_article_container閉じタグhirasawa*/
					print("</a>");/*banner_item sakagura閉じタグhirasawa*/

					if($row = getnextrow($res))
					{
						print('<a href="sda_view.php?id=' .$row["id"] .'" class="banner_item sakagura">');
							print('<div><img src="' .$path .'"></div>');
							print('<div class="banner_item_article_container">');
								print('<div class="banner_item_name_pref_container">');
									print('<div class="banner_item_name_container"><div>' .$row["sakagura_name"] .'</div></div>');
									print('<div class="banner_item_pref_container">');
										print('<div>'.$row["pref"].'</div>');
									//print('<span>'.stripslashes($row["address"]).'</span>');
									print('</div>');
								print('</div>');
								print('<div class="banner_item_profile_container">');
									// 代表銘柄
									print('<div class="banner_item_brewery_profile">');
										print('<div>代表銘柄: ' .$row["brand"] .'</div>');
									print('</div>');
									// 蔵見学情報
									print('<div class="banner_item_brewery_profile">');
										if($row["observation"] == 1)
											print('<div>蔵見学: 可</div>');
										else if($row["observation"] == 2)
											print('<div>蔵見学: 不可</div>');
										else
											print('<div>蔵見学: --</div>');
									print('</div>');
									// お気に入り酒蔵
									print('<div class="banner_item_brewery_profile">');
										print('<div>お気に入り酒蔵: --</div>');
									print('</div>');
								print('</div>');/*banner_item_brewery_profile_container閉じタグ*/
							print('</div>');/*banner_item_article_container閉じタグhirasawa*/
						print("</a>");/*banner_item sakagura閉じタグhirasawa*/
					}
				print("</li>");
			}
		print("</ul>");
	print("</div>");
	////////////////////////////////////////
  /*
	$res = executequery($db, "SELECT * FROM SAKAGURA_J ORDER BY RANDOM() LIMIT 3");
	$row = getnextrow($res);

	if($row)
	{
		$path = "images/icons/noimage160.svg";

		print('<div class="banner">');
			print('<div><img src="images/icons/brewery30.svg">全国の酒蔵</div>');
			print('<div class="banner_item_container">');
				print('<a href="sda_view.php?id=' .$row["id"] .'" class="banner_item sakagura">');
					print('<div><img src="' .$path .'"></div>');
					print('<div class="banner_item_article_container">');
						print('<div class="banner_item_name_pref_container">');
							print('<div class="banner_item_name_container"><div>' .$row["sakagura_name"] .'</div></div>');
							print('<div class="banner_item_pref_container">');
								print('<div>'.$row["pref"].'</div>');
								//print('<span>'.stripslashes($row["address"]).'</span>');
							print('</div>');
						print('</div>');
						print('<div class="banner_item_profile_container">');
							// 代表銘柄
							print('<div class="banner_item_brewery_profile">');
								print('<div>代表銘柄: ' .$row["brand"] .'</div>');
							print('</div>');
							// 蔵見学情報
							print('<div class="banner_item_brewery_profile">');
								if($row["observation"] == 1)
									print('<div>蔵見学: 可</div>');
								else if($row["observation"] == 2)
									print('<div>蔵見学: 不可</div>');
								else
									print('<div>蔵見学: --</div>');
							print('</div>');
							// お気に入り酒蔵
							print('<div class="banner_item_brewery_profile">');
								print('<div>お気に入り酒蔵: --</div>');
							print('</div>');
						print('</div>');
					print('</div>');
				print("</a>");

				if($row = getnextrow($res))
				{
					print('<a href="sda_view.php?id=' .$row["id"] .'" class="banner_item sakagura">');
						print('<div><img src="' .$path .'"></div>');
						print('<div class="banner_item_article_container">');
							print('<div class="banner_item_name_pref_container">');
								print('<div class="banner_item_name_container"><div>' .$row["sakagura_name"] .'</div></div>');
								print('<div class="banner_item_pref_container">');
									print('<div>'.$row["pref"].'</div>');
								//print('<span>'.stripslashes($row["address"]).'</span>');
								print('</div>');
							print('</div>');
							print('<div class="banner_item_profile_container">');
								// 代表銘柄
								print('<div class="banner_item_brewery_profile">');
									print('<div>代表銘柄: ' .$row["brand"] .'</div>');
								print('</div>');
								// 蔵見学情報
								print('<div class="banner_item_brewery_profile">');
									if($row["observation"] == 1)
										print('<div>蔵見学: 可</div>');
									else if($row["observation"] == 2)
										print('<div>蔵見学: 不可</div>');
									else
										print('<div>蔵見学: --</div>');
								print('</div>');
								// お気に入り酒蔵
								print('<div class="banner_item_brewery_profile">');
									print('<div>お気に入り酒蔵: --</div>');
								print('</div>');
							print('</div>');
						print('</div>');
					print("</a>");
				}
			print('</div>');
		print("</div>");
	}
	*/
	////////////////////////////////////////
}

function write_inshokuten($db)
{
	////////////////////////////////////////
	$sql = "SELECT inshokuten_id, inshokuten_name, inshokuten_pref FROM INSHOKUTEN_J ORDER BY RANDOM() LIMIT 12";
	$res = executequery($db, $sql);

	print('<div class="restaurant"><div><svg class="top_restaurant3630"><use xlink:href="#restaurant3630"/></svg>日本酒を飲める飲食店</div>');
		print('<ul class="slider multiple-restaurant">');

			while($row = getnextrow($res))
			{
				$path = "images/icons/noimage160.svg";
				print('<li inshokuten_id="' .$row["inshokuten_id"] .'">');
					print('<a href="inshokuten_view.php?inshokuten_id=' .$row["inshokuten_id"] .'" class="banner_item inshokuten">');
						print('<div><img src="' .$path .'"></div>');
						print('<div class="banner_item_article_container">');
							print('<div class="banner_item_name_pref_container">');
								print('<div class="banner_item_name_container">');
									print('<div>' .$row["inshokuten_name"] .'</div>');
								print('</div>');
								print('<div class="banner_item_pref_container">');
									print('<div>' .$row["inshokuten_pref"] .'</div>');
								print('</div>');
							print('</div>');
							print('<div></div>');
							print('<div class="banner_item_profile_container">');
								print('<div class="banner_item_restaurant_profile">');
									if($row["inshokuten_remarks"] != null && $row["inshokuten_remarks"] != "")
										print($row["inshokuten_remarks"]);
									else
										print("--");
								print('</div>');
							print('</div>');
						print('</div>');
					print('</a>');

					if($row = getnextrow($res))
					{
						print('<a href="inshokuten_view.php?inshokuten_id=' .$row["inshokuten_id"] .'" class="banner_item inshokuten">');
							print('<div><img src="' .$path .'"></div>');
							print('<div class="banner_item_article_container">');
								print('<div class="banner_item_name_pref_container">');
									print('<div class="banner_item_name_container">');
										print('<div>' .$row["inshokuten_name"] .'</div>');
									print('</div>');
									print('<div class="banner_item_pref_container">');
										print('<div>' .$row["inshokuten_pref"] .'</div>');
									print('</div>');
								print('</div>');
								print('<div></div>');
								print('<div class="banner_item_profile_container">');
									print('<div class="banner_item_restaurant_profile">');
										if($row["inshokuten_remarks"] != null && $row["inshokuten_remarks"] != "")
										print($row["inshokuten_remarks"]);
										else
										print("--");
									print('</div>');
								print('</div>');
							print('</div>');
						print('</a>');
					}
				print("</li>");
			}
		print("</ul>");
	print("</div>");
	////////////////////////////////////////
	/*
	$res = executequery($db, "SELECT inshokuten_id, inshokuten_name, inshokuten_pref FROM INSHOKUTEN_J ORDER BY RANDOM() LIMIT 3");
	$row = getnextrow($res);

	if($row)
	{
		$path = "images/icons/noimage160.svg";

		print('<div class="banner">');
			print('<div><img src="images/icons/restaurant30.svg">日本酒を飲める飲食店</div>');
			print('<div class="banner_item_container">');
				print('<a href="inshokuten_view.php?inshokuten_id=' .$row["inshokuten_id"] .'" class="banner_item inshokuten">');
					print('<div><img src="' .$path .'"></div>');
					print('<div class="banner_item_article_container">');
						print('<div class="banner_item_name_pref_container">');
							print('<div class="banner_item_name_container">');
								print('<div>' .$row["inshokuten_name"] .'</div>');
							print('</div>');
							print('<div class="banner_item_pref_container">');
								print('<div>' .$row["inshokuten_pref"] .'</div>');
							print('</div>');
						print('</div>');
						print('<div class="banner_item_profile_container">');
							print('<div class="banner_item_restaurant_profile">');
								if($row["sakagura_intro"] && $row["sakagura_intro"] != "")
									print('<div>' .$row["sakagura_intro"] .'</div>');
								else
									print('<div>--</div>');
							print('</div>');
						print('</div>');
					print('</div>');
				print('</a>');

				if($row = getnextrow($res))
				{
					print('<a href="inshokuten_view.php?inshokuten_id=' .$row["inshokuten_id"] .'" class="banner_item inshokuten">');
						print('<div><img src="' .$path .'"></div>');
						print('<div class="banner_item_article_container">');
							print('<div class="banner_item_name_pref_container">');
								print('<div class="banner_item_name_container">');
									print('<div>' .$row["inshokuten_name"] .'</div>');
								print('</div>');
								print('<div class="banner_item_pref_container">');
									print('<div>' .$row["inshokuten_pref"] .'</div>');
								print('</div>');
							print('</div>');
							print('<div class="banner_item_profile_container">');
								print('<div class="banner_item_restaurant_profile">');
									if($row["sakagura_intro"] && $row["sakagura_intro"] != "")
										print('<div>' .$row["sakagura_intro"] .'</div>');
									else
										print('<div>--</div>');
								print('</div>');
							print('</div>');
						print('</div>');
					print('</a>');
				}
			print('</div>');
		print('</div>');
	}
	*/
	////////////////////////////////////////
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function write_syuhanten($db)
{
	////////////////////////////////////////
	$sql = "SELECT syuhanten_id, syuhanten_name, syuhanten_pref FROM SYUHANTEN_J ORDER BY RANDOM() LIMIT 12";
	$res = executequery($db, $sql);

	print('<div class="store"><div><svg class="top_store3030"><use xlink:href="#store3030"/></svg>日本酒を買える酒販店</div>');
		print('<ul class="slider multiple-store">');

			while($row = getnextrow($res))
			{
				$path = "images/icons/noimage160.svg";
				print('<li syuhanten_id="' .$row["syuhanten_id"] .'">');
					print('<a href="syuhan_view.php?syuhanten_id=' .$row["syuhanten_id"] .'" class="banner_item syuhanten">');
						print('<div><img src="' .$path .'"></div>');
						print('<div class="banner_item_article_container">');
							print('<div class="banner_item_name_pref_container">');
								print('<div class="banner_item_name_container">');
									print('<div>' .$row["syuhanten_name"] .'</div>');
								print('</div>');
								print('<div class="banner_item_pref_container">');
									print('<div>' .$row["syuhanten_pref"] .'</div>');
								print('</div>');
							print('</div>');
							print('<div></div>');
							print('<div class="banner_item_profile_container">');
								print('<div class="banner_item_store_profile">');
									if($row["syuhanten_remarks"] != null && $row["syuhanten_remarks"] != "")
										print($row["syuhanten_remarks"]);
									else
										print("--");
								print('</div>');
							print('</div>');
						print('</div>');
					print('</a>');

					if($row = getnextrow($res))
					{
						print('<a href="syuhan_view.php?syuhanten_id=' .$row["syuhanten_id"] .'" class="banner_item syuhanten">');
							print('<div><img src="' .$path .'"></div>');
							print('<div class="banner_item_article_container">');
								print('<div class="banner_item_name_pref_container">');
									print('<div class="banner_item_name_container">');
										print('<div>' .$row["syuhanten_name"] .'</div>');
									print('</div>');
									print('<div class="banner_item_pref_container">');
										print('<div>' .$row["syuhanten_pref"] .'</div>');
									print('</div>');
								print('</div>');
								print('<div></div>');
								print('<div class="banner_item_profile_container">');
									print('<div class="banner_item_store_profile">');
										if($row["syuhanten_remarks"] != null && $row["syuhanten_remarks"] != "")
										print($row["syuhanten_remarks"]);
										else
										print("--");
									print('</div>');
								print('</div>');
							print('</div>');
						print('</a>');
					}
				print("</li>");
			}
		print("</ul>");
	print("</div>");
	////////////////////////////////////////
	/*
	$res = executequery($db, "SELECT syuhanten_id, syuhanten_name, syuhanten_pref FROM SYUHANTEN_J ORDER BY RANDOM() LIMIT 3");
	$row = getnextrow($res);

	if($row)
	{
		$path = "images/icons/noimage160.svg";

		print('<div class="banner">');
			print('<div><img src="images/icons/store30.svg">日本酒を買える酒販店</div>');
			print('<div class="banner_item_container">');
				print('<a href="syuhan_view.php?syuhanten_id=' .$row["syuhanten_id"] .'" class="banner_item syuhanten">');
					print('<div><img src="' .$path .'"></div>');
					print('<div class="banner_item_article_container">');
						print('<div class="banner_item_name_pref_container">');
							print('<div class="banner_item_name_container">');
								print('<div>' .$row["syuhanten_name"] .'</div>');
							print('</div>');
							print('<div class="banner_item_pref_container">');
								print('<div>' .$row["syuhanten_pref"] .'</div>');
							print('</div>');
						print('</div>');
						print('<div class="banner_item_profile_container">');
							print('<div class="banner_item_store_profile">');
								if($row["syuhanten_intro"] && $row["syuhanten_intro"] != "")
									print('<div>' .$row["syuhanten_intro"] .'</div>');
								else
									print('<div>--</div>');
							print('</div>');
						print('</div>');
					print('</div>');
				print('</a>');

				if($row = getnextrow($res))
				{
					print('<a href="syuhan_view.php?syuhanten_id=' .$row["syuhanten_id"] .'" class="banner_item syuhanten">');
						print('<div><img src="' .$path .'"></div>');
						print('<div class="banner_item_article_container">');
							print('<div class="banner_item_name_pref_container">');
								print('<div class="banner_item_name_container">');
									print('<div>' .$row["syuhanten_name"] .'</div>');
								print('</div>');
								print('<div class="banner_item_pref_container">');
									print('<div>' .$row["syuhanten_pref"] .'</div>');
								print('</div>');
							print('</div>');
							print('<div class="banner_item_profile_container">');
								print('<div class="banner_item_store_profile">');
									if($row["syuhanten_intro"] && $row["syuhanten_intro"] != "")
										print('<div>' .$row["syuhanten_intro"] .'</div>');
									else
										print('<div>--</div>');
								print('</div>');
							print('</div>');
						print('</div>');
					print('</a>');
				}
			print('</div>');
		print('</div>');
	}
	*/
	////////////////////////////////////////
}

function writefooter()
{
	$username = $_COOKIE['login_cookie'];

	print('<footer class="sakenomu_footer">');
		print('<div class="footer_container">');
			print('<a class="footer_icon" href="sake_search.php">');
				print('<svg class="footer_home2020"><use xlink:href="#home2020"/></svg><span>Home</span>');
			print('</a>');
			print('<a class="footer_icon" href="search.php">');
				print('<svg class="footer_search2020"><use xlink:href="#search2020"/></svg><span>検索</span>');
			print('</a>');
			if($username == "" || $username == null) {
				print('<a class="footer_icon" href="user_login_form.php">');
					print('<svg class="footer_login2020"><use xlink:href="#login2020"/></svg><span>ログイン</span>');
				print('</a>');
			} else {
				print('<a class="footer_icon" href="user_view.php?username=' .$loginname .'">');
					print('<svg class="footer_person2020"><use xlink:href="#person2020"/></svg><span>マイページ</span>');
				print('</a>');
			}
		print('</div>');
	print("</footer>");
}

function html_convert($p_string)
{
    $p_string = str_replace("&","&amp;", $p_string);
    $p_string = str_replace("\"","&quot;", $p_string);
    $p_string = str_replace("<","&lt;", $p_string);
    $p_string = str_replace(">","&gt;", $p_string);
    $p_string = str_replace(",","&#44;", $p_string);
    $p_string = str_replace("'","&#39;", $p_string);
    $p_string = str_replace("\r\n","\n", $p_string);
    $p_string = str_replace("\r","\n", $p_string);
    $p_string = str_replace(" ","&nbsp;", $p_string);
    $p_string = str_replace("\n","<br />", $p_string);
    return $p_string;
}

function X_to_Z($p_X, $p_Y, $p_Z, $p_N = "")
{
    if($p_X == $p_Y)
	{
        $return_string = $p_Z;
    }
	else
	{
        if($p_N != "")
		{
            $return_string = $p_N;
        }
		else
		{
            $return_string = $p_X;
        }
    }

    return $return_string;
}
?>
