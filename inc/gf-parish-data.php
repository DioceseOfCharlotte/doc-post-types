<?php

add_action( 'gform_after_submission_14', 'set_parish_post_sa_meta', 10, 2 );

function set_parish_post_sa_meta( $entry, $form ) {

	//getting post
	$post_id = absint( $entry['89'] );
	$entry_id = $entry['id'];

	//updating post
	update_post_meta( $post_id, 'sa_entry_id', $entry_id );
}
