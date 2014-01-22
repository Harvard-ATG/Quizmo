<div id="title-control-group" class="control-group">
	<label class="control-label" for="title">Title</label>
	<div class="controls">
		<input type="text" class="input-xlarge" id="title" name="title" value="{if $question}{$question.title}{/if}"/>
		<p class="help-inline"></p>
	</div>
</div>

<div id="fill-in-control-group" class="fill-in-control-group control-group hidden">
	<label class="control-label" for="numerical">Fill in the blank answer</label>
	<div class="controls">
		<p class="help-inline">
			{literal}
			<p>To create blanks, place curly braces around words. For example:</p>
			<p>Roses are {red} and violets are {blue}.</p>
			<p>Separate multiple correct answers with a pipe (|) symbol:</p>
			<p>Roses are {red|scarlet} and violets are {blue|azure}</p>
			{/literal}
		</p>
	</div>
</div>

<div id="body-control-group" class="control-group">
	<label class="control-label" for="body">Question</label>
	<div class="controls">
		<!--
		<div id="question-body-div" name="body" rows="5" class="hide"><img src="http://blog.wsd.net/teschriver/files/2012/09/test1.jpg"></div>
		-->
		<textarea id="question-body" name="body" rows="5" style="height:300px; width: 500px">{if $question}{$question.body}{/if}</textarea>
		<p class="help-inline"></p>
	</div>
</div>

<div id="fill-in-control-group" class="fill-in-control-group control-group hidden">
	<div class="controls">
		<label class="checkbox inline" style="white-space:nowrap;">
			<input type="checkbox" id="is_case_sensitive" name="is_case_sensitive" value="1" {if isset($question.answers[0].is_case_sensitive)}{if $question.answers[0].is_case_sensitive == 1}checked="checked"{/if}{/if}/> Case sensitive?
		</label>
	</div>
</div>

<div id="question_type-control-group" class="control-group">
	<p class="help-block"></p>
	<div class="btn-group" data-toggle="buttons-radio">
		<button type="button" id="question-type-multiple" class="btn question_type_btn" title="Students choose one of several answer choices. Only one choice is correct.">Multiple Choice</button>
		<button type="button" id="question-type-truefalse" class="btn question_type_btn" title='Students choose either "True" or "False".'>True False</button>
		<button type="button" id="question-type-checkall" class="btn question_type_btn" title="Students choose more than one of several answer choices.">Check all that apply</button>
		<button type="button" id="question-type-essay" class="btn question_type_btn" title="Students compose their own answer to a question. These questions must be manually graded.">Essay</button>
		<button type="button" id="question-type-numerical" class="btn question_type_btn" title="Students enter their answers in numeric form. A range of values may be accepted as correct.">Numerical</button>
		<button type="button" id="question-type-fillin" class="btn question_type_btn" title="Students fill in answer blanks in a block of text. Each blank may have more than one correct answer.">Fill in the blank</button>
		<input type="hidden" id="question_type" name="question_type" value=""/>
	</div>
</div>





<div id="multiple-choice-control-group" class="control-group hidden">
	<label class="control-label" for="state">Multiple Choice Answers</label>
	<p class="help-inline"></p>
	<div id="multiple-choice-control-group-inner">
	{if isset($question.answers)}
		{foreach from=$question.answers item=answer name=answers}
		{assign iteration $smarty.foreach.answers.iteration}
		<div class="controls">
			<label class="radio inline">
				<input type="radio" id="multiple_radio_answer{$iteration - 1}" name="multiple_radio_answer" value="{$iteration - 1}" {if isset($answer.is_correct)}{if $answer.is_correct == 1}checked="checked"{/if}{/if}/>
			</label>
				<input type="text" id="multiple_answer{$iteration - 1}" name="multiple_answer{$iteration - 1}" value="{$answer.answer}"/>
		</div>		
		{/foreach}
	{else}
	<div class="controls">
		<label class="radio inline">
			<input type="radio" id="multiple_radio_answer0" name="multiple_radio_answer" value="0"/>
		</label>
			<input type="text" id="multiple_answer0" name="multiple_answer0"/>
	</div>
	<div class="controls">
		<label class="radio inline">
			<input type="radio" id="multiple_radio_answer1" name="multiple_radio_answer" value="1"/>
		</label>
			<input type="text" id="multiple_answer1" name="multiple_answer1"/>
	</div>
	<div class="controls">
		<label class="radio inline">
			<input type="radio" id="multiple_radio_answer2" name="multiple_radio_answer" value="2"/>
		</label>
			<input type="text" id="multiple_answer2" name="multiple_answer2"/>
	</div>
	{/if}
	</div>
	<div class="controls">
		<button type="button" id="add-multiple-answer" class="btn">Add an answer</button>
		<button type="button" id="remove-multiple-answer" class="btn">Remove an answer</button>
	</div>	
