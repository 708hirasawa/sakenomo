//////////////////////////////////////////////////////////////////////////////////////////////////
// portal_menu handler
//////////////////////////////////////////////////////////////////////////////////////////////////
$(function() {

    $(".sub_listing div span").click(function() {

        if($(this).attr("value") == "34")
        {
            $('input[name="sake_category[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "33")
        {
            $('input[name="sake_category[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "44")
        {
            $('input[name="sake_category[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "32")
        {
            $('input[name="sake_category[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }

        ////////////////////
        else if($(this).attr("value") == "100")
        {
            $('input[name="rice_used[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "103")
        {
            $('input[name="rice_used[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "102")
        {
            $('input[name="rice_used[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "101")
        {
            $('input[name="rice_used[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "104")
        {
            $('input[name="rice_used[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "11")
        {
            $('input[name="sake_category[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "33")
        {
            $('input[name="sake_category[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "50")
        {
            $('input[name="sake_category[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "51")
        {
            $('input[name="sake_category[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        else if($(this).attr("value") == "53")
        {
            $('input[name="sake_category[]"').val($(this).find('span').attr("value"));
            $('#sake_form').submit();
        }
        //  alert("sub_listing:" + $(this).attr("value"));
    });

    $("#home_menu").click(function() {
        $("#service_sidebar").fadeToggle();
    });

    $('#service_sidebar').hover(

        function () {
            //alert("mouseover");
        },

        function () {
            //alert("mouseover");
            $(this).fadeOut();
        }
    );

    $('.service_listing .menu_item').hover(

        function () {
           $('.service_listing .menu_item').find(".sub_menu").css({"display": "none"});
           $(this).find(".sub_menu").css({"display": "block"});
        }
    );
});

