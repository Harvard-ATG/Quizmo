<div class="row-fluid">
	<h1 class="span12">Collections</h1>
</div>

<div id="collections-container" class="span12 row-fluid">
	<table class="table table-condensed">
		<thead>
			<tr>
				<td>
					<a class="btn" href="/collection/create">New Collection</a>
				</td>
			</tr>
		</thead>
		<tbody>
{foreach from=$collections item=collection}
			<tr id="collection-row-{$collection['ID']}">
				<td>
					<a href="{$collection['link']}">{$collection['TITLE']}</a>
				</td>
				<td>
					<a class="btn" href="/collection/create/{$collection['ID']}">Edit</a>
				</td>
				<td>
					<!-- <a class="btn collection-delete/{$collection['ID']}" href="#">Delete</a> -->
					<a class="btn" data-toggle="modal" href="#collection-delete-modal-{$collection['ID']}" >Delete</a>
					<div class="modal hide" id="collection-delete-modal-{$collection['ID']}">
					  <div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal">×</button>
					    <h3>Delete Collection</h3>
					  </div>
					  <div class="modal-body">
					    <p>Are you sure you want to delete this Collection?</p>
					  </div>
					  <div class="modal-footer">
					    <a href="#" class="btn btn-primary collection-delete-action" name="{$collection['ID']}" data-dismiss="modal">Delete</a>
					    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
					  </div>
					</div>
				</td>
			</tr>
{/foreach}
		</tbody>
	</table>
</div>



<script>
$(document).ready(function(){
	

});

</script>