<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render message output 
 * @since 0.0.1
 * @param array $field_details
 * @return void
 */
function fieldpress_render_message( $field_details ) {
	echo fieldpress_sanitize_allowed_html( $field_details['message'] );
}