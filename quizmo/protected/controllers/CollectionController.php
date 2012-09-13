<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


class CollectionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','edit','admin','delete'),
				'roles'=>array('admin','super'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionCreate($id='')
	{
		$collection_id = $id;
		$collection = new Collection;
		// then this is a create action
		$title = Yii::app()->getRequest()->getParam('title');
		$description = Yii::app()->getRequest()->getParam('description');
		$user_id = Yii::app()->user->getId();
		
		
		if($title != ''){
			
			$collection_id = $collection->create($title, $description);
			if($collection_id != ''){
				// then add the user to the collection as an owner
				$userscollection = new UsersCollection;
				$ucid = $userscollection->addUserToCollection($user_id, $collection_id, 'owner');
				// now go to list
				$this->redirect('index');
				return;
			}
		}

		$this->render('create', array(
			'title' => $title,
			'description' => $description,
			'collection_id' => $collection_id
		));
		

	}

	/**
	 * Edits a model.
	 * If edit is successful, the browser will be redirected to the 'index' page.
	 *
	 * @todo implement collection::edit
	 */
	public function actionEdit($id)
	{
		$collection = new Collection;
		// then this is a create action
		$title = Yii::app()->getRequest()->getParam('title');
		$description = Yii::app()->getRequest()->getParam('description');
		$user_id = Yii::app()->user->getId();
		
		if($title != ''){
			// not implemented
			// $collection_id = $collection->edit($title, $description);
			if($collection_id != ''){
				$this->redirect('index');
				return;
			}
		}

		$this->render('edit', array(
			'id' => $id,
			'title' => $title,
			'description' => $description,
		));
		


	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{	
		$user_id = Yii::app()->user->id;
		
		$collections = UsersCollection::getCollectionArrayByUserId($user_id);
		//$collections = UsersCollection::getCollectionArrayAll();
		
		$this->render('index',array(
			//'dataProvider'=>$dataProvider,
			//'collectionLinks'=>$collectionLinks,
			'collections'=>$collections,
			'user_id'=>$user_id,
		));
		
		
	}

}
