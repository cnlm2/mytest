<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id = 0;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$username = strtolower($this->username);
		if ($username === "admin") {
			$users=array(
				'admin'=>md5('jingyong'),
			);
			if($users[$username]!==$this->password)
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			else {
				$this->_id = 0;
				$this->errorCode=self::ERROR_NONE;
			}
		} else {
			$user = Account::model()->find('account=?',array($username));
			if ($user===null) {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			} else if (!$user->validatePassword($this->password)) {
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			} else {
				$this->_id = $user->id;
				$this->username = $user->account;
				$this->errorCode=self::ERROR_NONE;
			}
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function setId($id)
	{
		$this->_id = $id;
	}
}
