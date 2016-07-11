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
		wp_enqueue_style( 'arch-admin-styles', trailingslashit( $this->css_uri ) . 'dpt.css' );
		wp_enqueue_script( 'gplaces', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAWH6M9ymO6A5wEtB_DQa3866F80KZC2Ck&libraries=places', false, true );
		wp_enqueue_script( 'geocomplete', trailingslashit( $this->js_uri ) . 'jquery.geocomplete.min.js', array( 'jquery', 'gplaces' ), false, true );
	}

	public function activation() {
		flush_rewrite_rules();

		// Get the administrator role.
		$role = get_role( 'administrator' );
		// If the administrator role exists, add required capabilities for the plugin.
		if ( ! is_null( $role ) ) {

			// Remove old caps.
			$role->remove_cap( 'create_parishes' );
			$role->remove_cap( 'create_schools' );
			$role->remove_cap( 'create_departments' );
			$role->remove_cap( 'create_archive_posts' );
			$role->remove_cap( 'create_bishop_posts' );
			$role->remove_cap( 'create_deacon_posts' );
			$role->remove_cap( 'create_development_posts' );
			$role->remove_cap( 'create_education_posts' );
			$role->remove_cap( 'create_finance_posts' );
			$role->remove_cap( 'create_hisp_min_posts' );
			$role->remove_cap( 'create_housing_posts' );
			$role->remove_cap( 'create_hr_posts' );
			$role->remove_cap( 'create_it_posts' );
			$role->remove_cap( 'create_liturgy_posts' );
			$role->remove_cap( 'create_macs_posts' );
			$role->remove_cap( 'create_multicultural_posts' );
			$role->remove_cap( 'create_planning_posts' );
			$role->remove_cap( 'create_properties_posts' );
			$role->remove_cap( 'create_tribunal_posts' );
			$role->remove_cap( 'create_vocations_posts' );
			$role->remove_cap( 'create_statistics_reports' );

			$role->remove_cap( 'manage_parishes' );
			$role->remove_cap( 'manage_schools' );
			$role->remove_cap( 'manage_departments' );
			$role->remove_cap( 'manage_archive_posts' );
			$role->remove_cap( 'manage_bishop_posts' );
			$role->remove_cap( 'manage_deacon_posts' );
			$role->remove_cap( 'manage_development_posts' );
			$role->remove_cap( 'manage_education_posts' );
			$role->remove_cap( 'manage_finance_posts' );
			$role->remove_cap( 'manage_hisp_min_posts' );
			$role->remove_cap( 'manage_housing_posts' );
			$role->remove_cap( 'manage_hr_posts' );
			$role->remove_cap( 'manage_it_posts' );
			$role->remove_cap( 'manage_liturgy_posts' );
			$role->remove_cap( 'manage_macs_posts' );
			$role->remove_cap( 'manage_multicultural_posts' );
			$role->remove_cap( 'manage_planning_posts' );
			$role->remove_cap( 'manage_properties_posts' );
			$role->remove_cap( 'manage_tribunal_posts' );
			$role->remove_cap( 'manage_vocations_posts' );
			$role->remove_cap( 'manage_statistics_reports' );

			$role->remove_cap( 'edit_parishes' );
			$role->remove_cap( 'edit_schools' );
			$role->remove_cap( 'edit_departments' );
			$role->remove_cap( 'edit_archive_posts' );
			$role->remove_cap( 'edit_bishop_posts' );
			$role->remove_cap( 'edit_deacon_posts' );
			$role->remove_cap( 'edit_development_posts' );
			$role->remove_cap( 'edit_education_posts' );
			$role->remove_cap( 'edit_finance_posts' );
			$role->remove_cap( 'edit_hisp_min_posts' );
			$role->remove_cap( 'edit_housing_posts' );
			$role->remove_cap( 'edit_hr_posts' );
			$role->remove_cap( 'edit_it_posts' );
			$role->remove_cap( 'edit_liturgy_posts' );
			$role->remove_cap( 'edit_macs_posts' );
			$role->remove_cap( 'edit_multicultural_posts' );
			$role->remove_cap( 'edit_planning_posts' );
			$role->remove_cap( 'edit_properties_posts' );
			$role->remove_cap( 'edit_tribunal_posts' );
			$role->remove_cap( 'edit_vocations_posts' );
			$role->remove_cap( 'edit_statistics_reports' );

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

			foreach ($cpt_names as $name ) {
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
			}
		}
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
