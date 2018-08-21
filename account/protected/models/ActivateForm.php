<?php

class ActivateForm extends CFormModel
{
	public $key;

	public function rules()
	{
		return array(
			array('key', 'required'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'key'=>'激活码',
		);
	}

	public function activate()
	{
		$account_id = Yii::app()->user->getId();
		//$old_activation = Activation::model()->find("account_id=:account_id AND product_id=3",
		$old_activation = Activation::model()->find("account_id=:account_id",
			array(":account_id"=>$account_id));
		if ($old_activation) {
			$this->addError('key', "你已经激活过游戏了");
			return false;
		}

		if (strlen($this->key) < 20) {
			$this->addError('key', "无效的激活码");
			return false;
		}
		require_once('CardGenerator.php');
		$keyinfo = VerifyCard($this->key);
		if (!$keyinfo || $keyinfo['type'] != "gshx_activation") {
			$this->addError('key', "无效的激活码");
			return false;
		}
		$old_activation = Activation::model()->find("`key`=:key",
			array(":key"=>$this->key));
		if ($old_activation) {
			$this->addError('key', "激活码已经使用过了");
			return false;
		}
		#$card = Card::model()->find("`id`=:key",
		#	array(":key"=>$this->key));
		#if ($card && $card->transcation_id) {
		#	$this->addError('key', "激活码已被使用了");
		#	return false;
		#}

		//盖世豪侠 product => 3
		$new_activation = new Activation();
		$new_activation->account_id = $account_id;
		$new_activation->product_id = 3;
		$new_activation->key = $this->key;
		$new_activation->save();

		return true;
	}
}


