
<form id="collection-form" class="form-horizontal row-fluid" action="/collection/create" method="post">
	<fieldset>
		{if $collection_id == ''}
		<legend>Create Collection</legend>
		{else}
		<legend>Edit Collection</legend>
		{/if}

		{include file = 'protected/views/collection/_form.tpl'
			title = $title
			description = $description
		}
	</fieldset>
</form>


<script>
$(document).ready(function(){
	
	$('#collection-form').submit(function() {
		// validate data
		if ($("input:#title").val() == "") {
			$("#title-control-group p.help-inline").text("Error: title required").show();
			$("#title-control-group").addClass("error");
			return false;
		} else {
			$("#title-control-group p.help-inline").text("").show();			
			$("#title-control-group").removeClass("error");
		}

	  return true;
	});

});
</script>