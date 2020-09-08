<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<title>ユーザー情報を更新します</title>
</head>
<style>

#customers {
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

#customers td, #customers th {
    font-size: 0.9em;
    border: 1px solid #626262;
    padding: 3px 7px 2px 7px;
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
<script type="text/javascript">

	jQuery(document).ready(function(){
	  $(document).on('click','#button', function(){
		var data = $("#form").serialize(); 

		  $.ajax({
				type: "post",
				url: "user_update.php?username=<?php print($_GET['username']);?>",
				data: data,
		  }).done(function(xml){
			  var str = $(xml).find("str").text();
			  //alert(str);
      
			  if(str == "success")
				  window.open('user_view.php?username=<?php print($_GET['username']);?>', '_self');
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
<p id="sample1">ユーザーの情報を更新します。</p>
<?php
require_once("db_functions.php");
$username = $_GET['username'];
$sql = "SELECT * FROM USERS_J WHERE username = '$username'";

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
	print("<tr>");
	print("<th>項目</th>");
	print("<th>入力データ</th>");
	print("</tr>");

	print("<tr>");
	print("<td>ユーザー名</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"username\" value= \"".$username."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>姓</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"fname\" value= \"".$row["fname"]."\"></td>");
	print("</tr>");
	
	print("<tr>");
	print("<td>苗</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"lname\" value= \"".$row["lname"]."\"></td>");
	print("</tr>");
	
	print("<tr>");
	print("<td>ミドルネーム</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"minit\" value= \"".$row["minit"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>性別</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"sex\" value= \"".$row["sex"]."\"></td>");
	print("</tr>");

	print("<tr>");
	print("<td>生年月日</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"bdate\" value= \"".$row["bdate"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>Email</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"email\" value= \"".$row["email"]."\"></td>");
	print("</tr>");

	print("<tr>");
	print("<td>電話番号</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"phone\" value= \"".$row["phone"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>国名</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"country\" value= \"".$row["country"]."\"></td>");
	print("</tr>");

	print("<tr>");
	print("<td>地方</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"region\" value= \"".$row["region"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>都道府県よみ</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"pref\" value= \"".$row["pref"]."\"></td>");
	print("</tr>");

	print("<tr>");
	print("<td>住所</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"address\" value= \"".$row["address"]."\"></td>");
	print("</tr>");

	print("<tr class=\"alt\">");
	print("<td>住所よみ</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"address_read\" value= \"".$row["address_read"]."\"></td>");
	print("</tr>");

	print("<tr>");
	print("<td>郵便番号</td>");
	print("<td><input size=\"48\" type=\"text\" name=\"postal_code\" value= \"".$row["postal_code"]."\"></td>");
	print("</tr>");
}
?>

</tr>
<tr class="alt">
<td colspan="2" align="center">
<input id="button" type="button" value="更新"></td>
</tr>
</table>
<?php
print("<a href=\"sake_search.php\">検索画面に戻る</a><br />");
?>

</form>
</body>
</html>
