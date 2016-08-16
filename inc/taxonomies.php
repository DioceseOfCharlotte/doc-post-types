<?php
/**
 * Taxonomies.
 *
 * @package  RCDOC
 */

add_action( 'init', 'doc_register_taxonomies' );

/**
 * Register taxonomies.
 *
 * @since  0.1.0
 * @access public
 */

function doc_register_taxonomies() {

	// register_taxonomy_for_object_type( 'category', 'finance' );

	register_extended_taxonomy( 'attachment_category', 'attachment',
		array(
			'show_admin_column' => true,
			'sort' => true,
		),

		array(
			'singular' => 'Media Category',
			'plural'   => 'Media Categories',
		)
	);

	register_extended_taxonomy('school_system', 'school', array(
		'meta_box' => 'radio',
		'dashboard_glance' => true,

		'capabilities' => array(
			'manage_terms' => 'manage_options',
			'edit_terms'   => 'manage_options',
			'delete_terms' => 'manage_options',
			'assign_terms' => 'manage_options',
		),
	) );

	register_extended_taxonomy('vicariate', 'parish', array(
		'meta_box' => 'radio',
		'dashboard_glance' => true,

		'capabilities' => array(
			'manage_terms' => 'manage_options',
			'edit_terms'   => 'manage_options',
			'delete_terms' => 'manage_options',
			'assign_terms' => 'manage_options',
		),
	) );

	register_extended_taxonomy('document_category', 'document', array(
		//'meta_box' => 'radio',
		'dashboard_glance' => true,

		// 'capabilities' => array(
		// 	'manage_terms' => 'upload_files',
		// 	'edit_terms'   => 'upload_files',
		// 	'delete_terms' => 'upload_files',
		// 	'assign_terms' => 'upload_files',
		// ),
	),
	array(
		'singular' => 'Document Category',
		'plural'   => 'Document Categories',
		'slug'     => 'document-category',
	) );

	register_extended_taxonomy( 'agency', doc_home_tiles(),
		array(
			'meta_box' => 'radio',
			'dashboard_glance' => true,
		),
		array(
			'singular' => 'Agency',
			'plural'   => 'Agencies',
			'slug'     => 'agencies',
		)
	);

	register_extended_taxonomy( 'statistics_type', 'statistics_report', array(
		'meta_box' => 'radio',
		'dashboard_glance' => true,

		'capabilities' => array(
			'manage_terms' => 'manage_options',
			'edit_terms'   => 'manage_options',
			'delete_terms' => 'manage_options',
			'assign_terms' => 'edit_statistics_reports',
		),
	) );
}
