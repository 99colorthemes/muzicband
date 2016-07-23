<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */

?>


	<!-- Footer-end -->
	<?php if ( is_active_sidebar( 'muzicband_footer_section_1' ) || is_active_sidebar( 'muzicband_footer_section_2' ) || is_active_sidebar( 'muzicband_footer_section_3' ) ) : ?>
		<footer class="nnc-footer">
			<div class="nnc-container">
				<div class="nnc-footer-box nnc-footer-column-n">
					<?php 
					for ($i=1; $i <4 ; $i++) { 
						if( is_active_sidebar( 'muzicband_footer_section_'.$i ) ) : ?>
							<div class="nnc-footer-block">
								<?php dynamic_sidebar( 'muzicband_footer_section_'.$i ) ?>
							</div>
						<?php endif;
					} ?>
				</div>

				<div class="nnc-social">
				<?php wp_nav_menu( array( 'theme_location' => 'social', 'container' => 'ul', 'menu_class' => 'nnc-footer-social' ) ); ?>
				</div>
			</div>
		</footer>
	<?php endif;?>

	<?php muzicband_footer_copyright_info(); ?>
	<!-- Footer-end -->

</div><!-- #page -->

<?php wp_footer(); ?>

<div class="nnc-scroll-top">
	<span class="nnc-scroll-top-inner"><i class="fa fa-long-arrow-up"></i></span>
</div>

</body>
</html>
