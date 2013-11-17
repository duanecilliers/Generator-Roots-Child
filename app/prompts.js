module.exports = function() {

	// Validate required
	var requiredValidate = function(value) {
		if (value == '') {
			return 'This field is required.';
		}
		return true;
	};

	return [
		{
			name: 'title',
			message: 'The title of your child theme',
			type: 'input',
			default: 'Roots Child'
		}, {
			name: 'prefix',
			message: 'PHP function prefix (alpha and underscore characters only)',
			type: 'input',
			default: 'rootschild'
		}, {
			name: 'description',
			message: 'Description',
			type: 'input',
			default: 'Roots child theme'
		}, {
			name: 'theme_url',
			message: 'Theme URL',
			type: 'input'
		}, {
			name: 'author_name',
			message: 'Author Name',
			type: 'input',
			validate: requiredValidate
		}, {
			name: 'author_email',
			message: 'Author Email',
			type: 'input',
			validate: requiredValidate
		}, {
			name: 'author_url',
			message: 'Author URL',
			type: 'input'
		}, {
			name: 'css_type',
			message: 'CSS Preprocessor: Will you use "Sass", "LESS", or "none" for CSS with this project?',
			type: 'list',
			choices: [ 'Sass', 'LESS',  'none' ]
		}
	];

};
