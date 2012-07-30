<ul class="breadcrumb">
  <li>
    <a href="/quiz/index/{$collection_id}">Quizzes</a> <span class="divider">/</span>
  </li>
  <li class="active">Questions</li>
</ul>

<div class="row-fluid">
	<h1 class="span12">Questions</h1>
</div>

<div id="questions-container" class="span12 row-fluid">
	<a class="btn" href='{url url="/question/create/$quiz_id"}'>New Question</a>
{if $sizeofquestions > 0}
	<table class="table table-condensed">
		<thead>
			<tr>
				<th>Question</th><th>Actions</th>
			</tr>
		</thead>
		<tbody>
{foreach from=$questions item=question}

		<tr class="question-row-{$question['ID']}">
			<td><a href="{$question['link']}">{$question['TITLE']}</a></td>
			<td>
				<a href="{url url='/question/create/'|cat:$quiz_id|cat:'/'|cat:$question['ID']}">Edit</a><br/>

				<a data-toggle="modal" href="#question-delete-modal-{$question['ID']}" >Delete</a>
				<div class="modal hide" id="question-delete-modal-{$question['ID']}">
				  <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal">×</button>
				    <h3>Delete Question</h3>
				  </div>
				  <div class="modal-body">
				    <p>Are you sure you want to delete this Question?</p>
				  </div>
				  <div class="modal-footer">
				    <a href="#" class="btn btn-primary question-delete-action" name="{$question['ID']}" data-dismiss="modal">Delete</a>
				    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
				  </div>
				</div>
				
			</td>
		</tr>



{/foreach}
		</tbody>
	</table>
{/if}

</div>

<script>
	removeDiv = function(data){
		question_id = data.question_id;
		//$('.question-delete-action[name="'+question_id+'"]').hide();
		$('tr.question-row-'+question_id).hide(400);
		//console.log($('.question-delete-action[name="'+question_id+'"]'));
		
	
	}
	failure = function(){
		alert("failure saving");
	}
	$(document).ready(function(){
		$('.question-delete-action').click(function(e){
			// get the question_id from eventObject
			question_id = e.currentTarget.name;
			// form data
			data = {
				question_id: question_id
			};
			console.log(data);
			// now send the delete query
			$.ajax({
				type: 'POST',
				url: '/question/delete',
				data: data,
				dataType: 'json',
				error: failure,
				success: removeDiv
			});
		});
		
	});
</script>
