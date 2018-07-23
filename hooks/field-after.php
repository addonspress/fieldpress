<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Show description below the field
 *
 * @since 0.0.1
 * @param array $field_details 
 * @return void
 *
 */
function fieldpress_desc( $field_details) {
	if ( isset( $field_details['desc'] ) ){
		if( !is_array( $field_details['desc'] ) ){
			$desc = $field_details['desc'];
		}
		elseif ( isset($field_details['desc']['after-field'] ) ){
			$desc = $field_details['desc']['after-field'];
		}
		else{
			$desc = false;
		}
		if( $desc ){
			echo "<div class='fieldpress-desc'>".fieldpress_sanitize_allowed_html( $desc )."</div>";
		}
	}
}
add_action('fieldpress_render_field_after', 'fieldpress_desc',10 );

/**
 * .fieldpress-fields-box end
 *
 * @since 0.0.1
 * @return void
 *
 */
function fieldpress_box_wrap_end(){
	echo "</div>";	
}
add_action('fieldpress_render_field_after', 'fieldpress_box_wrap_end',20 );

/**
 * .fieldpress-field end
 *
 * @since 0.0.1
 * @return void
 *
 */
function fieldpress_field_wrap_end(){
	echo "</div>";	
}
add_action('fieldpress_render_field_after', 'fieldpress_field_wrap_end',30 );