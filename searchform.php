<?php
/**
 * The template for displaying search forms in MuzicBand.
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */
?>
<form role="search" method="get" class="s-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-form"> 
		<input type="search" placeholder="<?php echo esc_attr_x( 'Search here &hellip;', 'placeholder', 'muzicband' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	</div> 
</form> 