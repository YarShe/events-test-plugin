<?php

namespace App\views;

class Pages {
	public function __construct() {
		add_filter( 'template_include', array( $this, 'load_event_templates' ), 10, 1 );
	}

	public function load_event_templates( $template ) {
		global $wp_query;
		if ( $wp_query->is_singular( 'event' ) ) {
			return TESTPLUGIN_VIEWS . '/templates/single-event.php'; // Use your single event template
		} elseif ( is_archive( 'events' ) ) {
			return TESTPLUGIN_VIEWS . '/templates/archive-events.php'; // Use your archive event template
		}

		return $template;
	}
}