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
	load_theme_textdomain( '<%= theme_name %>', get_template_directory() . '/languages' );

	/****************************************
	Backend
	*****************************************/

	/**
	 * filter Yoast SEO metabox priority
	 */
	add_filter( 'wpseo_metabox_prio', '<%= prefix %>_filter_yoast_seo_metabox' );

	/**
	 * Customize contact methods
	 */
	add_filter( 'user_contactmethods', '<%= prefix %>_change_contactmethod', 10, 1 );

	/**
	 * Don't update theme if theme with same name exists in WP theme repo
	 */
	add_filter( 'http_request_args', '<%= prefix %>_dont_update_theme', 5, 2 );

	/**
	 * Remove dashboard metaboxes
	 */
	add_action('wp_dashboard_setup', '<%= prefix %>_remove_dashboard_widgets' );

	/**
	 * Change Admin Menu Order
	 */
	add_filter( 'custom_menu_order', '<%= prefix %>_custom_menu_order' );
	add_filter( 'menu_order', '<%= prefix %>_custom_menu_order' );

	/**
	 * Hide admin areas that aren't used
	 */
	add_action( 'admin_menu', '<%= prefix %>_remove_menu_pages' );

	/**
	 * Remove default link for images
	 */
	add_action( 'admin_init', '<%= prefix %>_imagelink_setup', 10 );

	/**
	 * Show kitchen Sink in WYSIWYG editor
	 */
	add_filter( 'tiny_mce_before_init', '<%= prefix %>_unhide_kitchensink' );

	/****************************************
	Frontend
	*****************************************/

	/**
	  * Add humans.txt to the <head> element.
	  */
	add_action( 'wp_head', '<%= prefix %>_header_meta' );

	/**
	 * Remove Query Strings From Static Resources
	 */
	add_filter( 'script_loader_src', '<%= prefix %>_remove_script_version', 15, 1 );
	add_filter( 'style_loader_src', '<%= prefix %>_remove_script_version', 15, 1 );

	/**
	 * Remove Read More Jump
	 */
	add_filter( 'the_content_more_link', '<%= prefix %>_remove_more_jump_link' );
}
add_action( 'after_setup_theme', '<%= prefix %>_setup' );
