
<h1>View Collection #<?php echo $model->ID; ?></h1>

<table>
	<tr>
		<td>ID</td>
		<td>{$collection.ID}</td>
	</tr>
	<tr>
		<td>Other</td>
		<td>{$collection.OTHER_ID}</td>
	</tr>
	<tr>
		<td>Title</td>
		<td>{$collection.TITLE}</td>
	</tr>
	<tr>
		<td>Description</td>
		<td>{$collection.DESCRIPTION}</td>
	</tr>
	<tr>
		<td>Deleted</td>
		<td>{$collection.DELETED}</td>
	</tr>
</table>

<ul>
	<li><a href="collection/index">List Collections</a></li>
	<li><a href="collection/create">Create Collection</a></li>
	<li><a href="collection/update/{$collection.ID}">Update Collection</a></li>
	<li><a href="collection/delete/{$collection.ID}">Delete Collection</a></li>

</ul>


