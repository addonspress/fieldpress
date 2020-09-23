<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*=====================Core Start=====================*/
/**
 * Check if current page is edit page
 * @since 0.0.1
 *
 * @return boolean
 *
 */
function fieldpress_is_edit_page() {
	/* make sure we are on the backend */
	if ( !is_admin() ){
		return false;
	}
	global $pagenow;
	return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}

/**
 * Find out and set unique fields for different fields provided
 *
 * @since 0.0.1
 *
 * @param array $all_fields
 * @return array
 *
 */
function fieldpress_unique_fields( $all_fields ){
	$unique_fields = array();
	foreach( $all_fields as $field_id => $single_field ){
		if( $single_field['type'] != 'repeater' ){
			$unique_fields[] = $single_field['type'];
		}
		else{
			fieldpress_unique_fields( $single_field['fields'] );
		}
	}
	$unique_fields =  array_unique( $unique_fields );
	return $unique_fields;
}

/**
 * Enqueue style and scripts at admin site based on field type
 *
 * @since 0.0.1
 *
 * @return void
 *
 */
function fieldpress_enqueue_scripts( $all_fields, $unique = false ) {

	$unique_fields = $all_fields;
	if( !$unique ){
		$unique_fields =  fieldpress_unique_fields( $all_fields );
	}

	do_action('fieldpress_enqueue_scripts', $unique_fields);

	wp_enqueue_script( 'underscore' );

	if( in_array('select', $unique_fields ) ){
		wp_enqueue_style('select2', FIELDPRESS_URL . 'assets/frameworks/select2/css/select2'.FIELDPRESS_SCRIPT_PREFIX.'.css', array(), null);
		wp_enqueue_script('select2', FIELDPRESS_URL . 'assets/frameworks/select2/js/select2'.FIELDPRESS_SCRIPT_PREFIX.'.js', array('jquery'), false, true);
	}
	if( in_array('file', $unique_fields) || in_array('image', $unique_fields ) ){
		wp_enqueue_media();
	}
	if( in_array('color', $unique_fields ) ){
		wp_enqueue_style( 'jquery-ui', FIELDPRESS_URL . 'assets/frameworks/jquery-ui/jquery-ui'.FIELDPRESS_SCRIPT_PREFIX.'.css' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}
	if( in_array('date', $unique_fields) || in_array('time', $unique_fields ) || in_array('repeater', $unique_fields ) ){
		wp_enqueue_script( 'jquery-ui-core');
	}
	if( in_array('repeater', $unique_fields ) || in_array('sortable',$unique_fields )){
		wp_enqueue_script( 'jquery-ui-sortable' );
	}
	if( in_array('date', $unique_fields) || in_array('time', $unique_fields ) ){
		wp_enqueue_style( 'jquery-ui', FIELDPRESS_URL . 'assets/frameworks/jquery-ui/jquery-ui'.FIELDPRESS_SCRIPT_PREFIX.'.css' );
	}
	if( in_array('date', $unique_fields ) ){
		wp_enqueue_script( 'jquery-ui-datepicker');
		wp_enqueue_style( 'timepicker-addon', FIELDPRESS_URL . 'assets/frameworks/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon'.FIELDPRESS_SCRIPT_PREFIX.'.css');
		wp_enqueue_script( 'timepicker-addon', FIELDPRESS_URL . 'assets/frameworks/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon'.FIELDPRESS_SCRIPT_PREFIX.'.js', array( 'jquery-ui-slider','jquery-ui-datepicker' ),false,true );

	}
	if( in_array('map', $unique_fields ) ){
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js??key=AIzaSyAsb-vsNWI3ZO-RxEVrpDdeBC5BsRSI_lk', '',false,false );
	}
	if( in_array('wysiwyg', $unique_fields ) ){
		wp_enqueue_media();
		wp_enqueue_editor();
	}

	if( in_array('icon', $unique_fields ) ){
		wp_enqueue_media();/*icon is using default media light-box*/
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
	}

	/*fieldpress style*/
	wp_enqueue_style( 'fieldpress', FIELDPRESS_URL . 'assets/css/fieldpress'.FIELDPRESS_SCRIPT_PREFIX.'.css' );

	/*fieldpress script*/
	wp_enqueue_script( 'fieldpress', FIELDPRESS_URL . 'assets/js/fieldpress'.FIELDPRESS_SCRIPT_PREFIX.'.js', array( 'jquery','jquery-ui-tabs' ), null, true );
	$translation_array = array(
		'FIELDPRESS_URL' => FIELDPRESS_URL,
		'ajaxurl'        => admin_url( 'admin-ajax.php' ),
		'reset_confirm'  => esc_html__('Resetting will reset all the options. Are you sure?','fieldpress')
	);
	wp_localize_script( 'fieldpress', 'fieldpress', $translation_array );
}

/**
 * render field based on field type
 *
 * @since 0.0.1
 * @param string $field_id
 * @param array $field_details
 * @param mixed $field_value
 * @return void
 *
 */
function fieldpress_render_field ( $field_id, $field_details, $field_value ){
	$field_details = apply_filters( 'fieldpress_render_field', $field_details);
	$field_value = apply_filters( 'fieldpress_render_value', $field_value);
	do_action( 'fieldpress_render_field_before', $field_details, $field_value );

	if( !isset($field_details['id'])){
		$field_details['id'] = $field_id;
    }
    if( !isset( $field_details['attr']['id'])){
	    $field_details['attr']['id'] = $field_details['id'];
    }
	if( !isset( $field_details['attr']['name'])){
		$field_details['attr']['name'] = $field_details['id'];
	}


	switch ( $field_details['type'] ) {
		case 'text':
		case 'url':
		case 'number':
		case 'email':
		case 'hidden':
			fieldpress_render_text( $field_details, $field_value );
			break;

		case 'message':
			fieldpress_render_message( $field_details);
			break;

		case 'textarea':
			fieldpress_render_textarea($field_details,$field_value);
			break;

		case 'color':
			fieldpress_render_color($field_details,$field_value);
			break;

		case 'image':
			fieldpress_render_image($field_details,$field_value);
			break;

		case 'gallery':
			fieldpress_render_gallery($field_details,$field_value);
			break;

		case 'file':
			fieldpress_render_file($field_details,$field_value);
			break;

		case 'date':
			fieldpress_render_date($field_details,$field_value);
			break;

		case 'map':
			fieldpress_render_map($field_details,$field_value);
			break;

		case 'checkbox':
			fieldpress_render_checkbox( $field_details,$field_value );
			break;

		case 'switcher':
			fieldpress_render_switcher( $field_details,$field_value );
			break;

		case 'select':
			fieldpress_render_select($field_details,$field_value);
			break;

		case 'radio':
			fieldpress_render_radio($field_details,$field_value);
			break;

		case 'wysiwyg':
			fieldpress_render_wysiwyg($field_details,$field_value);
			break;

		case 'repeater':
			fieldpress_render_repeater( $field_details, $field_value );
			break;

		case 'tabs':
			fieldpress_render_tabs( $field_details, $field_value );
			break;

		case 'icon':
			fieldpress_render_icon( $field_details, $field_value );
			break;

		case 'select-image':
			fieldpress_render_select_image( $field_details, $field_value );
			break;

		case 'sortable':
			fieldpress_render_sortable( $field_details, $field_value );
			break;

		case 'orders':
			fieldpress_render_orders( $field_details, $field_value );
			break;

		case 'accordions':
			fieldpress_render_accordions( $field_details, $field_value );
			break;

		case 'box':
			fieldpress_render_box( $field_details, $field_value );
			break;

		case 'default':
			/*todo*/
			break;
	}

	do_action( 'fieldpress_render_field_after', $field_details, $field_value );
}

/**
 * sanitize field based on field type
 *
 * @since 0.0.1
 * @param array $field_details
 * @param mixed $field_value
 * @return mixed $output sanitize field
 *
 */
function fieldpress_sanitize_field ( $field_details, $field_value){

	if ( isset( $field_details['sanitize_callback'] ) && is_callable( $field_details['sanitize_callback'] ) ) {
		$output = call_user_func( $field_details['sanitize_callback'], $field_value, $field_details );
		return $output;
	}
	switch ($field_details['type']) {

		case 'text':
			$output = fieldpress_sanitize_text_field( $field_value );
			break;

		case 'url':
			$output = fieldpress_sanitize_url( $field_value );
			break;

		case 'image':
			$output = fieldpress_sanitize_positive_integer( $field_value );
			break;

		case 'file':
		case 'gallery':
			$output = fieldpress_sanitize_explode_array( $field_value );
			break;

		case 'number':
			$output = fieldpress_sanitize_number( $field_value );
			break;

		case 'email':
			$output = fieldpress_sanitize_email( $field_value );
			break;

		case 'hidden':
			$output = fieldpress_sanitize_text_field( $field_value );
			break;

		case 'checkbox':
		case 'switcher':
			$output = fieldpress_sanitize_checkbox( $field_value );
			break;

		case 'select':
		case 'radio':
		case 'select-image':
			$output = fieldpress_sanitize_choices( $field_value );
			break;

		case 'message':
			$output = fieldpress_sanitize_allowed_html( $field_value );
			break;

		case 'textarea':
		case 'wysiwyg':
			$output = fieldpress_sanitize_textarea( $field_value );
			break;

		case 'color':
			$output = fieldpress_sanitize_color( $field_value );
			break;

		case 'map':
			$output = fieldpress_sanitize_text_field( $field_value );
			break;

		case 'icon':
			$output = fieldpress_sanitize_text_field( $field_value );
			break;

		case 'sortable':
			$output =  array() ;
			if( is_array( $field_value) ){
				foreach ( $field_value as $key_active_inactive => $active_inactive ){
					foreach ( $active_inactive as $active_inactive_id => $active_inactive_label ){

						$output[$key_active_inactive][$active_inactive_id] = $active_inactive_label;
					}
				}
			}
			break;

		case 'box':

			$output = array();
			if( is_array( $field_value ) ){
				$box_field_id = $field_details['id'];
				foreach ( $field_value as $device_id=> $device_details ){
					foreach( $device_details as $field_id => $field_val ){
						$order_check_field = array(
							'id'  	=> $box_field_id,
							'type'  	=> 'text',
						);
						$inner_output = fieldpress_sanitize_field ( $order_check_field, $field_val );
						$output[$device_id][$field_id] = $inner_output;
                    }

				}
			}
			break;

		case 'orders':
			$output = array();
			$orders = $field_details['orders'];
			$fields =  isset($field_details['fields'])? $field_details['fields'] : array();

			foreach( $orders as $order_id => $accordion_details ){
				$fields[$order_id] =  array(
					'type'  => 'checkbox',
					'order'  => $order_id,

				);
				$fields[$order_id.'-fieldpress-hidden-order'] = array(
					'type'  => 'hidden',
					'order'  => $order_id,
				);
			}


			if( is_array( $field_value ) ){
			    $i = 0;
				foreach ( $field_value as $index_key=> $field_val ){
					foreach( $orders as $order_id => $order_details ){

						foreach ( $field_val as $key=> $val ){

							if( $order_id == $key){
								foreach ( $val as $field_id=> $inner_fields ){
									$actual_value = $field_value[$index_key][$key][$field_id];
									$single_field = $fields[$field_id];
									$single_field['id'] = $field_id;
									$inner_output = fieldpress_sanitize_field ( $single_field, $actual_value );
									$output[$i][$field_id] = $inner_output;

								}
							}


						}
					}
					$i++;
				}
			}
			break;

		case 'repeater':


			$output = array();
			if( is_array( $field_details['fields'] ) ){

				/*adding parent and depth for nested*/
				if( isset($field_details['nested'] ) && true === $field_details['nested'] ){

					$field_details['fields']['fp-parent'] = array(
						'type'  => 'number'
					);
					$field_details['fields']['fp-depth'] = array(
						'type'  => 'number'
					);

					$field_details['fields']['fp-index'] = array(
						'type'  => 'number'
					);
				}

				foreach ( $field_details['fields'] as $field_id => $single_field ){
					if( is_array( $field_value ) ){
						foreach ( $field_value as $key=> $field_val ){
                            if (strpos($key, 'coderRepeaterDepth_') !== false) {
                                continue;
                            }

						    if( isset( $field_val[$field_id] ) ){
							    $actual_value = $field_val[$field_id];
							    $single_field['id'] = $field_id;
							    $inner_output = fieldpress_sanitize_field ( $single_field, $actual_value );
							    $output[$key][$field_id] = $inner_output;
                            }
						}
					}
				}
			}
			break;

		case 'tabs':
		case 'accordions':

		    $fields =  isset($field_details['fields'])? $field_details['fields'] : array();
		    if( $field_details['type'] == 'accordions'  ){
			    $accordions = $field_details['accordions'];
			    foreach( $accordions as $accordion_id => $accordion_details ){
				    if( isset( $accordion_details['checkbox']) && $accordion_details['checkbox'] ){
					    $fields['fp-checkbox'] =  array(
						    'type'  => 'checkbox'
					    );
					    break;
                    }
			    }
		    }

		    $output = array();
            if( is_array( $field_value ) ){
	            $output = $field_value;
	            foreach ( $field_value as $accordion_id => $accordion_fields ){
	                foreach ( $accordion_fields as $field_name => $field_val ){
		                foreach( $fields as $field_id => $field_details ){
			                if( $field_name == $field_id){
				                $actual_value = $field_val;
				                $single_field = $field_details;
				                $single_field['id'] = $field_id;
				                $inner_output = fieldpress_sanitize_field ( $single_field, $actual_value );
				                $output[$accordion_id][$field_id] = $inner_output;
			                }
		                }
                    }
	            }
            }
            break;


		default:
			$output = wp_kses_post( $field_value );
			break;
	}
	return $output;
}

/**
 * choice based on type
 *
 * @since 0.0.1
 * @param string $type
 * @param array $query_args
 * @return array
 *
 */
function fieldpress_get_choices( $type = '', $query_args = array() ) {

	$choices = array();

	switch( $type ) {

		case 'pages':
		case 'page':
		case 'posts':
		case 'post':
			if( 'page'  == $type || 'pages' == $type ){
				$query_args['post_type'] = 'page';
			}
			$posts = get_posts( $query_args );

			if ( ! is_wp_error( $posts ) && ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					$choices[$post->ID] = $post->post_title;
				}
			}

			break;

		case 'categories':
		case 'category':
		case 'tags':
		case 'tag':
		case 'taxonomy':
		case 'taxonomies':

			if( 'category'  == $type || 'categories' == $type ){
				$query_args['taxonomy'] = 'category';
			}
			elseif( 'tag'  == $type || 'tags' == $type ){
				$query_args['taxonomy'] = 'post_tag';
			}
			$tags = get_terms( $query_args );

			if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) {
				foreach ( $tags as $tag ) {
					$choices[$tag->term_id] = $tag->name;
				}
			}

			break;

		case 'callback':

			if( is_callable( $query_args['callback'] ) ) {
				$choices = call_user_func( $query_args['callback'], $query_args);
			}
			break;
	}
	return $choices;
}
/*=====================Core End=====================*/

