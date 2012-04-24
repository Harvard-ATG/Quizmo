<?php
$this->breadcrumbs=array(
	'Submissions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Submission', 'url'=>array('index')),
	array('label'=>'Create Submission', 'url'=>array('create')),
	array('label'=>'View Submission', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Submission', 'url'=>array('admin')),
);
?>

<h1>Update Submission <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>