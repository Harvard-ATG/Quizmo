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

});
</script>
