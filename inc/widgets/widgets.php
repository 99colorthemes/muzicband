<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function muzicband_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Right', 'muzicband' ),
		'id'            => 'muzicband_sidebar_right',
		'description'   => esc_html__( 'Add widgets in your right sidebar of  theme.', 'muzicband' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Left', 'muzicband' ),
		'id'            => 'muzicband_sidebar_left',
		'description'   => esc_html__( 'Add widgets in your left sidebar of  theme.', 'muzicband' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
  for ($i=1; $i<4 ; $i++) { 
    register_sidebar( array(
      'name'          => esc_html__( 'Footer Sidebar '. $i , 'muzicband' ),
      'id'            => 'muzicband_footer_section_'.$i,
      'description'   => esc_html__( 'Add widgets in your footer '. $i .' sidebar of  theme.', 'muzicband' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ) );
  }
	register_sidebar( array(
		'name'          => esc_html__( 'Front page builder', 'muzicband' ),
		'id'            => 'muzicband_frontpage_section',
		'description'   => esc_html__( 'Add widgets in your front page content area.', 'muzicband' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

  // Registering WooCommerce sidebar
  if ( class_exists('WooCommerce') ) {
    register_sidebar( array(
      'name'            => esc_html__( 'WooCommerce Sidebar', 'muzicband' ),
      'id'              => 'muziicband_woocommerce_sidebar',
      'description'     => esc_html__( 'Shows widgets on WooCommerce page Sidebar.', 'muzicband' ),
      'before_widget'   => '<aside id="%1$s" class="widget %2$s clearfix">',
      'after_widget'    => '</aside>',
      'before_title'    => '<h2 class="widget-title">',
      'after_title'     => '</h2>'
    ) );
    register_widget( "muzicband_special_recipes_woo_widget" );
  }

  register_widget( "muzicband_gallery_widget" );
  register_widget( "muzicband_cta_widget" );
  register_widget( "muzicband_blog_posts_widget" );
  register_widget( "muzicband_team_widget" );
  
}
add_action( 'widgets_init', 'muzicband_widgets_init' );

/************************************************************************************************************/
/**
 * Gallery Widget.
 */
class muzicband_gallery_widget extends WP_Widget {
  function __construct() {
  $widget_ops           = array( 
      'classname'       => 'widget_gallery_block', 
      'description'     => esc_html__( 'Display your images as in grid gallery views.', 'muzicband' ) 
    );
    $control_ops        = array( 
      'width'           => 200, 
      'height'          =>250 
    );
    parent::__construct( 
      false, 
      $name             = esc_html__( 'NNC: Gallery', 'muzicband' ), 
      $widget_ops, 
      $control_ops
    );
  }// end of construct.

  function form( $instance ) {
    $defaults = array();
    $defaults['title'] = '';
    $defaults['text'] = '';
    for ($i=0; $i<6; $i++) { 
      $defaults['image_'.$i] = '';
    }
    $instance             = wp_parse_args( (array) $instance, $defaults );

    $title                = $instance['title'];
    $text                 = $instance['text'];
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'muzicband' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php esc_html_e( 'Description','muzicband' ); ?>
    <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_textarea( $text ); ?></textarea>

    <?php for ( $i=0; $i<6; $i++ ) : ?>
      <p>
         <label for="<?php echo $this->get_field_id('image_'.$i); ?>"> <?php esc_html_e( 'Image ', 'muzicband' ); ?> </label> <br />
         <div class="media-uploader" id="<?php echo $this->get_field_id('image_'.$i); ?>">
            <div class="custom_media_preview">
               <?php if ( $instance['image_'.$i] != '') : ?>
                  <img class="custom_media_preview_default" src="<?php echo $instance['image_'.$i]; ?>" style="max-width:100%;" />
               <?php endif; ?>
            </div>
            <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id('image_'.$i); ?>" name="<?php echo $this->get_field_name('image_'.$i); ?>" value="<?php echo $instance['image_'.$i]; ?>" style="margin-top:5px;" />
            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id('image_'.$i); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'muzicband' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'muzicband' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'muzicband' ); ?></button>
         </div>
      </p>
      <hr/>
    <?php endfor; ?>
    <p>
      <strong><?php esc_html_e( 'Note:', 'muzicband'); ?></strong><br/>
      <?php esc_html_e( '1. Recommanded Image size 110 × 100 Pixels.', 'muzicband' ); ?><br/>
    </p>
    
  <?php }// end of form function.

  function update( $new_instance, $old_instance ) {
    $instance                 = $old_instance;
    $instance['title']      = sanitize_text_field( $new_instance['title'] );
    for( $i=0; $i<6; $i++ ) {
      $instance['image_'.$i]   = esc_url_raw( $new_instance['image_'.$i] );
    }
    if ( current_user_can('unfiltered_html') )
      $instance['text']     =  $new_instance['text'];
    else
      $instance['text']     = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); 
      // wp_filter_post_kses() expects slashed
    return $instance;
  }// end of update function.

  function widget( $args, $instance ) {
    extract( $args );
    extract( $instance );

    global $post;
    $title             = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '');
    $text              = isset( $instance['text'] ) ? $instance['text'] : '';
    $images = array();
    
    for( $i=0; $i<6; $i++ ) {
      $images[] = isset( $instance['image_'.$i] ) ? $instance['image_'.$i] : '';
    } ?>

    <?php echo $before_widget; ?>
    <!-- Gallery-start -->
      <?php if ( !empty( $title ) || !empty( $text ) ) :
          if ( !empty( $title ) ) {
            echo '<h2>'.esc_attr( $title ).'</h2>';
          }
          if ( !empty( $text ) ) {
            echo '<p>'.esc_textarea( $text ).'</p>';
          }
      endif; ?>
      <?php if ( !empty( $images ) ) :
      foreach ( $images as $key => $image ) {
        if ( $image !='' ){
          echo '<img src="'.esc_url( $image ).'">';
        }
      } 
      endif; ?>
    <!-- Gallery-end -->
    <?php echo $after_widget; ?>      
  <?php 
  }// end of widdget function.
}// end of apply for action widget.

/************************************************************************************************************/
/**
 * Call to Action Widget.
 */
class muzicband_cta_widget extends WP_Widget {
  function __construct() {
  $widget_ops          = array( 
      'classname'      => 'muzicband_cta_block', 
      'description'    => esc_html__( 'Display title, description, image and buttons as call to action.', 'muzicband' ) 
    );
    $control_ops       = array( 
      'width'          => 200, 
      'height'         =>250 
    );
    parent::__construct( 
      false, 
      $name            = esc_html__( 'NNC: Call To Aciton', 'muzicband' ), 
      $widget_ops, 
      $control_ops
    );
  }// end of construct.

  function form( $instance ) {
    $defaults       = array( 'title' => '', 'text' => '','image'=>'', 'btn_text'=>'', 'btn_url'=>'' );

    $instance            = wp_parse_args( (array) $instance, $defaults );
    $title               = $instance['title'];
    $text                = $instance['text'];
    $image                = $instance['image'];
    $btn_text               = $instance['btn_text'];
    $btn_url                = $instance['btn_url'];
  ?>
  <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'muzicband' ); ?></label>
    <input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
  </p>
  <?php esc_html_e( 'Description','muzicband' ); ?>
  <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text'); ?>"><?php echo esc_textarea( $text ); ?></textarea>
  <p>
     <label for="<?php echo $this->get_field_id( 'image' ); ?>"> <?php esc_html_e( 'Background Image:', 'muzicband' ); ?> </label> <br />
     <div class="media-uploader" id="<?php echo $this->get_field_id( 'image' ); ?>">
        <div class="custom_media_preview">
           <?php if ( $image != '' ) : ?>
              <img class="custom_media_preview_default" src="<?php echo $image; ?>" style="max-width:100%;" />
           <?php endif; ?>
        </div>
        <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $image; ?>" style="margin-top:5px;" />
        <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'muzicband' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'muzicband' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'muzicband' ); ?></button>
     </div>
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'btn_text' ); ?>"><?php esc_html_e( 'Button Text:', 'muzicband' ); ?></label>
    <input id="<?php echo $this->get_field_id( 'btn_text' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'btn_text' ); ?>" type="text" value="<?php echo esc_attr( $btn_text ); ?>" />
  </p>
  <p>
    <label for="<?php echo $this->get_field_id( 'btn_url' ); ?>"><?php esc_html_e( 'Button URL:', 'muzicband' ); ?></label>
    <input id="<?php echo $this->get_field_id( 'btn_url' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'btn_url' ); ?>" type="text" value="<?php echo esc_url( $btn_url ); ?>" />
  </p>

  <?php
  }// end of form function.

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ]           = sanitize_text_field( $new_instance[ 'title' ] );
    $instance[ 'image' ]           = esc_url_raw( $new_instance[ 'image' ] );
    $instance[ 'btn_text' ]           = sanitize_text_field( $new_instance[ 'btn_text' ] );
    $instance[ 'btn_url' ]           = esc_url_raw( $new_instance[ 'btn_url' ] );
    if ( current_user_can( 'unfiltered_html' ) )
      $instance[ 'text' ]            =  $new_instance[ 'text' ];
    else
      $instance[ 'text' ]            = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); 
      // wp_filter_post_kses() expects slashed
    return $instance;
  }// end of update function.

  function widget( $args, $instance ) {
    extract( $args );
    extract( $instance );
    global $post;
    $title  = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
    $text = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
    $image = isset( $instance[ 'image' ] ) ? $instance[ 'image' ] : '';
    $btn_text = isset( $instance[ 'btn_text' ] ) ? $instance[ 'btn_text' ] : '';
    $btn_url = isset( $instance[ 'btn_url' ] ) ? $instance[ 'btn_url' ] : '';
    ?>
    <?php echo $before_widget; ?>

    <!-- cta-start -->
    <div class="nnc-cta"> 
      <div class="parallax-image" style="background: url(<?php echo esc_url( $image ); ?>); background-attachment: fixed; background-size: cover; background-position: center 40px; background-repeat: no-repeat;">
        <div class="bg-white"></div>
      </div>
      <div class="nnc-container">  
        <div class="nnc-cta-block">
          <div class="nnc-cta-dtl">
          <?php if ( !empty( $title ) ) {
            echo '<h4>'.esc_attr( $title ).'</h4>';
          }
          ?>
          <?php if ( !empty( $text ) ) {
            echo '<p>'.esc_textarea( $text ).'</p>';
          }?>
          </div>
          <?php if ( !empty( $btn_text ) ) : ?>
            <a href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_text ); ?></a>
          <?php endif; ?>
          
        </div>
      </div>
    </div>
    <!-- cta-end -->

    <?php echo $after_widget; ?>      
  <?php 
  }// end of widdget function.
}// end of apply for action widget.

