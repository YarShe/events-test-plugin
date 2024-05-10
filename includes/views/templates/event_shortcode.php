<?php if ( !empty( $template_data ) ) : ?>
    <div class="event-banner-sc">
        <div class="banner-image" style="background-image: url('<?php echo esc_url( $template_data['banner_url'] ); ?>');">
			<?php if ( empty( $template_data['banner_url'] ) ) : ?>
                <div class="banner-placeholder">
                    <span><?php _e( 'Banner Image', 'test-plugin' ); ?></span>
                </div>
			<?php endif; ?>
        </div>
        <div class="banner-content-sc">
            <h2><?php echo esc_html( $template_data['title'] ); ?></h2>
            <div class="banner-event-details">
                <p>
                    <span class="banner-event-date"><?php echo esc_html( $template_data['date'] ); ?></span>
                    <span class="banner-event-time"><?php echo esc_html( $template_data['time'] ); ?></span>
                </p>
                <p><?php echo wp_kses_post( $template_data['place'] ); ?></p>
                <a target="_blank" href="<?php echo esc_html( $template_data['link'] ); ?>" class="banner-event-link"><?php _e( 'Learn More', 'test-plugin' ); ?></a>
            </div>
        </div>
    </div>
<?php endif; ?>