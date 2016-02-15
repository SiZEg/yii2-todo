<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegistrationForm is the model behind the registration form.
 */
class RegistrationForm extends Model
{

	public $email;
	public $password;
	public $password_conf;
	public $phone;
	public $name;
	public $avatar;
	
	/**
	 * @var string User model class
	 */
	public $userModelClass = 'app\models\User';

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['email', 'password', 'password_conf'], 'required'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => $this->userModelClass, 'targetAttribute' => 'email', 'message' => Yii::t('app', 'Email already exists.')],
			['password_conf', 'compare', 'compareAttribute' => 'password'],
			['phone', 'match', 'pattern' => '#^[0-9]{11}$#'],
			['phone', 'unique', 'targetClass' => $this->userModelClass, 'targetAttribute' => 'phone', 'message' => Yii::t('app', 'Phone already exists.')],
			['name', 'string', 'max' => 255],
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
            'password_conf' => Yii::t('app', 'Password Confirm'),
            'phone' => Yii::t('app', 'Phone'),
            'name' => Yii::t('app', 'Name'),
            'avatar' => Yii::t('app', 'Avatar'),
		];
	}

	/**
	 * @return boolean true if new user successfully registered
	 */
	public function register()
	{
		if ($this->validate()) {
			return $this->createUser();
		}

		return false;
	}

	/**
	 * @return boolean true if new user successfully created
	 */
	public function createUser()
	{
		$model = new $this->userModelClass;
		$model->setAttributes([
			'email' => $this->email,
			'password' => $this->password,
			'phone' => $this->phone,
			'name' => $this->name,
			], false);

		return $model->save(false);
	}

}
