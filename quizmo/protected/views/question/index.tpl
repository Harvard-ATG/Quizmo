<div class="row-fluid">
	<h1 class="span12">Questions</h1>
</div>

<div id="questions-container" class="span12 row-fluid">
	<a class="btn" href='{url url="/question/create/$quiz_id"}'>New Question</a>
		<pre>{url url="/question/create/$quiz_id"}</pre><br/>
{if $sizeofquestions > 0}
	<table class="table">
		<tr>
			<th>Question</th><th>Actions</th>
		</tr>
{foreach from=$questions item=question}

		<tr>
			<td><a href="{$question['link']}">{$question['TITLE']}</a></td>
			<td>--</td>
		</tr>



{/foreach}
	</table>
{/if}

</div>
