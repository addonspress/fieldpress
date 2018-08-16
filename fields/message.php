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

	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_message_field_default_args',array(
		'id'            => '',
		'class'         => '',
		'style'         => '',
	), $field_details );

	$field_attr = $field_details['attr'];

	$field_attr['type'] = $field_details['type'];

	$attributes = wp_parse_args( $field_attr, $default_attr );

	/*filter the classes*/
	$class = isset( $attributes['class'] ) ? $attributes['class'] : '';
	$attributes['class'] = fieldpress_get_single_field_class( $field_details, '', $class );

	$output = '<div ';
	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	$output .= fieldpress_sanitize_allowed_html( $field_details['message'] );
	$output .= "</div>";
	echo $output;
}