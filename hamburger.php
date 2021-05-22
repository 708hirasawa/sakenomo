<?php

function write_HamburgerLogo()
{
  print('<div class="overlay">');
    print('<button type="button" class="hamburger is-closed animated fadeInLeft" data-toggle="offcanvas">');
      print('<span class="hamb-top"></span>');
      print('<span class="hamb-middle"></span>');
      print('<span class="hamb-bottom"></span>');
    print('</button>');
  print('</div>');
}

function write_side_menu()
{
	$username = $_COOKIE['login_cookie'];
	$nickname = $_COOKIE['nickname'];
	$path = $_COOKIE['user_profile_image'];

  print('<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">');
    print('<ul class="sidebar-nav">');
      print('<li class="sidebar-brand">');
        print('<div class="sidebar-user">');

          print('<div class="user-img-container">');
            if($path) {
              print('<img src="' .$path .'">');
            } else {
              print('<img src="images/icons/noimage_user30.svg">');
            }
          print('</div>');
          if($nickname) {
            print('<span>'.$nickname.'</span>');
          } else {
            print('<span style="color: #8c8c8c">Not logged in</span>');
          }
        print('</div>');
      print('</li>');

      if($username == "" || $username == null) {
        print('<li class="sidebar-item">');
          print('<a href="user_login_form.php" class="fa fa-fw fa-login"><div class="img-container"><svg class="mobile_login2020"><use xlink:href="#login2020"/></svg></div><span>ログイン</span>');
          print('</a>');
        print('</li>');
      } else {
        print('<li class="sidebar-item">');
          print('<a href="user_view.php?username=' .$username .'" class="fa fa-fw fa-mypage"><div class="img-container"><svg class="mobile_person2020"><use xlink:href="#person2020"/></svg></div><span>マイページ</span>');
          print('</a>');
        print('</li>');

        print('<li class="sidebar-item" id="side_logout">');
          print('<a href="#" class="fa fa-fw fa-addsake"><div class="img-container"><svg class="mobile_logout2020"><use xlink:href="#logout2020"/></svg></div><span>ログアウト</span>');
          print('</a>');
        print('</li>');
      }

      /*print('<li class="sidebar-item">');
        print('<a href="#" class="fa fa-fw fa-folder"><div class="img-container"><svg class="mobile_bell2020"><use xlink:href="#bell2020"/></svg></div><span>お知らせ</span>');
        print('</a>');
      print('</li>');
      print('<li class="sidebar-item">');
        print('<a href="#" class="fa fa-fw fa-folder"><div class="img-container"><svg class="mobile_mail2620"><use xlink:href="#mail2620"/></svg></div><span>メッセージ</span>');
        print('</a>');
      print('</li>');*/
      print('<li class="sidebar-item">');
        print('<a href="about_sakenomo.php"><span class="about_sakenomo_text">Sakenomoについて</span>');
        print('</a>');
      print('</li>');
    print('</ul>');
  print('</nav>');
}
?>
