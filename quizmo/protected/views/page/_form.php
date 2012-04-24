<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'QUIZ_ID'); ?>
		<?php echo $form->textField($model,'QUIZ_ID'); ?>
		<?php echo $form->error($model,'QUIZ_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'HEADER'); ?>
		<?php echo $form->textField($model,'HEADER',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'HEADER'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'FOOTER'); ?>
		<?php echo $form->textField($model,'FOOTER',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'FOOTER'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'BODY'); ?>
		<?php echo $form->textField($model,'BODY',array('size'=>60,'maxlength'=>4000)); ?>
		<?php echo $form->error($model,'BODY'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'PAGE_NUMBER'); ?>
		<?php echo $form->textField($model,'PAGE_NUMBER'); ?>
		<?php echo $form->error($model,'PAGE_NUMBER'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DELETED'); ?>
		<?php echo $form->textField($model,'DELETED'); ?>
		<?php echo $form->error($model,'DELETED'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->