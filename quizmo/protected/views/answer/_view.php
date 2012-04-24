<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_id')); ?>:</b>
	<?php echo CHtml::encode($data->question_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question_type')); ?>:</b>
	<?php echo CHtml::encode($data->question_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textarea_rows')); ?>:</b>
	<?php echo CHtml::encode($data->textarea_rows); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer')); ?>:</b>
	<?php echo CHtml::encode($data->answer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_case_sensitive')); ?>:</b>
	<?php echo CHtml::encode($data->is_case_sensitive); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer_order')); ?>:</b>
	<?php echo CHtml::encode($data->answer_order); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('is_correct')); ?>:</b>
	<?php echo CHtml::encode($data->is_correct); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tolerance')); ?>:</b>
	<?php echo CHtml::encode($data->tolerance); ?>
	<br />

	*/ ?>

</div>