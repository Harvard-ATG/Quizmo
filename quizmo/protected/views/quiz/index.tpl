<h1>Quizzes</h1>


<div id="quizzes-container" class="row-fluid">
	<div class="span8">

	</div>
	{if $admin}
	<div class="span4">
		<a class="btn" href='{url url="/quiz/index/"|cat:$collection_id|cat:"/1"}'>Manage</a>
	</div>
	{/if}

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
						( Closed
						{if $quiz['scheduleState'] == 'N'}
							{if $quiz['scheduleTimeTill'] > 0}
								- opens in {$quiz['scheduleTimeTill']} day(s)
							{/if}
						{elseif $quiz['scheduleState'] == 'E'}
							{if $quiz['scheduleTimeTill'] > 0}
								- {$quiz['scheduleTimeTill']} day(s) ago
							{/if}
						{/if}
						)
					{else}
						( Open 
						{if $quiz['scheduleState'] == 'S'}
							{if $quiz['scheduleTimeTill'] > 0}
								- for {$quiz['scheduleTimeTill']} more day(s)
							{/if}
						{/if}						
						)
					{/if}
				{/if}	
			</td>
			<td>
				{if $quiz.status != 'S' && $quiz['STATE'] != 'C' && !$quiz['isClosed']}
					<a href="{url url='/quiz/take/'|cat:$quiz['ID']}">Take Quiz</a><br/>
				{/if}
				{if $quiz.status == 'N' && $quiz['STATE'] != 'C' && $quiz['STATE'] != 'S'}
					<!-- not started -->
				{elseif $quiz.status != 'N' || $quiz['STATE'] == 'C' || $quiz['isClosed']}
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