<?php

/**
 * This is the model class for table "activation".
 *
 * The followings are the available columns in table 'activation':
 * @property integer $account_id
 * @property integer $product_id
 * @property string $key
 */
class Activation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Activation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function isActivated($id)
	{
		$activation = Activation::model()->find("account_id=:account_id AND product_id=3",
			array(":account_id"=>$id));
		if ($activation) {
			return true;
		}
		return false;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'activation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, product_id, key', 'required'),
			array('account_id, product_id', 'numerical', 'integerOnly'=>true),
			array('key', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('account_id, product_id, key', 'safe', 'on'=>'search'),
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
			'account_id' => 'Account',
			'product_id' => 'Product',
			'key' => 'Key',
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

		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('key',$this->key,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
