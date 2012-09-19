	<h1>Quizzes</h1>

<div id="quizzes-container" class="row-fluid">
	<div class="span8">
		<a class="btn" href='{url url="/quiz/create/$collection_id"}'>New Quiz</a>
	</div>
	<div class="span4">
		<a class="btn" href='{url url="/quiz/index/"|cat:$collection_id|cat:"/0"}'>Student View</a>
	</div>

{if $sizeofquizzes > 0}
	<table id="quizzes-table" class="table table-condensed">
		<thead>
		<tr>
			<th></th>
			<th>Quiz</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>
{foreach from=$quizzes item=quiz name=qounter}

		<tr data-position="{$smarty.foreach.qounter.index + 1}" class="quiz-row-{$quiz['ID']}" id="{$quiz['ID']}">
			<td>{$smarty.foreach.qounter.index + 1}</td>
			<td><a href="{url url=$quiz['link']}">{$quiz['TITLE']}</a></td>
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
				{if $quiz['VISIBILITY'] == 0}
					(hidden)
				{/if}
			</td>
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

				<a class="quiz-reset-btn" name="#quiz-reset-modal-{$quiz['ID']}" >Reset</a><br/>
				<div class="modal hide" id="quiz-reset-modal-{$quiz['ID']}">
				  <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal">×</button>
				    <h3>Reset Quiz</h3>
				  </div>
				  <div class="modal-body">
				    <p>Are you sure you want to reset this Quiz? It will remove all results, they are not recoverable.</p>
				  </div>
				  <div class="modal-footer">
				    <a href="#" class="btn btn-primary quiz-reset-action" name="{$quiz['ID']}" data-dismiss="modal">Reset</a>
				    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
				  </div>
				</div>
				
				<a class="quiz-delete-btn" name="#quiz-delete-modal-{$quiz['ID']}" >Delete</a>
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
		</tbody>
	</table>
{else}
No Quizzes.
{/if}

</div>

<script>
	openModal = function(e){
		// get the id
		$(e.currentTarget.name).modal();
	}

	quizDeleteAction = function(e){
		quiz_delete_url = "{url url='/quiz/delete' ajax=1}";
		// get the quiz_id from eventObject
		quiz_id = e.currentTarget.name;
		// form data
		data = {
			quiz_id: quiz_id
		};
		// now send the delete query
		$.ajax({
			type: 'POST',
			url: quiz_delete_url,
			data: data,
			dataType: 'json',
			error: failure,
			success: removeDiv
		});
	}

	quizResetAction = function(e){
		quiz_reset_url = "{url url='/quiz/reset' ajax=1}";
		// get the quiz_id from eventObject
		quiz_id = e.currentTarget.name;
		// form data
		data = {
			quiz_id: quiz_id
		};
		// now send the delete query
		$.ajax({
			type: 'POST',
			url: quiz_reset_url,
			data: data,
			dataType: 'json',
			error: failure,
			//success: removeDiv
		});
	}
	
	removeDiv = function(data){
		quiz_id = data.quiz_id;
		$('tr.quiz-row-'+quiz_id).hide(400);
		
	
	}
	failure = function(){
		alert("failure saving");
	}
	
	$(document).ready(function(){
		
		$('.quiz-delete-btn').click(openModal);
		$('.quiz-delete-action').click(quizDeleteAction);
		$('.quiz-reset-btn').click(openModal);
		$('.quiz-reset-action').click(quizResetAction);

		$('#quizzes-table').dataTable({
			 "bPaginate": false,
			 "bFilter": false,
			 "bInfo": false,
			 "bSortClasses": false,
		}).rowReordering();

	});
</script>
