<?php

add_action( 'pre_get_posts', 'doc_custom_queries', 1 );
add_filter( 'post_mime_types', 'modify_post_mime_types' );
add_action( 'omnisearch_add_providers', 'doc_omnisearch_providers' );
add_filter( 'user_contactmethods', 'doc_user_parish_id' );

// Register User Contact Methods
function doc_user_parish_id( $user_contact_method ) {

	$user_contact_method['doc_user_parish'] = __( 'Parish ID', 'doc' );

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	return $user_contact_method;
}


/**
 * Custom queries.
 *
 * @since  0.1.0
 * @access public
 * @param array $query Main Query.
 */
function doc_custom_queries( $query ) {
	if ( ! $query->is_main_query() || is_admin() ) {
		return; }

	if ( is_tax( 'agency' ) ) {
		$post_type = $query->get( 'post_type' );
		$meta_query = $query->get( 'meta_query' );
		$post_type = doc_home_tiles();
		$meta_query[] = array(
			'key'       => 'doc_alias_checkbox',
			'value'     => 'on',
			'compare'   => 'NOT EXISTS',
		);
		$query->set( 'meta_query', $meta_query );
		$query->set( 'post_type', $post_type );
		$query->set( 'order', 'ASC' );
	  	$query->set( 'orderby', 'title' );

	} elseif ( is_post_type_archive( doc_place_cpts() ) ) {
			$query->set( 'order', 'ASC' );
			$query->set( 'orderby', 'name' );

		if ( is_post_type_archive( 'department' ) ) {
			$query->set( 'post_parent', 0 ); }
	}
}

function modify_post_mime_types( $post_mime_types ) {

	$post_mime_types['application/pdf'] = array(
		__( 'PDFs' ),
		__( 'Manage PDFs' ),
		_n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ),
	);

	return $post_mime_types;
}

/**
 * Post Groups.
 */
function doc_department_cpts() {
	$cpts = array( 'archive_post','bishop', 'deacon', 'development', 'education', 'finance', 'human_resources', 'hispanic_ministry', 'housing', 'info_tech', 'liturgy', 'macs', 'multicultural', 'planning', 'property', 'schools_office', 'tribunal', 'vocation' );
	return $cpts;
}

function doc_place_cpts() {
	$cpts = array(
	   'department',
	   'parish',
	   'school',
	   'cpt_archive',
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

//Jetpack_Omnisearch
function doc_omnisearch_providers() {
	if ( ! class_exists( 'Jetpack_Omnisearch_Posts' ) ) {
		return;
	}

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
		new Jetpack_Omnisearch_Posts( "{$name}" );
	}
}
