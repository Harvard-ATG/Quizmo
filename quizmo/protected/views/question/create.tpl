<ul class="breadcrumb">
  <li>
    <a href="/quiz/index/{$collection_id}">Quizzes</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="/question/index/{$quiz_id}">Questions</a> <span class="divider">/</span>
  </li>
  <li class="active">Edit Question</li>
</ul>

<form id="question-form" class="form-horizontal row-fluid isites-form" action="/question/create/{$quiz_id}/{$question_id}">
	<fieldset>
		<legend>Edit Question</legend>
		
		{include file='protected/views/question/_form.tpl'
			quiz_id = $quiz_id
			title = $title
			body = $body
			question_type = $question_type
			question_id = $question_id
			question = $question
		}
		
		<input type="hidden" id="quiz_id" name="quiz_id" value="{$quiz_id}"/>

		<div class="form-actions">
			<button id="question-submit" type="submit" class="btn btn-primary">Submit</button>
			<a class="btn" href="/question/index/<?php echo $quiz_id; ?>">Cancel</a>
		</div>
		
	</fieldset>

</form>


<script>
$(document).ready(function(){
		
	question_type = '{if $question}{$question.question_type}{/if}';		
	

	$('#question-form').submit(function() {
		//alert("asdf");
		returnval = true;
		// validate data

		if ($("input:#title").val() == "") {
			$("#title-control-group p.help-inline").text("Error: title required").show();
			$("#title-control-group").addClass("error");
			returnval = false;
		} else {
			$("#title-control-group p.help-inline").text("").show();			
			$("#title-control-group").removeClass("error");
		}

		if ($("textarea:#body").val() == "") {
			$("#body-control-group p.help-inline").text("Error: question required").show();
			$("#body-control-group").addClass("error");
			returnval = false;
		} else {
			$("#body-control-group p.help-inline").text("").show();			
			$("#body-control-group").removeClass("error");
		}

		if ($("input:#question_type").val() == "") {
			$("#question_type-control-group p.help-block").text("Error: question type required").show();
			$("#question_type-control-group").addClass("error");
			returnval = false;
		} else {
			$("#question_type-control-group p.help-block").text("").show();			
			$("#question_type-control-group").removeClass("error");

			if($("input:#question_type").val() == "multiple"){
				if($("input:radio[name=multiple_radio_answer]:checked").val() == ''){
					$("#multiple-choice-control-group p.help-inline").text("Error: multiple choice correct answer required").show();
					$("#multiple-choice-control-group").addClass("error");
					returnval = false;					
				} else {
					multival = $("input:radio[name=multiple_radio_answer]:checked").val();
					if($("input:#multiple_answer" + multival).val() == ''){
						$("#multiple-choice-control-group p.help-inline").text("Error: multiple choice needs an answer").show();
						$("#multiple-choice-control-group").addClass("error");
						returnval = false;											
					} else {
						$("#multiple-choice-control-group p.help-inline").text("").show();			
						$("#multiple-choice-control-group").removeClass("error");					
					}
				}
				

			}



		}




	  return returnval;
	});
	
	
	// functions for showing the question types
	showMultipleChoice = function(){
		$('#multiple-choice-control-group').removeClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("multiple");
		$('#question-type-multiple').addClass('active');	
	}
	showTrueFalse = function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').removeClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("truefalse");		
		$('#question-type-truefalse').addClass('active');	
	}
	showCheckAll = function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').removeClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("checkall");		
		$('#question-type-checkall').addClass('active');	
	}
	showEssay = function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').removeClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("essay");		
		$('#question-type-essay').addClass('active');	
	}
	showNumerical = function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').removeClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("numerical");		
		$('#question-type-numerical').addClass('active');	
	}
	showFillin = function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').removeClass('hidden');
		$('#question_type').val("fillin");		
		$('#question-type-fillin').addClass('active');	
	}

	if(question_type == ''){
		// if it's new
		// set the buttons
		$('#question-type-multiple').click(showMultipleChoice);
		$('#question-type-truefalse').click(showTrueFalse);
		$('#question-type-checkall').click(showCheckAll);
		$('#question-type-essay').click(showEssay);
		$('#question-type-numerical').click(showNumerical);
		$('#question-type-fillin').click(showFillin);
	} else {
		// set the show if it's an edit
		if(question_type == 'M'){
			showMultipleChoice();
		}
		if(question_type == 'T'){
			showTrueFalse();
		}
		if(question_type == 'S'){
			showCheckAll();
		}
		if(question_type == 'E'){
			showEssay();
		}
		if(question_type == 'N'){
			showNumerical();
		}
		if(question_type == 'F'){
			showFillin();
		}
	}
	

});
</script>
