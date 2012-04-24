<?php
$this->breadcrumbs=array(
	'Users Collections',
);

$this->menu=array(
	array('label'=>'Create UsersCollection', 'url'=>array('create')),
	array('label'=>'Manage UsersCollection', 'url'=>array('admin')),
);
?>

<h1>Users Collections</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
