<form id="quiz-form" class="form-horizontal row-fluid isites-form" action="/quiz/create">
	<fieldset>
		<legend>Create Quiz</legend>

		<?php echo $this->renderPartial('_form', array('collection_id'=>$collection_id, 'title'=>$title, 'description'=>$description, 'state'=>$state, 'start_date'=>$start_date, 'end_date'=>$end_date,)); ?>
	</fieldset>
</form>


<script>
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

});
</script>
