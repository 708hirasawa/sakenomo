function getAwardOption(award)
{
	if(award == 1)
	{
			var options = [
				{ text: "賞",		value: 0 },
				{ text: "金賞", value: 1 },
				{ text: "入賞", value: 2 }
			];

			//$("#dialog_sake_award1").replaceOptions(options);
			return options;
	}
	else if(award == 2)
	{
			var options = [
				{ text: "賞",					value: 0 },
				{ text: "トロフィー", value: 1 },
				{ text: "金賞",				value: 2 },
				{ text: "銀賞",				value: 3 },
				{ text: "銅賞",				value: 4 }
			];

			return options;
	}
	else if(award == 3)
	{
			var options = [
				{ text: "賞",		value: 0 },
				{ text: "グランプリ",		value: 1 },
				{ text: "準グランプリ",	value: 2 },
				{ text: "金賞",					value: 3 },
				{ text: "銀賞",					value: 4 }
			];

			return options;
	}
	else if(award == 4)
	{
			var options = [
				{ text: "賞",					value: 0 },
				{ text: "GOLD",				value: 1 },
				{ text: "SILVER",			value: 2 }
			];

			return options;
	}
	else
	{
			var options = [
				{ text: "賞",		value: 0 },
				{ text: "金賞", value: 1 },
				{ text: "入賞", value: 2 }
			];

			return options;
	}

	return 0;
}

function GetSakeSpecialName(sake_code)
{
    var special_name = "";

    if(sake_code == "11")
    {
        special_name = "普通酒";
    }
    else if(sake_code == "21")
    {
        special_name = "本醸造酒";
    }
    else if(sake_code == "22")
    {
        special_name = "特別本醸造酒";
    }
    else if(sake_code == "31")
    {
        special_name = "純米酒";
    }
    else if(sake_code == "32")
    {
        special_name = "特別純米酒";
    }
    else if(sake_code == "33")
    {
        special_name = "純米吟醸酒";
    }
    else if(sake_code == "34")
    {
        special_name = "純米大吟醸酒";
    }
    else if(sake_code == "43")
    {
        special_name = "吟醸酒";
    }
    else if(sake_code == "44")
    {
        special_name = "大吟醸酒";
    }
    else if(sake_code == "90")
    {
        special_name = "その他";
    }
    else if(sake_code == "99")
    {
        special_name = "不明";
    }
    else
    {
        special_name = "";
    }

    return special_name;
}

function GetSakeCategory(category_code)
{
    if(category_code == "11")
    {
      var retval = "無ろ過原酒";
      return retval;
    }
    else if(category_code == "21")
    {
      var retval = "にごり酒";
      return retval;
    }
    else if(category_code == "22")
    {
      var retval = "あらばしり";
      return retval;
    }
    else if(category_code == "31")
    {
      var retval = "中取り/中垂/中汲み";
      return retval;
    }
    else if(category_code == "32")
    {
      var retval = "押切り";
      return retval;
    }
    else if(category_code == "90")
	  {
      var retval = "その他";
      return retval;
	  }
    else
    {
      // var retval = "不明";
      var retval = "";
      return retval;
    }
}

(function($, window) {
      $.fn.replaceOptions = function(options) {
        var self, $option;

        this.empty();
        self = this;

	    $.each(options, function(index, option) {
  	    $option = $("<option></option>")
        .attr("value", option.value)
        .text(option.text);
  	    self.append($option);
	    });
    };
})(jQuery, window);


