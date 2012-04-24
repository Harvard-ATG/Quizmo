<?php
$this->breadcrumbs=array(
	'Responses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Response', 'url'=>array('index')),
	array('label'=>'Manage Response', 'url'=>array('admin')),
);
?>

<h1>Create Response</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>