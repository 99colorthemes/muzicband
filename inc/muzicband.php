<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function muzicband_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	// Add class site layout style.
	if ( get_theme_mod ( 'muzicband_site_layout', 'wide' ) == 'wide' ) {
		$classes[] = 'wide';
	} else {
		$classes[] = 'box';
	}

	return $classes;
}
add_filter( 'body_class', 'muzicband_body_classes' );

/*************************** HEADER LOGO **********************************/
if ( ! function_exists( 'muzicband_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo Introduced in WordPress 4.5 .
 *
 * Does nothing if the custom logo is not available.
 *
 */
	function muzicband_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;

/******************************** FOOTER COPYRIGHT ***************************/
/**
 * function to show the footer info, copyright information
 */

function muzicband_footer_copyright_info() {
   $site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" >' . get_bloginfo( 'name', 'display' ) . '</a>';

   $wp_link = '<a href="'.esc_url( 'http://wordpress.org' ).'" target="_blank" title="' . esc_attr__( 'WordPress', 'muzicband' ) . '"><span>' . esc_html__( 'WordPress', 'muzicband' ) . '</span></a>';

	$tm_link =  '<a href="'. 'http://99colorthemes.com/' .'" target="_blank" title="'.esc_attr__( '99colorthemes', 'muzicband' ).'" rel="designer">'.esc_html__( '99colorthemes', 'muzicband') .'</a>';

	$default_footer_value = '<div class="copyright">'.sprintf( esc_html__( 'Copyright &copy; %1$s %2$s. All rights reserved.', 'muzicband' ), date( 'Y' ), $site_link ) . '</div><div class="themeby">'.sprintf( __( 'Built by %s.', 'muzicband' ), $tm_link ).'</div><div class="pby"> ' . sprintf( esc_html__( 'Theme by %s.', 'muzicband' ), $wp_link ).'</div>';

	$muzicband_footer_copyright = '<div class="nnc-footer-bottom"><div class="nnc-container">'.$default_footer_value.'</div></div>';
	echo $muzicband_footer_copyright;
}
add_action( 'muzicband_footer_copyright', 'muzicband_footer_copyright_info', 10 );

/********************************** SIDEBAR LAYOUT SELECTION *******************/
if ( ! function_exists( 'muzicband_layout_class' ) ) :
/**
 * Generate layout class for sidebar based on customizer and post meta settings.
 */
function muzicband_layout_class() {
    global $post;
    $layout = get_theme_mod( 'muzicband_global_layout', 'right_sidebar' );
    // Front page displays in Reading Settings
    $page_for_posts = get_option('page_for_posts');
    // Get Layout meta
    if($post) {
        $layout_meta = get_post_meta( $post->ID, 'muzicband_page_specific_layout', true );
    }
    // Home page if Posts page is assigned
    if( is_home() && !( is_front_page() ) ) {
        $queried_id = get_option( 'page_for_posts' );
        $layout_meta = get_post_meta( $queried_id, 'muzicband_page_specific_layout', true );

        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $queried_id, 'muzicband_page_specific_layout', true );
        }
    }
    elseif( is_page() ) {
        $layout = get_theme_mod( 'muzicband_default_page_layout', 'right_sidebar' );
        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $post->ID, 'muzicband_page_specific_layout', true );
        }
    }
    elseif( is_single() ) {
        $layout = get_theme_mod( 'muzicband_default_single_post_layout', 'right_sidebar' );
        if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
            $layout = get_post_meta( $post->ID, 'muzicband_page_specific_layout', true );
        }
    }
    return $layout;
}
endif;


if ( ! function_exists( 'muzicband_sidebar_select' ) ) :
/**
 * Select and show sidebar based on post meta and customizer default settings
 */
function muzicband_sidebar_select() {
    $layout = muzicband_layout_class();
    if( $layout != "no_sidebar_full_width" &&  $layout != "no_sidebar_content_centered" ) {
        if ( $layout == "right_sidebar" ) {
            get_sidebar();
        } else {
            get_sidebar('left');
        }
    }
}
endif;

/******************************** POST-NAVIGATION *****************************************/
if ( ! function_exists( 'muzicband_navigation' ) ) :
/**
 * Return the navigations.
 */
