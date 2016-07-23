<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'muzicband_before' ); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'muzicband' ); ?></a>
	<?php do_action( 'muzicband_before_header' ); ?>
	<!-- header-start --> 
	<?php if ( is_front_page() && !is_home() ) { $header_class = 'site-header'; } else { $header_class = 'site-header sh-2'; } ?>
	<header role="banner" class="<?php echo esc_attr( $header_class ); ?>" id="masthead"> 
		<div class="nnc-header">
			<div class="nnc-container">
				<div class="site-branding">

					<div class="header-logo">
						<?php if( ( get_theme_mod( 'muzicband_header_logo_placement', 'header_text_only' ) == 'show_both' || get_theme_mod( 'muzicband_header_logo_placement', 'header_text_only' ) == 'header_logo_only' ) && has_custom_logo() ) : ?>
							<div class="logo">
								<?php muzicband_the_custom_logo(); ?>
							</div><!-- .logo-->
						<?php endif; ?>
					</div><!-- .header-logo -->

					<?php $screen_reader = 'normal-header';
					if ( ( get_theme_mod( 'muzicband_header_logo_placement', 'header_text_only' ) == 'header_logo_only' || get_theme_mod( 'muzicband_header_logo_placement', 'header_text_only' ) == 'disable' ) ) {
						$screen_reader = 'screen-reader-text';
					}
					if ( get_theme_mod( 'muzicband_header_logo_placement', 'header_text_only' ) == 'show_both' ) {					$screen_reader = 'nnc-seperate';
					} ?>

					<div id="header-text" class="<?php echo esc_attr( $screen_reader ); ?>">
						<?php
						if ( is_front_page() || is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
						endif;
						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
						<?php
						endif; ?>
					</div><!-- #header-text -->
					
				</div><!-- .site-branding -->

				<?php if (class_exists('woocommerce')): ?>
					<div class="nnc-login">
						<?php if ( is_user_logged_in() ) { ?>
							<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" title="<?php esc_attr_e('My Account','muzicband'); ?>"><?php esc_html_e('My Account', 'muzicband'); ?></a>
						<?php } else { ?>
							<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>" title="<?php esc_attr_e('Login','muzicband'); ?>"class="user-icon"><?php esc_html_e('Login', 'muzicband'); ?></a>
						<?php } ?>
					</div><!-- .login -->

					<div class="nnc-cart">
						<a href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" class="wcmenucart-contents">
							<i class="fa fa-cart-arrow-down"></i>
							<span class="cart-value"><?php echo wp_kses_data ( WC()->cart->get_cart_contents_count() ); ?></span>
						</a> <!-- quick wishlist end -->
					</div><!-- .cart -->
				<?php endif; ?>

				<div class="nnc-search">
					<?php get_search_form(); ?>
				</div><!-- .nnc-search -->

				<nav id="site-navigation" class="main-navigation" role="navigation">
					<div class="menu-main-menu-container">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'menu_class' => 'menu' ) ); ?>
					</div>	
				</nav><!-- #site-navigation -->
			</div>
		</div> 
	</header>
	<!-- header-end -->
	<?php do_action( 'muzicband_after_header' ); ?>
	<?php
	if( get_theme_mod( 'muzicband_slider_activation' ) == '1' && is_front_page() && !is_home() ){
		get_template_part( 'template-parts/content', 'slider' );
	}
	?>
	<?php do_action( 'muzicband_before_main' ); ?>
