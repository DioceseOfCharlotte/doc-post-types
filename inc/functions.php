<?php

add_filter( 'hybrid_content_template', 'doc_content_template' );
add_action( 'pre_get_posts', 'doc_custom_queries', 1 );
add_filter( 'post_mime_types', 'modify_post_mime_types' );
// add_filter( 'user_contactmethods', 'doc_user_parish_id' );

/**
 * Add templates to hybrid_get_content_template()
 */
function doc_content_template( $template ) {
	if ( is_admin() ) {
		return $template; }

	// If the post type isn't a document, bail.
	if ( get_post_type( get_the_ID() ) === 'document' && is_single( get_the_ID() ) ) {

		$template     = trailingslashit( doc_posts_plugin()->dir_path ) . 'content/single-document.php';
		$has_template = locate_template( array( 'content/single-document.php' ) );

		if ( $has_template ) {
			$template = $has_template;
		}
	}

	return $template;
}


// Register User Contact Methods
function doc_user_parish_id( $user_contact_method ) {

	$user_contact_method['doc_user_parish'] = __( 'Parish ID', 'doc' );

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	return $user_contact_method;
}


function doc_title_version( $title, $id ) {

	$doc_version = get_post_meta( $id, 'document-version', true );

	if ( get_post_type( $id ) === 'document' && $doc_version ) {

		if ( ! is_admin() ) {
			return $title . ' <em class="u-f-minus u-text-read u-normal u-opacity">' . $doc_version . '</em>';
		} else {
			return $title . ' -' . $doc_version;
		}
	}

	return $title;
}
add_filter( 'the_title', 'doc_title_version', 10, 2 );

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

	if ( is_post_type_archive( 'document' ) ) {
		$query->set( 'order', 'ASC' );
		$query->set( 'orderby', 'title' );
	}

	if ( is_tax( 'agency' ) ) {
		$post_type    = $query->get( 'post_type' );
		$meta_query   = $query->get( 'meta_query' );
		$post_type    = doc_home_tiles();
		$meta_query[] = array(
			'key'     => 'doc_alias_checkbox',
			'value'   => 'on',
			'compare' => 'NOT EXISTS',
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
	$cpts = array( 'archive_post', 'bishop', 'deacon', 'development', 'education', 'finance', 'human_resources', 'hispanic_ministry', 'housing', 'info_tech', 'liturgy', 'macs', 'multicultural', 'planning', 'property', 'schools_office', 'tribunal', 'vocation' );
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

function doc_mime_icon( $icon, $mime, $post_id ) {
	$mime_dir = doc_posts_plugin()->img_uri . 'mimetypes/';

	if ( 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' == $mime || 'application/vnd.ms-excel' == $mime ) {
		$icon = $mime_dir . 'spreadsheet.svg'; }

	if ( 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' == $mime || 'application/msword' == $mime ) {
		$icon = $mime_dir . 'doc.svg'; }

	if ( 'application/pdf' == $mime ) {
		$icon = $mime_dir . 'pdf.svg'; }

		return $icon;
}
add_filter( 'wp_mime_type_icon', 'doc_mime_icon', 10, 3 );


function doc_is_file( $type ) {
	$attachment_id = get_post_meta( get_the_ID(), 'dpt_document_id', true );
	$file          = get_attached_file( $attachment_id );
	$filetype      = wp_check_filetype( $file );

	if ( $type === 'pdf' ) {
		return $filetype['ext'] == 'pdf';
	}

	if ( $type === 'sheet' ) {
		return in_array( $filetype['ext'], array( 'xls', 'xlsx' ) );
	}

	if ( $type === 'doc' ) {
		return in_array( $filetype['ext'], array( 'doc', 'docx' ) );
	}
}

// Add Shortcode
function vicariates_shortcode() {

	$vicariates = wp_list_categories( array(
		'taxonomy' => 'vicariate',
		'title_li' => ' ',
	) );

	return $vicariates;

}
add_shortcode( 'vicariate-list', 'vicariates_shortcode' );
