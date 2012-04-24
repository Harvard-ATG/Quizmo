<?php
$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->PAGE_ID,
);

$this->menu=array(
	array('label'=>'List Page', 'url'=>array('index')),
	array('label'=>'Create Page', 'url'=>array('create')),
	array('label'=>'Update Page', 'url'=>array('update', 'id'=>$model->PAGE_ID)),
	array('label'=>'Delete Page', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->PAGE_ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Page', 'url'=>array('admin')),
);
?>

<h1>View Page #<?php echo $model->PAGE_ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'PAGE_ID',
		'QUIZ_ID',
		'HEADER',
		'FOOTER',
		'BODY',
		'PAGE_NUMBER',
		'DELETED',
	),
)); ?>
