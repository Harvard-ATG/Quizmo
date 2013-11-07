define(['jquery', 'lodash', 'bootstrap'], function($, _, bootstrap){
	
	var Take = function(config){
		this.config = config;
		this.is_submitted_url = config.is_submitted_url;
		this.quiz_id = config.quiz_id;
		this.redirect_url = config.redirect_url;
		this.init();
	};
	
	_.extend(Take.prototype, {
		init: function(){
			this.checkSubmitted();
		},
		checkSubmitted: function(){
			var that = this;
			var quiz_id = that.config.quiz_id;
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