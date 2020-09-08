(function( $ ) {
  $.fn.createTabs = function(options) {
        var obj = $(this);

        //$(this).find('ul').on('click', 'li a', function(e){
        $(options.text).on('click', 'li a', function(e){

            e.preventDefault();

            $(options.text).find(".active").removeClass('active');
            $(this).addClass('active');
            var $tab = $(this), href = $tab.attr('href');
    
            obj.find('.show').removeClass('show').addClass('hide').hide();
            $(href).removeClass('hide').addClass('show').show();
        }); 

        return(this);
    };
})( jQuery );

(function( $ ) {
  $.fn.createAutoKana = function(options) {

        // alert("inside createAutoKana");
        // alert("sakagura_name:" + $(options.sakagura_name).val());
        // alert("sakagura_read:" + $(options.sakagura_read).val());
        // alert("sakagura_english:" + $(options.sakagura_english).val());

		var convFlag  = 0;  //モードフラグ ひらがな→0　カタカナ→1
		var baseVal = "";

		var kanaArray = new Array(167);
		var romeArray = new Array(167);
		var i;
		kanaArray[0] = "，"; romeArray[0] = ",";
		kanaArray[1] = "、"; romeArray[1] = ",";
		kanaArray[2] = "。"; romeArray[2] = ".";
		kanaArray[3] = "ー"; romeArray[3] = "-";
		kanaArray[4] = "いぇ"; romeArray[4] = "YE";
		kanaArray[5] = "うぃ"; romeArray[5] = "WI";
		kanaArray[6] = "うぇ"; romeArray[6] = "WE";
		kanaArray[7] = "う゛ぁ"; romeArray[7] = "VA";
		kanaArray[8] = "う゛ぃ"; romeArray[8] = "VI";
		kanaArray[9] = "う゛ぇ"; romeArray[9] = "VE";
		kanaArray[10] = "う゛ぉ"; romeArray[10] = "VO";
		kanaArray[11] = "う゛"; romeArray[11] = "VU";
		kanaArray[12] = "きゃ"; romeArray[12] = "KYA";
		kanaArray[13] = "きぃ"; romeArray[13] = "KYI";
		kanaArray[14] = "きゅ"; romeArray[14] = "KYU";
		kanaArray[15] = "きぇ"; romeArray[15] = "KYE";
		kanaArray[16] = "きょ"; romeArray[16] = "KYO";
		kanaArray[17] = "くぁ"; romeArray[17] = "KWA";
		kanaArray[18] = "しゃ"; romeArray[18] = "SHA";
		kanaArray[19] = "しぃ"; romeArray[19] = "SYI";
		kanaArray[20] = "しゅ"; romeArray[20] = "SHU";
		kanaArray[21] = "しぇ"; romeArray[21] = "SHE";
		kanaArray[22] = "しょ"; romeArray[22] = "SHO";
		kanaArray[23] = "ちゃ"; romeArray[23] = "CHA";
		kanaArray[24] = "ちぃ"; romeArray[24] = "CYI";
		kanaArray[25] = "ちゅ"; romeArray[25] = "CHU";
		kanaArray[26] = "ちぇ"; romeArray[26] = "CHE";
		kanaArray[27] = "ちょ"; romeArray[27] = "CHO";
		kanaArray[28] = "てゃ"; romeArray[28] = "THA";
		kanaArray[29] = "てぃ"; romeArray[29] = "THI";
		kanaArray[30] = "てゅ"; romeArray[30] = "THU";
		kanaArray[31] = "てぇ"; romeArray[31] = "THE";
		kanaArray[32] = "てょ"; romeArray[32] = "THO";
		kanaArray[33] = "にゃ"; romeArray[33] = "NYA";
		kanaArray[34] = "にぃ"; romeArray[34] = "NYI";
		kanaArray[35] = "にゅ"; romeArray[35] = "NYU";
		kanaArray[36] = "にぇ"; romeArray[36] = "NYE";
		kanaArray[37] = "にょ"; romeArray[37] = "NYO";
		kanaArray[38] = "ひゃ"; romeArray[38] = "HYA";
		kanaArray[39] = "ひぃ"; romeArray[39] = "HYI";
		kanaArray[40] = "ひゅ"; romeArray[40] = "HYU";
		kanaArray[41] = "ひぇ"; romeArray[41] = "HYE";
		kanaArray[42] = "ひょ"; romeArray[42] = "HYO";
		kanaArray[43] = "ふぁ"; romeArray[43] = "FA";
		kanaArray[44] = "ふぃ"; romeArray[44] = "FI";
		kanaArray[45] = "ふぇ"; romeArray[45] = "FE";
		kanaArray[46] = "ふぉ"; romeArray[46] = "FO";
		kanaArray[47] = "ふゃ"; romeArray[47] = "FYA";
		kanaArray[48] = "ふゅ"; romeArray[48] = "FYU";
		kanaArray[49] = "ふょ"; romeArray[49] = "FYO";
		kanaArray[50] = "みゃ"; romeArray[50] = "MYA";
		kanaArray[51] = "みぃ"; romeArray[51] = "MYI";
		kanaArray[52] = "みゅ"; romeArray[52] = "MYU";
		kanaArray[53] = "みぇ"; romeArray[53] = "MYE";
		kanaArray[54] = "みょ"; romeArray[54] = "MYO";
		kanaArray[55] = "りゃ"; romeArray[55] = "RYA";
		kanaArray[56] = "りぃ"; romeArray[56] = "RYI";
		kanaArray[57] = "りゅ"; romeArray[57] = "RYU";
		kanaArray[58] = "りぇ"; romeArray[58] = "RYE";
		kanaArray[59] = "りょ"; romeArray[59] = "RYO";
		kanaArray[60] = "ぎゃ"; romeArray[60] = "GYA";
		kanaArray[61] = "ぎぃ"; romeArray[61] = "GYI";
		kanaArray[62] = "ぎゅ"; romeArray[62] = "GYU";
		kanaArray[63] = "ぎぇ"; romeArray[63] = "GYE";
		kanaArray[64] = "ぎょ"; romeArray[64] = "GYO";
		kanaArray[65] = "じゃ"; romeArray[65] = "JA";
		kanaArray[66] = "じぃ"; romeArray[66] = "JYI";
		kanaArray[67] = "じゅ"; romeArray[67] = "JU";
		kanaArray[68] = "じぇ"; romeArray[68] = "JE";
		kanaArray[69] = "じょ"; romeArray[69] = "JO";
		kanaArray[70] = "ぢゃ"; romeArray[70] = "DYA";
		kanaArray[71] = "ぢぃ"; romeArray[71] = "DYI";
		kanaArray[72] = "ぢゅ"; romeArray[72] = "DYU";
		kanaArray[73] = "ぢぇ"; romeArray[73] = "DYE";
		kanaArray[74] = "ぢょ"; romeArray[74] = "DYO";
		kanaArray[75] = "でゃ"; romeArray[75] = "DHA";
		kanaArray[76] = "でぃ"; romeArray[76] = "DHI";
		kanaArray[77] = "でゅ"; romeArray[77] = "DHU";
		kanaArray[78] = "でぇ"; romeArray[78] = "DHE";
		kanaArray[79] = "でょ"; romeArray[79] = "DHO";
		kanaArray[80] = "びゃ"; romeArray[80] = "BYA";
		kanaArray[81] = "びぃ"; romeArray[81] = "BYI";
		kanaArray[82] = "びゅ"; romeArray[82] = "BYU";
		kanaArray[83] = "びぇ"; romeArray[83] = "BYE";
		kanaArray[84] = "びょ"; romeArray[84] = "BYO";
		kanaArray[85] = "ぴゃ"; romeArray[85] = "PYA";
		kanaArray[86] = "ぴぃ"; romeArray[86] = "PYI";
		kanaArray[87] = "ぴゅ"; romeArray[87] = "PYU";
		kanaArray[88] = "ぴぇ"; romeArray[88] = "PYE";
		kanaArray[89] = "ぴょ"; romeArray[89] = "PYO";
		kanaArray[90] = "あ"; romeArray[90] = "A";
		kanaArray[91] = "い"; romeArray[91] = "I";
		kanaArray[92] = "う"; romeArray[92] = "U";
		kanaArray[93] = "え"; romeArray[93] = "E";
		kanaArray[94] = "お"; romeArray[94] = "O";
		kanaArray[95] = "か"; romeArray[95] = "KA";
		kanaArray[96] = "き"; romeArray[96] = "KI";
		kanaArray[97] = "く"; romeArray[97] = "KU";
		kanaArray[98] = "け"; romeArray[98] = "KE";
		kanaArray[99] = "こ"; romeArray[99] = "KO";
		kanaArray[100] = "さ"; romeArray[100] = "SA";
		kanaArray[101] = "し"; romeArray[101] = "SHI";
		kanaArray[102] = "す"; romeArray[102] = "SU";
		kanaArray[103] = "せ"; romeArray[103] = "SE";
		kanaArray[104] = "そ"; romeArray[104] = "SO";
		kanaArray[105] = "た"; romeArray[105] = "TA";
		kanaArray[106] = "ち"; romeArray[106] = "CHI";
		kanaArray[107] = "つ"; romeArray[107] = "TSU";
		kanaArray[108] = "て"; romeArray[108] = "TE";
		kanaArray[109] = "と"; romeArray[109] = "TO";
		kanaArray[110] = "な"; romeArray[110] = "NA";
		kanaArray[111] = "に"; romeArray[111] = "NI";
		kanaArray[112] = "ぬ"; romeArray[112] = "NU";
		kanaArray[113] = "ね"; romeArray[113] = "NE";
		kanaArray[114] = "の"; romeArray[114] = "NO";
		kanaArray[115] = "は"; romeArray[115] = "HA";
		kanaArray[116] = "ひ"; romeArray[116] = "HI";
		kanaArray[117] = "ふ"; romeArray[117] = "FU";
		kanaArray[118] = "へ"; romeArray[118] = "HE";
		kanaArray[119] = "ほ"; romeArray[119] = "HO";
		kanaArray[120] = "ま"; romeArray[120] = "MA";
		kanaArray[121] = "み"; romeArray[121] = "MI";
		kanaArray[122] = "む"; romeArray[122] = "MU";
		kanaArray[123] = "め"; romeArray[123] = "ME";
		kanaArray[124] = "も"; romeArray[124] = "MO";
		kanaArray[125] = "や"; romeArray[125] = "YA";
		kanaArray[126] = "ゆ"; romeArray[126] = "YU";
		kanaArray[127] = "よ"; romeArray[127] = "YO";
		kanaArray[128] = "ら"; romeArray[128] = "RA";
		kanaArray[129] = "り"; romeArray[129] = "RI";
		kanaArray[130] = "る"; romeArray[130] = "RU";
		kanaArray[131] = "れ"; romeArray[131] = "RE";
		kanaArray[132] = "ろ"; romeArray[132] = "RO";
		kanaArray[133] = "わ"; romeArray[133] = "WA";
		kanaArray[134] = "を"; romeArray[134] = "WO";
		kanaArray[135] = "ん"; romeArray[135] = "NN";
		kanaArray[136] = "が"; romeArray[136] = "GA";
		kanaArray[137] = "ぎ"; romeArray[137] = "GI";
		kanaArray[138] = "ぐ"; romeArray[138] = "GU";
		kanaArray[139] = "げ"; romeArray[139] = "GE";
		kanaArray[140] = "ご"; romeArray[140] = "GO";
		kanaArray[141] = "ざ"; romeArray[141] = "ZA";
		kanaArray[142] = "じ"; romeArray[142] = "JI";
		kanaArray[143] = "ず"; romeArray[143] = "ZU";
		kanaArray[144] = "ぜ"; romeArray[144] = "ZE";
		kanaArray[145] = "ぞ"; romeArray[145] = "ZO";
		kanaArray[146] = "だ"; romeArray[146] = "DA";
		kanaArray[147] = "ぢ"; romeArray[147] = "DI";
		kanaArray[148] = "づ"; romeArray[148] = "DU";
		kanaArray[149] = "で"; romeArray[149] = "DE";
		kanaArray[150] = "ど"; romeArray[150] = "DO";
		kanaArray[151] = "ば"; romeArray[151] = "BA";
		kanaArray[152] = "び"; romeArray[152] = "BI";
		kanaArray[153] = "ぶ"; romeArray[153] = "BU";
		kanaArray[154] = "べ"; romeArray[154] = "BE";
		kanaArray[155] = "ぼ"; romeArray[155] = "BO";
		kanaArray[156] = "ぱ"; romeArray[156] = "PA";
		kanaArray[157] = "ぴ"; romeArray[157] = "PI";
		kanaArray[158] = "ぷ"; romeArray[158] = "PU";
		kanaArray[159] = "ぺ"; romeArray[159] = "PE";
		kanaArray[160] = "ぽ"; romeArray[160] = "PO";
		kanaArray[161] = "ぁ"; romeArray[161] = "LA";
		kanaArray[162] = "ぃ"; romeArray[162] = "LI";
		kanaArray[163] = "ぅ"; romeArray[163] = "LU";
		kanaArray[164] = "ぇ"; romeArray[164] = "LE";
		kanaArray[165] = "ぉ"; romeArray[165] = "LO";
		kanaArray[166] = "っ"; romeArray[166] = "LTU";

		function convKana(val){
			var c, a = [];
			for(var i=val.length-1;0<=i;i--){
				c = val.charCodeAt(i);
				a[i] = (0x3041 <= c && c <= 0x3096) ? c + 0x0060 : c;
			}
			return String.fromCharCode.apply(null, a);
		}

		function convertStr(){
			var str, converted;
			var ltu;
			var pos, i, c;
			var lower;

			converted = "";
			ltu = pos = 0;
			//str = document.forms[0].strinput.value;
			//lower = document.forms[0].lower.checked;
			
			str = $($(options.sakagura_read)).val();
			lower = false;
		  
			while (pos < str.length) {
				for (i = 0; i < kanaArray.length; i++) {
					if (str.substring(pos, pos + kanaArray[i].length) == kanaArray[i]) {
						if (i == 166) {		// "っ"
							ltu++;
						} else {
							if (ltu > 0) {
								switch (romeArray[i].charAt(0)) {
									case "A":
									case "I":
									case "U":
									case "E":
									case "O":
									case "N":
										c = romeArray[166];	// "っ"
										break;
									default:
										c = romeArray[i].charAt(0);
										break;
								}
								if (lower) c = c.toLowerCase();
								while (ltu > 0) {
									converted += c;
									ltu--;
								}
							}
							converted += (lower) ? romeArray[i].toLowerCase() : romeArray[i];
						}
						pos += kanaArray[i].length;
						break;
					}
				}

				if (i == kanaArray.length) {
					while (ltu > 0) {
						converted += (lower) ? romeArray[166].toLowerCase() : romeArray[166]; // "っ"
						ltu--;
					}
					if ("あ".length == 2 && iskanji(str.charAt(pos))) {
						converted += str.substring(pos, pos + 2);
						pos += 2;
					} else {
						converted += str.substring(pos, pos + 1);
						pos++;
					}
				}
			}
			
			//document.forms[0].converted.value = converted;
			$(options.sakagura_english).val(converted);
		}

		function iskanji(c){
			return ((c >= "\x81" && c <= "\x9F") || (c >= "\xE0" && c <= "\xFC"));
		}

		$(options.sakagura_name).on('keyup', function(e) {
			var input_text = $(options.sakagura_name).val();
			var kana_text = $(options.sakagura_read).val();
			var addVal = input_text;
    		  
            //alert("addVal:" + addVal);

			if(e.keyCode == 32 || e.keyCode == 229) // bs is 8
			{
				//$('#sake_search').val(baseVal);
				//$('#sake_search').val(String.fromCharCode(e.keyCode));
				return;
			}

			if(input_text == "" || !input_text) {
				$(options.sakagura_read).val("");
				$(options.sakagura_english).val("");
				//$(sake_search).val("");
				baseVal = "";
				return;
			}

			if(baseVal == input_text){
					return;
			}    

			for(var i = baseVal.length; i >= 0; i--) {
				if(input_text.substr(0, i) == baseVal.substr(0, i)) {
					addVal = input_text.substr(i);
					break;
				}
			}

			var addruby = addVal.replace( /[^ 　ぁあ-んァー]/g, "" );

            //alert("onkeyup:" + kana_text + " addVal:" + addVal + " addruby:" + addruby);
			//alert("addVal:" + addVal + " addruby:" + addruby);

			if(addruby == ""){
				//alert("addruby is null addVal:" + addVal);
				return;
			}
			else
			{
				//alert("addruby is not null addruby:" + addruby + "addVal:" + addVal);
			}

			if(convFlag){
				addruby = convKana(addruby);
			}

			if(!kana_text)
				kana_text = addruby;
			else
				kana_text = kana_text + addruby;


			$(options.sakagura_read).val(kana_text);
			//$('#sake_search').val(baseVal);

			convertStr();
			baseVal = input_text;
		});

        return(this);
    };
})( jQuery );

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');

    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];

        while(c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if(c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
    }

    return "";
}
