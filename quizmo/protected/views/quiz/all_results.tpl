<style>
.enrollee {
	background-color: #E6E6E6 !important;
	background-repeat: repeat-x;
}
.guest {
	background-color: #E6E6D0;
}
.admin, super {
	background-color: #ffffff;
}
.example {
	border: 1px solid;
	border-radius: 5px;
	padding: 3px;
}
</style>
<ul class="breadcrumb">
  <li>
    <a href='{url url="/quiz/index/$collection_id"}'>Quizzes</a> <span class="divider">/</span>
  </li>
  <li>
    <a href='{url url="/quiz/allResults/$collection_id"}'>Results</a> <span class="divider">/</span>
  </li>
  <li class="active">All Results</li>
</ul>

<div class="row-fluid">
	<h1 class="span12">All Results</h1>
</div>
<div class="row-fluid">
	<div class="span8">
		<span class='enrollee example'><input type="checkbox" id="enrollee_check" checked="checked"/>Enrollee</span>
		<span class='guest example'><input type="checkbox" id="guest_check" checked="checked"/>Guest</span>
		<span class='super example'><input type="checkbox" id="other_check" checked="checked"/>Other</span>
	</div>
</div>
<table class="table table-bordered">
	<tbody>
		{foreach from=$results key=user_id item=result}
		<tr class="{$results[$user_id].permission}">
			<td>
				<a href='{url url="/quiz/individualResultsAdmin/$quiz_id/$user_id"}'>{$results[$user_id].name}</a><br/>
				<img height="50px" width="50px" src="{$results[$user_id].photo_url}"/><br/>
				{$results[$user_id].status}<br/>
				{$results[$user_id].score}
			</td>
			<td>
				<div class="well">
					{foreach from=$results[$user_id]['questions'] item=question name=qounter}
						{$smarty.foreach.qounter.index + 1}. 
						{if $question.score > 0}<i class="icon-ok"> </i>{else}<i class="icon-empty"> </i>{/if} 
						{$question.score}/{$question.points} 
						
						{if $question.question_type == 'M' || $question.question_type == 'T'}
							{foreach from=$question.answers key=key item=value}			
								{if $question.answers[$key].response}
									{$question.answers[$key].answer}  
								{/if}
							{/foreach}

						{elseif $question.question_type == 'S'}
							{foreach from=$question.answers key=key item=value}	
								{if $question.answers[$key].response}
									{$question.answers[$key].answer}  
								{/if}
							{/foreach}

						{elseif $question.question_type == 'E'}
							{$question.responses[0].response}

						{elseif $question.question_type == 'N'}
							{$question.responses[0].response}

						{elseif $question.question_type == 'F'}
							{foreach from=$question.responses item=response}
								{if $response.response != ''}
									{literal}{{/literal}{$response.response}{literal}}{/literal}
								{/if}
							{/foreach}
						{else}
							ERROR!!!  Undefined question_type
						{/if}
						
						
						<br/>
					{/foreach}
				</div>
			</td>
		</tr>
		{/foreach}
	</tbody>	
</table>

<script>
// onchange
$('#enrollee_check').change(function(){
	if($('#enrollee_check').is(':checked')){
		$('tr.enrollee').show();
	} else {
		$('tr.enrollee').hide();
	}
});
$('#guest_check').change(function(){
	if($('#guest_check').is(':checked')){
		$('tr.guest').show();
	} else {
		$('tr.guest').hide();
	}
});
$('#other_check').change(function(){
	if($('#other_check').is(':checked')){
		$('tr.super').show();
		$('tr.admin').show();
	} else {
		$('tr.super').hide();
		$('tr.admin').hide();
	}
});
</script>