/************************************************************************************************************/
/**
 * Blog Posts Widget.
 */
class muzicband_blog_posts_widget extends WP_Widget {
  function __construct() {
  $widget_ops           = array( 
      'classname'       => 'widget_blog_posts_block', 
      'description'     => esc_html__( 'Display blog posts.', 'muzicband' ) 
    );
    $control_ops        = array( 
      'width'           => 200, 
      'height'          =>250 
    );
    parent::__construct( 
      false, 
      $name             = esc_html__( 'NNC: Blog Posts', 'muzicband' ), 
      $widget_ops, 
      $control_ops
    );
  }// end of construct.

  function form( $instance ) {
    $defaults       = array( 'title' => '', 'text' => '', 'number'=>'3', 'type'=>'latest', 'category'=>'', 'btn_text'=>'', 'btn_url'=>'' );
    $instance               = wp_parse_args( (array) $instance, $defaults );
    $title                  = $instance[ 'title' ];
    $text                   = $instance[ 'text' ];
    $number                 = $instance[ 'number' ];
    $type                   = $instance[ 'type' ];
    $category               = $instance[ 'category' ];
    $btn_txt                = $instance[ 'btn_txt' ];
    $btn_url               = $instance[ 'btn_url' ];
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'muzicband' ); ?></label>
      <input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>

