<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the devices output
 * @since 0.0.1
 * @param array $field_details
 * @param mixed $field_value
 * @return void
 */
function fieldpress_render_box( $field_details, $field_value ) {

	$default_devices = array(
		'large'=>array(
			'icon' => 'dashicons-laptop',
		),
		'medium'=>array(
			'icon' => 'dashicons-tablet',

		),
		'small'=>array(
			'icon' => 'dashicons-smartphone ',
		),
	);
	$default_fields = array(
		'top'=> true,
		'right'=> true,
		'bottom'=> true,
		'left'=> true,
	);
	$box_field_id = $field_details['id'];
	$devices = isset( $field_details['device'] )?$field_details['device']: $default_devices;

	/*Sort devices according to priority*/
	fieldpress_stable_uasort ($devices,'fieldpress_uasort');

	$box_fields_attr =  isset($field_details['boxes'])? $field_details['boxes'] : $default_fields;

	echo '<div class="fieldpress-inner-devices-menu">';
	echo '<ul class="fields-devices">';
	$i = 1;
	foreach( $devices as $device_id => $device_details ){
		$active = '';
		if( $i == 1){
			$active = ' class="active"';
		}
		if( isset($device_details['icon'] )){
			$tab_label = "<i class='fp-icon ".esc_attr( $device_details['icon'])."'></i>";
		}
		echo '<li'.$active.'><a href="#'.esc_attr( $device_id ).esc_attr($box_field_id).'">'.$tab_label.'</a></li>';
		$i ++;
	}
	echo '</ul>';
	echo '</div>';

	echo '<div class="fieldpress-inner-devices-content">';
	$i = 1;

	foreach( $devices as $device_id => $device_details ){
		if( $i == 1){
			$active = ' active';
		}
		else{
			$active = ' hidden';
		}
		echo '<div id="'.esc_attr( $device_id ).esc_attr($box_field_id).'" class="fields-box-content'.$active.'">';

		foreach( $box_fields_attr as $field_id => $box_single_field ){

			if( isset( $field_details['is_in_repeater'])){

				$repeater_details = $field_details['repeater-details'];
				$field_repeater_depth = $field_details['repeater-depth'];

				$box_single_field_id  = $repeater_details['attr']['id'].$field_repeater_depth.$box_field_id.$device_id.$field_id;
				$box_single_field_name  = $repeater_details['attr']['name'].'['.$field_repeater_depth.']['.$box_field_id.']['.$device_id.']['.$field_id.']';

			}
			else{
				$box_single_field_id = $box_field_id.$device_id.$field_id;
				$box_single_field_name = $box_field_id.'['.$device_id.']['.$field_id.']';
			}

			$value = isset( $field_value[$device_id][$field_id] )?$field_value[$device_id][$field_id]:'';
			if ( ! $value ) {
				if ( isset( $box_single_field['default'] ) ) {
					$value = $box_single_field['default'];
				}
			}
			?>
            <input class="fieldpress-box-input" type="text" value="<?php echo esc_attr( $value )?>" id="<?php echo esc_attr( $box_single_field_id );?>" size="40" style="" name="<?php echo esc_attr($box_single_field_name);?>">
			<?php
		}

		echo '</div>';
		$i ++;

	}

	echo '</div>';

	
}