	<h1>Quizzes</h1>


<div id="quizzes-container">
	<a class="btn" href='{url url="/quiz/create/$collection_id"}'>New Quiz</a>

{if $sizeofquizzes > 0}
	<table class="table table-condensed">
		<tr>
			<th>Quiz</th><th>Actions</th>
		</tr>
{foreach from=$quizzes item=quiz}

		<tr class="quiz-row-{$quiz['ID']}">
			<td><a href="{url url=$quiz['link']}">{$quiz['TITLE']}</a></td>
			<td>
				{if $quiz.status != 'S' && $quiz.question_count > 0}
					<a href="{url url='/quiz/take/'|cat:$quiz['ID']}">Take Quiz</a><br/>
				{/if}
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


{/foreach}
	</table>
{else}
No Quizzes.
{/if}

</div>

<script>
	removeDiv = function(data){
		quiz_id = data.quiz_id;
		$('tr.quiz-row-'+quiz_id).hide(400);
		
	
	}
	failure = function(){
		alert("failure saving");
	}
	$(document).ready(function(){
		$('.quiz-delete-action').click(function(e){
			// get the quiz_id from eventObject
			quiz_id = e.currentTarget.name;
			// form data
			data = {
				quiz_id: quiz_id
			};
			// now send the delete query
			$.ajax({
				type: 'POST',
				url: '/quiz/delete',
				data: data,
				dataType: 'json',
				error: failure,
				success: removeDiv
			});
		});
		
	});
</script>
