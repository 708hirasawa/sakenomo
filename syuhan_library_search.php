<html lang="ja">
<head>
<link rel="stylesheet" type="text/css" href="css/header.css" />
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<style>

#logo {
    font-family: "メイリオ", "Myriad Pro", Arial, sans-serif;
    font-size: 18pt;
    position:absolute; 
    font-weight: bold;
    left: 4px;
    color: #fff; 
    cursor: pointer;
}

nav ul {
    font-family: "Trebuchet MS", "Myriad Pro", sans-serif;
    font-size: 14px;
    background: #22445B;
    right: 4px;
    top: 2px;
    margin: 0;
    padding: 0;
    list-style: none;
    position: relative;
    float: right;
    border-radius: 3px;    
}

nav li {
    cursor: pointer;
    background: #22445B;
    float: left;          
    color: #999999;
    margin:4px 4px 4px 4px;
    padding: 0px 6px 0px 6px;
    border:	1px solid	#22445B;
}

nav li:hover {
    cursor: pointer;
    background: #282b2f;
    border:	1px solid	#fff;
    float: left;          
    color: #fff;
}

nav li:active {
    border:	1px solid	#30ab52;
    color: #30ab52;
}

nav #login-trigger {
    font-family: "Trebuchet MS", "Myriad Pro", sans-serif;
    font-size: 14px;
    top: 4px;
    text-decoration: none;
    border-radius: 3px 0 0 3px;
    color: #999999;
}

nav #login-trigger:hover {
    color: #fff;
}

nav #username {
    color: #999999;
    border:	1px solid	#282b2f;
}

nav #username:hover {
    color: #fff;
    border:	1px solid	#282b2f;
}

ul #login-content {
    float: none;
    display: none;
    position: absolute;
    padding: 4px 0px 4px 0px;
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    font-size: 12px;
    top: 24px;
    z-index: 999;    
    background: #282b2f; 
    border-radius: 3px 0 3px 3px;
}

#login-content li {
    float: none;
    color: #fff; 
    list-style-type: none;
    padding: 4px 4px 4px 4px;
}

#login-content li:hover {
    background: #404040;
}

#login-content li:active {
    background: #136899;
}

nav {
    background: #22445B;
    width: 100%;
    height: 34px;
    left: 0px;
    position:fixed;.
    right: 0;
    top: 0;
    z-index: 10;
	  box-shadow: 0 3px 3px -1px rgba(0,0,0,.9);
}

.navigate_button {
	background: #e3e3e3;
	border: 1px solid #ccc;
	color: #333;
	font-family: "Trebuchet MS", "Myriad Pro", sans-serif;
	font-size: 12px;
	font-weight: bold;
	padding: 2px 0 2px;
	text-align: center;
	height: 20px;
	width: 100px;
	cursor:pointer;
	margin:2px 2px 2px 2px;
	text-shadow: 0px 1px 0px #fff;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	-moz-box-shadow: 0px 0px 2px #fff inset;
	-webkit-box-shadow: 0px 0px 2px #fff inset;
	box-shadow: 0px 0px 2px #fff inset;
}

.navigate_button:hover {
	background: #d9d9d9;
	-moz-box-shadow: 0px 0px 2px #eaeaea inset;
	-webkit-box-shadow: 0px 0px 2px #eaeaea inset;
	box-shadow: 0px 0px 2px #eaeaea inset;
	color: #222;
}

.update_button {
	background: #e3e3e3;
	border: 1px solid #ccc;
	color: #333;
	font-family: "Trebuchet MS", "Myriad Pro", sans-serif;
	font-size: 12px;
	font-weight: bold;
	padding: 2px 0 2px;
	text-align: center;
	height: 20px;
	width: 100px;
	cursor:pointer;
	float:right;
	margin:2px 2px 2px 2px;
	text-shadow: 0px 1px 0px #fff;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	-moz-box-shadow: 0px 0px 2px #fff inset;
	-webkit-box-shadow: 0px 0px 2px #fff inset;
	box-shadow: 0px 0px 2px #fff inset;
}

