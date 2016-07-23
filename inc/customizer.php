<?php
/**
 * MuzicBand Theme Customizer.
 *
 * @package 99colorthemes
 * @subpackage MuzicBand
 * @since MuzicBand 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function muzicband_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
/**
 * Loads wp customizer classes.
 */
require_once get_template_directory() . '/inc/wp-customize-class.php';

/********************************* IMPORTANT-LINKS ****************************************/
  $wp_customize->add_section(
    'muzicband_important_links', 
    array(
       'priority'     => 1,
       'title'        => esc_html__('MuzicBand Important Links', 'muzicband')
    )
  );

/**
* This setting has the dummy Sanitization function as it contains no value to be sanitized
*/
  $wp_customize->add_setting(
    'muzicband_important_links', 
    array(
       'capability'          => 'edit_theme_options',
       'sanitize_callback'   => 'muzicband_sanitize_links'
    )
  );

  $wp_customize->add_control(
    new MuzicBand_Important_Links(
      $wp_customize,
      'important_links', 
      array(
        'section'         => 'muzicband_important_links',
        'settings'        => 'muzicband_important_links'
      )
    )
  );


/********************************* SITE-IDENTITY-OPTIONS ****************************************/
  // Slider Activation Setting
  $wp_customize->add_setting(
    'muzicband_tagline_hide',
    array(
      'default'            => '',
      'capability'         => 'edit_theme_options',
      'sanitize_callback'  => 'muzicband_sanitize_checkbox'
    )
  );

  $wp_customize->add_control(
    'muzicband_tagline_hide',
    array(
      'label'    => esc_html__( 'Check to disable tagline' , 'muzicband' ),
      'section'  => 'title_tagline',
      'type'     => 'checkbox',
      'priority' => 10
    )
  );
  // logo and site title position options
 	$wp_customize->add_setting(
 		'muzicband_header_logo_placement',
  	array(
      	'default'            => 'header_text_only',
      	'capability'         => 'edit_theme_options',
      	'sanitize_callback'  => 'muzicband_sanitize_radio'
    	)
 	);

 	$wp_customize->add_control(
    'muzicband_header_logo_placement',
    array(
   		'type'               => 'radio',
   		'priority'           => 20,
   		'label'              => esc_html__('Choose the option that you want from below.', 'muzicband'),
   		'section'            => 'title_tagline',
   		'choices'            => array(
      		'header_logo_only'   => esc_html__('Header Logo Only', 'muzicband'),
      		'header_text_only'   => esc_html__('Header Text Only', 'muzicband'),
      		'show_both'          => esc_html__('Show Both', 'muzicband'),
      		'disable'            => esc_html__('Disable', 'muzicband')
   		)
		)
 	);
