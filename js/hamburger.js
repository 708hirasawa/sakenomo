$(function() {

    $('.hamburger').click(function () {

        if($('.hamburger').hasClass('is-open')) {
            $('.overlay').hide();
            $('.hamburger').removeClass('is-open');
            $('.hamburger').addClass('is-closed');
            $('body').css({"overflow-x": "visible"});
        }
        else {
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

    $('#side_mypage').click(function() {
         var username = getCookie('login_cookie');
         window.open("user_view.php?username=" + username, '_self');
    });
});
