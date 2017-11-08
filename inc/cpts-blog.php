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
		//'author',
		'thumbnail',
		'excerpt',
		'post-formats',
		'theme-layouts',
		'archive',
	);

	register_extended_post_type(
		'school_post',
		array(
			'supports'        => $supports,
			//'show_in_menu'	 	=> 'edit.php?post_type=schools_office',
			'hierarchical'    => false,
			'menu_icon'       => 'dashicons-pressthis',
			'capability_type' => 'school_post',
			'map_meta_cap'    => true,
			'capabilities'    => doc_posts_plugin()->doc_get_capabilities( 'school_post' ),
			'labels'          => array(
				'all_items' => __( 'School Posts', 'doc' ),
			),
		),
		array(
			'slug' => 'school-posts',
		)
	);

	register_extended_taxonomy(
		'post_school', 'school_post',
		array(
			'meta_box'     => 'radio',
			'capabilities' => array(
				'manage_terms' => 'manage_options',
				'edit_terms'   => 'manage_options',
				'delete_terms' => 'manage_options',
				'assign_terms' => 'edit_school_posts',
			),
		),
		array(
			'singular' => 'School',
			'plural'   => 'Schools',
		)
	);

		register_extended_post_type(
			'hr_post',
			array(
				'supports'        => $supports,
				//'show_in_menu'	 	=> 'edit.php?post_type=human_resources',
				'menu_icon'       => 'dashicons-pressthis',
				'hierarchical'    => false,
				'capability_type' => 'hr_post',
				'map_meta_cap'    => true,
				'capabilities'    => doc_posts_plugin()->doc_get_capabilities( 'hr_post' ),
				'labels'          => array(
					'all_items' => __( 'HR Posts', 'doc' ),
				),
			),
			array(
				'slug' => 'hr-posts',
			)
		);

		register_extended_post_type(
			'development_post',
			array(
				'supports'        => $supports,
				//'show_in_menu'	 	=> 'edit.php?post_type=development',
				'menu_icon'       => 'dashicons-pressthis',
				'hierarchical'    => false,
				'capability_type' => 'development_post',
				'map_meta_cap'    => true,
				'capabilities'    => doc_posts_plugin()->doc_get_capabilities( 'development_post' ),
				'labels'          => array(
					'all_items' => __( 'Development Posts', 'doc' ),
				),
			),
			array(
				'slug' => 'development-posts',
			)
		);

}
