<?php

function write_Nonda()
{
	print('<div id="dialog_background">');
	  print('<div class="dialog_table">');
		print('<div class="dialog_table-cell">');
		  print('<div id="dialog_bbs" value="" write_date="">');
			print('<div class="dialog_bbs_title_close_container">');
			  print('<div class="dialog_bbs_title_blanc"></div>');
			  print('<div class="dialog_bbs_title">「飲んだ」登録</div>');
			  print('<span class="close_bbs_button_container">');
				print('<button id="close_bbs_button"><svg class="close_bbs_close2020"><use xlink:href="#close2020"/></svg></button>');
			  print('</span>');
			print('</div>');

			print('<!--<div class="nonda_meigara">-->');
			print('<div class="nonda_sake_title_container">');
			  print('<input id="add_nonda_sake" type="text" autocomplete="off" name="add_nonda_sake" disabled>');
			print('</div>');

			print('<div id="tab_bbs_container">');
			  print('<ul class="nondaTabs">');
				print('<li class="nondaTabs_click">');
				  print('<a class="active" href="#tabs-1">');
					print('<svg class="nondaTabs_review3630"><use xlink:href="#review3630"/></svg>');
					print('<span>レビュー</span>');
				  print('</a>');
				print('</li>');
				print('<li class="nondaTabs_click">');
				  print('<a href="#tabs-2">');
					print('<svg class="nondaTabs_camera3630"><use xlink:href="#camera3630"/></svg>');
					print('<span>写真</span>');
				  print('</a>');
				print('</li>');
				print('<li class="nondaTabs_click">');
				  print('<a href="#tabs-3">');
					print('<svg class="nondaTabs_note3630"><use xlink:href="#note3630"/></svg>');
					print('<span>テイスティングノート</span>');
				  print('</a>');
				print('</li>');
			  print('</ul>');

			  print('<div id="tabs-1" class="form-action show">');
				print('<div class="star_container">');
				  print('<div class="star_rate">');
					print('<div class="satisfaction_title">満足度</div>');
					print('<form type="get" action="#" class="rating-box">');
					  print('<div id="rateYo"></div>');
					  print('<input class="rating-input" step="0.5" readonly>');
					print('</form>');

				  print('</div>');
				  print('<div class="star_delete">');
					print('<div class="star_delete_button"><svg class="nonda_tabs_delete1616"><use xlink:href="#delete1616"/></svg>満足度を削除</div>');
				  print('</div>');
				print('</div>');

				print('<div class="review_article_container">');
				  print('<div class="review_article_title">');
					print('<input id="custom_dialog_input_argument" name="review_title" class="inputform" value="" placeholder="レビュータイトルを入力">');
				  print('</div>');
				  print('<div class="review_article_text">');
					print('<textarea id="custom_dialog_input_message" name="review_message" class="inputform" placeholder="レビュー本文を入力"></textarea>');
				  print('</div>');
				  print('<div class="review_article_delete">');
					print('<div class="review_article_delete_button"><svg class="nonda_tabs_delete1616"><use xlink:href="#delete1616"/></svg>レビューを削除</div>');
				  print('</div>');
				print('</div>');
			  print('</div>');

				print('<div id="tabs-2" class="form-action hide">');

					print('<div id="nonda_image">');

						print('<div path="" id="nonda_image_post">');
							print('<span class="nonda_image_post_button_container">');
								print('<input type="file" name="files[]" multiple >');
								print('<input type="button" class="change_pic" value="写真の追加">');
							print('</span>');
						print('</div>');

						/*print('<div class="bbs_photo_container"><div class="photo_container"></div></div>');*/
					print('</div>'); // nonda_image

				print('</div>');

			  print('<div id="tabs-3" class="form-action hide">');
				print('<div id="nonda_tastingnote_container">');
				  print('<!--<div class="graph">-->');
					print('<div class="flavor_box_container">');
					  print('<div class="flavor_box">');
						print('<div class="nonda_tastingitem_title"><span class="nonda_tastingitem_icon"><svg class="nonda_tastingitem_flavor3630"><use xlink:href="#flavor3630"/></svg></span>フレーバー</div>');
						print('<div class="nonda_flavor_list">');
						  print('<div><span>1</span><p></p></div>');
						  print('<div><span>2</span><p></p></div>');
						print('</div>');
						print('<div class="nonda_flavor_list_note">2つまで選択可</div>');
					  print('</div>');

					  print('<div class="nonda_flavor_category">');
						print('<div id="nonda_flavor_type_name">');
						  print('<span class="nonda_flavor_type_title">フルーティタイプ</span>');
						  print('<p class="plus_minus_icon"><span></span><span></span></p>');
						print('</div>');
						print('<div class="nonda_flavor_item_container">');
						  print('<label><input type="checkbox" name="flavor[]" value="10" data-img="greenapple4040">青りんご</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="11" data-img="strawberry4040">いちご</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="12" data-img="orange4040">オレンジ</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="41" data-img="kiwi4040">キウイ</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="13" data-img="grapefruit4040">グレープフルーツ</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="43" data-img="watermelon4040">スイカ</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="14" data-img="nashi4040">梨</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="15" data-img="pineapple4040">パイナップル</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="16" data-img="banana4040">バナナ</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="42" data-img="grape4040">ぶどう</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="17" data-img="muscat4040">マスカット</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="18" data-img="mango4040">マンゴー</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="19" data-img="melon4040">メロン</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="20" data-img="peach4040">桃</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="21" data-img="pear4040">洋梨</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="22" data-img="lychee4040">ライチ</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="23" data-img="apple4040">りんご</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="24" data-img="lemon4040">レモン</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="25" data-img="flower4040">花</label>');
						print('</div>');

						print('<div id="nonda_flavor_type_name">');
						  print('<span class="nonda_flavor_type_title">スッキリタイプ</span>');
						  print('<p class="plus_minus_icon"><span></span><span></span></p>');
						print('</div>');
						print('<div class="nonda_flavor_item_container">');
						  print('<label><input type="checkbox" name="flavor[]" value="26" data-img="mineralwater4040">天然水・ミネラル</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="27" data-img="soda4040">ソーダ・ラムネ</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="28" data-img="herb4040">ハーブ・若草・根菜</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="29" data-img="tree4040">木</label>');
						print('</div>');

						print('<div id="nonda_flavor_type_name">');
						  print('<span class="nonda_flavor_type_title">コクタイプ</span>');
						  print('<p class="plus_minus_icon"><span></span><span></span></p>');
						print('</div>');
						print('<div class="nonda_flavor_item_container">');
						  print('<label><input type="checkbox" name="flavor[]" value="30" data-img="rice4040">ご飯・餅</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="31" data-img="nuts4040">ナッツ・豆</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="32" data-img="butter4040">バター・クリーム・バニラ・チーズ</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="33" data-img="driedfruit4040">ドライフルーツ・乾物</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="34" data-img="soysauce4040">しょうゆ・みりん</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="35" data-img="spice4040">スパイス</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="36" data-img="caramel4040">カラメル</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="37" data-img="cacao4040">カカオ・ビターチョコ</label>');
						print('</div>');

						print('<div id="nonda_flavor_type_name">');
						  print('<span class="nonda_flavor_type_title">その他のタイプ</span>');
						  print('<p class="plus_minus_icon"><span></span><span></span></p>');
						print('</div>');
						print('<div class="nonda_flavor_item_container">');
						  print('<label><input type="checkbox" name="flavor[]" value="38" data-img="cemedine4040">セメダイン</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="39" data-img="yogurt4040">ヨーグルト</label>');
						  print('<label><input type="checkbox" name="flavor[]" value="40" data-img="other4040">その他</label>');
						print('</div>');

						/*
						<!--<div><input type="checkbox" name="flavor[]" value="1"><img src="images/icons/fruits.svg">フルーツ系</div>
						<div><input type="checkbox" name="flavor[]" value="2"><img src="images/icons/herb.svg">ハーブ・草葉系</div>
						<div><input type="checkbox" name="flavor[]" value="3"><img src="images/icons/tree.svg">木系</div>
						<div><input type="checkbox" name="flavor[]" value="4"><img src="images/icons/plain.svg">プレーン系</div>
						<div><input type="checkbox" name="flavor[]" value="5"><img src="images/icons/gohan.svg">米・穀物系</div>
						<div><input type="checkbox" name="flavor[]" value="6"><img src="images/icons/nuts.svg">ナッツ・木の実系</div>
						<div><input type="checkbox" name="flavor[]" value="7"><img src="images/icons/milk.svg">乳製品系</div>
						<div><input type="checkbox" name="flavor[]" value="8"><img src="images/icons/aging.svg">熟成系</div>
						<div><input type="checkbox" name="flavor[]" value="9"><img src="images/icons/others.svg">その他</div>-->
						*/
					  print('</div>');
					print('</div>');

					print('<div class="frame_box">');
					  print('<div class="nonda_tastingitem_title"><span class="nonda_tastingitem_icon"><svg class="nonda_tastingitem_aroma2430"><use xlink:href="#aroma2430"/></svg></span>香り</div>');
					  print('<div class="frame_bar_container">');
						print('<div class="input_range_container">');
						  print('<input type="range" name="aroma" step="0.5" min="0" max="5" value="0" class="input_range">');
						print('</div>');

						print('<div class="horizontal_bar_caption">');
						  print('<div>弱い</div>');
						  print('<div>強い</div>');
						print('</div>');
					  print('</div>');
					  print('<div class="tasting_score">--</div>');
					print('</div>');

					print('<div class="frame_box">');
					  print('<div class="nonda_tastingitem_title"><span class="nonda_tastingitem_icon"><svg class="nonda_tastingitem_body2430"><use xlink:href="#body2430"/></svg></span>ボディ</div>');
					  print('<div class="frame_bar_container">');
						print('<div class="input_range_container">');
						  print('<input type="range" name="body" step="0.5" min="0" max="5" value="0" class="input_range">');
						print('</div>');
						/*
						<!--<div class="frame_bar">
						  <div class="horizontal_bar"></div>
						</div>-->
						*/
						print('<div class="horizontal_bar_caption">');
						  print('<div>味が軽い・淡麗</div>');
						  print('<div>味が重い・濃醇</div>');
						print('</div>');
					  print('</div>');
					  print('<div class="tasting_score">--</div>');
					print('</div>');

					print('<div class="frame_box">');
					  print('<div class="nonda_tastingitem_title"><span class="nonda_tastingitem_icon"><svg class="nonda_tastingitem_clear3030"><use xlink:href="#clear3030"/></svg></span>クリア</div>');
					  print('<div class="frame_bar_container">');
						print('<div class="input_range_container">');
						  print('<input type="range" name="clear" step="0.5" min="0" max="5" value="0" class="input_range">');
						print('</div>');

						print('<div class="horizontal_bar_caption">');
						  print('<div>雑味がある</div>');
						  print('<div>味がきれい</div>');
						print('</div>');
					  print('</div>');
					  print('<div class="tasting_score">--</div>');
					print('</div>');

					print('<div class="frame_box">');
					  print('<div class="nonda_tastingitem_title"><span class="nonda_tastingitem_icon"><svg class="nonda_tastingitem_sweetness3030"><use xlink:href="#sweetness3030"/></svg></span>甘辛</div>');
					  print('<div class="frame_bar_container">');
						print('<div class="input_range_container">');
						  print('<input type="range" name="sweetness" step="0.5" min="0" max="5" value="0" class="input_range">');
						print('</div>');


						print('<div class="horizontal_bar_caption">');
						  print('<div>ドライ・辛口</div>');
						  print('<div>スイート・甘口</div>');
						print('</div>');
					  print('</div>');
					  print('<div class="tasting_score">--</div>');
					print('</div>');

					print('<div class="frame_box">');
					  print('<div class="nonda_tastingitem_title"><span class="nonda_tastingitem_icon"><svg class="nonda_tastingitem_umami3030"><use xlink:href="#umami3030"/></svg></span>旨味</div>');
					  print('<div class="frame_bar_container">');
						print('<div class="input_range_container">');
						  print('<input type="range" name="umami" step="0.5" min="0" max="5" value="0" class="input_range">');
						print('</div>');
						print('<div class="horizontal_bar_caption">');
						  print('<div>弱い</div>');
						  print('<div>強い</div>');
						print('</div>');
					  print('</div>');
					  print('<div class="tasting_score">--</div>');
					print('</div>');

					print('<div class="frame_box">');
					  print('<div class="nonda_tastingitem_title"><span class="nonda_tastingitem_icon"><svg class="nonda_tastingitem_acidity3030"><use xlink:href="#acidity3030"/></svg></span>酸味</div>');
					  print('<div class="frame_bar_container">');
						print('<div class="input_range_container">');
						  print('<input type="range" name="acidity" step="0.5" min="0" max="5" value="0" class="input_range">');
						print('</div>');
						print('<div class="horizontal_bar_caption">');
						  print('<div>弱い</div>');
						  print('<div>強い</div>');
						print('</div>');
					  print('</div>');
					  print('<div class="tasting_score">--</div>');
					print('</div>');

					print('<div class="frame_box">');
					  print('<div class="nonda_tastingitem_title"><span class="nonda_tastingitem_icon"><svg class="nonda_tastingitem_bitter2430"><use xlink:href="#bitter2430"/></svg></span>ビター</div>');
					  print('<div class="frame_bar_container">');
						print('<div class="input_range_container">');
						  print('<input type="range" name="bitter" step="0.5" min="0" max="5" value="0" class="input_range">');
						print('</div>');
						print('<div class="horizontal_bar_caption">');
						  print('<div>弱い</div>');
						  print('<div>強い</div>');
						print('</div>');
					  print('</div>');
					  print('<div class="tasting_score">--</div>');
					print('</div>');

					print('<div class="frame_box">');
					  print('<div class="nonda_tastingitem_title"><span class="nonda_tastingitem_icon"><svg class="nonda_tastingitem_yoin3030"><use xlink:href="#yoin3030"/></svg></span>余韻</div>');
					  print('<div class="frame_bar_container">');
						print('<div class="input_range_container">');
						  print('<input type="range" name="yoin" step="0.5" min="0" max="5" value="0" class="input_range">');
						print('</div>');

						print('<div class="horizontal_bar_caption">');
						  print('<div>長く続く</div>');
						  print('<div>キレが良い</div>');
						print('</div>');
					  print('</div>');
					  print('<div class="tasting_score">--</div>');
					print('</div>');

					print('<div class="nonda_tastingnote_delete">');
					  print('<div class="nonda_tastingnote_delete_button"><svg class="nonda_tabs_delete1616"><use xlink:href="#delete1616"/></svg>テイスティングノートを削除</div>');
					print('</div>');
				  //<!--</div>-->
				print('</div>');
			  print('</div>');

			  /*
			  <!--<div>
				<progress id="upload_progressBar" value="0" max="100"></progress>
				<div id="upload_status"></div>
				<div id="upload_n_total"></div>
			  </div>-->
			  */

			  print('<div class="tab_bbs_button_container">');
				print('<input type="button" id="dialog_bbs_ok" value="登録・更新">');
				print('<input type="button" id="dialog_bbs_draft" value="下書き保存">');
				print('<input type="button" id="dialog_bbs_delete" value="削除">');
			  print('</div>');
			print('</div>');
		  print('</div>');
		print('</div>');
	  print('</div>');
	print('</div>');
}

?>
