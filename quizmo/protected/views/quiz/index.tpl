<div class="row-fluid">
	<h1 class="span12">Quizes</h1>
</div>

<div id="quizes-container" class="span12 row-fluid">
	<a class="btn" href="/quiz/create/{$collection_id}">New Quiz</a>
	New Quiz:
		{$collection_id}
		{url url="/quiz/create/$collection_id"}
{foreach from=$quizes item=quiz}
	<div class="row-fluid">

		<a href="{$quiz['link']}">{$quiz['TITLE']}:{$quiz['link']}</a>
	</div>
{/foreach}

</div>
