requirejs.config({
	paths: {
		'jquery' : 'http://code.jquery.com/jquery-1.10.1.min',
		'lodash' : '//cdnjs.cloudflare.com/ajax/libs/lodash.js/1.3.1/lodash',
		'bootstrap' : '//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min',
		'jqueryui' : 'http://code.jquery.com/ui/1.8.23/jquery-ui.min.js'
	},
	shim: {
		'jquery' : '$',
		'lodash' : '_'
	}
});