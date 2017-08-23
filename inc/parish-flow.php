<?php

add_action( 'gform_admin_pre_render', 'add_merge_tags' );
add_filter( 'gravityflow_webhook_args', 'doc_filter_gravityflow_webhook_args', 10, 3 );


function add_merge_tags( $form ) {
	?>
	<script type="text/javascript">
	gform.addFilter('gform_merge_tags', 'add_merge_tags');
	function add_merge_tags(mergeTags, elementId, hideAllFields, excludeFieldTypes, isPrepop, option){
		mergeTags["custom"].tags.push({ tag: '{post_meta:id=get(doc_pid)&meta_key=CUSTOM-FIELD}', label: 'Parish Meta' });

		return mergeTags;
	}
	</script>
	<?php
	// return the form object from the php hook
	return $form;
}

// Allow the webhook to be modified before it's sent.
function doc_filter_gravityflow_webhook_args( $args, $entry, $current_step ) {

	$username = get_theme_mod( 'meh_rest_name', '' );
	$password = get_theme_mod( 'meh_rest_pass', '' );
	$args['headers'] = array(
		'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),
	);

	return $args;

}

// User Parish ID.
function doc_user_parish_post_field( $user_contact_method ) {

	if ( ! current_user_can( 'edit_users' ) ) {
		return;
	}

	$user_contact_method['doc_department'] = __( 'Department Post', 'doc' );
	$user_contact_method['doc_school'] = __( 'School Post', 'doc' );
	$user_contact_method['doc_parish'] = __( 'Parish Post', 'doc' );

	return $user_contact_method;

}
add_filter( 'user_contactmethods', 'doc_user_parish_post_field' );


// User Parish ID.
function doc_user_parish_id_field( $user_contact_method ) {

	if ( ! current_user_can( 'edit_users' ) ) {
		return;
	}

	$user_contact_method['doc_user_parish_id'] = __( 'Parish ID', 'rcdoc' );

	return $user_contact_method;

}
add_filter( 'user_contactmethods', 'doc_user_parish_id_field' );

function get_users_parish_post( $user_id = 0 ) {
	$user_id = empty( $user_id ) ? get_current_user_id() : $user_id;
	$users_parish_post = get_user_meta( $user_id, 'doc_parish', true );

	return $users_parish_post;
}

function get_users_school_post( $user_id = 0 ) {
	$user_id = empty( $user_id ) ? get_current_user_id() : $user_id;
	$users_school_post = get_user_meta( $user_id, 'doc_school', true );

	return $users_school_post;
}

function get_users_department_post( $user_id = 0 ) {
	$user_id = empty( $user_id ) ? get_current_user_id() : $user_id;
	$users_department_post = get_user_meta( $user_id, 'doc_department', true );

	return $users_department_post;
}

function get_users_parish_id() {
	$user_id = get_current_user_id();
	$users_parish_post = get_user_meta( $user_id, 'doc_parish', true );
	$users_parish_id = get_post_meta( $users_parish_post, 'doc_parish_id', true );

	return $users_parish_id;
}

function get_parish_id( $post_id = 0 ) {
	$post_id   = empty( $post_id ) ? get_the_ID() : $post_id;
	$parish_id = get_post_meta( $post_id, 'doc_parish_id', true );

	return $parish_id;
}

function get_parish_post( $parish_id ) {
	$args = array(
		'post_type'      => 'parish',
		'meta_key'         => 'doc_parish_id',
		'meta_value'       => $parish_id,
	);
	$parish_post = get_posts( $args );

	return $parish_post[0]->ID;
}

function user_can_update_parish() {

	if ( current_user_can( 'edit_parishs' ) ) {
		return true;
	}

	if ( get_users_parish_id() !== get_parish_id() ) {
		return false;
	}

	return current_user_can( 'parish_update_form' );
}

function meh_shortcode_field( $atts ) {
	extract( shortcode_atts(
		array(
			'post_id' => NULL,
		), $atts));

	if ( ! isset( $atts[0] ) )
		return;

	$field = esc_attr( $atts[0] );
	global $post;
	$post_id = ( NULL === $post_id) ? $post->ID : $post_id;
	return get_post_meta( $post_id, $field, true );
}
add_shortcode( 'meh_field', 'meh_shortcode_field' );






add_filter( 'gform_field_value_list_two', 'itsg_prefill_list_two' );

function itsg_prefill_list_two( $value ) {
    $list_array = array(
        array(
            'Value' => 'Option 1',
            'Rating' => 'Good'
        ),
        array(
			'Value' => 'Option 2',
            'Rating' => 'Good'
        ),
        array(
			'Value' => 'Option 3',
            'Rating' => 'Good'
        ),
        array(
			'Value' => 'Option 4',
            'Rating' => 'Good'
        ),
    );
    return $list_array;
}
