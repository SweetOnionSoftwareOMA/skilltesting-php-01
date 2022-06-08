<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class AAA extends AbstractMigration
{
	/**
	 * Change Method.
	 *
	 * Write your reversible migrations using this method.
	 *
	 * More information on writing migrations is available here:
	 * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
	 *
	 * Remember to call "create()" or "update()" and NOT "save()" when working
	 * with the Table class.
	 */
	public function change(): void
	{
		$users = $this->table('users', ['primary_key'=>'user_id', 'id'=>false]);
		$users->addColumn('user_id', 'integer', ['identity'=>true,])
			->addColumn('first_name', 'string')
			->addColumn('last_name', 'string')
			->addColumn('title', 'string', ['null' => true])
			->addColumn('company_name', 'string', ['null' => true])
			->addColumn('address', 'string', ['null' => true])
			->addColumn('city', 'string', ['null' => true])
			->addColumn('state', 'string', ['null' => true])
			->addColumn('zip', 'string', ['null' => true])
			->addColumn('email', 'string', ['null'=>true])
			->addColumn('username', 'string', ['null'=>false])
			->addColumn('password', 'string', ['null' => false])
			->addColumn('one_time_pin', 'string', ['null' => true])
			->addColumn('question1', 'integer', ['null' => false])
			->addColumn('question1_answer', 'string', ['null' => false])
			->addColumn('question2', 'integer', ['null' => false])
			->addColumn('question2_answer', 'string', ['null' => false])
			->addColumn('reset_token', 'string', ['null' => true])
			->addColumn('reset_requested_at', 'timestamp', ['null' => true, 'timezone' => true])
			->addColumn('created_at', 'timestamp', ['null'=>false,'timezone'=>true,'default'=> Literal::from('now()')])
			->addColumn('updated_at', 'timestamp', ['null'=>true,'timezone'=>true])
			->addColumn('deleted_at', 'timestamp', ['null'=>true,'timezone'=>true])
			->addColumn('deleted', 'boolean', ['default'=>false])
			->addIndex('username', ['unique'=>true])
			->create();

		// Set increment and seed on table, the option(s) does not seem to work properly.
		if ($this->isMigratingUp()) {
			$this->execute('ALTER SEQUENCE users_user_id_seq INCREMENT BY 13 START with 1031; ALTER SEQUENCE users_user_id_seq RESTART WITH 1031;');
		}

		$roles = $this->table('roles', ['primary_key' => 'role_id', 'id' => false]);
		$roles->addColumn('role_id', 'integer', ['identity' => true,])
			->addColumn('role_name', 'string')
			->addColumn('description', 'text')
			->addColumn('super_admin', 'boolean', ['null'=>false, 'default'=>false])
			->addColumn('office_manager_can_assign', 'boolean', ['default'=>false])
			->addColumn('created_at', 'timestamp', ['null'=>false,'timezone'=>true,'default'=> Literal::from('now()')])
			->addColumn('updated_at', 'timestamp', ['null'=>true,'timezone'=>true])
			->addColumn('deleted_at', 'timestamp', ['null'=>true,'timezone'=>true])
			->addColumn('deleted', 'boolean', ['default'=>false])
			->addIndex('role_name', ['unique'=>true])
			->create();

		// Set increment and seed on table, the option(s) does not seem to work properly.
		if ($this->isMigratingUp()) {
			$this->execute('ALTER SEQUENCE roles_role_id_seq INCREMENT BY 31 START with 532; ALTER SEQUENCE roles_role_id_seq RESTART WITH 532;');
		}

		$permissions = $this->table('permissions', ['primary_key' => 'permission_id', 'id' => false]);
		$permissions->addColumn('permission_id', 'integer', ['identity'=>true])
					->addColumn('app', 'string', ['null'=>false])
					->addColumn('permission_name', 'string', ['null'=>false])
					->addColumn('description', 'text', ['null' => true])
					->addColumn('controller', 'string', ['null'=>false])
					->addColumn('page_method', 'string', ['null'=>false])
					->addColumn('created_at', 'timestamp', ['null'=>false,'timezone'=>true,'default'=> Literal::from('now()')])
					->addColumn('updated_at', 'timestamp', ['null'=>true,'timezone'=>true])
					->addColumn('deleted_at', 'timestamp', ['null'=>true,'timezone'=>true])
					->addColumn('deleted', 'boolean', ['default'=>false])
		            ->addIndex(['app','controller', 'page_method'], ['unique'=>true])
		            ->create();

		// Set increment and seed on table, the option(s) does not seem to work properly.
		if ($this->isMigratingUp()) {
			$this->execute('ALTER SEQUENCE permissions_permission_id_seq INCREMENT BY 17 START with 183; ALTER SEQUENCE permissions_permission_id_seq RESTART WITH 183;');
		}

		$role_user = $this->table('roles_users');
		$role_user->addColumn('role_id', 'integer')
			->addForeignKey('role_id', 'roles', 'role_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			->addColumn('user_id', 'integer')
			->addForeignKey('user_id', 'users', 'user_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			->create();

		$permission_role = $this->table('permissions_roles');
		$permission_role->addColumn('permission_id', 'integer')
			->addForeignKey('permission_id', 'permissions', 'permission_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			->addColumn('role_id', 'integer')
			->addForeignKey('role_id', 'roles', 'role_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			->create();

		$logs_security = $this->table('logs_audits');
		$logs_security->addColumn('log_id', 'integer', ['identity' => true])
			->addColumn('activity_time', 'timestamp', ['null'=>false,'timezone'=>true,'default'=> Literal::from('now()')])
			->addColumn('action_user_id', 'integer', ['null'=>false])
			->addColumn('affected_user_id', 'integer', ['null' => true])
			->addColumn('controller', 'string', ['null' => false])
			->addColumn('method', 'string', ['null' => false])
			->addColumn('action', 'string', ['null' => true])
			->addColumn('logging_comments', 'jsonb')
			->addIndex('action_user_id')
			->addIndex('activity_time')
			->addIndex('affected_user_id')
			->create();

		$logging_auth = $this->table('log_auth', ['primary_key' => 'id', 'id' => true]);
		$logging_auth->addColumn('user_id', 'integer', ['null' => false])
			->addColumn('ipaddress', 'string', ['null' => true])
			->addColumn('status', 'string', ['null' => false])
			->addColumn('impersonate_user', 'integer', ['null' => true])
			->addColumn('activity_time', 'timestamp', ['null' => false, 'timezone' => true, 'default' => Literal::from('now()')])
			->addIndex(['user_id', 'activity_time'], ['unique' => false])
			->addIndex(['user_id', 'status'], ['unique' => false])
			->create();

		$sessions = $this->table('ci_sessions', ['primary_key' => 'session_id', 'id' => false]);
		$sessions->addColumn('session_id', 'integer', ['identity' => true,])
			->addColumn('id', 'string', ['null' => false,])
			->addColumn('username', 'string', ['null' => true])
			->addColumn('ip_address', 'string', ['null' => false,])
			->addColumn('timestamp', 'biginteger', ['null' => false, 'default' => 0])
			->addColumn('data', 'text', ['null' => false, 'default' => ''])
			->addColumn('started_at', 'timestamp', ['null' => false, 'timezone' => true, 'default' => Literal::from('now()')])
			->addColumn('ended_at', 'timestamp', ['null' => true, 'timezone' => true,])
			->addIndex('timestamp')
			->create();
	}
}