/************************************** THEME-OPTIONS *******************************************************/
  $wp_customize->add_panel(
    'muzicband_design_options', 
    array(
      'capabitity'            => 'edit_theme_options',
      'priority'              => 220,
      'title'                 => esc_html__('Theme Options', 'muzicband')
    )
  );

  // site layout setting
  $wp_customize->add_section(
    'muzicband_site_layout_section',
    array(
       'priority'              => 15,
       'title'                 => esc_html__( 'Site Layout', 'muzicband' ),
       'panel'                 => 'muzicband_design_options'
    )
  );

  $wp_customize->add_setting(
    'muzicband_site_layout',
    array(
       'default'               => 'wide',
       'capability'            => 'edit_theme_options',
       'sanitize_callback'     => 'muzicband_sanitize_radio'
    )
  );

  $wp_customize->add_control(
    'muzicband_site_layout',
    array(
      'type'               => 'radio',
      'priority'           => 10,
      'label'              => esc_html__('Choose your site layout. The change is reflected in whole site.', 'muzicband'),
      'section'            => 'muzicband_site_layout_section',
      'choices'            => array(
              'box'            => esc_html__('Boxed layout', 'muzicband'),
              'wide'           => esc_html__('Wide layout', 'muzicband')
      )
    )
  );

  // Default Layout
  $wp_customize->add_section(
    'muzicband_global_layout_section',
    array(
       'priority'              => 30,
       'title'                 => esc_html__( 'Default Layout', 'muzicband' ),
       'panel'                 => 'muzicband_design_options'
    )
  );

  $wp_customize->add_setting(
    'muzicband_global_layout',
    array(
       'default'               => 'right_sidebar',
       'capability'            => 'edit_theme_options',
       'sanitize_callback'     => 'muzicband_sanitize_radio'
    )
  );

  $wp_customize->add_control(
    new MuzicBand_Image_Radio_Control(
      $wp_customize,
      'muzicband_global_layout',
      array(
        'type'               => 'radio',
        'priority'           => 10,
        'label'              => esc_html__('Select default layout. This layout will be reflected in whole site archives, categories, search page etc. The layout for a single post and page can be controlled from below options.', 'muzicband'),
        'section'            => 'muzicband_global_layout_section',
        'choices'            => array(
          'right_sidebar'               => ANCHOR_ADMIN_IMAGES_URL . '/right-sidebar.png',
          'left_sidebar'                => ANCHOR_ADMIN_IMAGES_URL . '/left-sidebar.png',
          'no_sidebar_full_width'       => ANCHOR_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
          'no_sidebar_content_centered' => ANCHOR_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
        )
      )
    )
  );

  // Default Pages Layout
  $wp_customize->add_section(
    'muzicband_default_page_layout_section',
    array(
       'priority'              => 45,
       'title'                 => esc_html__( 'Default Page Layout', 'muzicband' ),
       'panel'                 => 'muzicband_design_options'
    )
  );

  $wp_customize->add_setting(
    'muzicband_default_page_layout',
    array(
       'default'               => 'right_sidebar',
       'capability'            => 'edit_theme_options',
       'sanitize_callback'     => 'muzicband_sanitize_radio'
    )
  );

  $wp_customize->add_control(
    new MuzicBand_Image_Radio_Control(
      $wp_customize,
      'muzicband_default_page_layout',
      array(
        'type'               => 'radio',
        'priority'           => 10,
        'label'              => esc_html__('Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page.', 'muzicband'),
        'section'            => 'muzicband_default_page_layout_section',
        'choices'            => array(
          'right_sidebar'               => ANCHOR_ADMIN_IMAGES_URL . '/right-sidebar.png',
          'left_sidebar'                => ANCHOR_ADMIN_IMAGES_URL . '/left-sidebar.png',
          'no_sidebar_full_width'       => ANCHOR_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
          'no_sidebar_content_centered' => ANCHOR_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
        )
      )
    )
  );

  // Default Single Post Layout
  $wp_customize->add_section(
    'muzicband_default_single_post_layout_section',
    array(
       'priority'              => 60,
       'title'                 => esc_html__( 'Default Single Post Layout', 'muzicband' ),
       'panel'                 => 'muzicband_design_options'
    )
  );

  $wp_customize->add_setting(
    'muzicband_default_single_post_layout',
      array(
         'default'               => 'right_sidebar',
         'capability'            => 'edit_theme_options',
         'sanitize_callback'     => 'muzicband_sanitize_radio'
      )
  );

  $wp_customize->add_control(
    new MuzicBand_Image_Radio_Control(
      $wp_customize,
      'muzicband_default_single_post_layout',
      array(
        'type'               => 'radio',
        'priority'           => 10,
        'label'              => esc_html__('Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post.', 'muzicband'),
        'section'            => 'muzicband_default_single_post_layout_section',
        'choices'            => array(
          'right_sidebar'               => ANCHOR_ADMIN_IMAGES_URL . '/right-sidebar.png',
          'left_sidebar'                => ANCHOR_ADMIN_IMAGES_URL . '/left-sidebar.png',
          'no_sidebar_full_width'       => ANCHOR_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
          'no_sidebar_content_centered' => ANCHOR_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
        )
      )
    )
  );

  // Primary Color Setting
  $wp_customize->add_section(
    'muzicband_primary_color_section',
    array(
       'priority'              => 75,
       'title'                 => esc_html__( 'Primary Color', 'muzicband' ),
       'panel'                 => 'muzicband_design_options'
    )
  );

  $wp_customize->add_setting(
    'muzicband_primary_color',
    array(
       'default'              => '#ff4a1c',
       'capability'           => 'edit_theme_options',
       'sanitize_callback'    => 'muzicband_hex_color_sanitize',
       'sanitize_js_callback' => 'muzicband_color_escaping_sanitize'
    )
  );

  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'muzicband_primary_color',
        array(
          'label'              => esc_html__( 'This will reflect in links, buttons and many others. Choose a color to match your site', 'muzicband' ),
          'section'            => 'muzicband_primary_color_section'
        )
    )
  );

  // Custom CSS Box
  $wp_customize->add_section(
    'muzicband_custom_css_setting', 
    array(
       'priority'              => 90,
       'title'                 => esc_html__('Custom CSS', 'muzicband'),
       'panel'                 => 'muzicband_design_options'
    )
  );

  $wp_customize->add_setting(
    'muzicband_custom_css', 
    array(
       'default'               => '',
       'capability'            => 'edit_theme_options',
       'sanitize_callback'     => 'wp_filter_nohtml_kses',
       'sanitize_js_callback'  => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'muzicband_custom_css', 
    array(
       'label'                 => esc_html__('Write your custom css', 'muzicband'),
       'section'               => 'muzicband_custom_css_setting',
       'settings'              => 'muzicband_custom_css',
       'priority'              => 10,
       'type'                  => 'textarea'
    )
  );

  // Slider Section
  $wp_customize->add_section(
    'muzicband_header_slider',
    array(
      'priority'              => 105,
       'title'                 => esc_html__('Slider', 'muzicband'),
       'description' => '<strong>'.esc_html__( 'Note', 'muzicband').'</strong><br/>'.esc_html__( '1. To display the Slider first check Enable the slider below. Now create the page for each slider and enter title, text and featured image. Choose that pages in the dropdown options.', 'muzicband').'<br/>'.esc_html__( '2. The recommended size for the slider image is 1920 x 790 pixels. For better functioning of slider use equal size images for each slide.', 'muzicband' ).'<br/>'.esc_html__( '3. If page do not have featured Image than that page will not included in slider show.', 'muzicband' ),
       'panel'                 => 'muzicband_design_options'
    )
  );

  // Slider Activation Setting
  $wp_customize->add_setting(
    'muzicband_slider_activation',
    array(
      'default'            => '',
      'capability'         => 'edit_theme_options',
      'sanitize_callback'  => 'muzicband_sanitize_checkbox'
    )
  );

  $wp_customize->add_control(
    'muzicband_slider_activation',
    array(
      'label'    => esc_html__( 'Enable Slider' , 'muzicband' ),
      'section'  => 'muzicband_header_slider',
      'type'     => 'checkbox',
      'priority' => 10
    )
  );

  // Slider Images Selection Setting
  for( $i = 1; $i <= 4; $i++ ) {
    $wp_customize->add_setting(
      'muzicband_slide'.$i,
      array(
        'default'            => '',
        'capability'         => 'edit_theme_options',
        'sanitize_callback'  => 'muzicband_sanitize_integer'
      )
    );

    $wp_customize->add_control(
      'muzicband_slide'.$i,
      array(
        'label'    => esc_html__( 'Slide ' , 'muzicband' ).$i,
        'section'  => 'muzicband_header_slider',
        'type'     => 'dropdown-pages',
        'priority' =>  $i+10
      )
    );
  }

  // Extra Setting
  $wp_customize->add_section(
    'muzicband_extra_setting', 
    array(
       'priority'              => 120,
       'title'                 => esc_html__('Extra', 'muzicband'),
       'panel'                 => 'muzicband_design_options'
    )
  );

  $wp_customize->add_setting(
    'muzicband_post_meta_hide', 
    array(
      'default'               => '',
      'capability'            => 'edit_theme_options',
      'sanitize_callback'     => 'wp_filter_nohtml_kses'
    )
  );

  $wp_customize->add_control(
    'muzicband_custom_css', 
    array(
      'label'                 => esc_html__('Check to hide post date', 'muzicband'),
      'section'               => 'muzicband_extra_setting',
      'settings'              => 'muzicband_post_meta_hide',
      'priority'              => 10,
      'type'                  => 'checkbox'
    )
  );


  // sanitization of links
  function muzicband_sanitize_links() {
    return false;
  }
  // checkbox sanitize
  function muzicband_sanitize_checkbox($input) {
    if ( $input == 1 ) {
      return 1;
    } else {
      return '';
    }
  }
  // Sanitize Integer
  function muzicband_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
      return intval( $input );
    }
  }
 	// radio sanitization
 	function muzicband_sanitize_radio( $input, $setting ) {
  	// Ensuring that the input is a slug.
  	$input = sanitize_key( $input );
  	// Get the list of choices from the control associated with the setting.
  	$choices = $setting->manager->get_control( $setting->id )->choices;
  	// If the input is a valid key, return it, else, return the default.
  	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
 	}
  // Sanitize Color
  function muzicband_hex_color_sanitize( $color ) {
    return sanitize_hex_color( $color );
  }
  // Escape Color
  function muzicband_color_escaping_sanitize( $input ) {
    $input = esc_attr($input);
    return $input;
  }




}
add_action( 'customize_register', 'muzicband_customize_register' );
