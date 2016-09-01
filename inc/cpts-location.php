<?php
/**
 * Post Types.
 *
 * @package  RCDOC
 */

add_action( 'init', 'doc_register_location_cpts' );

/**
 * Register post_types.
 *
 * @since  0.1.0
 * @access public
 */
function doc_register_location_cpts() {

	$supports = array(
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		'page-attributes',
		'theme-layouts',
		'archive',
	);

	register_extended_post_type( 'department',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Logo',
					'featured_image' => 'abe-icon',
				),
				'agency' => array(
					'taxonomy' => 'agency',
				),
			),
			'menu_icon'           => 'dashicons-groups',
			'supports'            => $supports,
			'capability_type'     => 'department',
			'map_meta_cap'        => true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'department' ),
		)
	);

	register_extended_post_type( 'parish',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'menu_icon'           => 'dashicons-book-alt',
			'supports' 			        => $supports,
			'capability_type'     => 'parish',
			'map_meta_cap'        => true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'parish' ),
		),
		array(
	        'singular' => 'Parish',
	        'plural'   => 'Parishes',
	        'slug'     => 'parishes',
	    )
	);

	register_extended_post_type( 'school',
		array(
		'admin_cols' => array(
				'featured_image' => array(
				    'title'          => 'Logo',
				    'featured_image' => 'abe-icon',
				),
				'school_system' => array(
				    'taxonomy' => 'school_system',
				),
			),
			'menu_icon'           => 'dashicons-welcome-learn-more',
			'supports'            => $supports,
			'capability_type'     => 'school',
			'map_meta_cap'        => true,

			/* Capabilities. */
			'capabilities' => doc_posts_plugin()->doc_get_capabilities( 'school' ),
	    )
	);

}
