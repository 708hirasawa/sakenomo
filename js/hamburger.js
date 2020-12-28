$(function() {

    $('.hamburger').click(function () {

        
        if($('.hamburger').hasClass('is-open'))
        {
            $('.overlay').hide();
            $('.hamburger').removeClass('is-open');
            $('.hamburger').addClass('is-closed');
            $('body').css({"overflow-x": "visible"});
        }
        else
        {
            $('.overlay').show();
            $('.hamburger').removeClass('is-closed');
            $('.hamburger').addClass('is-open');
            $('body').css({"overflow-x": "hidden"});
        }

        $('#wrapper').toggleClass('toggled');
	    $('.header').toggleClass('toggled');
    });
});

$(function() {

    $('.nav.sidebar-nav li:nth-child(3)').click(function() {
        $('.hamburger').click();
        $("#nonda").click();
    });

    $('.nav.sidebar-nav li:nth-child(4)').click(function() {
        alert("お知らせ");
    });

    $('.nav.sidebar-nav li:nth-child(5)').click(function() {
        $('.hamburger').click();
        $('#user_message').click()
    });

    $('.nav.sidebar-nav li:nth-child(6)').click(function() {
        alert("ヘルプ");
    });

    $('.nav.sidebar-nav li:nth-child(7)').click(function() {
        alert("Sakenomuとは");
    });

    $('.nav.sidebar-nav li:nth-child(8)').click(function() {
        alert("日本酒とは");
    });

    $('.nav.sidebar-nav li:nth-child(9)').click(function() {
        var c = document.cookie.split("; ");

        for(i in c)
          document.cookie =/^[^=]+/.exec(c[i])[0]+"=;expires=Thu, 01 Jan 1970 00:00:00 GMT";

        alert("ログアウトしました");
        window.open('sake_search.php', '_self');
    });
    
    $('#side_mypage').click(function() {
         var username = getCookie('login_cookie'); 
         window.open("user_view.php?username=" + username, '_self');
    });

    $('#side_add_sake').click(function(){
	     window.open('sake_add_form.php', '_self');
    });

    $('#side_add_sakagura').click(function(){
	     window.open('sda_add_form.php', '_self');
    });

    $('#side_add_syuhanten').click(function(){
	     window.open('syuhan_add_form.php', '_self');
    });
});
