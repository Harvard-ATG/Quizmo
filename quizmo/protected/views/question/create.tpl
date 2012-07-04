<ul class="breadcrumb">
  <li>
    <a href="/quiz/index/{$quiz_id}">Quiz</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="/question/index/{$quiz_id}">Questions</a> <span class="divider">/</span>
  </li>
  <li class="active">Edit Question</li>
</ul>

<div class="row-fluid">
	<h1 class="span12">Questions</h1>
</div>

<form id="question-form" class="form-horizontal row-fluid isites-form" action="/question/create">
	<fieldset>
		<legend>Edit Question</legend>
		
		{include file='protected/views/question/_form.tpl'
			quiz_id = $quiz_id
			title = $title
			body = $body
			question_type = $question_type
			question_id = $question_id
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
		
	function blamo(){
		alert("blamo");
		
	}
		
	$('#question-form').bind('submit', function(){
		alert("submit");
		//return false;
	});
	$('#question-form').bind('onsubmit', function(){
		alert("onsubmit");
		return false;
	});

	$('#nononoquestion-form').submit(function() {
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


	$('#question-type-multiple').click(function(){
		//$('#multiple-choice-control-group').slideDown(10, easing).fadeTo(speed, 1, easing, callback);
		//$('#true-false-control-group').fadeTo(10, 0).slideUp(10);
		//$('#multiple-choice-control-group').slideDown(500).delay(200).fadeIn(500);

		$('#multiple-choice-control-group').removeClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("multiple");
	});
	$('#question-type-truefalse').click(function(){
		//$('#multiple-choice-control-group').fadeTo(10, 0).slideUp(10);
		//$('#true-false-control-group').slideDown(10).fadeTo(10, 1);

		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').removeClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("truefalse");
	});
	$('#question-type-checkall').click(function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').removeClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("checkall");
	});
	$('#question-type-essay').click(function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').removeClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("essay");
	});
	$('#question-type-numerical').click(function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').removeClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("numerical");
	});
	$('#question-type-fillin').click(function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').removeClass('hidden');
		$('#question_type').val("fillin");
	});




});
</script>
