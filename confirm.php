<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
  </head>
  <body>
    <?php
      mb_language("Japanese");
      mb_internal_encoding("UTF-8");
      $to = $_POST['email'];
      $titie = "Sakenomo登録完了";
      $content = $_POST['user_password'];
 
     if(mb_send_mail($to, $title, $content)){
        echo "メールを送信しました";
      } else {
        echo "メールの送信に失敗しました:".$to ."です";
      };
    ?>
  </body>
</html>