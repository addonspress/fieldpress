<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render color output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */
function fieldpress_render_color( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_color_field_default_args',array(
		'type'          => 'text',
		'value'         => '',
		'id'            => '',
		'class'         => '',
		'placeholder'   => '',
		'size'          => 40,
		'style'         => '',
	) );

	$field_attr = $field_details['attr'];
	$attributes = wp_parse_args( $field_attr, $default_attr );
	$attributes['value'] = $field_value;
	$attributes['class'] = (isset($attributes['class'])?$attributes['class'].' '.'fieldpress-color-picker':'fieldpress-color-picker');
	$output = '<input ';
	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	echo $output;
}