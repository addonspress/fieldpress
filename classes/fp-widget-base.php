<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!class_exists('FieldPress_Widget')) {

	/**
     * Class or almost all types of widget fields.
     *
	 * @package FieldPress
	 * @package FieldPress Widget Framework
     * @since 0.0.1
     */

	abstract class FieldPress_Widget extends WP_Widget {

	/**
	 * Holds all widget class
	 *
	 * @var array
	 * @access public
	 * @since 0.0.1
	 *
	 */
	public $widget_classname;

	/**
	 * Holds all widget description
	 *
	 * @var array
	 * @access public
	 * @since 0.0.1
	 *
	 */
	public $widget_description;

	/**
	 * Holds all widget_customize_selective_refresh
	 *
	 * @var array
	 * @access public
	 * @since 0.0.1
	 *
	 */
	public $widget_customize_selective_refresh;

	/**
	 * Holds all widget_id
	 *
	 * @var string
	 * @access public
	 * @since 0.0.1
	 *
	 */
	public $widget_id;

	/**
	 * Holds all widget_name
	 *
	 * @var string
	 * @access public
	 * @since 0.0.1
	 *
	 */
	public $widget_name;

	/**
	 * Holds all fields
	 *
	 * @var array
	 * @access public
	 * @since 0.0.1
	 *
	 */
	public $fields = array();

	/**
	 * Holds all control_ops
	 *
	 * @var array
	 * @access public
	 * @since 0.0.1
	 *
	 */
	public $control_ops = array();

	/**
	 * Holds all widget sections fields
	 *
	 * @var array
	 * @access protected
	 * @since 0.0.1
	 *
	 */
	protected $widget_sections_fields = array();
	
	/**
	 * Holds all widget sections 
	 *
	 * @var array
	 * @access protected
	 * @since 0.0.1
	 *
	 */
	protected $widget_sections = array();

	/**
	 * Holds all widget fields
	 *
	 * @var array
	 * @access protected
	 * @since 0.0.1
	 *
	 */
	protected $widget_fields = array();

	/**
	 * Hold current processing fields
	 *
	 * @var array
	 * @access protected
	 * @since 0.0.1
	 *
	 */
	protected $current_fields = array();

	/**
	 * Holds only unique fields types
	 *
	 * @var array
	 * @access protected
	 * @since 0.0.1
	 *
	 */
	protected $unique_field_types = array();

    /**
     * Constructor
     *
     * @access public
     * @since 0.0.1
     *
     */
	public function __construct() {

		$widget_options = apply_filters( 'fieldpress_widget_options', 
			array(
				'classname'   => $this->widget_classname,
				'description' => $this->widget_description,
				'customize_selective_refresh' => $this->widget_customize_selective_refresh,
			)
		);

		$widget_sections_fields = $this->fields;

		/*Hook before any function of class start */
		do_action( 'fieldpress_widget_framework_before', $widget_sections_fields );

		/*Basic variables initialization with filter*/
		$this->widget_sections_fields = apply_filters( 'fieldpress_widget_sections_fields', $widget_sections_fields );

		/*Since section is optional*/
		if( isset( $this->widget_sections_fields['sections'] ) ){
			$this->widget_sections = apply_filters( 'fieldpress_widget_sections', $this->widget_sections_fields['sections'] );
			/*Set default values for widget sections*/
			if( is_array( $this->widget_sections )){
				foreach( $this->widget_sections as $section_id=>$section ){
					$this->widget_section_default_values( $section_id, $section );
				}
				/*Sort section according to priority*/
				uasort ($this->widget_sections,'fieldpress_uasort');
			}
		}

		$this->widget_fields = apply_filters( 'filed_press_widget_fields', $this->widget_sections_fields['fields'] );
		/*Set default values for widget fields*/
		foreach( $this->widget_fields as $field_id=>$single_field ){
			$this->widget_field_default_values($field_id, $single_field);
		}
		/*Sort fields according to priority*/
		uasort ($this->widget_fields,'fieldpress_uasort');

		/*Hook before any function of class start */
		do_action( 'fieldpress_widget_framework_after', $widget_sections_fields );

		parent::__construct(
			$this->widget_id,/*$id_base*/
			$this->widget_name,/*Widget name will appear in UI*/
			$widget_options,/*widget options*/
			$this->control_ops
		);
	}

	/**
	 * Function to Set default values for widget
	 *
	 * @access public
	 * @since 0.0.1
	 *
	 * @param string $section_id Id of widget
	 * @param array $section Single widget
	 * @return void
	 *
	 */
	public function widget_section_default_values( $section_id, $section ) {
		$widget_details_section_default_values = array(
			'title' => ''
		);

		$widget_details_section_default_values = apply_filters( '$widget_details_section_default_values', $widget_details_section_default_values);

		$this->widget_sections[$section_id] =
		array_merge(
			$widget_details_section_default_values,
			(array)$section
		);
	}

	/**
	 * Function to Set default values for widget fields
	 *
	 * @access public
	 * @since 0.0.1
	 *
	 * @param string $field_id Id of widget field
	 * @param array $single_field Single widget field
	 * @return void
	 *
	 */
	public function widget_field_default_values( $field_id, $single_field ) {
		$field_details_default_values =
		array(
			'id' => $field_id,
			'label' => '',
			'desc' => '',
			'type' => 'text',
			'section' => ''
		);
		$field_details_default_values = apply_filters( 'widget_field_default_values', $field_details_default_values);

		$this->widget_fields[$field_id] =
		array_merge(
			$field_details_default_values,
			(array)$single_field
		);
	}

    /**
     * Find out and set unique fields for different fields provided
     *
     * @access public
     * @since 0.0.1
     *
     * @param string $menu_id Id of Menu
     * @param array $process_menu_fields menu fields
     * @param int $is_subfield check if repeater field
     * @param string $section_id
     *
     * @return void
     *
     */
	public function current_widget_fields( $process_widget_fields, $is_subfield = 0,  $section_id = '' ){

		foreach( $process_widget_fields as $field_id => $single_field ){
			if( 1 == $is_subfield){
				$single_field['section'] = $section_id;
			}

			if( isset($single_field['section'])){
				if( 1 != $is_subfield){
					$this->current_fields[$single_field['section']][$field_id]= $single_field;
				}

				$this->unique_field_types[] = $single_field['type'];
				if( $single_field['type'] == 'tabs' || $single_field['type'] == 'repeater'){
					$this->current_widget_fields( $single_field['fields'], 1, $single_field['section'] );
				}
			}
			else{

				if( 1 != $is_subfield){
					$this->current_fields['fieldpress-default-section'][$field_id]= $single_field;
				}
				$this->unique_field_types[] = $single_field['type'];
				if( $single_field['type'] == 'tabs' || $single_field['type'] == 'repeater'){
					$this->current_widget_fields( $single_field['fields'], 1, $single_field['section'] );
				}
			}
		}
	}

	public function set_current_fields(){
		$this->current_widget_fields( $this->widget_fields );
	}

	public function _register() {
		// Note that the widgets component in the customizer will also do the 'admin_print_scripts-widgets.php' action in WP_Customize_Widgets::print_scripts().
		add_action( 'admin_print_scripts-widgets.php', array( $this, 'enqueue_admin_scripts' ) );

		parent::_register();
	}

	public function enqueue_admin_scripts() {
		if( empty( $this->current_fields ) ){
			$this->set_current_fields();
		}
		/*remove duplicates*/
		$this->unique_field_types = array_unique( $this->unique_field_types );

		/*enqueue scripts*/
		fieldpress_enqueue_scripts( $this->unique_field_types, true );
	}

	public function form( $instance ) {
		
		if( empty( $this->current_fields ) ){
			$this->set_current_fields();
		}
		echo '<div class="fieldpress-addons fieldpress-widget-framework">';
		/*move fieldpress-default-section field to top*/
		if( isset( $this->current_fields['fieldpress-default-section'] ) ){
			$this->current_fields = array('fieldpress-default-section' => $this->current_fields['fieldpress-default-section']) + $this->current_fields;
			$fieldpress_default_section = $this->current_fields['fieldpress-default-section'];
			unset($this->current_fields['fieldpress-default-section']);

			foreach ( $fieldpress_default_section as $field_id => $single_field ) {
				$single_field['attr']['id'] = $this->get_field_id( $field_id );
				$single_field['attr']['name'] = $this->get_field_name( $field_id );
				$single_field['fieldpress-unique'] = $this->id;
				$value = isset( $instance[ $field_id ] ) ? $instance[ $field_id ] : '';
				fieldpress_render_field( $field_id, $single_field, $value, $instance );
			}
		}

		echo '<div class="fieldpress-wrap fieldpress-vertical-tab">';

		$transient  = get_transient( 'fieldpress-transient-'.esc_attr( $this->id ) );
		$active_section = ( ! empty( $transient['section_id'] ) ) ? $transient['section_id'] : '';
		echo '<input type="hidden" name="'.esc_attr( $this->get_field_name( 'fieldpress-current-section' ) ).'" class="fieldpress-current-section" value="'.esc_attr( $active_section ).'">';

		$i = 1;
		if( is_array( $this->widget_sections )){
			foreach($this->widget_sections as $section_id => $section) :
				$active = '';
				if( isset( $section['hide'] ) && $section['hide'] ){
					continue;
				}
				if( $i == 1 ){
					echo '<div class="fieldpress-tabs-menu"><ul class="fieldpress-main-tabs">';
					$active_section = empty( $active_section )  ? $section_id : $active_section;

					$i++;
				}
				if( $active_section == $section_id ){
					$active = ' class="active"';
				}
				$tab_title = '';
				if( isset($section['icon'] ) && !empty( $section['icon']  )){
					$tab_title = "<i class='fp-icon ".esc_attr( $section['icon'])."'></i>";
				}
				if( isset($section['title'] ) &&
					(!isset( $section['icon-only'] ) ||
						( isset( $section['icon-only'] ) && $section['icon-only'] == false )
					)
				){
					$tab_title .= esc_html( $section['title'] );
				}
				?>
				<li<?php echo $active;?>>
					<a href="#<?php echo esc_attr( $section_id );?>">
						<?php echo $tab_title;?>
					</a>
				</li>
				<?php
			endforeach;
		}
		if( $i > 1 ){
			echo '</ul></div>';
		}

		echo '<div class="fieldpress-tabs-content">';
		$i = 1;
		foreach ( $this->current_fields as $section_id => $section_details ):
			if ( ( $i ==1 && empty( $active_section ) ) || $active_section == $section_id ) {
				$active = ' active';
			} else {
				$active = ' hidden';
			}
			echo "<div class='fieldpress-tabs-content-wrapper" . $active . "' id='" . esc_attr( $section_id ) . "'>";

			foreach ( $section_details as $field_id => $single_field ) {
				$single_field['attr']['id'] = $this->get_field_id( $field_id );
				$single_field['attr']['name'] = $this->get_field_name( $field_id );
				$single_field['fieldpress-unique'] = $this->id;
				$value = isset( $instance[ $field_id ] ) ? $instance[ $field_id ] : '';
				fieldpress_render_field( $field_id, $single_field, $value, $instance );
			}
			echo "</div>";/*.fieldpress-tabs-content-wrapper*/
			$i++;
		endforeach;

		echo '</div>';/*.fieldpress-tabs-content*/
		echo '</div>';/*.fieldpress-wrap*/
		echo '</div>';/*.fieldpress-addons*/
	}

	public function fieldpress_widget_before( $args, $instance ) {
		echo $args['before_widget'];
		$title = apply_filters( 'widget_title', !empty( $instance['title'] ) ? $instance['title'] : '', $instance, $this->id_base );
		if ( !empty( $title ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}
	}

	public function fieldpress_widget_after( $args ) {
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		foreach ( $this->widget_fields as $field_id => $single_field ) {
			if( 'tabs' == $single_field['type'] ){
				foreach ( $single_field['fields'] as $tab_field_id => $tab_single_field ){
					$field_details_value_new = ( isset( $new_instance[$tab_field_id] ) ) ? $new_instance[$tab_field_id]:'' ;
					$instance[ $field_id ] = fieldpress_sanitize_field( $tab_single_field, $field_details_value_new );
				}
			}
			else{
				$field_details_value_new = ( isset( $new_instance[$field_id] ) ) ? $new_instance[$field_id]:'' ;
				$instance[ $field_id ] = fieldpress_sanitize_field( $single_field, $field_details_value_new );
			}
		}
		$fieldpress_current_section = ( isset( $new_instance['fieldpress-current-section'] ) ) ? $new_instance['fieldpress-current-section']: '';
		set_transient( 'fieldpress-transient-'.esc_attr( $this->id ), array( 'section_id' => sanitize_key( $fieldpress_current_section ) ), 30 );

		return $instance;
	}
}
}