    <?php esc_html_e( 'Description','muzicband' ); ?>
    <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_textarea( $text ); ?></textarea>

    <p>
      <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to display:', 'muzicband' ); ?></label>
      <input id="<?php echo $this->get_field_id( 'number' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" value="<?php echo $number; ?>" size="3" />
    </p>

    <p>
      <input type="radio" <?php checked( $type, 'latest' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php esc_html_e( 'Show latest Posts', 'muzicband' );?><br />
      <input type="radio" <?php checked( $type,'category' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php esc_html_e( 'Show posts from a category', 'muzicband' );?><br />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Select category', 'muzicband' ); ?>:</label>
      <?php wp_dropdown_categories(
        array(
        'class'               => 'widefat',
        'name'                => $this->get_field_name( 'category' ), 
        'selected'            => $category 
        ) 
      ); ?>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'btn_txt' ); ?>"><?php esc_html_e( 'Button Text:', 'muzicband' ); ?></label>
      <input id="<?php echo $this->get_field_id( 'btn_txt' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'btn-txt' ); ?>" type="text" value="<?php echo esc_attr( $btn_txt ); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'btn_url' ); ?>"><?php esc_html_e( 'Button URL:', 'muzicband' ); ?></label>
      <input id="<?php echo $this->get_field_id( 'btn_url' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'btn-url' ); ?>" type="text" value="<?php echo esc_url( $btn_url ); ?>" />
    </p>

    <p><?php esc_html_e( 'Info: To display posts from specific category, select the Category in above radio option than select the category from the drop-down list.', 'muzicband' ); ?></p>
  <?php
  }// end of form function.