/*=====================Icons Start=====================*/
/**
 * Font Awesome icons
 * @since 0.0.1
 *
 * @return array
 *
 */
function fieldpress_get_fa_4_icons(){
    return apply_filters('fieldpress_get_fa_4_icons', array(
        'fa fa-glass'                               => 'f000',
        'fa fa-music'                               => 'f001',
        'fa fa-search'                              => 'f002',
        'fa fa-envelope-o'                          => 'f003',
        'fa fa-heart'                               => 'f004',
        'fa fa-star'                                => 'f005',
        'fa fa-star-o'                              => 'f006',
        'fa fa-user'                                => 'f007',
        'fa fa-film'                                => 'f008',
        'fa fa-th-large'                            => 'f009',
        'fa fa-th'                                  => 'f00a',
        'fa fa-th-list'                             => 'f00b',
        'fa fa-check'                               => 'f00c',
        'fa fa-times'                               => 'f00d',
        'fa fa-search-plus'                         => 'f00e',
        'fa fa-search-minus'                        => 'f010',
        'fa fa-power-off'                           => 'f011',
        'fa fa-signal'                              => 'f012',
        'fa fa-cog'                                 => 'f013',
        'fa fa-trash-o'                             => 'f014',
        'fa fa-home'                                => 'f015',
        'fa fa-file-o'                              => 'f016',
        'fa fa-clock-o'                             => 'f017',
        'fa fa-road'                                => 'f018',
        'fa fa-download'                            => 'f019',
        'fa fa-arrow-circle-o-down'                 => 'f01a',
        'fa fa-arrow-circle-o-up'                   => 'f01b',
        'fa fa-inbox'                               => 'f01c',
        'fa fa-play-circle-o'                       => 'f01d',
        'fa fa-repeat'                              => 'f01e',
        'fa fa-refresh'                             => 'f021',
        'fa fa-list-alt'                            => 'f022',
        'fa fa-lock'                                => 'f023',
        'fa fa-flag'                                => 'f024',
        'fa fa-headphones'                          => 'f025',
        'fa fa-volume-off'                          => 'f026',
        'fa fa-volume-down'                         => 'f027',
        'fa fa-volume-up'                           => 'f028',
        'fa fa-qrcode'                              => 'f029',
        'fa fa-barcode'                             => 'f02a',
        'fa fa-tag'                                 => 'f02b',
        'fa fa-tags'                                => 'f02c',
        'fa fa-book'                                => 'f02d',
        'fa fa-bookmark'                            => 'f02e',
        'fa fa-print'                               => 'f02f',
        'fa fa-camera'                              => 'f030',
        'fa fa-font'                                => 'f031',
        'fa fa-bold'                                => 'f032',
        'fa fa-italic'                              => 'f033',
        'fa fa-text-height'                         => 'f034',
        'fa fa-text-width'                          => 'f035',
        'fa fa-align-left'                          => 'f036',
        'fa fa-align-center'                        => 'f037',
        'fa fa-align-right'                         => 'f038',
        'fa fa-align-justify'                       => 'f039',
        'fa fa-list'                                => 'f03a',
        'fa fa-outdent'                             => 'f03b',
        'fa fa-indent'                              => 'f03c',
        'fa fa-video-camera'                        => 'f03d',
        'fa fa-picture-o'                           => 'f03e',
        'fa fa-pencil'                              => 'f040',
        'fa fa-map-marker'                          => 'f041',
        'fa fa-adjust'                              => 'f042',
        'fa fa-tint'                                => 'f043',
        'fa fa-pencil-square-o'                     => 'f044',
        'fa fa-share-square-o'                      => 'f045',
        'fa fa-check-square-o'                      => 'f046',
        'fa fa-arrows'                              => 'f047',
        'fa fa-step-backward'                       => 'f048',
        'fa fa-fast-backward'                       => 'f049',
        'fa fa-backward'                            => 'f04a',
        'fa fa-play'                                => 'f04b',
        'fa fa-pause'                               => 'f04c',
        'fa fa-stop'                                => 'f04d',
        'fa fa-forward'                             => 'f04e',
        'fa fa-fast-forward'                        => 'f050',
        'fa fa-step-forward'                        => 'f051',
        'fa fa-eject'                               => 'f052',
        'fa fa-chevron-left'                        => 'f053',
        'fa fa-chevron-right'                       => 'f054',
        'fa fa-plus-circle'                         => 'f055',
        'fa fa-minus-circle'                        => 'f056',
        'fa fa-times-circle'                        => 'f057',
        'fa fa-check-circle'                        => 'f058',
        'fa fa-question-circle'                     => 'f059',
        'fa fa-info-circle'                         => 'f05a',
        'fa fa-crosshairs'                          => 'f05b',
        'fa fa-times-circle-o'                      => 'f05c',
        'fa fa-check-circle-o'                      => 'f05d',
        'fa fa-ban'                                 => 'f05e',
        'fa fa-arrow-left'                          => 'f060',
        'fa fa-arrow-right'                         => 'f061',
        'fa fa-arrow-up'                            => 'f062',
        'fa fa-arrow-down'                          => 'f063',
        'fa fa-share'                               => 'f064',
        'fa fa-expand'                              => 'f065',
        'fa fa-compress'                            => 'f066',
        'fa fa-plus'                                => 'f067',
        'fa fa-minus'                               => 'f068',
        'fa fa-asterisk'                            => 'f069',
        'fa fa-exclamation-circle'                  => 'f06a',
        'fa fa-gift'                                => 'f06b',
        'fa fa-leaf'                                => 'f06c',
        'fa fa-fire'                                => 'f06d',
        'fa fa-eye'                                 => 'f06e',
        'fa fa-eye-slash'                           => 'f070',
        'fa fa-exclamation-triangle'                => 'f071',
        'fa fa-plane'                               => 'f072',
        'fa fa-calendar'                            => 'f073',
        'fa fa-random'                              => 'f074',
        'fa fa-comment'                             => 'f075',
        'fa fa-magnet'                              => 'f076',
        'fa fa-chevron-up'                          => 'f077',
        'fa fa-chevron-down'                        => 'f078',
        'fa fa-retweet'                             => 'f079',
        'fa fa-shopping-cart'                       => 'f07a',
        'fa fa-folder'                              => 'f07b',
        'fa fa-folder-open'                         => 'f07c',
        'fa fa-arrows-v'                            => 'f07d',
        'fa fa-arrows-h'                            => 'f07e',
        'fa fa-bar-chart'                           => 'f080',
        'fa fa-twitter-square'                      => 'f081',
        'fa fa-facebook-square'                     => 'f082',
        'fa fa-camera-retro'                        => 'f083',
        'fa fa-key'                                 => 'f084',
        'fa fa-cogs'                                => 'f085',
        'fa fa-comments'                            => 'f086',
        'fa fa-thumbs-o-up'                         => 'f087',
        'fa fa-thumbs-o-down'                       => 'f088',
        'fa fa-star-half'                           => 'f089',
        'fa fa-heart-o'                             => 'f08a',
        'fa fa-sign-out'                            => 'f08b',
        'fa fa-linkedin-square'                     => 'f08c',
        'fa fa-thumb-tack'                          => 'f08d',
        'fa fa-external-link'                       => 'f08e',
        'fa fa-sign-in'                             => 'f090',
        'fa fa-trophy'                              => 'f091',
        'fa fa-github-square'                       => 'f092',
        'fa fa-upload'                              => 'f093',
        'fa fa-lemon-o'                             => 'f094',
        'fa fa-phone'                               => 'f095',
        'fa fa-square-o'                            => 'f096',
        'fa fa-bookmark-o'                          => 'f097',
        'fa fa-phone-square'                        => 'f098',
        'fa fa-twitter'                             => 'f099',
        'fa fa-facebook'                            => 'f09a',
        'fa fa-github'                              => 'f09b',
        'fa fa-unlock'                              => 'f09c',
        'fa fa-credit-card'                         => 'f09d',
        'fa fa-rss'                                 => 'f09e',
        'fa fa-hdd-o'                               => 'f0a0',
        'fa fa-bullhorn'                            => 'f0a1',
        'fa fa-bell'                                => 'f0f3',
        'fa fa-certificate'                         => 'f0a3',
        'fa fa-hand-o-right'                        => 'f0a4',
        'fa fa-hand-o-left'                         => 'f0a5',
        'fa fa-hand-o-up'                           => 'f0a6',
        'fa fa-hand-o-down'                         => 'f0a7',
        'fa fa-arrow-circle-left'                   => 'f0a8',
        'fa fa-arrow-circle-right'                  => 'f0a9',
        'fa fa-arrow-circle-up'                     => 'f0aa',
        'fa fa-arrow-circle-down'                   => 'f0ab',
        'fa fa-globe'                               => 'f0ac',
        'fa fa-wrench'                              => 'f0ad',
        'fa fa-tasks'                               => 'f0ae',
        'fa fa-filter'                              => 'f0b0',
        'fa fa-briefcase'                           => 'f0b1',
        'fa fa-arrows-alt'                          => 'f0b2',
        'fa fa-users'                               => 'f0c0',
        'fa fa-link'                                => 'f0c1',
        'fa fa-cloud'                               => 'f0c2',
        'fa fa-flask'                               => 'f0c3',
        'fa fa-scissors'                            => 'f0c4',
        'fa fa-files-o'                             => 'f0c5',
        'fa fa-paperclip'                           => 'f0c6',
        'fa fa-floppy-o'                            => 'f0c7',
        'fa fa-square'                              => 'f0c8',
        'fa fa-bars'                                => 'f0c9',
        'fa fa-list-ul'                             => 'f0ca',
        'fa fa-list-ol'                             => 'f0cb',
        'fa fa-strikethrough'                       => 'f0cc',
        'fa fa-underline'                           => 'f0cd',
        'fa fa-table'                               => 'f0ce',
        'fa fa-magic'                               => 'f0d0',
        'fa fa-truck'                               => 'f0d1',
        'fa fa-pinterest'                           => 'f0d2',
        'fa fa-pinterest-square'                    => 'f0d3',
        'fa fa-google-plus-square'                  => 'f0d4',
        'fa fa-google-plus'                         => 'f0d5',
        'fa fa-money'                               => 'f0d6',
        'fa fa-caret-down'                          => 'f0d7',
        'fa fa-caret-up'                            => 'f0d8',
        'fa fa-caret-left'                          => 'f0d9',
        'fa fa-caret-right'                         => 'f0da',
        'fa fa-columns'                             => 'f0db',
        'fa fa-sort'                                => 'f0dc',
        'fa fa-sort-desc'                           => 'f0dd',
        'fa fa-sort-asc'                            => 'f0de',
        'fa fa-envelope'                            => 'f0e0',
        'fa fa-linkedin'                            => 'f0e1',
        'fa fa-undo'                                => 'f0e2',
        'fa fa-gavel'                               => 'f0e3',
        'fa fa-tachometer'                          => 'f0e4',
        'fa fa-comment-o'                           => 'f0e5',
        'fa fa-comments-o'                          => 'f0e6',
        'fa fa-bolt'                                => 'f0e7',
        'fa fa-sitemap'                             => 'f0e8',
        'fa fa-umbrella'                            => 'f0e9',
        'fa fa-clipboard'                           => 'f0ea',
        'fa fa-lightbulb-o'                         => 'f0eb',
        'fa fa-exchange'                            => 'f0ec',
        'fa fa-cloud-download'                      => 'f0ed',
        'fa fa-cloud-upload'                        => 'f0ee',
        'fa fa-user-md'                             => 'f0f0',
        'fa fa-stethoscope'                         => 'f0f1',
        'fa fa-suitcase'                            => 'f0f2',
        'fa fa-bell-o'                              => 'f0a2',
        'fa fa-coffee'                              => 'f0f4',
        'fa fa-cutlery'                             => 'f0f5',
        'fa fa-file-text-o'                         => 'f0f6',
        'fa fa-building-o'                          => 'f0f7',
        'fa fa-hospital-o'                          => 'f0f8',
        'fa fa-ambulance'                           => 'f0f9',
        'fa fa-medkit'                              => 'f0fa',
        'fa fa-fighter-jet'                         => 'f0fb',
        'fa fa-beer'                                => 'f0fc',
        'fa fa-h-square'                            => 'f0fd',
        'fa fa-plus-square'                         => 'f0fe',
        'fa fa-angle-double-left'                   => 'f100',
        'fa fa-angle-double-right'                  => 'f101',
        'fa fa-angle-double-up'                     => 'f102',
        'fa fa-angle-double-down'                   => 'f103',
        'fa fa-angle-left'                          => 'f104',
        'fa fa-angle-right'                         => 'f105',
        'fa fa-angle-up'                            => 'f106',
        'fa fa-angle-down'                          => 'f107',
        'fa fa-desktop'                             => 'f108',
        'fa fa-laptop'                              => 'f109',
        'fa fa-tablet'                              => 'f10a',
        'fa fa-mobile'                              => 'f10b',
        'fa fa-circle-o'                            => 'f10c',
        'fa fa-quote-left'                          => 'f10d',
        'fa fa-quote-right'                         => 'f10e',
        'fa fa-spinner'                             => 'f110',
        'fa fa-circle'                              => 'f111',
        'fa fa-reply'                               => 'f112',
        'fa fa-github-alt'                          => 'f113',
        'fa fa-folder-o'                            => 'f114',
        'fa fa-folder-open-o'                       => 'f115',
        'fa fa-smile-o'                             => 'f118',
        'fa fa-frown-o'                             => 'f119',
        'fa fa-meh-o'                               => 'f11a',
        'fa fa-gamepad'                             => 'f11b',
        'fa fa-keyboard-o'                          => 'f11c',
        'fa fa-flag-o'                              => 'f11d',
        'fa fa-flag-checkered'                      => 'f11e',
        'fa fa-terminal'                            => 'f120',
        'fa fa-code'                                => 'f121',
        'fa fa-reply-all'                           => 'f122',
        'fa fa-star-half-o'                         => 'f123',
        'fa fa-location-arrow'                      => 'f124',
        'fa fa-crop'                                => 'f125',
        'fa fa-code-fork'                           => 'f126',
        'fa fa-chain-broken'                        => 'f127',
        'fa fa-question'                            => 'f128',
        'fa fa-info'                                => 'f129',
        'fa fa-exclamation'                         => 'f12a',
        'fa fa-superscript'                         => 'f12b',
        'fa fa-subscript'                           => 'f12c',
        'fa fa-eraser'                              => 'f12d',
        'fa fa-puzzle-piece'                        => 'f12e',
        'fa fa-microphone'                          => 'f130',
        'fa fa-microphone-slash'                    => 'f131',
        'fa fa-shield'                              => 'f132',
        'fa fa-calendar-o'                          => 'f133',
        'fa fa-fire-extinguisher'                   => 'f134',
        'fa fa-rocket'                              => 'f135',
        'fa fa-maxcdn'                              => 'f136',
        'fa fa-chevron-circle-left'                 => 'f137',
        'fa fa-chevron-circle-right'                => 'f138',
        'fa fa-chevron-circle-up'                   => 'f139',
        'fa fa-chevron-circle-down'                 => 'f13a',
        'fa fa-html5'                               => 'f13b',
        'fa fa-css3'                                => 'f13c',
        'fa fa-anchor'                              => 'f13d',
        'fa fa-unlock-alt'                          => 'f13e',
        'fa fa-bullseye'                            => 'f140',
        'fa fa-ellipsis-h'                          => 'f141',
        'fa fa-ellipsis-v'                          => 'f142',
        'fa fa-rss-square'                          => 'f143',
        'fa fa-play-circle'                         => 'f144',
        'fa fa-ticket'                              => 'f145',
        'fa fa-minus-square'                        => 'f146',
        'fa fa-minus-square-o'                      => 'f147',
        'fa fa-level-up'                            => 'f148',
        'fa fa-level-down'                          => 'f149',
        'fa fa-check-square'                        => 'f14a',
        'fa fa-pencil-square'                       => 'f14b',
        'fa fa-external-link-square'                => 'f14c',
        'fa fa-share-square'                        => 'f14d',
        'fa fa-compass'                             => 'f14e',
        'fa fa-caret-square-o-down'                 => 'f150',
        'fa fa-caret-square-o-up'                   => 'f151',
        'fa fa-caret-square-o-right'                => 'f152',
        'fa fa-eur'                                 => 'f153',
        'fa fa-gbp'                                 => 'f154',
        'fa fa-usd'                                 => 'f155',
        'fa fa-inr'                                 => 'f156',
        'fa fa-jpy'                                 => 'f157',
        'fa fa-rub'                                 => 'f158',
        'fa fa-krw'                                 => 'f159',
        'fa fa-btc'                                 => 'f15a',
        'fa fa-file'                                => 'f15b',
        'fa fa-file-text'                           => 'f15c',
        'fa fa-sort-alpha-asc'                      => 'f15d',
        'fa fa-sort-alpha-desc'                     => 'f15e',
        'fa fa-sort-amount-asc'                     => 'f160',
        'fa fa-sort-amount-desc'                    => 'f161',
        'fa fa-sort-numeric-asc'                    => 'f162',
        'fa fa-sort-numeric-desc'                   => 'f163',
        'fa fa-thumbs-up'                           => 'f164',
        'fa fa-thumbs-down'                         => 'f165',
        'fa fa-youtube-square'                      => 'f166',
        'fa fa-youtube'                             => 'f167',
        'fa fa-xing'                                => 'f168',
        'fa fa-xing-square'                         => 'f169',
        'fa fa-youtube-play'                        => 'f16a',
        'fa fa-dropbox'                             => 'f16b',
        'fa fa-stack-overflow'                      => 'f16c',
        'fa fa-instagram'                           => 'f16d',
        'fa fa-flickr'                              => 'f16e',
        'fa fa-adn'                                 => 'f170',
        'fa fa-bitbucket'                           => 'f171',
        'fa fa-bitbucket-square'                    => 'f172',
        'fa fa-tumblr'                              => 'f173',
        'fa fa-tumblr-square'                       => 'f174',
        'fa fa-long-arrow-down'                     => 'f175',
        'fa fa-long-arrow-up'                       => 'f176',
        'fa fa-long-arrow-left'                     => 'f177',
        'fa fa-long-arrow-right'                    => 'f178',
        'fa fa-apple'                               => 'f179',
        'fa fa-windows'                             => 'f17a',
        'fa fa-android'                             => 'f17b',
        'fa fa-linux'                               => 'f17c',
        'fa fa-dribbble'                            => 'f17d',
        'fa fa-skype'                               => 'f17e',
        'fa fa-foursquare'                          => 'f180',
        'fa fa-trello'                              => 'f181',
        'fa fa-female'                              => 'f182',
        'fa fa-male'                                => 'f183',
        'fa fa-gratipay'                            => 'f184',
        'fa fa-sun-o'                               => 'f185',
        'fa fa-moon-o'                              => 'f186',
        'fa fa-archive'                             => 'f187',
        'fa fa-bug'                                 => 'f188',
        'fa fa-vk'                                  => 'f189',
        'fa fa-weibo'                               => 'f18a',
        'fa fa-renren'                              => 'f18b',
        'fa fa-pagelines'                           => 'f18c',
        'fa fa-stack-exchange'                      => 'f18d',
        'fa fa-arrow-circle-o-right'                => 'f18e',
        'fa fa-arrow-circle-o-left'                 => 'f190',
        'fa fa-caret-square-o-left'                 => 'f191',
        'fa fa-dot-circle-o'                        => 'f192',
        'fa fa-wheelchair'                          => 'f193',
        'fa fa-vimeo-square'                        => 'f194',
        'fa fa-try'                                 => 'f195',
        'fa fa-plus-square-o'                       => 'f196',
        'fa fa-space-shuttle'                       => 'f197',
        'fa fa-slack'                               => 'f198',
        'fa fa-envelope-square'                     => 'f199',
        'fa fa-wordpress'                           => 'f19a',
        'fa fa-openid'                              => 'f19b',
        'fa fa-university'                          => 'f19c',
        'fa fa-graduation-cap'                      => 'f19d',
        'fa fa-yahoo'                               => 'f19e',
        'fa fa-google'                              => 'f1a0',
        'fa fa-reddit'                              => 'f1a1',
        'fa fa-reddit-square'                       => 'f1a2',
        'fa fa-stumbleupon-circle'                  => 'f1a3',
        'fa fa-stumbleupon'                         => 'f1a4',
        'fa fa-delicious'                           => 'f1a5',
        'fa fa-digg'                                => 'f1a6',
        'fa fa-pied-piper-pp'                       => 'f1a7',
        'fa fa-pied-piper-alt'                      => 'f1a8',
        'fa fa-drupal'                              => 'f1a9',
        'fa fa-joomla'                              => 'f1aa',
        'fa fa-language'                            => 'f1ab',
        'fa fa-fax'                                 => 'f1ac',
        'fa fa-building'                            => 'f1ad',
        'fa fa-child'                               => 'f1ae',
        'fa fa-paw'                                 => 'f1b0',
        'fa fa-spoon'                               => 'f1b1',
        'fa fa-cube'                                => 'f1b2',
        'fa fa-cubes'                               => 'f1b3',
        'fa fa-behance'                             => 'f1b4',
        'fa fa-behance-square'                      => 'f1b5',
        'fa fa-steam'                               => 'f1b6',
        'fa fa-steam-square'                        => 'f1b7',
        'fa fa-recycle'                             => 'f1b8',
        'fa fa-car'                                 => 'f1b9',
        'fa fa-taxi'                                => 'f1ba',
        'fa fa-tree'                                => 'f1bb',
        'fa fa-spotify'                             => 'f1bc',
        'fa fa-deviantart'                          => 'f1bd',
        'fa fa-soundcloud'                          => 'f1be',
        'fa fa-database'                            => 'f1c0',
        'fa fa-file-pdf-o'                          => 'f1c1',
        'fa fa-file-word-o'                         => 'f1c2',
        'fa fa-file-excel-o'                        => 'f1c3',
        'fa fa-file-powerpoint-o'                   => 'f1c4',
        'fa fa-file-image-o'                        => 'f1c5',
        'fa fa-file-archive-o'                      => 'f1c6',
        'fa fa-file-audio-o'                        => 'f1c7',
        'fa fa-file-video-o'                        => 'f1c8',
        'fa fa-file-code-o'                         => 'f1c9',
        'fa fa-vine'                                => 'f1ca',
        'fa fa-codepen'                             => 'f1cb',
        'fa fa-jsfiddle'                            => 'f1cc',
        'fa fa-life-ring'                           => 'f1cd',
        'fa fa-circle-o-notch'                      => 'f1ce',
        'fa fa-rebel'                               => 'f1d0',
        'fa fa-empire'                              => 'f1d1',
        'fa fa-git-square'                          => 'f1d2',
        'fa fa-git'                                 => 'f1d3',
        'fa fa-hacker-news'                         => 'f1d4',
        'fa fa-tencent-weibo'                       => 'f1d5',
        'fa fa-qq'                                  => 'f1d6',
        'fa fa-weixin'                              => 'f1d7',
        'fa fa-paper-plane'                         => 'f1d8',
        'fa fa-paper-plane-o'                       => 'f1d9',
        'fa fa-history'                             => 'f1da',
        'fa fa-circle-thin'                         => 'f1db',
        'fa fa-header'                              => 'f1dc',
        'fa fa-paragraph'                           => 'f1dd',
        'fa fa-sliders'                             => 'f1de',
        'fa fa-share-alt'                           => 'f1e0',
        'fa fa-share-alt-square'                    => 'f1e1',
        'fa fa-bomb'                                => 'f1e2',
        'fa fa-futbol-o'                            => 'f1e3',
        'fa fa-tty'                                 => 'f1e4',
        'fa fa-binoculars'                          => 'f1e5',
        'fa fa-plug'                                => 'f1e6',
        'fa fa-slideshare'                          => 'f1e7',
        'fa fa-twitch'                              => 'f1e8',
        'fa fa-yelp'                                => 'f1e9',
        'fa fa-newspaper-o'                         => 'f1ea',
        'fa fa-wifi'                                => 'f1eb',
        'fa fa-calculator'                          => 'f1ec',
        'fa fa-paypal'                              => 'f1ed',
        'fa fa-google-wallet'                       => 'f1ee',
        'fa fa-cc-visa'                             => 'f1f0',
        'fa fa-cc-mastercard'                       => 'f1f1',
        'fa fa-cc-discover'                         => 'f1f2',
        'fa fa-cc-amex'                             => 'f1f3',
        'fa fa-cc-paypal'                           => 'f1f4',
        'fa fa-cc-stripe'                           => 'f1f5',
        'fa fa-bell-slash'                          => 'f1f6',
        'fa fa-bell-slash-o'                        => 'f1f7',
        'fa fa-trash'                               => 'f1f8',
        'fa fa-copyright'                           => 'f1f9',
        'fa fa-at'                                  => 'f1fa',
        'fa fa-eyedropper'                          => 'f1fb',
        'fa fa-paint-brush'                         => 'f1fc',
        'fa fa-birthday-cake'                       => 'f1fd',
        'fa fa-area-chart'                          => 'f1fe',
        'fa fa-pie-chart'                           => 'f200',
        'fa fa-line-chart'                          => 'f201',
        'fa fa-lastfm'                              => 'f202',
        'fa fa-lastfm-square'                       => 'f203',
        'fa fa-toggle-off'                          => 'f204',
        'fa fa-toggle-on'                           => 'f205',
        'fa fa-bicycle'                             => 'f206',
        'fa fa-bus'                                 => 'f207',
        'fa fa-ioxhost'                             => 'f208',
        'fa fa-angellist'                           => 'f209',
        'fa fa-cc'                                  => 'f20a',
        'fa fa-ils'                                 => 'f20b',
        'fa fa-meanpath'                            => 'f20c',
        'fa fa-buysellads'                          => 'f20d',
        'fa fa-connectdevelop'                      => 'f20e',
        'fa fa-dashcube'                            => 'f210',
        'fa fa-forumbee'                            => 'f211',
        'fa fa-leanpub'                             => 'f212',
        'fa fa-sellsy'                              => 'f213',
        'fa fa-shirtsinbulk'                        => 'f214',
        'fa fa-simplybuilt'                         => 'f215',
        'fa fa-skyatlas'                            => 'f216',
        'fa fa-cart-plus'                           => 'f217',
        'fa fa-cart-arrow-down'                     => 'f218',
        'fa fa-diamond'                             => 'f219',
        'fa fa-ship'                                => 'f21a',
        'fa fa-user-secret'                         => 'f21b',
        'fa fa-motorcycle'                          => 'f21c',
        'fa fa-street-view'                         => 'f21d',
        'fa fa-heartbeat'                           => 'f21e',
        'fa fa-venus'                               => 'f221',
        'fa fa-mars'                                => 'f222',
        'fa fa-mercury'                             => 'f223',
        'fa fa-transgender'                         => 'f224',
        'fa fa-transgender-alt'                     => 'f225',
        'fa fa-venus-double'                        => 'f226',
        'fa fa-mars-double'                         => 'f227',
        'fa fa-venus-mars'                          => 'f228',
        'fa fa-mars-stroke'                         => 'f229',
        'fa fa-mars-stroke-v'                       => 'f22a',
        'fa fa-mars-stroke-h'                       => 'f22b',
        'fa fa-neuter'                              => 'f22c',
        'fa fa-genderless'                          => 'f22d',
        'fa fa-facebook-official'                   => 'f230',
        'fa fa-pinterest-p'                         => 'f231',
        'fa fa-whatsapp'                            => 'f232',
        'fa fa-server'                              => 'f233',
        'fa fa-user-plus'                           => 'f234',
        'fa fa-user-times'                          => 'f235',
        'fa fa-bed'                                 => 'f236',
        'fa fa-viacoin'                             => 'f237',
        'fa fa-train'                               => 'f238',
        'fa fa-subway'                              => 'f239',
        'fa fa-medium'                              => 'f23a',
        'fa fa-y-combinator'                        => 'f23b',
        'fa fa-optin-monster'                       => 'f23c',
        'fa fa-opencart'                            => 'f23d',
        'fa fa-expeditedssl'                        => 'f23e',
        'fa fa-battery-full'                        => 'f240',
        'fa fa-battery-three-quarters'              => 'f241',
        'fa fa-battery-half'                        => 'f242',
        'fa fa-battery-quarter'                     => 'f243',
        'fa fa-battery-empty'                       => 'f244',
        'fa fa-mouse-pointer'                       => 'f245',
        'fa fa-i-cursor'                            => 'f246',
        'fa fa-object-group'                        => 'f247',
        'fa fa-object-ungroup'                      => 'f248',
        'fa fa-sticky-note'                         => 'f249',
        'fa fa-sticky-note-o'                       => 'f24a',
        'fa fa-cc-jcb'                              => 'f24b',
        'fa fa-cc-diners-club'                      => 'f24c',
        'fa fa-clone'                               => 'f24d',
        'fa fa-balance-scale'                       => 'f24e',
        'fa fa-hourglass-o'                         => 'f250',
        'fa fa-hourglass-start'                     => 'f251',
        'fa fa-hourglass-half'                      => 'f252',
        'fa fa-hourglass-end'                       => 'f253',
        'fa fa-hourglass'                           => 'f254',
        'fa fa-hand-rock-o'                         => 'f255',
        'fa fa-hand-paper-o'                        => 'f256',
        'fa fa-hand-scissors-o'                     => 'f257',
        'fa fa-hand-lizard-o'                       => 'f258',
        'fa fa-hand-spock-o'                        => 'f259',
        'fa fa-hand-pointer-o'                      => 'f25a',
        'fa fa-hand-peace-o'                        => 'f25b',
        'fa fa-trademark'                           => 'f25c',
        'fa fa-registered'                          => 'f25d',
        'fa fa-creative-commons'                    => 'f25e',
        'fa fa-gg'                                  => 'f260',
        'fa fa-gg-circle'                           => 'f261',
        'fa fa-tripadvisor'                         => 'f262',
        'fa fa-odnoklassniki'                       => 'f263',
        'fa fa-odnoklassniki-square'                => 'f264',
        'fa fa-get-pocket'                          => 'f265',
        'fa fa-wikipedia-w'                         => 'f266',
        'fa fa-safari'                              => 'f267',
        'fa fa-chrome'                              => 'f268',
        'fa fa-firefox'                             => 'f269',
        'fa fa-opera'                               => 'f26a',
        'fa fa-internet-explorer'                   => 'f26b',
        'fa fa-television'                          => 'f26c',
        'fa fa-contao'                              => 'f26d',
        'fa fa-500px'                               => 'f26e',
        'fa fa-amazon'                              => 'f270',
        'fa fa-calendar-plus-o'                     => 'f271',
        'fa fa-calendar-minus-o'                    => 'f272',
        'fa fa-calendar-times-o'                    => 'f273',
        'fa fa-calendar-check-o'                    => 'f274',
        'fa fa-industry'                            => 'f275',
        'fa fa-map-pin'                             => 'f276',
        'fa fa-map-signs'                           => 'f277',
        'fa fa-map-o'                               => 'f278',
        'fa fa-map'                                 => 'f279',
        'fa fa-commenting'                          => 'f27a',
        'fa fa-commenting-o'                        => 'f27b',
        'fa fa-houzz'                               => 'f27c',
        'fa fa-vimeo'                               => 'f27d',
        'fa fa-black-tie'                           => 'f27e',
        'fa fa-fonticons'                           => 'f280',
        'fa fa-reddit-alien'                        => 'f281',
        'fa fa-edge'                                => 'f282',
        'fa fa-credit-card-alt'                     => 'f283',
        'fa fa-codiepie'                            => 'f284',
        'fa fa-modx'                                => 'f285',
        'fa fa-fort-awesome'                        => 'f286',
        'fa fa-usb'                                 => 'f287',
        'fa fa-product-hunt'                        => 'f288',
        'fa fa-mixcloud'                            => 'f289',
        'fa fa-scribd'                              => 'f28a',
        'fa fa-pause-circle'                        => 'f28b',
        'fa fa-pause-circle-o'                      => 'f28c',
        'fa fa-stop-circle'                         => 'f28d',
        'fa fa-stop-circle-o'                       => 'f28e',
        'fa fa-shopping-bag'                        => 'f290',
        'fa fa-shopping-basket'                     => 'f291',
        'fa fa-hashtag'                             => 'f292',
        'fa fa-bluetooth'                           => 'f293',
        'fa fa-bluetooth-b'                         => 'f294',
        'fa fa-percent'                             => 'f295',
        'fa fa-gitlab'                              => 'f296',
        'fa fa-wpbeginner'                          => 'f297',
        'fa fa-wpforms'                             => 'f298',
        'fa fa-envira'                              => 'f299',
        'fa fa-universal-access'                    => 'f29a',
        'fa fa-wheelchair-alt'                      => 'f29b',
        'fa fa-question-circle-o'                   => 'f29c',
        'fa fa-blind'                               => 'f29d',
        'fa fa-audio-description'                   => 'f29e',
        'fa fa-volume-control-phone'                => 'f2a0',
        'fa fa-braille'                             => 'f2a1',
        'fa fa-assistive-listening-systems'         => 'f2a2',
        'fa fa-american-sign-language-interpreting' => 'f2a3',
        'fa fa-deaf'                                => 'f2a4',
        'fa fa-glide'                               => 'f2a5',
        'fa fa-glide-g'                             => 'f2a6',
        'fa fa-sign-language'                       => 'f2a7',
        'fa fa-low-vision'                          => 'f2a8',
        'fa fa-viadeo'                              => 'f2a9',
        'fa fa-viadeo-square'                       => 'f2aa',
        'fa fa-snapchat'                            => 'f2ab',
        'fa fa-snapchat-ghost'                      => 'f2ac',
        'fa fa-snapchat-square'                     => 'f2ad',
        'fa fa-pied-piper'                          => 'f2ae',
        'fa fa-first-order'                         => 'f2b0',
        'fa fa-yoast'                               => 'f2b1',
        'fa fa-themeisle'                           => 'f2b2',
        'fa fa-google-plus-official'                => 'f2b3',
        'fa fa-font-awesome'                        => 'f2b4',
        'fa fa-handshake-o'                         => 'f2b5',
        'fa fa-envelope-open'                       => 'f2b6',
        'fa fa-envelope-open-o'                     => 'f2b7',
        'fa fa-linode'                              => 'f2b8',
        'fa fa-address-book'                        => 'f2b9',
        'fa fa-address-book-o'                      => 'f2ba',
        'fa fa-address-card'                        => 'f2bb',
        'fa fa-address-card-o'                      => 'f2bc',
        'fa fa-user-circle'                         => 'f2bd',
        'fa fa-user-circle-o'                       => 'f2be',
        'fa fa-user-o'                              => 'f2c0',
        'fa fa-id-badge'                            => 'f2c1',
        'fa fa-id-card'                             => 'f2c2',
        'fa fa-id-card-o'                           => 'f2c3',
        'fa fa-quora'                               => 'f2c4',
        'fa fa-free-code-camp'                      => 'f2c5',
        'fa fa-telegram'                            => 'f2c6',
        'fa fa-thermometer-full'                    => 'f2c7',
        'fa fa-thermometer-three-quarters'          => 'f2c8',
        'fa fa-thermometer-half'                    => 'f2c9',
        'fa fa-thermometer-quarter'                 => 'f2ca',
        'fa fa-thermometer-empty'                   => 'f2cb',
        'fa fa-shower'                              => 'f2cc',
        'fa fa-bath'                                => 'f2cd',
        'fa fa-podcast'                             => 'f2ce',
        'fa fa-window-maximize'                     => 'f2d0',
        'fa fa-window-minimize'                     => 'f2d1',
        'fa fa-window-restore'                      => 'f2d2',
        'fa fa-window-close'                        => 'f2d3',
        'fa fa-window-close-o'                      => 'f2d4',
        'fa fa-bandcamp'                            => 'f2d5',
        'fa fa-grav'                                => 'f2d6',
        'fa fa-etsy'                                => 'f2d7',
        'fa fa-imdb'                                => 'f2d8',
        'fa fa-ravelry'                             => 'f2d9',
        'fa fa-eercast'                             => 'f2da',
        'fa fa-microchip'                           => 'f2db',
        'fa fa-snowflake-o'                         => 'f2dc',
        'fa fa-superpowers'                         => 'f2dd',
        'fa fa-wpexplorer'                          => 'f2de',
        'fa fa-meetup'                              => 'f2e0'
    ));
}

