<ul class="breadcrumb">
  <li>
    <a href="/quiz/index/{$collection_id}">Quizzes</a> <span class="divider">/</span>
  </li>
  <li class="active">Results</li>
</ul>

<div class="row-fluid">
	<h1 class="span12">Results</h1>
</div>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
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
		<tr>
			<td>
				<a href="/quiz/individualResults/{$quiz_id}/{$user_id}">{$results[$user_id].name}</a> 
			</td>
			<td>
				{$results[$user_id].status} 
			</td>
			<td>
				{$results[$user_id].score} 
			</td>
			<td>
				Delete 
			</td>
		</tr>
		{/foreach}
		<!--
		<tr>
			<td>
				JaZahn Clevenger
			</td>
			<td>
				Finished
			</td>
			<td>
				100
			</td>
			<td>
				Delete
			</td>
		</tr>
		<tr>
			<td>
				Michael Hilborn
			</td>
			<td>
				Finished
			</td>
			<td>
				56
			</td>
			<td>
				Delete
			</td>
		</tr>
		<tr>
			<td>
				Arthur Barrett
			</td>
			<td>
				Finished
			</td>
			<td>
				98
			</td>
			<td>
				Delete
			</td>
		</tr>
		<tr>
			<td>
				Shannon Rice
			</td>
			<td>
				Finished
			</td>
			<td>
				74
			</td>
			<td>
				Delete
			</td>
		</tr>
		-->
	</tbody>	
</table>