<?php
$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->PAGE_ID=>array('view','id'=>$model->PAGE_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Page', 'url'=>array('index')),
	array('label'=>'Create Page', 'url'=>array('create')),
	array('label'=>'View Page', 'url'=>array('view', 'id'=>$model->PAGE_ID)),
	array('label'=>'Manage Page', 'url'=>array('admin')),
);
?>

<h1>Update Page <?php echo $model->PAGE_ID; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>