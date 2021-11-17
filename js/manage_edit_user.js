$(function() {

    var m_sake_id = "";

	$('#edit_sakagura_delete').click(function() {

        var data = "sakagura_id=" + m_sake_id;

	    $.ajax({
		    type: "POST",
		    url: "cgi/sakagura_delete.php",
		    data: data,
        }).done(function(xml){
            var str = $(xml).find("str").text();

            if(str != "success")
            {
		        alert("success:");
            }

	    }).fail(function(data){
		    alert("Failed:" + data);
	    }).complete(function(data){
            ; //removeLoading();
		});
    });

    $("body").on( "open_edit_user", function( event, username, fname) {

        var data = "category=5&from=0&username=" + username;
        $('#user_name_input_argument').val(username);

        //alert("user data:" + data);

	    $('#user_container').data('username', username);

        //alert('username:' + username);
        //dispLoading("処理中...");

	    $.ajax({
		    type: "POST",
		    url: "cgi/complex_search.php",
		    data: data,
		    dataType: 'json',

	    }).done(function(data){

		  //alert("user:" + user[0].fname);
		  //alert("success: fname:" + user[0].fname + " lname:" + users[0].lname);
          var user = data[0].sake;
		　var bdate = user[0].bdate;
		　var bdateArray = bdate.split('-');
		  //alert("success:" + user[0].username);

          $('#user_name_input_argument').val(user[0].username);
		　$('#sex').val(user[0].sex);
		　$('#email').val(user[0].email);
		　$('#phone').val(user[0].phone);
		　$('#pref').val(user[0].pref);

		　$('#birthday_month').val(bdateArray[0]);
		　$('#birthday_day').val(bdateArray[1]);
		　$('#birthday_year').val(bdateArray[2]);

          $('.profile_photo img').attr("src", user[0].filename);

		　$('#user_container').data('fname', user[0].fname);
          $('#user_container').data('minit', user[0].minit);
          $('#user_container').data('lname', user[0].lname);
          $('#user_container').data('sex', user[0].sex);
          $('#user_container').data('bdate', user[0].bdate);
          $('#user_container').data('email', user[0].email);
          $('#user_container').data('phone', user[0].phone);
          $('#user_container').data('pref', user[0].pref);
          $('#user_container').data('address', user[0].address);
          $('#user_container').data('address_read', user[0].address_read);
          $('#user_container').data('postal_code', user[0].postal_code);
          $('#user_container').data('certification', user[0].certification);
          $('#user_container').data('age_disclose', user[0].age_disclose);
          $('#user_container').data('sex_disclose', user[0].sex_disclose);
          $('#user_container').data('address_disclose', user[0].address_disclose);
          $('#user_container').data('certification_disclose', user[0].certification_disclose);
          $('#user_container').data('introduction', user[0].introduction);

	    }).fail(function(data){
		    alert("Failed:" + data);
	    }).complete(function(data){
          ; //removeLoading();
		});
	});
});