$(function() {
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 入力フォーム イベントハンドラー
	$('input[name="jas_code[]"]').change(function(){

        // $('input[name="jas_code[]"]').each(function() {
        //     $(this).val($.trim($(this).val()));
        // });

        if($(this).val())
			$(this).val($.trim($(this).val()));
    });

	$('.sakedata input[name="rice_used"]').change(function(){

		if($('.sakedata input[name="rice_used"] option:selected').val() == "other")
		{
			$("#rice_used_other").slideDown();
		}
		else
		{
			$("#rice_used_other").slideUp();
		}
	});

	$('.sakedata input[name="rice_used2"]').change(function(){

		if($('.sakedata select[name="rice_used2"] option:selected').val() == "other")
		{
			$("#rice_used_other2").slideDown();
		}
		else
		{
			$("#rice_used_other2").slideUp();
		}
	});

	$('.sakedata input[name="rice_used3"]').change(function(){

		if($('.sakedata select[name="rice_used3"] option:selected').val() == "other")
		{
			$("#rice_used_other3").slideDown();
		}
		else
		{
			$("#rice_used_other").slideUp();
		}
	});

	$('.sakedata input[name="jas_code"], .sakedata input[name="alcohol_level[]"], .sakedata input[name="jsake_level[]"], .sakedata input[name="oxidation_level[]"], .sakedata input[name="amino_level[]"], .sakedata input[name="jas_code[]').change(function() {
		var txt = $(this).val();
		var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
		$(this).val(han);
	});

	$('.sakedata input[name="kakemai_rate"], .sakedata input[name="kakemai_rate2"], .sakedata input[name="kakemai_rate3"], .sakedata input[name="seimai_rate"], .sakedata input[name="seimai_rate2"], .sakedata input[name="seimai_rate3"]').change(function(){
		var txt = $(this).val();
		var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
		$(this).val(han);
	});

	$('.sakedata input[name="size_other1"], .sakedata input[name="size_other2"], .sakedata input[name="size_other3"], .sakedata input[name="size_other4"]').change(function(){
		var txt = $(this).val();
		var han = txt.replace(/[Ａ-Ｚａ-ｚ０-９]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
		$(this).val(han);
	});

	if($('.sakedata input[name="ingredients_checked"]').prop("checked") == true)
	{
		$('.sakedata input[name="ingredients_other"]').prop('disabled', false);
	}
	else
	{
		$('.sakedata input[name="ingredients_other"]').prop('disabled', true);
	}

	if($('.sakedata input[name="category_checked"]').prop("checked") == true)
	{
		$('.sakedata input[name="sake_category_other"]').prop('disabled', false);
	}
	else
	{
		$('.sakedata input[name="sake_category_other"]').prop('disabled', true);
	}

	if($('.sakedata input[name="koubo_checked"]').prop("checked") == true)
	{
		$('.sakedata input[name="koubo_other"]').prop('disabled', false);
	}
	else
	{
		$('.sakedata input[name="koubo_other"]').prop('disabled', true);
	}

	if($('.sakedata input[name="koubo_checked2"]').prop("checked") == true)
	{
		$('.sakedata input[name="koubo_other2"]').prop('disabled', false);
	}
	else
	{
		$('.sakedata input[name="koubo_other2"]').prop('disabled', true);
	}

	if($('.sakedata input[name="koubo_checked3"]').prop("checked") == true)
	{
		$('.sakedata input[name="koubo_other3"]').prop('disabled', false);
	}
	else
	{
		$('.sakedata input[name="koubo_other3"]').prop('disabled', true);
	}

	$('.sakedata input[name="ingredients_checked"]').click(function() {
		if($('.sakedata input[name="ingredients_checked"]').prop("checked") == true)
		{
			$('.sakedata input[name="ingredients_other"]').prop('disabled', false);
		}
		else
		{
			$('.sakedata input[name="ingredients_other"]').prop('disabled', true);
		}
	});

	$('.sakedata input[name="category_checked"]').click(function() {
		if($('.sakedata input[name="category_checked"]').prop("checked") == true)
		{
			$('.sakedata input[name="sake_category_other"]').prop('disabled', false);
		}
		else
		{
			$('.sakedata input[name"sake_category_other"]').prop('disabled', true);
		}
	});

	$('.sakedata input[name="koubo_checked"]').click(function() {
		 if($('.sakedata input[name="koubo_checked"]').prop("checked") == true)
		 {
			$('.sakedata input[name="koubo_other"]').prop('disabled', false);
		 }
		 else
		 {
			$('.sakedata input[name="koubo_other"]').prop('disabled', true);
		 }
	});

	$('.sakedata input[name="koubo_checked2"]').click(function() {
		 if($('.sakedata input[name="koubo_checked2"]').prop("checked") == true)
		 {
			$('.sakedata input[name="koubo_other2"]').prop('disabled', false);
		 }
		 else
		 {
			$('.sakedata input[name="koubo_other2"]').prop('disabled', true);
		 }
	});

	$('.sakedata input[name="koubo_checked3"]').click(function() {
		 if($('.sakedata input[name="koubo_checked3"]').prop("checked") == true)
		 {
			$('.sakedata input[name="koubo_other3"]').prop('disabled', false);
		 }
		 else
		 {
			$('.sakedata input[name="koubo_other3"]').prop('disabled', true);
		 }
	});

	$('.sakedata input[name="special_name"]').click(function() {
		if($('.sakedata input[name="special_name"]:checked').val() != $('.sakedata input[name="special_name"]').attr("prev"))
		{
			$('.sakedata input[name="special_name"]').attr("prev", $('.sakedata input[name="special_name"]:checked').val());
		}
		else
		{
			$(this).attr('checked', false);
			$('.sakedata input[name="special_name"]').attr("prev", "");
		}
	});

	function key_down(get_code){
		if(get_code >= 48 && get_code <= 57  //数字キー
				|| get_code >= 96 && get_code <= 105 //テンキーの数字
				|| get_code == 189  // '-'
				|| get_code == 8 //bs
				|| get_code == 37 // left
				|| get_code == 39 // right
				|| get_code == 190 // .
			 )
			   return true;
		else
		{
			alert("半角で入力してください");
			return false;
		}
	} // key_down

  /*hirasawaここから*/
		//酒編集ページ特定名称その他入力可
    $('input[name="special_name"]:radio').change( function() {
        var radioval = $(this).val();
        if(radioval == 90){
          $('input[name="special_name_other"]').removeAttr('disabled');
        }else{
          $('input[name="special_name_other"]').attr('disabled','disabled');
        }
    });

    // 酒編集ページ特定名称ラジオボタン選択解除
    var nowchecked = $('.column2_tokuteimeisho input[name="special_name"]:checked').val();
    $('.column2_tokuteimeisho input[name="special_name"]').click(function(){
        if($(this).val() == nowchecked) {
          $(this).prop('checked', false);
          nowchecked = false;
        }
        else {
          nowchecked = $(this).val();
        }
    });

    // 酒編集ページ特定名称その他チェック外した場合のdisabled
    var nowchecked = $('.column2_tokuteimeisho div label input[name=special_name]:checked').val();

    $('.column2_tokuteimeisho div label input[name="special_name"]').click(function(){
        if($(this).val() == nowchecked) {
          $('input[name="special_name_other"]').removeAttr('disabled');
        }
        else {
          $('input[name="special_name_other"]').attr('disabled','disabled');
        }
    });

    // 酒編集ページ原材料
    $("#ingredients_checked").change(function(){
        ingredients_checkedVal = $("#ingredients_checked:checked").val();

        if (ingredients_checkedVal == "90") {
          $('input[name="ingredients_other"]').removeAttr("disabled");
        }
        else {
          $('input[name="ingredients_other"]').attr("disabled", "disabled");
        }
    }).trigger("change");

   // 酒編集ページ原料米品種名その他入力フォーム
    $('select[name="rice_used"]').change(function(){
        if($('select[name="rice_used"] option:selected').val() == "other")
        {
          $("#rice_used_other").slideDown();
        }
        else
        {
          $("#rice_used_other").slideUp();
        }
    });

    $('select[name="rice_used2"]').change(function(){
        if($('select[name="rice_used2"] option:selected').val() == "other")
        {
          $("#rice_used_other2").slideDown();
        }
        else
        {
          $("#rice_used_other2").slideUp();
        }
    });

    $('select[name="rice_used3"]').change(function(){
        if($('select[name="rice_used3"] option:selected').val() == "other")
        {
          $("#rice_used_other3").slideDown();
        }
        else
        {
          $("#rice_used_other3").slideUp();
        }
    });

    // 酒編集ページ酵母その他
    $("#koubo_other_checked").change(function(){
        koubo_other_checkedVal = $("#koubo_other_checked:checked").val();

        if(koubo_other_checkedVal == "90") {
          $("#koubo_other").removeAttr("disabled");
        }
        else {
          $("#koubo_other").attr("disabled", "disabled");
        }
    }).trigger("change");

    $("#koubo_other_checked2").change(function(){
        koubo_other_checkedVal = $("#koubo_other_checked2:checked").val();

        if (koubo_other_checkedVal == "91") {
            $('input[name="koubo_other2"]').removeAttr("disabled");
        }
        else {
            $('input[name="koubo_other2"]').attr("disabled", "disabled");
        }
    }).trigger("change");

    $("#koubo_other_checked3").change(function(){
        koubo_other_checkedVal = $("#koubo_other_checked3:checked").val();

        if (koubo_other_checkedVal == "92") {
          $('input[name="koubo_other3"]').removeAttr("disabled");
        }
        else {
          $('input[name="koubo_other3"]').attr("disabled", "disabled");
        }
    }).trigger("change");
    // hirasawaここまで
});

$(function() {

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 酒蔵選択ポップアップ　イベントハンドラー
		//hirasawaここから
		/*酒編集ページ酒蔵の選択モーダルウィンドウ*/
		$('input[name="add_sakagura_button"]').click(function() {
			var touch_start_y;
			// タッチしたとき開始位置を保存しておく
			$(window).on('touchstart', function(event) {
				touch_start_y = event.originalEvent.changedTouches[0].screenY;
			});
			// スワイプしているとき
			$(window).on('touchmove.noscroll', function(event) {
				var current_y = event.originalEvent.changedTouches[0].screenY,
				height = $('.dialog_add_sakagura_background').outerHeight(),
				is_top = touch_start_y <= current_y && $('.dialog_add_sakagura_background')[0].scrollTop === 0,
				is_bottom = touch_start_y >= current_y && $('.dialog_add_sakagura_background')[0].scrollHeight - $('.dialog_add_sakagura_background')[0].scrollTop === height;

				// スクロール対応モーダルの上端または下端のとき
				if (is_top || is_bottom) {
					// スクロール禁止
					event.preventDefault();
				}
			});

			// スクロール禁止
			$('html, body').css('overflow', 'hidden');
			$(".dialog_add_sakagura_background").css({"display":"flex"});
		});

		$('.close_add_sakagura_button').click(function() {
			// イベントを削除
			$(window).off('touchmove.noscroll');
			$('html, body').css('overflow', '');
			$(".dialog_add_sakagura_background").css({"display":"none"});
		});
		//hirasawaここまで

	$(".add_sakagura_content li").click(function () {

		$(".add_sakagura_content li").removeClass("checked");
		$(".add_sakagura_content li").css({"background":"#fff"});
		$(".add_sakagura_content li").css({"color":"#3f3f3f"});

		$(this).addClass("checked");
		this.style.backgroundColor = "#B4DCE6";
		this.style.color = "#3f3f3f"
    });

    $('input[name="add_sakagura_ok"]').click(function() {

		if($('.add_sakagura_content li.checked').length > 0)
		{
            $('.sakedata').data('sakagura_id', $('.add_sakagura_content li.checked').data('sakagura_id'));
            $('input[name="sakagura_id"]').val($('.add_sakagura_content li.checked').data('sakagura_id'));

			$('.sakagura_name').val($('.add_sakagura_content li.checked span:nth-child(2)').text());
            $('input[name="sakagura_name"]').val($('.add_sakagura_content li.checked span:nth-child(2)').text());
		}

		$('.add_sakagura_content').empty();
		$('.add_sakagura_input').val('');

        $(window).off('touchmove.noscroll');
        $('html, body').css('overflow', '');
        $(".dialog_add_sakagura_background").css({"display":"none"});

   });

    // 追加する酒蔵の検索
    $('input[name="add_sake_name"]').on('keyup', function() {

        var inputText = $('input[name="add_sake_name"]').val();
        var count = inputText.length;
        var search_limit = 24;
        var search_type = 2;

        var data = "search_type=" + search_type + "&search_limit=" + search_limit + "&search_text=" + inputText;

        if(count >= 1)
        {
            $.ajax({
                type: "POST",
                url: "auto_complete.php",
		              data: data,
                dataType: 'json',

            }).done(function(data){

                //alert("succeded:" + data + "length:" + data.length);
                $('.add_sakagura_content').empty();

                for(var i = 0; i < data.length; i++)
                {
					//alert("filename: " + data[i].filename);
                    $('.add_sakagura_content').append('<li class="message_class" data-sakagura_id="' + data[i].sake_id + '" data-sakagura_name="' + data[i].sake_name + '"><svg class="add_sakagura_content_icon"><use xlink:href="#brewery3630"/></svg><span>' + data[i].sake_name + '</span><span>' + data[i].pref + '</span></li>');
                }

                $(".add_sakagura_content").css({"visibility": "visible"});


			        $(".add_sakagura_content li").click(function () {

				        //var bchecked = $(this).hasClass("checked");
				        $(".add_sakagura_content li").removeClass("checked");
				        $(".add_sakagura_content li").css({"background":"#fff"});
				        $(".add_sakagura_content li").css({"color":"#3f3f3f"});

				        $(this).addClass("checked");
				        this.style.backgroundColor = "#2D96C3";
				        this.style.color = "#ffffff"
		            });

            }).fail(function(data){
                //alert("Failed:" + data);
            });
        }
        else
        {
            $('.add_sakagura_content').empty();
        }
    }); // keyup

	$('.edit_sake_close').click(function() {

        $("body").trigger( "edit_sake_close", [ this ] );
	});

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 確認用ポップアップでデータを与える
	$('input[name="confirm_button"]').click(function() {

		var message = [];

		if($('.sakedata input[name="sakagura_id"]').val() == "")
		{
			message.push("酒蔵を選択してください");
		}

		if($('.sakedata input[name="sake_name"]').val() == "")
		{
			message.push("日本酒名を入力してください");
		}

		if($('.sakedata input[name="alcohol_level[]"]').val() != "" && $.isNumeric($('.sakedata input[name="alcohol_level[]"]').val()) == false)
		{
			message.push("Alc度数は半角数字で入力してください");
		}

		if($('.sakedata input[name="seimai_rate"]').val() != "" && $.isNumeric($('.sakedata input[name="seimai_rate"]').val()) == false)
		{
			message.push("原料米1の精米歩合は半角数字で入力してください");
		}

		if($('.sakedata input[name="seimai_rate2"]').val() != "" && $.isNumeric($('.sakedata input[name="seimai_rate2"]').val()) == false)
		{
			message.push("原料米2の精米歩合は半角数字で入力してください");
		}

		if($('.sakedata input[name="seimai_rate3"]').val() != "" && $.isNumeric($('.sakedata input[name="seimai_rate3"]').val()) == false)
		{
			message.push("原料米3の精米歩合は半角数字で入力してください");
		}

		if($('.sakedata input[name="jsake_level[]"]').val() != "" && $.isNumeric($('.sakedata input[name="jsake_level[]"]').val()) == false)
		{
			message.push("日本酒度は半角数字で入力してください");
		}

		if($('.sakedata input[name="oxidation_level[]"]').val() != "" && $.isNumeric($('.sakedata input[name="oxidation_level[]"]').val()) == false)
		{
			message.push("酸度は半角数字で入力してください");
		}

		if($('.sakedata input[name="amino_level[]"]').val() != "" && $.isNumeric($('.sakedata input[name="amino_level[]"]').val()) == false)
		{
			message.push("アミノ酸度は半角数字で入力してください");
		}

		if($('.sakedata input[name="jas_code[]"]').val() != "" && $.isNumeric($('.sakedata input[name="jas_code[]"]').val()) == false)
		{
			message.push("JANコードは半角数字で入力してください");
		}

		if(message != "")
		{
			alert(message.join(" / "));
		}
		else
		{
			//alert('sake_name:' + $('input[name="sake_name"]').val());

			$('.dialog_table .dialog_sakagura_name').text($('.sakedata input[name="sakagura_name"]').val());
			$('.dialog_table .dialog_sake_name').text($('.sakedata input[name="sake_name"]').val());
			$('.dialog_table .dialog_jas_code').text($('.sakedata input[name="jas_code"]').val());
			//////////
			$('.dialog_table .dialog_sake_read').text($('.sakedata input[name="sake_read"]').val());

			//////////
			$('.dialog_table .dialog_sake_english').text($('.sakedata input[name="sake_english"]').val());
			//////////
			$('.dialog_table .dialog_sake_search').text($('.sakedata input[name="sake_search"]').val());
			//////////
			if($('.sakedata select[name="year_made"]').val()) {
				$('.dialog_table .dialog_year_made').text($('.sakedata select[name="year_made"]').val() + "年");
			} else {
				$('.dialog_table .dialog_year_made').text('');
			}
			//////////
			if($('.sakedata input[name="special_name"]:checked').val() == "90") {
				$('.dialog_table .dialog_special_name').text($('.sakedata input[name="special_name_other"]').val());
			} else {
				$('.dialog_table .dialog_special_name').text(GetSakeSpecialName($('.sakedata input[name="special_name"]:checked').val()));
			}
			//////////
			if($('.sakedata input[name="alcohol_level[]"]:nth(0)').val() && $('.sakedata input[name="alcohol_level[]"]:nth(1)').val()) {
				$('.dialog_table .dialog_alcohol_level').text($('.sakedata input[name="alcohol_level[]"]:nth(0)').val() + "%～");
				$('.dialog_table .dialog_alcohol_level2').text($('.sakedata input[name="alcohol_level[]"]:nth(1)').val() + "%");
			} else if($('.sakedata input[name="alcohol_level[]"]:nth(0)').val() && $('.sakedata input[name="alcohol_level[]"]:nth(1)').val() == "") {
				$('.dialog_table .dialog_alcohol_level').text($('.sakedata input[name="alcohol_level[]"]:nth(0)').val() + "%");
				$('.dialog_table .dialog_alcohol_level2').text('');
			} else if($('.sakedata input[name="alcohol_level[]"]:nth(0)').val() == "" && $('.sakedata input[name="alcohol_level[]"]:nth(1)').val()) {
				$('.dialog_table .dialog_alcohol_level').text('');
				$('.dialog_table .dialog_alcohol_level2').text($('.sakedata input[name="alcohol_level[]"]:nth(1)').val() + "%");
			} else {
				$('.dialog_table .dialog_alcohol_level').text('');
				$('.dialog_table .dialog_alcohol_level2').text('');
			}
			//////////
			var ingredients_innertext = "";
			$('.sakedata input[name="ingredients[]"]').each(function(){

				if(this.checked == true)
				{
					if(this.value == "90")
					{
						ingredients_innertext += (ingredients_innertext == "") ? $('input[name="ingredients_other"]').val() : (" / " + $('input[name="ingredients_other"]').val());
					}
					else
					{
						ingredients_innertext += (ingredients_innertext == "") ? $(this).parent().text() : (" / " + $(this).parent().text());
					}
				}
			});
			$(".dialog_table .dialog_ingredients").text(ingredients_innertext);
			//////////
			var rice_used_text = "";

			if($('.sakedata select[name="rice_used"] option:selected').val()) {

                var kakemai = "";

                if($('.sakedata select[name="kakemai"] option:selected').val() != 0) {
				    kakemai = $('.sakedata select[name="kakemai"] option:selected').text() + ":";
                }

				rice_used_text = kakemai + $('.sakedata select[name="rice_used"] option:selected').text();
			}

			if($('.sakedata select[name="rice_used2"] option:selected').val()) {

                var kakemai2 = "";

                if($('.sakedata select[name="kakemai2"] option:selected').val() != 0) {
				    kakemai2 = $('.sakedata select[name="kakemai2"] option:selected').text() + ":";
                }
            
				if(rice_used_text == "") {
					rice_used_text = kakemai2 + $('.sakedata select[name="rice_used2"] option:selected').text();
				} else {
					rice_used_text += (" / " + kakemai2 + $('.sakedata select[name="rice_used2"] option:selected').text());
				}
			}

			if($('.sakedata select[name="rice_used3"] option:selected').val()) {

                var kakemai3 = "";

                if($('.sakedata select[name="kakemai3"] option:selected').val() != 0) {
				    kakemai3 = $('.sakedata select[name="kakemai3"] option:selected').text() + ":";
                }

				if(rice_used_text == "") {
					rice_used_text = kakemai3 + $('.sakedata select[name="rice_used3"] option:selected').text();
				} else {
					rice_used_text += (" / " + kakemai3 + $('.sakedata select[name="rice_used3"] option:selected').text());
				}
			}

			$('.dialog_table .dialog_rice_used').text(rice_used_text);
			//////////
			var seimai_rate = "";

			if($('.sakedata input[name="seimai_rate"]').val())
			{
                var kakemai = "";

                if($('.sakedata select[name="kakemai"] option:selected').val() != 0) {
				    kakemai = $('.sakedata select[name="kakemai"] option:selected').text() + ":";
                }

				seimai_rate = kakemai + $('.sakedata input[name="seimai_rate"]').val() + '%';
			}

			if($('.sakedata input[name="seimai_rate2"]').val())
			{
                var kakemai2 = "";

                if($('.sakedata select[name="kakemai2"] option:selected').val() != 0) {
				    kakemai2 = $('.sakedata select[name="kakemai2"] option:selected').text() + ":";
                }

				if(seimai_rate == "") {
					seimai_rate = kakemai2 + $('.sakedata input[name="seimai_rate2"]').val() + '%';
				} else {
					seimai_rate += ' / ' + kakemai2 + $('.sakedata input[name="seimai_rate2"]').val() + '%';
				}
			}

			if($('.sakedata input[name="seimai_rate3"]').val())
			{
                var kakemai3 = "";

                if($('.sakedata select[name="kakemai3"] option:selected').val() != 0) {
				    kakemai3 = $('.sakedata select[name="kakemai3"] option:selected').text() + ":";
                }

				if(seimai_rate == "") {
					seimai_rate = kakemai3 + $('.sakedata input[name="seimai_rate3"]').val() + '%';
				} else {
					seimai_rate += ' / ' + kakemai3 + $('.sakedata input[name="seimai_rate3"]').val() + '%';
				}
			}

			$('.dialog_table .dialog_seimai_rate').text(seimai_rate);

			if($('.sakedata input[name="jsake_level[]"]:nth(0)').val() && $('.sakedata input[name="jsake_level[]"]:nth(1)').val()) {
				$('.dialog_table .dialog_jsake_level').text($('.sakedata input[name="jsake_level[]"]:nth(0)').val() + "～");
				$('.dialog_table .dialog_jsake_level2').text($('.sakedata input[name="jsake_level[]"]:nth(1)').val());
			} else if($('.sakedata input[name="jsake_level[]"]:nth(0)').val() && $('.sakedata input[name="jsake_level[]"]:nth(1)').val() == "") {
				$('.dialog_table .dialog_jsake_level').text($('.sakedata input[name="jsake_level[]"]:nth(0)').val());
				$('.dialog_table .dialog_jsake_level2').text('');
			} else if($('.sakedata input[name="jsake_level[]"]:nth(0)').val() == "" && $('.sakedata input[name="jsake_level[]"]:nth(1)').val()) {
				$('.dialog_table .dialog_jsake_level').text('');
				$('.dialog_table .dialog_jsake_level2').text($('.sakedata input[name="jsake_level[]"]:nth(1)').val());
			} else {
				$('.dialog_table .dialog_jsake_level').text('');
				$('.dialog_table .dialog_jsake_level2').text('');
			}
			//////////
			if($('.sakedata input[name="oxidation_level[]"]:nth(0)').val() && $('.sakedata input[name="oxidation_level[]"]:nth(1)').val()) {
				$('.dialog_table .dialog_oxidation_level').text($('.sakedata input[name="oxidation_level[]"]:nth(0)').val() + "～");
				$('.dialog_table .dialog_oxidation_level2').text($('.sakedata input[name="oxidation_level[]"]:nth(1)').val());
			} else if($('.sakedata input[name="oxidation_level[]"]:nth(0)').val() && $('.sakedata input[name="oxidation_level[]"]:nth(1)').val() == "") {
				$('.dialog_table .dialog_oxidation_level').text($('.sakedata input[name="oxidation_level[]"]:nth(0)').val());
				$('.dialog_table .dialog_oxidation_level2').text('');
			} else if($('.sakedata input[name="oxidation_level[]"]:nth(0)').val() == "" && $('.sakedata input[name="oxidation_level[]"]:nth(1)').val()) {
				$('.dialog_table .dialog_oxidation_level').text('');
				$('.dialog_table .dialog_oxidation_level2').text($('.sakedata input[name="oxidation_level[]"]:nth(1)').val());
			} else {
				$('.dialog_table .dialog_oxidation_level').text('');
				$('.dialog_table .dialog_oxidation_level2').text('');
			}
			//////////
			if($('.sakedata input[name="amino_level[]"]:nth(0)').val() && $('.sakedata input[name="amino_level[]"]:nth(1)').val()) {
				$('.dialog_table .dialog_amino_level').text($('.sakedata input[name="amino_level[]"]:nth(0)').val() + "～");
				$('.dialog_table .dialog_amino_level2').text($('.sakedata input[name="amino_level[]"]:nth(1)').val());
			} else if($('.sakedata input[name="amino_level[]"]:nth(0)').val() && $('.sakedata input[name="amino_level[]"]:nth(1)').val() == "") {
				$('.dialog_table .dialog_amino_level').text($('.sakedata input[name="amino_level[]"]:nth(0)').val());
				$('.dialog_table .dialog_amino_level2').text('');
			} else if($('.sakedata input[name="amino_level[]"]:nth(0)').val() == "" && $('.sakedata input[name="amino_level[]"]:nth(1)').val()) {
				$('.dialog_table .dialog_amino_level').text('');
				$('.dialog_table .dialog_amino_level2').text($('.sakedata input[name="amino_level[]"]:nth(1)').val());
			} else {
				$('.dialog_table .dialog_amino_level').text('');
				$('.dialog_table .dialog_amino_level2').text('');
			}
			//////////
			var koubo_kanji = "";

			$('input[name="koubo_used[]"]').each(function(){
				if(this.checked == true)
				{
					//alert("kanji:" + $(this).attr('kanji'));
					if(this.value == "90")
					{
						koubo_kanji += (koubo_kanji == "") ? $('input[name="koubo_other"]').val() : (" / " + $('input[name="koubo_other"]').val());
					}
					else if(this.value == "91")
					{
						koubo_kanji += (koubo_kanji == "") ? $('input[name="koubo_other2"]').val() : (" / " + $('input[name="koubo_other2"]').val());
					}
					else if(this.value == "92")
					{
						koubo_kanji += (koubo_kanji == "") ? $('input[name="koubo_other3"]').val() : (" / " + $('input[name="koubo_other3"]').val());
					}
					else
					{
						koubo_kanji += (koubo_kanji == "") ? $(this).parent().text() : (" / " + $(this).parent().text());
					}
				}
			});

			$('.dialog_table .dialog_koubo_used').text(koubo_kanji);
			//////////
			var sake_category_innertext = "";

			$('.sakedata input[name="sake_category[]"]').each(function() {
				//alert("this.value:" + this.value + " this.checked:" + this.checked);

				if(this.checked == true)
				{
					if(this.value == "90")
					{
						sake_category_innertext += (sake_category_innertext == "") ? $('input[name="sake_category_other"]').val() : (" / " + $('input[name="sake_category_other"]').val());
					}
					else
					{
						sake_category_innertext += (sake_category_innertext == "") ? $(this).parent().text() : (" / " + $(this).parent().text());
					}
				}
			});

			$(".dialog_table .dialog_sake_category").text(sake_category_innertext);
			//////////
			var sake_award_name1 = $('.sakedata select[name="sake_award_name1"] option:selected').text();
			var sake_award_year1 = $('.sakedata select[name="sake_award_year1"]').val();
			var sake_award1 = $('.sakedata select[name="sake_award1"] option:selected').text();

			var sake_award_name2 = $('.sakedata select[name="sake_award_name2"] option:selected').text();
			var sake_award_year2 = $('.sakedata select[name="sake_award_year2"]').val();
			var sake_award2	= $('.sakedata select[name="sake_award2"] option:selected').text();

			var sake_award_name3 = $('.sakedata select[name="sake_award_name3"] option:selected').text();
			var sake_award_year3 = $('.sakedata select[name="sake_award_year3"]').val();
			var sake_award3	= $('.sakedata select[name="sake_award3"] option:selected').text();
			var sake_award_history = "";

			if($('.sakedata select[name="sake_award_name1"] option:selected').val() != undefined && $('.sakedata select[name="sake_award_name1"] option:selected').val() != "")
			{
				 sake_award_history = '<div><span>' + sake_award_name1 + '</span><span style="margin-left:4px">' + sake_award_year1 + '</span><span style="margin-left:4px">' + sake_award1 + '</span></div>';
			}

			if($('.sakedata .select[name="sake_award_name2"] option:selected').val() != undefined && $('.sakedata select[name="sake_award_name2"] option:selected').val() != "")
			{
				if(sake_award_history == "")
					sake_award_history = '<div><span>' + sake_award_name2 + '</span><span style="margin-left:4px">' + sake_award_year2 + '</span><span style="margin-left:4px">' + sake_award2 + '</span></div>';
				else
					sake_award_history += '<div><span>' + sake_award_name2 + '</span><span style="margin-left:4px">' + sake_award_year2 + '</span><span style="margin-left:4px">' + sake_award2 + '</span></div>';
			}

			if($('.sakedata .sake_award_name3 option:selected').val() != undefined && $('.sakedata .sake_award_name3 option:selected').val() != "")
			{
				if(sake_award_history == "")
					sake_award_history = '<div><span>' + sake_award_name3 + '</span><span style="margin-left:4px">' + sake_award_year3 + '</span><span style="margin-left:4px">' + sake_award3 + '</span></div>';
				else
					sake_award_history += '<div><span>' + sake_award_name3 + '</span><span style="margin-left:4px">' + sake_award_year3 + '</span><span style="margin-left:4px">' + sake_award3 + '</span></div>';
			}

			$('.dialog_table .dialog_award_history').html(sake_award_history);
			//////////
			var recommended_drink_innertext = "";

			$('.sakedata input[name="recommended_drink[]"]').each(function() {
				if(this.checked == true) {
					recommended_drink_innertext += (recommended_drink_innertext == "") ? $(this).parent().text() : (" / " + $(this).parent().text());
				}
			});

			$(".dialog_table .dialog_recommended_drink").text(recommended_drink_innertext);
			//////////
			var jas_code = "";

			$('.sakedata input[name="jas_code[]"]').each(function() {
				if($(this).val()) {
					jas_code += (jas_code == "") ? $(this).val() : (" / " + $(this).val());
				}
			});

			$(".dialog_table .dialog_jas_code").text(jas_code);
			//////////
			$('.dialog_table .dialog_sake_memo').text($('.sakedata input[name="sake_memo"]').val());
			//////////

			//alert("製法の特徴:" + sake_category_innertext);
			//$(".dialog_table .dialog_sake_category").text(sake_category_innertext);

			//hirasawaここから
			/*酒編集ページ確認モーダルウィンドウ*/
			//$('input[name="confirm_button"]').click(function() {
			var touch_start_y;
			// タッチしたとき開始位置を保存しておく
			$(window).on('touchstart', function(event) {
				touch_start_y = event.originalEvent.changedTouches[0].screenY;
			});
			// スワイプしているとき
			$(window).on('touchmove.noscroll', function(event) {
				var current_y = event.originalEvent.changedTouches[0].screenY,
				height = $('.dialog_add_sake_background').outerHeight(),
				is_top = touch_start_y <= current_y && $('.dialog_add_sake_background')[0].scrollTop === 0,
				is_bottom = touch_start_y >= current_y && $('.dialog_add_sake_background')[0].scrollHeight - $('.dialog_add_sake_background')[0].scrollTop === height;

				// スクロール対応モーダルの上端または下端のとき
				if (is_top || is_bottom) {
					// スクロール禁止
					event.preventDefault();
				}
			});

			// スクロール禁止
			$('html, body').css('overflow', 'hidden');
			$(".dialog_add_sake_background").css({"display":"flex"});
			//});

			$('input[name="button_back"], input[name="submit_button"]').click(function() {
				// イベントを削除
				$(window).off('touchmove.noscroll');
				$('html, body').css('overflow', '');
				$(".dialog_add_sake_background").css({"display":"none"});
			});
			//hirasawaここまで
		} // else

    });  // confirm

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 編集用　フォームに既存データを与える
    $("body").on( "open_edit_sake", function( event, sake_id, sake_name) {

        var data = "category=2&from=0&sake_id=" + sake_id;
        //alert("open_edit_sake:" + sake_id);

        $('.sakedata input[name="sake_name"]').val(sake_name);
        $('.sakedata').data("sake_id", sake_id);

        //alert("data:" + data);

	    $.ajax({
		    type: "POST",
		    url: "complex_search.php",
		    data: data,
		    dataType: 'json',

	    }).done(function(data){

		    var result = data[0].result;

            //alert("jsake:" + jsake_level);
            //alert("rice_used:" + result[0].rice_used);

            $('.sakedata input[name="sake_name"]').val(result[0].sake_name);
            $('.sakedata input[name="sake_read"]').val(result[0].sake_read);
            $('.sakedata input[name="sake_english"]').val(result[0].sake_english);
            $('.sakedata input[name="sake_search"]').val(result[0].sake_search);
            $('.sakedata input[name="sakagura_name"]').val(result[0].sakagura_name);
            $('.sakedata input[name="sakagura_id"]').val(result[0].sakagura_id);
            $('.sakedata').data('sakagura_id', result[0].sakagura_id);
            // $('input[name="year_made"]').val(result[0].year_made);

            $('.sakedata select[name="year_made"] option').each(function(){

                if(this.value == result[0].year_made)
				{
					 $('.sakedata select[name="year_made"]').val(result[0].year_made);
					 return false;
				}
			});

		    var special_name_array = result[0].special_name_code.split(',');

		    if(special_name_array.length >= 1)
		    {
			    $('.sakedata input[name="special_name"]').each(function(){

				    if(special_name_array[0] == this.value)
				    {
					    this.checked = true;

					    if(special_name_array[0] == "90")
					    {
							  $('.sakedata input[name="special_name_other"]').val(special_name_array[1]);
					    }
				    }
			    });
		    }

			if(result[0].alcohol_level != null && result[0].alcohol_level != "")
			{
				var alcohol_array = result[0].alcohol_level.split(',');

				$('.sakedata input[name="alcohol_level[]"]:nth(0)').val(alcohol_array[0]);
				$('.sakedata input[name="alcohol_level[]"]:nth(1)').val(alcohol_array[1]);
			}

			if(result[0].jsake_level != null && result[0].jsake_level != "")
			{
				var jsake_array = result[0].jsake_level.toString().split(',');

				$('.sakedata input[name="jsake_level[]"]:nth(0)').val(jsake_array[0]);
				$('.sakedata input[name="jsake_level[]"]:nth(1)').val(jsake_array[1]);
			}

			if(result[0].oxidation_level != null && result[0].oxidation_level != "")
			{
				var oxidation_array = result[0].oxidation_level.toString().split(',');

				$('.sakedata input[name="oxidation_level[]"]:nth(0)').val(oxidation_array[0]);
				$('.sakedata input[name="oxidation_level[]"]:nth(1)').val(oxidation_array[1]);
			}

			if(result[0].amino_level != null && result[0].amino_level != "")
			{
				var amino_array = result[0].amino_level.toString().split(',');

				$('.sakedata input[name="amino_level[]"]:nth(0)').val(amino_array[0]);
				$('.sakedata input[name="amino_level[]"]:nth(1)').val(amino_array[1]);
			}

            // sake category
			var sake_category = result[0].sake_category_code;
			var category_array = sake_category.split(',');
			//alert("sake_category:" + sake_category);

			$('.sakedata input[name="sake_category_other"]').prop('disabled', true);

			$.each(category_array, function(index, val){

				 $('.sake_container input[name="sake_category[]"]').each(function(){

                    //if(val == this.value)
                    if(val == this.value || val == parseInt(this.value))
                    {
                        this.checked = true;

                        if(val == "90")
                        {
	                        $('.sakedata input[name="sake_category_other"]').val(category_array[index + 1]);
					        $('.sakedata input[name="sake_category_other"]').prop('disabled', false);
                        }
                    }
                });
			});

			//alert("success:" + " sake_english:" + result[0].sake_english + " sake_name" + result[0].sake_name);
			//alert("koubo_used:" + result[0].koubo_used);

            // koubo_used
			var koubo_used = result[0].koubo_used;
			var koubo_array = koubo_used.split(',');

            if(koubo_used && koubo_used != undefined)
            {
			    $.each(koubo_array, function(index, val){

				     $('.sake_container input[name="koubo_used[]"]').each(function(){

                        if(val == this.value || val == parseInt(this.value))
                        {
                            this.checked = true;

                            if(val == "90")
                            {
	                            //alert("val" + val);
	                            $('.sakedata input[name="koubo_other"]').val(koubo_array[index + 1]);
		                        $('.sakedata input[name="koubo_other"]').prop('disabled', false);
                            }
                            else if(val == "91")
                            {
	                            //alert("val" + val);
	                            $('.sakedata input[name="koubo_other2"]').val(koubo_array[index + 1]);
	                            $('.sakedata input[name="koubo_other2"]').prop('disabled', false);
                            }
                            else if(val == "92")
                            {
	                            //alert("val" + val);
	                            $('.sakedata input[name="koubo_other3"]').val(koubo_array[index + 1]);
		                        $('.sakedata input[name="koubo_other3"]').prop('disabled', false);
                            }
                        }
                    });
			    });
            }

            if(result[0].sake_award_history != null && result[0].sake_award_history != "")
            {
				var sake_award = result[0].sake_award_history;
				var award_array = sake_award.split('/');

			    if(award_array.length > 0)
				{
					var award_entry = award_array[0].split(',');

					$('.sakedata select[name="sake_award_name1"] option').each(function(){

						if(this.value == award_entry[0])
						{
							 $('.sakedata select[name="sake_award_name1"]').val(award_entry[0]);
							 $('.sakedata select[name="sake_award1"]').replaceOptions(getAwardOption($('.sakedata select[name="sake_award_name1"]').val()));
							 //alert("this.value:" + this.value + " entry:" + award_entry[0]);
							 return false;
						}
					});


					$('.sakedata select[name="sake_award_year1"] option').each(function(){

                        //alert("this.value:" + this.value);

						if(this.value == award_entry[1])
						{
                             //alert("award_entry[1]:" + award_entry[1]);

							 $('.sakedata select[name="sake_award_year1"]').val(award_entry[1]);
							 return false;
						}
					});

					$('.sakedata select[name="sake_award1"] option').each(function(){

						if(this.value == award_entry[2])
						{
							 $('.sakedata select[name="sake_award1"]').val(award_entry[2]);
							 return false;
						}
					});
				}

				if(award_array.length > 1)
				{
					var award_entry = award_array[1].split(',');

					$('.sakedata select[name="sake_award_name2"] option').each(function(){

						if(this.value == award_entry[0])
						{
							 $('.sakedata select[name="sake_award_name2"]').val(award_entry[0]);
							 $('.sakedata select[name="sake_award2"]').replaceOptions(getAwardOption($('.sakedata select[name="sake_award_name2"]').val()));
							 return false;
						}
					});

					$('.sakedata select[name="sake_award_year2"] option').each(function(){

						if(this.value == award_entry[1])
						{
							 $('.sakedata select[name="sake_award_year2"]').val(award_entry[1]);
							 return false;
						}
					});

					$('.sakedata select[name="sake_award2"] option').each(function(){

						if(this.value == award_entry[2])
						{
							 $('.sakedata select[name="sake_award2"]').val(award_entry[2]);
							 return false;
						}
					});
				}

				if(award_array.length > 2)
				{
					var award_entry = award_array[2].split(',');

					$('.sakedata select[name="sake_award_name3"] option').each(function(){

						if(this.value == award_entry[0])
						{
							 $('.sakedata select[name="sake_award_name3"]').val(award_entry[0]);
							 $('.sakedata select[name="sake_award3"]').replaceOptions(getAwardOption($('.sakedata select[name="sake_award_name3"]').val()));
							 return false;
						}
				    });

					$('.sakedata select[name="sake_award_year3"] option').each(function(){

						if(this.value == award_entry[1])
						{
							 $('.sakedata select[name="sake_award_year3"]').val(award_entry[1]);
							 return false;
						}
					});

					$('.sakedata select[name="sake_award3"] option').each(function(){

						if(this.value == award_entry[2])
						{
							 $('.sakedata select[name="sake_award3"]').val(award_entry[2]);
							 return false;
						}
					});
				}

	            $('.sakedata select[name="sake_award_name1"]').change(function(){
		            if($('.sakedata select[name="sake_award_name1"]').val() != "")
		            {
			            $('.sakedata select[name="sake_award_year1"]').prop('disabled', false);
			            $('.sakedata select[name="sake_award1"]').replaceOptions(getAwardOption($('.sakedata select[name="sake_award_name1"]').val()));
			            $('.sakedata select[name="sake_award1"]').prop('disabled', false);
		            }
		            else
		            {
			            $('.sakedata select[name="sake_award_year1"]').prop('disabled', true);
			            $('.sakedata select[name="sake_award1"]').prop('disabled', true);
		            }
	            });

	            $('.sakedata select[name="sake_award_name2"]').change(function(){
		            if($('.sakedata select[name="sake_award_name2"]').val() != "")
		            {
			            $('.sakedata select[name="sake_award_year2"]').prop('disabled', false);
			            $('.sakedata select[name="sake_award2"]').replaceOptions(getAwardOption($('.sakedata select[name="sake_award_name2"]').val()));
			            $('.sakedata select[name="sake_award2"]').prop('disabled', false);
		            }
		            else
		            {
			            $('.sakedata select[name="sake_award_year2"]').prop('disabled', true);
			            $('.sakedata select[name="sake_award2"]').prop('disabled', true);
		            }
	            });

	            $('.sakedata select[name="sake_award_name3"]').change(function(){
		            if($('.sakedata select[name="sake_award_name3"]').val() != "")
		            {
			            $('.sakedata select[name="sake_award_year3"]').prop('disabled', false);
			            $('.sakedata select[name="sake_award3"]').replaceOptions(getAwardOption($('.sakedata select[name="sake_award_name3"]').val()));
			            $('.sakedata select[name="sake_award3"]').prop('disabled', false);
		            }
		            else
		            {
			            $('.sakedata select[name="sake_award_year3"]').prop('disabled', true);
			            $('.sakedata select[name="sake_award3"]').prop('disabled', true);
		            }
	            });

                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	            if($('.sakedata select[name="sake_award_name1"]').val() != "")
	            {
		            $('.sakedata select[name="sake_award_year1"]').prop('disabled', false);
		            $('.sakedata select[name="sake_award1"]').prop('disabled', false);
	            }
	            else
	            {
		            $('.sakedata select[name="sake_award_year1"]').prop('disabled', true);
		            $('.sakedata select[name="sake_award1"]').prop('disabled', true);
	            }

	            if($('.sakedata select[name="sake_award_name2"]').val() != "")
	            {
		            $('.sakedata select[name="sake_award_year2"]').prop('disabled', false);
		            $('.sakedata select[name="sake_award2"]').prop('disabled', false);
	            }
	            else
	            {
		            $('.sakedata select[name="sake_award_year2"]').prop('disabled', true);
		            $('.sakedata select[name="sake_award2"]').prop('disabled', true);
	            }

	            if($('.sakedata select[name="sake_award_name3"]').val() != "")
	            {
		            $('.sakedata select[name="sake_award_year3"]').prop('disabled', false);
		            $('.sakedata select[name="sake_award3"]').prop('disabled', false);
	            }
	            else
	            {
		            $('.sakedata select[name="sake_award_year3"]').prop('disabled', true);
		            $('.sakedata select[name="sake_award3"]').prop('disabled', true);
	            }
            }

			////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////
		    var seimai_rate = result[0].seimai_rate;

            if(seimai_rate && seimai_rate != "") {
			    var seimai_array = seimai_rate.split(',');

			    if(seimai_array.length > 0)
				    $('.sakedata input[name="seimai_rate"]').val(seimai_array[0]);

			    if(seimai_array.length > 1)
				    $('.sakedata input[name="seimai_rate2"]').val(seimai_array[1]);

			    if(seimai_array.length > 2)
				    $('.sakedata input[name="seimai_rate3"]').val(seimai_array[2]);
            }

		    var rice_used = result[0].rice_used;

            if(rice_used && rice_used != "") {
			    var rice_array = rice_used.split('/');

			    if(rice_array.length > 0 && rice_array[0] != undefined)
			    {
				    var rice_entry1 = rice_array[0].split(',');

				    $('.sakedata select[name="rice_used"] option').each(function(){

					    if(this.value == rice_entry1[0])
					    {
						    $('.sakedata select[name="rice_used"]').val(rice_entry1[0]);

                            if(seimai_array && seimai_array.length > 0)
                                $('.sakedata input[name="seimai_rate"]').val(seimai_array[0]);

						    if(rice_entry1[1] != undefined)
							    $('.sakedata select[name="kakemai"]').val(rice_entry1[1]);

						    if(rice_entry1[2] != undefined)
							    $('.sakedata input[name="kakemai_rate"]').val(rice_entry1[2]);

						    if($('.sakedata select[name="rice_used"] option:selected').val() == "other")
						    {
							    $("#rice_used_other").css({"display":"block"});
							    $('.sakedata input[name="rice_used_other"]').val(rice_entry1[3]);
						    }

						    return false;
					    }
				    });
			    }

			    if(rice_array.length > 1 && rice_array[1] != undefined)
			    {
				    var rice_entry2 = rice_array[1].split(',');

				    $('.sakedata select[name="rice_used2"] option').each(function(){

					    if(this.value == rice_entry2[0])
					    {
						    $('.sakedata select[name="rice_used2"]').val(rice_entry2[0]);

                            if(seimai_array && seimai_array.length > 1)
						        $('.sakedata input[name="seimai_rate2"]').val(seimai_array[1]);

						    if(rice_entry2[1] != undefined)
							    $('.sakedata select[name="kakemai2"]').val(rice_entry2[1]);

						    if(rice_entry2[2] != undefined)
							    $('.sakedata input[name="kakemai_rate2"]').val(rice_entry2[2]);

						    if($('.sakedata select[name="rice_used2"] option:selected').val() == "other")
						    {
							    $("#rice_used_other2").css({"display":"block"});
							    $('.sakedata input[name="rice_used_other2"]').val(rice_entry2[3]);
						    }

						    return false;
					    }
				    });
			    }

			    if(rice_array.length > 2 && rice_array[2] != undefined)
			    {
				    var rice_entry3 = rice_array[2].split(',');

				    $('.sakedata select[name="rice_used3"] option').each(function(){

					    if(this.value == rice_entry3[0])
					    {
						    $('.sakedata select[name="rice_used3"]').val(rice_entry3[0]);

                            if(seimai_array && seimai_array.length > 2)
						        $('.sakedata input[name="seimai_rate3"]').val(seimai_array[2]);

						    if(rice_entry3[1] != undefined)
							    $('.sakedata select[name="kakemai3"]').val(rice_entry3[1]);

						    if(rice_entry3[2] != undefined)
							    $('.sakedata input[name="kakemai_rate3"]').val(rice_entry3[2]);

						    if($('.sakedata select[name="rice_used3"] option:selected').val() == "other")
						    {
							    $("#rice_used_other3").css({"display":"block"});
							    $('.sakedata input[name="rice_used_other3"]').val(rice_entry3[3]);
						    }

						    return false;
					    }
				    });
			    }
            }

			////////////////////////////////////////////////////////////////////////////////////////////////////

			if(result[0].jas != null && result[0].jas != "")
			{
				var jas_array = result[0].jas.split(',');
				var index = 0;

                if(jas_array.length == 0)
				    jas_array = result[0].jas.split('/');

			    $('.sake_container input[name="jas_code[]"]').each(function(index){
				    //alert("index:" + index + " length:" + jas_array.length);

				    if(index >= jas_array.length) {
					     return false;
				    }

				    this.value = $.trim(jas_array[index]);
			    });
            }

			////////////////////////////////////////////////////////////////////////////////////////////////////
			if(result[0].ingredients != null && result[0].ingredients != "")
            {
                var ingredients = result[0].ingredients;
			    var ingredients_array = ingredients.split(',');

			    $.each(ingredients_array, function(index, val){

			         $('.sake_container input[name="ingredients[]"]').each(function(){

				        if(val == this.value || val == parseInt(this.value))
				        {
					        this.checked = true;

                            if(val == "90")
                            {
	                            $('.sakedata input[name="ingredients_other"]').val(ingredients_array[index + 1]);
		                        $('.sakedata input[name="ingredients_other"]').prop('disabled', false);
                            }
				        }
			         });
			    });
            }

			////////////////////////////////////////////////////////////////////////////////////////////////////
			if(result[0].recommended_drink != null && result[0].recommended_drink != "")
            {
                var recommended_drink = result[0].recommended_drink;
			    var recommended_drink_array = recommended_drink.split(',');

			    $.each(recommended_drink_array, function(index, val){

			         $('.sake_container input[name="recommended_drink[]"]').each(function(){

				        if(val == this.value || val == parseInt(this.value))
				        {
					        this.checked = true;
				        }
			         });
			    });
            }

			////////////////////////////////////////////////////////////////////////////////////////////////////
			if(result[0].recommended_drink != null && result[0].recommended_drink != "")
            {
                var recommended_drink = result[0].recommended_drink;
			    var recommended_drink_array = recommended_drink.split(',');

			    $.each(recommended_drink_array, function(index, val){

			         $('.sake_container input[name="recommended_drink[]"]').each(function(){

				        if(val == this.value || val == parseInt(this.value))
				        {
					        this.checked = true;
				        }
			         });
			    });
            }

            //$('input[name="submit_button"]').css({"display":"none"});
            //$('input[name="update_button"]').css({"diplay":"block"});
            //alert("sake_name:" + $('input[name="submit_button"]').val());

	    }).fail(function(data){
		    alert("Failed:" + data);
	    }).complete(function(data){
            //;
		});

        //alert("ajax");
        return;
	});
});
