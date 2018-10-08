<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * render the text output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */
function fieldpress_render_text( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_text_field_default_args',array(
		'type'          => 'text',
		'value'         => '',
		'id'            => '',
		'class'         => '',
		'placeholder'   => '',
		'size'          => 40,
		'style'         => '',
	), $field_details, $field_value );

	$field_attr = $field_details['attr'];

	$field_attr['type'] = $field_details['type']; /*not working for url and email*/

	$attributes = wp_parse_args( $field_attr, $default_attr );

	/*filter the classes*/
	$class = isset($attributes['class'])?$attributes['class']:'';
	$attributes['class'] = fieldpress_get_single_field_class( $field_details, $field_value, $class );

	$attributes['value'] = $field_value;

	$output = '<input ';
	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	echo $output;
}