<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta content='width=device-width, initial-scale=1' name='viewport'/>
    <title>Sakenomo</title>
    <link rel="stylesheet" type="text/css" href="css/common.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
    <link rel="stylesheet" type="text/css" href="css/mail_registry.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
  </head>

  <body>
    <?php
      include_once('images/icons/svg_sprite.svg');
      mb_language("Japanese");
      mb_internal_encoding("UTF-8");
      $to = $_POST['email'];
      $password = $_POST['user_password'];
      $title = "Sakenomo会員登録のご案内";
      $content = "Sakenomoに仮登録いただき誠にありがとうございます。\r\nまだ登録は完了しておりません。お手数ですが、以下のURLをクリックして本登録の手続きを行ってください。\r\n\r\n http://sakenomo.xsrv.jp/sakenomo/add_user.php?email=".$to ."&password=".$password ."\r\n\r\n※上記のURLの有効期限は24時間となります。期限をすぎてしまった場合は、再び登録手続きを行ってください。\r\n※このメールはご入力いただいたメールアドレスに自動で送信されています。送信専用のメールアドレスのため、こちらではご返信メールを受け付けることができません。ご了承ください。\r\n※本メールにお心当たりがない場合は、恐れ入りますが、破棄してくださいますようお願い申し上げます。";

      print('<div id="container">');
        print('<div id="registry_user_container">');
          if(mb_send_mail($to, $title, $content)){
            print('<div class="mail_registry_message">メールを送信しました。メール本文のURLをクリックし、本登録手続きを行ってください。</div>');
          } else {
            print('<div class="mail_registry_message">メールを送信できませんでした。ご入力いただいたメールアドレスに間違いがないかご確認ください。</div>');
          };
          print('<svg class="logoheartgray14024"><use xlink:href="#logoheartgray14024"/></svg>');
        print('</div>');
      print('</div>');
    ?>
  </body>
</html>
