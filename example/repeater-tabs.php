<?php
if( class_exists('FieldPress_Menu_Framework' ) ) {

    $menu_fields = array(
        'menus' => array(
            'fp-repeater-tabs'=>array(
                'page_title'   => esc_html__('FieldPress Repeater Tabs','fieldpress'),
                'menu_title'   => esc_html__('FieldPress Repeater Tabs','fieldpress'),
                'menu_slug'    => 'fp-repeater-tabs',
            ),
        ),
        'sections'=> array(
            /*
           -------------------------------------------
           Sections listed in "FieldPress General" Menu
           -------------------------------------------
           */
            'fp-repeater-tabs' => array(
                'title'   => esc_html__('FieldPress Repeater Tabs','fieldpress'),
                'menu'    => 'fp-repeater-tabs',
                'hide'    => true
            ),
        ),

        'fields'=> array(

            'fp-overview-general-repeater' => array(
                'type' => 'repeater',
                'info' => esc_html__( 'Some Description goes here', 'fieldpress' ),
                'section' => 'fp-repeater-tabs',
                'fields'=> array(
                    'fp-overview-general-repeater-wysiwyg'  => array(
                        'type'  => 'text',
                        'label' => esc_html__( 'Text', 'fieldpress' ),
                    ),
                    'fp-overview-general-repeater-tabs' => array(
                        'type' 			=> 'tabs',
                        'tabs'			=> array(
                            'fp-overview-general-repeat-tab1'=>array(
                                'label' => esc_html__( 'Repeater Tab1', 'fieldpress' ),
                            ),
                            'fp-overview-general-repeat-tab2'=>array(
                                'label' => esc_html__( 'Repeater Tab2', 'fieldpress' ),
                            ),
                            'fp-overview-general-repeat-tab3'=>array(
                                'label' => esc_html__( 'Repeater Tab3', 'fieldpress' ),
                            ),
                        ),
                        'fields'=> array(
                            'overview-repeater-tab-text'  => array(
                                'type'  => 'text',
                                'label' => esc_html__( 'Text', 'fieldpress' ),
                                'tab'   => 'fp-overview-general-repeat-tab1',
                            ),
                            'overview-repeater-tab-radio'  => array(
                                'type'  => 'radio',
                                'label' => esc_html__( 'Radio', 'fieldpress' ),
                                'choices' => array(
                                    'red' 	=> esc_html__( 'Red', 'fieldpress' ),
                                    'green' => esc_html__( 'Green', 'fieldpress' ),
                                    'blue' 	=> esc_html__( 'Blue', 'fieldpress' ),
                                    'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
                                ),
                                "default" => 'yellow',
                                'tab'  => 'fp-overview-general-repeat-tab1',
                            ),
                            'overview-repeater-tab-number'  => array(
                                'type'  => 'number',
                                'label' => esc_html__( 'Number', 'fieldpress' ),
                                'tab'   => 'fp-overview-general-repeat-tab2',
                            ),
                            'overview-repeater-tab-textarea'  => array(
                                'type'  => 'textarea',
                                'label' => esc_html__( 'Textarea', 'fieldpress' ),
                                'tab'   => 'fp-overview-general-repeat-tab2',
                            ),
                            'overview-repeater-tab-url'  => array(
                                'type'  => 'url',
                                'label' => esc_html__( 'Url', 'fieldpress' ),
                                'tab'   => 'fp-overview-general-repeat-tab3',
                            ),
                            'overview-repeater-tab-checkbox-multiple'  => array(
                                'type'  => 'checkbox',
                                'label' => esc_html__( 'Checkbox Multiple', 'fieldpress' ),
                                'choices'=> array(
                                    'red'   => esc_html__( 'Red', 'fieldpress' ),
                                    'green' => esc_html__( 'Green', 'fieldpress' ),
                                    'blue'  => esc_html__( 'Blue', 'fieldpress' ),
                                    'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
                                ),
                                'wrap-attr' => array(
                                    'class' => 'inline-block',
                                ),
                                'tab'   => 'fp-overview-general-repeat-tab3',
                            ),

                            /*inner repeater and tabs*/
                            'fp-overview-general-repeater-1' => array(
                                'type' => 'repeater',
                                'tab'   => 'fp-overview-general-repeat-tab1',
                                'fields'=> array(
                                    'fp-overview-general-repeater-1-wysiwyg'  => array(
                                        'type'  => 'text',
                                        'label' => esc_html__( 'Text', 'fieldpress' ),
                                    ),
                                    'fp-overview-general-repeater-1-tabs' => array(
                                        'type' 			=> 'tabs',
                                        'tabs'			=> array(
                                            'fp-overview-general-repeat-tab1-1'=>array(
                                                'label' => esc_html__( 'Repeater Tab1', 'fieldpress' ),
                                            ),
                                            'fp-overview-general-repeat-tab2-2'=>array(
                                                'label' => esc_html__( 'Repeater Tab2', 'fieldpress' ),
                                            ),
                                            'fp-overview-general-repeat-tab3-3'=>array(
                                                'label' => esc_html__( 'Repeater Tab3', 'fieldpress' ),
                                            ),
                                        ),
                                        'fields'=> array(
                                            'overview-repeater-tab-text-1'  => array(
                                                'type'  => 'text',
                                                'label' => esc_html__( 'Text', 'fieldpress' ),
                                                'tab'   => 'fp-overview-general-repeat-tab1-1',
                                            ),
                                            'overview-repeater-tab-radio-1'  => array(
                                                'type'  => 'radio',
                                                'label' => esc_html__( 'Radio', 'fieldpress' ),
                                                'choices' => array(
                                                    'red' 	=> esc_html__( 'Red', 'fieldpress' ),
                                                    'green' => esc_html__( 'Green', 'fieldpress' ),
                                                    'blue' 	=> esc_html__( 'Blue', 'fieldpress' ),
                                                    'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
                                                ),
                                                "default" => 'yellow',
                                                'tab'  => 'fp-overview-general-repeat-tab1-1',
                                            ),
                                            'overview-repeater-tab-number-1'  => array(
                                                'type'  => 'number',
                                                'label' => esc_html__( 'Number', 'fieldpress' ),
                                                'tab'   => 'fp-overview-general-repeat-tab2-1',
                                            ),
                                            'overview-repeater-tab-textarea-1'  => array(
                                                'type'  => 'textarea',
                                                'label' => esc_html__( 'Textarea', 'fieldpress' ),
                                                'tab'   => 'fp-overview-general-repeat-tab2-1',
                                            ),
                                            'overview-repeater-tab-url-1'  => array(
                                                'type'  => 'url',
                                                'label' => esc_html__( 'Url', 'fieldpress' ),
                                                'tab'   => 'fp-overview-general-repeat-tab3-1',
                                            ),
                                            'overview-repeater-tab-checkbox-multiple-1'  => array(
                                                'type'  => 'checkbox',
                                                'label' => esc_html__( 'Checkbox Multiple', 'fieldpress' ),
                                                'choices'=> array(
                                                    'red'   => esc_html__( 'Red', 'fieldpress' ),
                                                    'green' => esc_html__( 'Green', 'fieldpress' ),
                                                    'blue'  => esc_html__( 'Blue', 'fieldpress' ),
                                                    'yellow'=> esc_html__( 'Yellow', 'fieldpress' ),
                                                ),
                                                'wrap-attr' => array(
                                                    'class' => 'inline-block',
                                                ),
                                                'tab'   => 'fp-overview-general-repeat-tab3-1',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            /*inner repeater and tabs end*/
                        ),
                    ),
                ),
            ),

        )
    );
    $menu_fields = apply_filters( 'slider_press_meta_content', $menu_fields );
    new FieldPress_Menu_Framework( $menu_fields );
}
?>