<?php

class GameactivitiesController extends Controller
{
	// Uncomment the following methods and override them if needed
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl', // perform access control for CRUD operations
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
			'actions'=>array('qbscore','lottery','address','rebate',
				'returngift','gethongbao','sethongbao'),
				'users'=>array('*'),
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
	public function getEventTime()
	{
		return "2015-06-05 17:00:00";
	}

		/* 
	 * 查询Qb积分
	 */
    public function actionQbScore()
	{
		//需要先登录
		if (Yii::app()->user->isGuest) {
			echo json_encode(array('res_code'=>-1,
				'value'=>"no login"));
			return;
		}
		$account_id = Yii::app()->user->getId();
		$attrs = Accattr::model()->findAllBySql(
			"SELECT * FROM `accattr` WHERE account_id=? AND attr like ?",
			array($account_id, "QBEVENT_".strtotime($this->getEventTime())."%" ));
		if (!$attrs){
			echo json_encode(array('res_code'=>0,'value'=>''));
			return;
		}
		$result = array();
		foreach($attrs as $attr) {
			$result = array_merge($result,  explode('|', $attr->value));
		}
		$result = array_values(array_unique($result));
		echo json_encode(array('res_code'=>0,'value'=>$result ));
		return;
	}
	/* 
	 * 领取Qb
	 */
    public function actionQbReward()
	{
		//判断mac ，出现过相同mac只能领取一次 
		//这个还是通过手动查出结果，然后给用户发奖
		//
	}

	public function getServerId(){
		return 1100;		
	}

	public function getEventName() {
		return "青春狂欢抽奖";
	}

	public function getRealReward( $account_id ){
		$exist_reward = GiftCenter::model()->findBySql(
			"SELECT * FROM `giftcenter` WHERE account_id=? 
			AND `type`=?
			AND `server_id`=?
			AND `desc`=?
			AND `phone` is null
			AND `address` is null",
			array($account_id,1,$this->getServerId(), $this->getEventName() ));
		return $exist_reward;
	}

	//public function getAccountAttr( $account_id, $id ){
	//	$exist_attr = Accattr::model()->findBySql(
	//		"SELECT * FROM accattr WHERE account_id=? AND attr=?",
	//		array($account_id, "LOTTERY_".strtotime($this->getEventTime()).'_'.$id ));
	//	if ($exist_attr) {
	//		return true;
	//	}
	//	return false;
	//}
	
	public function getAccountAttr( $account_id, $attr ){
		$exist_attr = Accattr::model()->findBySql(
			"SELECT * FROM accattr WHERE account_id=? AND attr=?",
			array($account_id, $attr));
		if ($exist_attr) {
			return true;
		}
		return false;
	}

	public function updateAccountAttr( $account_id, $id, $prefix ){
		$attr = new Accattr();
		$attr->account_id = $account_id;
		$attr->attr = "LOTTERY_".strtotime($this->getEventTime())."_".$id;
		$attr->value = $prefix;
		return $attr->save();
	}
	
