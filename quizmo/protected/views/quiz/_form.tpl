<div id="title-control-group" class="control-group">
	<label class="control-label" for="title">Title</label>
	<div class="controls">
		<input type="text" class="input-xlarge" id="title" name="title" value="{$title}"/>
		<p class="help-inline"></p>
	</div>
</div>
<div id="description-control-group" class="control-group">
	<label class="control-label" for="description">Description</label>
	<div class="controls">
		<textarea class="input-xlarge" id="description" name="description">{$description}</textarea>
		<p class="help-inline">(Appears at the beginning of the quiz in student view)</p>
	</div>
</div>
<div id="state-control-group" class="control-group">
	<label class="control-label" for="state">Quiz Availability</label>
	<div class="controls">
		<label class="radio">
			<input type="radio" name="state" id="state1" value="O" /> Open
		</label>		
		<label class="radio">
			<input type="radio" name="state" id="state2" value="C" /> Closed
		</label>		
		<label class="radio">
			<input type="radio" name="state" id="state3" value="S" /> Scheduled
		</label>		
		<p class="help-block">You will be able to open or schedule a quiz after you have added questions.</p>
		<label class="control-label" for="start_date">Display start</label>
		<div class="controls">
			<input type="text" class="input-xlarge span2" id="start_date" name="start_date" value="{$start_date}"/>
			<p class="help-inline"></p>
		</div>
		<label class="control-label" for="end_date">Display end</label>
		<div class="controls">
			<input type="text" class="input-xlarge span2" id="end_date" name="end_date" value="{$end_date}"/>
			<p class="help-inline"></p>
		</div>
	</div>
	
	<div class="controls">
		<label class="checkbox">
			<input type="checkbox" id="visibility" name="visibility" value="1"/>
			Show quiz availability on student's list of quizzes
			<p class="help-inline"></p>
		</label>
		<label class="checkbox">
			<input type="checkbox" id="show_feedback" name="show_feedback" value="1"/>
			Show correct answers to student after student submits quiz
			<p class="help-inline"></p>
		</label>
	</div>
	
</div>

<input type="hidden" id="collection_id" name="collection_id" value="{$collection_id}"/>

<div class="form-actions">
	<input type="submit" class="btn btn-primary" value="Submit" />
	<button class="btn">Cancel</button>
</div>

