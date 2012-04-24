<?php
$this->breadcrumbs=array(
	'Submissions',
);

$this->menu=array(
	array('label'=>'Create Submission', 'url'=>array('create')),
	array('label'=>'Manage Submission', 'url'=>array('admin')),
);
?>

<h1>Submissions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
