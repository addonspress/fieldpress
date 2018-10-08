<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the switcher output 
 * @since 0.0.1
 * @param array $field_details
 * @param mixed $field_value
 * @return void
 */
function fieldpress_render_switcher( $field_details, $field_value ) {

	/*defaults attributes*/
	$default_attr = apply_filters( 'fieldpress_switcher_field_default_args',array(
		'type'          => 'checkbox',
		'id'            => '',
		'class'         => '',
		'style'         => '',
	), $field_details, $field_value );

	$field_attr = $field_details['attr'];
	$attributes = wp_parse_args( $field_attr, $default_attr );
	$attributes['type'] = 'checkbox'; /*force any type to checkbox*/

	/*filter the classes*/
	$class = isset($attributes['class'])?$attributes['class']:'';
	$attributes['class'] = fieldpress_get_single_field_class( $field_details, $field_value, $class );

	$choices = ( isset( $field_details['choices'] ) ? $field_details['choices'] : '' );
	$query_args = ( isset( $field_details['query_args'] ) ? $field_details['query_args'] : array() );
	$output = '<ul>';
	if ( !empty( $choices ) ){
		$choices  = ( is_array( $choices ) ) ? $choices : fieldpress_get_choices( $choices, $query_args );
		if( isset( $attributes['name'])){
			$attributes['name'] = $attributes['name'].'[]';
		}
		if( isset( $attributes['fieldpress-filed-name'])){
			$attributes['fieldpress-filed-name'] = $attributes['fieldpress-filed-name'].'[]';
		}
		foreach ( $choices as $choice_value => $choice ) {
			$attributes['value'] = $choice_value;
			$output .= '<li>';
			$output .= '<label>';
			$output .= '<input ';
			foreach ( $attributes as $name => $value ) {
				$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
			}
			if( is_array( $field_value )){
				$output .= checked( in_array( $choice_value, $field_value ), true, false );
			}
			$output .= '>';
			
			$output .= '<span></span>';
			$output .= '</label>';
			$output .= ( isset( $choice ) ?  '<p class="switcher-label">'.esc_html( $choice ).'</p>' : '' );
			$output .= '</li>';
		}
	}
	else{
		$output .= '<li>';
		$output .= '<label>';
		$output .= '<input ';
		foreach ($attributes as $name => $value) {
			$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
		}
		$output .= checked( $field_value, true, false) ;
		$output .= '>';
		
		$output .= '<span></span>';
		$output .= '</label>';
		$output .= ( isset( $field_details['switcher-label'] ) ?  '<p class="switcher-label">'.esc_html( $field_details['switcher-label'] ).'</p>' : '' );
		$output .= '</li>';
	}
	$output .= '</ul>';
	echo $output;
}