<?php
require_once("html_disp.php");
require_once("hamburger.php");
require_once("searchbar.php");
require_once("nonda.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!DOCTYPE html>

<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<title>Sakenomo</title>
<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/sakenomuui.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/searchbar.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/nonda.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
<script src="js/hamburger.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
</head>

<style>

* {
    box-sizing: border-box;
}

.row::after {
    content: "";
    clear: both;
    display: block;
}

[class*="col-"] {
    float: left;
    padding: 15px;
}

html {
    font-family: "Lucida Sans", sans-serif;
}

.sake_menu ul {
    margin: 0px;
    padding: 0px;
    font-family: "メイリオ", Arial, Helvetica, sans-serif;
    font-size: 10pt;
    list-style-type: none;
		font-weight:bold;
}
 
.sake_menu li {
    float:left;
		width:24px;
		height:24px;
		margin:4px;

    cursor: pointer;
    padding: 4px;

    margin-bottom: 7px;
    background-color: #fff;
    color: #0740A5;
	  border: 1px solid #c6c6c6;

    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.sake_menu li:hover {
    background-color: #0099cc;
}

.aside {
    background-color: #33b5e5;
    padding: 2px;
    color: #ffffff;
    text-align: center;
    font-size: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}

.footer {
    background: url(images/icons/footer.jpg) repeat;
    color: #ffffff;
    text-align: center;
    font-size: 12px;
    padding: 15px;
}

/* For mobile phones: */
[class*="col-"] {
    width: 100%;
}

@media only screen and (min-width: 600px) {
    /* For tablets: */
    .col-m-1 {width: 8.33%;}
    .col-m-2 {width: 16.66%;}
    .col-m-3 {width: 25%;}
    .col-m-4 {width: 33.33%;}
    .col-m-5 {width: 41.66%;}
    .col-m-6 {width: 50%;}
    .col-m-7 {width: 58.33%;}
    .col-m-8 {width: 66.66%;}
    .col-m-9 {width: 75%;}
    .col-m-10 {width: 83.33%;}
    .col-m-11 {width: 91.66%;}
    .col-m-12 {width: 100%;}
}

@media only screen and (min-width: 768px) {
    /* For desktop: */
    .col-1 {width: 8.33%;}
    .col-2 {width: 16.66%;}
    .col-3 {width: 25%;}
    .col-4 {width: 33.33%;}
    .col-5 {width: 41.66%;}
    .col-6 {width: 50%;}
    .col-7 {width: 58.33%;}
    .col-8 {width: 66.66%;}
    .col-9 {width: 75%;}
    .col-10 {width: 83.33%;}
    .col-11 {width: 91.66%;}
    .col-12 {width: 100%;}
}
</style>
</head>
<body>

<?php
	include_once('images/icons/svg_sprite.svg');
	write_side_menu();
	write_HamburgerLogo();
	write_search_bar();
	write_Nonda();
?>

<div class="row" style="margin-top:88px">

<div class="col-3 col-m-3 sake_menu">
  <ul>
    <li>あ</li>
    <li>い</li>
    <li>う</li>
    <li>え</li>
    <li>お</li>

    <li>か</li>
    <li>き</li>
    <li>く</li>
    <li>け</li>
    <li>こ</li>

    <li>さ</li>
    <li>し</li>
    <li>す</li>
    <li>せ</li>
    <li>そ</li>

    <li>た</li>
    <li>ち</li>
    <li>つ</li>
    <li>て</li>
    <li>と</li>

    <li>な</li>
    <li>に</li>
    <li>ぬ</li>
    <li>ね</li>
    <li>の</li>

    <li>は</li>
    <li>ひ</li>
    <li>ふ</li>
    <li>へ</li>
    <li>ほ</li>

    <li>ま</li>
    <li>み</li>
    <li>む</li>
    <li>め</li>
    <li>も</li>

    <li>や</li>
    <li></li>
    <li>ゆ</li>
    <li></li>
    <li>よ</li>

    <li>ら</li>
    <li>り</li>
    <li>る</li>
    <li>れ</li>
    <li>ろ</li>

    <li>わ</li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>

  </ul>
</div>

<div class="col-6 col-m-9">
	<img style="width:100%" src="images/icons/sakebackground.jpg">
  <h1>The City</h1>
  <p>Chania is the capital of the Chania region on the island of Crete. The city can be divided in two parts, the old town and the modern city.</p>
</div>

<div class="col-3 col-m-12">
  <div class="aside">

		<div id="ad1" style="width:100%; height:auto"><img style="width:100%; height:250px;" src="images/ad/ad1.jpg"></div>

    <h2>What?</h2>
    <p>Chania is a city on the island of Crete.</p>
    <h2>Where?</h2>
    <p>Crete is a Greek island in the Mediterranean Sea.</p>
    <h2>How?</h2>
    <p>You can reach Chania airport from all over Europe.</p>


  </div>
</div>

</div>

<div class="footer" >
	<div style="position:relative; width:100%; padding-top:4px; padding-bottom:4px; overflow:auto; color:#000">
	
		<ul style="position:relative; float:left; height:80px; list-style-type: none; padding-left:2px; padding-right:8px;">
			<li>sakenomuとは</li>
			<li>日本酒を知る</li>
			<li>日本酒とは</li>;
			<li>飲食店を検索する</li>
		</ul>
		    
		<ul style="position:relative; float:left; height:80px; list-style-type: none; padding-left:2px; padding-right:8px"> 
			<li>検索カテゴリー一覧</li>
			<li>サービスガイド</li>
			<li>ヘルプ・問い合わせ</li>
			<li>お知らせ・特集</li>
		</ul>
		    
		<ul style="position:relative; float:left; height:80px; list-style-type: none; padding-left:2px; padding-right:8px"> 
			<li>新レビュアー</li>
			<li>ログイン</li>
			<li>About us</li>
			<li>会社概要</li>
		</ul>

		<ul style="position:relative; float:left; height:80px; list-style-type: none; padding-left:2px; padding-right:8px;"> 
			<li>理念</li>
			<li>Contact us</li>
			<li>よくある質問</li>
			<li>広告掲載について</li>
		</ul>

		<ul style="position:relative; float:left; height:80px; list-style-type: none; padding-left:2px; padding-right:8px;">
			<li>企業向け無料会員登録</li>
			<li>ピックアップレビュアー</li>
			<li>お知らせ・特集</li>
			<li>利用規約</li>
		</ul>

		<div style="position:relative; float:left;  width:300px">
		<textarea style="width:100%; height:140px; border-radius:4px" placeholder="コメントを入力してください"></textarea><br>
		<input type="button" name="search_option" class="navigate_button" style="margin:2% 40% 2% 40%; float:none;" value="送信する">
		</div>
	</div>

	<div>Copyright drinksake Inc. All Rights Reserved</div>
</div>

<script type="text/javascript">

jQuery(document).ready(function($) {

		function ScaleSlider() {

 	      var parentWidth = $(window).width();

        if(parentWidth)
        {
						scaleNavigator(parentWidth);
        } 
    }

    ScaleSlider();
    $(window).bind("load", ScaleSlider);
    $(window).bind("resize", ScaleSlider);
    $(window).bind("orientationchange", ScaleSlider);
});

</script>
</body>
</html>
