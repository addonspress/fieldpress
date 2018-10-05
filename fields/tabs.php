<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the tabs output 
 * @since 0.0.1
 * @param array $field_details
 * @param mixed $field_value
 * @return void
 */
function fieldpress_render_tabs( $field_details, $field_value ) {

	/*use for name*/
	$tab_main_id = $field_details['id'];

	$tabs = $field_details['tabs'];
	/*Sort tabs according to priority*/
	fieldpress_stable_uasort ($tabs,'fieldpress_uasort');

	$fields =  isset($field_details['fields'])? $field_details['fields'] : array();
	/*Sort fields according to priority*/
	fieldpress_stable_uasort ($fields,'fieldpress_uasort');

	/*override attr*/
	$override = false;
	if( isset( $field_details['fieldpress-override-attr']) && is_array( $field_details['fieldpress-override-attr'] ) ){
		$override_attr = $field_details['fieldpress-override-attr'];
		$override_name = $override_attr['name'];
		$override_id = $override_attr['id'];
		$override = true;
	}

	$tabs_and_fields = array();
	if( isset( $field_details['tabs-layout']) && 'vertical' == $field_details['tabs-layout'] ){
		echo '<div class="fiedpress-inner-vertical-tab">';
	}
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

			if( $override ){
				$tab_single_field_name = $override_name.'['.$tab_id.']['.$field_id.']';
				$tab_single_field_id = $override_id;
			}
			else{
				$tab_single_field_name = $tab_main_id.'['.$tab_id.']['.$field_id.']';
				$tab_single_field_id = $tab_main_id.$tab_id.$field_id;
			}
			$tab_single_field['fieldpress-override-attr']['name'] = $tab_single_field_name;
			$tab_single_field['fieldpress-override-attr']['id'] = $tab_single_field_id;

			$tab_single_field['attr']['name'] = $tab_single_field_name;
			$tab_single_field['attr']['id'] = $tab_single_field_id;


			$value = isset($field_value[$tab_id][$field_id])?$field_value[$tab_id][$field_id]:false;
			if ( ! $value ) {
				if ( isset( $tab_single_field['default'] ) ) {
					$value = $tab_single_field['default'];
				}
			}

			fieldpress_render_field( $field_id, $tab_single_field, $value );
		}
		echo '</div>';
		$i ++;
	}
	echo '</div>';/*fieldpress-inner-tabs-menu*/
	if( isset( $field_details['tabs-layout']) && 'vertical' == $field_details['tabs-layout'] ){
		echo '</div>';/*fiedpress-inner-vertical-tab*/
	}
}