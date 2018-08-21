<?php

class FetchPasswordMobileForm extends CFormModel
{
	public $account;
	public $verifyCode;

	public $user;

	public function rules()
	{
		return array(
			array('account', 'required'),
			array('verifyCode', 'required'),
			array('account', 'checkaccount'),
			array('verifyCode', 'checkverifycode'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'account'=>'账号',
			'verifyCode'=>'验证码',
		);
	}

	public function checkaccount($attribute,$params)
	{
		$this->user = Account::model()->find("account=?",
			array($this->account));
		if ($this->user === null) {
			$this->addError("account", "账号不存在");
			return;
		}
		if (!$this->user->verifiedmobile || $this->user->verifiedmobile=="") {
			$this->addError("account", "账号没有绑定安全手机，请联系客服人员解决此问题！");
			return;
		}
		/*
		$reset = Reset::model()->findBySql(
			"SELECT * FROM `reset` WHERE account_id=? ORDER BY `time` DESC LIMIT 1",
			array($this->user->id));
		if ($reset) {
			if ((time()-strtotime($reset->time)) < 600) {
				$this->addError("account", "您好，每次密码重置请求至少相隔10分钟。");
			} else {
				$reset->delete();
			}
			return;
		}
		 */
	}

	public function checkverifycode($attribute,$params)
	{
		if (!$this->user) {
			$this->user = Account::model()->find("account=?",
				array($this->account));
		}
		if (!$this->user || !$this->user->verifiedmobile) {
			return;	
		}

		Yii::import('application.vendors.*');
		require_once("sms.php");
		if (!Verify($this->user->verifiedmobile,$this->verifyCode)) {
			$this->addError('verifyCode', "验证码错误。");
		}

	}

	public function fetch($controller) {
		if (!$this->user) {
			$this->user = Account::model()->find("account=?",
				array($this->account));
		}
		$reset = new Reset();
		$reset->key = md5(uniqid('', true));
		$reset->account_id = $this->user->id;
		if (!$reset->save())
			return false;
		return $reset->key;
	}

}

