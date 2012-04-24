<?php
$this->breadcrumbs=array(
	'Submissions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Submission', 'url'=>array('index')),
	array('label'=>'Create Submission', 'url'=>array('create')),
	array('label'=>'Update Submission', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Submission', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Submission', 'url'=>array('admin')),
);
?>

<h1>View Submission #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'quiz_id',
		'user_id',
		'status',
		'date_modified',
	),
)); ?>
