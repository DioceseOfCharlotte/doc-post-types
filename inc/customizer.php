<?php
/**
 * Theme Customizer.
 *
 * @package doc
 */

add_action( 'customize_register', 'doc_customize_register' );

/**
 * Customizer Settings
 *
 * @param  array $wp_customize Add controls and settings.
 */
function doc_customize_register( $wp_customize ) {

	// Add our API Customization section section.
	$wp_customize->add_section(
		'meh_api_section',
		array(
			'title'    => esc_html__( 'Owner Info and APIs', 'doc' ),
			'priority' => 90,
		)
	);

	// Add maps api text field.
	$wp_customize->add_setting(
		'google_maps_api',
		array(
			'default' => '',
		)
	);
	$wp_customize->add_control(
		'google_maps_api',
		array(
			'label'       		=> esc_html__( 'Google Maps JS API', 'doc' ),
			'description' 		=> esc_html__( 'YOUR_API_KEY', 'doc' ),
			'section'     		=> 'meh_api_section',
			'type'        		=> 'text',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
		)
	);
}
