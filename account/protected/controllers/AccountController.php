<?php

class AccountController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CaptchaAction',
				'height'=>30,
				'minLength'=>4,
				'maxLength'=>4,
				'offset'=>1,
				'transparent'=>true,
				'width'=>80,
				'padding'=>1,
				'testLimit'=>999,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			//'page'=>array(
			//	'class'=>'CViewAction',
			//),
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',
			'actions'=>array('create','reset','resetfromyy','quickreg','verify',
					'test','mobilebook','sendverifyphonegame','sendverifyphone','verifyphonegame','captcha','authyy',
					'bindemailgame','cleartokengame','cleartokenmail','clearyy','verifygame',
					'verifycleartoken','loggingnoanswer','loggingnohelp','bindyy','bindmobilemail','stidlist','fhidlist','antiaddictiongame',
					'clear','gencardid','serverlist'
				),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('create','view', 'giftcenter',
					'update','password','sendverify', 'openbbs',
					'sendcleartokenmail','cleartoken','cleartokenmobile',
					'drawreward','drawrewardroll','rewardroll','activationkey','antiaddiction','sendclearyy',
					'bindmail','bindmobile','idlist'
				),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('admin','delete','index','clear'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function preFilter($maxCount) {
		$ip = Yii::app()->request->userHostAddress;
		$token = md5($ip."1OFSFjzQXKk1Pbcphw#@!");
		$url = $_SERVER['REQUEST_URI'];
		
		//Yii::log("RETURN PREFILTER POST ${ip} ${url} ${data}","error");
		if (isset($_COOKIE['token'])) {
			if ($token != $_COOKIE['token']) {
				return;
			}
			if (Yii::app()->cache->get($ip)) {
				$count = Yii::app()->cache->get($ip) + 1;
			} else {
			
				$count = 1;
			}

			if ($count>=$maxCount) {
				Yii::log("RETURN RETRY TOO MANY TIMES ${ip} ${url}","error");
				return;
			}
			Yii::app()->cache->set($ip,$count,24*3600);

		} else {
			echo '<script>var pto = new Date();pto.setTime(pto.getTime() + 300000);document.cookie = "token='.$token.';path=/;domain=gshx.greenyouxi.com;expires=" + pto.toGMTString();window.location.href="http://gshx.greenyouxi.com/account/index.php/account/create";</script>';
			return;
		}
		Yii::log("RETURN PREFILTER TRUE ${ip} ${url}","error");
		return true;
	}

	public function actionTest()
	{
		//var_dump($this->genNonvirtualRewardId("Q1"));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView()
	{
		$user = Yii::app()->user;
		if ($user->name === 'admin') {
			//$this->render('view',array(
			//	'model'=>$this->loadModel($id),
			//));
			;
		} else {
			$this->render('view',array(
				'model'=>$this->loadModel($user->id),
			));
		}
	}
	public function genCardId($prefix)
	{
		$counter = Counter::model()->findByPk($prefix);
		if (!$counter) {
			$counter = new Counter();
			$counter->name = $prefix;
			$counter->value = 0;
		}
		require_once('CardGenerator.php');
		$card_id = GenCode($prefix, $counter->value);
		$counter->value++;
		$counter->save();
		return $card_id;
	}

	public function actionGenCardId(){
		if (!$this->filterIp()) {
			return;
		}
		if (isset($_GET['prefix'])) {
			echo $this->genCardId($_GET['prefix']);
		}
	
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		//return $this->redirect("https://aq.yy.com/p/reg/mobile.do?appid=5584");

		Yii::import('application.vendors.*');

		//require_once('ipinfo.php');
		//$ip = $_SERVER["REMOTE_ADDR"];
		//$ipinfo = GetIpInfo($ip);
		//if ($ipinfo['city'] === "广州市") {
		//	return $this->redirect(array('site/notyet'));
		//}
		//
		
		//if (!$this->preFilter(10)) {
		//	return;
		//}
		$model=new Account("create");

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Account']))
		{
			Yii::import('application.vendors.*');
			require_once('ucenter.php');

			$_POST['Account']['email'] = strtolower($_POST['Account']['email']);

			$origin_account = $_POST['Account']['account'];
			$model->originpassword = $_POST['Account']['password'];
			$origin_email = $_POST['Account']['email'];

			$salt = $model->generateSalt();
			$_POST['Account']['password'] =
				$model::crypt(md5($_POST['Account']['password']), $salt);
			$_POST['Account']['confirm'] =
				$model::crypt(md5($_POST['Account']['confirm']), $salt);
			$model->attributes=$_POST['Account'];
			if (isset($_GET['from'])) {
				$model->from = $_GET['from'];
			}
			else{
				if (isset($_COOKIE['from'])) {
					$model->from = $_COOKIE['from'];
				}
			}

			if($model->save()) {
				//$this->redirect(array('view','id'=>$model->id));
				//uc_user_register($origin_account, $model->originpassword, $origin_email);
				//if (isset($_GET['from'])) {   // 来源跟踪
				//	$activation = new Activation();
				//	$activation->account_id = $model->id;
				//	$activation->product_id = 3;
				//	$activation->key = $_GET['from'];
				//	$activation->save();
				//}
				//if ($model->verified==0 && $this->sendVerifyMail($model)) {
				//	Yii::app()->user->setState('info', "恭喜！你已经成功注册，现在可以登录了。同时验证邮件已发送至安全邮箱，请尽快登录邮箱验证。");
				//} else {
					Yii::app()->user->setState('info', "恭喜！你已经成功注册，现在可以登录了：");
				//}
				//stat_log("REGISTER");
				$this->redirect(array('site/login'));
				return;
			}
			$model->password="";
			$model->confirm="";
		}

		$this->render('_form',array(
			'model'=>$model,
		));
	}
	
	public function actionQuickReg()
	{
		$model=new Account("quickreg");

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Account']))
		{
			Yii::import('application.vendors.*');
			require_once('ucenter.php');
			//$_POST['Account']['email'] = strtolower($_POST['Account']['email']);

			$origin_account = $_POST['Account']['account'];
			$model->originpassword = $_POST['Account']['password'];
			//$origin_email = $_POST['Account']['email'];

			$salt = $model->generateSalt();
			$_POST['Account']['password'] =
				$model::crypt(md5($_POST['Account']['password']), $salt);
			$_POST['Account']['confirm'] =
				$model::crypt(md5($_POST['Account']['confirm']), $salt);
			$model->attributes=$_POST['Account'];
			$model->idcard="";
			if (isset($_GET['from'])) {
				$model->from = $_GET['from'];
			}
			else{
				if (isset($_COOKIE['from'])) {
					$model->from = $_COOKIE['from'];
				}
			}
			if($model->save()) {
				//uc_user_register($origin_account, $model->originpassword, $origin_email);
				//if ($model->verified==0 && $this->sendVerifyMail($model)) {
				//	Yii::app()->user->setState('info', "恭喜！你已经成功注册，现在可以登录了。同时验证邮件已发送至安全邮箱，请尽快登录邮箱验证。");
				//} else {
				Yii::app()->user->setState('info', "恭喜！你已经成功注册，现在可以登录了：");
				//}
				//stat_log("REGISTER");
				if (!Yii::app()->user->isGuest) {
					Yii::app()->user->logout(false);
				}
				$identity = new UserIdentity($model->account,md5($model->originpassword));
				$identity->authenticate();
				Yii::app()->user->login($identity, 0);
				//发官方媒体礼包
				//$card_id = $this->genCardId("8UP");
				//
				//广告用户直接激活
				//if ($model->from){
				//	$activation = new Activation();
				//	$activation->account_id = $model->id;
				//	$activation->product_id = 3;
				//	$activation->key = $model->from;
				//	$activation->save();
				//}
				//$this->renderPartial('quickregok', array('url'=>'site/login','model'=>$model,'card'=>$card_id), false, true);
				return true;
			}
			$model->password="";
			$model->confirm="";
		}

		$this->renderPartial('quickreg',array(
			'model'=>$model,
		), false, true);
	}

	public function actionOpenBBS()
	{
		$user = Yii::app()->user;
		if ($user->name !== 'admin') {
			$id = $user->id;
		}
		$model=$this->loadModel($id);
		$model->scenario = "openbbs";

		Yii::import('application.vendors.*');
		require_once('ucenter.php');
		$uc_user = uc_get_user($model->account);
		if ($uc_user) {
			Yii::app()->user->setState(
				'info', "论坛账号已经开通，请使用游戏账号登录论坛。");
		}

		if(isset($_POST['Account']))
		{
			$model->attributes=$_POST['Account'];

			if ($model->validate()) {
				$ret = uc_user_register($model->account, $model->originpassword, $model->email, $model->nickname);
				if ($ret < 0) {
					if ($ret == -4) {
						$info = "请填写电子邮件！";
					} else {
						$info = "未知错误：${ret}！";
					}
					Yii::app()->user->setState(
						'info', $info);
				} else {
					Yii::app()->user->setState(
						'info', "已经成功为您开通了论坛。");
					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}
		$this->render('openbbs',array(
			'model'=>$model,
		));
	}

	public function actionPassword($id)
	{
		$user = Yii::app()->user;
		if ($user->name !== 'admin') {
			$id = $user->id;
		}
		$model=$this->loadModel($id);
		$model->scenario = "password";

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Account']))
		{
			$model->originpassword = $_POST['Account']['password'];

			$salt = $model->generateSalt();
			$_POST['Account']['password'] =
				$model::crypt(md5($_POST['Account']['password']), $salt);
			$_POST['Account']['confirm'] =
				$model::crypt(md5($_POST['Account']['confirm']), $salt);
			$model->attributes=$_POST['Account'];

			if($model->save()) {
				//Yii::import('application.vendors.*');
				//require_once('ucenter.php');
				//$uc_user = uc_get_user($model->account);
				//if ($uc_user) {
				//	uc_user_edit($model->account, "", $model->originpassword, "", 1);
				//} else {
				//	uc_user_register($model->account, $model->originpassword, $model->email);
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$model->password="";
		$model->confirm="";
		$this->render('password',array(
			'model'=>$model,
		));
	}

	public function actionReset($id)
	{
		$reset = Reset::model()->findByPk($id);
		if (!$reset) {
			throw new CHttpException(404, "无效的重置链接");
		}
		if ((time()-strtotime($reset->time))>3600*24) {
			$reset->delete();
			throw new CHttpException(404, "无效的重置链接");
		}
		
		$model=$this->loadModel($reset->account_id);
		$model->scenario = "reset";

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Account']))
		{
			$model->originpassword = $_POST['Account']['password'];

			$salt = $model->generateSalt();
			$_POST['Account']['password'] =
				$model::crypt(md5($_POST['Account']['password']), $salt);
			$_POST['Account']['confirm'] =
				$model::crypt(md5($_POST['Account']['confirm']), $salt);
			$model->attributes=$_POST['Account'];

			if($model->save()) {
			//	Yii::import('application.vendors.*');
			//	require_once('ucenter.php');
			//	uc_user_edit($model->account, "", $model->originpassword, "", 1);
			//	$reset->delete();
				Yii::app()->user->setState('info', "你已经成功重置密码，现可以使用新密码登录了：");
				$this->redirect(array('site/login'));
			}
		}
		$model->password="";
		$model->confirm="";
		$this->render('reset',array(
			'model'=>$model,
			'id'=>$reset->key,
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$user = Yii::app()->user;
		if ($user->name !== 'admin') {
			$id = $user->id;
		}
		$model=$this->loadModel($id);
		$model->scenario = "update";

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		/*
		if(isset($_POST['Account']))
		{
			if (!isset($_POST['Account']['email'])) {
				$_POST['Account']['email'] = $model->getOldEmail() ? $model->getOldEmail() : "";
			}
			$_POST['Account']['email'] = strtolower($_POST['Account']['email']);

			if (!isset($_POST['Account']['idcard'])) {
				$_POST['Account']['idcard'] = $model->getOldIdCard() ? $model->getOldIdCard() : "";
			}
			if (!isset($_POST['Account']['mobile'])) {
				$_POST['Account']['mobile'] = $model->getOldMobile() ? $model->getOldMobile() : "";
			}
			if (!isset($_POST['Account']['name'])) {
				$_POST['Account']['name'] = $model->getOldName() ? $model->getOldName(): "";
			}

			$model->attributes=$_POST['Account'];
			if($model->save()) {
				Yii::import('application.vendors.*');
				require_once('ucenter.php');
				uc_user_edit($model->account, "", "", $model->email, 1);
				if ($model->verified == 0) {
					if ($this->sendVerifyMail($model)) {
						Yii::app()->user->setState(
							'info', "验证邮件已发送至您新提交的邮箱，为了您账号的安全，请尽快登录邮箱进行验证。");
					} else {
						Yii::app()->user->setState(
							'info', "验证邮件发送失败，请确认邮箱地址填写正确。");
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		*/

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Account');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Account('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Account']))
			$model->attributes=$_GET['Account'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Account the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Account::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Account $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-form')
		{;
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function sendVerifyMail($model,$view="verify")
	{
		$verify = new Verify();
		$verify->key = md5(uniqid('', true));
		$verify->account_id = $model->id;
		$verify->email = $model->email;

		if (!$verify->email) {
			throw new CHttpException(403, "邮箱未设置。");
		}

		if ($model->verified == 0) {
			$account = Account::model()->find('`email`=? AND `verified`=1',
				array($verify->email));
			if ($account) {
				throw new CHttpException(403, "邮箱已经被别的账号验证，一个邮箱只能用于验证一个账号。");;
			}
		}

		$exist_verify = Verify::model()->findBySql(
			"SELECT * FROM `verify` WHERE account_id=? AND email=? ORDER BY `time` DESC LIMIT 1",
			array($verify->account_id, $verify->email));
		if ($exist_verify) {
			if ((time()-strtotime($exist_verify->time)) < 300) {
				throw new CHttpException(403, "请勿过于频繁地发送验证邮件。");
			}
		}

		if (!$verify->save()) {
			throw new CHttpException(500, "验证邮件无法创建。");
		}

		$message = $this->renderPartial($view, array(
			"token"=>$verify->key,
		), true);

		$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
		$mailer->Host = "127.0.0.1";
		$mailer->Port = 25;
		$mailer->IsSMTP();
		#$mailer->SMTPAuth = true;
		#$mailer->SMTPSecure = "ssl";
		#$mailer->Username = "webmaster@dxqzol.com";
		#$mailer->Password = "lianpeng123";
		$mailer->CharSet = "UTF-8";
		$mailer->SetFrom("webmaster@dxqzol.com", "拍拍富用户中心");
		$mailer->AddAddress($model->email);
		$mailer->Subject = "拍拍富邮箱验证";
		$mailer->MsgHTML($message);

		$ret = $mailer->send();
		return $ret ? true : false;
	}

	public function sendClearTokenMail($model)
	{
		$cleartoken = new Cleartoken();
		$cleartoken->key = md5(uniqid('', true));
		$cleartoken->account_id = $model->id;

		if ($model->verified == 0) {
			throw new CHttpException(403, "邮箱未验证，不能清除口令。");
		}

		$exist_cleartoken = Cleartoken::model()->findBySql(
			"SELECT * FROM `cleartoken` WHERE account_id=? ORDER BY `time` DESC LIMIT 1",
			array($cleartoken->account_id));
		if ($exist_cleartoken) {
			if ((time()-strtotime($exist_cleartoken->time)) < 300) {
				throw new CHttpException(403, "请勿过于频繁地发送口令清除邮件。");
			}
		}

		if (!$cleartoken->save()) {
			throw new CHttpException(500, "口令清除无法创建。");
		}

		$message = $this->renderPartial("cleartoken", array(
			"name"=>$model->getCallName(),
			"account"=>$model->account,
			"token"=>$cleartoken->key,
		), true);

		$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
		$mailer->Host = "127.0.0.1";
		$mailer->Port = 25;
		$mailer->IsSMTP();
		#$mailer->SMTPAuth = true;
		#$mailer->SMTPSecure = "ssl";
		#$mailer->Username = "webmaster@dxqzol.com";
		#$mailer->Password = "lianpeng123";
		$mailer->CharSet = "UTF-8";
		$mailer->SetFrom("webmaster@dxqzol.com", "拍拍富用户中心");
		$mailer->AddAddress($model->email);
		$mailer->Subject = "拍拍富口令清除";
		$mailer->MsgHTML($message);

		$ret = $mailer->send();
		return $ret ? true : false;
	}

	public function actionVerify($id)
	{
		$verify = Verify::model()->findByPk($id);
		if (!$verify) {
			throw new CHttpException(404, "无效的验证链接");
		}
		if ((time()-strtotime($verify->time))>3600*24) {
			$verify->delete();
			throw new CHttpException(404, "无效的验证链接");
		}

		$model=$this->loadModel($verify->account_id);

		if ($verify->email != $model->email) {
			$verify->delete();
			throw new CHttpException(404, "验证邮箱地址错误");
		}

		$model->verified = 1;

		if ($model->save()) {
			$verify->delete();
			Yii::app()->user->setState('info', "安全邮箱已经成功验证。");
			if (Yii::app()->user->isGuest) {
				$this->redirect(array('site/login'));
			} else {
				$this->redirect(array('view', 'id'=>Yii::app()->user->getId()));
			}
		}
	}


	public function renderResult($Msg){
		$this->renderPartial('result',array(
			"msg" => $Msg,
		), false, true);
	}
		
	public function actionVerifyGame($id)
	{
		$verify = Verify::model()->findByPk($id);
		if (!$verify) {
			$this->renderResult("无效的验证链接");
			return false;
		}
		if ((time()-strtotime($verify->time))>3600*24) {
			$verify->delete();
			$this->renderResult("无效的验证链接");
			return false;
		}

		$model=$this->loadModel($verify->account_id);
		$model->scenario = 'update';

		if ($verify->email != $model->email) {
			$verify->delete();
			$this->renderResult("验证邮箱地址错误");
			return false;
		}

		$model->verified = 1;

		if ($model->save()) {
			$verify->delete();
			$this->renderResult("安全邮箱已经成功验证，重新登录游戏设置生效。");
		}
		//return true;
	}

	public function actionSendVerify()
	{
		$model = $this->loadModel(Yii::app()->user->id);
		if (!$model) {
			throw new CHttpException(404, "账户不存在");
		}
		if ($this->sendVerifyMail($model)) {
			Yii::app()->user->setState(
				'info', "验证邮件已经发送，请登录邮箱进行验证。");
		} else {
			Yii::app()->user->setState(
				'info', "验证邮件发送失败，请确认邮箱地址填写正确。");
		}
		$this->redirect(array('view','id'=>$model->id));
	}

	public function actionSendClearTokenMail()
	{
		$model = $this->loadModel(Yii::app()->user->id);
		if (!$model) {
			throw new CHttpException(404, "账户不存在");
		}
		if ($this->sendClearTokenMail($model)) {
			Yii::app()->user->setState(
				'info', "口令清除邮件已经发送，请登录安全邮箱清除口令。");
		} else {
			Yii::app()->user->setState(
				'info', "口令清除邮件发送失败。");
		}
		$this->redirect(array('view','id'=>$model->id));
	}

	public function actionClearTokenMail($id)
	{
		$cleartoken = Cleartoken::model()->findByPk($id);
		if (!$cleartoken) {
			throw new CHttpException(404, "无效的验证链接");
		}
		if ((time()-strtotime($cleartoken->time))>3600*24) {
			$cleartoken->delete();
			throw new CHttpException(404, "无效的验证链接");
		}
		$model = $this->loadModel($cleartoken->account_id);
		$cleartoken->delete();
		Yii::app()->db->createCommand("DELETE FROM `accattr` WHERE `account_id`=$cleartoken->account_id AND `attr`=\"token\"")->execute();
		Yii::app()->user->setState('info', "您的安全口令已经清除，请尽快进入游戏重新设置口令。");
		$this->redirect(array('view', 'id'=>Yii::app()->user->getId()));
	}
	
	//public function actionGiftCenter()
	//{
	//	$model = $this->loadModel(Yii::app()->user->id);
	//	if (!$model) {
	//		throw new CHttpException(404, "账户不存在");
	//	}
	//	# 所有的奖励卡将以 RW*** 的形式发到玩家属性
	//	$criteria = new CDbCriteria();

	//	$criteria->compare('account_id', $model->id);	
	//	$criteria->addCondition('attr LIKE "DXQZ_GIFT%"');

	//	$count = Accattr::model()->count($criteria);
	//	$pages = new CPagination($count);

	//	$pages->pageSize = 20;
	//	$pages->applyLimit($criteria);

	//	$models = Accattr::model()->findAll($criteria);
	//	
	//	$this->render('giftcenter', array(
	//		'models'=>$models,
	//		'pages'=>$pages,
	//	));
	//}
	public function actionGiftCenter()
	{
		$model = $this->loadModel(Yii::app()->user->id);
		if (!$model) {
			throw new CHttpException(404, "账户不存在");
		}
		# 所有的奖励卡将以 RW*** 的形式发到玩家属性
		$criteria = new CDbCriteria();

		$criteria->compare('account_id', $model->id);	
		$criteria->addCondition('expire>current_timestamp()');

		$count = GiftCenter::model()->count($criteria);
		$pages = new CPagination($count);

		$pages->pageSize = 20;
		$pages->applyLimit($criteria);

		$models = GiftCenter::model()->findAll($criteria);
		
		$this->render('giftcenter', array(
			'models'=>$models,
			'pages'=>$pages,
		));
	}
/*
	public function renderReward($reward, $model)
	{
		$prefix = substr($reward->value, 0, 4);

		$CardPrefix2DrawPrefix = array(
			"ABoB" => "L1",
			"ABoy" => "L2",
			"ABoC" => "L3",
			"ABox" => "L4",
		);

		if (isset($CardPrefix2DrawPrefix[$prefix])) {
			$prefix = $CardPrefix2DrawPrefix[$prefix];
		} else {
			$prefix = substr($reward->value, 0, 2);
		}

		$this->render('reward', array(
			'model'=>$model,
			'info'=>$prefix,
			'key'=>$reward->value,
		));
		return;
	}

	public function getRewardKey()
	{
		return "RW20140815";
	}

	public function updateAccountReward($model, $id)
	{
		$reward = new Accattr();
		$reward->account_id = $model->id;
		$reward->attr = $this->getRewardKey();
		$reward->value = $id;
		$reward->save();
	}

	public function getAccountReward($model)
	{
		$attr = Accattr::model()->findBySql(
			"SELECT * FROM `accattr` WHERE account_id=? AND attr=?",
			array($model->id, $this->getRewardKey()));
		return $attr;
	}

	public function genNonvirtualRewardId($prefix)
	{
		$PrefixMax = array(
			'IP' => 0,
			'MU' => 5,
			'Q3' => 20,
			'Q1' => 50,
		);

		if (!isset($PrefixMax[$prefix])) {
			return false;
		}
		$limit = $PrefixMax[$prefix];

		$counter = Counter::model()->findByPk($prefix);
		if (!$counter) {
			$counter = new Counter();
			$counter->name = $prefix;
			$counter->value = 0;
		}

		if ($counter->value >= $limit) {
			return false;
		}
		$counter->value++;
		$counter->save();

		$code = substr($prefix.md5(time()), 0, 20);

		return $code;
	}

	public function drawGiftCard($model, $prefix)
	{
		$card_id = $this->genNonvirtualRewardId($prefix);
		if ($card_id) {
			$this->updateAccountReward($model, $card_id);
			return true;
		}

		$DrawPrefix2CardPrefix = array(
			"L1" => "ABMu",
			"L2" => "ABM2",
			"L3" => "ABMG",
			"L4" => "ABM.",
		);
		$card_id = $this->genCardId($DrawPrefix2CardPrefix[$prefix]);
		$this->updateAccountReward($model, $card_id);

		return true;
	}
 */	
	/*
	public function drawGiftCard($model, $prefix,$angle)
	{
		$card = Card::model()->find("`distributed`=0 AND `id` LIKE '${prefix}%'");
		if ($card) {

			$card->distributed = 1;
			$card->save();

			$reward = new Accattr();
			$reward->account_id = $model->id;
			$reward->attr = "RW20131018";
			$reward->value = $card->id;
			$reward->save();

			#$this->renderReward($reward, $model);
			return true;
		}
		$re = array();
		$re['angle'] = $angle;
		$re['prize'] = "此项奖品已经发完！，请重新抽奖！";
		echo json_encode($re);
		return false;
	}
	*/
	
/*
	public function actionDrawReward()
	{
		# 2013年10月1日的国庆抽奖活动
		$model = $this->loadModel(Yii::app()->user->id);
		if (!$model) {
			throw new CHttpException(404, "账户不存在");
		}

		$begintime = date("Y-m-d H:i:s",mktime( 0, 0, 0,10,7,2013));
		$endtime   = date("Y-m-d H:i:s",mktime(23,59,59,10,10,2013));
		$nowtime   = date("Y-m-d H:i:s",time());
		if ($nowtime< $begintime or $nowtime> $endtime ) {
			$this->render("reward", array(
				'model'=>$model,
				'info'=>"not_yet",
				'key'=>'',
			));
			return;
		}

		# 如果没有参与资格	
		$attr = Accattr::model()->findBySql(
			"SELECT * FROM `accattr` WHERE account_id=? AND attr='OR_NationalSign'",
			array($model->id));
		if (!$attr) {
			$this->render('reward', array(
				'model'=>$model,
				'info'=>"no_sign_7_days",
				'key'=>'',
			));
			return;
		}
		# 如果已经抽了奖
		$reward = Accattr::model()->findBySql(
			"SELECT * FROM `accattr` WHERE account_id=? AND attr='RW20140131'",
			array($model->id));
		if ($reward) {
			return $this->renderReward($reward, $model);
		}

		# 开始抽奖
		# 如果没有验证邮箱
		if ($model->verified == 0) {
			$this->render('reward', array(
				'model'=>$model,
				'info'=>"no_verify_email",
				'key'=>'',
			));
			return;
		}

		# 开始根据概率抽奖，概率如下：
		$randvalue = rand(0, 9999);
		if ($randvalue < 0) {
			if ($this->drawGiftCard($model, "IP"))
				return;
		} elseif ($randvalue < 8) {
			if ($this->drawGiftCard($model, "MU"))
				return;
		} elseif ($randvalue < 8+25) {
			if ($this->drawGiftCard($model, "QB"))
				return;
		} elseif ($randvalue < 8+25+2000) {
			if ($this->drawGiftCard($model, "L1"))
				return;
		} elseif ($randvalue < 8+25+2000+2000) {
			if ($this->drawGiftCard($model, "L2"))
				return;
		} elseif ($randvalue < 8+25+2000+2000+2500) {
			if ($this->drawGiftCard($model, "L3"))
				return;
		} elseif ($randvalue < 8+25+2000+2000+2500+3000) {
			if ($this->drawGiftCard($model, "L4"))
				return;
		}
		$this->drawGiftCard($model, "L5");
	}
 */	

	public function renderReward_1($reward, $model)
	{
		$prefix = substr($reward->value, 0, 4);

		$CardPrefix2DrawPrefix = array(
			"ABMu" => "L1",
			"ABM2" => "L2",
			"ABMG" => "L3",
			"ABM." => "L4",
		);

		if (isset($CardPrefix2DrawPrefix[$prefix])) {
			$prefix = $CardPrefix2DrawPrefix[$prefix];
		} else {
			$prefix = substr($reward->value, 0, 2);
		}

		$this->render('reward_1', array(
			'model'=>$model,
			'info'=>$prefix,
			'key'=>$reward->value,
		));
		return;
	}


	public function returnRollResult($pos, $message)
	{
		# 转盘的位置编号:
		#      4    5
		#
		#   3           6
		#
		#   2           7
		#
		#      1    8
		$disk2angle = array(
			1 => 22,
			2 => 67,
			3 => 112,
			4 => 157,
			5 => 203,
			6 => 248,
			7 => 293,
			8 => 338,
		);
		$angle = -1799;
		if (isset($disk2angle[$pos])) {
			$angle = $disk2angle[$pos];
		}
		$result['angle'] = $angle;
		$result['prize'] = $message;
		echo json_encode($result);
		return;
	}

	public function actionMobileBook(){
		if (isset($_GET['mobile'])) {
			//验证手机号码格式
			$phone = $_GET['mobile'];
			$isphone = "/^1[3-9]{1}[0-9]{9}$/";
			if(!preg_match($isphone, $phone)){
				return false;
			}
			////防止恶意预约
			$ip = $_SERVER["REMOTE_ADDR"];
			//$exist_ip = Mobile::model()->findBySql(
			//	"SELECT * FROM `mobile` WHERE ip=? ORDER BY `time` DESC LIMIT 1",
			//	array($ip));

			//if($exist_ip){
			//	if ((time()-strtotime($exist_ip->time)) < 100){
			//		return false;	
			//	}
			//}
			//已经存在的
			$exist_mobile = Mobile::model()->findBySql(
				"SELECT * FROM `mobile` WHERE mobile=?",
				array($phone));
			if ($exist_mobile) {
				return true;
			}
			$module = new Mobile();
			$module->mobile = $phone;
			$module->ip = $ip;
			$module->time = date("Y-m-d H:i:s");
			return $module->save();
		}
		return false;
	}

	public function sendVerifyPhone($phone){

		Yii::import('application.vendors.*');
		require_once("sms.php");

		return SendVerify($phone);
	}

	public function actionSendVerifyPhoneGame() {
		if (!$this->filterIp()) {
			return;
		}
		if(isset($_POST['Account'])){
			$account = $_POST['Account']['account'];
			$model = Account::model()->find("account=:account",
				array(":account"=>$account));	
			if (!$model) {
				echo($this->JSON(array("code"=>-1,"msg"=>"账号不存在。" )));
				return;
			}
			/*
			if (date("Y-m") === date("Y-m",strtotime($model->verifiedmobile_time)) ) {
				echo($this->JSON(array("code"=>-1,"msg"=>"本月已经验证过手机号码。" )));
				return;
			}
			 */
			$phone = null;
			if (isset($_POST['Account']['phone'])) {
				$phone = $_POST['Account']['phone'];
	
			} else {
				$phone = $model->verifiedmobile;
			}

			$isphone = "/^1[3-9]{1}[0-9]{9}$/";
			if(!preg_match($isphone, $phone)){
				echo($this->JSON(array("code"=>-1,"msg"=>"请输入正确的手机号码。" )));
				return;
			}
			
			if (!$model->verifiedmobile) {
				$count = Account::model()->count('`verifiedmobile`=?',array($phone));
				if ($count >= 10) {
					echo($this->JSON(array("code"=>-1,"msg"=>"1个手机号码最多只能绑定10个账号。")));
					return;
				}
			}

			$cache = Yii::app()->cache->get($phone);
			if ($cache) {
				if (time()-$cache['time'] < 120){
					echo($this->JSON(array("code"=>-1,"msg"=>"请勿频繁发送验证短信。" )));
					return;	
				}
				if (date('Y-m-d') !== date('Y-m-d',$cache['time'])) {
					$cache['today_send_times'] = 0;
				}
				if ($cache['today_send_times'] >= 50) {
					echo($this->JSON(array("code"=>-1,"msg"=>"今日验证短信发送次数超过50次，明天再来试试吧。" )));
					return;	
				}
				if (date('Y-m') !== date('Y-m',$cache['time']) ) {
					$cache['month_send_times'] = 0;
				}
				if ($cache['month_send_times'] >= 100) {
					echo($this->JSON(array("code"=>-1,"msg"=>"本月验证短信发送次数超过100次，下个月再来试试吧。" )));
					return;	
				}
			}
			if (!$this->sendVerifyPhone($phone)) {
				echo($this->JSON(array("code"=>-1,"msg"=>"验证短信发送失败。" )));
				return;
			}
			echo($this->JSON(array("code"=>0,"msg"=>"验证短信发送成功。" )));
		}
	}

	public function actionVerifyPhoneGame(){
		if (!$this->filterIp()) {
			return;
		}
		if(isset($_POST['Account'])){
			$account = $_POST['Account']['account'];
			$model = Account::model()->find("account=:account",
				array(":account"=>$account));	
			if (!$model) {
				echo($this->JSON(array("code"=>-1,"msg"=>"账号不存在。" )));
				return;
			}
			/*
			if (date("Y-m") === date("Y-m",strtotime($model->verifiedmobile_time)) ) {
				echo($this->JSON(array("code"=>-1,"msg"=>"本月已经验证过手机号码。" )));
				return;
			}
			 */
			if ($model->verifiedmobile) {
				echo($this->JSON(array("code"=>-1,"msg"=>"该账号已经绑定手机。")));
				return;
			}

			//发邮件验证
			if ($model->email && $model->verified == 1) {
				if ($this->sendVerifyMailGame($model,'bindmobilemail')) {
					echo($this->JSON(array("code"=>1,"msg"=>"绑定手机邮件已发送至您的安全邮箱".$model->email."，请尽快登录邮箱进行验证。")));
				} else {
					echo($this->JSON(array("code"=>-1,"msg"=>"绑定手机号码验证邮件发送失败，请稍后重试或者联系客服。")));
				}
				return;
			}

			$phone = $_POST['Account']['phone'];
			$count = Account::model()->count('`verifiedmobile`=?',array($phone));
			if ($count >= 10) {
				echo($this->JSON(array("code"=>-1,"msg"=>"1个手机号码最多只能绑定10个账号。")));
				return;
			}

			$cache = Yii::app()->cache->get($phone);
			if (!$cache){
				echo($this->JSON(array("code"=>-1,"msg"=>"验证码不存在。" )));
				return;
			}
			if ($cache['randcode'] !== $_POST['Account']['randcode']) {
				echo($this->JSON(array("code"=>-1,"msg"=>"验证码错误。" )));
				return;
			}
			
			$model->scenario = "verifymobile";
			$model->verifiedmobile = $phone;
			$model->verifiedmobile_time = date('Y-m-d H:i:s');
			if (!$model->save()) {
				echo($this->JSON(array("code"=>-1,"msg"=>"手机验证失败。" )));
				return;
			}
			Yii::app()->cache->delete($phone);
			echo($this->JSON(array("code"=>0,"msg"=>"手机验证成功。" )));
		}
	}
	
	public function actionClearTokenGame(){
		if (!$this->filterIp()) {
			return;
		}
		if(isset($_POST['Account'])){
			$account = $_POST['Account']['account'];
			$model = Account::model()->find("account=:account",
				array(":account"=>$account));	
			if (!$model) {
				echo($this->JSON(array("code"=>-1,"msg"=>"账号不存在。" )));
				return;
			}
			if (!$model->verifiedmobile) {
				echo($this->JSON(array("code"=>-1,"msg"=>"该账号未绑定手机。")));
				return;
			}
			$phone = $model->verifiedmobile;
			$cache = Yii::app()->cache->get($phone);
			if (!$cache){
				echo($this->JSON(array("code"=>-1,"msg"=>"验证码不存在。" )));
				return;
			}
			if ($cache['randcode'] !== $_POST['Account']['randcode']) {
				echo($this->JSON(array("code"=>-1,"msg"=>"验证码错误。" )));
				return;
			}
			
			Yii::app()->cache->delete($phone);
			Yii::app()->db->createCommand("DELETE FROM `accattr` WHERE `account_id`=$model->id AND `attr`in ('token', 'bindmac')")->execute();
			echo($this->JSON(array("code"=>0,"msg"=>"安全口令成功清除。" )));
		}
	}


	public function actionClear() {
		 Yii::app()->cache->flush();
		 Yii::app()->session->clear();
		 Yii::app()->session->destroy();
		 echo("clear succ");
	}

	public function genActivationKey(){
		$counter = Counter::model()->findBySql(
			"SELECT * FROM `counter` WHERE name=? ORDER BY `time` DESC LIMIT 1",
			array("ILT"));
		if ($counter) {
			//if ($counter->value>=150) {
			//	return false;
			//}
			;
		}
		else {
			$counter = new Counter();
			$counter->name = "ILT";
			$counter->value = 0;
		}
		require_once("CardGenerator.php");
		$card_id = GenCode("ILT", $counter->value);
		$counter->value++;
		$counter->save();
		return $card_id;
		//echo json_encode(array("key"=>$card_id));
	}

	public function actionActivationKey(){
		$account_id = Yii::app()->user->getId();
		$old_activation = Activation::model()->find("account_id=:account_id",
			array(":account_id"=>$account_id));
		if ($old_activation) {
			$this->render('keydeliver', array('key'=>false,'res_code'=>'你已经激活过游戏了'));
			return true;
		}
		$card_id = $this->genActivationKey();
		if ($card_id) {
			$this->render('keydeliver', array('key'=>$card_id));
			//$new_activation = new Activation();
			//$new_activation->account_id = $account_id;
			//$new_activation->product_id = 3;
			//$new_activation->key = $card_id;
			//if ($new_activation->save()) {
			//	$this->render('//site/actsucc', array('model'=>$new_activation));
			//}
		}
		else{
			$this->render('keydeliver', array('key'=>$card_id,'res_code'=>'对不起！今天的激活码已经发放完毕，每天限量150个。'));
		}
		return true;
	}

	public function actionAntiaddiction(){
		$user = Yii::app()->user;
		if ($user->name !== 'admin') {
			$id = $user->id;
		}
		$model=$this->loadModel($id);
		if ($model->idcard && $model->idcard !== "" && $model->name && $model->name !== "") {
				$this->redirect(array('view','id'=>$model->id));
				return;
		}
		$model->scenario = "antiaddiction";

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Account']))
		{
			$model->attributes=$_POST['Account'];
			if($model->save()) {
				Yii::app()->user->setState(
					'info', "防沉迷验证成功。");
				$this->redirect(array('view','id'=>$model->id));
				//$this->render('antisucc', array('model'=>$model));
				return;
			}
		}
		$this->render('antiaddiction',array(
			'model'=>$model,
		));
	}
	public function actionAntiaddictionGame(){
		//if (!$this->filterIp()) {
		//	return;
		//}
		if(isset($_POST['Account'])){
			$account = $_POST['Account']['account'];
			$model = Account::model()->find("account=:account",
				array(":account"=>$account));	
			if (!$model) {
				echo($this->JSON(array("code"=>-1,"msg"=>"账号不存在。" )));
				return;
			}
			$idcard = $_POST['Account']['idcard'];
			if (!Yii::app()->idcard->isIdNum($idcard)) {
				echo($this->JSON(array("code"=>-1,"msg"=>"不是合法的身份证号码。" )));
				return;
			}
			if (!Yii::app()->idcard->isAdult($idcard)) {
				echo($this->JSON(array("code"=>-1,"msg"=>"您未满十八岁，无法通过防沉迷验证。" )));
				return;
			}

			$model->scenario = "antiaddiction";
			$model->name = $_POST['Account']['name'];
			$model->idcard = $_POST['Account']['idcard'];

			if (!$model->save()) {
				echo($this->JSON(array("code"=>-1,"msg"=>"防沉迷验证失败。" )));
				return;
			}
			echo($this->JSON(array("code"=>0,"msg"=>"防沉迷验证成功。" )));
			
		}

	}

	public function uuid() {
	    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        // 32 bits for "time_low"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
	
	        // 16 bits for "time_mid"
	        mt_rand( 0, 0xffff ),
	
	        // 16 bits for "time_hi_and_version",
	        // four most significant bits holds version number 4
	        mt_rand( 0, 0x0fff ) | 0x4000,
	
	        // 16 bits, 8 bits for "clk_seq_hi_res",
	        // 8 bits for "clk_seq_low",
	        // two most significant bits holds zero and one for variant DCE1.1
	        mt_rand( 0, 0x3fff ) | 0x8000,
	
	        // 48 bits for "node"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	    );
	}

	public function actionBindyy(){
		#if (Account::isBindYY(Yii::app()->user->id)) {
		#	throw new CHttpException(403, "您的账号已经绑定了YY。");
		#}
		$url = "https://thirdlogin.yy.com/oauth2/authorize_client.do?";
		$param['redirect_uri']= "redirect_uri=http://gshx.greenyouxi.com/account/index.php/account/authyy";
		$param['client_id'] = "client_id=5588";
		$state = $this->uuid();
		$param['state'] = "state=".$state;

		#Yii::app()->cache->set($state,Yii::app()->user->id,1200);
		$param['display'] = "display=web";
		$param['response_type'] = "response_type=code";
		$url .= implode("&",$param);
		$this->redirect($url);
		return;
	}

	public function actionAuthyy(){
		#if (isset($_GET['code']) && isset($_GET['server_sig']) && isset($_GET['state']) ) {
		if (isset($_GET['code']) && isset($_GET['server_sig']) ) {
			//$account_id = Yii::app()->cache->get($_GET['state']);
			//if (!$account_id) {
			//	$this->render('bindyyfail', array('model'=>null));
			//	return;
			//}	
			//验证
			$secret='inXGjkkn2D7Io3xkN4RGGGjiRX8YX1j7';
			$sign = SHA1('code='.$_GET['code'].'state='.$_GET['state'].$secret);
			if ( $sign != $_GET['server_sig'] ) {
				$this->render('bindyyfail', array('model'=>null));
				return;
			}
			$url = "http://api.dylogin.game.yy.com/access";
			$appId ='3019';
			$param['appId']= 'appId='.$appId;
			$param['sid'] = 'sid='.$_GET['state'];
			$worldId = '1100';
			$param['worldId'] = 'worldId='.$worldId;
			$param['code'] = 'code='.$_GET['code'];
			$randString = $this->uuid();
			$param['randString'] = 'randString='.$randString;
			$key = 'fkn1Rg1K8NAWbAubFZwJ3E8EWxuiV49g';

			$signature = strtolower(md5($appId.$_GET['state'].$worldId.$_GET['code'].$randString.$key ));
			$param['signature'] = 'signature='.$signature;

			$result = Yii::app()->curl->post($url,implode("&",$param));
			$resultArray = json_decode($result,true);
			if ($resultArray['retCode'] == 0) {
				#$model = $this->loadModel($account_id);
				$model = Account::model()->find('yy=?',array($resultArray['uid']));
				if (!$model) {
					$this->render('bindyyfail', array('model'=>null,'msg'=>'您的账号没有在拍拍富中创建过任何角色'));
					return;	
				}
				//if ($model->password != "") {
				//	$this->render('bindyyfail', array('model'=>$model,'msg'=>"您的账号已经绑定莲蓬账号：".$model->account));
				//	return;
				//}
				$reset = new Reset();
				$reset->key = md5(uniqid('', true));
				$reset->account_id = $model->id;
				if (!$reset->save()) {
					$this->render('bindyyfail', array('model'=>$model));
					return;
				}
				$url = array('account/resetfromyy','id'=>$reset->key);
				$this->redirect($url);
			}

		}
		$this->render('bindyyfail', array('model'=>null,'msg'=>null));
	}

	public function sendClearyyMail($model) {
		$clearyy = new Clearyy();
		$clearyy->key = md5(uniqid('', true));
		$clearyy->account_id = $model->id;

		if ($model->verified == 0) {
			throw new CHttpException(403, "邮箱未验证，不能清除绑定yy。");
		}

		$exist_clearyy = Clearyy::model()->findBySql(
			"SELECT * FROM `clearyy` WHERE account_id=? ORDER BY `time` DESC LIMIT 1",
			array($clearyy->account_id));
		if ($exist_clearyy) {
			if ((time()-strtotime($exist_clearyy->time)) < 300) {
				throw new CHttpException(403, "请勿过于频繁地发送清除绑定yy邮件。");
			}
		}

		if (!$clearyy->save()) {
			$msg = $clearyy->getErrors();
			throw new CHttpException(500, "清除绑定yy无法创建。");
		}

		$message = $this->renderPartial("clearyy", array(
			"name"=>$model->getCallName(),
			"account"=>$model->account,
			"key"=>$clearyy->key,
		), true);

		$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
		$mailer->Host = "127.0.0.1";
		$mailer->Port = 25;
		$mailer->IsSMTP();
		#$mailer->SMTPAuth = true;
		#$mailer->SMTPSecure = "ssl";
		#$mailer->Username = "webmaster@dxqzol.com";
		#$mailer->Password = "lianpeng123";
		$mailer->CharSet = "UTF-8";
		$mailer->SetFrom("webmaster@dxqzol.com", "拍拍富用户中心");
		$mailer->AddAddress($model->email);
		$mailer->Subject = "拍拍富解绑YY账号";
		$mailer->MsgHTML($message);

		$ret = $mailer->send();
		return $ret ? true : false;
	}

	public function actionSendClearyy()
	{
		$model = $this->loadModel(Yii::app()->user->id);
		if (!$model) {
			throw new CHttpException(404, "账户不存在");
		}
		if ($this->sendClearyyMail($model)) {
			Yii::app()->user->setState(
				'info', "清除绑定yy邮件已经发送，请登录安全邮箱清除绑定yy。");
		} else {
			Yii::app()->user->setState(
				'info', "清除绑定yy邮件发送失败。");
		}
		$this->redirect(array('view','id'=>$model->id));
	}
	
	public function actionClearyy($id)
	{
		$clearyy = Clearyy::model()->findByPk($id);
		if (!$clearyy) {
			throw new CHttpException(404, "无效的验证链接");
		}
		if ((time()-strtotime($clearyy->time))>3600*24) {
			$clearyy->delete();
			throw new CHttpException(404, "无效的验证链接");
		}
		$model = $this->loadModel($clearyy->account_id);
		$clearyy->delete();
		Yii::app()->db->createCommand("UPDATE `account` SET `yy`=NULL WHERE `id`=$clearyy->account_id LIMIT 1")->execute();
		Yii::app()->user->setState('info', "您的绑定yy账号已经清除，请尽快绑定yy账号。");
		$this->redirect(array('view', 'id'=>Yii::app()->user->getId()));
	}
	

	public function JSON($array) {
		foreach ( $array as $key => $value ) {
			$array[$key] = urlencode ( $value );
		}
		return urldecode(json_encode($array) );
	}
	
	public function sendVerifyMailGame($model,$view="verifygame")
	{
		$verify = new Verify();
		$verify->key = md5(uniqid('', true));
		$verify->account_id = $model->id;
		$verify->email = $model->email;

		if (!$verify->email) {
			echo($this->JSON(array("code"=>-1,"msg"=>"邮箱未设置")));
			return false;
		}

		if ($model->verified == 0) {
			$account = Account::model()->find('`email`=? AND `verified`=1',
				array($verify->email));
			if ($account) {
				echo($this->JSON(array("code"=>-1,"msg"=>"邮箱已经被别的账号验证，一个邮箱只能用于验证一个账号。")));
				return false;
			}
		}

		$exist_verify = Verify::model()->findBySql(
			"SELECT * FROM `verify` WHERE account_id=? AND email=? ORDER BY `time` DESC LIMIT 1",
			array($verify->account_id, $verify->email));
		if ($exist_verify) {
			if ((time()-strtotime($exist_verify->time)) < 300) {
				echo($this->JSON(array("code"=>-1,"msg"=>"请勿过于频繁地发送验证邮件。")));
				return false;
			}
		}

		if (!$verify->save()) {
			echo($this->JSON(array("code"=>-1,"msg"=>"验证邮件无法创建。")));
			return false;
		}

		$message = $this->renderPartial($view, array(
			"token"=>$verify->key,
		), true);

		$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
		$mailer->Host = "127.0.0.1";
		$mailer->Port = 25;
		$mailer->IsSMTP();
		#$mailer->SMTPAuth = true;
		#$mailer->SMTPSecure = "ssl";
		#$mailer->Username = "webmaster@dxqzol.com";
		#$mailer->Password = "lianpeng123";
		$mailer->CharSet = "UTF-8";
		$mailer->SetFrom("webmaster@dxqzol.com", "拍拍富用户中心");
		$mailer->AddAddress($model->email);
		$mailer->Subject = "拍拍富邮箱验证";
		$mailer->MsgHTML($message);

		$ret = $mailer->send();

		return $ret ? true : false;
	}

	public function filterIp() {
		$ipfilters = array(
			'192.168.16.121','192.168.16.10',
			'121.201.99.172',
			'121.201.99.173','121.201.99.174',
			'121.201.99.175','121.201.99.176',
			'121.201.99.177'
		);
		$ip = Yii::app()->request->userHostAddress;
		return in_array($ip, $ipfilters);
	}

	public function actionBindEmailGame(){
		if (!$this->filterIp()) {
			return;
		}
		if(isset($_POST['Account'])) {
			$account = $_POST['Account']['account'];
			$model = Account::model()->find("account=:account",
				array(":account"=>$account));	
			if (!$model) {
				echo($this->JSON(array("code"=>-1,"msg"=>"账号不存在。" )));
				return;
			}
			if ($model->verified == 1) {
				echo($this->JSON(array("code"=>-1,"msg"=>"该账号已经绑定邮箱。" )));
				return;
			}
			if (!isset($_POST['Account']['email'])) {
				$_POST['Account']['email'] = $model->getOldEmail() ? $model->getOldEmail() : "";
			}
			$_POST['Account']['email'] = strtolower($_POST['Account']['email']);

			if (!isset($_POST['Account']['idcard'])) {
				$_POST['Account']['idcard'] = $model->getOldIdCard() ? $model->getOldIdCard() : "";
			}
			if (!isset($_POST['Account']['mobile'])) {
				$_POST['Account']['mobile'] = $model->getOldMobile() ? $model->getOldMobile() : "";
			}
			if (!isset($_POST['Account']['name'])) {
				$_POST['Account']['name'] = $model->getOldName() ? $model->getOldName(): "";
			}

			$model->attributes=$_POST['Account'];
			$account = Account::model()->find('`email`=? AND `verified`=1',
				array($_POST['Account']['email']));
			if ($account) {
				echo($this->JSON(array("code"=>-1,"msg"=>"邮箱已经被别的账号验证，一个邮箱只能用于验证一个账号。")));
				return;
			}

			Yii::import('application.vendors.*');
			include_once 'ucenter.php';
			$flag = uc_user_checkemail($_POST['Account']['email']);
			if ($flag < 0) {
				echo($this->JSON(array("code"=>0,"msg"=>"Email 格式有误")));
				return;
			}
			if($model->save()) {
				//Yii::import('application.vendors.*');
				//require_once('ucenter.php');
				//uc_user_edit($model->account, "", "", $model->email, 1);
				if ($model->verified == 0) {
					if ($this->sendVerifyMailGame($model)) {
						echo($this->JSON(array("code"=>0,"msg"=>"验证邮件已发送至您新提交的邮箱，为了您账号的安全，请尽快登录邮箱进行验证。")));
					} else {
						echo($this->JSON(array("code"=>-1,"msg"=>"验证邮件发送失败，请确认邮箱地址填写正确。")));
					}
				}
			}

		}
	}
	public function sendClearTokenMailGame($model)
	{
		$cleartoken = new Cleartoken();
		$cleartoken->key = md5(uniqid('', true));
		$cleartoken->account_id = $model->id;

		if ($model->verified == 0) {
			echo($this->JSON(array("code"=>-1,"msg"=>"邮箱未验证，不能清除口令。")));
			return false;
		}

		$exist_cleartoken = Cleartoken::model()->findBySql(
			"SELECT * FROM `cleartoken` WHERE account_id=? ORDER BY `time` DESC LIMIT 1",
			array($cleartoken->account_id));
		if ($exist_cleartoken) {
			if ((time()-strtotime($exist_cleartoken->time)) < 300) {
				echo($this->JSON(array("code"=>-1,"msg"=>"请勿过于频繁地发送口令清除邮件。")));
				return false;
			}
		}

		if (!$cleartoken->save()) {
			echo($this->JSON(array("code"=>-1,"msg"=>"口令清除无法创建。")));
			return false;
		}

		$message = $this->renderPartial("verifycleartoken", array(
			"name"=>$model->getCallName(),
			"account"=>$model->account,
			"token"=>$cleartoken->key,
		), true);

		$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
		$mailer->Host = "127.0.0.1";
		$mailer->Port = 25;
		$mailer->IsSMTP();
		#$mailer->SMTPAuth = true;
		#$mailer->SMTPSecure = "ssl";
		#$mailer->Username = "webmaster@dxqzol.com";
		#$mailer->Password = "lianpeng123";
		$mailer->CharSet = "UTF-8";
		$mailer->SetFrom("webmaster@dxqzol.com", "拍拍富用户中心");
		$mailer->AddAddress($model->email);
		$mailer->Subject = "拍拍富口令清除";
		$mailer->MsgHTML($message);

		$ret = $mailer->send();
		return $ret ? true : false;
	}

	public function actionVerifyClearToken($id)
	{
		$cleartoken = Cleartoken::model()->findByPk($id);
		if (!$cleartoken) {
			//$this->renderResult("无效的验证链接");
			$this->renderResult("您的安全口令已经清除，请尽快重新进入游戏设置口令。");
			return false;
		}
		if ((time()-strtotime($cleartoken->time))>3600*24) {
			$cleartoken->delete();
			$this->renderResult("无效的验证链接");
			return false;
		}
		$model = $this->loadModel($cleartoken->account_id);
		$cleartoken->delete();
		Yii::app()->db->createCommand("DELETE FROM `accattr` WHERE `account_id`=$cleartoken->account_id AND `attr`in ('token', 'bindmac')")->execute();
		$this->renderResult("您的安全口令已经清除，请尽快重新进入游戏设置口令。");
		//return true;
	}
	/*	
	public function actionClearTokenGame(){
		$ipfilters = array(
			'192.168.16.121','192.168.16.10',
			'121.201.99.172',
			'121.201.99.173','121.201.99.174',
			'121.201.99.175','121.201.99.176',
			'121.201.99.177'
		);
		$ip = Yii::app()->request->userHostAddress;
		if (!in_array($ip, $ipfilters)) {
			return;
		}
		if(isset($_POST['Account'])) {
			$account = $_POST['Account']['account'];
			$model = Account::model()->find("account=:account",
				array(":account"=>$account));	
			if (!$model) {
				echo($this->JSON(array("code"=>-1,"msg"=>"账号不存在。" )));
				return;
			}
			if ($this->sendClearTokenMailGame($model)) {
				$len = strpos($model->email,'@') - 2;
				echo($this->JSON(array("code"=>0,"msg"=>sprintf("口令清除邮件已经发送，请登录安全邮箱%s清除口令。", substr_replace($model->email,str_repeat('*',$len),2,$len) ))));
			} else {
				echo($this->JSON(array("code"=>-1,"msg"=>"口令清除邮件发送失败。" )));
			}
		}
	}
	 */
	
	public function actionLoggingNoAnswer(){
		if (!$this->filterIp()) {
			return;
		}
		if(isset($_POST['Account'])) {
			$question = $_POST['Account']['question'];
			$model = new Noanswer();
			$model->question = $question;
			if ($model->save()) {
				echo($this->JSON(array("code"=>0)));
			}
			else{
				echo($this->JSON(array("code"=>-1)));
			}
		}
	}
	
	public function actionLoggingNoHelp(){
		if (!$this->filterIp()) {
			return;
		}
		if(isset($_POST['Account'])) {
			$question = $_POST['Account']['question'];
			$answer = $_POST['Account']['answer'];
			$model = new Nohelp();
			$model->question = $question;
			$model->answer = $answer;
			if ($model->save()) {
				echo($this->JSON(array("code"=>0)));
			}
			else{
				echo($this->JSON(array("code"=>-1)));
			}
		}

	}

	public function actionBindMail(){
		$user = Yii::app()->user;
		$model=$this->loadModel($user->id);
		if ($model->verified == 1) {
			$this->redirect(array('view','id'=>$model->id));
			return;
		}
		$model->scenario = "bindmail";
		$this->performAjaxValidation($model);

		if(isset($_POST['Account']))
		{
			if (!isset($_POST['Account']['email'])) {
				$_POST['Account']['email'] = $model->getOldEmail() ? $model->getOldEmail() : "";
			}
			$_POST['Account']['email'] = strtolower($_POST['Account']['email']);

			$model->attributes=$_POST['Account'];
			if($model->save()) {
				Yii::import('application.vendors.*');
				require_once('ucenter.php');
				uc_user_edit($model->account, "", "", $model->email, 1);
				if ($model->verified == 0) {
					if ($this->sendVerifyMail($model)) {
						Yii::app()->user->setState(
							'info', "验证邮件已发送至您新提交的邮箱，为了您账号的安全，请尽快登录邮箱进行验证。");
					} else {
						Yii::app()->user->setState(
							'info', "验证邮件发送失败，请确认邮箱地址填写正确。");
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$this->render('bindmail',array(
			'model'=>$model,
		));
	}
	
	public function actionBindMobileMail($id){
		$verify = Verify::model()->findByPk($id);
		if (!$verify) {
			throw new CHttpException(404, "无效的验证链接");
		}
		if ((time()-strtotime($verify->time))>3600*24) {
			$verify->delete();
			throw new CHttpException(404, "无效的验证链接");
		}

		$model=$this->loadModel($verify->account_id);

		if ($verify->email != $model->email || $model->verified == 0) {
			$verify->delete();
			throw new CHttpException(404, "验证邮箱地址错误");
		}
		if ($this->bindMobile($model)) {
			$verify->delete();
		}
	}

	public function actionBindMobile(){
		$user = Yii::app()->user;
		$model=$this->loadModel($user->id);
		
		if ($model->verifiedmobile && $model->verifiedmobile !== "") {
			$this->redirect(array('view','id'=>$model->id));
			return;
		}

		if ($model->email && $model->verified == 1) {
			if ($this->sendVerifyMail($model,'bindmobilemail')) {
				Yii::app()->user->setState(
				'info', "绑定手机号码邮件已发送至您的安全邮箱，为了您账号的安全，请尽快登录邮箱进行验证。");
			} else {
				Yii::app()->user->setState(
				'info', "绑定手机号码验证邮件发送失败，请稍后重试或者联系客服。");
			}
			$this->redirect(array('view','id'=>$model->id));
			return;
		}
		$this->bindMobile($model);
	}

	public function bindMobile($model){

		$model->scenario = "bindmobile";
		$this->performAjaxValidation($model);

		if(isset($_POST['Account']))
		{
			$mobile = strtolower($_POST['Account']['verifiedmobile']);
			$model->verifyCode = $_POST['Account']['verifyCode'];

			$model->verifiedmobile = $mobile;
			$model->verifiedmobile_time = date('Y-m-d H:i:s');
			if($model->save()) {
				Yii::app()->cache->delete($model->verifiedmobile);
				Yii::app()->user->setState(
					'info', "手机验证成功。");
				$this->redirect(array('view','id'=>$model->id));
				return true;
			}
		}

		$this->render('bindmobile',array(
			'model'=>$model,
		));

	}
	
	public function actionSendVerifyPhone($id = null){
		$user = Yii::app()->user;
		if (!$user->isGuest) {
			$model=$this->loadModel($user->id);
			if ($id == null) {
				$id = $model->verifiedmobile;	
			}
		}
		/*
		if ($model->verifiedmobile !== $id) {
			$account = Account::model()->find('`verifiedmobile`=?',array($id));
			if ($account) {
				return;
			}
		}
		*/
		if (!preg_match("/^1[3-9]{1}[0-9]{9}$/", $id)) {
			return;
		}
		$cache = Yii::app()->cache->get($id);
		if ($cache) {
			if (time()-$cache['time'] < 120){
				echo json_encode(array("res"=>-1));
				return;	
			}
		}
		if (!$this->sendVerifyPhone($id)) {
			return;
		
		}
		echo json_encode(array("res"=>0));
		return true;
	}

	public function actionClearTokenMobile()
	{
		$user = Yii::app()->user;
		$model=$this->loadModel($user->id);

		if (!$model->verifiedmobile || $model->verifiedmobile == "") {
			Yii::app()->user->setState(
				'info', "未绑定手机号码，请先绑定手机号码。");
			$this->redirect(array('bindmobile'));
			return;
		}

		$model->scenario = "cleartoken";
		$this->performAjaxValidation($model);

		if(isset($_POST['Account']))
		{
			#$mobile = strtolower($_POST['Account']['verifiedmobile']);
			$model->verifyCode = $_POST['Account']['verifyCode'];

			if ($model->validate()) {
				Yii::app()->cache->delete($model->verifiedmobile);
				Yii::app()->db->createCommand("DELETE FROM `accattr` WHERE `account_id`=$model->id AND `attr`in ('token', 'bindmac')")->execute();
				Yii::app()->user->setState('info', "您的安全口令已经清除，请尽快进入游戏重新设置口令。");
				$this->redirect(array('view','id'=>$model->id));
			}

		}

		$this->render('cleartokenmobile',array(
			'model'=>$model,
		));

	}

	public function actionClearToken()
	{
		$user = Yii::app()->user;
		$this->render('cleartokenview',array(
			'model'=>$this->loadModel($user->id),
		));
	}

	public function actionIdList() 
	{
		if (!$this->preFilter(20)) {
			return;
		}
		if (!isset($_GET['account'])) {
			if (Yii::app()->user->isGuest) {
				echo json_encode(array('res_code'=>1));
				return;
			}
			$model=$this->loadModel(Yii::app()->user->id);
			$account = $model->account;
		} else {
			$account = $_GET['account'];
		}

		$rows = Yii::app()->db->createCommand(
			"SELECT Id,Name,Server FROM User WHERE Account='$account'")->query();

		$IdList = array();
		foreach($rows as $value) {
			if (isset($_GET['server_id'])) {
				if ($value['Server'] == $_GET['server_id']) {
					array_push($IdList,$value);
				}
			} else {
				array_push($IdList,$value);
			}
		}
		echo json_encode(array('res_code'=>0, 'idlist'=>$IdList));	
	}
	
	public function actionServerList()
	{
		if (isset($_GET['server_id'])) {
			$sql = "SELECT * FROM serverlist where id=".$_GET['server_id'];
		} else {
			$sql = "SELECT * FROM serverlist";
		
		}
		$rows = Yii::app()->db->createCommand($sql)->query();
		$serverList = array();
		foreach($rows as $value) {
			array_push($serverList,$value);
		}
		echo json_encode($serverList);

	}

	public function actionStIdList() {
		$params = array(
			"gameCode","serverId","time","userId","sign"
		);
		$values = array();
		foreach( $params as $param ) {
			if (!isset($_GET[$param] )) {
				echo json_encode(array('errno'=>-3,'errmsg'=>"missing param ".$param ));
				return;
			} else {
				array_push($values,$_GET[$param]);
			}
		}
		$key="BD27A225FCBDD15E335914AA53E815E5";
		array_pop($values);
		array_push($values,$key);
		if (strtolower(md5(implode("",$values))) != $_GET["sign"]) {
			echo json_encode(array('errno'=>-4,'errmsg'=>"sign invalid"));
			return;
		}
		$account = "st_".$_GET['userId'];
		$server = $_GET['serverId'];
		$rows = Yii::app()->db->createCommand(
			"SELECT Id,Name,Grade,Time FROM User WHERE Account='$account' AND Server=$server")->query();

		$IdList = array();
		foreach($rows as $value) {
			array_push($IdList,array(
				'nickname'=> $value['Name'],
				'level' => (int)(isset($value['Grade'])?$value['Grade']:0),
				'createtime'=> strtotime($value['Time']),
			));
		}
		if (sizeof($IdList) == 0) {
			echo json_encode(array('errno'=>-1,'errmsg'=>"no role"));
			return;
		}
		echo json_encode(array('errno'=>0,'errmsg'=>"success",'data'=>$IdList));
	}
	public function actionFhIdList() {
		$params = array(
			"gameid","server","time","uid","sign"
		);
		$values = array();
		foreach( $params as $param ) {
			if (!isset($_GET[$param] )) {
				echo json_encode(array('errno'=>-3,'errmsg'=>"missing param ".$param ));
				return;
			} else {
				array_push($values,$_GET[$param]);
			}
		}
		$key="eLxIMb9wlLS4tCR7";
		array_pop($values);
		array_push($values,$key);
		if (strtolower(md5(implode("",$values))) != $_GET["sign"]) {
			echo json_encode(array('errno'=>-4,'errmsg'=>"sign invalid"));
			return;
		}
		$account = "fh_".$_GET['uid'];
		$server = $_GET['server'];
		$rows = Yii::app()->db->createCommand(
			"SELECT Id,Name,Grade,Time FROM User WHERE Account='$account' AND Server=$server")->query();

		$IdList = array();
		foreach($rows as $value) {
			array_push($IdList,array(
				'charid' => $value['Id'],
				'nickname'=> $value['Name'],
				'level' => (int)(isset($value['Grade'])?$value['Grade']:0),
				'createtime'=> strtotime($value['Time']),
			));
		}
		if (sizeof($IdList) == 0) {
			echo json_encode(array('errno'=>-1,'errmsg'=>"no role"));
			return;
		}
		echo json_encode(array('errno'=>0,'errmsg'=>"success",'data'=>$IdList));
	}


/*	
	public function actionDrawRewardroll()
	{
		$this->layout = "zt140815";
	
		# 幸运大转盘活动
		$model = $this->loadModel(Yii::app()->user->id);
		if (!$model) {
			throw new CHttpException(404, "账户不存在");
		}
		
		# 如果已经抽了奖
		$reward = $this->getAccountReward($model);
		if ($reward) {
			return $this->renderReward_1($reward, $model);
		}

        /*
		#验证url的合法性
		#$URL=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$v = isset($_REQUEST["v"]) ? $_REQUEST["v"] : "";
		#5位随机数
		$num = substr($v,0,5);
		$str = substr($v,5);
		#账号
		$account = $model->account;
		#ip地址
		#$ip = $_SERVER["REMOTE_ADDR"];
		#密钥
		$secret = "383843809438";
		
		$str2 = $num . $account . $secret;
		$str3 = MD5($str2);
		#echo $str2."<br/>";
		#echo $str3;
		
		#如果链接不是来自客户端，提示错误！
		if($str != $str3) {
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				return $this->returnRollResult(0, "请从游戏内点击活动链接！");
			} else {
				$this->render("reward_1", array(
					'model'=>$model,
					'info'=>"error_url",
					'key'=>'',
				));
			}
			return;
		}
		
        //*
		#验证活动时间
		$begintime = date("Y-m-d H:i:s",mktime(12, 0, 0,8,12,2014));
		$endtime   = date("Y-m-d H:i:s",mktime(23,59,59,8,27,2014));
		$nowtime   = date("Y-m-d H:i:s",time());
		if ($nowtime< $begintime or $nowtime> $endtime ) {
			$this->render("reward_1", array(
				'model'=>$model,
				'info'=>"not_open",
				'key'=>'',
			));
			return;
		}
		

		# 如果没有参与资格
		$attr = Accattr::model()->findBySql(
			"SELECT * FROM `accattr` WHERE account_id=? AND attr='OR_HolidayGet20140131'",
			array($model->id));
		if (!$attr) {
			$this->render('reward', array(
				'model'=>$model,
				'info'=>"no_sign_7_days",
				'key'=>'',
			));
			return;
		}

        # 投票没有到三票
        $exist_vote = Surveyvote::model()->findAllBySql(
            "SELECT * FROM `surveyvote` WHERE account_id=? AND subject_id=2",
            array($model->id));
        if (count($exist_vote) < 3) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                return $this->returnRollResult(0, "请将你手中的三票都投出去哦！");
            } else {
                $this->render("reward_1", array(
                    'model'=>$model,
                    'info'=>"not_finish",
                    'key'=>'',
                ));
            }
            return;
        }

		# 如果没有验证邮箱
		if ($model->verified == 0) {
			$this->render('reward_1', array(
				'model'=>$model,
				'info'=>"no_verify_email",
				'key'=>'',
			));
			return;
		}

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$randvalue = rand(0, 9999);

			#指定获奖用户及奖品
			#$user = Yii::app()->user;
			#if ($user->name == 'tsukikage01') {
			#	if($this->drawGiftCard($model, "MU")){
			#		return $this->returnRollResult(3, "哇塞，中了雷蛇鼠标哦");
			#	} else {
			#		if($this->drawGiftCard($model, "L1")){
			#			return $this->returnRollResult(6, "获得洗髓丹*30");
			#		}else{
			#			return $this->returnRollResult(0, "本次抽奖已经结束！");
			#		}
			#	}
			#}

			# 开始根据概率抽奖，概率如下：
			if ($randvalue < 0) {
				if ($this->drawGiftCard($model, "IP")) {
					return $this->returnRollResult(1, "恭喜您抽中了iPad mini 2");
				}
			} elseif ($randvalue < 13) {
				if ($this->drawGiftCard($model, "MU")) {
					return $this->returnRollResult(3, "哇塞，中了雷蛇鼠标哦");
				}
			} elseif ($randvalue < 13+50) {
				if ($this->drawGiftCard($model, "Q3")) {
					return $this->returnRollResult(5, "恭喜，获得30QB");
				}
			} elseif ($randvalue < 13+50+125) {
				if ($this->drawGiftCard($model, "Q1")) {
					return $this->returnRollResult(7, "恭喜，获得10QB");
				}
			} elseif ($randvalue < 13+50+125+2500) {
				if ($this->drawGiftCard($model, "L1")) {
					return $this->returnRollResult(2, "获得如意卷*3");
				}
			} elseif ($randvalue < 13+50+125+2500+2500) {
				if ($this->drawGiftCard($model, "L2")) {
					return $this->returnRollResult(4, "获得回春汤*3");
				}
			} elseif ($randvalue < 13+50+125+2500+2500+2500) {
				if ($this->drawGiftCard($model, "L3")) {
					return $this->returnRollResult(8, "获得优质牧草*5");
				}
			}
			if($this->drawGiftCard($model, "L4")) {
				return $this->returnRollResult(6, "获得洗髓单*30");
			} else {
				return $this->returnRollResult(0, "本次抽奖已经结束！");
			}
		}
		$this->render('rewardroll', array(
			'model'=>$model,
			'info'=>"reward",
			'key'=>1,
		));
	}
 */
}

