<!--
id=>1
quiz_id=>1
question_type=>M
title=>Multiple Choice Question 1
body=>Pick a number, any number
question_order=>1
points=>
feedback=>
deleted=>0
answers=>Array

answer[0]
id=>1
question_id=>1
question_type=>M
textarea_rows=>
answer=>A
is_case_sensitive=>
answer_order=>1
is_correct=>1
tolerance=>
-->

<!--
{foreach from=$question key=key item=value}
{$key}=>{$question.$key}<br/>
{/foreach}

{foreach from=$question.answers key=key item=value}
{$key}=>{$question.answers.$key}<br/>
{/foreach}

{foreach from=$question.answers[0] key=key item=value}
{$key}=>{$question.answers[0].$key}<br/>
{/foreach}
-->


<h3>
	{$question['title']}
</h3>

<div id="question-quiz-view" class="well" style="height: 200px">
	<div class="lead">
		{if $question.question_type == 'F'}
			{fillin question=$question.body}
		{else}
			{$question['body']}
		{/if}
	</div>
	
	{if $question.question_type == 'M' || $question.question_type == 'T'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			{foreach from=$question.answers key=key item=value}			
			<label class="radio">
				<input type="radio" id="answer{$question.answers[$key].id}" name="answer1" value="{$question.answers[$key].id}">
					{$question.answers[$key].answer}
				</input>
			</label>
			{/foreach}
		</div>
	</div>
	<script>
		submitQuestion = function(){
			console.log("M/T");
			// get value of radio
			answer_id = $('input:radio[name=answer1]:checked').val();
			// set data
			data = {
				question_id: '{$question.id}',
				question_type: '{$question.question_type}',
				answer_id: answer_id
			}
			// submit value via ajax
			$.ajax({
				type: 'POST',
				url: '/response/submitQuestion',
				data: data
				//success: success,
				//dataType: dataType
			});
		}
	</script>

	{elseif $question.question_type == 'S'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			{foreach from=$question.answers key=key item=value}			
			<label class="checkbox">
				<input type="checkbox" name="answer1" value="{$question.answers[$key].id}">
					{$question.answers[$key].answer}
				</input>
			</label>
			{/foreach}
		</div>
	</div>
	<script>
		submitQuestion = function(){
			console.log("S");
			// get the answers
			answers = [];
			$('input[type=checkbox]').each(function () {
				if (this.checked) {
					answers.push($(this).val());
				}
			});
			// set the data
			data = {
				question_id: '{$question.id}',
				question_type: '{$question.question_type}',
				answers: answers
			}
			// send the ajax
			$.ajax({
				type: 'POST',
				url: '/response/submitQuestion',
				data: data
			});
		}
	</script>

	{elseif $question.question_type == 'E'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<textarea id="essay-text" class="input-xlarge" rows="9"></textarea>
		</div>
	</div>
	<script>
		submitQuestion = function(){
			console.log("E");
			// get the answer
			answer = $('#essay-text').val();
			// set the data
			data = {
				question_id: '{$question.id}',
				question_type: '{$question.question_type}',
				answer: answer
			}
			// send the ajax
			$.ajax({
				type: 'POST',
				url: '/response/submitQuestion',
				data: data
			});
		}
	</script>

	{elseif $question.question_type == 'N'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<input id="numerical-text" type="text" class="input-xlarge"/>
		</div>
	</div>
	<script>
		submitQuestion = function(){
			console.log("N");
			// get the answer
			answer = $('#numerical-text').val();
			// set the data
			data = {
				question_id: '{$question.id}',
				question_type: '{$question.question_type}',
				answer: answer
			}
			// send the ajax
			$.ajax({
				type: 'POST',
				url: '/response/submitQuestion',
				data: data
			});
		}
	</script>

	{elseif $question.question_type == 'F'}
	<script>
		submitQuestion = function(){
			console.log("F");
		}
	</script>

	{else}
		ERROR!!!  Undefined question_type
	{/if}
	
</div>
