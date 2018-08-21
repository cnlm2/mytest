<?php

/**
 * This is the model class for table "player".
 *
 * The followings are the available columns in table 'player':
 * @property integer $charid
 * @property string $account
 * @property string $yy
 * @property string $time
 * @property integer $server
 * @property string $name
 * @property string $idcard
 * @property string $birthday
 * @property integer $grade
 * @property integer $exp
 * @property integer $totalexp
 * @property integer $school
 * @property integer $totalgametime
 * @property integer $jinqian
 * @property integer $yinpiao
 * @property integer $yuanbao
 * @property integer $tongbao
 * @property integer $cunkuan
 * @property integer $worldcontr
 * @property integer $schoolcontr
 * @property integer $orgcontr
 * @property integer $sceneid
 * @property string $scenename
 * @property integer $x
 * @property integer $y
 * @property integer $lastmissionid
 * @property integer $lastmissionstep
 * @property string $lastmissiontime
 * @property string $AccountFrom
 * @property integer $consume
 * @property integer $vip
 */
class Player extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Player the static model class
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
		return 'player';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('charid, time', 'required'),
			array('charid, server, grade, exp, totalexp, school, totalgametime, jinqian, yinpiao, yuanbao, tongbao, cunkuan, worldcontr, schoolcontr, orgcontr, sceneid, x, y, lastmissionid, lastmissionstep, consume, vip', 'numerical', 'integerOnly'=>true),
			array('account, yy, name, idcard, scenename, AccountFrom', 'length', 'max'=>255),
			array('birthday, lastmissiontime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('charid, account, yy, time, server, name, idcard, birthday, grade, exp, totalexp, school, totalgametime, jinqian, yinpiao, yuanbao, tongbao, cunkuan, worldcontr, schoolcontr, orgcontr, sceneid, scenename, x, y, lastmissionid, lastmissionstep, lastmissiontime, AccountFrom, consume, vip', 'safe', 'on'=>'search'),
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
			'charid' => 'Charid',
			'account' => 'Account',
			'yy' => 'Yy',
			'time' => 'Time',
			'server' => 'Server',
			'name' => 'Name',
			'idcard' => 'Idcard',
			'birthday' => 'Birthday',
			'grade' => 'Grade',
			'exp' => 'Exp',
			'totalexp' => 'Totalexp',
			'school' => 'School',
			'totalgametime' => 'Totalgametime',
			'jinqian' => 'Jinqian',
			'yinpiao' => 'Yinpiao',
			'yuanbao' => 'Yuanbao',
			'tongbao' => 'Tongbao',
			'cunkuan' => 'Cunkuan',
			'worldcontr' => 'Worldcontr',
			'schoolcontr' => 'Schoolcontr',
			'orgcontr' => 'Orgcontr',
			'sceneid' => 'Sceneid',
			'scenename' => 'Scenename',
			'x' => 'X',
			'y' => 'Y',
			'lastmissionid' => 'Lastmissionid',
			'lastmissionstep' => 'Lastmissionstep',
			'lastmissiontime' => 'Lastmissiontime',
			'AccountFrom' => 'Account From',
			'consume' => 'Consume',
			'vip' => 'Vip',
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

		$criteria->compare('charid',$this->charid);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('yy',$this->yy,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('server',$this->server);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('idcard',$this->idcard,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('exp',$this->exp);
		$criteria->compare('totalexp',$this->totalexp);
		$criteria->compare('school',$this->school);
		$criteria->compare('totalgametime',$this->totalgametime);
		$criteria->compare('jinqian',$this->jinqian);
		$criteria->compare('yinpiao',$this->yinpiao);
		$criteria->compare('yuanbao',$this->yuanbao);
		$criteria->compare('tongbao',$this->tongbao);
		$criteria->compare('cunkuan',$this->cunkuan);
		$criteria->compare('worldcontr',$this->worldcontr);
		$criteria->compare('schoolcontr',$this->schoolcontr);
		$criteria->compare('orgcontr',$this->orgcontr);
		$criteria->compare('sceneid',$this->sceneid);
		$criteria->compare('scenename',$this->scenename,true);
		$criteria->compare('x',$this->x);
		$criteria->compare('y',$this->y);
		$criteria->compare('lastmissionid',$this->lastmissionid);
		$criteria->compare('lastmissionstep',$this->lastmissionstep);
		$criteria->compare('lastmissiontime',$this->lastmissiontime,true);
		$criteria->compare('AccountFrom',$this->AccountFrom,true);
		$criteria->compare('consume',$this->consume);
		$criteria->compare('vip',$this->vip);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}