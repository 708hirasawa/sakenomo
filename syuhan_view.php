<?php 
require_once("db_functions.php");
require_once("bbs_functions.php");
require_once("hamburger.php");
require_once("searchbar.php");
require_once("nonda.php");
?>

<html lang="ja">

<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta content='width=device-width, initial-scale=1, user-scalable=0' name='viewport'/>

	<title>検索結果</title>
	<link rel="stylesheet" href="slick/slick-theme.css">
	<link rel="stylesheet" href="slick/slick.css">
	<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/user_view_config.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/syuhan_view.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />

	<!-- The JavaScript -->
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

$id = $_GET['syuhanten_id'];
$username = $_COOKIE['login_cookie'];

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$sql = "SELECT * FROM FOLLOW_SYUHANTEN_J WHERE username = '$username' AND syuhanten_id = '$id'";
$res = executequery($db, $sql);
$row = getnextrow($res);

$syuhanten_id = $_GET['syuhanten_id'];
//print("酒販店のID". $syuhanten_id);

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

//print("酒蔵のID". $sake_id);
$sql = "SELECT * FROM SYUHANTEN_J WHERE syuhanten_id = '$syuhanten_id'";
$res = executequery($db, $sql);
$row = getnextrow($res);
$address = $row["syuhanten_pref"] ." " .$row["syuhanten_address"];

print('<div id="container">');

