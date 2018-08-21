<?php

/**
 * This is the model class for table "charge".
 *
 * The followings are the available columns in table 'charge':
 * @property string $no
 * @property integer $account_id
 * @property string $account_name
 * @property integer $fee
 * @property integer $status
 * @property integer $hide
 * @property string $charge_type
 * @property string $time
 */
class Charge extends CActiveRecord
{
	const CREATED	= 0;
	const PAYED		= 1;
	const CANCELED	= 2;
	const FINISHED	= 3;
	const DELETED	= 4;	
	const CONSUMED  = 5;

	public $account_name;
	public $account_confirm;
	public $bank;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Charge the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'charge';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fee,account_name,charge_type,game_type,char_id,server_id', 'required'),
			array('fee', 'numerical', 'min'=>1, 'max'=>100000, 'integerOnly'=>false),
			array('account_name', 'length', 'max'=>50),
			array('bank', 'length', 'max'=>3, 'min'=>3),
			array('account_name', 'existAccount'),
			array('char_id', 'existChar', 'on'=>array('create')),
			//array('account_confirm', 'compare', 'compareAttribute'=>'account_name'),
			//
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('no, account_id, fee, status, hide, time', 'safe', 'on'=>'search'),
		);
	}

	public function existAccount($attribute, $params)
	{
		if(!$this->hasErrors())
		{
			$account = Account::model()->find('account=?',array($this->account_name));
			if($account===null) {
				$this->addError('account_name', '不存在的账号');
			}
		}
	}

	public function existChar($attribute, $params)
	{
		if(!$this->hasErrors())
		{
			$account = User::model()->find('id=?',array($this->char_id));
			if($account===null) {
				$this->addError('char_id', '不存在的角色');
			}
		}

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'no' => '订单号',
			'account_id' => '充值账户ID',
			'account_name' => '充值账户',
			'char_id'=>"充值角色",
			'account_confirm' => '账户确认',
			'fee' => '充值金额',
			'amount' => '游戏点数',
			'status' => '订单状态',
			'hide' => '隐藏',
			'charge_type' => '充值类型',
			'time' => '创建日期',
			'server_id'=>'服务器',
		);
	}

	public function scopes()
	{
		return array(
			'recently'=>array(
				'order'=>'time DESC',
			),
		);
	}

	public function byAccountId($account_id)
	{
		$criteria = $this->getDbCriteria();
		$criteria->mergeWith(array(
			'condition'=>'account_id=:account_id',
		));
		$criteria->params=array(':account_id'=>$account_id);
		return $this;
	}

	public function byCreatorId($creator_id)
	{
		$criteria = $this->getDbCriteria();
		$criteria->mergeWith(array(
			'condition'=>'creator_id=:creator_id',
		));
		$criteria->params=array(':creator_id'=>$creator_id);
		return $this;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('no',$this->no,true);
		$criteria->compare('account_id',$this->account_id,true);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('status',$this->status);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getStatusName()
	{
		switch($this->status) {
		case self::CREATED:
			return "未支付";
		case self::PAYED:
			return "已支付";
		case self::FINISHED:
			return "已完成";
		case self::DELETED:
			return "已删除";
		case self::CONSUMED:
			return "已完成";

		}
	}

	public function getChargeTypeName()
	{
		if ($this->charge_type == 'yd') {
			return '移动充值卡';
		} elseif ($this->charge_type == 'lt') {
			return '联通充值卡';
		} elseif ($this->charge_type == 'dx') {
			return '电信充值卡';
		} elseif (strpos($this->charge_type, "hfbbank") === 0) {
			return '银行卡';
		} elseif (strpos($this->charge_type, "wx") === 0) {
			return '微信';
		} elseif (strpos($this->charge_type, "fzw") === 0) {
			return '方中网';
		} else {
			return '支付宝';
		}
	}
}
