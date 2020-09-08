<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<title>酒蔵検索</title>
</head>
<style>
#customers {
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;
}

#customers td, #customers th {
    font-size: 1em;
    border: 1px solid #782a90;
    padding: 2px 7px 2px 7px;
}

#customers th {
    font-size: 1em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #782a90;
    color: #ffffff;
}

#customers tr.alt td {
    color: #000000;
    background-color: #dec6e6;
}

</style>
<script language="javascript" src="sakagura.js">
</script>
<body>

<center><font size="+1" face="メイリオ">管理人用画面</font></center>

<table BORDER=0 BGCOLOR="#FFFFFF" CELLSPACING=0 CELLPADDING=4 WIDTH=324>
   <tr>
      <td width=76 bgcolor="#782a90">
         <center><font size="+1" face="メイリオ" color="#FFFFFF">酒検索</font></center>
      </td>
      <td width=76 bgcolor="#217346" onclick=sakagura_write()>
         <center><font size="+1" face="メイリオ" color="#FFFFFF">酒蔵検索</font></center>
      </td>
   </tr>
</table>

<center>

<form action="sake_library_search.php" method="post">

<table id="customers">
<tr class="alt">
<td>銘柄名</td>
<td><input size=42 type="text" name="sake_name"></td>
<td>銘柄よみ</td>
<td><input size=42 type="text" name="sake_read"></td>
</tr>
<tr>
<td>酒ＩＤ</td>
<td><input size=42 type="text" name="sake_id"></td>
<td>酒蔵名</td>
<td><input size=42 type="text" name="sakagura_name"></td>
</tr>
<tr class="alt">
<td>酒蔵名よみ</td>
<td><input size=42 type="text" name="sakagura_read"></td>
<td>都道府県</td>
<td>
<SELECT name="pref">
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
</SELECT>
</td>
</tr>

<tr>
<td colspan="4" align="center">
<input size=42 type="submit" name="submit" value="検索"></td>
</tr>
</table>
</CENTER>
<br /><a href="sake_add_form.php">酒を追加する</a><br />
</body>
</html>
