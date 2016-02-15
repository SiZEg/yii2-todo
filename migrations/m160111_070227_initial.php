<?php

use yii\db\Schema;
use yii\db\Migration;

class m160111_070227_initial extends Migration
{

	public function up()
	{
		$this->createTable('{{user}}', [
			'id' => 'pk',
			'email' => 'string NOT NULL',
			'password' => 'varchar(128) NOT NULL',
			'phone' => 'varchar(11) DEFAULT NULL',
			'name' => 'string DEFAULT NULL',
			'avatar' => 'varchar(16) DEFAULT NULL',
			'auth_key' => 'varchar(32) NOT NULL',
		]);
		
		$this->createIndex('email', '{{user}}', 'email');

		$this->createTable('{{project}}', [
			'id' => 'pk',
			'user_id' => 'integer NOT NULL',
			'title' => 'string',
			'sort' => 'integer DEFAULT 0',
			'is_active' => 'boolean DEFAULT 1', // 1 - active, 0 - archive
			'is_deleted' => 'boolean DEFAULT 0', // 1 - trash, 0 - visible
			'created_at' => 'datetime DEFAULT NULL',
			'updated_at' => 'datetime DEFAULT NULL',
			'deleted_at' => 'datetime DEFAULT NULL',
		]);
		
		$this->createIndex('fk_project_user_id', '{{project}}', 'user_id');
		$this->addForeignKey('fk_project_user_id', '{{project}}', 'user_id', '{{user}}', 'id', 'CASCADE', 'CASCADE');
		$this->createIndex('sort', '{{project}}', 'sort');
		$this->createIndex('is_active', '{{project}}', 'is_active');
		$this->createIndex('is_deleted', '{{project}}', 'is_deleted');

		$this->createTable('{{project_user_rel}}', [
			'project_id' => 'integer NOT NULL',
			'user_id' => 'integer NOT NULL',
		]);
		
		$this->addPrimaryKey('pk_project_user_rel', '{{project_user_rel}}', ['project_id', 'user_id']);
		$this->createIndex('fk_project_user_rel_user_id', '{{project_user_rel}}', 'user_id');
		$this->addForeignKey('fk_project_user_rel_user_id', '{{project_user_rel}}', 'user_id', '{{user}}', 'id', 'CASCADE', 'CASCADE');
		$this->createIndex('fk_project_user_rel_project_id', '{{project_user_rel}}', 'project_id');
		$this->addForeignKey('fk_project_user_rel_project_id', '{{project_user_rel}}', 'project_id', '{{project}}', 'id', 'CASCADE', 'CASCADE');

		$this->createTable('{{task_status}}', [
			'id' => 'pk',
			'code' => 'varchar(8) NOT NULL',
			'title' => 'string NOT NULL'
		]);
		
		$this->createIndex('code', '{{task_status}}', 'code', true);

		$this->createTable('{{task}}', [
			'id' => 'pk',
			'project_id' => 'integer NOT NULL',
			'user_id' => 'integer DEFAULT NULL',
			'executive_user_id' => 'integer DEFAULT NULL',
			'task_status_id' => 'integer DEFAULT NULL',
			'title' => 'string DEFAULT NULL',
			'description' => 'text DEFAULT NULL',
			'sort' => 'integer DEFAULT 0',
			'is_active' => 'boolean DEFAULT 1', // 1 - active, 0 - finish
			'start_at' => 'datetime DEFAULT NULL',
			'finish_at' => 'datetime DEFAULT NULL',
			'created_at' => 'datetime DEFAULT NULL',
			'updated_at' => 'datetime DEFAULT NULL',
		]);
		
		$this->createIndex('fk_task_project_id', '{{task}}', 'project_id');
		$this->addForeignKey('fk_task_project_id', '{{task}}', 'project_id', '{{project}}', 'id', 'CASCADE', 'CASCADE');
		$this->createIndex('fk_task_user_id', '{{task}}', 'user_id');
		$this->addForeignKey('fk_task_user_id', '{{task}}', 'user_id', '{{user}}', 'id', 'SET NULL', 'CASCADE');
		$this->createIndex('fk_task_executive_user_id', '{{task}}', 'executive_user_id');
		$this->addForeignKey('fk_task_executive_user_id', '{{task}}', 'executive_user_id', '{{user}}', 'id', 'SET NULL', 'CASCADE');
		$this->createIndex('fk_task_task_status_id', '{{task}}', 'task_status_id');
		$this->addForeignKey('fk_task_task_status_id', '{{task}}', 'task_status_id', '{{task_status}}', 'id', 'RESTRICT', 'CASCADE');
		$this->createIndex('sort', '{{task}}', 'sort');
		$this->createIndex('is_active', '{{task}}', 'is_active');

		$this->createTable('{{task_attach}}', [
			'id' => 'pk',
			'project_id' => 'integer NOT NULL',
			'task_id' => 'integer NOT NULL',
			'user_id' => 'integer DEFAULT NULL',
			'filename' => 'varchar(32) NOT NULL',
			'realname' => 'string DEFAULT NULL',
			'is_image' => 'boolean DEFAULT 0',
			'created_at' => 'datetime DEFAULT NULL',
			'updated_at' => 'datetime DEFAULT NULL',
		]);
		
		$this->createIndex('fk_task_attach_project_id', '{{task_attach}}', 'project_id');
		$this->addForeignKey('fk_task_attach_project_id', '{{task_attach}}', 'project_id', '{{project}}', 'id', 'RESTRICT', 'CASCADE');
		$this->createIndex('fk_task_attach_task_id', '{{task_attach}}', 'task_id');
		$this->addForeignKey('fk_task_attach_task_id', '{{task_attach}}', 'task_id', '{{task}}', 'id', 'RESTRICT', 'CASCADE');
		$this->createIndex('fk_task_attach_user_id', '{{task_attach}}', 'user_id');
		$this->addForeignKey('fk_task_attach_user_id', '{{task_attach}}', 'user_id', '{{user}}', 'id', 'SET NULL', 'CASCADE');

		$this->createTable('{{task_comment}}', [
			'id' => 'pk',
			'project_id' => 'integer NOT NULL',
			'task_id' => 'integer NOT NULL',
			'user_id' => 'integer DEFAULT NULL',
			'comment' => 'text',
			'created_at' => 'datetime DEFAULT NULL',
			'updated_at' => 'datetime DEFAULT NULL',
		]);
		
		$this->createIndex('fk_task_comment_project_id', '{{task_comment}}', 'project_id');
		$this->addForeignKey('fk_task_comment_project_id', '{{task_comment}}', 'project_id', '{{project}}', 'id', 'CASCADE', 'CASCADE');
		$this->createIndex('fk_task_comment_task_id', '{{task_comment}}', 'task_id');
		$this->addForeignKey('fk_task_comment_task_id', '{{task_comment}}', 'task_id', '{{task}}', 'id', 'CASCADE', 'CASCADE');
		$this->createIndex('fk_task_comment_user_id', '{{task_comment}}', 'user_id');
		$this->addForeignKey('fk_task_comment_user_id', '{{task_comment}}', 'user_id', '{{user}}', 'id', 'SET NULL', 'CASCADE');

		$this->createTable('{{task_comment_attach}}', [
			'id' => 'pk',
			'project_id' => 'integer NOT NULL',
			'task_id' => 'integer NOT NULL',
			'task_comment_id' => 'integer NOT NULL',
			'user_id' => 'integer DEFAULT NULL',
			'filename' => 'varchar(32) NOT NULL',
			'realname' => 'string DEFAULT NULL',
			'is_image' => 'boolean DEFAULT 0',
			'created_at' => 'datetime DEFAULT NULL',
			'updated_at' => 'datetime DEFAULT NULL',
		]);
		
		$this->createIndex('fk_task_comment_attach_project_id', '{{task_comment_attach}}', 'project_id');
		$this->addForeignKey('fk_task_comment_attach_project_id', '{{task_comment_attach}}', 'project_id', '{{project}}', 'id', 'RESTRICT', 'CASCADE');
		$this->createIndex('fk_task_comment_attach_task_id', '{{task_comment_attach}}', 'task_id');
		$this->addForeignKey('fk_task_comment_attach_task_id', '{{task_comment_attach}}', 'task_id', '{{task}}', 'id', 'RESTRICT', 'CASCADE');
		$this->createIndex('fk_task_comment_attach_task_comment_id', '{{task_comment_attach}}', 'task_comment_id');
		$this->addForeignKey('fk_task_comment_attach_task_comment_id', '{{task_comment_attach}}', 'task_comment_id', '{{task_comment}}', 'id', 'RESTRICT', 'CASCADE');
		$this->createIndex('fk_task_comment_attach_user_id', '{{task_comment_attach}}', 'user_id');
		$this->addForeignKey('fk_task_comment_attach_user_id', '{{task_comment_attach}}', 'user_id', '{{user}}', 'id', 'SET NULL', 'CASCADE');

		$this->createTable('{{task_tag}}', [
			'id' => 'pk',
			'tag' => 'string NOT NULL'
		]);
		
		$this->createIndex('tag', '{{task_tag}}', 'tag', true);

		$this->createTable('{{task_tag_rel}}', [
			'task_id' => 'integer NOT NULL',
			'task_tag_id' => 'integer NOT NULL',
		]);
		
		$this->addPrimaryKey('pk_task_tag_rel', '{{task_tag_rel}}', ['task_id', 'task_tag_id']);
		
		$this->createIndex('fk_task_comment_attach_task_id', '{{task_tag_rel}}', 'task_id');
		$this->addForeignKey('fk_task_tag_rel_task_id', '{{task_tag_rel}}', 'task_id', '{{task}}', 'id', 'CASCADE', 'CASCADE');
		$this->createIndex('fk_task_tag_rel_task_tag_id', '{{task_tag_rel}}', 'task_tag_id');
		$this->addForeignKey('fk_task_tag_rel_task_tag_id', '{{task_tag_rel}}', 'task_tag_id', '{{task_tag}}', 'id', 'CASCADE', 'CASCADE');

		$this->createTable('{{task_time}}', [
			'id' => 'pk',
			'task_id' => 'integer NOT NULL',
			'user_id' => 'integer NOT NULL',
			'start_at' => 'datetime DEFAULT NULL',
			'finish_at' => 'datetime DEFAULT NULL',
		]);
		
		$this->createIndex('fk_task_time_task_id', '{{task_time}}', 'task_id');
		$this->addForeignKey('fk_task_time_task_id', '{{task_time}}', 'task_id', '{{task}}', 'id', 'CASCADE', 'CASCADE');

		$this->createTable('{{currency}}', [
			'id' => 'pk',
			'code' => 'string NOT NULL',
			'title' => 'string NOT NULL',
		]);
		
		$this->createIndex('code', '{{currency}}', 'code', true);

		$this->createTable('{{project_evaluation}}', [
			'id' => 'pk',
			'project_id' => 'integer NOT NULL',
			'currency_id' => 'integer NOT NULL',
			'money_per_hour' => 'money DEFAULT NULL',
			'working_hours_per_day' => 'decimal DEFAULT NULL',
			'working_days_per_month' => 'integer DEFAULT NULL',
			'created_at' => 'datetime DEFAULT NULL', // For history
		]);
		
		$this->createIndex('fk_project_evaluation_project_id', '{{project_evaluation}}', 'project_id');
		$this->addForeignKey('fk_project_evaluation_project_id', '{{project_evaluation}}', 'project_id', '{{project}}', 'id', 'CASCADE', 'CASCADE');
		$this->createIndex('fk_project_evaluation_currency_id', '{{project_evaluation}}', 'currency_id');
		$this->addForeignKey('fk_project_evaluation_currency_id', '{{project_evaluation}}', 'currency_id', '{{currency}}', 'id', 'RESTRICT', 'CASCADE');
		$this->createIndex('created_at', '{{project_evaluation}}', 'created_at');

		$this->createTable('{{task_evaluation}}', [
			'id' => 'pk',
			'project_id' => 'integer NOT NULL',
			'task_id' => 'integer NOT NULL',
			'time' => 'decimal DEFAULT NULL', // Evaluation time
			'money' => 'money DEFAULT NULL', // or Fixed price for task
		]);
		
		$this->createIndex('fk_task_evaluation_project_id', '{{task_evaluation}}', 'project_id');
		$this->addForeignKey('fk_task_evaluation_project_id', '{{task_evaluation}}', 'project_id', '{{project}}', 'id', 'CASCADE', 'CASCADE');
		$this->createIndex('fk_task_evaluation_task_id', '{{task_evaluation}}', 'task_id');
		$this->addForeignKey('fk_task_evaluation_task_id', '{{task_evaluation}}', 'task_id', '{{task}}', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		echo "m160111_070227_initial cannot be reverted.\n";

		return false;
	}

}
