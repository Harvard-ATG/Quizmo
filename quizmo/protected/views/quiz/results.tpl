<style>
.enrollee {
	background-color: #E6E6E6 !important;
	background-repeat: repeat-x;
}
.guest {
	background-color: #E6E6D0;
}
.admin, super {
	background-color: #ffffff;
}
.example {
	border: 1px solid;
	border-radius: 5px;
	padding: 3px;
}
</style>
<ul class="breadcrumb">
  <li>
    <a href='{url url="/quiz/index/$collection_id"}'>Quizzes</a> <span class="divider">/</span>
  </li>
  <li class="active">{$title} <span class="divider">/</span></li>
  <li class="active">Results</li>
</ul>

<div class="row-fluid">
	<h1 class="span12">{$title} Results</h1>
</div>
<div class="row-fluid">
	<h5 class="span12"><a href='{url url="/quiz/allResults/$collection_id"}'>All Results</a></h5>
</div>
<div class="row-fluid">
	<h6 class="span4"><a href='{url url="/quiz/export/$quiz_id"}'>Export</a></h6>
	<div class="span8">
		<span class='enrollee example'><input type="checkbox" id="enrollee_check" checked="checked"/>Enrollee</span>
		<span class='guest example'><input type="checkbox" id="guest_check" checked="checked"/>Guest</span>
		<span class='super example'><input type="checkbox" id="other_check" checked="checked"/>Other</span>
	</div>
</div>
<table class="table table-bordered">
	<thead>
		<tr>
			<th></th>
			<th>
				Name
			</th>
			<th>
				Status
			</th>
			<th>
				Score
			</th>
			<th>
				Actions
			</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$results key=user_id item=value}
		<tr class="{$results[$user_id].permission}" id="result-row-{$user_id}">
			<td>
				<img height="50px" width="50px" src="{$results[$user_id].photo_url}"/>
			</td>
			<td>
				<a href='{url url="/quiz/individualResultsAdmin/$quiz_id/$user_id"}'>{$results[$user_id].name}</a> 
			</td>
			<td class="result-status">
				{$results[$user_id].status} 
			</td>
			<td class="result-score">
				{$results[$user_id].score} 
			</td>
			<td>
				<a class="result-delete-btn" name="#result-delete-modal-{$user_id}" >Delete</a> 
				<div class="modal hide" id="result-delete-modal-{$user_id}">
				  <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal">×</button>
				    <h3>Delete Result</h3>
				  </div>
				  <div class="modal-body">
				    <p>Are you sure you want to delete this Result?</p>
				  </div>
				  <div class="modal-footer">
				    <a href="#" class="btn btn-primary result-delete-action" name="{$user_id}" data-dismiss="modal">Delete</a>
				    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
				  </div>
				</div>
			</td>
		</tr>
		{/foreach}
	</tbody>	
</table>

<script>
// onchange
$('#enrollee_check').change(function(){
	if($('#enrollee_check').is(':checked')){
		$('tr.enrollee').show();
	} else {
		$('tr.enrollee').hide();
	}
});
$('#guest_check').change(function(){
	if($('#guest_check').is(':checked')){
		$('tr.guest').show();
	} else {
		$('tr.guest').hide();
	}
});
$('#other_check').change(function(){
	if($('#other_check').is(':checked')){
		$('tr.super').show();
		$('tr.admin').show();
	} else {
		$('tr.super').hide();
		$('tr.admin').hide();
	}
});

openModal = function(e){
	// get the id
	$(e.currentTarget.name).modal();
}

resultDeleteAction = function(e){
	result_delete_url = "{url url='/response/delete' ajax=1}";
	// get the quiz_id from eventObject
	quiz_id = '{$quiz_id}';
	user_id = e.currentTarget.name;
	// form data
	data = {
		quiz_id: quiz_id,
		user_id: user_id
	};
	// now send the delete query
	$.ajax({
		type: 'POST',
		url: result_delete_url,
		data: data,
		dataType: 'json',
		//error: failure,
		success: changeDiv
	});
}

removeDiv = function(data){
	user_id = data.user_id;
	$('tr#result-row-'+user_id).hide(400);
		
}

changeDiv = function(data){
	// change the status to "Not Started"
	$('tr#result-row-'+user_id+' .result-status').text("Not Started");
	// change the score to 0
	$('tr#result-row-'+user_id+' .result-score').text("0");	
}

$(document).ready(function(){
		
	$('.result-delete-btn').click(openModal);
	$('.result-delete-action').click(resultDeleteAction);
	
});

</script>