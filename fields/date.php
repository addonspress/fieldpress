<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render date output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */
function fieldpress_render_date( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_date_field_default_args',array(
		'type'          => 'text',
		'value'         => '',
		'id'            => '',
		'class'         => '',
		'placeholder'   => '',
		'size'          => 40,
		'style'         => '',
	), $field_details, $field_value );

	$field_attr = $field_details['attr'];

	/*Check for time*/
	if( isset( $field_details['time'] ) ){
		$field_attr['data-fieldpress-time'] = true;
		$time_options = $field_details['time'];
		if( isset( $time_options['time-only'] ) && $time_options['time-only'] == true){
			$field_attr['data-time-only'] = true;
		}
		$field_attr['data-time-format'] = ( ( isset($time_options['time-format']  ) && !empty( $time_options['time-format'] ) )?$time_options['time-format']:'HH:mm:ss');
	}
	$field_attr['data-date-format'] = ( isset( $field_attr['date-format'] ) ? $field_attr['date-format'] : 'M d, yy');

	$attributes = apply_filters('fieldpress_field_attributes', wp_parse_args( $field_attr, $default_attr ), $field_details, $field_value );

	$attributes['value'] = $field_value;

	/*filter the classes*/
	$class = isset($attributes['class'])?$attributes['class'].' '.'fieldpress-date-picker':'fieldpress-date-picker';
	$attributes['class'] = fieldpress_get_single_field_class( $field_details, $field_value, $class );

	$output = '<input ';

	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	echo $output;
}