<ul class="breadcrumb">
  <li>
    <a href='{url url="/quiz/index/$collection_id"}'>Quizzes</a> <span class="divider">/</span>
  </li>
  <li>
    <a href='{url url="/quiz/results/$quiz_id"}'>Results</a> <span class="divider">/</span>
  </li>
  <li class="active">{$name}</li>
</ul>

<div class="row-fluid">
	<h1 class="span12">Question Results for {$name}</h1>
</div>

<div class="row-fluid">
	<div class="span2">
		<img src="/img/user-icon.png"/>
	</div>
	<div class="span2 well">
		Score: {$score} / {$total_score}
	</div>
</div>

<div class="row-fluid">
<table class="table table-bordered table-striped">
	<tbody>
{foreach from=$questions item=question}
		<tr>
			<td>
	{include file = 'protected/views/question/_view.tpl'
		question = $question
	}
			</td>
		</tr>
{/foreach}
	</tbody>
</table>
</div>