if($row)
{
  print('<input type="hidden" id="hidden_syuhanten_id" value="' .$row["syuhanten_id"]  .'">');
  print('<input type="hidden" id="hidden_syuhanten_country" value="' .$row["syuhanten_country"]  .'">');
  print('<input type="hidden" id="hidden_syuhanten_region"  value="' .$row["syuhanten_region"]  .'">');
  print('<input type="hidden" id="hidden_syuhanten_develop" value="' .$row["syuhanten_develop"]  .'">');
  print('<input type="hidden" id="hidden_syuhanten_rank"    value="' .$row["syuhanten_rank"]   .'">');
  print('<input type="hidden" id="hidden_syuhanten_address" value="' .stripslashes($row["syuhanten_address"])  .'">');
  print('<input type="hidden" id="hidden_syuhanten" value="' .$row["syuhanten"] .'">');
  print('<input type="hidden" id="hidden_syuhanten_sake"	value="' .$row["syuhanten_sake"] .'">');

  print('<div id="syuhantable">');
		print('<div id="syuhantentitle" class="syuhantenRow" style="border:0px solid #c6c6c6; background:#fff">');
			 print('<div id="syuhanpanel1">');

				// 酒販店名
				print('<div id="syuhanten_name" style="font-size:16px; font-weight: bold; color:#000">' .$row["syuhanten_name"] .'</div>');
				print('<div id="syuhanten_read" style="margin-top:4px; font-size:12px; color: #000">' .stripslashes($row["syuhanten_read"]) .'</div>');
				print('<div id="syuhanten_english" style="margin-top:4px; font-size:12px; color: #000">' .stripslashes($row["syuhanten_english"]) .'</div>');

			print("</div>");

			////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////////////////
			print('<div id="syuhanpanel2">');
				print('<ul class="info" style="overflow:auto; margin-top:4px; min-height:24px; margin-left:6px; border:0px solid #c6c6c6">');
				print('<li id="button_bbs"><span style="float:left; margin-right:6px; border-radius:2px; width:18px; height:18px; text-align:left; border:0px solid #404040"><img style="vertical-align:middle; height:18px; margin-right:4px" src="images/icons/writing.svg"></span>コメント・写真</li>');

				$result = executequery($db, "SELECT * FROM FOLLOW_SYUHANTEN_J WHERE username = '$username' AND syuhanten_id = '$id'");

				if($rd = getnextrow($result))
				{
						print('<li id="follow">フォロー中</li>');
				}
				else
				{
						print('<li id="follow">フォローする</li>');
				}

				$result = executequery($db, "SELECT * FROM USERS_J WHERE USERS_J.sakagura_syuhanten_id = '$syuhanten_id'");

				if($rd = getnextrow($result))
				{
					 print('<li style="float:left; padding:2px" id="button_mail">酒販店にメールを送る</li>');
				}

				if($_COOKIE['usertype_cookie'] == 9)
				{
						//print("<li id=\"setting_button\">編集</li>");
						print('<li id="delete_syuhanten" syuhanten_id =' .$id .'>削除</li>');
				}

				print('</ul>');

				////////////////////////////////////////////////////////////////////////////////////////////////////////////
				print('<div style="overflow:auto; margin-top:4px; border:0px solid #c6c6c6">');

						////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// 住所
						print('<div class="syuhanten_item">');
							print('<span class="label">住所</span>');
							print('<span id="syuhanten_address_location" style="overflow:auto; padding-top:2px; color:#000">');
								print('<span>〒</span><span id="syuhanten_postal_code" style="margin-right:4px">' .$row["syuhanten_postal_code"] .'</span>');
								print('<span id="syuhanten_prefecture" style="margin-right:4px">' .$row["syuhanten_pref"] .'</span>');
								print('<span id="syuhanten_address" style="margin-right:4px">' .$row["syuhanten_address"] .'</span>');
							print('</span>');
						print('</div>');

						////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// 定休日
						print('<div class="syuhanten_item">');
							print('<span class="label">定休日</span>');
							print('<span id="syuhanten_closed" style="overflow:auto; padding-top:2px; color:#000">'.$row["syuhanten_closed"].'</span>');
						print('</div>');

						////////////////////////////////////////////////////////////////////////////////////////////////////////////
						// 電話番号
						print('<div class="syuhanten_item">');
							print('<span class="label">&#9742</span>');
							print('<span id="syuhanten_phone" style="overflow:auto; padding-top:2px; color:#000">' .$row["syuhanten_phone"] .'</span>');
						print('</div>');

				print("</div>");
		print("</div>"); // syuhantentitle
	print("</div>");

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // tabs
  print('<div class="syuhantenRow" style="border:1px solid #c6c6c6; margin-top:12px">');

		print('<div id="tab_main" class="tab_container">');
				print('<ul class="simpleTabs">');
						print('<li><a class="active" href="#tabs-40"><img style="height:18px; margin:2px;" src="images/icons/top.svg"><div>トップ</div></a></li>');
						print('<li><a href="#tabs-41"><img style="height:18px; margin:2px;" src="images/icons/aboutproduct.svg"><div>取扱い銘柄</div></a></li>');
						print('<li><a href="#tabs-42"><img style="height:18px; margin:2px;" src="images/icons/camera30.svg"><div>写真</div></a></li>');
						print('<li><a href="#tabs-43"><img style="height:18px; margin:2px;" src="images/icons/reviewicon.svg"><div>コメント</div></a></li>');
				print('</ul>');

				print('<div id="tabs-40" style="overflow:auto; padding:0px 0px 4px 0px; border:0px solid #c6c6c6" class="form-action show">');

					print('<div style="overflow:auto; font-size:9pt; margin:0px 0px 8px 0px; padding:4px 8px 4px 8px; background:#F5F5F5"><div>一般ユーザーのご協力によって編集された詳細や投稿されたコメント・写真の内容は最新の情報と異なる場合があります。ご了承ください。</div><div style="color:#8BA340">酒蔵様は無料会員登録をご利用いただくと、自社ページの詳細情報や写真を編集することができます。</div></div>');
					print('<div id="panel1">');

							print('<div style="height:100px; padding:4px">');
							print("<img style=\"border-radius:0px; height:80%;\" src=\"images/icons/syuhanten.gif\">");
							print("</div>");

					print("</div>"); // panel1

					////////////////////////////////////////////////////////////////////////////////////////////////////////////
					// 酒蔵の紹介 */
					print("<div style=\"margin-bottom:8px; min-height:80px; overflow:auto; background:#fff; border:0px solid #c6c6c6;\">");
						print("<div style=\"width:100%; color:#000; font-weight:bold; background:#e3e3e3;\">");

						print('<svg  version="1.1" id="レイヤー_1" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;" width="24" height="20" viewBox="0 0 24 20"
  					 overflow="visible" enable-background="new 0 0 24 20" xml:space="preserve">
								<path fill="#3F3F3F" d="M14,7.425v-5.4C14,0.912,13.139,0,12.09,0H1.908C0.857,0,0,0.912,0,2.025v5.4
								c0,1.114,0.857,2.025,1.908,2.025h3.447l3.554,2.454c0.294,0.205,0.577,0.068,0.632-0.297l0.322-2.157h2.227
								C13.139,9.451,14,8.539,14,7.425z M3.816,5.738c-0.525,0-0.951-0.455-0.951-1.011c0-0.561,0.426-1.016,0.951-1.016
								c0.53,0,0.956,0.455,0.956,1.016C4.772,5.283,4.347,5.738,3.816,5.738z M6.998,5.738c-0.526,0-0.952-0.455-0.952-1.011
								c0-0.561,0.426-1.016,0.952-1.016c0.53,0,0.956,0.455,0.956,1.016C7.954,5.283,7.528,5.738,6.998,5.738z M10.18,5.738
								c-0.526,0-0.951-0.455-0.951-1.011c0-0.561,0.425-1.016,0.951-1.016c0.528,0,0.957,0.455,0.957,1.016
								C11.137,5.283,10.708,5.738,10.18,5.738z M22.187,17.148l-2.354-0.947c-0.393-0.177-0.643-0.563-0.643-0.985v-0.34
								c0-0.163,0.028-0.322,0.081-0.475c0,0,1.479-1.939,1.479-3.727C20.75,8.438,19.297,7,17.5,7s-3.25,1.438-3.25,3.675
								c0,1.787,1.479,3.727,1.479,3.727c0.051,0.152,0.081,0.312,0.081,0.475v0.34c0,0.423-0.251,0.809-0.642,0.985l-2.354,0.947
								c-0.546,0.245-1.706,0.738-1.813,1.321V20h6.5H24v-1.53C23.893,17.887,22.732,17.394,22.187,17.148z"/>
						</svg>');
						print("ここが自慢</div>");

						$row["syuhanten_intro"] = nl2br($row["syuhanten_intro"]);
						print("<div id=\"syuhanten_intro\" style=\"font-size:9pt; margin:4px\">".stripslashes($row["syuhanten_intro"])."</div>");
					print("</div>");

				print('</div>');

				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// 取扱い銘柄
				print('<div id="tabs-41" style="overflow:auto; min-height:80px; padding:4px 2px 4px 2px; border:0px solid #c6c6c6" class="form-action hide">');

					$sake_array = explode(',', $row["syuhanten_sake"]);

					print("<button id=\"addsake\">酒を追加する</button>");

					print('<div id="gridframe" style="position:relative">');

					for($i = 0; $i < count($sake_array); $i++)
					{
							$sql1 = "SELECT * FROM SAKE_J WHERE sake_id = '$sake_array[$i]'";
							$result1 = executequery($db, $sql1);

							if($row1 = getnextrow($result1))
							{
									print('<div class="griditem" style="position:relative; float:left; height:200px; min-width:120px; margin:8px; padding:4px; background:#c6c6c6; border:1px solid #c6c6ff;"><div style="position:relative;">'); // float position

										$path = "images/icons/NoPhotoSake.jpg";
										$sql = "SELECT filename FROM SAKE_IMAGE WHERE SAKE_IMAGE.sake_id = '" .$sake_array[$i] ."' LIMIT 2";
										$result_set = executequery($db, $sql);

										if($record = getnextrow($result_set))
										{
											$path = "images/photo/thumb/".$record["filename"];
										}

										print('<img style="height:180px; width:auto; border-radius:0px; box-shadow: 1px 1px 1px -1px rgba(0,0,0,.9);" src="' .$path .'">');
										print("<button style=\"position:absolute; right:0px; top:0px; width:46; height:22\" id=\"" .$sake_array[$i] ."\" class=\"navigate_button\" sake_name = " .$row1["sake_name"] .">削除</button>");
										print('<span style="position:absolute; width:98%; left:0px; top:164px; background:#404040; color:fff">' .$row1["sake_name"] .'</span>');
									print('</div></div>'); // float position;
							}
					}

					print("</div>"); // gridframe
				print("</div>"); // tabs-41

				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// 写真
				print('<div id="tabs-42" style="overflow:auto; min-height:80px; padding:4px 2px 4px 2px; border:0px solid #c6c6c6" class="form-action hide">');

					$result = executequery($db, "SELECT SYUHANTEN_IMAGE.syuhanten_id, SYUHANTEN_IMAGE.filename, syuhanten_name FROM SYUHANTEN_IMAGE, SYUHANTEN_J WHERE SYUHANTEN_IMAGE.syuhanten_id = SYUHANTEN_J.id AND SYUHANTEN_IMAGE.syuhanten_id = '$id' ORDER BY filename"." LIMIT 20");
					print('<button id="addimage" class="navigate_button">写真を追加する</button>');

					//print("<table id=\"gridframe\" border=\"0\">");
					//while($record = getnextrow($result))
					//{
							//$path = "images/syuhanten/".$record["filename"];
							//print("<tr>");
							//print("<td><center><img style=\"width:140px; height: auto; border-radius: 6px; box-shadow: 1px 1px 1px -1px rgba(0,0,0,.9);\" id=\"" .$record["filename"] ."\" class=\"preview\"  src=\"" .$path  ."\"></center></td>");
							//print("<td>");
							//print("<button id=\"" .$record["filename"] ."\" class=\"navigate_button\" filename = " .$record["filename"] ." style=\"width:46;height:22\">削除</button>");
							//print($record["filename"] ."</td>");
							//print("</tr>");
					//}
					//print("</table>");

				print('</div>');

				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				// コメント
				print('<div id="tabs-41" style="overflow:auto; min-height:80px; padding:4px 2px 4px 2px; border:0px solid #c6c6c6" class="form-action hide">');

				if(!$db_bbs = opendatabase("sake.db"))
				{
					  die("データベース接続エラー .<br />");
				}

				$tablename = "table_" .$id;
				$sql = "CREATE TABLE IF NOT EXISTS " .$tablename ." (message_sequence INTEGER PRIMARY KEY, contributor VARCHAR(24), subject VARCHAR(256), rank INTEGER, message VARCHAR(2048), pass_word VARCHAR(12), write_date INTEGER)";
				$result = executequery($db_bbs, $sql);

				$sql = "SELECT * FROM " .$tablename." ORDER BY message_sequence DESC";
				$result = executequery($db_bbs, $sql);

				print('<div class="threads" id="threads" style="position:relative">');

				while($record = getnextrow($result))
				{
					if($_COOKIE['usertype_cookie'] == 9)
					{
							$i = 0;
							$path = "images/icons/users.jpg";
							$rank_value = intval($row["rank"]);

							print("<div class=\"review\" style=\"width:100%;\"><img style=\"width:48px; height:auto; border-radius:4px;\" src=\"" .$path ."\">");
							print("<span style=\"position:absolute; left:60px;  top:4px;\">" .$record["contributor"] ."</span>");
							print("<span style=\"position:absolute; left:60px;  top:20px;\">" .$record["subject"] ."</span>");
							print("<span style=\"position:absolute; left:200px; top:4px;\">".gmdate("Y/m/d H:i:s",$record["write_date"] + 9 * 3600)."</span>");
							print("<span style=\"position:absolute; left:240px; top:20px; color:#F7931D;\">");

							for($i = 0; $i < $rank_value && $i < 5; $i++)
								print("&#9733");

							for(; $i < 5; $i++)
								print("&#9734");

							print("</span>");
							print("<input id=\"button\" class=\"cancel_button\" tablename=\"" .$tablename ."\" message_sequence=" .$record[message_sequence] ." type=\"button\" style=\"width:60px;\" value=\"削除\">");
							print("<span style=\"position:relative; padding-left:8px; color:#404040;\">".$record["message"]."</span>");
							print("</div>");
					}
					else
					{
							$i = 0;
							$path = "images/icons/users.jpg";
							$rank_value = intval($row["rank"]);

							print("<div class=\"review\" style=\"width:100%;\"><img style=\"width:6%; border-radius:4px;\" src=\"" .$path ."\">");
							print("<span style=\"position:absolute; left:60px;  top:4px;\">" .$record["contributor"] ."</span>");
							print("<span style=\"position:absolute; left:60px;  top:20px;\">" .$record["subject"] ."</span>");
							print("<span style=\"position:absolute; left:200px; top:4px;\">".gmdate("Y/m/d H:i:s",$record["write_date"] + 9 * 3600)."</span>");
							print("<span style=\"position:absolute; left:240px; color:#f26a19;\">");

							for($i = 0; $i < $rank_value && $i < 5; $i++)
								print("&#9733");

							for(; $i < 5; $i++)
								print("&#9734");

							print("</span>");
							print("<span style=\"position:relative; padding-left:8px; color:#404040;\">".$record["message"]."</span>");
							print("</div>");
					}
				}

				print("</div>"); // thread
				print("</div>"); // tabs-43

		print("</div>"); // tab-main
		print("</div>"); // syuhantenRow

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// 地図
		print("<div id=\"syuhanten_map\" class=\"syuhantenRow\" style=\"margin-top:8px; border:1px solid #c6c6c6; text-align:center; height:300px;\">");
			print("<iframe style=\"width:100%; height:100%; pointer-events: none;\" class=\"map\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"https://maps.google.co.jp/maps?hl=&amp;ie=UTF8&amp;q=loc:".$address."&amp;z=18&amp;iwloc=B&amp;output=embed\"></iframe>");
		print("</div>");

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		print('<div class="syuhantenRow" style="float:none; border:1px solid #c6c6c6; margin-top:18px">');
		print('<table class="syuhantentable" style="font-size:9pt">');

			// 酒販店
			print("<tr>");
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">酒販店</td>');
				print("<td style=\"margin-left:4px;\" id=\"syuhanten_code\">".$row["syuhanten"]."</td>");
			print("</tr>");

			// 都道府県よみ
			print("<tr>");
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">都道府県よみ</td>');
				print('<td style="margin-left:4px" id="spec_syuhanten_pref_read">'.$row["syuhanten_pref_read"].'</td>');
			print("</tr>");

			// URL
			print('<tr>');
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">URL</td>');
				print('<td style="margin-left:4px; id="syuhanten_url"><a href="' .$row["syuhanten_url"] .'">' .$row["syuhanten_url"]. '</a></td>');
			print('</div>');

			// FAX番号
			print('<tr>');
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">FAX</td>');
				print('<td style="margin-left:4px; id="syuhanten_fax">'.$row["syuhanten_fax"].'</td>');
			print('</tr>');

			// Email
			print('<tr>');
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">Email</td>');
				print('<td id="syuhanten_email" style="margin-left:4px; id="syuhanten_fax">'.$row["syuhanten_email"].'</td>');
			print('</tr>');

			print("<tr>");
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">ID</td>');
				print("<td style=\"margin-left:4px; id=\"syuhanten_id\">".$row["syuhanten_id"]."</td>");
			print("</tr>");

			// タイプ
			print("<tr>");
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">酒販店タイプ</td>');
				print("<td style=\"margin-left:4px; id=\"syuhanten_type\">".$row["syuhanten_type"]."</td>");
			print("</tr>");

			// 営業時間
			print('<tr>');
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">営業時間</td>');
				print('<td style="margin-left:4px" id="syuhanten_hours">'.$row["syuhanten_hours"].'</td>');
			print('</tr>');

			// 駐車場
			print("<tr>");
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">駐車場</td>');
				print("<td style=\"margin-left:4px;\" id=\"syuhanten_parking\">".$row["syuhanten_parking"]."</td>");
			print("</tr>");

			// 酒販店ソート
			print("<tr>");
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">酒販店ソート</td>');
				print("<td style=\"margin-left:4px;\" id=\"syuhanten_sort\">".$row["syuhanten_sort"]."</td>");
			print("</tr>");

			// 酒販店検索用
			print("<tr>");
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">酒販店検索用</td>');
				print("<td style=\"margin-left:4px;\" id=\"syuhanten_search\">".$row["syuhanten_search"]."</td>");
			print("</tr>");

			// メモ
			print("<tr>");
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">メモ</td>');
				print("<td style=\"margin-left:4px;\" id=\"memo\" style=\"margin-left:8px; min-height:80px;\">".$row["syuhanten_memo"]."</td>");
			print("</tr>");

			print("<tr>");
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">最終更新日</td>');
				print("<td style=\"margin-left:4px;\" id=\"syuhanten_datasource\">".$row["syuhanten_datasource"]."</td>");
			print("</tr>");

			print("<tr>");
				print('<td style="background:#f6f5ff; border-right:1px solid #e3e3e3; margin-left:4px; width:100px">Last Contacted</td>');
				print("<td style=\"margin-left:4px;\" id=\"syuhanten_lastcontacted\">".$row["syuhanten_lastcontacted"]."</td>");
			print("</tr>");

		print("</table>");
		print("</div>");

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		// 編集
		if($_COOKIE['usertype_cookie'] == 9)
		{
				print("<div class=\"syuhantenRow\" style=\"margin-top:12px; margin-top:12px; border:1px solid #c6c6c6;\"><center>");
					print("<button id=\"setting_button\" sakagura_id=\"".$row["sakagura_id"]."\">この酒販店の情報を編集する</button>");
					print("<button id=\"add_syuhanten\" syuhanten_id=\"".$row["syuhanten_id"]."\"><a style=\"text-decoration: none; color: #000;\" href=\"syuhan_add_form.php\">新しい酒販店を登録する</a></button>");
				print("</center></div>");
		}

		if(!$db = opendatabase("sake.db"))
		{
			die("データベース接続エラー .<br />");
		}

		$sql = "SELECT SAKE_J.sake_id as sake_id, sake_name, filename FROM SAKE_J, SAKE_IMAGE WHERE SAKE_J.sake_id = SAKE_IMAGE.sake_id ORDER BY RANDOM() LIMIT 12";
		$result = executequery($db, $sql);

		print("<div class=\"syuhantenRow\" style=\"margin-top:8px; overflow:auto; border:1px solid #c6c6c6; min-height:220px;\">");
		print("<div style=\"text-align:left;margin-top:10px;\"><img src=\"images/icons/recommend.gif\">オススメの酒</div>");
		print("<ul class=\"slider multiple-sake\">");

		while($record = getnextrow($result))
		{
				$path = "images\\photo\\thumb\\".$record["filename"];
				print("<li class=\"static\" id=\"" .$record["sake_id"] ."\" value=\"sake_view.php?sake_id=\" style=\"margin:auto;\">");

				print("<img id=\"" .$path ."\" style=\"border-radius: 6px; box-shadow: 1px 1px 1px -1px rgba(0,0,0,.9);\" src=\"" .$path  ."\">");
				print("<h2 style=\"position:absolute; bottom:18px; text-align: center;\">" .$record["sake_name"] ."</h2></li>");
		}

		print("</ul>");
	print("</div>");

  ///////////////////////////////////////////////////////////////////////////
  print("</div>"); // syuhantable
}
else
{
	print("no data");
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* advertisement */
print('<div id="banner_frame">');

	print('<div id="ad1" style="float:left; padding:4px">
							<img style="width:100%" src="images/ad/ad4.jpg">
							<hr style="position:relative; width:90%; margin-left:12px">
							</div>');

	print('<div id="ad2" style="float:left; padding:4px">
							<img style="width:100%" src="images/ad/ad5.jpg">
							<hr style="position:relative; width:90%;  margin-left:12px">
							</div>');

	print("<div id=\"tokusyu\" style=\"position:relative; float:left; text-align:center;  margin: 0 auto 0 auto; width:300px; height:250px; border:1px solid #e3e3e3;\">");
		print("<span style=\"position:absolute; left:1%; width:98%;  height:48px; top:0px; text-align:left; font-size:10pt; font-weight:bold; color:0740A5;\">Sakenomu特集</span>");
		print("<img  style=\"position:absolute; left:1%; width:98%;  height:48px; top:20px;\" src=\"images/icons/tokusyu.gif\">");
		print("<img  style=\"position:absolute; left:1%; width:98%;  height:48px; top:78px;\" src=\"images/icons/tokusyu2.gif\">");
	print("</div>");

	write_inshokuten($db);

print("</div>");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

print("</div>"); // container
writefooter();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<div id="dialog_background"></div>

<div id="dialog_edit_syuhanten">
	<div>酒販店を編集する</div>
	<span style="position:absolute; top:0%; right:0%; margin:2px;"><button id="close_edit_syuhanten_button" style="position:relative; background:#1F2735; box-shadow:1px 1px 1px -1px rgba(0,0,0,.9); top:-2; color:#fff; width:40px;">x</button></span>
	<center>

	<form id="form_edit_syuhanten" style="overflow:auto; padding:4px; height:87%; border:1px solid #626262" name="form_edit_syuhanten" method="post">
			<table class="edittable">
			<tr class="alt">
			<td style="width:120px">酒販店名</td>
			<td colspan="3"><input style="width:100%" id = "dialog_syuhanten_name" type="text" name="syuhanten_name"></td>
			</tr>

			<tr class="alt">
			<td>ふりがな</td>
			<td colspan="3"><input style="width:100%" id = "dialog_syuhanten_read" type="text" name="syuhanten_read"></td>
			</tr>

			<tr class="alt">
			<td>英語よみ</td>
			<td colspan="3"><input style="width:100%" id = "dialog_syuhanten_english" type="text" name="syuhanten_english"></td>
			</tr>

			<tr class="alt">
			<td>その他の読み方</td>
			<td colspan="3"><input style="width:100%" id="dialog_syuhanten_search" type="text" name="syuhanten_search"></td>
			</tr>

			<tr class="alt">
			<td>酒販店(優先度)</td>
			<td colspan="3"><SELECT id="dialog_syuhanten_rank" name="syuhanten">
			<OPTION VALUE="">指定なし</OPTION>
			<OPTION VALUE="1">S</OPTION>
			<OPTION VALUE="2">A</OPTION>
			<OPTION VALUE="3">B</OPTION>
			<OPTION VALUE="4">C</OPTION>
			<OPTION VALUE="5">D</OPTION>
			<OPTION VALUE="6">X</OPTION>
			</SELECT></td>
			</tr>

			<!--
			<tr class="alt">
			<td>酒販店ID</td>
			<td colspan="3" id="dialog_syuhanten_id" style="color:#FFF"></td>
			</tr>

			<tr class="alt">
			<td>タイプ</td>
			<td colspan="3"><input style="width:100%" id = "dialog_syuhanten_type" type="text" name="dialog_syuhanten_type"></td>
			</tr>
			-->

			<tr class="alt">
			<td>酒販店の紹介</td>
			<td colspan="3"><textarea id="dialog_syuhanten_intro" rows="4" style="width:100%;"  name="syuhanten_intro"></textarea></td>
			</tr>

			<tr class="alt">
			<td>都道府県</td>
			<td colspan="3"><SELECT id = "dialog_syuhanten_pref" type="text" name="syuhanten_pref">
			<OPTION VALUE="">すべて</OPTION>
			<OPTION VALUE="北海道">北海道</OPTION>
			<OPTION VALUE="青森県">青森県</OPTION>
			<OPTION VALUE="岩手県">岩手県</OPTION>
			<OPTION VALUE="宮城県">宮城県</OPTION>
			<OPTION VALUE="秋田県">秋田県</OPTION>
			<OPTION VALUE="山形県">山形県</OPTION>
			<OPTION VALUE="福島県">福島県</OPTION>
			<OPTION VALUE="茨城県">茨城県</OPTION>
			<OPTION VALUE="栃木県">栃木県</OPTION>
			<OPTION VALUE="群馬県">群馬県</OPTION>
			<OPTION VALUE="埼玉県">埼玉県</OPTION>
			<OPTION VALUE="千葉県">千葉県</OPTION>
			<OPTION VALUE="東京都">東京都</OPTION>
			<OPTION VALUE="神奈川県">神奈川県</OPTION>
			<OPTION VALUE="新潟県">新潟県</OPTION>
			<OPTION VALUE="富山県">富山県</OPTION>
			<OPTION VALUE="石川県">石川県</OPTION>
			<OPTION VALUE="福井県">福井県</OPTION>
			<OPTION VALUE="山梨県">山梨県</OPTION>
			<OPTION VALUE="長野県">長野県</OPTION>
			<OPTION VALUE="岐阜県">岐阜県</OPTION>
			<OPTION VALUE="静岡県">静岡県</OPTION>
			<OPTION VALUE="愛知県">愛知県</OPTION>
			<OPTION VALUE="三重県">三重県</OPTION>
			<OPTION VALUE="滋賀県">滋賀県</OPTION>
			<OPTION VALUE="京都府">京都府</OPTION>
			<OPTION VALUE="大阪府">大阪府</OPTION>
			<OPTION VALUE="兵庫県">兵庫県</OPTION>
			<OPTION VALUE="奈良県">奈良県</OPTION>
			<OPTION VALUE="和歌山県">和歌山県</OPTION>
			<OPTION VALUE="鳥取県">鳥取県</OPTION>
			<OPTION VALUE="島根県">島根県</OPTION>
			<OPTION VALUE="岡山県">岡山県</OPTION>
			<OPTION VALUE="広島県">広島県</OPTION>
			<OPTION VALUE="山口県">山口県</OPTION>
			<OPTION VALUE="徳島県">徳島県</OPTION>
			<OPTION VALUE="香川県">香川県</OPTION>
			<OPTION VALUE="愛媛県">愛媛県</OPTION>
			<OPTION VALUE="高知県">高知県</OPTION>
			<OPTION VALUE="福岡県">福岡県</OPTION>
			<OPTION VALUE="佐賀県">佐賀県</OPTION>
			<OPTION VALUE="長崎県">長崎県</OPTION>
			<OPTION VALUE="熊本県">熊本県</OPTION>
			<OPTION VALUE="大分県">大分県</OPTION>
			<OPTION VALUE="宮城県">宮城県</OPTION>
			<OPTION VALUE="鹿児島県">鹿児島県</OPTION>
			<OPTION VALUE="沖縄県">沖縄県</OPTION>
			</SELECT></td></tr>
			<tr class="alt">
			<td>郵便番号</td>
			<td colspan="3"><input style="width:100%" id="dialog_syuhanten_postal_code" type="text" name="syuhanten_postal_code"></td>
			</tr>
			<tr class="alt">
			<td>住所</td>
			<td colspan="3"><input style="width:100%" id = "dialog_syuhanten_address" type="text" name="syuhanten_address"></td>
			</tr>
			<tr class="alt">
			<td>電話番号</td>
			<td colspan="3"><input style="width:100%" id="dialog_syuhanten_phone" type="text" name="syuhanten_phone"></td>
			</tr>
			<tr class="alt">
			<td>FAX番号</td>
			<td colspan="3"><input style="width:100%" id="dialog_syuhanten_fax" type="text" name="syuhanten_fax"></td>
			</tr>
			<tr class="alt">
			<td>ウェブサイト</td>
			<td colspan="3"><input style="width:100%"  id = "dialog_syuhanten_url" type="text" name="syuhanten_url"></td>
			</tr>
			<tr class="alt">
			<td>Email</td>
			<td colspan="3"><input style="width:100%" id = "dialog_syuhanten_email" type="text" name="syuhanten_email"></td>
			</tr>

			<!--
			<tr class="alt">
			<td>酒販店ソート</td>
			<td colspan="3"><input style="width:100%" id="dialog_syuhanten_sort" type="text" name="syuhanten_sort"></td>
			</tr>
			-->

			<tr class="alt">
			<td>営業時間</td>
			<td colspan="3"><textarea id="dialog_syuhanten_hours" style="width:100%; height:62px" name="syuhanten_hours"></textarea></td>
			</tr>

			<tr class="alt">
			<td>定休日</td>
			<td colspan="3"><input style="width:100%" id="dialog_syuhanten_closed" type="text" name="syuhanten_closed"></td>
			</tr>

			<tr class="alt">
			<td>駐車場</td>
			<td colspan="3"><input size="20" id="dialog_syuhanten_parking" type="text" name="syuhanten_parking"></td>
			</tr>

			<tr class="alt">
			<td>取扱い銘柄</td>
			<td colspan="3"><input style="width:100%" id = "dialog_syuhanten_sake" type="text" name="dialog_syuhanten_sake"></td>
			</tr>

			<tr class="alt">
			<td>メモ</td>
			<td colspan="3"><textarea id="dialog_syuhanten_memo" rows="4" style="width:100%" name="syuhanten_memo"></textarea></td>
			</tr>

			<tr class="alt">
			<td>データ状況</td>
			<td colspan="3"><SELECT id="dialog_syuhanten_develop" name="syuhanten_develop">
			<OPTION VALUE="0">未完成</OPTION>
			<OPTION VALUE="1">完成</OPTION>
			<OPTION VALUE="2">途中</OPTION></SELECT></td></tr>
			</table>
	</form>
	<input type="button" id="edit_syuhanten_ok" style="height:24px;" value="更新">
	<input type="button" id="edit_syuhanten_close" style="height:24px;" value="閉じる">
	</center>
</div>

<div id="dialog_send_syuhanten">
	<div>酒販店にメールを送る</div>
	<span style="position:absolute; top:0%; right:0%; margin:2px;"><button id="close_mail_button" style="position:relative; background:#1F2735; box-shadow:1px 1px 1px -1px rgba(0,0,0,.9); top:-2; color:#fff; width:40px;">x</button></span>
	<div id="dialog_send_syuhanten_container" style="position:relative; overflow:auto; padding:4px; height:92%; border:1px solid #626262;">
	<center>
			<div style="overflow:auto; width:92%; height:88%; margin:18px auto auto auto; border: 1px solid #ccc; rgba(31, 39, 53);">
					<div>
						<span style="float:left; margin-left:4px; width:100px; text-align:left;">題名</span>
						<span><input id="mail_subject" value="" style="text-align:left; width:100%" placeholder="題名を入力してください"></span>
					</div>

					<div>
						<span style="float:left; margin-left:4px; width:100px; text-align:left;">メッセージ</span>
						<span><textarea id="mail_message" style="text-align:left; width:100%; height:380px" placeholder="コメントを入力してください"></textarea></span>
					</div>
			</div>
			<input type="button" id="send_syuhanten_close" style="height:24px;" value="閉じる">
	</center>
	</div>
</div>


<!-- Add Image -->
<div id="dialog_addimage">

		<div id="dialog_title">写真の追加</div>
		<span style="position:absolute; top:0%; right:0%; margin:2px;"><button id="close_addimage_button" style="position:relative; background:#1F2735; box-shadow:1px 1px 1px -1px rgba(0,0,0,.9); top:-2; color:#fff; width:40px;">x</button></span>

		<div id="dialog_addimage_container" style="position:relative; overflow:auto; padding:4px; height:92%; border:1px solid #626262;">
			<center>
			<div style="overflow:auto; width:70%; height:88%; margin:auto; border: 1px solid #ccc;">
					<img style="position:relative; margin-top:18px; height:80%; width:auto; image-orientation:from-image; background: rgba(31, 39, 53);" src="" id="image">
			</div>

			<progress style="width:70%; margin:auto" id="progressBar" value="0" max="100"></progress>
			<div id="status"></div>
			<div id="loaded_n_total"></div>

			<input type="file" id="file1" onchange="handleFiles()">
			<input type="button" id="submit" value="アップロード" onclick="uploadFile()">
			<input type="button" id="edit_addimage_close" style="height:24px;" value="閉じる">
			</center>
		</div>
</div>

<!-- dialog preview -->
<div id="dialog_preview">
		<div>写真の表示</div>
		<span style="position:absolute; top:0%; right:0%; margin:2px;"><button id="close_preview_button" style="position:relative; background:#1F2735; box-shadow:1px 1px 1px -1px rgba(0,0,0,.9); top:-2; color:#fff; width:40px;">x</button></span>
		<div id="dialog_preview_container" style="position:relative; overflow:auto; padding:4px; height:92%; border:1px solid #626262;">
					<center>
					<div style="overflow:auto; width:70%; height:88%; margin:auto; border: 1px solid #ccc; rgba(31, 39, 53);">
							<img class="full" style="position:relative; margin-top:18px; height:88%; width:auto; image-orientation: from-image;" src="" id="previe_image">
					</div>
					<div id="dialog_preview_filename"></div>
					<input type="button" id="edit_preview_close" style="height:24px;" value="閉じる">
					</center>
		</div>
</div>

<!-- dialog bbs -->
<div id="dialog_syuhanten_bbs">
	<div>コメントを投稿する</div>
	<span style="position:absolute; top:0%; right:0%; margin:2px;"><button id="close_syuhanten_bbs_button" style="position:relative; background:#1F2735; box-shadow:1px 1px 1px -1px rgba(0,0,0,.9); top:-2; color:#fff; width:40px;">x</button></span>
	<div id="dialog_syuhanten_bbs_container" style="position:relative; overflow:auto; padding:4px; height:92%; border:1px solid #626262;">
	<center>
			<div style="overflow:auto; width:92%; height:88%; margin:18px auto auto auto; border: 1px solid #ccc; rgba(31, 39, 53);">
					<div>
						<span style="float:left; margin-left:4px; width:100px; text-align:left;">題名</span>
						<span><input id="bbs_subject" value="" style="text-align:left; width:100%" placeholder="題名を入力してください"></span>
					</div>
					<div>
							<span style="float:left; margin-left:4px; width:120px; text-align:left;">メッセージ</span>
							<span style="float:right; width:60px"><SELECT id="bbs_rank" name="sake_rank">
										<OPTION VALUE="0">0</OPTION>
										<OPTION VALUE="1">1</OPTION>
										<OPTION VALUE="2">2</OPTION>
										<OPTION VALUE="3">3</OPTION>
										<OPTION VALUE="4">4</OPTION>
										<OPTION VALUE="5">5</OPTION>
										</SELECT>
							</span>
							<span style="float:right; width:80px; text-align:left;">酒販店の評価</span>
							<span><textarea id="bbs_message" style="text-align:left; width:100%; height:82%" placeholder="コメントを入力してください"></textarea></span>
					</div>
			</div>
			<input type="button" id="syuhanten_bbs_ok" style="height:24px;" value="投稿する">
			<input type="button" id="syuhanten_bbs_close" style="height:24px;" value="閉じる">
	</center>
	</div>
</div>

<div id="dialog_add_sake">
	<div>酒を追加する</div>
	<span style="position:absolute; top:0%; right:0%; margin:2px;"><button id="close_add_sake_button" style="position:relative; background:#1F2735; box-shadow:1px 1px 1px -1px rgba(0,0,0,.9); top:-2; color:#fff; width:40px;">x</button></span>
	<div id="dialog_syuhanten_bbs_container" style="position:relative; overflow:auto; padding:4px; height:92%; border:1px solid #626262;">
	<center>
			<div style="overflow:auto; width:92%; height:88%; margin:18px auto auto auto; border: 1px solid #ccc; rgba(31, 39, 53);">
					<div style="width:98%; text-align:left;">日本酒の銘柄</div>
					<div style="width:98%"><input id="add_sake_input" style="width:95%; height:24px; autocomplete="off" placeholder="日本酒を検索" type="text" name="sake_name"></div>
					<div style="position:relative; height:82%; width:98%; border:1px solid #404040;">
				　		<ul id="add_sake_content" style="left:4px; right:4px; height:100%; border:1px solid #ccc;"></ul>
					</div>
			</div>
			<input type="button" id="add_sake_ok" class="regular_button" style="height:24px;" value="追加する">
			<input type="button" id="add_sake_close" class="regular_button" style="height:24px;" value="閉じる">
	</center>
	</div>
</div>

<script type="text/javascript">

Array.prototype.remove = function(x) {
    var i;

    for(i in this){
        if(this[i].toString() == x.toString()){
            this.splice(i, 1)
        }
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
// 編集
////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {

	$("#addsake").click(function() {
			$("#dialog_background").css({"display":"block"});
			$("#dialog_add_sake").css({"display":"block"});
	});

	$("#add_sake_close").click(function() {
		$("#dialog_background").css({"display":"none"});
		$("#dialog_add_sake").css({"display":"none"});
	});

	$("#add_sake_content li").click(function () {

		if($(this).hasClass("checked"))
		{
				$(this).removeClass("checked");
				this.style.backgroundColor = "";
				this.style.color = "#000"
		}
		else
		{
				$(this).addClass("checked");
				this.style.backgroundColor = "#FFC88D";
				this.style.color = "#404040"
		}
	});

	$("#add_sake_ok").click(function() {

			var sake_array = $('#hidden_syuhanten_sake').val().split(',');
			var sake_ids = [];
			var sake_names = [];
			var sake_images = [];

			$('#add_sake_content li.checked').each(function(){
					//alert("this:" + $(this).attr('sake_id'));
					//alert("this:" + $(this).text());
					//alert("image:" + $(this).find("img").attr('src'));

					if(jQuery.inArray($(this).attr('sake_id'), sake_array) < 0)
					{
						//alert("find the value " + $(this).attr('sake_id') + " in " + sake_ids + ":" + jQuery.inArray($(this).attr('sake_id'), sake_ids));
						//sake_names.push($(this).find("span").text());

						//alert("children:" + $(this).children('span:first').text());
						//alert("sake_name:" + $(this).text());

						sake_ids.push($(this).attr('sake_id'));
						sake_names.push($(this).text());
						sake_images.push($(this).find("img").attr('src'));
					}
			});

			//alert("saka_ids:" + sake_ids + " length: " + sake_ids.length);
			//alert("length: " + sake_ids.length);

			if(sake_ids.length > 0)
			{
				var new_array = sake_array.concat(sake_ids);
				var data = "syuhanten_id=" + $('#hidden_syuhanten_id').val() + "&syuhanten_sake=" + new_array;

				$.ajax({
						type: "post",
						url: "cgi/syuhan_update.php?id=<?php print($_GET['syuhanten_id']);?>",
						data: data,
				}).done(function(xml){
						var str = $(xml).find("str").text();

						if(str == "success")
						{
							//alert("success:" + $(xml).find("sql").text());
							var path = "images/icons/NoPhotoSake.jpg";

							for(var i = 0; i < sake_ids.length; i++)
							{
								//alert("sake_names[i]:" + sake_names[i]);
								var innerHTML = '<div class="griditem" style="position:relative; float:left; height:200px; min-width:120px; margin:8px; padding:4px; background:#c6c6c6; border: 1px solid #c6c6c6;"><div style="position:relative;">' +
										'<img style="height:180px; width:auto; border-radius: 6px; box-shadow: 1px 1px 1px -1px rgba(0,0,0,.9);" src="' + sake_images[i] + '">' +
										'<button style="position:absolute; right:0px; top:0px; width:46; height:22" id="' + sake_ids[i] + '" class="navigate_button" sake_name = "' + sake_names[i] + '">削除</button>' +
										'<span style="position:absolute; width:98%; left:0px; top:164px; background:#404040; color:fff">' + sake_names[i] + '</span>' +
										'</div></div>';

								$(innerHTML).hide().prependTo('#gridframe').fadeIn(900);
								//$('#gridframe').prepend(innerHTML);
							}

							$('#hidden_syuhanten_sake').val(sake_array);
						}
						else
						{
								alert("SQL returned Failed:" +str);
						}
				}).fail(function(data){
							var str = $(xml).find("str").text();
							alert("Failed:" +str);
				});
			}

			$("#dialog_background").css({"display":"none"});
			$("#dialog_add_sake").css({"display":"none"});
      $('#add_sake_content').empty();
      $('#add_sake_input').val('');
	});

	$("#add_sake_close, #close_add_sake_button").click(function() {
			$("#dialog_background").css({"display":"none"});
			$("#dialog_add_sake").css({"display":"none"});
      $('#add_sake_content').empty();
      $('#add_sake_input').val('');
	});

  // 追加する酒の検索
  $('#add_sake_input').on('keyup', function() {

    var inputText = $("#add_sake_input").val();
    var count = inputText.length;
    var search_limit = 24;
    var search_type = 1;

    var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

		if(count >= 1)
    {
        $.ajax({
			type: "POST",
			url: "cgi/auto_complete.php",
			data: data,
			dataType: 'json',

        }).done(function(data){

            //alert("succeded:" + data + "length:" + data.length);
            $('#add_sake_content').empty();

            for(var i = 0; i < data.length; i++)
            {
								//alert("filename: " + data[i].filename);
                $('#add_sake_content').append('<li class="message_class" sake_id="' + data[i].sake_id + '"><span style="width:28px"><img style="height:28px; width:auto;" src="' + data[i].filename + '"></span><span style="margin-left:4px">' + data[i].sake_name + '</span><span style="margin-left:8px">' + data[i].sakagura_name + '</span><span style="margin-left:8px">' + data[i].pref + '</span></li>');
            }

            $("#add_sake_content").css({"visibility": "visible"});

        }).fail(function(data){
            //alert("Failed:" + data);
        });
    }
    else
    {
        $('#add_sake_content').empty();
    }
  }); // keyup
});

$(function() {
		$('#addimage').click(function(){

				var element_width  = $("#dialog_addimage").width();
				var element_height = $("#dialog_addimage").height();
				var w = $(window).width();
				var h = (document.body.clientHeight < document.documentElement.clientHeight) ? document.body.clientHeight : document.documentElement.clientHeight;

				var element_x = (w / 2) - (element_width  / 2);
				var element_y = (h / 2) - (element_height / 2);
				var	offset_x = window.pageXOffset;
				var	offset_y = 0; //window.pageYOffset;

				$("#dialog_addimage").css({left:element_x + offset_x, top:element_y + offset_y});
				$("#dialog_background").css({"display":"block"});
				$("#dialog_addimage").css({"display":"block"});
		});

		$('#close_addimage_button').click(function(){
				$("#dialog_background").css({"display":"none"});
				$("#dialog_addimage").css({"display":"none"});
		});

		$('#edit_addimage_close').click(function(){
				$("#dialog_background").css({"display":"none"});
				$("#dialog_addimage").css({"display":"none"});
		});
});

$(function() {

	$("#setting_button").click(function() {

			$('#dialog_syuhanten_pref option').each(function(){

					if(this.value == $("#syuhanten_prefecture").text())
					{
						 //alert("match pref:" + this.value);
						 $("#dialog_syuhanten_pref").val($("#syuhanten_prefecture").text());
						 return false;
					}
			});

			var hidden_syuhanten_rank = document.getElementById("hidden_syuhanten_rank");
			var hidden_syuhanten_country = document.getElementById("hidden_syuhanten_country");

			//alert("syuhanten_id:" + $("#hidden_syuhanten_id").val());
			$("#dialog_syuhanten_id").text($("#hidden_syuhanten_id").val());
			$("#dialog_syuhanten").val($("#hidden_syuhanten").val());
			$("#dialog_syuhanten_type").val($("#syuhanten_type").text());
			$("#dialog_syuhanten_name").val($("#syuhanten_name").text());
			$("#dialog_syuhanten_read").val($("#syuhanten_read").text());
			$("#dialog_syuhanten_english").val($("#syuhanten_english").text());
			$("#dialog_syuhanten_search").val($("#syuhanten_search").text());
			$("#dialog_syuhanten_sort").val($("#syuhanten_sort").text());

			$("#dialog_syuhanten_hours").val($("#syuhanten_hours").text());

			$("#dialog_syuhanten_closed").val($("#syuhanten_closed").text());

			$("#dialog_syuhanten_intro").val($("#syuhanten_intro").text());
			$("#dialog_syuhanten_postal_code").val($("#syuhanten_postal_code").text());
			$("#dialog_syuhanten_address").val($("#hidden_syuhanten_address").val());
			$("#dialog_syuhanten_phone").val($("#syuhanten_phone").text());
			$("#dialog_syuhanten_fax").val($("#syuhanten_fax").text());
			$("#dialog_syuhanten_url").val($("#syuhanten_url").text());
			$("#dialog_syuhanten_email").val($("#syuhanten_email").text());
			$("#dialog_syuhanten_parking").val($("#syuhanten_parking").text());
			$("#dialog_syuhanten_sake").val($("#syuhanten_sake").text());
			$("#dialog_syuhanten_memo").val($("#syuhanten_memo").text());
			$("#dialog_syuhanten_datasource").val($("#syuhanten_datasource").text());
			$("#dialog_syuhanten_lastcontacted").val($("#syuhanten_lastcontacted").text());
			//alert("username: " + username + fname + lname + minit + sex + bdate + email + phone + country + region + pref + address + address_read + postal_code);

			if($("#hidden_syuhanten_develop").val() != undefined)
			{
					$('#dialog_syuhanten_develop option').each(function(){

							if(this.value == $("#hidden_syuhanten_develop").val())
							{
									 $("#dialog_syuhanten_develop").val($("#hidden_syuhanten_develop").val());
									 return false;
							}
					});
			}

			$("#dialog_background").css({"display":"block"});
			$("#dialog_edit_syuhanten").css({"display":"block"});
	});

	$("#edit_syuhanten_close, #close_edit_syuhanten_button").click(function() {
			$("#dialog_background").css({"display":"none"});
			$("#dialog_edit_syuhanten").css({"display":"none"});
	});

	$("#edit_syuhanten_ok").click(function() {

				event.preventDefault();
				var syuhanten_id = <?php echo json_encode($syuhanten_id); ?>;
				var data = "syuhanten_id=" +syuhanten_id + '&' + $("#form_edit_syuhanten").serialize();

				$.ajax({
						type: "post",
						url: "cgi/syuhan_update.php?id=<?php print($_GET['syuhanten_id']);?>",
						data: data,
				}).done(function(xml){
						str = $(xml).find("str").text();
						//alert("success:" + str);

						if(str == "success")
						{
								//alert("success:" + $(xml).find("sql").text());
								//alert("success:" + $(xml).find("sakagura_name").text() + " done");
								$("#syuhanten_code").text($(xml).find("syuhanten").text());

								///////////////////
								// syuhanten rank
								///////////////////
								var i = 0;
								var syuhanten_rank_value = parseInt($("#dialog_syuhanten_rank").val());
								var rank_star_value = "";

								for(i = 0; i < syuhanten_rank_value && i < 5; i++)
									rank_star_value += "&#9733";

								for(; i < 5; i++)
									rank_star_value += "&#9734";

								$("#hidden_syuhanten_rank").val($("#dialog_syuhanten_rank").val());
								$("#hidden_syuhanten_develop").text($("#dialog_syuhanten_develop").val());
								$("#syuhanten_rank").html($("#dialog_syuhanten_rank").val());
								$("#syuhanten_rank_star").html(rank_star_value);

								$("#syuhanten_type").text($("#dialog_syuhanten_type").val());
								$("#syuhanten_prefecture").text($("#dialog_syuhanten_pref").val());
								$("#syuhanten_pref_read, #spec_syuhanten_pref_read").text($("#dialog_pref_read").val());
								$("#syuhanten_name").text($("#dialog_syuhanten_name").val());
								$("#syuhanten_read").text($("#dialog_syuhanten_read").val());
								$("#syuhanten_english").text($("#dialog_syuhanten_english").val());
								$("#syuhanten_search").text($("#dialog_syuhanten_search").val());
								$("#syuhanten_sort").text($("#dialog_syuhanten_sort").val());
								$("#syuhanten_hours").text($("#dialog_syuhanten_hours").val());

								//var intro = nl2br($(xml).find("syuhanten_intro").text());
								//var intro = nl2br(input_syuhanten_intro.value);
								$("#syuhanten_intro").html(nl2br($("#dialog_syuhanten_intro").val()));
								$("#syuhanten_postal_code").text($("#dialog_syuhanten_postal_code").val());
								$("#syuhanten_prefecture").text($("#dialog_syuhanten_prefecture").val());
								$("#syuhanten_address").text($("#dialog_syuhanten_address").val());

								$("#syuhanten_phone").text($("#dialog_syuhanten_phone").val());
								$("#syuhanten_fax").text($("#dialog_syuhanten_fax").val());
								$("#syuhanten_url").text($("#dialog_syuhanten_url").val());
								$("#syuhanten_email").text($("#dialog_syuhanten_email").val());
								$("#syuhanten_closed").text($("#dialog_syuhanten_closed").val());
								$("#syuhanten_parking").text($("#dialog_syuhanten_parking").val());
								$("#syuhanten_sake").text($("#dialog_syuhanten_sake").val());
								$("#memo").text($("#dialog_syuhanten_memo").val());
								$("#syuhanten_datasource").text($("#dialog_syuhanten_datasource").val());
								$("#syuhanten_lastcontacted").text($("#dialog_syuhanten_lastcontacted").val());

								//		if($("#dialog_syuhanten_develop").val() == "0")
								//		{
								//			 $("#status").text("未完成");
								//		}
								//		else if($("#dialog_syuhanten_develop").val() == "1")
								//		{
								//			 $("#status").text("完成");
								//		}
								//		else if($("#dialog_syuhanten_develop").val() == "2")
								//		{
								//			 $("#status").text("途中");
								//		}
						 }
						 else
						 {
								alert("else:" + str);
								$("#sample1").text(str);
						 }
				}).fail(function(data){
					 alert("This is Error");
					 $("#sample1").text('This is Error');
				});

				$("#dialog_background").css({"display":"none"});
				$("#dialog_edit_syuhanten").css({"display":"none"});
	  });
});

////////////////////////////////////////////////////////////////////////////////////////////////////////
// メール
////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {
	$("#button_syuhanten_mail").click(function() {
			$("#dialog_background").css({"display":"block"});
			$("#dialog_send_syuhanten").css({"display":"block"});
	});

	$("#mail_syuhanten_ok").click(function() {

      var syuhanten_id = <?php echo json_encode($syuhanten_id); ?>;
      var syuhanten_name = <?php echo json_encode($syuhanten_name); ?>;

      var data = "sakagura_id="    +syuhanten_id +
                 "&sakagura_name=" +syuhanten_name +
                 "&title="         +$("#mail_subject").val() +
                 "&message="       +$("#mail_message").val();

      $.ajax({
          type: "post",
          url: "cgi/sda_send_message.php",
          data: data,
      }).done(function(xml){
          var str = $(xml).find("str").text();
          var intime = $(xml).find("intime").text();

          //alert("received: " +str + " " + intime + " " + intime);

          if(str == "success")
          {
              alert("message was sent:" + intime);
          }
          else
          {
              $("#sample1").text(str);
          }
      }).fail(function(data){
          alert("This is Error");
      });

			$("#dialog_background").css({"display":"none"});
			$("#dialog_send_syuhanten").css({"display":"none"});
	});

	$("#send_syuhanten_close, #close_mail_button").click(function() {
			$("#dialog_background").css({"display":"none"});
			$("#dialog_send_syuhanten").css({"display":"none"});
	});
});

$(function() {
	$('.multiple-sake').slick({
		infinite: true,
		dots:false,
		slidesToShow: 6,
		slidesToScroll: 6,
		responsive: [{
			breakpoint: 820,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
			}
		},{
			breakpoint: 480,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
				}
			}
		]
	});
});

function _(el){
  return document.getElementById(el);
}

function progressHandler(event){
    _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
    var percent = (event.loaded / event.total) * 100;
    _("progressBar").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}

function completeHandler(event){
    var responseText = event.target.responseText;
    var responseArray = JSON.parse(responseText);
    var path = "images\\photo\\" + responseArray[0];

    if($('#hidden_data_type').val() == "sakagura")
    {
        path = "images\\sakagura\\" + responseArray[0];
    }

    _("status").innerHTML = responseArray[0];
    _("progressBar").value = 0;

    var innerHTML = '<tr><td><center>' +
        '<img id="' + responseArray[0] + '" style="width:140px; height: auto;" class="preview" src="' + path + '"></center></td>' +
        '<td><button filename =' + responseArray[0] + ' class="navigate_button" style="width:46; height:22">削除</button>' + responseArray[0] + '</td></tr>';

    $element = $('#gridframe').prepend(innerHTML);
}

function errorHandler(event){
  _("status").innerHTML = "Upload Failed";
}

function abortHandler(event){
  _("status").innerHTML = "Upload Aborted";
}

function uploadFile()
{
    var file = _("file1").files[0];

    if(file)
    {
        // alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();

        formdata.append("file1", file);
        formdata.append("id", $('#hidden_id').val());
        formdata.append("title", $('#hidden_title').val());
        formdata.append("data_type", $('#hidden_data_type').val());

        //alert("data_type:" + $('#hidden_data_type').val());
        //alert("completeHander");

        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "data_upload_parser.php");
        ajax.send(formdata);
    }
}

