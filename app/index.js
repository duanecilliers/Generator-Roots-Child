'use strict';
var fs = require('fs');
var util = require('util');
var path = require('path');
var slugify = require('slugify');
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
					me.title = input.title;
					me.slug = slugify(me.title).toLowerCase();
					me.theme_name = path.basename(process.cwd());
					me.prefix = input.prefix;
					me.prefix_caps = me.prefix.toUpperCase();
					me.description = input.description;
					me.theme_url = input.theme_url;
					me.author_name = input.author_name;
					me.author_url = input.author_url;
					me.author_email = input.author_email;
					me.css_type = input.css_type;
					me.bootstrap = input.bootstrap;
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
	var dirs  = ['assets', 'assets/css', 'assets/img', 'assets/js', 'lib', 'templates', 'languages'];
	for (var i = 0; i < dirs.length; i++) {
		this.mkdir(dirs[i]);
	}
};

RootsChildGenerator.prototype.projectfiles = function projectfiles() {
	this.copy('editorconfig', '.editorconfig');
	this.copy('jshintrc', '.jshintrc');
	this.template('package.json.tmpl', 'package.json');
	this.template('bower.json.tmpl', 'bower.json');
	this.template('humans.txt.tmpl', 'humans.txt');
	this.template('functions.php.tmpl', 'functions.php');
	this.template('config.php.tmpl', 'lib/config.php');
	// this.copy('_Gruntfile.js', 'Gruntfile.js');
	// this.copy('bowerrc', '.bowerrc');
};
