{if $guest}
You need to be signed into Course iSites in order to use this tool.
{else}

<div id="quizzes-container" class="row-fluid">

	{if $admin}
	<div id="view-switch" class="span4">
		<a class="btn" href='{url url="/quiz/index/"|cat:$collection_id|cat:"/1"}'>Manage</a>
	</div>
	{/if}

{if $sizeofquizzes > 0}
	<table id="quizzes-table_{$topic_id}" class="table table-condensed">
		<thead>
			<tr>
				<th>Quiz</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
{foreach from=$quizzes item=quiz name=qounter}
	{if $quiz['VISIBILITY'] != 0}
		<tr data-position="{$smarty.foreach.qounter.index}" class="quiz-row-{$quiz['ID']}" id="{$quiz['ID']}">
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
				{if $quiz.status != 'S' && $quiz.question_count > 0 && $quiz['STATE'] != 'C' && !$quiz['isClosed']}
					<a href="{url url='/quiz/take/'|cat:$quiz['ID']}">Take Quiz</a><br/>
				{/if}
				{if $quiz.question_count == 0}
					Quiz has no questions.<br/>
				{/if}
				
				{if $quiz.status == 'N' && $quiz['STATE'] != 'C' && $quiz['STATE'] != 'S'}
					<!-- not started -->
				{elseif ($quiz.status != 'N' && $quiz.status != 'U')}
					<!-- submitted -->
					<a href='{url url="/quiz/individualResults/"|cat:$quiz['ID']|cat:"/"|cat:$user_id}'>My Results</a><br/>
				{elseif $quiz.status == 'U' && !$quiz['isClosed']}
					<!-- started -->
					<a href='{url url="/quiz/submit/"|cat:$quiz['ID']}'>Submit</a><br/>
				{/if}
				
			</td>
		</tr>
	{/if}

{/foreach}
		</tbody>
	</table>
{else}
<div class="span12">
	<div class="lead">
		There are no quizzes available right now.
	</div>
</div>
{/if}


</div>

<script>
$(document).ready(function () {

	topic_id = '{$topic_id}'.replace(".", "\\.");

	$('#quizzes-table_'+topic_id).dataTable({
		"bPaginate": false,
		"bFilter": false,
		"bInfo": false,
		"bSortClasses": false,
		"aaSorting": [],
	});

});

</script>

{/if}
