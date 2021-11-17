$(function() {

	$('.edit_sakagura_button_container .button_back, .edit_sakagura_button_container .submit_button').click(function() {
		// イベントを削除
		$(window).off('touchmove.noscroll');
		$('html, body').css('overflow', '');
		$(".dialog_add_sakagura_background").css({"display":"none"});
	});
	//hirasawaここまで

	$('#edit_sakagura_close').click(function() {

        $("body").trigger( "edit_sakagura_close", [ this ] );
	});

	$('#edit_sakagura_delete').click(function() {

        var data = "sakagura_id=" + $('#sakagura_container').data('sakagura_id');

	    $.ajax({
		    type: "POST",
		    url: "cgi/sakagura_delete.php",
		    data: data,
        }).done(function(xml){
            var str = $(xml).find("str").text();

            if(str != "success")
            {
                var str = $(xml).find("sql").text();
		        alert("success:" + str);
            }

	    }).fail(function(data){
		    alert("Failed:" + data);
	    }).complete(function(data){
            ; //removeLoading();
		});
    });

    $("body").on( "open_edit_sakagura", function( event, sakagura_id, sakagura_name) {

        var data = "category=3&from=0&sakagura_id=" + sakagura_id;
        //alert("open_edit_sakagura:" + sakagura_name);

        $('.sakagura_container').data('sakagura_id', sakagura_id);

        //alert("open_edit_sake:data:" + data);
        //dispLoading("処理中...");

	    $.ajax({
		    type: "POST",
		    url: "cgi/complex_search.php",
		    data: data,
		    dataType: 'json',

	    }).done(function(data){

            //alert("success");
		    var sakagura = data[0].result;
            //alert("sakagura_english:" + sakagura[0].sakagura_english);
            //alert("establishment:" + $('input[name="establishment"]').val());

            $('input[name="sakagura_name"]').val(sakagura_name);
            $('input[name="sakagura_read"]').val(sakagura[0].sakagura_read);
            $('input[name="sakagura_english"]').val(sakagura[0].sakagura_english);
            $('input[name="pref"]').val(sakagura[0].pref);
            $('input[name="postal_code"]').val(sakagura[0].postal_code);
            $('input[name="address"]').val(sakagura[0].address);
            $('input[name="phone"]').val(sakagura[0].phone);
            $('input[name="representative"]').val(sakagura[0].representative);
            $('input[name="touji"]').val(sakagura[0].touji);
            $('input[name="email"]').val(sakagura[0].email);
            $('input[name="url[]"]').val(sakagura[0].url);
            $('input[name="fax"]').val(sakagura[0].fax);
            $('textarea[name="award_history"]').val(sakagura[0].award_history);
            $('input[name="observation"]').val(sakagura[0].observation);
            $('textarea[name="observatory_info"]').val(sakagura[0].observatory_info);
            $('input[name="direct_sale"]').val(sakagura[0].direct_sale);
            $('input[name="brand"]').val(sakagura[0].brand);

            $('select[name="pref"] option').each(function(){

                if(this.value == sakagura[0].pref)
				{
					 $('select[name="pref"]').val(sakagura[0].pref);
					 return false;
				}
			});

            $('select[name="establishment"] option').each(function(){

                //alert("establishmament:" + sakagura[0].establishment);
                var yearArray = sakagura[0].establishment.split(',');
    
                if(this.value == yearArray[0])
				{
					$('select[name="establishment"]').val(yearArray[0]);

		            if(yearArray[0] == 9999)
		            {
			            if($('input[name="other_year"]').prop("disabled") == true)
			            {
				            $('input[name="other_year"]').prop('disabled', false);
				            $('input[name="other_year"]').val(yearArray[1]);
			            }
		            }

					return false;
				}
			});

            $('select[name="observation"] option').each(function(){

                if(this.value == sakagura[0].observation)
				{
					 $('select[name="observation"]').val(sakagura[0].observation);
					 return false;
				}
			});

            $('select[name="direct_sale"] option').each(function(){

                if(this.value == sakagura[0].direct_sale)
				{
					 $('select[name="direct_sale"]').val(sakagura[0].direct_sale);
					 return false;
				}
			});

            // alert("sakagura_search:" + sakagura[0].sakagura_search);

            if(sakagura[0].sakagura_search && sakagura[0].sakagura_search != "") {
                var sakagura_search_array = sakagura[0].sakagura_search.split(',');
                var i = 0;

		        $('input[name="sakagura_search[]"]').each(function(){
                    if(i < sakagura_search_array.length) {
                        $(this).val(sakagura_search_array[i]);
                    }

                    i++
		        });
            }

            $('input[name="url[]"]').val(sakagura[0].url);

            if(sakagura[0].url && sakagura[0].url != "") {
                var url_array = sakagura[0].url.split(',');
                var i = 0;

		        $('input[name="url[]"]').each(function(){
                    if(i < url_array.length) {
                        $(this).val(url_array[i]);
                    }

                    i++
		        });
            }

	    }).fail(function(data){
		    alert("Failed:" + data);
	    }).complete(function(data){
            ; //removeLoading();
		});
 	});
});