</div>

<script>
//<![CDATA[
$(document).ready(function(){
	$('#add-multiple-answer').click(function(){
		// get the number of radios in there...
		current_index = $('#multiple-choice-control-group input[type=radio]').length;
		// add a new item
		// this needs to be conditional based on if it's isites
		{if true}
		$('#multiple-choice-control-group-inner').append('<div class="controls"> '+
		'<label class="radio inline"> '+
		'<input type="radio" id="multiple_radio_answer'+current_index+'" name="multiple_radio_answerValue" value="'+current_index+'" /> '+
		'<input value="multiple_radio_answer" name="inputField" type="hidden"> '+
		'</label> '+
		'<input type="text" id="multiple_answer'+current_index+'" name="multiple_answer'+current_index+'Value"/> '+
		'<input value="multiple_answer'+current_index+'" name="inputField" type="hidden"> '+
		'<p class="help-inline"></p> '+
		'</div> ');
		{else}
		$('#multiple-choice-control-group-inner').append('<div class="controls"> '+
		'<label class="radio inline"> '+
		'<input type="radio" id="multiple_radio_answer1" name="multiple_radio_answer" value="iteration" /> '+
		'</label> '+
		'<input type="text" id="multiple_answer'+current_index+'" name="multiple_answer'+current_index+'"/> '+
		'</div>');		
		{/if}
	});
	
	$('#remove-multiple-answer').click(function(){
		// get the number of radios in there...
		current_index = $('#multiple-choice-control-group input[type=radio]').length;
		// remove the last added
		$('#multiple-choice-control-group-inner div.controls:last').remove();
	
	});
	
});
//]]>
</script>

<div id="true-false-control-group" class="control-group hidden">
	<label class="control-label" for="state">True/False Answers</label>
	{if isset($question.answers)}
		{foreach from=$question.answers item=answer name=answers}
		{assign iteration $smarty.foreach.answers.iteration}
		<div class="controls">
			<label class="radio inline">
				<input type="radio" id="true_false_answer{$iteration - 1}" name="truefalse" value="{if $answer.answer == 'True'}1{else}0{/if}" {if isset($answer.is_correct)}{if $answer.is_correct == 1}checked="checked"{/if}{/if}/>{$answer.answer}
			</label>
				<p class="help-inline"></p>
		</div>
		{/foreach}
	{else}
	<div class="controls">
		<label class="radio">
			<input type="radio" id="true_false_answer0" name="truefalse" value="true" checked="checked"/> True
			<p class="help-inline"></p>
		</label>
	</div>
	<div class="controls">
		<label class="radio">
			<input type="radio" id="true_false_answer1" name="truefalse" value="false"/> False
			<p class="help-inline"></p>
		</label>
		<p class="help-block"></p>
	</div>
	{/if}
</div>

<div id="check-all-control-group" class="control-group hidden">
	<label class="control-label" for="check-all">Check All Answers</label>
	<p class="help-inline"></p>
	<div id="check-all-control-group-inner">
	{if isset($question.answers)}
		{foreach from=$question.answers item=answer name=answers}
		{assign iteration $smarty.foreach.answers.iteration}
		<div class="controls">
			<label class="checkbox inline">
				<input type="checkbox" id="check_all_check_answer{$iteration - 1}" name="check_all_check_answer{$iteration - 1}" value="iteration" {if isset($answer.is_correct)}{if $answer.is_correct == 1}checked="checked"{/if}{/if}/>
			</label>
				<input type="text" id="check_all_answer{$iteration - 1}" name="check_all_answer{$iteration - 1}" value="{$answer.answer}"/>
		</div>			
		{/foreach}
	{else}
	<div class="controls">
		<label class="checkbox inline">
			<input type="checkbox" id="check_all_check_answer0" name="check_all_check_answer0" value="1"/>
		</label>
			<input type="text" id="check_all_answer0" name="check_all_answer0"/>
	</div>
		
	<div class="controls">
		<label class="checkbox inline">
			<input type="checkbox" id="check_all_check_answer1" name="check_all_check_answer1" value="1"/>
		</label>
			<input type="text" id="check_all_answer1" name="check_all_answer1"/>
	</div>
		
	<div class="controls">
		<label class="checkbox inline">
			<input type="checkbox" id="check_all_check_answer2" name="check_all_check_answer2" value="1"/>
		</label>
			<input type="text" id="check_all_answer2" name="check_all_answer2"/>
	</div>
	{/if}
	</div>
	<div class="controls">
		<button type="button" id="add-check-all-answer" class="btn">Add an answer</button>
		<button type="button" id="remove-check-all-answer" class="btn">Remove an answer</button>
	</div>
