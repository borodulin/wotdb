<?php

class WotController extends Controller
{
	public $layout='conquer';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

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
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('index','players', 'effect', 'glory'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated users to access all actions
			//	'users'=>array('@'),
				'users'=>array('*'),
			//	'expression'=>'WotPlayer::isClanPlayer($user->id)',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionPlayers()
	{
	//	$this->layout='column1';
		$this->render('players');
	}

	public function actionEffect()
	{
		//	$this->layout='column1';
		$this->render('effect');
	}

	public function actionMedals()
	{
		$this->render('medals');
	}

	public function actionTanks()
	{
		$this->render('tanks');
	}

	public function actionHangars()
	{
		$this->render('hangars');
	}

	public function actionActivity()
	{
		$this->render('activity');
	}

	public function actionProgress()
	{
		$this->render('progress');
	}

	public function actionPresense()
	{
		$this->render('presense');
	}

	public function actionPlayer()
	{
		$this->render('player');
	}

	public function actionPlayerdata($id)
	{
		echo json_encode(RptReport::execute('playerProgress',array('player'=>$id, 'stat'=>1)));
	}

	public function actionPlayertankdata($playerId,$date)
	{
		echo json_encode(RptReport::execute('playerProgressTanks',array('player_id'=>$playerId, 'date'=>$date)));
	}

	public function actionJqgrid() {
		$this->render('testjqgrid');
	}

	public function actionJqgriddata() {
		$rowsCount=$_GET['rows']==0?10:$_GET['rows'];
		$page=$_GET['page']==0?1:$_GET['page'];
		$dataProvider=new CActiveDataProvider('WotPlayer', array(
			'pagination'=>array(
				'pageSize'=>$rowsCount,
				'currentPage'=>$page-1,
			),
		));
		$responce->page = $page;
		$responce->records = $dataProvider->getTotalItemCount();
		$responce->total = ceil($responce->records / $rowsCount);
		$rows = $dataProvider->getData();
		foreach ($rows as $i=>$row) {
			$responce->rows[$i]['id']=$row->getPrimaryKey();
			$responce->rows[$i]['cell']=array($row->player_id,$row->player_name);
		}
		echo json_encode($responce);
	}

	public function actionTs()
	{
		//	header('Content-Type: text/html; charset=UTF-8');
		Yii::import('ext.teamspeak.libraries.TeamSpeak3.*',true);//cFsOcmiR
		// connect to local server, authenticate and spawn an object for the virtual server on port 9987
		$ts3_VirtualServer = TeamSpeak3::factory(Yii::app()->params['tsUri']);
		// build and display HTML treeview using custom image paths
		$this->renderText($ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html("/images/viewer/", "/images/flags/")));
		//echo $ts3_VirtualServer->getViewer(new TeamSpeak3_Viewer_Html("/images/viewer/", "/images/flags/"));

	}
	
	public function actionGk()
	{
		WotService::updateClanProvinces(WotClan::currentClan());
	}
	
	public function actionPost()
	{
		if(isset($_GET['new'])){
			
		}
		$this->render('post');
	}
	
	public function actionTest()
	{
		WotService::updateAchievments();
	}
	
	public function actionFame()
	{
		$this->render('fame');
	}

	public function actionGlory()
	{
		$this->render('glory');
	}
	
	public function actionUsefulness()
	{
		$this->render('usefulness');
	}
	
	public function actionPlayerTankProblem()
	{
		$this->render('playerTankProblem');
	}
}
