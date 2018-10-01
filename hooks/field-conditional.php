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
	if ( isset( $field_details['controller'] ) && true == $field_details['controller'] ){
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
	if ( isset( $field_details['dependent'] ) ){
		$dependent_details = $field_details['dependent'];

		$classes[] = 'fieldpress-dependent';
		$classes[] = 'fieldpress-hidden';

		if ( isset( $dependent_details['controller'] ) ){
			$classes[] = $dependent_details['controller'];
		}
		else{
			foreach ( $dependent_details as $single_dependent ){

				if( is_array( $single_dependent )){
					$classes[] = $single_dependent['controller'];
				}
			}
		}
	}
	return $classes;
}
add_filter('fieldpress_get_field_wrap_class', 'fieldpress_field_wrap_add_controller',10, 4 );

function fieldpress_set_wrap_condition( $attributes, $field_details, $field_value ){
	if ( isset( $field_details['dependent'] ) ){
		$dependent_details = $field_details['dependent'];
		if( isset( $dependent_details['relation'])){
			$relation = $dependent_details['relation'] == 'AND'?'AND':'OR';/*JUST AND || OR*/
			$attributes['data-relation'] = $relation;
			$attributes['data-condition'] = '';
			$condition = $controller = $conditional_value = '';
			foreach ( $dependent_details as $single_dependent ){
				if( is_array( $single_dependent )){
					/*&fp& is uniquer do not use it as any value*/
					$condition .= $single_dependent['condition'].'&fp&';
					$controller .= $single_dependent['controller'].'&fp&';
					$conditional_value .= $single_dependent['conditional-value'].'&fp&';
				}
				$attributes['data-condition'] = substr($condition, 0, -4);
				$attributes['data-controller'] = substr($controller, 0, -4);
				$attributes['data-conditional-value'] = substr($conditional_value, 0, -4);
			}

		}
		else{
			$condition = $dependent_details['condition'];
			$conditional_value = $dependent_details['conditional-value'];

			$attributes['data-condition'] = $condition;
			$attributes['data-conditional-value'] = $conditional_value;
			$attributes['data-controller'] = $dependent_details['controller'];
		}
	}
	return $attributes;
}
add_filter('fieldpress_field_wrap_attributes', 'fieldpress_set_wrap_condition',10, 3 );