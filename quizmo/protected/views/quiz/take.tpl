<div class="row-fluid">
	<h1 class="span12">Taking the quiz</h1>
</div>

<div id="questions-container" class="span12 row-fluid">


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

<input type="hidden" id="question_ids" value='{$question_ids_json}'/>

<script>
submitQuestion = function(){
	console.log("ERROR: submitting blank!");
}

$(document).ready(function(){
	//var question_ids = {$question_ids_json};
	//var question_ids = eval($('#question_ids').val());
	var prev_button = $('#quiz-controls .btn-group button[name=prev]');
	var next_button = $('#quiz-controls .btn-group button[name=next]');
	prev_button.addClass("disabled");
	
	var current_item = $('#question_1');
	current_item.addClass("active");
	
	//load the first question...
	var current_question_id = current_item.attr("name");
	$('#questions-container').load(url('/question/view/' + current_question_id));
	
	// add the click listener for the numbered buttons
	$('#quiz-controls .btn-group[name=question_numbers] button').click(function(e){
		submitQuestion();
		
		this_question_button = $(e.currentTarget);
		this_question_id = this_question_button.attr("name");
		
		// only perform the actions if the button is not already active
		if(!this_question_button.hasClass("active")){
			$('#questions-container').load('/question/view/' + this_question_id);
			current_item.removeClass("active");
			current_item = this_question_button;
			current_item.addClass("active");
			if(current_item.attr("id") == "question_1"){
				console.log(current_item.attr("id") + "bam?");
				prev_button.addClass("disabled");
			} else {
				prev_button.removeClass("disabled");
			}
		}
		
	});
	
	prev_button.click(function(e){
		submitQuestion();
		
		prev_item = current_item.prev("button");
		prev_item_quesion_id = prev_item.attr("name");
		$('#questions-container').load('/question/view/' + prev_item_quesion_id);
		
		current_item.removeClass("active");
		current_item = prev_item;
		current_item.addClass("active");
		if(current_item.attr("id") == "question_1"){
			console.log(current_item.attr("id") + "bam?");
			prev_button.addClass("disabled");
		} else {
			prev_button.removeClass("disabled");
		}

	});

	next_button.click(function(e){
		submitQuestion();
		
		next_item = current_item.next("button");
		next_item_quesion_id = next_item.attr("name");
		$('#questions-container').load('/question/view/' + next_item_quesion_id);
		
		current_item.removeClass("active");
		current_item = next_item;
		current_item.addClass("active");
		if(current_item.attr("id") == "question_1"){
			console.log(current_item.attr("id") + "bam?");
			prev_button.addClass("disabled");
		} else {
			prev_button.removeClass("disabled");
		}
		
	});

});
</script>