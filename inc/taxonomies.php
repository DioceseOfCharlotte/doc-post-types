<?php
/**
 * Taxonomies.
 *
 * @package  RCDOC
 */

add_action( 'init', 'doc_register_taxonomies' );

/**
 * Post Groups.
 */
function doc_department_cpts() {
   $cpts = array( 'archive_post','bishop', 'deacon', 'development', 'education', 'finance', 'human_resources', 'hispanic_ministry', 'housing', 'info_tech', 'liturgy', 'macs', 'multicultural', 'planning', 'property', 'tribunal', 'vocation' );
   return $cpts;
}

function doc_place_cpts() {
   $cpts = array(
	   'department',
	   'parish',
	   'school',
   );
   return $cpts;
}

function doc_home_tiles() {
   $cpts = array(
	   'department',
	   'cpt_archive',
   );
   return array_merge( $cpts, doc_department_cpts() );
}

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
