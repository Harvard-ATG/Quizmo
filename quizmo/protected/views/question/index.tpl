<ul class="breadcrumb">
  <li>
    <a href='{url url="/quiz/index/$collection_id"}'>Quizzes</a> <span class="divider">/</span>
  </li>
  <li class="active">Questions</li>
</ul>

<div>
	<h1>Questions</h1>
</div>

<div id="questions-container">
	<a class="btn" href='{url url="/question/create/$quiz_id"}'>New Question</a>
{if $sizeofquestions > 0}
	<table id="questions-table" class="table table-condensed">
		<thead>
			<tr>
				<th></th>
				<th>Question</th><th>Actions</th>
			</tr>
		</thead>
		<tbody>
{foreach from=$questions item=question name=qounter}

		<tr data-position="{$smarty.foreach.qounter.index + 1}" id="{$question['ID']}" class="question-row-{$question['ID']}">
			<td>{$smarty.foreach.qounter.index + 1}</td>
			<td><a href="{url url='/quiz/take/'|cat:$quiz_id|cat:'/'|cat:$question['ID']}">{$question['TITLE']}</a></td>
			<td>
				<a href="{url url='/question/create/'|cat:$quiz_id|cat:'/'|cat:$question['ID']}">Edit</a><br/>

				<a class="question-delete-btn" name="#question-delete-modal-{$question['ID']}" >Delete</a>
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
{else}
<div class="lead">
	No Questions.
</div>
{/if}

</div>

<script>
	openQuestionDeleteModal = function(e){
		// get the id
		$(e.currentTarget.name).modal();
	}
	questionDeleteAction = function(e){
		question_delete_url = "{url url='/question/delete' ajax=1}";
		// get the question_id from eventObject
		question_id = e.currentTarget.name;
		// form data
		data = {
			question_id: question_id
		};
		// now send the delete query
		$.ajax({
			type: 'POST',
			url: question_delete_url,
			data: data,
			dataType: 'json',
			error: failure,
			success: removeDiv
		});
	}
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
		$('.question-delete-btn').click(openQuestionDeleteModal);
		$('.question-delete-action').click(questionDeleteAction);
		
		$('#questions-table').dataTable({
			 "bPaginate": false,
			 "bFilter": false,
			 "bInfo": false,
			 "bSortClasses": false,
		}).rowReordering({ 
			sURL:"{url url='/question/reorder' ajax=1}",
			sRequestType: "GET"
		});
		
	});
</script>