  function update( $new_instance, $old_instance ) {
    $instance                 = $old_instance; 
    $instance[ 'title' ]      = sanitize_text_field( $new_instance[ 'title' ] );
    $instance[ 'number' ]     = absint( $new_instance[ 'number' ] );
    $instance[ 'type' ]       = esc_attr( $new_instance[ 'type' ] );
    $instance[ 'category' ]   = absint( $new_instance[ 'category' ] );
    $instance[ 'btn_txt' ]    = sanitize_text_field( $new_instance[ 'btn_txt' ] );
    $instance[ 'btn_url' ]    = esc_url_raw( $new_instance[ 'btn_url' ] );

    if ( current_user_can('unfiltered_html') )
      $instance[ 'text' ]     =  $new_instance[ 'text' ];
    else
      $instance[ 'text' ]     = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); 
      // wp_filter_post_kses() expects slashed
    return $instance;
  }// end of update function.

  private function nnc_post_date() {
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

    printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark">%3$s</a></span>', 'muzicband' ),
      esc_url( get_permalink() ),
      esc_attr( get_the_time() ),
      $time_string
    );
  }
  function widget( $args, $instance ) {
    extract( $args );
    extract( $instance );

    global $post;
    
    $title                    = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
    $text = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
    $number = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];
    $type = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
    $category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
    $btn_txt = isset( $instance[ 'btn_txt' ] ) ? $instance[ 'btn_txt' ] : '';
    $btn_url = isset( $instance[ 'btn_url' ] ) ? $instance[ 'btn_url' ] : '';

    if( $type == 'latest' ) {
      $get_featured_posts = new WP_Query( array(
        'posts_per_page'        => $number,
        'post_type'             => 'post',
        'ignore_sticky_posts'   => true
        ) );
    }
    else {
      $get_featured_posts = new WP_Query( array(
        'posts_per_page'        => $number,
        'post_type'             => 'post',
        'category__in'          => $category
        ) );
    }
    ?>
    <?php echo $before_widget; ?>

    <!-- blogs-start -->
    <div class="nnc-blogs">
      <div class="nnc-container">
        <div class="nnc-title">
          <?php if ( !empty( $title ) ) {
            echo '<h2>'.esc_attr( $title ).'</h2>';
          }
          ?>
          <?php if ( !empty( $text ) ) {
            echo '<p>'.esc_textarea( $text ).'</p>';
          }?>
        </div>
        <div class="nnc-blog">
        <?php while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post(); ?>
          <div class="nnc-blog-single"> 
            <?php if ( has_post_thumbnail() ) : ?>
              <figure class="nnc-blog-img">
                <?php the_post_thumbnail( 'muzicband-blog' ); ?>
              </figure>
            <?php endif; ?>
            <div class="nnc-blog-dtl">
              <?php echo $this->nnc_post_date(); ?>
              <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
              <?php the_excerpt(); ?>
              <?php if ( trim( $post->post_content ) != "") : ?>
                <a href="<?php the_permalink(); ?>"><?php echo esc_html('Read More','muzicband');?></a>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile;?>
        <?php wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
    <!-- blogs-end -->

    <?php echo $after_widget; ?>      
  <?php 
  }// end of widdget function.
}// end of apply for action widget.

