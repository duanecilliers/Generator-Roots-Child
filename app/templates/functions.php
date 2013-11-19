<?php
/**
 * <%= title %> functions and definitions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package <%= theme_name %>
 * @since 0.1.0
 */

 // Useful global constants
define( '<%= prefix_caps %>_VERSION', '0.1.0' );

require_once( get_stylesheet_directory() . '/lib/theme-functions.php' );

/**
 * Require plugins
 */
require_once( get_stylesheet_directory() . '/lib/class-tgm-plugin-activation.php' );
require_once( get_stylesheet_directory() . '/lib/theme-require-plugins.php' );

add_action( 'tgmpa_register', '<%= prefix %>_register_required_plugins' );

 /**
  * Set up theme defaults and register supported WordPress features.
  *
  * @uses load_theme_textdomain() For translation/localization support.
  *
  * @since 0.1.0
  */
function <%= prefix %>_setup() {
	/**
	 * Makes <%= theme_name %> available for translation.
	 *
	 * Translations can be added to the /lang directory.
	 * If you're building a theme based on <%= theme_name %>, use a find and replace
	 * to change '<%= prefix %>' to the name of your theme in all template files.
	 */
	load_theme_textdomain( '<%= prefix %>', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', '<%= prefix %>_setup' );

 /**
  * Add humans.txt to the <head> element.
  */
function <%= prefix %>_header_meta() {
	$humans = '<link type="text/plain" rel="author" href="' . get_stylesheet_directory_uri() . '/humans.txt" />';

	echo apply_filters( '<%= prefix %>_humans', $humans );
}
add_action( 'wp_head', '<%= prefix %>_header_meta' );

/**
 * filter Yoast SEO metabox priority
 */
add_filter( 'wpseo_metabox_prio', '<%= prefix %>_filter_yoast_seo_metabox' );
function <%= prefix %>_filter_yoast_seo_metabox() {
        return 'low';
}
