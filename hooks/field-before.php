<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Wrap class for every field
 * 
 * @since 0.0.1
 * @param array $field_details
 * @return void
 *
 */
function fieldpress_field_wrap( $field_details, $field_value ) {
	$attributes = array();
	if( isset( $field_details['wrap-attr'] )){
		$attributes = $field_details['wrap-attr'];
	}

	$attributes = apply_filters('fieldpress_field_wrap_attributes', $attributes, $field_details, $field_value );

	/*filter the classes*/
	$class = isset($attributes['class'])?$attributes['class'].' '."fieldpress-field fieldpress-{$field_details['type']}":"fieldpress-field fieldpress-{$field_details['type']}";
	$attributes['class'] = fieldpress_get_field_wrap_class( $field_details, $field_value, $class );

	$output = '<div ';

	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';

	echo $output;
}
add_action('fieldpress_render_field_before', 'fieldpress_field_wrap', 10, 2 );

/**
 * Show description before and after every label
 * $field_details['desc']['before-label']
 * $field_details['desc']['after-label'] 
 * @since 0.0.1
 * @param array $field_details 
 * @return void
 *
 */
function fieldpress_label( $field_details ) {

	$output ='';
	if ( isset( $field_details['label']) && ( $field_details['label'] != '' || $field_details['label'] != FALSE ) ) {
		$output .= "<div class='fieldpress-label'>";
		/*show description before label*/
		if ( isset($field_details['desc']) && is_array( $field_details['desc'] ) && isset($field_details['desc']['before-label'] ) ){
			$output .=  "<div class='fieldpress-desc'>".fieldpress_sanitize_allowed_html( $field_details['desc']['before-label'] )."</div>";
		}
		$output .=  "<label for='".esc_attr( $field_details['attr']['id'] )."'>".esc_html( $field_details['label'] )."</label>";
		/*show description after label*/
		if ( isset($field_details['desc']) && is_array( $field_details['desc'] ) && isset($field_details['desc']['after-label'] ) ){
			$output .=  "<div class='fieldpress-desc'>".fieldpress_sanitize_allowed_html( $field_details['desc']['after-label'] )."</div>";
		}
		$output .= "</div>";
	}
	echo $output;
}
add_action('fieldpress_render_field_before', 'fieldpress_label',30);

/**
 * Wrap with fieldpress-fields-box
 *
 * @since 0.0.1
 *
 * @param array $field_details 
 * @return void
 *
 */
function fieldpress_box_wrap( $field_details, $field_value ){

	$attributes = array();
	if( isset( $field_details['box-attr'] )){
		$attributes = $field_details['box-attr'];
	}

	$attributes = apply_filters('fieldpress_field_box_attributes', $attributes, $field_details, $field_value );

	/*filter the classes*/
	$class = isset($attributes['class'])?$attributes['class'].' '."fieldpress-fields-box":"fieldpress-fields-box";

	if( isset($field_details['info'])){
		$class .= ' fp-has-tooltip';
	}
	if( isset($field_details['layout'])){
		$class .= ' fiedpress-inner-'.$field_details['layout'].'-tab ';
	}
	$attributes['class'] = fieldpress_get_field_box_class( $field_details, $field_value, $class );

	$output = '<div ';

	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';

	echo $output;

}
add_action('fieldpress_render_field_before', 'fieldpress_box_wrap', 50, 2 );

/**
 * Show tooltip between label and field
 *
 * @since 0.0.1
 *
 * @param array $field_details
 * @return void
 *
 */
function fieldpress_tooltip( $field_details ){
	if( isset($field_details['info'])){
		echo '<div class="fieldpress-tooltip">
			    	<i class="dashicons dashicons-editor-help"></i>
					<span class="tooltiptext">'.esc_html(  $field_details['info'] ).'</span>
			  </div>';
	}
}
add_action('fieldpress_render_field_before', 'fieldpress_tooltip',60);

/**
 * Show description before every field
 *
 * @since 0.0.1
 *
 * @param array $field_details Single field
 * @return void
 *
 */
function fieldpress_desc_before_field( $field_details ) {
	/*show description*/
	if ( isset($field_details['desc']) && is_array( $field_details['desc'] ) && isset($field_details['desc']['before-field'] ) ){
		echo "<div class='fieldpress-desc'>".fieldpress_sanitize_allowed_html( $field_details['desc']['before-field'] )."</div>";
	}
}
add_action('fieldpress_render_field_before', 'fieldpress_desc_before_field',70 );