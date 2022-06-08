<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class States extends AbstractMigration
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
			$users = $this->table('states', ['primary_key' => 'state_id', 'id' => false]);
			$users->addColumn('state_id', 'integer', ['identity' => true, 'seed' => 2092, 'increment' => 87])
					->addColumn('state_abbr', 'string')
					->addColumn('state_name', 'string')
					->addIndex('state_abbr', ['unique' => true])
					->addIndex('state_name', ['unique' => true])
					->create();
			// Set increment and seed on table, the option(s) does not seem to work properly.
			if ($this->isMigratingUp()) {
				$this->execute('ALTER SEQUENCE states_state_id_seq INCREMENT BY 87 START with 2092; ALTER SEQUENCE states_state_id_seq RESTART WITH 2092;');
			}

    }
}
