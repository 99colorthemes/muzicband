<?php
/**
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */

?>

<?php
$page_array = array();
for ( $i=1; $i<=4; $i++ ) {
  $page_id = get_theme_mod( 'muzicband_slide'.$i );
    if ( !empty ( $page_id ) )
    array_push( $page_array, $page_id );
}
$get_featured_posts = new WP_Query(
  array(
    'posts_per_page'     => -1,
    'post_type'          =>  array( 'page' ),
    'post__in'           => $page_array,
    'orderby'            => 'post__in'
) ); ?>
<?php if ( ! empty( $page_array ) ) : ?>
  <!-- slider-start -->
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php while( $get_featured_posts->have_posts() ) : $get_featured_posts->the_post(); ?>
          <?php if ( has_post_thumbnail() ) : ?>
              <div class="swiper-slide">
                <div class="nnc-b-img">
                  <?php the_post_thumbnail( 'muzicband-slider' ); ?>
                  <div class="nnc-bg"></div>
                </div>     
                <div class="nnc-caption">
                  <div class="nnc-container">
                    <div class="nnc-dtl">
                      <h2><?php the_title(); ?></h2> 
                      <?php the_excerpt(); ?>
                      <span><a href="#">Check Our Events</a></span>
                      <span><a href="#">Book Now</a></span> 
                    </div>   
                  </div>
                </div> 
              </div>
          <?php endif; ?>

        <?php endwhile;
        // Reset Post Data
        wp_reset_query(); ?>
      </div>
      <!-- Add Pagination -->
      <div class="swiper-pagination"></div>
      <!-- Add Arrows -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  <!-- slider-end -->

<?php endif; ?>