.update_button:hover {
	background: #d9d9d9;
	-moz-box-shadow: 0px 0px 2px #eaeaea inset;
	-webkit-box-shadow: 0px 0px 2px #eaeaea inset;
	box-shadow: 0px 0px 2px #eaeaea inset;
	color: #222;
}

.update_button:active {
	background: #136899;
	/*box-shadow: 0 3px 1px #0f608c;*/
}

.delete_button {
	background: #e3e3e3;
	border: 1px solid #ccc;
	color: #333;
	font-family: "Trebuchet MS", "Myriad Pro", sans-serif;
	font-size: 12px;
	font-weight: bold;
	padding: 2px 0 2px;
	text-align: center;
	height: 20px;
	width: 100px;
	cursor:pointer;
	float:right;
	margin:2px 2px 2px 2px;
	text-shadow: 0px 1px 0px #fff;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	-moz-box-shadow: 0px 0px 2px #fff inset;
	-webkit-box-shadow: 0px 0px 2px #fff inset;
	box-shadow: 0px 0px 2px #fff inset;
}

.delete_button:hover {
	background: #d9d9d9;
	-moz-box-shadow: 0px 0px 2px #eaeaea inset;
	-webkit-box-shadow: 0px 0px 2px #eaeaea inset;
	box-shadow: 0px 0px 2px #eaeaea inset;
	color: #222;
}

.delete_button:active {
	background: #136899;
	/*box-shadow: 0 3px 1px #0f608c;*/
}

.navi_wrapper {
    position: relative;
    top: 32px;
}

table, td, th {
    border: 1px solid black;
}

table {
    width: 200%;
    table-layout: fixed;
}

th {
    height: 30px;
}

#page {
    border: 0px solid black;
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

#page td, #page th {
    font-size: 0.8em;
    border: 0px solid #626262;
    padding: 2px 2px 2px 2px;
}

#page th {
    color: #ffffff;
    background-color: #626262;
}

#page tr.alt td {
    color: #000000;
    background-color: #e3e3e3;
}

#customers {
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

#customers td, #customers th {
    font-size: 0.8em;
    border: 0px solid #626262;
    padding: 3px 7px 2px 7px;
}

#customers th {
    color: #ffffff;
    background-color: #626262;
	text-align: left;
}

#customers tr.alt td {
    color: #000000;
    background-color: #e3e3e3;
}

</style>
<title>検索結果</title></head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<body>

<?php
require_once("db_functions.php");

function html_convert($p_string)
{
    $p_string = str_replace("\"","&quot;", $p_string);
    return $p_string;
}

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
        $disp_num = "投稿されていません。";
    }
    else
    {
        $disp_num = $disp_num_from."件目～".$disp_num_to."件目を表示";
    }

    print($disp_num);
}

function disp_link($p_from, $p_to, $p_max, $p_count, $p_link, $p_search = "")
{
    if($p_from != 0)
    {
        $before_num = $p_from - $p_max;
            
        if($before_num < 0)
        {
            $before_num = 0;
        }
            
        $move_link  = "<li><a style=\"text-decoration: none; color: #fff;\" href=\"".$p_link."?in_disp_from=".$before_num ."&in_search=".$p_search."\">前の".$p_max."件</a></li>";
    }

    if($p_to < $p_count)
    {
        $after_num = $p_from + $p_max;

        $move_link  = $move_link."<li><a style=\"text-decoration: none; color: #fff;\" href=\"".$p_link."?in_disp_from=" .$after_num."&in_search=".$p_search."\">次の".$p_max ."件</a></li>";
    }

    print($move_link);
}

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$condition = "";

