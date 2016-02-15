<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;
	
	/**
	 * @var mixed User model object
	 */
	private $_user = false;

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember Me'),
		];
	}

    /**
     * Validates the password.
     */
    public function validatePassword($attribute, $params)
    {
        if ($this->hasErrors()) {
			return;
		}
		
		$user = $this->getUser();

		if (!$user || !$user->validatePassword($this->password)) {
			$this->addError($attribute, Yii::t('app', 'Incorrect email or password.'));
		}
    }

    /**
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}
