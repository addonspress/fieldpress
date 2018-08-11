<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render map output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */
function fieldpress_render_map( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_map_field_default_args',array(
		'type'          => 'text',
		'value'         => '',
		'id'            => '',
		'class'         => '',
		'placeholder'   => '',
		'size'          => 40,
		'style'         => '',
		'zoom'         => 8,
	), $field_details, $field_value );

	$unique = sanitize_key( $field_details['attr']['id'] );
	$field_attr = $field_details['attr'];
	if( empty( $field_value ) ) {
		$field_value = '27.7,85.33333300000004';
	}
	$lat_long = explode(",",$field_value);
	$lat = $lat_long[0];
	$long = $lat_long[1];

	$attributes = apply_filters('fieldpress_field_attributes', wp_parse_args( $field_attr, $default_attr ), $field_details, $field_value );

	$attributes['value'] = $field_value;

	/*filter the classes*/
	$class = isset($attributes['class'])?$attributes['class'].' '.'fieldpress-map-lat-long':'fieldpress-map-lat-long';
	$attributes['class'] = fieldpress_get_single_field_class( $field_details, $field_value, $class );

	$find_label = (isset( $field_details['find-label']) && !empty( $field_details['find-label'] ) ? $field_details['find-label']:__('Find','fieldpress') );
	$search_placeholder = (isset( $field_details['search-placeholder']) && !empty( $field_details['search-placeholder'] ) ? $field_details['search-placeholder']:__('Search Place','fieldpress') );
	$show_map_label = (isset( $field_details['show-map-label']) && !empty( $field_details['show-map-label'] ) ? $field_details['show-map-label']:__('Show Map','fieldpress') );

    $output = '<input ';
	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';

	$output .= "<div class='fieldpress-map-content'><a href='#' class='button button-secondary fieldpress-show-map'>".esc_html( $show_map_label )."</a>";
	$output .= "<div class='fieldpress-map-wrapper hidden'>";
	$output .= "<p><input type='text' class='fieldpress-search-map' placeholder='".esc_attr( $search_placeholder )."'/>";
	$output .= "<a href='#' class='button button-primary fieldpress-find-map'>". esc_attr( $find_label ) ."</a></p>";
	$output .= "<p class='address-wrapper'>";
	$output .= "<span class='fieldpress-address hidden'></span></p>";
	$output .= "<div class='fieldpress-map-holder' data-lat='{$lat}' data-long='{$long}' id='fieldpress-".esc_attr( $unique )."'></div>";
	$output .= '<div class="fieldpress-map-control-actions">
				<button type="button" class="button-link fieldpress-map-clear">'.esc_html__('Close','fieldpress').'</button>
			</div>';
	$output .= "</div>";/*.fieldpress-map-wrapper*/
	$output .= "</div>";/*.fieldpress-map-content*/
	echo $output;
}