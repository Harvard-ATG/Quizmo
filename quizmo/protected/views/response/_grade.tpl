<div class="span2">
	<input id="grade_{$response_id}" type="text" class="input-mini" value="{$score}"/> / {$points}<br/>
	<a id="gradebtn_{$response_id}" href='#' class='btn'>Update Score</a>
</div>
<script>
$(document).ready(function(){
	$('#grade_{$response_id}').keypress(function(e){
		if(e.which == 13){
			// get data
			score = $('#grade_{$response_id}').val();
			updateScore('{$response_id}', '{$user_id}', score);	
		}
	});
	
	$('#gradebtn_{$response_id}').click(function(){
		score = $('#grade_{$response_id}').val();
		updateScore('{$response_id}', '{$user_id}', score);	
	});
});
</script>