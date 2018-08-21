<?php

class KeyGenForm extends CFormModel
{
	public $comment;
	public $number;

	public function rules()
	{
		return array(
			array('comment, number', 'required'),
			array('number','numerical','max'=>'9999','min'=>'1'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'comment'=>'说明',
			'number'=>'个数',
		);
	}

	public function generate()
	{
		$sql = "INSERT INTO `key` (`key`, used, comment) VALUES(:key, :used, :comment)";
		$conn = Yii::app()->db;
		$stat = $conn->createCommand($sql);

		$lastmd5 = md5(uniqid('',true));

		$used = 0;
		$comment = $this->comment;
		$stat->bindParam(":used", $used, PDO::PARAM_INT);
		$stat->bindParam(":comment", $comment, PDO::PARAM_STR);

		$trx = $conn->beginTransaction();
		try {
			for ($i=0; $i<$this->number; $i=$i+1) {
				$key = md5(uniqid('',true).$lastmd5);
				$lastmd5 = $key;
				$stat->bindParam(":key", $key, PDO::PARAM_STR);
				$stat->execute();
			}
			$trx->commit();
		} catch (Exception $e) {
			$trx->rollback();
		}

		return true;
	}
}


