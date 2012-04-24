<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'question-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'quiz_id'); ?>
		<?php echo $form->textField($model,'quiz_id'); ?>
		<?php echo $form->error($model,'quiz_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'question_type'); ?>
		<?php echo $form->textField($model,'question_type',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'question_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textField($model,'body',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'question_order'); ?>
		<?php echo $form->textField($model,'question_order'); ?>
		<?php echo $form->error($model,'question_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'points'); ?>
		<?php echo $form->textField($model,'points'); ?>
		<?php echo $form->error($model,'points'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'feedback'); ?>
		<?php echo $form->textField($model,'feedback',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'feedback'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deleted'); ?>
		<?php echo $form->textField($model,'deleted'); ?>
		<?php echo $form->error($model,'deleted'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->