function fieldpress_get_fa_5_icons(){
    return apply_filters('fieldpress_get_fa_5_icons', array(
        'fas fa-address-book'                        => 'f2b9',
        'fas fa-address-card'                        => 'f2bb',
        'fas fa-adjust'                              => 'f042',
        'fas fa-align-center'                        => 'f037',
        'fas fa-align-justify'                       => 'f039',
        'fas fa-align-left'                          => 'f036',
        'fas fa-align-right'                         => 'f038',
        'fas fa-allergies'                           => 'f461',
        'fas fa-ambulance'                           => 'f0f9',
        'fas fa-american-sign-language-interpreting' => 'f2a3',
        'fas fa-anchor'                              => 'f13d',
        'fas fa-angle-double-down'                   => 'f103',
        'fas fa-angle-double-left'                   => 'f100',
        'fas fa-angle-double-right'                  => 'f101',
        'fas fa-angle-double-up'                     => 'f102',
        'fas fa-angle-down'                          => 'f107',
        'fas fa-angle-left'                          => 'f104',
        'fas fa-angle-right'                         => 'f105',
        'fas fa-angle-up'                            => 'f106',
        'fas fa-archive'                             => 'f187',
        'fas fa-arrow-alt-circle-down'               => 'f358',
        'fas fa-arrow-alt-circle-left'               => 'f359',
        'fas fa-arrow-alt-circle-right'              => 'f35a',
        'fas fa-arrow-alt-circle-up'                 => 'f35b',
        'fas fa-arrow-circle-down'                   => 'f0ab',
        'fas fa-arrow-circle-left'                   => 'f0a8',
        'fas fa-arrow-circle-right'                  => 'f0a9',
        'fas fa-arrow-circle-up'                     => 'f0aa',
        'fas fa-arrow-down'                          => 'f063',
        'fas fa-arrow-left'                          => 'f060',
        'fas fa-arrow-right'                         => 'f061',
        'fas fa-arrow-up'                            => 'f062',
        'fas fa-arrows-alt'                          => 'f0b2',
        'fas fa-arrows-alt-h'                        => 'f337',
        'fas fa-arrows-alt-v'                        => 'f338',
        'fas fa-assistive-listening-systems'         => 'f2a2',
        'fas fa-asterisk'                            => 'f069',
        'fas fa-at'                                  => 'f1fa',
        'fas fa-audio-description'                   => 'f29e',
        'fas fa-backward'                            => 'f04a',
        'fas fa-balance-scale'                       => 'f24e',
        'fas fa-ban'                                 => 'f05e',
        'fas fa-band-aid'                            => 'f462',
        'fas fa-barcode'                             => 'f02a',
        'fas fa-bars'                                => 'f0c9',
        'fas fa-baseball-ball'                       => 'f433',
        'fas fa-basketball-ball'                     => 'f434',
        'fas fa-bath'                                => 'f2cd',
        'fas fa-battery-empty'                       => 'f244',
        'fas fa-battery-full'                        => 'f240',
        'fas fa-battery-half'                        => 'f242',
        'fas fa-battery-quarter'                     => 'f243',
        'fas fa-battery-three-quarters'              => 'f241',
        'fas fa-bed'                                 => 'f236',
        'fas fa-beer'                                => 'f0fc',
        'fas fa-bell'                                => 'f0f3',
        'fas fa-bell-slash'                          => 'f1f6',
        'fas fa-bicycle'                             => 'f206',
        'fas fa-binoculars'                          => 'f1e5',
        'fas fa-birthday-cake'                       => 'f1fd',
        'fas fa-blender'                             => 'f517',
        'fas fa-blind'                               => 'f29d',
        'fas fa-bold'                                => 'f032',
        'fas fa-bolt'                                => 'f0e7',
        'fas fa-bomb'                                => 'f1e2',
        'fas fa-book'                                => 'f02d',
        'fas fa-book-open'                           => 'f518',
        'fas fa-bookmark'                            => 'f02e',
        'fas fa-bowling-ball'                        => 'f436',
        'fas fa-box'                                 => 'f466',
        'fas fa-box-open'                            => 'f49e',
        'fas fa-boxes'                               => 'f468',
        'fas fa-braille'                             => 'f2a1',
        'fas fa-briefcase'                           => 'f0b1',
        'fas fa-briefcase-medical'                   => 'f469',
        'fas fa-broadcast-tower'                     => 'f519',
        'fas fa-broom'                               => 'f51a',
        'fas fa-bug'                                 => 'f188',
        'fas fa-building'                            => 'f1ad',
        'fas fa-bullhorn'                            => 'f0a1',
        'fas fa-bullseye'                            => 'f140',
        'fas fa-burn'                                => 'f46a',
        'fas fa-bus'                                 => 'f207',
        'fas fa-calculator'                          => 'f1ec',
        'fas fa-calendar'                            => 'f133',
        'fas fa-calendar-alt'                        => 'f073',
        'fas fa-calendar-check'                      => 'f274',
        'fas fa-calendar-minus'                      => 'f272',
        'fas fa-calendar-plus'                       => 'f271',
        'fas fa-calendar-times'                      => 'f273',
        'fas fa-camera'                              => 'f030',
        'fas fa-camera-retro'                        => 'f083',
        'fas fa-capsules'                            => 'f46b',
        'fas fa-car'                                 => 'f1b9',
        'fas fa-caret-down'                          => 'f0d7',
        'fas fa-caret-left'                          => 'f0d9',
        'fas fa-caret-right'                         => 'f0da',
        'fas fa-caret-square-down'                   => 'f150',
        'fas fa-caret-square-left'                   => 'f191',
        'fas fa-caret-square-right'                  => 'f152',
        'fas fa-caret-square-up'                     => 'f151',
        'fas fa-caret-up'                            => 'f0d8',
        'fas fa-cart-arrow-down'                     => 'f218',
        'fas fa-cart-plus'                           => 'f217',
        'fas fa-certificate'                         => 'f0a3',
        'fas fa-chalkboard'                          => 'f51b',
        'fas fa-chalkboard-teacher'                  => 'f51c',
        'fas fa-chart-area'                          => 'f1fe',
        'fas fa-chart-bar'                           => 'f080',
        'fas fa-chart-line'                          => 'f201',
        'fas fa-chart-pie'                           => 'f200',
        'fas fa-check'                               => 'f00c',
        'fas fa-check-circle'                        => 'f058',
        'fas fa-check-square'                        => 'f14a',
        'fas fa-chess'                               => 'f439',
        'fas fa-chess-bishop'                        => 'f43a',
        'fas fa-chess-board'                         => 'f43c',
        'fas fa-chess-king'                          => 'f43f',
        'fas fa-chess-knight'                        => 'f441',
        'fas fa-chess-pawn'                          => 'f443',
        'fas fa-chess-queen'                         => 'f445',
        'fas fa-chess-rook'                          => 'f447',
        'fas fa-chevron-circle-down'                 => 'f13a',
        'fas fa-chevron-circle-left'                 => 'f137',
        'fas fa-chevron-circle-right'                => 'f138',
        'fas fa-chevron-circle-up'                   => 'f139',
        'fas fa-chevron-down'                        => 'f078',
        'fas fa-chevron-left'                        => 'f053',
        'fas fa-chevron-right'                       => 'f054',
        'fas fa-chevron-up'                          => 'f077',
        'fas fa-child'                               => 'f1ae',
        'fas fa-church'                              => 'f51d',
        'fas fa-circle'                              => 'f111',
        'fas fa-circle-notch'                        => 'f1ce',
        'fas fa-clipboard'                           => 'f328',
        'fas fa-clipboard-check'                     => 'f46c',
        'fas fa-clipboard-list'                      => 'f46d',
        'fas fa-clock'                               => 'f017',
        'fas fa-clone'                               => 'f24d',
        'fas fa-closed-captioning'                   => 'f20a',
        'fas fa-cloud'                               => 'f0c2',
        'fas fa-cloud-download-alt'                  => 'f381',
        'fas fa-cloud-upload-alt'                    => 'f382',
        'fas fa-code'                                => 'f121',
        'fas fa-code-branch'                         => 'f126',
        'fas fa-coffee'                              => 'f0f4',
        'fas fa-cog'                                 => 'f013',
        'fas fa-cogs'                                => 'f085',
        'fas fa-coins'                               => 'f51e',
        'fas fa-columns'                             => 'f0db',
        'fas fa-comment'                             => 'f075',
        'fas fa-comment-alt'                         => 'f27a',
        'fas fa-comment-dots'                        => 'f4ad',
        'fas fa-comment-slash'                       => 'f4b3',
        'fas fa-comments'                            => 'f086',
        'fas fa-compact-disc'                        => 'f51f',
        'fas fa-compass'                             => 'f14e',
        'fas fa-compress'                            => 'f066',
        'fas fa-copy'                                => 'f0c5',
        'fas fa-copyright'                           => 'f1f9',
        'fas fa-couch'                               => 'f4b8',
        'fas fa-credit-card'                         => 'f09d',
        'fas fa-crop'                                => 'f125',
        'fas fa-crosshairs'                          => 'f05b',
        'fas fa-crow'                                => 'f520',
        'fas fa-crown'                               => 'f521',
        'fas fa-cube'                                => 'f1b2',
        'fas fa-cubes'                               => 'f1b3',
        'fas fa-cut'                                 => 'f0c4',
        'fas fa-database'                            => 'f1c0',
        'fas fa-deaf'                                => 'f2a4',
        'fas fa-desktop'                             => 'f108',
        'fas fa-diagnoses'                           => 'f470',
        'fas fa-dice'                                => 'f522',
        'fas fa-dice-five'                           => 'f523',
        'fas fa-dice-four'                           => 'f524',
        'fas fa-dice-one'                            => 'f525',
        'fas fa-dice-six'                            => 'f526',
        'fas fa-dice-three'                          => 'f527',
        'fas fa-dice-two'                            => 'f528',
        'fas fa-divide'                              => 'f529',
        'fas fa-dna'                                 => 'f471',
        'fas fa-dollar-sign'                         => 'f155',
        'fas fa-dolly'                               => 'f472',
        'fas fa-dolly-flatbed'                       => 'f474',
        'fas fa-donate'                              => 'f4b9',
        'fas fa-door-closed'                         => 'f52a',
        'fas fa-door-open'                           => 'f52b',
        'fas fa-dot-circle'                          => 'f192',
        'fas fa-dove'                                => 'f4ba',
        'fas fa-download'                            => 'f019',
        'fas fa-dumbbell'                            => 'f44b',
        'fas fa-edit'                                => 'f044',
        'fas fa-eject'                               => 'f052',
        'fas fa-ellipsis-h'                          => 'f141',
        'fas fa-ellipsis-v'                          => 'f142',
        'fas fa-envelope'                            => 'f0e0',
        'fas fa-envelope-open'                       => 'f2b6',
        'fas fa-envelope-square'                     => 'f199',
        'fas fa-equals'                              => 'f52c',
        'fas fa-eraser'                              => 'f12d',
        'fas fa-euro-sign'                           => 'f153',
        'fas fa-exchange-alt'                        => 'f362',
        'fas fa-exclamation'                         => 'f12a',
        'fas fa-exclamation-circle'                  => 'f06a',
        'fas fa-exclamation-triangle'                => 'f071',
        'fas fa-expand'                              => 'f065',
        'fas fa-expand-arrows-alt'                   => 'f31e',
        'fas fa-external-link-alt'                   => 'f35d',
        'fas fa-external-link-square-alt'            => 'f360',
        'fas fa-eye'                                 => 'f06e',
        'fas fa-eye-dropper'                         => 'f1fb',
        'fas fa-eye-slash'                           => 'f070',
        'fas fa-fast-backward'                       => 'f049',
        'fas fa-fast-forward'                        => 'f050',
        'fas fa-fax'                                 => 'f1ac',
        'fas fa-feather'                             => 'f52d',
        'fas fa-female'                              => 'f182',
        'fas fa-fighter-jet'                         => 'f0fb',
        'fas fa-file'                                => 'f15b',
        'fas fa-file-alt'                            => 'f15c',
        'fas fa-file-archive'                        => 'f1c6',
        'fas fa-file-audio'                          => 'f1c7',
        'fas fa-file-code'                           => 'f1c9',
        'fas fa-file-excel'                          => 'f1c3',
        'fas fa-file-image'                          => 'f1c5',
        'fas fa-file-medical'                        => 'f477',
        'fas fa-file-medical-alt'                    => 'f478',
        'fas fa-file-pdf'                            => 'f1c1',
        'fas fa-file-powerpoint'                     => 'f1c4',
        'fas fa-file-video'                          => 'f1c8',
        'fas fa-file-word'                           => 'f1c2',
        'fas fa-film'                                => 'f008',
        'fas fa-filter'                              => 'f0b0',
        'fas fa-fire'                                => 'f06d',
        'fas fa-fire-extinguisher'                   => 'f134',
        'fas fa-first-aid'                           => 'f479',
        'fas fa-flag'                                => 'f024',
        'fas fa-flag-checkered'                      => 'f11e',
        'fas fa-flask'                               => 'f0c3',
        'fas fa-folder'                              => 'f07b',
        'fas fa-folder-open'                         => 'f07c',
        'fas fa-font'                                => 'f031',
        'fas fa-font-awesome-logo-full'              => 'f4e6',
        'fas fa-football-ball'                       => 'f44e',
        'fas fa-forward'                             => 'f04e',
        'fas fa-frog'                                => 'f52e',
        'fas fa-frown'                               => 'f119',
        'fas fa-futbol'                              => 'f1e3',
        'fas fa-gamepad'                             => 'f11b',
        'fas fa-gas-pump'                            => 'f52f',
        'fas fa-gavel'                               => 'f0e3',
        'fas fa-gem'                                 => 'f3a5',
        'fas fa-genderless'                          => 'f22d',
        'fas fa-gift'                                => 'f06b',
        'fas fa-glass-martini'                       => 'f000',
        'fas fa-glasses'                             => 'f530',
        'fas fa-globe'                               => 'f0ac',
        'fas fa-golf-ball'                           => 'f450',
        'fas fa-graduation-cap'                      => 'f19d',
        'fas fa-greater-than'                        => 'f531',
        'fas fa-greater-than-equal'                  => 'f532',
        'fas fa-h-square'                            => 'f0fd',
        'fas fa-hand-holding'                        => 'f4bd',
        'fas fa-hand-holding-heart'                  => 'f4be',
        'fas fa-hand-holding-usd'                    => 'f4c0',
        'fas fa-hand-lizard'                         => 'f258',
        'fas fa-hand-paper'                          => 'f256',
        'fas fa-hand-peace'                          => 'f25b',
        'fas fa-hand-point-down'                     => 'f0a7',
        'fas fa-hand-point-left'                     => 'f0a5',
        'fas fa-hand-point-right'                    => 'f0a4',
        'fas fa-hand-point-up'                       => 'f0a6',
        'fas fa-hand-pointer'                        => 'f25a',
        'fas fa-hand-rock'                           => 'f255',
        'fas fa-hand-scissors'                       => 'f257',
        'fas fa-hand-spock'                          => 'f259',
        'fas fa-hands'                               => 'f4c2',
        'fas fa-hands-helping'                       => 'f4c4',
        'fas fa-handshake'                           => 'f2b5',
        'fas fa-hashtag'                             => 'f292',
        'fas fa-hdd'                                 => 'f0a0',
        'fas fa-heading'                             => 'f1dc',
        'fas fa-headphones'                          => 'f025',
        'fas fa-heart'                               => 'f004',
        'fas fa-heartbeat'                           => 'f21e',
        'fas fa-helicopter'                          => 'f533',
        'fas fa-history'                             => 'f1da',
        'fas fa-hockey-puck'                         => 'f453',
        'fas fa-home'                                => 'f015',
        'fas fa-hospital'                            => 'f0f8',
        'fas fa-hospital-alt'                        => 'f47d',
        'fas fa-hospital-symbol'                     => 'f47e',
        'fas fa-hourglass'                           => 'f254',
        'fas fa-hourglass-end'                       => 'f253',
        'fas fa-hourglass-half'                      => 'f252',
        'fas fa-hourglass-start'                     => 'f251',
        'fas fa-i-cursor'                            => 'f246',
        'fas fa-id-badge'                            => 'f2c1',
        'fas fa-id-card'                             => 'f2c2',
        'fas fa-id-card-alt'                         => 'f47f',
        'fas fa-image'                               => 'f03e',
        'fas fa-images'                              => 'f302',
        'fas fa-inbox'                               => 'f01c',
        'fas fa-indent'                              => 'f03c',
        'fas fa-industry'                            => 'f275',
        'fas fa-infinity'                            => 'f534',
        'fas fa-info'                                => 'f129',
        'fas fa-info-circle'                         => 'f05a',
        'fas fa-italic'                              => 'f033',
        'fas fa-key'                                 => 'f084',
        'fas fa-keyboard'                            => 'f11c',
        'fas fa-kiwi-bird'                           => 'f535',
        'fas fa-language'                            => 'f1ab',
        'fas fa-laptop'                              => 'f109',
        'fas fa-leaf'                                => 'f06c',
        'fas fa-lemon'                               => 'f094',
        'fas fa-less-than'                           => 'f536',
        'fas fa-less-than-equal'                     => 'f537',
        'fas fa-level-down-alt'                      => 'f3be',
        'fas fa-level-up-alt'                        => 'f3bf',
        'fas fa-life-ring'                           => 'f1cd',
        'fas fa-lightbulb'                           => 'f0eb',
        'fas fa-link'                                => 'f0c1',
        'fas fa-lira-sign'                           => 'f195',
        'fas fa-list'                                => 'f03a',
        'fas fa-list-alt'                            => 'f022',
        'fas fa-list-ol'                             => 'f0cb',
        'fas fa-list-ul'                             => 'f0ca',
        'fas fa-location-arrow'                      => 'f124',
        'fas fa-lock'                                => 'f023',
        'fas fa-lock-open'                           => 'f3c1',
        'fas fa-long-arrow-alt-down'                 => 'f309',
        'fas fa-long-arrow-alt-left'                 => 'f30a',
        'fas fa-long-arrow-alt-right'                => 'f30b',
        'fas fa-long-arrow-alt-up'                   => 'f30c',
        'fas fa-low-vision'                          => 'f2a8',
        'fas fa-magic'                               => 'f0d0',
        'fas fa-magnet'                              => 'f076',
        'fas fa-male'                                => 'f183',
        'fas fa-map'                                 => 'f279',
        'fas fa-map-marker'                          => 'f041',
        'fas fa-map-marker-alt'                      => 'f3c5',
        'fas fa-map-pin'                             => 'f276',
        'fas fa-map-signs'                           => 'f277',
        'fas fa-mars'                                => 'f222',
        'fas fa-mars-double'                         => 'f227',
        'fas fa-mars-stroke'                         => 'f229',
        'fas fa-mars-stroke-h'                       => 'f22b',
        'fas fa-mars-stroke-v'                       => 'f22a',
        'fas fa-medkit'                              => 'f0fa',
        'fas fa-meh'                                 => 'f11a',
        'fas fa-memory'                              => 'f538',
        'fas fa-mercury'                             => 'f223',
        'fas fa-microchip'                           => 'f2db',
        'fas fa-microphone'                          => 'f130',
        'fas fa-microphone-alt'                      => 'f3c9',
        'fas fa-microphone-alt-slash'                => 'f539',
        'fas fa-microphone-slash'                    => 'f131',
        'fas fa-minus'                               => 'f068',
        'fas fa-minus-circle'                        => 'f056',
        'fas fa-minus-square'                        => 'f146',
        'fas fa-mobile'                              => 'f10b',
        'fas fa-mobile-alt'                          => 'f3cd',
        'fas fa-money-bill'                          => 'f0d6',
        'fas fa-money-bill-alt'                      => 'f3d1',
        'fas fa-money-bill-wave'                     => 'f53a',
        'fas fa-money-bill-wave-alt'                 => 'f53b',
        'fas fa-money-check'                         => 'f53c',
        'fas fa-money-check-alt'                     => 'f53d',
        'fas fa-moon'                                => 'f186',
        'fas fa-motorcycle'                          => 'f21c',
        'fas fa-mouse-pointer'                       => 'f245',
        'fas fa-music'                               => 'f001',
        'fas fa-neuter'                              => 'f22c',
        'fas fa-newspaper'                           => 'f1ea',
        'fas fa-not-equal'                           => 'f53e',
        'fas fa-notes-medical'                       => 'f481',
        'fas fa-object-group'                        => 'f247',
        'fas fa-object-ungroup'                      => 'f248',
        'fas fa-outdent'                             => 'f03b',
        'fas fa-paint-brush'                         => 'f1fc',
        'fas fa-palette'                             => 'f53f',
        'fas fa-pallet'                              => 'f482',
        'fas fa-paper-plane'                         => 'f1d8',
        'fas fa-paperclip'                           => 'f0c6',
        'fas fa-parachute-box'                       => 'f4cd',
        'fas fa-paragraph'                           => 'f1dd',
        'fas fa-parking'                             => 'f540',
        'fas fa-paste'                               => 'f0ea',
        'fas fa-pause'                               => 'f04c',
        'fas fa-pause-circle'                        => 'f28b',
        'fas fa-paw'                                 => 'f1b0',
        'fas fa-pen-square'                          => 'f14b',
        'fas fa-pencil-alt'                          => 'f303',
        'fas fa-people-carry'                        => 'f4ce',
        'fas fa-percent'                             => 'f295',
        'fas fa-percentage'                          => 'f541',
        'fas fa-phone'                               => 'f095',
        'fas fa-phone-slash'                         => 'f3dd',
        'fas fa-phone-square'                        => 'f098',
        'fas fa-phone-volume'                        => 'f2a0',
        'fas fa-piggy-bank'                          => 'f4d3',
        'fas fa-pills'                               => 'f484',
        'fas fa-plane'                               => 'f072',
        'fas fa-play'                                => 'f04b',
        'fas fa-play-circle'                         => 'f144',
        'fas fa-plug'                                => 'f1e6',
        'fas fa-plus'                                => 'f067',
        'fas fa-plus-circle'                         => 'f055',
        'fas fa-plus-square'                         => 'f0fe',
        'fas fa-podcast'                             => 'f2ce',
        'fas fa-poo'                                 => 'f2fe',
        'fas fa-portrait'                            => 'f3e0',
        'fas fa-pound-sign'                          => 'f154',
        'fas fa-power-off'                           => 'f011',
        'fas fa-prescription-bottle'                 => 'f485',
        'fas fa-prescription-bottle-alt'             => 'f486',
        'fas fa-print'                               => 'f02f',
        'fas fa-procedures'                          => 'f487',
        'fas fa-project-diagram'                     => 'f542',
        'fas fa-puzzle-piece'                        => 'f12e',
        'fas fa-qrcode'                              => 'f029',
        'fas fa-question'                            => 'f128',
        'fas fa-question-circle'                     => 'f059',
        'fas fa-quidditch'                           => 'f458',
        'fas fa-quote-left'                          => 'f10d',
        'fas fa-quote-right'                         => 'f10e',
        'fas fa-random'                              => 'f074',
        'fas fa-receipt'                             => 'f543',
        'fas fa-recycle'                             => 'f1b8',
        'fas fa-redo'                                => 'f01e',
        'fas fa-redo-alt'                            => 'f2f9',
        'fas fa-registered'                          => 'f25d',
        'fas fa-reply'                               => 'f3e5',
        'fas fa-reply-all'                           => 'f122',
        'fas fa-retweet'                             => 'f079',
        'fas fa-ribbon'                              => 'f4d6',
        'fas fa-road'                                => 'f018',
        'fas fa-robot'                               => 'f544',
        'fas fa-rocket'                              => 'f135',
        'fas fa-rss'                                 => 'f09e',
        'fas fa-rss-square'                          => 'f143',
        'fas fa-ruble-sign'                          => 'f158',
        'fas fa-ruler'                               => 'f545',
        'fas fa-ruler-combined'                      => 'f546',
        'fas fa-ruler-horizontal'                    => 'f547',
        'fas fa-ruler-vertical'                      => 'f548',
        'fas fa-rupee-sign'                          => 'f156',
        'fas fa-save'                                => 'f0c7',
        'fas fa-school'                              => 'f549',
        'fas fa-screwdriver'                         => 'f54a',
        'fas fa-search'                              => 'f002',
        'fas fa-search-minus'                        => 'f010',
        'fas fa-search-plus'                         => 'f00e',
        'fas fa-seedling'                            => 'f4d8',
        'fas fa-server'                              => 'f233',
        'fas fa-share'                               => 'f064',
        'fas fa-share-alt'                           => 'f1e0',
        'fas fa-share-alt-square'                    => 'f1e1',
        'fas fa-share-square'                        => 'f14d',
        'fas fa-shekel-sign'                         => 'f20b',
        'fas fa-shield-alt'                          => 'f3ed',
        'fas fa-ship'                                => 'f21a',
        'fas fa-shipping-fast'                       => 'f48b',
        'fas fa-shoe-prints'                         => 'f54b',
        'fas fa-shopping-bag'                        => 'f290',
        'fas fa-shopping-basket'                     => 'f291',
        'fas fa-shopping-cart'                       => 'f07a',
        'fas fa-shower'                              => 'f2cc',
        'fas fa-sign'                                => 'f4d9',
        'fas fa-sign-in-alt'                         => 'f2f6',
        'fas fa-sign-language'                       => 'f2a7',
        'fas fa-sign-out-alt'                        => 'f2f5',
        'fas fa-signal'                              => 'f012',
        'fas fa-sitemap'                             => 'f0e8',
        'fas fa-skull'                               => 'f54c',
        'fas fa-sliders-h'                           => 'f1de',
        'fas fa-smile'                               => 'f118',
        'fas fa-smoking'                             => 'f48d',
        'fas fa-smoking-ban'                         => 'f54d',
        'fas fa-snowflake'                           => 'f2dc',
        'fas fa-sort'                                => 'f0dc',
        'fas fa-sort-alpha-down'                     => 'f15d',
        'fas fa-sort-alpha-up'                       => 'f15e',
        'fas fa-sort-amount-down'                    => 'f160',
        'fas fa-sort-amount-up'                      => 'f161',
        'fas fa-sort-down'                           => 'f0dd',
        'fas fa-sort-numeric-down'                   => 'f162',
        'fas fa-sort-numeric-up'                     => 'f163',
        'fas fa-sort-up'                             => 'f0de',
        'fas fa-space-shuttle'                       => 'f197',
        'fas fa-spinner'                             => 'f110',
        'fas fa-square'                              => 'f0c8',
        'fas fa-square-full'                         => 'f45c',
        'fas fa-star'                                => 'f005',
        'fas fa-star-half'                           => 'f089',
        'fas fa-step-backward'                       => 'f048',
        'fas fa-step-forward'                        => 'f051',
        'fas fa-stethoscope'                         => 'f0f1',
        'fas fa-sticky-note'                         => 'f249',
        'fas fa-stop'                                => 'f04d',
        'fas fa-stop-circle'                         => 'f28d',
        'fas fa-stopwatch'                           => 'f2f2',
        'fas fa-store'                               => 'f54e',
        'fas fa-store-alt'                           => 'f54f',
        'fas fa-stream'                              => 'f550',
        'fas fa-street-view'                         => 'f21d',
        'fas fa-strikethrough'                       => 'f0cc',
        'fas fa-stroopwafel'                         => 'f551',
        'fas fa-subscript'                           => 'f12c',
        'fas fa-subway'                              => 'f239',
        'fas fa-suitcase'                            => 'f0f2',
        'fas fa-sun'                                 => 'f185',
        'fas fa-superscript'                         => 'f12b',
        'fas fa-sync'                                => 'f021',
        'fas fa-sync-alt'                            => 'f2f1',
        'fas fa-syringe'                             => 'f48e',
        'fas fa-table'                               => 'f0ce',
        'fas fa-table-tennis'                        => 'f45d',
        'fas fa-tablet'                              => 'f10a',
        'fas fa-tablet-alt'                          => 'f3fa',
        'fas fa-tablets'                             => 'f490',
        'fas fa-tachometer-alt'                      => 'f3fd',
        'fas fa-tag'                                 => 'f02b',
        'fas fa-tags'                                => 'f02c',
        'fas fa-tape'                                => 'f4db',
        'fas fa-tasks'                               => 'f0ae',
        'fas fa-taxi'                                => 'f1ba',
        'fas fa-terminal'                            => 'f120',
        'fas fa-text-height'                         => 'f034',
        'fas fa-text-width'                          => 'f035',
        'fas fa-th'                                  => 'f00a',
        'fas fa-th-large'                            => 'f009',
        'fas fa-th-list'                             => 'f00b',
        'fas fa-thermometer'                         => 'f491',
        'fas fa-thermometer-empty'                   => 'f2cb',
        'fas fa-thermometer-full'                    => 'f2c7',
        'fas fa-thermometer-half'                    => 'f2c9',
        'fas fa-thermometer-quarter'                 => 'f2ca',
        'fas fa-thermometer-three-quarters'          => 'f2c8',
        'fas fa-thumbs-down'                         => 'f165',
        'fas fa-thumbs-up'                           => 'f164',
        'fas fa-thumbtack'                           => 'f08d',
        'fas fa-ticket-alt'                          => 'f3ff',
        'fas fa-times'                               => 'f00d',
        'fas fa-times-circle'                        => 'f057',
        'fas fa-tint'                                => 'f043',
        'fas fa-toggle-off'                          => 'f204',
        'fas fa-toggle-on'                           => 'f205',
        'fas fa-toolbox'                             => 'f552',
        'fas fa-trademark'                           => 'f25c',
        'fas fa-train'                               => 'f238',
        'fas fa-transgender'                         => 'f224',
        'fas fa-transgender-alt'                     => 'f225',
        'fas fa-trash'                               => 'f1f8',
        'fas fa-trash-alt'                           => 'f2ed',
        'fas fa-tree'                                => 'f1bb',
        'fas fa-trophy'                              => 'f091',
        'fas fa-truck'                               => 'f0d1',
        'fas fa-truck-loading'                       => 'f4de',
        'fas fa-truck-moving'                        => 'f4df',
        'fas fa-tshirt'                              => 'f553',
        'fas fa-tty'                                 => 'f1e4',
        'fas fa-tv'                                  => 'f26c',
        'fas fa-umbrella'                            => 'f0e9',
        'fas fa-underline'                           => 'f0cd',
        'fas fa-undo'                                => 'f0e2',
        'fas fa-undo-alt'                            => 'f2ea',
        'fas fa-universal-access'                    => 'f29a',
        'fas fa-university'                          => 'f19c',
        'fas fa-unlink'                              => 'f127',
        'fas fa-unlock'                              => 'f09c',
        'fas fa-unlock-alt'                          => 'f13e',
        'fas fa-upload'                              => 'f093',
        'fas fa-user'                                => 'f007',
        'fas fa-user-alt'                            => 'f406',
        'fas fa-user-alt-slash'                      => 'f4fa',
        'fas fa-user-astronaut'                      => 'f4fb',
        'fas fa-user-check'                          => 'f4fc',
        'fas fa-user-circle'                         => 'f2bd',
        'fas fa-user-clock'                          => 'f4fd',
        'fas fa-user-cog'                            => 'f4fe',
        'fas fa-user-edit'                           => 'f4ff',
        'fas fa-user-friends'                        => 'f500',
        'fas fa-user-graduate'                       => 'f501',
        'fas fa-user-lock'                           => 'f502',
        'fas fa-user-md'                             => 'f0f0',
        'fas fa-user-minus'                          => 'f503',
        'fas fa-user-ninja'                          => 'f504',
        'fas fa-user-plus'                           => 'f234',
        'fas fa-user-secret'                         => 'f21b',
        'fas fa-user-shield'                         => 'f505',
        'fas fa-user-slash'                          => 'f506',
        'fas fa-user-tag'                            => 'f507',
        'fas fa-user-tie'                            => 'f508',
        'fas fa-user-times'                          => 'f235',
        'fas fa-users'                               => 'f0c0',
        'fas fa-users-cog'                           => 'f509',
        'fas fa-utensil-spoon'                       => 'f2e5',
        'fas fa-utensils'                            => 'f2e7',
        'fas fa-venus'                               => 'f221',
        'fas fa-venus-double'                        => 'f226',
        'fas fa-venus-mars'                          => 'f228',
        'fas fa-vial'                                => 'f492',
        'fas fa-vials'                               => 'f493',
        'fas fa-video'                               => 'f03d',
        'fas fa-video-slash'                         => 'f4e2',
        'fas fa-volleyball-ball'                     => 'f45f',
        'fas fa-volume-down'                         => 'f027',
        'fas fa-volume-off'                          => 'f026',
        'fas fa-volume-up'                           => 'f028',
        'fas fa-walking'                             => 'f554',
        'fas fa-wallet'                              => 'f555',
        'fas fa-warehouse'                           => 'f494',
        'fas fa-weight'                              => 'f496',
        'fas fa-wheelchair'                          => 'f193',
        'fas fa-wifi'                                => 'f1eb',
        'fas fa-window-close'                        => 'f410',
        'fas fa-window-maximize'                     => 'f2d0',
        'fas fa-window-minimize'                     => 'f2d1',
        'fas fa-window-restore'                      => 'f2d2',
        'fas fa-wine-glass'                          => 'f4e3',
        'fas fa-won-sign'                            => 'f159',
        'fas fa-wrench'                              => 'f0ad',
        'fas fa-x-ray'                               => 'f497',
        'fas fa-yen-sign'                            => 'f157',
        'far fa-address-book'                        => 'f2b9',
        'far fa-address-card'                        => 'f2bb',
        'far fa-arrow-alt-circle-down'               => 'f358',
        'far fa-arrow-alt-circle-left'               => 'f359',
        'far fa-arrow-alt-circle-right'              => 'f35a',
        'far fa-arrow-alt-circle-up'                 => 'f35b',
        'far fa-bell'                                => 'f0f3',
        'far fa-bell-slash'                          => 'f1f6',
        'far fa-bookmark'                            => 'f02e',
        'far fa-building'                            => 'f1ad',
        'far fa-calendar'                            => 'f133',
        'far fa-calendar-alt'                        => 'f073',
        'far fa-calendar-check'                      => 'f274',
        'far fa-calendar-minus'                      => 'f272',
        'far fa-calendar-plus'                       => 'f271',
        'far fa-calendar-times'                      => 'f273',
        'far fa-caret-square-down'                   => 'f150',
        'far fa-caret-square-left'                   => 'f191',
        'far fa-caret-square-right'                  => 'f152',
        'far fa-caret-square-up'                     => 'f151',
        'far fa-chart-bar'                           => 'f080',
        'far fa-check-circle'                        => 'f058',
        'far fa-check-square'                        => 'f14a',
        'far fa-circle'                              => 'f111',
        'far fa-clipboard'                           => 'f328',
        'far fa-clock'                               => 'f017',
        'far fa-clone'                               => 'f24d',
        'far fa-closed-captioning'                   => 'f20a',
        'far fa-comment'                             => 'f075',
        'far fa-comment-alt'                         => 'f27a',
        'far fa-comment-dots'                        => 'f4ad',
        'far fa-comments'                            => 'f086',
        'far fa-compass'                             => 'f14e',
        'far fa-copy'                                => 'f0c5',
        'far fa-copyright'                           => 'f1f9',
        'far fa-credit-card'                         => 'f09d',
        'far fa-dot-circle'                          => 'f192',
        'far fa-edit'                                => 'f044',
        'far fa-envelope'                            => 'f0e0',
        'far fa-envelope-open'                       => 'f2b6',
        'far fa-eye'                                 => 'f06e',
        'far fa-eye-slash'                           => 'f070',
        'far fa-file'                                => 'f15b',
        'far fa-file-alt'                            => 'f15c',
        'far fa-file-archive'                        => 'f1c6',
        'far fa-file-audio'                          => 'f1c7',
        'far fa-file-code'                           => 'f1c9',
        'far fa-file-excel'                          => 'f1c3',
        'far fa-file-image'                          => 'f1c5',
        'far fa-file-pdf'                            => 'f1c1',
        'far fa-file-powerpoint'                     => 'f1c4',
        'far fa-file-video'                          => 'f1c8',
        'far fa-file-word'                           => 'f1c2',
        'far fa-flag'                                => 'f024',
        'far fa-folder'                              => 'f07b',
        'far fa-folder-open'                         => 'f07c',
        'far fa-font-awesome-logo-full'              => 'f4e6',
        'far fa-frown'                               => 'f119',
        'far fa-futbol'                              => 'f1e3',
        'far fa-gem'                                 => 'f3a5',
        'far fa-hand-lizard'                         => 'f258',
        'far fa-hand-paper'                          => 'f256',
        'far fa-hand-peace'                          => 'f25b',
        'far fa-hand-point-down'                     => 'f0a7',
        'far fa-hand-point-left'                     => 'f0a5',
        'far fa-hand-point-right'                    => 'f0a4',
        'far fa-hand-point-up'                       => 'f0a6',
        'far fa-hand-pointer'                        => 'f25a',
        'far fa-hand-rock'                           => 'f255',
        'far fa-hand-scissors'                       => 'f257',
        'far fa-hand-spock'                          => 'f259',
        'far fa-handshake'                           => 'f2b5',
        'far fa-hdd'                                 => 'f0a0',
        'far fa-heart'                               => 'f004',
        'far fa-hospital'                            => 'f0f8',
        'far fa-hourglass'                           => 'f254',
        'far fa-id-badge'                            => 'f2c1',
        'far fa-id-card'                             => 'f2c2',
        'far fa-image'                               => 'f03e',
        'far fa-images'                              => 'f302',
        'far fa-keyboard'                            => 'f11c',
        'far fa-lemon'                               => 'f094',
        'far fa-life-ring'                           => 'f1cd',
        'far fa-lightbulb'                           => 'f0eb',
        'far fa-list-alt'                            => 'f022',
        'far fa-map'                                 => 'f279',
        'far fa-meh'                                 => 'f11a',
        'far fa-minus-square'                        => 'f146',
        'far fa-money-bill-alt'                      => 'f3d1',
        'far fa-moon'                                => 'f186',
        'far fa-newspaper'                           => 'f1ea',
        'far fa-object-group'                        => 'f247',
        'far fa-object-ungroup'                      => 'f248',
        'far fa-paper-plane'                         => 'f1d8',
        'far fa-pause-circle'                        => 'f28b',
        'far fa-play-circle'                         => 'f144',
        'far fa-plus-square'                         => 'f0fe',
        'far fa-question-circle'                     => 'f059',
        'far fa-registered'                          => 'f25d',
        'far fa-save'                                => 'f0c7',
        'far fa-share-square'                        => 'f14d',
        'far fa-smile'                               => 'f118',
        'far fa-snowflake'                           => 'f2dc',
        'far fa-square'                              => 'f0c8',
        'far fa-star'                                => 'f005',
        'far fa-star-half'                           => 'f089',
        'far fa-sticky-note'                         => 'f249',
        'far fa-stop-circle'                         => 'f28d',
        'far fa-sun'                                 => 'f185',
        'far fa-thumbs-down'                         => 'f165',
        'far fa-thumbs-up'                           => 'f164',
        'far fa-times-circle'                        => 'f057',
        'far fa-trash-alt'                           => 'f2ed',
        'far fa-user'                                => 'f007',
        'far fa-user-circle'                         => 'f2bd',
        'far fa-window-close'                        => 'f410',
        'far fa-window-maximize'                     => 'f2d0',
        'far fa-window-minimize'                     => 'f2d1',
        'far fa-window-restore'                      => 'f2d2',
        'fab fa-500px'                               => 'f26e',
        'fab fa-accessible-icon'                     => 'f368',
        'fab fa-accusoft'                            => 'f369',
        'fab fa-adn'                                 => 'f170',
        'fab fa-adversal'                            => 'f36a',
        'fab fa-affiliatetheme'                      => 'f36b',
        'fab fa-algolia'                             => 'f36c',
        'fab fa-amazon'                              => 'f270',
        'fab fa-amazon-pay'                          => 'f42c',
        'fab fa-amilia'                              => 'f36d',
        'fab fa-android'                             => 'f17b',
        'fab fa-angellist'                           => 'f209',
        'fab fa-angrycreative'                       => 'f36e',
        'fab fa-angular'                             => 'f420',
        'fab fa-app-store'                           => 'f36f',
        'fab fa-app-store-ios'                       => 'f370',
        'fab fa-apper'                               => 'f371',
        'fab fa-apple'                               => 'f179',
        'fab fa-apple-pay'                           => 'f415',
        'fab fa-asymmetrik'                          => 'f372',
        'fab fa-audible'                             => 'f373',
        'fab fa-autoprefixer'                        => 'f41c',
        'fab fa-avianex'                             => 'f374',
        'fab fa-aviato'                              => 'f421',
        'fab fa-aws'                                 => 'f375',
        'fab fa-bandcamp'                            => 'f2d5',
        'fab fa-behance'                             => 'f1b4',
        'fab fa-behance-square'                      => 'f1b5',
        'fab fa-bimobject'                           => 'f378',
        'fab fa-bitbucket'                           => 'f171',
        'fab fa-bitcoin'                             => 'f379',
        'fab fa-bity'                                => 'f37a',
        'fab fa-black-tie'                           => 'f27e',
        'fab fa-blackberry'                          => 'f37b',
        'fab fa-blogger'                             => 'f37c',
        'fab fa-blogger-b'                           => 'f37d',
        'fab fa-bluetooth'                           => 'f293',
        'fab fa-bluetooth-b'                         => 'f294',
        'fab fa-btc'                                 => 'f15a',
        'fab fa-buromobelexperte'                    => 'f37f',
        'fab fa-buysellads'                          => 'f20d',
        'fab fa-cc-amazon-pay'                       => 'f42d',
        'fab fa-cc-amex'                             => 'f1f3',
        'fab fa-cc-apple-pay'                        => 'f416',
        'fab fa-cc-diners-club'                      => 'f24c',
        'fab fa-cc-discover'                         => 'f1f2',
        'fab fa-cc-jcb'                              => 'f24b',
        'fab fa-cc-mastercard'                       => 'f1f1',
        'fab fa-cc-paypal'                           => 'f1f4',
        'fab fa-cc-stripe'                           => 'f1f5',
        'fab fa-cc-visa'                             => 'f1f0',
        'fab fa-centercode'                          => 'f380',
        'fab fa-chrome'                              => 'f268',
        'fab fa-cloudscale'                          => 'f383',
        'fab fa-cloudsmith'                          => 'f384',
        'fab fa-cloudversify'                        => 'f385',
        'fab fa-codepen'                             => 'f1cb',
        'fab fa-codiepie'                            => 'f284',
        'fab fa-connectdevelop'                      => 'f20e',
        'fab fa-contao'                              => 'f26d',
        'fab fa-cpanel'                              => 'f388',
        'fab fa-creative-commons'                    => 'f25e',
        'fab fa-creative-commons-by'                 => 'f4e7',
        'fab fa-creative-commons-nc'                 => 'f4e8',
        'fab fa-creative-commons-nc-eu'              => 'f4e9',
        'fab fa-creative-commons-nc-jp'              => 'f4ea',
        'fab fa-creative-commons-nd'                 => 'f4eb',
        'fab fa-creative-commons-pd'                 => 'f4ec',
        'fab fa-creative-commons-pd-alt'             => 'f4ed',
        'fab fa-creative-commons-remix'              => 'f4ee',
        'fab fa-creative-commons-sa'                 => 'f4ef',
        'fab fa-creative-commons-sampling'           => 'f4f0',
        'fab fa-creative-commons-sampling-plus'      => 'f4f1',
        'fab fa-creative-commons-share'              => 'f4f2',
        'fab fa-css3'                                => 'f13c',
        'fab fa-css3-alt'                            => 'f38b',
        'fab fa-cuttlefish'                          => 'f38c',
        'fab fa-d-and-d'                             => 'f38d',
        'fab fa-dashcube'                            => 'f210',
        'fab fa-delicious'                           => 'f1a5',
        'fab fa-deploydog'                           => 'f38e',
        'fab fa-deskpro'                             => 'f38f',
        'fab fa-deviantart'                          => 'f1bd',
        'fab fa-digg'                                => 'f1a6',
        'fab fa-digital-ocean'                       => 'f391',
        'fab fa-discord'                             => 'f392',
        'fab fa-discourse'                           => 'f393',
        'fab fa-dochub'                              => 'f394',
        'fab fa-docker'                              => 'f395',
        'fab fa-draft2digital'                       => 'f396',
        'fab fa-dribbble'                            => 'f17d',
        'fab fa-dribbble-square'                     => 'f397',
        'fab fa-dropbox'                             => 'f16b',
        'fab fa-drupal'                              => 'f1a9',
        'fab fa-dyalog'                              => 'f399',
        'fab fa-earlybirds'                          => 'f39a',
        'fab fa-ebay'                                => 'f4f4',
        'fab fa-edge'                                => 'f282',
        'fab fa-elementor'                           => 'f430',
        'fab fa-ember'                               => 'f423',
        'fab fa-empire'                              => 'f1d1',
        'fab fa-envira'                              => 'f299',
        'fab fa-erlang'                              => 'f39d',
        'fab fa-ethereum'                            => 'f42e',
        'fab fa-etsy'                                => 'f2d7',
        'fab fa-expeditedssl'                        => 'f23e',
        'fab fa-facebook'                            => 'f09a',
        'fab fa-facebook-f'                          => 'f39e',
        'fab fa-facebook-messenger'                  => 'f39f',
        'fab fa-facebook-square'                     => 'f082',
        'fab fa-firefox'                             => 'f269',
        'fab fa-first-order'                         => 'f2b0',
        'fab fa-first-order-alt'                     => 'f50a',
        'fab fa-firstdraft'                          => 'f3a1',
        'fab fa-flickr'                              => 'f16e',
        'fab fa-flipboard'                           => 'f44d',
        'fab fa-fly'                                 => 'f417',
        'fab fa-font-awesome'                        => 'f2b4',
        'fab fa-font-awesome-alt'                    => 'f35c',
        'fab fa-font-awesome-flag'                   => 'f425',
        'fab fa-font-awesome-logo-full'              => 'f4e6',
        'fab fa-fonticons'                           => 'f280',
        'fab fa-fonticons-fi'                        => 'f3a2',
        'fab fa-fort-awesome'                        => 'f286',
        'fab fa-fort-awesome-alt'                    => 'f3a3',
        'fab fa-forumbee'                            => 'f211',
        'fab fa-foursquare'                          => 'f180',
        'fab fa-free-code-camp'                      => 'f2c5',
        'fab fa-freebsd'                             => 'f3a4',
        'fab fa-fulcrum'                             => 'f50b',
        'fab fa-galactic-republic'                   => 'f50c',
        'fab fa-galactic-senate'                     => 'f50d',
        'fab fa-get-pocket'                          => 'f265',
        'fab fa-gg'                                  => 'f260',
        'fab fa-gg-circle'                           => 'f261',
        'fab fa-git'                                 => 'f1d3',
        'fab fa-git-square'                          => 'f1d2',
        'fab fa-github'                              => 'f09b',
        'fab fa-github-alt'                          => 'f113',
        'fab fa-github-square'                       => 'f092',
        'fab fa-gitkraken'                           => 'f3a6',
        'fab fa-gitlab'                              => 'f296',
        'fab fa-gitter'                              => 'f426',
        'fab fa-glide'                               => 'f2a5',
        'fab fa-glide-g'                             => 'f2a6',
        'fab fa-gofore'                              => 'f3a7',
        'fab fa-goodreads'                           => 'f3a8',
        'fab fa-goodreads-g'                         => 'f3a9',
        'fab fa-google'                              => 'f1a0',
        'fab fa-google-drive'                        => 'f3aa',
        'fab fa-google-play'                         => 'f3ab',
        'fab fa-google-plus'                         => 'f2b3',
        'fab fa-google-plus-g'                       => 'f0d5',
        'fab fa-google-plus-square'                  => 'f0d4',
        'fab fa-google-wallet'                       => 'f1ee',
        'fab fa-gratipay'                            => 'f184',
        'fab fa-grav'                                => 'f2d6',
        'fab fa-gripfire'                            => 'f3ac',
        'fab fa-grunt'                               => 'f3ad',
        'fab fa-gulp'                                => 'f3ae',
        'fab fa-hacker-news'                         => 'f1d4',
        'fab fa-hacker-news-square'                  => 'f3af',
        'fab fa-hips'                                => 'f452',
        'fab fa-hire-a-helper'                       => 'f3b0',
        'fab fa-hooli'                               => 'f427',
        'fab fa-hotjar'                              => 'f3b1',
        'fab fa-houzz'                               => 'f27c',
        'fab fa-html5'                               => 'f13b',
        'fab fa-hubspot'                             => 'f3b2',
        'fab fa-imdb'                                => 'f2d8',
        'fab fa-instagram'                           => 'f16d',
        'fab fa-internet-explorer'                   => 'f26b',
        'fab fa-ioxhost'                             => 'f208',
        'fab fa-itunes'                              => 'f3b4',
        'fab fa-itunes-note'                         => 'f3b5',
        'fab fa-java'                                => 'f4e4',
        'fab fa-jedi-order'                          => 'f50e',
        'fab fa-jenkins'                             => 'f3b6',
        'fab fa-joget'                               => 'f3b7',
        'fab fa-joomla'                              => 'f1aa',
        'fab fa-js'                                  => 'f3b8',
        'fab fa-js-square'                           => 'f3b9',
        'fab fa-jsfiddle'                            => 'f1cc',
        'fab fa-keybase'                             => 'f4f5',
        'fab fa-keycdn'                              => 'f3ba',
        'fab fa-kickstarter'                         => 'f3bb',
        'fab fa-kickstarter-k'                       => 'f3bc',
        'fab fa-korvue'                              => 'f42f',
        'fab fa-laravel'                             => 'f3bd',
        'fab fa-lastfm'                              => 'f202',
        'fab fa-lastfm-square'                       => 'f203',
        'fab fa-leanpub'                             => 'f212',
        'fab fa-less'                                => 'f41d',
        'fab fa-line'                                => 'f3c0',
        'fab fa-linkedin'                            => 'f08c',
        'fab fa-linkedin-in'                         => 'f0e1',
        'fab fa-linode'                              => 'f2b8',
        'fab fa-linux'                               => 'f17c',
        'fab fa-lyft'                                => 'f3c3',
        'fab fa-magento'                             => 'f3c4',
        'fab fa-mandalorian'                         => 'f50f',
        'fab fa-mastodon'                            => 'f4f6',
        'fab fa-maxcdn'                              => 'f136',
        'fab fa-medapps'                             => 'f3c6',
        'fab fa-medium'                              => 'f23a',
        'fab fa-medium-m'                            => 'f3c7',
        'fab fa-medrt'                               => 'f3c8',
        'fab fa-meetup'                              => 'f2e0',
        'fab fa-microsoft'                           => 'f3ca',
        'fab fa-mix'                                 => 'f3cb',
        'fab fa-mixcloud'                            => 'f289',
        'fab fa-mizuni'                              => 'f3cc',
        'fab fa-modx'                                => 'f285',
        'fab fa-monero'                              => 'f3d0',
        'fab fa-napster'                             => 'f3d2',
        'fab fa-nintendo-switch'                     => 'f418',
        'fab fa-node'                                => 'f419',
        'fab fa-node-js'                             => 'f3d3',
        'fab fa-npm'                                 => 'f3d4',
        'fab fa-ns8'                                 => 'f3d5',
        'fab fa-nutritionix'                         => 'f3d6',
        'fab fa-odnoklassniki'                       => 'f263',
        'fab fa-odnoklassniki-square'                => 'f264',
        'fab fa-old-republic'                        => 'f510',
        'fab fa-opencart'                            => 'f23d',
        'fab fa-openid'                              => 'f19b',
        'fab fa-opera'                               => 'f26a',
        'fab fa-optin-monster'                       => 'f23c',
        'fab fa-osi'                                 => 'f41a',
        'fab fa-page4'                               => 'f3d7',
        'fab fa-pagelines'                           => 'f18c',
        'fab fa-palfed'                              => 'f3d8',
        'fab fa-patreon'                             => 'f3d9',
        'fab fa-paypal'                              => 'f1ed',
        'fab fa-periscope'                           => 'f3da',
        'fab fa-phabricator'                         => 'f3db',
        'fab fa-phoenix-framework'                   => 'f3dc',
        'fab fa-phoenix-squadron'                    => 'f511',
        'fab fa-php'                                 => 'f457',
        'fab fa-pied-piper'                          => 'f2ae',
        'fab fa-pied-piper-alt'                      => 'f1a8',
        'fab fa-pied-piper-hat'                      => 'f4e5',
        'fab fa-pied-piper-pp'                       => 'f1a7',
        'fab fa-pinterest'                           => 'f0d2',
        'fab fa-pinterest-p'                         => 'f231',
        'fab fa-pinterest-square'                    => 'f0d3',
        'fab fa-playstation'                         => 'f3df',
        'fab fa-product-hunt'                        => 'f288',
        'fab fa-pushed'                              => 'f3e1',
        'fab fa-python'                              => 'f3e2',
        'fab fa-qq'                                  => 'f1d6',
        'fab fa-quinscape'                           => 'f459',
        'fab fa-quora'                               => 'f2c4',
        'fab fa-r-project'                           => 'f4f7',
        'fab fa-ravelry'                             => 'f2d9',
        'fab fa-react'                               => 'f41b',
        'fab fa-readme'                              => 'f4d5',
        'fab fa-rebel'                               => 'f1d0',
        'fab fa-red-river'                           => 'f3e3',
        'fab fa-reddit'                              => 'f1a1',
        'fab fa-reddit-alien'                        => 'f281',
        'fab fa-reddit-square'                       => 'f1a2',
        'fab fa-rendact'                             => 'f3e4',
        'fab fa-renren'                              => 'f18b',
        'fab fa-replyd'                              => 'f3e6',
        'fab fa-researchgate'                        => 'f4f8',
        'fab fa-resolving'                           => 'f3e7',
        'fab fa-rocketchat'                          => 'f3e8',
        'fab fa-rockrms'                             => 'f3e9',
        'fab fa-safari'                              => 'f267',
        'fab fa-sass'                                => 'f41e',
        'fab fa-schlix'                              => 'f3ea',
        'fab fa-scribd'                              => 'f28a',
        'fab fa-searchengin'                         => 'f3eb',
        'fab fa-sellcast'                            => 'f2da',
        'fab fa-sellsy'                              => 'f213',
        'fab fa-servicestack'                        => 'f3ec',
        'fab fa-shirtsinbulk'                        => 'f214',
        'fab fa-simplybuilt'                         => 'f215',
        'fab fa-sistrix'                             => 'f3ee',
        'fab fa-sith'                                => 'f512',
        'fab fa-skyatlas'                            => 'f216',
        'fab fa-skype'                               => 'f17e',
        'fab fa-slack'                               => 'f198',
        'fab fa-slack-hash'                          => 'f3ef',
        'fab fa-slideshare'                          => 'f1e7',
        'fab fa-snapchat'                            => 'f2ab',
        'fab fa-snapchat-ghost'                      => 'f2ac',
        'fab fa-snapchat-square'                     => 'f2ad',
        'fab fa-soundcloud'                          => 'f1be',
        'fab fa-speakap'                             => 'f3f3',
        'fab fa-spotify'                             => 'f1bc',
        'fab fa-stack-exchange'                      => 'f18d',
        'fab fa-stack-overflow'                      => 'f16c',
        'fab fa-staylinked'                          => 'f3f5',
        'fab fa-steam'                               => 'f1b6',
        'fab fa-steam-square'                        => 'f1b7',
        'fab fa-steam-symbol'                        => 'f3f6',
        'fab fa-sticker-mule'                        => 'f3f7',
        'fab fa-strava'                              => 'f428',
        'fab fa-stripe'                              => 'f429',
        'fab fa-stripe-s'                            => 'f42a',
        'fab fa-studiovinari'                        => 'f3f8',
        'fab fa-stumbleupon'                         => 'f1a4',
        'fab fa-stumbleupon-circle'                  => 'f1a3',
        'fab fa-superpowers'                         => 'f2dd',
        'fab fa-supple'                              => 'f3f9',
        'fab fa-teamspeak'                           => 'f4f9',
        'fab fa-telegram'                            => 'f2c6',
        'fab fa-telegram-plane'                      => 'f3fe',
        'fab fa-tencent-weibo'                       => 'f1d5',
        'fab fa-themeisle'                           => 'f2b2',
        'fab fa-trade-federation'                    => 'f513',
        'fab fa-trello'                              => 'f181',
        'fab fa-tripadvisor'                         => 'f262',
        'fab fa-tumblr'                              => 'f173',
        'fab fa-tumblr-square'                       => 'f174',
        'fab fa-twitch'                              => 'f1e8',
        'fab fa-twitter'                             => 'f099',
        'fab fa-twitter-square'                      => 'f081',
        'fab fa-typo3'                               => 'f42b',
        'fab fa-uber'                                => 'f402',
        'fab fa-uikit'                               => 'f403',
        'fab fa-uniregistry'                         => 'f404',
        'fab fa-untappd'                             => 'f405',
        'fab fa-usb'                                 => 'f287',
        'fab fa-ussunnah'                            => 'f407',
        'fab fa-vaadin'                              => 'f408',
        'fab fa-viacoin'                             => 'f237',
        'fab fa-viadeo'                              => 'f2a9',
        'fab fa-viadeo-square'                       => 'f2aa',
        'fab fa-viber'                               => 'f409',
        'fab fa-vimeo'                               => 'f40a',
        'fab fa-vimeo-square'                        => 'f194',
        'fab fa-vimeo-v'                             => 'f27d',
        'fab fa-vine'                                => 'f1ca',
        'fab fa-vk'                                  => 'f189',
        'fab fa-vnv'                                 => 'f40b',
        'fab fa-vuejs'                               => 'f41f',
        'fab fa-weibo'                               => 'f18a',
        'fab fa-weixin'                              => 'f1d7',
        'fab fa-whatsapp'                            => 'f232',
        'fab fa-whatsapp-square'                     => 'f40c',
        'fab fa-whmcs'                               => 'f40d',
        'fab fa-wikipedia-w'                         => 'f266',
        'fab fa-windows'                             => 'f17a',
        'fab fa-wolf-pack-battalion'                 => 'f514',
        'fab fa-wordpress'                           => 'f19a',
        'fab fa-wordpress-simple'                    => 'f411',
        'fab fa-wpbeginner'                          => 'f297',
        'fab fa-wpexplorer'                          => 'f2de',
        'fab fa-wpforms'                             => 'f298',
        'fab fa-xbox'                                => 'f412',
        'fab fa-xing'                                => 'f168',
        'fab fa-xing-square'                         => 'f169',
        'fab fa-y-combinator'                        => 'f23b',
        'fab fa-yahoo'                               => 'f19e',
        'fab fa-yandex'                              => 'f413',
        'fab fa-yandex-international'                => 'f414',
        'fab fa-yelp'                                => 'f1e9',
        'fab fa-yoast'                               => 'f2b1',
        'fab fa-youtube'                             => 'f167',
        'fab fa-youtube-square'                      => 'f431'
    ));
}

