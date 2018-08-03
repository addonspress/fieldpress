<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render file output 
 * @since 0.0.1
 * @param array $field_details
 * @param int $field_value
 * @return void
 */

function fieldpress_render_file( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_file_field_default_args',array(
		'type'          => 'hidden',
		'data-type'     => '',
		'value'         => '',
		'id'            => '',
		'class'         => '',
		'placeholder'   => '',
		'size'          => 40,
		'style'         => '',
		'data-multiple'         => true,
	) );

	$field_attr = $field_details['attr'];
	$attributes = wp_parse_args( $field_attr, $default_attr );
	$attributes['type'] = 'hidden';
	$attributes['value'] = $field_value;

	if( isset($attributes['multiple']) && 'multiple' == $attributes['multiple'] ){
		$attributes['data-multiple'] = true;
	}

	$preview = $title = $size = $url = $name = '';
	$upload_title     = ( ! empty( $field_details['upload_title'] ) ) ? $field_details['upload_title'] : __( 'Select File', 'fieldpress' );
	$button_text     = ( ! empty( $field_details['button_text'] ) ) ? $field_details['button_text'] : __( 'Select File', 'fieldpress' );
	$file_type     = ( ! empty( $field_details['file_type'] ) ) ? $field_details['file_type'] :'';
	$hidden  = ( empty( $field_value ) || !$field_value ) ? ' hidden' : '';

	$output = "<div class='fieldpress-file-preview-holder".esc_attr( $hidden )."'>";

	if( ! empty( $field_value ) ) {
		$values = explode( ',', $field_value );

		foreach ( $values as $id ) {
			$file = get_post( $id );

			if( $file ) {
				$preview = wp_mime_type_icon( $file->ID );
				$title	= $file->post_title;
				$size = size_format(filesize( get_attached_file( $file->ID ) ));
				$url = wp_get_attachment_url( $file->ID );
				$explode = explode('/', $url);
				$name = end( $explode );
				$output .= '<div class="fieldpress-file-preview" data-value="'.absint( $id ).'">';
				$output .= '<div class="fieldpress-file-wrap">';
				$output .= "<i class='dashicons dashicons-no fieldpress-file-clear'></i>";
				$output .= "<div class='fieldpress-icon-wrapper'><a data-file-type='".esc_attr( $file_type )."' data-button-text='".esc_attr( $button_text )."' data-title='".esc_attr( $upload_title )."' href='#' class='fieldpress-file-uploader-open'><img src='". esc_url( $preview ) ."' /></a></div>";
				$output .= "<div class='fieldpress-file-details'>";
				$output .= "<div class='fieldpress-file-title'>".esc_html( $title)."</div>";
				$output .= "<div class='fieldpress-file-name'><a class='fieldpress-file-link' href='".esc_url( $url )."' target='_blank'>".esc_html( $name)."</a></div>";
				$output .= "<div class='fieldpress-file-size'>".esc_html( $size )."</div>";
				$output .= "</div>";/*details*/
				$output .= "</div>";/*fieldpress-file-wrap*/
				$output .= "</div>";/*fieldpress-file-preview*/
			}
		}
	}
	$output .= "</div>";/*preview holder*/
	$output .= "<a href='#' class='button button-primary fieldpress-file-uploader-open' data-file-type='".esc_attr( $file_type )."'  data-button-text='".esc_html( $button_text)."' data-title='".esc_html( $upload_title )."'>". esc_html( $upload_title ) ."</a>";

	$output .= '<input ';

	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	echo $output;
}