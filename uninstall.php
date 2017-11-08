<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package    DOC Post Types
 */

// Make sure we're actually uninstalling the plugin.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/* Remove capabilities removeed by the plugin. */

// Get the administrator role.
$role = get_role( 'administrator' );

// If the administrator role exists, remove removeed capabilities for the plugin.
if ( ! is_null( $role ) ) {

	foreach ( doc_posts_plugin()->cpt_names as $name ) {

		// Post type caps.
		$role->remove_cap( "create_{$name}s" );
		$role->remove_cap( "edit_{$name}s" );
		$role->remove_cap( "edit_others_{$name}s" );
		$role->remove_cap( "publish_{$name}s" );
		$role->remove_cap( "read_private_{$name}s" );
		$role->remove_cap( "delete_{$name}s" );
		$role->remove_cap( "delete_private_{$name}s" );
		$role->remove_cap( "delete_published_{$name}s" );
		$role->remove_cap( "delete_others_{$name}s" );
		$role->remove_cap( "edit_private_{$name}s" );
		$role->remove_cap( "edit_published_{$name}s" );
		$role->remove_cap( 'create_doc_documents' );
		$role->remove_cap( 'edit_doc_documents' );
		$role->remove_cap( 'manage_doc_documents' );

		remove_role(
			$name, "{$name} Administrator",
			array(
				'read'                      => true,
				'create_doc_documents'      => true, // documents
				'edit_doc_documents'        => true, // documents
				'manage_doc_documents'      => true, // documents
				'restrict_content'          => true, // members
				'upload_files'              => true,
				"create_{$name}s"           => true,
				"edit_{$name}s"             => true,
				"edit_others_{$name}s"      => true,
				"publish_{$name}s"          => true,
				"read_private_{$name}s"     => true,
				"delete_{$name}s"           => true,
				"delete_private_{$name}s"   => true,
				"delete_published_{$name}s" => true,
				"delete_others_{$name}s"    => true,
				"edit_private_{$name}s"     => true,
				"edit_published_{$name}s"   => true,
			)
		);
	}
}
