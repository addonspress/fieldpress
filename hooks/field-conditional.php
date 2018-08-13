<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Classes for conditional
 *
 * @since 0.0.1
 * @param array $classes
 * @param array $class
 * @param array $field_details
 * @param array $field_value
 * @return array
 *
 */
function fieldpress_single_field_add_controller( $classes, $class, $field_details, $field_value ) {
	if ( isset( $field_details['conditional'] ) && isset( $field_details['conditional']['type'] ) && 'controller' == $field_details['conditional']['type'] ){
		$classes[] = 'fieldpress-controller';
	}
	return $classes;
}
add_filter('fieldpress_get_single_field_class', 'fieldpress_single_field_add_controller',10, 4 );

/**
 * Add Classes for conditional
 *
 * @since 0.0.1
 * @param array $classes
 * @param array $class
 * @param array $field_details
 * @param array $field_value
 * @return array
 *
 */
function fieldpress_field_wrap_add_controller( $classes, $class, $field_details, $field_value ) {
	if ( isset( $field_details['conditional'] ) && isset( $field_details['conditional']['type'] ) && 'dependent' == $field_details['conditional']['type'] ){
		$conditional = $field_details['conditional'];
		$controller = $conditional['controller'];
		$classes[] = 'fieldpress-dependent';
		$classes[] = 'fieldpress-hidden';
		$classes[] = $controller;
	}
	return $classes;
}
add_filter('fieldpress_get_field_wrap_class', 'fieldpress_field_wrap_add_controller',10, 4 );

function fieldpress_set_wrap_condition( $attributes, $field_details, $field_value ){
	if ( isset( $field_details['conditional'] ) && isset( $field_details['conditional']['type'] ) && 'dependent' == $field_details['conditional']['type'] ){
		$conditional = $field_details['conditional'];
		$condition = $conditional['condition'];
		$conditional_value = $conditional['conditional-value'];

		$attributes['data-condition'] = $condition;
		$attributes['data-conditional-value'] = $conditional_value;
	}
	return $attributes;
}
add_filter('fieldpress_field_wrap_attributes', 'fieldpress_set_wrap_condition',10, 3 );