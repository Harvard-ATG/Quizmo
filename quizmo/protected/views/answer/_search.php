<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'question_id'); ?>
		<?php echo $form->textField($model,'question_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'question_type'); ?>
		<?php echo $form->textField($model,'question_type',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'textarea_rows'); ?>
		<?php echo $form->textField($model,'textarea_rows'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'answer'); ?>
		<?php echo $form->textField($model,'answer',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_case_sensitive'); ?>
		<?php echo $form->textField($model,'is_case_sensitive'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'answer_order'); ?>
		<?php echo $form->textField($model,'answer_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_correct'); ?>
		<?php echo $form->textField($model,'is_correct'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tolerance'); ?>
		<?php echo $form->textField($model,'tolerance'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->