function handleFiles()
{
    var filesToUpload = document.getElementById('file1').files;
    var file = filesToUpload[0];
    var img = document.createElement("img"); // Create an image
    var reader = new FileReader(); // Create a file reader

    // Set the image once loaded into file reader
    reader.onload = function(e) {

        img.src = e.target.result;

        //var canvas = $("<canvas>", {"id":"testing"})[0];
        var canvas = document.createElement("canvas");
        var MAX_WIDTH = 500;
        var MAX_HEIGHT = 400;
        var width = img.width;
        var height = img.height;

        if(width > height)
        {
            if (width > MAX_WIDTH)
            {
                height *= MAX_WIDTH / width;
                width = MAX_WIDTH;
            }
        }
        else
        {
            if(height > MAX_HEIGHT)
            {
                width *= MAX_HEIGHT / height;
                height = MAX_HEIGHT;
            }
        }

        canvas.width = width;
        canvas.height = height;

        var ctx = canvas.getContext("2d");

        ctx.drawImage(img, 0, 0, width, height);
        //var dataurl = canvas.toDataURL("image/png");
        var dataurl = canvas.toDataURL("image/jpg");
        document.getElementById('image').src = dataurl;
    }

    reader.readAsDataURL(file);
} // handleFiles()

function nl2br(str, is_xhtml) {
  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

  return (str + '')
    .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

jQuery(document).ready(function(){

  $("body").wrapInner('<div id="wrapper"></div>');

	$('#tab_main').createTabs({
			text : $('#tab_main ul')
	});

    $("body").fadeIn(400);

	$(document).on('click','#follow', function(){
	    var data = $("#form").serialize();

	    //alert("data:" + data);

		  $.ajax({
					type: "post",
					url: "cgi/syuhan_follow.php?syuhanten_id=<?php print($_GET['syuhanten_id']);?>",
					data: data,
		  }).done(function(xml){
					var str = $(xml).find("str").text();
					//alert("str:" + str);

					if(str == "follow")
					{
							$("#follow").text("フォローする");
					}
					else if(str == "followed")
					{
							$("#follow").text("フォロー中");
					}
		  }).fail(function(data){
					alert("This is Error");
					$("#follow").text('This is Error');
		  });
	});

	$('#delete_syuhanten').click(function(){

    var syuhanten_id = $(this).attr('syuhanten_id');

    if(confirm("削除しますか:" + syuhanten_id) == true)
		{
			var data = "id="+syuhanten_id;

			  $.ajax({
				  type: "post",
				  url: "cgi/syuhan_dynamic_delete.php?id=<?php print($_GET['syuhanten_id']);?>",
				  data: data,
			  }).done(function(xml){
				  var str = $(xml).find("str").text();

				  if(str == "success")
				  {
					  alert("酒販店を削除しました");
					  window.open('sake_search.php', '_self');
				  }

			  }).fail(function(data){
				  var str = $(xml).find("str").text();
				  alert("Failed:" +str);
			  });
		  }
  });

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // gridframe events
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $("#gridframe").delegate('div', 'mouseover', function() {
			//alert("syuhanten mouseover");
			$(this).css('background-color', '#ffc6c6');
	});

  $("#gridframe").delegate('div', 'mouseleave', function() {
			$(this).css('background-color', '#c6c6c6');
	});

  $("#gridframe").delegate('button', 'click', function() {

			var sake_id = $(this).attr('id');
			var sake_name = $(this).attr('sake_name');

			//alert("button clicked:" + sake_name);

      if(confirm(sake_name + "を削除しますか?") == true)
      {
				  var data = "syuhanten_id=" + $('#hidden_syuhanten_id').val();
					var sake_array = $('#hidden_syuhanten_sake').val().split(',');
					var obj = this;
					sake_array.remove(sake_id);

					//alert("sake_id:" + $('#hidden_syuhanten_id').val());

					$('#hidden_syuhanten_sake').val(sake_array);
					data += "&syuhanten_sake=" + $('#hidden_syuhanten_sake').val();
			//alert("data:" + data);

			$.ajax({
				type: "post",
				url: "cgi/syuhan_update.php?id=<?php print($_GET['syuhanten_id']);?>",
				data: data,
			}).done(function(xml){
				var str = $(xml).find("str").text();
				//alert("success");

					if(str == "success")
					{
						$(obj).closest('div').parent().fadeOut();
						//$(obj).closest('div').fadeOut();
					}
					else
					{
					  alert("SQL returned Failed:" +str);
					}
				}).fail(function(data){
					var str = $(xml).find("str").text();
					alert("Failed:" +str);
				});
			}
   });

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // recommended sake events
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  $(".static").draggable({
    start: function(event, ui) {
				//alert("no click");
        $(this).addClass('noclick');
    }
  });

  $(".static").click(function() {
			if ($(this).hasClass('noclick')) {
					$(this).removeClass('noclick');
			}
			else {
				var url = $(this).attr('value');

				//alert("url:" + url + " id:" + this.id);
				//var sake_id = $(this).attr('sake_id');
				//alert("image id:" + sake_id);
				window.open(url + this.id, '_self');
		 }
  });

  $(".static").mouseover(function() {
      $(this).find("h2").css('visibility','visible');
      $(this).find("h2").fadeIn();
  });

  $(".static").mouseleave(function() {
      $(this).find("h2").fadeOut();　
      $(this).find("h2").css('visibility','hidden');
  });

  /*************************************************************************************/
  $(".syuhanten").click(function() {
      //alert("syuhanten click");
      var url = $(this).attr('value');
      window.open(url + this.id, '_self');
  });

  $(".syuhanten").mouseover(function() {
      //alert("syuhanten mouseover");
      $(this).find("h1").css('background-color', '#404040');
      $(this).find("h1").css('color', '#fff');
  });

  $(".syuhanten").mouseleave(function() {
      $(this).find("h1").css('background-color', '#e3e3e3');
      $(this).find("h1").css('color', '#404040');
  });

  /*************************************************************************************/
  $('div#head_left div').on('mousedown', 'li, a', function() {
      //brand_id = $(this).attr('brand_id');
      //location.href = '/brands/' + brand_id + '/';
  });

  $('input').blur(function() {
      $("div#suggest_ulbox ul").remove();
  });

  $("ul#content").mouseleave(function () {
      $("#content").css({"visibility": "hidden"});
  });
}); // jquery

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

</script>
</body>
</html>
