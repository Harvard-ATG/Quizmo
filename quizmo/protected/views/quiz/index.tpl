<h1>Quizzes</h1>


<div id="quizzes-container" class="row-fluid">
	<div class="span8">

	</div>
	<div class="span4">
		<a class="btn" href='{url url="/quiz/index/$collection_id"}'>Manage</a>
	</div>

{if $sizeofquizzes > 0}
	<table class="table table-condensed">
		<tr>
			<th>Quiz</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
{foreach from=$quizzes item=quiz}
	{if $quiz['VISIBILITY'] != 0}
		<tr class="quiz-row-{$quiz['ID']}">
			<td>{$quiz['TITLE']}</td>
			<td>
				{if $quiz['STATE'] == 'C'}
					Closed
				{elseif $quiz['STATE'] == 'O'}
					Open
				{elseif $quiz['STATE'] == 'S'}
					Scheduled
					{if $quiz['isClosed']}
						(Closed)
					{/if}
				{/if}
			</td>
			<td>
				{if $quiz.status != 'S' && $quiz['STATE'] != 'C' && !$quiz['isClosed']}
					<a href="{url url='/quiz/take/'|cat:$quiz['ID']}">Take Quiz</a><br/>
				{/if}
				{if $quiz.status == 'N' && $quiz['STATE'] != 'C' && $quiz['STATE'] != 'S'}
					<!-- not started -->
				{elseif $quiz.status == 'S' || $quiz['STATE'] == 'C' || $quiz['isClosed']}
					<!-- submitted -->
					<a href='{url url="/quiz/individualResults/"|cat:$quiz['ID']|cat:"/"|cat:$user_id}'>My Results</a><br/>
				{else}
					<!-- started -->
					<a href='{url url="/quiz/submit/"|cat:$quiz['ID']}'>Submit</a><br/>
				{/if}
				
			</td>
		</tr>
	{/if}

{/foreach}
	</table>
{else}
<div class="lead">
	No Quizzes.
</div>
{/if}


</div>