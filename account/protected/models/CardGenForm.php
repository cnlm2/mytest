<?php

class CardGenForm extends CFormModel
{
	public $type;
	public $tags;
	public $number;

	public function rules()
	{
		return array(
			array('type, number', 'required'),
			array('tags', 'length', 'max'=>'50'),
			array('number','numerical','max'=>'9999','min'=>'1'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'type'=>'类型',
			'tags'=>'标签',
			'number'=>'个数',
		);
	}

	public function generate()
	{
		$sql = "INSERT INTO `card` VALUES(:id, :type, :tags, NULL, 0, NULL, NULL, NULL, NULL, NULL)";
		$conn = Yii::app()->db;
		$stat = $conn->createCommand($sql);

		$lastmd5 = md5(uniqid('',true));

		$type = $this->type;
		$tags = $this->tags;

		$stat->bindParam(":type", $type, PDO::PARAM_STR);
		$stat->bindParam(":tags", $tags, PDO::PARAM_STR);

		$txn = $conn->beginTransaction();
		try {
			for ($i=0; $i<$this->number; $i=$i+1) {
				$key = md5(uniqid('',true).$lastmd5);
				$lastmd5 = $key;
				$stat->bindParam(":id", $key, PDO::PARAM_STR);
				$stat->execute();
			}
			$txn->commit();
		} catch (Exception $e) {
			$this->addError("type", $e->getMessage());
			$txn->rollback();
			return false;
		}

		return true;
	}
}