function fieldpress_get_icons(){
	$fieldpress_get_icons = apply_filters( 'fieldpress_get_icons', array() );
	return $fieldpress_get_icons;
}

/**
 * Ajax function to get icons
 * @access public
 * @since 0.0.1
 *
 * @return array
 *
 */
if( ! function_exists( 'fieldpress_select_icons' ) ) {
	function fieldpress_select_icons() {

		$fieldpress_get_icons = fieldpress_get_icons();

		if( ! empty( $fieldpress_get_icons ) ) {
			foreach ( $fieldpress_get_icons as $key=>$icon ) {
				echo '<span class="single-icon"><i class="'. esc_attr( $key ) .'"></i></span>';
			}
		}
		exit;
	}
	add_action( 'wp_ajax_fieldpress_select_icons', 'fieldpress_select_icons' );
}

/**
 *
 * fieldpress_icon_holder
 *
 * @since 0.0.1
 * @version 0.0.1
 *
 */
if( ! function_exists( 'fieldpress_icon_holder' ) ) {
	function fieldpress_icon_holder() {
		?>
		<div class="supports-drag-drop hidden" id="fieldpress-icon-modal">
			<div class="media-modal wp-core-ui">
				<button type="button" class="media-modal-close fieldpress-icon-modal-close">
					<span class="media-modal-icon"><span class="screen-reader-text">Close</span></span>
				</button>
				<div class="media-modal-content">
					<div class="media-frame mode-select wp-core-ui hide-menu hide-sidebar">
						<div class="media-frame-title"><h1><?php esc_html_e('Select Icon','fieldpress')?><span class="dashicons dashicons-arrow-down"></span></h1></div>
						<div class="media-frame-content">
							<div class="attachments-browser">
								<div class="media-toolbar">
									<div class="media-toolbar-primary search-form">
										<label for="media-search-input" class="screen-reader-text"><?php esc_html_e('Search Icons','fieldpress')?></label>
										<input placeholder="Search icons..." id="fieldpress-icon-search" class="search" type="search">
									</div>
								</div>
								<div class="attachments">
									<?php
									echo '<div id="fieldpress-select-icons-load"></div>';
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="media-modal-backdrop"></div>
		</div>
		<?php

	}
	add_action( 'admin_footer', 'fieldpress_icon_holder' );
	add_action( 'customize_controls_print_footer_scripts', 'fieldpress_icon_holder' );
}
/*=====================Icons End=====================*/

