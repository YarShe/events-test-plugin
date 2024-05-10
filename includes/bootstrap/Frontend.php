<?php

namespace App\bootstrap;



use App\models\EventsGetter;

/**
 * Frontend Pages Handler
 */
class Frontend {
	use EventsGetter;
	public function __construct() {
		$this->init_hooks();
		add_shortcode( 'event-sc', [ $this, 'render_frontend' ] );

	}
	/**
	 * Render frontend app
	 *
	 * @param  array $atts
	 * @param  string $content
	 *
	 * @return string
	 */

	public function render_frontend($atts)
	{
		$atts = shortcode_atts( array(
			'id' => '',  // Default empty id
			'orientation' => 'vertical',  // Default orientation: vertical
		), $atts );

		$class = 'sc-event-card';  // Base class

		if ( $atts['orientation'] === 'vertical' ) {
			$class .= ' event-card-vertical';  // Add class for vertical layout
		} else {
			$class .= ' event-card-horizontal';  // Add class for horizontal layout
		}

		// Include the template file
		$event_obj = $this->get_event( $atts['id'] );

		if ($event_obj) {
			$template_data = $this->get_event_data($event_obj, $atts['orientation']);
		} else {
			// Handle case where no event is found or the post type is not "event"
			$content = 'Event not found or not of type "event".';
		}






		ob_start();
		include( TESTPLUGIN_VIEWS . '/templates/event_shortcode.php' );
		$content = ob_get_clean();

		$output = '<div class="' . esc_attr( $class ) . '">' . $content . '</div>';

		return $output;
	}

	public function init_hooks() {
		wp_enqueue_style( 'testplugin-style' );
		wp_enqueue_script( 'testplugin-frontend' );
	}





}