function muzicband_navigation() {
    if( is_archive() || is_home() || is_search() ) {
    /**
     * Checking WP-PageNaviplugin exist
     */
    if ( function_exists('wp_pagenavi' ) ) :
      wp_pagenavi();
    else:
      global $wp_query;
      if ( $wp_query->max_num_pages > 1 ) :
      ?>
      <ul class="default-wp-page clearfix">
        <li class="previous"><?php previous_posts_link( esc_html__( '&larr; Previous', 'muzicband' ) ); ?></li>
        <li class="next"><?php next_posts_link( esc_html__( 'Next &rarr;', 'muzicband' ) ); ?></li>
      </ul>
      <?php
      endif;
    endif;
  }

  if ( is_single() ) {
    if( is_attachment() ) {
    ?>
      <ul class="default-wp-page clearfix">
        <li class="previous"><?php previous_image_link( false, esc_html__( '&larr; Previous', 'muzicband' ) ); ?></li>
        <li class="next"><?php next_image_link( false, esc_html__( 'Next &rarr;', 'muzicband' ) ); ?></li>
      </ul>
    <?php
    }
    else {
    ?>
      <ul class="default-wp-page clearfix">
        <li class="previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . esc_html_x( '&larr; Previous Post', 'Previous post link', 'muzicband' ) . '</span>' ); ?></li>
        <li class="next"><?php next_post_link( '%link', '<span class="meta-nav">' . esc_html_x( 'Next Post &rarr;', 'Next post link', 'muzicband' ) . '</span>' ); ?></li>
      </ul>
    <?php
    }
  } 
}
endif;

/****************************** BREADCRUMBS ******************************************/
if ( ! function_exists( 'muzicband_breadcrumbs' ) ) :
/**
 * Display Breadcrumbs
 *
 * This code is a modified version of Melissacabral's original menu code for dimox_breadcrumbs().
 *
 */
function muzicband_breadcrumbs(){
  /* === OPTIONS === */
	$text['home']     = esc_html__('Home', 'muzicband'); // text for the 'Home' link
	$text['category'] = esc_html__('Archive by Category "%s"', 'muzicband'); // text for a category page
	$text['tax'] 	  = esc_html__('Archive for "%s"', 'muzicband'); // text for a taxonomy page
	$text['search']   = esc_html__('Search Results for "%s" query', 'muzicband'); // text for a search results page
	$text['tag']      = esc_html__('Posts Tagged "%s"', 'muzicband'); // text for a tag page
	$text['author']   = esc_html__('Articles Posted by %s', 'muzicband'); // text for an author page
	$text['404']      = esc_html__('Error 404', 'muzicband'); // text for the 404 page
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$showOnHome  = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = '&nbsp;&frasl;&nbsp;'; // delimiter between crumbs
	$before      = '<span class="current">'; // tag before the current crumb
	$after       = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */
	global $post;
	$homeLink   = esc_url(home_url()) . '/';
	$linkBefore = '<span typeof="v:Breadcrumb">';
	$linkAfter = '</span>';
	$linkAttr = ' rel="v:url" property="v:title"';
	$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
	if (is_home() || is_front_page()) {
		if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';
	} else {
		echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
		} elseif( is_tax() ){
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['tax'], single_cat_title('', false)) . $after;

		}elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;
		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;
		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;
		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
			$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
		} elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1) echo $before . get_the_title() . $after;
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo $delimiter;
			}
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;
		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}
		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo esc_html__( 'Page', 'muzicband' ) . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}
		echo '</div>';
	}
} // end muzicband_breadcrumbs()
endif;

/******************************** EXCERPT LIMIT **********************************/
/**
 * Sets the post excerpt length to 35 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function muzicband_excerpt_length( $length ) {
  return 40;
}
add_filter( 'excerpt_length', 'muzicband_excerpt_length' );

/************************************* EXCERPT COUTINEW READING *******************/
/**
 * Returns a "Continue Reading" link for excerpts
 */
function muzicband_continue_reading() {
  global $post;
  return '';
}
add_filter( 'excerpt_more', 'muzicband_continue_reading' );

/***************************************** REMOVE DEFAULT GALLERY **********************/
/**
 * Removing the default style of wordpress gallery
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/******************************************* ADD GALLERY IMAGE SIZE *********************/
/**
 * Filtering the size to be medium from thumbnail to be used in WordPress gallery as a default size
 */
function muzicband_gallery_atts( $out, $pairs, $atts ) {
	$atts = shortcode_atts( array(
	'size' => 'medium',
	), $atts );
	$out['size'] = $atts['size'];
	return $out;
}
add_filter( 'shortcode_atts_gallery', 'muzicband_gallery_atts', 10, 3 );

