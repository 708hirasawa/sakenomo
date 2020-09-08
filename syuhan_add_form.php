<?php
require_once("html_disp.php");
require_once("hamburger.php");
require_once("nonda.php");
require_once("searchbar.php");
?>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>  
</head>

<title>酒販店登録</title>
<link rel="stylesheet" type="text/css" href="css/hamburger.css">
<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/syuhan_add_form.css">
<script type="text/javascript" src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<body>

<?php
include_once('images/icons/svg_sprite.svg');
write_side_menu();
write_HamburgerLogo();
write_search_bar();
write_Nonda();
?>

<div id="container">
<div style="font-weight:bold; font-size: 1.1em; border: 2px solid #404040; color:#000; padding:4px"><span style="padding-left:10px;">酒販店　新規登録・情報編集</span></div>
<p id="sample1" style="font-size:11px;">登録・編集する情報に誤りがないことと情報が最新のものであることをご確認ください。<br>
また、入力された情報が事実と異なる場合、管理者側から修正・削除させていただくことがございますので、ご了承ください。
</p>

<form id="form" name="form" method="post">

<div style="background:linear-gradient(#c6c6c6, #404040); color:#fff; padding:8px 6px; border-top:1px solid #c6c6c6; border-left:1px solid #c6c6c6; border-right:1px solid #c6c6c6">入力フォーム</div>  
<div class="sakerow" style="margin-top:12px; border-top:1px solid #C6C6C6"><span style="margin-left:8px; margin-right:8px; padding-left:2px; background:#404040; border:1px solid #404040"></span>酒販店名<span style="margin-left:4px; color:#ff0000">[必須]</span></div>
<div class="sakerow" style="padding-left:8px; border-bottom:0px solid #C6C6C6">酒販店名</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input type="text" style="width:100%;" name="syuhanten_name"></div>

<div class="sakerow" style="padding-left:8px; border-bottom:0px solid #C6C6C6">ふりがな</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input type="text" style="width:100%;" name="syuhanten_read"></div>

<div class="sakerow" style="padding-left:8px; border-bottom:0px solid #C6C6C6">英語よみ</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input type="text" style="width:100%;" name="syuhanten_english"></div>

<div class="sakerow" style="padding-left:8px; border-bottom:0px solid #C6C6C6">酒販店検索用</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input type="text" style="width:100%;" name="syuhanten_search"></div>

<div class="sakerow" style="margin-top:12px; border-top:1px solid #C6C6C6"><span style="margin-left:8px; margin-right:8px; padding-left:2px; background:#404040; border:1px solid #404040"></span>酒販店の紹介</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><textarea id="syuhanten_intro" name="syuhanten_intro" style="width:100%; height:100px;"></textarea></div>

<!--
<tr class="alt">
<td style="border-right:0px solid #fff;">酒販店</td>
<td style="border-left:0px solid #fff;" colspan="3"><input style="width:100%;"  type="text" name="syuhanten"></td>
</tr>
-->

<div class="sakerow" style="margin-top:12px; border-top:1px solid #C6C6C6"><span style="margin-left:8px; margin-right:8px; padding-left:2px; background:#404040; border:1px solid #404040"></span>住所</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px; border-bottom:0px solid #c6c6c6"></span>郵便番号</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input id="syuhanten_postal_code" type="text" name="syuhanten_postal_code"></div>

<div class="sakerow" style="padding-left:8px; padding-right:4px; border-bottom:0px solid #C6C6C6"></span>都道府県</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px">
	<SELECT id="pref" name="pref">
	<OPTION VALUE="">指定なし</OPTION>
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
</div>
  
<div class="sakerow" style="padding-left:8px; padding-right:4px; border-bottom:0px solid #C6C6C6"></span>市区町村・番地</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input id="syuhanten_address" style="width:100%;" type="text" name="syuhanten_address"></div>

<div class="sakerow" style="padding-left:8px; padding-right:4px; border-bottom:0px solid #C6C6C6"></span>ふりがな</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input id="pref_read" style="width:100%;" type="text" name="pref_read"></div>
  

<div class="sakerow" style="margin-top:12px; border-top:1px solid #C6C6C6"><span style="margin-left:8px; margin-right:8px; padding-left:2px; background:#404040; border:1px solid #404040"></span>問い合わせ先</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px; border-bottom:0px solid #C6C6C6">電話番号</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input id="syuhanten_phone" type="text" name="syuhanten_phone" style="width:100%;"></div>

