define(['jquery', 'lodash', 'bootstrap'], function($, _, bootstrap){
	
	var Take = function(config){
		// is_submitted_url
		// quiz_id
		// redirect_url
		this.config = config;
		this.init();
	};
	
	_.extend(Take.prototype, {
		init: function(){
			this.checkSubmitted();
		},
		checkSubmitted: function(){
			var that = this;
			quiz_id = that.config.quiz_id;
			$.ajax({
				type: 'POST',
				url: that.config.is_submitted_url,
				data: {'quiz_id': quiz_id},
				dataType: 'json',
				success: function(data, statusText){		
					if(data.success){
						// redirect
						window.location.href = that.config.redirect_url;
					} else {
						// do nothing
					}
				},
				error: function(request, statusText){
					alert("Request failed.");
				}
			});
		}
	});
	
	return Take;

});