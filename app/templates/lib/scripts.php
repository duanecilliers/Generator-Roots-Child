<?php
/**
 * Overwrites scripts.php in wp-content/themes/roots/lib
 *
 * Dequeue roots scripts and stylesheets
 * Enqueue scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /<%= theme_name %>/assets/css/main.min.css
 *
 * Enqueue scripts in the following order:
 * 1. jquery-1.10.2.min.js via Google CDN
 * 2. /roots/assets/js/vendor/modernizr-2.6.2.min.js
 * 3. /<%= theme_name %>/assets/js/main.min.js (in footer)
 */
function <%= prefix %>_scripts() {
	<% if (css_type == 'none') { %>
	wp_enqueue_style( 'roots_main', get_template_directory_uri() . '/assets/css/main.min.css', false );
	<% } %>
	if ( ! <%= prefix %>_is_dev_mode() ) {
		$assets_config = get_stylesheet_directory() . '/lib/assets.config.php';
		if ( false == @include $assets_config ) {
			wp_die( '<p>Scripts and styles have not been processed by Grunt.</p>
				<p>Please run the following command from terminal in the theme directory path. <strong>Omit the "$" (dollar sign)</strong>.</p>
				<p><pre><code>$ grunt</code></pre></p>
				<p>Run the following command to watch for changes and compile scripts.</p>
				<p><pre><code>$ grunt dev</code></pre></p>
				<p>Set the WP_DEV_MODE constant to true in wp-config.php to enqueue unminified javascript.</p>' );
		}
		$config = include $assets_config;
		$main_versioned_css = $config['staticAssets']['global']['css'][0];
		$modernizr_versioned_js = $config['staticAssets']['global']['js'][0];
		$plugins_versioned_js = $config['staticAssets']['global']['js'][0];
		$main_versioned_js = $config['staticAssets']['global']['js'][1];
	}

	$main_css = ( <%= prefix %>_is_dev_mode() ) ? '/assets/css/main.css' : '/assets/dist' . $main_versioned_css;
	wp_enqueue_style( '<%= prefix %>_main', get_stylesheet_directory_uri() . $main_css, false, null );

	// jQuery is loaded using the same method from HTML5 Boilerplate:
	// Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
	// It's kept in the header instead of footer to avoid conflicts with plugins.
	if ( ! is_admin() && current_theme_supports( 'jquery-cdn' ) ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, null, false );
		add_filter( 'script_loader_src', '<%= prefix %>_jquery_local_fallback', 10, 2 );
	}

	if (is_single() && comments_open() && get_option( 'thread_comments')) {
		wp_enqueue_script( 'comment-reply' );
	}
	<% if('none' == css_type) { %>
	if ( <%= prefix %>_is_dev_mode() )
		wp_enqueue_script( 'roots_scripts', get_template_directory_uri() . '/assets/js/scripts.min.js', false, null, true );<% } %>
	<% if (modernizr) { %>
	$modernizr_js = ( <%= prefix %>_is_dev_mode() ) ? '/bower_components/modernizr/modernizr.js' : '/assets/dist' . $modernizr_versioned_js;
	wp_enqueue_script( 'modernizr', get_stylesheet_directory_uri() . $modernizr_js, false, null, false );
	<% } %>
	wp_enqueue_script( 'jquery' );

	$plugins_js = ( <%= prefix %>_is_dev_mode() ) ? '/assets/js/plugins.min.js' : '/assets/dist' . $plugins_versioned_js;
	$main_js = ( <%= prefix %>_is_dev_mode() ) ? '/assets/js/source/main.js' : '/assets/dist' . $main_versioned_js;
	wp_enqueue_script( '<%= prefix %>_plugins', get_stylesheet_directory_uri() . $plugins_js, array( 'jquery' ), null, true );
	wp_enqueue_script( '<%= prefix %>_main', get_stylesheet_directory_uri() . $main_js, array( 'jquery', '<%= prefix %>_plugins' ), null, true );
}

// http://wordpress.stackexchange.com/a/12450
function <%= prefix %>_jquery_local_fallback( $src, $handle = null ) {
	static $add_jquery_fallback = false;

	if ( $add_jquery_fallback ) {
		echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/js/vendor/jquery-1.10.2.min.js"><\/script>\')</script>' . "\n";
		$add_jquery_fallback = false;
	}

	if ( $handle === 'jquery' ) {
		$add_jquery_fallback = true;
	}

	return $src;
}
