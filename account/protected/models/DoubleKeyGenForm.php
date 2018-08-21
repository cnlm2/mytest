<?php

class DoubleKeyGenForm extends CFormModel
{
	public $comment;
	public $type;
	public $tags;
	public $number;

	public function rules()
	{
		return array(
			array('comment, type, number', 'required'),
			array('tags', 'length', 'max'=>'50'),
			array('number','numerical','max'=>'9999','min'=>'1'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'comment'=>'激活码Tag',
			'type'=>'卡密类型',
			'tags'=>'卡密标签',
			'number'=>'个数',
		);
	}

	public function generate()
	{
		$sql1 = "INSERT INTO `card` VALUES(:id, :type, :tags, NULL, 0, NULL, NULL, NULL, NULL, NULL)";
		$sql2 = "INSERT INTO `key` (`key`, used, comment) VALUES(:key, 0, :comment)";
		$conn = Yii::app()->db;
		$stat1 = $conn->createCommand($sql1);
		$stat2 = $conn->createCommand($sql2);

		$lastmd5 = md5(uniqid('',true));

		$type = $this->type;
		$tags = $this->tags;
		$comment = $this->comment;

		$stat1->bindParam(":type", $type, PDO::PARAM_STR);
		$stat1->bindParam(":tags", $tags, PDO::PARAM_STR);
		$stat2->bindParam(":comment", $comment, PDO::PARAM_STR);

		$txn = $conn->beginTransaction();
		try {
			for ($i=0; $i<$this->number; $i=$i+1) {
				$key = md5(uniqid('',true).$lastmd5);
				$lastmd5 = $key;
				$stat1->bindParam(":id", $key, PDO::PARAM_STR);
				$stat1->execute();
				$stat2->bindParam(":key", $key, PDO::PARAM_STR);
				$stat2->execute();
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


