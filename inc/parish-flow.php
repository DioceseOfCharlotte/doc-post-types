<?php

add_action( 'gform_admin_pre_render', 'add_merge_tags' );
add_filter( 'gravityflow_webhook_args', 'doc_filter_gravityflow_webhook_args', 10, 3 );
add_action( 'widgets_init', 'doc_cpt_widgets', 5 );

$user_id = get_current_user_id();

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

	$username        = get_theme_mod( 'meh_rest_name', '' );
	$password        = get_theme_mod( 'meh_rest_pass', '' );
	$args['headers'] = array(
		'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),
	);

	return $args;

}

// User Parish ID.
function doc_user_place_post_field( $user_contact_method ) {

	if ( ! current_user_can( 'edit_users' ) ) {
		return;
	}

	$user_contact_method['doc_department'] = __( 'Department Post', 'doc' );
	$user_contact_method['doc_school']     = __( 'School Post', 'doc' );
	$user_contact_method['doc_parish']     = __( 'Parish Post', 'doc' );
	$user_contact_method['doc_mission']    = __( 'Mission Post', 'doc' );

	return $user_contact_method;

}
add_filter( 'user_contactmethods', 'doc_user_place_post_field' );


// User Parish ID.
function doc_user_parish_id_field( $user_contact_method ) {

	if ( ! current_user_can( 'edit_users' ) ) {
		return;
	}

	$user_contact_method['doc_user_parish_id'] = __( 'Parish ID', 'rcdoc' );

	return $user_contact_method;

}
add_filter( 'user_contactmethods', 'doc_user_parish_id_field' );

// Get the parish assigned to the user.
function get_users_parish_post() {
	$user_id           = get_current_user_id();
	$users_parish_post = get_user_meta( $user_id, 'doc_parish', true );

	if ( ! empty( $users_parish_post ) ) {
		return $users_parish_post;
	}
}

// Get the mission assigned to the user.
function get_users_mission_post() {
	$user_id           = get_current_user_id();
	$users_mission_post = get_user_meta( $user_id, 'doc_mission', true );

	if ( ! empty( $users_mission_post ) ) {
		return $users_mission_post;
	}
}

// Get the school assigned to the user.
function get_users_school_post() {
	$user_id           = get_current_user_id();
	$users_school_post = get_user_meta( $user_id, 'doc_school', true );

	return $users_school_post;
}

// Get the department assigned to the user.
function get_users_department_post() {
	$user_id               = get_current_user_id();
	$users_department_post = get_user_meta( $user_id, 'doc_department', true );

	return $users_department_post;
}

// Convert a user's Post ID to the Parish ID.
function get_users_parish_id( $user_id ) {
	$user_id           = empty( $user_id ) ? get_current_user_id() : $user_id;
	$users_parish_post = get_user_meta( $user_id, 'doc_parish', true );
	$users_parish_id   = get_post_meta( $users_parish_post, 'doc_parish_id', true );

	if ( ! empty( $users_parish_id ) ) {
		return $users_parish_id;
	}
}

// Get the Parish ID from a Post ID.
function get_parish_id( $post_id ) {
	$post_id   = empty( $post_id ) ? get_the_ID() : $post_id;
	$parish_id = get_post_meta( $post_id, 'doc_parish_id', true );

	if ( ! empty( $parish_id ) ) {
		return $parish_id;
	}
}

// Get the Post ID from a Parish ID.
function get_parish_post( $parish_id ) {
	$args        = array(
		'post_type'  => 'parish',
		'meta_key'   => 'doc_parish_id',
		'meta_value' => $parish_id,
	);
	$parish_post = get_posts( $args );

	return $parish_post[0]->ID;
}

// Can the user submit an update for a Parish.
function user_can_update_parish( $user_id, $post_id = '' ) {

	if ( current_user_can( 'edit_parishs' ) ) {
		return true;
	}

	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$users_parish_post  = absint( get_user_meta( $user_id, 'doc_parish', true ) );
	$users_mission_post = absint( get_user_meta( $user_id, 'doc_mission', true ) );

	$can_update = false;

	if ( $users_parish_post === $post_id ) {
		$can_update = true;
	}

	if ( $users_mission_post === $post_id ) {
		$can_update = true;
	}

	if ( ! current_user_can( 'parish_update_form' ) ) {
		$can_update = false;
	}

	return $can_update;
}

// Add Shortcode
function can_update_parish_shortcode( $atts, $content = null ) {
	$user_id = get_current_user_id();
	$post_id = get_the_ID();

	return ! user_can_update_parish( $user_id, $post_id ) || is_null( $content ) ? '' : do_shortcode( $content );

}
add_shortcode( 'can_update_parish', 'can_update_parish_shortcode' );

// Add Shortcode
function edit_parish_link_shortcode( $atts, $content = null ) {
	$user_id = get_current_user_id();
	$post_id = get_the_ID();

	$atts = shortcode_atts(
		array(
			'icon' => 'edit',
			'page' => 'parish-info',
		),
		$atts,
		'edit_parish_link'
	);

	$icon = strtolower( $atts['icon'] );
	$page = strtolower( $atts['page'] );

	$link  = '';
	$link .= '<a class="btn" href="' . esc_url( site_url( '/' ) ) . $page . '/?doc_pid=' . get_the_ID() . '" target="_blank" rel="noopener">';
	$link .= abe_get_svg( $icon, 'sm' ) . ' ' . $content;
	$link .= '</a>';

	return ! user_can_update_parish( $user_id, $post_id ) || is_null( $content ) ? '' : $link;

}
add_shortcode( 'edit_parish_link', 'edit_parish_link_shortcode' );

/**
 * Registers sidebars.
 *
 * @access public
 * @return void
 */
function doc_cpt_widgets() {
	register_sidebar(
		array(
			'id'            => 'parish',
			'name'          => esc_html__( 'Parish', 'abraham' ),
			'description'   => esc_html__( 'Add widgets to each Parish page.', 'doc' ),
			'before_widget' => '<section id="%1$s" class="widget u-mb u-bg-frost-1 u-br %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title u-h3 u-text-display u-pt0 u-opacity">',
			'after_title'   => '</h2>',
		)
	);
}
