<?php

class PromoterController extends Controller
{
	// Uncomment the following methods and override them if needed
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);

	}
	/*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('index','charge','chargeexcel','reg','regexcel','player','playerexcel'),
				'users'=>array('@'),
			),

			array('allow',
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function loadModel($id){
		return Promoter::model()->findByPk($id);
	}

	public function actionIndex(){
		$this->render('index');
	}

	public function authPromoter(){
		$id = Yii::app()->user->getId();
		$model = $this->loadModel($id);
		if (!$model) {
			throw new CHttpException(404, "您不是推广员。");
		}	
		return $model;
	}

	public function actionReg(){
		$model = $this->authPromoter();
		$models = null;
		$pages	= null;
		$startTime = null;
		$endTime = null;
		$daily = null;

		if(isset($_GET['Account'])) {
			$startTime = $_GET['Account']['StartTime'];
			$endTime = $_GET['Account']['EndTime'];
			if (isset($_GET['Account']['daily'])) {
				$daily = $_GET['Account']['daily'];
			}

			$criteria = new CDbCriteria();
			$sql = "SELECT count(DISTINCT t.account) as accounts,
				webcounter.clicks as clicks,
				DATE_FORMAT(t.time,'%Y-%m-%d') as d,
				count(DISTINCT login.account) as logins,
				count(DISTINCT login.priip) as macs FROM `account` `t`
				LEFT JOIN webcounter on (t.`from`=webcounter.trace and to_days(t.time)= to_days(webcounter.time))
				LEFT JOIN login on (t.account=login.account)
				WHERE (t.`from` in $model->key) AND (to_days(t.time) between to_days('$startTime') and to_days('$endTime'))";

			$sqlCharge = "SELECT sum(charge.fee) as fee,
				DATE_FORMAT(t.time,'%Y-%m-%d') as d,
				count(DISTINCT charge.account_id) as charges from `account`	`t`
				LEFT JOIN charge on (`t`.id=charge.account_id and charge.`status`>=3 and left(charge.`no`,3)!='lp_')
				WHERE (t.`from` in $model->key) AND (to_days(t.time) between to_days('$startTime') and to_days('$endTime'))";

			if ($daily) {
				$sql .= "GROUP BY d";
				$sqlCharge .= "GROUP BY d";
			}

			$rows = Yii::app()->db_slave->createCommand($sql)->query();
			$pages=new CPagination($rows->rowCount);
			$pages->pageSize=15;
			$pages->applyLimit($criteria);

			$rows=Yii::app()->db_slave->createCommand($sql." LIMIT :limit OFFSET :offset");
			$rows->bindValue(':offset', $pages->currentPage*$pages->pageSize);
			$rows->bindValue(':limit', $pages->pageSize);
			$res=$rows->query();

			$chargeRows = Yii::app()->db_slave->createCommand($sqlCharge." LIMIT :limit OFFSET :offset");
			$chargeRows->bindValue(':offset', $pages->currentPage*$pages->pageSize);
			$chargeRows->bindValue(':limit', $pages->pageSize);
			$chargeRes = $chargeRows->query();

			$models = array();
			foreach ($res as $key=>$value) {
				array_push($models,$value);
			}
			foreach ($chargeRes as $key=>$value) {
				$models[$key] = array_merge($models[$key], $value);
			}
			
		}
		$this->render('reg',array(
			'models'=>$models,
			'pages'=>$pages,
			'starttime'=>$startTime,
			'endtime'=>$endTime,
			'daily'=>$daily,
		));
	}

	public function actionPlayer() {
		$model = $this->authPromoter();
		$models = null;
		$pages	= null;
		$startTime = null;
		$endTime = null;
		if(isset($_GET['Account'])) {
			$startTime = $_GET['Account']['StartTime'];
			$endTime = $_GET['Account']['EndTime'];

			$criteria = new CDbCriteria();
			$criteria->addCondition("`t`.`AccountFrom` in $model->key");
			$criteria->addCondition("to_days(`t`.birthday) between to_days('".$startTime."') and to_days('".$endTime."')");
			
			$count = Player::model()->count($criteria);
			$pages = new CPagination($count);

			$pages->pageSize = 6;
			$pages->applyLimit($criteria);

			$models = Player::model()->findAll($criteria);

		}
		$this->render('player',array(
			'models'=>$models,
			'pages'=>$pages,
			'starttime'=>$startTime,
			'endtime'=>$endTime,
		));

	}

	public function actionCharge() {
		$id = Yii::app()->user->getId();
		$model = $this->loadModel($id);
		if (!$model) {
			throw new CHttpException(404, "您不是推广员。");
		}	
		$models = null;
		$pages	= null;
		$startTime = null;
		$endTime = null;
		if(isset($_GET['Account'])) {
			$startTime = $_GET['Account']['StartTime'];
			$endTime = $_GET['Account']['EndTime'];

			$criteria = new CDbCriteria();
			$criteria->join = "LEFT JOIN account on `t`.account_id=account.id";
			$criteria->addCondition("account.`from` in $model->key");
			$criteria->addCondition("`t`.status>=3 and left(`t`.`no`,3)!='lp_'");
			$criteria->addCondition("DATE_FORMAT(`t`.time,'%Y-%m')>='".$startTime."'");
			$criteria->addCondition("DATE_FORMAT(`t`.time,'%Y-%m')<='".$endTime."'");
			//$criteria->order = "`time` DESC";

			$count = Charge::model()->count($criteria);
			$pages = new CPagination($count);

			$pages->pageSize = 6;
			$pages->applyLimit($criteria);

			$models = Charge::model()->findAll($criteria);

		}
		$this->render('charge',array(
			'models'=>$models,
			'pages'=>$pages,
			'starttime'=>$startTime,
			'endtime'=>$endTime,
		));

	}
	public function export_csv($filename,$data) {
		header("Content-type:text/csv");
		header("Content-Disposition:attachment;filename=".$filename);
		header('Cache-Control:must-revalidateost-check=0re-check=0');
		header('Expires:0');
		header('Pragma:public');
		echo $data;
	}

	public function actionChargeExcel() {
		$id = Yii::app()->user->getId();
		$model = $this->loadModel($id);
		if (!$model) {
			throw new CHttpException(404, "您不是推广员。");
		}	
		if(isset($_GET['Account'])) {
			$startTime = $_GET['Account']['StartTime'];
			$endTime = $_GET['Account']['EndTime'];

			$rows = Yii::app()->db_slave->createCommand(
				"SELECT `account`.`account` `account`, `charge`.`fee` `fee`,
				`charge`.`point` `point`, `charge`.`time` `time` FROM `charge`
				LEFT JOIN `account` on (`charge`.`account_id`=`account`.`id`)
				WHERE `account`.`from` in $model->key
				AND `charge`.`status`>=3
				AND left(`charge`.`no`,3)!='lp_'
				AND DATE_FORMAT(`charge`.`time`,'%Y-%m') >= '$startTime'
				AND DATE_FORMAT(`charge`.`time`,'%Y-%m') <= '$endTime'
				ORDER BY `charge`.`time`"
			)->query();

			$str = "充值账号,账单金额,游戏点数,创建时间\n";
			$str = iconv('utf-8','gb2312',$str);
			foreach($rows as $k=>$v){
				$str .= $v['account'].','.$v['fee'].','.$v['point'].','.$v['time']."\n";
			}
			$filename = 'charge'.date('Ymd').'.csv';
			$this->export_csv($filename,$str);
		}

	}

	public function actionRegExcel() {
		$model = $this->authPromoter();
		if(isset($_GET['Account'])) {
			$startTime = $_GET['Account']['StartTime'];
			$endTime = $_GET['Account']['EndTime'];


			$res = Yii::app()->db_slave->createCommand(
				"SELECT count(DISTINCT t.account) as accounts,
				webcounter.clicks as clicks,
				DATE_FORMAT(t.time,'%Y-%m-%d') as d,
				count(DISTINCT login.account) as logins,
				count(DISTINCT login.priip) as macs FROM `account` `t`
				LEFT JOIN webcounter on (t.`from`=webcounter.trace and to_days(t.time)= to_days(webcounter.time))
				LEFT JOIN login on (t.account=login.account)
				WHERE (t.`from` in $model->key) AND (to_days(t.time) between to_days('$startTime') and to_days('$endTime'))
				GROUP BY d"
				)->query();
			
			$chargeRes = Yii::app()->db_slave->createCommand("SELECT sum(charge.fee) as fee,
				DATE_FORMAT(t.time,'%Y-%m-%d') as d,
				count(DISTINCT charge.account_id) as charges from `account`	`t`
				LEFT JOIN charge on (`t`.id=charge.account_id and charge.`status`=3 and left(charge.`no`,3)!='lp_')
				WHERE (t.`from` in $model->key) AND (to_days(t.time) between to_days('$startTime') and to_days('$endTime'))
				GROUP BY d"
				)->query();

			$models = array();
			foreach ($res as $key=>$value) {
				array_push($models,$value);
			}
			foreach ($chargeRes as $key=>$value) {
				$models[$key] = array_merge($models[$key], $value);
			}

			$str = "日期,新增注册,登录账号,登录MAC,充值账号,充值金额,访问量\n";
			$str = iconv('utf-8','gb2312',$str);
			$keys = array('d','accounts','logins','macs','charges','fee','clicks');

			foreach($models as $k=>$v){
				$values = array();
				foreach($keys as $key) {
					if ($v[$key]) {
						array_push($values,$v[$key]);
					} else {
						array_push($values,0);
					}
				}
				$str .=implode(",",$values)."\n";
			}
			$filename = 'reg'.date('Ymd').'.csv';
			$this->export_csv($filename,$str);
		}
	}

	public function actionPlayerExcel() {
		$model = $this->authPromoter();
		if(isset($_GET['Account'])) {
			$startTime = $_GET['Account']['StartTime'];
			$endTime = $_GET['Account']['EndTime'];
			
			$rows = Yii::app()->db_slave->createCommand(
				"SELECT account, charid, name, birthday, grade, school, consume, vip FROM player
				WHERE `player`.`AccountFrom` in $model->key AND TO_DAYS(`player`.`birthday`) 
				BETWEEN TO_DAYS('$startTime') AND TO_DAYS('$endTime')"
			)->query();

			$str = "账号,角色Id,角色名,创建时间,等级,门派,兑换元宝,vip等级\n";
			$schoolNameArray = array("无门派","少林寺","丐帮","唐门","恶人谷","移花宫","武当派","白鹿书院","天山派");
			foreach($rows as $k=>$v){
				$schoolName = $schoolNameArray[$v['school']];
				$str .= $v['account'].','.$v['charid'].','.$v['name'].','.$v['birthday'].','.$v['grade'].','.$schoolName.','.$v['consume'].','.$v['vip']."\n";
			}
			$str = iconv('utf-8','gbk',$str);
			$filename = 'charge'.date('Ymd').'.csv';
			$this->export_csv($filename,$str);

		}
	}


}