/************************************************************************************************************/
/**
 * Team widget.
 */
class muzicband_team_widget extends WP_Widget {
  function __construct() {
  $widget_ops           = array( 
      'classname'       => 'widget_team_block', 
      'description'     => esc_html__( 'Display team members details of page content.', 'muzicband' ) 
    );
    $control_ops        = array( 
      'width'           => 200, 
      'height'          =>250 
    );
    parent::__construct( 
      false, 
      $name             = esc_html__( 'NNC: Team Memebers', 'muzicband' ), 
      $widget_ops, 
      $control_ops
    );
  }// end of construct.

  function form( $instance ) {
    $defaults = array();
    $defaults['title'] = '';
    $defaults['text'] = '';
    for ($i=0; $i<4; $i++) { 
      $defaults['page_'.$i] = '';
      $defaults['fc_url_'.$i] = '';
      $defaults['twt_url_'.$i] = '';
      $defaults['gplus_url_'.$i] = '';
    }

    $instance            = wp_parse_args( (array) $instance, $defaults );
    $title               = $instance[ 'title' ];
    $text                = $instance[ 'text' ];
    ?>

    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'muzicband' ); ?></label>
      <input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php esc_html_e( 'Description','muzicband' ); ?>
    <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_textarea( $text ); ?></textarea>
    <?php for ($i=0; $i<4; $i++) : ?>
    <p>
      <label for="<?php echo $this->get_field_id('page_'.$i); ?>"><?php esc_html_e( 'Page: ', 'muzicband' ); ?></label>
      <?php
        $arg = array(
            'class' => 'widefat',
            'show_option_none' =>' ',
            'name' => $this->get_field_name('page_'.$i),
            'id'   => $this->get_field_id('page_'.$i),
            'selected' => absint( $instance['page_'.$i] )
        );
        wp_dropdown_pages( $arg ); 
      ?>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('fc_url_'.$i); ?>"><?php esc_html_e( 'Facebook Profile URL:', 'muzicband' ); ?></label>
      <input id="<?php echo $this->get_field_id('fc_url_'.$i); ?>" class="widefat" name="<?php echo $this->get_field_name('fc_url_'.$i); ?>" type="text" value="<?php echo esc_url( $instance['fc_url_'.$i] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('twt_url_'.$i); ?>"><?php esc_html_e( 'Twitter Profile URL:', 'muzicband' ); ?></label>
      <input id="<?php echo $this->get_field_id('twt_url_'.$i); ?>" class="widefat" name="<?php echo $this->get_field_name('twt_url_'.$i); ?>" type="text" value="<?php echo esc_url( $instance['twt_url_'.$i] ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('gplus_url_'.$i); ?>"><?php esc_html_e( 'Gplus Profile URL:', 'muzicband' ); ?></label>
      <input id="<?php echo $this->get_field_id('gplus_url_'.$i); ?>" class="widefat" name="<?php echo $this->get_field_name('gplus_url_'.$i); ?>" type="text" value="<?php echo esc_url( $instance['gplus_url_'.$i] ); ?>" />
    </p>
    <hr/>
    <?php endfor; ?>
  <?php
  }// end of form function.

  function update( $new_instance, $old_instance ) {
    $instance               = $old_instance;
    $instance[ 'title' ]      = sanitize_text_field( $new_instance[ 'title' ] );
    for( $i=0; $i<4; $i++ ) {
      $instance['page_'.$i] = absint( $new_instance['page_'.$i] );
      $instance['fc_url_'.$i] = esc_url_raw( $new_instance['fc_url_'.$i] );
      $instance['twt_url_'.$i] = esc_url_raw( $new_instance['twt_url_'.$i] );
      $instance['gplus_url_'.$i] = esc_url_raw( $new_instance['gplus_url_'.$i] );
    }

    if ( current_user_can('unfiltered_html') )
      $instance['text']     =  $new_instance['text'];
    else
      $instance['text']     = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); 
      // wp_filter_post_kses() expects slashed
    return $instance;
  }// end of update function.

  function widget( $args, $instance ) {
    extract( $args );
    extract( $instance );

    global $post;
  
    $title                    = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '');
    $text                    = isset( $instance['text'] ) ? $instance['text'] : '';
    $pages = array();
    $facebook = array();
    $twitter = array();
    $google_plus = array();
    for( $i=0; $i<4; $i++ ) {
      $pages[] = isset( $instance['page_'.$i] ) ? $instance['page_'.$i] : '';
      $facebook[] = isset( $instance['fc_url_'.$i] ) ? $instance['fc_url_'.$i] : '';
      $twitter[] = isset( $instance['twt_url_'.$i] ) ? $instance['twt_url_'.$i] : '';
      $google_plus[] = isset( $instance['gplus_url_'.$i] ) ? $instance['gplus_url_'.$i] : '';  
    }

    $get_featured_pages = new WP_Query( array(
      'posts_per_page'            => -1,
      'post_type'                 =>  array( 'page' ),
      'post__in'                  => $pages,
      'orderby'                   => 'post__in'
    ) );
    ?>
    
    <?php echo $before_widget; ?>

    <?php if ( !empty( $pages ) ) : ?>
    <!-- member-start -->
    <div class="nnc-b-members">
      <div class="nnc-container">
        <div class="nnc-title"> 
          <?php if ( !empty( $title ) ) {
            echo '<h2>'.esc_attr( $title ).'</h2>';
          }
          ?>
          <?php if ( !empty( $text ) ) {
            echo '<p>'.esc_textarea( $text ).'</p>';
          }?>
        </div>
        <div class="nnc-band-member">
        <?php 
        $post_count = 0; 
        while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post(); ?>
          <div class="nnc-single-member">
            <?php if ( has_post_thumbnail() ) : ?>
              <figure class="nnc-member-img">
                <?php the_post_thumbnail( 'muzicband-team' ); ?>
              </figure>
            <?php endif; ?>
            <div class="nnc-single-dtl">
              <h4><?php the_title(); ?></h4>
              <ul class="nnc-social-icon">
                <?php if ( !empty( $facebook[$post_count] ) ) : ?>
                  <li class="fb"><a href="<?php echo esc_url( $facebooke[$post_count] ); ?>"><i class="fa fa-facebook"></i></a></li>
                <?php endif; ?>
                <?php if ( !empty( $twitter[$post_count] ) ) : ?>
                  <li class="twit"><a href="<?php echo esc_url( $twitter[$post_count] ); ?>"><i class="fa fa-twitter"></i></a></li>
                <?php endif; ?>
                <?php if ( !empty( $google_plus[$post_count] ) ) : ?>
                  <li class="gplus"><a href="<?php echo esc_url( $google_plus[$post_count] ); ?>"><i class="fa fa-google-plus"></i></a></li>
                <?php endif; ?>
              </ul>
              <?php the_excerpt(); ?>
            </div>
          </div>
        <?php $post_count++; endwhile; 
        // Reset Post Data
        wp_reset_postdata();?>
        </div>
      </div>
    </div>
    <!-- member-end -->
    <?php endif; ?>
    
    <?php echo $after_widget; ?>      
  <?php 
  }// end of widdget function.
}// end of apply for action widget.

