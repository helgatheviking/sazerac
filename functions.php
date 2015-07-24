<?php
/**
 * sazerac functions and definitions
 *
 * @package sazerac
 */

if ( ! function_exists( 'sazerac_setup' ) ) :
	/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
	function sazerac_setup()
	{

		/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
		if ( ! isset( $content_width ) ) {
			$content_width = 640; /* pixels */
		}

		/*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on sazerac, use a find and replace
        * to change 'sazerac' to the name of your theme in all the template files
        */
		load_theme_textdomain( 'sazerac', get_template_directory() . '/library/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
        */
		add_theme_support( 'post-thumbnails' );

		/*
        * Enable title tag support for all posts.
        *
        * @link http://codex.wordpress.org/Title_Tag
        */
		add_theme_support( 'title-tag' );

		/*
        * Add Editor Style for adequate styling in text editor.
        *
        * @link http://codex.wordpress.org/Function_Reference/add_editor_style
        */
		add_editor_style( '/assets/css/editor-style.css' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary-navigation', __( 'Primary Menu', 'sazerac' ) );

		// Enable support for Post Formats.
		if ( 'yes' === get_theme_mod( 'some-like-it-neat_post_format_support' ) ) {
			add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'status', 'gallery', 'chat', 'audio' ) );
		}

		// Enable Support for Jetpack Infinite Scroll
		if ( 'yes' === get_theme_mod( 'some-like-it-neat_infinite_scroll_support' ) ) {
			$scroll_type = get_theme_mod( 'some-like-it-neat_infinite_scroll_type' );
			add_theme_support( 'infinite-scroll', array(
				'type'				=> $scroll_type,
				'footer_widgets'	=> false,
				'container'			=> 'content',
				'wrapper'			=> true,
				'render'			=> false,
				'posts_per_page' 	=> false,
				'render'			=> 'sazerac_infinite_scroll_render',
			) );

			function sazerac_infinite_scroll_render() {
				if ( have_posts() ) : while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content', get_post_format() );
				endwhile;
				endif;
			}
		}

		// Setup the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'sazerac_custom_background_args', array(
				'default-color' => 'ffffff',
				'default-image' => '',
				)
			)
		);

		/**
	 * Including Theme Hook Alliance (https://github.com/zamoose/themehookalliance).
	 */
		include 'inc/theme-hook-alliance/tha-theme-hooks.php' ;

		/**
	 * WP Customizer
	 */
		include get_template_directory() . '/inc/customizer/customizer.php';

		/**
	 * Implement the Custom Header feature.
	 */
		//require get_template_directory() . '/inc/custom-header.php';

		/**
	 * Custom template tags for this theme.
	 */
		include get_template_directory() . '/inc/template-tags.php';

		/**
	 * Custom functions that act independently of the theme templates.
	 */
		include get_template_directory() . '/inc/extras.php';

		/**
	 * Load Jetpack compatibility file.
	 */
		include get_template_directory() . '/inc/jetpack.php';

	}