if(isset($_POST["syuhanten_name"]) && ($_POST["syuhanten_name"] != ""))
{
    $syuhanten_name = sqlite3::escapeString( $_POST["syuhanten_name"]);
    $syuhanten_name = str_replace("%", "\%", $syuhanten_name);
    $condition = "WHERE (syuhanten_name LIKE \"%".$syuhanten_name."%\" OR syuhanten_read LIKE \"%".$syuhanten_name."%\" OR syuhanten_id LIKE \"%".$syuhanten_name."%\" OR syuhanten_address LIKE \"%".$syuhanten_name."%\" OR syuhanten_pref LIKE \"%".$syuhanten_name."%\" OR syuhanten_phone LIKE \"%".$syuhanten_name."%\" OR syuhanten_url LIKE \"%".$syuhanten_name."%\") ";
}

if(isset($_POST["syuhanten_country"]) && ($_POST["syuhanten_country"] != ""))
{
    $syuhanten_country = sqlite3::escapeString($_POST["syuhanten_country"]);
    $syuhanten_country = str_replace("%", "\%", $syuhanten_country);
    
    if($condition == "")
    {
        $condition = "WHERE syuhanten_country LIKE \"%".$syuhanten_country."%\"";
    } 
    else
    {
        $condition .= "AND syuhanten_country LIKE \"%".$syuhanten_country."%\"";
    }
}

if(isset($_POST["syuhanten_region"]) && ($_POST["syuhanten_region"] != ""))
{
    $syuhanten_region = sqlite3::escapeString($_POST["syuhanten_region"]);
    $syuhanten_region = str_replace("%", "\%", $syuhanten_region);
    
    if($condition == "")
    {
        $condition = "WHERE syuhanten_region LIKE \"%".$syuhanten_region."%\"";
    } 
    else
    {
        $condition .= "AND syuhanten_region LIKE \"%".$syuhanten_region."%\"";
    }
}

if(isset($_POST["syuhanten_pref"]) && ($_POST["syuhanten_pref"] != ""))
{
    $syuhanten_pref = sqlite3::escapeString($_POST["syuhanten_pref"]);
    $syuhanten_pref = str_replace("%", "\%", $syuhanten_pref);
    
    if($condition == "")
    {
        $condition = "WHERE syuhanten_pref LIKE \"%".$syuhanten_pref."%\"";
    } 
    else
    {
        $condition .= "AND syuhanten_pref LIKE \"%".$syuhanten_pref."%\"";
    }
}

if(isset($_POST["syuhanten_fax"]) && ($_POST["syuhanten_fax"] != ""))
{
    $syuhanten_fax = sqlite3::escapeString($_POST["syuhanten_fax"]);
    $syuhanten_fax = str_replace("%", "\%", $syuhanten_fax);
    
    if($condition == "")
    {
        $condition = "WHERE syuhanten_fax LIKE \"%".$syuhanten_fax."%\"";
    } 
    else
    {
        $condition .= "AND syuhanten_fax LIKE \"%".$syuhanten_fax."%\"";
    }
}

if(isset($_POST["syuhanten_email"]) && ($_POST["syuhanten_email"] != ""))
{
    $syuhanten_email = sqlite3::escapeString($_POST["syuhanten_email"]);
    $syuhanten_email = str_replace("%", "\%", $syuhanten_email);
    
    if($condition == "")
    {
        $condition = "WHERE syuhanten_email LIKE \"%".$syuhanten_email."%\"";
    } 
    else
    {
        $condition .= "AND syuhanten_email LIKE \"%".$syuhanten_email."%\"";
    }
}

if(isset($_POST["syuhanten_develop"]) && ($_POST["syuhanten_develop"] != ""))
{
    $syuhanten_develop = sqlite3::escapeString($_POST["syuhanten_develop"]);
  
    if($condition == "")
    {
        if($syuhanten_develop == "3")
        {
            $condition = "WHERE syuhanten_develop is NULL ";
        }
        else
        {
            $condition = "WHERE syuhanten_develop = \"".$syuhanten_develop."\"";
        }
    } 
    else
    {
        if($syuhanten_develop == "3")
        {
            $condition .= "AND syuhanten_develop is NULL ";
        }
        else
        {
            $condition .= "AND syuhanten_develop = \"".$syuhanten_develop."\" ";
        }
    }
}

