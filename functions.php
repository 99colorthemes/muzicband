<?php
/**
 * MuzicBand functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */

if ( ! function_exists( 'muzicband_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function muzicband_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on MuzicBand, use a find and replace
	 * to change 'muzicband' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'muzicband', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	// Add WooCommerce Support
	add_theme_support( 'woocommerce' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	// Register image sizes
	add_image_size( 'muzicband-slider', 1920, 900, true );

	add_image_size( 'muzicband-blog', 370, 255, true );
	add_image_size( 'muzicband-team', 270, 325, true );
	add_image_size( 'muzicband-event-image', 390, 220, true );
	

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'muzicband' ),
		'social' => esc_html__( 'Social Icon', 'muzicband' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Adds Support for Custom Logo Introduced in WordPress 4.5
	add_theme_support( 'custom-logo',
		array(
    		'flex-width' => true,
    		'flex-height' => true,
    	)
    );

    // Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );
}
endif;
add_action( 'after_setup_theme', 'muzicband_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function muzicband_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'muzicband_content_width', 640 );
}
add_action( 'after_setup_theme', 'muzicband_content_width', 0 );

if ( ! function_exists( 'muzicband_fonts_url' ) ) :
/**
 * Register Google fonts for muzicband.
 *
 * Create your own muzicband_fonts_url() function to override in a child theme.
 *
 * @return string Google fonts URL for the theme.
 */
function muzicband_fonts_url() {
  $fonts_url = '';
  $fonts = array();
  $subsets = 'latin,latin-ext';
  // applying the translators for the Google Fonts used
  /* Translators: If there are characters in your language that are not
   * supported by Roboto, translate this to 'off'. Do not translate
   * into your own language.
   */
  if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'muzicband' ) ) {
     $fonts[] = 'Roboto:400,300,500,700,400italic';
  }

  // ready to enqueue Google Font
  if ( $fonts ) {
     $fonts_url = add_query_arg( array(
        'family' => urlencode( implode( '|', $fonts ) ),
        'subset' => urlencode( $subsets ),
     ), '//fonts.googleapis.com/css' );
  }
  return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles.
 */
function muzicband_scripts() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// use of enqueued google fonts
	wp_enqueue_style( 'muzicband-google-fonts', muzicband_fonts_url(), array(), null );
	
	wp_enqueue_style( 'muzicband-style', get_stylesheet_uri() );

	//Register font-awesome style
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/font-awesome/css/font-awesome' .$suffix. '.css', false, '4.6.3' );

	//Register swiper style
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/swiper.css', false, '3.3.1' );

	//Register muzicband main style
	wp_enqueue_style( 'muzicband-main', get_template_directory_uri() . '/css/style.css', false, '1.0.0' );

	//Register muzicband responsive style
	wp_enqueue_style( 'muzicband-responsive', get_template_directory_uri() . '/css/responsive.css', false, '1.0.0' );

	// Register jQuery.scrollSpeed Script
	wp_enqueue_script( 'jquery-scrollSpeed', get_template_directory_uri() . '/js/jquery.scrollSpeed.js', array( 'jquery' ), '1.0.2', true );
	// Register swiper Script
	wp_enqueue_script( 'swiper-min', get_template_directory_uri() . '/js/swiper.min.js', array( 'jquery' ), '3.3.1', true );
	// Register muzicband main Script
	wp_enqueue_script( 'muzicband-main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '1.0.0', true );

	wp_enqueue_script( 'muzicband-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'muzicband-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'muzicband_scripts' );

/**
 * Add admin scripts and styles.
 */

function muzicband_admin_scripts( $hook ) {
   global $post_type;
   if( $hook == 'widgets.php' || $hook == 'customize.php' ) {
 
    //For image uploader
    wp_enqueue_media();

    //For color
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );

   	wp_enqueue_style( 'muzicband-admin-css', get_template_directory_uri() . '/css/admin/muzicband-admin.css', false, '1.0.0' );

   	wp_enqueue_script( 'muzicband-image-uploader', get_template_directory_uri() . '/js/image-uploader.js', array( 'jquery' ), '1.0.0', true );

   	wp_enqueue_script( 'muzicband-color-picker', get_template_directory_uri() . '/js/color-picker.js', array( 'jquery' ), '1.0.0', true );
    
    wp_enqueue_script( 'muzicband-admin-scripts', get_template_directory_uri() . '/js/admin/muzicband-admin.js', array( 'jquery' ), '1.0.0', true );      
       
    }
}
add_action('admin_enqueue_scripts', 'muzicband_admin_scripts');


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/muzicband.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custome Widgts.
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * Custome metabox.
 */
require get_template_directory() . '/inc/admin/meta-boxes.php';

/**
 * Define URL Location Constants
 */
define( 'ANCHOR_PARENT_URL', get_template_directory_uri() );

define( 'ANCHOR_ADMIN_IMAGES_URL', ANCHOR_PARENT_URL . '/images/admin' );

// WooCommerce Specific
if(class_exists('WooCommerce')) {
	// Remove default wrapper
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

	// Adds wrapper around the main content
	add_action('woocommerce_before_main_content', 'muzicband_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'muzicband_wrapper_end', 10);

	function muzicband_wrapper_start() {
	  echo '<div id="primary">';
	}

	function muzicband_wrapper_end() {
	  echo '</div>';
	}
}

/* Add Support for The Event Calendar Plugin by Modern Tribe */
if( class_exists( 'Tribe__Events__Main' ) ) {
	// Loads custom widget for events
	require get_template_directory() . '/inc/event-widget.php';
}