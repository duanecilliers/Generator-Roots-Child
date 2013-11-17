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
	var dirs  = ['assets', 'assets/css', 'assets/img', 'assets/js', 'assets/js/vendor', 'lib', 'templates', 'languages'];
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
	this.template('package.json.tmpl', 'package.json');
	this.template('bower.json.tmpl', 'bower.json');
	this.template('humans.txt.tmpl', 'humans.txt');
	this.template('style.css.tmpl', 'style.css');
	this.template('main.js.tmpl', 'assets/js/_main.js');
	this.template('theme.pot.tmpl', 'languages/' + this.theme_name + '.pot');
	this.template('functions.php.tmpl', 'functions.php');
	this.template('config.php.tmpl', 'lib/config.php');
	this.template('scripts.php.tmpl', 'lib/scripts.php');
	this.template('Gruntfile.js.tmpl', 'Gruntfile.js');
	switch (this.css_type) {
		case 'Sass':
			this.template('main.css.tmpl', 'assets/css/sass/main.scss');
			break;
		case 'LESS':
			this.template('main.css.tmpl', 'assets/css/less/main.less');
			break;
		default:
			this.template('main.css.tmpl', 'assets/css/main.css');
	}
};
