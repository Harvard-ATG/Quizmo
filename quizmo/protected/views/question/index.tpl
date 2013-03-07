<ul class="breadcrumb">
  <li>
    <a href='{url url="/quiz/index/$collection_id"}'>Quizzes</a> <span class="divider">/</span>
  </li>
  <li>
    {$title} <span class="divider">/</span>
  </li>
  <li class="active">Questions</li>
</ul>

<div>
	<h1>Questions for {$title}</h1>
</div>

<div id="questions-container">

{if $sizeofquestions > 0}
	<table id="questions-table" class="table table-condensed">
		<thead>
			<tr>
				<th></th>
			</tr>
		</thead>
		<tbody>
{foreach from=$questions item=question name=qounter}

		<tr data-position="{$smarty.foreach.qounter.index + 1}" id="{$question['ID']}" class="question-row-{$question['ID']}">
			<td><a href="{url url='/quiz/take/'|cat:$quiz_id|cat:'/'|cat:$question['ID']}">{$question['TITLE']}</a></td>
		</tr>



{/foreach}
		</tbody>
	</table>
{else}
<div class="lead">
	No Questions.
</div>
{/if}

</div>

<script>
	$(document).ready(function(){
		
	});
</script>
