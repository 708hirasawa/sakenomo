
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function AutoLink(str) {
    var regexp_url = /((h?)(ttps?:\/\/[a-zA-Z0-9.\-_@:/~?%&;=+#',()*!]+))/g; // ']))/;
    var regexp_makeLink = function(all, url, h, href) {
		return '<a href="h' + href + '" target="_blank">' + url + '</a>';
    }

    return str.replace(regexp_url, regexp_makeLink);
}

$(function() {

	function _(el){
		return document.getElementById(el);
	}

	function progressHandler(event){
		_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
		var percent = (event.loaded / event.total) * 100;
		_("progressBar").value = Math.round(percent);
		_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
	}

	function completeHandler(event){
		var responseText = event.target.responseText;
		var responseArray = JSON.parse(responseText);
		var path = "images\\" + responseArray[0];

		//alert("array[0]:" + responseArray[0] + " array[1]:" + responseArray[1] + " array[2]:" + responseArray[2] + " array[3]:" + responseArray[3]);

		if($('#hidden_data_type').val() == "sakagura")
		{
			path = "images\\sakagura\\" + responseArray[0];
		}

		/*
		_("status").innerHTML = event.target.responseText;
		_("progressBar").value = 0;
		*/

		_("status").innerHTML = responseArray[0];
		_("progressBar").value = 0;

		var innerHTML = '<div style="float:left; height:200px; width:auto; margin:8px;"><div style="position:relative;">' +
				'<img style="height:180px; width:auto; border-radius: 6px; box-shadow: 1px 1px 1px -1px rgba(0,0,0,.9);" id="' + responseArray[0] + '" class="preview" src="' + path + '">' +
				'<button style="position:absolute; right:0px; top:0px; width:46; height:22" filename ="' + responseArray[0] + '" class="navigate_button">çÌèú</button>' +
				'<span style="position:absolute; left:0px; top:165px; color:#fff">' + responseArray[0] + '</span></div></div>';

		$element = $('#page').prepend(innerHTML);
		//$element.effects("highlight", {}, 2000);
		$("#dialog_background").css({"display":"none"});
		$("#dialog_addimage").fadeOut();
	}

	function errorHandler(event){
		_("status").innerHTML = "Upload Failed";
	}

	function abortHandler(event){
		_("status").innerHTML = "Upload Aborted";
	}

	$('#upload_image').click(function() {

		var file = _("file1").files[0];

		if(file)
		{
			var formdata = new FormData();

			formdata.append("file1", file);
			formdata.append("id", $('#hidden_id').val());
			formdata.append("title", $('#hidden_title').val());
			formdata.append("data_type", $('#hidden_data_type').val());

			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler, false);
			ajax.addEventListener("load", completeHandler, false);
			ajax.addEventListener("error", errorHandler, false);
			ajax.addEventListener("abort", abortHandler, false);
			ajax.open("POST", "data_upload_parser.php");
			ajax.send(formdata);
		}
	});

	$('#file1').change(function() {

		var filesToUpload = document.getElementById('file1').files;
		var file = filesToUpload[0];
		var reader = new FileReader(); // Create a file reader
		var imageobj = $('#image');

		reader.onload = function(e) {

			var canvas = document.createElement("canvas");
			var max_width = 500;
			var max_height = 400;

			$('#image').attr("src", e.target.result);

			var width = $('#image').width();
			var height = $('#image').height();

			if(width > height)
			{
				if (width > max_width)
				{
					height *= max_width / width;
					height = Math.floor(height);
					width = max_width;
				}
			}
			else
			{
				if(height > max_height)
				{
					width *= max_height / height;
					width = Math.floor(width);
					height = max_height;
				}
			}

			canvas.width = width;
			canvas.height = height;

			var ctx = canvas.getContext("2d");
			var data = e.target.result;
			var orientation = 0;
			var className = $("#image").attr("class");

			//alert("width:" + width + " height:" + height);

			if(className)
			{
				$("#image").removeClass(className);
			}

			if(data.split(',')[0].match('jpeg'))
			{
				var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);
				var isIE = /*@cc_on!@*/false || !!document.documentMode;
				var isChrome = !!window.chrome && !!window.chrome.webstore;
				var isFirefox = typeof InstallTrigger !== 'undefined';

				//alert("safari:" + isSafari + " isIE:" + isIE + " isChrome:" + isChrome);

				if(isChrome == true || isIE == true || isFirefox == true)
				{
					orientation = getOrientation(data);
					//alert("orientation:" + orientation);

					if(orientation == 1)
					{
						//ctx.transform(1, 0, 0, 1, 0, 0);
					}
					else if(orientation == 2)
					{
						//ctx.transform(-1, 0, 0, 1, width, 0);
					}
					else if(orientation == 3)
					{
						$("#image").addClass("image_rotated_by_180_clock");
						//ctx.transform(-1, 0, 0, -1, width, height);
					}
					else if(orientation == 4)
					{
						//ctx.transform(1, 0, 0, -1, 0, height);
					}
					else if(orientation == 5)
					{
						//ctx.transform(0, 1, 1, 0, 0, 0);
					}
					else if(orientation == 6)
					{
						$("#image").addClass("image_rotated_by_90_clock");
						//ctx.transform(0, 1, -1, 0, height , 0);
					}
					else if(orientation == 7)
					{
						//ctx.transform(0, -1, -1, 0, height , width);
					}
					else if(orientation == 8)
					{
						$("#image").addClass("image_rotated_by_90_counter_clock");
						//ctx.transform(0, -1, 1, 0, 0, width);
					}
				}
			}
			else
			{
					alert("something else");
			}

			ctx.drawImage(img, 0, 0, width, height);
			var dataurl = canvas.toDataURL("image/jpg");
		}

		reader.readAsDataURL(file); // load files into file reader
	});

	// é ê^ÇçÌèúÇ∑ÇÈ
	$("#page").delegate('button', 'click', function() {

		var filename = $(this).attr('filename');
		var sakagura_id = $('#hidden_id').val();
		var data_type = $('#hidden_data_type').val();
		var obj = this;

		if(confirm("çÌèúÇµÇ‹Ç∑Ç© ID:" + sakagura_id + " filename:" + filename) == true)
		{
			var data = "id="+sakagura_id+"&data_type="+data_type+"&filename="+filename;
			//alert("data:" + data);

			$.ajax({
					type: "post",
					url: "image_delete.php",
					data: data,
			}).done(function(xml){
					var str = $(xml).find("str").text();

					if(str == "success")
					{
						//alert("success");
						$(obj).closest('div').fadeOut();
					}
					else
					{
						alert("SQL returned Failed:" +str);
					}
			}).fail(function(data){
						var str = $(xml).find("str").text();
						alert("Failed:" +str);
			});
		}
	});

});

function nl2br(str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display

    return (str + '')
      .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
} // nl2br


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function update_dialog(dialog_name){
		var element_width  = $(dialog_name).width();
		var element_height = $(dialog_name).height();

		var w = $(window).width();
		var h = (document.body.clientHeight < document.documentElement.clientHeight) ? document.body.clientHeight : document.documentElement.clientHeight;

		var element_x = (w / 2) - (element_width / 2);
		var element_y = (h / 2) - (element_height / 2);
		var	offset_x = window.pageXOffset;
		var	offset_y = 0; //window.pageYOffset;

		$(dialog_name).css({left:element_x + offset_x, top:element_y + offset_y});

		if(w < 700)
		{
				$(dialog_name).css({"width": "96%"});
				$(dialog_name).css({"height": "460px"});
		}
		else
		{
				$(dialog_name).css({"width": "70%"});
				$(dialog_name).css({"height": "560px"});
		}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// é ê^Çí«â¡Ç∑ÇÈ
$(function() {
	$('#addimage').click(function(){

			var element_width  = $("#dialog_addimage").width();
			var element_height = $("#dialog_addimage").height();
			var w = $(window).width();
			var h = (document.body.clientHeight < document.documentElement.clientHeight) ? document.body.clientHeight : document.documentElement.clientHeight;

			var element_x = (w / 2) - (element_width  / 2);
			var element_y = (h / 2) - (element_height / 2);
			var	offset_x = window.pageXOffset;
			var	offset_y = 0; //window.pageYOffset;

			$("#dialog_addimage").css({left:element_x + offset_x, top:element_y + offset_y});
			$("#dialog_background").css({"display":"block"});
			$("#dialog_addimage").css({"display":"block"});
	});

	$('#close_addimage_button').click(function(){
			$("#dialog_background").css({"display":"none"});
			$("#dialog_addimage").css({"display":"none"});
	});

	$('#edit_addimage_close').click(function(){
			$("#dialog_background").css({"display":"none"});
			$("#dialog_addimage").css({"display":"none"});
	});
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// prev, next sake
$(function() {

	var in_disp_from = 0;
	var in_disp_to = 25;
	var disp_max = 25;

	function searchSake(in_disp_from, disp_max, data, bCount)
	{
		    //dispLoading("èàóùíÜ...");
			//alert("searchsake:" + data);

			$.ajax({
					type: "POST",
					url: "complex_search.php",
					data: data,
					dataType: 'json',
	    
			}).done(function(data){
	        
					var innerHTML = "";
					var i = 0;
					var count_result = data[0].syuhanten;
					var sake = data[0].sake;

					//alert("success count_result:" + count_result + " sql:" + data[0].sakagura);          
					//$result1[] = array('sake_name' => $row["sake_name"], 'name' => $row["sake_read"], 'special_name' => $special_name, 'sake_id' => $row["sake_id"], 'sakagura_name' => $row["sakagura_name"], 'alcohol_level' => $row["alcohol_level"], 'jsake_level' => $row["jsake_level"], 'rice_used' => $rice_used, 'seimai_rate' => $row["seimai_rate"], 'sake_category' => $sake_category, 'filename' => $imagefile, 'sake_rank' => $row["sake_rank"], 'pref' => $row["pref"], 'address' => $row["address"], 'phone' => $row["phone"], 'url' => $row["url"], 'write_date' => $intime);

					$('#search_sake_result').empty()

					for(i = 0; i < sake.length; i++) 
					{
						innerHTML = '<div class="searchRow">';
						innerHTML += '<div><img src="' + sake[i].filename + '"></div>';

						innerHTML += '<div>';
						innerHTML += '<button class="custom_button" sake_id=' + sake[i].sake_id + '><span style="overflow:auto"><span class="button_icon"><img src="images/icons/heart.svg"></span><span class="button_text">à˘Ç›ÇΩÇ¢</span></span></button>';
						innerHTML += '<button class="custom_button" sake_id=' + sake[i].sake_id + '><span style="overflow:auto"><span class="button_icon"><img src="images/icons/pin.svg"></span><span class="button_text">à˘ÇÒÇæ</span></span></button>';
						innerHTML += '</div>';

						innerHTML += '<div><a class="search_sake_name" href= "sake_view.php?sake_id=' + sake[i].sake_id + '">' + sake[i].sake_name + '</a></div>';
						innerHTML += '<div><img class="search_sake_image" src="images/icons/top.svg"><span>' + sake[i].sakagura_name + '</span><span style="margin-left:2px;">/</span><span style="margin-left:2px;">' + sake[i].pref + '</span><span style="margin-left:2px;">' + sake[i].address + '</span></div>';
						innerHTML += '<div class="search_sake_date">' + sake[i].write_date + '</div>';
						innerHTML += '<div>';

						for(var j = 0; j < sake[i].sake_rank && j < 5; j++)
						{
								//innerHTML += '&#9733';
								innerHTML += '<svg  version="1.1" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;"'; 
								innerHTML += ' width="21" height="18" viewBox="-0.758 -0.272 21 21" enable-background="new -0.758 -0.272 21 21" xml:space="preserve">';
								innerHTML += '	<polygon fill="#D55319" points="0,7.64 5,12.763 3.82,20 6,18.794 6,6.722 "/>';
								innerHTML += '	<polygon fill="#D55319" points="10,0 6.91,6.583 6,6.722 6,18.794 10,16.583 "/>';
								innerHTML += '	<polygon fill="#D55319" points="13.088,6.583 10,0 10,16.583 14,18.794 14,6.723 "/>';
								innerHTML += '	<polygon fill="#D55319" points="15,12.763 20,7.64 14,6.723 14,18.794 16.178,20 "/>';
								innerHTML += '	</svg>';
						}

						for(; j < 5; j++)
						{
								//innerHTML += '&#9734';
								innerHTML += '<svg  version="1.1" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;"'; 
								innerHTML += ' width="21" height="18" viewBox="-0.046 -0.845 21 21" enable-background="new -0.046 -0.845 21 21" xml:space="preserve">';
								innerHTML += '	<polygon fill="#B1B0B1" points="0,7.64 5,12.763 3.82,20 6,18.794 6,6.722 "/>';
								innerHTML += '	<polygon fill="#B1B1B2" points="10,0 6.91,6.583 6,6.722 6,18.794 10,16.583 "/>';
								innerHTML += '	<polygon fill="#B1B1B2" points="13.088,6.583 10,0 10,16.583 14,18.794 14,6.723 "/>';
								innerHTML += '  <polygon fill="#B1B1B2" points="15,12.763 20,7.64 14,6.723 14,18.794 16.178,20 "/>';
								innerHTML += '  </svg>';
						}

						innerHTML += '</div>';

						innerHTML += '<div class="spec">';

						innerHTML += '<div>';

							innerHTML += '<div class="seihou"><img src="images/icons/specialname.svg">ì¡íËñºèÃ</div>';

							if(sake[i].special_name && sake[i].special_name != "")
							{
								innerHTML += '<div class="seihou">' + sake[i].special_name + '</div>';
							}
							else
							{
								innerHTML += '<div class="seihou">--</div>';
							}

						innerHTML += '</div>';


						innerHTML += '	<div>';	
						innerHTML += '		 <div class="seihou"><img src="images/icons/alcohol.svg">ÉAÉãÉRÅ[Éã</div>';
						innerHTML += '		 <div class="seihou">';
						
						if(sake[i].alcohol_level != undefined)
						{
							var alcohol_array = sake[i].alcohol_level.split(',');

							if(alcohol_array.length == 1)
								innerHTML += alcohol_array[0];
							else
							{
								if(alcohol_array[0] == alcohol_array[1])
									innerHTML += alcohol_array[0] + 'ìx';
								else if(alcohol_array[0] != "" && alcohol_array[1] != "")
									innerHTML += alcohol_array[0] + 'Å`' + alcohol_array[1] + 'ìx';
								else if(alcohol_array[0] != "" && alcohol_array[1] == "")
									innerHTML += alcohol_array[0] + 'ìx';
								else if(alcohol_array[0] == "" && alcohol_array[1] != "")
									innerHTML += alcohol_array[1] + 'ìxà»â∫';
							}
						}
						else
						{
							innerHTML += '--';
						}
							
						innerHTML += '  </div>';
						innerHTML += '	</div>';

						innerHTML += '	<div>';	
						innerHTML += '		 <div class="seihou"><img src="images/icons/syubei.svg">å¥óøïƒ</div>';
						innerHTML += '		 <div class="seihou">' + sake[i].rice_used + '</div>';
						innerHTML += '	</div>';

						innerHTML += '	<div>';	
						innerHTML += '	     <div class="seihou"><img src="images/icons/seimai.svg">ê∏ïƒï‡çá</div>';
						innerHTML += '	     <div class="seihou">';
						
						if(sake[i].seimai_rate != undefined)
						{
							var seimai_array = sake[i].seimai_rate.split(',');

							for(var j = 0; j < seimai_array.length; j++)
							{
								if(seimai_array[j])
								{
									innerHTML += seimai_array[j] + '%';

									if(j < seimai_array.length - 1 && seimai_array[j + 1])
										innerHTML += ', ';
								}
							}
						}
						else
						{
							innerHTML += '--';
						}
						
						innerHTML += '	</div>';
						innerHTML += '	</div>';
						
						innerHTML += '	<div>';	
						innerHTML += '	   <div class="seihou"><img src="images/icons/syudo.svg">ì˙ñ{éìx</div>';
						innerHTML += '		 <div class="seihou">';
						
						if(sake[i].jsake_level != undefined)
						{
							var syudo_array = sake[i].jsake_level.split(',');

							if(syudo_array.length == 1 && syudo_array[0])
							{
								innerHTML += syudo_array[0];
							}
							else if(syudo_array.length > 1 && (syudo_array[0] && syudo_array[1]))
							{
								if(syudo_array[0] && (syudo_array[1] == null || syudo_array[1] == ""))
									innerHTML += syudo_array[0];
								else if(syudo_array[0] == null && syudo_array[1])
									innerHTML += syudo_array[1] + "à»â∫";
								else if(syudo_array[0] == syudo_array[1])
									innerHTML += syudo_array[0];
								else
									innerHTML += syudo_array[0] + "Å`" + syudo_array[1];
							}						
						}
						else
						{
							innerHTML += '--';
						}
						
						innerHTML += '	</div>';
						innerHTML += '	</div>';

						innerHTML += '	<div>';	
						innerHTML += '		 <div class="seihou"><img src="images/icons/sando.svg">é_ìx</div>';
						innerHTML += '		 <div class="seihou">';
						
						if(sake[i].oxidation_level != undefined)
						{
							var oxidation_array = sake[i].oxidation_level.split(',');

							if(oxidation_array.length == 1 && oxidation_array[0])
							{
								innerHTML += oxidation_array[0];
							}
							else if(oxidation_array.length > 1 && (oxidation_array[0] && oxidation_array[1]))
							{
								if(oxidation_array[0] && (!oxidation_array[1] || oxidation_array[1] != ""))
									innerHTML += oxidation_array[0];
								else if((!oxidation_array[0] || oxidation_array[0] != "") && oxidation_array[1])
									innerHTML += oxidation_array[1];
								else if(oxidation_array[0] == oxidation_array[1])
									innerHTML += oxidation_array[0];
								else
									innerHTML += oxidation_array[0] + "Å`" + oxidation_array[1];
							}
						}
						else
						{
							innerHTML += '--';
						}
												
						innerHTML += '	</div>';
						innerHTML += '	</div>';

						innerHTML += '	<div>';	
						innerHTML += '		 <div class="seihou"><img src="images/icons/alcohol.svg">êªñ@ÇÃì¡í•</div>';
						innerHTML += '		 <div class="seihou">';
						
						if(sake[i].sake_category != undefined)
							innerHTML += sake[i].sake_category;
												
						innerHTML += '	</div>';
						innerHTML += '	</div>';

						innerHTML += '	<div>';	
						innerHTML += '		 <div class="seihou"><img src="images/icons/amino.svg">ÉAÉ~Émé_ìx</div>';
						innerHTML += '		 <div class="seihou style="text-align:center">';
						
						if(sake[i].amino_level != undefined)
						{
							var amino_array = sake[i].amino_level.split(',');

							if(amino_array.length == 1 && amino_array[0])
							{
								innerHTML += amino_array[0];
							}
							else if(amino_array.length > 1 && (amino_array[0] && amino_array[1]))
							{
								if(amino_array[0] && (!amino_array[1] || amino_array[1] != ""))
									innerHTML += amino_array[0];
								else if((!amino_array[0] || amino_array[0] != "") && amino_array[1])
									innerHTML += amino_array[1];
								else if(amino_array[0] == amino_array[1])
									innerHTML += amino_array[0];
								else
									innerHTML += amino_array[0] + "Å`" + amino_array[1];
							}

						}
						else
						{
							innerHTML += '--';
						}
							
						innerHTML += '</div>';
						innerHTML += '</div>';
						innerHTML += '</div>';
						innerHTML += '</div>';

						$('#search_sake_result').append(innerHTML);
					}
			
					var limit = ((in_disp_from + disp_max) >= $("#hidden_sake_count_query").val()) ? $("#hidden_sake_count_query").val() : (in_disp_from + disp_max);

					$('#disp_sake').text((in_disp_from + 1) + " Å` " + limit + "/ëS" + $("#hidden_sake_count_query").val() + "åè");

					if(in_disp_from == 0)
					{
						$("#prev_sake").css({"visibility":"hidden"});
						$("#next_sake").css({"visibility":"visible"});
					}
					else if((in_disp_from + 25) > $("#hidden_sake_count_query").val())
					{
						$("#prev_sake").css({"visibility":"visible"});
						$("#next_sake").css({"visibility":"hidden"});
					}
					else
					{
						$("#prev_sake").css({"visibility":"visible"});
						$("#next_sake").css({"visibility":"visible"});
					}

			}).fail(function(data){
					alert("Failed:" + data);
			}).complete(function(data){
					// LoadingÉCÉÅÅ[ÉWÇè¡Ç∑
					removeLoading();
			});
    }

	$(document).on('click', '#next_sake', function(e){

		var data = "search_category=2";
		var username = <?php echo json_encode($username); ?>; 
		var sakagura_id = <?php echo json_encode($id); ?>;
	
		if((in_disp_from + 25) < $("#hidden_sake_count_query").val())			
		{
			in_disp_from += 25;
			in_disp_to += 25;
		
			data += "&sakagura_id="+sakagura_id+"&in_disp_from="+in_disp_from+"&in_disp_to="+in_disp_to + "&orderby=write_date";
			//var data = ""in_disp_from="+in_disp_from+"&disp_max="+ (in_disp_from + disp_max) +"&username="+username+"&orderby="+ $("#hidden_order_by").val()+"&pref="+ $('span[name="sake_pref"]').attr("value")+"&special_name="+$('span[name="special_name"]').attr("value") + "&count_query=1";
			//alert('next_sake:' + data);

			searchSake(in_disp_from, disp_max, data, false);
		}
	});

	$(document).on('click', '#prev_sake', function(e){

		var data = "search_category=2";
		var username = <?php echo json_encode($username); ?>; 
		var sakagura_id = <?php echo json_encode($id); ?>;
				
		if((in_disp_from - 25) >= 0)
		{
			in_disp_from -= 25;
			in_disp_to -= 25;

			data += "&sakagura_id="+sakagura_id+"&in_disp_from="+in_disp_from+"&in_disp_to="+in_disp_to + "&orderby=write_date";
			//alert("prev_data:" + data);

			searchSake(in_disp_from, disp_max, data, false);
		}
	});
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// éë†çXêVÉCÉxÉìÉg
$(function() {

		$('#dialog_edit_sakagura > div:first-child').dblclick(function() {
			
			$('#dialog_edit_sakagura').toggleClass("maximizeEdit");
		});

		$('input[name="kokuzei"]').each(function(){
				if($("#hidden_kokuzei").val() == this.value)
				{
						this.checked = true;
						$(this).attr("prev", true);
						//break;
				}
				else
				{
						$(this).attr("prev", false);
				}
		});

		$('input[name="kumiai"]').click(function() {

				//alert("prev:" + $(this).attr('prev') + " checked:" + $(this).prop('checked'));

				if($(this).attr('prev') == "true")
				{
						$(this).prop('checked', false);
						$(this).attr('prev', false);
				}
				else
				{
						$(this).prop('checked', true);
						$(this).attr('prev', true);
				}
		});

		$('input[name="kokuzei"]').click(function() {
			if($(this).attr('prev') == "true")
			{
					$(this).prop('checked', false);
					$(this).attr('prev', false);
			}
			else
			{
					$(this).prop('checked', true);
					$(this).attr('prev', true);
			}
		});

		$('input[name="status"]').click(function() {

				//alert("prev:" + $(this).attr('prev') + " checked:" + $(this).prop('checked'));

				if($(this).attr('prev') == "true")
				{
						$(this).prop('checked', false);
						$(this).attr('prev', false);
				}
				else
				{
						$(this).prop('checked', true);
						$(this).attr('prev', true);
				}
		});
		

    $('#dialog_postal_code').change(function(){
				var txt = $(this).val();
				var han = txt.replace(/[Ç`-ÇyÇÅ-ÇöÇO-ÇX]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
				$(this).val(han);
    });


    $('#dialog_phone').change(function(){
				var txt = $(this).val();
				var han = txt.replace(/[Ç`-ÇyÇÅ-ÇöÇO-ÇX]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
				$(this).val(han);
    });

    $('#dialog_fax').change(function(){
				var txt = $(this).val();
				var han = txt.replace(/[Ç`-ÇyÇÅ-ÇöÇO-ÇX]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
				$(this).val(han);
    });

    $('#dialog_url').change(function(){
				var txt = $(this).val();
				var han = txt.replace(/[Ç`-ÇyÇÅ-ÇöÇO-ÇX]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
				$(this).val(han);
    });

    $('#dialog_email').change(function(){
				var txt = $(this).val();
				var han = txt.replace(/[Ç`-ÇyÇÅ-ÇöÇO-ÇX]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
				$(this).val(han);
    });

    $('#dialog_other_year').change(function(){
				var txt = $(this).val();
				var han = txt.replace(/[Ç`-ÇyÇÅ-ÇöÇO-ÇX]/g,function(s){return String.fromCharCode(s.charCodeAt(0)-0xFEE0)});
				$(this).val(han);
    });

		$("#dialog_establishment").change(function(){

				if($("#dialog_establishment").val() == 9999)
				{
						if($('#dialog_other_year').prop("disabled") == true)
						{
							$('#dialog_other_year').prop('disabled', false);
						}
				}
				else
				{
						$('#dialog_other_year').prop('disabled', true);
				}

				return true;
		});


	 $("#update_sakagura").click(function() {

		var sakagura_id = <?php echo json_encode($id); ?>;
		var establishment = $('#hidden_establishment').val();
		var establishment_array = establishment.split(',');

		$("#dialog_sakagura_id").val($("#sakagura_id").text());
		$("#dialog_pref").val($("#pref").text());
		$("#dialog_pref_read").val($("#hidden_pref_read").val());
		$("#dialog_sakagura_name").val($("#sakagura_name").text());
		$("#dialog_sakagura_read").val($("#sakagura_read").text());

		var sakagura_search_array = $("#hidden_sakagura_search").val().split(',');

		if(sakagura_search_array.length > 0)
		{
				var i = 0;

				$('input[name="sakagura_search[]"]').each(function(){

						if(i < sakagura_search_array.length)
						{
								$(this).val(sakagura_search_array[i]);
						}

						i++;
				});
		}

		var url_array = $("#hidden_url").val().split(',');

		if(url_array.length > 0)
		{
				var i = 0;

				$('input[name="url[]"]').each(function(){

						if(i < url_array.length)
						{
								$(this).val(url_array[i]);
						}

						i++;
				});
		}

		$("#dialog_sakagura_english").val($("#sakagura_english").text());
		$("#dialog_sakagura_intro").val($("#sakagura_intro").text());
		$("#dialog_postal_code").val($("#postal_code").text());
		$("#dialog_address").val($("#address").text());
		$("#dialog_phone").val($("#phone").text());
		$("#dialog_fax").val($("#fax").text());

		$("#dialog_email").val($("#email").text());
		$("#dialog_brand").val($("#brand").text());
		$("#dialog_representative").val($("#representative").text());
		$("#dialog_touji").val($("#touji").text());
		$("#dialog_award_history").val($("#award_history").text());
		$("#dialog_observation").val($("#observation").text());
		$("#dialog_observatory_info").val($("#observatory_info").text());
		$("#dialog_direct_sale").val($("#direct_sale").text());
		$("#dialog_payment_method").val($("#payment_method").text());
		$("#dialog_memo").val($("#memo").text());

		$('input[name="kumiai"]').each(function(){
			if($("#hidden_kumiai").val() == this.value)
			{
					this.checked = true;
					$(this).attr("prev", true);
			}
			else
			{
					this.checked = false;
					$(this).attr("prev", false);
			}
		});

		$('input[name="kokuzei"]').each(function(){
			if($("#hidden_kokuzei").val() == this.value)
			{
					this.checked = true;
					$(this).attr("prev", true);
			}
			else
			{
					this.checked = false;
					$(this).attr("prev", false);
			}
		});

		$('input[name="status"]').each(function(){
			if($("#hidden_status").val() == this.value)
			{
					this.checked = true;
					$(this).attr("prev", true);
			}
			else
			{
					this.checked = false;
					$(this).attr("prev", false);
			}
		});

		if($("#hidden_sakagura_develop").val() != undefined)
		{
		  $('#dialog_sakagura_develop option').each(function(){

			  if(this.value == $("#hidden_sakagura_develop").val())
			  {
				   $("#dialog_sakagura_develop").val($("#hidden_sakagura_develop").val());
				   return false;
			  }
		  });
		}

		$('#dialog_pref').change(function(){
		  var pref = $("#dialog_pref").val();

		  $('#dialog_pref option').each(function(){

			  if(this.value == pref)
			  {
				  pref_read_value = $(this).attr("read");
				  //alert("pref_read_value:" + pref_read_value);
				  return false;
			  }
		  });
		});

		if($("#establishment").text() != undefined)
		{
		  $('#dialog_establishment option').each(function(){

			  if(this.value == establishment_array[0])
			  {
					$("#dialog_establishment").val(establishment_array[0]);

					if(establishment_array[0] == 9999)
					{
							$("#dialog_other_year").val(establishment_array[1]);
							$('#dialog_other_year').prop('disabled', false);
					}

					return false;
			  }
		  });
		}

		if($("#hidden_sakagura").val() != undefined)
		{
		  $('#dialog_sakagura option').each(function(){

			  if(this.value == $("#hidden_sakagura").val())
			  {
					$("#dialog_sakagura").val($("#hidden_sakagura").val());
					return false;
			  }
		  });
		}

		if($("#direct_sale").attr('value') != undefined)
		{
		  $('#dialog_direct_sale option').each(function(){

			  if(this.value == $("#direct_sale").attr('value'))
			  {
				   $("#dialog_direct_sale").val($("#direct_sale").attr('value'));
				   return false;
			  }
		  });
		}

		if($("#observation").attr('value') != undefined)
		{
		  $('#dialog_observation option').each(function(){

			  if(this.value == $("#observation").attr('value'))
			  {
				   $("#dialog_observation").val($("#observation").attr('value'));
				   return false;
			  }
		  });
		}

		$("#dialog_background").css({"display":"block"});
		$("#dialog_edit_sakagura").css({"display":"block"});
	});

	$("#edit_sakagura_close, #close_edit_sakagura_button").click(function() {
			$("#dialog_background").css({"display":"none"});
			$("#dialog_edit_sakagura").css({"display":"none"});
	});

	function ajax_update_sakagura_data(xml) {

			//////////////////////////////////////////////
			$("#sakagura_name").text($("#dialog_sakagura_name").val());

			var sakagura_search = "";

			$('input[name="sakagura_search[]"]').each(function(){

				if(sakagura_search == "")
					sakagura_search += $(this).val();
				else
					sakagura_search += ',' + $(this).val();
			});

			$("#hidden_sakagura_search").val(sakagura_search);

			var urls = "";
			var urls_html = "";

			$('input[name="url[]"]').each(function(){

				if(urls_html == "")
				{
					urls = $(this).val();
					urls_html = '<span style="margin:2px 8px 2px 0px"><a href = "' + $(this).val() + '">' + $(this).val() + '</a></span>';
				}
				else
				{
					urls += ',' + $(this).val();
					urls_html = urls_html + '<span style="margin:2px 8px 2px 0px"><a href = "' + $(this).val() + '">' + $(this).val() + '</a></span>';
				}
			});

			//alert("url:" + urls_html);
			$("#hidden_url").val(urls);
			$("#url").html(urls_html);

		    $("#sakagura_english").text($("#dialog_sakagura_english").val());
			$("#sakagura_read").text($("#dialog_sakagura_read").val());
			$("#sakagura_intro").html(nl2br($("#dialog_sakagura_intro").val()));

			$("#pref").text($("#dialog_pref").val());
			$("#pref_read").text($("#dialog_pref_read").val());
			$("#postal_code").text($("#dialog_postal_code").val());
			$("#address").text($("#dialog_address").val());
			$("#phone").text($("#dialog_phone").val());
			$("#fax").text($("#dialog_fax").val());

			$("#email").text($("#dialog_email").val());
			$("#brand").text($("#dialog_brand").val());
			$("#brand2").text($("#dialog_brand").val());

			$("#representative").text($("#dialog_representative").val());
			$("#touji").text($("#dialog_touji").val());

			if($("#dialog_establishment").val() == 9999)
			{
				//alert("year:" + $("#dialog_other_year").val());
				$("#establishment").text($("#dialog_other_year").val());
				$("#hidden_establishment").val($("#dialog_establishment").val() + ',' + $("#dialog_other_year").val());
			}
			else
			{
				//alert("establishment:" + $("#dialog_establishment option:selected").text());
				$("#establishment").text($("#dialog_establishment option:selected").val());
				$("#hidden_establishment").val($("#dialog_establishment").val());
			}

			$("#award_history").text($("#dialog_award_history").val());
			$("#observation").text($("#dialog_observation").val());

			$("#observatory_info").html(nl2br($("#dialog_observatory_info").val()));
			$("#direct_sale").text($("#dialog_direct_sale").val());
			$("#payment_method").text($("#dialog_payment_method").val());

			if($('input[name="kumiai"]:checked').val() != undefined)
				$("#hidden_kumiai").val($('input[name="kumiai"]:checked').val());
			else
				$("#hidden_kumiai").val("");

			if($('input[name="kumiai"]:checked').val() == 10)
			{
				$("#kumiai").text("Ç†ÇË");
			}
			else if($('input[name="kumiai"]:checked').val() == 11)
			{
				$("#kumiai").text("Ç»Çµ");
			}
			else if($('input[name="kumiai"]:checked').val() == 12)
			{
				$("#kumiai").text("ïsñæ");
			}
			else
			{
				$("#kumiai").text("");
			}

			if($('input[name="kokuzei"]:checked').val() != undefined)
			  $("#hidden_kokuzei").val($('input[name="kokuzei"]:checked').val());
			else
			  $("#hidden_kokuzei").val("");

			if($('input[name="kokuzei"]:checked').val() == 10)
			{
				$("#kokuzei").text("Ç†ÇË");
			}
			else if($('input[name="kokuzei"]:checked').val() == 11)
			{
				$("#kokuzei").text("Ç»Çµ");
			}
			else if($('input[name="kokuzei"]:checked').val() == 12)
			{
				$("#kokuzei").text("ïsñæ");
			}
			else
			{
				$("#kokuzei").text("");
			}

			// status
			if($('input[name="status"]:checked').val() != undefined)
				$("#hidden_status").val($('input[name="status"]:checked').val());
			else
				$("#hidden_status").val("");

			if($('input[name="status"]:checked').val() == 10)
			{
				$("#status").text("active");
			}
			else if($('input[name="status"]:checked').val() == 11)
			{
				$("#status").text("inactive");
			}
			else if($('input[name="status"]:checked').val() == 12)
			{
				$("#status").text("àÍéûêªë¢ãxé~");
			}
			else if($('input[name="status"]:checked').val() == 13)
			{
				$("#status").text("âcã∆ïsñæÅEé©è¯í‚é~äOïîè¯ë¢");
			}
			else
			{
				$("#status").text("");
			}

			$("#memo").html(AutoLink(nl2br($("#dialog_memo").val())));
			$("#sakagura_type").text($("#dialog_sakagura option:selected").text());
			$("#hidden_sakagura").val($("#dialog_sakagura option:selected").val());
			$("#hidden_sakagura_develop").val($("#dialog_sakagura_develop").val());
			$("#observation").attr('value', $("#dialog_observation").val()); // ë†å©äw

			if($("#dialog_observation").val() == 1)
			{
				 $("#observation").text("â¬");
			}
			else if($("#dialog_observation").val() == 2)
			{
				 $("#observation").text("ïsâ¬");
			}
			else
			{
				 $("#observation").text("");
			}

			if($("#dialog_observation").val() == 1)
			{
				 $("#observation2").text("â¬");
			}
			else if($("#dialog_observation").val() == 2)
			{
				 $("#observation2").text("ïsâ¬");
			}
			else
			{
				 $("#observation2").text("");
			}

			// íºîÃ
			
			//alert("dialog_direct_sale:" + $("#dialog_direct_sale").val());
			$("#direct_sale").attr('value', $("#dialog_direct_sale").val());

			if($("#dialog_direct_sale").val() == 1)
			{
				 $("#direct_sale").text("â¬");
			}
			else if($("#dialog_direct_sale").val() == 2)
			{
				 $("#direct_sale").text("ïsâ¬");
			}
			else
			{
				 $("#direct_sale").text("");
			}

			// äJî≠èÛãµ
			if($('#dialog_sakagura_develop').val() == 0)
			{
				 $("#develop").text("ñ¢äÆê¨");
			}
			else if($('#dialog_sakagura_develop').val() == 1)
			{
				 $("#develop").text("äÆê¨");
			}
			else if($('#dialog_sakagura_develop').val() == 2)
			{
				 $("#develop").text("ìríÜ");
			}

			//alert("done");
	}

	// èIóπéûÇ…é¿çsÇ≥ÇÍÇÈÉCÉxÉìÉg
	$('#edit_sakagura_ok').click(function() {

            var data = $("#dialog_edit_sakagura_container").serialize();
			//alert("data:" + data);

			$.ajax({
					type: "post",
					url: "sakagura_update.php?id=<?php print($_GET['id']);?>",
					data: data,
			}).done(function(xml){
					str = $(xml).find("str").text();
					//alert("str:" + str);

					if(str == "success")
					{
						//alert("success");
						//ajax_update_sakagura_data(xml);
						location.reload();	
						return;
					}
					else
					{
						alert("failed sql:" + $(xml).find("sql").text());
						//alert("str:" + str);
						$("#sample1").text(str);
					}

			}).fail(function(data){
					alert("This is Error");
					$("#sample1").text('This is Error');
			});


			$("#dialog_background").css({"display":"none"});
			$("#dialog_edit_sakagura").css({"display":"none"});
	 });
});


////////////////////////////////////////////////////////////////////////////////////////////////////////
// åfé¶î¬
////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {

	$("#button_sakagura_bbs").click(function() {
			$("#dialog_background").css({"display":"block"});
			$("#dialog_sakagura_bbs").css({"display":"block"});
	});

	$("#sakagura_bbs_close, #close_sakagura_bbs_button").click(function() {
			$("#dialog_background").css({"display":"none"});
			$("#dialog_sakagura_bbs").css({"display":"none"});
	});

	$("#sakagura_bbs_ok").click(function() {

			var sakagura_id = <?php echo json_encode($id); ?>;
			var tablename = "table_" + sakagura_id;
			var data = "tablename="+tablename+"&title="+$("#bbs_subject").val()+"&rank="+$("#bbs_rank").val()+"&message="+$("#bbs_message").val();

			$.ajax({
					type: "post",
					url: "bbs_write.php",
					data: data,
			}).done(function(xml){
					var str = $(xml).find("str").text();
					var tablename = $(xml).find("tablename").text();
					var message_sequence = $(xml).find("message_sequence").text();
					var contributor = $(xml).find("contributor").text();
					var subject = $(xml).find("subject").text();
					var rank = $(xml).find("rank").text();
					var message = $(xml).find("message").text();
					var intime = $(xml).find("intime").text();

					if(str == "success")
					{
							var i = 0;
							var path = "images/icons/users.jpg";;

							var innerText = '<div class="review">';
									innerText += '<div style="float:left; overflow:auto; padding:2px; width:68px; height:72px; border:0px solid #e3e3e3">';
										 innerText += '<img style="margin:auto; width:54px; height:auto; border-radius:4px;" src="' + path + '">';
										 innerText += '<div style="margin:auto; font-size:8pt; color:#0740A5">' + contributor + '</div>';
									innerText += '</div>';

									innerText += '<button input id="button" class="cancel_button" tablename="' + tablename + '" message_sequence=' + message_sequence + ' style="border-radius:0px; background:transparent; width:28px;" value="çÌèú"><img style="width:14px; margin:0px" src="images/icons/cross.svg"></button>';
									innerText += '<div style="margin-left:4px">' + subject + '</div>';
									innerText += '<div style="float:right; margin-left:4px">' + intime + '</div>';
									innerText += '<div style="color:#F7931D; font-size:1.4em;">';

									for(i = 0; i < rank && i < 5; i++)
										innerText += "&#9733";

									for(; i < 5; i++)
										innerText += "&#9734";

									innerText += '</div>';
									innerText += '<div style="margin-left:4px; color:#404040;">' + message + '</div>';

									innerText += '</div>';
									var element = $("#threads").prepend(innerText);
					}
					else
					{
							$("#sample1").text(str);
					}
			}).fail(function(data){
					 alert("This is Error");
					$("#sample1").text('This is Error');
			});

			$("#dialog_background").css({"display":"none"});
			$("#dialog_sakagura_bbs").css({"display":"none"});
	 });

}); // $function()

////////////////////////////////////////////////////////////////////////////////////////////////////////////
// éë†Ç…ÉÅÉbÉZÅ[ÉWÇëóÇÈ
////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {

	$("#button_sakagura_mail").click(function() {
			$("#dialog_background").css({"display":"block"});
			$("#dialog_send_sakagura").css({"display":"block"});
	});

	$("#mail_sakagura_ok").click(function() {

			var sakagura_id = <?php echo json_encode($id); ?>;
			var sakagura_name = $("#sakagura_name").val();

			var data = "sakagura_id="    +sakagura_id   +
					"&sakagura_name=" +sakagura_name +
					"&title="         +$("#mail_subject").val() +
					"&message="       +$("#mail_message").val();

			$.ajax({
					type: "post",
					url: "sda_send_message.php",
					data: data,
			}).done(function(xml){
					var str = $(xml).find("str").text();
					var intime = $(xml).find("intime").text();

					//alert("received: " +str + " " + intime + " " + intime);

					if(str == "success")
					{
						alert("message was sent:" + intime);
					}
					else
					{
						$("#sample1").text(str);
					}
			}).fail(function(data){
					alert("This is Error");
			});

			$("#dialog_background").css({"display":"none"});
			$("#dialog_send_sakagura").css({"display":"none"});
	});

	$("#send_sakagura_close, #close_mail_button").click(function() {
			$("#dialog_background").css({"display":"none"});
			$("#dialog_send_sakagura").css({"display":"none"});
	});
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

jQuery(document).ready(function(){

  $("body").wrapInner('<div id="wrapper"></div>');

	$('#tab_main').createTabs({
			text : $('#tab_main ul')
	});

  $("body").fadeIn(400);

	$(document).on('click', '#url a', function(){
			//alert("url clicked:" + $('#url a').attr("href"));

			event.preventDefault();
			//alert('url:' + $(this).attr("href"));
			window.open($(this).attr("href"));
	});

  /*
  $('#dialog_postal_code').jpostal({
			postcode : [
				'#dialog_postal_code',
			],
			address : {
				'#dialog_pref'       : '%3',
				'#dialog_address'    : '%4%5',
				'#dialog_pref_read'  : '%8%9%10',
			}
  });
	*/

	$('#threads').delegate('#button', 'click', function() {
			var message_sequence = $(this).attr('message_sequence');
			var tablename = $(this).attr('tablename');
			var data = "message_sequence="+message_sequence+"&tablename="+tablename;
			var obj = this;

			//alert("message_sequence:" +message_sequence + " tablename:" + tablename);

			$.ajax({
					type: "post",
					url: "bbs_delete.php",
					data: data,
			}).done(function(xml){
					var str = $(xml).find("str").text();

					if(str == "success")
					{
						$(obj).closest('div').fadeOut();
					}

			}).fail(function(data){
					var str = $(xml).find("str").text();
					alert("Failed:" +str);
			});
	});

  $("#tabs_specs").tabs();

  $('#add_sake').click(function() {
      //alert("add sake");
      var sakagura_id = $(this).attr('sakagura_id');
      window.open('sake_add_form.php?id=' + sakagura_id + '&sakagura_name=' + sakagura_name.innerText, '_self');
  });

  $('#follow').click(function() {
	Å@
		var data = $(this).attr("value");
	 	//alert("data1:" + data);

		$.ajax({
			type: "post",
			url: "sda_follow.php?id=<?php print($_GET['id']);?>",
			data: data,
		}).done(function(xml){
			var str = $(xml).find("str").text();

			if(str == "follow")
			{
				$("#follow").animate({ backgroundColor: 'linear-gradient(#fff, #e6e6e6)', color: '#000'}, 'slow');
				$("#follow").css('background', 'linear-gradient(#e6e6e6, #fff)');
				$("#follow").attr("value", false);
			}
			else if(str == "followed")
			{
				$("#follow").css('background', '#e6e6e6');
				$("#follow").animate({ backgroundColor: '#FF4545', color: '#fff'}, 'slow');
				$("#follow").attr("value", true);
			}
		}).fail(function(data){
		  alert("This is Error");
		  $("#follow").text('This is Error');
		});
	});

  $(".static").click(function() {
      var url = $(this).attr('value');
      window.open(url + this.id, '_self');
  });

  $(".static").mouseover(function() {
      $(this).find("h2").css('visibility','visible');
      $(this).find("h2").fadeIn();
  });

  $(".static").mouseleave(function() {
      $(this).find("h2").fadeOut();Å@
      $(this).find("h2").css('visibility','hidden');
  });

  $(".syuhanten").click(function() {
      var url = $(this).attr('value');
      window.open(url + this.id, '_self');
  });

  $('div#head_left div').on('mousedown', 'li, a', function() {
      //brand_id = $(this).attr('brand_id');
      //location.href = '/brands/' + brand_id + '/';
  });

  $("#showpic").click(function() {
      var sakagura_id = $(this).attr('sakagura_id');
      var sakagura_name = $('#sakagura_name').text();

      window.open('sake_image.php?sake_id=' + sakagura_id + '&data_type=sakagura&title=' + sakagura_name, '_self');
  });

  $('#delete_sakagura').click(function(){
     var sakagura_id = $(this).attr('sakagura_id');

     if(confirm("çÌèúÇµÇ‹Ç∑Ç©:" + sakagura_id) == true)
		 {
        var data = "id="+sakagura_id;

        $.ajax({
	        type: "post",
	        url: "sda_dynamic_delete.php?id=<?php print($_GET['id']);?>",
	        data: data,
        }).done(function(xml){
	        var str = $(xml).find("str").text();

	        if(str == "success")
	        {
		        alert("éë†ÇçÌèúÇµÇ‹ÇµÇΩ");
		        window.open('sake_search.php', '_self');
	        }

        }).fail(function(data){
	        var str = $(xml).find("str").text();
	        alert("Failed:" +str);
        });
	   } // confirm
	});

  ////////////////////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////////////////////

  function ScaleSlider() {
	    var parentWidth = $(window).width();

      if(parentWidth)
      {
				scaleNavigator(parentWidth);

				if(parentWidth > 700)
				{
					if($('.hamburger').hasClass('is-open')) {
						$('.overlay').hide();
						$('.hamburger').removeClass('is-open');
						$('.hamburger').addClass('is-closed');
						$('#wrapper').toggleClass('toggled');
						$('.header').toggleClass('toggled');
					}
				}

				update_dialog("#dialog_sakagura_bbs");
				update_dialog("#dialog_send_sakagura");
      }

  } // resize

  ScaleSlider();
  $(window).bind("load", ScaleSlider);
  $(window).bind("resize", ScaleSlider);
  $(window).bind("orientationchange", ScaleSlider);

});  // jquery ready

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
