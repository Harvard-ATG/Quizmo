<ul class="breadcrumb">
  <li>
    <a href='{url url="/quiz/index/$collection_id"}'>Quizzes</a> <span class="divider">/</span>
  </li>
  <li class="active">Edit Quiz</li>
</ul>

<form id="quiz-form" class="form-horizontal row-fluid isites-form" action="/quiz/create/{$collection_id}/{$quiz_id}">
	<fieldset>
		{if $quiz_id == ''}
			<legend>Create Quiz</legend>
		{else}
			<legend>Edit Quiz</legend>
		{/if}
		
		{include file = 'protected/views/quiz/_form.tpl'
			collection_id = $collection_id
			title = $title
			description = $description
			state = $state
			start_date = $start_date
			end_date = $end_date
			visibility = $visibility
			show_feedback = $show_feedback
			quiz_id = $quiz_id
		}
	</fieldset>
</form>

<script>
{literal}
$(document).ready(function(){
		
	$('#quiz-form_default').submit(function() {
		// validate data
		if ($("input:#title").val() == "") {
			$("#title-control-group p.help-inline").text("Error: title required").show();
			$("#title-control-group").addClass("error");
			return false;
		} else {
			$("#title-control-group p.help-inline").text("").show();			
			$("#title-control-group").removeClass("error");
		}

	  return true;
	});
	

	$("input:radio[name='quiz_stateValue']").change(function(){
		selected_state = $("input[name='quiz_stateValue']:checked").val();
		if(selected_state == 'S'){
			//console.log("SCHEDULED");
			// show the dates
			$("#scheduling").fadeIn(500);
		} else {
			$("#scheduling").fadeOut(500);			
		}
	});
	
	$("#start_date").datepicker();
	$("#end_date").datepicker();
		

});
{/literal}
</script>
