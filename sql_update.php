<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1, user-scalable=0' name='viewport'/>  
</head>

<script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.min.js"></script>

<p>文字列変換</p>




<?php
require_once("db_functions.php");

if(!$db = opendatabase("sake.db"))
{
   print("<div>データベース接続エラー </div>");
}
else
{
	$stmt = "UPDATE SAKE_J SET write_date = " .time() ." where	write_date is NULL";

	$ret = executequery($db, $stmt);
		 
	if(!$ret)
		print("<div>更新できませんでした</div>");

	print("終了しました:".$stmt);
}
?>







</body>
</html>
