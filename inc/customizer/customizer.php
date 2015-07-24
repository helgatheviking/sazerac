<?php
/**
 * Sazerac Theme Customizer
 *
 * @package sazerac
 * Look, I'm sorry about this messy file, mmkay? Saw Paul Underwood's  repo for extended customizer controls and had a
 * "moment." Okay? Below, just copy the controls you need to use and go bonkers, customize as needed. I started things
 * off by adding a Textarea for GA.
 */


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function sazerac_customize_register( $wp_customize ) 
{
	$wp_customize->get_setting('blogname')->transport         = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
}
add_action('customize_register', 'sazerac_customize_register');

/**
 * Customizer Sanitization Functions
 */
function sazerac_sanitize_text( $input ) 
{
	return wp_kses_post(force_balance_tags($input));
}

function sazerac_sanitize_checkbox( $input ) 
{
	if (1 == $input ) {
		return 1;
	} else {
		return '';
	}
}

function sazerac_sanitize_choices( $input, $setting ) {
	global $wp_customize;
 
	$control = $wp_customize->get_control( $setting->id );
 
	if ( array_key_exists( $input, $control->choices ) ) {
		return $input;
	} else {
		return $setting->default;
	}
}

/**
 * Customizer Some Like it Neat Additions
 */

function sazerac_add_customizer_theme_options($wp_customize) 
{

	// Changing panels for default Customizer settings
	$wp_customize->get_section('static_front_page')->panel = 'site_content';
	$wp_customize->get_section('title_tagline')->panel = 'site_content';
	$wp_customize->get_section('background_image')->panel = 'theme_settings';
	$wp_customize->get_section('background_image')->priority = 10;
	$wp_customize->get_section('colors')->panel = 'theme_settings';
	$wp_customize->get_section('colors')->priority = 20;


	/**
	* Add Panel for General Content Settings
	*/
	$wp_customize->add_panel(
		'site_content', array(
		'priority' => 5,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __('General Site Content Settings', 'sazerac'),
		'description' => __('Various site settings and config.', 'sazerac'),
		) 
	);

	/**
	* Adding Logo to title/tag section
	*/
	$wp_customize->add_setting( 'sazerac_logo' ); // Add setting for logo uploader
 
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sazerac_logo', array(
		'label'    => __( 'Upload Logo (replaces text)', 'sazerac' ),
		'section'  => 'title_tagline',
		'settings' => 'sazerac_logo',
	) ) );

	/**
	* Add Panel for Theme Settings
	*/
	$wp_customize->add_panel(
		'theme_settings', array(
		'priority' => 10,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __('Appearance Settings', 'sazerac'),
		'description' => __('Modify visual aspects of the theme such as color and layout', 'sazerac'),
		) 
	);

	// General Link Colors
	$wp_customize->add_setting(
		'sazerac_add_link_color', array(
		'default'            => '#000000',
		'sanitize_callback'     => 'maybe_hash_hex_color',
		'transport' => 'postMessage'
		) 
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, 'sazerac_add_link_color', array(
			'label'            => __('Body Link Color', 'sazerac'),
			'section'        => 'colors',
			'priority'        => 6,
			)
		) 
	);

	// Theme Layout
	$wp_customize->add_section(
		'layouts_section', array(
			'priority' => 30,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __('Layout', 'sazerac'),
			'description' => __('This theme\'s sidebar can be displayed to the left or right of the main content. Or not at all.', 'sazerac' ),
			'panel' => 'theme_settings',
		) 
	);

	$wp_customize->add_setting(
		'sazerac_layout', array(
		'default'            => 'full-width',
		'sanitize_callback'     => 'sazerac_sanitize_choices'
		) 
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'sazerac_layout',
			array(
				'label'          => __( 'Main layout', 'theme_name' ),
				'section'        => 'layouts_section',
				'type'           => 'radio',
				'choices'        => array(
					'left-sidebar'   => __( 'Left Sidebar', 'sazerac' ),
					'right-sidebar'  => __( 'Right Sidebar', 'sazerac' ),
					'full-width'	=> __( 'Full Width', 'sazerac' )
				)
			)
		)
	);

	/**
		* Adding Footer settings
		*/

	$wp_customize->add_section(
		'sazerac_footer_section_settings', array(
		'priority' => 50,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __('Footer Area', 'sazerac'),
		'description' => '',
		'panel' => 'theme_settings',
		) 
	);

	$wp_customize->add_setting(
		'sazerac_site_info',
		array(
		'sanitize_callback'    => 'sazerac_sanitize_text',
		'default'            => '&copy; All Rights Reserved',
		'transport' 	=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'sazerac_site_info',
		array(
		'section'    => 'sazerac_footer_section_settings',
		'label'        => __('Left Footer', 'sazerac'),
		'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'sazerac_credits',
		array(
		'default'            => sprintf(__( '%sSazerac%s, by Kathy Darling', 'sazerac' ), '<a href="http://www.kathyisawesome.com">' ,'</a>' ),
		'sanitize_callback'    => 'sazerac_sanitize_text',
		'transport' 	=> 'postMessage'
		)
	);
	$wp_customize->add_control(
		'sazerac_credits',
		array(
		'section'    => 'sazerac_footer_section_settings',
		'label'        => __('Right Footer', 'sazerac'),
		'type'        => 'text',
		)
	);

	/**
		* Content Extras Panel Config and Settings
		*/

	// Add Content Extras Panel
	$wp_customize->add_section(
		'content_extras', array(
		'priority' => 0,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __('Content Extras', 'sazerac'),
		'description' => '',
		'panel' => 'site_content',
		) 
	);


	/**
		* Enable/Disable Post Format support
		* @link http://codex.wordpress.org/Post_Formats
		*/
	$wp_customize->add_setting(
		'sazerac_post_format_support',
		array(
					'default'   => 'yes',
					'sanitize_callback' => 'sazerac_sanitize_choices'
				)
	);

	$wp_customize->add_control(
		'sazerac_post_format_support',
		array(
					'section'    => 'content_extras',
					'label'        => __('Enable Post Format support', 'sazerac'),
					'type'        => 'radio',
					'choices'    => array(
						'yes'    => 'Yes',
						'no'        => 'No'
					)
				)
	);

	/**
		* Enable/Disable Infinite Scroll support
		* @uses Jetpack
		* @link http://downloads.wordpress.org/plugin/jetpack.latest-stable.zip
		*/
	$wp_customize->add_setting(
		'sazerac_infinite_scroll_support',
		array(
					'default'   => 'no',
					'sanitize_callback' => 'sazerac_sanitize_choices'
				)
	);

	$wp_customize->add_control(
		'sazerac_infinite_scroll_support',
		array(
					'section'  => 'content_extras',
					'label'        => __('Enable Infinite Scroll Theme Support', 'sazerac'),
					'type'     => 'radio',
					'description' => __('If enabled, you must install the Jetpack Plugin and Activate it.', 'sazerac'),
					'choices'    => array(
						'yes'    => 'Yes',
						'no'        => 'No'
					)
				)
	);

	// Set the type of Infinite Scroll
	$wp_customize->add_setting(
		'sazerac_infinite_scroll_type',
		array(
					'default'   => 'scroll',
					'sanitize_callback' => 'sazerac_sanitize_choices'
				)
	);

	$wp_customize->add_control(
		'sazerac_infinite_scroll_type',
		array(
					'section'    => 'content_extras',
					'label'        => __('Infinite Scroll Type', 'sazerac'),
					'type'        => 'radio',
					'choices'    => array(
						'scroll'    => __('Scroll', 'sazerac'),
						'click'        => __('Click', 'sazerac')
					)
				)
	);


}
add_action('customize_register', 'sazerac_add_customizer_theme_options');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */

function sazerac_customize_preview_js() 
{
	wp_enqueue_script('sazerac_customizer', get_stylesheet_directory_uri() . '/inc/customizer/js/customizer.js', array( 'jquery','customize-preview' ), true );
}
add_action('customize_preview_init', 'sazerac_customize_preview_js');
