

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

$(document).ready(function() {
  

	  
    var numItems = $('li.expo-tab').length;
		
			  if (numItems == 2){
					$("li.expo-tab").width('50%');
				}
		  
	 

	
		});

$(window).load(function() {

  $('.expo-tabs').each(function() {

    var highestBox = 0;
    $('.expo-tab a', this).each(function() {

      if ($(this).height() > highestBox)
        highestBox = $(this).height();
    });

    $('.expo-tab a', this).height(highestBox);

  });
});