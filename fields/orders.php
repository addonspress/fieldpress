<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * render the orders output
 * @since 0.0.1
 * @param array $field_details
 * @param mixed $field_value
 * @return void
 */
function fieldpress_render_orders( $field_details, $field_value ) {

	$orders = $field_details['orders'];
	$field_order_main_id = $field_details['id'];

	/*Sort orders according to priority*/
	fieldpress_stable_uasort ($orders,'fieldpress_uasort');

	$fields =  isset($field_details['fields'])? $field_details['fields'] : array();
	/*Sort fields according to priority*/
	fieldpress_stable_uasort ($fields,'fieldpress_uasort');

	/*initialize new order and fields*/
	$orders_and_fields = array();

	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_order_field_default_args',array(
		'type'          => 'order',
		'id'            => '',
		'class'         => '',
		'style'         => '',
	), $field_details, $field_value );

	$field_attr = $field_details['attr'];
	$attributes = apply_filters('fieldpress_field_attributes', wp_parse_args( $field_attr, $default_attr ), $field_details, $field_value );
	$class = isset($attributes['class'])?$attributes['class'].' '.'fieldpress-order':'fieldpress-order';
	$attributes['class'] = fieldpress_get_single_field_class( $field_details, $field_value, $class );

	$output = '<div ';

	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	echo $output;

	$i= 0;
	foreach( $orders as $order_id => $order_details ){
		/*need at-least one field for order, checkbox at header does not set if not checked*/
		$orders_and_fields[$order_id][$order_id.'-fieldpress-hidden-order'] = array(
			'type'  => 'hidden',
		);
		foreach( $fields as $field_id => $order_single_field ){
			if( $order_single_field['order'] == $order_id ){
				/*array is awesome*/
				$orders_and_fields[$order_id][$field_id] = $order_single_field;
			}
		}
		$i++;
	}

	/*override attr*/
	$override = false;
	if( isset( $field_details['fieldpress-override-attr']) && is_array( $field_details['fieldpress-override-attr'] ) ){
		$override_attr = $field_details['fieldpress-override-attr'];
		$override_name = $override_attr['name'];
		$override_id = $override_attr['id'];
		$override = true;
	}

	/*order index imp for ordering*/
	$order_index = 0;

	if ( !empty( $field_value ) && is_array($field_value) && count($field_value) > 0 ){
		foreach ( $field_value as $key => $field_saved_value ){

			foreach( $orders_and_fields as $order_id => $order_fields ){

				$order_array_key = array_keys($order_fields);
				$saved_array_key = array_keys($field_saved_value);
				$result = array_diff($order_array_key,$saved_array_key);

				/*here goes the logic*/
				if( isset( $field_saved_value[$order_id])  || ( count( $result) < count( $order_array_key))){

					echo  '<div class="order-table">';
					echo '<div class="fieldpress-order-top">';
					if( !empty( $order_fields) && count( $order_fields ) > 1 ){
						echo '<div class="fieldpress-order-title-action">
							<button type="button" class="fieldpress-order-action">
								<span class="toggle-indicator" aria-hidden="true"></span>
							</button>
						</div>';
					}
					echo '<div class="fieldpress-order-title">';
					$checkbox_value = isset($field_saved_value[$order_id])?$field_saved_value[$order_id]:false;

					if( $override ){
						$order_checkbox_field_name = $override_name.'['.$order_index.']['.$order_id.']['.$order_id.']';
						$order_checkbox_field_id = $override_id;
					}
					else{
						$order_checkbox_field_name = $field_order_main_id.'['.$order_index.']['.$order_id.']['.$order_id.']';
						$order_checkbox_field_id = $field_order_main_id.$order_id;
					}

//					$order_checkbox_field_name = $field_order_main_id.'['.$order_index.']['.$order_id.']['.$order_id.']';
					$checkbox_label = $orders[$order_id]['label'];
					echo '<label><input type="checkbox" id="'.$order_checkbox_field_id.'" name="'.$order_checkbox_field_name.'" '.checked( $checkbox_value, true, false).'>'.$checkbox_label.'</label>';
					echo '</div></div>';
					if( !empty( $order_fields) ){

						echo "<div class='fieldpress-order-inside hidden'>";

						foreach( $order_fields as $field_id => $order_single_field ){

							if( $override ){
								$order_single_field_name = $override_name.'['.$order_index.']['.$order_id.']['.$field_id.']';
								$order_single_field_id = $override_id;
							}
							else{
								$order_single_field_name = $field_order_main_id.'['.$order_index.']['.$order_id.']['.$field_id.']';
								$order_single_field_id = $field_id;
							}
							$order_single_field['fieldpress-override-attr']['name'] = $order_single_field_name;
							$order_single_field['fieldpress-override-attr']['id'] = $order_single_field_id;

							$order_single_field['attr']['name'] = $order_single_field_name;
							$order_single_field['attr']['id'] = $order_single_field_id;

							$value = isset($field_saved_value[$field_id])?$field_saved_value[$field_id]:'';

							if ( ! $value ) {
								if ( isset( $order_single_field['default'] ) ) {
									$value = $order_single_field['default'];
								}
							}

							fieldpress_render_field( $field_id, $order_single_field, $value );
						}
						echo'</div>'/*.fieldpress-order-inside*/;
					}

					echo'</div>'/*.fieldpress-order-inside*/;
					$order_index++;

					unset($orders_and_fields[$order_id]);
				}
			}

		}
	}

	foreach( $orders_and_fields as $order_id => $order_fields ){

		echo  '<div class="order-table">';
		echo '<div class="fieldpress-order-top">';
		if( !empty( $order_fields) && count( $order_fields ) > 1){
			echo '<div class="fieldpress-order-title-action">
							<button type="button" class="fieldpress-order-action">
								<span class="toggle-indicator" aria-hidden="true"></span>
							</button>
						</div>';
		}
		echo '<div class="fieldpress-order-title">';
		$checkbox_value = false;
		$order_checkbox_field_name = $field_order_main_id.'['.$order_index.']['.$order_id.']['.$order_id.']';
		$checkbox_label = $orders[$order_id]['label'];
		echo '<label><input type="checkbox" id="'.$order_id.'" name="'.$order_checkbox_field_name.'" '.checked( $checkbox_value, true, false).'>'.$checkbox_label.'</label>';
		echo '</div></div>';

		if( !empty( $order_fields) ){
			echo "<div class='fieldpress-order-inside hidden'>";

			foreach( $order_fields as $field_id => $order_single_field ){

				if( $override ){
					$order_single_field_name = $override_name.'['.$order_index.']['.$order_id.']['.$field_id.']';
					$order_single_field_id = $override_id;
				}
				else{
					$order_single_field_name = $field_order_main_id.'['.$order_index.']['.$order_id.']['.$field_id.']';
					$order_single_field_id = $field_id;
				}
				$order_single_field['fieldpress-override-attr']['name'] = $order_single_field_name;
				$order_single_field['fieldpress-override-attr']['id'] = $order_single_field_id;

				$order_single_field['attr']['name'] = $order_single_field_name;
				$order_single_field['attr']['id'] = $order_single_field_id;
				$value = '';

				if ( isset( $order_single_field['default'] ) ) {
					$value = $order_single_field['default'];
				}

				fieldpress_render_field( $field_id, $order_single_field, $value );
			}
			echo'</div>'/*.fieldpress-order-inside*/;
		}

		echo'</div>'/*.fieldpress-order-inside*/;

		$order_index++;
	}
	echo'</div>'/*.fieldpress-order-inside*/;
}