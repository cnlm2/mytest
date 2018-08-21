<?php

/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property integer $Id
 * @property integer $Server
 * @property string $Name
 * @property string $Account
 * @property string $PubIp
 * @property string $PriIp
 * @property string $IdCard
 * @property integer $Birthday
 * @property integer $Grade
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'User';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Id, Server, Name, Account, PubIp, PriIp', 'required'),
			array('Id, Server, Birthday, Grade', 'numerical', 'integerOnly'=>true),
			array('Name, Account', 'length', 'max'=>32),
			array('PubIp, PriIp', 'length', 'max'=>64),
			array('IdCard', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Id, Server, Name, Account, PubIp, PriIp, IdCard, Birthday, Grade', 'safe', 'on'=>'search'),
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
			'Id' => 'ID',
			'Server' => 'Server',
			'Name' => 'Name',
			'Account' => 'Account',
			'PubIp' => 'Pub Ip',
			'PriIp' => 'Pri Ip',
			'IdCard' => 'Id Card',
			'Birthday' => 'Birthday',
			'Grade' => 'Grade',
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Server',$this->Server);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Account',$this->Account,true);
		$criteria->compare('PubIp',$this->PubIp,true);
		$criteria->compare('PriIp',$this->PriIp,true);
		$criteria->compare('IdCard',$this->IdCard,true);
		$criteria->compare('Birthday',$this->Birthday);
		$criteria->compare('Grade',$this->Grade);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}