<?php

add_action( 'pre_get_posts', 'doc_custom_queries', 1 );
add_filter( 'hybrid_content_template_hierarchy', 'article_format_template', 20 );

/**
 * Post Groups.
 */
function doc_department_cpts() {
   $cpts = array( 'archive_post','bishop', 'deacon', 'development', 'education', 'finance', 'human_resources', 'hispanic_ministry', 'housing', 'info_tech', 'liturgy', 'macs', 'multicultural', 'planning', 'property', 'tribunal', 'vocation' );
   return $cpts;
}

/**
 * Add templates to hybrid_get_content_template()
 */
function article_format_template( $templates ) {
	$terms = get_the_terms( get_the_ID(), 'article_format' );

	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$article_format[] = $term->name;
		}

		$templates = array_merge(
			array(
				"content/single-document.php",
			), $templates
		);
	}

	return $templates;
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
