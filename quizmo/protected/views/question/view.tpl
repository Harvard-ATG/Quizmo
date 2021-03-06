{if !$isajax}
<ul class="breadcrumb">
  <li>
    <a href='{url url="/quiz/index/$collection_id"}'>Quizzes</a> <span class="divider">/</span>
  </li>
  <li>
    <a href='{url url="/question/index/$quiz_id"}'>Questions</a> <span class="divider">/</span>
  </li>
  <li class="active">{$question['title']}</li>
</ul>
{/if}

<h3>
	{$question['title']}
	<input type="hidden" id="question-id" value="{$question.id}"/>
	<input type="hidden" id="question-type" value="{$question.question_type}"/>
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
		submitQuestion = function(callback){
			// get value of radio
			answer_id = $('input:radio[name=answer1]:checked').val();
			// set data
			data = {
				question_id: '{$question.id}',
				question_type: '{$question.question_type}',
				answer_id: answer_id
			}
			// submit value via ajax
			submit_url = "{url url='/response/submitQuestion' ajax=1}";
			$.ajax({
				type: 'POST',
				url: submit_url,
				data: data,
				complete: callback
				//success: success,
				//dataType: dataType
			});
			return true;
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
		submitQuestion = function(callback){
			// get the answers
			var answers = [];
			$('input[type=checkbox]').each(function (key, item) {
				//if (this.checked) {
				if ($(item).is(':checked')) {
					answers.push($(item).val());
				}
			});
			// set the data
			var data = {
				question_id: '{$question.id}',
				question_type: '{$question.question_type}',
				answers: answers
			}
			// send the ajax
			var submit_url = "{url url='/response/submitQuestion' ajax=1}";
			$.ajax({
				type: 'POST',
				url: submit_url,
				data: data,
				complete: callback
			});
			return true;
		}
	</script>

	{elseif $question.question_type == 'E'}
	<div class="control-group">
		<label class="control-label"></label>
		<div class="controls">
			<textarea id="essay-text" style="width:100%" class="input-xlarge" rows="9">{if isset($question.responses[0])}{$question.responses[0].response}{/if}</textarea>
		</div>
	</div>
	<script>
		submitQuestion = function(callback){
			// get the answer
			answer = $('#essay-text').val();
			// set the data
			data = {
				question_id: '{$question.id}',
				question_type: '{$question.question_type}',
				answer: answer
			}
			// send the ajax
			submit_url = "{url url='/response/submitQuestion' ajax=1}";
			$.ajax({
				type: 'POST',
				url: submit_url,
				data: data,
				complete: callback
			});
			return true;
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
		submitQuestion = function(callback){
			// get the answer
			answer = $('#numerical-text').val();
			// set the data
			data = {
				question_id: '{$question.id}',
				question_type: '{$question.question_type}',
				answer: answer
			}
			// send the ajax
			submit_url = "{url url='/response/submitQuestion' ajax=1}";
			$.ajax({
				type: 'POST',
				url: submit_url,
				data: data,
				complete: callback
			});
			return true;
		}
	</script>

	{elseif $question.question_type == 'F'}
	<script>
		submitQuestion = function(callback){
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
			submit_url = "{url url='/response/submitQuestion' ajax=1}";
			$.ajax({
				type: 'POST',
				url: submit_url,
				data: data,
				complete: callback
			});
			return true;
		}
	</script>

	{else}
		ERROR!!!  Undefined question_type
	{/if}
	
</div>
