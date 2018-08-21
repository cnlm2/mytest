<?php

class ChargeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'create',
					'pay','return','notify',
					'szfpay','szfreturn','szfnotify',
					'hfbpay','hfbreturn','hfbnotify',
					'wxpay',
					'yhcharge',
					'maintnotify',
				),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','remove'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','index','view','recharge'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
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

	public function getCurrentRate()
	{
		$begintime = date("Y-m-d H:i:s",mktime( 0, 0, 0,3,21,2014));
		$endtime   = date("Y-m-d H:i:s",mktime(23,59,59,3,27,2014));
		$nowtime   = date("Y-m-d H:i:s",time());
		if ($nowtime>= $begintime and $nowtime<= $endtime ) {
			return 11;
		} else {				
			return 10;
		}
	}

	public function getServerList()
	{
		$rows = Yii::app()->db->createCommand(
			"SELECT * FROM serverlist ORDER BY id DESC"
		)->queryAll();
		$serverList = array(
			0=>'请选择服务器',
		);
		foreach($rows as $value) {
			$id = $value["id"];
			$name = $value["name"];
			$serverList[$id] = $name;
		}
		return $serverList;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		Yii::import('application.vendors.*');

		//require_once('ipinfo.php');
		//$ip = $_SERVER["REMOTE_ADDR"];
		//$ipinfo = GetIpInfo($ip);
		//if ($ipinfo['city'] === "广州市") {
		//	return $this->redirect(array('site/notyet'));
		//}

		$model=new Charge('create');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		if (isset($_REQUEST['account'])) {
			$model->account_name = $_REQUEST['account'];
			//$model->account_confirm = $_REQUEST['account'];
		} elseif (!Yii::app()->user->isGuest) {
			$model->account_name = Yii::app()->user->name;
			//$model->account_confirm = Yii::app()->user->name;
		}
		//gshx
		$model->game_type = 28;

		if(isset($_POST['Charge']))
		{
			$model->attributes=$_POST['Charge'];

			$model->no = $this->uuid();
			$model->status = Charge::CREATED;
			$model->itemid = $_POST['Charge']['itemid'];

			if ($model->validate()) {
				$account = Account::model()->find('account=?',
					array($model->account_name));
				$model->account_id = $account->id;

				//if (Yii::app()->user->isGuest) {
				//	$model->creator_id = 0;
				//} else {
				//	$model->creator_id = Yii::app()->user->id;
				//}
				$model->amount = $model->fee * $this->getCurrentRate();
				if ($model->charge_type == "hfbbank") {
					$model->charge_type = $model->charge_type.".".$model->bank;
				}
				if($model->save()) {
					if ($model->charge_type == "yd" ||
						$model->charge_type == "lt" ||
						$model->charge_type == "dx") {
						$this->redirect(array('szfpay','id'=>$model->no));
					} elseif (strpos($model->charge_type, "hfbbank") === 0) {
						$this->redirect(array('hfbpay','id'=>$model->no));
					} elseif (strpos($model->charge_type, "wx") === 0) {
						$this->redirect(array('wxpay','id'=>$model->no));
					} else {
						$this->redirect(array('pay','id'=>$model->no));
					}
				}
			}
		} else {
			if (Yii::app()->user->isGuest) {
				$this->redirect(array('site/login'));
			}
		}
		$this->render('create',array(
			'model'=>$model,
			'serverList'=>$this->getServerList(),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Charge']))
		{
			$model->attributes=$_POST['Charge'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->no));
		}

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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionRemove($id)
	{
		$model = $this->loadModel($id);
		$model->account_name = Yii::app()->user->name;
		//$model->account_confirm = Yii::app()->user->name;
		if (!$model->charge_type) {
			$model->charge_type = "zfb";
		}
		$model->hide = 1;
		$model->save();
		//if (!$model->save()) {
		//	var_dump($model->getErrors());
		//	return;
		//};
		$this->redirect(array('index'));
	}

	public function actionPay($id)
	{
		$model=$this->loadModel($id);
		$this->render('pay', array(
			'model'=>$model,
		));
	}

	public function actionSzfPay($id)
	{
		$model=$this->loadModel($id);
		$this->render('szfpay', array(
			'model'=>$model,
		));
	}

	public function actionHfbPay($id)
	{
		$model=$this->loadModel($id);
		$this->render('hfbpay', array(
			'model'=>$model,
		));
	}
	
	public function actionWxPay($id)
	{
		$model=$this->loadModel($id);
		$this->render('wxpay', array(
			'model'=>$model,
		));
	}

	public function actionRecharge($id)
	{
		if ($this->recharge($id)) {
			echo 'ok';
		} else {
			echo 'error';
		}
	}

	public function isChargeFinished($id)
	{
		try {
			$charge = Charge::model()->findBySql(
				"SELECT * FROM charge WHERE no=?",
				array($id));
			if ($charge->status == Charge::FINISHED) {
				return true;
			}
			return false;
		} catch (Exception $e) {
			return false;
		}
	}

	public function actionMaintNotify() {
		$char_id = $_GET['char_id'];
		$amount = $_GET['amount'];
		$balance = $_GET['balance'];
		$game_type = $_GET['game_type'];
		$this->maintNotify($char_id, $amount, $balance, $game_type);
	}

	public function maintNotify($char_id, $amount, $balance, $game_type) {
		$url = "http://121.201.99.173:8243/cmd/batchall?";
		$gameid = "gshx";
		$key = "r5hvLrQt6tbmJcOA";
		$command = "recharge_ok ".$char_id.",".$amount.",".$balance;
		$time = time();
		$param['gameid']= "gameid=".$gameid;
		$param['key']= "key=".$key;
		$param['command']= "command=".$command;
		$param['time']="time=".$time;
		$param['sign'] = "sign=".md5($gameid.$key.$command.$time);
		$url .= implode("&",$param);
		Yii::app()->curl->get($url);
	}

	public function recharge($id)
	{
		$txn = Yii::app()->db->beginTransaction();
		try {
			$charge = Charge::model()->findBySql(
				"SELECT * FROM charge WHERE no=? FOR UPDATE",
				array($id));

			// CREATED --- recharge --> FINISHED
			// 已经完成的订单，可以返回正确
			if ($charge->status == Charge::FINISHED || $charge->status == Charge::CONSUMED) {
				$txn->rollback();
				return true;
			}
			// 如果不在初始状态，应该是错误了
			if ($charge->status != Charge::CREATED) {
				$txn->rollback();
				return false;
			}

			if ($charge->char_id == 0) {
				$account_id = $charge->account_id;
				$account = Account::model()->findBySql(
					"SELECT * FROM account WHERE id=? FOR UPDATE",
					array($account_id));
				$account->balance = $account->balance + $charge->amount;
				$account->update();
				$charge->status = Charge::CONSUMED;
			} else {
				$charge->status = Charge::FINISHED;
			}

			$this->maintNotify($charge->char_id, $charge->amount, 0, $charge->game_type);
			$charge->update();

			$txn->commit();

			return true;
		} catch (Exception $e) {
			$txn->rollback();
			return false;
		}
	}

	public function actionNotify()
	{
		header("Content-Type: text/plain");

		Yii::import('application.vendors.*');
		require_once("ali.php");

		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();

		if($verify_result) {//验证成功
		    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			//商户订单号
			$out_trade_no = $_POST['out_trade_no'];
			//支付宝交易号
			$trade_no = $_POST['trade_no'];
			//交易状态
			$trade_status = $_POST['trade_status'];
		
		    if($_POST['trade_status'] == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
						
				//注意：
				//该种交易状态只在两种情况下出现
				//1、开通了普通即时到账，买家付款成功后。
				//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。
		
				if ($this->recharge($out_trade_no)) {
					Yii::log("NOTIFY TRADE_FINISHED 完成交易 ${out_trade_no} 成功","info","recharge.zfb");
					echo "success";
					return;
				} else {
					Yii::log("NOTIFY TRADE_FINISHED 完成交易 ${out_trade_no} 失败","info","recharge.zfb");
					echo "fail";
					return;
				}
		    }
		    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
						
				//注意：
				//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。
				if ($this->recharge($out_trade_no)) {
					Yii::log("NOTIFY TRADE_SUCCESS 完成交易 ${out_trade_no} 成功","info","recharge.zfb");
					echo "success";
					return;
				} else {
					Yii::log("NOTIFY TRADE_SUCCESS 完成交易 ${out_trade_no} 失败","info","recharge.zfb");
					echo "fail";
					return;
				}
		    }
		}
		else {
			$trade_no = "NOT_POST";
			if (array_key_exists("out_trade_no", $_POST)) {
				$trade_no = $_POST['out_trade_no'];
			}
			Yii::log("NOTIFY ${trade_no} 验证失败","info","recharge.zfb");
		    echo "fail";
			return;
		}
	}

	public function actionReturn()
	{
		Yii::import('application.vendors.*');
		require_once("ali.php");

		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();

		if($verify_result) {//验证成功
		    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
			//商户订单号
			$out_trade_no = $_GET['out_trade_no'];
			//支付宝交易号
			$trade_no = $_GET['trade_no'];
			//交易状态
			$trade_status = $_GET['trade_status'];
		
		    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
				if ($this->recharge($out_trade_no)) {
					Yii::log("RETURN ${trade_status} 完成交易 ${out_trade_no} 成功","info","recharge.zfb");
					$this->render('result', array(
						'result'=>"充值成功！",
					));
					return;
				} else {
					Yii::log("RETURN ${trade_status} 完成交易 ${out_trade_no} 失败","info","recharge.zfb");
				}
		    }
		    else {
				Yii::log("RETURN ${trade_status} 未处理的交易状态。","info","recharge.zfb");
		    }
			Yii::log("RETURN 验证成功","info","recharge.zfb");
		}
		else {
			$trade_no = "NOT_POST";
			if (array_key_exists("out_trade_no", $_POST)) {
				$trade_no = $_POST['out_trade_no'];
			}
			Yii::log("RETURN ${trade_no} 验证失败","info","recharge.zfb");
		}
		$this->render('result', array(
			'result'=>"充值失败！",
		));
	}

	public function hfbVerify($config)
	{
		$result=$_GET['result'];
		$pay_message=$_GET['pay_message'];
		$agent_id=$_GET['agent_id'];
		$jnet_bill_no=$_GET['jnet_bill_no'];
		$agent_bill_id=$_GET['agent_bill_id'];
		$pay_type=$_GET['pay_type'];
		$pay_amt=$_GET['pay_amt'];
		$remark=$_GET['remark'];
		$returnSign=$_GET['sign'];
		
		$key = $config['key'];
		
		$signStr ='';
		$signStr = $signStr . 'result=' . $result;
		$signStr = $signStr . '&agent_id=' . $agent_id;
		$signStr = $signStr . '&jnet_bill_no=' . $jnet_bill_no;
		$signStr = $signStr . '&agent_bill_id=' . $agent_bill_id;
		$signStr = $signStr . '&pay_type=' . $pay_type;
		$signStr = $signStr . '&pay_amt=' . $pay_amt;
		$signStr = $signStr . '&remark=' . $remark;
		$signStr = $signStr . '&key=' . $key;
		
		$sign='';
		$sign=md5($signStr);

		if ($sign == $returnSign) {
			return true;
		} else {
			return false;
		}
	}

	public function actionHfbNotify()
	{
		header("Content-Type: text/plain");
		Yii::import('application.vendors.*');
		require_once("hfb.php");

		if ($this->hfbVerify($hfb_config)) {
			$agent_bill_id = $_GET['agent_bill_id'];
			$result = $_GET['result'];
			echo 'ok';

			if ($this->isChargeFinished($agent_bill_id)) {
				Yii::log("NOTIFY CHARGE ${agent_bill_id} FINISHED", "info", "recharge.hfb");
				return;
			}

			if ($result == 1) {
				if ($this->recharge($agent_bill_id)) {
					Yii::log("NOTIFY SUCCESS ${agent_bill_id} CHARGE OK", "info", "recharge.hfb");
					return;
				} else {
					Yii::log("NOTIFY SUCCESS ${agent_bill_id} CHARGE FAILED", "info", "recharge.hfb");
					return;
				}
			} else {
				Yii::log("NOTIFY FAILED ${agent_bill_id}","info","recharge.hfb");
				return;
			}
		} else {
			echo "error";
			Yii::log("NOTIFY VERIFY FAILED","info","recharge.hfb");
			return;
		}
	}

	public function actionHfbReturn()
	{
		Yii::import('application.vendors.*');
		require_once("hfb.php");

		if ($this->hfbVerify($hfb_config)) {
			$agent_bill_id = $_GET['agent_bill_id']; //订单号
			$result = $_GET['result']; //支付结果 1:支付成功 0：支付失败

			if ($this->isChargeFinished($agent_bill_id)) {
				Yii::log("RETURN CHARGE ${agent_bill_id} FINISHED","info","recharge.hfb");
				$this->render('result', array(
					'result'=>"充值成功！",
				));
				return;
			}
			if ($result == 1) {
				if ($this->recharge($agent_bill_id)) {
					Yii::log("RETURN SUCCESS ${agent_bill_id} CHARGE OK","info","recharge.hfb");
					$this->render('result', array(
						'result'=>"充值成功！",
					));
					return;
				} else {
					Yii::log("RETURN SUCCESS ${agent_bill_id} CHARGE FAILED","info","recharge.hfb");
				}
			} else {
				Yii::log("RETURN FAILED ${agent_bill_id}","info","recharge.hfb");
			}
		} else {
			Yii::log("RETURN VERIFY FAILED","info","recharge.hfb");
		}
		$this->render('result', array(
			'result'=>"充值失败！",
		));
	}

	public function szfVerify($config)
	{
		$privateKey = $config['privateKey'];
		$certFile = $config['cacert'];
		
		//获得服务器返回数据
		$version = $_REQUEST['version']; //版本号
		$merId = $_REQUEST['merId']; //商户ID
		$payMoney =$_REQUEST['payMoney']; //支付金额
		$orderId = $_REQUEST['orderId']; //订单号
		$payResult = $_REQUEST['payResult']; //支付结果 1：支付成功 0：支付失败
		$privateField = $_REQUEST['privateField']; //商户私有数据
		$payDetails = $_REQUEST['payDetails']; //支付详情
		$md5String = $_REQUEST['md5String']; //MD5校验串
		$signString = $_REQUEST['signString']; //证书签名
		
		//进行MD5校验
		//md5(version+merId+payMoney+orderId+payResult+privateField+payDetails+privateKey)
		$myCombineString=$version.$merId.$payMoney.$orderId.$payResult.$privateField.$payDetails.$privateKey;
		$myMd5String=md5($myCombineString);

		if($myMd5String != $md5String) {
			return false;
		}
		
		//校验证书签名
		$fp = fopen($certFile, "r");
		$cert = fread($fp, 8192);
		fclose($fp);
		$pubkeyid = openssl_get_publickey($cert);
		
		if (openssl_verify($myMd5String, base64_decode($signString), $pubkeyid, OPENSSL_ALGO_MD5) != 1) {
			return false;
		}
		return true;
	}

	public function actionSzfNotify()
	{
		header("Content-Type: text/plain");
		Yii::import('application.vendors.*');
		require_once("szf.php");

		if ($this->szfVerify($szf_config)) {
			$orderId = $_REQUEST['orderId']; //订单号
			$payResult = $_REQUEST['payResult']; //支付结果 1:支付成功 0：支付失败

			echo $orderId;//响应服务器

			if ($this->isChargeFinished($orderId)) {
				Yii::log("NOTIFY CHARGE ${orderId} FINISHED","info","recharge.szf");
				return;
			}

			if ($payResult == 1) {
				if ($this->recharge($orderId)) {
					Yii::log("NOTIFY SUCCESS ${orderId} CHARGE OK","info","recharge.szf");
					return;
				} else {
					Yii::log("NOTIFY SUCCESS ${orderId} CHARGE FAILED","info","recharge.szf");
					return;
				}
			} else {
				Yii::log("NOTIFY FAILED ${orderId}","info","recharge.szf");
				return;
			}
		} else {
			Yii::log("NOTIFY VERIFY FAILED","info","recharge.szf");
			return;
		}
	}

	public function actionSzfReturn()
	{
		Yii::import('application.vendors.*');
		require_once("szf.php");

		if ($this->szfVerify($szf_config)) {
			$orderId = $_REQUEST['orderId']; //订单号
			$payResult = $_REQUEST['payResult']; //支付结果 1:支付成功 0：支付失败

			if ($this->isChargeFinished($orderId)) {
				Yii::log("RETURN CHARGE ${orderId} FINISHED","info","recharge.szf");
				$this->render('result', array(
					'result'=>"充值成功！",
				));
				return;
			}
			if ($payResult == 1) {
				if ($this->recharge($orderId)) {
					Yii::log("RETURN SUCCESS ${orderId} CHARGE OK","info","recharge.szf");
					$this->render('result', array(
						'result'=>"充值成功！",
					));
					return;
				} else {
					Yii::log("RETURN SUCCESS ${orderId} CHARGE FAILED","info","recharge.szf");
				}
			} else {
				Yii::log("RETURN FAILED ${orderId}","info","recharge.szf");
			}
		} else {
			Yii::log("RETURN VERIFY FAILED","info","recharge.szf");
		}
		$this->render('result', array(
			'result'=>"充值失败！",
		));
	}
	public function isChargeExists($id)
	{
		try {
			$charge = Charge::model()->findBySql(
				"SELECT * FROM charge WHERE no=?",
				array($id));
			if ($charge) {
				return $charge;
			}
			return false;
		} catch (Exception $e) {
			return false;
		}
	}
	public function findUserById($char_id)
	{
		try {
			$user = User::model()->findBySql(
				"SELECT * FROM User WHERE Id=?",
				array($char_id));
			if ($user) {
				return $user;
			}
			return false;
		} catch (Exception $e) {
			return false;
		}
	}

	public function isUserExists($char_name,$server_id)
	{
		try {
			$user = User::model()->findBySql(
				"SELECT * FROM User WHERE BINARY Name=? AND Server=?",
				array($char_name,$server_id));
			if ($user) {
				return $user;
			}
			return false;
		} catch (Exception $e) {
			return false;
		}
	}

	public function isAccountExists($id)
	{
		try {
			$account = Account::model()->findBySql(
				"SELECT * FROM account WHERE account=?",
				array((string)$id));
			if ($account) {
				return $account;
			}
			return false;
		} catch (Exception $e) {
			return false;
		}
	}
	
	public function FindAccountById($id)
	{
		try {
			$account = Account::model()->findBySql(
				"SELECT * FROM account WHERE id=?",
				array($id));
			if ($account) {
				return $account->yy;
			}
			return false;
		} catch (Exception $e) {
			return false;
		}
	}

	public function ValidateYyChargeParams()
	{
		$params = array(
			array('account', 'int'),
			array('orderid', 'string', 'length'=>array(20,25)),
			array('rmb', 'int'),
			array('type', 'string'),
			array('time', 'int'),
			array('game','string'),
			array('server','string'),
			array('itemid','string','value'=>'gold')
		);
		foreach( $params as $param ) {
			$value = null;
			if (!isset($_GET[$param[0]] )) {
				return false;
			}
			else{
				$value = $_GET[$param[0]];
			}
			if ($param[1] === 'int') {
				$value = (int)$value;
				if ( $value <= 0 ) {
					return false;	
				}
				$_GET[$param[0]] = $value;
			}elseif ($param[1] === 'string') {
				if (!is_string($value) ) {
					return false;	
				}
				if (array_key_exists('length', $param)) {
					$len = strlen($value);
					if (!in_array($len, $param['length'])) {
						return false;
					}
				}
				if (array_key_exists('value', $param) ) {
					if ($value != $param['value'] ) {
						return false;	
					}
				}
			}
		}
		return true;
	}

	//public function actionYycharge(){

	//	$ipfilters = array(
	//		'192.168.16.121','121.14.39.205',
	//		'58.215.138.12','122.97.250.12',
	//		'58.215.138.13','122.97.250.13',
	//		'58.215.138.14','122.97.250.14',
	//		'58.215.138.15','122.97.250.15',
	//		'58.215.138.49','122.97.250.49',
	//		'58.215.138.50','122.97.250.50',
	//		'58.215.138.52','122.97.250.52',
	//		'58.215.138.53','122.97.250.53',
	//		'58.215.138.54','122.97.250.54',
	//		'113.108.228.228','58.248.181.100',
	//		'113.108.228.230','113.108.228.230',
	//		'113.108.228.232','58.248.181.104',
	//		'113.108.228.235','58.248.181.107',
	//		'119.147.160.186','58.248.183.154',
	//		'113.108.228.118','58.248.184.54',
	//		'121.10.141.235','58.253.70.235'
	//	);

	//	$ip = Yii::app()->request->userHostAddress;
	//	if (!in_array($ip, $ipfilters)) {
	//		echo json_encode(array('code'=>-21,'data'=>null));
	//		return;
	//	}

	//	if (!$this->ValidateYyChargeParams()) {
	//		echo json_encode(array('code'=>-10,'data'=>null));
	//		return;
	//	}

	//	if (strtotime('2015-6-15')>$_GET['time']) {
	//		echo json_encode(array('code'=>-15,'data'=>null));
	//		return;
	//	}
	//	$sign = "";

	//	$params=array('account','orderid','rmb','num','type','time','game',
	//		'server','role','itemid','price','cparam');
	//	foreach( $params as $param ) {
	//		$sign = $sign.$_GET[$param];
	//	}
	//	$secret = 'yPowqyJpOT2VNDEuX7O2qW5Px2eMrexr';
	//	$sign = $sign.$secret;
	//	if (strtolower(md5($sign)) != $_GET['sign'] ) {
	//		echo json_encode(array('code'=>-11,'data'=>null));
	//		return;
	//	}
	//	$account = $this->isAccountExists($_GET['account']);
	//	if (!$account ) {
	//		echo json_encode(array('code'=>-19,'data'=>null));
	//		return;
	//	}
	//	$charge = $this->isChargeExists($_GET['orderid']);
	//	if ($charge) {
	//		echo json_encode(array('code'=>-18,
	//			'data'=>array(
	//				'orderid'=>$charge->no,
	//				'rmb' => $charge->fee,
	//				'account' =>$this->FindAccountById($charge->account_id),
	//		)));
	//		return;
	//	}
	//	$model=new Charge;
	//	$model->no = $_GET['orderid'];
	//	$model->status = Charge::CREATED;
	//	$model->account_id = $account->id;
	//	$model->creator_id = $account->id;
	//	$model->fee = $_GET['rmb'];
	//	$model->amount = $_GET['rmb'] * 10;
	//	$model->hide= 0;
	//	$model->charge_type = $_GET['type'];
	//	$model->time = date('Y-m-d H:i:s',$_GET['time']);
	//	//下面3个是为验证
	//	$model->account_name = $account->account;
	//	$model->account_confirm = $account->account;
	//	$model->bank = 'zfb';

	//	if (!$model->validate()) {
	//		echo json_encode(array('code'=>-20,'data'=>null));
	//		return;
	//	}
	//	if ($model->save()) {
	//		if ($this->recharge($model->no)) {
	//			echo json_encode(array('code'=>1,
	//				'data'=>array(
	//					'orderid'=>$_GET['orderid'],
	//					'rmb' => $_GET['rmb'],
	//					'account' => $_GET['account']
	//			)));
	//			return;
	//		}
	//	}
	//	echo json_encode(array('code'=>-20,'data'=>null));
	//}
	//
	public function actionVerifyxyCharge(){
		$ipfilters = array(
			'192.168.16.121','210.73.216.91','210.73.216.83','210.73.216.124','210.73.216.125',
		);
		$ip = Yii::app()->request->userHostAddress;
		if (!in_array($ip, $ipfilters)) {
			echo json_encode(array('res'=>-8,'msg'=>"ip invalid"));
			return;
		}
		if (!isset($_POST['account']) || !isset($_POST['server'])) {
			echo json_encode(array('res'=>-1,'msg'=>'account not exists'));
			return;
		}
		$_POST['account'] = urldecode($_POST['account']);
		$user = $this->isUserExists($_POST['account'], $_POST['server']);
		if (!$user) {
			echo json_encode(array('res'=>-1,'msg'=>'account not exists'));
			return;
		}

		$account = $this->isAccountExists($user->Account);
		if (!$account || $account->from != "17173") {
			echo json_encode(array('res'=>-1,'msg'=>'account not xinyou'));
			return;
		}

		if (!isset($_POST['time']) || abs(time() - $_POST['time']) > 600) {
			echo json_encode(array('res'=>-3,'msg'=>"time invalid"));
			return;
		}
		$sign = "";
		$params=array('account','gameid','zone','server','time');
		foreach( $params as $param ) {
			if (!isset($_POST[$param])) {
				echo json_encode(array('res'=>-9,'msg'=>"param missing ".$param));
				return;	
			}
			$sign = $sign.$_POST[$param];
		}
		$key = 'nJ8vCbhhUFOi3wQd';
		$sign = $sign.$key;
		if (!isset($_POST['sign']) || strtolower(md5($sign)) != $_POST['sign'] ) {
			echo json_encode(array('res'=>-2,'msg'=>'sign invalid'));
			return;
		}
		echo json_encode(array('res'=>1,'msg'=>'allow charge','result'=>substr($account->account,3)));
	}

	public function ValidateXyChargeParams()
	{
		$params = array(
			array('account', 'string'),
			array('gameid', 'string'),
			array('orderid', 'string'),
			array('amount', 'int'),
			array('coins', 'int'),
			array('channel', 'string'),
			array('zone', 'string'),
			array('server', 'int'),
			array('clientip', 'string'),
			array('time','int'),
			array('sign','string'),
		);
		foreach( $params as $param ) {
			$value = null;
			if (!isset($_POST[$param[0]] )) {
				echo json_encode(array('res'=>-9,'msg'=>"param missing ".$param[0]));
				return false;
			}
			else{
				$value = $_POST[$param[0]];
			}
			if ($param[1] === 'int') {
				$value = (int)$value;
				if ( $value <= 0 ) {
					echo json_encode(array('res'=>-9,'msg'=>"param invalid ".$param[0]));
					return false;	
				}
				$_POST[$param[0]] = $value;
			}elseif ($param[1] === 'string') {
				if (!is_string($value) ) {
					echo json_encode(array('res'=>-9,'msg'=>"param invalid ".$param[0]));
					return false;	
				}
			}
		}
		return true;
	}
	public function actionXycharge(){

		$ipfilters = array(
			'192.168.16.121','210.73.216.91','210.73.216.83',
		);
		$ip = Yii::app()->request->userHostAddress;
		if (!in_array($ip, $ipfilters)) {
			echo json_encode(array('res'=>-8,'msg'=>"ip invalid"));
			return;
		}

		if (!$this->ValidateXyChargeParams()) {
			return;
		}

		if ($_POST['gameid'] != 'gshx') {
			echo json_encode(array('res'=>-4,'msg'=>"gameid invalid"));
			return;
		}
		
		if ($_POST['amount'] < 1) {
			echo json_encode(array('res'=>-5,'msg'=>"amount invalid"));
			return;
		}
		if (abs(time() - $_POST['time']) > 600) {
			echo json_encode(array('res'=>-3,'msg'=>"time invalid"));
			return;
		}

		$_POST['account'] = urldecode($_POST['account']);
		$sign = "";
		$params=array('account','gameid','orderid','amount','coins',
			'channel','zone','server','clientip','time');
		foreach( $params as $param ) {
			$sign = $sign.$_POST[$param];
		}
		$key = 'nJ8vCbhhUFOi3wQd';
		$sign = $sign.$key;
		if (strtolower(md5($sign)) != $_POST['sign'] ) {
			echo json_encode(array('res'=>-2,'msg'=>'sign invalid'));
			return;
		}
		$user = $this->isUserExists($_POST['account'],$_POST['server']);
		if (!$user ) {
			echo json_encode(array('res'=>-1,'msg'=>'account not exists'));
			return;
		}

		$account = $this->isAccountExists($user->Account);
		if (!$account || $account->from != "17173") {
			echo json_encode(array('res'=>-1,'msg'=>'account not xinyou'));
			return;
		}
		
		$prefix = "xy_";
		$orderid = $prefix.$_POST['orderid'];
		$charge = $this->isChargeExists($orderid);
		if ($charge) {
			echo json_encode(array('res'=>0,'msg'=>'orderid already exists'));
			return;
		}
		$model=new Charge;
		$model->no = $orderid;
		$model->status = Charge::CREATED;
		$model->account_id = $account->id;
		$model->char_id = $user->Id;
		$model->server_id = $_POST['server'];
		$model->game_type = 28;
		//$model->creator_id = $account->id;
		$model->fee = $_POST['amount'];
		$model->amount = $_POST['amount'] * 10;
		$model->hide= 0;
		$model->charge_type = $_POST['channel'];
		$model->time = date('Y-m-d H:i:s',$_POST['time']);
		//下面3个是为验证
		$model->account_name = $account->account;
		//$model->account_confirm = $account->account;
		$model->bank = 'zfb';

		if (!$model->validate()) {
			echo json_encode(array('res'=>-10,'msg'=>"unknown error"));
			return;
		}
		if ($model->save()) {
			if ($this->recharge($model->no)) {
				echo json_encode(array('res'=>0,
					'msg'=>'charge success'));
				return;
			}
		}
		echo json_encode(array('res'=>-11,'msg'=>"unknown error"));
	}

	public function ValidateChargeParams($params) 
	{
		foreach( $params as $param ) {
			$value = null;
			if (!isset($_POST[$param[0]] )) {
				echo json_encode(array('res'=>-9,'msg'=>"param missing ".$param[0]));
				return false;
			}
			else{
				$value = $_POST[$param[0]];
			}
			if ($param[1] === 'int') {
				$value = (int)$value;
				if ( $value <= 0 ) {
					echo json_encode(array('res'=>-9,'msg'=>"param invalid ".$param[0]));
					return false;	
				}
				$_POST[$param[0]] = $value;
			}elseif ($param[1] === 'string') {
				if (!is_string($value) ) {
					echo json_encode(array('res'=>-9,'msg'=>"param invalid ".$param[0]));
					return false;	
				}
			}
		}
		return true;

	}

	public function actionSwcharge(){
		$ipfilters = array(
			'119.97.142.81','119.97.142.23','119.97.142.24','123.157.210.27'
		);
		$ip = Yii::app()->request->userHostAddress;
		if (!in_array($ip, $ipfilters)) {
			echo json_encode(array('res'=>-8,'msg'=>"ip invalid"));
			return;
		}

		$params = array(
			array('orderNo', 'string'),
			array('gameId', 'string'),
			array('guid', 'string'),
			array('region', 'string'),
			array('money', 'int'),
			array('coins', 'int'),
			array('time', 'string'),
			array('sign', 'string'),
		);
		if (!$this->ValidateChargeParams($params)) {
			return;
		}

		if ($_POST['gameId'] != '3397') {
			echo json_encode(array('res'=>-4,'msg'=>"gameId invalid"));
			return;
		}
		
		if ($_POST['money'] < 1) {
			echo json_encode(array('res'=>-5,'msg'=>"money invalid"));
			return;
		}
		
		$key = 'rngqeRBWGJXjifU1wT5U7gCNZ6FtnCaY';
		$sign = $_POST['coins'].'|'.$_POST['gameId'].'|'.$_POST['guid'].'|'.$_POST['money']
			.'|'.$_POST['orderNo'].'|'.$_POST['region'].'|'.$_POST['time'].'|'.$key;

		if (strtoupper(md5($sign)) != $_POST['sign'] ) {
			echo json_encode(array('res'=>-2,'msg'=>'sign invalid'));
			return;
		}
		$prefix = "sw_";
		$account = $this->isAccountExists($prefix.$_POST['guid']);
		if (!$account || $account->from != "18000") {
			echo json_encode(array('res'=>-1,'msg'=>'account not exists'));
			return;
		}

		$orderNo = $prefix.$_POST['orderNo'];
		$charge = $this->isChargeExists($orderNo);
		if ($charge) {
			echo json_encode(array('res'=>-7,'msg'=>'orderid already exists'));
			return;
		}
		$model=new Charge;
		$model->no = $orderNo;
		$model->status = Charge::CREATED;
		$model->account_id = $account->id;
		$model->char_id = 0;
		$model->server_id = $_POST['region'];
		$model->game_type = 28;
		$model->fee = $_POST['money'];
		$model->amount = $_POST['money'] * 10;
		$model->hide= 0;
		$model->charge_type = 'sw';
		$model->time = date('Y-m-d H:i:s',$_POST['time']);
		//下面3个是为验证
		$model->account_name = $account->account;
		//$model->account_confirm = $account->account;
		$model->bank = 'zfb';

		if (!$model->validate()) {
			echo json_encode(array('res'=>-10,'msg'=>"unknown error"));
			return;
		}
		if ($model->save()) {
			if ($this->recharge($model->no)) {
				echo json_encode(array('res'=>0,
					'msg'=>'charge success'));
				return;
			}
		}
		echo json_encode(array('res'=>-11,'msg'=>"unknown error"));
	}

	public function actionStcharge(){
		$ipfilters = array(
			'116.211.100.254','210.51.213.254',
			'59.175.233.154','220.249.92.18',
			'116.211.100.246','210.14.157.11',
			'210.14.157.12','210.14.157.13',
			'210.14.157.14','116.211.100.254',
			'210.51.213.254','59.175.233.154',
			'220.249.92.18','116.211.100.246',
			'220.249.92.50','47.100.34.42',
			'106.14.143.162','47.100.35.39',
			'106.14.223.225','106.14.0.166',

		);
		$ip = Yii::app()->request->userHostAddress;
		if (!in_array($ip, $ipfilters)) {
			echo json_encode(array('errno'=>-5,'errmsg'=>"ip invalid"));
			return;
		}
		$params = array(
			"gameCode","gameOrderId","money","orderId","serverId","time","userId","sign"
		);

		$values = array();
		foreach( $params as $param ) {
			if (!isset($_GET[$param] )) {
				echo json_encode(array('errno'=>-1,'errmsg'=>"missing param ".$param ));
				return;
			}
			else
			{
				array_push($values,$_GET[$param]);
			}
		}
		$key="BD27A225FCBDD15E335914AA53E815E5";
		array_pop($values);
		array_push($values,$key);
		if (strtolower(md5(implode("",$values))) != $_GET["sign"]) {
			echo json_encode(array('errno'=>-2,'errmsg'=>"sign invalid"));
			return;
		}
		$prefix = "st_";
		$account = $this->isAccountExists($prefix.$_GET['userId']);
		if (!$account || $account->from != "18001") {
			echo json_encode(array('errno'=>-3,'errmsg'=>'account not exists'));
			return;
		}

		$orderId = $prefix.$_GET['orderId'];
		$charge = $this->isChargeExists($orderId);
		if ($charge) {
			echo json_encode(array('errno'=>1,'errmsg'=>'orderid already exists'));
			return;
		}
		$model=new Charge;
		$model->no = $orderId;
		$model->status = Charge::CREATED;
		$model->account_id = $account->id;
		$model->char_id = 0;
		$model->server_id = $_GET['serverId'];
		$model->game_type = 28;
		$model->fee = (int)$_GET['money'];
		$model->amount = $model->fee * 10;
		$model->hide= 0;
		$model->charge_type = 'st';
		$model->time = date('Y-m-d H:i:s',$_GET['time']);
		//下面3个是为验证
		$model->account_name = $account->account;
		//$model->account_confirm = $account->account;
		$model->bank = 'zfb';

		if ($model->validate() && $model->save() && $this->recharge($model->no)) {
			echo json_encode(array(
				'errno'=>0,
				'errmsg'=>'charge success',
				'data'=>array(
					'orderId' => $model->no,
					'userId' => $_GET['userId'],
					'coins' => $model->amount,
					'money' => $model->fee,
					'time' => strtotime($model->time)
				)));
		} else {
			echo json_encode(array('errno'=>-6,'errmsg'=>"database error"));
		}
	}
	
	public function actionVerifyfhCharge(){
		$ipfilters = array(
			"122.228.214.133",
			"122.228.214.134",
			"122.228.214.141",
			"122.228.214.142",
			"122.228.214.143",
			"122.228.214.144",
			"60.12.47.210",
			"60.12.47.211",
			"60.12.47.212",
			"60.12.47.213",
			"122.228.214.157",
			"122.228.214.158 ",
			"122.228.214.137",
			"122.228.214.138 ",
			"221.228.215.183",
			"221.228.215.184",
			"221.228.215.185",
			"221.228.215.186",
			"221.228.215.188",
			"221.228.215.191",
			"221.228.215.117",
			"221.228.215.118",
			"221.228.215.119",
			"221.228.215.120",
			"221.228.215.104",
			"139.196.186.44",
			"203.80.150.2",
			"203.80.150.3",
			"203.80.150.4",
			"203.80.150.5",
			"203.80.150.6",
			"203.80.150.7",
			"203.80.150.8",
			"203.80.150.9",
			"203.80.150.10",
			"203.80.150.11",
			"203.80.150.12",
			"203.80.150.13",
			"203.80.150.14",
			"203.80.150.15",
			"203.80.150.16",
			"203.80.150.17",
			"203.80.150.18",
			"203.80.150.19",
			"203.80.150.20",
			"203.80.150.21",
			"203.80.150.22",
			"203.80.150.23",
			"203.80.150.24",
			"203.80.150.25",
			"203.80.150.26",
			"203.80.150.27",
			"203.80.150.28",
			"203.80.150.29",
			"203.80.150.30",
			"203.80.150.31",
			"203.80.150.32",
			"203.80.150.33",
			"203.80.150.34",
			"203.80.150.35",
			"203.80.150.36",
			"203.80.150.37",
			"203.80.150.38",
			"203.80.150.39",
			"203.80.150.40",
			"203.80.150.41",
			"203.80.150.42",
			"203.80.150.43",
			"203.80.150.44",
			"203.80.150.45",
			"203.80.150.46",
			"203.80.150.47",
			"203.80.150.48",
			"203.80.150.49",
			"203.80.150.50",
			"203.80.150.51",
			"203.80.150.52",
			"203.80.150.53",
			"203.80.150.54",
			"203.80.150.55",
			"203.80.150.56",
			"203.80.150.57",
			"203.80.150.58",
			"203.80.150.59",
			"203.80.150.60",
			"203.80.150.61",
			"203.80.150.62",
			"180.101.193.131",
			"180.101.193.140 ",
			"180.101.193.141",
			"180.101.193.143",
			"180.101.193.144",
			"180.101.193.157",
			"180.101.193.158",
			"180.101.193.169",
			"180.101.193.186",
			"180.101.193.165",
			"116.228.188.74",
		);
		$ip = Yii::app()->request->userHostAddress;
		if (!in_array($ip, $ipfilters)) {
			echo json_encode(array('res'=>-8,'msg'=>"ip invalid"));
			return;
		}
		if (!isset($_POST['charid'])) {
			echo json_encode(array('res'=>-1,'msg'=>'account not exists'));
			return;
		}
		$user = $this->findUserById($_POST['charid']);
		if (!$user) {
			echo json_encode(array('res'=>-1,'msg'=>'account not exists'));
			return;
		}

		$account = $this->isAccountExists($user->Account);
		if (!$account || $account->from != "18002") {
			echo json_encode(array('res'=>-1,'msg'=>'account not fh'));
			return;
		}

		if (!isset($_POST['time']) || abs(time() - $_POST['time']) > 600) {
			echo json_encode(array('res'=>-3,'msg'=>"time invalid"));
			return;
		}
		$sign = "";
		$params=array('charid','gameid','zone','server','time');
		foreach( $params as $param ) {
			if (!isset($_POST[$param])) {
				echo json_encode(array('res'=>-9,'msg'=>"param missing ".$param));
				return;	
			}
			$sign = $sign.$_POST[$param];
		}
		$key = 'eLxIMb9wlLS4tCR7';
		$sign = $sign.$key;
		if (!isset($_POST['sign']) || strtolower(md5($sign)) != $_POST['sign'] ) {
			echo json_encode(array('res'=>-2,'msg'=>'sign invalid'));
			return;
		}
		echo json_encode(array('res'=>1,'msg'=>'allow charge','result'=>substr($account->account,3)));
	}

	public function actionFhcharge(){
		$ipfilters = array(
			"122.228.214.133",
			"122.228.214.134",
			"122.228.214.141",
			"122.228.214.142",
			"122.228.214.143",
			"122.228.214.144",
			"60.12.47.210",
			"60.12.47.211",
			"60.12.47.212",
			"60.12.47.213",
			"122.228.214.157",
			"122.228.214.158 ",
			"122.228.214.137",
			"122.228.214.138 ",
			"221.228.215.183",
			"221.228.215.184",
			"221.228.215.185",
			"221.228.215.186",
			"221.228.215.188",
			"221.228.215.191",
			"221.228.215.117",
			"221.228.215.118",
			"221.228.215.119",
			"221.228.215.120",
			"221.228.215.104",
			"139.196.186.44",
			"203.80.150.2",
			"203.80.150.3",
			"203.80.150.4",
			"203.80.150.5",
			"203.80.150.6",
			"203.80.150.7",
			"203.80.150.8",
			"203.80.150.9",
			"203.80.150.10",
			"203.80.150.11",
			"203.80.150.12",
			"203.80.150.13",
			"203.80.150.14",
			"203.80.150.15",
			"203.80.150.16",
			"203.80.150.17",
			"203.80.150.18",
			"203.80.150.19",
			"203.80.150.20",
			"203.80.150.21",
			"203.80.150.22",
			"203.80.150.23",
			"203.80.150.24",
			"203.80.150.25",
			"203.80.150.26",
			"203.80.150.27",
			"203.80.150.28",
			"203.80.150.29",
			"203.80.150.30",
			"203.80.150.31",
			"203.80.150.32",
			"203.80.150.33",
			"203.80.150.34",
			"203.80.150.35",
			"203.80.150.36",
			"203.80.150.37",
			"203.80.150.38",
			"203.80.150.39",
			"203.80.150.40",
			"203.80.150.41",
			"203.80.150.42",
			"203.80.150.43",
			"203.80.150.44",
			"203.80.150.45",
			"203.80.150.46",
			"203.80.150.47",
			"203.80.150.48",
			"203.80.150.49",
			"203.80.150.50",
			"203.80.150.51",
			"203.80.150.52",
			"203.80.150.53",
			"203.80.150.54",
			"203.80.150.55",
			"203.80.150.56",
			"203.80.150.57",
			"203.80.150.58",
			"203.80.150.59",
			"203.80.150.60",
			"203.80.150.61",
			"203.80.150.62",
			"180.101.193.131",
			"180.101.193.140 ",
			"180.101.193.141",
			"180.101.193.143",
			"180.101.193.144",
			"180.101.193.157",
			"180.101.193.158",
			"180.101.193.169",
			"180.101.193.186",
			"180.101.193.165",
			"116.228.188.74",
		);
		$ip = Yii::app()->request->userHostAddress;
		if (!in_array($ip, $ipfilters)) {
			echo json_encode(array('res'=>-8,'msg'=>"ip invalid"));
			return;
		}
		$params = array(
			array('charid', 'int'),
			array('gameid', 'string'),
			array('orderid', 'string'),
			array('amount', 'int'),
			array('coins', 'int'),
			array('channel', 'string'),
			array('zone', 'string'),
			array('server', 'int'),
			array('clientip', 'string'),
			array('time','int'),
			array('sign','string'),
		);
		if (!$this->ValidateChargeParams($params)) {
			return;
		}

		if ($_POST['gameid'] != 'gshx') {
			echo json_encode(array('res'=>-4,'msg'=>"gameid invalid"));
			return;
		}
		
		if ($_POST['amount'] < 1) {
			echo json_encode(array('res'=>-5,'msg'=>"amount invalid"));
			return;
		}
		if (abs(time() - $_POST['time']) > 600) {
			echo json_encode(array('res'=>-3,'msg'=>"time invalid"));
			return;
		}

		$sign = "";
		$params=array('charid','gameid','orderid','amount','coins',
			'channel','zone','server','clientip','time');
		foreach( $params as $param ) {
			$sign = $sign.$_POST[$param];
		}
		$key = 'eLxIMb9wlLS4tCR7';
		$sign = $sign.$key;
		if (strtolower(md5($sign)) != $_POST['sign'] ) {
			echo json_encode(array('res'=>-2,'msg'=>'sign invalid'));
			return;
		}
		$user = $this->findUserById($_POST['charid']);
		if (!$user ) {
			echo json_encode(array('res'=>-1,'msg'=>'account not exists'));
			return;
		}

		$account = $this->isAccountExists($user->Account);
		if (!$account || $account->from != "18002") {
			echo json_encode(array('res'=>-1,'msg'=>'account not fh'));
			return;
		}
		
		$prefix = "fh_";
		$orderid = $prefix.$_POST['orderid'];
		$charge = $this->isChargeExists($orderid);
		if ($charge) {
			echo json_encode(array('res'=>0,'msg'=>'orderid already exists'));
			return;
		}
		$model=new Charge;
		$model->no = $orderid;
		$model->status = Charge::CREATED;
		$model->account_id = $account->id;
		$model->char_id = $user->Id;
		$model->server_id = $_POST['server'];
		$model->game_type = 28;
		//$model->creator_id = $account->id;
		$model->fee = $_POST['amount'];
		$model->amount = $_POST['amount'] * 10;
		$model->hide= 0;
		$model->charge_type = $_POST['channel'];
		$model->time = date('Y-m-d H:i:s',$_POST['time']);
		//下面3个是为验证
		$model->account_name = $account->account;
		//$model->account_confirm = $account->account;
		$model->bank = 'zfb';

		if (!$model->validate()) {
			echo json_encode(array('res'=>-10,'msg'=>"unknown error"));
			return;
		}
		if ($model->save()) {
			if ($this->recharge($model->no)) {
				echo json_encode(array('res'=>0,
					'msg'=>'charge success'));
				return;
			}
		}
		echo json_encode(array('res'=>-11,'msg'=>"unknown error"));
	}
	public function actionYhcharge(){

		$content = file_get_contents('php://input');
		Yii::log("RETURN YHCHARGE ${content}","info","recharge.zfb");

		$postData = json_decode(file_get_contents('php://input'),true);
		if (!is_array($postData)) {
			echo -1;
			return;
		}
		//$ipfilters = array(
		//);
		//$ip = Yii::app()->request->userHostAddress;
		//if (!in_array($ip, $ipfilters)) {
		//	echo json_encode(array('res'=>-8,'msg'=>"ip invalid"));
		//	return;
		//}
	

		$params = array(
			array('cpTradeNo', 'Y'),
			array('gameId', 'Y'),
			array('userId', 'Y'),
			array('roleId', 'Y'),
			array('serverId', 'N'),
			array('channelId', 'Y'),
			array('itemId', 'N'),
			array('itemAmount', 'Y'),
			array('privateField', 'Y'),
			array('money', 'Y'),
			array('status', 'Y'),
		);
		
		$sign_array = array();
		foreach( $params as $param ) {
			$value = null;
			if (!isset($postData[$param[0]] )) {
				if ($param[1] === 'Y') {
					echo -1;
					return;
				}
			}
			else{
				$value = $postData[$param[0]];
			}
			array_push($sign_array,$value);
		}
		
		$gameId = 80097;
		$appKey = "d1d155d24dfddba3457ead";
		if ($postData['gameId'] != $gameId) {
			echo -1;
			return;
		}
		array_push($sign_array,$appKey);
		if (strtolower(md5(implode("|",$sign_array))) != $postData['sign'] ) {
			echo -1;
			return;
		}
		$prefix = "yh_";
		$account = $this->isAccountExists($prefix.$postData['privateField']);
		if (!$account) {
			echo -1;
			return;
		}

		$roleId = $postData["roleId"];
		$User = Yii::app()->db->createCommand(
			"SELECT * FROM User WHERE Id=$roleId"	
		)->queryAll();

		if (!$User) {
			echo -1;
			return;	
		}

		$orderNo = $prefix.$postData['cpTradeNo'];
		$charge = $this->isChargeExists($orderNo);
		if ($charge) {
			echo $postData["cpTradeNo"];
			return;
		}

		$model=new Charge;
		$model->no = $orderNo;
		$model->status = Charge::CREATED;
		$model->account_id = $account->id;
		$model->char_id = $roleId;
		$model->server_id = $postData['serverId'];
		$model->game_type = 29;
		$model->fee = $postData['money']/100;
		$model->itemid = $postData['itemId'];
		$model->amount = $postData['money'] / 10;
		$model->hide= 0;
		$model->charge_type = $postData['channelId'];
		$model->time = date('Y-m-d H:i:s');
		//下面3个是为验证
		$model->account_name = $account->account;
		//$model->account_confirm = $account->account;
		$model->bank = 'zfb';

		if (!$model->validate()) {
			echo -1;
			return;
		}
		if ($model->save()) {
			if ($this->recharge($model->no)) {
				Yii::log("YHCHARGE SUCCESS ${orderNo} CHARGE OK", "info", "recharge.hfb");
				echo $postData["cpTradeNo"];
				return;
			}
		}
		echo -1;
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria();

		$criteria->compare('account_id', Yii::app()->user->id);
		$criteria->compare('hide', 0);
		$criteria->order = "`time` DESC";

		$count = Charge::model()->count($criteria);
		$pages = new CPagination($count);

		$pages->pageSize = 6;
		$pages->applyLimit($criteria);

		$models = Charge::model()->findAll($criteria);

		$this->render('index', array(
			'models'=>$models,
			'pages' =>$pages,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Charge('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Charge']))
			$model->attributes=$_GET['Charge'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Charge the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Charge::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Charge $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) &&
			(
				$_POST['ajax']==='charge-form1' ||
				$_POST['ajax']==='charge-form2' ||
				$_POST['ajax']==='charge-form3' ||
				$_POST['ajax']==='charge-form4' ||
				$_POST['ajax']==='charge-form5' ||
				$_POST['ajax']==='charge-form6'

			)
		)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
