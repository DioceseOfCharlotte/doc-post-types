<?php
/**
 * Expose custom metadata to the wp-api.
 */

add_filter( 'rest_api_allowed_post_types', 'doc_jetpack_post_types' );
add_action( 'init', 'doc_register_parish_meta' );
add_action( 'rest_api_init', 'doc_add_to_rest' );


function doc_jetpack_post_types( $allowed_post_types ) {
	$allowed_post_types = doc_posts_plugin()->cpt_names;

	return $allowed_post_types;
}

function doc_parish_rest_fields() {
	$fields = array(
		'doc_email',
		'doc_phone_number',
		'doc_fax',
		'doc_website',
		'doc_mass_schedule',
		'doc_street',
		'doc_city',
		'doc_state',
		'doc_zip',
		'staff_member',
	);
	return $fields;
}

function doc_register_parish_meta() {
	foreach ( doc_parish_rest_fields() as $field_name ) {
		register_meta(
			'parish', $field_name, [
				'show_in_rest' => true,
			]
		);
	}
}

function doc_add_to_rest() {
	foreach ( doc_parish_rest_fields() as $field_name ) {
		register_rest_field(
			'parish', $field_name,
			array(
				'get_callback'    => 'parish_get_field',
				'update_callback' => 'parish_update_field',
				'schema'          => null,
			)
		);
	}
}

function parish_get_field( $data, $field_name ) {
	return get_post_meta( $data['id'], $field_name, true );
}

function parish_update_field( $value, $post, $field_name ) {
	if ( '' === $value ) {
		return;
	}
	$value = esc_html( $value );
	return update_post_meta( $post->ID, $field_name, wp_slash( $value ) );
}
