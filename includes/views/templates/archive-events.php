<?php
/**
 * Template Name: Event Archive
 */
?>

<?php get_header(); ?>


<?php if ( have_posts() ) : ?>
    <div class="events-wrapper">
        <div class="page-events-title">
            <h1> Events</h1>
        </div>
        <button id="toggle-layout">Toggle Layout</button>
        <div class="event-list" id="events-container">
		    <?php while ( have_posts() ) : the_post(); ?>
                <div class="event-card">
                    <a href="<?php the_permalink(); ?>">
					    <?php if ( get_post_meta( get_the_ID(), 'banner_horizontal', true ) ) : ?>
						    <?php
						    $banner_id = get_post_meta( get_the_ID(), 'banner_horizontal', true );
						    $banner_url = wp_get_attachment_url( $banner_id ); // Get URL from ID
						    if ( $banner_url ) : ?>

                                    <img class="event-img" src="<?php echo esc_url( $banner_url ); ?>" alt="<?php the_title(); ?>">

						    <?php else: ?>
                                <img src="placeholder-image.jpg" alt="Event Placeholder">
						    <?php endif; ?>
					    <?php else: ?>
                            <img src="placeholder-image.jpg" alt="Event Placeholder">
					    <?php endif; ?>
                    </a>
                    <div class="event-content">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p class="event-date-time">
                            <span><?php echo get_the_date(); ?></span>
                        </p>
                        <p><?php echo wp_trim_words( get_the_content(), 30 ); ?></p>

                     <div class="event-footer">
                         <a href="<?php the_permalink(); ?>" class="event-read-more-btn">
		                     <?php esc_html_e( 'Read More', 'test-plugin' ); ?>
                         </a>
                     </div>

                    </div>
                </div>
		    <?php endwhile; ?>
        </div>
	    <?php else : ?>
            <p>No upcoming events found.</p>
	    <?php endif ?>
    </div>



<?php get_footer(); ?>