if(isset($_POST["syuhanten_hours"]) && ($_POST["syuhanten_hours"] != ""))
{
    $syuhanten_hours = sqlite3::escapeString($_POST["syuhanten_hours"]);
    $syuhanten_hours = str_replace("%", "\%", $syuhanten_hours);
    
    if($condition == "")
    {
        $condition = "WHERE syuhanten_hours LIKE \"%".$syuhanten_hours."%\"";
    } 
    else
    {
        $condition .= "AND syuhanten_hours LIKE \"%".$syuhanten_hours."%\"";
    }
}

if(isset($_POST["shuhanten_parking"]) && ($_POST["shuhanten_parking"] != ""))
{
    $shuhanten_parking = sqlite3::escapeString($_POST["shuhanten_parking"]);
    $shuhanten_parking = str_replace("%", "\%", $shuhanten_parking);
    
	if($condition == "")
	{
        $condition = "WHERE shuhanten_parking LIKE \"%".$shuhanten_parking."%\"";
    } 
	else
	{
        $condition .= "AND shuhanten_parking LIKE \"%".$shuhanten_parking."%\"";
    }
}

$in_disp_from = $_GET["in_disp_from"];

if(!$in_disp_from = intval($in_disp_from))
{
    $in_disp_from = 0;
}

$in_disp_to = $in_disp_from + 100;

/* count */
$sql = "SELECT COUNT(*) FROM SYUHANTEN_J ".$condition;

$res = executequery($db, $sql);
$row = getnextrow($res); 
$count_result = $row["COUNT(*)"];

/* query */
$sql = "SELECT * FROM SYUHANTEN_J ".$condition." ORDER BY syuhanten_read"." LIMIT ".$in_disp_from.", "."100";
$res = executequery($db, $sql);
?>

<nav>
  <span id="logo">sakenomu</span> 

  <ul>
    <li id="displink">
      <?php
          //disp_link($in_disp_from, $in_disp_to, 100, $count_result, "syuhan_library_search.php", html_convert($condition));
          disp_link($in_disp_from, $in_disp_to, 100, $count_result, "syuhan_library_search.php");
      ?>
    </li>
    <li id="return_to_home">ホームに戻る</li>
		<li id="login">
			<a id="login-trigger" href="#">
				Log out <span>&#x25BC;</span>
			</a>
			<div id="login-content">
				<form>
					<fieldset id="inputs">
            <?php
              print("<input id=\"username\" type=\"email\" name=\"Email\" placeholder=\"Your email address\" required value=" .$_COOKIE['login_cookie'] .">");   
						  print("<input id=\"password\" type=\"password\" name=\"Password\" placeholder=\"Password\" required value=" .$_COOKIE['password_cookie'] .">");   
            ?>
          </fieldset>
					<fieldset id="actions">
						<input type="button" id="logout" value="Log out">
						<label><input type="checkbox" checked="checked"> Keep me signed in</label>
					</fieldset>
				</form>
			</div>                     
		</li>
		<li id="login">
			<?php print("<a style=\"text-decoration: none; color: #fff;\" href=\"user_view.php?username=".$_COOKIE['login_cookie']."\">".$_COOKIE['login_cookie']."</a>"); ?>
		</li>
	</ul>
</nav>
</div>

<?php

print("<div id=\"navi_wrapper\" class=\"navi_wrapper\">");

print("<table id=\"page\" border=\"0\">");
print("<tr>");
//print("sql:".$condition ."<td><FONT size=3>検索結果: ".$count_result."</FONT></td>");
print("<td>検索結果: ".$count_result."</FONT></td>");
printf("<td>");
disp_data_num($in_disp_from, $in_disp_to, $count_result);
printf("</td>");
print("</tr>");
print("</table>");

