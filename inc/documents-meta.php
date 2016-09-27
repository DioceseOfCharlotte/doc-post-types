<?php
/**
 * Plugin Name: DPT Lesson #1
 * Plugin URI:  https://github.com/justintadlock/butterbean
 * Description: DPT Lesson #1 example plugin.
 * Version:     1.0.0
 * Author:      Justin Tadlock
 * Author URI:  http://themehybrid.com
 *
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2016, Justin Tadlock
 * @link       https://github.com/justintadlock/butterbean
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if ( ! class_exists( 'DPT_Documents_Meta' ) ) {

	/**
	 * Main DPT class.  Runs the show.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	final class DPT_Documents_Meta {

		/**
		 * Sets up initial actions.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function setup_actions() {

			// Register managers, sections, settings, and controls.
			add_action( 'butterbean_register', array( $this, 'register' ), 10, 2 );
		}

		/**
		 * Registers managers, sections, controls, and settings.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $butterbean  Instance of the `DPT` object.
		 * @param  string  $post_type
		 * @return void
		 */
		public function register( $butterbean, $post_type ) {

			// Only run this on the `document` post type.
			if ( 'document' !== $post_type )
				return;

			// Register our custom manager.
			$butterbean->register_manager(
				'dpt_document',
				array(
					'label'     => 'Document',
					'post_type' => 'document'
				)
			);

			// Get our custom manager object.
			$manager = $butterbean->get_manager( 'dpt_document' );

			// Register a section.
			$manager->register_section(
				'dpt_document_id_section',
				array(
					'label'    => 'Upload',
					'icon' => 'dashicons-upload'
				)
			);

			// Register a control.
			$manager->register_control(
				'dpt_document_id',
				array(
					'type'    => 'image',
					'section' => 'dpt_document_id_section',
					'label'   => '',
				)
			);

			// Register a setting.
			$manager->register_setting(
				'dpt_document_id',
				array(
					'sanitize_callback' => array( $this, 'sanitize_absint' )
				)
			);

			// Register a section.
			$manager->register_section(
				'dpt_document_v_section',
				array(
					'label'    => 'Version',
					'icon' => 'dashicons-tag'
				)
			);

			// Register a control.
			$manager->register_control(
				'document-version',
				array(
					'type'    => 'text',
					'section' => 'dpt_document_v_section',
					'label'   => '',
					'description' => 'date, revision, language, etc. <em>(optional)</em>'
				)
			);

			// Register a setting.
			$manager->register_setting(
				'document-version',
				array(
					'sanitize_callback' => 'sanitize_text_field'
				)
			);

			// Register a section.
			$manager->register_section(
				'dpt_document_parent_section',
				array(
					'label'    => 'Parent Document',
					'icon' => 'dashicons-paperclip'
				)
			);

			// Register a control.
			$manager->register_control(
				'document-parent',
				array(
					'type'    => 'parent',
					'section' => 'dpt_document_parent_section',
					'label'   => 'Is this file an appendix?',
					'description' => 'Choose the Document to append to.'
				)
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

	DPT_Documents_Meta::get_instance();
}
