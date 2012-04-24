<?php
$this->breadcrumbs=array(
	'Submissions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Submission', 'url'=>array('index')),
	array('label'=>'Manage Submission', 'url'=>array('admin')),
);
?>

<h1>Create Submission</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>