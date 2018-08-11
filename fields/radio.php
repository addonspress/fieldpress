<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the radio output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */
function fieldpress_render_radio( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_radio_field_default_args',array(
		'type'          => 'radio',
		'id'            => '',
		'class'         => '',
		'style'         => '',
	), $field_details, $field_value );

	$field_attr = $field_details['attr'];

	$attributes = apply_filters('fieldpress_field_attributes', wp_parse_args( $field_attr, $default_attr ), $field_details, $field_value );

	$attributes['type'] = 'radio';

	/*filter the classes*/
	$class = isset($attributes['class'])?$attributes['class']:'';
	$attributes['class'] = fieldpress_get_single_field_class( $field_details, $field_value, $class );

	$choices = (isset( $field_details['choices'] ) ? $field_details['choices'] : '' );
	$field_value = ( !empty( $field_value )? $field_value : '' );
	$query_args = ( isset( $field_details['query_args'] ) ? $field_details['query_args'] : array() );

	$output = '<ul>';

	if ( !empty( $choices ) ){
		$choices  = ( is_array( $choices ) ) ? $choices : fieldpress_get_choices( $choices, $query_args );
		foreach ( $choices as $choice_value => $choice ) {
			$attributes['value'] = $choice_value;
			$output .= '<li>';
			$output .= '<label>';
			$output .= '<input ';

			foreach ($attributes as $name => $value) {
				$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
			}
			$output .= checked( $field_value , $choice_value, false );
			$output .= '>';
			$output .= ( isset( $choice ) ?  esc_html( $choice ) : '' );
			$output .= '</label>';
			$output .= '</li>';
		}
	}
	$output .= '</ul>';
	echo $output;
}