<div class="sakerow" style="padding-left:8px; padding-right:4px; border-bottom:0px solid #C6C6C6">FAX番号</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input id="syuhanten_fax" type="text" name="syuhanten_fax" style="width:100%;"></div>

<div class="sakerow" style="padding-left:8px; padding-right:4px; border-bottom:0px solid #C6C6C6">ホームページ</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input id="syuhanten_url" type="text" name="syuhanten_url" style="width:100%;"></div>
 
<div class="sakerow" style="padding-left:8px; padding-right:4px; border-bottom:0px solid #C6C6C6">Email</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input id="syuhanten_email" type="text" name="syuhanten_email" style="width:100%;"></div>

<div class="sakerow" style="margin-top:12px; border-top:1px solid #C6C6C6"><span style="margin-left:8px; margin-right:8px; padding-left:2px; background:#404040; border:1px solid #404040"></span>営業時間</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><textarea id="syuhanten_hours" style="width:100%; height:62px" name="syuhanten_hours"></textarea></div>
  
<div class="sakerow" style="margin-top:12px; border-top:1px solid #C6C6C6"><span style="margin-left:8px; margin-right:8px; padding-left:2px; background:#404040; border:1px solid #404040"></span>定休日</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input style="width:100%" type="text" name="syuhanten_closed"></div>

<div class="sakerow" style="margin-top:12px; border-top:1px solid #C6C6C6"><span style="margin-left:8px; margin-right:8px; padding-left:2px; background:#404040; border:1px solid #404040"></span>取扱銘柄</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><input type="text" name="syuhanten_sake" style="width:100%"></div>

<div class="sakerow" style="margin-top:12px; border-top:1px solid #C6C6C6"><span style="margin-left:8px; margin-right:8px; padding-left:2px; background:#404040; border:1px solid #404040"></span>メモ</div>
<div class="sakerow" style="padding-left:8px; padding-right:4px"><textarea name="memo" style="width:100%" rows=10></textarea></div>
</form>

<div align="center">
<button id="syuhanten_confirm" class="add_button">確認</button>
<a href="sake_search.php"><input id="button_return" type="button" class="add_button" value="検索画面に戻る"></a>
</div>

</div>
  

<?php
require_once("html_disp.php");
writefooter();
?>  
  

<div id="dialog-confirm" title="酒販店を追加しますか？">
<table id="customers">
<tr class="alt">
<td style="border-right:0px solid #fff; width:25%;">酒販店名</td>
<td id="dialog_syuhanten_name" style="width:75%; border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">ふりがな</td>
<td id="dialog_syuhanten_read" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">英語よみ</td>
<td id="dialog_syuhanten_english" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>


<tr class="alt">
<td style="border-right:0px solid #fff;">酒販店検索用</td>
<td id="dialog_syuhanten_search" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>
  
<tr class="alt">
<td style="border-right:0px solid #fff;">酒販店の紹介</td>
<td id="dialog_syuhanten_intro" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">郵便番号</td>
<td id="dialog_syuhanten_postal_code" colspan="4" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">都道府県</td>
<td id="dialog_pref" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">酒販店ランク</td>
<td id="dialog_syuhanten_rank" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>
  
<tr class="alt">
<td style="border-right:0px solid #fff;">住所</td>
<td id="dialog_syuhanten_address" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">住所よみ<span style="color: #858585; font-size: 8pt;">半角数字</span></td>
<td id="dialog_pref_read" style="border-left:0px solid #fff;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">電話番号<span style="color: #858585; font-size: 8pt;">半角数字</span></td>
<td id="dialog_syuhanten_phone" style="border-left:0px solid #fff;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">FAX番号<span style="color: #858585; font-size: 8pt;">半角数字</span></td> 
<td id="dialog_syuhanten_fax" style="border-left:0px solid #fff;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">ウェブサイト </td>
<td id="dialog_syuhanten_url" style="border-left:0px solid #fff;"></td>
</tr>
  
<tr class="alt">
<td style="border-right:0px solid #fff;">Email</td>
<td id="dialog_syuhanten_email" style="border-left:0px solid #fff;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">営業時間</td>
<td id="dialog_syuhanten_hours" style="border-left:0px solid #fff;"></td>
</tr>
  
