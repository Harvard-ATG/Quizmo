<!--
<div class="row-fluid span6">
	<table class="table table-bordered table-striped">
		<tr>
			<td>Title</td>
			<td><input id="title" name="title" type="text" value="{$title}"/></td>
		</tr>
		<tr>
			<td>Description</td>
			<td><textarea id="description" name="description">{$description}</textarea></td>
		</tr>
		<tr>
			<td colspan=2><input id="submit" name="submit" class="pull-right" value="submit" type="submit"/></td>
		</tr>
	</table>
</div>
-->
<div id="title-control-group" class="control-group">
	<label class="control-label" for="title">Title</label>
	<div class="controls">
		<input type="text" class="input-xlarge" id="title" name="title" value="{$title}"/>
		<p class="help-inline"></p>
	</div>
</div>
<div id="description-control-group" class="control-group">
	<label class="control-label" for="title">Description</label>
	<div class="controls">
		<textarea class="input-xlarge" id="description" name="description"></textarea>
		<p class="help-inline"></p>
	</div>
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="Submit" />
		<button class="btn">Cancel</button>
	</div>
</div>

