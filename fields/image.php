<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * render image output
 * @since 0.0.1 
 * @param array $field_details
 * @param int $field_value
 * @return void
 */
function fieldpress_render_image( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_image_field_default_args',array(
		'type'          => 'text',
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
	$attributes['type'] = 'hidden';

	/*filter the classes*/
	$class = isset($attributes['class'])?$attributes['class']:'';
	$attributes['class'] = fieldpress_get_single_field_class( $field_details, $field_value, $class );

	$preview = '';
	$upload_title     = ( ! empty( $field_details['upload_title'] ) ) ? $field_details['upload_title'] : __( 'Select Image', 'fieldpress' );
	$button_text     = ( ! empty( $field_details['button_text'] ) ) ? $field_details['button_text'] : __( 'Select Image', 'fieldpress' );
	$hidden  = ( empty( $field_value ) ) ? ' hidden' : '';

	if( ! empty( $field_value ) ) {
		$attachment = wp_get_attachment_image_src( $field_value, 'thumbnail' );
		$preview    = $attachment[0];
	}

	$output = "<div class='fieldpress-image-preview". esc_attr( $hidden ) ."'><div class='fieldpress-image-wrap'><i class='dashicons dashicons-no fieldpress-clear'></i><a data-button-text='".esc_attr( $button_text )."' data-title='".esc_attr( $upload_title )."' href='#' class='fieldpress-image-uploader-open'><img src='". esc_url( $preview ) ."' /></a></div></div>";
	$output .= "<a href='#' class='button button-primary fieldpress-image-uploader-open' data-button-text='".esc_attr( $button_text )."' data-title='".esc_attr( $upload_title )."'>". esc_html( $upload_title ) ."</a>";

	$output .= '<input ';

	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	echo $output;
}