</div>
<script>
//<![CDATA[
$(document).ready(function(){
	$('#add-check-all-answer').click(function(){
		// get the number of radios in there...
		current_index = $('#check-all-control-group input[type=checkbox]').length;
		// add a new item
		// this needs to be conditional based on if it's isites
		{if true}
		$('#check-all-control-group-inner').append('<div class="controls"> '+
		'<label class="checkbox inline"> '+
		'<input type="checkbox" id="check_all_check_answer'+current_index+'" name="check_all_check_answer'+current_index+'Value" value="'+current_index+'" /> '+
		'<input value="check_all_check_answer'+current_index+'" name="inputField" type="hidden"> '+
		'</label> '+
		'<input type="text" id="check_all_answer'+current_index+'" name="check_all_answer'+current_index+'Value"/> '+
		'<input value="check_all_answer'+current_index+'" name="inputField" type="hidden"> '+
		'<p class="help-inline"></p> '+
		'</div>');
		{else}
		$('#check-all-control-group-inner').append('<div class="controls"> '+
		'<label class="checkbox inline"> '+
		'<input type="checkbox" id="check_all_check_answer'+current_index+ '" name="check_all_check_answer'+current_index+'" value="'+current_index+'" /> '+
		'</label> '+
		'<input type="text" id="check_all_answer'+current_index+'" name="check_all_answer'+current_index+'"/> '+
		'</div> ');		
		{/if}
	});
	
	$('#remove-check-all-answer').click(function(){
		// get the number of radios in there...
		current_index = $('#check-all-control-group input[type=checkbox]').length;
		// remove the last added
		$('#check-all-control-group-inner div.controls:last').remove();
	
	});
	
});
//]]>
</script>

<div id="essay-control-group" class="control-group hidden">
	<label class="control-label" for="essay">Text Field Size For Essay (Area where student will enter their essay text)</label>
	<div class="controls">
		Display <input type="text" class="span1" id="textarea_rows" name="textarea_rows" value="{if isset($question.answers[0].textarea_rows)}{$question.answers[0].textarea_rows}{/if}"/> rows in student response field.
		<p class="help-inline"></p>
	</div>	
</div>

<div id="numerical-control-group" class="control-group hidden">
	<p class="help-inline">Set the answer and the tolerance in the fields below. Tolerance is expressed as a number, not a percentage. For example, setting the answer to '50' and the tolerance to '5' indicates that any answer in the range 45-55 will be considered correct.</p>
	<label class="control-label" for="numerical">Numerical Answer</label>
	<div class="controls">
		<input type="text" class="span1" id="numerical_answer" name="numerical_answer" value="{if isset($question.answers)}{$question.answers[0].answer}{/if}"/>
	</div>
	<label class="control-label" for="numerical">Tolerance</label>
	<div class="controls">
		<input type="text" class="span1" id="tolerance" name="tolerance" value="{if isset($question.answers[0].tolerance)}{$question.answers[0].tolerance}{/if}"/>
		<p class="help-inline"></p>
	</div>

</div>









<div id="score-control-group" class="control-group">
	<label class="control-label" for="score">Score</label>
	<div class="controls">
		<input type="text" class="span1 input-xlarge" id="score" name="score" value="{if isset($question.points)}{$question.points}{/if}"/>
		<p class="help-inline">Points for essay questions must be manually assigned by the quiz administrator when they review results.</p>
	</div>
</div>
<div id="feedback-control-group" class="control-group">
	<label class="control-label" for="feedback">Feedback</label>
	<div class="controls">
		<textarea class="input-xlarge" id="feedback" name="feedback">{if isset($question.feedback)}{$question.feedback}{/if}</textarea>
		<p class="help-inline"></p>
	</div>
</div>