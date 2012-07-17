<ul class="breadcrumb">
  <li>
    <a href="/quiz/index/{$collection_id}">Quizzes</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="/quiz/results/{$quiz_id}">Results</a> <span class="divider">/</span>
  </li>
  <li class="active">{$name}</li>
</ul>

<div class="row-fluid">
	<h1 class="span12">Individual Results</h1>
</div>
<div class="span12">
	<div class="span2">
		<img src="/img/user-icon.png"/>
	</div>
	{foreach from=$questions item=question_id}
	<div class="span8 well">
		{* include file = 'protected/views/question/_view.tpl'
			question_id = $question_id
			title = $title
			description = $description
			state = $state
			start_date = $start_date
			end_date = $end_date
		*}
	</div>
	{/foreach}
	
</div>

