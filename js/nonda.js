////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// dialog bbs (飲んだ)
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getOrientation(imgDataURL)
{
	var byteString = atob(imgDataURL.split(',')[1]);
	var orientaion = byteStringToOrientation(byteString);
	return orientaion;

	function byteStringToOrientation(img)
	{
		var head = 0;
		var orientation;

		while(1)
		{
			if(img.charCodeAt(head) == 255 & img.charCodeAt(head + 1) == 218)
			{
				break;
			}
			if(img.charCodeAt(head) == 255 & img.charCodeAt(head + 1) == 216)
			{
				head += 2;
			}
			else
			{
			    var length = img.charCodeAt(head + 2) * 256 + img.charCodeAt(head + 3);
			    var endPoint = head + length + 2;

			    if(img.charCodeAt(head) == 255 & img.charCodeAt(head + 1) == 225)
			    {
				    var segment = img.slice(head, endPoint);
				    var bigEndian = segment.charCodeAt(10) == 77;
				    var count;

				    if(bigEndian)
				    {
					    count = segment.charCodeAt(18) * 256 + segment.charCodeAt(19);
				    }
				    else
				    {
					    count = segment.charCodeAt(18) + segment.charCodeAt(19) * 256;
				    }

				    for (i = 0; i < count; i++)
				    {
					    var field = segment.slice(20 + 12 * i, 32 + 12 * i);

					    if((bigEndian && field.charCodeAt(1) == 18) || (!bigEndian && field.charCodeAt(0) == 18))
					    {
						    orientation = bigEndian ? field.charCodeAt(9) : field.charCodeAt(8);
					    }
				    }
				    break;
			    }

			    head = endPoint;
			}

			if(head > img.length)
			{
					break;
			}
		}

		return orientation;
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
//// resize image //////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

function resizeImage(img_obj)
{
    var canvas = document.createElement("canvas");
    var max_width = 500;
    var max_height = 400;
    var width = $(img_obj).width();
    var height = $(img_obj).height();

    if(width > height) {
        if (width > max_width) {
	        height *= max_width / width;
	        width = max_width;
        }
    }
    else {
        if(height > max_height) {
	        width *= max_height / height;
	        height = max_height;
        }
    }

    //alert("width:" + width + " height:" + height);
    canvas.width = width;
    canvas.height = height;

    var ctx = canvas.getContext("2d");
    ctx.drawImage(img_obj, 0, 0, width, height);
    var dataurl = canvas.toDataURL("image/jpg");
    var ratio = 0;

    if(width > height) {
        var ratio = height / width;
        $(img_obj).height($(img_obj).width() * ratio);
        $(img_obj).attr("src", dataurl);
    }
    else {
        var ratio = width / height;
        $(img_obj).width($(img_obj).height() * ratio);
        $(img_obj).attr("src", dataurl);
    }

    return dataurl;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$(function() {

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$('#tab_bbs_container').createTabs({
		  text : $('#tab_bbs_container ul')
	});

    $('#nonda_sake_cancel').click(function() {
         $("#nonda_sake_frame").css({"display":"none"});
    });

	$(document).on('click', '.nonda_flavor_list > div', function(e){

	    //$('.nonda_flavor_category').slideToggle();
        var icon = this;

        if($(this).hasClass('flavor_highlight')) {
          $(this).removeClass('flavor_highlight');
          $('.nonda_flavor_category').slideUp();
          $('.nonda_flavor_list_note').html('2つまで選択可');
        }
        else {
            $('.nonda_flavor_list > div').removeClass('flavor_highlight');
            $(this).addClass('flavor_highlight');
            $('.nonda_flavor_item_container input[name="flavor[]"]').prop("checked", false);

            if($(icon).data("flavor") && $(icon).data("flavor") != undefined) {
                $('.nonda_flavor_item_container input[name="flavor[]"]').each(function(){

                    if($(icon).data("flavor") == this.value || $(icon).data("flavor") == parseInt(this.value))
                    {
                        this.checked = true;
                        $(this).prop("checked", true);
                    }
                });
            }

	        $('.nonda_flavor_category').slideDown();
        }
    });

    $('.nonda_flavor_list div:first-child').click(function() {
      $('.nonda_flavor_list_note').html('フレーバー<span>1</span>選択');
      $('.nonda_flavor_type_sign').css({"background":"#117DA8"});
    });

    $('.nonda_flavor_list div:last-child').click(function() {
      $('.nonda_flavor_list_note').html('フレーバー<span>2</span>選択');
      $('.nonda_flavor_type_sign').css({"background":"#A30D0D"});
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 日本酒名　自動入力
    $('#add_nonda_sake').on('keyup', function() {

        var inputText = $("#add_nonda_sake").val();
        var count = inputText.length;
        var search_limit = 24;
        var search_type = 1;
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
                $('#nonda_sake_content').empty();
                $('#nonda_sake_frame').css({"display":"block"});

                for(var i = 0; i < data.length; i++)
                {
                    //alert("filename: " + data[i].filename);
                    $('#nonda_sake_content').append('<li sake_id="' + data[i].sake_id + '" value="' + data[i].sake_name + ' ' + data[i].pref + '"><span style="width:28px"><img style="height:28px; width:auto;" src="' + data[i].filename + '"></span><span style="margin-left:4px">' + data[i].sake_name + '</span><span>' + data[i].pref + '</span></li>');
                }

                $("#nonda_sake_content").css({"visibility": "visible"});

                $("#nonda_sake_close").click(function() {
                    $("#dialog_noda_sake").css({"display":"none"});
                });

                $("#nonda_sake_content li").click(function () {

					$("#nonda_sake_content li").removeClass("checked");
					$("#nonda_sake_content li").css({"background":"#fff"});
					$("#nonda_sake_content li").css({"color":"#404040"});

					$(this).addClass("checked");
					this.style.backgroundColor = "#FFC88D";
					this.style.color = "#404040"

                    $("#add_nonda_sake").val($(this).attr("value"));
                    $("#add_nonda_sake").attr('sake_id', $(this).attr('sake_id'));
                    $("#nonda_sake_register").prop('disabled', false);
                });

            }).fail(function(data){
                //alert("Failed:" + data);
            });
        }
        else
        {
            $('#nonda_sake_frame').css({"display":"none"});
            $('#nonda_sake_content').empty();
        }
    }); // keyup
});

//hirasawa追加////////////////////////////////////////////////////////////
/*飲んだレーティング*/
$(function () {
    $("#rateYo").rateYo({
        rating: 0,
        starWidth: "28px",
        normalFill: "#d2d2d2",
        ratedFill: "#AAC81E",
		halfStar: true
    });

	/*レーティング数値表示*/
    'use strict';
    var args = {
        /*starWidth: "30px",
        ratedFill: "#efbb03",*/
        onChange: function (rating, rateYoInstance) {
          var pos = (-13) + rating * 30;
          $(this).next().text(rating).css({left : pos});
        }
    };

    $("#rateYo").rateYo({
        rating: 0,
        starWidth: "28px",
        normalFill: "#d2d2d2",
        ratedFill: "#AAC81E",
		halfStar: true
    });

	/*レーティング数値表示*/
	'use strict';
	var args = {
		/*starWidth: "30px",
		ratedFill: "#efbb03",*/
		onChange: function (rating, rateYoInstance) {

		  var pos = (-13) + rating * 30;
		  $(this).next().text(rating).css({left : pos});
		}
	};

	// start
	$('#rateYo').rateYo(args).on("rateyo.set", function (e, data) {
		var rate = parseFloat(data.rating);

        if(rate == 0) {
		    $(this).parents('.rating-box').find('.rating-input').val("--");
        }
        else
		    $(this).parents('.rating-box').find('.rating-input').val(data.rating.toFixed(1));
	});

	$('.rating-input').on('change', function() {
		var rate = parseFloat($(this).val());

		if( rate < 0 ) {
		  rate = 0;
		}
		else if( rate > 5 ) {
		  rate = 5;
		}
		else if( rate >= 0 ) {
		  rate = rate;
		}
		else if( rate <= 5 ) {
		  rate = rate;
		}
		else {
		  rate = 0;
		}

		$(this).parents('.rating-box').find('#rateYo').rateYo("rating", rate);
	});
});

//テイスティングスコア表示
$(function() {

	var rangeValue = function (elem, target) {

		return function(evt){

            if(elem.value == 0) {
			    target.textContent = "--";
            }
            else {
			    target.textContent = parseFloat(elem.value).toFixed(1);
            }
		}
	}

    $('.frame_box').each(function() {

        var bar = $(this).find('.input_range').get(0);
        var target = $(this).find('.tasting_score').get(0);
		bar.addEventListener('input', rangeValue(bar, target));
	});
});

// ajax.addEventListener("load", function(event) { completeHandler1(event, obj_img, total, status, progress); }, false);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 飲んだ 新規登録
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$(function() {

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //(function(i, file){
    //  fileReader.onload = function(evt) {
    //      alert("i:" + i + " files[i]:" + files);
    //      alert("evt:" + evt + " i:" + i + " file:" + file);
    // })(i, files[i]);
    var wait_array = [];

	var cancelEvent = function(event) {

		event.preventDefault();
		event.stopPropagation();
		return false;
	}

	function completeHandler1(event, obj, total, status, progress, loader, wait_array){
		var responseText = event.target.responseText;
		var responseArray = JSON.parse(responseText);
		var path = "images\\photo\\thumb\\" + responseArray[0];

        //alert("complete handler:" + responseText);
        //alert("sql:" + responseArray[3]);
        //var innerHTML = '<div class="bbs_photo_image"><img class="preview" src="' + path + '"></div>';
	    //$('#nonda_image .photo_container').append(innerHTML);

        $(status).html(responseArray[0]);
        $(progress).val(0);

        $(progress).css({"display":"none"});
        $(loader).css({"display":"none"});
        $(status).css({"display":"none"});
        $(total).css({"display":"none"});

        obj.removeClass('image_rotated_by_90_counter_clock', 'image_rotated_by_90_clock', 'image_rotated_by_180_clock');
        obj.attr("src", path);
        obj.removeClass('gray');

        wait_array.pop();

        if(!wait_array.length) {
            $('input[type="button"]').prop('disabled', false);
            $('#close_bbs_button').prop('disabled', false);
        }
    }

	function progressHandler1(event, total, status, progress, bShowPreview){

 		var percent = (event.loaded / event.total) * 100;

        if(bShowPreview) {
            //total.html(event.loaded + "/" + event.total + " bytes");
		    //status.html(Math.round(percent) + "% uploaded");
		    progress.val(Math.round(percent));
        }
	}

	function errorHandler1(event){
		_("status").innerHTML = "Upload Failed";
	}

	function abortHandler1(event){
		_("status").innerHTML = "Upload Aborted";
	}

	var handleDroppedFile = function(event) {

		event.preventDefault();
		event.stopPropagation();

	    var files = event.originalEvent.dataTransfer.files; // ファイルは複数ドロップされる可能性があります
        var length = event.originalEvent.dataTransfer.files.length;

        var progress = $('#nonda_image .nonda_image_photo .nonda_progress');
        var status = $('#nonda_image .nonda_image_photo .nonda_status');
        var total = $('#nonda_image .nonda_image_photo .nonda_total');

        $(progress).css({"display":"none"});
        $(status).css({"display":"none"});
        $(total).css({"display":"none"});
        //alert("legnth:" + length);

        $('input[type="button"]').prop('disabled', true);
        $('#close_bbs_button').prop('disabled', true);

        var wait_array = [];

        for(var i = 0; i < length; i++)
        {
	        var fileReader = new FileReader(); // ファイルの内容は FileReader で読み込みます.

            wait_array.push(i);

            // ドラッグ＆ドロップでファイルアップロードする場合は result の内容を Ajax でサーバに送信しましょう!
            (function(i, file, obj){

	            fileReader.onload = function(evt) {

                    //alert("evt:" + evt + " i:" + i + " file:" + file);
                    //alert("evt:" + evt.target.result);
        	        //alert("file:" + $('#nonda_image div:last-child input[type="file"]').prop("files")[0]);
        	        //$('#nonda_image div:last-child input[type="file"]').prop("files")[0] = file;

	                var data = evt.target.result;
		            var orientation = 0;

			        if(data.split(',')[0].match('jpeg') || data.split(',')[0].match('png') || data.split(',')[0].match('gif')) 
                    {
			            orientation = getOrientation(data);

			            if(orientation == 1) {
			            }
			            else if(orientation == 2) {
			            }
			            else if(orientation == 3) {
				            $('#nonda_image div:last-child img').addClass("image_rotated_by_180_clock");
			            }
			            else if(orientation == 4) {
			            }
			            else if(orientation == 5) {
			            }
			            else if(orientation == 6) {
				            $('#nonda_image div:last-child img').addClass("image_rotated_by_90_clock");
			            }
			            else if(orientation == 7) {
			            }
			            else if(orientation == 8) {
				            $('#nonda_image div:last-child img').addClass("image_rotated_by_90_counter_clock");
			            }
		            }

                    var path = "images\\icons\\noimage80.svg";
				    var innerHTML = '<div class="nonda_image_photo_container">';
		                innerHTML += '<div class="nonda_image_photo">';
		                    innerHTML += '<img class="thumb gray" src="' + path + '">';
			                innerHTML += '<div class="nonda_status_total_container">';
			                    innerHTML += '<input type="button" class="remove_pic" value="削除">';
			                    innerHTML += '<progress class="nonda_progress" value="0" max="100"></progress>';
		                        innerHTML += '<div class="loader"></div>';
                                innerHTML += '<div class="nonda_status">status</div>';
                                innerHTML += '<div class="nonda_total">total</div>';
			                innerHTML += '</div>';
                        innerHTML += '</div>';
			            innerHTML += '<div class="nonda_image_caption_container">';
			                innerHTML += '<input type="text" name="nonda_image_caption" maxlength="30" placeholder="メモ（30字以内）">';
			            innerHTML += '</div>';
		            innerHTML += '</div>';

                    $('#nonda_image_post .nonda_image_post_button_container').before(innerHTML);
                    $('.nonda_image_photo .thumb:last').attr("src", evt.target.result);

                    /////////////////////////////////////////////////////////////////////////////////////////////////////
                    /////////////////////////////////////////////////////////////////////////////////////////////////////

                    var prefix = "sn_" + (new Date()).getTime();
                    var filename =  prefix + file.name;
   			        var formdata = new FormData();

			        formdata.append("file1", file);
                    formdata.append("prefix", prefix);
                    formdata.append("id", $("#add_nonda_sake").attr("sake_id"));
                    formdata.append("contributor", $('#dialog_bbs').data('contributor'));
                    formdata.append("desc", $('input[name="nonda_image_caption"]').text());
		            formdata.append("max_width", 800);
		            formdata.append("max_height", 800);
		            formdata.append("thumb_width", 200);
		            formdata.append("thumb_height", 200);
		            formdata.append("status", 2);
			        formdata.append("tablename", "sake_image");

			        var ajax = new XMLHttpRequest();
                    var obj_img = $('.nonda_image_photo .thumb:last');
                    var loader = $('.nonda_image_photo:last').find('.loader');
                    var progress = $('.nonda_image_photo:last').find('.nonda_progress');
                    var status   = $('.nonda_image_photo:last').find('.nonda_status');
                    var total    = $('.nonda_image_photo:last').find('.nonda_total');
                    var value    = 4;

                    $(loader).css({"display":"block"});
                    $(progress).css({"display":"none"});
                    $(status).css({"display":"none"});
                    $(total).css({"display":"none"});
                    $(obj_img).data("filename", filename);

		            ajax.upload.addEventListener("progress", function(event) { progressHandler1(event, total, status, progress, true); }, false);
		            ajax.addEventListener("load", function(event) { completeHandler1(event, obj_img, total, status, progress, loader, wait_array); }, false);
		            ajax.addEventListener("error", errorHandler1, false);
		            ajax.addEventListener("abort", abortHandler1, false);
		            ajax.open("POST", "nonda_upload_image.php");
		            ajax.send(formdata);
                    //alert("send");
                }
            })(i, files[i], this);

            //$('#nonda_image div input[type="file"]').val(event.originalEvent.dataTransfer.files[i]);
        	fileReader.readAsDataURL(files[i]);
		    cancelEvent(event); // デフォルトの処理をキャンセルします.
		} // for

		return false;
	}

    //////////////////////////////////
    // ファイル変更　イベント
	$(document).on('click', '.add_nonda #nonda_image .change_pic', function() {

         //alert('add_nonda .change_pic');
         //$(this).parent().parent().find('input[type="file"]').click();
         $('#nonda_image input[type="file"]').trigger('click');
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ファイル変更
	$(document).on('change', '.add_nonda input[type="file"]', function() {

        if($('#add_nonda_sake').val() == "") {
            alert("酒を選んでください");
            return;
        }

        $('input[type="button"]').prop('disabled', true);
        $('#close_bbs_button').prop('disabled', true);

        wait_array = [];

        for(var i = 0; i < $(this).prop("files").length; i++) {

		    var reader = new FileReader(); // Create a file reader
            wait_array.push(i);

            // Set the image once loaded into file reader
            (function(file, obj){
		        reader.onload = function(e) {

                    /////////////////////////////////////////////////////////////////////////////////////////////////////
		            var data = e.target.result;
		            var orientation = 0;

			        if(data.split(',')[0].match('jpeg') || data.split(',')[0].match('png') || data.split(',')[0].match('gif')) 
                    {
                        var path = "images\\icons\\noimage80.svg";
			            var innerHTML = '<div class="nonda_image_photo_container">';
		                    // innerHTML += '<input type="file">';
	                        innerHTML += '<div class="nonda_image_photo">';
	                            innerHTML += '<img class="thumb gray" src="' + path + '">';
		                        innerHTML += '<div class="nonda_status_total_container">';
		                            innerHTML += '<input type="button" class="remove_pic" value="削除">';
		                            innerHTML += '<progress class="nonda_progress" value="0" max="100"></progress>';
 		                            innerHTML += '<div class="loader"></div>';
                                    innerHTML += '<div class="nonda_status">status</div>';
                                    innerHTML += '<div class="nonda_total">total</div>';
		                        innerHTML += '</div>';
                            innerHTML += '</div>';
		                    innerHTML += '<div class="nonda_image_caption_container">';
		                        innerHTML += '<input type="text" name="nonda_image_caption" maxlength="30" placeholder="メモ（30字以内）">';
		                    innerHTML += '</div>';
	                    innerHTML += '</div>';


                        $('#nonda_image_post .nonda_image_post_button_container').before(innerHTML);
                        $('.nonda_image_photo .thumb:last').attr("src", e.target.result);

                        var obj_img = $('.nonda_image_photo .thumb:last');
                        var loader = $('.nonda_image_photo:last').find('.loader');
                        var progress = $('.nonda_image_photo:last').find('.nonda_progress');
                        var status = $('.nonda_image_photo:last').find('.nonda_status');
                        var total = $('.nonda_image_photo:last').find('.nonda_total');
			            //alert("width:" + width + " height:" + height + " className:" + className);

                        $(loader).css({"display":"block"});
                        $(progress).css({"display":"none"});
                        $(status).css({"display":"none"});
                        $(total).css({"display":"none"});

				        orientation = getOrientation(data);
				        //alert("orientation:" + orientation);
				        //alert("data:" + data);

				        if(orientation == 6) {
					        $(obj_img).addClass("image_rotated_by_90_clock");
				        }
				        else if(orientation == 8) {
					        $(obj_img).addClass("image_rotated_by_90_counter_clock");
				        }

                        var prefix = "sn_" + (new Date()).getTime();
                        var filename =  prefix + file.name;
		                var formdata = new FormData();

		                formdata.append("file1", file);
                        formdata.append("id", $("#add_nonda_sake").attr("sake_id"));
                        formdata.append("prefix", prefix);
                        formdata.append("contributor", $('#dialog_bbs').data('contributor'));
		                formdata.append("max_width", 800);
		                formdata.append("max_height", 800);
		                formdata.append("thumb_width", 200);
		                formdata.append("thumb_height", 200);
		                formdata.append("status", 2);
		                formdata.append("tablename", "sake_image");
                        $(obj_img).data("filename", filename);

		                var ajax = new XMLHttpRequest();

		                //ajax.addEventListener("load", function(event) { completeHandler1(event, $(obj).parent()); }, false);
		                ajax.upload.addEventListener("progress", function(event) { progressHandler1(event, total, status, progress, true); }, false);
		                ajax.addEventListener("load", function(event) { completeHandler1(event, obj_img, total, status, progress, loader, wait_array); }, false);
		                ajax.addEventListener("error", errorHandler1, false);
		                ajax.addEventListener("abort", abortHandler1, false);
		                ajax.open("POST", "nonda_upload_image.php");
		                ajax.send(formdata);
			        }
			        else {
				        alert("something else");
                        wait_array.pop();

                        if(!wait_array.length) {
                            $('input[type="button"]').prop('disabled', false);
                            $('#close_bbs_button').prop('disabled', false);
                        }

                        return;
			        }

                } // end of onread function
            })($(this).prop("files")[i], this);

            reader.readAsDataURL($(this).prop("files")[i]); // load files into file reader
        } // end of for loop
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 飲んだ　編集　写真削除
	$(document).on('click', '.add_nonda .remove_pic', function() {

        //alert("remove pic:" + $(this).parent().find('img').attr("src"));
        //if($(this).parent().find('img').attr("src") == $('#nonda_image .nonda_image_photo img').attr("src"))

        var sake_id = $('#dialog_bbs').data('sake_id');
        var contributor = $('#dialog_bbs').data('contributor');
        var committed = $('#dialog_bbs').data('committed');
        var	filename = $(this).closest('.nonda_image_photo_container').find('img').data('filename');
        var data = "id="+sake_id+"&filename="+filename+"&contributor="+contributor+"&status=3";
        var obj = $(this).closest('.nonda_image_photo_container');

        //if(confirm("削除しますか ID:" + sake_id + " filename:" + filename) == true)
        //{
        var data = "id="+sake_id+"&filename="+filename+"&contributor="+contributor+"&status=3";

        //alert("data:" + data);
        //alert("add_nonda remove pic filename:" + filename);

        $.ajax({
            type: "post",
            url: "image_delete.php",
            data: data,
        }).done(function(xml){
            var str = $(xml).find("str").text();
            //alert("succeed:" + str);

            if(str == "success") {
                var index = $(this).index();
                //alert("index:" + index);

                $(obj).fadeOut(300, function() {
                    $(obj).remove();
                    var path = $('#nonda_image .photo_container .bbs_photo_image img:nth(' + index + ')').attr("src");
                    $('#nonda_image .nonda_image_photo img').attr("src", path);
                });
            }
            else {
                alert("Failed:" +str);
            }
        }).fail(function(data){
              var str = $(xml).find("str").text();
              alert("Failed:" +str);
        });
    });

    ////////////////////////////////
    // 飲んだ キャンセル
 	$(document).on('click', '.add_nonda #close_bbs_button', function() {

        //var data = "sake_id="+$("#add_nonda_sake").attr("sake_id") +"&contributor=" + $('#dialog_bbs').data('contributor') +"&write_date=" + $("#dialog_bbs").data("write_date");
        var data = "sake_id="+$('#dialog_bbs').data('sake_id') +"&contributor=" + $('#dialog_bbs').data('contributor') +"&write_date=" + $("#dialog_bbs").data("write_date");
        //alert("write_date:" + $("#dialog_bbs").data("write_date"));
        //alert("data:" + data);

        $.ajax({
            type: "post",
            url: "nonda_cancel.php",
            data: data,
        }).done(function(xml){
            var str = $(xml).find("str").text();
            var sql = $(xml).find("sql").text();

            //alert("success:" + sql);

            if(str != "success")
            {
                alert("failed to close nonda:" + str);
            }

        }).fail(function(data){
            var str = $(xml).find("str").text();
            alert("Failed:" +str);
        });

        /////////////////////////////////////////////////////////////////////////
        var path = "images\\icons\\noimage80.svg";
        /*hirasawa削除0519var innerHTML = '<div class="bbs_photo_image"><img class="preview" src="' + path + '"><progress class="nonda_progress" value="0" max="100"></progress><div class="nonda_status_total_container"><div class="nonda_status">status</div><div class="nonda_total">total</div></div>';*/

        $('#nonda_image .nonda_image_photo img').attr("src", path);
        /*hirasawa削除0519$('#nonda_image .photo_container').html(innerHTML);*/
        /////////////////////////////////////////////////////////////////////////

        $(window).off('touchmove.noscroll');
        $('html, body').css('overflow', '');
        $("#dialog_background").css({"display":"none"});
	});

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 飲んだ削除
 	$(document).on('click', '.add_nonda #dialog_bbs_delete', function() {
        //var data = "sake_id="+$("#add_nonda_sake").attr("sake_id") +"&contributor=" + $('#dialog_bbs').data('contributor') +"&write_date=" + $("#dialog_bbs").data("write_date");
        var data = "sake_id="+$('#dialog_bbs').data('sake_id') +"&contributor=" + $('#dialog_bbs').data('contributor') +"&write_date=" + $("#dialog_bbs").data("write_date");
        //alert("write_date:" + $("#dialog_bbs").data("write_date"));
        //alert("data:" + data);

        $.ajax({
            type: "post",
            url: "nonda_cancel.php",
            data: data,
        }).done(function(xml){
            var str = $(xml).find("str").text();
            var sql = $(xml).find("sql").text();

            //alert("success:" + sql);

            if(str != "success")
            {
                alert("failed to close nonda:" + str);
            }

        }).fail(function(data){
            var str = $(xml).find("str").text();
            alert("Failed:" +str);
        });

        /////////////////////////////////////////////////////////////////////////
        var path = "images\\icons\\noimage80.svg";
        /*hirasawa削除0519var innerHTML = '<div class="bbs_photo_image"><img class="preview" src="' + path + '"><progress class="nonda_progress" value="0" max="100"></progress><div class="nonda_status_total_container"><div class="nonda_status">status</div><div class="nonda_total">total</div></div>';*/

        $('#nonda_image .nonda_image_photo img').attr("src", path);
        /*hirasawa削除0519$('#nonda_image .photo_container').html(innerHTML);*/
        /////////////////////////////////////////////////////////////////////////

        $(window).off('touchmove.noscroll');
        $('html, body').css('overflow', '');
        $("#dialog_background").css({"display":"none"});
	});

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $("body").on("new_nonda", function( event, sake_id, sake_name, sake_read, sakagura_name, pref, contributor) {

        var data = "sake_id="+sake_id + "&contributor="+contributor  + "&committed=2";
        var touch_start_y;

        //alert("new_nonda:" + data);
	    $('#add_nonda_sake').val(sake_name);
		$('#dialog_bbs').data('sake_id', sake_id);
		$('#dialog_bbs').data('sake_name', sake_name);
		$('#dialog_bbs').data('sake_read', sake_read);
		$('#dialog_bbs').data('sakagura_name', sakagura_name);
		$('#dialog_bbs').data('pref', pref);
		$('#dialog_bbs').data('contributor', contributor);
        $('input[class="rating-input"]').val("--");

        //$(window).on('beforeunload', function() {
        //    return '投稿が完了していません。このまま移動しますか？';
        //});
        //
        //alert("new nonda sake_id:" + sake_id + " contributor:" + contributor);
        // タッチしたとき開始位置を保存しておく
        $(window).on('touchstart', function(event) {
            touch_start_y = event.originalEvent.changedTouches[0].screenY;
        });

        // スワイプしているとき
        $(window).on('touchmove.noscroll', function(event) {
            var current_y = event.originalEvent.changedTouches[0].screenY,
            height = $('#dialog_background').outerHeight(),
            is_top = touch_start_y <= current_y && $('#dialog_background')[0].scrollTop === 0,
            is_bottom = touch_start_y >= current_y && $('#dialog_background')[0].scrollHeight - $('#dialog_background')[0].scrollTop === height;

            // スクロール対応モーダルの上端または下端のとき
            if (is_top || is_bottom) {
              // スクロール禁止
              event.preventDefault();
            }
        });

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // input 初期化
        $('.nonda_flavor_item_container input[name="flavor[]"]').prop("checked", false);
        $('.nonda_flavor_list div').data('flavor', 0);

		$('.nonda_flavor_category').css({"display":"none"});
	    $('.nonda_flavor_list div').removeClass('flavor_highlight');
        $('.nonda_flavor_list_note').html('2つまで選択可');

        $('.nonda_flavor_list div').each(function() {
            $(this).html('<span>' + ($(this).index() + 1) + '</span>');
        });

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(sake_id != "")
        {
            $.ajax({
                type: "post",
                url: "nonda_new.php",
                data: data,
            }).done(function(xml){
                var str = $(xml).find("str").text();
                var write_date = $(xml).find("write_date").text();
                //alert("ret:" + str + " write_date:" + write_date);

                /////////////////////////////////////////////////////////////////////////
		        //var path = "images\\icons\\noimage80.svg";
		        //var innerHTML = '<div class="bbs_photo_image">さらに写真を追加</div>';
                //var innerHTML = '<div class="bbs_photo_image"><img class="preview" src="' + path + '"><progress class="nonda_progress" value="0" max="100"></progress><div class="nonda_status_total_container"><div class="nonda_status">status</div><div class="nonda_total">total</div></div>';
		        //$('#nonda_image .nonda_image_photo img').attr("src", path);
		        //$('#nonda_image .photo_container').html(innerHTML);
                /////////////////////////////////////////////////////////////////////////

                $("#dialog_bbs").data('write_date', write_date);

            }).fail(function(data){
                var str = $(xml).find("str").text();
                alert("Failed:" +str);
            });
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        $('.nonda_image_photo_container').remove();//hirasawa変更0517
	    $('#dialog_bbs').removeClass('add_nonda');
	    $('#dialog_bbs').removeClass('edit_nonda');
	    $('#dialog_bbs').addClass('add_nonda');
        $("#dialog_bbs").css({"display":"block"});

  	    // dragenter, dragover イベントのデフォルト処理をキャンセルします.
	    $('.add_nonda #nonda_image_post').bind("dragenter", cancelEvent);
	    $('.add_nonda #nonda_image_post').bind("dragover", cancelEvent);
	    $('.add_nonda #nonda_image_post').bind("drop", handleDroppedFile); // ドロップ時のイベントハンドラを設定します.

        // スクロール禁止
        $('html, body').css('overflow', 'hidden');
        $("#dialog_background").css({"display":"flex"});
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 飲んだ保存
	function progressHandler(event){
		var percent = (event.loaded / event.total) * 100;

        //$('#upload_n_total').html( "Uploaded " + event.loaded + " bytes of " + event.total);
		//$('#upload_status').html(Math.round(percent) + "% uploaded... please wait");
		$('#upload_progressBar').val(Math.round(percent));

		//_("upload_progressBar").value = Math.round(percent);
        //alert("progressHandler:" + event.total);
        //_("upload_n_total").innerHTML = "Uploaded " + event.loaded+" bytes of "+event.total;
	}

	function errorHandler(event){
		_("upload_status").innerHTML = "Upload Failed";
	}

	function abortHandler(event){
		_("upload_status").innerHTML = "Upload Aborted";
	}

	function completeHandler(event){

		var responseText = event.target.responseText;
		var responseArray = JSON.parse(responseText);

        // trigger a message so that sake_view can catch the message
		//var pathArray = responseArray[9].split(',');
        //alert("sql:" + responseArray[0]);
        //alert("responseArray[0]:" + responseArray[0]);

		$("#dialog_background").fadeOut(800);
        $("body").trigger( "nonda_saved", [ responseArray[0], responseArray[1], responseArray[2], responseArray[3], responseArray[4], responseArray[5], responseArray[6], responseArray[7], responseArray[8], responseArray[9] ] );

        // reset the preview dialog in tabs-2
        // var length = $('#nonda_image > div').length - 1;
        // $('#nonda_image > div:lt(' + length + ')').remove(); // lt selects all elements at an index less than index within the matched set
		// $("#dialog_background").fadeOut(800);

		_("upload_status").innerHTML = responseArray[0];
		_("upload_progressBar").value = 0;
	}

	$(document).on('blur', '.add_nonda input[name="nonda_image_caption"]', function() {

        var sake_id = $('#dialog_bbs').data('sake_id');
        var contributor = $('#dialog_bbs').data('contributor');
        var	desc = $(this).val();
        //var pathArray = $('#nonda_image .nonda_image_photo img').attr("src").split('\\');
        var pathArray = $(this).parent().parent().find('.thumb').attr("src").split('\\');
        var filename = pathArray[pathArray.length - 1];
        var data = "id="+sake_id+"&filename="+filename+"&desc="+desc+"&contributor="+contributor;

        //alert("data:" + data);

        $.ajax({
            type: "post",
            url: "nonda_image_desc.php",
            data: data,
        }).done(function(xml){
            var str = $(xml).find("str").text();
            var sql = $(xml).find("sql").text();

            if(str != "success")
            {
                alert("str:" + str + " succeed:" + sql);
            }
        }).fail(function(data){
              var str = $(xml).find("str").text();
              alert("Failed:" +str);
        });
    });

	$(document).on('click', '.add_nonda #dialog_bbs_ok', function() {

        var i = 0;
	    var formdata = new FormData();
        var taste_array = [];
        var path_array = [];
        var desc_array = [];
        var flavor_array = [];
        var tastes = "";

        if($('#add_nonda_sake').val() == "")
        {
            alert("酒を選んでください");
            return;
        }

        $('.nonda_flavor_list > div').each(function() {
           if($(this).data('flavor') && $(this).data('flavor') != "")
               flavor_array.push($(this).data('flavor'));
        });


        var total = $('#nonda_image > div').length;

        taste_array.push($('input[name="aroma"]').val());
        taste_array.push($('input[name="body"]').val());
        taste_array.push($('input[name="clear"]').val());
        taste_array.push($('input[name="sweetness"]').val());
        taste_array.push($('input[name="umami"]').val());
        taste_array.push($('input[name="acidity"]').val());
        taste_array.push($('input[name="bitter"]').val());
        taste_array.push($('input[name="yoin"]').val());

        for(var i = 0; i < taste_array.length; i++) {
            if(taste_array[i] != 0) {
                tastes += taste_array[i];
            }
        }

        if(tastes == "") {
            taste_array = tastes;
        }

        var rating = ($('input[class="rating-input"]').val() == "--") ? 0 : $('input[class="rating-input"]').val();

        //alert("save contributor:" + $("#dialog_bbs").data("contributor"));
        formdata.append("title", $('.add_nonda input[name="review_title"]').val());
        formdata.append("message", $('.add_nonda textarea[name="review_message"]').val());
        formdata.append("sake_id", $("#dialog_bbs").data("sake_id"));
        formdata.append("contributor", $("#dialog_bbs").data("contributor"));
        formdata.append("committed", 1);
        formdata.append("rank", rating);
        formdata.append("flavor", flavor_array);
        formdata.append("taste", taste_array);
        formdata.append("sake_name", $("#add_nonda_sake").val());
        formdata.append("write_date", $("#dialog_bbs").data("write_date"));

        // alert("flavor_array:" + flavor_array + " taste_array:" + taste_array + " path_array:" + path_array);
	    var ajax = new XMLHttpRequest();
	    ajax.upload.addEventListener("progress", progressHandler, false);
	    ajax.addEventListener("load", completeHandler, false);
	    ajax.addEventListener("error", errorHandler, false);
	    ajax.addEventListener("abort", abortHandler, false);
	    ajax.open("POST", "nonda_save.php");
	    ajax.send(formdata);
    });

    // 下書き保存
	$(document).on('click', '.add_nonda #dialog_bbs_draft', function() {

        var i = 0;
	    var formdata = new FormData();
        var taste_array = [];
        var path_array = [];
        var flavor_array = [];

        if($('#add_nonda_sake').val() == "")
        {
            alert("酒を選んでください");
            return;
        }

        $(".nonda_flavor_category > div input:checked").each(function() {
            flavor_array.push($(this).val());
        });

        var total = $('#nonda_image > div').length;

        $('#nonda_image > div').each(function(index) {
            if(index < total - 1)
            {
                //alert("this path:" + $(this).attr("path"));
                path_array.push($(this).attr("path"));
            }
        });

        //alert("flavor_array:" + flavor_array);
        formdata.append("committed", 2);
        formdata.append("flavor", flavor_array);
        formdata.append("taste", taste_array);
        formdata.append("sake_name", $("#add_nonda_sake").val());
        formdata.append("write_date", $("#dialog_bbs").data("write_date"));
        formdata.append("id", $("#add_nonda_sake").attr("sake_id"));
        formdata.append("title", $('#custom_dialog_input_argument').val());
        // formdata.append("rank", $('#custom_dialog_input_rank').val());
        formdata.append("message", $('#custom_dialog_input_message').val());
        formdata.append("imagepath", path_array);

	    var ajax = new XMLHttpRequest();
	    ajax.upload.addEventListener("progress", progressHandler, false);
	    ajax.addEventListener("load", completeHandler, false);
	    ajax.addEventListener("error", errorHandler, false);
	    ajax.addEventListener("abort", abortHandler, false);
	    ajax.open("POST", "nonda_save.php");
	    ajax.send(formdata);
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //　飲んだフレーバー
    $(".nonda_flavor_category > div input").click(function() {

	    if(this.value == $('.nonda_flavor_list div.flavor_highlight').data('flavor')) {

            var index = $('.nonda_flavor_list div.flavor_highlight').index();
	        $(this).prop("checked", false);
            $('.nonda_flavor_list div.flavor_highlight').data('flavor', 0);
            $('.nonda_flavor_list div.flavor_highlight').html('<span>' + (index + 1) + '</span>');
        }
        else {
            $('.nonda_flavor_item_container input[name="flavor[]"]:checked').prop("checked", false);
	        $(this).prop("checked", true);
            $('.nonda_flavor_list div.flavor_highlight').data('flavor', this.value);
            $('.nonda_flavor_list div.flavor_highlight').html('<svg><use xlink:href="#' + $(this).data("img") + '"/></svg>');
        }
    });

    /*
    $('body').on({
        'mousewheel': function(e) {

		        if(e.target.id == 'sake_nonda_container' || e.target.id == 'tabs_nonda_1')
		        {
				        alert('dialog_nonda_sake');
				        return;
		        }

		        e.preventDefault();
		        e.stopPropagation();
        }
    });
    */
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// nonda 編集

$(function() {

	var review_obj;

	var cancelEvent = function(event) {
		event.preventDefault();
		event.stopPropagation();
		return false;
	}

	function completeHandler1(event, obj, total, status, progress, loader, wait_array){
		var responseText = event.target.responseText;
		var responseArray = JSON.parse(responseText);
		var path = "images\\photo\\thumb\\" + responseArray[0];

        //alert("complete handler:" + responseText);
        //alert("nonda_edit sql:" + responseArray[3]);
        //var innerHTML = '<div class="bbs_photo_image"><img class="preview" src="' + path + '"></div>';
	    //$('#nonda_image .photo_container').append(innerHTML);

        //alert("path:" + path);
        obj.removeClass('image_rotated_by_90_counter_clock', 'image_rotated_by_90_clock', 'image_rotated_by_180_clock', 'gray');
        obj.removeClass('gray');
        obj.attr("src", path);

        $(status).html(responseArray[0]);
        $(progress).val(0);
        $(progress).css({"display":"none"});
        $(loader).css({"display":"none"});

        wait_array.pop();

        //alert("complete:" + wait_array.length);

        if(!wait_array.length) {
            $('input[type="button"]').prop('disabled', false);
            $('#close_bbs_button').prop('disabled', false);
        }
    }

	function progressHandler1(event, total, status, progress){

 		var percent = (event.loaded / event.total) * 100;
        //total.html(event.loaded + "/" + event.total + " bytes");
		//status.html(Math.round(percent) + "% uploaded");
		progress.val(Math.round(percent));
	}

	function errorHandler1(event){
        //alert("upload Failed");
		_("status").innerHTML = "Upload Failed";
	}

	function abortHandler1(event){
        //alert("upload Aborted");
		_("status").innerHTML = "Upload Aborted";
	}

	var handleDroppedFile = function(event) {

		event.preventDefault();
		event.stopPropagation();

	    var files = event.originalEvent.dataTransfer.files; // ファイルは複数ドロップされる可能性があります
        var length = event.originalEvent.dataTransfer.files.length;

        var progress = $('#nonda_image .nonda_image_photo .nonda_progress');
        var status = $('#nonda_image .nonda_image_photo .nonda_status');
        var total = $('#nonda_image .nonda_image_photo .nonda_total');

        $(progress).css({"display":"none"});
        $(status).css({"display":"none"});
        $(total).css({"display":"none"});
        //alert("legnth:" + length);

        $('input[type="button"]').prop('disabled', true);
        $('#close_bbs_button').prop('disabled', true);

        var wait_array = [];

        for(var i = 0; i < length; i++)
        {
	        var fileReader = new FileReader(); // ファイルの内容は FileReader で読み込みます.
            wait_array.push(i);

            // ドラッグ＆ドロップでファイルアップロードする場合は result の内容を Ajax でサーバに送信しましょう!
            (function(i, file, obj){

	            fileReader.onload = function(evt) {

                    //alert("evt:" + evt + " i:" + i + " file:" + file);
                    //alert("evt:" + evt.target.result);
        	        //alert("file:" + $('#nonda_image div:last-child input[type="file"]').prop("files")[0]);
        	        //$('#nonda_image div:last-child input[type="file"]').prop("files")[0] = file;

	                var data = evt.target.result;
		            var orientation = 0;
                    //$(imageObj).attr("src", evt.target.result);

			        if(data.split(',')[0].match('jpeg') || data.split(',')[0].match('png') || data.split(',')[0].match('gif'))
		            {
			            orientation = getOrientation(data);

			            if(orientation == 1) {
			            }
			            else if(orientation == 2) {
			            }
			            else if(orientation == 3) {
				            $('#nonda_image div:last-child img').addClass("image_rotated_by_180_clock");
			            }
			            else if(orientation == 4) {
			            }
			            else if(orientation == 5) {
			            }
			            else if(orientation == 6) {
				            $('#nonda_image div:last-child img').addClass("image_rotated_by_90_clock");
			            }
			            else if(orientation == 7) {
			            }
			            else if(orientation == 8) {
				            $('#nonda_image div:last-child img').addClass("image_rotated_by_90_counter_clock");
			            }
		            }

                    var path = "images\\icons\\noimage80.svg";
				    var innerHTML = '<div class="nonda_image_photo_container">';
		                innerHTML += '<div class="nonda_image_photo">';
		                    innerHTML += '<img class="thumb gray" src="' + path + '">';
			                innerHTML += '<div class="nonda_status_total_container">';
			                    innerHTML += '<input type="button" class="remove_pic" value="削除">';
			                    innerHTML += '<progress class="nonda_progress" value="0" max="100"></progress>';
		                        innerHTML += '<div class="loader"></div>';
                                innerHTML += '<div class="nonda_status">status</div>';
                                innerHTML += '<div class="nonda_total">total</div>';
			                innerHTML += '</div>';
                        innerHTML += '</div>';
			            innerHTML += '<div class="nonda_image_caption_container">';
			                innerHTML += '<input type="text" name="nonda_image_caption" maxlength="30" placeholder="メモ（30字以内）">';
			            innerHTML += '</div>';
		            innerHTML += '</div>';

                    $('#nonda_image_post .nonda_image_post_button_container').before(innerHTML);
                    $('.nonda_image_photo .thumb:last').attr("src", evt.target.result);

                    /////////////////////////////////////////////////////////////////////////////////////////////////////
                    /////////////////////////////////////////////////////////////////////////////////////////////////////

                    var prefix = "sn_" + (new Date()).getTime();
                    var filename =  prefix + file.name;
   			        var formdata = new FormData();

			        formdata.append("file1", file);
                    formdata.append("prefix", prefix);
                    formdata.append("id", $("#add_nonda_sake").attr("sake_id"));
                    formdata.append("contributor", $('#dialog_bbs').data('contributor'));
                    formdata.append("desc", $('input[name="nonda_image_caption"]').text());
		            formdata.append("max_width", 800);
		            formdata.append("max_height", 800);
		            formdata.append("thumb_width", 200);
		            formdata.append("thumb_height", 200);
		            formdata.append("status", 2);
			        formdata.append("tablename", "sake_image");

			        var ajax = new XMLHttpRequest();
                    var obj_img = $('.nonda_image_photo .thumb:last');
                    var progress = $('.nonda_image_photo:last').find('.nonda_progress');
                    var loader   = $('.nonda_image_photo:last').find('.loader');
                    var status   = $('.nonda_image_photo:last').find('.nonda_status');
                    var total    = $('.nonda_image_photo:last').find('.nonda_total');

                    $(loader).css({"display":"block"});
                    $(progress).css({"display":"none"});
                    $(status).css({"display":"none"});
                    $(total).css({"display":"none"});

		            ajax.upload.addEventListener("progress", function(event) { progressHandler1(event, total, status, progress, true); }, false);

		            //ajax.addEventListener("load", function(event) { completeHandler1(event, $(obj).parent()); }, false);
		            ajax.addEventListener("load", function(event) { completeHandler1(event, obj_img, total, status, progress, wait_array); }, false);
		            ajax.addEventListener("error", errorHandler1, false);
		            ajax.addEventListener("abort", abortHandler1, false);
		            ajax.open("POST", "nonda_upload_image.php");
		            ajax.send(formdata);
                }
            })(i, files[i], this);

            //$('#nonda_image div input[type="file"]').val(event.originalEvent.dataTransfer.files[i]);
        	fileReader.readAsDataURL(files[i]);
		    cancelEvent(event); // デフォルトの処理をキャンセルします.
		} // for

		return false;
	}

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ファイル変更
	$(document).on('change', '.edit_nonda input[type="file"]', function() {

        $('input[type="button"]').prop('disabled', true);
        $('#close_bbs_button').prop('disabled', true);

        var wait_array = [];

        if($('#add_nonda_sake').val() == "") {
            alert("酒を選んでください");
            return;
        }

        for(var i = 0; i < $(this).prop("files").length; i++) {

		    var reader = new FileReader(); // Create a file reader
            wait_array.push(i);

            // Set the image once loaded into file reader
            (function(file, obj){
		        reader.onload = function(e) {

			        var data = e.target.result;
			        var orientation = 0;

			        if(data.split(',')[0].match('jpeg') || data.split(',')[0].match('png') || data.split(',')[0].match('gif')) 
                    {
                        var path = "images\\icons\\noimage80.svg";
				        var innerHTML = '<div class="nonda_image_photo_container">';
			                // innerHTML += '<input type="file">';
		                    innerHTML += '<div class="nonda_image_photo">';
		                        innerHTML += '<img class="thumb gray" src="' + path + '">';
			                    innerHTML += '<div class="nonda_status_total_container">';
			                        innerHTML += '<input type="button" class="remove_pic" value="削除">';
			                        innerHTML += '<progress class="nonda_progress" value="0" max="100"></progress>';
			                        innerHTML += '<div class="loader"></div>';
                                    innerHTML += '<div class="nonda_status">status</div>';
                                    innerHTML += '<div class="nonda_total">total</div>';
			                    innerHTML += '</div>';
                            innerHTML += '</div>';
			                innerHTML += '<div class="nonda_image_caption_container">';
			                    innerHTML += '<input type="text" name="nonda_image_caption" maxlength="30" placeholder="メモ（30字以内）">';
			                innerHTML += '</div>';
		                innerHTML += '</div>';

                        $('#nonda_image_post .nonda_image_post_button_container').before(innerHTML);
                        $('.nonda_image_photo .thumb:last').attr("src", e.target.result);

                        var obj_img = $('.nonda_image_photo .thumb:last');
                        var progress = $('.nonda_image_photo:last').find('.nonda_progress');
                        var loader = $('.nonda_image_photo:last').find('.loader');
                        var status = $('.nonda_image_photo:last').find('.nonda_status');
                        var total = $('.nonda_image_photo:last').find('.nonda_total');

				        orientation = getOrientation(data);

				        //alert("orientation:" + orientation);
			            //alert("width:" + width + " height:" + height);
				        //alert("data:" + data);

				        if(orientation == 6) {
					        $(obj_img).addClass("image_rotated_by_90_clock");
				        }
				        else if(orientation == 8) {
					        $(obj_img).addClass("image_rotated_by_90_counter_clock");
				        }

                        $(loader).css({"display":"block"});
                        $(progress).css({"display":"none"});
                        $(status).css({"display":"none"});
                        $(total).css({"display":"none"});

                        ////////////////////////////////////////////////////////////////////////////////
                        var prefix = "sn_" + (new Date()).getTime();
                        var filename =  prefix + file.name;
		                var formdata = new FormData();

                        $(obj_img).data("filename", filename);
		                formdata.append("file1", file);
                        formdata.append("id", $("#add_nonda_sake").attr("sake_id"));
                        formdata.append("contributor", $('#dialog_bbs').data('contributor'));
                        formdata.append("prefix", prefix);
                        formdata.append("desc", $('input[name="nonda_image_caption"]').text());
		                formdata.append("max_width", 800);
		                formdata.append("max_height", 800);
		                formdata.append("thumb_width", 200);
		                formdata.append("thumb_height", 200);
		                formdata.append("status", 2);
		                formdata.append("tablename", "sake_image");

		                var ajax = new XMLHttpRequest();

		                ajax.upload.addEventListener("progress", function(event) { progressHandler1(event, total, status, progress, true); }, false);
		                ajax.addEventListener("load", function(event) { completeHandler1(event, obj_img, total, status, progress, loader, wait_array); }, false);
		                ajax.addEventListener("error", errorHandler1, false);
		                ajax.addEventListener("abort", abortHandler1, false);
		                ajax.open("POST", "nonda_upload_image.php");
		                ajax.send(formdata);
			        }
			        else {
				        alert("something else");
                        wait_array.pop();

                        if(!wait_array.length) {
                            $('input[type="button"]').prop('disabled', false);
                            $('#close_bbs_button').prop('disabled', false);
                        }

                        return;
			        }
                }
            })($(this).prop("files")[i], this);

            reader.readAsDataURL($(this).prop("files")[i]); // load files into file reader
        } // for loop ends
    });

    //////////////////////////////////
    // ファイル変更　イベント
	$(document).on('click', '.edit_nonda #nonda_image .change_pic', function() {
         //alert('edit_nonda .change_pic');
         //$(this).parent().parent().find('input[type="file"]').click();
         $('#nonda_image input[type="file"]').trigger('click');
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function errorHandler(event){
		_("upload_status").innerHTML = "Update Failed";
	}

	function abortHandler(event){
		_("upload_status").innerHTML = "Update Aborted";
	}

	function progressHandler(event){
		var percent = (event.loaded / event.total) * 100;
        //$('#upload_n_total').html( "Uploaded " + event.loaded + " bytes of " + event.total);
		//$('#upload_status').html(Math.round(percent) + "% uploaded... please wait");
		$('#upload_progressBar').val(Math.round(percent));
	}

	function completeHandler(event, obj){

		var responseText = event.target.responseText;
		var responseArray = JSON.parse(responseText);

        // trigger a message so that sake_view can catch the message
		// var pathArray = responseArray[9].split(',');
        // alert("sql:" + responseArray[0]);
        // alert("responseArray[0]:" + responseArray[0]);
	    $("#dialog_background").fadeOut(800);
        $("body").trigger( "nonda_saved", [ responseArray[0], responseArray[1], responseArray[2], responseArray[3], responseArray[4], responseArray[5], responseArray[6], responseArray[7], responseArray[8], responseArray[9] ] );

        // reset the preview dialog in tabs-2
        // var length = $('#nonda_image > div').length - 1;
        // $('#nonda_image > div:lt(' + length + ')').remove(); // lt selects all elements at an index less than index within the matched set
		// $("#dialog_background").fadeOut(800);

		_("upload_status").innerHTML = responseArray[0];
		_("upload_progressBar").value = 0;
	}

	$(document).on('blur', '.edit_nonda input[name="nonda_image_caption"]', function() {

        var sake_id = $('#dialog_bbs').data('sake_id');
        var contributor = $('#dialog_bbs').data('contributor');
        var	desc = $(this).val();
        //var pathArray = $('#nonda_image .nonda_image_photo img').attr("src").split('\\');
        var pathArray = $(this).parent().parent().find('.thumb').attr("src").split('\\');
        var filename = pathArray[pathArray.length - 1];
        var committed = $('#dialog_bbs').data('committed');
        var data = "id="+sake_id+"&filename="+filename+"&desc="+desc+"&contributor="+contributor;
        var obj = this;

        //alert("blur:" + $(this).parent().parent().find('.thumb').attr("src"));
        //alert("pathArray:" + $(this).parent().find('img').attr("src"));
        //alert("This input field has lost its focus:" + data);
        //alert("desc:" + desc);

        $.ajax({
            type: "post",
            url: "nonda_image_desc.php",
            data: data,
        }).done(function(xml){
            var str = $(xml).find("str").text();
            var sql = $(xml).find("sql").text();

            if(str != "success") {
                alert("failed:" + sql);
            }
        }).fail(function(data){
              var str = $(xml).find("str").text();
              alert("Failed:" +str);
        });
    });

    /* 編集保存 */
	$(document).on('click', '.edit_nonda #dialog_bbs_ok', function() {

		var total = $('#nonda_image > div').length;
		var formdata = new FormData();
		var taste_array = [];
		var flavor_array = [];
        var tastes = "";

        if($('#add_nonda_sake').val() == "")
        {
            alert("酒を選んでください");
            return;
        }

        $('.nonda_flavor_list > div').each(function() {

           if($(this).data('flavor') && $(this).data('flavor') != "")
             flavor_array.push($(this).data('flavor'));
        });

        //alert("flavor length:" +  $('.edit_nonda .nonda_flavor_item_container input[name="flavor[]"]:checked').length);
        //alert("flavors:" + flavor_array);

        taste_array.push($('input[name="aroma"]').val());
        taste_array.push($('input[name="body"]').val());
        taste_array.push($('input[name="clear"]').val());
        taste_array.push($('input[name="sweetness"]').val());
        taste_array.push($('input[name="umami"]').val());
        taste_array.push($('input[name="acidity"]').val());
        taste_array.push($('input[name="bitter"]').val());
        taste_array.push($('input[name="yoin"]').val());

        for(var i = 0; i < taste_array.length; i++) {
            if(taste_array[i] != 0) {
                tastes += taste_array[i];
            }
        }

        if(tastes == "") {
            taste_array = tastes;
        }

        var obj_img = $('.bbs_photo_image .preview:last');
        var rating = ($('input[class="rating-input"]').val() == "--") ? 0 : $('input[class="rating-input"]').val();

        //alert("sake_id:" + $("#dialog_bbs").data("sake_id"));
        formdata.append("title", $('.edit_nonda input[name="review_title"]').val());
        formdata.append("message", $('.edit_nonda textarea[name="review_message"]').val());
        formdata.append("sake_id", $("#dialog_bbs").data("sake_id"));
        formdata.append("contributor", $("#dialog_bbs").data("contributor"));
        formdata.append("rank", rating);
        formdata.append("flavor", flavor_array);
        formdata.append("taste", taste_array);
        formdata.append("sake_name", $("#add_nonda_sake").val());
        formdata.append("write_date", $("#dialog_bbs").data("write_date"));
        formdata.append("committed", 1);

		//alert("flavor_array:" + flavor_array);
		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", function(event) { completeHandler(event, obj_img); }, false);
		ajax.addEventListener("error", errorHandler1, false);
		ajax.addEventListener("abort", abortHandler1, false);

	    ajax.open("POST", "nonda_save.php");
		ajax.send(formdata);
    });

    /* 編集 下書き保存 */
	$(document).on('click', '.edit_nonda #dialog_bbs_draft', function() {

		var tablename = "sake_image";
		var total = $('#nonda_image > div').length;
		var formdata = new FormData();
		var taste_array = [];
		var path_array = [];
		var flavor_array = [];

        if($('#add_nonda_sake').val() == "")
        {
            alert("酒を選んでください");
            return;
        }

        $(".nonda_flavor_category > div input:checked").each(function() {
            flavor_array.push($(this).val());
        });

        $('.frame_box').each(function() {
            taste_array.push($(this).find('div:nth-child(2)').text());
        });

        $('#nonda_image > div').each(function(index) {
            if(index < total - 1)
            {
                //alert("this path:" + $(this).attr("path"));
                path_array.push($(this).attr("path"));
            }
        });

        formdata.append("title", $('.add_nonda input[name="review_title"]').val());
        formdata.append("message", $('.add_nonda textarea[name="review_message"]').val());
        formdata.append("sake_id", $("#dialog_bbs").data("sake_id"));
        formdata.append("contributor", $("#dialog_bbs").data("contributor"));
        formdata.append("committed", 1);
        formdata.append("flavor", flavor_array);
        formdata.append("taste", taste_array);
        formdata.append("sake_name", $("#add_nonda_sake").val());
        formdata.append("write_date", $("#dialog_bbs").data("write_date"));
        formdata.append("tablename", tablename);

		//alert("flavor_array:" + flavor_array);
		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress", progressHandler1, false);
		ajax.addEventListener("load", function(event) { completeHandler(event,  $("#dialog_bbs").attr("value")); }, false);
		ajax.addEventListener("error", errorHandler1, false);
		ajax.addEventListener("abort", abortHandler1, false);
		ajax.open("POST", "nonda_save.php");
		ajax.send(formdata);
	});

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 飲んだ　編集　写真削除
	$(document).on('click', '.edit_nonda .remove_pic', function() {

        //alert("remove pic:" + $(this).parent().find('img').attr("src"));
        //if($(this).parent().find('img').attr("src") == $('#nonda_image .nonda_image_photo img').attr("src"))

        var sake_id = $('#dialog_bbs').data('sake_id');
        var contributor = $('#dialog_bbs').data('contributor');
        var committed = $('#dialog_bbs').data('committed');
        var	filename = $(this).closest('.nonda_image_photo_container').find('img').data('filename');
        var obj = $(this).closest('.nonda_image_photo_container');

        //if(confirm("削除しますか ID:" + sake_id + " filename:" + filename) == true)
        //{
        var data = "id="+sake_id+"&filename="+filename+"&contributor="+contributor+"&status=3";
        //alert("data:" + data);

        $.ajax({
            type: "post",
            url: "image_delete.php",
            data: data,
        }).done(function(xml){
            var str = $(xml).find("str").text();
            //alert("sql:" + $(xml).find("sql").text());

            if(str == "success" || str == "file_does_not_exit") {
                var index = $(this).index();

                $(obj).fadeOut(300, function() {
                    $(obj).remove();
                    var path = $('#nonda_image .photo_container .bbs_photo_image img:nth(' + index + ')').attr("src");
                    $('#nonda_image .nonda_image_photo img').attr("src", path);
                });
            }
            else {
                alert("Failed:" +str);
            }
        }).fail(function(data){
              var str = $(xml).find("str").text();
              alert("Failed:" +str);
        });
    });

    // 飲んだ キャンセル
 	$(document).on('click', '.edit_nonda #close_bbs_button', function() {

        var data = "sake_id="+$('#dialog_bbs').data('sake_id') +"&contributor=" + $('#dialog_bbs').data('contributor');
        //alert("nonda cancel data:" + data);

        $.ajax({
            type: "post",
            url: "nonda_cancel.php",
            data: data,
        }).done(function(xml){
            var str = $(xml).find("str").text();
            var sql = $(xml).find("sql").text();
            //alert("nonda cancel:" + sql);

            if(str != "success")
            {
                //alert("failed to close nonda:" + str);
                alert("failed to close nonda sql:" + sql);
            }

        }).fail(function(data){
            var str = $(xml).find("str").text();
            alert("Failed:" +str);
        });

        $(window).off('touchmove.noscroll');
        $('html, body').css('overflow', '');
        $("#dialog_background").css({"display":"none"});
	});

    /* 飲んだ編集開く */
    $("body").on("open_nonda", function( event, subject, message, rank, added_paths, desc_array, sake_id, sake_name, sake_read, sakagura_name, pref, write_date, contributor, tastes, flavors, committed) {


        //alert("added_paths:" + added_paths);
		var innerHTML = '';

        //alert('sake_name:' + sake_name);
	    $('#add_nonda_sake').val(sake_name);
        $('input[name="review_title"]').val(subject);
        $('textarea[name="review_message"]').val(message);
        $('input[class="rating-input"]').val("--");
        //alert("desc1:" + desc_array[0] + " desc2:" + desc_array[1]  + " desc3:" + desc_array[2] + " length:" + desc_array.length);

        if(rank && rank != undefined)
           $('#rateYo').rateYo("rating", rank);


        // input 初期化
        $('.nonda_flavor_item_container input[name="flavor[]"]').prop("checked", false);
        $('.nonda_flavor_list div').data('flavor', 0);

		$('.nonda_flavor_category').css({"display":"none"});
	    $('.nonda_flavor_list div').removeClass('flavor_highlight');
        $('.nonda_flavor_list_note').html('2つまで選択可');

        $('.nonda_flavor_list div').each(function() {
            $(this).html('<span>' + ($(this).index() + 1) + '</span>');
        });


        if(flavors) {
		    var flavors_array = flavors.toString().split(',');
            var count = 1;

            $('.nonda_flavor_list').empty();

		    $.each(flavors_array, function(index, val){

			     $('.nonda_flavor_item_container input[name="flavor[]"]').each(function(){

                    if(val == this.value || val == parseInt(this.value))
                    {
                        this.checked = true;
                        var htmlText = '<div class="nonda_flavor" data-flavor= ' + this.value + '><svg><use xlink:href="#' + $(this).data("img") + '"/></svg></div>';
                        $('.nonda_flavor_list').append(htmlText);
                        count++;
                    }
                });
		    });

            for(; count <= 2; count++)
            {
                var htmlText = '<div class="nonda_flavor"><span>' + count + '</span></div>';
                $('.nonda_flavor_list').append(htmlText);
            }
        }

		$('.nonda_flavor_list div:first-child').click(function() {
			$('.nonda_flavor_list_note').html('フレーバー<span>1</span>選択');
			$('.nonda_flavor_type_sign').css({"background":"#117DA8"});
		});

		$('.nonda_flavor_list div:last-child').click(function() {
			$('.nonda_flavor_list_note').html('フレーバー<span>2</span>選択');
			$('.nonda_flavor_type_sign').css({"background":"#A30D0D"});
		});

        // alert("open_nonda subject:" + subject + " message:" + message);
		//$('#tabs-1 .rating-input').val(rank);

		$('#add_nonda_sake').attr('sake_id', sake_id);
		$('#dialog_bbs').data('rank', rank);
		$('#dialog_bbs').data('subject', subject);
		$('#dialog_bbs').data('message', message);
		$('#dialog_bbs').data('rank', rank);
		$('#dialog_bbs').data('added_paths', added_paths);
		$('#dialog_bbs').data('sake_id', sake_id);
		$('#dialog_bbs').data('sake_name', sake_name);
		$('#dialog_bbs').data('sake_read', sake_read);
		$('#dialog_bbs').data('sakagura_name', sakagura_name);
		$('#dialog_bbs').data('pref', pref);
		$('#dialog_bbs').data('write_date', write_date);
		$('#dialog_bbs').data('contributor', contributor);
		$('#dialog_bbs').data('tastes', tastes);
		$('#dialog_bbs').data('flavor', flavors);
		$('#dialog_bbs').data('committed', committed);

        if(added_paths && added_paths != "") {

  		    var pathArray = added_paths.split(', ');
            //alert("added_paths:" + added_paths);

            $('.nonda_image_photo_container').remove();//hirasawa変更0517

	        for(var i = 0; i < pathArray.length; i++)
		    {
			    //alert("path:" + pathArray[i]);
			    pathArray[i].replace(' ', '', pathArray[i]);
			    var path = "images\\photo\\" + pathArray[i];
			    //innerHTML += '<div class="bbs_photo_image">' + '<img class="preview" src="' + path + '" data-desc = "' + desc_array[i] + '">' + '</div>';

				innerHTML += '<div class="nonda_image_photo_container">';

		            innerHTML += '<div class="nonda_image_photo">';
		                innerHTML += '<img class="thumb" src="' + path + '" data-desc = "' + desc_array[i] + '" data-filename = "' + pathArray[i] + '">';
	                    innerHTML += '<div class="nonda_status_total_container">';
	                        innerHTML += '<input type="button" class="remove_pic" value="削除">';
	                        innerHTML += '<progress class="nonda_progress" value="0" max="100"></progress>';
	                        innerHTML += '<div class="loader"></div>';
                            innerHTML += '<div class="nonda_status">status</div>';
                            innerHTML += '<div class="nonda_total">total</div>';
			            innerHTML += '</div>';
                    innerHTML += '</div>';

			        innerHTML += '<div class="nonda_image_caption_container">';
			            innerHTML += '<input type="text" name="nonda_image_caption" maxlength="30" placeholder="メモ（30字以内）" value="' + desc_array[i] + '">';
			        innerHTML += '</div>';
		        innerHTML += '</div>';
		    }
        }

        $('#nonda_image_post .nonda_image_post_button_container').before(innerHTML);

		var nomitai_values = tastes.split(',');
        var i = 0;

		if(tastes)
		{
			var nomitai_values = tastes.split(',');

            $('input[name="aroma"]').val(nomitai_values[0]);
            $('input[name="body"]').val(nomitai_values[1]);
            $('input[name="clear"]').val(nomitai_values[2]);
            $('input[name="sweetness"]').val(nomitai_values[3]);
            $('input[name="umami"]').val(nomitai_values[4]);
            $('input[name="acidity"]').val(nomitai_values[5]);
            $('input[name="bitter"]').val(nomitai_values[6]);
            $('input[name="yoin"]').val(nomitai_values[7]);

		    $('.tasting_score:nth(0)').text((nomitai_values[0] == 0) ? "--" : parseFloat(nomitai_values[0]).toFixed(1));
		    $('.tasting_score:nth(1)').text((nomitai_values[1] == 0) ? "--" : parseFloat(nomitai_values[1]).toFixed(1));
		    $('.tasting_score:nth(2)').text((nomitai_values[2] == 0) ? "--" : parseFloat(nomitai_values[2]).toFixed(1));
		    $('.tasting_score:nth(3)').text((nomitai_values[3] == 0) ? "--" : parseFloat(nomitai_values[3]).toFixed(1));
		    $('.tasting_score:nth(4)').text((nomitai_values[4] == 0) ? "--" : parseFloat(nomitai_values[4]).toFixed(1));
		    $('.tasting_score:nth(5)').text((nomitai_values[5] == 0) ? "--" : parseFloat(nomitai_values[5]).toFixed(1));
		    $('.tasting_score:nth(6)').text((nomitai_values[6] == 0) ? "--" : parseFloat(nomitai_values[6]).toFixed(1));
		    $('.tasting_score:nth(7)').text((nomitai_values[7] == 0) ? "--" : parseFloat(nomitai_values[7]).toFixed(1));
		}

        ////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////
        var touch_start_y;

        // タッチしたとき開始位置を保存しておく
        $(window).on('touchstart', function(event) {
            touch_start_y = event.originalEvent.changedTouches[0].screenY;
        });

        // スワイプしているとき
        $(window).on('touchmove.noscroll', function(event) {
            var current_y = event.originalEvent.changedTouches[0].screenY,
            height = $('#dialog_background').outerHeight(),
            is_top = touch_start_y <= current_y && $('#dialog_background')[0].scrollTop === 0,
            is_bottom = touch_start_y >= current_y && $('#dialog_background')[0].scrollHeight - $('#dialog_background')[0].scrollTop === height;

            // スクロール対応モーダルの上端または下端のとき
            if(is_top || is_bottom) {
              // スクロール禁止
              event.preventDefault();
            }
        });

        // スクロール禁止
        $('html, body').css('overflow', 'hidden');
	    $('#dialog_bbs').removeClass('edit_nonda');
	    $('#dialog_bbs').removeClass('add_nonda');
	    $('#dialog_bbs').addClass('edit_nonda');
        $("#dialog_background").css({"display":"flex"});

  	    // dragenter, dragover イベントのデフォルト処理をキャンセルします.
	    $('.edit_nonda #nonda_image').bind("dragenter", cancelEvent);
	    $('.edit_nonda #nonda_image').bind("dragover", cancelEvent);
	    $('.edit_nonda #nonda_image').bind("drop", handleDroppedFile); // ドロップ時のイベントハンドラを設定します.
    });

    // 飲んだ キャンセル
 	$(document).on('click', '.edit_nonda #dialog_bbs_delete', function() {

		//var sake_id = <?php echo json_encode($sake_id); ?>;
        var data = "sake_id="+$('#dialog_bbs').data('sake_id') +"&contributor=" + $('#dialog_bbs').data('contributor');
		var obj = this;
        //alert("...delete edit_nonda:" + data);

		if(confirm("飲んだを削除しますか？") == true)
		{
		    $.ajax({
			      type: "post",
			      url: "nonda_delete.php",
			      data: data,
		    }).done(function(xml){

		        var str = $(xml).find("str").text();
		        var sql = $(xml).find("sql").text();

		        if(str == "success")
		        {
		            $("#dialog_background").css({"display":"none"});
                    $("body").trigger( "nonda_deleted", [ $('#dialog_bbs').data('sake_id'), $('#dialog_bbs').data('contributor') ] );
		        }
                else
                {
		            alert("ret:" + str);
		            alert("sql:" + sql);
                }
		    }).fail(function(data){
			    var str = $(xml).find("str").text();
			    alert("Failed:" +str);
		    });
        }
	});

 	$(document).on('click', '#tabs-1 .review_article_delete_button', function() {
        //alert("tabs_nonda click");
        $('#custom_dialog_input_argument').val('');
        $('#custom_dialog_input_message').text('');
        $('#custom_dialog_input_message').val('');
    });

 	$(document).on('click', '#tabs-1 .star_delete_button', function() {
	    $('#tabs-1 .rating-input').val(0);
        $('#rateYo').rateYo("rating", 0);
    });

    $(document).on('click', '#tabs-3 .nonda_tastingnote_delete_button', function() {

        var i = 0;

        $('#tabs-3 input[name="aroma"]').val(0);
        $('#tabs-3 input[name="body"]').val(0);
        $('#tabs-3 input[name="clear"]').val(0);
        $('#tabs-3 input[name="sweetness"]').val(0);
        $('#tabs-3 input[name="umami"]').val(0);
        $('#tabs-3 input[name="acidity"]').val(0);
        $('#tabs-3 input[name="bitter"]').val(0);
        $('#tabs-3 input[name="yoin"]').val(0);


        $('#tabs-3 .tasting_score').text('--');

        $('.nonda_flavor_category > div input').prop("checked", false);

        $('.nonda_flavor_list div').each(function() {
            $(this).data('flavor', 0);
            $(this).html('<span>' + (i + 1) + '</span>');
            i++;
        });
    });
});
