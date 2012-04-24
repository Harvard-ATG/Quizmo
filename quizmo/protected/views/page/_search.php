<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'PAGE_ID'); ?>
		<?php echo $form->textField($model,'PAGE_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'QUIZ_ID'); ?>
		<?php echo $form->textField($model,'QUIZ_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HEADER'); ?>
		<?php echo $form->textField($model,'HEADER',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FOOTER'); ?>
		<?php echo $form->textField($model,'FOOTER',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'BODY'); ?>
		<?php echo $form->textField($model,'BODY',array('size'=>60,'maxlength'=>4000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'PAGE_NUMBER'); ?>
		<?php echo $form->textField($model,'PAGE_NUMBER'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DELETED'); ?>
		<?php echo $form->textField($model,'DELETED'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->