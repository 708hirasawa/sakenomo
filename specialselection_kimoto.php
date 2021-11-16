<?php
require_once("db_functions.php");
require_once("html_disp.php");
require_once("hamburger.php");
require_once("nonda.php");
require_once("searchbar.php");
?>

<!DOCTYPE html>

<html lang="ja">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<!-- Facebook OGP設定 -->
	<!-- FacebookでOGPを使うにはFacebookでadmins IDを取得してそれを記述する -->
	<meta property="fb:app_id" content="●●">

	<!-- オブジェクトタイプwebsiteはWebサイトのトップページを表す -->
	<meta property="og:type" content="website">

	<!-- シェアしたいURLを絶対パスで記述する -->
	<meta property="og:url" content="https://">

	<!-- シェアされたときに表示させる画像があるURLを絶対パスで記述する-->
	<meta property="og:image" content="/company/images/ogp-1.png">

	<!-- FacebookのSakenomoのURLを入れるとFacebookで共有されたときにまだそのページにいいね!していない人に対していいね！ボタンが表示されるようになる -->
	<meta property="article:publisher" content="https://www.facebook.com/●●">

	<title>Sakenomo 生酛(きもと)造り特集</title>
	<link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/hamburger.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/searchbar.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/nonda.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<link rel="stylesheet" type="text/css" href="css/specialselection_kimoto.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
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
  ?>

  <div id="all_container">
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.9";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <div id="sec1">
      <div class="sec1-content">
        <div class="sec1-article-container">
          <h1 class="sec1-title">生酛(きもと)造り</h1>
          <p class="sec1-text">江戸時代にも行われていた生酛造り。古来受け継がれてきた酒造りの原点ともいえる製法です。時を超え、現在あらためて評価されている生酛造りの日本酒を集めました。</p>
          <div class="share-button">
            <div class="fb-share-button" data-href="http://cgi.sakenomu.com/sake/sake_search.php" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fcgi.sakenomu.com%2Fsake%2Fsake_search.php&amp;src=sdkpreparse">シェア</a></div>
            <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
          </div>
        </div>
      </div>
    </div>

    <div id="sec2">
      <div class="sec2-content">
        <div class="sec2-article-container">
          <div class="sec2-title">
            <h1>生酛(きもと)造りとは？</h1>
          </div>
          <div class="sec2-text">
            <p>酒母(酛)を仕込む際、酵母を育てやすい環境をつくるために、酒母に乳酸を取り入れ、酸性に弱いその他の雑菌を排除します。このとき、自然界に生息する乳酸菌を取り込んでつくられる酒母を生酛といいます。自然界の生存競争を生き抜いた微生物によってつくられる生酛は、力強く奥深い味わいを生むといわれています。一方、天然の乳酸菌を利用せず、人工の乳酸を直接添加してつくる酒母を速醸酛といいます。</p>
          </div>
        </div>
        <div class="sec2-image-container">
          <img src="image/image_kimoto_sec2.png" alt="日本酒イメージ" class="sec2-image">
        </div>
      </div>
    </div>

    <div id="sec3">
      <div class="sec3-content">
        <!--
        <div class="sec3-card">
          <a href="" class="sec3-image-container">
            <div style="background-image: url('image/image_noimage.svg');" class="sec3-image"></div>
          </a>
          <div class="sec3-sakename-container"><a href="">愛宕の松 Sparkling</a></div>
          <div class="sec3-breweryname-container"><a href="">新澤醸造店 / 宮城県</a></div>
        </div>
        -->


        <?php

        /* コメント: phpでsqlを使うための説明
        酒テーブル: sake_j
        ==================
        テーブルの含まれる項目リスト
        sake_id
        sake_name VARCHAR(48)
        sake_search VARCHAR(48)
        sake_read VARCHAR(48)
        sake_english VARCHAR(48)
        sakagura_id VARCHAR(48)
        sake_rank INTEGER
        definition VARCHAR(2058)
        special_name VARCHAR(48)
        sake_category VARCHAR(48)
        sake_category3 VARCHAR(48)
        volume_180 INTEGER
        volume_300 INTEGER
        volume_720 INTEGER,
        volume_1800 INTEGER,
        volume_other INTEGER
        price_180 INTEGER
        price_300 INTEGER
        price_720 INTEGER
        price_1800 INTEGER
        price_other INTEGER
        ingredients VARCHAR(2058)
        alcohol_level VARCHAR(64)
        rice_used VARCHAR(48)
        seimai_rate VARCHAR(48)
        jsake_level FLOAT
        oxidation_level FLOAT
        amino_level FLOAT
        koubo_used VARCHAR(48)
        syubo INTEGER
        kasu_level FLOAT,
        water_used VARCHAR(512),
        year_made INTEGER,
        sake_type VARCHAR(64),
        taste VARCHAR(2058),
        smell VARCHAR(2058),
        feature VARCHAR(2058),
        recommended_drink VARCHAR(2058),
        recommended_cook VARCHAR(2058),
        sake_award_history VARCHAR(2058),
        sake_memo VARCHAR(2058)
        write_date INTEGER
        develop varchar(512)


        酒蔵テーブル: sakagura_j
        =========================
        テーブルの含まれる項目リスト
        sakagura
        id VARCHAR(40)
        rank INTEGER
        country VARCHAR(40)
        region_name VARCHAR(20)
        pref VARCHAR(20)
        pref_read VARCHAR(20)
        sakagura_name VARCHAR(40)
        sakagura_search VARCHAR(40)
        sakagura_read VARCHAR(40)
        sakagura_english VARCHAR(64)
        sakagura_intro VARCHAR(40)
        postal_code VARCHAR(40)
        address VARCHAR(40)
        phone VARCHAR(40)
        fax VARCHAR(40)
        url VARCHAR(40)
        email VARCHAR(40)
        brand VARCHAR(40)
        representative VARCHAR(40)
        touji VARCHAR(40)
        establishment VARCHAR(40)
        award_history VARCHAR(40)
        observation VARCHAR(40)
        observatory_info VARCHAR(40)
        direct_sale VARCHAR(40)
        payment_method VARCHAR(40)
        memo VARCHAR(256)
        data_source VARCHAR(124)
        LastContacted VARCHAR(24)


        酒の画像テーブル: sake_image
        ============================
        テーブルの含まれる項目:

        sake_id VARCHAR(24)　	酒のID
        filename VARCHAR(256) 画像ファイル名

        sake_category code (製法の特徴)
        ------------------------------
        11	無ろ過
        21	にごり酒
        22	あらばしり
        32	責め・押切り
        33	生酒・本生
        34	生詰酒
        35	生貯蔵酒
        39	直汲み・直詰め
        40	遠心分離
        41	槽しぼり
        42	きもと
        43	山廃もと
        44	木桶仕込
        45	原酒
        46	生一本
        48	古酒・長期貯蔵酒
        51	スパークリング
        31	中取り/中垂/中汲み
        37	ひやおろし・秋上がり
        50	新酒・初しぼり・しぼりたて
        49	おり酒・おりがらみ・うすにごり・ささにごり
        38	しずく酒・しずくしぼり・袋吊り・袋しぼり・斗瓶取り・斗瓶囲い
        90  その他

        special_name code (特定名称)
        ---------------------------
        11	普通酒
        21	本醸造酒
        22	特別本醸造酒
        31	純米酒
        32	特別純米酒
        33	純米吟醸酒
        34	純米大吟醸酒
        43	吟醸酒
        44	大吟醸酒
        99	不明
        90	その他

        きもとの酒を検索する場合
        SELECT * FROM sake_j, sakagura_j WHERE sake_j.sakagura_id = sakagura.id AND sake_category like '%42%';

        きもとの酒を１０件ほど検索する場合
        SELECT * FROM sake_j, sakagura_j WHERE sake_j.sakagura_id = sakagura.id AND sake_category like '%42%' limit 0, 10;

        きもとの酒を１１件～２０件ほど検索する場合
        SELECT * FROM sake_j, sakagura_j WHERE sake_j.sakagura_id = sakagura.id AND sake_category like '%42%' limit 10, 20;

        普通酒を検索する場合
        SELECT * FROM sake_j, sakagura_j WHERE sake_j.sakagura_id = sakagura.id AND special_name like '%11%';

        普通酒と純米酒を検索する場合
        SELECT * FROM sake_j, sakagura_j WHERE sake_j.sakagura_id = sakagura.id AND (special_name like '%11%' OR special_name like '%31%');

        普通酒を検索して日本酒名で並べ替える場合
        SELECT * FROM sake_j, sakagura_j WHERE sake_j.sakagura_id = sakagura.id AND special_name like '%11%' ORDER BY sake_j.sake_read;

        写真付きのきもとの酒を検索する
        $sql = "SELECT * FROM sake_j, sakagura_j, sake_image WHERE sake_j.sake_id=sake_image.sake_id AND sake_category like '%42%' AND sake_j.sakagura_id = sakagura.id";
        */


        // ここから実際のコード
        require_once("db_functions.php");

        if(!$db = opendatabase("sake.db"))
        {
            print('<div>データベース接続エラー .</div>');
        }

        // きもとの酒を検索する
        $sql = "select sake_id, sake_name, sakagura_name, pref from sake_j, sakagura_j where sake_j.sakagura_id=sakagura_j.id and sake_category like '%42' limit 0, 12";
        $result1 = executequery($db, $sql);

        while($row = getnextrow($result1))
        {
            print('<a class="sec3-card" href="sake_view.php?sake_id=' .$row["sake_id"]. '">');
              print('<div class="sec3-image-container">');

                // 日本酒に写真があるか検索し、一枚だけ取り出す
                $result2 = executequery($db, "select filename from sake_image where sake_id = '" .$row["sake_id"] ."' LIMIT 1");
                $rd = getnextrow($result2);

                if($rd)
                {
                    // 写真がない
                    print('<div style="background-image: url(http://cgi.sakenomu.com/sake/images/' .$rd[filename] .');" class="sec3-image"></div>');
                }
                else
                {
                    // 写真がないので代わりの写真を使う
                    print('<div style="background-image: url(&#39;image/image_noimage.svg&#39;);" class="sec3-image"></div>');
                }

              print('</div>');
              print('<div class="sec3-sakename-container"><span>'  .$row["sake_name"] .'</span></div>');
              print('<div class="sec3-breweryname-container"><span>' .$row["sakagura_name"] .' / ' .$row["pref"] .'</span></div>');
            print('</a>');
        }

        ?>


      </div>
    </div>

    <!--非表示中<div id="sec4">
      <div class="sec4-content">
        <div class="sec4-button">
          <a href=""><p>もっと見る</p></a>
        </div>
      </div>
    </div>-->

  </div>

  <?php
  writefooter();
  ?>

</body>
<script type="text/javascript">

jQuery(document).ready(function($) {

  $("body").wrapInner('<div id="wrapper"></div>');
  $("body").fadeIn(400);
});

</script>
</html>
