<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class Offices extends AbstractMigration
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
		$orgs = $this->table('organizations', ['primary_key' => 'organization_id', 'id' => false]);
		$orgs->addColumn('organization_id', 'integer', ['identity' => true, 'seed' => 1053, 'increment' => 73])
			->addColumn('organization_name', 'string')
			->addColumn('created_at', 'timestamp', ['null' => false, 'timezone' => true, 'default' => Literal::from('now()')])
			->addColumn('updated_at', 'timestamp', ['null' => true, 'timezone' => true])
			->addColumn('deleted_at', 'timestamp', ['null' => true, 'timezone' => true])
			->addColumn('deleted', 'boolean', ['default' => false])
			->create();

		// Set increment and seed on table, the option(s) does not seem to work properly.
		if ($this->isMigratingUp()) {
			$this->execute('ALTER SEQUENCE organizations_organization_id_seq INCREMENT BY 73 START with 1053; ALTER SEQUENCE organizations_organization_id_seq RESTART WITH 1053;');
		}

		$offices = $this->table('offices', ['primary_key' => 'office_id', 'id' => false]);
		$offices->addColumn('office_id', 'integer', ['identity' => true, 'seed' => 607, 'increment' => 17])
			->addColumn('office_name', 'string', ['null' => true])
			->addColumn('notify_email_address', 'string', ['null' => true])
			->addColumn('notify_new_data', 'boolean', ['default' => true])
			->addColumn('office_color', 'string', ['null' => true])
			->addColumn('address1', 'string', ['null' => true])
			->addColumn('address2', 'string', ['null' => true])
			->addColumn('city', 'string', ['null' => true])
			->addColumn('state', 'string', ['null' => true])
			->addColumn('zip', 'string', ['null' => true])
			->addColumn('phone', 'string', ['null' => true])
			->addColumn('app_url', 'string', ['null' => true])
			->addColumn('taxrate', 'decimal', ['null' => false, 'default' => 0, 'precision' => 5, 'scale' => 3])
			->addColumn('location_url', 'string', ['null' => true])
			->addColumn('created_at', 'timestamp', ['null' => false, 'timezone' => true, 'default' => Literal::from('now()')])
			->addColumn('updated_at', 'timestamp', ['null' => true, 'timezone' => true])
			->addColumn('deleted_at', 'timestamp', ['null' => true, 'timezone' => true])
			->addColumn('deleted', 'boolean', ['default' => false])
			->create();

		// Set increment and seed on table, the option(s) does not seem to work properly.
		if ($this->isMigratingUp()) {
			$this->execute('ALTER SEQUENCE offices_office_id_seq INCREMENT BY 17 START with 607; ALTER SEQUENCE offices_office_id_seq RESTART WITH 607;');
		}

		$office_org = $this->table('offices_organizations');
		$office_org->addColumn('office_id','integer', ['null' => false])
			->addForeignKey('office_id', 'offices', 'office_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			->addColumn('organization_id', 'integer', ['null' => false])
			->addForeignKey('organization_id', 'organizations', 'organization_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			->create();

		$org_user = $this->table('organizations_users');
		$org_user->addColumn('user_id', 'integer', ['null' => false])
			->addForeignKey('user_id', 'users', 'user_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			->addColumn('organization_id', 'integer', ['null' => false])
			->addForeignKey('organization_id', 'organizations', 'organization_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			->create();

		$office_user = $this->table('offices_users');
		$office_user->addColumn('user_id', 'integer', ['null' => false])
			->addForeignKey('user_id', 'users', 'user_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			->addColumn('office_id', 'integer', ['null' => false])
			->addForeignKey('office_id', 'offices', 'office_id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
			->create();


		if ($this->isMigratingUp()) {
			// Creating a view, there is currently no support for views in PHINX,
			//        so we do it manually but still in a migration
			$sql = "CREATE VIEW v_offices_organizations AS SELECT o.*,
																  org.organization_name,
																  org.organization_id,
																  (SELECT count(user_id) FROM offices_users WHERE office_id = o.office_id) AS office_users_count
														   FROM offices AS o
														   LEFT OUTER JOIN organizations AS org ON org.organization_id = (SELECT organization_id FROM offices_organizations WHERE office_id = o.office_id);

					CREATE VIEW v_users_organizations AS SELECT u.*, org.organization_name, org.organization_id
														 FROM users AS u
														 LEFT OUTER JOIN organizations AS org ON org.organization_id = (SELECT organization_id FROM organizations_users WHERE user_id = u.user_id);";
			$this->execute($sql);
		} else {
			$sql = "DROP VIEW IF EXISTS v_offices_organizations;
					DROP VIEW IF EXISTS v_organizations_users;";
			$this->execute($sql);
		}

	}
}