/********************************** COMMENT DISPLAY ****************************************/
if ( ! function_exists( 'muzicband_comment' ) ) :
/**
 * Template for comments and pingbacks.
 * 
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function muzicband_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php esc_html_e( 'Pingback:', 'muzicband' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'muzicband' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo '<figure>'.esc_url( get_avatar( $comment, 74 ) ).'</figure>';
					echo '<div class="comment-meta-wrapper">';
					printf( '<div class="comment-author-link"><i class="fa fa-user" aria-hidden="true"></i> %1$s%2$s</div>',
						wp_kses( get_comment_author_link(), array( 'a'=> array( 'href' => array(), 'rel' => array(), 'class' => array() ) ) ),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . esc_html__( 'Post author', 'muzicband' ) . '</span>' : ''
					);
					printf( '<div class="comment-date-time"><i class="fa fa-calendar-o" aria-hidden="true"></i> %1$s</div>',
						sprintf( __( '%1$s at %2$s', 'muzicband' ), esc_html( get_comment_date() ), esc_html( get_comment_time() ) )
					);
					printf( '<a class="comment-permalink" href="%1$s"><i class="fa fa-link aria-hidden="true""></i> Permalink</a>', esc_url( get_comment_link( $comment->comment_ID ) ) );
					edit_comment_link();
					echo '</div>';
				?>
			</header><!-- .comment-meta -->
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'muzicband' ); ?></p>
			<?php endif; ?>
			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="fa fa-reply-all" aria-hidden="true"></i> Reply', 'muzicband' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</section><!-- .comment-content -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

/**
 * Change hex code to RGB
 * Source: https://css-tricks.com/snippets/php/convert-hex-to-rgb/#comment-1052011
 */
function muzicband_hex2rgb($hexstr) {
    $int = hexdec($hexstr);
    $rgb = array("red" => 0xFF & ($int >> 0x10), "green" => 0xFF & ($int >> 0x8), "blue" => 0xFF & $int);
    $r = $rgb['red'];
    $g = $rgb['green'];
    $b = $rgb['blue'];

    return "rgba($r,$g,$b, 0.85)";
}

/**
 * Generate darker color
 * Source: http://stackoverflow.com/questions/3512311/how-to-generate-lighter-darker-color-with-php
 */
function muzicband_lightcolor($hex, $steps) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max(+255, min(255, $steps));

	// Normalize into a six character long hex string
	$hex = str_replace('#', '', $hex);
	if (strlen($hex) == 3) {
		$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	}

	// Split into three parts: R, G and B
	$color_parts = str_split($hex, 2);
	$return = '#';

	foreach ($color_parts as $color) {
		$color   = hexdec($color); // Convert to decimal
		$color   = max(0,min(255,$color + $steps)); // Adjust color
		$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	}

	return $return;
}

add_action( 'wp_head', 'muzicband_custom_css' );
/**
 * Hooks the Custom Internal CSS to head section
 */
function muzicband_custom_css() {

	$primary_color   = esc_attr( get_theme_mod( 'muzicband_primary_color', '#ff4a1c' ) );
	$primary_opacity = muzicband_hex2rgb($primary_color);
	$primary_light    = muzicband_lightcolor($primary_color, -20);

	$muzicband_internal_css = '';
	if( $primary_color != '#00aced' ) {
	}

	if( !empty( $muzicband_internal_css ) ) {
	?>
		<style type="text/css"><?php echo $muzicband_internal_css; ?></style>
	<?php
	}

	$muzicband_custom_css = get_theme_mod( 'muzicband_custom_css', '' );
	if( !empty( $muzicband_custom_css ) ) {
		echo '<!-- '.get_bloginfo('name').' Custom Styles -->';
	?>
		<style type="text/css"><?php echo esc_html( $muzicband_custom_css ); ?></style>
	<?php
	}
}

/****************************************************************************************/

if ( ! function_exists( 'tg_events_event_schedule_details' ) ) :
/*
 * TribeEventsCalendar - function to dispaly the date and time of event
 */
