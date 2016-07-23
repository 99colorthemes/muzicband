<?php
/**
 * Events List Widget Template
 * This is the template for the output of the events list widget.
 * All the items are turned on and off through the widget admin.
 * There is currently no default styling, which is needed.
 *
 * This view contains the filters required to create an effective events list widget view.
 *
 * This overrides the default view of The Events Calendar plugin.
 *
 * @return string
 *
 * @package TribeEventsCalendar
 * @subpackage MuzicBand
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>
<?php
$events_label_plural = tribe_get_event_label_plural();

$posts = apply_filters( 'nnc_tribe_get_list_widget_events', NNC_Tribe__Events__List_Widget::$posts );

// Check if any event posts are found.
if ( $posts ) : $item_count = 0; ?>
	
	<div class="nnc-event">
		<?php
		// Setup the post data for each event.
		foreach ( $posts as $post ) :
			setup_postdata( $post );
			$item_wrapper_class = '';
			if ( $item_count % 4 == 0 ) {
				$item_wrapper_class = 'nnc-event-single-big'; 
			} else {
				$item_wrapper_class = 'nnc-event-single-big single-small';
			}
			?>
			<div class="<?php echo esc_attr( $item_wrapper_class ); ?>">
					<div class="nnc-flipper">
						<figure class="nnc-event-img">
							<?php echo tribe_event_featured_image( null, 'muzicband-event-image' ); ?>
						</figure>
						<span><?php echo tg_events_event_schedule_details();?></span>
						<div class="nnc-event-dtl">
							<div class="inner">
								<div class="outer">
								<?php do_action( 'tribe_events_list_widget_before_the_event_title' ); ?>
									<!-- Event Title -->
									<h4 class="entry-title upcoming-events-title summary">
										<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" rel="bookmark"><?php the_title(); ?></a>
									</h4>
								<?php do_action( 'tribe_events_list_widget_after_the_event_title' ); ?>
									<time><?php echo tg_events_event_schedule_details();?></time>
									<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" rel="bookmark"><?php esc_html_e( 'View Detail', 'muzicband' ) ?> </a>
								</div>
							</div>
						</div>
					</div> 
				</div>
		<?php $item_count++;
		endforeach;
		?>
	</div>

<?php
// No events were found.
else : ?>
	<p class="no-event"><?php printf( esc_html__( 'There are no upcoming %s at this time.', 'muzicband' ), strtolower( $events_label_plural ) ); ?></p>
<?php
endif;
?>
