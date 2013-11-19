<?php

/****************************************
Backend Functions
*****************************************/

/**
 * Customize Contact Methods
 * @since 1.0.0
 *
 * @author Bill Erickson
 * @link http://sillybean.net/2010/01/creating-a-user-directory-part-1-changing-user-contact-fields/
 *
 * @param array $contactmethods
 * @return array
 */
function <%= prefix %>_change_contactmethods( $contactmethods ) {
	unset( $contactmethods['aim'] );
	unset( $contactmethods['yim'] );
	unset( $contactmethods['jabber'] );

	return $contactmethods;
}
add_filter( 'user_contactmethods', '<%= prefix %>_change_contactmethod', 10, 1 );

/**
 * Don't Update Theme
 * @since 1.0.0
 *
 * If there is a theme in the repo with the same name,
 * this prevents WP from prompting an update.
 *
 * @author Mark Jaquith
 * @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
 *
 * @param array $r, request arguments
 * @param string $url, request url
 * @return array request arguments
 */
function <%= prefix %>_dont_update_theme( $r, $url ) {
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	return $r;
}
// Don't update theme
add_filter( 'http_request_args', '<%= prefix %>_dont_update_theme', 5, 2 );

/**
 * Remove Dashboard Meta Boxes
 */
function <%= prefix %>_remove_dashboard_widgets() {
	global $wp_meta_boxes;
	// unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
add_action('wp_dashboard_setup', '<%= prefix %>_remove_dashboard_widgets' );

/**
 * Change Admin Menu Order
 */
function <%= prefix %>_custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;
	return array(
		// 'index.php', // Dashboard
		// 'separator1', // First separator
		// 'edit.php?post_type=page', // Pages
		// 'edit.php', // Posts
		// 'upload.php', // Media
		// 'gf_edit_forms', // Gravity Forms
		// 'genesis', // Genesis
		// 'edit-comments.php', // Comments
		// 'separator2', // Second separator
		// 'themes.php', // Appearance
		// 'plugins.php', // Plugins
		// 'users.php', // Users
		// 'tools.php', // Tools
		// 'options-general.php', // Settings
		// 'separator-last', // Last separator
	);
}
// Change Admin Menu Order
add_filter( 'custom_menu_order', '<%= prefix %>_custom_menu_order' );
add_filter( 'menu_order', '<%= prefix %>_custom_menu_order' );

/**
 * Hide Admin Areas that are not used
 */
function <%= prefix %>_remove_menu_pages() {
	// remove_menu_page('link-manager.php');
}
add_action( 'admin_menu', '<%= prefix %>_remove_menu_pages' );

/**
 * Remove default link for images
 */
function <%= prefix %>_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action( 'admin_init', '<%= prefix %>_imagelink_setup', 10 );

/**
 * Show Kitchen Sink in WYSIWYG Editor
 */
function <%= prefix %>_unhide_kitchensink($args) {
	$args['wordpress_adv_hidden'] = false;
	return $args;
}
add_filter( 'tiny_mce_before_init', '<%= prefix %>_unhide_kitchensink' );

/****************************************
Frontend
*****************************************/

/**
 * Remove Query Strings From Static Resources
 */
function <%= prefix %>_remove_script_version($src){
	$parts = explode('?', $src);
	return $parts[0];
}
add_filter( 'script_loader_src', '<%= prefix %>_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '<%= prefix %>_remove_script_version', 15, 1 );

/**
 * Remove Read More Jump
 */
function <%= prefix %>_remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}
add_filter( 'the_content_more_link', '<%= prefix %>_remove_more_jump_link' );
