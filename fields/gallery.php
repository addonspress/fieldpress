<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render gallery output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */

function fieldpress_render_gallery( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_gallery_field_default_args',array(
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
	$attributes['type'] = 'hidden';

	$upload_title     = ( ! empty( $field_details['upload_title'] ) ) ? $field_details['upload_title'] : __( 'Add Gallery', 'fieldpress' );
	$edit_title   = ( ! empty( $field_details['edit_title'] ) ) ? $field_details['edit_title'] : __( 'Edit Gallery', 'fieldpress' );
	$button_text     = ( ! empty( $field_details['button_text'] ) ) ? $field_details['button_text'] : __( 'Add Gallery', 'fieldpress' );
	$remove_title  = ( ! empty( $field_details['remove_title'] ) ) ? $field_details['remove_title'] : __( 'Remove', 'fieldpress' );

	$hidden_edit  = ( empty( $field_value ) ) ? ' hidden' : '';
	$hidden_add  = ( !empty( $field_value ) ) ? ' hidden' : '';

	$output = '<ul class="fieldpress-gallery-preview">';

	if( ! empty( $field_value ) ) {

		$values = explode( ',', $field_value );

		foreach ( $values as $id ) {
			$attachment = wp_get_attachment_image_src( $id, 'thumbnail' );
			$output .= '<li><img src="'. esc_url( $attachment[0] ) .'" /></li>';
		}
	}

	$output .=  '</ul>';

	$output .= "<a href='#' class='button button-primary fieldpress-gallery-uploader-open ". esc_attr( $hidden_add ) ."' data-button-text='".esc_attr( $button_text )."' data-title='".esc_attr( $upload_title )."'>". esc_html( $upload_title ) ."</a>";
	$output .=  "<a href='#' class='button button-primary fieldpress-gallery-updater-open ". esc_attr( $hidden_edit ) ."' data-button-text='".esc_attr( $button_text )."' data-title='".esc_attr( $upload_title )."'>". esc_html( $edit_title ) ."</a>";
	$output .=  "<a href='#' class='button button-secondary fieldpress-remove ". esc_attr( $hidden_edit ) ."' data-button-text='".esc_attr( $button_text )."' data-title='".esc_attr( $upload_title )."'><i class='dashicons dashicons-no'></i>". esc_html( $remove_title )."</a>";

	$output .= '<input ';

	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	echo $output;
}