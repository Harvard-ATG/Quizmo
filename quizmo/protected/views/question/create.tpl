<ul class="breadcrumb">
  <li>
    <a href='{url url="/quiz/index/$collection_id"}'>Quizzes</a> <span class="divider">/</span>
  </li>
  <li>
    <a href='{url url="/question/admindex/$quiz_id"}'>Questions</a> <span class="divider">/</span>
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
			<input id="question-submit" type="submit" class="btn btn-primary" value="Submit" />
			<a class="btn" href='{url url="/question/admindex/$quiz_id"}'>Cancel</a>
		</div>
		
	</fieldset>

</form>


<script>
$(document).ready(function(){
		
	var question_type = '{if isset($question.question_type)}{$question.question_type}{/if}';		
	var errors = {$error_json};
	
	// validation
	if(errors['no_title']){
		$("#title-control-group p.help-inline").text("Error: title required").show();
		$("#title-control-group").addClass("error");
	}
	if(errors['no_body']){
		$("#body-control-group p.help-inline").text("Error: question required").show();
		$("#body-control-group").addClass("error");
	}
	if(errors['no_question_type']){
		$("#question_type-control-group p.help-block").text("Error: question type required").show();
		$("#question_type-control-group").addClass("error");
	}
	if(errors['score_not_number']){
		$("#score-control-group p.help-inline").text("Error: score needs to be a number").show();
		$("#score-control-group").addClass("error");
	}
	
	if(errors['multiple_no_answer']){
		$("#multiple-choice-control-group p.help-inline").text("Error: multiple choice questions need at least one answer").show();
		$("#multiple-choice-control-group").addClass("error");		
	}
	if(errors['multiple_no_correct']){
		$("#multiple-choice-control-group p.help-inline").text("Error: multiple choice questions need a correct answer").show();
		$("#multiple-choice-control-group").addClass("error");		
	}
	if(errors['checkall_no_answer']){
		$("#check-all-control-group p.help-inline").text("Error: multiple selection questions need at least one answer").show();
		$("#check-all-control-group").addClass("error");		
	}
	if(errors['checkall_no_correct']){
		$("#check-all-control-group p.help-inline").text("Error: multiple selection questions need at least one correct answer").show();
		$("#check-all-control-group").addClass("error");		
	}
	
	if(errors['numerical_not_number']){
		$("#numerical-control-group .controls p.help-inline").text("Error: numerical question answers need to be a number").show();
		$("#numerical-control-group").addClass("error");				
	}
	if(errors['tolerance_not_number']){
		$("#numerical-control-group .controls p.help-inline").text("Error: numerical tolerance needs to be a number").show();
		$("#numerical-control-group").addClass("error");						
	}

	// NOTE: this does not work in isites, linking to the isites form submit does not work
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
		$('#question-type-multiple').removeClass('disabled');
		$('#question-type-checkall').removeClass('disabled');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("multiple");
		$('#question-type-multiple').addClass('active');

		$('#question-type-truefalse').css('visibility', 'hidden');
		//$('#question-type-checkall').css('visibility', 'hidden');
		$('#question-type-essay').css('visibility', 'hidden');
		$('#question-type-numerical').css('visibility', 'hidden');
		$('#question-type-fillin').css('visibility', 'hidden');

		$('#question-type-multiple').click(showMultipleChoice);
		$('#question-type-checkall').click(showCheckAll);
		//unbindAllTypes();
	}
	showTrueFalse = function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').removeClass('hidden');
		$('#question-type-truefalse').removeClass('disabled');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("truefalse");		
		$('#question-type-truefalse').addClass('active');	

		$('#question-type-multiple').css('visibility', 'hidden');
		$('#question-type-checkall').css('visibility', 'hidden');
		$('#question-type-essay').css('visibility', 'hidden');
		$('#question-type-numerical').css('visibility', 'hidden');
		$('#question-type-fillin').css('visibility', 'hidden');

		unbindAllTypes();
	}
	showCheckAll = function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').removeClass('hidden');
		$('#question-type-multiple').removeClass('disabled');
		$('#question-type-checkall').removeClass('disabled');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("checkall");		
		$('#question-type-checkall').addClass('active');	

		//$('#question-type-multiple').css('visibility', 'hidden');
		$('#question-type-truefalse').css('visibility', 'hidden');
		$('#question-type-essay').css('visibility', 'hidden');
		$('#question-type-numerical').css('visibility', 'hidden');
		$('#question-type-fillin').css('visibility', 'hidden');

		$('#question-type-multiple').click(showMultipleChoice);
		$('#question-type-checkall').click(showCheckAll);
		//unbindAllTypes();
	}
	showEssay = function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').removeClass('hidden');
		$('#question-type-essay').removeClass('disabled');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("essay");		
		$('#question-type-essay').addClass('active');	

		$('#question-type-multiple').css('visibility', 'hidden');
		$('#question-type-truefalse').css('visibility', 'hidden');
		$('#question-type-checkall').css('visibility', 'hidden');
		$('#question-type-numerical').css('visibility', 'hidden');
		$('#question-type-fillin').css('visibility', 'hidden');

		unbindAllTypes();
	}
	showNumerical = function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').removeClass('hidden');
		$('#question-type-numerical').removeClass('disabled');
		$('#fill-in-control-group').addClass('hidden');
		$('#question_type').val("numerical");		
		$('#question-type-numerical').addClass('active');	

		$('#question-type-multiple').css('visibility', 'hidden');
		$('#question-type-truefalse').css('visibility', 'hidden');
		$('#question-type-checkall').css('visibility', 'hidden');
		$('#question-type-essay').css('visibility', 'hidden');
		$('#question-type-fillin').css('visibility', 'hidden');

		unbindAllTypes();
	}
	showFillin = function(){
		$('#multiple-choice-control-group').addClass('hidden');
		$('#true-false-control-group').addClass('hidden');
		$('#check-all-control-group').addClass('hidden');
		$('#essay-control-group').addClass('hidden');
		$('#numerical-control-group').addClass('hidden');
		$('#fill-in-control-group').removeClass('hidden');
		$('#question-type-fillin').removeClass('disabled');
		$('#question_type').val("fillin");		
		$('#question-type-fillin').addClass('active');	
		
		$('#question-type-multiple').css('visibility', 'hidden');
		$('#question-type-truefalse').css('visibility', 'hidden');
		$('#question-type-checkall').css('visibility', 'hidden');
		$('#question-type-essay').css('visibility', 'hidden');
		$('#question-type-numerical').css('visibility', 'hidden');
		
		unbindAllTypes();
	}
	
	unbindAllTypes = function(){
		$('#question-type-multiple').unbind("click");
		$('#question-type-truefalse').unbind("click");
		$('#question-type-checkall').unbind("click");
		$('#question-type-essay').unbind("click");
		$('#question-type-numerical').unbind("click");
		$('#question-type-fillin').unbind("click");	
		
		/*
		$('#question-type-multiple').css('visibility', 'hidden');
		$('#question-type-truefalse').css('visibility', 'hidden');
		$('#question-type-checkall').css('visibility', 'hidden');
		$('#question-type-essay').css('visibility', 'hidden');
		$('#question-type-numerical').css('visibility', 'hidden');
		$('#question-type-fillin').css('visibility', 'hidden');
		*/
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
		
		$('#question-type-multiple').tooltip({
			//animation: true,
			html: true,
			placement: 'top',
			trigger: 'hover'
		});
		//$('#question-type-multiple').tooltip('show');
		$('#question-type-truefalse').tooltip({
			//animation: true,
			html: true,
			placement: 'top',
			trigger: 'hover'
		});
		//$('#question-type-truefalse').tooltip('show');
		$('#question-type-checkall').tooltip({
			//animation: true,
			html: true,
			placement: 'top',
			trigger: 'hover'
		});
		//$('#question-type-checkall').tooltip('show');
		$('#question-type-essay').tooltip({
			//animation: true,
			html: true,
			placement: 'top',
			trigger: 'hover'
		});
		//$('#question-type-essay').tooltip('show');
		$('#question-type-numerical').tooltip({
			//animation: true,
			html: true,
			placement: 'top',
			trigger: 'hover'
		});
		//$('#question-type-numerical').tooltip('show');
		$('#question-type-fillin').tooltip({
			//animation: true,
			html: true,
			placement: 'top',
			trigger: 'hover'
		});
		//$('#question-type-fillin').tooltip('show');
		
	} else {
		// set the show if it's an edit
		$(".question_type_btn").addClass("disabled");
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
	
	$('#question-body').wysihtml5({
		"font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
		"emphasis": true, //Italics, bold, etc. Default true
		"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
		"html": false, //Button which allows you to edit the generated HTML. Default false
		"link": true, //Button to insert a link. Default true
		"image": true, //Button to insert an image. Default true,
		"color": false //Button to change color of font  
	});
	

});
</script>
