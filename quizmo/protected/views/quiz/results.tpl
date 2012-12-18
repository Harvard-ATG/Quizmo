<style>
.enrollee {
	background-color: #E6E6E6;
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
  <li class="active">Results</li>
</ul>

<div class="row-fluid">
	<h1 class="span12">Results</h1>
</div>
<div class="row-fluid">
	<h6 class="span4"><a href='{url url="/quiz/export/$quiz_id"}'>Export</a></h6>
	<div class="span8">
		<span class='enrollee example'>Enrollee</span>
		<span class='guest example'>Guest</span>
		<span class='super example'>Other</span>
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
		<tr class="{$results[$user_id].permission}">
			<td>
				<img height="50px" width="50px" src="{$results[$user_id].photo_url}"/>
			</td>
			<td>
				<a href='{url url="/quiz/individualResultsAdmin/$quiz_id/$user_id"}'>{$results[$user_id].name}</a> 
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
	</tbody>	
</table>