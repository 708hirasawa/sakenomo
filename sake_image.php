<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<style>

.navigate_button {
    background: #e3e3e3;
    border: 1px solid #ccc;
    color: #333;
    font-family: "Trebuchet MS", "Myriad Pro", sans-serif;
    font-size: 12px;
    font-weight: bold;
    padding: 2px 0 2px;
    text-align: center;
    height: 24px;
    width: 100px;
    cursor:pointer;
    float:right;
    //margin:2px 8px 2px 2px;
    
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

.navigate_button:active {
    background: #136899;
    /*box-shadow: 0 3px 1px #0f608c;*/
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

table, td, th {
    border: 1px solid black;
}

table {
    width: 100%;
    table-layout: fixed;
}

th {
    height: 30px;
}

#page {
    border: 0px solid black;
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
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

    //border: 1px solid #e3e3e3;
    margin: 4px 2px 4px 2px;
    padding: 2px 7px 2px 7px;
    box-shadow: 1px 1px 1px -1px rgba(0,0,0,.9);
}

#page tr td {
    color: #000000;
    background-color: #e3e3e3;
    margin: 4px 2px 4px 2px;
    padding: 2px 7px 2px 7px;
    box-shadow: 1px 1px 1px -1px rgba(0,0,0,.9);
}

nav ul {
    margin: 0;
    padding: 0;
    list-style: none;
    position: relative;
    float: right;
    background: #ddd;
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
    background-image: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#ddd));
    background-image: -webkit-linear-gradient(top, #fff, #ddd);
    background-image: -moz-linear-gradient(top, #fff, #ddd);
    background-image: -ms-linear-gradient(top, #fff, #ddd);
    background-image: -o-linear-gradient(top, #fff, #ddd);
    background-image: linear-gradient(top, #fff, #ddd);  
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

nav {
    background: #ddd;
    width: 100%;
    height: 32px;
    left: -8px;
    position:relative;
    //z-index: 10;
    right: 0;
    top: -10px;
	  box-shadow: 0 3px 3px -1px rgba(0,0,0,.9);
}

.form_wrapper {
    position: relative;
    width: 80%;
    top: 24px;
}

div.threads {
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    font-size: 0.9em;
    position: static;
    border: 0px solid #626262;
    background-color: #ffffff;
    height: 75%;
    width: 75%;
}

div.static {
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    font-size: 0.9em;
    position: static;
    border: 1px solid #626262;
    background-color: #e8e8e8;
    border-radius: 15px;
    margin:2px 8px 2px 2px;
    text-align:left;
    padding: 4px 2px 2px 24px;
}

.preview {
    width: 30%;
    height: auto;
    background: #444;
    margin: 0 auto;
}

.full {
    width: 70%;
    height: auto;
    background: #444;
    margin: 0 auto;
   // z-index: 40;
}

</style>
<title>写真の表示</title></head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<body>

<nav>
	<ul>
		<li id="home">
			<a href="sake_view.php?sake_id=<?php print($_GET['sake_id']);?>"><button class="navigate_button" id="return_to_home" style="width:100px;">前に戻る</button></a>
		</li>
		<li id="upload">
      <button id="addimage" class="navigate_button">写真を追加する</button>

    </li>
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

		<li id="username">
			<?php print("<a href=\"user_view.php?username=".$_COOKIE['login_cookie']."\">".$_COOKIE['login_cookie']."</a>"); ?>
		</li>
	</ul>
</nav>

<center>
<div id="form_wrapper" class="form_wrapper">
  
<?php

$id = $_GET['sake_id'];
$title = $_GET['title'];
$data_type = $_GET['data_type'];

require_once("db_functions.php");

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
          
      $move_link  = "<a href=\"".$p_link."?in_disp_from=".$before_num
            ."&in_search=".$p_search."\"><button class=\"navigate_button\" style=\"width:80;height:25\">前の".$p_max."件</button></a>    ";
    }
      
    if($p_to < $p_count)
    {
          $after_num = $p_from + $p_max;

          $move_link  = $move_link."<a href=\"".$p_link."?in_disp_from="
            .$after_num."&in_search=".$p_search."\"><button class=\"navigate_button\" style=\"width:80;height:25\">次の".$p_max ."件</button></a>";
    }

    print($move_link);
}

if(!$db = opendatabase("sake.db"))
{
   die("データベース接続エラー .<br />");
}

$in_disp_from = $_GET["in_disp_from"];
$in_disp_to = $in_disp_from + 20;

// count 
$sql = "SELECT COUNT(*) FROM SAKE_IMAGE WHERE sake_id = '$id' ORDER BY filename";

if($data_type == "sakagura")
  $sql = "SELECT COUNT(*) FROM SAKAGURA_IMAGE WHERE sakagura_id = '$id' ORDER BY filename";

$res = executequery($db, $sql);
$row = getnextrow($res); 
$count_result = $row["COUNT(*)"];

// query 
$in_disp_from = $_GET["in_disp_from"];

if(!$in_disp_from = intval($in_disp_from))
{
    $in_disp_from = 0;
}


print("<div><center>".$title."</center></div>");
print("<input type=\"hidden\" id=\"hidden_title\"  value=\"" .$title ."\">");
print("<input type=\"hidden\" id=\"hidden_id\" value=\"" .$id  ."\">");
print("<input type=\"hidden\" id=\"hidden_data_type\" value=\"" .$data_type  ."\">");

$sql = "SELECT SAKE_IMAGE.sake_id, SAKE_IMAGE.filename, sake_name FROM SAKE_IMAGE, SAKE_J WHERE SAKE_IMAGE.sake_id = SAKE_J.sake_id AND SAKE_IMAGE.sake_id = '$id' ORDER BY filename"." LIMIT ".$in_disp_from.", "."20";

if($data_type == "sakagura")
  $sql = "SELECT SAKAGURA_IMAGE.sakagura_id, SAKAGURA_IMAGE.filename, sakagura_name FROM SAKAGURA_IMAGE, SAKAGURA_J WHERE SAKAGURA_IMAGE.sakagura_id = SAKAGURA_J.id AND SAKAGURA_IMAGE.sakagura_id = '$id' ORDER BY filename"." LIMIT ".$in_disp_from.", "."20";

$res = executequery($db, $sql);

print("<table id=\"page\" border=\"0\">");
//print("<table border=\"0\">");
print("<tr>");

print("<td>写真数: ".$count_result."</FONT></td>");
printf("<td>");
disp_data_num($in_disp_from, $in_disp_to, $count_result);
printf("</td>");

printf("<td>");
disp_link($in_disp_from, $in_disp_to, 20, $count_result, "imageview.php");
//print("sql " .$sql);
print("</td>");
print("</tr>");
print("<tr><th>写真</th><th colspan=\"2\">ファイル名</th></tr>");

$i = 0;

while($row = getnextrow($res)) 
{
    $path = "images\\".$row["filename"];    

    if($data_type == "sakagura")
      $path = "images\\sakagura\\".$row["filename"];    

    print("<tr>");
    print("<td><center><img style=\"width:140px; height: auto; border-radius: 6px; box-shadow: 1px 1px 1px -1px rgba(0,0,0,.9);\" id=\"" .$row["filename"] ."\" class=\"preview\"  src=\"" .$path  ."\"></center></td>");
    print("<td colspan=\"2\">");
  	print("<button id=\"" .$row["filename"] ."\" class=\"delete_button\" filename = " .$row["filename"] ." style=\"width:46;height:22\">削除</button>");
    print($row["filename"] ."</td></tr>");
   
    $i++;
}

print("</table>");

/*
$i = 0;

print("<div class=\"threads\" id=\"threads\">");

while($row = getnextrow($res)) 
{
    $path = "images\\".$row["filename"];    
    print("<div class=\"static\">");
    print("<span style=\"position:absolute; left:30%;\">" .$row["sake_id"] ."</span><span style=\"position:absolute; left:40%;\">" .$row["filename"] ."<br></span>");
    
    print("<img id=\"" .$row["filename"] ."\" class=\"preview\"  src=\"" .$path  ."\">");
   
    print("<button class=\"delete_button\" style=\"width:46;height:22\" onclick=\"delete_image('$row[sake_id]', '$row[filename]', this)\">削除</button>");
    print("</div>");
}
*/

print("<center>");
print("<img src=\"drinksake.gif\" id=\"aboutlogo\" Title=\"Sake and Sakagura Listings\" alt=\"Sake and Sakagura Listings sakenomu.com\">");
print("</center>");
print("</div>");

sqlite_close($db);

?>

<script>

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
    var path = "images\\" + responseArray[0];

    if($('#hidden_data_type').val() == "sakagura")
    {
        path = "images\\sakagura\\" + responseArray[0];
    }

    /*
    _("status").innerHTML = event.target.responseText;
    _("progressBar").value = 0;
    */

    _("status").innerHTML = responseArray[0];
    _("progressBar").value = 0;

    var innerHTML = '<tr><td><center>' + 
        '<img id="' + responseArray[0] + '" style="width:140px; height: auto;" class="preview" src="' + path + '"></center></td>' +
        '<td colspan="2"><button filename =' + responseArray[0] + ' class="delete_button" style="width:46; height:22">削除</button>' + responseArray[0] + '</td></tr>';

    $element = $('#page').append(innerHTML);
    //$element.effects("highlight", {}, 2000);
    //alert("sakeid:" + responseArray[2]);
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

    // Load files into file reader
    reader.readAsDataURL(file);
}
  
  
$(document).ready(function(){

    $("#page").delegate('button', 'click', function() {
   
        var filename = $(this).attr('filename');
        var sakeid = $('#hidden_id').val();
        var data_type = $('#hidden_data_type').val();
        
        //alert("You clicked my <button>!");
        var obj = this;

        if(confirm("削除しますか ID:" + sakeid + " filename:" + filename) == true) 
        {
            var data = "id="+sakeid+"&data_type="+data_type+"&filename="+filename;
            //alert("data:" + data);

            $.ajax({
                type: "post",
                url: "image_delete.php",
                data: data,
            }).done(function(xml){
                var str = $(xml).find("str").text();

                if(str == "success")
                {
                    //alert("success");
                    //$(this).closest('tr').remove();
                    //$(obj).closest('tr').remove();
                    $(obj).closest('tr').fadeOut();
                }
                else
                {
                    alert("Failed:" +str);
                }
            }).fail(function(data){
                  var str = $(xml).find("str").text();
                  alert("Failed:" +str);
            });
        } 
    });

    $('#login-trigger').click(function(){
	    $(this).next('#login-content').slideToggle();
	    $(this).toggleClass('active');					
    	
	    if ($(this).hasClass('active')) $(this).find('span').html('&#x25B2;')
		    else $(this).find('span').html('&#x25BC;')
    });

    $('#logout').click(function(){
      var c = document.cookie.split("; ");
    	
      for(i in c) 
	      document.cookie =/^[^=]+/.exec(c[i])[0]+"=;expires=Thu, 01 Jan 1970 00:00:00 GMT";    

      alert("ログアウトしました");
      window.open('http://cgi.sakenomu.com', '_self');
    });
});


<!--
// 匿名関数内で実行
(function (){

	// --------------------------------------------------------------------------------
	// ドキュメントのクライアント領域のサイズを取得する関数
	// --------------------------------------------------------------------------------
	function GetClientSize(document_obj){
		var b = document_obj.body;
		var r = document_obj.documentElement;
		var w = b.clientWidth;
		var h;

		if(w < r.clientWidth)	
			w = r.clientWidth;
		
		if(document_obj.compatMode == "BackCompat")
		{
			h = b.clientHeight;
		}
		else
		{
			if(r.clientHeight)
			{
				h = r.clientHeight;
			}
			else
			{
				h = b.clientHeight;
			}
		}
		
		return {
			width :w,
			height:h
		};
	}

	// --------------------------------------------------------------------------------
	// ウィンドウのスクロール位置を取得する関数
	// --------------------------------------------------------------------------------
	function WindowGetScrollPosition(window_obj){
		if(window_obj.pageXOffset === undefined)
    {
		}
    else if(window_obj.pageYOffset === undefined)
    {
		}
    else
    {
			return {
				x:window_obj.pageXOffset,
				y:window_obj.pageYOffset
			};
		}

		var d = window_obj.document;
		
		return {
			x:(d.documentElement.scrollLeft || d.body.scrollLeft),
			y:(d.documentElement.scrollTop  || d.body.scrollTop )
		};
	}

	////////////////////////////////////////////////////////////////////////////////////
	// エレメントに文字列をセットして、テキストノードを構築する関数
	////////////////////////////////////////////////////////////////////////////////////
	function ElementSetTextContent(element,str)
  {
		if(element.textContent !== undefined)
    {
			element.textContent = str;
		}
		
    if(element.innerText !== undefined)
    {
			element.innerText = str;
		}
	}

	////////////////////////////////////////////////////////////////////////////////////
	// カスタムダイアログ用のコンストラクタ関数
	////////////////////////////////////////////////////////////////////////////////////
	function CustomDialog(title, width)
  {
		// プライベートな変数
		var _this = this;
		var _element_popup = null;
		var _element_bg = null;

		// 終了時に実行するイベント
		this.onclose = null;
		
		// メッセージを設定する
		this.setMessage = function (str){

			// "custom_dialog_message" という ID 属性のエレメントを取得する
			var element_message = document.getElementById("custom_dialog_message");

			if(element_message){

				// エレメントに文字列をセットする
				ElementSetTextContent(element_message,　str);
			}
		};

		// 要素を取得する
		this.getElement = function (){
			// "custom_dialog_body" という ID 属性のエレメントを取得する
			return document.getElementById("custom_dialog_body");
		};

		// 幅を設定する
		this.setWidth = function (width){
			// CSSStyleDeclaration オブジェクトを取得
			var style = _element_popup.style;

			// エレメントを幅を変更
			style.width = (width) + "px";
		};

		// 高さを設定する
		this.setHeight = function (height){
			// CSSStyleDeclaration オブジェクトを取得
			var style = _element_popup.style;

			// エレメントを幅を変更
			style.height = (height) + "px";
		};

		this.setUpdate = function () {
			update();
		};

		// 更新
		function update(){
			var style;

			//alert("update");

			// ドキュメントのクライアント領域のサイズを取得する
			var client_size = GetClientSize(document);

			// 現在のポップアップ用エレメントのバウンディングボックスのサイズを取得
			var rect = _element_popup.getBoundingClientRect();
			var element_width  = rect.right - rect.left;
			var element_height = rect.bottom - rect.top;

			//alert("client_size.height: " + client_size.height + " element_height: " + element_height);

			// 中央に配置するための位置を計算する（クライアント座標系）
			var element_x = (client_size.width / 2) - (element_width  / 2);
			var element_y = (client_size.height / 2) - (element_height / 2);

			// ウィンドウのスクロール位置を取得する
			var scroll_pos = WindowGetScrollPosition(window);

			// 位置をグローバル座標系に変換する
			element_x += scroll_pos.x;
			element_y += scroll_pos.y;

			// CSSStyleDeclaration オブジェクトを取得
			style = _element_popup.style;

			// エレメントを位置を修正する
			style.left = (element_x) + "px";
			style.top  = (element_y) + "px";

			// CSSStyleDeclaration オブジェクトを取得
			style = _element_bg.style;

			// エレメントを位置を修正する
			style.left = (scroll_pos.x) + "px";
			style.top  = (scroll_pos.y) + "px";

			// エレメントをサイズを修正する
			style.width  = (client_size.width)  + "px";
			style.height = (client_size.height) + "px";
		}

		// --------------------------------------------------------------------------------
		// 解放
		// --------------------------------------------------------------------------------
		function release(){
			var parent;

			// ------------------------------------------------------------
			// イベントのリッスンを終了する
			// ------------------------------------------------------------
			// イベントリスナーに対応している
			if(window.removeEventListener)
      {
          window.removeEventListener("resize" , update); // リサイズされるたびに実行されるイベント
          window.removeEventListener("scroll" , update); // スクロールされるたびに実行されるイベント
			    // アタッチイベントに対応している
			}
			else if(window.detachEvent)
			{
          window.detachEvent("onresize" , update); // リサイズされるたびに実行されるイベント
          window.detachEvent("onscroll" , update); // スクロールされるたびに実行されるイベント
			}

			// ------------------------------------------------------------
			// エレメントを、ノードリストから除外する
			// ------------------------------------------------------------
			parent = _element_popup.parentNode;

			if(parent){
				parent.removeChild(_element_popup);
			}

			parent = _element_bg.parentNode;
			if(parent){
				parent.removeChild(_element_bg);
			}
		}

		// --------------------------------------------------------------------------------
		// 初期化
		// --------------------------------------------------------------------------------
		(function (){
			var style;

			// エレメントを作成
			// ------------------------------------------------------------
			// スクリプト
			// ------------------------------------------------------------
			_element_script = document.createElement("script");
			_element_script.type = "text/javascript";
			_element_script.text = function key_down(get_code){
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
			
			document.body.appendChild(_element_script);			

			// ------------------------------------------------------------
			// 背景用エレメント
			// ------------------------------------------------------------
			// スタイルを設定

      _element_bg = document.createElement("div");
			style = _element_bg.style;
			style.position = "absolute";
			style.backgroundColor = "#000";
			var opacity = 0.5;
			style.opacity = opacity;
			style.filter = "alpha(opacity=" + (opacity * 100) + ")";

			// BODY のノードリストに登録する
			document.body.appendChild(_element_bg);

			// ------------------------------------------------------------
			// ポップアップ用エレメントを作成
			// ------------------------------------------------------------
			_element_popup = document.createElement("div");

			// スタイルを設定する
			style = _element_popup.style;
			style.position = "absolute";
			style.width  = width;

			style.backgroundColor = "#e3e3e3";
			style.border = "5px #404040 solid";
			style.borderRadius = "10px";
			style.boxShadow = "5px 5px 10px #444";
			style.lineHeight = "1.0";

			// BODY のノードリストに登録する
			document.body.appendChild(_element_popup);

			// ------------------------------------------------------------
			// HTML 文字列を指定して、DOM オブジェクトをまとめて構築する
			// ------------------------------------------------------------
			_element_popup.innerHTML = '' +
          '<div id="title" style="font-weight:bold; background:#404040; color:#fff; padding:4px;">' +
          title  +
          '</div>' +
          //'<div id="custom_dialog_message" style="margin:10px; padding:10px;"></div>' +
          '<div id="custom_dialog_body" style="margin:4px; padding:8px; background:#fff; border:1px solid #888;">' +
          '</div>' +
          '<div style="margin:10px;">' +
          '   <center> ' +
          //'	<input type="button" id="custom_dialog_button" style="width:18%; height:24px;" value="送信">' +
          '	<input type="button" id="custom_dialog_close_button" style="width:18%; height:24px;" value="閉じる">' +
          '   </center> ' +
          '</div>';

			// ------------------------------------------------------------
			// クリック時に実行されるイベント
			// ------------------------------------------------------------
			// "custom_dialog_button" という ID 属性のエレメントを取得する
			
      /*
      var element_button = document.getElementById("custom_dialog_button");

			element_button.onclick = function(){

          var callback = _this.onclose;

          // 解放
          release();

          // コールバック関数を実行
          if(callback)
          {
            callback();
          }
			};
      */

			var element_close_button = document.getElementById("custom_dialog_close_button");
			
			element_close_button.onclick = function (){
				release();
			};

			// ------------------------------------------------------------
			// イベントのリッスンを開始する
			// ------------------------------------------------------------
			if(window.addEventListener)
      {
          // イベントリスナーに対応している
          window.addEventListener("resize" , update); // リサイズされるたびに実行されるイベント
          window.addEventListener("scroll" , update); // スクロールされるたびに実行されるイベント
			}
      else if(window.attachEvent)
      {				
          // アタッチイベントに対応している
          window.attachEvent("onresize" , update); // リサイズされるたびに実行されるイベント
          window.attachEvent("onscroll" , update); // スクロールされるたびに実行されるイベント
			}

			// 更新
			update();
		})();
	} // CustomDialog

	// ------------------------------------------------------------
	// クリックした時に実行されるイベント
	// ------------------------------------------------------------

  $("table").delegate('img', 'click', function() {
      var path = document.getElementById(this.id);
      var custom_dialog = new CustomDialog("ここに写真を表示する", "400px");
      var element_body = custom_dialog.getElement();
      var innerHTML = '<table id="customers" border="1" cellspacing="0">';
          innerHTML += '	<tr class="alt"><td rowspan="10">';

      //custom_dialog.setMessage("メッセージを投稿する");
      innerHTML += '<center><img class="full" src=' + path.src + '></center>';
      innerHTML += '</td></tr></table>';

      //alert("innerHTML: " + innerHTML);
      custom_dialog.setWidth(680);
      element_body.innerHTML = innerHTML;
      custom_dialog.setUpdate();
      custom_dialog.onclose = function (){
      }; 
  });


  $('#addimage').click(function(){
      var custom_dialog = new CustomDialog("写真を追加する", "740px");
      var element_body = custom_dialog.getElement();
      var innerHTML = '<center><img src="" id="image" style="height:400px; width:auto;">';
          innerHTML += '<progress id="progressBar" value="0" max="100" style="width:300px;"></progress>';
          innerHTML += '<div id="status"></div>';
          innerHTML += '<div id="loaded_n_total"></div>';
          innerHTML += '<input type="file" id="file1" onchange="handleFiles()">';
          innerHTML += '<input type="button" id="submit" value="アップロード" onclick="uploadFile()"></center>';

          //alert("innerHTML: " + innerHTML);
          custom_dialog.setWidth(720);
          custom_dialog.setUpdate();
          element_body.innerHTML = innerHTML;
          custom_dialog.setUpdate();
          custom_dialog.onclose = function (){
          }; 
	});
})();
//-->

</script>
</div>
</center>
</body>
</html>
