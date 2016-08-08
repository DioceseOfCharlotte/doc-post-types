<?php

add_action( 'pre_get_posts', 'doc_custom_queries', 1 );

/**
 * Post Groups.
 */
function doc_department_cpts() {
   $cpts = array( 'archive_post','bishop', 'deacon', 'development', 'education', 'finance', 'human_resources', 'hispanic_ministry', 'housing', 'info_tech', 'liturgy', 'macs', 'multicultural', 'planning', 'property', 'tribunal', 'vocation' );
   return $cpts;
}

add_action( 'post_edit_form_tag' , 'post_edit_form_tag' );

function post_edit_form_tag( ) {

	global $post;

	//  if invalid $post object, return
	if(!$post)
		return;

	//  get the current post type
	$post_type = get_post_type($post->ID);

	//  if post type is not 'post', return
	if('document' != $post_type)
		return;

    echo ' enctype="multipart/form-data"';
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
 * Custom queries.
 *
 * @since  0.1.0
 * @access public
 * @param array $query Main Query.
 */
function doc_custom_queries( $query ) {
	if ( ! $query->is_main_query() || is_admin() )
		return;

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

			if ( is_post_type_archive( 'department' ) )
				$query->set( 'post_parent', 0 );
	}
}
