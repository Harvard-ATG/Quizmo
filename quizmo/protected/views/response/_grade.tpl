<div class="span2">
	<input id="grade_{$question_id}" type="text" class="input-mini" value="{$score}"/> / {$points}<br/>
	<button type="button" id="gradebtn_{$question_id}" class='btn'>Update Score</button>
</div>
<script>
$(document).ready(function(){
	
	$('#grade_{$question_id}').keypress(function(e){
		if(e.which == 13){
			// get data
			score = $('#grade_{$question_id}').val();
			updateScore('{$question_id}', '{$response_id}', '{$user_id}', score);	
		}
	});
	
	$('#gradebtn_{$question_id}').click(function(){
		score = $('#grade_{$question_id}').val();
		updateScore('{$question_id}', '{$response_id}', '{$user_id}', score);
	});
});
</script>