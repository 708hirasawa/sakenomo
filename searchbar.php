<?php

function write_search_bar()
{
	$keyword = $_GET['keyword'];
	$category = $_GET['category'] ? $_GET['category'] : 1;

  print('<nav class="header">');
    print('<div class="logo_navi_container">');
      print('<button type="button" class="hamburger is-closed animated fadeInLeft" data-toggle="offcanvas">');
        print('<span class="hamb-top"></span>');
        print('<span class="hamb-middle"></span>');
        print('<span class="hamb-bottom"></span>');
      print('</button>');

      print('<span id="logo">');
        print('<svg class="logoheart14024"><use xlink:href="#logoheart14024"/></svg>');
      print('</span>');

      print('<div class="mobile_search_container"></div>');

      print('<ul id="navigation_menu">');
        print('<li id="about_sakenomo">');
          print('<span>Sakenomoについて</span>');
        print('</li>');
        /*print('<<li id="user_message">');
          print('<svg class="header_mail2620"><use xlink:href="#mail2620"/></svg>');
          print('<span>メッセージ</span>');
        print('</li>');*/

        $username = $_COOKIE['login_cookie'];

        if($username == "" || $username == null)
        {
          print('<li class="login_button_container">');
            print('<span id="login">');
              print('<svg class="header_login2020"><use xlink:href="#login2020"/></svg>');
              print('<span>ログイン</span>');
            print('</span>');
          print('</li>');
        }
        else
        {
          print('<li id="mypage_button_container">');
            print('<span id="mypage">');
              print('<svg class="header_person2020"><use xlink:href="#person2020"/></svg>');
              print('<span>マイページ</span>');
            print('</span>');
            print('<p class="header_arrow_icon"><span></span></p>');
            print('<div id="mypage_content">');
              print('<p id="logout">ログアウト</p>');
            print('</div>');
          print('</li>');
        }

      print('</ul>');
    print('</div>');

    print('<div class="searchbar_container">');
      print('<div id="searchbar">');

        print('<div id="category_menu">');
          print('<div id="category_menu_trigger">');
            print('<span>すべて</span>');
          print('</div>');

          print('<div id="search_content_position_adjust">');
            print('<div id="search_content">');
              print('<div id="close_main_menu" class="search_content_close"><svg class="category_close2020"><use xlink:href="#close2020"/></svg></div>');
              print('<div class="search_content_title">検索カテゴリ</div>');
              print('<ul class="menu">');
                print('<li value="すべて">すべて</li>');
                print('<li value="日本酒">日本酒</li>');
                print('<li value="酒蔵">酒蔵</li>');
                //print('<li value="酒販店">酒販店（日本酒を買えるお店）</li>');
              print('</ul>');
            print('</div>');
          print('</div>');
        print('</div>');

        print('<div class="border_line_invisible"></div>');

        print('<div id="sake" class="form-action show">');
          print('<form id="sake_form" name="form">');
            print('<input type="hidden" name="category" value=' .$category .'>');

            print('<div class="search_button_container">');
              print('<button id="sake_submit_search">');
                print('<svg class="header_search2020"><use xlink:href="#search2020"/></svg>');
              print('</button>');
            print('</div>');

            print('<div class="input_item">');
              print('<input id="sake_input" class="all_mode" autocomplete="off" placeholder="日本酒、酒蔵を検索" type="text" name="keyword" value ="' .$keyword .'">');
              print('<ul id="sake_content"></ul>');
            print('</div>');

          print('</form>');
        print('</div>');
      print('</div>');
    print('</div>');
  print('</nav>');
}

?>
