<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-collection-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'collection_id'); ?>
		<?php echo $form->textField($model,'collection_id'); ?>
		<?php echo $form->error($model,'collection_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'permission'); ?>
		<?php echo $form->textField($model,'permission',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'permission'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->