/************************************************************************************************************/
/**
 * Special Recipes WooCommerce
 */
class muzicband_special_recipes_woo_widget extends WP_Widget {
  function __construct() {
  $widget_ops           = array( 
      'classname'       => 'widget_product_block', 
      'description'     => esc_html__( 'Show WooCommerce Products.', 'muzicband' ) 
    );
    $control_ops        = array( 
      'width'           => 200, 
      'height'          =>250 
    );
    parent::__construct( 
      false, 
      $name             = esc_html__( 'NNC: Latest Products', 'muzicband' ), 
      $widget_ops, 
      $control_ops
    );
  }// end of construct.

  function form( $instance ) {

    $defaults[ 'title' ] = '';
    $defaults[ 'text' ] = '';
    $defaults[ 'number' ] = '3';
    $defaults[ 'type' ] = 'latest';
    $defaults[ 'category' ] = '';

    $instance = wp_parse_args( (array) $instance, $defaults );

    $title = esc_attr( $instance['title'] );
    $text = esc_textarea( $instance['text'] );
    $number = absint( $instance[ 'number' ] );
    $type = $instance[ 'type' ];
    $category = $instance['category'];
    ?>

    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'muzicband' ); ?></label>
      <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
    </p>

    <?php esc_html_e( 'Description:','muzicband' ); ?>
    <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