<tr class="alt">
<td style="border-right:0px solid #fff;">定休日<span style="color: #858585; font-size: 8pt;">全角半角</span></td>
<td id="dialog_syuhanten_closed" style="border-left:0px solid #fff;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">取扱銘柄</td>
<td id="dialog_syuhanten_sake" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>
  
<tr class="alt">
<td style="border-right:0px solid #fff;">メモ</td>
<td id="dialog_syuhanten_memo" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>

<tr class="alt">
<td style="border-right:0px solid #fff;">データソース</td>
<td id="dialog_syuhanten_data_source" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>
  
<tr class="alt">
<td style="border-right:0px solid #fff;">Last Contacted</td>
<td id="dialog_syuhanten_lastcontacted" style="border-left:0px solid #fff; margin: 2px 0px 2px 0px;"></td>
</tr>
</table>
</div>


</body>

<script type="text/javascript">

jQuery(document).ready(function(){

  $("body").wrapInner('<div id="wrapper"></div>'); 

	$('.hamburger').click(function () {

	if($('.hamburger').hasClass('is-open')) {
			$('.overlay').hide();
			$('.hamburger').removeClass('is-open');
			$('.hamburger').addClass('is-closed');
	} else {   
	  $('.overlay').show();
	  $('.hamburger').removeClass('is-closed');
	  $('.hamburger').addClass('is-open');
	}

	$('#wrapper').toggleClass('toggled');
		$('.header').toggleClass('toggled');
	});

	$('#container').createAutoKana({
			sakagura_name : $('input[name="syuhanten_name"]'),
			sakagura_read : $('input[name="syuhanten_read"]'),
			sakagura_english : $('input[name="syuhanten_english"]')
	});

  var dialog_message = $("#dialog-message").dialog({
      autoOpen: false,
      modal: true,
      buttons: {
        Ok: function() {
          $(this).dialog( "close" );
        }
      }
  });

  var dialog = $("#dialog-confirm").dialog({
        autoOpen: false,
        resizable: false,
        height:640,
        width:840,
        modal: true,
        
        buttons: {
          追加: function() {
            
            var data = $("#form").serialize(); 
            //alert("data:" + data);

            $.ajax({
                type: "post",
                url: "syuhan_add.php",
                data: data,
            }).done(function(xml){
                var str = $(xml).find("str").text();
                //alert("success:" + str);

                if(str == "success")
                {
                    var id = $(xml).find("id").text();
                    //alert("id:" + id);
                    window.open('syuhan_view.php?syuhanten_id=' + id, '_self');
                }
                else
                {
                  $("#sample1").text(str);
                }  
            }).fail(function(data){
                var str = $(data).find("str").text();
                alert("This is Error:" + data);
                //$("#sample1").text('This is Error');
            });
            $(this).dialog("close");
          },
          
          キャンセル: function() {
            $(this).dialog("close");
          }
        }
  });


  $('#syuhanten_postal_code').change(function(){
      var txt = $(this).val();
      var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
      $(this).val(han);
	});

  $('#syuhanten_postal_code').jpostal({
	  postcode : [
		  '#syuhanten_postal_code',
	  ],
	  address : {
		  '#pref'       : '%3',
		  '#syuhanten_address'    : '%4%5',
      '#pref_read'  : '%8%9%10',
	  }
  });

  $('#syuhanten_confirm').click(function(){

      //var data = $("#form").serialize(); 
		  //alert("data:" + data);

      $("#dialog_syuhanten_name").text($('input[name="syuhanten_name"]').val());
      $("#dialog_syuhanten_read").text($('input[name="syuhanten_read"]').val());
      $("#dialog_syuhanten_english").text($('input[name="syuhanten_english"]').val());
      $("#dialog_syuhanten_search").text($('input[name="syuhanten_search"]').val());
      $("#dialog_syuhanten_postal_code").text($('input[name="syuhanten_postal_code"]').val());
      $("#dialog_syuhanten").text($('input[name="syuhanten"]').val());
      $("#dialog_pref").text($('input[name="pref"]').val());
      $("#dialog_syuhanten_rank").text($('input[name="syuhanten_rank"]').val());
      $("#dialog_syuhanten_address").text($('input[name="syuhanten_address"]').val());
      $("#dialog_pref_read").text($('input[name="pref_read"]').val());
      $("#dialog_syuhanten_phone").text($('input[name="syuhanten_phone"]').val());
      $("#dialog_syuhanten_fax").text($('input[name="syuhanten_fax"]').val());
      $("#dialog_syuhanten_url").text($('input[name="syuhanten_url"]').val());
      $("#dialog_syuhanten_email").text($('input[name="syuhanten_email"]').val());
      $("#dialog_syuhanten_hours").text($('textarea[name="syuhanten_hours"]').val());
      $("#dialog_syuhanten_closed").text($('input[name="syuhanten_closed"]').val());
      $("#dialog_syuhanten_sake").text($('input[name="syuhanten_sake"]').val());
      $("#dialog_syuhanten_memo").text($('input[name="syuhanten_memo"]').val());
      $("#dialog_syuhanten_data_source").text($('input[name="syuhanten_data_source"]').val());
      $("#dialog_syuhanten_lastcontacted").text($('input[name="syuhanten_lastcontacted"]').val());
 
      dialog.dialog("open");
  });
	

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  $('input[name="pref"]').change(function(){
		var txt = $(this).val();
		var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
		$(this).val(han);
	});

  $('input[name="syuhanten_phone"]').change(function(){
		var txt = $(this).val();
		var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
		$(this).val(han);
	});

  $('input[name="syuhanten_fax"]').change(function(){
		var txt = $(this).val();
		var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
		$(this).val(han);
	});

  $('input[name="syuhanten_url"]').change(function(){
		var txt = $(this).val();
		var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
		$(this).val(han);
	});

  $('input[name="syuhanten_email"]').change(function(){
		var txt = $(this).val();
		var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
		$(this).val(han);
	});
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////


  $('input[name="syuhanten_region"]').change(function(){
	  var region = $("#syuhanten_region option:selected").text();
	  var x = document.getElementById("pref");

	  if(region == "すべて")
	  {  
		  x.length = 43; 
		  x.options[0].value = x.options[0].text = "北海道";
		  x.options[1].value = x.options[1].text = "青森県";
		  x.options[2].value = x.options[2].text = "岩手県";
		  x.options[3].value = x.options[3].text = "宮城県";
		  x.options[4].value = x.options[4].text = "秋田県";
		  x.options[5].value = x.options[5].text = "山形県";
		  x.options[6].value = x.options[6].text = "福島県";
		  x.options[7].value = x.options[7].text = "茨城県";
		  x.options[8].value = x.options[8].text = "栃木県";
		  x.options[9].value = x.options[9].text = "群馬県";
		  x.options[10].value = x.options[10].text = "埼玉県";
		  x.options[11].value = x.options[11].text = "千葉県";
		  x.options[12].value = x.options[12].text = "東京都";
		  x.options[13].value = x.options[13].text = "神奈川県";
		  x.options[14].value = x.options[14].text = "新潟県";
		  x.options[15].value = x.options[15].text = "富山県";
		  x.options[16].value = x.options[16].text = "石川県";
		  x.options[17].value = x.options[17].text = "福井県";
		  x.options[18].value = x.options[18].text = "山梨県";
		  x.options[19].value = x.options[19].text = "長野県";
		  x.options[20].value = x.options[20].text = "岐阜県";
		  x.options[21].value = x.options[21].text = "静岡県";
		  x.options[22].value = x.options[22].text = "愛知県";
		  x.options[23].value = x.options[23].text = "三重県";
		  x.options[24].value = x.options[24].text = "滋賀県";
		  x.options[25].value = x.options[25].text = "京都府";
		  x.options[26].value = x.options[26].text = "大阪府";
		  x.options[27].value = x.options[27].text = "兵庫県";
		  x.options[28].value = x.options[28].text = "奈良県";
		  x.options[29].value = x.options[29].text = "和歌山県";
		  x.options[30].value = x.options[30].text = "鳥取県";
		  x.options[31].value = x.options[31].text = "島根県";
		  x.options[32].value = x.options[32].text = "岡山県";
		  x.options[33].value = x.options[33].text = "広島県";
		  x.options[34].value = x.options[34].text = "山口県";
		  x.options[35].value = x.options[35].text = "福岡県";
		  x.options[36].value = x.options[36].text = "佐賀県";
		  x.options[37].value = x.options[37].text = "長崎県";
		  x.options[38].value = x.options[38].text = "熊本県";
		  x.options[39].value = x.options[39].text = "大分県";
		  x.options[40].value = x.options[40].text = "宮城県";
		  x.options[41].value = x.options[41].text = "鹿児島県";
		  x.options[42].value = x.options[42].text = "沖縄県";
	  }
	  else if(region == "北海道地方")
	  {   
		  x.length = 1; 
		  x.options[0].value = x.options[0].text = "北海道";
	  }
	  else if(region == "東北地方")
	  {
		  x.length = 6;
		  x.options[0].value = x.options[0].text = "青森県";
		  x.options[1].value = x.options[1].text = "岩手県";
		  x.options[2].value = x.options[2].text = "宮城県";
		  x.options[3].value = x.options[3].text = "秋田県";
		  x.options[4].value = x.options[4].text = "山形県";
		  x.options[5].value = x.options[5].text = "福島県";
	  }
	  else if(region == "関東地方")
	  {
		  x.length = 7;
		  x.options[0].value = x.options[0].text = "茨城県";
		  x.options[1].value = x.options[1].text = "栃木県";
		  x.options[2].value = x.options[2].text = "群馬県";
		  x.options[3].value = x.options[3].text = "埼玉県";
		  x.options[4].value = x.options[4].text = "千葉県";
		  x.options[5].value = x.options[5].text = "東京都";
		  x.options[6].value = x.options[6].text = "神奈川県";
	  }
	  else if(region == "中部地方")
	  {
		  x.length = 9;
		  x.options[0].value = x.options[0].text = "新潟県";
		  x.options[1].value = x.options[1].text = "富山県";
		  x.options[2].value = x.options[2].text = "石川県";
		  x.options[3].value = x.options[3].text = "福井県";
		  x.options[4].value = x.options[4].text = "山梨県";
		  x.options[5].value = x.options[5].text = "長野県";
		  x.options[6].value = x.options[6].text = "岐阜県";
		  x.options[7].value = x.options[7].text = "静岡県";
		  x.options[8].value = x.options[8].text = "愛知県";
	  }
	  else if(region == "近畿地方")
	  {
		  x.length = 7;
		  x.options[0].value = x.options[0].text = "三重県";
		  x.options[1].value = x.options[1].text = "滋賀県";
		  x.options[2].value = x.options[2].text = "京都府";
		  x.options[3].value = x.options[3].text = "大阪府";
		  x.options[4].value = x.options[4].text = "兵庫県";
		  x.options[5].value = x.options[5].text = "奈良県";
		  x.options[6].value = x.options[6].text = "和歌山県";
	  }
	  else if(region == "中国地方")
	  {
		  x.length = 5;
		  x.options[0].value = x.options[0].text = "鳥取県";
		  x.options[1].value = x.options[1].text = "島根県";
		  x.options[2].value = x.options[2].text = "岡山県";
		  x.options[3].value = x.options[3].text = "広島県";
		  x.options[4].value = x.options[4].text = "山口県";
	  }
	  else if(region == "四国地方")
	  {
		  x.length = 5;
		  x.options[0].value = x.options[0].text = "徳島県";
		  x.options[1].value = x.options[1].text = "香川県";
		  x.options[2].value = x.options[2].text = "愛媛県";
		  x.options[3].value = x.options[3].text = "高知県";
		  x.options[4].value = x.options[4].text = "山口県";
	  }
	  else if(region == "九州地方")
	  {
		  x.length = 8;
		  x.options[0].value = x.options[0].text = "福岡県";
		  x.options[1].value = x.options[1].text = "佐賀県";
		  x.options[2].value = x.options[2].text = "長崎県";
		  x.options[3].value = x.options[3].text = "熊本県";
		  x.options[4].value = x.options[4].text = "大分県";
		  x.options[5].value = x.options[5].text = "宮城県";
		  x.options[6].value = x.options[6].text = "鹿児島県";
		  x.options[7].value = x.options[7].text = "沖縄県";
	  }
  });

  $(window).bind("load", ScaleDocument);
  $(window).bind("resize", ScaleDocument);
  $(window).bind("orientationchange", ScaleDocument);
});
  
</script>
</html>
