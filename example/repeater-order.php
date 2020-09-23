<?php
/*for icons*/
if(!function_exists('prefix_get_icons')){
	add_filter('fieldpress_get_icons','prefix_get_icons');
	function prefix_get_icons($icons){
		return array_merge($icons,fieldpress_get_fa_5_icons());
	}
}
if(!function_exists('prefix_enqueue_icons_css')){
	add_filter('fieldpress_enqueue_scripts','prefix_enqueue_icons_css');
	function prefix_enqueue_icons_css($fields){
		wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css', array(), null);
	}
}

if( class_exists('FieldPress_Meta_Framework' ) ) {

	$meta_fields = array(
		'meta_boxes'        => array(
			'sp-meta-content' => array(
				/* meta-box title */
				'title'          => esc_html__('Slider Press Setting', 'slider-press'),
				/* post types, accept custom post types as well, default (page,post) */
				'post_types'     => array('post','page'),
				/* where the meta box appear: normal (default), advanced, side; */
				'context'        => 'normal',
				/* order of meta box: high (default), low; optional */
				'priority'       => 'high',

				'section-layout'       => 'horizontal',
			)
		),

		'fields'=> array(
			//---------------add slide content fields--------------------*/

			'sp-add-slide-data' => array(
				'type'  => 'repeater',
				'desc' 		=> array(
					'before-field' => esc_html__( 'Add Slide', 'slider-press' ),
				),
				'label-repeater' => esc_html__( 'Slide', 'slider-press' ),
				'fields'=> array(
					'sp-slider-thumbnail'  => array(
						'type'  		=> 'image',
						'label' 		=> esc_html__( 'Thumbnail', 'slider-press' ),
					),
					'sp-slide-element-align'       => array(
						'type'                      => 'select',
						'label'                     => esc_html__( 'Slide Elements Alignment :', 'slider-press' ),
						'choices'                   => array(
							'center'               => esc_html__( 'Center', 'slider-press' ),
							'left'  				=> esc_html__( 'left', 'slider-press' ),
							'right'  				=> esc_html__( 'Right', 'slider-press' ),
							'justify'  				=> esc_html__( 'Justify', 'slider-press' ),
						),
					),
					'sp-slider-element-manager' => array(
						'type'     	=> 'orders',
						'orders'	=> array(

							'sp-order-slide-title'=>array(
								'label' => esc_html__( 'Title ', 'slider-press' ),
								'checkbox' => true,
							),
							'sp-order-slide-description'=>array(
								'label' => esc_html__( 'Description', 'slider-press' ),
								'checkbox' => true,
							),
							'sp-order-slide-buttons'=>array(
								'label' => esc_html__( 'Button', 'slider-press' ),
								'checkbox' => true,
							),
						),
						'fields'=> array(


							/*
							--------------------------------------------------------------------
							 fields listed in "Title and Position"
							---------------------------------------------------------------------
							*/
							'sp-slide-title-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Title', 'slider-press' ),
								'order' => 'sp-order-slide-title',
							),
							'sp-title-as-message'    => array(
								'type'                      => 'message',
								'message'                   => '<i>'.esc_html__( 'Apperance Setting',  'slider-press'  ).'</i>',
								'order' 					=> 'sp-order-slide-title',
							),
							'sp-title-font-size' => array(
								'order' => 'sp-order-slide-title',
								'label' => esc_html__( 'Title Font Size:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10px ,10em, 10%.', 'slider-press' ),
								'type' => 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'font-size'=> true,
								),
							),
							'sp-title-font-color'  => array(
								'type'  => 'color',
								'label' => esc_html__( 'Title Font Color', 'slider-press' ),
								'order'   =>  'sp-order-slide-title',
							),
							'sp-title-line-height' => array(
								'order'   =>  'sp-order-slide-title',
								'label' => esc_html__( 'Title Line Height:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10em,10, 10em,10px .', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'line-height'=> true,
								),
							),
							'sp-title-margin' => array(
								'order'   =>  'sp-order-slide-title',
								'label' => esc_html__( 'Margin:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10px ,10em, 10%.', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'top'=> true,
									'right'=> true,
									'bottom'=> true,
									'left'=> true,
								),
							),
							'sp-title-padding' => array(
								'order'   =>  'sp-order-slide-title',
								'label' => esc_html__( 'Padding:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10px ,10em, 10%.', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'top'=> true,
									'right'=> true,
									'bottom'=> true,
									'left'=> true,
								),
							),
							'sp-order-element-setting-msg'    => array(
								'type'                      => 'message',
								'message'                   => '<i>'.esc_html__( 'Element Setting',  'slider-press'  ).'</i>',
								'order' 					=> 'sp-order-slide-title',
							),
							'sp-title-animation-effect'       => array(
								'type'                      => 'select',
								'label'                     => esc_html__( 'Animation Effect', 'slider-press' ),
								'order' 					=> 'sp-order-slide-title',
								'choices'                   => array(
									'animation1'               => esc_html__( 'Animation 1', 'slider-press' ),
									'animation2'  				=> esc_html__( 'Animation 2', 'slider-press' ),
									'animation3'  				=> esc_html__( 'Animation 3', 'slider-press' ),
									'animation4'  				=> esc_html__( 'Animation 4', 'slider-press' ),
								),
							),

							/*
							--------------------------------------------------------------------
							 fields listed in "desc (content)"
							---------------------------------------------------------------------
							*/
							'sp-slide-desc'  => array(
								'type'  => 'textarea',
								'label' => esc_html__( 'Description', 'slider-press' ),
								'order' => 'sp-order-slide-description',
							),
							/*dec size*/
							'sp-desc-font-size' => array(
								'order' => 'sp-order-slide-description',
								'label' => esc_html__( 'Font Size:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10px ,10em, 10%.', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'font-size'=> true,
								),
							),
							/*member line height*/
							'sp-desc-line-height' => array(
								'order' => 'sp-order-slide-description',
								'label' => esc_html__( 'Line Height:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10em,10, 10em,10px .', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'line-height'=> true,
								),
							),
							'sp-desc-font-color'  => array(
								'type'  => 'color',
								'label' => esc_html__( 'Font Color', 'slider-press' ),
								'order'   => 'sp-order-slide-description',
							),
							/*title padding*/
							'sp-desc-padding' => array(
								'order' => 'sp-order-slide-description',
								'label' => esc_html__( 'Padding:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10px ,10em, 10%.', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'top'=> true,
									'right'=> true,
									'bottom'=> true,
									'left'=> true,
								),
							),
							/*title marign*/
							'sp-desc-margin' => array(
								'order' => 'sp-order-slide-description',
								'label' => esc_html__( 'Margin:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10px ,10em, 10%.', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'top'=> true,
									'right'=> true,
									'bottom'=> true,
									'left'=> true,
								),
							),

							/*
							--------------------------------------------------------------------
							 fields listed in "button (content)"
							---------------------------------------------------------------------
							*/
							'sp-button1-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Button 1 Text', 'slider-press' ),
								'order' => 'sp-order-slide-buttons',
							),
							'sp-button1-url'  => array(
								'type'  => 'url',
								'label' => esc_html__( 'Button 1 Link', 'slider-press' ),
								'attr'  => array(
									'placeholder' => esc_html__( 'URL', 'slider-press' ),
								),
								'order' => 'sp-order-slide-buttons',
							),
							'sp-button2-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Button 2 Link', 'slider-press' ),
								'order' => 'sp-order-slide-buttons',
							),
							'sp-button2-url'  => array(
								'type'  => 'url',
								'label' => esc_html__( 'Button 2 URL', 'slider-press' ),
								'attr'  => array(
									'placeholder' => esc_html__( 'URL', 'slider-press' ),
								),
								'order' => 'sp-order-slide-buttons',
							),
							/*dec size*/
							'sp-button-font-size' => array(
								'order' => 'sp-order-slide-buttons',
								'label' => esc_html__( 'Font Size:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10px ,10em, 10%.', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'font-size'=> true,
								),
							),
							/*member line height*/
							'sp-button-line-height' => array(
								'order' => 'sp-order-slide-buttons',
								'label' => esc_html__( 'Line Height:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10em,10, 10em,10px .', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'line-height'=> true,
								),
							),
							'sp-button-font-color'  => array(
								'type'  => 'color',
								'label' => esc_html__( 'Font Color', 'slider-press' ),
								'order'   => 'sp-order-slide-buttons',
							),
							/*title padding*/
							'sp-button-padding' => array(
								'order' => 'sp-order-slide-buttons',
								'label' => esc_html__( 'Padding:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10px ,10em, 10%.', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'top'=> true,
									'right'=> true,
									'bottom'=> true,
									'left'=> true,
								),
							),
							/*title marign*/
							'sp-button-margin' => array(
								'order' => 'sp-order-slide-buttons',
								'label' => esc_html__( 'Margin:', 'slider-press' ),
								'desc' => esc_html__( 'Insert value with unit. E.g 10px ,10em, 10%.', 'slider-press' ),
								'type' 			=> 'box',
								'device'		=> array(
									'large'=>array(
										'icon' => 'fas fa-desktop',
									),
									'medium'=>array(
										'icon' => 'fas fa-tablet-alt',
									),
									'small'=>array(
										'icon' => 'fas fa-mobile-alt ',
									),
								),
								'boxes'=> array(
									'top'=> true,
									'right'=> true,
									'bottom'=> true,
									'left'=> true,
								),
							),
						),
					),
				),
				'attr'    => array(
					'max-depth' => 2,

				),
				'meta_box' 		=> 'sp-meta-content',
				'priority' 		=> 20
			),
		)
	);
	$meta_fields = apply_filters( 'slider_press_meta_content', $meta_fields );
	new FieldPress_Meta_Framework( $meta_fields );
}
?>

