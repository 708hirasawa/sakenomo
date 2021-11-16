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
	top: 22px;
    color:				#ffffff;
	opacity:			1.0;
    background-color:	#626262;
    border:	1px solid	#626262;
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
    top: 20px;
    border:	3px solid	#404040;
    boxShadow:			"5px 5px 10px #444";
}

#customers {
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

#customers td, #customers th {
    font-size: 0.9em;
    border: 1px solid #626262;
    padding: 2px 2px 2px 2px;
}

#customers th {
    color: #ffffff;
    background-color: #626262;
}

#customers tr.alt td {
    color: #000000;
    background-color: #e3e3e3;
}

</style>

<!-- The JavaScript -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<body>

<?php
require_once("db_functions.php");
$sake_id = $_GET['sakeid'];
print("<div id=\"sample1\" style=\"font-weight:bold; background:#404040; color:#fff; padding:5px;\">銘柄を更新します</div>");

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$sql = "SELECT * FROM SAKE_J, SAKAGURA_J WHERE sake_id = '$sake_id' AND sakagura_id = id";
$res = executequery($db, $sql);
$row = getnextrow($res);
?>

<form id="form" name="form" method="post">
<table id="customers">

<?php
if($row)
{
	print("<tr class=\"alt\">");
	print("<td>銘柄</td>");
	print("<td colspan=\"3\"><input size=\"68\" type=\"text\" name=\"sake_name\" value= \"".$row["sake_name"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>銘柄よみ</td>");
	print("<td colspan=\"3\"><input size=\"68\" type=\"text\" name=\"sake_read\" value= \"".$row["sake_read"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>Sake Name</td>");
	print("<td colspan=\"3\"><input size=\"68\" type=\"text\" name=\"sake_english\" value= \"".$row["sake_english"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>銘柄名検索用</td>");
	print("<td colspan=\"3\"><input size=\"68\" type=\"text\" name=\"sake_search\" value= \"".$row["sake_search"]."\"></td>");
	print("</tr>");
	
	print("<tr class=\"alt\">");
	print("<td>酒ランク</td>");
	
	printf("<td colspan=\"3\">");
	printf("<SELECT name=\"sake_rank\">");
	printf("<OPTION VALUE=\"1\">1</OPTION>");
	printf("<OPTION VALUE=\"2\">2</OPTION>");
	printf("<OPTION VALUE=\"3\">3</OPTION>");
	printf("<OPTION VALUE=\"4\">4</OPTION>");
	printf("<OPTION VALUE=\"5\" SELECTED>5</OPTION>");
	printf("<OPTION VALUE=\"6\">6</OPTION>");
	printf("<OPTION VALUE=\"7\">7</OPTION>");
	printf("<OPTION VALUE=\"8\">8</OPTION>");
	printf("<OPTION VALUE=\"9\">9</OPTION>");
	printf("<OPTION VALUE=\"10\">10</OPTION>");
	printf("</SELECT>");
	printf("</td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td colspan=\"4\">酒の説明</td>");
	print("</tr>");

	print("<tr>");
	print("<td colspan=\"4\"><textarea name=\"definition\" rows=7 cols=100>".$row["definition"]."</textarea></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>酒蔵名</td>");
	print("<td>".$row["sakagura_name"]."</td>");
	print("<td>酒蔵よみ</td>");
	print("<td>".$row["sakagura_read"]."</td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>都道府県</td>");
	print("<td>".$row["pref"]."</td>");
	print("<td>都道府県よみ</td>");
	print("<td>".$row["pref_read"]."</td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td colspan=\"4\"><center>特定名称</center></td>");
	print("</tr>");

	print("<tr>");
	
	if($row["special_name"] == "11")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"11\" CHECKED>普通酒</td>");
	else
		print("<td><input type=\"radio\" name=\"special_name\" value=\"11\">普通酒</td>");

	if($row["special_name"] == "21")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"21\" CHECKED>本醸造酒</td>");
	else
		print("<td><input type=\"radio\" name=\"special_name\" value=\"21\">本醸造酒</td>");
	
	if($row["special_name"] == "22")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"22\" CHECKED>特別本醸造酒</td>");
	else
		print("<td><input type=\"radio\" name=\"special_name\" value=\"22\">特別本醸造酒</td>");
	
	if($row["special_name"] == "31")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"31\" CHECKED>純米酒</td>");
	else
		print("<td><input type=\"radio\" name=\"special_name\" value=\"31\">純米酒</td>");

	print("</tr>");
	print("<tr>");

	if($row["special_name"] == "32")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"32\" CHECKED>特別純米酒</td>");
	else
		print("<td><input type=\"radio\" name=\"special_name\" value=\"32\">特別純米酒</td>");

	if($row["special_name"] == "33")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"33\" CHECKED>純米吟醸酒</td>");
	else	
		print("<td><input type=\"radio\" name=\"special_name\" value=\"33\">純米吟醸酒</td>");
	
	if($row["special_name"] == "34")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"34\" CHECKED>純米大吟醸酒</td>");
	else	
		print("<td><input type=\"radio\" name=\"special_name\" value=\"34\">純米大吟醸酒</td>");
	
	if($row["special_name"] == "43")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"43\" CHECKED>吟醸酒</td>");
	else
		print("<td><input type=\"radio\" name=\"special_name\" value=\"43\">吟醸酒</td>");

	print("</tr>");
	print("<tr>");

	if($row["special_name"] == "44")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"44\">大吟醸酒</td>");
	else
		print("<td><input type=\"radio\" name=\"special_name\" value=\"44\">大吟醸酒</td>");

	if($row["special_name"] == "90")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"90\">その他</td>");
	else
		print("<td><input type=\"radio\" name=\"special_name\" value=\"90\">その他</td>");

	if($row["special_name"] == "99")
		print("<td><input type=\"radio\" name=\"special_name\" value=\"99\">不明</td>");
	else
		print("<td><input type=\"radio\" name=\"special_name\" value=\"99\">不明</td>");
	
	print("<td></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td colspan=\"4\"><center>種類</center></td>");
	print("</tr>");

	print("<tr>");

	if($row["sake_category"] == "11")
		print("<td><input type=\"radio\" name=\"sake_category\" value=\"11\" CHECKED>無ろ過原酒</td>");
	else
		print("<td><input type=\"radio\" name=\"sake_category\" value=\"11\">無ろ過原酒</td>");

	if($row["sake_category"] == "21")
		print("<td><input type=\"radio\" name=\"sake_category\" value=\"21\" CHECKED>にごり酒</td>");
	else	
		print("<td><input type=\"radio\" name=\"sake_category\" value=\"21\">にごり酒</td>");
	
	if($row["sake_category"] == "22")
		print("<td><input type=\"radio\" name=\"sake_category\" value=\"22\" CHECKED>あらばしり</td>");
	else	
		print("<td><input type=\"radio\" name=\"sake_category\" value=\"22\">あらばしり</td>");

	if($row["sake_category"] == "31")
		print("<td><input type=\"radio\" name=\"sake_category\" value=\"31\" CHECKED>中取り/中垂/中汲み</td>");
	else
		print("<td><input type=\"radio\" name=\"sake_category\" value=\"31\">中取り/中垂/中汲み</td>");

	print("</tr>");
	print("<tr>");

	if($row["sake_category"] == "32")
		print("<td><input type=\"radio\" name=\"sake_category\" value=\"32\" CHECKED>押切</td>");
	else
		print("<td><input type=\"radio\" name=\"sake_category\" value=\"32\">押切</td>");
	
	print("<td></td><td></td><td></td></tr>");
	print("<tr class=\"alt\">");
	print("<td colspan=\"4\"><center>種類３</center></td>");
	print("</tr>");

	print("<tr>");

	if($row["sake_category3"] == "11")
		print("<td><input type=\"radio\" name=\"sake_category3\" value=\"11\" CHECKED>生酒</td>");
	else
		print("<td><input type=\"radio\" name=\"sake_category3\" value=\"11\">生酒</td>");

	if($row["sake_category3"] == "21")
		print("<td><input type=\"radio\" name=\"sake_category3\" value=\"21\" CHECKED>生詰め</td>");
	else
		print("<td><input type=\"radio\" name=\"sake_category3\" value=\"21\">生詰め</td>");
	
	if($row["sake_category3"] == "22")
		print("<td><input type=\"radio\" name=\"sake_category3\" value=\"22\" CHECKED>生貯蔵</td>");
	else	
		print("<td><input type=\"radio\" name=\"sake_category3\" value=\"22\">生貯蔵</td>");
	
	if($row["sake_category3"] == "31")
		print("<td><input type=\"radio\" name=\"sake_category3\" value=\"31\" CHECKED>火入れ</td>");
	else
		print("<td><input type=\"radio\" name=\"sake_category3\" value=\"31\">火入れ</td>");
	
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>内容量</td>");

	if($row["volume_180"] == "1")
	{
      print("<td><input type=\"checkbox\" id=\"volume_180\" name=\"volume_180\" value = \"1\" CHECKED>180ml ");
		  print("<input id = \"price_180\" size = \"14\" type=\"text\" name=\"price_180\" onkeydown=\"return key_down(event.keyCode)\" value=\"" .$row["price_180"] ."\">円</td>");
	}
  else
	{
      print("<td><input type=\"checkbox\" id=\"volume_180\" name=\"volume_180\" value = \"1\">180ml ");
      print("<input id = \"price_180\" size = \"14\" type=\"text\" name=\"price_180\" onkeydown=\"return key_down(event.keyCode)\" DISABLED value=\"" .$row["price_180"] ."\">円</td>");
  }

	if($row["volume_300"] == "1")
	{
      print("<td><input type=\"checkbox\" id=\"volume_300\" name=\"volume_300\" value = \"1\" CHECKED>300ml ");
      print("<input id = \"price_300\" size = \"14\" type=\"text\" name=\"price_300\" onkeydown=\"return key_down(event.keyCode)\" value=\"" .$row["price_300"] ."\">円</td>");
	}
  else
	{	
    print("<td><input type=\"checkbox\" id=\"volume_300\" name=\"volume_300\" value = \"1\">300 ");
		print("<input id = \"price_300\" size = \"14\" type=\"text\" name=\"price_300\" onkeydown=\"return key_down(event.keyCode)\" DISABLED value=\"" .$row["price_300"] ."\">円</td>");
  }

  if($row["volume_720"] == "1")
	{
      print("<td><input type=\"checkbox\" id=\"volume_720\" name=\"volume_720\" value = \"1\" CHECKED>720ml ");
		  print("<input id = \"price_720\" size = \"14\" type=\"text\" name=\"price_720\" onkeydown=\"return key_down(event.keyCode)\" value=\"" .$row["price_720"] ."\">円</td>");
	}
  else
	{
      print("<td><input type=\"checkbox\" id=\"volume_720\" name=\"volume_720\" value = \"1\">720ml ");
		  print("<input id = \"price_720\" size = \"14\" type=\"text\" name=\"price_720\" onkeydown=\"return key_down(event.keyCode)\" DISABLED value=\"" .$row["price_720"] ."\">円</td>");
  }

	print("</tr><tr class=\"alt\"><td></td>");
  
  if($row["volume_1800"] == "1")
	{
      print("<td><input type=\"checkbox\" id=\"volume_1800\" name=\"volume_1800\" value = \"1\" CHECKED>1,800ml ");
		  print("<input id = \"price_1800\" size = \"14\" type=\"text\" name=\"price_1800\" onkeydown=\"return key_down(event.keyCode)\" value=\"" .$row["price_1800"] ."\">円</td>");
	}
  else
	{	
      print("<td><input type=\"checkbox\" id=\"volume_1800\" name=\"volume_1800\" value = \"1\">1800 ");
		  print("<input id = \"price_1800\" size = \"14\" type=\"text\" name=\"price_1800\" onkeydown=\"return key_down(event.keyCode)\" DISABLED value=\"" .$row["price_18000"] ."\">円</td>");
  }

	if($row["volume_other"] == "1")
	{
      print("<td><input type=\"checkbox\" id=\"volume_other\" name=\"volume_other\" value = \"1\" CHECKED>その他 ");
		  print("<input id = \"price_other\" size = \"14\" type=\"text\" name=\"price_other\" onkeydown=\"return key_down(event.keyCode)\" value=\"" .$row["price_other"] ."\">円</td>");
	}
  else
	{
      print("<td><input type=\"checkbox\" id=\"volume_other\" name=\"volume_other\" value = \"1\">その他 ");
		  print("<input id = \"price_other\" size = \"14\" type=\"text\" name=\"price_other\" onkeydown=\"return key_down(event.keyCode)\" DISABLED value=\"" .$row["price_other"] ."\">円</td>");
  }

	print("<td></td></tr>");

  print("<tr class=\"alt\">");
	print("<td>原材料名</td>");
	print("<td colspan=\"3\"><input size=\"48\" type=\"text\" name=\"ingredients\" value= \"".$row["ingredients"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>精米歩合</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"seimai_rate\" value= \"".$row["seimai_rate"]."\"></td>");

	print("<td>使用米</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"rice_used\" value= \"".$row["rice_used"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>アルコール度数</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"alcohol_level\" onkeydown=\"return key_down(event.keyCode)\" value= \"".$row["alcohol_level"]."\"></td>");

	print("<td>日本酒度</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"jsake_level\"  onkeydown=\"return key_down(event.keyCode)\" value= \"".$row["jsake_level"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>酸度</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"oxidation_level\" onkeydown=\"return key_down(event.keyCode)\" value= \"".$row["oxidation_level"]."\"></td>");

	print("<td>アミノ酸度</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"amino_level\" onkeydown=\"return key_down(event.keyCode)\" value= \"".$row["amino_level"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>使用酵母</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"koubo_used\" value= \"".$row["koubo_used"]."\"></td>");

	print("<td>酒母</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"syubo\" value= \"".$row["syubo"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>粕歩合</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"kasu_level\" value= \"".$row["kasu_level"]."\"></td>");

	print("<td>仕込み水</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"water_used\" value= \"".$row["water_used"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>醸造年度（販売の際表示）</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"year_made\" onkeydown=\"return key_down(event.keyCode)\" value= \"".$row["year_made"]."\"></td>");
	print("<td>酒タイプ</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"sake_type\" value= \"".$row["sake_type"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>味わい</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"taste\" value= \"".$row["taste"]."\"></td>");
	print("<td>香り</td>");
	print("<td><input size=\"24\" type=\"text\" name=\"smell\" value= \"".$row["smell"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>特徴</td>");
	print("<td colspan=\"3\"><input size=\"68\" type=\"text\" name=\"feature\" value= \"".$row["feature"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>オススメ飲み方</td>");
	print("<td colspan=\"3\"><input size=\"68\" type=\"text\" name=\"recommended_drink\" value= \"".$row["recommended_drink"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>相性のよい料理例</td>");
	print("<td colspan=\"3\"><input size=\"68\" type=\"text\" name=\"recommended_cook\" value= \"".$row["recommended_cook"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>主な受賞など</td>");
	print("<td colspan=\"3\"><input size=\"68\" type=\"text\" name=\"sake_award_history\" value= \"".$row["sake_award_history"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td colspan=\"4\">メモ</td>");
	print("</tr>");

	print("<tr>");
	print("<td colspan=\"4\"><textarea name=\"sake_memo\" rows=7 cols=100>".$row["sake_memo"]."</textarea></td>");
	print("</tr>");
}
else
{
	print("更新できませんでした。");
}

?>
</tr>

<tr class="alt">
<td colspan="4" align="center">

<input id="button" type="button" class="add_button" value="更新">
<a href="sake_view.php?sake_id=<?php print($_GET['sakeid']);?>">
<input id="button_cancel" type="button" class="add_button" onclick="goBack()" value="キャンセル"></a>
<a href="sake_search.php"><input id="button_cancel" type="button" class="add_button" value="検索画面に戻る"></a>

</td>
</tr>
</form>
</table>
<script type="text/javascript">

	jQuery(document).ready(function(){
	  $(document).on('click','#button', function(){
		  var data = $("#form").serialize(); 
		 
		  $.ajax({
				type: "post",
				url: "cgi/sake_update.php?id=<?php print($_GET['sakeid']);?>",
				data: data,
		  }).done(function(xml){
				var str = $(xml).find("str").text();
				//alert(str);

				if(str == "success")
				  window.open('./sake/sake_view.php?sake_id=<?php print($_GET['sakeid']);?>', '_self');
				else
				  $("#sample1").text(str);
		  }).fail(function(data){
			  //alert("This is Error");

			  $("#sample1").text('This is Error');
		  });
	  });
	});

	var input_volume_180	= document.getElementById("volume_180");
	var input_volume_300	= document.getElementById("volume_300");
	var input_volume_720	= document.getElementById("volume_720");
	var input_volume_1800	= document.getElementById("volume_1800");
	var input_volume_other  = document.getElementById("volume_other");

	var input_price_180	= document.getElementById("price_180");
	var input_price_300	= document.getElementById("price_300");
  var input_price_720		= document.getElementById("price_720");
	var input_price_1800	= document.getElementById("price_1800");
	var input_price_other	= document.getElementById("price_other");

	input_volume_180.onclick = function () {

		if(input_volume_180.checked == true)
		{
			input_price_180.disabled = false; 
		}
		else
		{
			input_price_180.disabled = true; 
		}

		return true;
	}

	input_volume_300.onclick = function () {

    if(input_volume_300.checked == true)
		{
			input_price_300.disabled = false; 
		}
		else
		{
			input_price_300.disabled = true; 
		}

		return true;
  }
 
 input_volume_720.onclick = function () {

		if(input_volume_720.checked == true)
		{
			input_price_720.disabled = false; 
		}
		else
		{
			input_price_720.disabled = true; 
		}

		return true;
	}

	input_volume_1800.onclick = function () {
		if(input_volume_1800.checked == true)
		{
			input_price_1800.disabled = false; 
		}
		else
		{
			input_price_1800.disabled = true; 
		}

		return true;
	}

	input_volume_other.onclick = function () {
		if(input_volume_other.checked == true)
		{
			input_price_other.disabled = false; 
		}
		else
		{
			input_price_other.disabled = true; 
		}

		return true;
	}

	function goBack() {
		window.history.back();
	}

	function key_down(get_code){
		 if(get_code >= 48 && get_code <= 57  //数字キー
			|| get_code >= 96 && get_code <= 105 //テンキーの数字
			|| get_code == 189  // '-'		
			|| get_code == 8 //bs
			|| get_code == 37 // left
			|| get_code == 39 // right
			|| get_code == 190 // .
		 )
		   return true;
		 else
		   return false;
	  }

</script>
</body>
</html>
