$(function() {

	//日本酒メニューラジオボタン選択解除
	var nowchecked = $('.column2_checkradio input[name="inshokuten_sake_count"]:checked').val();
	$('.column2_checkradio input[name="inshokuten_sake_count"]').click(function() {
		if($(this).val() == nowchecked) {
			$(this).prop('checked', false);
			nowchecked = false;
		}
		else {
			nowchecked = $(this).val();
		}
	});

	//予約ラジオボタン選択解除
	var nowchecked = $('.column2_checkradio input[name="inshokuten_reservation"]:checked').val();
	$('.column2_checkradio input[name="inshokuten_reservation"]').click(function() {
		if($(this).val() == nowchecked) {
			$(this).prop('checked', false);
			nowchecked = false;
		}
		else {
			nowchecked = $(this).val();
		}
	});

	//駐車場ラジオボタン選択解除
	var nowchecked = $('.column2_checkradio input[name="inshokuten_parking"]:checked').val();
	$('.column2_checkradio input[name="inshokuten_parking"]').click(function() {
		if($(this).val() == nowchecked) {
			$(this).prop('checked', false);
			nowchecked = false;
		}
		else {
			nowchecked = $(this).val();
		}
	});

	//飲食店編集ページ確認モーダルウィンドウ
	$('input[name="confirm_inshokuten"]').click(function() {

		//確認用モーダルにデータを与える
		var message = [];

		if($('input[name="inshokuten_name"]').val() == "") {
			message.push("店名を入力してください");
		}

		if($('input[name="inshokuten_read"]').val() == "") {
			message.push("ひらがなを入力してください");
		}

		if($('input[name="inshokuten_english"]').val() == "") {
			message.push("ローマ字を入力してください");
		}

		if(message != "") {
			alert(message.join(" / "));
		} else {
			$('.dialog_inshokuten_name').text($('input[name="inshokuten_name"]').val());
			$('.dialog_inshokuten_read').text($('input[name="inshokuten_read"]').val());
			$('.dialog_inshokuten_english').text($('input[name="inshokuten_english"]').val());
			$('.dialog_inshokuten_postalcode').text($('input[name="inshokuten_postalcode"]').val());
			$('.dialog_inshokuten_pref').text($('SELECT[name="inshokuten_pref"]').val());
			$('.dialog_inshokuten_address').text($('input[name="inshokuten_address"]').val());
			$('.dialog_inshokuten_address2').text($('input[name="inshokuten_address2"]').val());
			$('.dialog_inshokuten_phone').text($('input[name="inshokuten_phone"]').val());
			$('.dialog_inshokuten_email').text($('input[name="inshokuten_email"]').val());
			$('.dialog_inshokuten_station_optional').text($('textarea[name="inshokuten_station_optional"]').val());
			$('.dialog_inshokuten_hours').text($('textarea[name="inshokuten_hours"]').val());
			$('.dialog_inshokuten_holiday').text($('input[name="inshokuten_holiday"]').val());
			//////////
			$('.dialog_inshokuten_main_genre').text($('SELECT[name="inshokuten_main_genre"]').val());
			$('.dialog_inshokuten_sub_genre').text($('SELECT[name="inshokuten_sub_genre"]').val());
			$('.dialog_inshokuten_sub_genre2').text($('SELECT[name="inshokuten_sub_genre2"]').val());
			//////////
			var inshokuten_sake_count_innertext = $('input[name="inshokuten_sake_count"]:checked').parent().text();
			$(".dialog_inshokuten_sake_count").text(inshokuten_sake_count_innertext);
			//////////
			var inshokuten_store_style_innertext = $('input[name="inshokuten_store_style[]"]:checked').map(function(){
				return $(this).parent().text();
			}).get();
			$(".dialog_inshokuten_store_style").text(inshokuten_store_style_innertext.join(" / "));
			//////////
			$('.dialog_inshokuten_budget').text($('SELECT[name="inshokuten_budget"]').val());
			//////////
			var inshokuten_reservation_innertext = $('input[name="inshokuten_reservation"]:checked').parent().text();
			$(".dialog_inshokuten_reservation").text(inshokuten_reservation_innertext);
			//////////
			var inshokuten_payment_innertext = $('input[name="inshokuten_payment[]"]:checked').map(function(){
				return $(this).parent().text();
			}).get();
			$(".dialog_inshokuten_payment").text(inshokuten_payment_innertext.join(" / "));
			//////////
			$('.dialog_inshokuten_payment2').text($('input[name="inshokuten_payment_optional"]').val());
			$('.dialog_inshokuten_seats').text($('input[name="inshokuten_seats"]').val());
			//////////
			var inshokuten_parking_innertext = $('input[name="inshokuten_parking"]:checked').parent().text();
			$(".dialog_inshokuten_parking").text(inshokuten_parking_innertext);
			//////////
			$('.dialog_inshokuten_parking2').text($('input[name="inshokuten_parking_optional"]').val());
			//////////
			var inshokuten_url_innertext = $('input[name="inshokuten_url[]"]').map(function(){
				return $(this).val();
			}).get();
			$(".dialog_inshokuten_url").text(inshokuten_url_innertext.join(" / "));
			//////////
			$('.dialog_inshokuten_opened_date').text($('input[name="inshokuten_opened_date"]').val());
			$('.dialog_inshokuten_remarks').text($('textarea[name="inshokuten_remarks"]').val());
		}

		//飲食店編集ページ確認モーダルウィンドウ表示
		var touch_start_y;
		// タッチしたとき開始位置を保存しておく
		$(window).on('touchstart', function(event) {
			touch_start_y = event.originalEvent.changedTouches[0].screenY;
		});
		// スワイプしているとき
		$(window).on('touchmove.noscroll', function(event) {
			var current_y = event.originalEvent.changedTouches[0].screenY,
			height = $('.dialog_add_inshokuten_background').outerHeight(),
			is_top = touch_start_y <= current_y && $('.dialog_add_inshokuten_background')[0].scrollTop === 0,
			is_bottom = touch_start_y >= current_y && $('.dialog_add_inshokuten_background')[0].scrollHeight - $('.dialog_add_inshokuten_background')[0].scrollTop === height;

			// スクロール対応モーダルの上端または下端のとき
			if (is_top || is_bottom) {
				// スクロール禁止
				event.preventDefault();
			}
		});

		// スクロール禁止
		$('html, body').css('overflow', 'hidden');
		$(".dialog_add_inshokuten_background").css({"display":"flex"});
	});

	$('input[name="button_back"], input[name="submit_button"]').click(function() {
		// イベントを削除
		$(window).off('touchmove.noscroll');
		$('html, body').css('overflow', '');
		$(".dialog_add_inshokuten_background").css({"display":"none"});
	});






	$('#edit_inshokuten_close').click(function() {
		$("body").trigger( "edit_inshokuten_close", [ this ] );
	});

	$('#edit_inshokuten_delete').click(function() {
		var data = "inshokuten_id=" + $('.inshokuten_container').data('inshokuten_id');

		$.ajax({
			type: "POST",
			url: "cgi/inshokuten_delete.php",
			data: data,
		}).done(function(xml) {
			var str = $(xml).find("str").text();

			if(str != "success")
			{
				var str = $(xml).find("sql").text();
				alert("success:" + str);
			}

		}).fail(function(data) {
			alert("Failed:" + data);
		}).complete(function(data) {
			; //removeLoading();
		});
	});

	$("body").on( "open_edit_inshokuten", function( event, inshokuten_id, inshokuten_name) {

		var data = "search_category=6&in_disp_from=0&inshokuten_id=" + inshokuten_id;
		//alert("open_edit_sakagura:" + sakagura_name);

		$('.inshokuten_container').data('inshokuten_id', inshokuten_id);

		//alert("open_edit_sake:data:" + data);
		//dispLoading("処理中...");

		$.ajax({
			type: "POST",
			url: "cgi/complex_search.php",
			data: data,
			dataType: 'json',
		}).done(function(data) {

			//alert("success");
			var inshokuten = data[0].result;
			//alert("sakagura_english:" + sakagura[0].sakagura_english);
			//alert("establishment:" + $('input[name="establishment"]').val());

			$('input[name="inshokuten_name"]').val(inshokuten_name);
			$('input[name="inshokuten_read"]').val(inshokuten[0].inshokuten_read);
			$('input[name="inshokuten_english"]').val(inshokuten[0].inshokuten_english);
			$('input[name="inshokuten_postal_code"]').val(inshokuten[0].inshokuten_postal_code);




			/*$('input[name="pref"]').val(sakagura[0].pref);
			$('input[name="address"]').val(sakagura[0].address);
			$('input[name="phone"]').val(sakagura[0].phone);
			$('input[name="representative"]').val(sakagura[0].representative);
			$('input[name="touji"]').val(sakagura[0].touji);
			$('input[name="email"]').val(sakagura[0].email);
			$('input[name="observation"]').val(sakagura[0].observation);
			$('input[name="direct_sale"]').val(sakagura[0].direct_sale);
			$('input[name="brand"]').val(sakagura[0].brand);

			$('select[name="pref"] option').each(function(){
				if(this.value == sakagura[0].pref) {
					$('select[name="pref"]').val(sakagura[0].pref);
					return false;
				}
			});

			$('select[name="establishment"] option').each(function() {
				if(this.value == sakagura[0].establishment) {
					$('select[name="establishment"]').val(sakagura[0].establishment);
					return false;
				}
			});

			$('select[name="observation"] option').each(function() {
				if(this.value == sakagura[0].observation) {
					$('select[name="observation"]').val(sakagura[0].observation);
					return false;
				}
			});

			$('select[name="direct_sale"] option').each(function() {
				if(this.value == sakagura[0].direct_sale) {
					$('select[name="direct_sale"]').val(sakagura[0].direct_sale);
					return false;
				}
			});

			$('input[name="url"]').val(sakagura[0].url);
			if(sakagura[0].url && sakagura[0].url != "") {
				var url_array = sakagura[0].url.split(',');
				var i = 0;
				$('input[name="url[]"]').each(function() {
					if(i < url_array.length) {
						$(this).val(url_array[i]);
					}
					i++
				});
			}*/
		}).fail(function(data){
			alert("Failed:" + data);
		}).complete(function(data){
			; //removeLoading();
		});
	});
});
