<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the tabs output 
 * @since 0.0.1
 * @param array $field_details
 * @param mix $field_value
 * @return void
 */
function fieldpress_render_tabs( $field_details, $all_fields_value ) {

	$tabs = $field_details['tabs'];
	$fields = $field_details['fields'];

	$tabs_and_fields = array();
	echo '<div class="fieldpress-inner-tabs-menu">';
	echo '<ul class="fields-tabs">';
	$i = 1;
	foreach( $tabs as $tab_id => $tab_details ){
		$active = '';
		if( $i == 1){
			$active = ' class="active"';
		}
		$tab_label = $has_label = '';
		if( isset($tab_details['icon'] )){
			$tab_label = "<i class='fp-icon ".esc_attr( $tab_details['icon'])."'></i>";
		}
		if( isset($tab_details['label'] ) &&
		    (!isset( $tab_details['icon-only'] ) ||
		     ( isset( $tab_details['icon-only'] ) && $tab_details['icon-only'] == false )
		    )
		){
			$has_label = "fp-has-label";
			$tab_label .= esc_html( $tab_details['label'] );
		}
		echo '<li'.$active.'><a href="#'.esc_attr( $tab_id ).'fieldpress-tab-id" class="'.$has_label.'">'.$tab_label.'</a></li>';
		foreach( $fields as $field_id => $tab_single_field ){
			if($tab_single_field['tab'] == $tab_id ){
				/*Set array current menus sections*/
				$tabs_and_fields[$tab_id][$field_id] = $tab_single_field;
			}
		}
		$i ++;
	}
	echo '</ul>';
	echo '</div>';

	echo '<div class="fieldpress-inner-tabs-content">';
	$i = 1;
	foreach( $tabs_and_fields as $tab_id => $tab_fields ){
		if( $i == 1){
			$active = ' active';
		}
		else{
			$active = ' hidden';
		}
		echo '<div id="'.esc_attr( $tab_id ).'fieldpress-tab-id" class="fields-tabs-content'.$active.'">';
		foreach( $tab_fields as $field_id => $tab_single_field ){

			if( isset( $field_details['is_in_repeater'])){

				$repeater_details = $field_details['repeater-details'];
				$field_repeater_depth = $field_details['repeater-depth'];

				$repeater_id  = $repeater_details['attr']['id'].$field_repeater_depth.$field_id;
				$repeater_name  = $repeater_details['attr']['name'].'['.$field_repeater_depth.']['.$field_id.']';
				$tab_single_field['repeater_depth'] = $field_repeater_depth;

				/*set new id for field in array format*/
				$tab_single_field['attr']['id'] = $repeater_id;
				$tab_single_field['attr']['fieldpress-filed-name'] = $repeater_name;
				$tab_single_field['fieldpress-unique'] = $repeater_id;

				$tab_single_field['is_in_repeater'] = 1;

			}
			else{
				$tab_single_field['attr']['id'] = $field_id;
				$tab_single_field['attr']['name'] = $field_id;
			}

			$value = isset( $all_fields_value[$field_id] ) ? $all_fields_value[$field_id] : '';
			fieldpress_render_field( $tab_single_field, $value );
		}
		echo '</div>';
		$i ++;
	}
	echo '</div>';
}