<?php

/**
 * This is the model class for table "account".
 *
 * The followings are the available columns in table 'account':
 * @property integer $id
 * @property string $account
 * @property string $password
 //* @property string $idcard
 //* @property string $email
 //* @property integer $verified
 //* @property string $name
 * @property string $time
 */
class Account extends CActiveRecord
{
	public $confirm;
	public $oldpassword;
	public $originpassword;
	public $isagree;
	//public $nickname;
	public $verifyCode;
	public $name;

	private $_oldAttributes;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Account the static model class
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
		return 'account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account', 'required', 'on'=>array('create','quickreg')),
			array('isagree', 'required', 'on'=>array('create','quickreg')),
			//array('email', 'required', 'on'=>array('create','update')),
			//array('email', 'required', 'on'=>array('update')),
			//array('email', 'required', 'on'=>array('bindmail')),
			//array('verifiedmobile', 'required', 'on'=>array('bindmobile','bindmobilemail')),
			//array('verifyCode', 'required', 'on'=>array('bindmobile')),
			array('password, confirm, originpassword', 'required', 'on'=>array('password','create','reset','quickreg')),
			array('originpassword', 'length', 'min'=>6, 'max'=>12, 'on'=>array('password','create','reset','quickreg')),
			array('oldpassword', 'required', 'on'=>array('password')),
			array('oldpassword', 'authenticate', 'on'=>array('password')),
			//array('account, password, email, name', 'length', 'max'=>50, 'on'=>'create'),
			array('account, password', 'length', 'max'=>50, 'on'=>array('create','quickreg')),
			array('account, password', 'length', 'max'=>50, 'on'=>array('create','quickreg')),
			//array('name', 'length', 'max'=>50, 'on'=>'update'),
			array('confirm', 'compare', 'compareAttribute'=>'password', 'on'=>array('create','quickreg','password','reset')),
			array('account', 'unique', 'className'=>'Account', 'on'=>array('create','quickreg')),
			//array('idcard', 'ext.validators.idCard', 'on'=>array('create','quickreg','update','antiaddiction')),
			//array('idcard, name', 'required', 'on'=>array('antiaddiction')),
			//array('account', 'checkname', 'on'=>array('create','quickreg')),
			array('account', 'match', 'pattern'=>'/^[a-zA-Z]([a-zA-Z0-9])+$/', 'on'=>array('create','quickreg')),
			//array('email', 'checkemail', 'on'=>array('create')),
			//array('email', 'updatecheckemail', 'on'=>array('update')),
			//array('email', 'updatecheckemail', 'on'=>array('bindmail')),
			//array('mobile', 'checkmobile', 'on'=>array('create','quickreg','update')),
			//array('mobile', 'length', 'max'=>15, 'on'=>array('create','quickreg','update')),
			array('isagree', 'checkagree', 'on'=>array('create','quickreg')),

			//array('nickname,originpassword', 'required', 'on'=>'openbbs'),
			//array('nickname', 'length', 'min'=>2, 'max'=>50, 'on'=>'openbbs'),
			//array('nickname', 'checknick', 'on'=>'openbbs'),
			//array('account', 'checkbbs', 'on'=>'openbbs'),
			array('originpassword', 'authenticate2', 'on'=>'openbbs'),
			//array('yy', 'checkyy', 'on'=>'bindyy'),
			//array('from', 'checkfrom', 'on'=>array('create')),
			//array('verifiedmobile', 'checkverifiedmobile', 'on'=>array('bindmobile','bindmobilemail')),
			array('verifyCode', 'checkverifycode', 'on'=>'bindmobile'),
			array('verifyCode', 'checkverifycode', 'on'=>'cleartoken'),



			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, account, password, idcard, email, verified, mobile, name, time', 'safe', 'on'=>'search'),
			array('verifyCode', 'captcha', 'on'=>'create',
				'allowEmpty'=>!CCaptcha::checkRequirements(),
			),

		);
	}

	public function checkverifycode($attribute,$params){
		$mobile = $this->verifiedmobile;
		$code = $this->verifyCode;

		Yii::import('application.vendors.*');
		require_once("sms.php");
		if (!Verify($mobile,$code)) {
			$this->addError('verifyCode', "验证码错误。");
		}
	}

	public function checkverifiedmobile($attribute,$params){
		$mobile = $this->verifiedmobile;
		if ($mobile == "") return;
		//if (!preg_match("/^[0-9]+$/", $mobile)) {
		if (!preg_match("/^1[3-9]{1}[0-9]{9}$/", $mobile)) {
			$this->addError('verifiedmobile', "手机号码不合法。");
		}
		$count = Account::model()->count('`verifiedmobile`=?',array($mobile));
		if ($count >= 10) {
			$this->addError('verifiedmobile', "1个手机号码最多只能绑定10个账号。");
		}
	}

	public function checkfrom($attribute,$params)
	{

		if(isset($_GET['activationcode'])){
			if (!$this->from || $this->from == "") {
				$this->addError('from',"注册码不可为空白。");
				return;
			}
			$account = Account::model()->find('`from`=?',array($this->from));
			if ($account) {
				$this->addError('from', "此注册码已经被使用。");
				return;
			}
			require_once('CardGenerator.php');
			$keyinfo = VerifyCard($this->from);
			if (!$keyinfo || $keyinfo['type'] != "duowan_activation") {
				$this->addError('from', "无效的注册码。");
				return;
			}
		}
	}
	
	public function checkyy($attribute,$params)
	{
		$account = Account::model()->find('yy=?',array($this->yy));
		if ($account) {
			$this->addError('yy', "yy号已经被绑定，一个yy号只能绑定一个账号。");
		}
	}

	public function checkbbs($attribute,$params)
	{
		Yii::import('application.vendors.*');
		require_once('ucenter.php');
		$uc_user = uc_get_user($this->account);
		if ($uc_user) {
			$this->addError('nickname', '论坛账号已经开通，请使用游戏账号登录论坛。');
		}
	}

	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$identity=new UserIdentity(Yii::app()->user->name,
				md5($this->oldpassword));
			if(!$identity->authenticate())
				$this->addError('oldpassword','旧密码验证错误！');
		}
	}

	public function authenticate2($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$identity=new UserIdentity(Yii::app()->user->name,
				md5($this->originpassword));
			if(!$identity->authenticate())
				$this->addError('originpassword','密码验证错误！');
		}
	}

	public function checkmobile($attribute,$params)
	{
		$mobile = $this->mobile;
		if ($mobile == "") return;
		if (!preg_match("/^[0-9]+$/", $mobile)) {
			$this->addError('mobile', "手机号码不合法");
		}
	}

	public function checkagree($attribute,$params)
	{
		if ($this->isagree == 0) {
			$this->addError('isagree', "请接受服务协议");
		}
	}

	public function checknick($attribute,$params)
	{
        Yii::import('application.vendors.*');
        include_once 'ucenter.php';
        $flag = uc_user_checknick($this->nickname);
        switch($flag)
        {
            case -3:
                $this->addError('account','昵称已经存在');
                break;
        }
	}

	public function checkname($attribute,$params)
    {
        //ucenter
        Yii::import('application.vendors.*');
        include_once 'ucenter.php';
        $flag = uc_user_checkname($this->account);
        switch($flag)
        {
            case -1:
                $this->addError('account', '用户名不合法');
                break;
            case -2:
                $this->addError('account','包含不允许注册的词语');
                break;
            case -3:
                $this->addError('account','用户名已经存在');
                break;
        }
    }

    public function checkemail($attribute,$params)
    {
        //ucenter
        Yii::import('application.vendors.*');
        include_once 'ucenter.php';
        $flag = uc_user_checkemail($this->email);
        switch($flag)
        {
            case -4:
                $this->addError('email', 'Email 格式有误');
                break;
            case -5:
                $this->addError('email','Email 不允许注册');
                break;
            case -6:
                //$this->addError('email','该 Email 已经被注册');
                break;
        }
		//$account = Account::model()->find('`email`=? AND verified=1',array($this->email));
		//if ($account) {
		//	$this->addError('email','该 Email 已经被注册并验证');
		//}
    }

	public function getOldEmail()
	{
		$old = Null;
		if ($this->_oldAttributes) {
			$old = $this->_oldAttributes['email'];
		}
		return $old;
	}

	public function getOldIdCard()
	{
		$old = Null;
		if ($this->_oldAttributes) {
			$old = $this->_oldAttributes['idcard'];
		}
		return $old;
	}

	public function getOldName()
	{
		$old = Null;
		if ($this->_oldAttributes) {
			$old = $this->_oldAttributes['name'];
		}
		return $old;
	}

	public function getOldMobile()
	{
		$old = Null;
		if ($this->_oldAttributes) {
			$old = $this->_oldAttributes['mobile'];
		}
		return $old;
	}
	public function getOldVerifiedMobile()
	{
		$old = Null;
		if ($this->_oldAttributes) {
			$old = $this->_oldAttributes['mobile'];
		}
		return $old;
	}

	public function updatecheckemail($attribute,$params)
	{
		$oldemail = $this->getOldEmail();

		// 和原来一样的email就不用check了
		if ($this->email == $oldemail)
			return;

		// 如果原来已经注册了email, 在这里不允许修改
		if ($oldemail != Null && $oldemail != "" && $this->verified == 1) {
			$this->addError('email',"已经验证的 Email 请通过 GM 进行修改");
			return;
		}

		$account = Account::model()->find('`email`=? AND verified=1',array($this->email));
		if ($account) {
			$this->addError('email','该 Email 已经被注册并验证');
			return;
		}

		$this->checkemail($attribute,$params);
	}

	public static function isAntiaddiction($id){
		$model = Account::model()->find("id=:id AND idcard != ''",
			array(":id"=>$id));
		if ($model) {
			return true;
		}
		return false;
	}

	public static function isBindYY($id) {
		$model = Account::model()->find("id=:id AND yy is not null",
			array(":id"=>$id));
		if ($model) {
			return true;
		}
		return false;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'charges'=>array(self::HAS_MANY, 'Charge', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '编号',
			'account' => '账号',
			'password' => '密码',
			'confirm' => '确认密码',
			//'idcard' => '身份证号',
			//'email' => '电子邮件',
			//'mobile' => '手机号码',
			//'name' => '真实姓名',
			//'nickname' => '论坛昵称',
			'balance' => '账户余额',
			'time' => '注册时间',
			'oldpassword' => '旧密码',
			'originpassword' => '玩家密码',
			'verifyCode'=>'验证码',
			//'from'=>'注册码 *',
			//'verifiedmobile'=>'手机号码',
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
		$criteria->compare('account',$this->account,true);
		$criteria->compare('password',$this->password,true);
		//$criteria->compare('idcard',$this->idcard,true);
		//$criteria->compare('email',$this->email,true);
		//$criteria->compare('name',$this->name,true);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getCallName()
	{
		$strTemp = $this->name?$this->name:"";
		$strTemp = trim($strTemp);

		if ($strTemp === "")
			return $this->account;
		else
			return $this->name;
	}

	/**
	 * confirm virtual attribute
	 */
	public function getConfirm()
	{
		return $this->confirm;
	}

	public function setConfirm($value)
	{
		$this->confirm=$value;
	}

	static public function crypt($password, $salt)
	{
		$parts = explode("$", $salt);
		$salt = $parts[0];
		return $salt."$".md5($salt.$password);
	}

	public function generateSalt()
	{
		return uniqid();
	}

	public function validatePassword($password)
	{
		return self::crypt($password, $this->password)===$this->password;
	}

	#public function hashPassword($password)
	#{
	#	return self::crypt($password, $this->generateSalt());
	#}
	
	public function afterFind()
	{
		$this->_oldAttributes = $this->attributes;
	}
}

