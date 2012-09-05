<ul class="breadcrumb">
  <li>
    <a href='{url url="/quiz/index/$collection_id"}'>Quizzes</a> <span class="divider">/</span>
  </li>
  <li class="active">{$title}</li>
</ul>

<div class="well"  style="height: 250px">
<div id="questions-container">

</div>
</div>

<div id="quiz-controls" class="btn-toolbar">
	<div class="btn-group">
		<button name="prev" type="button" class="btn">&lt;</button>	
	</div>
	<div name="question_numbers" class="btn-group">
		{foreach from=$question_ids item=question_id name=questions}
			<button id="question_{$smarty.foreach.questions.iteration}" name="{$question_id}" type="button" class="btn">{$smarty.foreach.questions.iteration}</button>
		{/foreach}
	</div>
	<div class="btn-group">
		<button name="next" type="button" class="btn">&gt;</button>
	</div>
</div>

<div>
	<button type="button" class="btn btn-danger" id="quiz-submit-btn">Submit</button>
</div>
<div class="modal hide" id="quiz-submit" style="text-align: center">
	<div class="modal-body">
		<p class="lead">Are you sure you want to submit this quiz now?  You will not be able to come back to it.</p>
	</div>
	<div class="modal-footer" style="text-align: center">
		<a id="quiz-submit-confirm-btn" href="#" class="btn btn-danger" data-dismiss="modal">Submit</a>
		<a href="#" class="btn" data-dismiss="modal">Cancel</a>
	</div>
</div>


<input type="hidden" id="question_ids" value='{$question_ids_json}'/>

<script>

submitQuestion = function(){
	console.log("ERROR: submitting blank!");
}

continueNext = function(){
	next_item = current_item.next("button");
	// if next_item is 0, send us to the quiz page
	index_url = '{url url="/quiz/index/$collection_id"}';
	if(next_item.length == 0){
		window.location.href = index_url;
		$("#questions-container").hide(400);
		return;
	}
	next_item_question_id = next_item.attr("name");
	loadQuestion(next_item_question_id);
	
	current_item.removeClass("active");
	current_item = next_item;
	current_item.addClass("active");
	if(current_item.attr("id") == "question_1"){
		prev_button.addClass("disabled");
		prev_button.unbind("click");
	} else {
		prev_button.removeClass("disabled");
		prev_button.unbind("click");
		prev_button.click(prevclickfun);
	}
	
}

loadQuestion = function(question_id){
	
	data = {
		question_id: question_id,
		ajax: true
	};
	url = "{url url='/question/view' ajax=1}";
	{literal}
	$('#questions-container').load(url, data, function(){$(this).fadeIn('slow')}).hide();
	{/literal}	
}

openSubmitModal = function(){
	$("#quiz-submit").modal();
}

submitQuiz = function(){
	submitQuestion();
	
	index_url = '{url url="/quiz/submit/$quiz_id"}';
	window.location.href = index_url;
	
}

$(document).ready(function(){
	//var question_ids = {$question_ids_json};
	//var question_ids = eval($('#question_ids').val());
	prev_button = $('#quiz-controls .btn-group button[name=prev]');
	next_button = $('#quiz-controls .btn-group button[name=next]');
	prev_button.addClass("disabled");
	
	current_item = $('#question_1');
	current_item.addClass("active");
	
	prevclickfun = function(e){
		submitQuestion();
		
		prev_item = current_item.prev("button");
		prev_item_question_id = prev_item.attr("name");
		
		loadQuestion(prev_item_question_id);
		
		current_item.removeClass("active");
		current_item = prev_item;
		current_item.addClass("active");
		if(current_item.attr("id") == "question_1"){
			prev_button.addClass("disabled");
			prev_button.unbind("click");
		} 
	};


	//load the first question...
	var current_question_id = current_item.attr("name");
	loadQuestion(current_question_id);
	// add the click listener for the numbered buttons
	$('#quiz-controls .btn-group[name=question_numbers] button').click(function(e){
		submitQuestion();
		
		this_question_button = $(e.currentTarget);
		this_question_id = this_question_button.attr("name");
		
		// only perform the actions if the button is not already active
		if(!this_question_button.hasClass("active")){
			loadQuestion(this_question_id);
			current_item.removeClass("active");
			current_item = this_question_button;
			current_item.addClass("active");
			if(current_item.attr("id") == "question_1"){
				prev_button.addClass("disabled");
				prev_button.unbind("click");
			} else {
				prev_button.removeClass("disabled");
				prev_button.unbind("click");
				prev_button.click(prevclickfun);
			}
		}
		
	});
		
	//prev_button.click(prevclickfun);
	

	next_button.click(function(e){
		submitQuestion(continueNext);
		

	});
	
	$("#quiz-submit-btn").click(openSubmitModal);
	$("#quiz-submit-confirm-btn").click(submitQuiz);

});
</script>