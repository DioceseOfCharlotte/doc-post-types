<?php
/*
Plugin Name: DOC Post Types
Plugin URI: https://github.com/DioceseOfCharlotte/doc-post-types
Description: DOC Content Types for WordPress.
Version: 0.6.5
Author: Marty Helmick
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: doc-posts
GitHub Plugin URI: https://github.com/DioceseOfCharlotte/doc-post-types
*/

	/**
	 * Singleton class that sets up and initializes the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
final class Doc_Posts_Plugin {

	/**
	 * Directory path to the plugin folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_path = '';

	/**
	 * Directory URI to the plugin folder.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir_uri = '';

	/**
	 * Plugin CSS directory URI.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $css_uri = '';

	/**
	 * Plugin JS directory URI.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $js_uri = '';

	/**
	 * Plugin Image directory URI.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $img_uri = '';

	/**
	 * Google maps api key.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $maps_api = '';

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
			$instance->setup();
			$instance->includes();
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

	/**
	 * Initial plugin setup.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup() {
		$this->dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->dir_uri  = trailingslashit( plugin_dir_url( __FILE__ ) );

		// Plugin assets URIs.
		$this->css_uri = trailingslashit( $this->dir_uri . 'assets/styles' );
		$this->js_uri  = trailingslashit( $this->dir_uri . 'assets/scripts' );
		$this->img_uri  = trailingslashit( $this->dir_uri . 'assets/images' );

		$this->maps_api = get_theme_mod( 'google_maps_api' );
	}

	/**
	 * Loads include and admin files for the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function includes() {
		require_once $this->dir_path . 'lib/extended-cpts.php';
		require_once $this->dir_path . 'lib/extended-taxos.php';
		require_once $this->dir_path . 'inc/customizer.php';
		require_once $this->dir_path . 'inc/bb-settings/class-setting-value-array.php';
		require_once $this->dir_path . 'inc/bb-controls/class-control-address.php';
		require_once $this->dir_path . 'inc/bb-controls/class-control-contact.php';
		require_once $this->dir_path . 'inc/post-types.php';
		require_once $this->dir_path . 'inc/taxonomies.php';
		require_once $this->dir_path . 'inc/metaboxes.php';
		require_once $this->dir_path . 'inc/functions.php';
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Register scripts and styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_scripts() {
		wp_enqueue_media();
		wp_enqueue_style( 'dpt-admin-styles', trailingslashit( $this->css_uri ) . 'dpt.css' );
		wp_register_script( 'geocomplete', trailingslashit( $this->js_uri ) . 'address-autocomplete.js', false, false, true );
		wp_register_script( 'gplaces', "https://maps.googleapis.com/maps/api/js?key={$this->maps_api}&libraries=places&callback=initAutocomplete", array( 'geocomplete' ), false, true );
	}

	public function activation() {

		doc_register_post_types();
		doc_register_taxonomies();

		// Get the administrator role.
		$role = get_role( 'administrator' );
		// If the administrator role exists, add required capabilities for the plugin.
		if ( ! is_null( $role ) ) {

			$cpt_names = array(
				'school',
				'parish',
				'department',
				'archive_post',
				'bishop',
				'schools_office',
				'deacon',
				'development',
				'education',
				'finance',
				'hispanic_ministry',
				'housing',
				'human_resources',
				'info_tech',
				'liturgy',
				'macs',
				'multicultural',
				'planning',
				'property',
				'tribunal',
				'vocation',
				'statistics_report',
			);

			foreach ( $cpt_names as $name ) {
				// Taxonomy caps.
				// $role->add_cap( 'manage_{$name}_categories' );
				// $role->add_cap( 'manage_{$name}_tags' );

				// Post type caps.
				$role->add_cap( "create_{$name}s" );
				$role->add_cap( "edit_{$name}s" );
				$role->add_cap( "edit_others_{$name}s" );
				$role->add_cap( "publish_{$name}s" );
				$role->add_cap( "read_private_{$name}s" );
				$role->add_cap( "delete_{$name}s" );
				$role->add_cap( "delete_private_{$name}s" );
				$role->add_cap( "delete_published_{$name}s" );
				$role->add_cap( "delete_others_{$name}s" );
				$role->add_cap( "edit_private_{$name}s" );
				$role->add_cap( "edit_published_{$name}s" );

				add_role( $name, "{$name} Administrator",
					array(
						'read' => true,
						'upload_files' => true,
						'level_0' => true,
						"create_{$name}s" => true,
						"edit_{$name}s" => true,
						"edit_others_{$name}s" => true,
						"publish_{$name}s" => true,
						"read_private_{$name}s" => true,
						"delete_{$name}s" => true,
						"delete_private_{$name}s" => true,
						"delete_published_{$name}s" => true,
						"delete_others_{$name}s" => true,
						"edit_private_{$name}s" => true,
						"edit_published_{$name}s" => true,
					)
				);
			}
		}

		flush_rewrite_rules();
	}
}

/**
 * Gets the instance of the main plugin class.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function doc_posts_plugin() {
	return Doc_Posts_Plugin::get_instance();
}

doc_posts_plugin();
