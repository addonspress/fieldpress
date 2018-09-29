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
function fieldpress_render_accordions( $field_details, $accordions_from = array() ) {

	$accordions = $field_details['accordions'];
	/*Sort accordions according to priority*/
	fieldpress_stable_uasort ($accordions,'fieldpress_uasort');

	$fields =  isset($field_details['fields'])? $field_details['fields'] : array();
	/*Sort fields according to priority*/
	fieldpress_stable_uasort ($fields,'fieldpress_uasort');

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

		$label = isset($accordions[$accordion_id]['label'])?$accordions[$accordion_id]['label']:'';

		echo  '<div class="accordion-table">';
		echo '<div class="fieldpress-accordion-top">
						<div class="fieldpress-accordion-title-action">
							<button type="button" class="fieldpress-accordion-action">
								<span class="toggle-indicator" aria-hidden="true"></span>
							</button>
						</div>
						<div class="fieldpress-accordion-title"><label>'.$label.'</label></div>
					</div>';

		if( !empty( $accordion_fields) ){
			echo "<div class='fieldpress-accordion-inside'>";

			foreach( $accordion_fields as $field_id => $accordion_single_field ){


				if( isset( $field_details['is_in_repeater'])){

					$repeater_details = $field_details['repeater-details'];
					$field_repeater_depth = $field_details['repeater-depth'];

					$repeater_id  = $repeater_details['attr']['id'].$field_repeater_depth.$field_id;
					$repeater_name  = $repeater_details['attr']['name'].'['.$field_repeater_depth.']['.$field_id.']';
					$accordion_single_field['repeater_depth'] = $field_repeater_depth;

					/*set new id for field in array format*/
					$accordion_single_field['attr']['id'] = $repeater_id;
					$accordion_single_field['attr']['fieldpress-filed-name'] = $repeater_name;
					$accordion_single_field['fieldpress-unique'] = $repeater_id;

					$accordion_single_field['is_in_repeater'] = 1;

				}
				else{
					$accordion_single_field['attr']['id'] = $field_id;
					$accordion_single_field['attr']['name'] = $field_id;
				}

				$value = false;
				if( 'menu' == $accordions_from['type'] ){
					$value = get_option( $field_id );
				}
				elseif ('meta' == $accordions_from['type'] ){
					$value = get_post_meta( $accordions_from['post_id'], $field_id,true );
				}
				if ( ! $value ) {
					if ( isset( $accordion_single_field['default'] ) ) {
						$value = $accordion_single_field['default'];
					}
				}

				fieldpress_render_field( $field_id, $accordion_single_field, $value, $accordions_from );
			}
			echo'</div>'/*.fieldpress-accordion-inside*/;
		}
		echo'</div>';/*.accordion-table*/
	}
}