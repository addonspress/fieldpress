<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * render the wysiwyg output 
 * @since 0.0.1
 * @param array $field_details
 * @param string $field_value
 * @return void
 */
function fieldpress_render_wysiwyg( $field_details, $field_value ) {
	/*defaults values for fields*/
	$default_attr = apply_filters( 'fieldpress_wysiwyg_field_default_args',array(
		'id'            => '',
		'class'         => '',
		'placeholder'   => '',
		'cols'          => 50,
		'rows'          => 12,
		'style'         => '',
		'mediaButtons'  => true,
		'quicktags'     => true,
		'plugins'       => 'charmap colorpicker compat3x directionality fullscreen hr image link lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
		'toolbar1'      => 'formatselect bold italic | bullist numlist | blockquote | alignleft aligncenter alignright | link unlink | wp_more | spellchecker',
		'block_formats' => ''

	) );
	$field_attr = $field_details['attr'];
	$field_attr['class'] = ( isset($field_attr['class'])? $field_attr['class'].' '.'fieldpress-wysiwyg-textarea':'fieldpress-wysiwyg-textarea' );
	$show_editor_label = (isset( $field_details['show-editor-label']) && !empty( $field_details['show-editor-label'] ) ? $field_details['show-editor-label']:__('Open Editor','fieldpress') );

	$attributes = wp_parse_args( $field_attr, $default_attr );
	$output = "<div class='fieldpress-wysiwyg-content'><a href='#' class='button button-secondary fieldpress-open-wysiwyg'>".esc_html( $show_editor_label )."</a>";
	$output .= "<div class='fieldpress-wysiwyg-wrapper'>";
	$output .= '<textarea ';

	foreach ($attributes as $name => $value) {
		$output .= sprintf('%1$s="%2$s"', esc_attr( $name ), esc_attr( $value ));
	}
	$output .= '>';
	if( !empty( $field_value )){
		/*formatting same Text widget*/
		if ( user_can_richedit() ) {
			add_filter( 'the_editor_content', 'format_for_editor', 10, 2 );
			$default_editor = 'tinymce';
		} else {
			$default_editor = 'html';
		}

		/** This filter is documented in wp-includes/class-wp-editor.php */
		$text = apply_filters( 'the_editor_content', stripslashes( $field_value ), $default_editor );

		/* Reset filter addition. */
		if ( user_can_richedit() ) {
			remove_filter( 'the_editor_content', 'format_for_editor' );
		}

		/* Prevent premature closing of textarea in case format_for_editor() didn't apply or the_editor_content filter did a wrong thing. */
		$escaped_text = preg_replace( '#</textarea#i', '&lt;/textarea', $text );

		$output .= $escaped_text;
	}

	$output .= '</textarea>';
	$output .= '</div>';/*.fieldpress-wysiwyg-wrapper*/
	$output .= '</div>';/*.fieldpress-wysiwyg-content*/
	echo $output;
}