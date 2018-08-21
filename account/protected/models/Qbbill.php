<?php

/**
 * This is the model class for table "qbbill".
 *
 * The followings are the available columns in table 'qbbill':
 * @property string $id
 * @property string $time
 * @property string $card_id
 * @property string $password
 * @property string $account_id
 * @property string $action
 * @property string $txn_id
 * @property string $point
 * @property string $server_id
 * @property string $char_id
 */
class Qbbill extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Qbbill the static model class
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
		return 'qbbill';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('time, card_id, password, account_id, action, txn_id, point, server_id, char_id', 'required'),
			array('card_id, txn_id', 'length', 'max'=>64),
			array('password', 'length', 'max'=>50),
			array('account_id, point, server_id, char_id', 'length', 'max'=>11),
			array('action', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, time, card_id, password, account_id, action, txn_id, point, server_id, char_id', 'safe', 'on'=>'search'),
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
			'time' => 'Time',
			'card_id' => 'Card',
			'password' => 'Password',
			'account_id' => 'Account',
			'action' => 'Action',
			'txn_id' => 'Txn',
			'point' => 'Point',
			'server_id' => 'Server',
			'char_id' => 'Char',
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
		$criteria->compare('time',$this->time,true);
		$criteria->compare('card_id',$this->card_id,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('account_id',$this->account_id,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('txn_id',$this->txn_id,true);
		$criteria->compare('point',$this->point,true);
		$criteria->compare('server_id',$this->server_id,true);
		$criteria->compare('char_id',$this->char_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}