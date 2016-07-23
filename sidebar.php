<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */
?>
<!-- sidebar right -->

<div id="secondary">
   <?php do_action( 'muzicband_before_sidebar' ); ?>
      <?php if ( ! dynamic_sidebar( 'muzicband_sidebar_right' ) ) :
         the_widget( 'WP_Widget_Text',
            array(
               'title'  => esc_html__( 'Example Widget', 'muzicband' ),
               'text'   => sprintf( __( 'This is an example widget to show how the Right Sidebar looks by default. You can add custom widgets from the %swidgets screen%s in the admin. If custom widgets is added than this will be replaced by those widgets.', 'muzicband' ), current_user_can( 'edit_theme_options' ) ? '<a href="' . admin_url( 'widgets.php' ) . '">' : '', current_user_can( 'edit_theme_options' ) ? '</a>' : '' ),
               'filter' => true,
            ),
            array(
               'before_widget' => '<aside class="widget widget_text clearfix">',
               'after_widget'  => '</aside>',
               'before_title'  => '<h3 class="widget-title"><span>',
               'after_title'   => '</span></h3>'
            )
         );
      endif; ?>
   <?php do_action( 'muzicband_after_sidebar' ); ?>
</div><!-- #secondary -->