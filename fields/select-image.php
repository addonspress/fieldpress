<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the select image output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */
function fieldpress_render_select_image( $field_details, $field_value ) {
	/*defaults attributes*/
	$default_attr = apply_filters( 'fieldpress_select_image_field_default_args',array(
		'type'          => 'radio',
		'id'            => '',
		'class'         => '',
		'style'         => '',
	) );
	$field_attr = $field_details['attr'];
	$attributes = wp_parse_args( $field_attr, $default_attr );

	$choices = ( isset( $field_details['choices'] ) ? $field_details['choices'] : '' );

	$output = '<ul>';
	if ( !empty( $choices ) && is_array( $choices ) ){
		if( isset($attributes['multiple']) && 'multiple' == $attributes['multiple'] ){
			if( isset( $attributes['name'])){
				$attributes['name'] = $attributes['name'].'[]';
			}
			$attributes['type'] = 'checkbox'; /*force any type to checkbox*/
		}
		foreach ( $choices as $choice_value => $choice ) {
			$attributes['value'] = $choice_value;
			$output .= '<li>';
			$output .= '<label>';
			$output .= '<input ';

			foreach ( $attributes as $name => $value ) {
				$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
			}
			if( is_array( $field_value ) ){
				$output .= checked( in_array( $choice_value, $field_value ), true, false );
			}
			else{
				$output .= checked( $field_value, $choice_value, false) ;
			}
			$output .= '>';
			$output .= ( isset( $choice ) ?  '<img src="'. esc_url( $choice ) .'" alt="'. $choice_value .'" />' : '' );
			$output .= '</label>';
			$output .= '</li>';
		}
	}
	$output .= '</ul>';
	echo $output;
}