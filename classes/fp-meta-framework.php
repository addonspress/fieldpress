<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!class_exists('FieldPress_Meta_Framework')) {
	/**
	 * Class of almost all types of meta fields.
	 *
	 * @package FieldPress
	 * @package FieldPress Meta Framework
	 * @since 0.0.1
	 */
	class FieldPress_Meta_Framework {

		/*Basic variables for class*/

		/**
		 * Holds all meta boxes and meta fields
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $meta_sections_fields = array();

		/**
		 * Holds all meta boxes
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $meta_boxes = array();

		/**
		 * Holds all meta sections
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $meta_sections = array();

		/**
		 * Holds all meta fields
		 *
		 * @var array
		 * @access protected
		 * @since 0.0.1
		 *
		 */
		protected $meta_fields = array();

		/**
		 * Hold current processing sections of meta
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
		 * @param array $meta_sections_fields All meta boxes and meta fields
		 *
		 */
		public function __construct( $meta_sections_fields = array() ) {

			/*If we are not in admin area exit.*/
			if ( ! is_admin() ){
				return;
			}

			/*Basic variables initialization with filter*/
			$this->meta_sections_fields = apply_filters( 'fieldpress_meta_sections_fields', $meta_sections_fields );

			if( empty( $this->meta_sections_fields ) ){
				return;
			}

			/*Hook before any function of class start */
			do_action( 'fieldpress_meta_framework_before', $meta_sections_fields );

			$this->meta_boxes = apply_filters( 'fieldpress_meta_boxes', $this->meta_sections_fields['meta_boxes'] );

			/*Set default values for meta box*/
			foreach( $this->meta_boxes as $meta_box_id=>$meta_box_details ){
				$this->meta_box_default_values($meta_box_id, $meta_box_details);
			}

			/*Since section is optional*/
			if( isset( $this->meta_sections_fields['sections'] ) ){
				$this->meta_sections = apply_filters( 'fieldpress_meta_sections', $this->meta_sections_fields['sections'] );
				/*Set default values for meta sections*/
				if( is_array( $this->meta_sections ) ){
					foreach( $this->meta_sections as $meta_details_section_id=>$meta_details_section ){
						$this->meta_section_default_values( $meta_details_section_id, $meta_details_section );
					}
					/*Sort section according to priority*/
					fieldpress_stable_uasort ($this->meta_sections,'fieldpress_uasort');
				}
			}

			$this->meta_fields = apply_filters( 'fieldpress_meta_fields', $this->meta_sections_fields['fields'] );
			/*Set default values for meta fields*/
			foreach( $this->meta_fields as $field_id=>$single_field ){
				$this->meta_fields_default_values( $field_id, $single_field );
			}
			/*Sort fields according to priority*/
			fieldpress_stable_uasort ($this->meta_fields,'fieldpress_uasort');

			/*Enqueue necessary styles and scripts 2nd*/
			add_action('admin_enqueue_scripts', array($this,'enqueue_admin_scripts'), 12);

			/*Add necessary meta boxes 1st*/
			add_action('add_meta_boxes', array($this,'add_post_meta_boxes'), 12, 2);

			/*Save necessary meta boxes 1st on save post*/
			add_action('save_post', array($this,'save_post_metas'), 12, -1);

			/*Hook before any function of class end */
			do_action( 'fieldpress_meta_framework_after', $this->meta_sections_fields );
		}

		/**
		 * Function to Set default values for meta box
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param string $meta_box_id Id of meta box
		 * @param array $meta_box_details Single meta box
		 * @return void
		 *
		 */
		public function meta_box_default_values( $meta_box_id, $meta_box_details ) {
			$meta_box_default_values =
				array(
					'id' => $meta_box_id,
					'context' => 'normal',
					'priority' => 'high',
					'post_types' => array('post')
				);
			$meta_box_default_values = apply_filters( 'fieldpress_meta_box_default_values', $meta_box_default_values);

			$this->meta_boxes[$meta_box_id] =
				array_merge(
					$meta_box_default_values,
					(array)$meta_box_details
				);
		}

		/**
		 * Function to Set default values for section
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param string $meta_details_section_id Id of meta section
		 * @param array $meta_details_section Single meta section
		 * @return void
		 *
		 */
		public function meta_section_default_values( $meta_details_section_id, $meta_details_section ) {
			$meta_details_section_default_values = array(
				'title' => '',
				'meta_box' => ''
			);

			$meta_details_section_default_values = apply_filters( 'fieldpress_meta_details_section_default_values', $meta_details_section_default_values);

			$this->meta_sections[$meta_details_section_id] =
				array_merge(
					$meta_details_section_default_values,
					(array)$meta_details_section
				);
		}

		/**
		 * Function to Set default values for meta fields
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param string $field_id Id of meta field
		 * @param array $single_field Single meta field
		 * @return void
		 *
		 */
		public function meta_fields_default_values( $field_id, $single_field ) {
			$meta_fields_default_values = array(
				'id'        => $field_id,
				'label'     => '',
				'desc'      => '',
				'type'      => 'text',
				'meta_box'  => ''
			);
			$meta_fields_default_values = apply_filters( 'fieldpress_meta_fields_default_values', $meta_fields_default_values);

			$this->meta_fields[$field_id] =  array_merge(
				$meta_fields_default_values,
				(array)$single_field
			);
		}

		/**
		 * Find out and set unique fields for different fields provided
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param string $meta_box_id Id of metabox
		 * @param array $process_meta_fields meta fields
		 * @param int $is_subfield check if repeater field
		 * @param string $section_id

		 * @return void
		 *
		 */
		public function current_meta_fields( $meta_box_id, $process_meta_fields, $is_subfield = 0, $section_id = '' ){

			foreach( $process_meta_fields as $field_id => $single_field ){
				if( 1 == $is_subfield ){
					if( !empty( $section_id ) ){
						$single_field['section'] = $section_id;
					}
					else{
						$single_field['meta_box'] = $meta_box_id;
					}
				}

				if( isset($single_field['section']) && !empty( $this->current_sections_id[$meta_box_id] )){
					if(in_array($single_field['section'], $this->current_sections_id[$meta_box_id] )):
						if( 1 != $is_subfield){
							$this->current_fields[$meta_box_id][$single_field['section']][$field_id]= $single_field;
						}

						$this->unique_field_types[] = $single_field['type'];
						if( in_array($single_field['type'], fieldpress_nested_style_fields()) || $single_field['type'] == 'repeater' || $single_field['type'] == 'orders' ){
							$this->current_meta_fields( $meta_box_id, $single_field['fields'], 1, $single_field['section'] );
						}
					endif;
				}
                elseif (isset($single_field['meta_box'])){
					if( $meta_box_id == $single_field['meta_box']){

						if( 1 != $is_subfield){
							$this->current_fields[$meta_box_id]['fieldpress-default-section'][$field_id]= $single_field;
						}

						$this->unique_field_types[] = $single_field['type'];
						if( in_array($single_field['type'], fieldpress_nested_style_fields()) || $single_field['type'] == 'repeater' || $single_field['type'] == 'orders' ){
							$this->current_meta_fields( $meta_box_id, $single_field['fields'], 1 );
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
				global $typenow;
				foreach( $this->meta_boxes as $meta_box_id=>$meta_box_details ){
					if (in_array( $typenow, $meta_box_details['post_types']) && fieldpress_is_edit_page() ){

						foreach($this->meta_sections as $section_id => $section) :
							if( $meta_box_id == $section['meta_box']){
								/*Set array current meta sections*/
								$this->current_sections_id[$meta_box_id][] = $section_id;
							}
						endforeach;

						$this->current_meta_fields( $meta_box_id, $this->meta_fields );
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
		public function enqueue_admin_scripts() {

			global $typenow;
			if( !$typenow ){
				return;
			}

			$this->set_current_fields();

			/*remove duplicates*/
			$this->unique_field_types = array_unique($this->unique_field_types);

			/*enqueue scripts*/
			fieldpress_enqueue_scripts( $this->unique_field_types, true );
		}

		/**
		 * Get single field value
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param int $post_id Id of post
		 * @param string $field_id Id of field
		 * @return mixed
		 *
		 */
		public function get_field_value($post_id, $field_id) {
			$field_value = get_post_meta( $post_id, $field_id,true );
			return $field_value;
		}

		/**
		 * Add metabox
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param string $post_type Current post type
		 * @return void
		 *
		 */
		/*public function add_post_meta_boxes($post_type, $post)*/
		public function add_post_meta_boxes( $post_type ) {

			foreach( $this->meta_boxes as $meta_box_id=>$meta_box_details ){
				if( in_array( $post_type, $meta_box_details['post_types'] ) ) {
					$section_layout = isset( $meta_box_details['section-layout'] ) ? $meta_box_details['section-layout'] : '';
					add_meta_box(
						$meta_box_id,
						$meta_box_details['title'],
						array( $this, 'meta_screen' ),
						$post_type,
						$meta_box_details['context'],
						$meta_box_details['priority'],
						array(
							'fb-section-layout' => $section_layout,
						)
					);
				}
			}
		}

		/**
		 * Add fields on meta screen
		 * Callback functions for add_meta_box
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param object $post Current post object
		 * @param array $meta_box_details Extra parameters in add_meta_box
		 *
		 * @return void
		 *
		 */
		public function meta_screen( $post, $meta_box_details ){

			do_action( 'fieldpress_meta_screen_before', $post, $meta_box_details );

			/*$meta_box_id is always in id of callback meta data*/
			$meta_box_id = $meta_box_details['id'];

			echo '<div class="fieldpress-addons fieldpress-meta-framework">';

			if( empty( $this->current_fields ) ){
				$this->set_current_fields();
			}

			/*move fieldpress-default-section field to top*/
			if( isset( $this->current_fields[$meta_box_id]['fieldpress-default-section'] ) ){
				$fieldpress_default_section = $this->current_fields[$meta_box_id]['fieldpress-default-section'];
				unset($this->current_fields[$meta_box_id]['fieldpress-default-section']);

				foreach ( $fieldpress_default_section as $field_id => $single_field ) {
					$single_field['attr']['id'] = $single_field['id'];
					$single_field['attr']['name'] = $single_field['id'];

					$value = $this->get_field_value( $post->ID, $single_field['id'] );
					if( !metadata_exists('post', $post->ID, $single_field['id'])){
						if ( isset( $single_field['default'] ) ) {
							$value = $single_field['default'];
						}
					}

					fieldpress_render_field( $field_id, $single_field, $value );
				}
			}

			/*sections layout*/
			$section_layout = ('horizontal' == $meta_box_details['args']['fb-section-layout'])? 'fieldpress-horizontal-tab':'fieldpress-vertical-tab';
			echo '<div class="fieldpress-wrap '.$section_layout.'">';

			$i = 1;
			foreach($this->meta_sections as $section_id => $section) :
				$active = '';
				if( $meta_box_id == $section['meta_box']){
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
			foreach ( $this->current_fields as $current_meta_box_id => $current_section_details ):
				if( $meta_box_id == $current_meta_box_id ){
					foreach ( $current_section_details as  $section_id => $section_details ):
						if (  $i == 1 ) {
							$active = ' active';
						} else {
							$active = ' hidden';
						}

						echo "<div class='fieldpress-tabs-content-wrapper" . $active . "' id='" . esc_attr( $section_id ) . "'>";

						foreach ( $section_details as $field_id => $single_field ) {
							$single_field['attr']['id'] = $single_field['id'];
							$single_field['attr']['name'] = $single_field['id'];

							$value = $this->get_field_value( $post->ID, $single_field['id'] );
							if( !metadata_exists('post', $post->ID, $single_field['id'])){
								if ( isset( $single_field['default'] ) ) {
									$value = $single_field['default'];
								}
							}

							fieldpress_render_field( $field_id, $single_field, $value );
						}
						echo "</div>";/*.fieldpress-tabs-content-wrapper*/
						$i++;
					endforeach;
				}
			endforeach;

			wp_nonce_field( basename(__FILE__), 'fieldpress_meta_box_nonce' );

			echo '</div>';/*.fieldpress-tabs-content*/
			echo '</div>';/*.fieldpress-wrap*/
			echo '</div>';/*.fieldpress-addons*/

			do_action( 'fieldpress_meta_screen_after', $post, $meta_box_details );

		}

		/**
		 * Saving meta - callback function of save_post
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param int $post_id id of saving post
		 * @param object $post Current post object
		 * @return mixed depending on condition
		 *
		 * function save_post_metas( $post_id, $post, $update )
		 */
		public function save_post_metas( $post_id, $post ) {

			$post_type_object = get_post_type_object( $post->post_type );

			/*security check*/
			/*Verify the nonce before proceeding.*/
			if ( !isset( $_POST[ 'fieldpress_meta_box_nonce' ] ) || !wp_verify_nonce( $_POST[ 'fieldpress_meta_box_nonce' ], basename( __FILE__ ) ) )
				return;

			/*Stop WP from clearing custom fields on autosave*/
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
				return;

			if ( ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )     /*Check Revision*/
			     || ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) )  /*Check permission*/
			{
				return $post_id;
			}

			if( empty( $this->current_fields ) ){
				$this->set_current_fields();
			}

			do_action('fieldpress_save_post_metas', $this->meta_sections_fields, $post_id, $post, $_POST );

			foreach( $this->meta_boxes as $meta_box_id=>$meta_box_details ){

				if(in_array($post->post_type, $meta_box_details['post_types'])){

					foreach( $this->meta_fields as $field_id=>$single_field ){

						if( isset($single_field['section']) && !empty( $this->current_sections_id[$meta_box_id] )){
							if( in_array( $single_field['section'], $this->current_sections_id[$meta_box_id] ) ):
								$this->fieldpress_prepare_before_save( $single_field, $_POST , $post_id);
							endif;
						}
                        elseif (isset($single_field['meta_box'])){
							if( $meta_box_id == $single_field['meta_box']){
								$this->fieldpress_prepare_before_save( $single_field, $_POST , $post_id);
							}
						}
					}
				}
			}
		}

		/**
		 * Prepare fields before save since you have sub filelds on different fields
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param array $single_field details of single field
		 * @param array $meta_details_post $_Post value
		 * @param int $post_id Id of post
		 * @return void
		 *
		 */
		public function fieldpress_prepare_before_save( $single_field, $meta_details_post, $post_id) {

			$single_field_name = $single_field['id'];
			$field_details_value_new = ( isset( $meta_details_post[$single_field_name] ) ) ? $meta_details_post[$single_field_name]:'' ;
			$this->fieldpress_save_field( $single_field, $single_field_name, $field_details_value_new,$post_id );
		}

		/**
		 * Saving meta - callback function of save_post
		 *
		 * @access public
		 * @since 0.0.1
		 *
		 * @param array $single_field details of single field
		 * @param int $post_id Id of post
		 * @param string $field_name name of single field
		 * @param mixed $new_value New meta value
		 * @return void
		 *
		 */
		public function fieldpress_save_field( $single_field, $field_name, $new_value, $post_id ) {

			/*old value*/
			$old_value = $this->get_field_value( $post_id, $field_name );

			/*sanitize*/
			$new_value = fieldpress_sanitize_field( $single_field, $new_value );

			$post_id = apply_filters( 'fieldpress_meta_save_field_post_id', $post_id, $single_field, $field_name, $old_value , $new_value );
			$field_name = apply_filters( 'fieldpress_meta_save_field_name', $field_name, $single_field, $post_id, $old_value, $new_value);
			$new_value = apply_filters( 'fieldpress_meta_save_field_new_value', $new_value, $single_field, $post_id, $field_name, $old_value);
			$old_value = apply_filters( 'fieldpress_meta_save_field_old_value', $old_value, $single_field, $post_id, $field_name, $new_value);

			do_action( 'fieldpress_meta_save_field_before',$post_id, $single_field, $field_name, $old_value , $new_value );

			if ( $old_value == $new_value ){
				return;
			}
			update_post_meta( $post_id, $field_name, $new_value );

			do_action( 'fieldpress_meta_save_field_after',$post_id, $single_field, $field_name, $old_value , $new_value );

		}

	} /*END class FieldPress_Meta_Framework*/
} /*END if(!class_exists('FieldPress_Meta_Framework'))*/