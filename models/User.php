<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $name
 * @property string $avatar
 *
 * @property Project[] $projects
 * @property ProjectUserRel[] $projectUserRels
 * @property Project[] $projects0
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property TaskAttach[] $taskAttaches
 * @property TaskComment[] $taskComments
 * @property TaskCommentAttach[] $taskCommentAttaches
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	/**
	 * @var type ?
	 */
	public $authKey;
	
	/**
	 * @var type ?
	 */
	public $accessToken;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user}}';
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'email' => Yii::t('app', 'Email'),
			'password' => Yii::t('app', 'Password'),
			'phone' => Yii::t('app', 'Phone'),
			'name' => Yii::t('app', 'Name'),
			'avatar' => Yii::t('app', 'Avatar'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($this->isNewRecord) {
				$this->password = \Yii::$app->security->generatePasswordHash($this->password);
				$this->auth_key = \Yii::$app->security->generateRandomString();				
			}

			return true;
		}

		return false;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProjects()
	{
		return $this->hasMany(Project::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProjectUserRels()
	{
		return $this->hasMany(ProjectUserRel::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProjects0()
	{
		return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('{{%project_user_rel}}', ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTasks()
	{
		return $this->hasMany(Task::className(), ['executive_user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTasks0()
	{
		return $this->hasMany(Task::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTaskAttaches()
	{
		return $this->hasMany(TaskAttach::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTaskComments()
	{
		return $this->hasMany(TaskComment::className(), ['user_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTaskCommentAttaches()
	{
		return $this->hasMany(TaskCommentAttach::className(), ['user_id' => 'id']);
	}

	/**
	 * @inheritdoc
	 * @return UserQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new UserQuery(get_called_class());
	}

	/**
	 * @param  string  $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		// @todo Разобраться с этим :)
		return $this->authKey;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->authKey === $authKey;
	}

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

}
