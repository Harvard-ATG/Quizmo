<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'answer-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'question_id'); ?>
		<?php echo $form->textField($model,'question_id'); ?>
		<?php echo $form->error($model,'question_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'question_type'); ?>
		<?php echo $form->textField($model,'question_type',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'question_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textarea_rows'); ?>
		<?php echo $form->textField($model,'textarea_rows'); ?>
		<?php echo $form->error($model,'textarea_rows'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'answer'); ?>
		<?php echo $form->textField($model,'answer',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'answer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_case_sensitive'); ?>
		<?php echo $form->textField($model,'is_case_sensitive'); ?>
		<?php echo $form->error($model,'is_case_sensitive'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'answer_order'); ?>
		<?php echo $form->textField($model,'answer_order'); ?>
		<?php echo $form->error($model,'answer_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_correct'); ?>
		<?php echo $form->textField($model,'is_correct'); ?>
		<?php echo $form->error($model,'is_correct'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tolerance'); ?>
		<?php echo $form->textField($model,'tolerance'); ?>
		<?php echo $form->error($model,'tolerance'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->