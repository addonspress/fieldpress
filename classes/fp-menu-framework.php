<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!class_exists('FieldPress_Menu_Framework')) {
	/**
	 * Class or almost all types of Menu fields.
	 *
	 * @package FieldPress
	 * @package FieldPress Menu Framework
	 * @since 0.0.1
	 */
	class FieldPress_Menu_Framework {

		/*Basic variables for class*/

		/**
		 * Holds all menu, section fields
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $menus_sections_fields = array();

		/**
		 * Holds all menus
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $menus = array();

		/**
		 * Holds all menu sections
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $menus_sections = array();

		/**
		 * Holds all menu fields
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $menus_fields = array();

		/**
		 * Hold current processing menu
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $current_menu = array();

		/**
		 * Hold current $hook_suffix of menu
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $hook_suffix = array();

		/**
		 * Hold current processing sections of menu
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $current_sections_id = array();

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
		 * Holds all menu fields types for uniqueness
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 */
		protected $menu_value = array();

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
		 * Holds saved value of menu
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $menu_saved_value = array();

		/**
		 * Holds increment value of integer for unique position
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $menu_default_unique_position = 100;

		/**
		 * Constructor
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param array $menus_sections_fields All menues and menu fields
		 *
		 */

		public function __construct( $menus_sections_fields = array() ) {

			/*check admin area if not then exit.*/
			if ( ! is_admin() || empty( $menus_sections_fields ) ){
				return;
			}

			/*Basic variables initialization with filter*/
			$this->menus_sections_fields = apply_filters( 'fieldpress_menus_sections_fields', $menus_sections_fields );

			if( empty( $this->menus_sections_fields ) ){
				return;
			}

			/* Hook before any function of class start */
			do_action( 'fieldpress_menu_framework_before', $menus_sections_fields );

			$this->menus = apply_filters( 'fieldpress_menus', $this->menus_sections_fields['menus'] );

			/*Set default values for menus*/
			foreach( $this->menus as $menu_id=>$menu_details ){
				$this->menu_default_values( $menu_id, $menu_details );
			}

			/*Since section is optional*/
			if( isset( $this->menus_sections_fields['sections'] ) ){
				$this->menus_sections = apply_filters( 'fieldpress_menus_sections', $this->menus_sections_fields['sections'] );
				/*Set default values for menus sections*/
				if( is_array( $this->menus_sections )){
					foreach( $this->menus_sections as $section_id=>$section ){
						$this->menu_section_default_values( $section_id, $section );
					}
					/*Sort section according to priority*/
					fieldpress_stable_uasort ($this->menus_sections,'fieldpress_uasort');
				}

			}

			$this->menus_fields = apply_filters( 'filed_press_menus_fields', $this->menus_sections_fields['fields'] );
			/*Set default values for menu fields*/
			foreach( $this->menus_fields as $field_id=>$single_field ){
				$this->menu_field_default_values($field_id, $single_field);
			}
			/*Sort fields according to priority*/
			fieldpress_stable_uasort ($this->menus_fields,'fieldpress_uasort');

			/*Enqueue necessary styles and scripts*/
			add_action('admin_enqueue_scripts', array($this,'enqueue_admin_scripts'), 12);

			/*Add necessary menus*/
			add_action('admin_menu', array($this,'add_menus'), 12);

			/*Hook before any function of class start */
			do_action( 'fieldpress_menu_framework_after', $menus_sections_fields );
		}

		/**
		 * Function to Set default values for menu
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param string $menu_id Id of menu
		 * @param array $menu_details Single menu
		 * @return void
		 *
		 */
		public function menu_default_values( $menu_id, $menu_details ) {
			if(!isset($menu_details['parent_slug'])){
				$menu_details_default_values = array(

					'page_title'    => '',
					'menu_title'    => '',
					'capability'    => 'manage_options',
					'menu_slug'     => '',
					'function'      => '',
					'icon_url'      => '',
					'position'      => $this->menu_default_unique_position
				);
			}
			else{
				$menu_details_default_values = array(

					'parent_slug'   => '',
					'page_title'    => '',
					'menu_title'    => '',
					'capability'    => 'manage_options',
					'menu_slug'     => '',
					'function'      => '',
				);
			}
			$this->menu_default_unique_position += 1;

			$menu_details_default_values = apply_filters( 'menu_default_values', $menu_details_default_values);

			$this->menus[$menu_id] = array_merge(
				$menu_details_default_values,
				(array)$menu_details
			);
		}

		/**
		 * Function to Set default values for menu section
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param string $section_id Id of menu section
		 * @param array $section Single menu
		 * @return void
		 *
		 */
		public function menu_section_default_values($section_id, $section) {
			$menu_details_section_default_values = array(
				'title' => '',
				'menu' => '',
				'priority' => 10,
			);

			$menu_details_section_default_values = apply_filters( '$menu_details_section_default_values', $menu_details_section_default_values);

			$this->menus_sections[$section_id] = array_merge(
				$menu_details_section_default_values,
				(array)$section
			);
		}

		/**
		 * Function to Set default values for menu fields
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param string $field_id Id of menu field
		 * @param array $single_field Single menu field
		 * @return void
		 *
		 */
		public function menu_field_default_values( $field_id, $single_field ) {
			$field_details_default_values = array(
				'id' => $field_id,
				'label' => '',
				'desc' => '',
				'type' => 'text',
				'section' => '',
				'priority' => 10,
			);
			$field_details_default_values = apply_filters( 'menu_field_default_values', $field_details_default_values);

			$this->menus_fields[$field_id] =  array_merge(
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
		public function current_menu_fields( $menu_id, $process_menu_fields, $is_subfield = 0,  $section_id = '' ){

			foreach( $process_menu_fields as $field_id => $single_field ){
				if( 1 == $is_subfield ){
					if( !empty( $section_id ) ){
						$single_field['section'] = $section_id;
					}
					else{
						$single_field['menu'] = $menu_id;
					}
				}

				if( isset($single_field['section']) && !empty( $this->current_sections_id  )){
					if(in_array($single_field['section'], $this->current_sections_id  )):
						if( 1 != $is_subfield){
							$this->current_fields[$single_field['section']][$field_id]= $single_field;
						}

						$this->unique_field_types[] = $single_field['type'];
						if( in_array($single_field['type'], fieldpress_nested_style_fields()) || $single_field['type'] == 'repeater'){
							$this->current_menu_fields( $menu_id, $single_field['fields'], 1, $single_field['section'] );
						}
					endif;
				}
                elseif (isset($single_field['menu'])){

					if( $menu_id == $single_field['menu']){
						if( 1 != $is_subfield){
							$this->current_fields['fieldpress-default-section'][$field_id]= $single_field;
						}

						$this->unique_field_types[] = $single_field['type'];
						if( in_array($single_field['type'], fieldpress_nested_style_fields()) || $single_field['type'] == 'repeater'){
							$this->current_menu_fields( $menu_id,$single_field['fields'], 1 );
						}
					}
				}
			}
		}

		/**
		 * Set Current sections and fields
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @return void
		 *
		 */
		public function set_current_fields(){
			if( empty(  $this->current_sections_id ) ){
				$current_menu =  $_GET['page'];
				foreach( $this->menus as $menu_id => $menu_details ){
					if( $menu_details['menu_slug'] == $current_menu ){
						$this->current_menu = $menu_details;
						$this->current_menu['id'] = $menu_id;

						foreach( $this->menus_sections as $section_id => $section ){
							if($section['menu'] == $menu_id){
								/*Set array current menus sections*/
								$this->current_sections_id[] = $section_id;
							}
						}

						$this->current_menu_fields( $menu_id, $this->menus_fields, 0 );
					}
				}
			}
		}

		/**
		 * Enqueue style and scripts at admin panel
		 * Callback functions for admin_enqueue_scripts
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @return void
		 *
		 */
		public function enqueue_admin_scripts( $hook ) {

			/*$this->hook_suffix gives another value here*/
			$current_page = get_current_screen()->base;
			if( $current_page != $hook || !isset( $_GET['page'])){
				return;
			}

			$this->set_current_fields();

			/*remove duplicates*/
			$this->unique_field_types = array_unique( $this->unique_field_types );

			/*enqueue scripts*/
			fieldpress_enqueue_scripts( $this->unique_field_types, true );
		}

		/**
		 * Get single field value
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param string $field_id Id of field
		 * @return mixed
		 *
		 */
		public function get_field_value( $field_id ) {
			$field_value = get_option( $field_id );
			return $field_value;
		}

		/**
		 * Add admin menu
		 * Callback functions for admin_menu
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @return void
		 *
		 */
		public function add_menus() {

			foreach( $this->menus as $menu_id=>$menu_details ){

				if(!isset($menu_details['parent_slug'])){
					$this->hook_suffix = add_menu_page(
						$menu_details['page_title'],
						$menu_details['menu_title'],
						$menu_details['capability'],
						$menu_details['menu_slug'],
						array($this,'menu_screen'),
						$menu_details['icon_url'],
						$menu_details['position']
					);
				}
				else{
					$this->hook_suffix = add_submenu_page(
						$menu_details['parent_slug'],
						$menu_details['page_title'],
						$menu_details['menu_title'],
						$menu_details['capability'],
						$menu_details['menu_slug'],
						array($this,'menu_screen')
					);
				}
			}
		}

		/**
		 * Add fields on menu screen
		 * Callback functions for add_menu_page
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @return void
		 *
		 */
		public function menu_screen(){

			/*check capability again*/
			if (!current_user_can('manage_options')){
				wp_die( esc_html__("You don't have access to this page",'fieldpress') );
			}

			/*check if isset fieldpress-menu-action and check if it fieldpress-menu-save-update*/
			if ( isset($_POST['fieldpress-menu-action']) && $_POST['fieldpress-menu-action']== 'fieldpress-menu-save-update'){
				/*call for save*/
				$this->fieldpress_save_menu( $_POST );
			}

			if( empty( $this->current_fields ) ){
				$this->set_current_fields();
			}

			$menu_details = $this->current_menu;
			$menu_id = $menu_details['id'];

			$tabs_from = array(
				'type' => 'menu',
				'this_object' => $this,
			);


			?>
            <div class="fieldpress-addons fieldpress-menu-framework">

                <form action="" method="post">
                    <input type="hidden" name="fieldpress-menu-action" value="fieldpress-menu-save-update">
                    <input type="hidden" name="fieldpress-save-menu" value="<?php echo esc_attr( $menu_id );?>">
					<?php wp_nonce_field( basename(__FILE__), 'fieldpress_menu_nonce' );?>

                    <header class="fieldpress-header">
                        <div class="fieldpress-title">
                            <h1><?php echo esc_html( $menu_details['page_title'])?></h1>
                        </div>
                        <div class="fieldpress-actions">
                            <input type="submit" name="submit" id="fieldpress-submit" class="button button-primary action" value="<?php esc_attr_e('Save','fieldpress');?>" />
                            <input type="submit" name="reset" id="fieldpress-reset" class="button secondary" value="<?php esc_attr_e('Reset','fieldpress');?>">
                        </div>
                    </header>
					<?php

					/*move fieldpress-default-section field to top*/
					if( isset( $this->current_fields['fieldpress-default-section'] ) ){
						$fieldpress_default_section = $this->current_fields['fieldpress-default-section'];
						unset($this->current_fields['fieldpress-default-section']);

						foreach ( $fieldpress_default_section as $field_id => $single_field ) {
							$single_field['attr']['id'] = $single_field['id'];
							$single_field['attr']['name'] = $single_field['id'];

							$value = $this->get_field_value( $single_field['id'] );
							if ( ! $value ) {
								if ( isset( $single_field['default'] ) ) {
									$value = $single_field['default'];
								}
							}
							fieldpress_render_field( $field_id, $single_field, $value, $tabs_from );
						}
					}

					if( isset( $menu_details['section-layout']) && 'horizontal' == $menu_details['section-layout'] ){
						$section_layout = 'fieldpress-horizontal-tab';
					}
					else{
						$section_layout = 'fieldpress-vertical-tab';
					}
					echo '<div id="fieldpress-menu-tabs" class="fieldpress-wrap '.$section_layout.'">';
					$transient  = get_transient( 'fieldpress-transient-'.esc_attr( $menu_id ) );
					$active_section = ( ! empty( $transient['section_id'] ) ) ? $transient['section_id'] : '';

					echo '<input type="hidden" name="fieldpress-current-section" class="fieldpress-current-section" value="'.esc_attr( $active_section ).'">';

					$i = 1;
					foreach($this->menus_sections as $section_id => $section) :
						$active = '';
						if($section['menu'] == $menu_id) {
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
						}
					endforeach;
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
							$single_field['attr']['id']   = $single_field['id'];
							$single_field['attr']['name'] = $single_field['id'];

							$value = $this->get_field_value( $single_field['id'] );
							if ( ! $value ) {
								if ( isset( $single_field['default'] ) ) {
									$value = $single_field['default'];
								}
							}
							fieldpress_render_field( $field_id, $single_field, $value, $tabs_from );
						}
						echo "</div>";/*.fieldpress-tabs-content-wrapper*/
						$i++;

					endforeach;
					echo '</div>';/*.fieldpress-tabs-content*/
					echo '</div>';/*.fieldpress-wrap*/
					?>
                    <footer class="fieldpress-footer">
                        <div class="fieldpress-info">
                            <p>Powered by FieldPress</p>
                        </div>
                        <div class="fieldpress-actions">
                            <input type="submit" name="submit" class="button button-primary action" value="<?php esc_attr_e('Save','fieldpress');?>" />
                            <input type="submit" name="reset" class="button secondary" value="<?php esc_attr_e('Reset','fieldpress');?>">
                        </div>
                    </footer>
                </form>
            </div><!--fieldpress-addons-->
			<?php
		}

		/**
		 * Get menu value of menu fields
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param array $menu_details_post $_POST
		 * @return void|array
		 *
		 */
		public function fieldpress_save_menu( $menu_details_post ) {

			if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                       /*Check Autosave*/
			     || ( ! check_admin_referer( basename( __FILE__ ), 'fieldpress_menu_nonce') ) /*Check nonce - Security*/
			     || ( ! current_user_can( 'manage_options') ) )  /*Check permission*/
			{
				return $menu_details_post;
			}

			if( empty( $this->current_fields ) ){
				$this->set_current_fields();
			}

			$menu_id = $this->current_menu['id'];

			do_action('fieldpress_save_menu_fields', $this->menus_fields, $menu_details_post );

			/*menu id here*/
			$fieldpress_save_menu = $menu_details_post['fieldpress-save-menu'];

			if( isset( $menu_details_post['reset'] ) ){
				foreach( $this->menus_fields as $field_id => $single_field):

					if( isset( $single_field['section'] ) && !empty( $this->current_sections_id  )){
						if(in_array($single_field['section'], $this->current_sections_id )):
							$this->fieldpress_prepare_before_save( $single_field, $menu_details_post );
						endif;
					}
                    elseif (isset($single_field['menu'])){
						if( $fieldpress_save_menu == $single_field['menu']){
							$this->fieldpress_prepare_before_save( $single_field, $menu_details_post );
						}
					}
				endforeach;
			}
			else{
				foreach( $this->menus_fields as $field_id => $single_field):

					if( isset( $single_field['section'] ) && !empty( $this->current_sections_id  )){
						if(in_array($single_field['section'], $this->current_sections_id )):

							$this->fieldpress_prepare_before_save( $single_field, $menu_details_post );
						endif;
					}
                    elseif (isset($single_field['menu'])){
						if( $fieldpress_save_menu == $single_field['menu']){
							$this->fieldpress_prepare_before_save( $single_field, $menu_details_post );
						}
					}
				endforeach;
			}

			set_transient( 'fieldpress-transient-'.esc_attr( $menu_id ), array( 'section_id' => sanitize_key( $_POST['fieldpress-current-section']) ), 30 );
		}

		/**
		 * Prepare fields before save since you have sub filelds on different fields
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param array $single_field details of single field
		 * @param array $menu_details_post $_Post value
		 * @return void
		 *
		 */
		public function fieldpress_prepare_before_save( $single_field, $menu_details_post ) {

			$single_field_name = $single_field['id'];
			if( in_array( $single_field['type'], fieldpress_nested_style_fields() ) ){
				foreach ( $single_field['fields'] as $tab_field_id => $tab_single_field ){
					$field_details_value_new = ( isset( $menu_details_post[$tab_field_id] ) ) ? $menu_details_post[$tab_field_id] : '' ;
					$this->fieldpress_save_field( $tab_single_field, $tab_field_id, $field_details_value_new );
				}
			}
			else{
				$field_details_value_new = ( isset( $menu_details_post[$single_field_name] ) ) ? $menu_details_post[$single_field_name]:'' ;
				$this->fieldpress_save_field( $single_field, $single_field_name, $field_details_value_new );
			}
		}

		/**
		 * Saving menu in options - callback function of save_post
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param array $single_field details of single field
		 * @param string $field_name name of single field
		 * @param mixed $new_value New meta value
		 * @return void
		 *
		 */
		public function fieldpress_save_field( $single_field, $field_name, $new_value ) {

			/*old value*/
			$old_value = $this->get_field_value( $field_name );

			/*sanitize*/
			$new_value = fieldpress_sanitize_field( $single_field, $new_value );
			$field_name = apply_filters( 'fieldpress_save_field_field_name', $field_name, $single_field, $old_value, $new_value);
			$new_value = apply_filters( 'fieldpress_save_field_new_value', $new_value, $single_field, $field_name, $old_value);

			if ( $old_value == $new_value ){
				return;
			}
			delete_option( $field_name );
			update_option( $field_name, $new_value );
		}

	} /*END class FieldPress_Menu_Framework*/
} /*END if(!class_exists('FieldPress_Menu_Framework'))*/