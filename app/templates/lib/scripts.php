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

	<% if (css_type != 'None') { %>
	wp_dequeue_script('roots_main');
	<% } %>
	wp_enqueue_style('<%= prefix %>_main', get_stylesheet_directory_uri() . "/assets/css/main.min.css", false, '9dbd7d094ab56a14e3b2a984b20ea357');

	// jQuery is loaded using the same method from HTML5 Boilerplate:
	// Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
	// It's kept in the header instead of footer to avoid conflicts with plugins.
	if (!is_admin() && current_theme_supports('jquery-cdn')) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, null, false);
		add_filter('script_loader_src', '<%= prefix %>_jquery_local_fallback', 10, 2);
	}

	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	// deregister and dequeue roots_scripts
	wp_dequeue_script('roots_scripts');
	wp_deregister_script('roots_scripts');

	wp_register_script('<%= prefix %>_scripts', get_stylesheet_directory_uri() . "/assets/js/main.min.js", array('jquery'), 'be373268f9b8ecda7c3a45154676e637', true);

	// enqueue modernizr from roots parent theme if child theme supports it. Enable in lib/config.php
	if ( get_theme_support('modernizr') )
		wp_enqueue_script('modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-2.6.2.min.js', false, null, false);
	wp_enqueue_script('jquery');
	wp_enqueue_script('<%= prefix %>_scripts');
}
add_action('wp_enqueue_scripts', '<%= prefix %>_scripts', 100);

// http://wordpress.stackexchange.com/a/12450
function <%= prefix %>_jquery_local_fallback($src, $handle = null) {
	static $add_jquery_fallback = false;

	if ($add_jquery_fallback) {
		echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/assets/js/vendor/jquery-1.10.2.min.js"><\/script>\')</script>' . "\n";
		$add_jquery_fallback = false;
	}

	if ($handle === 'jquery') {
		$add_jquery_fallback = true;
	}

	return $src;
}
add_action('wp_head', '<%= prefix %>_jquery_local_fallback');

// Set Google Analytics ID in config.php
function <%= prefix %>_google_analytics() { ?>
<script>
	(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
	function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
	e=o.createElement(i);r=o.getElementsByTagName(i)[0];
	e.src='//www.google-analytics.com/analytics.js';
	r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
	ga('create','<?php echo GOOGLE_ANALYTICS_ID; ?>');ga('send','pageview');
</script>

<?php }
// Don't include Analytics tracking code if user is an admin or shen in dev mode.
if (false != WP_LOCAL_DEV && GOOGLE_ANALYTICS_ID && !current_user_can('manage_options')) {
	add_action('wp_footer', '<%= prefix %>_google_analytics', 20);
}