function tg_events_event_schedule_details( $event = null, $before = '', $after = '' ) {
	if ( is_null( $event ) ) {
		global $post;
		$event = $post;
	}

	if ( is_numeric( $event ) ) {
		$event = get_post( $event );
	}

	$inner                    = '<span class="date">';
	$format                   = '';
	$date_without_year_format = tribe_get_date_format();
	$date_with_year_format    = tribe_get_date_format( true );
	$time_format              = get_option( 'time_format' );
	$datetime_separator       = tribe_get_option( 'dateTimeSeparator', ' @ ' );
	$time_range_separator     = tribe_get_option( 'timeRangeSeparator', ' - ' );

	$settings = array(
		'show_end_time' => true,
		'time'          => true,
	);

	$settings = wp_parse_args( apply_filters( 'tribe_events_event_schedule_details_formatting', $settings ), $settings );
	if ( ! $settings['time'] ) {
		$settings['show_end_time'] = false;
	}

	/**
	 * @var $show_end_time
	 * @var $time
	 */
	extract( $settings );

	$format = $date_with_year_format;

	// if it starts and ends in the current year then there is no need to display the year
	if ( tribe_get_start_date( $event, false, 'Y' ) === date( 'Y' ) && tribe_get_end_date( $event, false, 'Y' ) === date( 'Y' ) ) {
		$format = $date_without_year_format;
	}

	if ( tribe_event_is_multiday( $event ) ) { // multi-date event

		$format2ndday = apply_filters( 'tribe_format_second_date_in_range', $format, $event );

		if ( tribe_event_is_all_day( $event ) ) {
			$inner .= tribe_get_start_date( $event, true, $format );
			$inner .= $time_range_separator;

			$end_date_full = tribe_get_end_date( $event, true, Tribe__Date_Utils::DBDATETIMEFORMAT );
			$end_date_full_timestamp = strtotime( $end_date_full );

			// if the end date is <= the beginning of the day, consider it the previous day
			if ( $end_date_full_timestamp <= strtotime( tribe_beginning_of_day( $end_date_full ) ) ) {
				$end_date = tribe_format_date( $end_date_full_timestamp - DAY_IN_SECONDS, false, $format2ndday );
			} else {
				$end_date = tribe_get_end_date( $event, false, $format2ndday );
			}

			$inner .= $end_date;
		} else {
			$inner .= tribe_get_start_date( $event, false, $format ) . $time_range_separator . tribe_get_end_date( $event, false, $format2ndday );
			$inner .= '</span>';
			$inner .= '<span class="time"><i class="fa fa-clock-o"></i>';
			$inner .= ( $time ? tribe_get_start_date( $event, false, $time_format ) : '' ) . ( $time ? $time_range_separator . tribe_get_end_date( $event, false, $time_format ) : '' );
		}
	} elseif ( tribe_event_is_all_day( $event ) ) { // all day event
		$inner .= tribe_get_start_date( $event, true, $format );
		$inner .= '</span>';
		$inner .= '<span class="time"><i class="fa fa-clock-o"></i>';
		$inner .= 'All Day Event';
	} else { // single day event
		if ( tribe_get_start_date( $event, false, 'g:i A' ) === tribe_get_end_date( $event, false, 'g:i A' ) ) { // Same start/end time
			$inner .= tribe_get_start_date( $event, false, $format );
			$inner .= '</span>';
			$inner .= '<span class="time"><i class="fa fa-clock-o"></i>';
			$inner .= $time ? tribe_get_start_date( $event, false, $time_format ) : '';
		} else { // defined start/end time
			$inner .= tribe_get_start_date( $event, false, $format );
			$inner .= '</span>';
			$inner .= '<span class="time"><i class="fa fa-clock-o"></i>';
			$inner .= $time ? tribe_get_start_date( $event, false, $time_format ) : '';
			$inner .= $show_end_time ? $time_range_separator . tribe_get_end_date( $event, false, $time_format ) : '';
		}
	}

	$inner .= '</span>';

	/**
	 * Provides an opportunity to modify the *inner* schedule details HTML (ie before it is
	 * wrapped).
	 *
	 * @param string $inner_html  the output HTML
	 * @param int    $event_id    post ID of the event we are interested in
	 */
	$inner = apply_filters( 'tribe_events_event_schedule_details_inner', $inner, $event->ID );

	// Wrap the schedule text
	$schedule = $before . $inner . $after;

	/**
	 * Provides an opportunity to modify the schedule details HTML for a specific event after
	 * it has been wrapped in the before and after markup.
	 *
	 * @param string $schedule  the output HTML
	 * @param int    $event_id  post ID of the event we are interested in
	 * @param string $before    part of the HTML wrapper that was prepended
	 * @param string $after     part of the HTML wrapper that was appended
	 */
	return apply_filters( 'tribe_events_event_schedule_details', $schedule, $event->ID, $before, $after );
}
endif;
