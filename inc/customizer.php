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
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'google_maps_api',
		array(
			'label'       		=> esc_html__( 'Google Maps JS API', 'doc' ),
			'description' 		=> esc_html__( 'YOUR_API_KEY', 'doc' ),
			'section'     		=> 'meh_api_section',
			'type'        		=> 'text',
		)
	);

	$wp_customize->add_setting(
		'meh_rest_name',
		array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'meh_rest_name',
		array(
			'label'       		=> esc_html__( 'Rest Username', 'doc' ),
			'description' 		=> '',
			'priority'          => 80,
			'section'     		=> 'meh_api_section',
			'type'        		=> 'text',
		)
	);

	$wp_customize->add_setting(
		'meh_rest_pass',
		array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',

		)
	);

	$wp_customize->add_control(
		'meh_rest_pass',
		array(
			'label'         	=> esc_html__( 'Rest Password', 'doc' ),
			'description' 		=> '',
			'priority'          => 90,
			'section'     		=> 'meh_api_section',
			'type'        		=> 'password',
		)
	);
}
