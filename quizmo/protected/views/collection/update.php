<?php
$this->breadcrumbs=array(
	'Collections'=>array('index'),
	$model->TITLE=>array('view','id'=>$model->ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Collection', 'url'=>array('index')),
	array('label'=>'Create Collection', 'url'=>array('create')),
	array('label'=>'View Collection', 'url'=>array('view', 'id'=>$model->ID)),
	array('label'=>'Manage Collection', 'url'=>array('admin')),
);
?>

<h1>Update Collection <?php echo $model->ID; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>