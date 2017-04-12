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

	$supports = array(
		'title',
		'editor',
		//'author',
		'thumbnail',
		'arch-post',
		'excerpt',
		'post-formats',
		'page-attributes',
		'theme-layouts',
		'archive',
		'jetpack_sitemap_post_types',
	);

	register_extended_post_type( 'document',
		array(

		'enter_title_here'     => 'Enter document title here',
		'menu_icon'            => 'dashicons-media-document',
		'supports'             => array( 'title', 'archive' ),
		'capability_type'     => 'doc_document',
		'map_meta_cap'        => true,
		'show_in_rest'          => true,

		/* Capabilities. */
		'capabilities' => array(
			'edit_post'              => 'edit_doc_document',
			'read_post'              => 'read_doc_document',
			'delete_post'            => 'delete_doc_document',

			// primitive/meta caps
			'create_posts'           => 'create_doc_documents',

			// primitive caps used outside of map_meta_cap()
			'edit_posts'             => 'edit_doc_documents',
			'edit_others_posts'      => 'manage_doc_documents',
			'publish_posts'          => 'manage_doc_documents',
			'read_private_posts'     => 'read',

			// primitive caps used inside of map_meta_cap()
			'read'                   => 'read',
			'delete_posts'           => 'manage_doc_documents',
			'delete_private_posts'   => 'manage_doc_documents',
			'delete_published_posts' => 'manage_doc_documents',
			'delete_others_posts'    => 'manage_doc_documents',
			'edit_private_posts'     => 'edit_doc_documents',
			'edit_published_posts'   => 'edit_doc_documents',
		),

	    # Show all posts on the post type archive:
	    'archive' => array(
	        'nopaging' => true,
	    ),

	    # Add some custom columns to the admin screen:
	    'admin_cols' => array(
			'document-version' => array(
			    'title'    => 'Version',
			    'meta_key' => 'document-version',
			),
			'document_department' => array(
	            'taxonomy' => 'document_department',
	        ),
	        'document_category' => array(
	            'taxonomy' => 'document_category',
	        ),
			'published' => array(
	            'title'       => 'Published',
				'post_field' => 'post_date',
	        ),
	    ),

	    # Add a dropdown filter to the admin screen:
	    'admin_filters' => array(
			'document_department' => array(
	            'taxonomy' => 'document_department',
	        ),
	        'document_category' => array(
	            'taxonomy' => 'document_category',
	        ),
	    ),

	) );

		register_extended_post_type( 'aa_ministries',
			array(
			'admin_cols' => array(
				'block_type' => array(
					'title'       => 'Type',
					'meta_key'    => 'arch_component',
				),
				'featured_image' => array(
					'title'          => 'Image',
					'featured_image' => 'abe-icon',
				),
				'published' => array(
		            'title'       => 'Published',
					'post_field' => 'post_date',
		        ),
			),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-share-alt',
			'supports'            => $supports,
			'capability_type'     => 'aa_ministries',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'aa_ministries' ),
			),
			array(
	        'singular' => 'AA Ministries Post',
	        'plural'   => 'AA Ministries Posts',
	        'slug'     => 'aa-ministries',
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
				'supports'            => $supports,
				'capability_type'     => 'archive_post',
				'map_meta_cap'        => true,
				'show_in_rest'      	=> true,
				'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'archive_post' ),
				)
			);

		register_extended_post_type( 'bishop',
			array(
				'admin_cols' => array(
					'block_type' => array(
						'title'       => 'Type',
						'meta_key'    => 'arch_component',
					),
					'featured_image' => array(
						'title'          => 'Image',
						'featured_image' => 'abe-icon',
					),
					'published' => array(
			            'title'       => 'Published',
						'post_field' => 'post_date',
			        ),
				),
			'admin_filters' => array(
		        'component' => array(
		            'title'    => 'All block types',
		            'meta_key' => 'arch_component',
		        ),
			),
			'menu_icon'           => 'dashicons-shield',
			'supports'            => $supports,
			'capability_type'     => 'bishop',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'bishop' ),
			),
			array(
	        'singular' => 'Bishop',
	        'plural'   => 'Bishop',
	        'slug'     => 'bishop',
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
			'supports'            => $supports,
			'capability_type'     => 'deacon',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'deacon' ),
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
			'supports'            => $supports,
			'capability_type'     => 'development',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'development' ),
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
			'supports'            => $supports,
			'capability_type'     => 'education',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'education' ),
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
			'supports'            => $supports,
			'capability_type'     => 'finance',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'finance' ),
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
			'supports'            => $supports,
			'capability_type'     => 'hispanic_ministry',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'hispanic_ministry' ),
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
			'supports'            => $supports,
			'capability_type'     => 'housing',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'housing' ),
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
			'supports'            => $supports,
			'capability_type'     => 'human_resources',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'human_resources' ),
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
			'supports'            => $supports,
			'capability_type'     => 'info_tech',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'info_tech' ),
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
			'supports'            => $supports,
			'capability_type'     => 'liturgy',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'liturgy' ),
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
			'supports'            => $supports,
			'capability_type'     => 'macs',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'macs' ),
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
			'supports'            => $supports,
			'capability_type'     => 'multicultural',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'multicultural' ),
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
			'supports'            => $supports,
			'capability_type'     => 'planning',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'planning' ),
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
			'supports'            => $supports,
			'capability_type'     => 'property',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'property' ),
			),
			array(
			'singular' => 'Properties post',
			'plural'   => 'Properties',
			'slug'     => 'properties',
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
			'supports'            => $supports,
			'capability_type'     => 'schools_office',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'schools_office' ),
			),
			array(
			'singular' => 'Schools Office',
			'plural'   => 'Schools Office',
			'slug'     => 'schools-office',
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
			'supports'            => $supports,
			'capability_type'     => 'tribunal',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'tribunal' ),
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
			'supports'            => $supports,
			'capability_type'     => 'vocation',
			'map_meta_cap'        => true,
			'show_in_rest'      	=> true,
			'capabilities'        => doc_posts_plugin()->doc_get_capabilities( 'vocation' ),
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
			'show_in_rest'      	=> true,
			'capabilities'         => doc_posts_plugin()->doc_get_capabilities( 'statistics_report' ),
			)
		);

}
