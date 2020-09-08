<?php

function write_portal_menu()
{
      print('<!--<div id="home_menu" name="search_menu">');
        print('<div>');
          print('<div>');
              print('<span></span>');
              print('<span></span>');
              print('<span></span>');
          print('</div>');
          print('<div>');
              print('<span></span>');
              print('<span></span>');
              print('<span></span>');
          print('</div>');
          print('<div>');
              print('<span></span>');
              print('<span></span>');
              print('<span></span>');
          print('</div>');
        print('</div>');

        print('<div id="service_sidebar">');
          print('<span><img src="images/icons/cross.svg"></span>');
          print('<div>サービス一覧</div>');
          print('<div class="service_listing">');

            print('<div class="menu_item">');
              print('<span><img src="images/icons/knowsake.svg"></span>');
              print('<span>日本酒を知る</span>');

              print('<div class="sub_menu">');
                print('<div>');
                  print('<span>日本酒を知る</span>');
                print('</div>');
                print('<div class="sub_listing">');
                  print('<div><span>日本酒とは何ですか?</span></div>');
                  print('<div><span>日本用語辞典</span></div>');
                print('</div>');
              print('</div>');
            print('</div>');

            print('<div class="menu_item">');
              print('<span><img src="images/icons/sakeicon.svg"></span>');
              print('<span>日本酒を探す</span>');

              print('<div class="sub_menu">');
                print('<div><span>日本酒を探す</span></div>');
                  print('<div class="sub_listing">');
                    print('<div><span value="34">純米大吟醸酒</span></div>');
                    print('<div><span value="33">純米吟醸酒</span></div>');
                    print('<div><span value="44">大吟醸酒</span></div>');
                    print('<div><span value="32">特別純米酒</span></div>');
                    print('<div><span value="100">山田錦</span></div>');
                    print('<div><span value="103">五百万石</span></div>');
                    print('<div><span value="102">雄町</span></div>');
                    print('<div><span value="101">美山錦</span></div>');
                    print('<div><span value="104">愛山</span></div>');
                    print('<div><span value="11">無濾過生原酒</span></div>');
                    print('<div><span value="33">生酒</span></div>');
                    print('<div><span value="50">新酒</span></div>');
                    print('<div><span value="51">スパークリング</span></div>');
                    print('<div><span value="53">ランキング</span></div>');
                  print('</div>');
                print('</div>');

              print('</div>');

            print('<div class="menu_item">');
              print('<span><img src="images/icons/sakagura.svg"></span>');
              print('<span>酒蔵を探す</span>');

              print('<div class="sub_menu">');
                print('<div><span>酒蔵を探す</span></div>');
                print('<div class="sub_listing">');
                  print('<div><span value="touhoku">北海道・東北</span></div>');
                  print('<div><span value="kantou">関東</span></div>');
                  print('<div><span value="chubu">中部</span></div>');
                  print('<div><span value="kansai">関西</span></div>');
                  print('<div><span value="chugoku">中国・四国</span></div>');
                  print('<div><span value="kyusyu">九州・沖縄</span></div>');
                print('</div>');
              print('</div>');
            print('</div>');

            print('<div class="menu_item">');
              print('<span><img src="images/icons/restaurant.svg"></span>');
              print('<span>飲食店を探す</span>');

              print('<div class="sub_menu">');
                print('<div><span>飲食店を探す</span></div>');
                print('<div class="sub_listing">');
                  print('<div><span>北海道・東北</span></div>');
                  print('<div><span>関東</span></div>');
                  print('<div><span>中部</span></div>');
                  print('<div><span>関西</span></div>');
                  print('<div><span>中国・四国</span></div>');
                  print('<div><span>九州・沖縄</span></div>');
                print('</div>');
              print('</div>');
            print('</div>');

            print('<div class="menu_item">');
              print('<span><img src="images/icons/syuhanten.svg"></span>');
              print('<span>酒販店を探す</span>');

              print('<div class="sub_menu">');
                print('<div><span>酒販店を探す</span></div>');
                print('<div class="sub_listing">');
                  print('<div><span>北海道・東北</span></div>');
                  print('<div><span>関東</span></div>');
                  print('<div><span>中部</span></div>');
                  print('<div><span>関西</span></div>');
                  print('<div><span>中国・四国</span></div>');
                  print('<div><span>九州・沖縄</span></div>');
                print('</div>');
              print('</div>');
            print('</div>');

            print('<div class="menu_item">');
              print('<span><img src="images/icons/reviewer.svg"></span>');
              print('<span>レビュアーを探す</span>');

              print('<div class="sub_menu">');
                print('<div><span>レビュアーを探す</span></div>');
                print('<div class="sub_listing">');
                  print('<div><span>レビュー数ランキング</span></div>');
                  print('<div><span>アクセス数ランキング</span></div>');
                print('</div>');
              print('</div>');
            print('</div>');

            print('<div class="menu_item">');
              print('<span><img src="images/icons/notify.svg"></span>');
              print('<span>お知らせ・特集を見る</span>');

              print('<div class="sub_menu">');
                print('<div><span>お知らせ・特集を見る</span></div>');
                print('<div class="sub_listing">');
                  print('<div><span>Sakenomoからのお知らせ</span></div>');
                  print('<div><span>Sakenomo特集</span></div>');
                print('</div>');
              print('</div>');

            print('</div>');
          print('</div>');
        print('</div>');
      print('</div>-->');
}
