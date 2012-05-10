<div id="title-control-group" class="control-group">
	<label class="control-label" for="title">Title</label>
	<div class="controls">
		<input type="text" class="input-xlarge" id="title" name="title" value="{$title}"/>
		<p class="help-inline"></p>
	</div>
</div>
<div id="body-control-group" class="control-group">
	<label class="control-label" for="body">Question</label>
	<div class="controls">
		<textarea class="input-xlarge" id="body" name="body">{$body}</textarea>
		<p class="help-inline"></p>
	</div>
</div>

<div id="question_type-control-group" class="control-group">
	<p class="help-block"></p>
	<div class="btn-group" data-toggle="buttons-radio">
		<button type="button" id="question-type-multiple" class="btn">Multiple-Choice</button>
		<button type="button" id="question-type-truefalse" class="btn">True False</button>
		<button type="button" id="question-type-checkall" class="btn">Check all that apply</button>
		<button type="button" id="question-type-essay" class="btn">Essay</button>
		<button type="button" id="question-type-numerical" class="btn">Numerical</button>
		<button type="button" id="question-type-fillin" class="btn">Fill in the blank</button>
		<input type="hidden" id="question_type" name="question_type" value=""/>
	</div>
</div>





<div id="multiple-choice-control-group" class="control-group hidden">
	<label class="control-label" for="state">Multiple Choice Answers</label>
	<div class="controls">
		<label class="radio inline">
			<input type="radio" id="multiple_radio_answer1" name="multiple_radio_answer" value="0"/>
		</label>
			<input type="text" id="multiple_answer0" name="multiple_answer1"/>
			<p class="help-inline"></p>
	</div>
	<div class="controls">
		<label class="radio inline">
			<input type="radio" id="multiple_radio_answer2" name="multiple_radio_answer" value="1"/>
		</label>
			<input type="text" id="multiple_answer1" name="multiple_answer2"/>
			<p class="help-inline"></p>
	</div>
	<div class="controls">
		<label class="radio inline">
			<input type="radio" id="multiple_radio_answer2" name="multiple_radio_answer" value="2"/>
		</label>
			<input type="text" id="multiple_answer2" name="multiple_answer3"/>
			<p class="help-inline"></p>
		<p class="help-block"></p>
	</div>
</div>

<div id="true-false-control-group" class="control-group hidden">
	<label class="control-label" for="state">True/False Answers</label>
	<div class="controls">
		<label class="radio">
			<input type="radio" id="true_answer" name="truefalse" value="true"/> True
			<p class="help-inline"></p>
		</label>
	</div>
	<div class="controls">
		<label class="radio">
			<input type="radio" id="false_answer" name="truefalse" value="false"/> False
			<p class="help-inline"></p>
		</label>
		<p class="help-block"></p>
	</div>
</div>

<div id="check-all-control-group" class="control-group hidden">
	<label class="control-label" for="check-all">Check All Answers</label>
	<div class="controls">
		<label class="checkbox inline">
			<input type="checkbox" id="check_all_check_answer1" name="check_all_check_answer1" value="1"/>
		</label>
			<input type="text" id="check_all_answer0" name="check_all_answer1"/>
			<p class="help-inline"></p>
	</div>
		
	<div class="controls">
		<label class="checkbox inline">
			<input type="checkbox" id="check_all_check_answer2" name="check_all_check_answer2" value="2"/>
		</label>
			<input type="text" id="check_all_answer1" name="check_all_answer2"/>
			<p class="help-inline"></p>
	</div>
		
	<div class="controls">
		<label class="checkbox inline">
			<input type="checkbox" id="check_all_check_answer3" name="check_all_check_answer3" value="3"/>
		</label>
			<input type="text" id="check_all_answer2" name="check_all_answer3"/>
			<p class="help-inline"></p>
	</div>
</div>

<div id="essay-control-group" class="control-group hidden">
	<p>I don't think an essay needs anything else...</p>
</div>

<div id="numerical-control-group" class="control-group hidden">
	<label class="control-label" for="numerical">Numerical Answer</label>
	<div class="controls">
		<input type="text" class="span1" id="numerical_answer" name="numerical_answer" value="{*$numerical_answer*}"/>
		<p class="help-inline"></p>
	</div>
	<label class="control-label" for="numerical">Upper Bound</label>
	<div class="controls">
		<input type="text" class="span1" id="numerical_upper_bound" name="numerical_upper_bound" value="{*$numerical_upper_bound*}"/>
		<p class="help-inline"></p>
	</div>
	<label class="control-label" for="numerical">Lower Bound</label>
	<div class="controls">
		<input type="text" class="span1" id="numerical_lower_bound" name="numerical_lower_bound" value="{*$numerical_lower_bound*}"/>
		<p class="help-inline"></p>
	</div>
</div>

<div id="fill-in-control-group" class="control-group hidden">
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







<div id="score-control-group" class="control-group">
	<label class="control-label" for="score">Score</label>
	<div class="controls">
		<input type="text" class="span1 input-xlarge" id="score" name="score" value="{*$score*}"/>
		<p class="help-inline"></p>
	</div>
</div>
<div id="feedback-control-group" class="control-group">
	<label class="control-label" for="feedback">Feedback</label>
	<div class="controls">
		<textarea class="input-xlarge" id="feedback" name="feedback">{*$feedback*}</textarea>
		<p class="help-inline"></p>
	</div>
</div>




<script>



$(document).ready(function(){
	



});

</script>