<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
			   		<?php if ( have_posts() ) :
						if ( is_home() && ! is_front_page() ) : ?>
							<header>
								<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
							</header>
						<?php endif;

						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );
						endwhile;
						muzicband_navigation();
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif; ?>				
				</div><!-- #primary -->
				<?php  muzicband_sidebar_select(); ?>	   			
	   		</div><!-- end nnc-container -->  		      
		</main><!-- #main -->	
	</div><!-- #content -->
	<?php do_action( 'muzicband_after_body_content' ); ?>
<?php get_footer(); ?>