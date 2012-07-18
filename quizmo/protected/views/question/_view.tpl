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
				<input type="radio" id="answer{$question.answers[$key].id}" name="answer{$question.id}" value="{$question.answers[$key].id}" {if $question.answers[$key].is_correct}checked{/if}>
					{$question.answers[$key].answer} {$question.answers[$key].is_correct} 
				</input>
			</label>
			{/foreach}
		</div>
	</div>

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


	{elseif $question.question_type == 'E'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<textarea id="essay-text" class="input-xlarge" rows="9"></textarea>
		</div>
	</div>


	{elseif $question.question_type == 'N'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<input id="numerical-text" type="text" class="input-xlarge"/>
		</div>
	</div>


	{elseif $question.question_type == 'F'}


	{else}
		ERROR!!!  Undefined question_type
	{/if}
	
</div>