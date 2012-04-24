<?php
$this->breadcrumbs=array(
	'Users Collections'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UsersCollection', 'url'=>array('index')),
	array('label'=>'Manage UsersCollection', 'url'=>array('admin')),
);
?>

<h1>Create UsersCollection</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>