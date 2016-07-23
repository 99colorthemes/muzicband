/**
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
jQuery(document).ready(function() {
	jQuery('.controls#muzicband-img-container li img').click(function(){
		jQuery('.controls#muzicband-img-container li').each(function(){
			jQuery(this).find('img').removeClass ('muzicband-radio-img-selected') ;
		});
		jQuery(this).addClass ('muzicband-radio-img-selected') ;
	});
});
