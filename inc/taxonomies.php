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

	register_extended_taxonomy('article_format', doc_department_cpts(), array(
		'meta_box' => 'radio',
		'dashboard_glance' => true,

		// 'capabilities' => array(
		// 	'manage_terms' => 'edit_published_developments',
		// 	'edit_terms'   => 'edit_published_developments',
		// 	'delete_terms' => 'edit_published_developments',
		// 	'assign_terms' => 'edit_published_developments',
		// ),
	),
	array(
		'singular' => 'Article Format',
		'plural'   => 'Article Formats',
		'slug'     => 'format-type',
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
