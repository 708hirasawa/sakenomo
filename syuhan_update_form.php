<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<title>酒蔵を更新します</title>
</head>
<style>

#sample1 {
    position: relative;
    backgroundColor:	"#000";
    color:				#ffffff;
    opacity:			1.0;
    background-color:	#626262;
    border:	5px solid	#626262;
    border-radius: 10px 10px 0 0;
    boxShadow:			"5px 5px 10px #444";
}

.add_button {
    border: none;
    background: #a40f0c;
    font-family: "メイリオ", "Myriad Pro", Arial, sans-serif;
    height: 34px;
    width: 120px;
    color: #ffffff;
    text-align: center;
    border-radius: 5px;
    margin:0px 4px 0px 0px;

    /*box-shadow: 0px 3px 1px #2075aa;*/
    -webkit-transition: all 0.15s linear;
    -moz-transition: all 0.15s linear;
    transition: all 0.15s linear;
}

.add_button:hover {
    background: #dec6e6;
    /*box-shadow: 0 3px 1px #237bb2;*/
}

.add_button:active {
    background: #136899;
    /*box-shadow: 0 3px 1px #0f608c;*/
}

#form {
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    position: relative;
    top: 0px;
    border:	1px solid	#626262;
    boxShadow:			"5px 5px 10px #444";
}

nav ul {
    margin: 0;
    padding: 0;
    list-style: none;
    position: relative;
    float: right;
    background: #eee;
    border-bottom: 1px solid #fff;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;    
}

nav li {
	float: left;          
}

nav #login {
	border-right: 1px solid #ddd;
	-moz-box-shadow: 1px 0 0 #fff;
	-webkit-box-shadow: 1px 0 0 #fff;
	box-shadow: 1px 0 0 #fff;  
}

nav #login-trigger,
nav #signup a {
	display: inline-block;
	*display: inline;
	*zoom: 1;
	height: 25px;
	line-height: 25px;
	font-weight: bold;
	padding: 0 8px;
	text-decoration: none;
	color: #444;
	text-shadow: 0 1px 0 #fff; 
}

nav #signup a {
	-moz-border-radius: 0 3px 3px 0;
	-webkit-border-radius: 0 3px 3px 0;
	border-radius: 0 3px 3px 0;
}

nav #login-trigger {
	-moz-border-radius: 3px 0 0 3px;
	-webkit-border-radius: 3px 0 0 3px;
	border-radius: 3px 0 0 3px;
}

nav #login-trigger:hover,
nav #login .active,
nav #signup a:hover {
	background: #fff;
}

nav #login-content {
	display: none;
	position: absolute;
	top: 24px;
	right: 0;
	z-index: 999;    
	background: #fff;
	background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#eee));
	background-image: -webkit-linear-gradient(top, #fff, #eee);
	background-image: -moz-linear-gradient(top, #fff, #eee);
	background-image: -ms-linear-gradient(top, #fff, #eee);
	background-image: -o-linear-gradient(top, #fff, #eee);
	background-image: linear-gradient(top, #fff, #eee);  
	padding: 15px;
	-moz-box-shadow: 0 2px 2px -1px rgba(0,0,0,.9);
	-webkit-box-shadow: 0 2px 2px -1px rgba(0,0,0,.9);
	box-shadow: 0 2px 2px -1px rgba(0,0,0,.9);
	-moz-border-radius: 3px 0 3px 3px;
	-webkit-border-radius: 3px 0 3px 3px;
	border-radius: 3px 0 3px 3px;
}

nav li #login-content {
	right: 0;
	width: 250px;  
}

#customers {
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    width: 100%;
	top: 40px;
    border-collapse: collapse;
}

#customers td, #customers th {
    font-size: 0.9em;
    border: 1px solid #626262;
    padding: 3px 7px 2px 7px;
}

#customers th {
    font-size: 0.9em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #626262;
    color: #ffffff;
}

#customers tr.alt td {
    color: #000000;
    background-color: #e3e3e3;
}

</style>

