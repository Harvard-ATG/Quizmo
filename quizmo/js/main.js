requirejs.config({
	paths: {
		'jquery' : 'jquery-1.7.2.min',
		'lodash' : '//cdnjs.cloudflare.com/ajax/libs/lodash.js/1.3.1/lodash',
		'bootstrap' : '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min',
		'jqueryui' : 'jquery-ui'
	},
	shim: {
		'jquery' : '$',
		'lodash' : '_',
		'jqueryui' : ['jquery']
	}
});
