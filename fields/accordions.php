<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the accordions output
 * @since 0.0.1
 * @param array $field_details
 * @param mixed $field_value
 * @return void
 */
function fieldpress_render_accordions( $field_details, $field_value ) {

	/*use for name*/
	$accordion_main_id = $field_details['id'];

	$accordions = $field_details['accordions'];

	/*Sort accordions according to priority*/
	fieldpress_stable_uasort ($accordions,'fieldpress_uasort');

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
	/*initialize accordion and fields*/
	$accordions_and_fields = array();

	foreach( $accordions as $accordion_id => $accordion_details ){
		$accordions_and_fields[$accordion_id] = array();
		foreach( $fields as $field_id => $accordion_single_field ){
			if($accordion_single_field['accordion'] == $accordion_id ){
				/*Set array current menus sections*/
				$accordions_and_fields[$accordion_id][$field_id] = $accordion_single_field;
			}
		}
	}

	foreach( $accordions_and_fields as $accordion_id => $accordion_fields ){

		if( isset( $accordions[$accordion_id]['checkbox']) && $accordions[$accordion_id]['checkbox'] ){
			$checkbox_value = isset($field_value[$accordion_id][$accordion_id])?$field_value[$accordion_id][$accordion_id]:false;
			$checkbox_label = $label = isset($accordions[$accordion_id]['label'])?$accordions[$accordion_id]['label']:'';

			if( $override ){
				$accordion_checkbox_field_name = $override_name.'['.$accordion_id.']['.$accordion_id.']';
				$accordion_checkbox_field_id = $override_id;
			}
			else{
				$accordion_checkbox_field_name = $accordion_main_id.'['.$accordion_id.']['.$accordion_id.']';
				$accordion_checkbox_field_id = $accordion_main_id.$accordion_id;
			}
			$checkbox_label = '<input type="checkbox" id="'.$accordion_checkbox_field_id.'" name="'.$accordion_checkbox_field_name.'" '.checked( $checkbox_value, true, false).'>'.$checkbox_label;

		}
		else{
			$checkbox_label = $label = isset($accordions[$accordion_id]['label'])?$accordions[$accordion_id]['label']:'';
		}

		echo  '<div class="accordion-table">';
		echo '<div class="fieldpress-accordion-top">
						<div class="fieldpress-accordion-title-action">
							<button type="button" class="fieldpress-accordion-action">
								<span class="toggle-indicator" aria-hidden="true"></span>
							</button>
						</div>
						<div class="fieldpress-accordion-title"><label>'.$checkbox_label.'</label></div>
					</div>';

		if( !empty( $accordion_fields) ){
			echo "<div class='fieldpress-accordion-inside'>";

			foreach( $accordion_fields as $field_id => $accordion_single_field ){

				if( $override ){
					$accordion_single_field_name = $override_name.'['.$accordion_id.']['.$field_id.']';
					$accordion_single_field_id = $override_id;
				}
				else{
					$accordion_single_field_name = $accordion_main_id.'['.$accordion_id.']['.$field_id.']';
					$accordion_single_field_id = $accordion_main_id.$accordion_id.$field_id;
				}
				$accordion_single_field['fieldpress-override-attr']['name'] = $accordion_single_field_name;
				$accordion_single_field['fieldpress-override-attr']['id'] = $accordion_single_field_id;

				$accordion_single_field['attr']['name'] = $accordion_single_field_name;
				$accordion_single_field['attr']['id'] = $accordion_single_field_id;


				$value = isset($field_value[$accordion_id][$field_id])?$field_value[$accordion_id][$field_id]:false;
				if ( ! $value ) {
					if ( isset( $accordion_single_field['default'] ) ) {
						$value = $accordion_single_field['default'];
					}
				}
				fieldpress_render_field( $field_id, $accordion_single_field, $value );
			}
			echo'</div>'/*.fieldpress-accordion-inside*/;
		}
		echo'</div>';/*.accordion-table*/
	}
}