<!-- The JavaScript -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">

	jQuery(document).ready(function(){
	  $(document).on('click','#button', function(){
		var data = $("#form").serialize(); 

		  $.ajax({
				type: "post",
				url: "cgi/syuhan_update.php?syuhanten_id=<?php print($_GET['syuhanten_id']);?>",
				data: data,
		  }).done(function(xml){
			  var str = $(xml).find("str").text();
			  //alert(str);
      
			  if(str == "success")
				  window.open('./syuhan_view.php?syuhanten_id=<?php print($_GET['syuhanten_id']);?>', '_self');
			  else
				  $("#sample1").text(str);
		  }).fail(function(data){
			  alert("This is Error");

			  $("#sample1").text('This is Error');
		  });
	  });
	});

</script>

<body>
<nav>
	<ul>
		<li id="home">
			<a href="sake_search.php">ホームに戻る</a>
		</li>

		<li id="login">
			<a id="login-trigger" href="#">
				Log out <span>&#x25BC;</span>
			</a>
			<div id="login-content">
				<form>
					<fieldset id="inputs">
						<input id="username" type="email" name="Email" placeholder="Your email address" required>   
						<input id="password" type="password" name="Password" placeholder="Password" required>
					</fieldset>
					<fieldset id="actions">
						<input type="submit" id="submit" value="Log out">
						<label><input type="checkbox" checked="checked"> Keep me signed in</label>
					</fieldset>
				</form>
			</div>                     
		</li>

		<li id="mahalopeace">
			<?php print("<a href=\"user_view.php?username=".$_COOKIE['login_cookie']."\">".$_COOKIE['login_cookie']."</a>"); ?>
		</li>
	</ul>
</nav>

<div id="sample1"　style="font-weight:bold; background:#404040; color:#fff; padding:5px;">酒販店を更新します</div>
<?php
require_once("db_functions.php");
$syuhanten_id = $_GET['syuhanten_id'];
$sql = "SELECT * FROM SYUHANTEN_J WHERE syuhanten_id = '$syuhanten_id'";

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$res = executequery($db, $sql);
$count_result = sqlite_num_rows($res);
?>

<form id="form" name="form" method="post">
<table id="customers">

<?php
$row = getnextrow($res);

