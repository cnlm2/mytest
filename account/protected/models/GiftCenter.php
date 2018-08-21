<?php

/**
 * This is the model class for table "giftcenter".
 *
 * The followings are the available columns in table 'giftcenter':
 * @property string $id
 * @property string $account_id
 * @property string $char_id
 * @property string $card_id
 * @property string $password
 * @property string $name
 * @property string $type
 * @property string $server_id
 * @property string $desc
 * @property string $expire
 * @property string $time
 * @property string $phone
 * @property string $address
 */
class GiftCenter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GiftCenter the static model class
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
		return 'giftcenter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, name, server_id, desc', 'required'),
			array('account_id, char_id', 'length', 'max'=>11),
			array('card_id, password, desc', 'length', 'max'=>64),
			array('name', 'length', 'max'=>16),
			array('type, server_id', 'length', 'max'=>10),
			array('phone', 'length', 'max'=>15),
			array('address', 'length', 'max'=>256),
			array('expire, time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, account_id, char_id, card_id, password, name, type, server_id, desc, expire, time, phone, address', 'safe', 'on'=>'search'),
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
			'card_id' => 'Card',
			'password' => 'Password',
			'name' => 'Name',
			'type' => 'Type',
			'server_id' => 'Server',
			'desc' => 'Desc',
			'expire' => 'Expire',
			'time' => 'Time',
			'phone' => 'Phone',
			'address' => 'Address',
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
		$criteria->compare('card_id',$this->card_id,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('server_id',$this->server_id,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('expire',$this->expire,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}