<div class="row-fluid">
	<h1 class="span12">Quizes</h1>
</div>

<div id="quizes-container" class="span12 row-fluid">
	<a class="btn" href='{url url="/quiz/create/$collection_id"}'>New Quiz</a>

{if $sizeofquizes > 0}
	<table class="table table-condensed">
		<tr>
			<th>Quiz</th><th>Actions</th>
		</tr>
{foreach from=$quizes item=quiz}

		<tr>
			<td><a href="{url url=$quiz['link']}">{$quiz['TITLE']}</a></td>
			<td>
				<a href="{url url='/quiz/take/'|cat:$quiz['ID']}">Take Quiz</a><br/>
				<a href="{url url='/question/index/'|cat:$quiz['ID']}">Edit Questions</a><br/>
				<a href="{url url='/quiz/create/'|cat:$collection_id|cat:'/'|cat:$quiz['ID']}">Edit Settings</a><br/>
				{if $quiz.status == 'N'}
					<!-- not started -->
				{elseif $quiz.status == 'S'}
					<!-- submitted -->
					<a href='{url url="/quiz/individualResults/"|cat:$quiz['ID']|cat:"/"|cat:$user_id}'>My Results</a><br/>
				{else}
					<!-- started -->
					<a href='{url url="/quiz/submit/"|cat:$quiz['ID']}'>Submit</a><br/>
				{/if}
				<a href="{url url='/quiz/results/'|cat:$quiz['ID']}">Results</a><br/>

				<a data-toggle="modal" href="#quiz-delete-modal-{$quiz['ID']}" >Delete</a>
				<div class="modal hide" id="quiz-delete-modal-{$quiz['ID']}">
				  <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal">×</button>
				    <h3>Delete Quiz</h3>
				  </div>
				  <div class="modal-body">
				    <p>Are you sure you want to delete this Quiz?</p>
				  </div>
				  <div class="modal-footer">
				    <a href="#" class="btn btn-primary quiz-delete-action" name="{$quiz['ID']}" data-dismiss="modal">Delete</a>
				    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
				  </div>
				</div>

			</td>
		</tr>
					
<!--	<a href="{$quiz['link']}">{$quiz['TITLE']}:{$quiz['link']}</a> -->




{/foreach}
	</table>
{/if}

</div>
