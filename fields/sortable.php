<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the sortable output 
 * @since 0.0.1
 * @param array $field_details
 * @param array $field_value
 * @return void
 */
function fieldpress_render_sortable( $field_details, $field_value ) {
	/*defaults attributes*/
	$default_attr = apply_filters( 'fieldpress_sortable_field_default_args',array(
		'type'          => 'hidden',
		'id'            => '',
		'class'         => '',
		'style'         => '',
	) );
	$field_attr = $field_details['attr'];
	$attributes = wp_parse_args( $field_attr, $default_attr );

	$choices = ( isset( $field_details['choices'] ) ? $field_details['choices'] : '' );

	$field_value    = ( ! empty( $field_value ) ) ? $field_value : $choices;
	$field_value    = ( ! empty( $field_value ) ) ? $field_value : $choices;
	$active         = ( ! empty( $field_value['active'] ) ) ? $field_value['active'] : array();
	$inactive       = ( ! empty( $field_value['inactive'] ) ) ? $field_value['inactive'] : array();
	$active_title   = ( isset( $field_details['active_title'] ) ) ? $field_details['active_title'] : esc_html__( 'Active Fields', 'fieldpress' );
	$inactive_title = ( isset( $field_details['inactive_title'] ) ) ? $field_details['inactive_title'] : esc_html__( 'Inactive Fields', 'fieldpress' );

	$fixed_name = $attributes['name'];

	$output     = '<div class="fieldpress-sortable-wrap">';
	$output    .= '<h3>'. esc_html( $active_title ) .'</h3>';
	$output    .= '<ul class="active-sortable">';
	if( ! empty( $active ) ) {
		foreach ( $active as $active_id => $active_label ) {
			$attributes['name'] = $fixed_name.'[active]'.'['.esc_attr( $active_id ).']';
			$attributes['value'] = $active_id;
			$output .= '<li>';
			$output .= '<label>';
			$output .= '<input ';

			foreach ( $attributes as $name => $value ) {
				$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
			}
			if( is_array( $field_value ) ){
				$output .= checked( in_array( $active_id, $field_value ), true, false );
			}
			$output .= '>';
			$output .= ( isset( $active_label ) ?  esc_html( $active_label ) : '' );
			$output .= '</label>';
			$output .= '</li>';
		}
	}
	$output    .= '</ul>';
	$output    .= '</div>';

	$output    .= '<div class="fieldpress-sortable-wrap">';
	$output    .= '<h3>'. esc_html( $inactive_title ) .'</h3>';
	$output    .= '<ul class="inactive-sortable">';
	if( ! empty( $inactive ) ) {
		foreach ( $inactive as $inactive_id => $inactive_label ) {
			$attributes['name'] = $fixed_name.'[inactive]'.'['.esc_attr( $inactive_id ).']';
			$attributes['value'] = $inactive_id;
			$output .= '<li>';
			$output .= '<label>';
			$output .= '<input ';

			foreach ( $attributes as $name => $value ) {
				$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
			}
			if( is_array( $field_value ) ){
				$output .= checked( in_array( $inactive_id, $field_value ), true, false );
			}
			$output .= '>';
			$output .= ( isset( $inactive_label ) ?  esc_html( $inactive_label ) : '' );
			$output .= '</label>';
			$output .= '</li>';
		}
	}
	$output    .= '</ul>';
	$output    .= '</div>';

	echo $output;
}