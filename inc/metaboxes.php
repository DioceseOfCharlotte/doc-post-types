<?php
/**
 * Metaboxes for parish cpt
 */

if ( ! class_exists( 'Doc_Meta' ) ) {

	/**
	* Main ButterBean class.  Runs the show.
	*
	* @since  1.0.0
	* @access public
	*/
	final class Doc_Meta {
		/**
		 * Sets up initial actions.
		 *
		 * @access private
		 * @return void
		 */
		private function setup_actions() {
			// Call the register function.
			add_action( 'butterbean_register', array( $this, 'register' ), 10, 2 );
		}

		/**
		 * Registers managers, sections, controls, and settings.
		 *
		 * @param  object $butterbean  Instance of the `ButterBean` object.
		 * @param  string $post_type
		 * @return void
		 */
		public function register( $butterbean, $post_type ) {

			$doc_po = array(
			   'department',
			   'parish',
			   'school',
			   'cpt_archive',
		   	);

			if ( ! in_array( $post_type, $doc_po, true ) ) {
				return; }

			require_once doc_posts_plugin()->dir_path . 'inc/bb-controls/class-control-contact.php';
			require_once doc_posts_plugin()->dir_path . 'inc/bb-controls/class-control-address.php';

				$butterbean->register_manager(
					'doc_contact_info',
					array(
					'label'     => 'Doc Info',
					'post_type' => $doc_po,
					'context'   => 'normal',
					'priority'  => 'high',
					)
				);

				$manager  = $butterbean->get_manager( 'doc_contact_info' );
				/* === Register Sections === */
				$manager->register_section(
					'doc_contact_fields',
					array(
					'label' => 'Contact',
					'icon'  => 'dashicons-format-status',
					)
				);
				$manager->register_section(
					'doc_location_fields',
					array(
					'label' => 'Location',
					'icon'  => 'dashicons-location-alt',
					)
				);

				/* === Register Controls === */

				$manager->register_control(
					new ButterBean_Control_Contact(
						$manager,
						'doc_contact',
						array(
						'type'        => 'contact',
						'section'     => 'doc_contact_fields',
						'settings' => array(
							'phone' 	=> 'doc_phone_number',
							'fax'  		=> 'doc_fax',
							'email'  	=> 'doc_email',
							'website' 	=> 'doc_website',
						),
						)
					)
				);

				$manager->register_control(
					new ButterBean_Control_Address(
						$manager,
						'doc_address',
						array(
						'type'        => 'address',
						'section'     => 'doc_location_fields',
						'settings' => array(
						'street' 	=> 'doc_street',
						'city'  	=> 'doc_city',
						'state'  	=> 'doc_state',
						'zip_code' 	=> 'doc_zip',
						'lat_lon' 	=> 'geo_coordinates',
						),
						)
					)
				);

				/* === Register Settings === */

				$manager->register_setting(
					'doc_phone_number',
					array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
				);
				$manager->register_setting(
					'doc_fax',
					array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
				);
				$manager->register_setting(
					'doc_email',
					array( 'sanitize_callback' => 'sanitize_email' )
				);
				$manager->register_setting(
					'doc_website',
					array( 'sanitize_callback' => 'esc_url' )
				);

				$manager->register_setting(
					'doc_street',
					array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
				);
				$manager->register_setting(
					'doc_city',
					array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
				);
				$manager->register_setting(
					'doc_state',
					array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
				);
				$manager->register_setting(
					'doc_zip',
					array( 'sanitize_callback' => 'absint' )
				);

				$manager->register_setting(
					'geo_coordinates',
					array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
				);

				// Parishes
			if ( 'parish' === $post_type ) {

				if ( current_user_can( 'manage_options' ) ) {
					$manager->register_control(
						'doc_parish_id',
						array(
							'type'        => 'text',
							'section'     => 'doc_contact_fields',
							'label'       => 'Parish ID',
						)
					);
					$manager->register_setting(
						'doc_parish_id',
						array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
					);
				}

				$manager->register_control(
					'doc_parish_staff',
					array(
					'type'        => 'textarea',
					'section'     => 'doc_contact_fields',
					'label'       => 'Parish Staff',
					'description' => 'Format:<br>Title: Name<br>Title: Name',
					)
				);

				$manager->register_setting(
					'doc_parish_staff',
					array( 'sanitize_callback' => 'wp_kses_post' )
				);

				$manager->register_section(
					'doc_mass_fields',
					array(
					'label' => 'Mass',
					'icon'  => 'dashicons-clock',
					)
				);

				$manager->register_control(
					'doc_mass_schedule',
					array(
					'type'        => 'textarea',
					'section'     => 'doc_mass_fields',
					'label'       => 'Mass Schedule',
					'description' => 'Example description.',
					)
				);

				$manager->register_setting(
					'doc_mass_schedule',
					array( 'sanitize_callback' => 'wp_kses_post' )
				);

			}// End if().

				// Schools
			if ( 'school' === $post_type ) {

				$manager->register_section(
					'doc_grade_level_fields',
					array(
					'label' => 'Grade Levels',
					'icon'  => 'dashicons-chart-bar',
					)
				);

				$manager->register_control(
					'doc_grade_level',
					array(
					'type'        => 'checkboxes',
					'section'     => 'doc_grade_level_fields',
					'label'       => 'Grades',
					'description' => 'Select all that apply.',
					'choices'     => array(
						'0-pk' => 'Pre-K',
						'0-tk' => 'Transitional-K',
						'0-k' => 'Kindergarten',
						'1' => '1st',
						'2' => '2nd',
						'3' => '3rd',
						'4' => '4th',
						'5' => '5th',
						'6' => '6th',
						'7' => '7th',
						'8' => '8th',
						'9' => '9th',
						'10' => '10th',
						'11' => '11th',
						'12' => '12th',
					),
					)
				);

				$manager->register_setting(
					'doc_grade_level',
					array( 'type' => 'array', 'sanitize_callback' => 'sanitize_key' )
				);
			}// End if().

				$manager->register_section(
					'doc_post_colors',
					array(
					'label' => 'Colors',
					'icon'  => 'dashicons-art',
					)
				);

				$manager->register_control(
					'doc_page_primary_color',
					array(
					'type'        => 'color',
					'section'     => 'doc_post_colors',
					'label'       => 'Primary color',
					'options' => array( 'palettes' => array( '#34495E', '#2980b9', '#39CCCC', '#16a085', '#FFC107', '#F44336' ) ),
					)
				);

				$manager->register_control(
					'doc_page_secondary_color',
					array(
					'type'        => 'color',
					'section'     => 'doc_post_colors',
					'label'       => 'Secondary color',
					'options' => array( 'palettes' => array( '#34495E', '#2980b9', '#39CCCC', '#16a085', '#FFC107', '#F44336' ) ),
					)
				);

				$manager->register_setting(
					'doc_page_primary_color',
					array( 'sanitize_callback' => 'sanitize_hex_color_no_hash' )
				);

				$manager->register_setting(
					'doc_page_secondary_color',
					array( 'sanitize_callback' => 'sanitize_hex_color_no_hash' )
				);

				// Image
				$manager->register_section(
					'header_fields',
					array(
					'label' => 'Header',
					'icon'  => 'dashicons-star-filled',
					)
				);

				$manager->register_control(
					'header_image',
					array(
					'type'        => 'image',
					'section'     => 'header_fields',
					'label'       => 'Header Image',
					)
				);

				$manager->register_setting(
					'header_image',
					array( 'sanitize_callback' => 'absint' )
				);
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {
			static $instance = null;
			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup_actions();
			}
			return $instance;
		}
		/**
		 * Constructor method.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function __construct() {}
	}
	Doc_Meta::get_instance();
}// End if().
