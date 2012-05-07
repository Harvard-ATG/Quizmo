<form id="question-form" class="form-horizontal row-fluid" action="/question/create" method="post">
	<fieldset>
		<legend>Create Question</legend>

		<?php echo $this->renderPartial('_form', array(
			'quiz_id'=>$quiz_id,
			'title'=>$title, 
			'body'=>$body,
			'question_type'=>$question_type,
		)); ?>
	</fieldset>
</form>


<script>
$(document).ready(function(){

	$('#question-form').submit(function() {
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

	  return returnval;
	});


	$('#question-type-multiple').click(function(){
		$('#multiple-choice-control-group').removeClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
	});
	$('#question-type-truefalse').click(function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').removeClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
	});
	$('#question-type-checkall').click(function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').removeClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
	});
	$('#question-type-essay').click(function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').removeClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
	});
	$('#question-type-numerical').click(function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').removeClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
	});
	$('#question-type-fillin').click(function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').removeClass('hidden');
	});




});
</script>
