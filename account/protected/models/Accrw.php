<?php

/**
 * This is the model class for table "accrw".
 *
 * The followings are the available columns in table 'accrw':
 * @property string $id
 * @property string $account_id
 * @property string $char_id
 * @property string $reward_id
 * @property string $rw_type
 * @property string $server_id
 * @property string $action
 * @property string $expire
 * @property string $time
 */
class Accrw extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Accrw the static model class
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
		return 'accrw';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, reward_id, rw_type, action', 'required'),
			array('account_id, reward_id', 'length', 'max'=>11),
			array('rw_type', 'length', 'max'=>10),
			array('action', 'length', 'max'=>64),
			array('expire, time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, account_id, char_id, reward_id, rw_type, server_id, action, expire, time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'account_id' => 'Account',
			'char_id' => 'Char',
			'reward_id' => 'Reward',
			'rw_type' => 'Rw Type',
			'server_id' => 'Server',
			'action' => 'Action',
			'expire' => 'Expire',
			'time' => 'Time',
		);
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('account_id',$this->account_id,true);
		$criteria->compare('char_id',$this->char_id,true);
		$criteria->compare('reward_id',$this->reward_id,true);
		$criteria->compare('rw_type',$this->rw_type,true);
		$criteria->compare('server_id',$this->server_id,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('expire',$this->expire,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
