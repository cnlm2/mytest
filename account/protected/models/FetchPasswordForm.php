<?php

class FetchPasswordForm extends CFormModel
{
	public $account;

	public $user;

	public function rules()
	{
		return array(
			array('account', 'required'),
			array('account', 'checkaccount'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'account'=>'账号',
		);
	}

	public function checkaccount($attribute,$params)
	{
		if (!$this->hasErrors()) {
			$this->user = Account::model()->find("account=?",
				array($this->account));
			if ($this->user === null) {
				$this->addError("account", "账号不存在");
				return;
			}
			if ($this->user->email === null) {
				$this->addError("account", "账号没有邮箱信息，请联系客服人员解决此问题！");
				return;
			}
			if ($this->user->verified == 0) {
				$this->addError("account", "账号安全邮箱没有通过验证，不能使用密码找回功能！");
				return;
			}
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
		}
	}

	public function fetch($controller)
	{
		if (!$this->user) {
			$this->user = Account::model()->find("account=?",
				array($this->account));
		}
		$reset = new Reset();
		$reset->key = md5(uniqid('', true));
		$reset->account_id = $this->user->id;
		if (!$reset->save())
			return false;

		$message = $controller->renderPartial("mail", array(
			"name"=>$this->user->getCallName(),
			"account"=>$this->user->account,
			"token"=>$reset->key,
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
		$mailer->SetFrom("webmaster@dxqzol.com", "拍拍投用户中心");
		$mailer->AddAddress($this->user->email);
		$mailer->Subject = "拍拍投密码重置";
		$mailer->MsgHTML($message);

		return $mailer->send() ? true : false;
	}
}

