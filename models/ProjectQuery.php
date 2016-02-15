<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Project]].
 *
 * @see Project
 */
class ProjectQuery extends \yii\db\ActiveQuery
{

	/**
	 * Only active project scope
	 * 
	 * @return \app\models\ProjectQuery
	 */
	public function active()
	{
		$this->andWhere('[[is_active]]=1');
		
		return $this;
	}

	/**
	 * Only deleted project scope
	 * 
	 * @return \app\models\ProjectQuery
	 */
	public function deleted()
	{
		$this->andWhere('[[is_deleted]]=1');
		
		return $this;
	}
	
	/**
	 * Current user scope
	 * 
	 * @param type $user_id
	 * @return \app\models\ProjectQuery
	 */
	public function user($user_id)
	{
		$this->andWhere('[[user_id]]=:user_id', [':user_id' => $user_id]);
		
		return $this;
	}
	
	/**
	 * Sort ascending scope
	 * 
	 * @return \app\models\ProjectQuery
	 */
	public function sortAsc(){
		$this->addOrderBy('sort ASC');
		
		return $this;
	}
	
	/**
	 * Projects of specified user
	 * 
	 * @param int $user_id User id
	 * @return []
	 */
	public function userAll($user_id)
	{
		return $this->user($user_id)->all();
	}

}
