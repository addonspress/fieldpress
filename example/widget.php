<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* generate widget of FieldPress
* 
* @package   fieldPress
* @subpackage example
* 
*/
if (!class_exists('Example_Widget_Blog')) {

	class Example_Widget_Blog extends FieldPress_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->widget_classname     = 'container';
			$this->widget_description   = esc_html__( 'Blog Description.', 'text-domain' );
			$this->widget_id            = 'widget_blog';                                         // widget id
			$this->widget_name          = esc_html__( 'FieldPress Example Title', 'text-domain' ); // widget title
			$this->widget_customize_selective_refresh = true;
			$this->control_ops          = array( 'width' => 600, 'height' => 350 ); // define widget width and height
			$this->fields               = apply_filters( 'example_widget_settings_' . $this->widget_id,
				array(
					'sections'=> array(

						/*
						-------------------------------------------
						section listed in FieldPress widget
						-------------------------------------------
						*/
						'fp-option-checkbox' => array(
							'icon' => 'fa fa-user',
							'menu'  => 'fp-menus-options'
						),
						'fp-option-color' => array(
							'title' => esc_html__('Colors','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-date' => array(
							'title' => esc_html__('Date','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-email' => array(
							'title' => esc_html__('Email','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-file' => array(
							'title' => esc_html__('File Upload','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-gallery' => array(
							'title' => esc_html__('Gallery','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-image' => array(
							'title' => esc_html__('Image','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-icon' => array(
							'title' => esc_html__('Icon','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-map' => array(
							'title' => esc_html__('Map','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-number' => array(
							'title' => esc_html__('Number','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-radio' => array(
							'title' => esc_html__('Radio','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-repeater' => array(
							'title' => esc_html__('Repeater','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-nested-repeater' => array(
							'title' => esc_html__('Nested Repeater','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-nested-menu-repeater' => array(
							'title' => esc_html__('Nested Menu Repeater','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-select-image' => array(
							'title' => esc_html__('Select Image','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-select' => array(
							'title' => esc_html__('Select','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-sortable' => array(
							'title' => esc_html__('Sortable','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-switcher' => array(
							'title' => esc_html__('Switcher','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-tabs' => array(
							'title' => esc_html__('Tabs','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-text' => array(
							'title' => esc_html__('Text','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-textarea' => array(
							'title' => esc_html__('Textarea','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-url' => array(
							'title' => esc_html__('Url','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-wysiwyg' => array(
							'title' => esc_html__('Wysiwyg','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
						'fp-option-general-option' => array(
							'title' => esc_html__('General Options','fieldpress'),
							'menu'  => 'fp-menus-options'
						),
					),
					'fields'=> array(

					/*
					-----------------------------------------------------
					 fields listed in "FieldPress widget"
					-----------------------------------------------------
					*/
					/*-------------------checkbox------------------------------*/
					'fp-option-field-checkbox'  => array(
						'type'  		=> 'checkbox',
						'label' 		=> esc_html__( 'Checkbox', 'fieldpress' ),
						'checkbox-label'=> esc_html__( 'check for something', 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox'
					),

					//checkbox multiple options
					'fp-field-checkbox-multiple-options'  => array(
						'type'  		=> 'checkbox',
						'label' 		=> esc_html__( 'Checkbox with Multiple Options' , 'fieldpress' ),
						'checkbox-label'=> esc_html__( 'check for something', 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox',
						'choices' 		=> array(
							'red' 			=> esc_html__( 'Red', 'fieldpress' ),
							'green' 		=> esc_html__( 'Green', 'fieldpress' ),
							'blue' 			=> esc_html__( 'Blue', 'fieldpress' ),
							'yellow' 		=> esc_html__( 'Yellow', 'fieldpress' ),
						),
					),
					//checkbox multiple options horizontal 
					'fp-field-checkbox-multiple-options-horizontal'  => array(
						'type'  		=> 'checkbox',
						'label' 		=> esc_html__( 'Checkbox with Multiple Options Horizontal' , 'fieldpress' ),
						'checkbox-label'=> esc_html__( 'check for something', 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox',
						'wrap-attr' 	=> array(
							'class' 	=> 'fp-inline'
						),
						'choices' 		=> array(
							'red' 			=> esc_html__( 'Red', 'fieldpress' ),
							'green' 		=> esc_html__( 'Green', 'fieldpress' ),
							'blue' 			=> esc_html__( 'Blue', 'fieldpress' ),
							'yellow' 		=> esc_html__( 'Yellow', 'fieldpress' ),
						),
					),
					//Help Info
					'fp-field-checkbox-help-info'  => array(
						'type'  		=> 'checkbox',
						'label' 		=> esc_html__( 'Checkbox with Help Information' , 'fieldpress' ),
						'info' 			=> esc_html__( 'Some Description goes here', 'fieldpress' ),
						'checkbox-label'=> esc_html__( 'check for something', 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox'
					),
					//option and default
					'fp-field-checkbox-option-and-default'  => array(
						'type'  		=> 'checkbox',
						'label' 		=> esc_html__( 'Checkbox with Options and Default' , 'fieldpress' ),
						'checkbox-label'=> esc_html__( 'check for something', 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox',
						'choices' 		=> array(
							'red' 		=> esc_html__( 'Red', 'fieldpress' ),
							'green' 	=> esc_html__( 'Green', 'fieldpress' ),
							'blue' 		=> esc_html__( 'Blue', 'fieldpress' ),
							'yellow' 	=> esc_html__( 'Yellow', 'fieldpress' ),
						),
						'default' 		=> array('red'),
					),
					//checkbox with post
					'fp-field-checkbox-post'  => array(
						'type'  		=> 'checkbox',
						'label' 		=> esc_html__( 'Checkbox with Posts' , 'fieldpress' ),
						'info' 			=> esc_html__( 'Set choices => posts', 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox',
						'choices' 		=> 'posts',
					),
					//checkbox with page
					'fp-field-checkbox-page'  => array(
						'type'  		=> 'checkbox',
						'info' 			=> esc_html__( 'Set choices => pages', 'fieldpress' ),
						'label' 		=> esc_html__( 'Checkbox with Pages' , 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox',
						'choices' 		=> 'pages'
					),
					//checkbox with post catgories
					'fp-field-checkbox-categories'  => array(
						'type'  		=> 'checkbox',
						'label' 		=> esc_html__( 'Checkbox with Post Categories' , 'fieldpress' ),
						'checkbox-label'=> esc_html__( 'Uncategorized', 'fieldpress' ),
						'info' 			=> esc_html__( 'Set choices => categories', 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox',
						'choices' 		=> 'categories',
					),
					//checkbox with tags
					'fp-field-checkbox-tags'  => array(
						'type'  		=> 'checkbox',
						'label' 		=> esc_html__( 'Checkbox with Post tags' , 'fieldpress' ),
						'checkbox-label'=> esc_html__( 'tags', 'fieldpress' ),
						'info' 			=> esc_html__( 'Set choices => tags', 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox',
						'choices' 		=> 'tags',
					),
					//checkbox with CPT posts
					/**
					*to get CPT post "query_args" and "choices" are required.
					* 'query_args' accecpted all the args of wp_query.
					* 'choices' must be post
					*/
					'fp-field-checkbox-cpt-post'  => array(
						'type'  		=> 'checkbox',
						'query_args' 	=>array(
							'post_type'	=> 'download', //change with your post_type name
						),
						'info' 			=> esc_html__( 'query_args and choices are required."query_args" accepts all the args of wp_query & "choices" must be "post"', 'fieldpress' ),
						'label' 		=> esc_html__( 'Checkbox with CPT posts' , 'fieldpress' ),
						'checkbox-label'=> esc_html__( 'Post 1', 'fieldpress' ),
						'choices' 		=>'post',
						'section' 		=> 'fp-option-checkbox'
					),
					//checkbox with CPT categories
					/**
					*to get CPT categories "query_args" and "choices" are required.
					* 'query_args' accecpted all the args of get_terms(excluded get-terms)
					* 'choices' must be taxonomy
					*/
					'fp-field-checkbox-cpt-categories'  => array(
						'type'  		=> 'checkbox',
						'query_args' 	=> array(
							'taxonomy'  => 'download_category', // change with your post_type category name
							'hide_empty'=> true,
						),
						'choices' 		=>'taxonomy',
						'info' 			=> esc_html__( 'query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'fieldpress' ),
						'label' 		=> esc_html__( 'Checkbox with CPT categories' , 'fieldpress' ),
						'checkbox-label'=> esc_html__( 'CPT uncategories', 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox'
					),
					//checkbox with CPT tags
					/**
					*to get CPT tags "query_args" and "choices" are required.
					* 'query_args' accecpted all the args of get_terms(excluded get-terms)
					* 'choices' must be taxonomy
					*/
					'fp-field-checkbox-cpt-tags'  => array(
						'type'  		=> 'checkbox',
						'query_args' 	=> array(
							'taxonomy'  => 'download_tag', // change it with your post_type tag name
							'hide_empty'=> true,
						),
						'choices' 		=>'taxonomy',
						'info' 			=> esc_html__( ' query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'fieldpress' ),
						'label' 		=> esc_html__( 'Checkbox with CPT tags' , 'fieldpress' ),
						'checkbox-label'=> esc_html__( 'CPT tags', 'fieldpress' ),
						'section' 		=> 'fp-option-checkbox'
					),

					/*-------------------color------------------------------*/
					'fp-option-field-color'  => array(
						'type'  		=> 'color',
						'label' 		=> esc_html__( 'Color', 'fieldpress' ),
						'section'		=> 'fp-option-color'
					),
					//Color Picker with Default
					'fp-field-color-default'  => array(
						'type'  		=> 'color',
						'default' 		=> '#2196F3',
						'label' 		=> esc_html__( 'Color Picker With Default', 'fieldpress' ),
						'section' 		=> 'fp-option-color'
					),
					//Color Picker with RGB Infromation
					'fp-field-color-with-rgba'  => array(
						'type'  		=> 'color',
						'label' 		=> esc_html__( 'Color Picker With RGBA', 'fieldpress' ),
						'attr' 			=> array(
							'data-rgba' => true,
						),
						'section' 		=> 'fp-option-color'
					),
					//Color Picker with Help
					'fp-field-color-help'  => array(
						'type'  		=> 'color',
						'info'  		=> esc_html__( 'Please select your favourite colour', 'fieldpress' ),
						'label' 		=> esc_html__( 'Color Picker with Help Information', 'fieldpress' ),
						'section' 		=> 'fp-option-color'
					),

					/*-------------------date------------------------------*/
					'fp-option-field-date' => array(
						'type'  		=> 'date',
						'label'		 	=> esc_html__( 'Date', 'fieldpress' ),
						'section' 		=> 'fp-option-date',
					),
					// date with default
					'fp-option-field-default'  => array(
						'type'  		=> 'date',
						'default' 		=> 'Jul 20, 2018',
						'label' 		=> esc_html__( 'Date with Default', 'fieldpress' ),
						'section' 		=> 'fp-option-date'
					),
					//date with time
					'fp-option-field-date-with-time'  => array(
						'type'  		=> 'date',
						'label' 		=> esc_html__( 'Date With Time', 'fieldpress' ),
						'time' 			=> array(
							'time-only' => false,
						'time-format'	=> 'HH:mm:ss',
						),
						'section' 		=> 'fp-option-date'
					),
					'fp-option-field-time'  => array(
						'type'  		=> 'date',
						'label' 		=> esc_html__( 'Time Only', 'fieldpress' ),
						'time'			=> array(
							'time-only' => true,
							//http://trentrichardson.com/examples/timepicker/
							// follow above for time format
							'time-format'=> 'HH:mm:ss',
						),
						'section' 		=> 'fp-option-date'
					),
					//Date MM/DD/YY
					'fp-field-date-mm-dd-yy'  => array(
						'type'  		=> 'date',
						'label' 		=> esc_html__( 'Date in MM/DD/YY format', 'fieldpress' ),
						'attr' 			=> array(
							//https://api.jqueryui.com/datepicker/
							'date-format'=> 'mm/dd/yy'
						),
						'section' 		=> 'fp-option-date'
					),
					//Date DD/MM/YY
					'fp-field-date-dd-mm-yy'  => array(
						'type'  		=> 'date',
						'label' 		=> esc_html__( 'Date in DD-MM-YY format', 'fieldpress' ),
						'attr' 			=> array(
							'date-format'=> 'dd-mm-yy'
						),
						'section' 		=> 'fp-option-date'
					),

					/*-------------------email------------------------------*/
					'fp-option-field-email'  => array(
						'type'  		=> 'email',
						'label' 		=> esc_html__( 'Email', 'fieldpress' ),
						'section' 		=> 'fp-option-email'
					),
					//email with placeholder
					'fp-field-email-placeholder'  => array(
						'type'  		=> 'email',
						'label' 		=> esc_html__( 'Email With Placeholder', 'fieldpress' ),
						'attr' 			=> array(
							'placeholder'=>'Email placeholder....',
						),
						'section' 		=> 'fp-option-email'
					),
					//email with Help Infromation
					'fp-field-email-help-inforamtion'  => array(
						'type'  		=> 'email',
						'label' 		=> esc_html__( 'Email With Help Information.
							', 'fieldpress' ),
						'info' 			=> esc_html__( 'Please enter valid email address here.', 'fieldpress' ),
						'section' 		=> 'fp-option-email'
					),
					//email with default
					'fp-field-email-default'  => array(
						'type'  		=> 'email',
						'default' 		=> esc_html__( 'xyz@gmail.com', 'fieldpress' ),
						'label' 		=> esc_html__( 'Email With Default value.', 'fieldpress' ),
						'section' 		=> 'fp-option-email'
					),

					/*-------------------file------------------------------*/
					'fp-option-field-file'  => array(
						'type'  		=> 'file',
						'label' 		=> esc_html__( 'File Upload', 'fieldpress' ),
						'section' 		=> 'fp-option-file'
					),
					//file upload with descriptions
					'fp-field-file-description'  => array(
						'type'  		=> 'file',
						'label' 		=> esc_html__( 'File upload with Description', 'fieldpress' ),
						'desc'  		=> esc_html__( 'Max: File size upto 5 MB', 'fieldpress' ),
						'section' 		=> 'fp-option-file'
					),
					//file upload with Help Infroamtion
					'fp-field-file-help-information'  => array(
						'type'  		=> 'file',
						'label' 		=> esc_html__( 'File upload with Help Information', 'fieldpress' ),
						'info' 			=> esc_html__( 'This is required field.', 'fieldpress' ),
						'section' 		=> 'fp-option-file'
					),
					//file upload with custom uploader title
					'fp-field-file-custom-uploader-title'  => array(
						'type'  		=> 'file',
						'upload_title' 	=> esc_html__( 'Custom Upload Title', 'fieldpress' ),
						'label' 		=> esc_html__( 'File upload with Custom Uploder Title', 'fieldpress' ),
						'section' 		=> 'fp-option-file'
					),
					//file upload with custom button title
					// this button is visible when we upload the any item.
					'fp-field-file-custom-button_title'  => array(
						'type'  		=> 'file',
						'button_text' 	=> esc_html__( 'Custom Button', 'fieldpress' ),
						'label' 		=> esc_html__( 'File upload with Custom Selector Title', 'fieldpress' ),
						'section' 		=> 'fp-option-file'
					),

					/*-------------------gallery------------------------------*/
					'fp-option-field-gallery'  => array(
						'type'  		=> 'gallery',
						'label' 		=> esc_html__( 'Gallery', 'fieldpress' ),
						'section' 		=> 'fp-option-gallery'
					),
					//gallery with help infromation
					'fp-field-gallery-help-information'  => array(
						'type'  		=> 'gallery',
						'label' 		=> esc_html__( 'Gallery with Help Information', 'fieldpress' ),
						'info'  		=> esc_html__( 'Selected images are used as slider image.', 'fieldpress' ),
						'section' 		=> 'fp-option-gallery'
					),
					//gallery with custom button title
					'fp-field-gallery-custom-uploader-title'  => array(
						'type'  		=> 'gallery',
						'upload_title' 	=> esc_html__( 'Select Slider', 'fieldpress' ),
						'label' 		=> esc_html__( 'Gallery with Custom Uploader title', 'fieldpress' ),
						'section' 		=> 'fp-option-gallery'
					),
					//gallery with before text
					'fp-field-gallery-before-text'  => array(
						'type'  		=> 'gallery',
						'desc'  		=> array(
							'before-field' => 'Select Images for Slider', 'fieldpress',
						),
						'label' 		=> esc_html__( 'Gallery with Before Text', 'fieldpress' ),
						'section' 		=> 'fp-option-gallery'
					),

					/*-------------------image------------------------------*/
					'fp-option-field-image'  => array(
						'type'  		=> 'image',
						'label' 		=> esc_html__( 'Image', 'fieldpress' ),
						'section' 		=> 'fp-option-image'
					),
					// Image With Help Information
					'fp-field-image-help-information'  => array(
						'type'  		=> 'image',
						'label' 		=> esc_html__( 'Image with Help Information', 'fieldpress' ),
						'info'  		=> esc_html__( 'This is required field', 'fieldpress' ),
						'section' 		=> 'fp-option-image'
					),
					// Image With After Text
					'fp-field-image-after-text'  => array(
						'type'  		=> 'image',
						'label'			=> esc_html__( 'Image with After Field Information', 'fieldpress' ),
						'desc'  		=> esc_html__( 'Maximum upload file size: 5 MB.', 'fieldpress' ),
						'section' 		=> 'fp-option-image'
					),
					// Image With Before Text
					'fp-field-image-before-text'  => array(
						'type'  		=> 'image',
						'label' 		=> esc_html__( 'Image with Before Field Information', 'fieldpress' ),
						'desc'  		=> array(
							'before-field' => esc_html__( 'Maximum upload file size: 5 MB.', 'fieldpress' ),
						),
						'section' 		=> 'fp-option-image'
					),
					// Image With custom Uploder title
					'fp-field-image-custom-uploder-title'  => array(
						'type'  		=> 'image',
						'upload_title' 	=> esc_html__( 'Custom Uploader', 'fieldpress' ),
						'label' 		=> esc_html__( 'Image with Custom Uploader Title', 'fieldpress' ),
						'section' 		=> 'fp-option-image'
					),
					// Image With custom selector title
					'fp-field-image-custom-selector-title'  => array(
						'type'  		=> 'image',
						'button_text' 	=> esc_html__( 'Custom Selector', 'fieldpress' ),
						'label' 		=> esc_html__( 'Image with Custom Selector Title', 'fieldpress' ),
						'section'		=> 'fp-option-image'
					),

					/*-------------------icon------------------------------*/
					'fp-option-field-icon'  => array(
						'type'  		=> 'icon',
						'label' 		=> esc_html__( 'Icon Selector', 'fieldpress' ),
						'section' 		=> 'fp-option-icon'
					),
					// icon with Help Information
					'fp-field-icon-with-help-information'  => array(
						'type'  		=> 'icon',
						'info'  		=> esc_html__( 'This is required field', 'fieldpress' ),
						'label' 		=> esc_html__( 'Icon Selector with help Information', 'fieldpress' ),
						'section' 		=> 'fp-option-icon'
					),
					// icon with default value
					'fp-field-icon-default'  => array(
						'type'  		=> 'icon',
						'default' 		=> 'fa fa-adjust',
						'label' 		=> esc_html__( 'Icon with Default', 'fieldpress' ),
						'section' 		=> 'fp-option-icon'
					),
					// icon with after field text
					'fp-field-icon-after-field-text'  => array(
						'type'  		=> 'icon',
						'label' 		=> esc_html__( 'Icon with After Field Text', 'fieldpress' ),
						'desc' 			=> esc_html__( 'Select Icon for the page.', 'fieldpress' ),
						'section' 		=> 'fp-option-icon'
					),

					/*-------------------map------------------------------*/
					'fp-option-field-map'  => array(
						'type'  		=> 'map',
						'label' 		=> esc_html__( 'Map', 'fieldpress' ),
						'search_label' 	=> esc_html__( 'Search Map', 'fieldpress' ),
						'attr' 			=> array(
							'zoom'  	=> 5,
						),
						'section' 		=> 'fp-option-map'
					),
					// Map with Default location
					'fp-field-map-default-location'  => array(
						'type'  		=> 'map',
						'default' 		=>'36.778261 ,-119.41793239999998',
						'label' 		=> esc_html__( 'Map with Default Location', 'fieldpress' ),
						'search_label' 	=> esc_html__( 'Search Map', 'fieldpress' ),
						'section' 		=> 'fp-option-map'
					),
					// Map with custom search placeholder
					'fp-field-map-search-placeholder'  => array(
						'type'  		=> 'map',
						'label' 		=> esc_html__( 'Map with Custom search Placeholder', 'fieldpress' ),
						'search-placeholder'=> esc_html__( 'Custom Placeholder', 'fieldpress' ),
						'search_label' 	=> esc_html__( 'Search Map', 'fieldpress' ),
						'section' 		=> 'fp-option-map'
					),
					// Map with custom search Button text
					'fp-field-map-custom-search-button-text'  => array(
						'type'  		=> 'map',
						'label' 		=> esc_html__( 'Map with Custom Search Button Text', 'fieldpress' ),
						'find-label'	=> esc_html__( 'Search', 'fieldpress' ),
						'search_label'	=> esc_html__( 'Search Map', 'fieldpress' ),
						'section' 		=> 'fp-option-map'
					),
					// Map with custom show map text
					'fp-field-map-custom-show-map-text'  => array(
						'type'  		=> 'map',
						'label' 		=> esc_html__( 'Map with Custom Show Map Text', 'fieldpress' ),
						'show-map-label'=> esc_html__( 'Display Map', 'fieldpress' ),
						'section' 		=> 'fp-option-map'
					),
					// Map with Custom Zoom Level
					'fp-field-map-zoom-level'  => array(
						'type'  		=> 'map',
						'label' 		=> esc_html__( 'Map with Zoom level', 'fieldpress' ),
						'desc' 			=> array(
							'after-label' => esc_html__( 'E.g Zoom => 10', 'fieldpress' ),
						), 
						'attr' 			=> array(
							'zoom'  => 15,
						),
						'section' 		=> 'fp-option-map'
					),

					/*-------------------number------------------------------*/
					'fp-option-field-number'  => array(
						'type'  		=> 'number',
						'label' 		=> esc_html__( 'Number', 'fieldpress' ),
						'section' 		=> 'fp-option-number'
					),
					//number with before label text
					'fp-field-number-before-label-text'  => array(
						'type'  		=> 'number',
						'desc'  		=> array(
							'before-label' => esc_html__( 'Some help information before the label', 'fieldpress' ),
						),
						'label' 		=> esc_html__( 'Number with Before Label Text', 'fieldpress' ),
						'section' 		=> 'fp-option-number'
					),
					//number with after label text
					'fp-field-number-after-label-text'  => array(
						'type'  		=> 'number',
						'desc'  		=> array(
							'after-label' => esc_html__( 'Some help information after the label', 'fieldpress' ),
						),
						'label' 		=> esc_html__( 'Number with After Label Text', 'fieldpress' ),
						'section' 		=> 'fp-option-number'
					),
					//number with before field text
					'fp-field-number-before-field-text'  => array(
						'type'  		=> 'number',
						'desc'  		=> array(
							'before-field' => esc_html__( 'Please provide us your age number.', 'fieldpress' ),
						),
						'label' 		=> esc_html__( 'Number with Before Field Text', 'fieldpress' ),
						'section' 		=> 'fp-option-number'
					),
					//number with after Field text
					'fp-field-number-after-field-text'  => array(
						'type'  		=> 'number',
						'desc' 	 		=> array(
							'after-field' => esc_html__( 'Only positive number are allowed.', 'fieldpress' ),
						),
						'label' 		=> esc_html__( 'Number with After Field Text', 'fieldpress' ),
						'section' 		=> 'fp-option-number'
					),
					//number with help
					'fp-field-number-help'  => array(
						'type'  		=> 'number',
						'info'  		=> esc_html__( 'This field is required.', 'fieldpress' ),
						'label' 		=> esc_html__( 'Number with Help Information', 'fieldpress' ),
						'section' 		=> 'fp-option-number'
					),
					//number with default
					'fp-field-number-default'  => array(
						'type'  		=> 'number',
						'default' 		=> 1,
						'label' 		=> esc_html__( 'Number with Default', 'fieldpress' ),
						'section' 		=> 'fp-option-number'
					),
					//number with placeholder
					'fp-field-number-placeholder'  => array(
						'type'  		=> 'number',
						'label' 		=> esc_html__( 'Number with Placeholder', 'fieldpress' ),
						'attr' 			=> array(
							'class' 	=> 'widefat',
							'placeholder' => esc_html__( 'Allowed number from 0 to 10 only...', 'fieldpress' ),
						),
						'section' => 'fp-option-number'
					),
					//number with Max value
					'fp-field-number-max'  => array(
						'type'  => 'number',
						'label' => esc_html__( 'Number with Max Value', 'fieldpress' ),
						'desc' => esc_html__( 'Note: Max number allowed is 10', 'fieldpress' ),
						'attr' => array(
							'max' => 10,
						),
						'section' => 'fp-option-number'
					),
					//number with Min value and max value
					'fp-field-number-min-max'  => array(
						'type'  => 'number',
						'label' => esc_html__( 'Number with Min and Max Value', 'fieldpress' ),
						'desc' => esc_html__( 'Note: Number accepted between Min 10 & Max 20. ', 'fieldpress' ),
						'attr' => array(
							'min' => 10,
							'max' => 20,
						),
						'default' => 11,
						'section' => 'fp-option-number'
					),

					/*-------------------radio------------------------------*/
					'fp-option-field-radio'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						'section' => 'fp-option-radio'
					),
					// radio with before field text
					'fp-field-radio-before-text'  => array(
						'type'  => 'radio',
						'desc'  =>array(
							'before-field' => esc_html__( 'Choose any of them from available option:-', 'fieldpress' ),
						),
						'label' => esc_html__( 'Radio with Before Field Text', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						'section' => 'fp-option-radio'
					),
					// radio with after field text
					'fp-field-radio-after-text'  => array(
						'type'  => 'radio',
						'desc'  =>array(
							'after-field' => esc_html__( 'Choose any of them from available option:-', 'fieldpress' ),
						),
						'label' => esc_html__( 'Radio with After Field Text', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						'section' => 'fp-option-radio'
					),
					// radio with after label text
					'fp-field-radio-label-after-text'  => array(
						'type'  => 'radio',
						'desc'  =>array(
							'after-label' => esc_html__( 'Choose any of the option:-', 'fieldpress' ),
						),
						'label' => esc_html__( 'Radio with After Label Text', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						'section' => 'fp-option-radio'
					),
					//radio with default red value
					'fp-field-radio-default'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio with Default Red Value', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						"default" => 'red',
						'section' => 'fp-option-radio'
					),
					//radio with help Information
					'fp-field-radio-help'  => array(
						'type'  => 'radio',
						'info' => esc_html__( 'Select your suitable item.', 'fieldpress' ),
						'label' => esc_html__( 'Radio with Help Information', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						"default" => 'yellow',
						'section' => 'fp-option-radio'
					),
					//radio with horizontal
					'fp-field-radio-horizonatl'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio On Horizontal View', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
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
						'label' => esc_html__( 'Radio with Pages', 'fieldpress' ),
						'choices' => 'pages',
						'info' => esc_html__( 'Set choices => pages', 'fieldpress' ),
						'section' => 'fp-option-radio'
					),
					//radio with posts
					'fp-field-radio-posts'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio with Posts', 'fieldpress' ),
						'choices' =>'posts',
						'info' => esc_html__( 'Set choices => posts', 'fieldpress' ),
						'section' => 'fp-option-radio'
					),
					//radio with post categories
					'fp-field-radio-posts-catgories'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio with Posts Categories', 'fieldpress' ),
						'choices' => 'categories',
						'info' => esc_html__( 'Set choices => categories', 'fieldpress' ),
						'section' => 'fp-option-radio'
					),
					//radio with post tags
					'fp-field-radio-posts-tags'  => array(
						'type'  => 'radio',
						'label' => esc_html__( 'Radio with Posts Tags', 'fieldpress' ),
						'choices' => 'tags',
						'info' => esc_html__( 'Set choices => tags', 'fieldpress' ),
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
						'label' => esc_html__( 'Radio with CPT Posts', 'fieldpress' ),
						'choices' =>'posts',
						'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of wp_query & "choices" must be "post"', 'fieldpress' ),
						'section' => 'fp-option-radio'
					),
					//radio with cpt categories
					'fp-field-radio-cpt-categories'  => array(
						'type'  => 'radio',
						'query_args' => array(
							'taxonomy'   => 'download_category',
							'hide_empty' => true,
						),
						'label' => esc_html__( 'Radio with CPT Categories', 'fieldpress' ),
						'choices' =>'taxonomy',
						'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'fieldpress' ),
						"default" => 'yellow',
						'section' => 'fp-option-radio'
					),
					//radio with cpt tags
					'fp-field-radio-cpt-tags'  => array(
						'type'  => 'radio',
						'query_args' => array(
							'taxonomy'   => 'download_tag',
							'hide_empty' => true,
						),
						'label' => esc_html__( 'Radio with CPT Tags', 'fieldpress' ),
						'choices' =>'taxonomy',
						'info' => esc_html__( ' query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'fieldpress' ),
						"default" => 'yellow',
						'section' => 'fp-option-radio'
					),
					//-----------------repeater------------------------------
					'fp-option-field-repeater' => array(
						'type'  => 'repeater',
						'fields'=> array(
							'fp-option-repeater-checkbox'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox', 'fieldpress' ),
								'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
							),
							'fp-option-repeater-checkbox-multiple'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox Multiple', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
								),
								'wrap-attr' => array(
									'class'  => 'inline-block',
								),
							),
							'fp-option-repeater-checkbox-post'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox Post', 'fieldpress' ),
								'choices' => 'posts',
							),
							'fp-option-repeater-color'  => array(
								'type'  => 'color',
								'label' => esc_html__( 'Color', 'fieldpress' ),

							),
							'fp-option-repeater-date'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Date', 'fieldpress' ),
							),
							'fp-option-repeater-date-time'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Date and Time', 'fieldpress' ),
								'time' => true,
							),
							'fp-option-repeater-time-only'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Time Only', 'fieldpress' ),
								'time' =>array(
									'time-only' => true,
									'time-format' =>''
								),
							),
							'fp-option-repeater-email'  => array(
								'type'  => 'email',
								'label' => esc_html__( 'Email', 'fieldpress' ),

							),
							'fp-option-repeater-file'  => array(
								'type'  => 'file',
								'label' => esc_html__( 'File', 'fieldpress' ),
							),
							'fp-option-repeater-gallery'  => array(
								'type'  => 'gallery',
								'label' => esc_html__( 'Gallery', 'fieldpress' ),
							),
							'fp-option-repeater-icon'  => array(
								'type'  => 'icon',
								'label' => esc_html__( 'Icon Selector', 'fieldpress' ),
							),
							'fp-option-repeater-image'  => array(
								'type'  => 'image',
								'label' => esc_html__( 'Image', 'fieldpress' ),

							),
							'fp-option-repeater-map'  => array(
								'type'  => 'map',
								'label' => esc_html__( 'Map', 'fieldpress' ),
								'search_label' => esc_html__( 'Search Map', 'fieldpress' ),
							),
							'fp-option-repeater-number'  => array(
								'type'  => 'number',
								'label' => esc_html__( 'Number', 'fieldpress' ),
							),
							'fp-option-repeater-radio'  => array(
								'type'  => 'radio',
								'label' => esc_html__( 'Radio', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
								),
								"default" => 'yellow',
							),
							'fp-option-repeater-select-image'  => array(
								'type'  => 'select-image',
								'label' => esc_html__( 'Select Image', 'fieldpress' ),
								'choices' => array(
									'red'   => 'https://addonspress.com/wp-content/uploads/edd/2018/07/documentation-press.jpg',
									'green' => 'https://addonspress.com/wp-content/uploads/edd/2018/07/field-press.jpg',
								),
							),
							'fp-option-repeater-select'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
								),
							),
							'fp-option-repeater-select-multiple'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select Multiple', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
								),
								'attr' => array(
									'multiple'  => 'multiple',
								),
							),
							'fp-option-repeater-select-post'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select Post', 'fieldpress' ),
								'choices' => 'posts',

							),
							'fp-option-repeater-sortable'  => array(
								'type'  => 'sortable',
								'label' => esc_html__( 'Sortable', 'fieldpress' ),
								'choices' => array(
									'active'      => array(
										'red' => esc_html__( 'Red', 'fieldpress' ),
										'green' => esc_html__( 'Green', 'fieldpress' ),
										'blue' => esc_html__( 'Blue', 'fieldpress' ),
										'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
										'orange' => esc_html__( 'Orange', 'fieldpress' ),
										'ocean'  => esc_html__( 'Ocean', 'fieldpress' ),
									),
									'inactive'     => array(
										'black'      => esc_html__( 'Black', 'fieldpress' ),
										'white'      => esc_html__( 'White', 'fieldpress' ),
									)
								),
								'active_title'   => esc_html__( 'Active Colors', 'fieldpress' ),
								'inactive_title' => esc_html__( 'Deactivate Colors', 'fieldpress' ),
							),
							'fp-option-repeater-switcher'  => array(
								'type'  => 'switcher',
								'label' => esc_html__( 'Switcher', 'fieldpress' ),
								'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
							),
							'fp-option-repeater-tabs' => array(
								'type' => 'tabs',
								'tabs' => array(
									'fp-option-repeater-tab1'=>array(
										'label'     => esc_html__( 'Tab1', 'fieldpress' ),
									),
									'fp-option-repeater-tab2'=>array(
										'label'    => esc_html__( 'Tab2', 'fieldpress' ),
									),
									'fp-option-repeater-tab3'=>array(
										'label'     => esc_html__( 'Tab13', 'fieldpress' ),
									),
									'fp-option-repeater-tab4'=>array(
										'label'     => esc_html__( 'Tab4', 'fieldpress' ),
									),
								),
								'fields'=> array(
									'fp-option-repeater-tab1-text'  => array(
										'type'  => 'text',
										'label' => esc_html__( 'Text', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab1',
									),
									'fp-option-repeater-tab1-number'  => array(
										'type'  => 'number',
										'label' => esc_html__( 'Number', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab1',
									),
									'fp-option-repeater-tab1-url'  => array(
										'type'  => 'url',
										'label' => esc_html__( 'Url', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab1',

									),
									'fp-option-repeater-tab1-email'  => array(
										'type'  => 'email',
										'label' => esc_html__( 'Email', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab1',
									),
									'fp-option-repeater-tab-hidden'  => array(
										'type'  => 'hidden',
										'tab'  => 'fp-option-repeater-tab1',
									),
									'fp-option-repeater-tab-textarea'  => array(
										'type'  => 'textarea',
										'label' => esc_html__( 'Textarea', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab2',
									),
									'fp-option-repeater-tab-colors'  => array(
										'type'  => 'color',
										'label' => esc_html__( 'Color', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab2',
									),
									'fp-option-repeater-tab-image'  => array(
										'type'  => 'image',
										'label' => esc_html__( 'Image', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab2',
									),
									'fp-option-repeater-tab-gallery'  => array(
										'type'  => 'gallery',
										'label' => esc_html__( 'Gallery', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab2',
									),
									'fp-option-repeater-tab-files'  => array(
										'type'  => 'file',
										'label' => esc_html__( 'File', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab2',
									),
									'fp-option-repeater-tab-date'  => array(
										'type'  => 'date',
										'label' => esc_html__( 'Date', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab2',
									),
									'fp-option-repeater-tab-date-time'  => array(
										'type'  => 'date',
										'label' => esc_html__( 'Date and Time', 'fieldpress' ),
										'time' => true,
										'tab'  => 'fp-option-repeater-tab2',
									),
									'fp-option-repeater-tab-time-only'  => array(
										'type'  => 'date',
										'label' => esc_html__( 'Time Only', 'fieldpress' ),
										'time' =>array(
											'time-only' => true,
											'time-format' =>''
										),
										'tab'  => 'fp-option-repeater-tab2',
									),
									'fp-option-repeater-tab-map'  => array(
										'type'  => 'map',
										'label' => esc_html__( 'Map', 'fieldpress' ),
										'search_label' => esc_html__( 'Search Map', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab2',
									),
									'fp-option-repeater-tab-checkbox'  => array(
										'type'  => 'checkbox',
										'label' => esc_html__( 'Checkbox', 'fieldpress' ),
										'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab2'
									),
									'fp-option-repeater-tab-checkbox-multiple'  => array(
										'type'  => 'checkbox',
										'label' => esc_html__( 'Checkbox Multiple', 'fieldpress' ),
										'choices' => array(
											'red' => esc_html__( 'Red', 'fieldpress' ),
											'green' => esc_html__( 'Green', 'fieldpress' ),
											'blue' => esc_html__( 'Blue', 'fieldpress' ),
											'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
										),
										'wrap-attr' => array(
											'class'  => 'inline-block',
										),
										'tab'  => 'fp-option-repeater-tab2',

									),
									'fp-option-repeater-tab-checkbox-post'  => array(
										'type'  => 'checkbox',
										'label' => esc_html__( 'Checkbox Post', 'fieldpress' ),
										'choices' => 'posts',
										'tab'  => 'fp-option-repeater-tab3',
									),
									'fp-option-repeater-tab-select'  => array(
										'type'  => 'select',
										'label' => esc_html__( 'Select', 'fieldpress' ),
										'choices' => array(
											'red' => esc_html__( 'Red', 'fieldpress' ),
											'green' => esc_html__( 'Green', 'fieldpress' ),
											'blue' => esc_html__( 'Blue', 'fieldpress' ),
											'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
										),
										'tab'  => 'fp-option-repeater-tab3',
									),
									'fp-option-repeater-tab-select-multiple'  => array(
										'type'  => 'select',
										'label' => esc_html__( 'Select Multiple', 'fieldpress' ),
										'choices' => array(
											'red' => esc_html__( 'Red', 'fieldpress' ),
											'green' => esc_html__( 'Green', 'fieldpress' ),
											'blue' => esc_html__( 'Blue', 'fieldpress' ),
											'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
										),
										'attr' => array(
											'multiple'  => 'multiple',
										),
										'tab'  => 'fp-option-repeater-tab3',
									),
									'fp-option-repeater-tab-select-post'  => array(
										'type'  => 'select',
										'label' => esc_html__( 'Select Post', 'fieldpress' ),
										'choices' => 'posts',
										'tab'  => 'fp-option-repeater-tab3',
									),
									'fp-option-repeater-tab-radio'  => array(
										'type'  => 'radio',
										'label' => esc_html__( 'Radio', 'fieldpress' ),
										'choices' => array(
											'red' => esc_html__( 'Red', 'fieldpress' ),
											'green' => esc_html__( 'Green', 'fieldpress' ),
											'blue' => esc_html__( 'Blue', 'fieldpress' ),
											'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
										),
										"default" => 'yellow',
										'tab'  => 'fp-option-repeater-tab3',
									),
									'fp-option-repeater-tab-wysiwyg'  => array(
										'type'  => 'wysiwyg',
										'label' => esc_html__( 'Wysiwyg', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab3',
									),
									'fp-option-repeater-tab-text'  => array(
										'type'  => 'text',
										'label' => esc_html__( 'Text', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab4',
									),
									'fp-option-repeater-tab-number'  => array(
										'type'  => 'number',
										'label' => esc_html__( 'Number', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab4',
									),
									'fp-option-repeater-tab-url'  => array(
										'type'  => 'url',
										'label' => esc_html__( 'Url', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab4',

									),
									'fp-option-repeater-tab-email'  => array(
										'type'  => 'email',
										'label' => esc_html__( 'Email', 'fieldpress' ),
										'tab'  => 'fp-option-repeater-tab4',
									),
								),
							),
							'fp-option-repeater-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'fieldpress' ),
							),
							'fp-option-repeater-textarea'  => array(
								'type'  => 'textarea',
								'label' => esc_html__( 'Textarea', 'fieldpress' ),

							),
							'fp-option-repeater-url'  => array(
								'type'  => 'url',
								'label' => esc_html__( 'Url', 'fieldpress' ),

							),
							'fp-option-repeater-wysiwyg'  => array(
								'type'  => 'wysiwyg',
								'label' => esc_html__( 'Wysiwyg', 'fieldpress' ),
							),
						),
					'section' => 'fp-option-repeater'
					),

					/*-------------------nested-repeater------------------------------*/
					'fp-field-nested-repeater' => array(
						'type'  => 'repeater',
						'nested' => true,
						'fields'=> array(
							'fp-nested-repeater-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'fieldpress' ),
							),
							'fp-nested-repeater-radio'  => array(
								'type'  => 'radio',
								'label' => esc_html__( 'Radio', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
								),
								"default" => 'yellow',
							),
							'fp-nested-repeater-select'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
								),
							),
							'fp-nested-repeater-switcher'  => array(
								'type'  => 'switcher',
								'label' => esc_html__( 'Switcher', 'fieldpress' ),
								'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
							),
							'fp-nested-repeater-wysiwyg'  => array(
								'type'  => 'wysiwyg',
								'label' => esc_html__( 'Wysiwyg', 'fieldpress' ),

							),
							/*repeater into repeater*/
							'fp-nested-repeater-into-repeater'  => array(
								'type'  => 'repeater',
								'label' => esc_html__( 'Repeater', 'fieldpress' ),
								'nested' => true,
								'fields'=> array(
									'fp-nested-repeater-into-repeater-checkbox'  => array(
										'type'  => 'checkbox',
										'label' => esc_html__( 'Checkbox', 'fieldpress' ),
										'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
									),
									'fp-nested-repeater-into-repeater-text'  => array(
										'type'  => 'text',
										'label' => esc_html__( 'Text', 'fieldpress' ),
										'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
									),
								),
							),
						),
					'section' => 'fp-option-nested-repeater'
					),

					/*-------------------nested menu repeater------------------------------*/
					'fp-nested-menu-repeater' => array(
						'type'  => 'repeater',
						'nested'=> true,
						'fields'=> array(
							'fp-option-repeater-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'fieldpress' ),
							),
							'fp-option-repeater-checkbox'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox', 'fieldpress' ),
								'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
							),
							'fp-option-repeater-radio'  => array(
								'type'  => 'radio',
								'label' => esc_html__( 'Radio', 'fieldpress' ),
								'choices' => array(
										'red' => esc_html__( 'Red', 'fieldpress' ),
										'green' => esc_html__( 'Green', 'fieldpress' ),
										'blue' => esc_html__( 'Blue', 'fieldpress' ),
										'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
								),
								"default" => 'yellow',
							),
							'fp-option-repeater-select'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
								),

							),
							'fp-option-repeater-switcher'  => array(
								'type'  => 'switcher',
								'label' => esc_html__( 'Switcher', 'fieldpress' ),
								'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
							),
							'fp-option-repeater-textarea'  => array(
								'type'  => 'textarea',
								'label' => esc_html__( 'Textarea', 'fieldpress' ),
							),
							'fp-option-repeater-wysiwyg'  => array(
								'type'  => 'wysiwyg',
								'label' => esc_html__( 'Wysiwyg', 'fieldpress' ),
							),
						),
					'section' => 'fp-option-nested-menu-repeater'
					),

					/*-------------------select-image------------------------------*/
					'fp-option-field-select-image'  => array(
						'type'  => 'select-image',
						'label' => esc_html__( 'Select Image', 'fieldpress' ),
						'choices' => array(
							'red'   => 'https://addonspress.com/wp-content/uploads/edd/2018/07/documentation-press.jpg',
							'green' => 'https://addonspress.com/wp-content/uploads/edd/2018/07/field-press.jpg',
						),
						'section' => 'fp-option-select-image'
					),
					//select image with default
					'fp-field-select-image-default'  => array(
						'type'  => 'select-image',
						'label' => esc_html__( 'Select Image With Default', 'fieldpress' ),
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
						'label' => esc_html__( 'Select Image With Multiple Select', 'fieldpress' ),
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
						'label' => esc_html__( 'Select Image With Help Information', 'fieldpress' ),
						'info' => esc_html__( 'Select Image for Slider', 'fieldpress' ),
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
						'label' => esc_html__( 'Select Image With Before Field Text', 'fieldpress' ),
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
						'label' => esc_html__( 'Select Image With After Field Text', 'fieldpress' ),
						'choices' => array(
							'red'   => 'https://addonspress.com/wp-content/uploads/edd/2018/07/documentation-press.jpg',
							'green' => 'https://addonspress.com/wp-content/uploads/edd/2018/07/field-press.jpg',
						),
						'section' => 'fp-option-select-image'
					),

					/*-------------------select------------------------------*/
					'fp-option-field-select'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						'section' => 'fp-option-select'
					),
					// select with normal style
					'fp-field-select-normal'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Noraml Select', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						'normal' => true,
						'section' => 'fp-option-select'
					),
					//select with first empty value
					'fp-field-select-first-empty'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select With First Empty Values', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						'section' => 'fp-option-select'
					),
					//select with help
					'fp-field-select-help'  => array(
						'type'  => 'select',
						'info' => esc_html__( 'Select your Favourite Colour:-', 'fieldpress' ),
						'label' => esc_html__( 'Select With Help', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						'section' => 'fp-option-select'
					),
					//select with default value
					'fp-field-select-default'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select With Default Value', 'fieldpress' ),
						'default' => 'green',
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						'section' => 'fp-option-select'
					),
					//select with multi select
					'fp-field-select-multi-select'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select With Multiple Select Value', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
						),
						'attr' => array(
							'multiple' => true,
						),
						'section' => 'fp-option-select'
					),
					//select with multi select and default
					'fp-field-select-multi-select-default'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select With Multiple Select With Default', 'fieldpress' ),
						'choices' => array(
							'red' => esc_html__( 'Red', 'fieldpress' ),
							'green' => esc_html__( 'Green', 'fieldpress' ),
							'blue' => esc_html__( 'Blue', 'fieldpress' ),
							'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
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
						'label' => esc_html__( 'Select With Pages', 'fieldpress' ),
						'choices' =>'pages',
						'info' => esc_html__( 'Set choices => pages', 'fieldpress' ),
						'section' => 'fp-option-select'
					),
					//select with post
					'fp-field-select-post'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select With Posts', 'fieldpress' ),
						'choices' =>'posts',
						'info' => esc_html__( 'Set choices => posts', 'fieldpress' ),
						'section' => 'fp-option-select'
					),
					//select with post catgories
					'fp-field-select-post-categories'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select With Post categories', 'fieldpress' ),
						'choices' =>'categories',
						'info' => esc_html__( 'Set choices => categories', 'fieldpress' ),
						'section' => 'fp-option-select'
					),
					//select with post tags
					'fp-field-select-post-tages'  => array(
						'type'  => 'select',
						'label' => esc_html__( 'Select With Posts Tages', 'fieldpress' ),
						'choices' =>'tags',
						'info' => esc_html__( 'Set choices => tags', 'fieldpress' ),
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
						'label' => esc_html__( 'Select With CPT Posts', 'fieldpress' ),
						'choices' =>'post',
						'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of wp_query & "choices" must be "post"', 'fieldpress' ),
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
							'hide_empty' => true,
						),
						'label' => esc_html__( 'Select With CPT Categories', 'fieldpress' ),
						'choices' =>'taxonomy',
						'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'fieldpress' ),
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
							'hide_empty' => true,
						),
						'choices' =>'taxonomy',
						'info' => esc_html__( ' query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'fieldpress' ),
						'label' => esc_html__( 'Select With CPT Tags', 'fieldpress' ),
						'section' => 'fp-option-select'
					),

					/*-------------------sortable------------------------------*/
					'fp-option-field-sortable'  => array(
						'type'  => 'sortable',
						'label' => esc_html__( 'Sortable', 'fieldpress' ),
						'choices' => array(
							'active'      => array(
								'red' => esc_html__( 'Red', 'fieldpress' ),
								'green' => esc_html__( 'Green', 'fieldpress' ),
								'blue' => esc_html__( 'Blue', 'fieldpress' ),
								'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
								'orange' => esc_html__( 'Orange', 'fieldpress' ),
								'ocean'  => esc_html__( 'Ocean', 'fieldpress' ),
							),
							'inactive'     => array(
								'black'  => esc_html__( 'Black', 'fieldpress' ),
								'white'  => esc_html__( 'White', 'fieldpress' ),
							)
						),
						'section' => 'fp-option-sortable'
					),
					// sortable with active and deactive title
					'fp-field-sortable-social-sharing'  => array(
						'type'  => 'sortable',
						'label' => esc_html__( 'Sortable', 'fieldpress' ),
						'choices' => array(
							'active'      => array(
								'facebook'      => esc_html__( 'Facebook', 'fieldpress' ),
								'instagram'      => esc_html__( 'Instagram', 'fieldpress' ),
								'twitter'        => esc_html__( 'Twitter', 'fieldpress' ),
								'googleplus'     => esc_html__( 'Googleplus', 'fieldpress' ),
							),
							'inactive'     => array(
								'linkedin'      => esc_html__( 'Linkedin', 'fieldpress' ),
								'pinterest'      => esc_html__( 'Pinterest', 'fieldpress' ),
							)
						),
						'active_title'  => esc_html__( 'Active Social Sharing', 'fieldpress' ),
						'inactive_title' => esc_html__( 'Deactivate Social Sharing', 'fieldpress' ),
						'section' => 'fp-option-sortable'
					),
					/*-------------------switcher------------------------------*/
					'fp-option-field-switcher'  => array(
						'type'  => 'switcher',
						'label' => esc_html__( 'Switcher', 'fieldpress' ),
						'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
						'section' => 'fp-option-switcher'
					),
					//switcher with help
					'fp-field-switcher-help'  => array(
						'type'  => 'switcher',
						'info' => esc_html__( 'Enable Or Disable the setting', 'fieldpress' ),
						'label' => esc_html__( 'Switcher With Help Information', 'fieldpress' ),
						'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
						'section' => 'fp-option-switcher'
					),
					//switcher without after text
					'fp-field-switcher-without'  => array(
						'type'  => 'switcher',
						'label' => esc_html__( 'Switcher Without After Text', 'fieldpress' ),
						'section' => 'fp-option-switcher'
					),
					//switcher with description
					'fp-field-switcher-description'  => array(
						'type'  => 'switcher',
						'label' => esc_html__( 'Switcher With description', 'fieldpress' ),
						'desc'  => esc_html__( 'Switcher helps to enable or disable the setting', 'fieldpress' ),
						'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
						'section' => 'fp-option-switcher'
					),
					/**
					* # As checkbox ,radio, select in switcher also we retrive the post, page, post_type ,categories,tags
					* pass 'query_args' and choice as pass in checkbok,radio,select.
					*/
					//switcher with posts
					'fp-field-switcher-posts'  => array(
						'type'  => 'switcher',
						'label' => esc_html__( 'Switcher With Posts', 'fieldpress' ),
						'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
						'choices' => 'posts',
						'info' => esc_html__( 'Set choices => posts', 'fieldpress' ),
						'section' => 'fp-option-switcher'
					),
					//switcher with posts categories
					'fp-field-switcher-posts-categories'  => array(
						'type'  => 'switcher',
						'label' => esc_html__( 'Switcher With Post Categories', 'fieldpress' ),
						'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
						'choices' => 'categories',
						'info' => esc_html__( 'Set choices => categories', 'fieldpress' ),
						'section' => 'fp-option-switcher'
					),
					//switcher with posts categories
					'fp-field-switcher-posts-tages'  => array(
						'type'  => 'switcher',
						'label' => esc_html__( 'Switcher With Post Tags', 'fieldpress' ),
						'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
						'choices' => 'tags',
						'info' => esc_html__( 'Set choices => tags', 'fieldpress' ),
						'section' => 'fp-option-switcher'
					),
					//switcher with pages
					'fp-field-switcher-pages'  => array(
						'type'  => 'switcher',
						'label' => esc_html__( 'Switcher With Pages', 'fieldpress' ),
						'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
						'choices' => 'pages',
						'info' => esc_html__( 'Set choices => pages', 'fieldpress' ),
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
						'label' => esc_html__( 'Switcher With CPT Posts', 'fieldpress' ),
						'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
						'choices' => 'post',
						'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of wp_query & "choices" must be "post"', 'fieldpress' ),
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
							'hide_empty' => true,
						),
						'label' => esc_html__( 'Switcher With CPT categories', 'fieldpress' ),
						'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
						'choices' => 'taxonomy',
						'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'fieldpress' ),
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
							'hide_empty' => true,
						),
						'label' => esc_html__( 'Switcher With CPT Tags', 'fieldpress' ),
						'switcher-label' => esc_html__( 'Switch something', 'fieldpress' ),
						'choices' => 'taxonomy',
						'info' => esc_html__( 'query_args and choices are required."query_args" accepts all the args of get_terms & "choices" must be "taxonomy"', 'fieldpress' ),
						'section' => 'fp-option-switcher'
					),

					/*-------------------tabs------------------------------*/
					// tabs with out label
						'fp-field-tabs-nolabel' => array(
						'type' => 'tabs',
						'tabs' => array(
							'fp-option-nolabel-tab1'=>array(
								'label'     => esc_html__( 'Tab1', 'fieldpress' ),
								'icon'     => 'dashicons-before dashicons-admin-media',
							),
							'fp-option-nolabel-tab2'=>array(
								'label'     => esc_html__( 'Tab2', 'fieldpress' ),
								'icon'     => 'dashicons-before dashicons-admin-settings',
							),
							'fp-option-nolabel-tab3'=>array(
								'label'     => esc_html__( 'Tab3', 'fieldpress' ),
								'icon'     => 'fa fa-star',
							),
							'fp-option-nolabel-tab4'=>array(
								'label'     => esc_html__( 'Tab4', 'fieldpress' ),
								'icon'     => 'fa fa-folder',
							),
						),
						'fields'=> array(
							'fp-option-nolabel-tab1-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'fieldpress' ),
								'tab'  => 'fp-option-nolabel-tab1',
							),
							'fp-option-nolabel-tab1-number'  => array(
								'type'  => 'number',
								'label' => esc_html__( 'Number', 'fieldpress' ),
								'tab'  => 'fp-option-nolabel-tab1',
							),
							'fp-option-nolabel-tab2-url'  => array(
								'type'  => 'url',
								'label' => esc_html__( 'Url', 'fieldpress' ),
								'tab'  => 'fp-option-nolabel-tab2',
							),
							'fp-option-nolabel-tab2-email'  => array(
								'type'  => 'email',
								'label' => esc_html__( 'Email', 'fieldpress' ),
								'tab'  => 'fp-option-nolabel-tab2',
							),
							'fp-option-nolabel-tab3-textarea'  => array(
								'type'  => 'textarea',
								'label' => esc_html__( 'Textarea', 'fieldpress' ),
								'tab'  => 'fp-option-nolabel-tab3',
							),
							'fp-option-nolabel-tab3-colors'  => array(
								'type'  => 'color',
								'label' => esc_html__( 'Color', 'fieldpress' ),
								'tab'  => 'fp-option-nolabel-tab3',
							),
							'fp-option-nolabel-tab4-checkbox'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox', 'fieldpress' ),
								'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
								'tab'  => 'fp-option-nolabel-tab4'
							),
							'fp-option-nolabel-tab4-radio'  => array(
								'type'  => 'radio',
								'label' => esc_html__( 'Radio', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' => esc_html__( 'Yellow', 'fieldpress' ),
								),
								"default" => 'yellow',
								'tab'  => 'fp-option-nolabel-tab4',
							),
						),
					'section' => 'fp-option-tabs'
					),
					// tabs with label
					'fp-option-field-tabs' => array(
						'type' => 'tabs',
						'label' => esc_html__( 'Tabs with Label', 'fieldpress' ),
						'info' => esc_html__( 'Tabs with Label', 'fieldpress' ),
						'tabs' => array(
							'fp-option-tab1'=>array(
								'label'     => esc_html__( 'Tab1', 'fieldpress' ),
								'icon'     => 'dashicons-before dashicons-admin-media',
							),
							'fp-option-tab2'=>array(
								'label'     => esc_html__( 'Tab2', 'fieldpress' ),
								'icon'     => 'dashicons-before dashicons-admin-settings',
							),
							'fp-option-tab3'=>array(
								'label'     => esc_html__( 'Tab3', 'fieldpress' ),
								'icon'     => 'fa fa-star',
							),
							'fp-option-tab4'=>array(
								'label'     => esc_html__( 'Tab4', 'fieldpress' ),
								'icon'     => 'fa fa-folder',
							),
						),
						'fields'=> array(
							'fp-option-tab1-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'fieldpress' ),
								'tab'  => 'fp-option-tab1',
							),
							'fp-option-tab1-number'  => array(
								'type'  => 'number',
								'label' => esc_html__( 'Number', 'fieldpress' ),
								'tab'  => 'fp-option-tab1',
							),
							'fp-option-tab1-url'  => array(
								'type'  => 'url',
								'label' => esc_html__( 'Url', 'fieldpress' ),
								'tab'  => 'fp-option-tab1',

							),
							'fp-option-tab1-email'  => array(
								'type'  => 'email',
								'label' => esc_html__( 'Email', 'fieldpress' ),
								'tab'  => 'fp-option-tab1',
							),
							'fp-option-tab-textarea'  => array(
								'type'  => 'textarea',
								'label' => esc_html__( 'Textarea', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-colors'  => array(
								'type'  => 'color',
								'label' => esc_html__( 'Color', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-image'  => array(
								'type'  => 'image',
								'label' => esc_html__( 'Image', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-gallery'  => array(
								'type'  => 'gallery',
								'label' => esc_html__( 'Gallery', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-files'  => array(
								'type'  => 'file',
								'label' => esc_html__( 'File', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-date'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Date', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-date-time'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Date and Time', 'fieldpress' ),
								'time' => true,
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-time-only'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Time Only', 'fieldpress' ),
								'time' =>array(
									'time-only' => true,
									'time-format' =>''
								),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-map'  => array(
								'type'  => 'map',
								'label' => esc_html__( 'Map', 'fieldpress' ),
								'search_label' => esc_html__( 'Search Map', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-checkbox'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox', 'fieldpress' ),
								'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
								'tab'  => 'fp-option-tab2'
							),
							'fp-option-tab-checkbox-multiple'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox Multiple', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' =>esc_html__( 'Yellow', 'fieldpress' ),
								),
								'wrap-attr' => array(
									'class'  => 'inline-block',
								),
								'tab'  => 'fp-option-tab2',

							),
							'fp-option-tab-checkbox-post'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox Post', 'fieldpress' ),
								'choices' => 'posts',
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-select'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' =>esc_html__( 'Yellow', 'fieldpress' ),
								),
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-select-multiple'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select Multiple', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' =>esc_html__( 'Yellow', 'fieldpress' ),
								),
								'attr' => array(
									'multiple'  => 'multiple',
								),
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-select-post'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select Post', 'fieldpress' ),
								'choices' => 'posts',
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-radio'  => array(
								'type'  => 'radio',
								'label' => esc_html__( 'Radio', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' =>esc_html__( 'Yellow', 'fieldpress' ),
								),
								"default" => 'yellow',
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-wysiwyg'  => array(
								'type'  => 'wysiwyg',
								'label' => esc_html__( 'Wysiwyg', 'fieldpress' ),
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'fieldpress' ),
								'tab'  => 'fp-option-tab4',
							),
							'fp-option-tab-number'  => array(
								'type'  => 'number',
								'label' => esc_html__( 'Number', 'fieldpress' ),
								'tab'  => 'fp-option-tab4',
							),
							'fp-option-tab-url'  => array(
								'type'  => 'url',
								'label' => esc_html__( 'Url', 'fieldpress' ),
								'tab'  => 'fp-option-tab4',

							),
							'fp-option-tab-email'  => array(
								'type'  => 'email',
								'label' => esc_html__( 'Email', 'fieldpress' ),
								'tab'  => 'fp-option-tab4',
							),
						),
					'section' => 'fp-option-tabs'
					),
					// tabs with Icons only
					'fp-field-tabs-with-icon' => array(
						'type' => 'tabs',
						'label' => esc_html__( 'Tabs with Icon only', 'fieldpress' ),
						'tabs' => array(
							'fp-option-icon-tab1'=>array(
								'label'     => esc_html__( 'Tab1', 'fieldpress' ),
								'icon'     => 'dashicons-before dashicons-admin-media',
								'icon-only' => true,
							),
							'fp-option-icon-tab2'=>array(
								'label'     => esc_html__( 'Tab2', 'fieldpress' ),
								'icon'     => 'dashicons-before dashicons-admin-settings',
								'icon-only' => true,
							),
							'fp-option-icon-tab3'=>array(
								'label'     => esc_html__( 'Tab3', 'fieldpress' ),
								'icon'     => 'fa fa-star',
								'icon-only' => true,
							),
							'fp-option-icon-tab4'=>array(
								'label'     => esc_html__( 'Tab4', 'fieldpress' ),
								'icon'     => 'fa fa-folder',
								'icon-only' => true,
							),
						),
						'fields'=> array(
							'fp-option-icon-tab1-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'fieldpress' ),
								'tab'  => 'fp-option-icon-tab1',
							),
							'fp-option-icon-tab1-number'  => array(
								'type'  => 'number',
								'label' => esc_html__( 'Number', 'fieldpress' ),
								'tab'  => 'fp-option-icon-tab1',
							),
							'fp-option-icon-tab2-url'  => array(
								'type'  => 'url',
								'label' => esc_html__( 'Url', 'fieldpress' ),
								'tab'  => 'fp-option-icon-tab2',
							),
							'fp-option-icon-tab2-email'  => array(
								'type'  => 'email',
								'label' => esc_html__( 'Email', 'fieldpress' ),
								'tab'  => 'fp-option-icon-tab2',
							),
							'fp-option-icon-tab3-textarea'  => array(
								'type'  => 'textarea',
								'label' => esc_html__( 'Textarea', 'fieldpress' ),
								'tab'  => 'fp-option-icon-tab3',
							),
							'fp-option-icon-tab3-colors'  => array(
								'type'  => 'color',
								'label' => esc_html__( 'Color', 'fieldpress' ),
								'tab'  => 'fp-option-icon-tab3',
							),
							'fp-option-icon-tab4-checkbox'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox', 'fieldpress' ),
								'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
								'tab'  => 'fp-option-icon-tab4'
							),
							'fp-option-icon-tab4-radio'  => array(
								'type'  => 'radio',
								'label' => esc_html__( 'Radio', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' =>esc_html__( 'Yellow', 'fieldpress' ),
								),
								"default" => 'yellow',
								'tab'  => 'fp-option-icon-tab4',
							),
						),
					'section' => 'fp-option-tabs'
					)
					// tabs with repeater
					,'fp-option-tabs-with-repeater' => array(
						'type' => 'tabs',
						'label' => esc_html__( 'Tabs with Repeater', 'fieldpress' ),
						'tabs' => array(
							'fp-option-tab1'=>array(
								'label' => esc_html__( 'Tab1', 'fieldpress' ),
							),
							'fp-option-tab2'=>array(
								'label' => esc_html__( 'Tab2', 'fieldpress' ),
							),
							'fp-option-tab3'=>array(
								'label' => esc_html__( 'Tab3', 'fieldpress' ),
							),
							'fp-option-tab4'=>array(
								'label' => esc_html__( 'Tab4', 'fieldpress' ),
							),
						),
						'fields'=> array(
							'fp-option-tab1-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'fieldpress' ),
								'tab'  => 'fp-option-tab1',
							),
							'fp-option-tab1-number'  => array(
								'type'  => 'number',
								'label' => esc_html__( 'Number', 'fieldpress' ),
								'tab'  => 'fp-option-tab1',
							),

							/*repeater in tabs*/
							'fp-option-tab1-repeater'  => array(
								'type'  => 'repeater',
								'label' => esc_html__( 'Repeater', 'fieldpress' ),
								'nested' => true,
								'fields'=> array(
									'fp-option-tab1-repeater-checkbox'  => array(
										'type'  => 'checkbox',
										'label' => esc_html__( 'Checkbox', 'fieldpress' ),
										'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
									),
									'fp-option-tab1-repeater-text'  => array(
										'type'  => 'text',
										'label' => esc_html__( 'Text', 'fieldpress' ),
										'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
									),
								),
								'tab'  => 'fp-option-tab1',
							),

							'fp-option-tab-textarea'  => array(
								'type'  => 'textarea',
								'label' => esc_html__( 'Textarea', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-colors'  => array(
								'type'  => 'color',
								'label' => esc_html__( 'Color', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-image'  => array(
								'type'  => 'image',
								'label' => esc_html__( 'Image', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-gallery'  => array(
								'type'  => 'gallery',
								'label' => esc_html__( 'Gallery', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-files'  => array(
								'type'  => 'file',
								'label' => esc_html__( 'File', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-date'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Date', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-date-time'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Date and Time', 'fieldpress' ),
								'time' => true,
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-time-only'  => array(
								'type'  => 'date',
								'label' => esc_html__( 'Time Only', 'fieldpress' ),
								'time' =>array(
									'time-only' => true,
									'time-format' =>''
								),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-map'  => array(
								'type'  => 'map',
								'label' => esc_html__( 'Map', 'fieldpress' ),
								'search_label' => esc_html__( 'Search Map', 'fieldpress' ),
								'tab'  => 'fp-option-tab2',
							),
							'fp-option-tab-checkbox'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox', 'fieldpress' ),
								'checkbox-label' => esc_html__( 'check for something', 'fieldpress' ),
								'tab'  => 'fp-option-tab2'
							),
							'fp-option-tab-checkbox-multiple'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox Multiple', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' =>esc_html__( 'Yellow', 'fieldpress' ),
								),
								'wrap-attr' => array(
									'class'  => 'inline-block',
								),
								'tab'  => 'fp-option-tab2',

							),
							'fp-option-tab-checkbox-post'  => array(
								'type'  => 'checkbox',
								'label' => esc_html__( 'Checkbox Post', 'fieldpress' ),
								'choices' => 'posts',
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-select'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' =>esc_html__( 'Yellow', 'fieldpress' ),
								),
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-select-multiple'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select Multiple', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' =>esc_html__( 'Yellow', 'fieldpress' ),
								),
								'attr' => array(
									'multiple'  => 'multiple',
								),
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-select-post'  => array(
								'type'  => 'select',
								'label' => esc_html__( 'Select Post', 'fieldpress' ),
								'choices' => 'posts',
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-radio'  => array(
								'type'  => 'radio',
								'label' => esc_html__( 'Radio', 'fieldpress' ),
								'choices' => array(
									'red' => esc_html__( 'Red', 'fieldpress' ),
									'green' => esc_html__( 'Green', 'fieldpress' ),
									'blue' => esc_html__( 'Blue', 'fieldpress' ),
									'yellow' =>esc_html__( 'Yellow', 'fieldpress' ),
								),
								"default" => 'yellow',
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-wysiwyg'  => array(
								'type'  => 'wysiwyg',
								'label' => esc_html__( 'Wysiwyg', 'fieldpress' ),
								'tab'  => 'fp-option-tab3',
							),
							'fp-option-tab-text'  => array(
								'type'  => 'text',
								'label' => esc_html__( 'Text', 'fieldpress' ),
								'tab'  => 'fp-option-tab4',
							),
							'fp-option-tab-number'  => array(
								'type'  => 'number',
								'label' => esc_html__( 'Number', 'fieldpress' ),
								'tab'  => 'fp-option-tab4',
							),
							'fp-option-tab-url'  => array(
								'type'  => 'url',
								'label' => esc_html__( 'Url', 'fieldpress' ),
								'tab'  => 'fp-option-tab4',

							),
							'fp-option-tab-email'  => array(
								'type'  => 'email',
								'label' => esc_html__( 'Email', 'fieldpress' ),
								'tab'  => 'fp-option-tab4',
							),
						),
					'section' => 'fp-option-tabs',
					),

					/*-------------------text------------------------------*/
					'fp-option-field-text'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text', 'fieldpress' ),
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
						'desc'  => esc_html__( 'Enter your full name.', 'fieldpress' ),
						'label' => esc_html__( 'Text With Description', 'fieldpress' ),
						'section' => 'fp-option-text'
					),
					//text with default
					'fp-field-text-default'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text with Default Value', 'fieldpress' ),
						'default' => "FieldPress",
						'section' => 'fp-option-text'
					),
					//text with help 
					'fp-field-text-help'  => array(
						'type'  => 'text',
						'info' => esc_html__( 'This is required field.', 'fieldpress' ),
						'label' => esc_html__( 'Text With Help', 'fieldpress' ),
						'section' => 'fp-option-text'
					),
					//text with placeholder
					'fp-field-text-placeholder'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text With Placeholder', 'fieldpress' ),
						'attr' => array(
							'placeholder' => esc_html__( 'Only characters are allowed...', 'fieldpress' ),
						),
						'section' => 'fp-option-text'
					),
					//text with after text 
					'fp-field-text-after-field-texts'  => array(
						'type'  => 'text',
						'desc'  =>array(
							'after-field' => esc_html__( 'Enter your favourite pluign name', 'fieldpress' ),
						),
						'label' => esc_html__( 'Text with After Field Text', 'fieldpress' ),
						'section' => 'fp-option-text'
					),
					//text with after text 
					'fp-field-text-before-field-texts'  => array(
						'type'  => 'text',
						'desc'  =>array(
							'before-field' => esc_html__( 'Enter your favourite pluign name', 'fieldpress' ),
						),
						'label' => esc_html__( 'Text with Before Field Text', 'fieldpress' ),
						'section' => 'fp-option-text'
					),
					//text with read only
					'fp-field-text-read-only'  => array(
						'type'  => 'text',
						'default' => "FieldPress Plugin",
						'label' => esc_html__( 'Text with Read Only', 'fieldpress' ),
						'attr' => array(
							'readonly'=>''  // if required to pass only attribute then pass the arttribute with empty e.g readonly,required 
						),
						'section' => 'fp-option-text'
					),
					//text with max length 
					'fp-field-text-max-length'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text With Max Length', 'fieldpress' ),
						'desc' => esc_html__( 'Only 12 characters are accepted ', 'fieldpress' ),
						'attr' => array(
							'maxlength' => '12',
						),
						'section' => 'fp-option-text'
					),
					//text with custom style 
					'fp-field-text-custom-style'  => array(
						'type'  => 'text',
						'label' => esc_html__( 'Text With Custom Style', 'fieldpress' ),
						'attr' => array(
							'style' => 'background:grey;'
						),
						'section' => 'fp-option-text'
					),

					/*-------------------textarea------------------------------*/
					'fp-option-field-textarea'  => array(
						'type'  => 'textarea',
						'label' => esc_html__( 'Textarea', 'fieldpress' ),
						'section' => 'fp-option-textarea'
					),
					//textarea with placeholder
					'fp-field-textarea-placeholder'  => array(
						'type'  => 'textarea',
						'label' => esc_html__( 'Textarea With Placeholder', 'fieldpress' ),
						'attr' => array(
							'placeholder' => esc_html__( 'Your text goes here...', 'fieldpress' ),
						),
						'section' => 'fp-option-textarea'
					),
					//textarea with default
					'fp-field-textarea-default-value'  => array(
						'type'  => 'textarea',
						'default' => esc_html__( 'FieldPress is awesome plugin which provide you multiple facilities like create  metabox, framework option, customizer options, widget, shortcode, menu options.', 'fieldpress' ),
						'label' => esc_html__( 'Textarea With Default', 'fieldpress' ),
						'section' => 'fp-option-textarea'
					),
					//textarea with help
					'fp-field-textarea-help'  => array(
						'type'  => 'textarea',
						'info' => esc_html__( 'This field is required', 'fieldpress' ),
						'label' => esc_html__( 'Textarea With Help', 'fieldpress' ),
						'section' => 'fp-option-textarea'
					),
					//textarea with description
					'fp-field-textarea-default'  => array(
						'type'  => 'textarea',
						'desc'  => esc_html__( 'Enter your current details.', 'fieldpress' ),
						'label' => esc_html__( 'Textarea With Description', 'fieldpress' ),
						'section' => 'fp-option-textarea'
					),
					//textarea with Before Text
					'fp-field-textarea-before-text'  => array(
						'type'  => 'textarea',
						'desc'  => array(
							'before-field' =>  'Enter Your Current Address.',
						),
						'label' => esc_html__( 'Textarea With Before Text', 'fieldpress' ),
						'section' => 'fp-option-textarea'
					),
					//textarea with row max size
					'fp-field-textarea-row-max'  => array(
						'type'  => 'textarea',
						'label' => esc_html__( 'Textarea With Row and Column', 'fieldpress' ),
						'desc' => esc_html__( 'Note: Rows= 4 & cols = 50', 'fieldpress' ),
						'attr' => array(
							'rows'  => 4, 
							'cols'  => 50,
						),
						'section' => 'fp-option-textarea',
					),

					/*------------------------------url----------------------------*/
					'fp-option-field-url'  => array(
						'type'  => 'url',
						'label' => esc_html__( 'Url', 'fieldpress' ),
						'section' => 'fp-option-url'
					),
					//url with description
					'fp-field-url-description'  => array(
						'type'  => 'url',
						'label' => esc_html__( 'Url With Description', 'fieldpress' ),
						'desc' => esc_html__( 'Enter your email @ddress', 'fieldpress' ),
						'section' => 'fp-option-url'
					),
					//url with Default
					'fp-field-url-default'  => array(
						'type'  => 'url',
						'label' => esc_html__( 'Url With Default Value', 'fieldpress' ),
						'default' => esc_html__( 'https://wordpress.org/', 'fieldpress' ),
						'section' => 'fp-option-url'
					),
					//url with help
					'fp-field-url-help'  => array(
						'type'  => 'url',
						'label' => esc_html__( 'Url With Help Information', 'fieldpress' ),
						'info' => esc_html__( 'This is required field', 'fieldpress' ),
						'section' => 'fp-option-url'
					),

					/*----------------------------wysiwyg----------------------------*/
					'fp-option-field-wysiwyg'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg', 'fieldpress' ),
						'section' => 'fp-option-wysiwyg'
					),
					//wysiwyg with Help
					'fp-field-wysiwyg-help'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg with Help', 'fieldpress' ),
						'info' => esc_html__( 'Enter your article here.', 'fieldpress' ),
						'section' => 'fp-option-wysiwyg'
					),
					//wysiwyg without Media Button
					'fp-field-wysiwyg-without-media'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg without Media Button', 'fieldpress' ),
						'info' => esc_html__( 'Enter your article here.', 'fieldpress' ),
						'attr' => array(
							'mediaButtons'=> false,
						),
						'section' => 'fp-option-wysiwyg'
					),
					//wysiwyg without quicktags
					'fp-field-wysiwyg-without-quicktags'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg without Quicktags', 'fieldpress' ),
						'info' => esc_html__( 'Enter your article here.', 'fieldpress' ),
						'attr' => array(
							'mediaButtons'=> false,
							'quicktags'   => false,
						),
						'section' => 'fp-option-wysiwyg'
					),
					//wysiwyg without editor tool
					'fp-field-wysiwyg-without-editor-tool'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg without Editor Tool', 'fieldpress' ),
						'info' => esc_html__( 'Enter your article here.', 'fieldpress' ),
						'attr' => array(
							'mediaButtons'=> false,
							'plugins'     => '',
						),
						'section' => 'fp-option-wysiwyg'
					),
					//wysiwyg with certain editor tool (plugin) and toolbar1
					'fp-field-wysiwyg-with-certain-editor-tool'  => array(
						'type'  => 'wysiwyg',
						'label' => esc_html__( 'Wysiwyg with Certain Editor Tool', 'fieldpress' ),
						'info' => esc_html__( 'Enter your article here.', 'fieldpress' ),
						'attr' => array(
							'mediaButtons'=> false,
							'plugins'     => 'charmap colorpicker compat3x directionality fullscreen hr image link lists media paste tabfocus textcolor',
							'toolbar1'      => 'bullist numlist | blockquote',

						),
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
							'desc' => esc_html__( 'This description can directly pass through "desc".', 'fieldpress' ),
							'type'  => 'text',
							'label' => esc_html__( 'Text with Direct Description', 'fieldpress' ),
							'section' => 'fp-option-general-option'
						),
						// text with before label
						'fp-general-text-before-label'  => array(
							'desc' => array(
								'before-label' => esc_html__( 'This description show before label of the field.', 'fieldpress' ),
							),
							'type'  => 'text',
							'label' => esc_html__( 'Text Field with Text Before Label', 'fieldpress' ),
							'section' => 'fp-option-general-option'
						),
						// text with after label
						'fp-general-text-after-label'  => array(
							'desc' => array(
								'after-label' => esc_html__( 'This description show after label of the field.', 'fieldpress' ),
							),
							'type'  => 'text',
							'label' => esc_html__( 'Text Field with Text After label', 'fieldpress' ),
							'section' => 'fp-option-general-option'
						),
						// text with before field
						'fp-general-text-before-field'  => array(
							'desc' => array(
								'before-field' => esc_html__( 'This description will display before the field.', 'fieldpress' ),
							),
							'type'  => 'text',
							'label' => esc_html__( 'Text Field with Text Before Field', 'fieldpress' ),
							'section' => 'fp-option-general-option'
						),
						// text with after field
						'fp-general-text-after-field'  => array(
							'desc' => array(
								'after-field' => esc_html__( 'This description will display after the field.', 'fieldpress' ),
							),
							'type'  => 'text',
							'label' => esc_html__( 'Text Field with Text After Field', 'fieldpress' ),
							'section' => 'fp-option-general-option'
						),
						// text with help information
						'fp-general-text-help'  => array(
							'type'  => 'text',
							'label' => esc_html__( 'Text Field with Text After Field', 'fieldpress' ),
							'info' => esc_html__( 'This field is required.', 'fieldpress' ),
							'section' => 'fp-option-general-option'
						),
						// text with custom class
						'fp-general-text-custom'  => array(
							'type'  => 'text',
							'label' => esc_html__( 'Text Field with Custom Class', 'fieldpress' ),
							'desc' => esc_html__( '"Custom Class" class will appear in this field class.', 'fieldpress' ),
							/**
							 * 'attr' accept all parameters which include in field like "class","placeholder","max" ,"required"
							 */
							'attr' => array(
								'class'  => 'custom-class',
							),
							'section' => 'fp-option-general-option'
						),
					)
				)
			) ;
			parent::__construct();
		}

		/**
		 * Output widget.
		 *
		 * @see WP_Widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {

			$this->fieldpress_widget_before( $args, $instance );

			/*here comes the logig*/
			echo "Hi";

			$this->fieldpress_widget_after( $args );
		}
	}
}

/**
 * Register Widgets.
 */
function example_register_widgets() {

	register_widget( 'Example_Widget_Blog' );
}
add_action( 'widgets_init', 'example_register_widgets' ,11);