<div class="row-fluid">
	<h1 class="span12">Quizes</h1>
</div>

<div id="quizes-container" class="span12 row-fluid">
	<a class="btn" href='{url url="/quiz/create/$collection_id"}'>New Quiz</a>

{if $sizeofquizes > 0}
	<table class="table">
		<tr>
			<th>Quiz</th><th>Actions</th>
		</tr>
{foreach from=$quizes item=quiz}

		<tr>
			<td><a href="{url url=$quiz['link']}">{$quiz['TITLE']}</a></td>
			<td><a href="{url url='/quiz/take/'|cat:$quiz['ID']}">Take Quiz</a></td>
		</tr>
					
<!--	<a href="{$quiz['link']}">{$quiz['TITLE']}:{$quiz['link']}</a> -->




{/foreach}
	</table>
{/if}

</div>
