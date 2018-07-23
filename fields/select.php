<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the select output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */
function fieldpress_render_select( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_select_field_default_args',array(
		'id'            => '',
		'class'         => '',
		'style'         => '',
	) );
	$field_attr = $field_details['attr'];
	$attributes = wp_parse_args( $field_attr, $default_attr );
	if( !isset( $field_details['normal'] ) || ( isset( $field_details['normal'] ) && $field_details['normal'] != true ) ){
		$attributes['class'] = (isset($attributes['class'])?$attributes['class'].' '.'fieldpress-select2':'fieldpress-select2');
	}

	$choices = (isset( $field_details['choices'] ) ? $field_details['choices'] : '' );
	$field_value = ( !empty( $field_value )? $field_value : '' );
	$query_args = ( isset( $field_details['query_args'] ) ? $field_details['query_args'] : array() );

	$output = '<select ';
	if( 'multiple' == $attributes['multiple'] ){
		$attributes['name'] = $attributes['name'].'[]';
	}
	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	if ( !empty( $choices ) ){
		$choices  = ( is_array( $choices ) ) ? $choices : fieldpress_get_choices( $choices, $query_args );
		$attributes['name'] = $attributes['name'].'[]';
		foreach ( $choices as $choice_value => $choice ) {
			if( 'multiple' == $attributes['multiple'] ){
				$output .= "<option value='".esc_attr( $choice_value )."' " . selected( (is_array( $field_value) ? in_array( $choice_value, $field_value ):false), true, false ) . ">".esc_html( $choice )."</option>";
			}
			else{
				$output .= "<option value='".esc_attr( $choice_value )."' " . selected( $choice_value, $field_value, false ) . ">".esc_html( $choice )."</option>";
			}
		}
	}
	$output .= '</select>';
	echo $output;
}