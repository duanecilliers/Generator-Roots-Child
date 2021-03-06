'use strict';
require('date-utils');
var fs = require('fs');
var util = require('util');
var path = require('path');
var yeoman = require('yeoman-generator');


var RootsChildGenerator = module.exports = function RootsChildGenerator(args, options, config) {
	yeoman.generators.Base.apply(this, arguments);

	this.on('end', function () {
		this.installDependencies({ skipInstall: options['skip-install'] });
	});

	this.pkg = JSON.parse(this.readFileAsString(path.join(__dirname, '../package.json')));
};

util.inherits(RootsChildGenerator, yeoman.generators.Base);

RootsChildGenerator.prototype.askFor = function askFor() {
	var done = this.async(),
		me = this;

	// have Yeoman greet the user.
	console.log(this.yeoman);

	getInput();

	function getInput() {

		var prompts = require('./prompts');
		me.prompt(prompts(), function (input) {
			me.prompt([{
				name: 'confirm',
				message: 'Does this all look correct?',
				type: 'confirm'
			}], function (i) {
				if (i.confirm) {
					me.date = Date.today();
					me.date_formatted = me.date.toFormat('YYYY-MM-DD HH:MI');
					me.year = me.date.toFormat('YYYY');
					me.title = input.title;
					me.js_safe_title = me.title.split(' ').join('');
					me.theme_name = path.basename(process.cwd());
					me.prefix = input.prefix;
					me.prefix_caps = me.prefix.toUpperCase();
					me.description = input.description;
					me.theme_url = input.theme_url;
					me.author_name = input.author_name;
					me.author_url = input.author_url;
					me.author_email = input.author_email;
					me.css_type = input.css_type;
					me.modernizr = input.modernizr;
					done();
				} else {
					console.log();
					getInput();
				}
			});
		}.bind(me));
	}

};

RootsChildGenerator.prototype.projectdirs = function projectdirs() {
	var dirs  = ['assets', 'assets/dist', 'assets/css', 'assets/img', 'assets/img/dist', 'assets/js', 'assets/js/source', 'assets/js/vendor', 'lib', 'templates', 'lang'];
	for (var i = 0; i < dirs.length; i++) {
		this.mkdir(dirs[i]);
	}
	switch (this.css_type) {
		case 'Sass':
			this.mkdir('assets/css/sass');
			break;
		case 'LESS':
			this.mkdir('assets/css/less');
			break;
	}
};

RootsChildGenerator.prototype.projectfiles = function projectfiles() {
	this.copy('editorconfig', '.editorconfig');
	this.copy('jshintrc', '.jshintrc');
	this.copy('bowerrc', '.bowerrc');
	this.copy('gruntjshintrc', '.gruntjshintrc');
	this.copy('_screenshot.png', 'screenshot.png');
	this.copy('_index.php', 'index.php');

	this.template('package.json', 'package.json');
	this.template('bower.json', 'bower.json');
	this.template('humans.txt', 'humans.txt');
	this.template('style.css', 'style.css');
	this.template('theme.pot', 'lang/' + this.theme_name + '.pot');
	this.template('functions.php', 'functions.php');

	this.template('assets/main.js', 'assets/js/source/main.js');
	this.template('assets/plugins.js', 'assets/js/source/plugins.js');

	this.template('lib/config.php', 'lib/config.php');
	this.template('lib/activation.php', 'lib/activation.php');
	this.template('lib/scripts.php', 'lib/scripts.php');
	this.template('lib/theme-functions.php', 'lib/theme-functions.php');
	this.template('lib/class-tgm-plugin-activation.php', 'lib/class-tgm-plugin-activation.php');
	this.template('lib/theme-require-plugins.php', 'lib/theme-require-plugins.php');

	this.template('Gruntfile.js', 'Gruntfile.js');

	switch (this.css_type) {
		case 'Sass':
			this.template('assets/main.css', 'assets/css/sass/main.scss');
			break;
		case 'LESS':
			this.template('assets/main.css', 'assets/css/less/main.less');
			break;
		default:
			this.template('assets/main.css', 'assets/css/main.css');
	}
};
