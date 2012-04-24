<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('PAGE_ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->PAGE_ID), array('view', 'id'=>$data->PAGE_ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('QUIZ_ID')); ?>:</b>
	<?php echo CHtml::encode($data->QUIZ_ID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('HEADER')); ?>:</b>
	<?php echo CHtml::encode($data->HEADER); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FOOTER')); ?>:</b>
	<?php echo CHtml::encode($data->FOOTER); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BODY')); ?>:</b>
	<?php echo CHtml::encode($data->BODY); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('PAGE_NUMBER')); ?>:</b>
	<?php echo CHtml::encode($data->PAGE_NUMBER); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DELETED')); ?>:</b>
	<?php echo CHtml::encode($data->DELETED); ?>
	<br />


</div>