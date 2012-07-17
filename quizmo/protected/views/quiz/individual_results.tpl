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
</div>
{foreach from=$questions item=question}
<div class="span8 well">{$question.id}
	{include file = 'protected/views/question/_view.tpl'
		question = $question
	}
</div>
{/foreach}
	
</div>

