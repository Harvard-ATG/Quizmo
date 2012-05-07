<div class="row-fluid">
	<h1 class="span12">Quizes</h1>
</div>

<div id="quizes-container" class="span12 row-fluid">
	<a class="btn" href='{url url="/quiz/create/$collection_id"}'>New Quiz</a>
	New Quiz:

		{url url="/quiz/create/$collection_id"}
		<pre>{url url="/quiz/create/$collection_id"}</pre><br/>
{if $sizeofquizes > 0}
	<table class="table">
		<tr>
			<th>Quiz</th><th>Actions</th>
		</tr>
{foreach from=$quizes item=quiz}

		<tr>
			<td><a href="{url url=$quiz['link']}">{$quiz['TITLE']}</a></td>
			<td>Take Quiz</td>
		</tr>
					
<!--	<a href="{$quiz['link']}">{$quiz['TITLE']}:{$quiz['link']}</a> -->




{/foreach}
	</table>
{/if}

</div>
