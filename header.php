<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package sazerac
 */
?>
<!DOCTYPE html>
<?php tha_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
    <?php tha_head_top(); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<style type="text/css">
		<?php if ( 'no' === get_theme_mod( 'some-like-it-neat_post_format_support' ) ): ?>
			h1.entry-title:before {
				display: none;
			}
		<?php endif; ?>
	</style>

    <?php tha_head_bottom(); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php tha_body_top(); ?>
	<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'sazerac' ); ?></a>

		<div id="primary-navigation-section">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<div class="menu-toggle">
					<a href="#offcanvas" class="navigation-button">
						<span class="screen-reader-text"><?php _e( 'Menu', 'luminate' ); ?></span>
						<span class="toggle"></span>
					</a>
				</div>
				<?php wp_nav_menu( 
					array( 'theme_location' => 'primary-navigation', 
						'menu_id' => 'primary-menu', 
						'link_before' => '<span>',
						'link_after' => '</span>',
						'depth' => '2' ) 
					); ?>
			</nav><!-- #site-navigation -->
		</div><!-- #primary-navigation-section -->

		<?php tha_header_before(); ?>
		<header id="masthead" class="site-header wrap" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
		<?php tha_header_top(); ?>

			<div class="site-branding">
			<?php if ( get_theme_mod( 'sazerac_logo' ) ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="site-logo" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				 
					<img src="<?php echo get_theme_mod( 'sazerac_logo' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				 
				</a>
				 
			<?php endif; ?>

			<?php if ( 'yes' === get_theme_mod( 'sazerac_show_title', 'yes' ) || 'yes' === get_theme_mod( 'sazerac_show_description', 'yes' ) ) : ?>
				<hgroup>
					<?php $tag = is_home() || is_front_page() ? 'h1' : 'div'; ?>
					<?php if( 'yes' === get_theme_mod( 'sazerac_show_title', 'yes' ) ) {
						printf( '<%1$s class="site-title"><a href="%2$s" title="%3$s" rel="home">%4$s</a></%1$s>', $tag, esc_url( home_url( '/' ) ), esc_attr( get_bloginfo( 'name', 'display' ) ), get_bloginfo( 'name' ), $tag ); 
					} ?>
					<?php if( 'yes' === get_theme_mod( 'sazerac_show_title', 'yes' ) ) { ?>
						<p class="site-description"><?php bloginfo( 'description' ); ?></p>
					<?php } ?>
				</hgroup>

			<?php endif; ?>

			</div>

			<?php tha_header_bottom(); ?>

		</header><!-- #masthead -->
		<?php tha_header_after(); ?>

		<?php tha_content_before(); ?>
		<main id="main" class="site-main wrap" role="main">
			<?php tha_content_top(); ?>
