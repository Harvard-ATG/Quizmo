<?php

class SiteController extends Controller
{
	
	protected $_identity;
	public $_logouturl;
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		//error_log("site/index");
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->render('index');


		if(Yii::app()->params['authMethod'] == 'isites'){
			$other_id = Yii::app()->getRequest()->getParam('topicId');
			$collection = Collection::getByOtherId($other_id);
			Yii::app()->session['collection_id'] = $collection->ID;

			// forward doesn't seem to send along the parameter...
			//$this->forward('/quiz/index/'.$collection->ID);
			$this->redirect($this->url('/quiz/index/'.$collection->ID));
		} else {
			// forward is cleaner in this case
			$this->forward('/collection/index');
			//$this->redirect($this->url('/collection/index'));
		}
		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	
	
	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		
		
		$identity = IdentityFactory::getIdentity();
		Yii::app()->user->login($identity);
		$this->redirect('index');
		
		
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{

		IdentityFactory::logout();
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
		
	}
}
