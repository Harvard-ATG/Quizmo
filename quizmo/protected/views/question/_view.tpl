<div id="question-quiz-view" class="well">
	<div class="lead">
		{if $question.question_type == 'F'}
			{fillin question=$question.body responses=$question.responses disabled=1}<br/>
			{if $show_feedback == 1}
			<div style="font-size: 10px; border: black solid 1px; border-radius: 5px; padding: 2px;">
				Correct answer:<br/>
				{fillin question=$question.body responses=$question.answers disabled=1}
			</div>
			{/if}
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
				<input type="radio" name="answer{$question.id}" value="{$question.answers[$key].id}" {if $question.answers[$key].response}checked="checked"{/if} disabled="disabled" />
				{if $show_feedback == 1}
					{if $question.answers[$key].is_correct == 1}
						{if $question.answers[$key].response}
							<i class="icon-tick"> </i>
							{else}
							<i class="icon-tick-grey"> </i>
						{/if}
					{else if $question.answers[$key].response}
						<i class="icon-cross"> </i>
					{else}
						<i class="icon-empty"> </i>
					{/if}  
				{/if} {$question.answers[$key].answer}

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
				<input type="checkbox" name="answer1" value="{$question.answers[$key].id}" {if $question.answers[$key].response}checked="checked"{/if} disabled="disabled">
				
				{if $show_feedback == 1}
					{if $question.answers[$key].is_correct == 1}
						{if $question.answers[$key].response}
							<i class="icon-tick"> </i>
							{else}
							<i class="icon-tick-grey"> </i>
						{/if}
					{else if $question.answers[$key].response}
						<i class="icon-cross"> </i>
					{else}
						<i class="icon-empty"> </i>
					{/if}  
				{/if} {$question.answers[$key].answer}
				</input>
			</label>
			{/foreach}
		</div>
	</div>


	{elseif $question.question_type == 'E'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<textarea id="essay-text" class="span12 input-xlarge disabled" rows="9" disabled="disabled">{$question.responses[0].response}</textarea>
		</div>
	</div>


	{elseif $question.question_type == 'N'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<input id="numerical-text" type="text" class="input-small disabled" value="{$question.responses[0].response}" disabled="disabled"/>
			{if $show_feedback == 1}
			<div style="font-size: 10px; border: black solid 1px; border-radius: 5px; padding: 2px;">
				Correct answer: {$question.answers[0].answer}<br/>
			</div>
			{/if}
		</div>
	</div>


	{elseif $question.question_type == 'F'}


	{else}
		ERROR!!!  Undefined question_type
	{/if}
	
</div>