print("<table id=\"customers\" border=\"0\">");
print("<tr><th width=\"300\">酒販店</th><th width=\"180\">酒販店よみ</th><th width=\"60\">国名</th><th width=\"80\">郵便番号</th><th width=\"80\">地方名</th><th width=\"80\">都道府県</th><th width=\"120\">酒販店ID</th><th width=\"240\">住所</th><th width=\"140\">電話番号</th><th width=\"140\">FAX番号</th><th width=\"190\">ウェブサイト</th><th width=\"80\">Email</th><th width=\"240\">営業時間</th><th width=\"80\">駐車場</th></tr>");

$i = 0;

while($row = getnextrow($res)) 
{
	if($i % 2)
		print("<tr class=\"alt\">");
	else
		print("<tr>");

	if($_COOKIE['usertype_cookie'] == 9)
	{
    print("<td><a href= \"syuhan_view.php?syuhanten_id=".$row["syuhanten_id"]."\">".$row["syuhanten_name"]."</a>");
    //print("<button id=\"" .$row["syuhanten_id"] ."\" class=\"delete_button\" style=\"width:46;height:22\">削除</button>");
    print("<a href= \"syuhan_update_form.php?syuhanten_id=".$row["syuhanten_id"]."\">");
    //print("<button class=\"update_button\" style=\"width:46;height:22\">更新</button>");
    print("</a></td>");
	}
	else
		print("<td><a href= \"syuhan_view.php?syuhanten_id=".$row["syuhanten_id"]."\">".$row["syuhanten_name"]."</a></td>");

  print("<td>".$row["syuhanten_read"]."</td>");
  print("<td>".$row["syuhanten_country"]."</td>");
  print("<td>".$row["syuhanten_postal_code"]."</td>");
  print("<td>".$row["syuhanten_region"]."</td>");
  print("<td>".$row["syuhanten_pref"]."</td>");
  print("<td>".$row["syuhanten_id"]."</td>");
  print("<td>".$row["syuhanten_address"]."</td>");
  print("<td>".$row["syuhanten_phone"]."</td>");
  print("<td>".$row["syuhanten_fax"]."</td>");

 	if($row["syuhanten_url"] == "")
		print("<td>".$row["syuhanten_url"]."</td>");
	else
		print("<td><a href = \"".$row["syuhanten_url"]."\">".$row["syuhanten_url"]."</a></td>");
		
  print("<td>".$row["syuhanten_email"]."</td>");
  print("<td>".$row["syuhanten_hours"]."</td>");
  print("<td>".$row["syuhanten_parking"]."</td>");
	print("</tr>");
	$i++;
}
print("</table>");
sqlite_close($db);
?>
<script>

$(document).ready(function(){
	$('#login-trigger').click(function(){
		$(this).next('#login-content').slideToggle();
		$(this).toggleClass('active');					
		
		if ($(this).hasClass('active')) $(this).find('span').html('&#x25B2;')
			else $(this).find('span').html('&#x25BC;')
		})

	$('#logout').click(function(){
		var c = document.cookie.split("; ");
		
		for(i in c) 
			document.cookie =/^[^=]+/.exec(c[i])[0]+"=;expires=Thu, 01 Jan 1970 00:00:00 GMT";    

		alert("ログアウトしました");
		window.open('http://cgi.sakenomu.com', '_self');
		})

  $("#return_to_home").click(function() {
    window.open('sake_search.php', '_self');
  });
});

$('.delete_button').click(function(){

	if(confirm(this.id + "を削除しますか?") == true) 
	{
		var data = "id="+this.id;

		$.ajax({
			type: "post",
			url: "syuhan_dynamic_delete.php?id=" + this.id,
			data: data,
		}).done(function(xml){
			var str = $(xml).find("str").text();

			if(str == "success")
			{
				alert("削除しました");
				location.reload();
			}

		}).fail(function(data){
			var str = $(xml).find("str").text();
			alert("Failed:" +str);
		});
	} 
});

</script>
</body>
</html>
