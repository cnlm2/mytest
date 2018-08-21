<?php

/**
 * This is the model class for table "rebate".
 *
 * The followings are the available columns in table 'rebate':
 * @property integer $id
 * @property string $time
 * @property integer $account_id
 * @property integer $point
 * @property integer $balance
 * @property string $action
 * @property string $txn_id
 * @property integer $game_type
 * @property integer $server_id
 * @property integer $char_id
 * @property integer $grade
 */
class Rebate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rebate the static model class
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
		return 'rebate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('time, account_id, point, balance, action', 'required'),
			array('account_id, point, balance, game_type, server_id, char_id, grade', 'numerical', 'integerOnly'=>true),
			array('action, txn_id', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, time, account_id, point, balance, action, txn_id, game_type, server_id, char_id, grade', 'safe', 'on'=>'search'),
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
			'account_id' => 'Account',
			'point' => 'Point',
			'balance' => 'Balance',
			'action' => 'Action',
			'txn_id' => 'Txn',
			'game_type' => 'Game Type',
			'server_id' => 'Server',
			'char_id' => 'Char',
			'grade' => 'Grade',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('point',$this->point);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('txn_id',$this->txn_id,true);
		$criteria->compare('game_type',$this->game_type);
		$criteria->compare('server_id',$this->server_id);
		$criteria->compare('char_id',$this->char_id);
		$criteria->compare('grade',$this->grade);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}