/*=====================Sanitization Start=====================*/

function fieldpress_sanitize_text_field( $input ) {
	return sanitize_text_field( wp_unslash($input) );
}

function fieldpress_sanitize_email( $input ) {
	return sanitize_email( wp_unslash($input ) );
}

function fieldpress_sanitize_url( $input ) {
	return wp_slash( esc_url_raw( wp_unslash( $input ) ) );
}

function fieldpress_sanitize_positive_integer( $input ) {
	return absint( $input );
}

function fieldpress_sanitize_number ( $input ) {
	return intval( $input );
}

function fieldpress_sanitize_allowed_html ( $input ) {
	$allowed_html = wp_kses_allowed_html('post');
	$output = wp_kses( wp_unslash($input ), $allowed_html );
	return $output;
}

function fieldpress_sanitize_textarea( $input ) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$output = wp_unslash($input );
	} else {
		$output = fieldpress_sanitize_allowed_html( $input );
	}
	return $output;
}

function fieldpress_sanitize_checkbox( $checked ) {
	if( is_array( $checked ) ){
		return $checked;
	}
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function fieldpress_sanitize_choices( $input ) {
	if( is_array( $input ) ){
		return $input;
	}
	return esc_attr( $input );
}

function fieldpress_sanitize_color( $input ) {

	if ( empty( $input ) || is_array( $input ) )
		return '';

	/* 
	*  If string does not start with 'rgba', then treat as hex
	*  sanitize the hex color and finally convert hex to rgba 
	*  
	*/
	if ( false === strpos( $input, 'rgba' ) ) {
		return sanitize_hex_color( $input );
	}

	/* 
	* By now we know the string is formatted as an rgba color so we need to further sanitize it.
	*
	*/
	$input = str_replace( ' ', '', $input );
	sscanf( $input, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
	return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
}

function fieldpress_sanitize_explode_array( $input ) {
	$gallery_items = explode(',', $input);
	$gallery_sanitize_items = array();
	foreach ( $gallery_items as $gallery_item ){
		$gallery_sanitize_items[] = fieldpress_sanitize_positive_integer( $gallery_item );
	}
	return implode(',', $gallery_sanitize_items);
}
/*=====================Sanitization End=====================*/

/*=====================Field Class Start=====================*/
/**
 * get classes of field
 * @since 0.0.1
 * @param array $field_details
 * @param mixed $field_value
 * @param mixed $class
 * @return string
 */
function fieldpress_get_single_field_class( $field_details, $field_value = '', $class = '' ) {

	$classes = array();

	if ( ! empty( $class ) ) {
		if ( !is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	/**
	 * Filters fieldpress_get_single_field_class
	 *
	 * @since 0.0.1
	 *
	 * @param array $classes An array of single field classes.
	 * @param array $class   An array of additional classes added to the body.
	 * @param array $field_details   An array of field.
	 * @param mixed $field_value value of field.
	 */
	$classes = apply_filters( 'fieldpress_get_single_field_class', $classes, $class, $field_details, $field_value );
	$classes = array_unique( $classes );

	/*lets sanitize it*/
	$classes = array_map( 'esc_attr', $classes );

	// Separates classes with a single space, collates classes for body element
	$classes = join( ' ', $classes );
	return $classes;
}

function fieldpress_get_field_wrap_class( $field_details, $field_value, $class = '' ) {

	$classes = array();

	if ( ! empty( $class ) ) {
		if ( !is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	/**
	 * Filters fieldpress_get_single_field_class
	 *
	 * @since 0.0.1
	 *
	 * @param array $classes An array of single field classes.
	 * @param array $class   An array of additional classes added to the body.
	 * @param array $field_details   An array of field.
	 * @param mixed $field_value value of field.
	 */
	$classes = apply_filters( 'fieldpress_get_field_wrap_class', $classes, $class, $field_details, $field_value );
	$classes = array_unique( $classes );

	/*lets sanitize it*/
	$classes = array_map( 'esc_attr', $classes );

	// Separates classes with a single space, collates classes for body element
	$classes = join( ' ', $classes );
	return $classes;
}

function fieldpress_get_field_box_class( $field_details, $field_value, $class = '' ) {

	$classes = array();

	if ( ! empty( $class ) ) {
		if ( !is_array( $class ) )
			$class = preg_split( '#\s+#', $class );
		$classes = array_merge( $classes, $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}

	/**
	 * Filters fieldpress_get_single_field_class
	 *
	 * @since 0.0.1
	 *
	 * @param array $classes An array of single field classes.
	 * @param array $class   An array of additional classes added to the body.
	 * @param array $field_details   An array of field.
	 * @param mixed $field_value value of field.
	 */
	$classes = apply_filters( 'fieldpress_get_field_box_class', $classes, $class, $field_details, $field_value );
	$classes = array_unique( $classes );

	/*lets sanitize it*/
	$classes = array_map( 'esc_attr', $classes );

	// Separates classes with a single space, collates classes for body element
	$classes = join( ' ', $classes );
	return $classes;
}
/*=====================Field Class End=====================*/

/*=====================tabs style fields=====================*/
function fieldpress_nested_style_fields(){
    return apply_filters('fieldpress_nested_style_fields',array('tabs','accordions'));
}

/*=====================Sort according to priority=====================*/
function fieldpress_stable_uasort(&$array, $cmp_function) {
	if(count($array) < 2) {
		return;
	}
	$halfway = count($array) / 2;
	$array1 = array_slice($array, 0, $halfway, TRUE);
	$array2 = array_slice($array, $halfway, NULL, TRUE);

	fieldpress_stable_uasort($array1, $cmp_function);
	fieldpress_stable_uasort($array2, $cmp_function);
	if(call_user_func($cmp_function, end($array1), reset($array2)) < 1) {
		$array = $array1 + $array2;
		return;
	}
	$array = array();
	reset($array1);
	reset($array2);
	while(current($array1) && current($array2)) {
		if(call_user_func($cmp_function, current($array1), current($array2)) < 1) {
			$array[key($array1)] = current($array1);
			next($array1);
		} else {
			$array[key($array2)] = current($array2);
			next($array2);
		}
	}
	while(current($array1)) {
		$array[key($array1)] = current($array1);
		next($array1);
	}
	while(current($array2)) {
		$array[key($array2)] = current($array2);
		next($array2);
	}
	return;
}

function fieldpress_uasort($a, $b) {
	if( !isset($a['priority'])){
		$a['priority'] = 10;
	}
	if( !isset($b['priority'])){
		$b['priority'] = 10;
	}

	if($a["priority"] == $b["priority"]) {
		return 0;
	}
	return ($a["priority"] < $b["priority"]) ? -1 : 1;
}