<?php
/**
 * Post Types.
 *
 * @package  RCDOC
 */

add_action( 'init', 'doc_register_post_types' );

/**
 * Register post_types.
 *
 * @since  0.1.0
 * @access public
 */
function doc_register_post_types() {

	$doc_page_supports = array(
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		'page-attributes',
		'theme-layouts',
		'archive',
	);

	$doc_post_supports = array(
		'title',
		'editor',
		'author',
		'thumbnail',
		'arch-home',
		'excerpt',
		'post-formats',
		'page-attributes',
		'theme-layouts',
		'archive',
	);

	/**
	 * Returns the capabilities for the project post type.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	function doc_get_capabilities( $name ) {

		$caps = array(

			// meta caps (don't assign these to roles)
			'edit_post'              => "edit_{$name}",
			'read_post'              => "read_{$name}",
			'delete_post'            => "delete_{$name}",

			// primitive/meta caps
			'create_posts'           => "create_{$name}s",

			// primitive caps used outside of map_meta_cap()
			'edit_posts'             => "edit_{$name}s",
			'edit_others_posts'      => "edit_others_{$name}s",
			'publish_posts'          => "publish_{$name}s",
			'read_private_posts'     => "read_private_{$name}s",

			// primitive caps used inside of map_meta_cap()
			'read'                   => 'read',
			'delete_posts'           => "delete_{$name}s",
			'delete_private_posts'   => "delete_private_{$name}s",
			'delete_published_posts' => "delete_published_{$name}s",
			'delete_others_posts'    => "delete_others_{$name}s",
			'edit_private_posts'     => "edit_private_{$name}s",
			'edit_published_posts'   => "edit_published_{$name}s",
		);

		return apply_filters( 'doc_get_capabilities', $caps );
	}

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
			'supports'            => $doc_page_supports,
			'capability_type'     => 'school',
			'map_meta_cap'        => true,

			/* Capabilities. */
			'capabilities' => doc_get_capabilities( 'school' ),
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
			'supports' 			        => $doc_page_supports,
			'capability_type'     => 'parish',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'parish' ),
		),
		array(
	        'singular' => 'Parish',
	        'plural'   => 'Parishes',
	        'slug'     => 'parishes',
	    )
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
			'supports'            => $doc_page_supports,
			'capability_type'     => 'department',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'department' ),
		)
	);

	register_extended_post_type( 'archive_post',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'menu_icon'           => 'dashicons-archive',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'archive_post',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'archive_post' ),
		)
	);

	register_extended_post_type( 'bishop',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-shield',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'bishop',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'bishop' ),
		),
		array(
	        'singular' => 'Bishop',
	        'plural'   => 'Bishop',
	        'slug'     => 'bishop',
	    )
	);

	register_extended_post_type( 'schools_office',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-flag',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'schools_office',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'schools_office' ),
		),
		array(
			'singular' => 'Schools Office Post',
			'plural'   => 'Schools Office Posts',
			'slug'     => 'schools-office',
		)
	);

	register_extended_post_type( 'deacon',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-shield-alt',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'deacon',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'deacon' ),
		),
		array(
			'singular' => 'Deacon',
			'plural'   => 'Deacon',
			'slug'     => 'deacon',
		)
	);

	register_extended_post_type( 'development',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-chart-bar',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'development',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'development' ),
		),
		array(
			'singular' => 'Development post',
			'plural'   => 'Development',
			'slug'     => 'development',
		)
	);

	register_extended_post_type( 'education',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-image-filter',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'education',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'education' ),
		),
		array(
			'singular' => 'Education post',
			'plural'   => 'Education Vicariate',
			'slug'     => 'education-vicariate',
		)
	);

	register_extended_post_type( 'finance',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-portfolio',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'finance',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'finance' ),
		),
		array(
			'singular' => 'Finance post',
			'plural'   => 'Finance',
			'slug'     => 'finance',
		)
	);

	register_extended_post_type( 'hispanic_ministry',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-share-alt',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'hispanic_ministry',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'hispanic_ministry' ),
		),
		array(
			'singular' => 'Hispanic Ministry post',
			'plural'   => 'Hispanic Ministry',
			'slug'     => 'hispanic-ministry',
		)
	);

	register_extended_post_type( 'housing',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-admin-multisite',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'housing',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'housing' ),
		),
		array(
			'singular' => 'Housing post',
			'plural'   => 'Housing',
			'slug'     => 'housing',
		)
	);

	register_extended_post_type( 'human_resources',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-universal-access-alt',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'human_resources',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'human_resources' ),
		),
		array(
			'singular' => 'HR post',
			'plural'   => 'Human Resources',
			'slug'     => 'human-resources',
		)
	);

	register_extended_post_type( 'info_tech',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-desktop',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'info_tech',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'info_tech' ),
		),
		array(
			'singular' => 'IT post',
			'plural'   => 'IT',
			'slug'     => 'information-tech',
		)
	);

	register_extended_post_type( 'liturgy',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-book',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'liturgy',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'liturgy' ),
		),
		array(
			'singular' => 'Liturgy & Worship post',
			'plural'   => 'Liturgy & Worship',
			'slug'     => 'liturgy-worship',
		)
	);

	register_extended_post_type( 'macs',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-awards',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'macs',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'macs' ),
		),
		array(
			'singular' => 'MACS post',
			'plural'   => 'MACS',
			'slug'     => 'macs',
		)
	);

	register_extended_post_type( 'multicultural',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-translation',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'multicultural',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'multicultural' ),
		),
		array(
			'singular' => 'Multicultural post',
			'plural'   => 'Multicultural',
			'slug'     => 'multicultural',
		)
	);

	register_extended_post_type( 'planning',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-networking',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'planning',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'planning' ),
		),
		array(
			'singular' => 'Planning post',
			'plural'   => 'Planning',
			'slug'     => 'planning',
		)
	);

	register_extended_post_type( 'property',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-building',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'property',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'property' ),
		),
		array(
			'singular' => 'Properties post',
			'plural'   => 'Properties',
			'slug'     => 'properties',
		)
	);

	register_extended_post_type( 'tribunal',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-analytics',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'tribunal',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'tribunal' ),
		),
		array(
			'singular' => 'Tribunal post',
			'plural'   => 'Tribunal',
			'slug'     => 'tribunal',
		)
	);

	register_extended_post_type( 'vocation',
		array(
			'admin_cols' => array(
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-businessman',
			'supports'            => $doc_post_supports,
			'capability_type'     => 'vocation',
			'map_meta_cap'        => true,
			'capabilities'        => doc_get_capabilities( 'vocation' ),
		),
		array(
			'singular' => 'Vocations post',
			'plural'   => 'Vocations',
			'slug'     => 'vocations',
		)
	);

	register_extended_post_type( 'statistics_report',
		array(
			'admin_cols' => array(
				'statistics_type' => array(
					'taxonomy' => 'statistics_type',
				),
			),
			'enter_title_here'     => 'Enter report title here',
			'menu_icon'            => 'dashicons-chart-pie',
			'supports'             => array( 'title', 'author', 'archive' ),
			'capability_type'      => 'statistics_report',
			'map_meta_cap'         => true,
			'capabilities'         => doc_get_capabilities( 'statistics_report' ),
		)
	);

}
