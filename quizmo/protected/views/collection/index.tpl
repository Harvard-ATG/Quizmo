<div class="row-fluid">
	<h1 class="span12">Collections</h1>
</div>

<div id="collections-container" class="span12 row-fluid">
	<a class="btn" href="/collection/create">New Collection</a>
{foreach from=$collections item=collection}
	<div class="row-fluid">

		<!-- {*$this->widget('LinkWidget', ['href' => $collection.ID, 'text' => $collection.TITLE], true)*}<br/> -->
		<a href="{$collectionLinks[$collection.ID]}">{$collection.TITLE}:{$collectionLinks[$collection.ID]}</a>
	</div>
{/foreach}
</div>
