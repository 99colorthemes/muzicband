 
//************************ scroll to top ***********************************//
jQuery(document).ready(function() {
  jQuery(".nnc-scroll-top").on("click", function() {
    jQuery("html, body").animate({ scrollTop: 0 }, 600);
    return false;
  });
});
jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > 1){  
        jQuery('.nnc-scroll-top').addClass("show");
    }
    else{
        jQuery('.nnc-scroll-top').removeClass("show");
    }
});

jQuery(document).ready(function() {
  jQuery('input,search,textarea').focus(function(){   
  jQuery(this).data('placeholder',jQuery(this).attr('placeholder'))   
    jQuery(this).attr('placeholder','');});jQuery('input,search,textarea').blur(function(){   
    jQuery(this).attr('placeholder',jQuery(this).data('placeholder'));
  });
});

//************************ hide menu on scroll ***********************************//
jQuery(document).ready(function() {

//scroll hide 
    var lastScrollTop = 0;    
            
      jQuery(document).scroll(function(){
          
          var stop = jQuery(this).scrollTop();
                
          if (stop > lastScrollTop){
              console.log('down');
              // scrolling down
            if( jQuery('#masthead').hasClass('site-header'))
            {
                jQuery('#masthead').addClass('menu-hide');
                jQuery('#masthead').removeClass('site-header');
            }
        }
          else
          {
          // scrolling up
            if(jQuery('#masthead').hasClass('menu-hide'))
            {
                console.log('up');
                jQuery('#masthead').addClass('site-header');
                jQuery('#masthead').removeClass('menu-hide');
            } 
          } 
          lastScrollTop = stop;
            
      });

});

//************************ Slider ***********************************//
jQuery(document).ready(function() {
  var swiper = new Swiper('.swiper-container', {
    pagination: '.swiper-pagination',
    paginationClickable: true,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev'
  });
});
 