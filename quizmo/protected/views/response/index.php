<?php
$this->breadcrumbs=array(
	'Responses',
);

$this->menu=array(
	array('label'=>'Create Response', 'url'=>array('create')),
	array('label'=>'Manage Response', 'url'=>array('admin')),
);
?>

<h1>Responses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
