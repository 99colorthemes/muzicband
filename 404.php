<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */

?>

<?php get_header(); ?>
	<?php do_action( 'muzicband_before_body_content' );
	$muzicband_layout = muzicband_layout_class(); ?>
	<div id="content" class="site-content">
	   	<main id="main" class="clearfix <?php echo esc_attr( $muzicband_layout ); ?>">
		   	<div class="nnc-container">
			   	<div id="primary">
			   		<section class="error-404 not-found">
						<header class="page-header">
							<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'muzicband' ); ?></h1>
						</header><!-- .page-header -->

						<div class="page-content">
							<span class="error-404-num">404 error</span>
							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search ?', 'muzicband' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .page-content -->
					</section><!-- .error-404 -->				
				</div><!-- #primary -->
				<?php  muzicband_sidebar_select(); ?>
		   	</div><!-- end nnc-container -->
		</main><!-- #main -->
	</div><!-- #content -->
	<?php do_action( 'muzicband_after_body_content' ); ?>
<?php get_footer(); ?>