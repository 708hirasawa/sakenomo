<?php

function write_manage_mail()
{
	print('<!-- send mail -->');
	print('<div id="dialog_message">');
	  print('<div>���b�Z�[�W</div>');
	  print('<span><button id="close_dialog_message"><img src="images/icons/cross.svg"></button></span>');

	  print('<div id="message_tabs">');
		print('<ul>');
			print('<li><a href="#tab_sendmail">���[���𑗂�</a></li>');
			print('<li><a href="#tab_received">��M�g���C</a></li>');
			print('<li><a href="#tab_sent">���M�g���C</a></li>');
		print('</ul>');

		print('<div id="tab_sendmail">');
			print('<div id="tab_sendmail_container">');
			print('<center>');
				print('<div>');
					print('<div>');
						print('<span>���[�U�[��</span>');
						print('<span><input id="mail_user" value="" placeholder="���[�U�[������͂��Ă�������"></span>');
					print('</div>');
					print('<div>');
						print('<span>�薼</span>');
						print('<span><input id="mail_subject" value="" placeholder="�薼����͂��Ă�������"></span>');
					print('</div>');
					print('<div>');
						print('<span>���b�Z�[�W</span>');
						print('<span><textarea id="mail_message" placeholder="�R�����g����͂��Ă�������"></textarea></span>');
					print('</div>');
				print('</div>');
			print('</center>');
			print('</div>');
		print('</div>');

		print('<div id="tab_received" class="form-action hide">');
		  print('<div id="tab_received_container">���[����\������</div>');
		  print('<table id="message_table" class="customers" border="1" cellspacing="0">');
			print('<tr>');
			  print('<td>���o�l</td>');
			  print('<td>���M�^�C��</td>');
			  print('<td>�薼</td>');
			  print('<td>���b�Z�[�W</td>');
			print('</tr>');
		  print('</table>');
		print('</div>');

		print('<div id="tab_sent" class="form-action hide">');
		  print('<table class="customers" border="1" cellspacing="0">');
		  print('</table>');
		print('</div>');
	  print('</div> <!-- tabs -->');
	  print('<center><input type="button" id="message_dialog_close" value="����"></center>');
	print('</div>');

	print('<!-- dialog_background -->');
	print('<!--<div id="dialog_background"></div>-->');
}

?>