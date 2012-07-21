<div id="question-quiz-view" class="well" style="height: 200px">
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
				<input type="radio" id="answer{$question.answers[$key].id}" name="answer{$question.id}" value="{$question.answers[$key].id}" {if $question.answers[$key].response}checked="checked"{/if}>
					{$question.answers[$key].answer} {if $question.answers[$key].is_correct == 1}<i class="icon-ok"></i>{/if} 
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
				<input type="checkbox" name="answer1" value="{$question.answers[$key].id}" {if $question.answers[$key].response}checked="checked"{/if}>
					{$question.answers[$key].answer} {if $question.answers[$key].is_correct == 1}<i class="icon-ok"></i>{/if} 
				</input>
			</label>
			{/foreach}
		</div>
	</div>


	{elseif $question.question_type == 'E'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<textarea id="essay-text" class="input-xlarge" rows="9">{$question.responses[0].response}</textarea>
		</div>
	</div>


	{elseif $question.question_type == 'N'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<input id="numerical-text" type="text" class="input-xlarge" value="{$question.responses[0].response}" />
		</div>
	</div>


	{elseif $question.question_type == 'F'}


	{else}
		ERROR!!!  Undefined question_type
	{/if}
	
</div>