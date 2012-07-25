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
{if isset($collection_id)}
<ul class="breadcrumb">
  <li>
    <a href="/quiz/index/{$collection_id}">Quizzes</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="/question/index/{$quiz_id}">Questions</a> <span class="divider">/</span>
  </li>
  <li class="active">{$question['title']}</li>
</ul>
{/if}

<h3>
	{$question['title']}
</h3>

<div id="question-quiz-view">
	<div class="lead">
		{if $question.question_type == 'F'}
			{fillin question=$question.body responses=$question.responses}
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
				<input type="radio" id="answer{$question.answers[$key].id}" name="answer1" value="{$question.answers[$key].id}" {if $question.answers[$key].response}checked="checked"{/if}>
					{$question.answers[$key].answer}
				</input>
			</label>
			{/foreach}
		</div>
	</div>
	<script>
		submitQuestion = function(){
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
				<input type="checkbox" name="answer1" value="{$question.answers[$key].id}" {if $question.answers[$key].response}checked="checked"{/if}>
					{$question.answers[$key].answer}
				</input>
			</label>
			{/foreach}
		</div>
	</div>
	<script>
		submitQuestion = function(){
			// get the answers
			answers = [];
			$('input[type=checkbox]').each(function () {
				//if (this.checked) {
				if ($(this).attr('checked')) {
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
			<textarea id="essay-text" class="span10 input-xlarge" rows="9">{if isset($question.responses[0])}{$question.responses[0].response}{/if}</textarea>
		</div>
	</div>
	<script>
		submitQuestion = function(){
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
			<input id="numerical-text" type="text" class="input-small" value="{if isset($question.responses[0])}{$question.responses[0].response}{/if}"/>
		</div>
	</div>
	<script>
		submitQuestion = function(){
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
			// get the answer
			answers = [];
			$('.fillin-text').each(function () {
				answers.push($(this).val());
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

	{else}
		ERROR!!!  Undefined question_type
	{/if}
	
</div>
