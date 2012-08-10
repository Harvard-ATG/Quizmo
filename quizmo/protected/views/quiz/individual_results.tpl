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
	<h1>Question Results for {$name}</h1>
</div>

<div class="row-fluid">
	<div class="span2">
		<img src="/img/user-icon.png"/>
	</div>
	<div id="total_score" class="span4 well">
		Status: {$status}<br/>
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
			<td nowrap="nowrap">
			{if true}
				{include file = 'protected/views/response/_grade.tpl'
					response_id = $question.responses[0].id
					score = $question.score
					points = $question.points
					user_id = $user_id
				}
			{else}
				{include file = 'protected/views/response/_score.tpl'
					score = $question.score
					points = $question.points
				}
			{/if}
			</td>
		</tr>
{/foreach}
	</tbody>
</table>
</div>

<script>

	updateTotalScore = function(){
		// compose data
		data = {
			user_id: '{$user_id}',
			quiz_id: '{$quiz_id}'
		};
		// load ajax
		$('#total_score').load(
			'/quiz/totalScore', 
			data
		);
	}

	updateScore = function(response_id, user_id, score){
		// compose data
		data = {
			response_id: response_id,
			user_id: user_id,
			score: score
		}
		// send the ajax
		$.ajax({
			type: 'POST',
			url: '/response/grade',
			data: data,
			success: updateTotalScore
		});
			
	}
	
	$(document).ready(function(){
		updateTotalScore();
	});
	
</script>