	public function genCardId($prefix){
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

	public function getPrize(){
		return array(
			0 => array('id'=>1,'min'=>2, 'prefix'=>'ABMk','max'=>44,'prize'=>'四等奖：毕业狂欢礼包','v'=>50,'jx'=>4), 
			1 => array('id'=>2,'min'=>47,'prefix'=>'ABMQ','max'=>89,'prize'=>'三等奖：狭义石*2','v'=>10,'jx'=>3), 
			2 => array('id'=>3,'min'=>92,'prefix'=>'ABMR','max'=>134,'prize'=>'三等奖：龙纹手环*1','v'=>10,'jx'=>3), 
			3 => array('id'=>4,'min'=>137,'prefix'=>'ABMj','max'=>179,'prize'=>'三等奖：洗髓丹*10','v'=>10,'jx'=>3), 
			4 => array('id'=>5,'min'=>182,'prefix'=>'ABMi','max'=>224,'prize'=>'三等奖：内丹*1','v'=>10,'jx'=>3), 
			5 => array('id'=>6,'min'=>227,'prefix'=>'ABM8','max'=>269,'prize'=>'三等奖：优质牧草*5','v'=>10,'jx'=>3), 
			6 => array('id'=>7,'min'=>272,'max'=>314,'prize'=>'二等奖：小米Note','v'=>0,'jx'=>2),
			7 => array('id'=>8,'min'=>317,'max'=>359,'prize'=>'一等奖：Apple iwatch','v'=>0,'jx'=>1)
		); 
	}

	public function updateGiftCenter($account_id,$id){
		$prize_arr = $this->getPrize();
		$reward = new GiftCenter();
		$reward->account_id= $account_id;
		$reward->name = $prize_arr[$id]['prize'];
		if ( array_key_exists('prefix', $prize_arr[$id]) ) {
			$reward->card_id =
				$this->genCardId($prize_arr[$id]['prefix']);
			$reward->type = 0;
		}else{
			$reward->type = 1;
			$reward->card_id = "";
		}
		$reward->desc =	"青春狂欢抽奖";
		$reward->server_id = $this->getServerId();
		$reward->expire = "2015-7-5";
		return $reward->save();
	}

	public function returnLotteryResult($id) {
		$prize_arr = $this->getPrize();
		$min =  $prize_arr[$id]['min'];
		$max =  $prize_arr[$id]['max'];
		$prize = $prize_arr[$id]['prize'];
		$jx    = $prize_arr[$id]['id'];

		echo json_encode(array('res_code'=>0,	
			'angle'=> ($min+$max)/2,//mt_rand($min,$max),
			'prize'=>$prize,
			'jx' => $jx
		));
	}

	public function getCounter($prefix) {
		$counter = Counter::model()->findByPk($prefix);
		if (!$counter) {
			$counter = new Counter();
			$counter->name = $prefix;
			$counter->value = 0;
		}
		return $counter;
	}

	public function actionLottery(){
		if ( time()>strtotime('2015-6-29') ) {
			echo json_encode(array('res_code'=>4));	
		}
		//需要先登录
		if (Yii::app()->user->isGuest) {
			echo json_encode(array('res_code'=>1));
			return;
		}
		$account_id = Yii::app()->user->getId();
		if ($this->getRealReward($account_id) ) {
			echo json_encode(array('res_code'=>2));
			return;
		}

		$prefix = "LOTTERY_".strtotime($this->getEventTime())."_";

		if(!$this->getAccountAttr( $account_id, $prefix."1" )){
			$this->updateGiftCenter($account_id, 0);
			$this->updateAccountAttr($account_id, 1, 0);

			$this->returnLotteryResult(0);
			return;
		}

		$prefix_times = "LOTTERY_".strtotime($this->getEventTime())."_TIMES_";

		if($this->getAccountAttr($account_id, $prefix_times."2") &&
			(!$this->getAccountAttr( $account_id, $prefix."2" )) ){

			$this->updateGiftCenter($account_id, 1);
			$this->updateAccountAttr( $account_id, 2, 1 );

			$this->returnLotteryResult(1);
			return;
		}

		if($this->getAccountAttr($account_id, $prefix_times."3") && 
			(!$this->getAccountAttr( $account_id, $prefix."3" )) ){

			$counter = $this->getCounter("LOTTERY_".strtotime($this->getEventTime())."_1");
			//中小米note
			if ($counter->value < 2) {
				$randvalue = rand(0, 9999);
				if ($randvalue < 2) {
					$counter->value++;
					$counter->save();

					$this->updateGiftCenter($account_id, 6);
					$this->updateAccountAttr( $account_id, 3, 6 );

					$this->returnLotteryResult(6);
					return;
				}
			}
			$prizeArrray = array(2,3,4,5);
			$index = rand(0, count($prizeArrray)-1);

			$this->updateGiftCenter($account_id,$prizeArrray[$index]);
			$this->updateAccountAttr( $account_id, 3, $prizeArrray[$index] );

			$this->returnLotteryResult($prizeArrray[$index]);
			return;
		}
		echo json_encode(array('res_code'=>3));
		return;

	}

	public function actionAddress(){
		if (Yii::app()->user->isGuest) {
			echo json_encode(array('res_code'=>-1,
				'value'=>"no login"));
			return;
		}
		$account_id = Yii::app()->user->getId();

		$exist_reward = $this->getRealReward($account_id);
		if (!$exist_reward) {
			return;
		}

		if(isset($_POST['Address']))
		{
			$isphone = "/^1[3-9]{1}[0-9]{9}$/";
			if(!preg_match($isphone, $_POST['Address']['phone'])){
				echo json_encode(array('res_code'=>-1,
					'value'=>"phone error"));
				return;
			}

			if (!$_POST['Address']['address']) {
				echo json_encode(array('res_code'=>-1,
					'value'=>"address error"));
				return;
			}

			$exist_reward->address = $_POST['Address']['address'];
			$exist_reward->phone = $_POST['Address']['phone'];

			if ($exist_reward->save()) {
				echo json_encode(array('res_code'=>1, 'value'=>""));	
			}
			return;
		}
		$account = Account::model()->findBySql(
			"SELECT * FROM account where id=?",
			array($account_id));

		echo json_encode(array(
			'res_code'=>0,
			'account'=>$account->account,
			'email'=>$account->email
		));

	}

	public function actionRebate(){
		if (Yii::app()->user->isGuest) {
			echo json_encode(array('res_code'=>1));
			return;
		}
		$server_id = $_GET['server_id'];
		$account_id = Yii::app()->user->getId();
		$balance = Yii::app()->db->createCommand("SELECT SUM(point) `balance` FROM rebate WHERE account_id=$account_id AND (server_id<=$server_id OR point<0) ")->queryAll();
		$total = Yii::app()->db->createCommand("SELECT SUM(point) `total` FROM rebate WHERE account_id=$account_id AND point > 0 AND server_id<=$server_id")->queryAll();
		echo json_encode(array(
			'res_code'=>0,
			'balance'=>$balance[0]['balance'],
			'total'=>$total[0]['total']
		));
	}

	public function actionReturnGift(){
		if (Yii::app()->user->isGuest) {
			echo json_encode(array('res_code'=>1));
			return;
		}
		$account_id = Yii::app()->user->getId();
		$account = Account::model()->findBySql(
			"SELECT * FROM account where id=?",
			array($account_id));
		if (strtotime($account->time) >= strtotime("2016-5-1 00:00:00")) {
			echo json_encode(array('res_code'=>2));
			return;
		}
		echo json_encode(array('res_code'=>0));	
	}

	public function get_rand($arr) {
		$sum = array_sum($arr);
		$accum = 0;
		$rand_num=mt_rand(1,100)/100;
		foreach($arr as $key=>$val) {
			$accum += $val;
			if ($accum/$sum > $rand_num) {
				return $key;
			}
		}
	}

	public function getHongbaoAction() {
		return "hongbao".date("Ymd");
	}

	public function actionGetHongBao(){
		if ( time()>strtotime('2018-3-16 15:00:00') ) {
			echo json_encode(array('res_code'=>4));	
			return;
		}
		//需要先登录
		if (Yii::app()->user->isGuest) {
			echo json_encode(array('res_code'=>1));
			return;
		}
		$action = $this->getHongbaoAction();

		$account_id = Yii::app()->user->getId();
		$exist_reward = Accrw::model()->findBySql("
			SELECT * FROM `accrw` WHERE account_id=?
			AND `action`=? LIMIT 1
		", array($account_id, $action));
		if ($exist_reward) {
			echo json_encode(array('res_code'=>2,
				'reward_id'=>$exist_reward->reward_id,
				'char_id'=>$exist_reward->char_id));
			return;
		}
		$reward_array = array(51200=>0.96,51201=>0.3,51202=>0.01);
		$reward_id = $this->get_rand($reward_array);
		$exist_reward = new Accrw();
		$exist_reward->account_id = $account_id;
		$exist_reward->reward_id = $reward_id;
		$exist_reward->rw_type = 1;
		$exist_reward->server_id = 1;
		$exist_reward->char_id = 1;
		$exist_reward->action = $action;
		$exist_reward->expire = "2018-12-1";

		if ($exist_reward->save()) {
			echo json_encode(array('res_code'=>3,
				'reward_id'=>$reward_id,
				'char_id'=>1));
		} else {
			echo $reward_id;
			echo json_encode(array('res_code'=>5));	
		}
		
	}

	public function actionSetHongBao(){
		if ( time()>strtotime('2018-3-16 15:00:00') ) {
			echo json_encode(array('res_code'=>4));	
			return;
		}
		//需要先登录
		if (Yii::app()->user->isGuest) {
			echo json_encode(array('res_code'=>1));
			return;
		}
				
		$action = $this->getHongbaoAction();

		$account_id = Yii::app()->user->getId();
		$exist_reward = Accrw::model()->findBySql("
			SELECT * FROM `accrw` WHERE account_id=?
			AND `action`=? LIMIT 1
		", array($account_id,$action));
		if (!$exist_reward) {
			echo json_encode(array('res_code'=>3));
			return;
		}

		if ($exist_reward->server_id != 1 ||
			$exist_reward->char_id != 1 ) {
			echo json_encode(array('res_code'=>5,
				'reward_id'=>$exist_reward->reward_id,
				'char_id'=>$exist_reward->char_id,
				'server_id'=>$exist_reward->server_id));
			return;
		}
		
		//需要选择server
		if (!isset($_GET['server_id']) ||
			!is_numeric($_GET['server_id']) ||
			$_GET['server_id'] <= 0) {
			echo json_encode(array('res_code'=>2,
				'reward_id'=>$exist_reward->reward_id));
			return;
		}
		
		//需要选择charid
		if (!isset($_GET['char_id']) ||
			!is_numeric($_GET['char_id']) ||
			$_GET['char_id'] <= 0) {
			echo json_encode(array('res_code'=>2,
				'reward_id'=>$exist_reward->reward_id));
			return;
		}

		$char_id = $_GET['char_id'];
		$server_id = $_GET['server_id'];
		$account = Account::model()->findBySql(
				"SELECT account FROM account WHERE id=?",array(Yii::app()->user->id));

		$exist_char = Yii::app()->db->createCommand(
			"SELECT Id FROM User WHERE Account='$account->account'
		   AND Server=$server_id AND Id=$char_id LIMIT 1")->queryAll();
		if (!$exist_char) {
			return;
		}

		$exist_reward->char_id =  $char_id;
		$exist_reward->server_id = $server_id;
		if ($exist_reward->save()) {
			echo json_encode(array('res_code'=>6,
				'reward_id'=>$exist_reward->reward_id,
				'char_id'=>$exist_reward->char_id,
				'server_id'=>$exist_reward->server_id));
		}
		
	}

	
}

