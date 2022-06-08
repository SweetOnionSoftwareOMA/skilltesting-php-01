<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class Forms extends AbstractMigration
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
		$form = $this->table('forms', ['primary_key' => 'form_id', 'id' => false]);
		$form->addColumn('form_id', 'integer', ['identity' => true])
			 ->addColumn('name', 'string', 'string', ['null' => false])
			 ->addColumn('description', 'text', ['null' => true])
			 ->addColumn('template_url', 'string', ['null' => false])
			 ->addColumn('visibility', 'boolean', ['null' => false, 'signed' => false, 'default' => true])
			 ->addColumn('display_order', 'integer', ['null' => false, 'signed' => false, 'default' => 0])
			 ->addColumn('created_at', 'timestamp', ['null' => false, 'timezone' => true, 'default' => Literal::from('now()')])
			 ->addColumn('updated_at', 'timestamp', ['null' => true, 'timezone' => true])
			 ->addColumn('deleted_at', 'timestamp', ['null' => true, 'timezone' => true])
			 ->addColumn('deleted', 'boolean', ['default' => false]);

		$form->addIndex(['name', 'visibility', 'display_order']);

		$form->create();
	}
}
