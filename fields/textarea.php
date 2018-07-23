<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the textarea output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */
function fieldpress_render_textarea( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_textarea_field_default_args',array(
		'id'            => '',
		'class'         => '',
		'placeholder'   => '',
		'cols'          => 50,
		'rows'          => 8,
		'style'         => ''
	) );
	$field_attr = $field_details['attr'];
	$attributes = wp_parse_args( $field_attr, $default_attr );

	$output = '<textarea ';
	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	$output .= esc_textarea( $field_value );
	$output .= '</textarea>';
	echo $output;
}