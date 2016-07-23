<?php
/**
 * Template Name: MuzicBand Startpage
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */
?>

<?php get_header(); ?>

  <?php do_action( 'muzicband_before_body_content' ); ?>

  <?php if( is_active_sidebar( 'muzicband_frontpage_section' ) ) {
    if( !dynamic_sidebar( 'muzicband_frontpage_section' ) ):
    endif;
  } ?>

  <?php do_action( 'muzicband_before_body_content' ); ?>

<?php get_footer(); ?>