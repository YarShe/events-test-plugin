<?php

namespace App\models;

class Events {

	public function __construct() {

		$this->register_event_components();
	}

	public function register_event_components() {
		$this->create_event_post_type();
		$this->create_event_type_taxonomy();
		$this->add_custom_fields();
	}

	public function create_event_post_type() {
		$labels = array(
			'name'                  => __( 'Events' ),
			'singular_name'         => __( 'Event' ),
			'menu_name'             => __( 'Events' ),
			'all_items'             => __( 'All Events' ),
			'add_new'               => __( 'Add Event' ),
			'add_new_item'          => __( 'Add New Event' ),
			'edit_item'             => __( 'Edit Event' ),
			'update_item'           => __( 'Update Event' ),
			'search_items'          => __( 'Search Events' ),
			'not_found'             => __( 'No Events Found' ),
			'not_found_in_trash'    => __( 'No Events Found in Trash' ),
			'featured_image'        => __( 'Event Image' ),
			'set_featured_image'    => __( 'Set Event Image' ),
			'remove_featured_image' => __( 'Remove Event Image' ),
			'use_featured_image'    => __( 'Use as Event Image' ),
			'archives'              => __( 'Event Archives' ),
			'filter_items'          => __( 'Filter Events' ),
			'parent_item_colon'     => __( 'Parent Event:' ),
		);

		$args = array(
			'label'       => __( 'Events' ),
			'description' => __( 'Custom post type for events' ),
			'labels'      => $labels,
			'supports'    => array( 'title', 'editor', 'thumbnail' ),
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'events' ),
			'menu_icon'   => 'dashicons-calendar-alt',
			'taxonomies'  => array( 'event_type' )
		);


