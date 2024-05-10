<?php
/**
 * Template Name: Single Event
 */
?>

<?php get_header(); ?>

    <div class="event-details">
        <h1><?php the_title(); ?></h1>

            <div class="event-featured-image">
	            <?php if ( get_post_meta( get_the_ID(), 'banner_horizontal', true ) ) : ?>
		            <?php
		            $banner_id = get_post_meta( get_the_ID(), 'banner_horizontal', true );
		            $banner_url = wp_get_attachment_url( $banner_id ); // Get URL from ID
		            if ( $banner_url ) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo esc_url( $banner_url ); ?>" alt="<?php the_title(); ?>">
                        </a>
		            <?php else: ?>
                        <img src="placeholder-image.jpg" alt="Event Placeholder">
		            <?php endif; ?>
	            <?php else: ?>
                    <img src="placeholder-image.jpg" alt="Event Placeholder">
	            <?php endif; ?>
            </div>


        <div class="event-info">
            <p><strong>Date:</strong> <?php echo get_post_meta( get_the_ID(), 'event_date', true ); ?></p>
            <p><strong>Time:</strong> <?php echo get_post_meta( get_the_ID(), 'event_time', true ); ?></p>
            <p><strong>Place:</strong> <?php echo get_post_meta( get_the_ID(), 'event_place', true ); ?></p>
	        <?php
	        $event_types = get_the_terms( get_the_ID(), 'event_type' );

	        if ( ! empty( $event_types ) ) {
		        echo '<p><strong>Event Types:</strong> ';
		        $first = true;
		        foreach ( $event_types as $event_type ) {
			        if ( ! $first ) {
				        echo ', ';
			        }
			        echo '<a href="' . get_term_link( $event_type ) . '">' . $event_type->name . '</a>';
			        $first = false;
		        }
		        echo '</p>';
	        }
	        ?>
        </div>

        <div class="event-content">
			<?php the_content(); ?>
        </div>

	    <?php if ( get_post_meta( get_the_ID(), 'event_link', true ) ) : ?>
            <div class="event-link-wrapper">
                <a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'event_link', true ) ); ?>" class="event-link">
				    <?php esc_html_e( 'Visit Event Website', 'your-theme-textdomain' ); ?>
                </a>
            </div>
	    <?php endif; ?>
    </div>


<?php get_footer(); ?>