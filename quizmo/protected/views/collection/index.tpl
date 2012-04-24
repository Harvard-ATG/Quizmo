<h1>Collections</h1>

<div id="collections-container">
{foreach from=$collections item=collection}
	<div>

		<!-- {$this->widget('LinkWidget', ['href' => $collection.ID, 'text' => $collection.TITLE], true)}<br/> -->
		<a href="{$collectionLinks[$collection.ID]}">{$collection.TITLE}:{$collectionLinks[$collection.ID]}</a>
	</div>
{/foreach}
</div>
