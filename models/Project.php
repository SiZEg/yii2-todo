<?php

namespace app\models;

use Yii;
use yii\db\Query;
use app\models\ProjectQuery;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property integer $sort
 * @property integer $is_active
 * @property integer $is_deleted
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property User $user
 * @property ProjectEvaluation[] $projectEvaluations
 * @property ProjectUserRel[] $projectUserRels
 * @property User[] $users
 * @property Task[] $tasks
 * @property TaskAttach[] $taskAttaches
 * @property TaskComment[] $taskComments
 * @property TaskCommentAttach[] $taskCommentAttaches
 * @property TaskEvaluation[] $taskEvaluations
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'sort', 'is_active', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'sort' => Yii::t('app', 'Sort'),
            'is_active' => Yii::t('app', 'Is Active'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectEvaluations()
    {
        return $this->hasMany(ProjectEvaluation::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectUserRels()
    {
        return $this->hasMany(ProjectUserRel::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('{{%project_user_rel}}', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAttaches()
    {
        return $this->hasMany(TaskAttach::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskComments()
    {
        return $this->hasMany(TaskComment::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskCommentAttaches()
    {
        return $this->hasMany(TaskCommentAttach::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskEvaluations()
    {
        return $this->hasMany(TaskEvaluation::className(), ['project_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }
	
	/**
	 * Returns maximum sort number for active projects
	 * 
	 * @return integer
	 */
	public static function getActiveMaxSort()
	{
		return (new Query())
			->select(['MAX(sort) as sort'])
			->from(self::tableName())
			->where('is_active=1')
			->scalar();
	}
	
	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if ($insert) {
				$this->user_id = Yii::$app->user->id;
			}
			
			return true;
		} else {
			return false;
		}
	}

}
