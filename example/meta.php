<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* generate meta-box for post_type
* 
* @package   fieldPress
* @subpackage classes
* 
*/
if(class_exists('FieldPress_Menu_Framework')) {
	$custom_meta_fields = array(
		'meta_boxes'        => array(
			'fp-demo-meta-box1' => array(
				/* meta-box title */
				'title'          => esc_html__('Simple Meta Box Demo 1','text-domain'),
				/* post types, accept custom post types as well, default (page,post) */
				'post_types'     => array('page','post'),
				/* where the meta box appear: normal (default), advanced, side; */
				'context'        => 'normal',
				/* order of meta box: high (default), low; optional */
				'priority'       => 'high',
			),
			'fp-demo-meta-box2' => array(
				/* meta box title */
				'title'          => esc_html__('Simple Meta Box Demo 2','text-domain'),
				/* post types, accept custom post types as well, default and is array('post'); optional  */
				'post_types'     => array('page','post'),
				/* where the meta box appear: normal (default), advanced, side;  */
				'context'        => 'normal',
				/* order of meta box: high (default), low; optional */
				'priority'       => 'high',
			),
		),
		'sections'=> array(


			/*
			----------------------------------------------------
			section listed in "Simple Meta Box Demo 1" meta-Box
			----------------------------------------------------
			*/
			'fp-option-checkbox' => array(
				'title' => esc_html__('Checkbox','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-color' => array(
				'title' => esc_html__('Colors','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-date' => array(
				'title' => esc_html__('Date','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-email' => array(
				'title' => esc_html__('Email','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-file' => array(
				'title' => esc_html__('File','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-gallery' => array(
				'title' => esc_html__('Gallery','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-image' => array(
				'title' => esc_html__('Image','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-icon' => array(
				'title' => esc_html__('Icon','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-map' => array(
				'title' => esc_html__('Map','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-number' => array(
				'title' => esc_html__('Number','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-radio' => array(
				'title' => esc_html__('Radio','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-repeater' => array(
				'title' => esc_html__('Repeater','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-nested-repeater' => array(
				'title' => esc_html__('Nested Repeater','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-nested-menu-repeater' => array(
				'title' => esc_html__('Nested Menu Repeater','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-select-image' => array(
				'title' => esc_html__('Select Image','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-select' => array(
				'title' => esc_html__('Select','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-sortable' => array(
				'title' => esc_html__('Sortable','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-switcher' => array(
				'title' => esc_html__('Switcher','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-tabs' => array(
				'title' => esc_html__('Tabs','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-text' => array(
				'title' => esc_html__('Text','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-textarea' => array(
				'title' => esc_html__('Textarea','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-url' => array(
				'title' => esc_html__('Url','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-wysiwyg' => array(
				'title' => esc_html__('Wysiwyg','text-domain'),
				'meta_box' => 'fp-demo-meta-box1'
			),
			'fp-option-general-option' => array(
				'title' => esc_html__('General Options','text-domain'),
				'meta_box' => 'fp-demo-meta-box2'
			),
		),

		'fields'=> array(


			/*
			-----------------------------------------------------
			 fields listed in "Simple Meta Box Demo 1" Meta-Box
			-----------------------------------------------------
			*/
			//-----------------checkbox---------------------------
			'fp-option-field-checkbox'  => array(
				'type'  => 'checkbox',
				'label' => esc_html__( 'Checkbox', 'text-domain' ),
				'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
				'section' => 'fp-option-checkbox'
			),

			//checkbox multiple options
			'fp-field-checkbox-multiple-options'  => array(
				'type'  => 'checkbox',
				'label' => esc_html__( 'Checkbox with Multiple Options' , 'text-domain' ),
				'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
				'section' => 'fp-option-checkbox',
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
			),
			//checkbox multiple options horizontal
			'fp-field-checkbox-multiple-options-horizontal'  => array(
				'type'  => 'checkbox',
				'label' => esc_html__( 'Checkbox with Multiple Options Horizontal' , 'text-domain' ),
				'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
				'section' => 'fp-option-checkbox',
				'wrap-attr' => array(
					'class' => 'fp-inline'
				),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
			),
			//Help Info
			'fp-field-checkbox-help-info'  => array(
				'type'  => 'checkbox',
				'label' => esc_html__( 'Checkbox with Help Information' , 'text-domain' ),
				'info' => esc_html__( 'Some Description goes here', 'text-domain' ),
				'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
				'section' => 'fp-option-checkbox'
			),
			//option and default
			'fp-field-checkbox-option-and-default'  => array(
				'type'  => 'checkbox',
				'label' => esc_html__( 'Checkbox with Options and Default' , 'text-domain' ),
				'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
				'section' => 'fp-option-checkbox',
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'default' => array('red'),

			),
			//checkbox with post
			'fp-field-checkbox-post'  => array(
				'type'  => 'checkbox',
				'label' => esc_html__( 'Checkbox with Posts' , 'text-domain' ),
				'info' => esc_html__( 'Set choices => posts', 'text-domain' ),
				'section' => 'fp-option-checkbox',
				'choices' => 'posts',
			),
			//checkbox with page
			'fp-field-checkbox-page'  => array(
				'type'  => 'checkbox',
				'info' => esc_html__( 'Set choices => pages', 'text-domain' ),
				'label' => esc_html__( 'Checkbox with Pages' , 'text-domain' ),
				'section' => 'fp-option-checkbox',
				'choices' => 'pages'
			),
			//checkbox with post catgories
			'fp-field-checkbox-categories'  => array(
				'type'  => 'checkbox',
				'label' => esc_html__( 'Checkbox with Post Categories' , 'text-domain' ),
				'checkbox-label' => esc_html__( 'Uncategorized', 'text-domain' ),
				'info' => esc_html__( 'Set choices => categories', 'text-domain' ),
				'section' => 'fp-option-checkbox',
				'choices' => 'categories',
			),
			//checkbox with tags
			'fp-field-checkbox-tags'  => array(
				'type'  => 'checkbox',
				'label' => esc_html__( 'Checkbox with Post tags' , 'text-domain' ),
				'checkbox-label' => esc_html__( 'tags', 'text-domain' ),
				'info' => esc_html__( 'Set choices => tags', 'text-domain' ),
				'section' => 'fp-option-checkbox',
				'choices' => 'tags',
			),
			//checkbox with CPT posts
			/**
			 *to get CPT post "query_args" and "choices" are required.
			 * 'query_args' accecpted all the args of wp_query.
			 * 'choices' must be post
			 */
			'fp-field-checkbox-cpt-post'  => array(
				'type'  => 'checkbox',
				'query_args' =>array(
					'post_type'=> 'download', //change with your post_type
				),
				'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of wp_query & "choices" must be "post"', 'text-domain' ),
				'label' => esc_html__( 'Checkbox with CPT posts' , 'text-domain' ),
				'checkbox-label' => esc_html__( 'Post 1', 'text-domain' ),
				'choices' =>'post',
				'section' => 'fp-option-checkbox'
			),
			//checkbox with CPT categories
			/**
			 *to get CPT categories "query_args" and "choices" are required.
			 * 'query_args' accecpted all the args of get_terms(excluded get-terms)
			 * 'choices' must be taxonomy
			 */
			'fp-field-checkbox-cpt-categories'  => array(
				'type'  => 'checkbox',
				'query_args' => array(
					'taxonomy'   => 'download_category',
					'hide_empty' => false,
				),
				'choices' =>'taxonomy',
				'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'text-domain' ),
				'label' => esc_html__( 'Checkbox with CPT categories' , 'text-domain' ),
				'checkbox-label' => esc_html__( 'CPT uncategories', 'text-domain' ),
				'section' => 'fp-option-checkbox'
			),
			//checkbox with CPT tags
			/**
			 *to get CPT tags "query_args" and "choices" are required.
			 * 'query_args' accecpted all the args of get_terms(excluded get-terms)
			 * 'choices' must be taxonomy
			 */
			'fp-field-checkbox-cpt-tags'  => array(
				'type'  => 'checkbox',
				'query_args' => array(
					'taxonomy'   => 'download_tag',
					'hide_empty' => false,
				),
				'choices' =>'taxonomy',
				'info' => esc_html__( ' query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'text-domain' ),
				'label' => esc_html__( 'Checkbox with CPT tags' , 'text-domain' ),
				'checkbox-label' => esc_html__( 'CPT tags', 'text-domain' ),
				'section' => 'fp-option-checkbox'
			),
			//-----------------color-------------------------------
			'fp-option-field-color'  => array(
				'type'  => 'color',
				'label' => esc_html__( 'Color', 'text-domain' ),
				'section' => 'fp-option-color'
			),
			//Color Picker with Default
			'fp-field-color-default'  => array(
				'type'  => 'color',
				'default' => '#2196F3',
				'label' => esc_html__( 'Color Picker With Default', 'text-domain' ),
				'section' => 'fp-option-color'
			),
			//Color Picker with RGB Infromation
			'fp-field-color-with-rgba'  => array(
				'type'  => 'color',
				'label' => esc_html__( 'Color Picker With RGBA', 'text-domain' ),
				'attr' => array(
					'data-rgba' => true,
				),
				'section' => 'fp-option-color'
			),
			//Color Picker with Help
			'fp-field-color-help'  => array(
				'type'  => 'color',
				'info'  => esc_html__( 'Please select your favourite colour', 'text-domain' ),
				'label' => esc_html__( 'Color Picker with Help Information', 'text-domain' ),
				'section' => 'fp-option-color'
			),
			//
			//-----------------date-------------------------------
			//
			'fp-option-field-date'  => array(
				'type'  => 'date',
				'label' => esc_html__( 'Date', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-date'
			),
			// date with default
			'fp-option-field-default'  => array(
				'type'  => 'date',
				'default' => 'Jul 20, 2018',
				'label' => esc_html__( 'Date with Default', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-date'
			),
			//date with time
			'fp-option-field-date-with-time'  => array(
				'type'  => 'date',
				'label' => esc_html__( 'Date With Time', 'text-domain' ),
				'multiple' => true,
				'time' => array(
					'time-only' => false,
					'time-format' => 'HH:mm:ss',
				),
				'section' => 'fp-option-date'
			),
			'fp-option-field-time'  => array(
				'type'  => 'date',
				'label' => esc_html__( 'Time Only', 'text-domain' ),
				'multiple' => true,
				'time' => array(
					'time-only' => true,
					//http://trentrichardson.com/examples/timepicker/
					// follow above for time format
					'time-format' => 'HH:mm:ss',
				),
				'section' => 'fp-option-date'
			),
			//Date MM/DD/YY
			'fp-field-date-mm-dd-yy'  => array(
				'type'  => 'date',
				'label' => esc_html__( 'Date in MM/DD/YY format', 'text-domain' ),
				'multiple' => true,
				'attr' => array(
					//https://api.jqueryui.com/datepicker/
					'date-format' => 'mm/dd/yy'
				),
				'section' => 'fp-option-date'
			),
			//Date DD/MM/YY
			'fp-field-date-dd-mm-yy'  => array(
				'type'  => 'date',
				'label' => esc_html__( 'Date in DD-MM-YY format', 'text-domain' ),
				'multiple' => true,
				'attr' => array(
					'date-format' => 'dd-mm-yy'
				),
				'section' => 'fp-option-date'
			),
			//
			//-----------------email-------------------------------
			//
			'fp-option-field-email'  => array(
				'type'  => 'email',
				'label' => esc_html__( 'Email', 'text-domain' ),
				'section' => 'fp-option-email'
			),
			//email with placeholder
			'fp-field-email-placeholder'  => array(
				'type'  => 'email',
				'label' => esc_html__( 'Email With Placeholder', 'text-domain' ),
				'attr' => array(
					'placeholder'=>'Email placeholder....',
				),
				'section' => 'fp-option-email'
			),
			//email with Help Infromation
			'fp-field-email-help-inforamtion'  => array(
				'type'  => 'email',
				'label' => esc_html__( 'Email With Help Information.
					', 'text-domain' ),
				'info' => esc_html__( 'Please enter valid email address here.', 'text-domain' ),
				'section' => 'fp-option-email'
			),
			//email with default
			'fp-field-email-default'  => array(
				'type'  => 'email',
				'default' => esc_html__( 'xyz@gmail.com', 'text-domain' ),
				'label' => esc_html__( 'Email With Default value.', 'text-domain' ),
				'section' => 'fp-option-email'
			),
			//-----------------file-------------------------------
			'fp-option-field-file'  => array(
				'type'  => 'file',
				'label' => esc_html__( 'File Upload', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-file'
			),
			//file upload with descriptions
			'fp-field-file-description'  => array(
				'type'  => 'file',
				'label' => esc_html__( 'File upload With Description', 'text-domain' ),
				'desc'  => esc_html__( 'Max: File size upto 5 MB', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-file'
			),
			//file upload with Help Infroamtion
			'fp-field-file-help-information'  => array(
				'type'  => 'file',
				'label' => esc_html__( 'File upload With Help Information', 'text-domain' ),
				'info' => esc_html__( 'This is required field.', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-file'
			),
			//file upload with default
			'fp-field-file-default'  => array(
				'type'  => 'file',
				'default' => 'screenshot-1.png',
				'label' => esc_html__( 'File upload With Help Default', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-file'
			),
			//file upload with custom uploader title
			'fp-field-file-custom-uploader-title'  => array(
				'type'  => 'file',
				'upload_title' => esc_html__( 'Custom Upload Title', 'text-domain' ),
				'label' => esc_html__( 'File upload With Custom Uploder Title', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-file'
			),
			//file upload with custom button title
			// this button is visible when we upload the any item.
			'fp-field-file-custom-button_title'  => array(
				'type'  => 'file',
				'button_text' => esc_html__( 'Custom Button', 'text-domain' ),
				'label' => esc_html__( 'File upload With Custom Selector Title', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-file'
			),
			//-----------------gallery-------------------------------
			'fp-option-field-gallery'  => array(
				'type'  => 'gallery',
				'label' => esc_html__( 'Gallery', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-gallery'
			),
			//gallery with help infromation
			'fp-field-gallery-help-information'  => array(
				'type'  => 'gallery',
				'label' => esc_html__( 'Gallery With Help Information', 'text-domain' ),
				'info'  => esc_html__( 'Selected images are used as slider image.', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-gallery'
			),
			//gallery with custom button title
			'fp-field-gallery-custom-uploader-title'  => array(
				'type'  => 'gallery',
				'upload_title' => esc_html__( 'Select Slider', 'text-domain' ),
				'label' => esc_html__( 'Gallery With Custom Uploader title', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-gallery'
			),
			//gallery with before text
			'fp-field-gallery-before-text'  => array(
				'type'  => 'gallery',
				'desc'  => array(
					'before-field' => 'Select Images for Slider', 'text-domain',
				),
				'label' => esc_html__( 'Gallery With Before Text', 'text-domain' ),
				'multiple' => true,
				'section' => 'fp-option-gallery'
			),
			//-----------------image-------------------------------
			'fp-option-field-image'  => array(
				'type'  => 'image',
				'label' => esc_html__( 'Image', 'text-domain' ),
				'section' => 'fp-option-image'
			),
			// Image With default
			'fp-option-field-image-default'  => array(
				'type'  => 'image',
				'default' => 'screen-shot.png',
				'label' => esc_html__( 'Image With Default', 'text-domain' ),
				'section' => 'fp-option-image'
			),
			// Image With Help Information
			'fp-field-image-help-information'  => array(
				'type'  => 'image',
				'label' => esc_html__( 'Image With Help Information', 'text-domain' ),
				'info'  => esc_html__( 'This is required field', 'text-domain' ),
				'section' => 'fp-option-image'
			),
			// Image With After Text
			'fp-field-image-after-text'  => array(
				'type'  => 'image',
				'label' => esc_html__( 'Image with After Field Information', 'text-domain' ),
				'desc'  => esc_html__( 'Maximum upload file size: 5 MB.', 'text-domain' ),
				'section' => 'fp-option-image'
			),
			// Image With Before Text
			'fp-field-image-before-text'  => array(
				'type'  => 'image',
				'label' => esc_html__( 'Image with Before Field Information', 'text-domain' ),
				'desc'  => array(
					'before-field' => esc_html__( 'Maximum upload file size: 5 MB.', 'text-domain' ),
				),
				'section' => 'fp-option-image'
			),
			// Image With custom Uploder title
			'fp-field-image-custom-uploder-title'  => array(
				'type'  => 'image',
				'upload_title' => esc_html__( 'Custom Uploader', 'text-domain' ),
				'label' => esc_html__( 'Image With Custom Uploader Title', 'text-domain' ),
				'section' => 'fp-option-image'
			),
			// Image With custom selector title
			'fp-field-image-custom-selector-title'  => array(
				'type'  => 'image',
				'button_text' => esc_html__( 'Custom Selector', 'text-domain' ),
				'label' => esc_html__( 'Image With Custom Selector Title', 'text-domain' ),
				'section' => 'fp-option-image'
			),
			//-----------------icon--------------------------------
			'fp-option-field-icon'  => array(
				'type'  => 'icon',
				'label' => esc_html__( 'Icon Selector', 'text-domain' ),
				'section' => 'fp-option-icon'
			),
			// icon with Help Information
			'fp-field-icon-with-help-information'  => array(
				'type'  => 'icon',
				'info'  => esc_html__( 'This is required field', 'text-domain' ),
				'label' => esc_html__( 'Icon Selector With help Information', 'text-domain' ),
				'section' => 'fp-option-icon'
			),
			// icon with default value
			'fp-field-icon-default'  => array(
				'type'  => 'icon',
				'default' => 'fa fa-adjust',
				'label' => esc_html__( 'Icon With Default', 'text-domain' ),
				'section' => 'fp-option-icon'
			),
			// icon with after field text
			'fp-field-icon-after-field-text'  => array(
				'type'  => 'icon',
				'label' => esc_html__( 'Icon With After Field Text', 'text-domain' ),
				'desc' => esc_html__( 'Select Icon for the page.', 'text-domain' ),
				'section' => 'fp-option-icon'
			),
			//-----------------map---------------------------------
			'fp-option-field-map'  => array(
				'type'  => 'map',
				'label' => esc_html__( 'Map', 'text-domain' ),
				'search_label' => esc_html__( 'Search Map', 'text-domain' ),
				'attr' => array(
					'zoom'  => 5,
				),
				'section' => 'fp-option-map'
			),
			// Map with Default location
			'fp-field-map-default-location'  => array(
				'type'  => 'map',
				'default' =>'36.778261 ,-119.41793239999998',
				'label' => esc_html__( 'Map With Default Location', 'text-domain' ),
				'search_label' => esc_html__( 'Search Map', 'text-domain' ),
				'section' => 'fp-option-map'
			),
			// Map with custom search placeholder
			'fp-field-map-search-placeholder'  => array(
				'type'  => 'map',
				'label' => esc_html__( 'Map With Custom search Placeholder', 'text-domain' ),
				'search-placeholder' => esc_html__( 'Custom Placeholder', 'text-domain' ),
				'search_label' => esc_html__( 'Search Map', 'text-domain' ),
				'section' => 'fp-option-map'
			),
			// Map with custom search Button text
			'fp-field-map-custom-search-button-text'  => array(
				'type'  => 'map',
				'label' => esc_html__( 'Map With Custom Search Button Text', 'text-domain' ),
				'find-label'=> esc_html__( 'Search', 'text-domain' ),
				'search_label' => esc_html__( 'Search Map', 'text-domain' ),
				'section' => 'fp-option-map'
			),
			// Map with custom show map text
			'fp-field-map-custom-show-map-text'  => array(
				'type'  => 'map',
				'label' => esc_html__( 'Map With Custom Show Map Text', 'text-domain' ),
				'show-map-label' => esc_html__( 'Display Map', 'text-domain' ),
				'section' => 'fp-option-map'
			),
			// Map with Custom Zoom Level
			'fp-field-map-zoom-level'  => array(
				'type'  => 'map',
				'label' => esc_html__( 'Map With Zoom level', 'text-domain' ),
				'section' => 'fp-option-map'
			),
			// Map with set marker
			'fp-field-map-set-marker'  => array(
				'type'  => 'map',
				'label' => esc_html__( 'Set Marker in Map', 'text-domain' ),
				'section' => 'fp-option-map'
			),
			//-----------------number-------------------------------
			'fp-option-field-number'  => array(
				'type'  => 'number',
				'label' => esc_html__( 'Number', 'text-domain' ),
				'section' => 'fp-option-number'
			),
			//number with before label text
			'fp-field-number-before-label-text'  => array(
				'type'  => 'number',
				'desc'  => array(
					'before-label' => esc_html__( 'Some help information before the label', 'text-domain' ),
				),
				'label' => esc_html__( 'Number With Before Label Text', 'text-domain' ),
				'section' => 'fp-option-number'
			),
			//number with after label text
			'fp-field-number-after-label-text'  => array(
				'type'  => 'number',
				'desc'  => array(
					'after-label' => esc_html__( 'Some help information after the label', 'text-domain' ),
				),
				'label' => esc_html__( 'Number With After Label Text', 'text-domain' ),
				'section' => 'fp-option-number'
			),
			//number with before field text
			'fp-field-number-before-field-text'  => array(
				'type'  => 'number',
				'desc'  => array(
					'before-field' => esc_html__( 'Please provide us your age number.', 'text-domain' ),
				),
				'label' => esc_html__( 'Number With Before Field Text', 'text-domain' ),
				'section' => 'fp-option-number'
			),
			//number with after Field text
			'fp-field-number-after-field-text'  => array(
				'type'  => 'number',
				'desc'  => array(
					'after-field' => esc_html__( 'Only positive number are allowed.', 'text-domain' ),
				),
				'label' => esc_html__( 'Number With After Field Text', 'text-domain' ),
				'section' => 'fp-option-number'
			),
			//number with help
			'fp-field-number-help'  => array(
				'type'  => 'number',
				'info'  => esc_html__( 'This field is required.', 'text-domain' ),
				'label' => esc_html__( 'Number with Help Information', 'text-domain' ),
				'section' => 'fp-option-number'
			),
			//number with default
			'fp-field-number-default'  => array(
				'type'  => 'number',
				'default' => 1,
				'label' => esc_html__( 'Number with Default', 'text-domain' ),
				'section' => 'fp-option-number'
			),
			//number with placeholder
			'fp-field-number-placeholder'  => array(
				'type'  => 'number',
				'label' => esc_html__( 'Number With Placeholder', 'text-domain' ),
				'attr' => array(
					'placeholder' => esc_html__( 'Allowed number from 0 to 10 only...', 'text-domain' ),
				),
				'section' => 'fp-option-number'
			),
			//number with Max value
			'fp-field-number-max'  => array(
				'type'  => 'number',
				'label' => esc_html__( 'Number With Max Value', 'text-domain' ),
				'desc' => esc_html__( 'Note: Max number allowed is 10', 'text-domain' ),
				'attr' => array(
					'max' => 10,
				),
				'section' => 'fp-option-number'
			),
			//number with Min value and max value
			'fp-field-number-min-max'  => array(
				'type'  => 'number',
				'label' => esc_html__( 'Number With Min and Max Value', 'text-domain' ),
				'desc' => esc_html__( 'Note: Number accepted between Min 10 & Max 20. ', 'text-domain' ),
				'attr' => array(
					'min' => 10,
					'max' => 20,
				),
				'default' => 11,
				'section' => 'fp-option-number'
			),
			//-----------------radio--------------------------------
			'fp-option-field-radio'  => array(
				'type'  => 'radio',
				'label' => esc_html__( 'Radio', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'section' => 'fp-option-radio'
			),
			// radio with before field text
			'fp-field-radio-before-text'  => array(
				'type'  => 'radio',
				'desc'  =>array(
					'before-field' => esc_html__( 'Choose any of them from available option:-', 'text-domain' ),
				),
				'label' => esc_html__( 'Radio with Before Field Text', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'section' => 'fp-option-radio'
			),
			// radio with after field text
			'fp-field-radio-after-text'  => array(
				'type'  => 'radio',
				'desc'  =>array(
					'after-field' => esc_html__( 'Choose any of them from available option:-', 'text-domain' ),
				),
				'label' => esc_html__( 'Radio with After Field Text', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'section' => 'fp-option-radio'
			),
			// radio with after label text
			'fp-field-radio-label-after-text'  => array(
				'type'  => 'radio',
				'desc'  =>array(
					'after-label' => esc_html__( 'Choose any of the option:-', 'text-domain' ),
				),
				'label' => esc_html__( 'Radio with After Label Text', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'section' => 'fp-option-radio'
			),
			//radio with default red value
			'fp-field-radio-default'  => array(
				'type'  => 'radio',
				'label' => esc_html__( 'Radio with Default Red Value', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				"default" => 'red',
				'section' => 'fp-option-radio'
			),
			//radio with help Information
			'fp-field-radio-help'  => array(
				'type'  => 'radio',
				'info' => esc_html__( 'Select your suitable item.', 'text-domain' ),
				'label' => esc_html__( 'Radio With Help Information', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				"default" => 'yellow',
				'section' => 'fp-option-radio'
			),
			//radio with horizontal
			'fp-field-radio-horizonatl'  => array(
				'type'  => 'radio',
				'label' => esc_html__( 'Radio On Horizontal View', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'wrap-attr' => array(
					'class' => 'fp-inline'
				),
				"default" => 'yellow',
				'section' => 'fp-option-radio'
			),
			//radio with page
			'fp-field-radio-pages'  => array(
				'type'  => 'radio',
				'label' => esc_html__( 'Radio with Pages', 'text-domain' ),
				'choices' => 'pages',
				'info' => esc_html__( 'Set choices => pages', 'text-domain' ),
				'section' => 'fp-option-radio'
			),
			//radio with posts
			'fp-field-radio-posts'  => array(
				'type'  => 'radio',
				'label' => esc_html__( 'Radio with Posts', 'text-domain' ),
				'choices' =>'posts',
				'info' => esc_html__( 'Set choices => posts', 'text-domain' ),
				'section' => 'fp-option-radio'
			),
			//radio with post categories
			'fp-field-radio-posts-catgories'  => array(
				'type'  => 'radio',
				'label' => esc_html__( 'Radio with Posts Categories', 'text-domain' ),
				'choices' => 'categories',
				'info' => esc_html__( 'Set choices => categories', 'text-domain' ),
				'section' => 'fp-option-radio'
			),
			//radio with post tags
			'fp-field-radio-posts-tags'  => array(
				'type'  => 'radio',
				'label' => esc_html__( 'Radio with Posts Tags', 'text-domain' ),
				'choices' => 'tags',
				'info' => esc_html__( 'Set choices => tags', 'text-domain' ),
				'section' => 'fp-option-radio'
			),
			//radio with cpt posts
			/**
			 *to get CPT post "query_args" and "choices" are required.
			 * 'query_args' accecpted all the args of wp_query.
			 * 'choices' must be post
			 */
			'fp-field-radio-cpt-posts'  => array(
				'type'  => 'radio',
				'query_args' =>array(
					'post_type'=> 'download', //change with your post_type
				),
				'label' => esc_html__( 'Radio with CPT Posts', 'text-domain' ),
				'choices' =>'posts',
				'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of wp_query & "choices" must be "post"', 'text-domain' ),
				'section' => 'fp-option-radio'
			),
			//radio with cpt categories
			'fp-field-radio-cpt-categories'  => array(
				'type'  => 'radio',
				'query_args' => array(
					'taxonomy'   => 'download_category',
					'hide_empty' => false,
				),
				'label' => esc_html__( 'Radio with CPT Categories', 'text-domain' ),
				'choices' =>'taxonomy',
				'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'text-domain' ),
				"default" => 'yellow',
				'section' => 'fp-option-radio'
			),
			//radio with cpt tags
			'fp-field-radio-cpt-tags'  => array(
				'type'  => 'radio',
				'query_args' => array(
					'taxonomy'   => 'download_tag',
					'hide_empty' => false,
				),
				'label' => esc_html__( 'Radio with CPT Tags', 'text-domain' ),
				'choices' =>'taxonomy',
				'info' => esc_html__( ' query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'text-domain' ),
				"default" => 'yellow',
				'section' => 'fp-option-radio'
			),
			//-----------------repeater------------------------------
			'fp-option-field-repeater' => array(
				'type'  => 'repeater',
				'fields'=> array(
					'fp-option-repeater-checkbox'  => array(
						'type'  => 'checkbox',
						'label' => esc_html__( 'Checkbox', 'text-domain' ),
						'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
					),
					'fp-option-repeater-checkbox-multiple'  => array(
						'type'  => 'checkbox',
						'label' => esc_html__( 'Checkbox Multiple', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						'wrap-attr' => array(
							'class'  => 'inline-block',
						),
					),
					'fp-option-repeater-checkbox-post'  => array(
						'type'  => 'checkbox',
						'label' => esc_html__( 'Checkbox Post', 'text-domain' ),
						'choices' => 'posts',
					),
					'fp-option-repeater-color'  => array(
						'type'  => 'color',
						'label' => esc_html__( 'Color', 'text-domain' ),
					),
					'fp-option-repeater-date'  => array(
						'type'  => 'date',
						'label' => esc_html__( 'Date', 'text-domain' ),
						'multiple' => true,
					),
					'fp-option-repeater-date-time'  => array(
						'type'  => 'date',
						'label' => esc_html__( 'Date and Time', 'text-domain' ),
						'multiple' => true,
						'time' => true,
					),
					'fp-option-repeater-time-only'  => array(
						'type'  => 'date',
						'label' => esc_html__( 'Time Only', 'text-domain' ),
						'multiple' => true,
						'time' =>array(
							'time-only' => true,
							'time-format' =>''
						),
					),
					'fp-option-repeater-email'  => array(
						'type'  => 'email',
						'label' => esc_html__( 'Email', 'text-domain' ),
					),
					'fp-option-repeater-file'  => array(
						'type'  => 'file',
						'label' => esc_html__( 'File', 'text-domain' ),
						'multiple' => true,
					),
					'fp-option-repeater-gallery'  => array(
						'type'  => 'gallery',
						'label' => esc_html__( 'Gallery', 'text-domain' ),
						'multiple' => true,
					),
					'fp-option-repeater-icon'  => array(
						'type'  => 'icon',
						'label' => esc_html__( 'Icon Selector', 'text-domain' ),
					),
					'fp-option-repeater-image'  => array(
						'type'  => 'image',
						'label' => esc_html__( 'Image', 'text-domain' ),
					),
					'fp-option-repeater-map'  => array(
						'type'  => 'map',
						'label' => esc_html__( 'Map', 'text-domain' ),
						'search_label' => esc_html__( 'Search Map', 'text-domain' ),
					),
					'fp-option-repeater-number'  => array(
						'type'  => 'number',
						'label' => esc_html__( 'Number', 'text-domain' ),
					),
					'fp-option-repeater-radio'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						"default" => 'yellow',
					),
					'fp-option-repeater-select-image'  => array(
						'type'  => 'select-image',
						'label' => esc_html__( 'Select Image', 'text-domain' ),
						'choices' => array(
							'red'   => 'https://addonspress.com/wp-content/uploads/edd/2018/07/documentation-press.jpg',
							'green' => 'https://addonspress.com/wp-content/uploads/edd/2018/07/field-press.jpg',
						),
					),
					'fp-option-repeater-select'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
					),
					'fp-option-repeater-select-multiple'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select Multiple', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						'attr' => array(
							'multiple'  => 'multiple',
						),
					),
					'fp-option-repeater-select-post'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select Post', 'text-domain' ),
						'choices' => 'posts',
					),
					'fp-option-repeater-sortable'  => array(
						'type'  => 'sortable',
						'label' => esc_html__( 'Sortable', 'text-domain' ),
						'choices' => array(
							'active'      => array(
								'red'   => esc_html__( 'Red', 'fieldpress' ),
								'green' => esc_html__( 'Green', 'fieldpress' ),
								'blue'  => esc_html__( 'Blue', 'fieldpress' ),
								'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
								'orange'=> esc_html__( 'Orange', 'fieldpress' ),
								'ocean'=> esc_html__( 'Ocean', 'fieldpress' ),
							),
							'inactive'     => array(
								'black'=> esc_html__( 'Black', 'fieldpress' ),
								'white'=> esc_html__( 'White', 'fieldpress' ),
							)
						),
						'active_title'  => esc_html__( 'Active Colors', 'fieldpress' ),
						'inactive_title' => esc_html__( 'Deactivate Colors', 'fieldpress' ),
					),
					'fp-option-repeater-switcher'  => array(
						'type'  => 'switcher',
						'label' => esc_html__( 'Switcher', 'text-domain' ),
						'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
					),
					'fp-option-repeater-tabs' => array(
						'type' => 'tabs',
						'tabs' => array(
							'fp-option-repeater-tab1'=>array(
								'label'     => esc_html__( 'Tab1', 'text-domain' ),
							),
							'fp-option-repeater-tab2'=>array(
								'label'     => esc_html__( 'Tab2', 'text-domain' ),
							),
							'fp-option-repeater-tab3'=>array(
								'label'     => esc_html__( 'Tab3', 'text-domain' ),
							),
							'fp-option-repeater-tab4'=>array(
								'label'     => esc_html__( 'Tab4', 'text-domain' ),
							),
						),
						'fields'=> array(
							'fp-option-repeater-tab1-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab1',
							),
							'fp-option-repeater-tab1-number'  => array(
								'type'  => 'number',
								'label' => esc_html__( 'Number', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab1',
							),
							'fp-option-repeater-tab1-url'  => array(
								'type'  => 'url',
								'label' => esc_html__( 'Url', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab1',

							),
							'fp-option-repeater-tab1-email'  => array(
								'type'  => 'email',
								'label' => esc_html__( 'Email', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab1',
							),
							'fp-option-repeater-tab-hidden'  => array(
								'type'  => 'hidden',
								'tab'  => 'fp-option-repeater-tab1',
							),
							'fp-option-repeater-tab-textarea'  => array(
								'type'  => 'textarea',
								'label' => esc_html__( 'Textarea', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab2',
							),
							'fp-option-repeater-tab-colors'  => array(
								'type'  => 'color',
								'label' => esc_html__( 'Color', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab2',
							),
							'fp-option-repeater-tab-image'  => array(
								'type'  => 'image',
								'label' => esc_html__( 'Image', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab2',
							),
							'fp-option-repeater-tab-gallery'  => array(
								'type'  => 'gallery',
								'label' => esc_html__( 'Gallery', 'text-domain' ),
								'multiple' => true,
								'tab'  => 'fp-option-repeater-tab2',
							),
							'fp-option-repeater-tab-files'  => array(
								'type'  => 'file',
								'label' => esc_html__( 'File', 'text-domain' ),
								'multiple' => true,
								'tab'  => 'fp-option-repeater-tab2',
							),
							'fp-option-repeater-tab-date'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Date', 'text-domain' ),
								'multiple' => true,
								'tab'  => 'fp-option-repeater-tab2',
							),
							'fp-option-repeater-tab-date-time'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Date and Time', 'text-domain' ),
								'multiple' => true,
								'time' => true,
								'tab'  => 'fp-option-repeater-tab2',
							),
							'fp-option-repeater-tab-time-only'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Time Only', 'text-domain' ),
								'multiple' => true,
								'time' =>array(
									'time-only' => true,
									'time-format' =>''
								),
								'tab'  => 'fp-option-repeater-tab2',
							),
							'fp-option-repeater-tab-map'  => array(
								'type'  => 'map',
								'label' => esc_html__( 'Map', 'text-domain' ),
								'search_label' => esc_html__( 'Search Map', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab2',
							),
							'fp-option-repeater-tab-checkbox'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox', 'text-domain' ),
								'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab2'
							),
							'fp-option-repeater-tab-checkbox-multiple'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox Multiple', 'text-domain' ),
								'choices' => array(
									'red'   => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue'  => esc_html__( 'Blue', 'fieldpress' ),
									'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
								),
								'wrap-attr' => array(
									'class'  => 'inline-block',
								),
								'tab'  => 'fp-option-repeater-tab2',

							),
							'fp-option-repeater-tab-checkbox-post'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox Post', 'text-domain' ),
								'choices' => 'posts',
								'tab'  => 'fp-option-repeater-tab3',
							),
							'fp-option-repeater-tab-select'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select', 'text-domain' ),
								'choices' => array(
									'red'   => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue'  => esc_html__( 'Blue', 'fieldpress' ),
									'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
								),
								'tab'  => 'fp-option-repeater-tab3',
							),
							'fp-option-repeater-tab-select-multiple'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select Multiple', 'text-domain' ),
								'choices' => array(
									'red'   => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue'  => esc_html__( 'Blue', 'fieldpress' ),
									'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
								),
								'attr' => array(

									'multiple'  => 'multiple',
								),
								'tab'  => 'fp-option-repeater-tab3',
							),
							'fp-option-repeater-tab-select-post'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select Post', 'text-domain' ),
								'choices' => 'posts',
								'tab'  => 'fp-option-repeater-tab3',
							),
							'fp-option-repeater-tab-radio'  => array(
								'type'  => 'radio',
								'label' => esc_html__( 'Radio', 'text-domain' ),
								'choices' => array(
									'red'   => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue'  => esc_html__( 'Blue', 'fieldpress' ),
									'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
								),
								"default" => 'yellow',
								'tab'  => 'fp-option-repeater-tab3',
							),
							'fp-option-repeater-tab-wysiwyg'  => array(
								'type'  => 'wysiwyg',
								'label' => esc_html__( 'Wysiwyg', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab3',
							),
							'fp-option-repeater-tab-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab4',
							),
							'fp-option-repeater-tab-number'  => array(
								'type'  => 'number',
								'label' => esc_html__( 'Number', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab4',
							),
							'fp-option-repeater-tab-url'  => array(
								'type'  => 'url',
								'label' => esc_html__( 'Url', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab4',

							),
							'fp-option-repeater-tab-email'  => array(
								'type'  => 'email',
								'label' => esc_html__( 'Email', 'text-domain' ),
								'tab'  => 'fp-option-repeater-tab4',
							),
						),
					),
					'fp-option-repeater-text'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text', 'text-domain' ),
					),
					'fp-option-repeater-textarea'  => array(
						'type'  => 'textarea',
						'label' => esc_html__( 'Textarea', 'text-domain' ),
					),
					'fp-option-repeater-url'  => array(
						'type'  => 'url',
						'label' => esc_html__( 'Url', 'text-domain' ),
					),
					'fp-option-repeater-wysiwyg'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg', 'text-domain' ),
					),
				),
				'section' => 'fp-option-repeater'
			),
			//-----------------nested-repeater------------------------------
			'fp-field-nested-repeater' => array(
				'type'  => 'repeater',
				'nested' => true,
				'fields'=> array(
					'fp-nested-repeater-text'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text', 'text-domain' ),
					),
					'fp-nested-repeater-radio'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						"default" => 'yellow',
					),
					'fp-nested-repeater-select'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
					),
					'fp-nested-repeater-switcher'  => array(
						'type'  => 'switcher',
						'label' => esc_html__( 'Switcher', 'text-domain' ),
						'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
					),
					'fp-nested-repeater-wysiwyg'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg', 'text-domain' ),
					),
					/*repeater into repeater*/
					'fp-nested-repeater-into-repeater'  => array(
						'type'  => 'repeater',
						'label' => esc_html__( 'Repeater', 'text-domain' ),
						'nested' => true,
						'fields'=> array(
							'fp-nested-repeater-into-repeater-checkbox'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox', 'text-domain' ),
								'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
							),
							'fp-nested-repeater-into-repeater-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'text-domain' ),
								'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
							),
						),
					),
				),
				'section' => 'fp-option-nested-repeater'
			),
			//-----------------nested menu repeater------------------------------
			'fp-nested-menu-repeater' => array(
				'type'  => 'repeater',
				'nested'=> true,
				'fields'=> array(
					'fp-option-repeater-text'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text', 'text-domain' ),
					),
					'fp-option-repeater-checkbox'  => array(
						'type'  => 'checkbox',
						'label' => esc_html__( 'Checkbox', 'text-domain' ),
						'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
					),
					'fp-option-repeater-radio'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						"default" => 'yellow',
					),
					'fp-option-repeater-select'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
					),
					'fp-option-repeater-switcher'  => array(
						'type'  => 'switcher',
						'label' => esc_html__( 'Switcher', 'text-domain' ),
						'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
					),
					'fp-option-repeater-textarea'  => array(
						'type'  => 'textarea',
						'label' => esc_html__( 'Textarea', 'text-domain' ),
					),
					'fp-option-repeater-wysiwyg'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg', 'text-domain' ),
					),
				),
				'section' => 'fp-option-nested-menu-repeater'
			),
			//-----------------select-image--------------------------
			'fp-option-field-select-image'  => array(
				'type'  => 'select-image',
				'label' => esc_html__( 'Select Image', 'text-domain' ),
				'choices' => array(
					'red'   => 'https://addonspress.com/wp-content/uploads/edd/2018/07/documentation-press.jpg',
					'green' => 'https://addonspress.com/wp-content/uploads/edd/2018/07/field-press.jpg',
				),
				'section' => 'fp-option-select-image'
			),
			//select image with default
			'fp-field-select-image-default'  => array(
				'type'  => 'select-image',
				'label' => esc_html__( 'Select Image With Default', 'text-domain' ),
				'default' => array('red'),
				'choices' => array(
					'red'   => 'https://addonspress.com/wp-content/uploads/edd/2018/07/documentation-press.jpg',
					'green' => 'https://addonspress.com/wp-content/uploads/edd/2018/07/field-press.jpg',
				),
				'section' => 'fp-option-select-image'
			),
			//select image with multiple select
			'fp-field-select-image-multiple-select'  => array(
				'type'  => 'select-image',
				'label' => esc_html__( 'Select Image With Multiple Select', 'text-domain' ),
				'choices' => array(
					'red'   => 'https://addonspress.com/wp-content/uploads/edd/2018/07/documentation-press.jpg',
					'green' => 'https://addonspress.com/wp-content/uploads/edd/2018/07/field-press.jpg',
				),
				'attr' => array(
					'multiple'  => 'multiple',
				),
				'section' => 'fp-option-select-image'
			),
			//select image with help
			'fp-field-select-image-help'  => array(
				'type'  => 'select-image',
				'label' => esc_html__( 'Select Image With Help Information', 'text-domain' ),
				'info' => esc_html__( 'Select Image for Slider', 'text-domain' ),
				'choices' => array(
					'red'   => 'https://addonspress.com/wp-content/uploads/edd/2018/07/documentation-press.jpg',
					'green' => 'https://addonspress.com/wp-content/uploads/edd/2018/07/field-press.jpg',
				),
				'section' => 'fp-option-select-image'
			),
			//select image with before field text
			'fp-field-select-image-before-field-text'  => array(
				'type'  => 'select-image',
				'desc'  => array(
					'before-field'=> 'Select images for Slider from available images:-'
				),
				'label' => esc_html__( 'Select Image With Before Field Text', 'text-domain' ),
				'choices' => array(
					'red'   => 'https://addonspress.com/wp-content/uploads/edd/2018/07/documentation-press.jpg',
					'green' => 'https://addonspress.com/wp-content/uploads/edd/2018/07/field-press.jpg',
				),
				'section' => 'fp-option-select-image'
			),
			//select image with after field text
			'fp-field-select-image-after-field-text'  => array(
				'type'  => 'select-image',
				'desc'  => array(
					'after-field'=> 'Select images for Slider from available images:-'
				),
				'label' => esc_html__( 'Select Image With After Field Text', 'text-domain' ),
				'choices' => array(
					'red'   => 'https://addonspress.com/wp-content/uploads/edd/2018/07/documentation-press.jpg',
					'green' => 'https://addonspress.com/wp-content/uploads/edd/2018/07/field-press.jpg',
				),
				'section' => 'fp-option-select-image'
			),
			//-----------------select--------------------------------
			'fp-option-field-select'  => array(
				'type'  => 'select',
				'label' => esc_html__( 'Select', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'section' => 'fp-option-select'
			),
			// select with normal style
			'fp-field-select-normal'  => array(
				'type'  => 'select',
				'label' => esc_html__( 'Noraml Select', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'normal' => true,
				'section' => 'fp-option-select'
			),
			//select with first empty value
			'fp-field-select-first-empty'  => array(
				'type'  => 'select',
				'label' => esc_html__( 'Select With First Empty Values', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'section' => 'fp-option-select'
			),
			//select with help
			'fp-field-select-help'  => array(
				'type'  => 'select',
				'info' => esc_html__( 'Select your Favourite Colour:-', 'text-domain' ),
				'label' => esc_html__( 'Select With Help', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'section' => 'fp-option-select'
			),
			//select with default value
			'fp-field-select-default'  => array(
				'type'  => 'select',
				'label' => esc_html__( 'Select With Default Value', 'text-domain' ),
				'default' => 'green',
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'section' => 'fp-option-select'
			),
			//select with multi select
			'fp-field-select-multi-select'  => array(
				'type'  => 'select',
				'multiple' => true,
				'label' => esc_html__( 'Select With Multiple Select Value', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'attr' => array(

					'multiple' => true,
				),
				'section' => 'fp-option-select'
			),
			//select with multi select and default
			'fp-field-select-multi-select-default'  => array(
				'type'  => 'select',
				'label' => esc_html__( 'Select With Multiple Select With Default', 'text-domain' ),
				'choices' => array(
					'red'   => esc_html__( 'Red', 'fieldpress' ),
					'green' => esc_html__( 'Green', 'fieldpress' ),
					'blue'  => esc_html__( 'Blue', 'fieldpress' ),
					'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
				),
				'attr' => array(
					'multiple' => true,
				),
				'default' => array('green'),
				'section' => 'fp-option-select'
			),
			//select with pages
			'fp-field-select-pages'  => array(
				'type'  => 'select',
				'label' => esc_html__( 'Select With Pages', 'text-domain' ),
				'choices' =>'pages',
				'info' => esc_html__( 'Set choices => pages', 'text-domain' ),
				'section' => 'fp-option-select'
			),
			//select with post
			'fp-field-select-post'  => array(
				'type'  => 'select',
				'label' => esc_html__( 'Select With Posts', 'text-domain' ),
				'choices' =>'posts',
				'info' => esc_html__( 'Set choices => posts', 'text-domain' ),
				'section' => 'fp-option-select'
			),
			//select with post catgories
			'fp-field-select-post-categories'  => array(
				'type'  => 'select',
				'label' => esc_html__( 'Select With Post categories', 'text-domain' ),
				'choices' =>'categories',
				'info' => esc_html__( 'Set choices => categories', 'text-domain' ),
				'section' => 'fp-option-select'
			),
			//select with post tags
			'fp-field-select-post-tages'  => array(
				'type'  => 'select',
				'label' => esc_html__( 'Select With Posts Tages', 'text-domain' ),
				'choices' =>'tags',
				'info' => esc_html__( 'Set choices => tags', 'text-domain' ),
				'section' => 'fp-option-select'
			),
			//select with CPT posts
			/**
			 *to get CPT post "query_args" and "choices" are required.
			 * 'query_args' accecpted all the args of wp_query.
			 * 'choices' must be post
			 */
			'fp-field-select-cpt-post'  => array(
				'type'  => 'select',
				'query_args' =>array(
					'post_type'=> 'download',
				),
				'label' => esc_html__( 'Select With CPT Posts', 'text-domain' ),
				'choices' =>'post',
				'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of wp_query & "choices" must be "post"', 'text-domain' ),

				'section' => 'fp-option-select'
			),
			//select with CPT categories
			/**
			 *to get CPT categories "query_args" and "choices" are required.
			 * 'query_args' accecpted all the args of get_terms(excluded get-terms)
			 * 'choices' must be taxonomy
			 */
			'fp-field-select-cpt-categories'  => array(
				'type'  => 'select',
				'query_args' => array(
					'taxonomy'   => 'download_category',
					'hide_empty' => false,
				),
				'label' => esc_html__( 'Select With CPT Categories', 'text-domain' ),
				'choices' =>'taxonomy',
				'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'text-domain' ),
				'section' => 'fp-option-select'
			),
			//select with CPT tags
			/**
			 *to get CPT tags "query_args" and "choices" are required.
			 * 'query_args' accecpted all the args of get_terms(excluded get-terms)
			 * 'choices' must be taxonomy
			 */
			'fp-field-select-cpt-tags'  => array(
				'type'  => 'select',
				'query_args' => array(
					'taxonomy'   => 'download_tag',
					'hide_empty' => false,
				),
				'choices' =>'taxonomy',
				'info' => esc_html__( ' query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'text-domain' ),
				'label' => esc_html__( 'Select With CPT Tags', 'text-domain' ),
				'section' => 'fp-option-select'
			),
			//-----------------sortable--------------------------------
			'fp-option-field-sortable'  => array(
				'type'  => 'sortable',
				'label' => esc_html__( 'Sortable', 'text-domain' ),
				'choices' => array(
					'active'      => array(
						'red'   => esc_html__( 'Red', 'fieldpress' ),
						'green' => esc_html__( 'Green', 'fieldpress' ),
						'blue'  => esc_html__( 'Blue', 'fieldpress' ),
						'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						'orange'=> esc_html__( 'Orange', 'fieldpress' ),
						'ocean'=> esc_html__( 'Ocean', 'fieldpress' ),
					),
					'inactive'     => array(
						'black'=> esc_html__( 'Black', 'fieldpress' ),
						'white'=> esc_html__( 'White', 'fieldpress' ),
					)
				),
				'section' => 'fp-option-sortable'
			),
			// sortable with active and deactive title
			'fp-field-sortable-social-sharing'  => array(
				'type'  => 'sortable',
				'label' => esc_html__( 'Sortable', 'text-domain' ),
				'choices' => array(
					'active'      => array(
						'facebook'=> esc_html__( 'Facebook', 'fieldpress' ),
						'instagram'=> esc_html__( 'Instagram', 'fieldpress' ),
						'twitter'=> esc_html__( 'Twitter', 'fieldpress' ),
						'googleplus'=> esc_html__( 'GooglePlus', 'fieldpress' ),
					),
					'inactive'     => array(
						'linkedin'=> esc_html__( 'Linkedin', 'fieldpress' ),
						'pinterest'=> esc_html__( 'Pinterest', 'fieldpress' ),
					)
				),
				'active_title'  => esc_html__( 'Active Social Sharing', 'fieldpress' ),
				'inactive_title' => esc_html__( 'Deactivate Social Sharing', 'fieldpress' ),
				'section' => 'fp-option-sortable'
			),
			//-----------------switcher--------------------------------
			'fp-option-field-switcher'  => array(
				'type'  => 'switcher',
				'label' => esc_html__( 'Switcher', 'text-domain' ),
				'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			//switcher with help
			'fp-field-switcher-help'  => array(
				'type'  => 'switcher',
				'info' => esc_html__( 'Enable Or Disable the setting', 'text-domain' ),
				'label' => esc_html__( 'Switcher With Help Information', 'text-domain' ),
				'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			//switcher without after text
			'fp-field-switcher-without'  => array(
				'type'  => 'switcher',
				'label' => esc_html__( 'Switcher Without After Text', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			//switcher with description
			'fp-field-switcher-description'  => array(
				'type'  => 'switcher',
				'label' => esc_html__( 'Switcher With description', 'text-domain' ),
				'desc'  => esc_html__( 'Switcher helps to enable or disable the setting', 'text-domain' ),
				'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			/**
			 * # As checkbox ,radio, select in switcher also we retrive the post, page, post_type ,categories,tags
			 * pass 'query_args' and choice as pass in checkbok,radio,select.
			 */
			//switcher with posts
			'fp-field-switcher-posts'  => array(
				'type'  => 'switcher',
				'label' => esc_html__( 'Switcher With Posts', 'text-domain' ),
				'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
				'choices' => 'posts',
				'info' => esc_html__( 'Set choices => posts', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			//switcher with posts categories
			'fp-field-switcher-posts-categories'  => array(
				'type'  => 'switcher',
				'label' => esc_html__( 'Switcher With Post Categories', 'text-domain' ),
				'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
				'choices' => 'categories',
				'info' => esc_html__( 'Set choices => categories', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			//switcher with posts categories
			'fp-field-switcher-posts-tages'  => array(
				'type'  => 'switcher',
				'label' => esc_html__( 'Switcher With Post Tags', 'text-domain' ),
				'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
				'choices' => 'tags',
				'info' => esc_html__( 'Set choices => tags', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			//switcher with pages
			'fp-field-switcher-pages'  => array(
				'type'  => 'switcher',
				'label' => esc_html__( 'Switcher With Pages', 'text-domain' ),
				'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
				'choices' => 'pages',
				'info' => esc_html__( 'Set choices => pages', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			//switcher with CPT post
			/**
			 *to get CPT post "query_args" and "choices" are required.
			 * 'query_args' accecpted all the args of wp_query.
			 * 'choices' must be post
			 */
			'fp-field-switcher-cpt-posts'  => array(
				'type'  => 'switcher',
				'query_args' =>array(
					'post_type'=> 'download', // change post_type
				),
				'label' => esc_html__( 'Switcher With CPT Posts', 'text-domain' ),
				'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
				'choices' => 'post',
				'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of wp_query & "choices" must be "post"', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			//switcher with CPT Categories
			/**
			 *to get CPT categories "query_args" and "choices" are required.
			 * 'query_args' accecpted all the args of get_terms(excluded get-terms)
			 * 'choices' must be taxonomy
			 */
			'fp-field-switcher-cpt-categories'  => array(
				'type'  => 'switcher',
				'query_args' => array(
					'taxonomy'   => 'download_category',
					'hide_empty' => false,
				),
				'label' => esc_html__( 'Switcher With CPT categories', 'text-domain' ),
				'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
				'choices' => 'taxonomy',
				'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			//switcher with CPT tags
			/**
			 *to get CPT categories "query_args" and "choices" are required.
			 * 'query_args' accecpted all the args of get_terms(excluded get-terms)
			 * 'choices' must be taxonomy
			 */
			'fp-field-switcher-cpt-tags'  => array(
				'type'  => 'switcher',
				'query_args' => array(
					'taxonomy'   => 'download_category',
					'hide_empty' => false,
				),
				'label' => esc_html__( 'Switcher With CPT Tags', 'text-domain' ),
				'switcher-label' => esc_html__( 'Switch something', 'text-domain' ),
				'choices' => 'taxonomy',
				'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'text-domain' ),
				'section' => 'fp-option-switcher'
			),
			//-----------------tabs--------------------------------
			'fp-option-field-tabs' => array(
				'type' => 'tabs',
				'label' => esc_html__( 'Tabs Label', 'text-domain' ),
				'tabs' => array(
					'fp-option-tab1'=>array(
						'label'     => esc_html__(  'Tab1','text-domain' ),
						'icon'     => 'dashicons-before dashicons-admin-media',
						'icon-only' => true
					),
					'fp-option-tab2'=>array(
						'label'     => esc_html__(  'Tab2','text-domain' ),
						'icon'     => 'dashicons-before dashicons-admin-settings',
					),
					'fp-option-tab3'=>array(
						'label'     => esc_html__(  'Tab3','text-domain' ),
						'icon'     => 'fa fa-star',
					),
					'fp-option-tab4'=>array(
						'label'     => esc_html__(  'Tab4','text-domain' ),
						'icon'     => 'fa fa-folder',
					),
				),
				'fields'=> array(
					'fp-option-tab1-text'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text', 'text-domain' ),
						'tab'  => 'fp-option-tab1',
					),
					'fp-option-tab1-number'  => array(
						'type'  => 'number',
						'label' => esc_html__( 'Number', 'text-domain' ),
						'tab'  => 'fp-option-tab1',
					),
					'fp-option-tab1-url'  => array(
						'type'  => 'url',
						'label' => esc_html__( 'Url', 'text-domain' ),
						'tab'  => 'fp-option-tab1',

					),
					'fp-option-tab1-email'  => array(
						'type'  => 'email',
						'label' => esc_html__( 'Email', 'text-domain' ),
						'tab'  => 'fp-option-tab1',
					),
					'fp-option-tab-textarea'  => array(
						'type'  => 'textarea',
						'label' => esc_html__( 'Textarea', 'text-domain' ),
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-colors'  => array(
						'type'  => 'color',
						'label' => esc_html__( 'Color', 'text-domain' ),
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-image'  => array(
						'type'  => 'image',
						'label' => esc_html__( 'Image', 'text-domain' ),
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-gallery'  => array(
						'type'  => 'gallery',
						'label' => esc_html__( 'Gallery', 'text-domain' ),
						'multiple' => true,
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-files'  => array(
						'type'  => 'file',
						'label' => esc_html__( 'File', 'text-domain' ),
						'multiple' => true,
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-date'  => array(
						'type'  => 'date',
						'label' => esc_html__( 'Date', 'text-domain' ),
						'multiple' => true,
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-date-time'  => array(
						'type'  => 'date',
						'label' => esc_html__( 'Date and Time', 'text-domain' ),
						'multiple' => true,
						'time' => true,
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-time-only'  => array(
						'type'  => 'date',
						'label' => esc_html__( 'Time Only', 'text-domain' ),
						'multiple' => true,
						'time' =>array(
							'time-only' => true,
							'time-format' =>''
						),
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-map'  => array(
						'type'  => 'map',
						'label' => esc_html__( 'Map', 'text-domain' ),
						'search_label' => esc_html__( 'Search Map', 'text-domain' ),
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-checkbox'  => array(
						'type'  => 'checkbox',
						'label' => esc_html__( 'Checkbox', 'text-domain' ),
						'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
						'tab'  => 'fp-option-tab2'
					),
					'fp-option-tab-checkbox-multiple'  => array(
						'type'  => 'checkbox',
						'label' => esc_html__( 'Checkbox Multiple', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						'wrap-attr' => array(
							'class'  => 'inline-block',
						),
						'tab'  => 'fp-option-tab2',

					),
					'fp-option-tab-checkbox-post'  => array(
						'type'  => 'checkbox',
						'label' => esc_html__( 'Checkbox Post', 'text-domain' ),
						'choices' => 'posts',
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-select'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-select-multiple'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select Multiple', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						'attr' => array(
							'multiple'  => 'multiple',
						),
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-select-post'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select Post', 'text-domain' ),
						'choices' => 'posts',
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-radio'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						"default" => 'yellow',
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-wysiwyg'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg', 'text-domain' ),
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-text'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text', 'text-domain' ),
						'tab'  => 'fp-option-tab4',
					),
					'fp-option-tab-number'  => array(
						'type'  => 'number',
						'label' => esc_html__( 'Number', 'text-domain' ),
						'tab'  => 'fp-option-tab4',
					),
					'fp-option-tab-url'  => array(
						'type'  => 'url',
						'label' => esc_html__( 'Url', 'text-domain' ),
						'tab'  => 'fp-option-tab4',

					),
					'fp-option-tab-email'  => array(
						'type'  => 'email',
						'label' => esc_html__( 'Email', 'text-domain' ),
						'tab'  => 'fp-option-tab4',
					),
				),
				'section' => 'fp-option-tabs'
			),
			'fp-option-tabs-with-repeater' => array(
				'type' => 'tabs',
				'tabs' => array(
					'fp-option-tab1'=>array(
						'label'     => esc_html__(  'Tab1','text-domain' ),
					),
					'fp-option-tab2'=>array(
						'label'     => esc_html__(  'Tab2','text-domain' ),
					),
					'fp-option-tab3'=>array(
						'label'     => esc_html__(  'Tab3','text-domain' ),
					),
					'fp-option-tab4'=>array(
						'label'     => esc_html__(  'Tab4','text-domain' ),
					),
				),
				'fields'=> array(
					'fp-option-tab1-text'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text', 'text-domain' ),
						'tab'  => 'fp-option-tab1',
					),
					'fp-option-tab1-number'  => array(
						'type'  => 'number',
						'label' => esc_html__( 'Number', 'text-domain' ),
						'tab'  => 'fp-option-tab1',
					),

					/*repeater in tabs*/
					'fp-option-tab1-repeater'  => array(
						'type'  => 'repeater',
						'label' => esc_html__( 'Repeater', 'text-domain' ),
						'nested' => true,
						'fields'=> array(
							'fp-option-tab1-repeater-checkbox'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox', 'text-domain' ),
								'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
							),
							'fp-option-tab1-repeater-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'text-domain' ),
								'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
							),
						),
						'tab'  => 'fp-option-tab1',
					),

					'fp-option-tab-textarea'  => array(
						'type'  => 'textarea',
						'label' => esc_html__( 'Textarea', 'text-domain' ),
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-colors'  => array(
						'type'  => 'color',
						'label' => esc_html__( 'Color', 'text-domain' ),
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-image'  => array(
						'type'  => 'image',
						'label' => esc_html__( 'Image', 'text-domain' ),
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-gallery'  => array(
						'type'  => 'gallery',
						'label' => esc_html__( 'Gallery', 'text-domain' ),
						'multiple' => true,
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-files'  => array(
						'type'  => 'file',
						'label' => esc_html__( 'File', 'text-domain' ),
						'multiple' => true,
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-date'  => array(
						'type'  => 'date',
						'label' => esc_html__( 'Date', 'text-domain' ),
						'multiple' => true,
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-date-time'  => array(
						'type'  => 'date',
						'label' => esc_html__( 'Date and Time', 'text-domain' ),
						'multiple' => true,
						'time' => true,
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-time-only'  => array(
						'type'  => 'date',
						'label' => esc_html__( 'Time Only', 'text-domain' ),
						'multiple' => true,
						'time' =>array(
							'time-only' => true,
							'time-format' =>''
						),
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-map'  => array(
						'type'  => 'map',
						'label' => esc_html__( 'Map', 'text-domain' ),
						'search_label' => esc_html__( 'Search Map', 'text-domain' ),
						'tab'  => 'fp-option-tab2',
					),
					'fp-option-tab-checkbox'  => array(
						'type'  => 'checkbox',
						'label' => esc_html__( 'Checkbox', 'text-domain' ),
						'checkbox-label' => esc_html__( 'check for something', 'text-domain' ),
						'tab'  => 'fp-option-tab2'
					),
					'fp-option-tab-checkbox-multiple'  => array(
						'type'  => 'checkbox',
						'label' => esc_html__( 'Checkbox Multiple', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						'wrap-attr' => array(
							'class'  => 'inline-block',
						),
						'tab'  => 'fp-option-tab2',

					),
					'fp-option-tab-checkbox-post'  => array(
						'type'  => 'checkbox',
						'label' => esc_html__( 'Checkbox Post', 'text-domain' ),
						'choices' => 'posts',
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-select'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-select-multiple'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select Multiple', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						'attr' => array(
							'multiple'  => 'multiple',
						),
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-select-post'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select Post', 'text-domain' ),
						'choices' => 'posts',
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-radio'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio', 'text-domain' ),
						'choices' => array(
							'red'   => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue'  => esc_html__( 'Blue', 'fieldpress' ),
							'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						"default" => 'yellow',
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-wysiwyg'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg', 'text-domain' ),
						'tab'  => 'fp-option-tab3',
					),
					'fp-option-tab-text'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text', 'text-domain' ),
						'tab'  => 'fp-option-tab4',
					),
					'fp-option-tab-number'  => array(
						'type'  => 'number',
						'label' => esc_html__( 'Number', 'text-domain' ),
						'tab'  => 'fp-option-tab4',
					),
					'fp-option-tab-url'  => array(
						'type'  => 'url',
						'label' => esc_html__( 'Url', 'text-domain' ),
						'tab'  => 'fp-option-tab4',

					),
					'fp-option-tab-email'  => array(
						'type'  => 'email',
						'label' => esc_html__( 'Email', 'text-domain' ),
						'tab'  => 'fp-option-tab4',
					),
				),
				'section' => 'fp-option-tabs',
				'desc'    => array(
					'before-label' => 'Tabs with Repeater.'),
			),
			//------------------text-----------------------------
			'fp-option-field-text'  => array(
				'type'  => 'text',
				'label' => esc_html__( 'Text', 'text-domain' ),
				'section' => 'fp-option-text'
			),
			//text with description
			/**
			 * Different type of desc (text) are:-
			 * before label,after label, before field,after field
			 * To get this text
			 *  'desc' => array(
			 *      'before_label' => "your text",  // display before the title
			 *      'after_label' => "your text",   // display after the title
			 *      'before_field' => "your text",  // display after the field
			 *      'after_field' => "your text",   // display after the field
			 *   ),
			 * if you pass direct string in desc the this will display after the field
			 */
			'fp-field-text-description'  => array(
				'type'  => 'text',
				'desc'  => esc_html__( 'Enter your full name.', 'text-domain' ),
				'label' => esc_html__( 'Text With Description', 'text-domain' ),
				'attr' => array(
					'class'  => 'widefat'
				),
				'section' => 'fp-option-text'
			),
			//text with default
			'fp-field-text-default'  => array(
				'type'  => 'text',
				'label' => esc_html__( 'Text with Default Value', 'text-domain' ),
				'default' => "FieldPress",
				'section' => 'fp-option-text'
			),
			//text with help
			'fp-field-text-help'  => array(
				'type'  => 'text',
				'info' => esc_html__( 'This is required field.', 'text-domain' ),
				'label' => esc_html__( 'Text With Help', 'text-domain' ),
				'section' => 'fp-option-text'
			),
			//text with placeholder
			'fp-field-text-placeholder'  => array(
				'type'  => 'text',
				'label' => esc_html__( 'Text With Placeholder', 'text-domain' ),
				'attr' => array(
					'placeholder' => esc_html__( 'Only characters are allowed...', 'text-domain' ),
				),
				'section' => 'fp-option-text'
			),
			//text with after text
			'fp-field-text-after-field-texts'  => array(
				'type'  => 'text',
				'desc'  =>array(
					'after-field' => esc_html__( 'Enter your favourite pluign name', 'text-domain' ),
				),
				'label' => esc_html__( 'Text with After Field Text', 'text-domain' ),
				'section' => 'fp-option-text'
			),
			//text with after text
			'fp-field-text-before-field-texts'  => array(
				'type'  => 'text',
				'desc'  =>array(
					'before-field' => esc_html__( 'Enter your favourite pluign name', 'text-domain' ),
				),
				'label' => esc_html__( 'Text with Before Field Text', 'text-domain' ),
				'section' => 'fp-option-text'
			),
			//text with read only
			'fp-field-text-read-only'  => array(
				'type'  => 'text',
				'default' => "FieldPress Plugin",
				'label' => esc_html__( 'Text with Read Only', 'text-domain' ),
				'attr' => array(
					'readonly'=>''  // if required to pass only attribute then pass the arttribute with empty e.g readonly,required
				),
				'section' => 'fp-option-text'
			),
			//text with max length
			'fp-field-text-max-length'  => array(
				'type'  => 'text',
				'label' => esc_html__( 'Text With Max Length', 'text-domain' ),
				'desc' => esc_html__( 'Only 12 characters are accepted ', 'text-domain' ),
				'attr' => array(
					'maxlength' => '12',
				),
				'section' => 'fp-option-text'
			),
			//text with custom style
			'fp-field-text-custom-style'  => array(
				'type'  => 'text',
				'label' => esc_html__( 'Text With Custom Style', 'text-domain' ),
				'attr' => array(

					'style' => 'background:grey;'
				),
				'section' => 'fp-option-text'
			),
			//-----------------textarea---------------------------
			'fp-option-field-textarea'  => array(
				'type'  => 'textarea',
				'label' => esc_html__( 'Textarea', 'text-domain' ),
				'section' => 'fp-option-textarea'
			),
			//textarea with placeholder
			'fp-field-textarea-placeholder'  => array(
				'type'  => 'textarea',
				'label' => esc_html__( 'Textarea With Placeholder', 'text-domain' ),
				'attr' => array(
					'placeholder' => esc_html__( 'Your text goes here...', 'text-domain' ),
				),
				'section' => 'fp-option-textarea'
			),
			//textarea with default
			'fp-field-textarea-default-value'  => array(
				'type'  => 'textarea',
				'default' => esc_html__( 'FieldPress is awesome plugin which provide you multiple facilities like create  metabox, framework option, customizer options, widget, shortcode, menu options.', 'text-domain' ),
				'label' => esc_html__( 'Textarea With Default', 'text-domain' ),
				'section' => 'fp-option-textarea'
			),
			//textarea with help
			'fp-field-textarea-help'  => array(
				'type'  => 'textarea',
				'info' => esc_html__( 'This field is required', 'text-domain' ),
				'label' => esc_html__( 'Textarea With Help', 'text-domain' ),
				'section' => 'fp-option-textarea'
			),
			//textarea with description
			'fp-field-textarea-default'  => array(
				'type'  => 'textarea',
				'desc'  => esc_html__( 'Enter your current details.', 'text-domain' ),
				'label' => esc_html__( 'Textarea With Description', 'text-domain' ),
				'section' => 'fp-option-textarea'
			),
			//textarea with Before Text
			'fp-field-textarea-before-text'  => array(
				'type'  => 'textarea',
				'desc'  => array(
					'before-field' =>  'Enter Your Current Address.',
				),
				'label' => esc_html__( 'Textarea With Before Text', 'text-domain' ),
				'section' => 'fp-option-textarea'
			),
			//textarea with row max size
			'fp-field-textarea-row-max'  => array(
				'type'  => 'textarea',
				'label' => esc_html__( 'Textarea With Row and Column', 'text-domain' ),
				'desc' => esc_html__( 'Note: Rows= 4 & cols = 50', 'text-domain' ),
				'attr' => array(
					'rows'  => 4,
					'cols'  => 50,
				),
				'section' => 'fp-option-textarea',
			),
			//-------------------url------------------------------
			'fp-option-field-url'  => array(
				'type'  => 'url',
				'label' => esc_html__( 'Url', 'text-domain' ),
				'section' => 'fp-option-url'
			),
			//url with description
			'fp-field-url-description'  => array(
				'type'  => 'url',
				'label' => esc_html__( 'Url With Description', 'text-domain' ),
				'desc' => esc_html__( 'Enter your email @ddress', 'text-domain' ),

				'section' => 'fp-option-url'
			),
			//url with Default
			'fp-field-url-default'  => array(
				'type'  => 'url',
				'label' => esc_html__( 'Url With Default Value', 'text-domain' ),
				'default' => esc_html__( 'https://wordpress.org/', 'text-domain' ),
				'section' => 'fp-option-url'
			),
			//url with help
			'fp-field-url-help'  => array(
				'type'  => 'url',
				'label' => esc_html__( 'Url With Help Information', 'text-domain' ),
				'info' => esc_html__( 'This is required field', 'text-domain' ),
				'section' => 'fp-option-url'
			),
			//-------------------wysiwyg--------------------------
			'fp-option-field-wysiwyg'  => array(
				'type'  => 'wysiwyg',
				'label' => esc_html__( 'Wysiwyg', 'text-domain' ),
				'section' => 'fp-option-wysiwyg'
			),
			//wysiwyg with Help
			'fp-field-wysiwyg-help'  => array(
				'type'  => 'wysiwyg',
				'label' => esc_html__( 'Wysiwyg with Help', 'text-domain' ),
				'info' => esc_html__( 'Enter your article here.', 'text-domain' ),

				'section' => 'fp-option-wysiwyg'
			),
			//-------------------General Option--------------------------
			/**
			 * this general option applicable for every field of fieldPress
			 *
			 */
			/**
			 * Different type of desc (text) are:-
			 * before label,after label, before field,after field
			 * To get this text
			 *  'desc' => array(
			 *      'before_label' => "your text",  // display before the title
			 *      'after_label' => "your text",   // display after the title
			 *      'before_field' => "your text",  // display after the field
			 *      'after_field' => "your text",   // display after the field
			 *   ),
			 * if you pass direct string in desc the this will display after the field
			 */
			// text with direct desc
			'fp-field-general-text-desc'  => array(
				'desc' => esc_html__( 'This description can directly pass through "desc".', 'text-domain' ),
				'type'  => 'text',
				'label' => esc_html__( 'Text with Direct Description', 'text-domain' ),
				'section' => 'fp-option-general-option'
			),
			// text with before label
			'fp-general-text-before-label'  => array(
				'desc' => array(
					'before-label' => esc_html__( 'This description show before label of the field.', 'text-domain' ),
				),
				'type'  => 'text',
				'label' => esc_html__( 'Text Field with Text Before Label', 'text-domain' ),
				'section' => 'fp-option-general-option'
			),
			// text with after label
			'fp-general-text-after-label'  => array(
				'desc' => array(
					'after-label' => esc_html__( 'This description show after label of the field.', 'text-domain' ),
				),
				'type'  => 'text',
				'label' => esc_html__( 'Text Field with Text After label', 'text-domain' ),
				'section' => 'fp-option-general-option'
			),
			// text with before field
			'fp-general-text-before-field'  => array(
				'desc' => array(
					'before-field' => esc_html__( 'This description will display before the field.', 'text-domain' ),
				),
				'type'  => 'text',
				'label' => esc_html__( 'Text Field with Text Before Field', 'text-domain' ),
				'section' => 'fp-option-general-option'
			),
			// text with after field
			'fp-general-text-after-field'  => array(
				'desc' => array(
					'after-field' => esc_html__( 'This description will display after the field.', 'text-domain' ),
				),
				'type'  => 'text',
				'label' => esc_html__( 'Text Field with Text After Field', 'text-domain' ),
				'section' => 'fp-option-general-option'
			),
			// text with help information
			'fp-general-text-help'  => array(
				'type'  => 'text',
				'label' => esc_html__( 'Text Field with Text After Field', 'text-domain' ),
				'info' => esc_html__( 'This field is required.', 'text-domain' ),
				'section' => 'fp-option-general-option'
			),
			// text with custom class
			'fp-general-text-custom'  => array(
				'type'  => 'text',
				'label' => esc_html__( 'Text Field with Custom Class', 'text-domain' ),
				'desc' => esc_html__( '"Custom Class" class will appear in this field class.', 'text-domain' ),
				/**
				 * 'attr' accept all parameters which include in field like "class","placeholder","max" ,"required"
				 */
				'attr' => array(
					'class'  => 'custom-class',
				),
				'section' => 'fp-option-general-option'
			),
		)
	);
	$my_menu =  new FieldPress_Meta_Framework( $custom_meta_fields );
}