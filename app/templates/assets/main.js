/**
 * <%= title %>
 * <%= theme_url %>
 *
 * Copyright (c) <%= year %> <%= author_name %>
 * Licensed under the GPLv2+ license.
 */

// Modified http://paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/
// Only fires on body class (working off strictly WordPress body_class)

var <%= js_safe_title %> = {
	// All pages
	common: {
		init: function() {
			// JS here
		},
		finalize: function() { }
	},
	// Home page
	home: {
		init: function() {
			// JS here
		}
	},
	// About page
	about: {
		init: function() {
			// JS here
		}
	}
};

var UTIL = {
	fire: function(func, funcname, args) {
		var namespace = <%= js_safe_title %>;
		funcname = (funcname === undefined) ? 'init' : funcname;
		if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
			namespace[func][funcname](args);
		}
	},
	loadEvents: function() {

		UTIL.fire('common');

		jQuery.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
			UTIL.fire(classnm);
		});

		UTIL.fire('common', 'finalize');
	}
};

jQuery(document).ready(function($) {
	UTIL.loadEvents();
});