endif; // sazerac_setup
add_action( 'after_setup_theme', 'sazerac_setup' );

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists( 'sazerac_scripts' ) ) :
	function sazerac_scripts()
	{

		if ( SCRIPT_DEBUG || WP_DEBUG ) :
			// Vendor Scripts
			wp_enqueue_script( 'sidr', get_template_directory_uri() . '/assets/js/vendors/jquery.sidr.js', array( 'jquery' ), '1.2.1', true );
			wp_enqueue_script( 'fastclick', get_template_directory_uri() . '/assets/js/vendors/jquery.fastclick.js', array( 'jquery' ), '1.0.0', true );


			// Concatonated Scripts
			wp_enqueue_script( 'development-js', get_template_directory_uri() . '/assets/js/development.js', array( 'jquery' ), '1.0.0', false );

			// Main Style
			wp_enqueue_style( 'sazerac-style',  get_template_directory_uri() . '/style.css' );

	 else :
			// Vendor Scripts
			wp_enqueue_script( 'sidr', get_template_directory_uri() . '/assets/js/vendors/jquery.sidr.min.js', array( 'jquery' ), '1.2.1', true );
			wp_enqueue_script( 'fastclick', get_template_directory_uri() . '/assets/js/vendors/jquery.fastclick.min.js', array( 'jquery' ), '1.0.0', true );

			// Concatonated Scripts
			wp_enqueue_script( 'production-js', get_template_directory_uri() . '/assets/js/production-min.js', array( 'jquery' ), '1.0.0', false );

			// Main Style
			wp_enqueue_style( 'sazerac-style',  get_template_directory_uri() . '/style-min.css' );

	 endif;

		// Dashicons
		wp_enqueue_style( 'dashicons' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'sazerac_scripts' );
endif; // Enqueue Scripts and Styles

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function sazerac_widgets_init()
{
	register_sidebar(
		array(
		'name'          => __( 'Sidebar', 'sazerac' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'sazerac_widgets_init' );


/**
 * Add Singular Post Template Navigation
 */
if ( ! function_exists( 'sazerac_post_navigation' ) ) :
	function sazerac_post_navigation() {
		if ( function_exists( 'get_the_post_navigation' ) && is_singular() ) {
			echo get_the_post_navigation(
				array(
				'prev_text'    => __( '&larr; %title', 'sazerac' ),
				'next_text'    => __( '%title &rarr;', 'sazerac' ),
				'screen_reader_text' => __( 'Page navigation', 'sazerac' )
				)
			);
		} else {
			wp_link_pages(
				array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'sazerac' ),
				'after'  => '</div>',
				)
			);
		}
	}
endif;
add_action( 'tha_entry_after', 'sazerac_post_navigation' );

/**
 * Custom Hooks and Filters
 */
if ( ! function_exists( 'sazerac_add_breadcrumbs' ) ) :
	function sazerac_add_breadcrumbs()
	{
		if ( ! is_front_page() ) {
			if ( function_exists( 'HAG_Breadcrumbs' ) ) { HAG_Breadcrumbs(
				array(
				'prefix'     => __( 'You are here: ', 'sazerac' ),
				'last_link'  => true,
				'separator'  => '|',
				'excluded_taxonomies' => array(
				'post_format'
				),
				'taxonomy_excluded_terms' => array(
				'category' => array( 'uncategorized' )
				),
				'post_types' => array(
				'gizmo' => array(
				'last_show'          => false,
				'taxonomy_preferred' => 'category',
				),
				'whatzit' => array(
				'separator' => '&raquo;',
				)
				)
				)
			);
			}
		}
	}
	add_action( 'tha_content_top', 'sazerac_add_breadcrumbs' );
endif;

if ( ! function_exists( 'sazerac_optional_scripts' ) ) :
	function sazerac_optional_scripts()
	{
		// Link Color
		if ( '' != get_theme_mod( 'sazerac_add_link_color' )  ) {
		} ?>
			<style type="text/css">
				a { color: <?php echo get_theme_mod( 'sazerac_add_link_color' ); ?>; }
			</style>
		<?php
	}
	add_action( 'wp_head', 'sazerac_optional_scripts' );
endif;



if ( ! function_exists( 'sazerac_add_footer_divs' ) ) :
	function sazerac_add_footer_divs()
	{
	?>

			<div class="site-info">
				<?php echo get_theme_mod( 'sazerac_site_info', __( '&copy; All Rights Reserved', 'sazerac' ) ); ?>
			</div>
			<div class="credits">
				<?php echo get_theme_mod( 'sazerac_credits', sprintf(__( '%sSazerac%s, by Kathy Darling', 'sazerac' ), '<a href="http://www.kathyisawesome.com">' ,'</a>' ) );  ?>
			</div>
		<?php
	}
	add_action( 'sazerac_credits', 'sazerac_add_footer_divs' );
endif;