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
		* @since  1.0.0
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
		* @since  1.0.0
		* @access public
		* @param  object  $butterbean  Instance of the `ButterBean` object.
		* @param  string  $post_type
		* @return void
		*/
		public function register( $butterbean, $post_type ) {
			if ( 'parish' !== $post_type && 'school' !== $post_type && 'department' !== $post_type ) {
				return; }
				/* === Register Managers === */
				$butterbean->register_manager(
					'doc_contact_info',
					array(
					'label'     => 'Doc Info',
					'post_type' => array( 'parish', 'school', 'department' ),
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

				if ( 'parish' === $post_type ) {

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
				}

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
}