    <p>
      <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of Special items to display:', 'muzicband' ); ?></label>
      <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
    </p>

    <p>
      <input type="radio" <?php checked( $type, 'latest' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php esc_html_e( 'Show Latest Products', 'muzicband' );?><br />
      <input type="radio" <?php checked( $type,'category' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php esc_html_e( 'Show Products from a category', 'muzicband' );?><br />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Select category', 'muzicband' ); ?>:</label>
      <?php
      wp_dropdown_categories(
        array(
          'show_option_none' => ' ',
          'name'             => $this->get_field_name( 'category' ),
          'selected'         => $instance['category'],
          'taxonomy'         => 'product_cat'
        )
      );
      ?>
    </p>

    <p><?php esc_html_e( 'Note: Create the woocommerce products and choose above whether to display latest products or products from certain category.', 'muzicband' ); ?></p>
  <?php }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );

    if ( current_user_can('unfiltered_html') ) {
      $instance[ 'text' ] =  $new_instance[ 'text' ];
    }
    else {
      $instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); // wp_filter_post_kses() expects slashed
    }
    $instance[ 'number' ] = absint( $new_instance[ 'number' ] );
    $instance[ 'type' ] = $new_instance[ 'type' ];
    $instance[ 'category' ] = $new_instance[ 'category' ];

    return $instance;
  }

  function widget( $args, $instance ) {
    extract( $args );
    extract( $instance );

    global $post, $muzicband_duplicate_posts;
    $title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
    $text = isset( $instance[ 'text' ] ) ? $instance['text'] : '';
    $number = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];
    $type = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
    $category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';

    if( $type == 'latest' ) {
      $get_featured_posts = new WP_Query( array(
        'posts_per_page'        => $number,
        'post_type'             => 'product',
        'ignore_sticky_posts'   => true
      ) );
    }
    else {
    $get_featured_posts = new WP_Query( array(
      'post_type' => 'product',
      'orderby'   => 'date',
      'tax_query' => array(
        array(
          'taxonomy'  => 'product_cat',
          'field'     => 'id',
          'terms'     => $category
        )
      ),
      'posts_per_page' => $number
      ) );
    }
    echo $before_widget; ?>

    <!-- latest-albums-start -->
    <div class="nnc-albums">
      <div class="nnc-container">
        <div class="nnc-title">
        <?php if ( !empty( $title ) ) {
            echo '<h2>'.esc_attr( $title ).'</h2>';
          }
          ?>
          <?php if ( !empty( $text ) ) {
            echo '<p>'.esc_textarea( $text ).'</p>';
          }?>
        </div>

        
        <div class="nnc-album">
        <?php while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post(); ?>
          <div class="nnc-album-single">
          <?php if( has_post_thumbnail() ) { ?>
            <figure class="nnc-album-img">
              <?php the_post_thumbnail(); ?>
              <span class="nnc-disk"></span>
            </figure>                  
          <?php } ?>
            <div class="nnc-album-dtl">
              <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
              <?php the_excerpt(); ?>
              <a href="<?php the_permalink(); ?>"><?php esc_html_e('Buy Now','muzicband'); ?></a>
            </div>
          </div>
        <?php endwhile; ?>
        </div>
      </div>
    </div>
    <!-- latest-albums-end -->

    <?php echo $after_widget;
  }
}


