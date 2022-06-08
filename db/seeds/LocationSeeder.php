<?php

use Phinx\Seed\AbstractSeed;
use Phinx\Util\Literal;

class LocationSeeder extends AbstractSeed
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
		$this->execute('TRUNCATE TABLE organizations RESTART IDENTITY CASCADE');
		$this->execute('TRUNCATE TABLE organizations_users RESTART IDENTITY CASCADE');
		$this->execute('TRUNCATE TABLE offices RESTART IDENTITY CASCADE');
		$this->execute('TRUNCATE TABLE offices_organizations RESTART IDENTITY CASCADE');
		$this->execute('TRUNCATE TABLE offices_users RESTART IDENTITY CASCADE');
		// Truncate so this can be rebuilt in demo/dev environments

		$organizationsArray = [
			[
				'organization_id' => 1,
				'organization_name' => 'Vision Specialists',
				'created_at' => Literal::from('now()')
			]
		];

		$organizations = $this->table('organizations');
		$organizations->insert($organizationsArray)->saveData();

		$officesArray = [
			[
				'office_id' => 1,
				'office_name' => 'Clocktower Village',
				'created_at' => Literal::from('now()')
			],
			[
				'office_id' => 2,
				'office_name' => 'Council Bluffs',
				'created_at' => Literal::from('now()')
			],
			[
				'office_id' => 3,
				'office_name' => 'Papillion',
				'created_at' => Literal::from('now()')
			],
			[
				'office_id' => 4,
				'office_name' => 'NW Omaha (156th & W. Maple)',
				'created_at' => Literal::from('now()')
			],
			[
				'office_id' => 5,
				'office_name' => 'SW Omaha (180th & Harrison)',
				'created_at' => Literal::from('now()')
			]
		];

		$offices = $this->table('offices');
		$offices->insert($officesArray)->saveData();

		$officesOrganizationsArray = [
			['office_id' => 1, 'organization_id' => 1],
			['office_id' => 2, 'organization_id' => 1],
			['office_id' => 3, 'organization_id' => 1],
			['office_id' => 4, 'organization_id' => 1],
			['office_id' => 5, 'organization_id' => 1],
		];

		$offices_organizations = $this->table('offices_organizations');
		$offices_organizations->insert($officesOrganizationsArray)->saveData();

		$organizationsUsersArray = [
			['user_id' => 3, 'organization_id' => 1],
			['user_id' => 4, 'organization_id' => 1],
			['user_id' => 5, 'organization_id' => 1],
			['user_id' => 6, 'organization_id' => 1],
			['user_id' => 7, 'organization_id' => 1],
			['user_id' => 8, 'organization_id' => 1],
		];

		$organizations_users = $this->table('organizations_users');
		$organizations_users->insert($organizationsUsersArray)->saveData();

		$officesUsersArray = [
			['user_id' => 3, 'office_id' => 2],
			['user_id' => 4, 'office_id' => 1],
			['user_id' => 5, 'office_id' => 2],
			['user_id' => 5, 'office_id' => 4],
			['user_id' => 6, 'office_id' => 5],
			['user_id' => 6, 'office_id' => 2],
			['user_id' => 7, 'office_id' => 3],
			['user_id' => 8, 'office_id' => 2]
		];

		$offices_users = $this->table('offices_users');
		$offices_users->insert($officesUsersArray)->saveData();
    }
}
