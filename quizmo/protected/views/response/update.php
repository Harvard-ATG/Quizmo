<?php
$this->breadcrumbs=array(
	'Responses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Response', 'url'=>array('index')),
	array('label'=>'Create Response', 'url'=>array('create')),
	array('label'=>'View Response', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Response', 'url'=>array('admin')),
);
?>

<h1>Update Response <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>