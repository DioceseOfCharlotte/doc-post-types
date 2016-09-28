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
	 * Custom post types registered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $cpt_names = array(
			'department',
			'parish',
			'school',
			'archive_post',
			'bishop',
			'deacon',
			'development',
			'development_post',
			'education',
			'finance',
			'hispanic_ministry',
			'housing',
			'human_resources',
			'hr_post',
			'info_tech',
			'liturgy',
			'macs',
			'multicultural',
			'planning',
			'property',
			'schools_office',
			'school_post',
			'tribunal',
			'vocation',
			'statistics_report',
		);

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
		require_once $this->dir_path . 'inc/cpts-location.php';
		require_once $this->dir_path . 'inc/post-types.php';
		require_once $this->dir_path . 'inc/cpts-blog.php';
		require_once $this->dir_path . 'inc/taxonomies.php';
		require_once $this->dir_path . 'inc/metaboxes.php';
		require_once $this->dir_path . 'inc/documents-meta.php';
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
		wp_enqueue_style( 'dpt-admin-styles', $this->css_uri . 'dpt.css' );
		//wp_register_script( 'bb-file', $this->dir_uri . 'butterbean-media-file.js', array( 'backbone', 'wp-util' ), '', true );
		wp_register_script( 'geocomplete', $this->js_uri . 'address-autocomplete.js', false, false, true );
		wp_register_script( 'gplaces', "https://maps.googleapis.com/maps/api/js?key={$this->maps_api}&libraries=places&callback=initAutocomplete", array( 'geocomplete' ), false, true );
	}

	/**
	 * Returns the capabilities for the post types.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function doc_get_capabilities( $name ) {

		$caps = array(

			// meta caps (don't assign these to roles)
			'edit_post'              => "edit_{$name}",
			'read_post'              => "read_{$name}",
			'delete_post'            => "delete_{$name}",

			// primitive/meta caps
			'create_posts'           => "create_{$name}s",

			// primitive caps used outside of map_meta_cap()
			'edit_posts'             => "edit_{$name}s",
			'edit_others_posts'      => "edit_others_{$name}s",
			'publish_posts'          => "publish_{$name}s",
			'read_private_posts'     => "read_private_{$name}s",

			// primitive caps used inside of map_meta_cap()
			'read'                   => 'read',
			'delete_posts'           => "delete_{$name}s",
			'delete_private_posts'   => "delete_private_{$name}s",
			'delete_published_posts' => "delete_published_{$name}s",
			'delete_others_posts'    => "delete_others_{$name}s",
			'edit_private_posts'     => "edit_private_{$name}s",
			'edit_published_posts'   => "edit_published_{$name}s",
		);

		return apply_filters( 'doc_get_capabilities', $caps );
	}

	public function activation() {

		$this->doc_get_capabilities( $name );
		doc_register_blog_cpts();
		doc_register_location_cpts();
		doc_register_post_types();
		doc_register_taxonomies();
		$this->add_roles();

		flush_rewrite_rules();

	}

	public function add_roles() {

		foreach ( $this->cpt_names as $name ) {
			add_role( $name, "{$name} Administrator",
				array(
					'read' => true,
					'create_doc_documents' => true, // documents
					'edit_doc_documents' => true, // documents
					'manage_doc_documents' => true, // documents
					'restrict_content' => true, // members
					'level_1' => true, // for the author dropdown
					'upload_files' => true,
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

		// Get the administrator role.
		$role = get_role( 'administrator' );

		// Add required capabilities for the administrator role.
		if ( ! is_null( $role ) ) {

			$role->add_cap( 'create_doc_documents' );
			$role->add_cap( 'edit_doc_documents' );
			$role->add_cap( 'manage_doc_documents' );

			foreach ( $this->cpt_names as $name ) {

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