if($row)
{
	print("<tr class=\"alt\">");
	print("<td>酒販店名</td>");
	print("<td width=\"40%\"><input size=\"48\" type=\"text\" name=\"syuhanten_name\" value= \"".$row["syuhanten_name"]."\"></td>");
	print("<td>酒販店名よみ</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_read\" value= \"".$row["syuhanten_read"]."\"></td>");
	print("</tr>");

	print("<tr>");
	print("<td>酒販店名検索用</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"syuhanten_search\" value= \"".$row["syuhanten_search"]."\"></td>");
	print("<td>酒販店名よみ検索・ソート用</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"syuhanten_sort\" value= \"".$row["syuhanten_sort"]."\"></td>");
	print("</tr>");

	print("<tr>");
	print("<td>酒販店</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten\" value= \"".$row["syuhanten"]."\"></td>");
	print("<td>酒販店ID</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"syuhanten_id\" value= \"".$row["syuhanten_id"]."\"></td>");
	print("</tr>");
	
	print("<tr>");
	print("<td>酒蔵ランク</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_rank\" value= \"".$row["syuhanten_rank"]."\"></td>");
	print("<td>酒蔵タイプ</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_type\" value= \"".$row["syuhanten_type"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>国名</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_country\" value= \"".$row["syuhanten_country"]."\"></td>");

	print("<td>地方名</td>");
	print("<td><SELECT id=\"syuhanten_region\" name=\"syuhanten_region\">");

	if($row["syuhanten_region"] == "北海道地方")
		print("<OPTION VALUE=\"北海道地方\" SELECTED>北海道地方</OPTION>");
	else
		print("<OPTION VALUE=\"北海道地方\">北海道地方</OPTION>");

	if($row["syuhanten_region"] == "東北地方")
		print("<OPTION VALUE=\"東北地方\" SELECTED>東北地方</OPTION>");
	else	
		print("<OPTION VALUE=\"東北地方\">東北地方</OPTION>");

	if($row["syuhanten_region"] == "関東地方")
		print("<OPTION VALUE=\"関東地方\" SELECTED>関東地方</OPTION>");
	else
		print("<OPTION VALUE=\"関東地方\">関東地方</OPTION>");

	if($row["syuhanten_region"] == "中部地方")
		print("<OPTION VALUE=\"中部地方\" SELECTED>中部地方</OPTION>");
	else
		print("<OPTION VALUE=\"中部地方\">中部地方</OPTION>");

	if($row["syuhanten_region"] == "近畿地方")
		print("<OPTION VALUE=\"近畿地方\" SELECTED>近畿地方</OPTION>");
	else
		print("<OPTION VALUE=\"近畿地方\">近畿地方</OPTION>");

	if($row["syuhanten_region"] == "中国地方")
		print("<OPTION VALUE=\"中国地方\" SELECTED>中国地方</OPTION>");
	else
		print("<OPTION VALUE=\"中国地方\">中国地方</OPTION>");

	if($row["region_name"] == "九州地方")
		print("<OPTION VALUE=\"九州地方\" SELECTED>九州地方</OPTION>");
	else
		print("<OPTION VALUE=\"九州地方\">九州地方</OPTION>");

	print("</SELECT></td></tr>");

	print("<tr><td>都道府県</td><td>");
	print("<SELECT id=\"syuhanten_pref\" name=\"syuhanten_pref\">");

	if($row["syuhanten_pref"] == "北海道")
		print("<OPTION VALUE=\"北海道\" SELECTED>北海道</OPTION>");
	else	
		print("<OPTION VALUE=\"北海道\">北海道</OPTION>");
	
	if($row["syuhanten_pref"] == "青森県")
		print("<OPTION VALUE=\"青森県\" SELECTED>青森県</OPTION>");
	else
		print("<OPTION VALUE=\"青森県\">青森県</OPTION>");
	
	if($row["syuhanten_pref"] == "岩手県")
		print("<OPTION VALUE=\"岩手県\" SELECTED>岩手県</OPTION>");
	else
		print("<OPTION VALUE=\"岩手県\">岩手県</OPTION>");
	
	if($row["syuhanten_pref"] == "宮城県")
		print("<OPTION VALUE=\"宮城県\" SELECTED>宮城県</OPTION>");
	else	
		print("<OPTION VALUE=\"宮城県\">宮城県</OPTION>");

	if($row["syuhanten_pref"] == "秋田県")
		print("<OPTION VALUE=\"秋田県\" SELECTED>秋田県</OPTION>");
	else
		print("<OPTION VALUE=\"秋田県\">秋田県</OPTION>");
	
	if($row["syuhanten_pref"] == "山形県")
		print("<OPTION VALUE=\"山形県\" SELECTED>山形県</OPTION>");
	else		
		print("<OPTION VALUE=\"山形県\">山形県</OPTION>");
	
	if($row["syuhanten_pref"] == "福島県")
		print("<OPTION VALUE=\"福島県\" SELECTED>福島県</OPTION>");
	else	
		print("<OPTION VALUE=\"福島県\">福島県</OPTION>");
	
	if($row["syuhanten_pref"] == "茨城県")
		print("<OPTION VALUE=\"茨城県\" SELECTED>茨城県</OPTION>");
	else	
		print("<OPTION VALUE=\"茨城県\">茨城県</OPTION>");
	
	if($row["syuhanten_pref"] == "栃木県")
		print("<OPTION VALUE=\"栃木県\" SELECTED>栃木県</OPTION>");
	else
		print("<OPTION VALUE=\"栃木県\">栃木県</OPTION>");
	
	if($row["syuhanten_pref"] == "群馬県")
		print("<OPTION VALUE=\"群馬県\" SELECTED>群馬県</OPTION>");
	else
		print("<OPTION VALUE=\"群馬県\">群馬県</OPTION>");
	
	if($row["syuhanten_pref"] == "埼玉県")
		print("<OPTION VALUE=\"埼玉県\" SELECTED>埼玉県</OPTION>");
	else
		print("<OPTION VALUE=\"埼玉県\">埼玉県</OPTION>");
	
	if($row["syuhanten_pref"] == "千葉県")
		print("<OPTION VALUE=\"千葉県\" SELECTED>千葉県</OPTION>");
	else
		print("<OPTION VALUE=\"千葉県\">千葉県</OPTION>");
	
	if($row["syuhanten_pref"] == "東京都")
		print("<OPTION VALUE=\"東京都\" SELECTED SELECTED>東京都</OPTION>");
	else
		print("<OPTION VALUE=\"東京都\">東京都</OPTION>");
	
	if($row["syuhanten_pref"] == "神奈川県")
		print("<OPTION VALUE=\"神奈川県\" SELECTED>神奈川県</OPTION>");
	else
		print("<OPTION VALUE=\"神奈川県\">神奈川県</OPTION>");
	
	if($row["syuhanten_pref"] == "新潟県")
		print("<OPTION VALUE=\"新潟県\" SELECTED>新潟県</OPTION>");
	else	
		print("<OPTION VALUE=\"新潟県\">新潟県</OPTION>");
	
	if($row["syuhanten_pref"] == "富山県")
		print("<OPTION VALUE=\"富山県\" SELECTED>富山県</OPTION>");
	else	
		print("<OPTION VALUE=\"富山県\">富山県</OPTION>");
	
	if($row["syuhanten_pref"] == "石川県")
		print("<OPTION VALUE=\"石川県\" SELECTED>石川県</OPTION>");
	else	
		print("<OPTION VALUE=\"石川県\">石川県</OPTION>");
	
	if($row["syuhanten_pref"] == "福井県")
		print("<OPTION VALUE=\"福井県\" SELECTED>福井県</OPTION>");
	else
		print("<OPTION VALUE=\"福井県\">福井県</OPTION>");
	
	if($row["syuhanten_pref"] == "山梨県")
		print("<OPTION VALUE=\"山梨県\" SELECTED>山梨県</OPTION>");
	else
		print("<OPTION VALUE=\"山梨県\">山梨県</OPTION>");
	
	if($row["syuhanten_pref"] == "長野県")
		print("<OPTION VALUE=\"長野県\" SELECTED>長野県</OPTION>");
	else	
		print("<OPTION VALUE=\"長野県\">長野県</OPTION>");
	
	if($row["syuhanten_pref"] == "岐阜県")
		print("<OPTION VALUE=\"岐阜県\" SELECTED>岐阜県</OPTION>");
	else	
		print("<OPTION VALUE=\"岐阜県\">岐阜県</OPTION>");
	
	if($row["syuhanten_pref"] == "静岡県")
		print("<OPTION VALUE=\"静岡県\" SELECTED>静岡県</OPTION>");
	else
		print("<OPTION VALUE=\"静岡県\">静岡県</OPTION>");

	if($row["syuhanten_pref"] == "愛知県")
		print("<OPTION VALUE=\"愛知県\" SELECTED>愛知県</OPTION>");
	else
		print("<OPTION VALUE=\"愛知県\">愛知県</OPTION>");

	if($row["syuhanten_pref"] == "三重県")
		print("<OPTION VALUE=\"三重県\" SELECTED>三重県</OPTION>");
	else
		print("<OPTION VALUE=\"三重県\">三重県</OPTION>");

	if($row["syuhanten_pref"] == "滋賀県")
		print("<OPTION VALUE=\"滋賀県\" SELECTED>滋賀県</OPTION>");
	else
		print("<OPTION VALUE=\"滋賀県\">滋賀県</OPTION>");
		
	if($row["syuhanten_pref"] == "京都府")
		print("<OPTION VALUE=\"京都府\" SELECTED>京都府</OPTION>");
	else
		print("<OPTION VALUE=\"京都府\">京都府</OPTION>");

	if($row["syuhanten_pref"] == "大阪府")
		print("<OPTION VALUE=\"大阪府\" SELECTED>大阪府</OPTION>");
	else
		print("<OPTION VALUE=\"大阪府\">大阪府</OPTION>");
	
	if($row["syuhanten_pref"] == "兵庫県")
		print("<OPTION VALUE=\"兵庫県\" SELECTED>兵庫県</OPTION>");
	else
		print("<OPTION VALUE=\"兵庫県\">兵庫県</OPTION>");
	
	if($row["syuhanten_pref"] == "奈良県")
		print("<OPTION VALUE=\"奈良県\" SELECTED>奈良県</OPTION>");
	else
		print("<OPTION VALUE=\"奈良県\">奈良県</OPTION>");
	
	if($row["syuhanten_pref"] == "和歌山県")
		print("<OPTION VALUE=\"和歌山県\" SELECTED>和歌山県</OPTION>");
	else
		print("<OPTION VALUE=\"和歌山県\">和歌山県</OPTION>");
	
	if($row["syuhanten_pref"] == "鳥取県")
		print("<OPTION VALUE=\"鳥取県\" SELECTED>鳥取県</OPTION>");
	else
		print("<OPTION VALUE=\"鳥取県\">鳥取県</OPTION>");
	
	if($row["syuhanten_pref"] == "島根県")
		print("<OPTION VALUE=\"島根県\" SELECTED>島根県</OPTION>");
	else
		print("<OPTION VALUE=\"島根県\">島根県</OPTION>");
	
	if($row["syuhanten_pref"] == "岡山県")
		print("<OPTION VALUE=\"岡山県\" SELECTED>岡山県</OPTION>");
	else
		print("<OPTION VALUE=\"岡山県\">岡山県</OPTION>");
	
	if($row["syuhanten_pref"] == "広島県")
		print("<OPTION VALUE=\"広島県\" SELECTED>広島県</OPTION>");
	else
		print("<OPTION VALUE=\"広島県\">広島県</OPTION>");
	
	if($row["syuhanten_pref"] == "山口県")
		print("<OPTION VALUE=\"山口県\" SELECTED>山口県</OPTION>");
	else
		print("<OPTION VALUE=\"山口県\">山口県</OPTION>");
	
	if($row["syuhanten_pref"] == "徳島県")
		print("<OPTION VALUE=\"徳島県\" SELECTED>徳島県</OPTION>");
	else
		print("<OPTION VALUE=\"徳島県\">徳島県</OPTION>");
	
	if($row["syuhanten_pref"] == "香川県")
		print("<OPTION VALUE=\"香川県\" SELECTED>香川県</OPTION>");
	else
		print("<OPTION VALUE=\"香川県\">香川県</OPTION>");

	if($row["syuhanten_pref"] == "愛媛県")
		print("<OPTION VALUE=\"愛媛県\" SELECTED>愛媛県</OPTION>");
	else
		print("<OPTION VALUE=\"愛媛県\">愛媛県</OPTION>");
	
	if($row["syuhanten_pref"] == "高知県")
		print("<OPTION VALUE=\"高知県\" SELECTED>高知県</OPTION>");
	else
		print("<OPTION VALUE=\"高知県\">高知県</OPTION>");

	if($row["syuhanten_pref"] == "福岡県")
		print("<OPTION VALUE=\"福岡県\" SELECTED>福岡県</OPTION>");
	else
		print("<OPTION VALUE=\"福岡県\">福岡県</OPTION>");
	
	if($row["syuhanten_pref"] == "佐賀県")
		print("<OPTION VALUE=\"佐賀県\" SELECTED>佐賀県</OPTION>");
	else
		print("<OPTION VALUE=\"佐賀県\">佐賀県</OPTION>");
	
	if($row["syuhanten_pref"] == "長崎県")
		print("<OPTION VALUE=\"長崎県\" SELECTED>長崎県</OPTION>");
	else
		print("<OPTION VALUE=\"長崎県\">長崎県</OPTION>");
	
	if($row["syuhanten_pref"] == "熊本県")
		print("<OPTION VALUE=\"熊本県\" SELECTED>熊本県</OPTION>");
	else
		print("<OPTION VALUE=\"熊本県\">熊本県</OPTION>");

	if($row["syuhanten_pref"] == "大分県")
		print("<OPTION VALUE=\"大分県\" SELECTED>大分県</OPTION>");
	else
		print("<OPTION VALUE=\"大分県\">大分県</OPTION>");

	if($row["syuhanten_pref"] == "宮城県")
		print("<OPTION VALUE=\"宮城県\" SELECTED>宮城県</OPTION>");
	else
		print("<OPTION VALUE=\"宮城県\">宮城県</OPTION>");

	if($row["syuhanten_pref"] == "鹿児島県")
		print("<OPTION VALUE=\"鹿児島県\" SELECTED>鹿児島県</OPTION>");
	else
		print("<OPTION VALUE=\"鹿児島県\">鹿児島県</OPTION>");

	if($row["syuhanten_pref"] == "沖縄県")
		print("<OPTION VALUE=\"沖縄県\" SELECTED>沖縄県</OPTION>");
	else
		print("<OPTION VALUE=\"沖縄県\">沖縄県</OPTION>");

	print("</SELECT>");
	print("</td>");

	print("<td>都道府県よみ</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_pref_read\" value= \"".$row["syuhanten_pref_read"]."\"></td>");
	print("</tr>");


	print("<tr>");
	print("<td>郵便番号</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_postal_code\" value= \"".$row["syuhanten_postal_code"]."\"></td>");
	print("<td>住所</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_address\" value= \"".$row["syuhanten_address"]."\"></td>");
	print("</tr>");

	print("<tr>");
	print("<td>電話番号</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_phone\" value= \"".$row["syuhanten_phone"]."\"></td>");
	print("<td>FAX番号</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_fax\" value= \"".$row["syuhanten_fax"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>ウェブサイト</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_url\" value= \"".$row["syuhanten_url"]."\"></td>");
	print("<td>Email</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_email\" value= \"".$row["syuhanten_email"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td colspan=\"4\">酒販店の紹介</td>");
	print("</tr>");
	print("<tr><td colspan=\"4\"><textarea name=\"syuhanten_intro\" rows=8 cols=100>".$row["syuhanten_intro"]."</textarea></td></tr>");

	print("<tr class=\"alt\">");
	print("<td colspan=\"4\">メモ</td></tr>");
	print("<tr><td colspan=\"4\"><textarea name=\"syuhanten_memo\" rows=8 cols=100>".$row["syuhanten_memo"]."</textarea></td>");
	print("</tr>");

	print("<tr>");
	print("<td>営業時間</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_hours\" value= \"".$row["syuhanten_hours"]."\"></td>");
	print("<td>定休日</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_closed\" value= \"".$row["syuhanten_closed"]."\"></td>");
	print("</tr>");

	print("<tr>");
	print("<td>駐車場</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_parking\" value= \"".$row["syuhanten_parking"]."\"></td>");
	print("<td>取扱銘柄</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_sake\" value= \"".$row["syuhanten_sake"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>データソース</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_datasource\" value= \"".$row["syuhanten_datasource"]."\"></td>");
	print("<td>Last Contacted</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"syuhanten_lastcontacted\" value= \"".$row["syuhanten_lastcontacted"]."\"></td>");
	print("</tr>");

	print("</tr>");
	print("<tr class=\"alt\">");
	print("<td colspan=\"4\" align=\"center\">");
	print("<input id=\"button\" type=\"button\" class=\"add_button\" style=\"width:60;height:24\" value=\"更新\">");
	print("<a href=\"sake_search.php\"><input id=\"button_cancel\" type=\"button\" class=\"add_button\" style=\"width:120; height:24\" value=\"検索画面に戻る\"></a>");
	print("</tr>");
}
?>

</table>
</form>
</body>
</html>
