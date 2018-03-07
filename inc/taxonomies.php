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

	register_extended_taxonomy(
		'document_department', 'document', array(
			'meta_box'     => 'radio',

			'capabilities' => array(
				'manage_terms' => 'manage_options',
				'edit_terms'   => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' => 'upload_files',
			),
		),
		array(
			'singular' => 'Department',
			'plural'   => 'Departments',
			'slug'     => 'document-department',
		)
	);

	register_extended_taxonomy(
		'document_category', 'document', array(
			//'meta_box' => 'radio',

			'capabilities' => array(
				'manage_terms' => 'manage_options',
				'edit_terms'   => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' => 'upload_files',
			),
		),
		array(
			'singular' => 'Category',
			'plural'   => 'Categories',
			'slug'     => 'document-category',
		)
	);

	register_extended_taxonomy(
		'document_tag', 'document', array(
			'hierarchical' => false,
			'capabilities' => array(
				'manage_terms' => 'manage_options',
				'edit_terms'   => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' => 'upload_files',
			),
		),
		array(
			'singular' => 'Tag',
			'plural'   => 'Tags',
			'slug'     => 'document-tag',
		)
	);

	// register_taxonomy_for_object_type( 'category', 'finance' );

	register_extended_taxonomy(
		'school_system', 'school', array(
			'meta_box'     => 'radio',

			'capabilities' => array(
				'manage_terms' => 'manage_options',
				'edit_terms'   => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' => 'manage_options',
			),
		)
	);

	register_extended_taxonomy(
		'vicariate', 'parish', array(
			'meta_box'     => 'radio',

			'capabilities' => array(
				'manage_terms' => 'manage_options',
				'edit_terms'   => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' => 'manage_options',
			),
		)
	);

	register_extended_taxonomy(
		'parish_accessibility', 'parish', array(
			'meta_box'     => 'radio',

			'capabilities' => array(
				'manage_terms' => 'manage_options',
				'edit_terms'   => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' => 'manage_options',
			),
		),
		array(
			'singular' => 'Parish Accessibility',
			'plural'   => 'Parish Accessibility',
			'slug'     => 'parish-accessibility',
		)
	);

	register_extended_taxonomy(
		'agency', doc_home_tiles(),
		array(
			'meta_box' => 'radio',
		),
		array(
			'singular' => 'Agency',
			'plural'   => 'Agencies',
			'slug'     => 'agencies',
		)
	);

	register_extended_taxonomy(
		'statistics_type', 'statistics_report', array(
			'meta_box'     => 'radio',

			'capabilities' => array(
				'manage_terms' => 'manage_options',
				'edit_terms'   => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' => 'edit_statistics_reports',
			),
		)
	);
}

class Vicariate_VF_Meta {

	public function __construct() {

		if ( is_admin() ) {

			add_action( 'vicariate_add_form_fields', array( $this, 'create_screen_fields' ), 10, 1 );
			add_action( 'vicariate_edit_form_fields', array( $this, 'edit_screen_fields' ), 10, 2 );

			add_action( 'created_vicariate', array( $this, 'save_data' ), 10, 1 );
			add_action( 'edited_vicariate', array( $this, 'save_data' ), 10, 1 );

		}

	}

	public function create_screen_fields( $taxonomy ) {

		// Set default values.
		$doc_vicar_forane = '';

		// Form fields.
		echo '<div class="form-field term-doc_vicar_forane-wrap">';
		echo '	<label for="doc_vicar_forane">' . __( 'Vicar Forane', 'doc' ) . '</label>';
		echo '	<input type="text" id="doc_vicar_forane" name="doc_vicar_forane" value="' . esc_attr( $doc_vicar_forane ) . '">';
		echo '</div>';

	}

	public function edit_screen_fields( $term, $taxonomy ) {

		// Retrieve an existing value from the database.
		$doc_vicar_forane = get_term_meta( $term->term_id, 'doc_vicar_forane', true );

		// Form fields.
		echo '<tr class="form-field term-doc_vicar_forane-wrap">';
		echo '<th scope="row">';
		echo '	<label for="doc_vicar_forane">' . __( 'Vicar Forane', 'doc' ) . '</label>';
		echo '</th>';
		echo '<td>';
		echo '	<input type="text" id="doc_vicar_forane" name="doc_vicar_forane" value="' . esc_attr( $doc_vicar_forane ) . '">';
		echo '</td>';
		echo '</tr>';

	}

	public function save_data( $term_id ) {

		// Sanitize user input.
		$new_doc_vicar_forane = isset( $_POST['doc_vicar_forane'] ) ? sanitize_text_field( $_POST['doc_vicar_forane'] ) : '';

		// Update the meta field in the database.
		update_term_meta( $term_id, 'doc_vicar_forane', $new_doc_vicar_forane );

	}

}

new Vicariate_VF_Meta;
