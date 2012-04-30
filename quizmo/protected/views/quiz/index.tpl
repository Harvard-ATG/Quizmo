<div class="row-fluid">
	<h1 class="span12">Quizes</h1>
</div>

<div id="quizes-container" class="span12 row-fluid">
	<a class="btn" href="/quiz/create">New Quiz</a>
{foreach from=$quizes item=quiz}
	<div class="row-fluid">

		<!-- {*$this->widget('LinkWidget', ['href' => $collection.ID, 'text' => $collection.TITLE], true)*}<br/> -->
		<a href="{$quiz.link}">{$quiz.TITLE}:{$quiz.link}</a>
	</div>
{/foreach}

</div>
