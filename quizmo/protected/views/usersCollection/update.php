<?php
$this->breadcrumbs=array(
	'Users Collections'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UsersCollection', 'url'=>array('index')),
	array('label'=>'Create UsersCollection', 'url'=>array('create')),
	array('label'=>'View UsersCollection', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UsersCollection', 'url'=>array('admin')),
);
?>

<h1>Update UsersCollection <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>