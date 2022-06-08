<?php
use Phinx\Seed\AbstractSeed;

class BaseUserAuth extends AbstractSeed
{
	/**
	 * Run Method.
	 *
	 * Write your database seeder using this method.
	 *
	 * More information on writing seeders is available here:
	 * https://book.cakephp.org/phinx/0/en/seeding.html
	 */

	public function run()
	{
		// Truncate so this can be rebuilt in demo/dev environments
		$this->execute('TRUNCATE TABLE roles RESTART IDENTITY CASCADE');
		$this->execute('TRUNCATE TABLE users RESTART IDENTITY CASCADE');
		$this->execute('TRUNCATE TABLE roles_users RESTART IDENTITY CASCADE');
		// Truncate so this can be rebuilt in demo/dev environments

		$rolesArray = [
			[
				'role_id' => 1,
				'role_name' => 'Super Admin',
				'description' => 'Godlike role, has full access to everything.',
				'super_admin' => true,
				'office_manager_can_assign' => false
			],
			[
				'role_id' => 2,
				'role_name' => 'General Access',
				'description' => 'APPLEVEL: View dashboard, profile and general sections.',
				'super_admin' => false,
				'office_manager_can_assign' => false
			],
			[
				'role_id' => 3,
				'role_name' => 'Data Analyst',
				'description' => 'APPLEVEL: View data view and reporting.',
				'super_admin' => false,
				'office_manager_can_assign' => false
			],
			[
				'role_id' => 4,
				'role_name' => 'Office User Manager',
				'description' => 'APPLEVEL: Manage office users.',
				'super_admin' => false,
				'office_manager_can_assign' => false
			],
			[
				'role_id' => 5,
				'role_name' => 'OD Form',
				'description' => 'APPLEVEL: Manage OD form entries..',
				'super_admin' => false,
				'office_manager_can_assign' => true
			],
			[
				'role_id' => 6,
				'role_name' => 'Location Form',
				'description' => 'APPLEVEL: Manage Location form entries.',
				'super_admin' => false,
				'office_manager_can_assign' => true
			],
			[
				'role_id' => 7,
				'role_name' => 'VC Form',
				'description' => 'APPLEVEL: Manage VC form entries.',
				'super_admin' => false,
				'office_manager_can_assign' => true
			]
		];

		$roles = $this->table('roles');
		$roles->insert($rolesArray)->saveData();

		$adminUser = [
				[
					'user_id' => 1,
					'title' => 'Mr.',
					'first_name' => 'Admin',
					'last_name' => 'MTM',
					'username' => 'admin',
					'password' => password_hash('password', PASSWORD_DEFAULT),
					'question1' => 0,
					'question1_answer' => '',
					'question2' => 0,
					'question2_answer' => ''
				],
				[
					'user_id' => 2,
					'title' => 'Mr.',
					'first_name' => 'Brandon',
					'last_name' => 'Osborn',
					'username' => 'BOsborn',
					'password' => password_hash('VSOsborn2021', PASSWORD_DEFAULT),
					'question1' => 0,
					'question1_answer' => '',
					'question2' => 0,
					'question2_answer' => ''
				],
				[
					'user_id' => 3,
					'title' => 'Dr.',
					'first_name' => 'Robyn',
					'last_name' => 'Epley',
					'username' => 'REpley',
					'password' => password_hash('VSEpley2021', PASSWORD_DEFAULT),
					'question1' => 0,
					'question1_answer' => '',
					'question2' => 0,
					'question2_answer' => ''
				],
				[
					'user_id' => 4,
					'title' => 'Dr.',
					'first_name' => 'Jared',
					'last_name' => 'Holthaus',
					'username' => 'JHolthaus',
					'password' => password_hash('VSJared2021', PASSWORD_DEFAULT),
					'question1' => 0,
					'question1_answer' => '',
					'question2' => 0,
					'question2_answer' => ''
				],
				[
					'user_id' => 5,
					'title' => 'Dr.',
					'first_name' => 'Kate',
					'last_name' => 'Holthaus',
					'username' => 'KHolthaus',
					'password' => password_hash('VSKate2021', PASSWORD_DEFAULT),
					'question1' => 0,
					'question1_answer' => '',
					'question2' => 0,
					'question2_answer' => ''
				],
				[
					'user_id' => 6,
					'title' => 'Dr.',
					'first_name' => 'Lexye',
					'last_name' => 'Bruegman',
					'username' => 'LBruegman',
					'password' => password_hash('VSLexye2021', PASSWORD_DEFAULT),
					'question1' => 0,
					'question1_answer' => '',
					'question2' => 0,
					'question2_answer' => ''
				],
				[
					'user_id' => 7,
					'title' => 'Dr.',
					'first_name' => 'Dayna',
					'last_name' => 'Hazlewood',
					'username' => 'DHazlewood',
					'password' => password_hash('VSDayna2021', PASSWORD_DEFAULT),
					'question1' => 0,
					'question1_answer' => '',
					'question2' => 0,
					'question2_answer' => ''
				],
				[
					'user_id' => 8,
					'title' => 'Dr.',
					'first_name' => 'Katie',
					'last_name' => 'West',
					'username' => 'KWest',
					'password' => password_hash('VSWest2021', PASSWORD_DEFAULT),
					'question1' => 0,
					'question1_answer' => '',
					'question2' => 0,
					'question2_answer' => ''
				]
		];

		$assignedRole = [
			['role_id' => 1, 'user_id' => 1],

			['role_id' => 1, 'user_id' => 2],

			['role_id' => 2, 'user_id' => 3],
			['role_id' => 3, 'user_id' => 3],
			['role_id' => 4, 'user_id' => 3],
			['role_id' => 5, 'user_id' => 3],
			['role_id' => 6, 'user_id' => 3],

			['role_id' => 2, 'user_id' => 4],
			['role_id' => 3, 'user_id' => 4],
			['role_id' => 4, 'user_id' => 4],
			['role_id' => 5, 'user_id' => 4],
			['role_id' => 6, 'user_id' => 4],

			['role_id' => 2, 'user_id' => 5],
			['role_id' => 3, 'user_id' => 5],
			['role_id' => 4, 'user_id' => 5],
			['role_id' => 5, 'user_id' => 5],
			['role_id' => 6, 'user_id' => 5],

			['role_id' => 2, 'user_id' => 6],
			['role_id' => 3, 'user_id' => 6],
			['role_id' => 4, 'user_id' => 6],
			['role_id' => 5, 'user_id' => 6],
			['role_id' => 6, 'user_id' => 6],

			['role_id' => 2, 'user_id' => 7],
			['role_id' => 3, 'user_id' => 7],
			['role_id' => 4, 'user_id' => 7],
			['role_id' => 5, 'user_id' => 7],
			['role_id' => 6, 'user_id' => 7],

			['role_id' => 2, 'user_id' => 8],
			['role_id' => 3, 'user_id' => 8],
			['role_id' => 4, 'user_id' => 8],
			['role_id' => 5, 'user_id' => 8],
			['role_id' => 6, 'user_id' => 8]
		];

		// Define all tables used in the seeder
		$users = $this->table('users');
		$role_users = $this->table('roles_users');

		$users->insert($adminUser)->saveData();
		$role_users->insert($assignedRole)->saveData();
	}
}
