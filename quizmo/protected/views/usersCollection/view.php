<?php
$this->breadcrumbs=array(
	'Users Collections'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UsersCollection', 'url'=>array('index')),
	array('label'=>'Create UsersCollection', 'url'=>array('create')),
	array('label'=>'Update UsersCollection', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UsersCollection', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UsersCollection', 'url'=>array('admin')),
);
?>

<h1>View UsersCollection #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'collection_id',
		'user_id',
		'permission',
	),
)); ?>
