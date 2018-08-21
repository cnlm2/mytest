<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CaptchaAction',
				'backColor'=>0xFFFFFF,
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
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
			'actions'=>array('index','login','quicklogin','error','fetchpassword','fetchpasswordmail','fetchpasswordmobile',
			'captcha','notyet','sendverifyphone','xinyoulogin','xinyouloginweb','xinyouloginwebcallback','swlogin','fhlogin','fhloginbbs','fhloginbbscallback',),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('keyget','logout','activate'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('keygen','cardgen','doublegen'),
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->render('index');
		$this->redirect( $this->createUrl('account/view') );

			/*
			 */
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
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
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
		$model=new LoginForm('validate');

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			$model->scenario = "";
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			    $this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

    public function actionQuickLogin()
    {
        $this->layout = "empty";
        $model=new LoginForm('validate');

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            $model->scenario = "";
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
				echo(json_encode( array("loginok"=>true) ));
				return;
			}
        }
        // display the login form
        $this->render('quicklogin',array('model'=>$model));
    }

    public function actionKeygen()
	{
		$model = new KeyGenForm();

		if(isset($_POST['KeyGenForm'])) {
			$model->attributes=$_POST['KeyGenForm'];
			if($model->validate() && $model->generate())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		$this->render('keygen',array('model'=>$model));
	}

	public function actionCardgen()
	{
		$model = new CardGenForm();

		if(isset($_POST['CardGenForm'])) {
			$model->attributes = $_POST['CardGenForm'];
			if($model->validate() && $model->generate())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		$this->render('cardgen', array('model'=>$model));
	}

	public function actionDoublegen()
	{
		$model = new DoubleKeyGenForm();
		if(isset($_POST['DoubleKeyGenForm'])) {
			$model->attributes = $_POST['DoubleKeyGenForm'];
			if ($model->validate() && $model->generate())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		$this->render('doublegen', array('model'=>$model));
	}

	public function actionKeyget()
	{
		$model = null;
		if(isset(Yii::app()->session['questions_model'])) {
			$model = Yii::app()->session['questions_model'];
		} else {
			$model = new KeyGetForm();
			Yii::app()->session['questions_model'] = $model;
		}
		$model->clearErrors();
		if(isset($_POST['KeyGetForm'])) {
			$model->attributes=$_POST['KeyGetForm'];
			if($model->fetch()) {
				unset(Yii::app()->session['questions_model']);
				$this->render('keydeliver', array('model'=>$model));
				return;
			}
		}
		$this->render('keyget',array('model'=>$model));
	}

	public function actionActivate()
	{
		$model = new ActivateForm();
		if(isset($_POST['ActivateForm'])) {
			$model->attributes=$_POST['ActivateForm'];
			if($model->activate()) {
				$this->render('actsucc', array('model'=>$model));
				return;
			}
		}
		$this->render('activate', array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionFetchPassword(){
		$this->render('fetchview');
	}
	
	
	public function actionFetchPasswordMobile(){
		$model = new FetchPasswordMobileForm();

		if(isset($_POST['ajax']) && $_POST['ajax'] == "fetch-password-mobile-form") {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['FetchPasswordMobileForm'])) {
			$model->attributes=$_POST['FetchPasswordMobileForm'];
			if ($model->validate()) {
				$id = $model->fetch($this);
				if ($id) {
					$this->redirect($this->createUrl('account/reset',array('id'=>$id)) );
					return;
				}
			}
		}
		$this->render('fetchmobile', array('model'=>$model));
	}
	
	public function actionFetchPasswordMail()
	{
		$model = new FetchPasswordForm();
		if (isset($_POST['FetchPasswordForm'])) {
			$model->attributes=$_POST['FetchPasswordForm'];
			if ($model->validate() && $model->fetch($this)) {
				$this->render('fetchrt', array(
					'account'=>$model->user->account,
					'email'=>$model->user->email,
				));
				return;
			}
		}
		$this->render('fetch', array('model'=>$model));
	}

	public function actionNotYet()
	{
		$this->render('notyet');
	}

	public function actionSendVerifyPhone($id) {
		$model = Account::model()->find("account=?",
			array($id));
		if (!$model || !$model->verifiedmobile || $model->verifiedmobile == "") {
			return;
		}
		$cache = Yii::app()->cache->get($model->verifiedmobile);
		if ($cache && (time()-$cache['time']) < 120) {
			echo json_encode(array("res"=>-1));
			return;	
		}
		Yii::import('application.vendors.*');
		require_once("sms.php");
		if (!SendVerify($model->verifiedmobile)) {
			return;
		}
		echo json_encode(array("res"=>0,"mobile"=>$model->verifiedmobile));
		return true;
	}

	public function actionXinyouLogin()
	{
		$key = "nJ8vCbhhUFOi3wQd";
		if(isset($_POST['sessionid']) && isset($_POST['time']) && isset($_POST['sign'])) {
			$sessionid = $_POST['sessionid'];
			$time  =$_POST['time'];
			$sign  =$_POST['sign'];
			if (md5($sessionid.$time.$key) == $sign) {
				echo $sessionid;
				return;
			}

		}
		echo "error";
	}

	public function actionXinyouLoginWeb() {
		$url = "https://ucenter.ixinyou.com/terminal/serv/login/weblogin?";		
		$gameid ="gshx";
		$key= "nJ8vCbhhUFOi3wQd";
		$param['gameid'] = "gameid=".$gameid;
		$callback = "http://hi.gshx.ixinyou.com/account/index.php/site/xinyouloginwebcallback";
		$param['callback'] = "callback=".$callback;
		$css = "https://ucenter.ixinyou.com/terminal/css/loginweb.css";
		$param['css'] = "css=".$css;
		$sign = strtolower(md5($gameid.$callback.$css.$key));
		$param['sign'] = "sign=".$sign;
		$url .= implode("&",$param);
		$this->redirect($url);
		return;
	}

	public function actionXinyouLoginWebCallback()
	{
		$paramnames = array("sessionid","time","sign");
		foreach( $paramnames as $paramname ) {
			if (!isset($_POST[$paramname] )) {
				echo(json_encode(array("code"=>-1,"msg"=>"missing param ".$paramname)));
				return;
			}
		}
		$sessionid = $_POST['sessionid'];
		$time  =$_POST['time'];
		$sign  =$_POST['sign'];

		$key = "nJ8vCbhhUFOi3wQd";
		$gameid = "gshx";
		if (md5($sessionid.$time.$key) !== $sign) {
			echo(json_encode(array("code"=>-2,"msg"=>"sign invalid")));
			return;
		}

		$url = "http://api.ucenter.ixinyou.com/terminal/serv/api/checksession";
		$param['sessionid']= "sessionid=".$sessionid;
		$param['gameid']= "gameid=".$gameid;
		$timestamp = time();
		$param['time']= "time=".$timestamp;
		$param['sign']= "sign=".md5($sessionid.$gameid.$timestamp.$key);
		$str = implode("&",$param);

		$result = Yii::app()->curl->post($url,$str);
		$resultArray = json_decode($result,true);

		if ($resultArray['res'] == 1) {
			$account ="xy_".strtolower($resultArray['account']);
			$model=Account::model()->findBySql("SELECT * FROM account WHERE `account`=?", array($account));
			if (!$model) {
				$model = new Account();
				$model->account = $account;
				$model->password = "";
				$model->from = "17173";
				if (!$model->save())  {
					echo(json_encode(array("code"=>-3,"msg"=>"account not exists")));
				}
			}
			$identity = new UserIdentity($model->account,md5($model->originpassword));
			$identity->setId($model->id);
			Yii::app()->user->login($identity,0);
			echo(json_encode( array("loginok"=>true) ));
		}

	}
	
	public function actionSwLogin()
	{
		if (!isset($_GET["code"])) {
			echo "error";
			return;
		}
		$url = "https://gshx.swjoy.com/oauth2/token.do";
		$param['client_id']= "client_id=3397";
		$param['client_secret']= "client_secret=f5261df9429e5717188a25ccdf5eb9ee9d6203fd";
		$param['grant_type']= "grant_type=authorization_code";
		$param['code']= "code=".$_GET["code"];
		$param['redirect_uri']= "redirect_uri=http://gshx.greenyouxi.com/account/index.php/site/swlogin";
		$str = implode("&",$param);
		$result = Yii::app()->curl->post($url,$str);
		$resultArray = json_decode($result,true);
		if (array_key_exists("access_token", $resultArray)) {
			echo($resultArray["access_token"]);
			return;
		}
		echo "error";
	}

	public function curl_post($url='', $postdata='', $options=array()){
		$ch = curl_init($url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    	if (!empty($options)){
    	    curl_setopt_array($ch, $options);
    	}
    	$data = curl_exec($ch);
    	curl_close($ch);
    	return $data;
	}

	public function actionFhLogin()
	{
		if (!isset($_GET["code"])) {
			echo "error";
			return;
		}
		$url = "http://oauth2.feihuo.com/token.php";
		$param['client_id']= "client_id=2015100023";
		$param['client_secret']= "client_secret=e2e3f76e78e40e2e029fd70729c0f324";
		$param['grant_type']= "grant_type=authorization_code";
		$param['code']= "code=".$_GET["code"];
		$param['redirect_uri']= "redirect_uri=http://gshx.greenyouxi.com/account/index.php/site/fhlogin";
		$str = implode("&",$param);
		$result = $this->curl_post($url,$str);//Yii::app()->curl->post($url,$str);
		$resultArray = json_decode($result,true);
		if (array_key_exists("access_token", $resultArray)) {
			echo($resultArray["access_token"]);
			return;
		}
		echo "error";
	}

	public function actionFhLoginbbs()
	{
		$url="http://oauth2.feihuo.com/gshx_authorize.php?response_type=code&client_id=2015100023&redirect_uri=http://gshx.greenyouxi.com/account/index.php/site/fhloginbbscallback";
		$this->redirect($url);
		return;
	}


	public function actionFhLoginbbsCallback()
	{
		if (!isset($_GET["code"])) {
			echo "error";
			return;
		}
		$url = "http://oauth2.feihuo.com/token.php";
		$param['client_id']= "client_id=2015100023";
		$param['client_secret']= "client_secret=e2e3f76e78e40e2e029fd70729c0f324";
		$param['grant_type']= "grant_type=authorization_code";
		$param['code']= "code=".$_GET["code"];
		$param['redirect_uri']= "redirect_uri=http://gshx.greenyouxi.com/account/index.php/site/fhlogin";
		$str = implode("&",$param);
		$result = $this->curl_post($url,$str);//Yii::app()->curl->post($url,$str);
		$resultArray = json_decode($result,true);
		if (!array_key_exists("access_token", $resultArray)) {
			return;
		}
		$access_token = $resultArray["access_token"];

		$url = "https://oauth2.feihuo.com/resource_new.php?access_token=".$access_token;

		$result = Yii::app()->curl->get($url);
		$resultArray = json_decode($result,true);
		
		if (!array_key_exists("uid", $resultArray)) {
			return;
		}

		$account="fh_".$resultArray["uid"];
		Yii::import('application.vendors.*');
		require_once('ucenter.php');
		$uc_user = uc_get_user($account);
		if (!$uc_user) {
			uc_user_register($account, "fh", "");
		}
		$url = "http://gshx.greenyouxi.com/bbs/member.php?mod=logging&action=login&loginsubmit=yes&infloat=yes&lssubmit=yes&inajax=0&fastloginfield=username&username=".$account."&password=fh&quickforward=yes&handlekey=ls";
		$this->redirect($url);

	}

}
