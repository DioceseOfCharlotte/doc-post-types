<?php
/**
 * Post Types.
 *
 * @package  RCDOC
 */

add_action( 'init', 'doc_register_blog_cpts' );


/**
 * Register post_types.
 *
 * @since  0.1.0
 * @access public
 */
function doc_register_blog_cpts() {

	$supports = array(
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		'post-formats',
		'theme-layouts',
		'archive',
	);

	register_extended_post_type( 'school-posts',
		array(
			'supports' 			=> $supports,
			'show_in_menu'	 	=> 'edit.php?post_type=schools_office',
			'capability_type'     => 'school-posts',
			'map_meta_cap'        => true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'school-posts' ),
		),
		array(
			'singular' => 'School Post',
			'plural'   => 'School Posts',
			'slug'     => 'school-posts',
		)
	);

}
