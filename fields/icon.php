<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render icon output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */

function fieldpress_render_icon( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_icon_field_default_args',array(
		'type'          => 'hidden',
		'value'         => '',
		'id'            => '',
		'class'         => '',
		'placeholder'   => '',
		'size'          => 40,
		'style'         => '',
	), $field_details, $field_value );

	$field_attr = $field_details['attr'];

	$attributes = apply_filters('fieldpress_field_attributes', wp_parse_args( $field_attr, $default_attr ), $field_details, $field_value );

	$attributes['value'] = $field_value;

	/*filter the classes*/
	$class = isset($attributes['class'])?$attributes['class']:'';
	$attributes['class'] = fieldpress_get_single_field_class( $field_details, $field_value, $class );

	$upload_title     = ( ! empty( $field_details['upload_title'] ) ) ? $field_details['upload_title'] : __( 'Select Icon', 'fieldpress' );
	$hidden  = ( empty( $field_value ) ) ? ' hidden' : '';

	$output = "<div class='fieldpress-icon-preview". esc_attr( $hidden ) ."'><div class='fieldpress-icon-wrap'><i class='dashicons dashicons-no fieldpress-icon-clear'></i><a href='#' class='fieldpress-icon-selector-open'><i class='". esc_attr( $field_value ) ."' /></i></a></div></div>";
	$output .= "<a href='#' class='button button-primary fieldpress-icon-selector-open' data-title='".esc_attr( $upload_title )."'>". esc_html( $upload_title ) ."</a>";

	$output .= '<input ';

	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	echo $output;
}