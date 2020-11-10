

(function($){
    var scrollTop = $(window).scrollTop();
    $(window).on('scroll', function() {
        if(scrollTop >= 80){
            $('nav').fadeIn(500).addClass('stickybg');
        } else {
            $('nav').removeClass('stickybg');
        }
        scrollTop = $(window).scrollTop()
    })
})(jQuery);