<?php
/**
 * Event List Widget
 *
 * Creates a widget that displays the next upcoming x events
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

add_action( 'widgets_init', 'muzicband_event_widget_init' );

function muzicband_event_widget_init() {
	register_widget( 'NNC_Tribe__Events__List_Widget' );
}

class NNC_Tribe__Events__List_Widget extends Tribe__Events__List_Widget {

	private static $limit = 5;
	public static $posts = array();

	/**
	 * Allows widgets extending this one to pass through their own unique name, ID base etc.
	 *
	 * @param string $id_base
	 * @param string $name
	 * @param array  $widget_options
	 * @param array  $control_options
	 */
	public function __construct(
		$id_base = 'nnc-tribe-events-list-widget',
		$name = 'NNC: Events Slider',
		$widget_options  =  array(
								'classname' => 'upcoming-events-section',
								'description' => 'A Slider Widget that displays events from The Event Calendar Plugin'
							),
		$control_options = array( 'id_base' => 'nnc-tribe-events-list-widget' )
		){

		parent::__construct( $id_base, $name, $widget_options, $control_options );
	}

	/**
	 * The main widget output function (called by the class's widget() function).
	 *
	 * @param array  $args
	 * @param array  $instance
	 * @param string $template_name The template name.
	 * @param string $subfolder     The subfolder where the template can be found.
	 * @param string $namespace     The namespace for the widget template stuff.
	 * @param string $pluginPath    The pluginpath so we can locate the template stuff.
	 */
	public function widget_output( $args, $instance, $template_name = 'widgets/nnc-list-widget' ) {
		global $wp_query, $tribe_ecp, $post;

		$instance = wp_parse_args(
			$instance, array(
				'limit' => self::$limit,
				'title' => '',
			)
		);

		/**
		 * @var $after_title
		 * @var $after_widget
		 * @var $before_title
		 * @var $before_widget
		 * @var $limit
		 * @var $no_upcoming_events
		 * @var $title
		 */
		extract( $args, EXTR_SKIP );
		extract( $instance, EXTR_SKIP );

		// Temporarily unset the tribe bar params so they don't apply
		$hold_tribe_bar_args = array();
		foreach ( $_REQUEST as $key => $value ) {
			if ( $value && strpos( $key, 'tribe-bar-' ) === 0 ) {
				$hold_tribe_bar_args[ $key ] = $value;
				unset( $_REQUEST[ $key ] );
			}
		}

		$title = apply_filters( 'widget_title', $title );
		$text = apply_filters( 'widget_text', empty( $instance[ 'text' ] ) ? '' : $instance['text'], $instance );

		self::$limit = absint( $limit );

		if ( ! function_exists( 'tribe_get_events' ) ) {
			return;
		}

		self::$posts = tribe_get_events(
			apply_filters(
				'tribe_events_list_widget_query_args', array(
					'eventDisplay'   => 'list',
					'posts_per_page' => self::$limit,
					'tribe_render_context' => 'widget',
				)
			)
		);

		// If no posts, and the don't show if no posts checked, let's bail
		if ( empty( self::$posts ) && $no_upcoming_events ) {
			return;
		}

		echo $before_widget;
		do_action( 'tribe_events_before_list_widget' ); ?>

		<!-- upcomming-events-start -->
		<div class="nnc-events">
			<div class="nnc-container">
				<div class="nnc-title">
					<?php if ( $title ){
						do_action( 'tribe_events_list_widget_before_the_title' );
						echo '<h2>' . esc_html( $title ) . '</h2>' ;
						do_action( 'tribe_events_list_widget_after_the_title' );
					}
					if( !empty( $text ) ) { ?>
						<p><?php echo esc_textarea( $text ); ?></p>
					<?php } ?>
				</div>

				<?php
				// Include template 
				include Tribe__Events__Templates::getTemplateHierarchy( $template_name ); ?>
			</div>
		</div>
		<!-- upcomming-events-end -->

		<?php do_action( 'tribe_events_after_list_widget' );
		
		echo $after_widget;
		wp_reset_query();

		// Reinstate the tribe bar params
		if ( ! empty( $hold_tribe_bar_args ) ) {
			foreach ( $hold_tribe_bar_args as $key => $value ) {
				$_REQUEST[ $key ] = $value;
			}
		}
	}

	/**
	 * The function for saving widget updates in the admin section.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array The new widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title']              = strip_tags( $new_instance['title'] );
		if ( current_user_can('unfiltered_html') ) {
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		}
		else {
			$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); // wp_filter_post_kses() expects slashed
		}
		$instance['limit']              = $new_instance['limit'];
		$instance['no_upcoming_events'] = $new_instance['no_upcoming_events'];

		return $instance;
	}

	/**
	 * Output the admin form for the widget.
	 *
	 * @param array $instance
	 *
	 * @return string The output for the admin widget form.
	 */
	public function form( $instance ) {
		/* Set up default widget settings. */
		$defaults  = array(
			'title'              => esc_html__( 'Upcoming Events', 'muzicband' ),
			'text' => '',
			'limit'              => '5',
			'no_upcoming_events' => false,
		);
		$instance  = wp_parse_args( (array) $instance, $defaults );
		$text = esc_textarea( $instance['text'] );
		$tribe_ecp = Tribe__Events__Main::instance();
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'muzicband' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<?php _e( 'Description:','muzicband' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Show:', 'muzicband' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" class="widefat">
				<?php for ( $i = 1; $i <= 10; $i ++ ) {
					?>
					<option <?php if ( $i == $instance['limit'] ) {
						echo 'selected="selected"';
					} ?> > <?php echo $i; ?> </option>
				<?php } ?>
			</select>
		</p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'no_upcoming_events' ) ); ?>"><?php esc_html_e( 'Show widget only if there are upcoming events:', 'muzicband' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'no_upcoming_events' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_upcoming_events' ) ); ?>" type="checkbox" <?php checked( $instance['no_upcoming_events'], 1 ); ?> value="1" />
		<p>

		</p>
	<?php }
}