		register_post_type( 'event', $args );
	}

	public function create_event_type_taxonomy() {
		$labels = array(
			'name'               => __( 'Event Types' ),
			'singular_name'      => __( 'Event Type' ),
			'menu_name'          => __( 'Event Types' ),
			'all_items'          => __( 'All Event Types' ),
			'add_new'            => __( 'Add Event Type' ),
			'add_new_item'       => __( 'Add New Event Type' ),
			'edit_item'          => __( 'Edit Event Type' ),
			'update_item'        => __( 'Update Event Type' ),
			'search_items'       => __( 'Search Event Types' ),
			'parent_item_colon'  => __( 'Parent Event Type:' ),
			'parent_item'        => __( 'Parent Event Type' ),
			'not_found'          => __( 'No Event Types Found' ),
			'not_found_in_trash' => __( 'No Event Types Found in Trash' ),
			'hierarchical'       => false,
			'label'              => __( 'Event Type' ),
		);

		register_taxonomy( 'event_type', array( 'event' ), $labels );
	}

	public function add_custom_fields() {


		add_action( 'admin_menu', function () {
			add_meta_box( 'event_details', 'Event Details', function ( $post ) {
				$date_field = array(
					'label'   => __( 'Event Date' ),
					'type'    => 'date',
					'default' => '',
				);

				$link_field            = array(
					'label'   => __( 'Event Link' ),
					'type'    => 'url',
					'default' => '',
				);
				$banner_vertical_field = array(
					'label' => __( 'Banner (Vertical)' ),
					'type'  => 'media',
				);

				$banner_horizontal_field = array(
					'label' => __( 'Banner (Horizontal)' ),
					'type'  => 'media',
				);
				$time_field              = array(
					'label' => __( 'Event Time' ),
					'type'  => 'time',
				);
				$place_field             = array(
					'label' => __( 'Event Place' ),
					'type'  => 'text', // Use 'text' for a text input field
				);
				wp_nonce_field( basename( __FILE__ ), 'event_details_nonce' );
				?>
                <table class="form-table">
                    <tr>
                        <th><label for="event_date"><?php echo $date_field['label']; ?></label></th>
                        <td>
							<?php
							$event_date = get_post_meta( $post->ID, 'event_date', true );
							?>
                            <input type="<?php echo $date_field['type']; ?>" id="event_date" name="event_date"
                                   value="<?php echo esc_attr( $event_date ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="event_time"><?php echo $time_field['label']; ?></label></th>
                        <td>
                            <input type="<?php echo $time_field['type']; ?>" id="event_time" name="event_time"
                                   value="<?php echo esc_attr( get_post_meta( $post->ID, 'event_time', true ) ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="event_place"><?php echo $place_field['label']; ?></label></th>
                        <td>
                            <input type="<?php echo $place_field['type']; ?>" id="event_place" name="event_place"
                                   value="<?php echo esc_attr( get_post_meta( $post->ID, 'event_place', true ) ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="event_link"><?php echo $link_field['label']; ?></label></th>
                        <td>
							<?php
							$event_link = get_post_meta( $post->ID, 'event_link', true );
							?>
                            <input type="<?php echo $link_field['type']; ?>" id="event_link" name="event_link"
                                   value="<?php echo esc_url( $event_link ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="banner_vertical"><?php echo $banner_vertical_field['label']; ?></label></th>
                        <td>
							<?php
							$banner_vertical_id  = get_post_meta( $post->ID, 'banner_vertical', true );
							$banner_vertical_url = wp_get_attachment_url( $banner_vertical_id );
							?>
                            <p>
								<?php if ( $banner_vertical_url ) : ?>
                                    <img src="<?php echo esc_url( $banner_vertical_url ); ?>" alt="Banner Vertical"
                                         width="100"/>
                                    <br/>
								<?php endif; ?>
                                <input type="hidden" id="banner_vertical" name="banner_vertical"
                                       value="<?php echo esc_attr( $banner_vertical_id ); ?>"/>
                                <button type="button" class="button upload_image_button"
                                        data-uploader_for="banner_vertical">Upload Image
                                </button>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="banner_horizontal"><?php echo $banner_horizontal_field['label']; ?></label></th>
                        <td>
							<?php
							$banner_horizontal_id  = get_post_meta( $post->ID, 'banner_horizontal', true );
							$banner_horizontal_url = wp_get_attachment_url( $banner_horizontal_id );
							?>
                            <p>
								<?php if ( $banner_horizontal_url ) : ?>
                                    <img src="<?php echo esc_url( $banner_horizontal_url ); ?>" alt="Banner Horizontal"
                                         width="100"/>
                                    <br/>
								<?php endif; ?>
                                <input type="hidden" id="banner_horizontal" name="banner_horizontal"
                                       value="<?php echo esc_attr( $banner_horizontal_id ); ?>"/>
                                <button type="button" class="button upload_image_button"
                                        data-uploader_for="banner_horizontal">Upload Image
                                </button>
                            </p>
                        </td>
                    </tr>
                </table>
				<?php
			}, 'event', 'normal', 'high' );
		} );
		add_action( 'admin_enqueue_scripts', function () {
			wp_enqueue_media(); // Enqueue media uploader script
		} );
		// Save custom fields when the post is saved
		add_action( 'save_post', function ( $post_id ) {
			// Check if the nonce is set and valid
			if ( ! wp_verify_nonce( $_POST['event_details_nonce'], basename( __FILE__ ) ) ) {
				return;
			}

			// Check if autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// Check permissions
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			// Update event date and time
			if ( isset( $_POST['event_date'] ) ) {
				$sanitized_date = sanitize_text_field( $_POST['event_date'] );
				update_post_meta( $post_id, 'event_date', $sanitized_date );
			}

			if ( isset( $_POST['event_time'] ) ) {
				$sanitized_event_time = sanitize_text_field( $_POST['event_time'] );
				update_post_meta( $post_id, 'event_time', $sanitized_event_time );
			}

			if ( isset( $_POST['event_link'] ) ) {
				$sanitized_link = esc_url_raw( $_POST['event_link'] ); // Preserve potential existing formatting
				update_post_meta( $post_id, 'event_link', $sanitized_link );
			}

			if ( isset( $_POST['event_place'] ) ) {
				$sanitized_event_place = sanitize_text_field( $_POST['event_place'] );
				update_post_meta( $post_id, 'event_place', $sanitized_event_place );
			}

			if ( isset( $_POST['banner_vertical'] ) ) {
				$sanitized_banner_vertical_id = sanitize_text_field( $_POST['banner_vertical'] );
				update_post_meta( $post_id, 'banner_vertical', $sanitized_banner_vertical_id );
			}

			if ( isset( $_POST['banner_horizontal'] ) ) {
				$sanitized_banner_horizontal_id = sanitize_text_field( $_POST['banner_horizontal'] );
				update_post_meta( $post_id, 'banner_horizontal', $sanitized_banner_horizontal_id );
			}
		}, 10, 2 );

		add_action( 'admin_footer', function () { ?>
            <script>
                jQuery(document).ready(function ($) {
                    $('.upload_image_button').click(function () {
                        var button = $(this);
                        var uploader_for = button.data('uploader_for');
                        var previewContainer = button.parent(); // Container for preview image

                        // Open the media uploader
                        var mediaUploader = wp.media({
                            title: 'Select Image',
                            button: {
                                text: 'Choose Image'
                            },
                            multiple: false // Allow only single image selection
                        });

                        mediaUploader.on('select', function () {
                            var attachment = mediaUploader.state().get('selection').first().toJSON();
                            $('#' + uploader_for).val(attachment.id); // Update hidden field with attachment ID

                            // Update preview image
                            if (attachment.sizes && attachment.sizes.thumbnail) {
                                previewContainer.find('img').attr('src', attachment.sizes.thumbnail.url);
                            } else {
                                previewContainer.find('img').attr('src', attachment.url);
                            }
                            previewContainer.find('img').removeClass('hidden'); // Show preview image
                        });

                        mediaUploader.open();
                    });
                });
            </script>
		<?php } );
	}
}