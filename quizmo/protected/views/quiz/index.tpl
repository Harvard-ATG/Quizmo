<div class="row-fluid">
	<h1 class="span12">Quizzes</h1>
</div>

<div id="quizzes-container">

{if $sizeofquizzes > 0}
	<table class="table table-condensed">
		<tr>
			<th>Quiz</th><th>Actions</th>
		</tr>
{foreach from=$quizzes item=quiz}

		<tr class="quiz-row-{$quiz['ID']}">
			<td>{$quiz['TITLE']}</td>
			<td>
				{if $quiz.status != 'S'}
					<a href="{url url='/quiz/take/'|cat:$quiz['ID']}">Take Quiz</a><br/>
				{/if}
				{if $quiz.status == 'N'}
					<!-- not started -->
				{elseif $quiz.status == 'S'}
					<!-- submitted -->
					<a href='{url url="/quiz/individualResults/"|cat:$quiz['ID']|cat:"/"|cat:$user_id}'>My Results</a><br/>
				{else}
					<!-- started -->
					<a href='{url url="/quiz/submit/"|cat:$quiz['ID']}'>Submit</a><br/>
				{/if}
				
			</td>
		</tr>


{/foreach}
	</table>
{else}
No Quizzes.
{/if}


</div>