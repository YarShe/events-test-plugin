<?php
namespace App\models;

trait EventsGetter {

	public function get_events( $args = array() ) {
		$defaults = array(
			'post_type' => 'event',
			'posts_per_page' => -1, // Show all events by default
		);

		$args = wp_parse_args( $args, $defaults );

		$events = new WP_Query( $args );

		return $events;
	}

	public function get_event( $event_id ) {
		$event = get_post( $event_id ); // Retrieve single post by ID

		if ( $event && $event->post_type === 'event' ) {
			return $event;
		} else {
			return null; // Return null if not an event post
		}
	}

	public function get_event_data($event , $orientation = 'vertical'){

		$data = array(
			"title" => $event->post_title,
			"content" => $event->post_content,
			"taxonomy_list" => "",
		);

		// Get taxonomy list
		$taxonomies = get_the_taxonomies( $event );
		if ( $taxonomies ) {
			$taxonomy_list = array();
			foreach ( $taxonomies as $taxonomy ) {
				$terms = get_the_terms( $event->ID, $taxonomy );
				if ( $terms ) {
					foreach ( $terms as $term ) {
						$taxonomy_list[] = $term->name;
					}
				}
			}
			$data["taxonomy_list"] = implode( ', ', $taxonomy_list );
		}

		$custom_fields = get_post_custom( $event->ID );

		$data["banner_url"] = "";

		if ( $orientation === "vertical"  ) {
			$data["banner_url"] = wp_get_attachment_url($custom_fields['banner_vertical'][0]);
		} elseif ( $orientation === "horizontal" && isset( $custom_fields['banner_horizontal'][0] ) ) {
			$data["banner_url"] = wp_get_attachment_url( $custom_fields['banner_horizontal'][0]);
		}
		$date_format = get_option( 'date_format' );
		$event_date = strtotime( $custom_fields['event_date'][0] );
		$date = date_i18n( $date_format, $event_date );
		$data["date"] = isset( $custom_fields['event_date'][0] ) ? $date : "";
		$data["time"] = isset( $custom_fields['event_time'][0] ) ? $custom_fields['event_time'][0] : "";
		$data["place"] = isset( $custom_fields['event_place'][0] ) ? $custom_fields['event_place'][0] : "";
		$data["link"] = isset( $custom_fields['event_link'][0] ) ? $custom_fields['event_link'][0] : "";
		return $data;
	}
}