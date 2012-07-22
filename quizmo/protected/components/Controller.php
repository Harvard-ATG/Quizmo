<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	//public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	
	// added for facebook-opengraph
	protected function afterRender($view, &$output){
	    parent::afterRender($view,$output);
	    //Yii::app()->facebook->addJsCallback($js); // use this if you are registering any $js code you want to run asyc
	    Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
	    Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags
	    return true;
	}
	
	protected function url($url){
		if(Yii::app()->params['authMethod'] == 'isites'){
			$url = Yii::app()->isitestool->url($url);
		} else {
			$url = Yii::app()->createUrl($url);
		}
		return $url;
	}
	
}