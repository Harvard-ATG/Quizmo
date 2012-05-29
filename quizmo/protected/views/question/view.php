<?php
$this->breadcrumbs=array(
	'Questions'=>array('index'),
	$model->TITLE,
);

$this->menu=array(
	array('label'=>'List Question', 'url'=>array('index')),
	array('label'=>'Create Question', 'url'=>array('create')),
	array('label'=>'Update Question', 'url'=>array('update', 'id'=>$model->ID)),
	array('label'=>'Delete Question', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);
?>

<h1>View Question #<?php echo $model->ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ID',
		'QUIZ_ID',
		'QUESTION_TYPE',
		'TITLE',
		'BODY',
		'QUESTION_ORDER',
		'POINTS',
		'FEEDBACK',
		'DELETED',
	),
)); ?>
