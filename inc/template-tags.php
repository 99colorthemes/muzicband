<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */

if ( ! function_exists( 'muzicband_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function muzicband_posted_on() {
	global $post;
	global $page;

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="fa fa-calendar-o"></i> %3$s</a></span>', 'muzicband' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		$time_string
	);?>

	<span class="byline author vcard"><i class="fa fa-user" aria-hidden="true"></i> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo get_the_author(); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>

	<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
		<span class="comments-link"><i class="fa fa-comments" aria-hidden="true"></i> <?php comments_popup_link( __( '0', 'muzicband' ), __( '1', 'muzicband' ), __( ' % Comments', 'muzicband' ) ); ?></span>
	<?php }
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ' / ', 'muzicband' ) );
		if ( $categories_list && muzicband_categorized_blog() ) {
			printf( '<span class="cat-links"><i class="fa fa-folder" aria-hidden="true"></i>' . esc_html__( '%1$s', 'muzicband' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ' / ', 'muzicband' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><i class="fa fa-tags" aria-hidden="true"></i>' . esc_html__( '%1$s', 'muzicband' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

}
endif;

if ( ! function_exists( 'muzicband_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function muzicband_entry_footer() {
	global $post;
	if ( is_single() ) {

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'muzicband' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);

	}

	if ( ! is_single() ) { ?>

	<?php if ( $post->post_content !=="" ) : ?>

	<!-- Do stuff with empty posts (or leave blank to skip empty posts) -->
	<span class="read-more pull-right"><a href="<?php the_permalink(); ?>" class="btn btn-theme" title="" rel="bookmark"><?php echo esc_html_e('Read More','muzicband')?> <i class="fa fa-angle-double-right"></i></a></span>
	<?php endif; ?>

	<?php }
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function muzicband_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'muzicband_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'muzicband_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so muzicband_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so muzicband_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in muzicband_categorized_blog.
 */
function muzicband_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'muzicband_categories' );
}
add_action( 'edit_category', 'muzicband_category_transient_flusher' );
add_action( 'save_post',     'muzicband_category_transient_flusher' );
