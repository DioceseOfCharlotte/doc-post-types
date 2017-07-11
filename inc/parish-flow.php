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

	$username = 'admin';
	$password = 'password';
	$args['headers'] = array(
		'Authorization' => 'Basic ' . base64_encode( $username . ':' . $password ),
	);

	return $args;
}
