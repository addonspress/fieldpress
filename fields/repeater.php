<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the repeater output 
 * @since 0.0.1
 * @param array $field_details
 * @param mixed $field_value
 * @return void
 */
function fieldpress_render_repeater( $field_details, $field_value, $all_fields_value ) {

	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_radio_field_default_args',array(
		'type'          => 'repeater',
		'id'            => '',
		'class'         => '',
		'style'         => '',
	), $field_details, $field_value );
	$field_attr = $field_details['attr'];
	$attributes = apply_filters('fieldpress_field_attributes', wp_parse_args( $field_attr, $default_attr ), $field_details, $field_value );

	$label_repeater = ( isset($field_details['label-repeater'] )? $field_details['label-repeater'] : 'Repeater' );
	$fp_parent = '';
	$fp_depth = '';
	$fp_index = '';
	$margin_left = '';


	if( isset($field_details['nested'] ) && true === $field_details['nested'] ){
		$max_depth = isset($field_attr['max-depth']) ? $field_attr['max-depth'] : 10;

		$attributes = array(
			'data-nested'       => 1,
			'data-max-depth'    => $max_depth
		);
	}
	/*filter the classes*/
	$class = isset($attributes['class'])?$attributes['class'].' '.'fieldpress-repeater':'fieldpress-repeater';
	$attributes['class'] = fieldpress_get_single_field_class( $field_details, $field_value, $class );

	$output = '<div ';

	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	echo $output;

	/*count repeater field*/
	$total_repeater = 0;
	if ( !empty( $field_value ) && is_array($field_value) && count($field_value) > 0 ){
		foreach ($field_value as $field_saved_value){

			if( isset($field_details['nested'] ) && true === $field_details['nested'] ){
				$fp_parent = $field_saved_value['fp-parent'];
				$fp_depth = $field_saved_value['fp-depth'];
				$fp_index = $field_saved_value['fp-index'];
				$margin_left = ($fp_depth * 32).'px' ;
			}

			/*for labeling toggles*/
			echo  '<div class="repeater-table" data-depth="'.absint($fp_depth).'" data-index="'.absint($fp_index).'" style="margin-left:'.$margin_left.'">';
			echo '<div class="fieldpress-repeater-top">
						<div class="fieldpress-repeater-title-action">
							<button type="button" class="fieldpress-repeater-action">
								<span class="toggle-indicator" aria-hidden="true"></span>
							</button>
						</div>
						<div class="fieldpress-repeater-title"><h3>'.$label_repeater.'<span class="in-fieldpress-repeater-title"></span></h3></div>
					</div>';
			echo "<div class='fieldpress-repeater-inside hidden'>";

			$fields = $field_details['fields'];
			/*Sort fields according to priority*/
			fieldpress_stable_uasort ($fields,'fieldpress_uasort');

			foreach ( $fields as $field_id => $field_cr ){

				/*reset var $repeater_id for repeater*/
				$repeater_id  = $field_attr['id'].$total_repeater.$field_id;
				$repeater_name  = $field_attr['name'].'['.$total_repeater.']['.$field_id.']';

				$field_value = isset($field_saved_value[$field_id]) ? $field_saved_value[$field_id]: '';

				/*set new id for field in array format*/
				$field_cr['attr']['id'] = $repeater_id;
				$field_cr['fieldpress-unique'] = $repeater_id;
				$field_cr['attr']['name'] = $repeater_name;
				$field_cr['is_in_repeater'] = 1;

				if( 'tabs' == $field_cr['type'] ){
					$field_cr['repeater-details'] = $field_details;
					$field_cr['repeater-depth'] = $total_repeater;
				}
				fieldpress_render_field( $field_id, $field_cr, $field_value, $field_saved_value );

			}
			echo '<div class="fieldpress-repeater-control-actions">
				<button type="button" class="button-link button-link-delete fieldpress-repeater-remove">'.esc_html__('Delete','fieldpress').'</button> |
				<button type="button" class="button-link fieldpress-repeater-close">'.esc_html__('Close','fieldpress').'</button>
			</div>';

			echo'<input class="fp-parent" type="hidden" name="'.$field_attr['name'].'['.$total_repeater.'][fp-parent]'.'" value="'.$fp_parent.'">';/*.parent*/
			echo'<input class="fp-depth" type="hidden" name="'.$field_attr['name'].'['.$total_repeater.'][fp-depth]'.'" value="'.$fp_depth.'">';/*.depth*/
			echo'<input class="fp-index" type="hidden" name="'.$field_attr['name'].'['.$total_repeater.'][fp-index]'.'" value="'.$total_repeater.'">';/*.index*/

			echo'</div>'/*.fieldpress-repeater-inside*/;
			echo '<div class="fs-repeater-transport"></div>';/*for sub items*/
			echo'</div>';/*.repeater-table*/
			$total_repeater = $total_repeater + 1;
		}
	}

	/*create all fields once more for js function and catch with object buffer*/
	echo '<div type="text/template" class="fieldpress-code-for-repeater" style="display: none">';
	ob_start();
	echo '<div class="fieldpress-repeater-top">
				<div class="fieldpress-repeater-title-action">
					<button type="button" class="fieldpress-repeater-action">
						<span class="toggle-indicator" aria-hidden="true"></span>
					</button>
				</div>
		<div class="fieldpress-repeater-title"><h3>'.esc_html( $label_repeater ).'<span class="in-fieldpress-repeater-title"></span></h3></div>
	</div>';
	echo "<div class='fieldpress-repeater-inside'>";
	if(isset($field_details['repeater_depth'])){
		$field_repeater_depth = $field_details['repeater_depth'];
		$field_repeater_depth = explode( '_', $field_repeater_depth );
		$field_repeater_depth = $field_repeater_depth[1];
		$field_repeater_depth = $field_repeater_depth + 1;
		$field_repeater_depth = 'coderRepeaterDepth_'.$field_repeater_depth;
	}
	else{
		$field_repeater_depth = 'coderRepeaterDepth_'.'0';
	}
	$fields = $field_details['fields'];
	/*Sort fields according to priority*/
	fieldpress_stable_uasort ($fields,'fieldpress_uasort');

	foreach ($fields as $field_id => $field_cr){

		$field_value ='';

		if ( isset( $field_cr['default'] ) ) {
			$field_value = $field_cr['default'];
		}
		/*reset var $repeater_id for repeater*/

		$repeater_id  = $field_attr['id'].$field_repeater_depth.$field_id;
		$repeater_name  = $field_attr['name'].'['.$field_repeater_depth.']['.$field_id.']';
		$field_cr['repeater_depth'] = $field_repeater_depth;

		/*set new id for field in array format*/
		$field_cr['attr']['id'] = $repeater_id;
		$field_cr['attr']['fieldpress-filed-name'] = $repeater_name;
		$field_cr['fieldpress-unique'] = $repeater_id;

		$field_cr['is_in_repeater'] = 1;

		if( 'tabs' == $field_cr['type'] ){

			$field_cr['repeater-details'] = $field_details;
			$field_cr['repeater-depth'] = $field_repeater_depth;

		}
		fieldpress_render_field( $field_id, $field_cr, $field_value );

	}
	echo '<div class="fieldpress-repeater-control-actions">
				<button type="button" class="button-link button-link-delete fieldpress-repeater-remove">'.esc_html__('Delete','fieldpress').'</button> |
				<button type="button" class="button-link fieldpress-repeater-close">'.esc_html__('Close','fieldpress').'</button>
			</div>';

	echo'<input class="fp-parent" type="hidden" fieldpress-filed-name="'.$field_attr['name'].'['.$field_repeater_depth.'][fp-parent]'.'">';/*.parent*/
	echo'<input class="fp-depth" type="hidden" fieldpress-filed-name="'.$field_attr['name'].'['.$field_repeater_depth.'][fp-depth]'.'">';/*.depth*/
	echo'<input class="fp-index" type="hidden" fieldpress-filed-name="'.$field_attr['name'].'['.$field_repeater_depth.'][fp-index]'.'">';/*.depth*/

	echo '</div>';/*.fieldpress-repeater-inside*/
	echo '<div class="fs-repeater-transport"></div>';/*for sub items*/

	$encode_content = ob_get_contents();
	ob_end_clean();
	echo $encode_content;
	echo'</div>';/*.fieldpress-code-for-repeater*/

	/*most important section for repeater*/
	echo '<input class="fieldpress-total-repeater" type="hidden" value="'.$total_repeater.'">';
	$add_field = esc_html__('Add field', 'fieldpress');
	echo '<span class="button-primary fieldpress-add-repeater" id="'.esc_attr( $field_repeater_depth ).'"><i class="dashicons dashicons-plus"></i>'.esc_html( $add_field ).'</span><br/>';
	echo "</div>";/*.fieldpress-repeater*/
}