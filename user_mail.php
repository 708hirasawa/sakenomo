<?php

function write_manage_mail()
{
	print('<!-- send mail -->');
	print('<div id="dialog_message">');
	  print('<div>メッセージ</div>');
	  print('<span><button id="close_dialog_message"><img src="images/icons/cross.svg"></button></span>');

	  print('<div id="message_tabs">');
		print('<ul>');
			print('<li><a href="#tab_sendmail">メールを送る</a></li>');
			print('<li><a href="#tab_received">受信トレイ</a></li>');
			print('<li><a href="#tab_sent">送信トレイ</a></li>');
		print('</ul>');

		print('<div id="tab_sendmail">');
			print('<div id="tab_sendmail_container">');
			print('<center>');
				print('<div>');
					print('<div>');
						print('<span>ユーザー名</span>');
						print('<span><input id="mail_user" value="" placeholder="ユーザー名を入力してください"></span>');
					print('</div>');
					print('<div>');
						print('<span>題名</span>');
						print('<span><input id="mail_subject" value="" placeholder="題名を入力してください"></span>');
					print('</div>');
					print('<div>');
						print('<span>メッセージ</span>');
						print('<span><textarea id="mail_message" placeholder="コメントを入力してください"></textarea></span>');
					print('</div>');
				print('</div>');
			print('</center>');
			print('</div>');
		print('</div>');

		print('<div id="tab_received" class="form-action hide">');
		  print('<div id="tab_received_container">メールを表示する</div>');
		  print('<table id="message_table" class="customers" border="1" cellspacing="0">');
			print('<tr>');
			  print('<td>差出人</td>');
			  print('<td>着信タイム</td>');
			  print('<td>題名</td>');
			  print('<td>メッセージ</td>');
			print('</tr>');
		  print('</table>');
		print('</div>');

		print('<div id="tab_sent" class="form-action hide">');
		  print('<table class="customers" border="1" cellspacing="0">');
		  print('</table>');
		print('</div>');
	  print('</div> <!-- tabs -->');
	  print('<center><input type="button" id="message_dialog_close" value="閉じる"></center>');
	print('</div>');

	print('<!-- dialog_background -->');
	print('<!--<div id="dialog_background"></div>-->');
}

?>