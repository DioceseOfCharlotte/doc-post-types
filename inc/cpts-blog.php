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
	);

	$school_post = register_extended_post_type( 'school_post',
		array(
			'supports' 			=> $supports,
			'show_in_menu'	 	=> 'edit.php?post_type=schools_office',
			'hierarchical'        => false,
			'capability_type'     => 'school_post',
			'map_meta_cap'        => true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'school_post' ),
		),
		array(
			'slug'     => 'school-posts',
		)
	);
	$school_post->add_taxonomy( 'post_school' );


	register_extended_post_type( 'hr_post',
		array(
			'supports' 			=> $supports,
			'show_in_menu'	 	=> 'edit.php?post_type=human_resources',
			'hierarchical'        => false,
			'capability_type'     => 'hr_post',
			'map_meta_cap'        => true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'hr_post' ),
		),
		array(
			'singular' => 'HR Post',
			'plural'   => 'HR Posts',
			'slug'     => 'hr-posts',
		)
	);

	register_extended_post_type( 'development_post',
		array(
			'supports' 			=> $supports,
			'show_in_menu'	 	=> 'edit.php?post_type=development',
			'hierarchical'        => false,
			'capability_type'     => 'development_post',
			'map_meta_cap'        => true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'development_post' ),
		),
		array(
			'singular' => 'Development Post',
			'plural'   => 'Development Posts',
			'slug'     => 'development-posts',
		)
	);

}
