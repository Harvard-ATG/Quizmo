<div class="row-fluid">
	<h1 class="span12">Taking the quiz</h1>
</div>

<div id="questions-container" class="span12 row-fluid">


</div>

<div id="quiz-controls" class="btn-toolbar">
	<div class="btn-group">
		<button name="prev" type="button" class="btn">&lt;</button>	
	</div>
	<div class="btn-group">
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
	$('#questions-container').load('/question/view/' + current_question_id);
	
	

});
</script>