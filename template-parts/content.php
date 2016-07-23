<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="nnc-entry-image">
		 	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		        <?php if ( is_single() ) {
		        	the_post_thumbnail( 'full', array( 'class' => 'nnc-single-image' ) );
		        } else {
					the_post_thumbnail( 'medium', array( 'class' => 'nnc-thumb-image' ) ); ?>
		        <?php } ?>
		    </a>
	    </figure><!-- .nnc-entry-image -->
	<?php endif; ?>
	
	<div class="nnc-entry-block">
		<header class="entry-header">
			<?php
				if ( is_single() ) {
					the_title( '<h1 class="entry-title">', '</h1>' );
				} else {
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				}

			if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php muzicband_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
			endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
				the_excerpt( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'muzicband' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'muzicband' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php muzicband_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div><!-- .nnc-entry-block -->
	
</article><!-- #post-## -->