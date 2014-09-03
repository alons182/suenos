(function($){
    var menu = $('.menu'),
        btnMovil = $('#btn_nav'),
        btnLogin = $('.btn-login');


    menu.find(".parent").hoverIntent({
        over: function() {
            $(this).find(">.sub-menu").slideDown(200 );
        },
        out:  function() {
            $(this).find(">.sub-menu").slideUp(200);
        },
        timeout: 200

    });
    //menu.find('.item-109 a').addClass('btn btn-red');

    // Login form
    btnLogin.click(function(e){
        $('.login-register').toggle();
        e.preventDefault();
    });
    // NAV MOBILE
    btnMovil.click(function(){
        menu.toggle();

    });

    $('button[data-dismiss], input[data-dismiss]').on('click', function(e){
        $('.alert').fadeOut(300);
    });

})(jQuery);
