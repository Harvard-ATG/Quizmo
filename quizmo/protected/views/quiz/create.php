<form id="collection-form" class="form-horizontal row-fluid" action="/collection/create" method="post">
	<fieldset>
		<legend>Create Quiz</legend>

		<?php echo $this->renderPartial('_form', array('title'=>'', 'description'=>'', 'state'=>$state, 'start_date'=>$start_date, 'end_date'=>$end_date,)); ?>
	</fieldset>
</form>


<script>
$(document).ready(function(){
	
	$('#quiz-form').submit(function() {
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
